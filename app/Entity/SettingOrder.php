<?php
/**
 * Created by PhpStorm.
 * User: Nam Handsome
 * Date: 11/3/2017
 * Time: 2:46 PM
 */

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class SettingOrder extends Model
{
    protected $table = 'setting_order';

    protected $primaryKey = 'setting_order_id';

    protected $fillable = [
        'setting_order_id',
        'point_to_currency',
        'currency_give_point',
        'created_at',
        'updated_at'
    ];

}
