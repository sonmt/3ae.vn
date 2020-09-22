<?php
/**
 * Created by PhpStorm.
 * User: Nam Handsome
 * Date: 11/3/2017
 * Time: 2:45 PM
 */

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class OrderBank extends Model
{
    protected $table = 'order_bank';

    protected $primaryKey = 'order_bank_id';

    protected $fillable = [
        'order_bank_id',
        'name_bank',
        'manager_account',
        'branch',
        'number_bank',
        'created_at',
        'updated_at'
    ];
}
