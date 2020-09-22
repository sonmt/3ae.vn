@extends('admin.layout.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Chỉnh sửa trường dữ liệu thông tin {{ $typeInformation->title }}
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cài đặt thông tin</a></li>
            <li class="active">Chỉnh sửa</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('type-information.update', ['type_infor_id' => $typeInformation->type_infor_id]) }}" method="POST">
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
                                <label for="exampleInputEmail1">title</label>
                                <input type="text" class="form-control" name="title" placeholder="Tiêu đề"
                                       value="{{ $typeInformation->title }}" required>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">slug</label>
                                <input type="text" class="form-control" name="slug" placeholder="đường dẫn tĩnh"
                                value="{{ $typeInformation->slug }}" />
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Chú dẫn</label>
                                <input type="text" class="form-control" name="placeholder" placeholder="chú dẫn"
                                       value="{{ $typeInformation->placeholder }}" />
                            </div>

                            <div class="form-group" style="color: red;">
                                @if ($errors->has('title'))
                                    <label for="exampleInputEmail1">{{ $errors->first('title') }}</label>
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
                                    <input type="radio" name="type_input" value="one_line" class="flat-red" @if(strpos($typeInformation->type_input, 'one_line') !== false) checked @endif>
                                    Mộ dòng
                                </label>
                            </div>

                            <div class="form-group">
                                <label>
                                    <input type="radio" name="type_input" value="multi_line" class="flat-red" @if(strpos($typeInformation->type_input, 'multi_line') !== false) checked @endif>
                                    Nhiều dòng dòng
                                </label>
                            </div>

                            <div class="form-group">
                                <label>
                                    <input type="radio" name="type_input" value="editor" class="flat-red" @if(strpos($typeInformation->type_input, 'editor') !== false) checked @endif>
                                    Editor
                                </label>
                            </div>

                            <div class="form-group">
                                <label>
                                    <input type="radio" name="type_input" value="image" class="flat-red"
                                           @if(strpos($typeInformation->type_input, 'image') !== false) checked @endif/>
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

