<?php
/**
 * Created by PhpStorm.
 * User: Nam Handsome
 * Date: 9/24/2017
 * Time: 3:59 PM
 */

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    protected $table = 'information';

    protected $primaryKey = 'infor_id';

    protected $fillable = [
        'infor_id',
        'slug_type_input',
        'content',
        'language',
        'updated_at'
    ];
}
