<?php
/**
 * Created by PhpStorm.
 * User: Nam Handsome
 * Date: 11/16/2017
 * Time: 11:00 AM
 */

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class LanguageSave extends Model
{
    protected $table = 'language_save';

    protected $primaryKey = 'language_save_id';

    protected $fillable = [
        'language_save_id',
        'element_type',
        'element_id',
        'main_id',
        'created_at',
        'updated_at',
    ];
}
