@extends('site.layout.site')

@section('title', $languageSetup['dat-tiec'])
@section('meta_description', $information['meta_description'])
@section('keywords', $information['meta_keyword'])

@section('content')
    <section class="contacForm bgPageFull">
        <img src="img/bgPage.png" class="bgPage">
        <div class="mask"></div>
        <div class="container">
            <div class="contactContent">
                <h1 class="titleLine"><span class="line"></span><span class="title orange">{{ $languageSetup['dat-tiec'] }}</span><span class="line"></span></h1>
                <p style="color: red; font-size: 18px;">
                    <i> {{ (isset($isBookSuccess)) ? $languageSetup['cam-on-khi-dat-ban'] : '' }} </i>
                </p>

            </div>
        </div>
        </div>
    </section>
@endsection
