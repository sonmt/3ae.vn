@extends('site.layout.site')

@section('title', $post->title )
@section('meta_description', $post->description )
@section('keywords', '')

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
    @media (max-width:1000px){
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
            top: 76px;
            background: #fff;
            left: 0;
            width: 100%;
            padding-left: 25px;
        }
        .Restourant {
            padding-top: 80px;
        }
    }
	@media (max-width:500px)
	{
		.MenuFixel {
			position: fixed;
			z-index: 25;
			top: 50px;
			background: #fff;
			left: 0;
			width: 100%;
			padding-left: 25px;
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
                            <a href="{{ route('logo', ['languageCurrent' => $languageCurrent, 'markTrade' => $post->slug]) }}">
                                <img src="{{ !empty($post->image) ?  asset($post->image) : asset('/site/img/no_image.png') }}" title="{{ $post->title }}" alt="{{ $post->title }}"/></a>
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
                                <li class="{{ ($cateLogo->url == $menuLogoCurrent) ? 'active' : '' }}">
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
                                    <li class="{{ ($cateLogo->url == $menuLogoCurrent) ? 'active' : '' }}">
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
                        <h2 class="titleLine"><span class="line"></span><span class="title Color">{{ $languageSetup['thuc-don'] }}</span><span class="line"></span></h2>
                        <div class="row listPro">
                            @foreach ($menus as $id => $menu)
                                <div class="col-md-4 item boxPro">
                                    <div class="CropImg hoverCropZoom">
                                        <a href="{{ route('show-detail-food', ['languageCurrent' => $languageCurrent, 'markTrade' => $post->slug, 'food' => $menu->slug]) }}" class="thumbs">
                                            <img src="{{ !empty($menu->image) ?  asset($menu->image) : asset('/site/img/no_image.png') }}" alt="{{ $menu->title }}" title="{{ $menu->title }}"/>
                                        </a>
                                    </div>
                                    <h3 class="tl"><a class="Color" href="{{ route('show-detail-food', ['languageCurrent' => $languageCurrent, 'markTrade' => $post->slug, 'menu' => $menu->slug]) }}">{{ $menu->title }}</a></h3>
                                    <div class="except tl">
                                        {{ $menu->description }}
                                    </div>
                                    <div class="more tl">
                                        <a class="Btn hvr-radial-out changeColor" href="{{ route('show-detail-food', ['languageCurrent' => $languageCurrent, 'markTrade' => $post->slug, 'food' => $menu->slug]) }}">{{ !empty($menu['gia-thuc-don']) ? $menu['gia-thuc-don'] : 'Xem chi tiết' }}</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="pagging Black">
                            {{ $menus->links() }}
                        </div>
                        <script>
                            //Đồng bộ chiều cao các div
                            $(function() {
                                $('.boxPro').matchHeight();
								$('.boxPro .except').matchHeight();
                            });
                        </script>

                        <div class="ds-none mbds-block">
                            @include('site.module.news_logo', ['markTrade' => $postMain->title])
                        </div>

                    </div>
                </div>
            </section>
           
           @include('site.module.food_corner', ['markTrade' => $post->title])
        </div>
    </section>
@endsection

