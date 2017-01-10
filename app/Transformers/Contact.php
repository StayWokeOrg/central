<?php

namespace App\Transformers;

class Contact
{
    private $contact;

    public function __construct($contact)
    {
        $this->contact = $contact;
    }

    public function transform()
    {
        return [
            'name' => $this->contact->name,
            'email' => $this->contact->email,
            'phone' => $this->contact->phone,
            'campaign' => $this->contact->campaign,
            'source' => $this->contact->source,
        ];
    }

    public function __toArray()
    {
        return $this->transform();
    }

    public function __toString()
    {
        return json_encode($this->transform());
    }
}
