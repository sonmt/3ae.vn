@extends('site.layout.site')


@section('title', 'tim-kiem')
@section('meta_description', $information['meta_description'] )
@section('keywords', '')

@section('content')
    <section class="mainMenu">
        <div class="container">
            <div class="row">
                <div class="col-md-12 ">
                    <h2 class="titleLote titleBlack"><span class="line changeColor"></span>{{ $languageSetup['thuc-don'] }}
                        <span class="Color">{{ $languageSetup['nha-hang'] }} </span></h2>
                    <h2 class="titleLine"><span class="line"></span><span class="title Color">{{ $languageSetup['thuc-don'] }}</span><span class="line"></span></h2>
                    <div class="row listPro">
                        @foreach ($posts as $id => $menu)
                            <div class="col-md-4 item boxPro">
                                <div class="CropImg">
                                    <a href="{{ route('show-detail-food', ['languageCurrent' => $languageCurrent, 'markTrade' => $menu['chon-thuong-hieu-nha-hang'], 'food' => $menu->slug]) }}" class="thumbs">
                                        <img src="{{ !empty($menu->image) ?  asset($menu->image) : asset('/site/img/no_image.png') }}" alt="{{ $menu->title }}" title="{{ $menu->title }}" />
                                    </a>
                                </div>
                                <h3 class="tl"><a class="Color" href="{{ route('show-detail-food', ['languageCurrent' => $languageCurrent, 'markTrade' => $menu['chon-thuong-hieu-nha-hang'], 'menu' => $menu->slug]) }}">{{ $menu->title }}</a></h3>
                                <div class="except tl">
                                    {{ $menu->description }}
                                </div>
                                <div class="more tl">
                                    <a class="Btn hvr-radial-out changeColor" href="{{ route('show-detail-food', ['languageCurrent' => $languageCurrent, 'markTrade' => $menu['chon-thuong-hieu-nha-hang'], 'food' => $menu->slug]) }}">{{ !empty($menu['gia-thuc-don']) ? $menu['gia-thuc-don'] : 'Xem chi tiết' }}</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="pagging Black">
                        {{ $posts->links() }}
                    </div>
                    <script>
                        //Đồng bộ chiều cao các div
                        $(function() {
                            $('.boxPro').matchHeight();
                        });
                    </script>
                </div>
            </div>
        </div>
    </section>
@endsection
