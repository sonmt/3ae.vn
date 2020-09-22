<?php
/**
 * Created by PhpStorm.
 * User: Nam Handsome
 * Date: 11/3/2017
 * Time: 2:50 PM
 */

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class OrderCodeSale extends Model
{
    protected $table = 'order_code_sale';

    protected $primaryKey = 'order_code_sale_id';

    protected $fillable = [
        'order_code_sale_id',
        'code',
        'method_sale',
        'sale',
        'many_use',
        'start',
        'end',
        'created_at',
        'updated_at'
    ];

}
