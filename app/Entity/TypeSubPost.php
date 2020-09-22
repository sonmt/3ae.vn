<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class TypeSubPost extends Model
{
    protected $table = 'type_sub_post';

    protected $primaryKey = 'type_sub_post_id';

    protected $fillable = [
        'type_sub_post_id',
        'title',
        'slug',
        'input_default_used',
        'template',
        'location',
        'show_menu',
        'have_sort',
        'is_index_hot',
        'created_at',
        'updated_at'
    ];
}
