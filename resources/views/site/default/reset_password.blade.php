@extends('site.layout.site')

@section('title','Thay đổi mật khẩu')
@section('meta_description', $information['meta_description'])
@section('keywords', $information['meta_keyword'])

@section('content')
    @include('site.partials.menu_main', ['classHome' => ''])
    <section class="user">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-md-3">
                    @include('site.partials.side_bar_user', ['active' => 'resetPassword'])
                </div>

                <div class="col-xs-12 col-md-9">
                    <div class="breadrum mb20">
                        <a href="/">Trang chủ</a> <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                        <a href="/doi-mat-khau">Đổi mật khẩu</a>
                    </div>

                    <div class="InformationPerson clearfix">
						<div class="mainTitle lineblue">
							<h1 class="titleV bgblue"><i class="fa fa-newspaper-o" aria-hidden="true"></i>Thông tin cá nhân</h1>
						</div>
                        @if (session('success'))
                            <span class="help-block">
                                <strong> {{ session('success') }}</strong>
                            </span>
                        @endif
                        <form action="/doi-mat-khau" method="post" enctype="multipart/form-data">
                            {!! csrf_field() !!}
                            <div class="col-xs-12 col-md-12">
                                <div class="resetPassword">
                                    <div class="form-group">
                                        <label for="password">Mật khẩu cũ</label>
                                        <input id="password_old" type="password" class="form-control" name="password_old" required>

                                        @if (session('faidOldPassword'))
                                            <span class="help-block">
                                                <strong> {{ session('faidOldPassword') }}</strong>
                                            </span>
                                        @endif
                                    </div>


                                    <div class="form-group">
                                        <label for="password">Mật khẩu mới</label>
                                        <input id="password" type="password" class="form-control" name="password" required>

                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="password">Nhập lại mật khẩu mới</label>
                                        <input id="password-confirm"  type="password" class="form-control" name="password_confirmation" required>

                                        @if ($errors->has('password_confirmation'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-danger">ĐỔI THÔNG TIN</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
