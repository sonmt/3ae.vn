<?php
/**
 * Created by PhpStorm.
 * User: Nam Handsome
 * Date: 11/18/2017
 * Time: 3:27 PM
 */

namespace App\Http\Controllers\Site;


use App\Entity\Category;
use App\Entity\LanguageSave;
use App\Entity\Post;
use Illuminate\Http\Request;

class LanguageController extends SiteController
{
    public function index(Request $request) {
        $language = $request->input('language');
        $currentLink = $request->input('current_link');
        $nameRoute = $request->input('name_route');
        $mainId = $request->input('main_id');
        $arrayRoute = $request->input('array_route');
        session(['languageCurrent' => $language]);

        switch ($nameRoute) {
            case 'contact':
                return redirect(route('lien-he', ['languageCurrent' => $language]));
            case 'lien-he':
                return redirect(route('contact', ['languageCurrent' => $language]));
            case 'next_video' :
                return redirect(route('next_video_en', ['languageCurrent' => $language]));
            case 'next_video_en':
                return redirect(route('next_video', ['languageCurrent' => $language]));
            case 'category':
                $categories = LanguageSave::where('main_id', $mainId)->first();
                $category = Category::where('language', $language)
                    ->whereNotNull('title')
                    ->whereIn('category_id', explode(',', $categories->element_id))->first();

                if (empty($category)) {
                    return redirect('/');
                }
                return redirect(route('category', ['languageCurrent' => $language, 'cate_slug' => $category->slug]));
            case 'post':
                $post = LanguageSave::where('main_id', $mainId)->first();
                $postLanguage = Post::where('language', $language)
                    ->whereNotNull('title')
                    ->whereIn('post_id', explode(',', $post->element_id))->first();

                $categories = LanguageSave::where('main_id', $arrayRoute)->first();
                $category = Category::where('language', $language)
                    ->whereIn('category_id', explode(',', $categories->element_id))
                    ->whereNotNull('title')
                    ->first();

                if (empty($postLanguage) || empty($category)) {
                    return redirect('/');
                }

                return redirect(route('post', ['languageCurrent' => $language, 'cate_slug' => $category->slug, 'post_slug' => $postLanguage->slug]));
            case 'logo':
                $logo = LanguageSave::where('main_id', $mainId)
                    ->first();
                $logoLanguage = Post::where('language', $language)
                    ->whereNotNull('title')
                    ->whereIn('post_id', explode(',', $logo->element_id))->first();

                if (empty($logoLanguage)) {
                    return redirect('/');
                }
                
                return redirect(route('logo', ['languageCurrent' => $language, 'markTrade' => $logoLanguage->slug]));
            case 'logo-menus':
                $logo = LanguageSave::where('main_id', $mainId)
                    ->first();
                $logoLanguage = Post::where('language', $language)
                    ->whereNotNull('title')
                    ->whereIn('post_id', explode(',', $logo->element_id))
                    ->whereNotNull('title')->first();
                
                $menuLogo = LanguageSave::where('main_id', $arrayRoute)->first();
                $menuLogoLanguage = Post::where('language', $language)
                    ->whereIn('post_id', explode(',', $menuLogo->element_id))
                    ->whereNotNull('title')
                    ->first();

                if (empty($menuLogoLanguage) || empty($logo)) {
                    return redirect('/');
                }
                
                return redirect(route('logo-menus', ['languageCurrent' => $language, 'markTrade' => $logoLanguage->slug, 'cateLogo' => $menuLogoLanguage->slug]));
            case 'show-detail-food':
                $logo = LanguageSave::where('main_id', $mainId)
                        ->whereNotNull('title')>first();
                $logoLanguage = Post::where('language', $language)
                    ->whereIn('post_id', explode(',', $logo->element_id))
                    ->whereNotNull('title')->first();

                $food = LanguageSave::where('main_id', $arrayRoute)->first();
                $foodLanguage = Post::where('language', $language)
                    ->whereIn('post_id', explode(',', $food->element_id))
                    ->whereNotNull('title')->first();

                if (empty($foodLanguage) || empty($logo)) {
                    return redirect('/');
                }
                return redirect(route('show-detail-food', ['languageCurrent' => $language, 'markTrade' => $logoLanguage->slug, 'food' => $foodLanguage->slug]));
            default:
                return redirect('/');
        }


    }
}
