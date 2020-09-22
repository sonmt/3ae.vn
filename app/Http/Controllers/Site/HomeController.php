<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use Yangqi\Htmldom\Htmldom;

class HomeController extends SiteController
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      
        return view('site.default.index');
    }
}
