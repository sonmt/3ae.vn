<?php
/**
 * Created by PhpStorm.
 * User: Nam Handsome
 * Date: 10/19/2017
 * Time: 10:24 AM
 */

namespace App\Http\Controllers\Site;


use App\Entity\Category;
use App\Entity\Post;
use App\Entity\Product;
use App\Ultility\Ultility;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Input;

class ProductCategoryController extends SiteController
{
    public function index($cate_slug, Request $request) {
        $category = Category::where('slug', $cate_slug)->first();

        $products = Post::join('category_post', 'category_post.post_id', '=', 'posts.post_id')
            ->join('products', 'products.post_id', '=', 'posts.post_id')
            ->select(
                'posts.*',
                'products.price',
                'products.discount',
                'products.discount_start',
                'products.discount_end'
                )
            ->where('category_post.category_id', $category->category_id);

        if (!empty($request->input('word'))) {
            $word = $request->input('word');
            $products =  $products->where('posts.slug', 'like', '%'.Ultility::createSlug($word).'%');
        }
        $products = $products->paginate(16);

        $productSeen =Product::saveProductSeen($request);
        
        if ($category->template == 'default') {
            return view('site.default.category_product', compact('category', 'products', 'productSeen'));
        } else {
            return view('site.template.'.$category->template, compact('category', 'products', 'productSeen'));
        }
    }

    public function filter(Request $request) {
        $mark = $request->input('mark');
        $madeInOf = $request->input('made_in_of');
        $cateSlug = $request->input('slug_cate');

        $category = Category::where('slug', $cateSlug)->first();
        // tìm kiếm theo thương hiệu
        $products = Post::join('category_post', 'category_post.post_id', '=', 'posts.post_id')
            ->join('products', 'products.post_id', '=', 'posts.post_id')
            ->leftJoin('input', 'input.post_id', '=', 'posts.post_id')
            ->select(
                'posts.*',
                'products.price',
                'products.discount'
            )
            ->where('category_post.category_id', $category->category_id)
            ->where('input.type_input_slug', 'hang-san-xuat');
            if(!empty($mark)) {
                $products = $products->whereIn('input.content', $mark);
            }


        // tìm kiếm theo nơi sản xuất
        if(!empty($madeInOf)) {
        $productMadeInOf =  Post::leftJoin('category_post', 'category_post.post_id', '=', 'posts.post_id')
            ->leftJoin('products', 'products.post_id', '=', 'posts.post_id')
            ->leftJoin('input', 'input.post_id', '=', 'posts.post_id')
            ->select(
                'posts.*',
                'products.price',
                'products.discount'
            )
            ->where('category_post.category_id', $category->category_id)
            ->where('input.type_input_slug', 'xuat-xu')
            ->whereIn('input.content', $madeInOf);

            $products = $products->union($productMadeInOf);
        }


        // tìm kiếm theo khoảng giá
        $priceRanges = $request->input('price_range');
        if (!empty($priceRanges)) {
            $priceRange = explode('-', $priceRanges);
            $productPriceRange =  Post::leftJoin('category_post', 'category_post.post_id', '=', 'posts.post_id')
                ->leftJoin('products', 'products.post_id', '=', 'posts.post_id')
                ->select(
                    'posts.*',
                    'products.price',
                    'products.discount'
                )
                ->where('category_post.category_id', $category->category_id)
                ->where('products.price','>=', $priceRange[0])
                ->where('products.price', '<=', $priceRange[1]);

            $products = $products->union($productPriceRange);
        }

        $productSeen =Product::saveProductSeen($request);

        $products = $products->get();
        if ($category->template == 'default') {
            return view('site.default.category_product', compact('category', 'products', 'productSeen'));
        } else {
            return view('site.template.'.$category->template, compact('category', 'products', 'productSeen'));
        }
    }

    public function search(Request $request) {
        $category = $request->input('category');
        $word = $request->input('word');

        if ($category == 'all') {

            $products = Post::join('products', 'products.post_id', '=', 'posts.post_id')
                ->select(
                    'posts.*',
                    'products.price',
                    'products.discount',
                    'products.discount_start',
                    'products.discount_end'
                )
                ->where('posts.post_type', 'product')
                ->where('posts.slug', 'like', '%'.Ultility::createSlug($word).'%')
                ->paginate(16);

            $productSeen =Product::saveProductSeen($request);

            return view('site.default.search', compact('category', 'products', 'productSeen'));
           
        }


        return redirect($category.'?word='.$word.'&category='.$category);
    }

    public function searchAjax(Request $request) {
        $word = $request->input('word');
        
        if ( empty($word) ) {
            return response('Error', 404)
                ->header('Content-Type', 'text/plain');
        }

        $products = Post::join('products', 'products.post_id', '=', 'posts.post_id')
            ->select(
                'posts.*',
                'products.price',
                'products.discount',
                'products.discount_start',
                'products.discount_end'
            )
            ->where('posts.slug', 'like', '%'.Ultility::createSlug($word).'%')
            ->offset(0)
            ->limit(5)->get();

        return response([
            'status' => 200,
            'products' => $products
        ])->header('Content-Type', 'text/plain');
    }
}
