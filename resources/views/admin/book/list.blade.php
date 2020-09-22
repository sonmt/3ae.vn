@extends('admin.layout.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Đặt bàn
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Danh sách đặt bàn</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <a href="{{ route('book.create') }}"><button class="btn btn-primary">Thêm mới</button> </a>
                        <a href="{{ route('exportBooks') }}" class="btn btn-success">Xuất file Excel</a>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">STT</th>
                                <th>Họ và tên</th>
                                <th>Số điện thoai</th>
                                <th>Email</th>
                                <th>Message</th>
                                <th>Thời gian</th>
                                <th>Nhà hàng</th>
                                <th>Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($books as $id => $book )
                                <tr>
                                    <td>{{ ($id+1) }}</td>
                                    <td>{{ $book->name }}</td>
                                    <td>{{ $book->phone }}</td>
                                    <td>{{ $book->email }}</td>
                                    <td>{{ $book->message }}</td>
                                    <td>{{ $book->time }}</td>
                                    <td>{{ $book->restaurant }}</td>
                                    <td>
                                        <a href="{{ route('book.edit', ['book_id' => $book->book_id]) }}">
                                            <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                        </a>
                                        <a  href="{{ route('book.destroy', ['book_id' => $book->book_id]) }}" class="btn btn-danger btnDelete" data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th width="5%">STT</th>
                                <th>Họ và tên</th>
                                <th>Số điện thoai</th>
                                <th>Email</th>
                                <th>Message</th>
                                <th>Thời gian</th>
                                <th>Thao tác</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
    @include('admin.partials.popup_delete')
@endsection

