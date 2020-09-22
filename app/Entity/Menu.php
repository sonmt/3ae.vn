<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menus';

    protected $primaryKey = 'menu_id';

    protected $fillable = [
        'menu_id',
        'title',
        'slug',
        'location',
        'image',
        'created_at',
        'updated_at'
    ];

    public static function showTitleMenu($slug) {
        $menu = static::where('slug', $slug)->first();

        return $menu->title;
    }

    public static function showWithLocation($slug) {
       $menus = static::orderBy('menu_id')->where('location', $slug)->get();

       return $menus;
    }

}
