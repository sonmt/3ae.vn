@extends('site.layout.site')

@section('title','Đơn hàng trang cá nhân')
@section('meta_description', $information['meta_description'])
@section('keywords', $information['meta_keyword'])

@section('content')
    @include('site.partials.menu_main', ['classHome' => ''])
    <section class="user">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-md-3">
                    @include('site.partials.side_bar_user', ['active' => 'orderPerson'])
                </div>

                <div class="col-xs-12 col-md-9">
                    <div class="breadrum">
                        <a href="/">Trang chủ</a> <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                        <a href="/don-hang-ca-nhan"> Thông tin đơn hàng </a>
                    </div>

                    <div class="InformationPerson orderPerson clearfix">
                        <div class="mainTitle lineorange"><h3 class="titleV bgorange"><i class="fa fa-newspaper-o" aria-hidden="true"></i>Thông tin đơn hàng</h3></div>
                        @foreach($orders as $id => $order)
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="orderItem clearfix">
                                    @foreach($order->orderItems as $id => $orderItem)
                                        <div class="col-xs-6">
                                            <div class="item">
                                                <div class="row">
                                                    <div class="col-xs-3">
                                                        <img src="{{ !empty($orderItem->image) ?  asset($orderItem->image) : asset('/site/img/no_image.png') }}" alt="{{ $orderItem->title }}"/>
                                                    </div>
                                                    <div class="col-xs-9">
                                                        <h2>{{ $orderItem->title }}</h2>
                                                        <div class="price">
                                                            Giá:
                                                            @if (!empty($orderItem->discount))
                                                                <span class="priceOld">{{ number_format($orderItem->price, 0, ',', '.') }}</span>
                                                                <span class="priceDiscount">{{ number_format($orderItem->discount, 0, ',', '.') }} VND</span>
                                                                <input type="hidden" class="unitPrice" value="{{  $orderItem->discount }}">
                                                            @else
                                                                <input type="hidden" class="unitPrice" value="{{ $orderItem->price }}">
                                                                <span class="priceDiscount">{{ number_format($orderItem->price, 0, ',', '.') }} VND</span>
                                                            @endif
                                                        </div>
                                                        <p>Số lượng: {{ $orderItem->quantity }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="orderItemFooter clearfix col-xs-12">
                                        Tổng: <span class="priceDiscount">{{ number_format($order->total_price, 0, ',', '.') }} VND</span>
                                        <?php switch ($order->status) {
                                            case 1: echo '<button class="btn btn-info">Đã đặt đơn hàng</button>';break;
                                            case 2: echo '<button class="btn btn-warning">Đã nhận đơn hàng</button>';break;
                                            case 3: echo '<button class="btn btn-danger">Đang vận chuyển</button>';break;
                                            case 4: echo '<button class="btn btn-success">Đã giao hàng</button>';break;
                                        }?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        {{ $orders->links() }}
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
