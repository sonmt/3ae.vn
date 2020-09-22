<?php
/**
 * Created by PhpStorm.
 * User: Nam Handsome
 * Date: 11/23/2017
 * Time: 8:25 AM
 */

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'contact';

    protected $primaryKey = 'contact_id';

    protected $fillable = [
        'contact_id',
        'name',
        'phone',
        'email',
        'address',
        'message',
        'created_at',
        'updated_at'
    ];
}
