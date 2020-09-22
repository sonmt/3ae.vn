@extends('admin.layout.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Thêm mới Trường dữ liệu thông tin
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cài đặt thông tin</a></li>
            <li class="active">Thêm mới</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('type-information.store') }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('POST') }}
                <div class="col-xs-12 col-md-6">
    
                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Nội dung</h3>
                        </div>
                        <!-- /.box-header -->

                            <div class="box-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">title</label>
                                    <input type="text" class="form-control" name="title" placeholder="Tiêu đề" required>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">slug</label>
                                    <input type="text" class="form-control" name="slug" placeholder="đường dẫn tĩnh" >
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Chú dẫn</label>
                                    <input type="text" class="form-control" name="placeholder" placeholder="Chú dẫn" >
                                </div>



                                <div class="form-group" style="color: red;">
                                    @if ($errors->has('title'))
                                        <label for="exampleInputEmail1">{{ $errors->first('title') }}</label>
                                    @endif
                                </div>
                            </div>
                            <!-- /.box-body -->

                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">Thêm mới</button>
                            </div>
                    </div>
                    <!-- /.box -->

                </div>

                <div class="col-xs-12 col-md-6">
                    <!-- Nội dung chọn trường dữ liệu -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Chọn hiển thị chỉnh sửa</h3>
                        </div>
                        <!-- /.box-header -->
                            <div class="box-body">
                                <!-- checkbox -->
                                <div class="form-group">
                                    <label>
                                        <input type="radio" name="type_input" value="one_line" class="flat-red" checked>
                                         Một dòng
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label>
                                        <input type="radio" name="type_input" value="multi_line" class="flat-red">
                                         Nhiều dòng
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label>
                                        <input type="radio" name="type_input" value="editor" class="flat-red">
                                        editor
                                    </label>
                                </div>

                                <div class="form-group">
                                    <label>
                                        <input type="radio" name="type_input" value="image" class="flat-red">
                                        Ảnh
                                    </label>
                                </div>
                            </div>
                            <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
            </form>
        </div>
    </section>
@endsection

