<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    protected $primaryKey = 'category_id';

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'description',
        'image',
        'template',
        'parent',
        'post_type',
        'is_hide',
        'language',
        'created_at',
        'updated_at'
    ];

    public function getCategory($postType = 'post'){
        $categories = $this->where([
            'parent' => 0,
            'post_type' => $postType,
        ])->orderBy('category_id')
            ->where('language', 'vn')->get();

        foreach ($categories as $id => $cate) {
            $categories[$id]['sub_children'] = array();
            $categories[$id]['sub_children'] = $this->getSubCategory($cate->category_id, $categories[$id]['sub_children'], $postType);
        }

        return $categories;
    }

    public function getCategoryLanguage ($postType = 'post', $mainId) {
        try {
			$categoryLanguage = LanguageSave::where('main_id', $mainId)
            ->where('element_type', 'category')->select('element_id')->first();

			$categories = $this->where([
				'post_type' => $postType,
			])->orderBy('category_id')
				->whereIn('category_id', explode(',', $categoryLanguage->element_id))->get();

			return $categories;
		} catch(\Exception $e) {
			return array();
		}
    }
    public function getSubCategory($cateId, $categorySource = array(), $postType = 'post', $subChild = '') {
        $categories = $this->where([
            'parent' => $cateId,
            'post_type' => $postType
        ])->where('language', 'vn')
            ->orderBy('category_id')->get();
        
        if($categories->isEmpty()) {
            
            return $categorySource;
        }
        $subChild .= '---';
        foreach ($categories as $cate) {
            $categorySource[] = [
                'title' => $subChild.$cate->title,
                'category_id' => $cate->category_id,
                'image' => $cate->image,
                'slug' => $cate->slug,
                'language' => $this->getCategoryLanguage('post', $cate->category_id)
            ];
            $categorySource = $this->getSubCategory($cate->category_id, $categorySource, $postType, $subChild);
        }
           
        return $categorySource;
    }

    public static function getChidrenCate($cateId, $postType = 'post') {
        $languageCurrent = session('languageCurrent', 'vn');
        $languages = Language::orderBy('language_id', 'asc')->get();
        $indexLangCurrent = 0;
        foreach ($languages as $id => $language) {
            if ($language->acronym == $languageCurrent) {
                $indexLangCurrent = $id;
            }
        }
        $cateId = $cateId - $indexLangCurrent;
        
        $categories = static::where([
            'parent' => $cateId,
            'post_type' => $postType
        ])->where('language', $languageCurrent)
            ->orderBy('category_id')->get();

        return  $categories;
    }
}
