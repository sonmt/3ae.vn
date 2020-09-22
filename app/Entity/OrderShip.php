<?php
/**
 * Created by PhpStorm.
 * User: Nam Handsome
 * Date: 11/3/2017
 * Time: 2:46 PM
 */

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class OrderShip extends Model
{
    protected $table = 'order_ship';

    protected $primaryKey = 'order_ship_id';

    protected $fillable = [
        'order_ship_id',
        'method_ship',
        'cost',
        'created_at',
        'updated_at'
    ];
}
