<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $table = 'language';

    protected $primaryKey = 'language_id';

    protected $fillable = [
        'language_id',
        'language',
        'acronym',
        'created_at',
        'updated_at',
    ];
}
