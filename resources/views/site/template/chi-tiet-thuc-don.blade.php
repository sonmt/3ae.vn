@extends('site.layout.site')

@section('title', $food->title )
@section('meta_description', $food->description )
@section('meta_image', asset($food->image) )
@section('meta_url', route('show-detail-food', ['languageCurrent' => $languageCurrent, 'markTrade' => $post->slug, 'food' => $food->slug]) )

@section('content')
<style type="text/css">
    .ds-block
    {
        display: block;
    }
    .ds-none
    {
        display: none;
    }
    @media (max-width:768px){
        .mbds-block
        {
            display: block;
        }
        .mbds-none
        {
            display: none;
        }
        .listMenuMobile
        {
            display: none;
        }
        .clickToggle i
        {
            margin-right: 5px;
        }
         .clickToggle 
        {
            display: block;
        }
        .MenuFixel
        {
            position: fixed;
            z-index: 25;
            top: 90px;
            background: #fff;
            left: 0;
            width: 100%;
            padding-left: 25px;
        }
        .Restourant {
            padding-top: 80px;
        }
		.Restourant .InfoRes {

			margin-top: 50px;
		}
    }
	 @media (max-width:500px){
		 .MenuFixel
        {
            position: fixed;
            z-index: 25;
            top: 50px;
            background: #fff;
            left: 0;
            width: 100%;
            padding-left: 25px;
        }
		.Restourant .InfoRes {

			margin-top: 30px;
		}
	 }
