@extends('site.layout.site')

@section('title','Quên mật khẩu')
@section('meta_description', $information['meta_description'])
@section('keywords', $information['meta_keyword'])

@section('content')
@include('site.partials.menu_main', ['classHome' => ''])
<section class="user">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-3">
                @include('site.partials.side_bar_user', ['active' => 'inforUser'])
            </div>

            <div class="col-xs-12 col-md-9">
                <div class="breadrum mb20">
                    <a href="/">Trang chủ</a> <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                    <a href="/thong-tin-ca-nhan"> Trang cá nhân</a>
                </div>

                <div class="InformationPerson clearfix">
                    <div class="mainTitle lineblue">
                        <h3 class="titleV bgblue"><i class="fa fa-newspaper-o" aria-hidden="true"></i>Quên mật khẩu</h3>
                    </div>
                    <div class="underline"></div>
                    @if ($isSuccess == 1)
                        <p>
                            Chúng tôi đã gửi mail xác nhận lại mật khẩu, vui lòng truy cập mail để biết thông tin. Cảm ơn bạn.
                        </p>
                    @else
                        <p>
                            Email xác nhận không chính xác (hoặc không tồn tại).
                        </p>
                    @endif
                </div>
                <script>
                    //Đồng bộ chiều cao các div
                    $(function() {
                        $('.boxH5').matchHeight();
                    });
                </script>
            </div>
        </div>
    </div>
</section>
@endsection
