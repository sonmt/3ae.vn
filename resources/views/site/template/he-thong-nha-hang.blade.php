@extends('site.layout.site')

@section('title', $information['meta_title'])
@section('meta_description', $information['meta_description'])
@section('keywords', $information['meta_keyword'])

@section('content')
    <section class="viewBg viewTextbox wow fadeInUp bgPageFull" data-wow-offset="300">
        <img src="{{ !empty($category->image) ?  asset($category->image) : asset('/site/img/no_image.png') }}" class="bgPage">
        <div class="mask"></div>
        <div class="container">
            <h1 class="titleLine"><span class="line"></span><span class="title orange">{{ $category->title }}</span><span class="line"></span></h1>
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="infoProduct row">
                        <div class="cont">
                            <div class="Views">
                                <p>
                                    {{ $category->description }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <ul class="listProduct">
						
                        @foreach ($posts as $id => $post)
                        <li class="row {{ ( ($id % 2) == 0) ? 'left' : 'right' }}">
                            @if ($id % 2 == 0)
                            <div class="col-md-6 col-xs-12">
                                <div class="CropImg">
                                    <a href="{{ !empty($post['link-landing']) ? $post['link-landing'] : route('post', ['cate_slug' => $category->slug, 'post_slug' => $post->slug, 'languageCurrent' => $languageCurrent]) }}" class="thumbs">
                                        <img src="{{ asset($post->image) }}" alt="{{ $post->title }}" title="{{ $post->title }}"/>
											
                                    </a>
                                </div>
                            </div>
                            @endif
                            <div class="col-md-6 col-xs-12">
                                <h3><a href="{{ !empty($post['link-landing']) ? $post['link-landing'] : route('post', ['cate_slug' => $category->slug, 'post_slug' => $post->slug, 'languageCurrent' => $languageCurrent]) }}">{{ $post->title }} </a></h3>
                                <div class="except">
                                   <?= $post->content ?>
                                </div>
                                <div class="tr readMore"><a href="{{ route('post', ['cate_slug' => $category->slug, 'post_slug' => $post->slug, 'languageCurrent' => $languageCurrent]) }}" class="BtnBlack">{{ $languageSetup['xem-chi-tiet'] }}</a></div>
                            </div>
                            @if ($id % 2 == 1)
                                <div class="col-md-6 col-xs-12">
                                    <div class="CropImg">
                                        <a href="{{ !empty($post['link-landing']) ? $post['link-landing'] : route('post', ['cate_slug' => $category->slug, 'post_slug' => $post->slug, 'languageCurrent' => $languageCurrent]) }}" class="thumbs">
                                            <img src="{{ asset($post->image) }}" alt="{{ $post->title }}" title="{{ $post->title }}"/>
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </li>
                        @endforeach
                    </ul>

                    <div class="pagging">
                        {{ $posts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

