<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ContactsApiTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function it_stores_contacts()
    {
        $this->post('api/contacts', [
            'name' => 'DeRay',
            'email' => 'deray@deray.com',
            'phone' => '123-456-7890',
            'campaign' => 'inauguration',
            'source' => 'sms'
        ]);

        $this->seeInDatabase('contacts', [
            'name' => 'DeRay',
            'email' => 'deray@deray.com',
            'phone' => '123-456-7890',
            'campaign' => 'inauguration',
            'source' => 'sms'
        ]);
    }

    /** @test */
    function after_storing_contacts_they_are_returned_in_jsend_format()
    {
        $this->post('api/contacts', [
            'name' => 'DeRay',
            'email' => 'deray@deray.com',
            'phone' => '123-456-7890',
            'campaign' => 'inauguration',
            'source' => 'sms'
        ]);

        $this->seeJsonStructure([
            'status',
            'data' => [
                'contact' => [
                    'name',
                    'email',
                    'phone',
                    'campaign',
                    'source'
                ]
            ]
        ]);

        $this->seeJson(['status' => 'success']);
        $this->seeJson(['name' => 'DeRay']);
    }

    /** @test */
    function duplicate_contacts_are_updated_not_duplicated()
    {
        $this->markTestIncomplete();
        // @todo: How do we handle multiple people with the same email/phone?
    }
}
