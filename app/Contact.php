<?php

namespace App;

use App\EncryptsFields;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
//    use EncryptsFields;

//    protected $encryptable = ['name', 'email', 'phone'];

    protected $fillable = ['name', 'email', 'phone', 'zip', 'campaign', 'source'];
}
