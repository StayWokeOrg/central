<?php

namespace App\Console\Commands;

use App\Contact;
use Illuminate\Foundation\Console\KeyGenerateCommand;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Helper\ProgressBar;

class CycleEncryptionCommand extends KeyGenerateCommand
{

    /**
     * Lists the Eloquent Models that use encryption
     * and implement the EncryptFields trait.
     *
     * @var array
     */
    public $modelsWithEncryption = [
        \App\Contact::class,
    ];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'key:cycle';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sets a new application key and re-encrypts the database data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command by cycling through the models
     * listed in $modelsWithEncryption. To make sure that
     * no data is lost, the changes are not committed
     * until we know that no exceptions were raised
     * in the process. The new key is then saved
     * in the current environment file.
     *
     * @return mixed
     */
    public function handle()
    {
        $oldKey = config('app.key');
        $this->info("Old key is {$oldKey}");
        $key = $this->generateRandomKey();
        $this->info("New key is {$key}");

        DB::beginTransaction();
        try {
            foreach ($this->modelsWithEncryption as $class) {
                $this->cycleEncryption($class);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            $this->error(
                "There was an error cycling the encryption of the database data. Nothing was modified");
            $this->error("Error message: {$e->getMessage()}");
            return;
        }
        config(['app.key' => $key]);
        DB::commit();


        $this->setKeyInEnvironmentFile($key);


        $this->info("Application key [$key] replaced successfully.");
    }


    /**
     * Rewrites all the encrypted fields to the database,
     * using the newly defined application key.
     *
     * @param string $class
     */
    public function cycleEncryption($class)
    {
        if (!in_array(\App\EncryptsFields::class, class_uses($class))) {
            return;
        }

        $entries = (new $class())->all();

        $progress = new ProgressBar($this->output, $entries->count());
        $this->info("Re-encrypting {$class}");
        $progress->start();

        $entries->each(function ($entry) use ($progress) {
            foreach ($entry->encryptable as $field) {
                $value = $entry->getAttribute($field);
                $entry->setAttribute($field, $value);
            }
            $entry->save();
            $progress->advance();
        });
        $progress->finish();
        $this->line("\n");
        $this->info("Successfully re-encrypted {$class}");
    }
}
