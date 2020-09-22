@extends('admin.layout.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Thêm mới Trường dữ liệu
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Trường dữ liệu</a></li>
            <li class="active">Thêm mới</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('type-input.store') }}" method="POST">
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
                                    <label for="exampleInputEmail1">placeholder</label>
                                    <input type="text" class="form-control" name="placeholder" placeholder="ghi chú" >
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">slug</label>
                                    <input type="text" class="form-control" name="slug" placeholder="đường dẫn tĩnh" >
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Sử dụng chung</label>
                                    <input type="checkbox" class="flat-red" name="general" value="1" >
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
                            <h3 class="box-title">Trường dữ liệu sử dụng</h3>
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
                                    <input type="radio" name="type_input" value="image" class="flat-red">
                                    Hình ảnh
                                </label>
                            </div>
                            <div class="form-group">
                                <label>
                                    <input type="radio" name="type_input" value="image_list" class="flat-red">
                                    Danh sách Hình ảnh
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
                                    <input type="radio" name="type_input" value="text_color" class="flat-red">
                                    Input chọn màu sắc
                                </label>
                            </div>
                            <div class="form-group">
                                <label>
                                    <input type="radio" name="type_input" value="list" class="flat-red">
                                    List danh sách của:
                                </label>
                                <select class="form-control" name="list">
                                    @foreach ($typeSubPosts as $typeSubPost)
                                        <option value="{{ $typeSubPost->slug }}">{{ $typeSubPost->title }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{--<div class="form-group">--}}
                                {{--<label>--}}
                                    {{--<input type="radio" name="type_input" value="list_multi" class="flat-red">--}}
                                    {{--List chọn nhiều danh sách của:--}}
                                {{--</label>--}}
                                {{--<select class="form-control" name="list">--}}
                                    {{--@foreach ($typeSubPosts as $typeSubPost)--}}
                                        {{--<option value="{{ $typeSubPost->slug }}">{{ $typeSubPost->title }}</option>--}}
                                    {{--@endforeach--}}
                                {{--</select>--}}
                            {{--</div>--}}
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->

                    <!-- Nội dung chọn trường dữ liệu -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Hiện thị tại</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <!-- checkbox -->
                            <div class="form-group">
                                <label>
                                    <input type="checkbox" name="post_used[]" value="post" class="flat-red" checked>
                                    Bài viết
                                </label>
                            </div>
                            <div class="form-group">
                                <label>
                                    <input type="checkbox" name="post_used[]" value="product" class="flat-red">
                                    Sản phẩm
                                </label>
                            </div>
                            <div class="form-group">
                                <label>
                                    <input type="checkbox" name="post_used[]" value="language" class="flat-red">
                                    Ngôn ngữ (Không dùng chung với dạng bài viết khác)
                                </label>
                            </div>
                             @foreach($typeSubPosts as $typeSubPost) 
                            <div class="form-group">
                                <label>
                                    <input type="checkbox" name="post_used[]" value="{{ $typeSubPost->slug }}" class="flat-red">
                                    {{$typeSubPost->title}}
                                </label>
                            </div>
                            @endforeach
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
            </form>
        </div>
    </section>
@endsection

