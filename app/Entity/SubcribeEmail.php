<?php
/**
 * Created by PhpStorm.
 * User: Nam Handsome
 * Date: 11/7/2017
 * Time: 2:45 PM
 */

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class SubcribeEmail extends Model
{
    protected $table = 'subcribe_email';

    protected $primaryKey = 'subcribe_email_id';

    protected $fillable = [
        'subcribe_email_id',
        'email',
        'name',
        'group_id',
        'created_at',
        'updated_at'
    ];
}
