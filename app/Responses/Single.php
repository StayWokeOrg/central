<?php

namespace App\Responses;

class Single
{
    private $status;
    private $body;
    private $label;

    public function __construct($status, $body, $label = 'data')
    {
        $this->status = $status;
        $this->body = $body;
        $this->label = $label;
    }

    public function __toArray()
    {
        return [
            'status' => $this->status,
            'data' => [
                $this->label => $this->body
            ]
        ];
    }

    public function __toString()
    {
        return json_encode($this->__toArray());
    }
}
