@extends('site.layout.site')

@section('title','Đăng ký')
@section('meta_description', $information['meta_description'])
@section('keywords', $information['meta_keyword'])

@section('content')
    @include('site.partials.menu_main', ['classHome' => ''])
    <section class="contentCategoryProduct">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-xs-12 hidePhone">
                    <div class="sideBarContent menuProduct mb20">
						<?php echo \App\Entity\MenuElement::showMenuElementPage('menu-trong-trang-san-pham', 'sideMenu', true) ?>
					</div>
					<div class="sideBarContent fanpageFacebook mb20">
						<h2 class="titleV bggreen"><i class="fa fa-facebook-official" aria-hidden="true"></i>FANPAGE FACEBOOK</h2>
						<?= $information['fanpage-facebook'] ?>
					</div>
                </div>

                <div class="col-md-9 col-xs-12">
                    <div class="breadrum">
                        <a href="/">Trang chủ</a> <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                        <a href="/dang-ky" class="active">Đăng ký</a>
                    </div>

                    <div class="register hotDeal clearfix">
                        <div class="mainTitle lineblue">
                            <h1 class="titleV bgblue"><i class="fa fa-key" aria-hidden="true"></i> Đăng ký</h1>
                        </div>
                        <div class="underline"></div>
                            <div class="col-md-8 col-xs-12">
                                <p>Vui lòng điền đầy đủ thông tin bên dưới, các mục có dấu <span class="red">(*)</span> là bắt buộc</p>
                                <form action="/dang-ky" method="post">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label>Họ và tên <span class="red">(*)</span></label>
                                        <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Họ và tên" />
                                    </div>
                                    <div class="form-group">
                                        <label>Email <span class="red">(*)</span></label>
                                        <input type="text" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email" required/>
                                    </div>
                                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                        <label for="password" class="control-label">Mật khẩu <span class="red">(*)</span></label>

                                        <input id="password" type="password" class="form-control" name="password" required>

                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="password-confirm" class="control-label">Nhập lại mật khẩu <span class="red">(*)</span></label>
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Mã xác nhận <span class="red">(*)</span></label>
                                        <input type="text" class="form-control"  placeholder="Mã xác nhận" />
                                    </div>
                                    <div class="form-group">
                                        <label> <input type="checkbox" name="is_register" value="1" required/> Tôi xác nhận đồng ý với các
                                           <a href="">điều khoản</a> của website</label>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-danger">Đăng ký</button>
                                    </div>
                                </form>
                            </div>

                            <div class="col-md-4 col-xs-12 mb20">
                                Đăng nhập bằng tài khoản<br>
                                <a href="{{ $urlLoginFace }}" class="btn btn-primary"><i class="fa fa-facebook-square" aria-hidden="true"></i> Facebook</a>
                                <a href="#" class="btn btn-danger"><i class="fa fa-google-plus-square" aria-hidden="true"></i> google</a>
                            </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="menuPicture">
                    @foreach(\App\Entity\MenuElement::showMenuElementInfor('anh-menu') as $menu)
                        <div class="col-xs-3">
                            <a href="{{ $menu->url }}"><img src="{{ !empty($menu->menu_image) ?  asset($menu->menu_image) : asset('/site/img/no_image.png') }}" alt="{{ $menu->title_show }}"/></a>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <div class="ProductReaded">
                        <div class="hotDeal clearfix">
                            <div class="mainTitle linegreen">
                                <h2 class="titleV bggreen"><i class="fa fa-cubes" aria-hidden="true"></i>Sản phẩm đã xem</h2>
                            </div>
                            <!-- list item hot deal-->
                            @foreach (\App\Entity\Product::showProduct('hot-deal', 4)  as $id => $product)
                                <div class="col-md-3 col-xs-6">
                                    <div class="item">
										<div class="CropImg CropImgP">
											<a href="{{ route('product', [ 'post_slug' => $product->slug]) }}" class="image thumbs">
												<img src="{{ !empty($product->image) ?  asset($product->image) : asset('/site/img/no_image.png') }}" />
												@if (!empty($product->discount))
													<span class="discountPersent">-{{ round(($product->price - $product->discount) / $product->price * 100) }}%</span>
												@endif
											</a>
										</div>
                                        <a href="{{ route('product', [ 'post_slug' => $product->slug]) }}">
                                            <h3>{{ $product->title }}</h3>
                                        </a>
                                        <div class="tiemDiscount"></div>
                                        <div class="price">
                                            @if (!empty($product->discount))
                                                <span class="priceOld">{{ number_format($product->price, 0, ',', '.') }}</span>
                                                <span class="priceDiscount">{{ number_format($product->discount, 0, ',', '.') }}</span> VND
                                            @else
                                                <span class="priceDiscount">{{ number_format($product->price, 0, ',', '.') }}</span> VND
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
