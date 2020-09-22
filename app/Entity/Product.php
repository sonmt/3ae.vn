<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Product extends Model
{
    protected $table = 'products';

    protected $primaryKey = 'product_id';

    protected $fillable = [
        'product_id',
        'code',
        'post_id',
        'price',
        'discount',
        'discount_start',
        'discount_end',
        'image_list',
        'properties',
        'buy_together',
        'buy_after'
    ];

    public static function showProduct($slug, $countPost = 5) {
        return Post::where('posts.post_type', 'product')
            ->join('category_post', 'posts.post_id', '=', 'category_post.post_id')
            ->join('categories', 'category_post.category_id', '=', 'categories.category_id')
            ->join('products', 'products.post_id', '=', 'posts.post_id')
            ->where('categories.slug', $slug)
            ->select(
                'posts.*',
                'products.price',
                'products.discount',
                'products.discount_start',
                'products.discount_end'
            )
            ->offset(0)
            ->limit($countPost)->get();
    }

    public static function newProduct($countPost = 5) {
        return Post::where('posts.post_type', 'product')
            ->join('products', 'products.post_id', '=', 'posts.post_id')
            ->select(
                'posts.title',
                'posts.description',
                'posts.image',
                'posts.slug',
                'products.price',
                'products.discount'
            )
            ->offset(0)
            ->limit($countPost)->get();
    }

    public static function detailProduct($slug) {

        return Post::where('posts.post_type', 'product')
            ->join('products', 'products.post_id', '=', 'posts.post_id')
            ->where('posts.slug', $slug)
            ->select(
                'posts.title',
                'posts.description',
                'posts.image',
                'posts.slug',
                'products.price',
                'products.discount',
                'products.product_id'
            )
            ->first();
    }

    public static function relativeProduct($slug, $countProduct=4) {
        $categoriesDB = Post::where('posts.post_type', 'product')
            ->join('category_post', 'posts.post_id', '=', 'category_post.post_id')
            ->join('categories', 'category_post.category_id', '=', 'categories.category_id')
            ->join('products', 'products.post_id', '=', 'posts.post_id')
            ->where('posts.slug', $slug)
            ->select(
                'categories.category_id'
            )
            ->get();

        $categories = array();
        foreach($categoriesDB as $category) {
            $categories[] =  $category->category_id;
        }

        return Post::where('posts.post_type', 'product')
            ->join('category_post', 'posts.post_id', '=', 'category_post.post_id')
            ->join('categories', 'category_post.category_id', '=', 'categories.category_id')
            ->join('products', 'products.post_id', '=', 'posts.post_id')
            ->whereIn('categories.category_id', $categories)
            ->select(
                'posts.title',
                'posts.description',
                'posts.image',
                'posts.slug',
                'products.price',
                'products.discount',
                'products.product_id'
            )
            ->offset(0)
            ->limit($countProduct)->get();
    }

    public static function showProductWithMenu ($slug, $countProduct =6) {
        $menus = MenuElement::showMenuElement($slug);
        $cateSlug = array();
        foreach ($menus as $menu) {
            $urls = explode('/', $menu->url);
            if(isset($urls[2])) {
               $cateSlug[] = $urls[2];
            }
        }                                                   

        return Post::where('posts.post_type', 'product')
            ->join('category_post', 'posts.post_id', '=', 'category_post.post_id')
            ->join('categories', 'category_post.category_id', '=', 'categories.category_id')
            ->join('products', 'products.post_id', '=', 'posts.post_id')
            ->whereIn('categories.slug', $cateSlug)
            ->select(
                'posts.title',
                'posts.description',
                'posts.image',
                'posts.slug',
                'products.price',
                'products.discount',
                'products.product_id'
            )->distinct()
            ->offset(0)
            ->limit($countProduct)->get();

    }

    public static function saveProductSeen($request, $product = null) {
        $seenProducts = null;
        if ($request->session()->has('productReaded')) {
            $seenProducts = $request->session()->get('productReaded');
            foreach ($seenProducts as $pSeen) {
                if (!empty($product) && ($pSeen->product_id == $product->product_id) ) {
                    return $seenProducts;
                }
            }

        }

        if(!empty($product)) {
            $request->session()->push('productReaded', $product);
        }

        return $request->session()->get('productReaded');
    }
}
