<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Borrower extends Model
{
    protected $fillable  = [
        'fullname',
        'phone_no',
        'email'
    ];
}