</style>
<section class="Restourant bgPageFull">
    <img src="{{ !empty($post['banner-thuong-hieu']) ?  asset($post['banner-thuong-hieu']) : asset('/site/img/no_image.png') }}" class="bgPage">
    <div class="mask"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="InfoRes">
                    <div class="logoContent">
                        <a href="@"><img src="{{ !empty($post->image) ?  asset($post->image) : asset('/site/img/no_image.png') }}"/></a>
                    </div>
                    <div class="info">
                        <h3>{{ $post->description }}</h3>
                        <div class="viewInfo">
                            <?= $post['thong-tin-thuong-hieu'] ?>
                        </div>
                        <div class="timeZone changeColor">
                            <i class="fa fa-clock-o" aria-hidden="true"></i>
                            <?= $post['thoi-gian-lam-viec-cua-thuong-hieu'] ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8 mbds-none">
                @include('site.module.slide_mark_trade', ['markTrade' => $postMain->title])
            </div>
        </div>

        <section class="mainMenu">
            <div class="row">
			
                <div class="col-md-4 left mbds-none">
                    <h2 class="titleLote titleBlack"><span class="line changeColor"></span>{{ $languageSetup['thuc-don'] }}
                        <span class="Color">{{ $languageSetup['nha-hang'] }} </span></h2>
                    <ul class="listMenu">
                        @foreach (\App\Entity\MenuElement::showMenuElement($postMain->slug) as $cateLogo)
                        <li class="{{ ($cateLogo->title_show == $menuLogo) ? 'active' : '' }}">
                            <a href="{{ route('logo-menus', ['languageCurrent' => $languageCurrent, 'markTrade' => $post->slug, 'cateLogo' => $cateLogo->url]) }}">
                                {{ $cateLogo->title_show }}</a>
                        </li>
                        @endforeach
                    </ul>
                    @include('site.module.news_logo', ['markTrade' => $postMain->title])

                </div>
				<!-- MOBILE -->
                    <div class="col-md-4 left ds-none mbds-block ">
                        <div class="MenuFixel">
                            <h2 class="titleLote titleBlack clickToggle"><i class="fa fa-bars" aria-hidden="true"></i> <span class="line changeColor"></span>{{ $languageSetup['thuc-don'] }}
                                <span class="Color">{{ $languageSetup['nha-hang'] }} </span></h2>
                            <ul class="listMenu listMenuMobile">
                                @foreach (\App\Entity\MenuElement::showMenuElement($postMain->slug) as $cateLogo)
								<li class="{{ ($cateLogo->title_show == $menuLogo) ? 'active' : '' }}">
									<a href="{{ route('logo-menus', ['languageCurrent' => $languageCurrent, 'markTrade' => $post->slug, 'cateLogo' => $cateLogo->url]) }}">
										{{ $cateLogo->title_show }}</a>
								</li>
								@endforeach
                            </ul>
                        </div>

                        <div class="mbds-none">
                           @include('site.module.news_logo', ['markTrade' => $postMain->title])
                        </div>
                        

                    </div>
                    <script type="text/javascript">
                        $(document).ready(function(){
                            $(".clickToggle").click(function(){
                                $(".listMenuMobile").toggle();
                            });
                        });
                    </script>
                    <!--END  MOBILE -->
				
				
				
				
				
                <div class="col-md-8 right">
                    <div class="breCrum">
                        <a href="#">Trang chủ</a> / <a href="#">Thực đơn</a> / <span>{{ $food->title }}</span>
                    </div>
                    <div class="clearfix">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="CropImg">
                                    <a class="thumbs"><img src="{{ !empty($food->image) ?  asset($food->image) : asset('/site/img/no_image.png') }}"
                                            title="{{ $food->title }}"   alt="{{ $food->title }}"/></a>
                                </div>
                            </div>
                            <div class="col-md-7 ShowContent">
                                <h1 class="Color">{{ $food->title }}</h1>
                                <div class="likeAndShare">
                                    @include('site.common.like_and_share', ['link' =>  route('show-detail-food', ['languageCurrent' => $languageCurrent, 'markTrade' => $post->slug, 'food' => $food->slug]) ])
                                </div>
                                <div class="price">{{ $food['gia-thuc-don'] }}</div>
                                <div class="Except">
                                    {{ $food->description }}
                                </div>
                            </div>
                        </div>
                        <div class="clearfix">
                            <h2 class="titleL"><span class="line changeColor"></span>{{ $languageSetup['mo-ta'] }}</h2>
                            <div class="Content">
                                <?= $food->content ?>
                            </div>
                        </div>
                        <div class="clearfix">
                            <h2 class="titleL"><span class="line changeColor"></span>{{ $languageSetup['binh-luan'] }}</h2>
                            {{--comment facebook--}}
                            <div>
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
                                     data-href="{{ route('show-detail-food', ['languageCurrent' => $languageCurrent, 'markTrade' => $post->slug, 'food' => $food->slug]) }}"
                                     data-numposts="5" data-width="100%"></div>
                            </div>
                            {{--end comment facebook--}}
                        </div>
                        <div class="clearfix">
                            <h2 class="titleL"><span class="line changeColor"></span>{{ $languageSetup['thuc-don-lien-quan'] }}</h2>
                            <div class="row listPro">
                                @foreach ($menus as $menu)
                                <div class="col-md-4 item boxPro">
                                    <div class="CropImg hoverCropZoom">
                                        <a href="{{ route('show-detail-food', ['languageCurrent' => $languageCurrent, 'markTrade' => $post->slug, 'food' => $menu->slug]) }}" class="thumbs">
                                            <img src="{{ !empty($menu->image) ?  asset($menu->image) : asset('/site/img/no_image.png') }}" alt="{{ $menu->title }}" title="{{ $menu->title }}"/></a>
                                    </div>
                                    <h3 class="tl"><a class="Color" href="{{ route('show-detail-food', ['languageCurrent' => $languageCurrent, 'markTrade' => $post->slug, 'food' => $menu->slug]) }}">{{ $menu->title }}</a></h3>
                                    <div class="except tl">
                                        {{ $menu->description }}
                                    </div>
                                    <div class="more tl"><a class="Btn hvr-radial-out changeColor" href="{{ route('show-detail-food', ['languageCurrent' => $languageCurrent, 'markTrade' => $post->slug, 'food' => $menu->slug]) }}">{{ $languageSetup['doc-them'] }}</a></div>
                                </div>
                                @endforeach
                            </div>
                        </div>
						<script>
                            //Đồng bộ chiều cao các div
                            $(function() {
                                $('.boxPro').matchHeight();
								$('.boxPro .except').matchHeight();
                            });
                        </script>
                    </div>
                </div>
            </div>
        </section>
        <!-- <section class="Ads">
            <a href="#"><img src="{{ asset('/site/img/no_image.png') }}"/></a>
        </section> -->
        @include('site.module.food_corner', ['markTrade' => $post->title])
    </div>
</section>
@endsection

