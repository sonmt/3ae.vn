@extends('admin.layout.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Chỉnh sửa đăt bàn của khách hàng {{ $book->name }}
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Đặt bàn</a></li>
            <li class="active">Chỉnh sửa</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('book.update', ['contact_id' => $book->book_id]) }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('PUT') }}
                <div class="col-xs-12 col-md-6">

                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Nội dung</h3>
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Họ và tên</label>
                                <input type="text" class="form-control" name="name" placeholder="Họ và tên" value="{{ $book->name }}" required>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Điện thoại</label>
                                <input type="text" class="form-control" name="phone" placeholder="Điện thoại" value="{{ $book->phone }}" required>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Email</label>
                                <input type="email" class="form-control" name="email" placeholder="Email" value="{{ $book->email }}" required>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Địa chỉ</label>
                                <input type="text" class="form-control" name="address" placeholder="Địa chỉ"  value="{{ $book->address }}" required>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Thời gian tiệc</label>
                                <input type="text" class="form-control" name="time" placeholder="Thời gian tiệc" value="{{ $book->time }}" required>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Message</label>
                                <textarea rows="4" class="form-control" name="message"
                                          placeholder="">{{ $book->message }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Chọn nhà hàng</label>
                                <select class="form-control" name="restaurant">
                                    @foreach (\App\Entity\SubPost::showSubPost('quan-li-dia-diem', 30) as $markTrade)
                                        <option value="{{ $markTrade['dia-chi-nha-hang'] }}" {{ ($book->restaurant == $markTrade['dia-chi-nha-hang']) ? 'selected' :'' }}>
                                            {{ $markTrade->title }}: {{ $markTrade['dia-chi-nha-hang'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="form-group" style="color: red;">
                                @if ($errors->has('name'))
                                    <label for="exampleInputEmail1">{{ $errors->first('name') }}</label>
                                @endif
                            </div>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                        </div>
                    </div>
                    <!-- /.box -->

                </div>
                
            </form>
        </div>
    </section>
@endsection

