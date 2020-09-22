<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $table = 'template';

    protected $primaryKey = 'template_id';

    protected $fillable = [
        'template_id',
        'title',
        'slug',
        'is_hide',
        'created_at',
        'updated_at'
    ];

    
}
