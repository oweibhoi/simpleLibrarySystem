<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BorrowList extends Model
{
    protected $fillable = [
        'borrowerID',
        'bookID',
        'borrowed_date'
    ];

    protected $guarded = [
        'isReturn'
    ];
}
