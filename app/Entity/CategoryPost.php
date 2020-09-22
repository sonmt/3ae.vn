<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class CategoryPost extends Model
{
    protected $table = 'category_post';

    protected $primaryKey = 'category_post_id';

    protected $fillable = [
        'category_post_id',
        'category_id',
        'post_id',
        'created_at',
        'updated_at'
    ];
}
