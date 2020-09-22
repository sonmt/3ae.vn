@extends('site.layout.site')

@section('title', !empty($post->meta_title) ? $post->meta_title : $post->title)
@section('meta_description',  !empty($post->meta_description) ? $post->meta_description : $post->description)
@section('keywords', $post->meta_keyword )
@section('meta_image', asset($post->image) )
@section('meta_url', route('post', ['cate_slug' => $category->slug, 'post_slug' => $post->slug, 'languageCurrent' => $languageCurrent]) )

@section('content')
    <section class="viewNews wow fadeInUp" data-wow-offset="300">
        <div class="mask"></div>
        <div class="container">
            <div class="titleLine"><span class="line"></span><span class="title orange">{{ $category->title }}</span><span class="line"></span></div>
            <div class="infoNews">
                <div class="cont">
                    <h1 class="titleNews">{{$post->title}} 
					@if(isset($post->hotnews_start))
						@if(strtotime($post->hotnews_start) < time() && strtotime($post->hotnews_end) > time())
							(Hot)
						@elseif (strtotime($post->hotnews_end) < time())
							<span style="color: red">(Hết hạn)</span>
						@endif
					@endif</h1>
                    <div class="likeAndShare">
                        @include('site.common.like_and_share', ['link' =>  route('post', ['cate_slug' => $category->slug, 'post_slug' => $post->slug, 'languageCurrent' => $languageCurrent])])
                    </div>
                    <div class="DateTime">
                        <i class="fa fa-clock-o" aria-hidden="true"></i> <?php $date=date_create($post->created_at); echo date_format($date,"d/m/Y h:i:s");?>
                    </div>
                    <div class="exceptNews mb20">
                        {{ $post->description }}
                    </div>
                    <div class="contentNews">
						<div class="mb20">
							<!-- Go to www.addthis.com/dashboard to customize your tools --> <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-541a6755479ce315"></script>
							<!-- Go to www.addthis.com/dashboard to customize your tools --> <div class="addthis_inline_share_toolbox"></div>
						</div>
                       {{-- <div class="tc mb20"><img src="{{ !empty($post->image) ?  asset($post->image) : asset('/site/img/no_image.png') }}"/></div>--}}
                        <p>
                            <?= $post->content ?>
                        </p>
                    </div>
                    <div class="Tags mb20">
                        <i class="fa fa-tag" aria-hidden="true">
                        </i>Tags
                        @if(!empty($post->tags))
                            @foreach(explode(',', $post->tags) as $tag)
                                <a href="{{ route('search', [ 'languageCurrent' => $languageCurrent] ) }}?tags={{ $tag }}">{{ $tag }}</a>
                            @endforeach
                        @endif
                    </div>
					<div class="col-xs-12 mb20">
                        <?= isset($post['ban-do-nha-hang']) ? $post['ban-do-nha-hang'] : '' ?>
                    </div>
                    {{--comment fb--}}
                    <div id="fb-root"></div>
                    <script>(function (d, s, id) {
                            var js, fjs = d.getElementsByTagName(s)[0];
                            if (d.getElementById(id)) return;
                            js = d.createElement(s);
                            js.id = id;
                            js.src = 'https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.11&appId=887742841384108';
                            fjs.parentNode.insertBefore(js, fjs);
                        }(document, 'script', 'facebook-jssdk'));</script>
                    <div class="fb-comments"
                         data-href="{{ route('post', ['languageCurrent' => $languageCurrent, 'cate_slug' => $category->slug, 'post_slug' => $post->slug]) }}"
                         data-numposts="5" data-width="100%"></div>
                    {{--end comment fb--}}
                    
                </div>
            </div>
        </div>
        @include('site.module.relate_news')
    </section>
@endsection

