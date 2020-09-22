@extends('site.layout.site')

@section('title',$languageSetup['lien-he'])
@section('meta_description', $information['meta_description'])
@section('keywords', $information['meta_keyword'])

@section('content')
	<section class="contacForm bgPageFull">
		<img src="img/bgPage.png" class="bgPage">
		<div class="mask"></div>
		<div class="container">
			<div class="contactContent">
				<h1 class="titleLine"><span class="line"></span><span class="title orange">{{ $languageSetup['lien-he'] }}</span><span class="line"></span></h1>
				<p style="color: red; font-size: 18px; padding: 25px 0 40px 0;">
					<i> {{ (isset($isBookSuccess)) ? $languageSetup['cam-on-khi-dat-ban'] : '' }} </i>
				</p>
				<div class="row mb20">
					<div class="col-md-12">
						<ul class="listRestaurant" id="tabBar" role="tablist">
							@foreach(\App\Entity\SubPost::showSubPost('quan-li-dia-diem', 20) as $id => $post)
							<div>
								<li role="presentation" class="{{ ($id == 0) ? 'active': '' }} col-md-4"><a href="#tab{{$id}}" aria-controls="home" role="tab" data-toggle="modal" data-target="#map{{ $id }}">
										<h3>{{ $post->title }}</h3>
										<p><i class="fa fa-map-marker" aria-hidden="true"></i>{{ $post['dia-chi-nha-hang'] }}<br>
											<i class="fa fa-phone" aria-hidden="true"></i>{{ $post['so-dien-thoai'] }}</p>
									</a>
								</li>
							</div>
							@foreach(\App\Entity\SubPost::showSubPost('quan-li-dia-diem', 30) as $id => $post)
							<div id="map{{ $id }}"  class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
								<div class="modal-dialog modal-lg" role="document">
									<div class="modal-content">
										<div class="tab-content">
											<?= $post['ban-do-nha-hang'] ?>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-default" data-dismiss="modal">{{ $languageSetup['dong-ban-do'] }}</button>
										</div>
									</div><!-- /.modal-content -->
								</div><!-- /.modal-dialog -->
							</div><!-- /.modal -->
							@endforeach
							@endforeach

						</ul>
					</div>
				</div>

				<form action="{{ route('sub_contact', [ 'languageCurrent' => $languageCurrent]) }}" method="post">
					{!! csrf_field() !!}
				<div class="row">
					<div class="col-md-12">

						<div class="row">
							<div class="col-md-6">
								<h2 class="titleLote titleBlack mb50"><span class="line bgred"></span>{{ $languageSetup['thong-tin'] }}
									<span class="red">{{ $languageSetup['nha-hang'] }}</span></h2>
								<div class="infoContact boxH">
									<h3>{{ $information['ten-cong-ty'] }}</h3>
									<p>Địa chỉ: {{ $information['dia-chi-cong-ty'] }}
										<br>Điện thoại: <a href="tel:0934553435"> {{ $information['so-dien-thoai-cong-ty'] }}</a>
										<br>Email: <a href="mail:info@3ae.vn">{{ $information['email-cong-ty'] }}</a>
									</p>
								</div>
							</div>
							<div class="col-md-6 boxForm">
								<div class="form boxH">
									<h2 class="titleLote titleBlack mb50"><span class="line bgred"></span>{{ $languageSetup['lien-he'] }}
										<span class="red">{{ $languageSetup['voi-chung-toi'] }}</span></h2>
									<p>{{ isset($success) ? $languageSetup['cam-on-khi-gui-thanh-cong-lien-he'] : '' }}</p>
									<p><i>Lưu ý: Các trường đánh dấu (*) là bắt buộc.</i></p>
									<div class="form-group">
										<input type="text" class="form-control" name="name" id="name" placeholder="Full name *" required/>
									</div>
									<div class="form-group">
										<input type="number" class="form-control" name="phone" placeholder="Phone *" required/>
									</div>
									<div class="form-group">
										<input type="email" class="form-control" name="email" placeholder="Email *" required/>
									</div>
									<div class="form-group">
										<input type="text" class="form-control" name="address" placeholder="Address *" created_at/>
									</div>
									<div class="form-group">
										<textarea style="height: 134px;" class="form-control" name="message" placeholder="Message"></textarea>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="tr col-md-12">
								<button type="submit" class="btnContact">{{ $languageSetup['gui-thu'] }}</button>
							</div>
						</div>
					<script>
                        //Đồng bộ chiều cao các div
                        $(function() {
                            $('.boxH').matchHeight();
							$('.boxContact').matchHeight();
                        });
					</script>
				</div>
			</div>
			</form>
		</div>
		</div>
		</div>
	</section>
@endsection
