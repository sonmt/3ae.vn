@extends('admin.layout.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Cài thanh toán
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Cài đặt thanh toán</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <div class="col-xs-12 col-md-6">

                <!-- Nội dung thêm mới -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Quản lý phí ship</h3>
                    </div>
                    <!-- /.box-header -->

                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">STT</th>
                                <th>Hình thức ship</th>
                                <th>Chi phí</th>
                                <th>Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orderShips as $id => $orderShip )
                                <tr>
                                    <td>{{ ($id+1) }}</td>
                                    <td>{{ $orderShip->method_ship }}</td>
                                    <td>{{ $orderShip->cost }}</td>
                                    <td>
                                        <a  href="" class="btn btn-danger btnDelete" data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th width="5%">STT</th>
                                <th>Hình thức ship</th>
                                <th>Chi phí</th>
                                <th>Thao tác</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-body">
                        <h4 class="box-title">Thêm mới phí ship</h4>
                        <form action="{{ route('cost_ship') }}" method="post">
                            {!! csrf_field() !!}
                            <div class="form-group">
                                <label>Hình thức ship</label>
                                <input type="text" class="form-control" name="method_ship" required/>
                            </div>
                            <div class="form-group">
                                <label>Giá ship</label>
                                <input type="number" class="form-control" name="cost" required/>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Thêm mới</button>
                            </div>
                        </form>

                    </div>
                </div>
                <!-- /.box -->
            </div>

            <div class="col-xs-12 col-md-6">

                <!-- Nội dung thêm mới -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Quản lý ngân hàng</h3>
                    </div>
                    <!-- /.box-header -->

                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">STT</th>
                                <th>Tên tài khoản</th>
                                <th>Số tài khoản</th>
                                <th>Chủ tài khoản</th>
                                <th>Chi nhánh</th>
                                <th>Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orderBanks as $id => $orderBank )
                                <tr>
                                    <td>{{ ($id+1) }}</td>
                                    <td>{{ $orderBank->name_bank }}</td>
                                    <td>{{ $orderBank->number_bank }}</td>
                                    <td>{{ $orderBank->manager_account }}</td>
                                    <td>{{ $orderBank->branch }}</td>
                                    <td>
                                        <a  href="" class="btn btn-danger btnDelete" data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th width="5%">STT</th>
                                <th>Tên tài khoản</th>
                                <th>Số tài khoản</th>
                                <th>Chủ tài khoản</th>
                                <th>Chi nhánh</th>
                                <th>Thao tác</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="box-body">
                        <h4 class="box-title">Thêm mới ngân hàng</h4>
                        <form action="{{ route('bank') }}" method="post">
                            {!! csrf_field() !!}
                            <div class="form-group">
                                <label>Tên ngân hàng</label>
                                <input type="text" class="form-control" name="name_bank" required/>
                            </div>
                            <div class="form-group">
                                <label>Số tài khoản</label>
                                <input type="text" class="form-control" name="number_bank" required/>
                            </div>
                            <div class="form-group">
                                <label>Chủ tài khoản</label>
                                <input type="text" class="form-control" name="manager_account" required/>
                            </div>
                            <div class="form-group">
                                <label>Chi nhánh</label>
                                <input type="text" class="form-control" name="branch" required/>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Thêm mới</button>
                            </div>
                        </form>

                    </div>

                </div>
                <!-- /.box -->
            </div>

            <div class="col-xs-12 col-md-6">

                <!-- Nội dung thêm mới -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Quản lý điểm quy đổi</h3>
                    </div>
                    <!-- /.box-header -->

                    <div class="box-body">
                        <form action="{{ route('updateSetting') }}" method="post">
                            {!! csrf_field() !!}
                            <div class="form-group">
                                <label>Một điểm tương ứng bao nhiêu tiền</label>
                                <input type="number" class="form-control" name="point_to_currency"
                                       value="{{ (isset($settingOrder->point_to_currency)) ? $settingOrder->point_to_currency : '' }}" required/>
                            </div>
                            <div class="form-group">
                                <label>Số tiền mua hàng tương ứng 1 điểm</label>
                                <input type="number" class="form-control" name="currency_give_point" value="{{ (isset($settingOrder->currency_give_point)) ? $settingOrder->currency_give_point : '' }}" required/>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Thêm mới</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.box -->
            </div>

            <div class="col-xs-12 col-md-6">

                <!-- Nội dung thêm mới -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Quản lý mã giảm giá</h3>
                    </div>
                    <!-- /.box-header -->

                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">STT</th>
                                <th>Mã giảm giá</th>
                                <th>Phương thức sale</th>
                                <th>Mức sale</th>
                                <th>Số lần sale</th>
                                <th>Thời gian bắt đầu</th>
                                <th>Thời gian kết thúc</th>
                                <th>Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orderCodeSales as $id => $orderCodeSale )
                                <tr>
                                    <td>{{ ($id+1) }}</td>
                                    <td>{{ $orderCodeSale->code }}</td>
                                    <td>{{ ($orderCodeSale->method_sale == 0) ? 'tiền' : '%' }}</td>
                                    <td>{{ $orderCodeSale->sale }}</td>
                                    <td>{{ $orderCodeSale->many_use }}</td>
                                    <td>{{ $orderCodeSale->start }}</td>
                                    <td>{{ $orderCodeSale->end }}</td>
                                    <td>
                                        <a  href="" class="btn btn-danger btnDelete" data-toggle="modal" data-target="#myModalDelete"
                                            onclick="return submitDelete(this);">
                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th width="5%">STT</th>
                                <th>Mã giảm giá</th>
                                <th>Phương thức sale</th>
                                <th>Mức sale</th>
                                <th>Số lần sale</th>
                                <th>Thời gian bắt đầu</th>
                                <th>Thời gian kết thúc</th>
                                <th>Thao tác</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="box-body">
                        <h4 class="box-title">Thêm mới mã giảm giá</h4>
                        <form action="{{ route('code_sale') }}" method="post">
                            {!! csrf_field() !!}
                            <div class="form-group">
                                <label>Mã giảm giá</label>
                                <input type="text" class="form-control" name="code" required/>
                            </div>
                            <div class="form-group">
                                <label>Phương thức sale</label>
                                <input type="radio" name="method_sale" value="0" checked/> Theo tiền
                                <input type="radio" name="method_sale" value="1" /> Theo %
                            </div>
                            <div class="form-group">
                                <label>Mức sale</label>
                                <input type="number" class="form-control" name="sale" required/>
                            </div>
                            <div class="form-group">
                                <label>Số lần sử dụng</label>
                                <input type="number" class="form-control" name="many_use" required/>
                            </div>
                            <div class="form-group">
                                <label>Thời gian khuyến mãi:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-clock-o"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right" id="reservationtime" name="code_sale_start_end" />
                                </div>
                                <!-- /.input group -->
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Thêm mới</button>
                            </div>
                        </form>

                    </div>
                </div>

                <!-- /.box -->
            </div>
        </div>
    </section>
@endsection

