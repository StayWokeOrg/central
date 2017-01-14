<?php

use App\Contact;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class ContactsApiTest extends TestCase
{
    use DatabaseMigrations;
    use WithoutMiddleware;

    // Cannot use seeInDatabase because of encryption
    private function seeinModel($model, $array)
    {
        foreach ($array as $key => $value) {
            $this->assertEquals($value, $model->$key);
        }
    }

    /** @test */
    function it_stores_contacts()
    {
        $this->post('api/contacts', [
            'name' => 'DeRay',
            'email' => 'deray@deray.com',
            'phone' => '123-456-7890',
            'zip' => '02345',
            'campaign' => 'inauguration',
            'source' => 'sms',
        ]);

        $this->assertEquals(1, Contact::count());
        $this->seeInModel(Contact::first(), [
            'name' => 'DeRay',
            'email' => 'deray@deray.com',
            'phone' => '123-456-7890',
            'campaign' => 'inauguration',
            'source' => 'sms',
            'zip' => '02345',
        ]);
    }

    /** @test */
    function after_storing_contacts_they_are_returned_in_jsend_format()
    {
        $this->post('api/contacts', [
            'name' => 'DeRay',
            'email' => 'deray@deray.com',
            'phone' => '123-456-7890',
            'zip' => '02345',
            'campaign' => 'inauguration',
            'source' => 'sms',
        ]);

        $this->seeJsonStructure([
            'status',
            'data' => [
                'contact' => [
                    'id',
                    'name',
                    'email',
                    'phone',
                    'campaign',
                    'source',
                    'zip',
                    'created_at',
                    'updated_at'
                ]
            ]
        ]);

        $this->seeJson(['status' => 'success']);
        $this->seeJson(['name' => 'DeRay']);
    }
}
