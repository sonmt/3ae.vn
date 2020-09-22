<header>
	<div class="topnav">
		<div class="container position">
			<div class="pull-right tr col-md-8">
				<span><i class="fa fa-map-marker" aria-hidden="true"></i>{{ $information['dia-chi-tren-dau-trang'] }}</span>
				<ul class="social">
					<li><a href="{{ $information['link-facebook'] }}"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
					<li><a href="{{ $information['link-twitter'] }}"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
					<li><a href="{{ $information['link-instagram'] }}"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
					<li><a href="{{ $information['link-google+'] }}"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
				</ul>
				<script>
                    $('.search i').click(function(){
                        if($(this).parent().find('.searchContent').is(":hidden")){
                            $(this).parent().find('.searchContent').show();
                        } else {
                            $(this).parent().find('.searchContent').hide();
                        }
                    });
				</script>
				
					<form action="{{ route('change_language') }}" method="post" id="changeLanguage">
						{!! csrf_field() !!}
							
						<div class="seectLang"> 
							<ul>
								<li onClick="return showLanguage(this);">
										<img src="{{ $languageCurrent == 'vn' ? asset('site/img/vietnam.png') :  asset('site/img/english.jpg') }}" style="width: 30px;"> 
									<i class="fa fa-sort-desc" aria-hidden="true"></i>
									<ul>
										@foreach ($languages as $language)
										<li onClick='return changeLanguage(this);' acronym='{{ $language->acronym }}'><a >	<img src="{{  ($language->acronym == 'vn') ? asset('site/img/vietnam.png') : asset('site/img/english.jpg') }}" style="width: 30px;"></a></li>
										@endforeach
									</ul>
								</li>
							</ul>	
						</div>
						<input type="hidden" name="language" id="language" value=""/>
						<input type="hidden" value="{{ $nameRoute }}" name="name_route" />
						<input type="hidden" value="{{ $mainId }}" name="main_id" />
						<input type="hidden" value="{{ $arrayRoute }}" name="array_route" />
					</form>
					
					<script>
						function showLanguage(e) {
							$(e).find('ul').show();
						}
						function changeLanguage(e) {
							var valLanguage = $(e).attr('acronym');
							$('#language').val(valLanguage);
							
							$('#changeLanguage').submit();
						}
					</script>
			</div>
		</div>
	</div>
	<nav class="Navigation navbar navbar-default">
		<div class="container">
			<div class="logo">
				<a href="/"><img src="{{ $logoSite }}"/></a>
			</div>
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="Navbutton navbar-toggle collapsed" data-toggle="collapse" data-target="#navMobile" aria-expanded="false">
					<span class="sr-only">Menu</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<div class="logoMobile hiddenPC">
					<a href="/"><img src="{{ $logoSite }}"/></a>
				</div>
				<form action="{{ route('change_language') }}" method="post" id="changeLanguage" class="changeLanguageMB mdds-none ds-block98" >
						{!! csrf_field() !!}
							
						<div class="seectLang"> 
							<ul>
								<li onClick="return showLanguage(this);">
										<img src="{{ $languageCurrent == 'vn' ? asset('site/img/vietnam.png') :  asset('site/img/english.jpg') }}" style="width: 30px;"> 
									<i class="fa fa-sort-desc" aria-hidden="true"></i>
									<ul>
										@foreach ($languages as $language)
										<li onClick='return changeLanguage(this);' acronym='{{ $language->acronym }}'><a >	<img src="{{  ($language->acronym == 'vn') ? asset('site/img/vietnam.png') : asset('site/img/english.jpg') }}" style="width: 30px;"></a></li>
										@endforeach
									</ul>
								</li>
							</ul>	
						</div>
						<input type="hidden" name="language" id="language" value=""/>
						<input type="hidden" value="{{ $nameRoute }}" name="name_route" />
						<input type="hidden" value="{{ $mainId }}" name="main_id" />
						<input type="hidden" value="{{ $arrayRoute }}" name="array_route" />
					</form>
					
					<script>
						function showLanguage(e) {
							$(e).find('ul').show();
						}
						function changeLanguage(e) {
							var valLanguage = $(e).attr('acronym');
							$('#language').val(valLanguage);
							
							$('#changeLanguage').submit();
						}
					</script>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="navMobile">
				<div class="hiddenPC navMenu" id="navClose">
					<span id="hiddenNav" class="pull-left">x</span>
					<a href="/"><img src="{{ !empty($information['logo']) ?  asset($information['logo']) : asset('/site/img/no_image.png') }}"/></a>
					<a class="pull-right searchMain">
						<i class="fa fa-search" aria-hidden="true"></i>
					</a>
				</div>
				<script>
					$('#hiddenNav').click(function(){
						$('.navbar-collapse').removeClass('in');
					});
				</script>
				<div class="hiddenPC">
					<div class="searchMenu">
						<form>
							<input type="text" placeholder="Tìm kiếm"/>
						</form>
					</div>
				</div>
				<ul class="nav navbar-nav">
					@foreach (\App\Entity\Menu::showWithLocation('menu-top') as $menu)
						@foreach (\App\Entity\MenuElement::showMenuElement($menu->slug) as $id => $menuElement)
							<li class="{{ ($activeMenu == $menuElement->url) ? 'active' : '' }}">
								<a class="hvr-underline-from-center" href="{{ $menuElement->url }}">
									{{ $menuElement->title_show }}
								</a>
							</li>
						@endforeach
					@endforeach
				</ul>
				<div class="hiddenPC socialNav">
					<ul class="social">
						<li><a href="{{ $information['link-facebook'] }}"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
						<li><a href="{{ $information['link-twitter'] }}"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
						<li><a href="{{ $information['link-instagram'] }}"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
						<li><a href="{{ $information['link-google+'] }}"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
						@foreach ($languages as $language)
						<li class="pull-right" onClick='return changeLanguage(this);' acronym='{{ $language->acronym }}'><a >	<img src="{{  ($language->acronym == 'vn') ? asset('site/img/vietnam.png') : asset('site/img/english.jpg') }}" style="width: 30px;"></a></li>
						@endforeach
					</ul>
				</div>
			</div><!-- /.navbar-collapse -->
		</div><!-- /.container-fluid -->
	</nav>
</header>
