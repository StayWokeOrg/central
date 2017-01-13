<?php

use App\Contact;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class ContactsApiTest extends TestCase
{
    use DatabaseMigrations;
    use WithoutMiddleware;

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

        // Cannot use seeInDatabase because of encryption

        $this->assertEquals(1, Contact::count());

        $contact = Contact::first();

        $this->assertEquals('DeRay', $contact->name);
        $this->assertEquals('deray@deray.com', $contact->email);
        $this->assertEquals('123-456-7890', $contact->phone);
        $this->assertEquals('inauguration', $contact->campaign);
        $this->assertEquals('sms', $contact->source);
        $this->assertEquals('02345', $contact->zip);
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

    /** @test */
    function duplicate_contacts_are_updated_not_duplicated()
    {
        $this->markTestIncomplete();
        // @todo: How do we handle multiple people with the same email/phone?
    }
}
