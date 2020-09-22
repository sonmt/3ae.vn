<?php
/**
 * Created by PhpStorm.
 * User: Nam Handsome
 * Date: 10/16/2017
 * Time: 9:24 AM
 */

namespace App\Http\Controllers\Admin;

use App\Entity\Post;
use App\Entity\TypeSubPost;
use App\Entity\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

    public function __construct(){

        $typeSubPostsAdmin = TypeSubPost::orderBy('location', 'asc')->get();
        view()->share([
            'typeSubPostsAdmin' => $typeSubPostsAdmin
        ]);
    }

    public function home() {
        session_start();
        $user = Auth::user();
        if (User::isManager($user->role) || User::isEditor($user->role)) {
            $_SESSION['loginSuccessAdmin'] = $user->email;
        }
        
        $countPost = Post::where('post_type', 'post')->count();
        $countProduct = Post::where('post_type', 'product')->count();
        $countUser = User::count();

        return View('admin.home.index', compact(
            'countPost',
            'countProduct',
            'countUser'
        ));
    }
}
