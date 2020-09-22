<?php
/**
 * Created by PhpStorm.
 * User: Nam Handsome
 * Date: 11/13/2017
 * Time: 9:30 AM
 */

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class GroupMail extends Model
{
    protected $table = 'group_mail';

    protected $primaryKey = 'group_mail_id';

    protected $fillable = [
        'group_mail_id',
        'name',
        'description',
    ];
}
