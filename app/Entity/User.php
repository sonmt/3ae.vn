<?php

namespace App\Entity;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'users';

    // thành viên
    protected static $member = 1;
    // Biên tập viên
    protected static $editor = 2;
    // Quản lý
    protected static $manager = 3;

    public static function isManager($role) {
        if ($role == User::$manager) {
            return true;
        }

        return false;
    }

    public static function isEditor($role) {
        if ($role == User::$editor) {
            return true;
        }

        return false;
    }

    public static function isMember($role) {
        if ($role == User::$member) {
            return true;
        }

        return false;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'role', 'password', 'image', 'point'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

}
