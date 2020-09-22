<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class TypeInformation extends Model
{
    protected $table = 'type_information';

    protected $primaryKey = 'type_infor_id';

    protected $fillable = [
        'type_infor_id',
        'title',
        'slug',
        'type_input',
        'placeholder',
        'created_at',
        'updated_at'
    ];
}
