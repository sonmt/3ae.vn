@extends('site.layout.site')

@section('title','Gửi đơn hàng thành công')
@section('meta_description', $information['meta_description'])
@section('keywords', $information['meta_keyword'])

@section('content')
    @include('site.partials.menu_main', ['classHome' => ''])
    <section class="order">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-md-3">
                    @include('site.partials.sidebar_order', ['active' => 'send'])
                </div>

                <div class="col-xs-12 col-md-9">
                    <div class="breadrum">
                        <a href="/">Trang chủ</a> <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                        <a href="/dat-hang"> Giỏ hàng</a>
                    </div>


                    
                    <div class="InformationPerson informationOrder clearfix">
                        <h3><i class="fa fa-newspaper-o" aria-hidden="true"></i>Đặt hàng thành công</h3>
                        <div class="underline"></div>

                        <div class="panel panel-default">
                            <!-- Table -->
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>Giá</th>
                                    <th>Số lượng</th>
                                    <th>Tổng tiền</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $sumPrice = 0;?>
                                @foreach($orderItems as $id => $orderItem)
                                    <tr>
                                        <td>
                                            <img src="{{ !empty($orderItem->image) ?  asset($orderItem->image) : asset('/site/img/no_image.png') }}" alt="{{ $orderItem->title }}" width="100"/>
                                            <p>{{ $orderItem->title }}</p>
                                        </td>
                                        <td>
                                            <div class="price">
                                                Giá:
                                                @if (!empty($orderItem->discount))
                                                    <span class="priceOld">{{ number_format($orderItem->price, 0, ',', '.') }}</span>
                                                    <span class="priceDiscount">{{ number_format($orderItem->discount, 0, ',', '.') }} VND</span>
                                                    <input type="hidden" class="unitPrice" value="{{ $orderItem->discount }}">
                                                @else
                                                    <input type="hidden" class="unitPrice" value="{{ $orderItem->price }}">
                                                    <span class="priceDiscount">{{ number_format($orderItem->price, 0, ',', '.') }} VND</span>
                                                @endif
                                                Tiết kiệm: <span class="priceDiscount">{{ round(($orderItem->price - $orderItem->discount) / $orderItem->price * 100) }}%</span>
                                            </div>
                                        </td>
                                        <td> {{ $orderItem->quantity }}</td>
                                        <td class="totalPrice">
                                            <?php $sumPrice += !empty($orderItem->discount) ? ($orderItem->discount*$orderItem->quantity) : ($orderItem->price*$orderItem->quantity) ?>
                                            {{ !empty($orderItem->discount) ? number_format(($orderItem->discount*$orderItem->quantity) , 0, ',', '.') : number_format(($orderItem->price*$orderItem->quantity)  , 0, ',', '.')}}
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="3">Tổng tiền</td>
                                    <td class="sumPrice">{{ number_format($sumPrice, 0, ',', '.') }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="col-xs-12 col-md-6 col-md-offset-6">
                            <p>Mã giảm giá: <span class="red">-{{ number_format($codeSalePrice, 0, ',', '.') }} VNĐ</span></p>
                            @if(\Illuminate\Support\Facades\Auth::check())
                                <p>Điểm thưởng:  <span class="red">-{{ number_format($pointGive, 0, ',', '.') }} VNĐ</span></p>
                            @endif
                            <p>Phí vận chuyển:  <span class="red">+{{ number_format($costShip, 0, ',', '.') }} VNĐ</span></p>
                            <p>Số tiền thanh toán:  <span class="red">{{ number_format(($totalPrice + $costShip - $codeSalePrice - $pointGive), 0, ',', '.') }} VNĐ</span> </p>
                        </div>

                        <div class="col-xs-12 col-md-12">
                            <h4>Thông tin người nhận hàng</h4>
                            <p>{{ $customer['ship_name'] }}</p>
                            <p>Địa chỉ: {{ $customer['ship_address'] }}</p>
                            <p>Điện thoại: {{ $customer['ship_phone'] }}</p>
                            <p>Email: {{ $customer['ship_email'] }}</p>
                        </div>
                        
                        <p class="titlePayment clearfix">Cảm ơn bạn đã mua hàng của chúng tôi, Mã đơn hàng của bạn là #{{ $orderId }}</p>
                        <p class="">Cảm ơn bạn đã mua hàng của chúng tôi, chúng tôi sẽ xác nhận và gửi đơn hàng trong thời gian ngắn nhất.</p>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
