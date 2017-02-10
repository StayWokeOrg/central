<?php

namespace App\Console\Commands;

use App\Contact;
use Illuminate\Foundation\Console\KeyGenerateCommand;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Helper\ProgressBar;

class CycleEncryptionCommand extends KeyGenerateCommand
{

    public $classesWithEncryption = [
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
     * Execute the console command.
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
            foreach ($this->classesWithEncryption as $class) {
                $this->cycleEncryption($class, $key, $oldKey);
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


    public function cycleEncryption($class, $key, $oldKey)
    {
        if (!in_array(\App\EncryptsFields::class, class_uses($class))) {
            return;
        }

        $entries = (new $class())->all();

        $progress = new ProgressBar($this->output, $entries->count());
        $this->info("Re-encrypting {$class}");
        $progress->start();

        $entries->each(function ($entry) use ($progress, $oldKey, $key) {
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
