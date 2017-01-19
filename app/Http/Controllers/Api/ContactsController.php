<?php

namespace App\Http\Controllers\Api;

use App\Contact;
use App\Responses\Single as SingleResponse;
use App\Responses\Collection as CollectionResponse;
use App\Transformers\Contact as ContactTransformer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactsController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 'success',
            'data' => Contact::all()->map(function ($contact) {
                return (new ContactTransformer($contact))->transform();
            })
        ]);
    }

    public function store(Request $request)
    {
        return response()->json([
            'status' => 'success',
            'data' => [
                'contact' => (new ContactTransformer(
                    Contact::create(
                        $request->only(['name', 'email', 'phone', 'zip', 'campaign', 'source', 'topics'])
                    )
                ))->transform(),
            ]
        ]);
    }
}
