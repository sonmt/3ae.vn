<?php
/**
 * Created by PhpStorm.
 * User: Nam Handsome
 * Date: 11/14/2017
 * Time: 3:35 PM
 */

namespace App\Http\Controllers\Site;

use App\Entity\Input;
use App\Entity\MenuElement;
use Sitemap;
use App\Entity\Post;
use App\Entity\Category;
use App\Entity\SubPost;

class SitemapsController extends SiteController
{
    public function index()
    {
        // trang chủ
        Sitemap::addSitemap(asset('/'));

        // show sitemap voi tin tuc
        $category = new Category();
        $postCategories = $category->getCategory();
        $posts = Post::where('post_type', 'post')
		->where('language', 'vn')
		->orderBy('post_id', 'desc')
		->get();
        foreach ($postCategories as $cate) {
            Sitemap::addSitemap(asset('/danh-muc/'.$cate->slug));
            foreach ($cate['sub_children'] as $child) {
                Sitemap::addSitemap(asset('/danh-muc/'.$child['slug']));
            }
        }
        foreach ($posts as $post ) {
            Sitemap::addSitemap(asset('/tin-tuc/'.$post->slug));
        }

        // show sitemap voi danh muc san pham
        $productCategories =$category->getCategory('product');
        foreach ($productCategories as $cate) {
            Sitemap::addSitemap(asset('/cua-hang/'.$cate->slug));
            foreach ($cate['sub_children'] as $child) {
                Sitemap::addSitemap(asset('/cua-hang/'.$child['slug']));
            }
        }

        $products = Post::join('products', 'products.post_id', '=', 'posts.post_id')
            ->select(
                'products.product_id',
                'title',
                'slug',
                'image'
            )
			->where('posts.language', 'vn')
            ->where('post_type', 'product')->orderBy('posts.post_id', 'desc')->get();
        foreach ($products as $product ) {
            Sitemap::addSitemap(asset('/'.$product->slug));
        }
		
		foreach ($this->showLogo('vn') as $logo) {
			if (empty($logo['duong-dan-thuong-hieu'])) {
				Sitemap::addSitemap(route('logo', ['languageCurrent' => 'vn', 'markTrade' => $logo->slug] ));
                $menuElements = MenuElement::where('menu_slug', $logo->slug)
                    ->where('language', 'vn')
                    ->orderBy('menu_element_id')->get();
				foreach ($menuElements as $cateLogo) {
                    Sitemap::addSitemap(route('logo-menus', ['languageCurrent' => 'vn', 'markTrade' => $logo->slug, 'cateLogo' => $cateLogo->url]));

                    $menuIDOfLogos = Input::select('post_id')
                        ->where('input.content', $logo->title)
                        ->get();

                    $postCateLogo =  Post::where('slug', $cateLogo->url)
                        ->where('language', 'vn')
                        ->whereIn('post_id', $menuIDOfLogos)
                        ->first();
                    $menuLogo = $postCateLogo->title;

                    $inputPostIds =  Input::select('post_id')
                        ->where('input.content', $menuLogo)
                        ->get();
                    $menus = Post::whereIn('post_id', $inputPostIds)->select('posts.*')
                        ->where('posts.post_type', 'thuc-don')
                        ->where('language', 'vn')
                        ->where('visiable', 0)
                        ->whereNotNull('posts.title')->get();
                    foreach ($menus as $menu) {
                        Sitemap::addSitemap(route('show-detail-food', ['languageCurrent' => 'vn', 'markTrade' => $logo->slug, 'food' => $menu->slug]));
                    }
                }

                $logoEn = Post::join('sub_post', 'sub_post.post_id', '=', 'posts.post_id')
                    ->select(
                        'sub_post.sub_post_id',
                        'posts.post_id',
                        'title',
                        'slug',
                        'image',
                        'content',
                        'sort'
                    )
                    ->where('post_type', 'thuong-hieu-nha-hang')
                    ->where('posts.post_id', ($logo->post_id + 1) )
                    ->where('visiable', 0)
                    ->where('language', 'en')
                    ->whereNotNull('posts.title')->first();
                Sitemap::addSitemap(route('logo', ['languageCurrent' => 'en', 'markTrade' => $logoEn->slug] ));

                $menuElements = MenuElement::where('menu_slug', $logo->slug)
                    ->where('language', 'en')
                    ->orderBy('menu_element_id')->get();
                foreach ($menuElements as $cateLogo) {
                    Sitemap::addSitemap(route('logo-menus', ['languageCurrent' => 'en', 'markTrade' => $logoEn->slug, 'cateLogo' => $cateLogo->url]));

                    $menuIDOfLogos = Input::select('post_id')
                        ->where('input.content', $logo->title)
                        ->get();

                    $postCateLogo =  Post::where('slug', $cateLogo->url)
                        ->where('language', 'en')
                        ->whereIn('post_id', $menuIDOfLogos)
                        ->first();
                    $menuLogo = $postCateLogo->title;

                    $inputPostIds =  Input::select('post_id')
                        ->where('input.content', $menuLogo)
                        ->get();
                    $menus = Post::whereIn('post_id', $inputPostIds)->select('posts.*')
                        ->where('posts.post_type', 'thuc-don')
                        ->where('language', 'en')
                        ->where('visiable', 0)
                        ->whereNotNull('posts.title')->get();
                    foreach ($menus as $menu) {
                        Sitemap::addSitemap(route('show-detail-food', ['languageCurrent' => 'en', 'markTrade' => $logoEn->slug, 'food' => $menu->slug]));
                    }
                }
			}
		}


		
        // Return the sitemap to the client.
        return Sitemap::index();
    }

    private function showLogo($language) {
        $logos = Post::join('sub_post', 'sub_post.post_id', '=', 'posts.post_id')
            ->select(
                'sub_post.sub_post_id',
                'posts.post_id',
                'title',
                'slug',
                'image',
                'content',
                'sort'
            )
            ->where('post_type', 'thuong-hieu-nha-hang')
            ->where('visiable', 0)
            ->where('language', $language)
            ->whereNotNull('posts.title')->get();

        return $logos;
    }
}
