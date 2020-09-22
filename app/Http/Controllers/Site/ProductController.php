<?php
/**
 * Created by PhpStorm.
 * User: Nam Handsome
 * Date: 10/19/2017
 * Time: 10:23 AM
 */

namespace App\Http\Controllers\Site;


use App\Entity\Category;
use App\Entity\Input;
use App\Entity\Post;
use App\Entity\Product;
use App\Entity\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends SiteController
{
    public function index($slug_post, Request $request) {

        $product = Post::join('products', 'products.post_id','=', 'posts.post_id')
            ->select(
                'products.price',
                'products.image_list',
                'products.discount',
                'products.code',
                'products.product_id',
                'products.properties',
                'products.buy_together',
                'products.buy_after',
                'posts.*'
            )
            ->where('posts.slug', $slug_post)->first();
        
        $inputs = Input::where('post_id', $product->post_id)->get();
        foreach ($inputs as $input) {
            $product[$input->type_input_slug] = $input->content;
        }
        $averageRating = $product->avgRating;
        $sumRating = $product->countPositive;
        
        $categories = Category::join('category_post', 'categories.category_id', '=', 'category_post.category_id')
            ->select('categories.*')
            ->where('category_post.post_id', $product->post_id)->get();

        // product seen
        $productSeen = Product::saveProductSeen($request, $product);
        
        if ($product->template == 'default') {
            return view('site.default.product', compact('product', 'categories', 'productSeen', 'averageRating', 'sumRating'));
        } else {
            return view('site.template.'.$product->template, compact('product', 'categories', 'productSeen', 'averageRating', 'sumRating'));
        }
    }

    public function Rating(Request $request){
        $postId = $request->input('postid');
        $rating = $request->input('rating');

        $post = Post::where('post_id', $postId)->first();
        $post->id = $post->post_id;
        $user = User::first();
        $rating = $post->rating([
            'rating' => $rating
        ], $user);
        $averageRating = $post->avgRating;
        $return_arr = array("averageRating"=>$averageRating);

        return response()->json($return_arr);
    }
}
