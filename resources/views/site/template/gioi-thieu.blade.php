@extends('site.layout.site')

@section('title', !empty($post->meta_title) ? $post->meta_title : $post->title)
@section('meta_description',  !empty($post->meta_description) ? $post->meta_description : $post->description)
@section('keywords', $post->meta_keyword )

@section('content')

    @include ('site.module.slide')
    <section class="textBox">
        <div class="mask"></div>
        <div class="container">
            <div class="infoText">
                <div class="cont">
                    <h2 class="title"><strong>{{ $post->title }}</strong>
                        <br>{{ $post->description }}<span></span></h2>
                    <div class="ContentNews">
                        <?= $post->content ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

