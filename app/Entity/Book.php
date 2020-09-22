<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'book';

    protected $primaryKey = 'book_id';

    protected $fillable = [
        'book_id',
        'name',
        'address',
        'phone',
        'email',
        'message',
        'time',
        'restaurant',
        'created_at',
        'updated_at'
    ];
}
