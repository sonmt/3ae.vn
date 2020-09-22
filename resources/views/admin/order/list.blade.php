@extends('admin.layout.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
           Danh sách đơn hàng
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Cài đặt thanh toán</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">

                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Tìm kiếm</h3>
                    </div>
                    <!-- /.box-header -->

                    <div class="box-body">
                        <form method="get">
                        <div class="form-group col-xs-12 col-md-6">
                            <input class="form-control" value="{{ !empty($_GET['order_id']) ? $_GET['order_id'] : '' }}" name="order_id" placeholder="id đơn hàng"/>
                        </div>
                        <div class="form-group col-xs-12 col-md-6">
                            <input class="form-control" value="{{ !empty($_GET['phone']) ? $_GET['phone'] : '' }}" name="phone" placeholder="Số điện thoại khách hàng"/>
                        </div>
                        <div class="form-group col-xs-12 col-md-6">
                            <input class="form-control" value="{{ !empty($_GET['email']) ? $_GET['email'] : '' }}" name="email" placeholder="Mail khách hàng" />
                        </div>
                        <div class="form-group col-xs-12 col-md-6">
                            <input class="form-control" value="{{ !empty($_GET['name']) ? $_GET['name'] : '' }}" name="name" placeholder="Tên khách hàng" />
                        </div>
                        <div class="form-group col-xs-12 col-md-6">
                            <label class="control-label">Ngày giờ</label>
                            <input type="checkbox" name="is_search_time" value="1" class="flat-red" {{ (!empty($_GET['is_search_time']) && $_GET['is_search_time'] == 1) ? 'checked' : '' }}/> Tích chọn để search theo thời gian
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-clock-o"></i>
                                </div>
                                <input type="text" class="form-control pull-right" id="reservationtime" name="search_start_end" />
                            </div>
                        </div>
                            <input type="hidden" value="{{ !empty($_GET['user_id']) ? $_GET['user_id'] : '' }}" name="user_id" />
                        <div class="form-group col-xs-12 col-md-12">
                            <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>

            @foreach($orders as $id => $order)
            <!-- form start -->
            <div class="col-xs-12">
                
                <div class="box">
                    <div class="box-header">
                        <div class="box-title">
                            <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#order{{$id}}" aria-expanded="false" aria-controls="collapseExample">
                                Mã đơn hàng: #{{ $order->order_id }}
                            </button> (click vào đơn hàng để xem chi tiết đơn hàng)
                            <p>Ngày đặt hàng: <?php $dateOrder = new \DateTime($order->updated_at); echo $dateOrder->format('d/m/Y H:i'); ?></p>
                            <p>IP khách hàng: {{ $order->ip_customer }}</p>
                            <a  href="{{ route('orderAdmin.destroy', ['order_id' => $order->order_id]) }}" class="btn btn-danger btnDelete" data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                                <i class="fa fa-trash-o" aria-hidden="true"></i> Xóa đơn hàng
                            </a>
                        </div>
                        <div class="box-tools">
                            <form action="{{ route('orderUpdateStatus') }}" method="post">
                                {!! csrf_field() !!}
                                <select name="status" class="
                                <?php switch ($order->status) {
                                    case 1: echo 'btn-info';break;
                                    case 2: echo 'btn-warning';break;
                                    case 3: echo 'btn-danger';break;
                                    case 4: echo 'btn-success';break;
                                }?>"

                                >
                                    <option value="1" class="btn-info clearfix" {{ ($order->status==1) ? 'selected' : ''}}>
                                        Đã đặt đơn hàng
                                    </option>
                                    <option value="2" class="btn-warning clearfix" {{ ($order->status==2) ? 'selected' : ''}}>Đã nhận đơn hàng</option>
                                    <option value="3" class="btn-danger clearfix" {{ ($order->status==3) ? 'selected' : ''}}>Đang vận chuyển</option>
                                    <option value="4" class="btn-success clearfix" {{ ($order->status==4) ? 'selected' : ''}}>Đã giao hàng</option>
                                </select>
                                <input type="hidden" value="{{ $order->order_id }}" name="order_id" />
                                <button type="submit" class="btn btn-primary">Xác nhận</button>
                            </form>
                        </div>
                    </div>


                    <div class="collapse" id="order{{$id}}">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="5%">STT</th>
                                    <th>Sản phẩm</th>
                                    <th>Giá</th>
                                    <th>Số lượng</th>
                                    <th>Thành tiền</th>
                                </tr>
                            </thead>

                            <tbody>
                            <?php $sumPrice = 0;?>
                                @foreach($order->orderItems as $id => $orderItem)
                                <tr>
                                    <td>{{ ($id+1) }}</td>
                                    <td>
                                        <img src="{{ $orderItem->image }}" alt="{{ $orderItem->title }}"/>
                                        <p>{{ $orderItem->title }} (MSP: {{ $orderItem->code }})</p>
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
                                        </div>
                                    </td>
                                    <td>
                                        {{ $orderItem->quantity }}
                                    </td>
                                    <td>
                                        <?php $sumPrice += !empty($orderItem->discount) ? ($orderItem->discount*$orderItem->quantity) : ($orderItem->price*$orderItem->quantity) ?>
                                        {{ !empty($orderItem->discount) ? number_format(($orderItem->discount*$orderItem->quantity), 0, ',', '.') : number_format(($orderItem->price*$orderItem->quantity), 0, ',', '.') }} VND
                                    </td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td colspan="4">Tổng tiền</td>
                                    <td>{{ number_format($sumPrice, 0, ',', '.') }} VNĐ</td>
                                </tr>
                            </tbody>
                            
                            <tr>
                                <td colspan="2">
                                    <h4>Thông tin người nhận hàng</h4>
                                    <p>{{ $order->shipping_name }}</p>
                                    <p>Địa chỉ: {{ $order->shipping_address }}</p>
                                    <p>Số điện thoại: {{ $order->shipping_phone }}</p>
                                    <p>Email: {{ $order->shipping_email }}</p>
                                </td>
                                <td colspan="2">
                                    <p>Mã giảm giá: </p>
                                    <p>Điểm thưởng: </p>
                                    <p>Phí vận chuyển: </p>
                                    <p>Số tiền thanh toán: </p>
                                </td>
                                <td>
                                    <p>-{{ number_format($order->cost_sale, 0, ',', '.') }} VNĐ</p>
                                    <p>-{{ number_format($order->cost_point, 0, ',', '.') }} VNĐ</p>
                                    <p>+{{ number_format($order->cost_ship, 0, ',', '.') }} VNĐ</p>
                                    <p>{{ number_format($order->total_price, 0, ',', '.') }} VNĐ</p>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            @endforeach
                {{ $orders->links() }}
        </div>
    </section>
    @include('admin.partials.popup_delete')
@endsection

