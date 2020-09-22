<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class TypeInput extends Model
{
    protected $table = 'type_input';

    protected $primaryKey = 'type_input_id';

    protected $fillable = [
        'type_input_id',
        'title',
        'slug',
        'type_input',
        'placeholder',
        'post_used',
        'general',
        'created_at',
        'updated_at'
    ];
}
