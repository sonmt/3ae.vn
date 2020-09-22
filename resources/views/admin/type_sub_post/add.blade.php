@extends('admin.layout.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Thêm mới Dạng bài viết
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Dạng bài viết</a></li>
            <li class="active">Thêm mới</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('type-sub-post.store') }}" method="POST">
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
                                    <label for="exampleInputEmail1">Số thứ tự hiển thị</label>
                                    <input type="number" class="form-control" name="location" placeholder="Số thứ tự hiển thị" >
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Hiển thị trong lựa chọn menu</label>
                                    <input type="checkbox" class="flat-red" value="1" name="show_menu" placeholder="Hiển thị trong lựa chọn menu" >
                                </div>

                                <div class="form-group">
                                    <label>
                                        <input type="checkbox" name="have_sort" value="1" class="flat-red">
                                        Có lựa chọn số thứ tự sắp xếp
                                    </label>
                                </div>

                                <div class="form-group">
                                    <label>
                                        <input type="checkbox" name="is_index_hot" value="1" class="flat-red">
                                        Có lưa chọn nổi bật
                                    </label>
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

                    <div class="box box-primary">
                        <div class="box-body">
                            <div class="form-group">
                                <label>Chọn template</label>
                                <select class="form-control" name="template">
                                    <option value="default">Mặc định</option>
                                    @foreach($templates as $template)
                                        <option value="{{ $template->slug }}">{{ $template->title }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                    </div>
                    
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
                                        <input type="checkbox" name="input_default_used[]" value="content" class="flat-red">
                                         Trình soạn thảo
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label>
                                        <input type="checkbox" name="input_default_used[]" value="tags" class="flat-red">
                                        Tags
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label>
                                        <input type="checkbox" name="input_default_used[]" value="image" class="flat-red">
                                         Ảnh nổi bật
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label>
                                        <input type="checkbox" name="input_default_used[]" value="description" class="flat-red">
                                         Tóm tắt
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

