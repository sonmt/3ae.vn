<section class="listLogo wow fadeInUp" data-wow-offset="300">
    <div class="container">
        <h2 class="titleLote titleBlack tc mb50">{{ $languageSetup['thuong-hieu'] }} <span class="Nb red">{{ $languageSetup['nha-hang'] }}</span></h2>
		<div class="row">
			@foreach(\App\Entity\SubPost::showSubPost('thuong-hieu-nha-hang', 20) as $id => $post)
				@if ( strpos($post->slug, '3ae') !== false )
					<div class="col-md-12 item boxLogo">
						<a target="_blank" class="thumbs hoverZoom" target="" href="{{ empty($post['duong-dan-thuong-hieu']) ? route('logo', ['languageCurrent' => $languageCurrent, 'markTrade' => $post->slug] ) : $post['duong-dan-thuong-hieu'] }}">
						<img src="{{ !empty($post->image) ?  asset($post->image) : asset('/site/img/no_image.png') }}"/></a>
						<div class="clearfix readMore"><a target="_blank" class="hvr-radial-out" href="{{ empty($post['duong-dan-thuong-hieu']) ? route('logo', ['languageCurrent' => $languageCurrent, 'markTrade' => $post->slug] ) : $post['duong-dan-thuong-hieu'] }}"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i> {{ $languageSetup['xem-chi-tiet'] }}</a></div>
					</div>
					@else
					<div class="col-md-3 item boxLogo">
						<a target="_blank" class="thumbs hoverZoom" target="" href="{{ empty($post['duong-dan-thuong-hieu']) ? route('logo', ['languageCurrent' => $languageCurrent, 'markTrade' => $post->slug] ) : $post['duong-dan-thuong-hieu'] }}">
						<img src="{{ !empty($post->image) ?  asset($post->image) : asset('/site/img/no_image.png') }}"/></a>
						<div class="clearfix readMore"><a target="_blank" class="hvr-radial-out" href="{{ empty($post['duong-dan-thuong-hieu']) ? route('logo', ['languageCurrent' => $languageCurrent, 'markTrade' => $post->slug] ) : $post['duong-dan-thuong-hieu'] }}"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i> {{ $languageSetup['xem-chi-tiet'] }}</a></div>
					</div>
				@endif
			@endforeach
		</div>
		<script>
			//Đồng bộ chiều cao các div
			$(function() {
				$('.boxLogo').matchHeight();
			});
		</script>
        <!-- logoSlide <div id="logoList" class="owl-carousel">
            @foreach(\App\Entity\SubPost::showSubPost('thuong-hieu-nha-hang', 20) as $id => $post)
            <div class="item">
                <a href="{{ empty($post['duong-dan-thuong-hieu']) ? route('logo', ['languageCurrent' => $languageCurrent, 'markTrade' => $post->slug] ) : $post['duong-dan-thuong-hieu'] }}">
                    <img src="{{ asset($post->image) }}"/></a>
            </div>
            @endforeach
           
        </div>
        <script>
            $("#logoList").owlCarousel({

                autoPlay: 5000, //Set AutoPlay to 3 seconds

                items : 7,
                itemsDesktop : [1199,7],
                itemsDesktopSmall : [979,5],
                itemsTablet: [768,5],
                itemsMobile : [481,3]

            });
        </script> -->
    </div>
</section>
