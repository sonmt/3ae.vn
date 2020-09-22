@extends('site.layout.site')

@section('title', $category->title)
@section('meta_description',  $category->description )
@section('keywords', '')

@section('content')
    <section class="viewNews wow fadeInUp" data-wow-offset="300">
        <img src="{{ !empty($category->image) ?  asset($category->image) : asset('/site/img/no_image.png') }}" class="bgPage"/>
        <div class="mask"></div>
        <div class="RelatedNews">
            <div class="container">
                <h1 class="titleLine"><span class="line"></span><span class="title orange">{{ $category->title }}</span><span class="line"></span></h1>
                <ul class="nav nav-tabs navTab {{ $category->slug }}" id="tabBar" role="tablist">
                    <li role="presentation" class="active"><a href="#tab1" aria-controls="home" role="tab" data-toggle="tab">{{ $languageSetup['tin-moi-nhat'] }}</a></li>
                    <li role="presentation"><a href="#tab2" aria-controls="home" role="tab" data-toggle="tab">{{ $languageSetup['tin-noi-bat'] }}</a></li>
                </ul>
                <div class="tab-content {{ $category->slug }}">
                    <div role="tabpanel" class="tab-pane active" id="tab1">
                        <div class="row">
                            <div class="listRelate">
                                @foreach (\App\Entity\Post::newPost('tin-tuc', 4) as $id => $new)
                                <div class="col-md-3 col-sm-6 itemm">
									
										<a href="{{ route('post', ['cate_slug' => 'tin-tuc', 'post_slug' => $new->slug, 'languageCurrent' => $languageCurrent]) }}">
											<img src="{{ !empty($new->image) ?  asset($new->image) : asset('/site/img/no_image.png') }}" alt="{{ $new->title }}" title="{{ $new->title }}"/>
											<h3>{{ $new->title }}</h3>
										</a>
									
                                </div>
                                @endforeach
								<div class="clear"></div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="tab2">
                        <div class="row">
                            <div class="listRelate">
                                @foreach (\App\Entity\Post::newPost('tin-noi-bat', 4) as $id => $new)
                                    <div class="col-md-3 col-sm-6 itemm">
										
                                        <a href="{{ route('post', ['cate_slug' => 'tin-noi-bat', 'post_slug' => $new->slug, 'languageCurrent' => $languageCurrent]) }}">
                                            <img src="{{ !empty($new->image) ?  asset($new->image) : asset('/site/img/no_image.png') }}" alt="{{ $new->title }}" title="{{ $new->title }}"/>
                                            <h3>{{ $new->title }}</h3>
										
                                        </a>
                                    </div>
                                @endforeach
								<div class="clear"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="listNews">
                @foreach ($posts as $post)
                    <?php $date=date_create($post->created_at);?>
                <div class="itemList row wow fadeInUp" data-wow-delay="0.2s">
                    <div class="col-md-4 col-sm-4">
						<div class="CropImg">
							<a href="{{ route('post', ['cate_slug' => $category->slug, 'post_slug' => $post->slug, 'languageCurrent' => $languageCurrent]) }}" class="thumbs">
                                <img src="{{ !empty($post->image) ?  asset($post->image) : asset('/site/img/no_image.png') }}" title="{{ $post->title }}" alt="{{ $post->title }}"/></a>
						</div>
                    </div>
                    <div class="col-md-8 col-sm-8">
                        <h3 class="tl">
                            <a href="{{ route('post', ['cate_slug' => $category->slug, 'post_slug' => $post->slug, 'languageCurrent' => $languageCurrent]) }}">{{ $post->title }}
                                @if(isset($post->hotnews_start))
                                    @if(strtotime($post->hotnews_start) < time() && strtotime($post->hotnews_end) > time())
                                        (Hot)
                                    @elseif (strtotime($post->hotnews_end) < time())
                                        <span style="color: red">(Hết hạn)</span>
                                    @endif
                                @endif
                            </a></h3>
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

