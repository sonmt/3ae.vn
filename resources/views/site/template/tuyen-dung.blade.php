@extends('site.layout.site')

@section('title', $information['meta_title'])
@section('meta_description', $information['meta_description'])
@section('keywords', $information['meta_keyword'])

@section('content')
    <section class="viewNews wow fadeInUp" data-wow-offset="300">
        <img src="{{ !empty($category->image) ?  asset($category->image) : asset('/site/img/no_image.png') }}" class="bgPage"/>
        <div class="mask"></div>
		
        <div class="RelatedNews">
            <div class="container">
                <h1 class="titleLine"><span class="line"></span><span class="title orange">{{ $category->title }}</span><span class="line"></span></h1>
				<!--
                <ul class="nav nav-tabs navTab" id="tabBar" role="tablist">
                    @foreach (\App\Entity\Category::getChidrenCate($category->category_id ) as $id => $child)
                    <li role="presentation" class="{{ ($id == 0) ? 'active' : '' }}">
                        <a href="#{{ $child->slug }}" aria-controls="home" role="tab" data-toggle="tab">{{ $child->title }}</a></li>
                    @endforeach
                </ul>
				-->
				<!--
                <div class="tab-content">
                    @foreach (\App\Entity\Category::getChidrenCate($category->category_id ) as $id => $child)
                    <div role="tabpanel" class="tab-pane {{ ($id == 0) ? 'active' : '' }}" id="{{ $child->slug }}">
                        <div class="row">
                            <div class="listRelate ">
                                @foreach (\App\Entity\Post::newPost($child->slug, 4) as $id => $new)
                                    <div class="col-md-3 col-sm-6 itemm">
										<div class="CropImg">
											<a class="thumbs" href="{{ route('post', ['cate_slug' => 'tin-noi-bat', 'post_slug' => $new->slug, 'languageCurrent' => $languageCurrent]) }}">
												<img src="{{ !empty($new->image) ?  asset($new->image) : asset('/site/img/no_image.png') }}" title="{{ $new->title }}" alt="{{ $new->title }}"/>
												<h3>{{ $new->title }}</h3>
											</a>
										</div>
									</div>
                                @endforeach
								<div class="clear"></div>
                            </div>
                        </div>
                    </div>
                   @endforeach
                </div>
				-->
            </div>
        </div>
		
        <div class="container">
            <div class="listNews">
                @foreach ($posts as $post)
                    <?php $date=date_create($post->created_at);?>
                    <div class="itemList row wow fadeInUp" data-wow-delay="0.2s">
                        <div class="col-md-4 col-sm-4">
                            <a href="{{ route('post', ['cate_slug' => $category->slug, 'post_slug' => $post->slug, 'languageCurrent' => $languageCurrent]) }}" class="thumbs">
                                <img src="{{ asset($post->image) }}" title="{{ $post->title }}" alt="{{ $post->title }}"/></a>
                        </div>
                        <div class="col-md-8 col-sm-8">
                            <h3 class="tl"><a href="{{ route('post', ['cate_slug' => $category->slug, 'post_slug' => $post->slug, 'languageCurrent' => $languageCurrent]) }}">{{ $post->title }}</a></h3>
                            <div class="DateTime">
                                {{ date_format($date,"d") }} tháng {{ date_format($date,"m") }} năm {{ date_format($date,"Y") }}
                            </div>
                            <div class="except tl">
                                {{ $post->description }}
                            </div>
                            <div class="more tl"><a class="BtnBlack" href="{{ route('post', ['cate_slug' => $category->slug, 'post_slug' => $post->slug, 'languageCurrent' => $languageCurrent]) }}">{{ $languageSetup['doc-them'] }}</a></div>
                        </div>
                    </div>
                @endforeach


                <div class="pagging">
                    {{ $posts->links() }}
                </div>
            </div>
        </div>
    </section>
@endsection

