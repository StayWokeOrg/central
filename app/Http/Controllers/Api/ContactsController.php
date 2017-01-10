<?php

namespace App\Http\Controllers\Api;

use App\Contact;
use App\Responses\Single as SingleResponse;
use App\Transformers\Contact as ContactTransformer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactsController extends Controller
{
    public function store(Request $request)
    {
        $contact = Contact::where('email', $request->input('email'))
            ->orWhere('phone', $request->input('phone'))->first();

        if ($contact) {
            return new SingleResponse(
                'success',
                (new ContactTransformer($contact))->transform(),
                'contact'
            );
        }

        return new SingleResponse(
            'success',
            (new ContactTransformer(
                Contact::create(
                    $request->only(['name', 'email', 'phone', 'campaign', 'source'])
                )
            ))->transform(),
            'contact'
        );
    }
}
