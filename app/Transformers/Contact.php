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
            'id' => $this->contact->id,
            'name' => $this->contact->name,
            'email' => $this->contact->email,
            'phone' => $this->contact->phone,
            'zip' => $this->contact->zip,
            'campaign' => $this->contact->campaign,
            'source' => $this->contact->source,
            'created_at' => $this->contact->created_at->toIso8601String(),
            'updated_at' => $this->contact->updated_at->toIso8601String(),
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
