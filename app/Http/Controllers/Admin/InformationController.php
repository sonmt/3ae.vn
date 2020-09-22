<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Language;
use App\Entity\TypeInformation;
use App\Entity\User;
use Illuminate\Http\Request;
use App\Entity\Information;
use Illuminate\Support\Facades\Auth;

class InformationController extends AdminController
{
    protected $role;

    public function __construct()
    {
        parent::__construct();
        $this->middleware(function ($request, $next) {
            $this->role =  Auth::user()->role;

            if (User::isMember($this->role)) {
                return redirect('admin/home');
            }

            return $next($request);
        });

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $typeInformations = TypeInformation::orderBy('type_infor_id')->get();
        $languages = Language::orderBy('language_id')->get();

        // get information
        $informations = Information::get();
        foreach($typeInformations as $id => $typeInformation) {
            foreach($languages as $language ) {
                $typeInformations[$id]['information'.$language->acronym] = '';
                foreach ($informations as $information) {
                    if ( ($information->slug_type_input == $typeInformation->slug) && ($information->language == $language->acronym )) {
                        $typeInformations[$id]['information'.$language->acronym] = $information->content;
                        break;
                    }
                }
            }

        }

        return View('admin.information.index', compact('typeInformations', 'languages'));
    }

    /**
     *  Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $contents = array();
        $languages = Language::orderBy('language_id')->get();
        foreach ($languages as $language) {
            $contents[$language->acronym] = $request->input('content'.$language->acronym);
        }
        
        $typeInformations = TypeInformation::orderBy('type_infor_id')->get();
        foreach($typeInformations as $id => $typeInformation) {
            // insert information
            foreach ($languages as $language) {
                $content = $contents[$language->acronym][$id];
                $information = new Information();
                $inforDetail = $information->where([
                    'language' =>  $language->acronym,
                    'slug_type_input' => $typeInformation->slug,
                ])->first();
                if (empty($inforDetail)) {
                    $information->insert([
                        'slug_type_input' => $typeInformation->slug,
                        'content' => $content,
                        'language' => $language->acronym
                    ]);
                } else {
                    $inforDetail->update([
                        'content' => $content,
                    ]);
                }

            }

        }

        return redirect('admin/information');
    }
    
}
