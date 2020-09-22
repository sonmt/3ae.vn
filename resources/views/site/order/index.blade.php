@extends('site.layout.site')

@section('title','Đặt hàng')
@section('meta_description', $information['meta_description'])
@section('keywords', $information['meta_keyword'])

@section('content')
    @include('site.partials.menu_main', ['classHome' => ''])
    <section class="order">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-md-3">
                    @include('site.partials.sidebar_order', ['active' => 'order'])
                </div>

                <div class="col-xs-12 col-md-9">
                    <div class="breadrum">
                        <a href="/">Trang chủ</a> <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                        <a href="/dat-hang"> Giỏ hàng</a>
                    </div>
                    <form action="{{ route('send') }}" method="post">
                        {{ csrf_field() }}
                        <div class="InformationPerson informationOrder clearfix">
                            <div class="mainTitle lineorange">
								<h3 class="titleV bgorange"><i class="fa fa-newspaper-o" aria-hidden="true"></i>Xác nhận đơn hàng</h3>
							</div>
							<div class="col-md-12">
                            @if(\Illuminate\Support\Facades\Auth::check())
                            <div class="point">
                                Số điểm tích lũy: <span class="red">{{ $point }} Điểm</span>
                            </div>
                             @endif
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
                                                            <span class="priceOld">{{ number_format($orderItem->price , 0)}}</span>
                                                            <span class="priceDiscount">{{ number_format($orderItem->discount , 0) }} VND</span>
                                                            <input type="hidden" class="unitPrice" value="{{ $orderItem->discount }}">
                                                        @else
                                                            <input type="hidden" class="unitPrice" value="{{ $orderItem->price }}">
                                                            <span class="priceDiscount">{{ number_format($orderItem->price , 0)}} VND</span>
                                                        @endif
                                                        Tiết kiệm: <span class="priceDiscount">{{ round(($orderItem->price - $orderItem->discount) / $orderItem->price * 100) }}%</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="hidden" name="product_id[]" value="{{ $orderItem->product_id }}"/>
                                                    <input type="number" name="quantity[]" style="width:60px;"
                                                           value="{{ $orderItem->quantity }}"
                                                           onchange="return changeQuantity(this);" />
                                                </td>
                                                <td class="totalPrice tr bold">
                                                    <font color="red"><?php $sumPrice += !empty($orderItem->discount) ? ($orderItem->discount*$orderItem->quantity) : ($orderItem->price*$orderItem->quantity) ?>
                                                    {{ !empty($orderItem->discount) ? number_format(($orderItem->discount*$orderItem->quantity) , 0) : number_format(($orderItem->price*$orderItem->quantity) , 0, ',', '.') }}</font>
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td class="bold tr">Tổng tiền:</td>
                                            <td colspan="3" class="sumPrice bold tr red">{{ number_format($sumPrice , 0) }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <script>
                                    function changeQuantity(e) {
                                        var unitPrice = $(e).parent().parent().find('.unitPrice').val();
                                        var quantity = $(e).val();
                                        var totalPrice = unitPrice*quantity;
                                        var sum = 0;
                                        $(e).parent().parent().find('.totalPrice').empty();
                                        $(e).parent().parent().find('.totalPrice').html(numeral(totalPrice).format('0,0'));

                                        $('.totalPrice').each(function () {
                                            var totalPrice = $(this).html();
                                            sum += parseInt(numeral(totalPrice).value());
                                        });
                                        $('.sumPrice').empty();
                                        $('.sumPrice').html(numeral(sum).format('0,0'));
                                    }
                                </script>
                                <div class="col-xs-8 col-xs-offset-0 col-md-6 col-md-offset-6">
                                    <div class="form-group">
                                        <label>Sử dụng mã giảm giá</label>
                                        <input type="text" class="form-control" name="code_sale" value="" placeholder="Mã giảm giá ..."/>
                                    </div>
                                    @if(\Illuminate\Support\Facades\Auth::check())
                                    <div class="form-group">
                                        <label>Sử dụng điểm tích lũy để mua hàng</label>
                                        <input type="checkbox" name="is_use_point" value="1" />
                                    </div>
                                    @endif
                                </div>
                                <div class="col-xs-12 col-md-6 ">
                                    <p>Lựa chọn phương pháp vận chuyển</p>
                                </div>
                                <div class="col-xs-12 col-md-6 ">
                                    @foreach($orderShips as $id => $orderShip)
                                        <div class="form-group">
                                            <label>{{ $orderShip->method_ship }}</label>
                                            <input type="radio" name="method_ship" value="{{ $orderShip->order_ship_id }}" {{ ($id ==0) ? 'checked' : '' }}/> {{ number_format($orderShip->cost , 0) }} VND
                                        </div>
                                    @endforeach
                                </div>
							</div>
                        </div>

                        <div class="InformationPerson informationOrder clearfix">
                            <div class="mainTitle lineorange"><h3 class="titleV bgorange"><i class="fa fa-newspaper-o" aria-hidden="true"></i>Hình thức thanh toán</h3></div>
							<div class="col-md-12">
                            <p class="titlePayment">Vui lòng lựa chọn hình thức thanh toán phù hợp</p>

                            <div class="form-group itemPayment">
                                <input type="radio" name="method_payment" value="Thanh toán khi nhận hàng" checked /> Thanh toán khi nhận hàng
                            </div>
                            <div class="form-group itemPayment">
                                <input type="radio" name="method_payment" value="Thanh toán qua tài khoản ngân hàng" />
                                Thanh toán qua tài khoản ngân hàng
                            </div>
                            <div class="panel panel-default">
                                <!-- Table -->
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Ngân hàng</th>
                                        <th>Chủ tài khoản</th>
                                        <th>Số tài khoản</th>
                                        <th>Chi nhánh</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($orderBanks as $id => $orderBank)
                                        <tr>
                                            <td>
                                                {{ $orderBank->name_bank }}
                                            </td>
                                            <td>
                                                {{ $orderBank->manager_account }}
                                            </td>
                                            <td>
                                                {{ $orderBank->number_bank }}
                                            </td>
                                            <td class="totalPrice">
                                                {{ $orderBank->branch }}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <p>Quý khách vui lòng điền mã đơn hàng <span class="red">(Ví dụ: #123414)</span> trong phần nội dung chuyển khoản để chúng tôi xác nhận đơn hàng.</p>
							</div>
                        </div>

                        <div class="InformationPerson informationOrder clearfix">
							<div class="mainTitle lineorange"><h3 class="titleV bgorange"><i class="fa fa-newspaper-o" aria-hidden="true"></i>Thông tin thanh toán</h3></div>
                                <div class="col-xs-12 col-xs-offset-0 col-md-9 col-md-offset-3 pb20">
                                    <p class="titlePayment">Vui lòng điền đầy đủ thông tin nhận hàng bên dưới, các mục có dấu <font color="red">(*)</font> là bắt buộc </p>
                                    <div class="form-group">
                                        <label>Họ và tên<span><font color="red">*</font></span>: </label>
                                        <input type="text" class="form-control" name="ship_name" placeholder=""
                                               value="{{ !empty(old('ship_name')) ? old('ship_name') : '' }}"  required/>
                                        @if ($errors->has('ship_name'))
                                            <span class="red">
                                        <strong>{{ $errors->first('ship_name') }}</strong>
                                </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label>Điện thoại<span><font color="red">*</font></span>: </label>
                                        <input type="text" class="form-control" name="ship_phone" placeholder=""
                                               value="{{ !empty(old('ship_phone')) ? old('ship_phone') : '' }}"  required/>
                                        @if ($errors->has('ship_phone'))
                                            <span class="red">
                                        <strong>{{ $errors->first('ship_phone') }}</strong>
                                </span>
                                        @endif
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Email<span></span>: </label>
                                        <input type="email" class="form-control" name="ship_email" placeholder=""
                                               value="{{ !empty(old('ship_email')) ? old('ship_email') : '' }}" required/>
                                        @if ($errors->has('ship_email'))
                                            <span class="red">
                                        <strong>{{ $errors->first('ship_email') }}</strong>
                                </span>
                                        @endif
                                    </div>
									<div class="form-group">
                                        <label>Địa chỉ nhận hàng<span><font color="red">*</font></span>: </label>
                                        <input type="text" class="form-control" name="ship_address" placeholder=""
                                               value="{{ !empty(old('ship_address')) ? old('ship_address') : '' }}" required/>
                                        @if ($errors->has('ship_address'))
                                            <span class="red">
                                        <strong>{{ $errors->first('ship_address') }}</strong>
                                </span>
                                        @endif
                                    </div>
                                    <div class="btnSubmit">
                                        <a href="{{ route('order') }}" class="btn btn-default">Quay lại giỏ hàng</a>
                                        <button type="submit" class="btn btn-danger">Thanh toán</button>
                                    </div>
                                </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
