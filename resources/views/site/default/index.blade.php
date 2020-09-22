@extends('site.layout.site')

@section('title', $information['meta_title'])
@section('meta_description', $information['meta_description'])
@section('keywords', $information['meta_keyword'])
    
@section('content')
	<h1 class="titleHome1">{{$information['meta_title']}}</h1>
    @include ('site.module.slide')
    @include ('site.module.nav_search')
    @include ('site.module.set_desk')
    @include ('site.module.logo_slide')
    @include ('site.module.video_image')
    @include ('site.module.news_home')
    @include ('site.module.popup')
@endsection

