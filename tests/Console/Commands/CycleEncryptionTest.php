<?php

use App\Console\Commands\CycleEncryptionCommand;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Mockery as m;

class CycleEncryptionTest extends TestCase
{

    use DatabaseMigrations;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct();
    }


    function test_it_sets_a_new_app_key()
    {
        $oldKey = config('app.key');

        Artisan::call('key:cycle');

        $this->assertNotEquals($oldKey, config('app.key'));
    }

    function test_it_saves_new_encrypted_values_to_the_database()
    {
        $user = factory(App\Contact::class)->create();

        Artisan::call('key:cycle');

        $reEncryptedUser = App\Contact::find($user->id);

        foreach ($user->encryptable as $field) {
            $this->assertNotEquals($user->getOriginal($field), $reEncryptedUser->getOriginal($field));
            $this->assertEquals($user->getAttribute($field), $reEncryptedUser->getAttribute($field));
        }
    }

    function test_it_does_not_save_anything_when_an_exception_occurs()
    {

        // Need to find a way to assess the following:
        // DB::shouldReceive('beginTransaction')->once();
        // DB::shouldReceive('rollBack')->once();
        // DB::shouldNotReceive('commit');


    }

    function test_it_skips_when_a_model_does_not_use_encryption()
    {
        $eloquentModel = new m\Mock(Illuminate\Database\Eloquent::class);
        $eloquentModel->shouldNotReceive('every', 'getArgument', 'setArgument');

        (new CycleEncryptionCommand())->cycleEncryption(get_class($eloquentModel), 'key', 'oldKey');


    }
}
