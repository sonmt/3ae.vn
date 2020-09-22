@extends('site.layout.site')

@section('title','Thanh toán')
@section('meta_description', $information['meta_description'])
@section('keywords', $information['meta_keyword'])

@section('content')
    @include('site.partials.menu_main', ['classHome' => ''])
    <section class="order">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-md-3">
                    @include('site.partials.sidebar_order', ['active' => 'payment'])
                </div>

                <div class="col-xs-12 col-md-9">
                    <div class="breadrum">
                        <a href="/">Trang chủ</a> <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                        <a href="/dat-hang"> Giỏ hàng</a>
                    </div>

                    <form action="{{ route('information_receiver') }}" method="post">
                        {{ csrf_field() }}
                        <div class="InformationPerson informationOrder clearfix">
                            <h3><i class="fa fa-newspaper-o" aria-hidden="true"></i>Hình thức thanh toán</h3>
                            <div class="underline"></div>

                            <p class="titlePayment">Vui lòng lựa chọn hình thức thanh toán phù hợp</p>

                            <div class="form-group itemPayment">
                                <input type="radio" name="method_payment" value="Thanh toán khi nhận hàng"
                                       {{ !empty($methodPayment) ? ($methodPayment=='Thanh toán khi nhận hàng') ? 'checked' : '' : 'checked' }}/> Thanh toán khi nhận hàng
                            </div>
                            <div class="form-group itemPayment">
                                <input type="radio" name="method_payment" value="Thanh toán qua tài khoản ngân hàng"
                                        {{ !empty($methodPayment) ? ($methodPayment=='Thanh toán qua tài khoản ngân hàng') ? 'checked' : '' : 'checked' }} />
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

                            <div class="btnSubmit">
                                <a href="{{ route('order') }}" class="btn btn-default">Quay lại giỏ hàng</a>
                                <button type="submit" class="btn btn-danger">Hoàn thành</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
