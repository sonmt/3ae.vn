@extends('admin.layout.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Chỉnh sửa Dạng bài viết {{ $typeSubPost->title }}
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Dạng bài viết</a></li>
            <li class="active">Chỉnh sửa</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('type-sub-post.update', ['type_sub_post_id' => $typeSubPost->type_sub_post_id]) }}" method="POST">
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
                                       value="{{ $typeSubPost->title }}" required>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">slug</label>
                                <input type="text" class="form-control" name="slug" placeholder="đường dẫn tĩnh"
                                value="{{ $typeSubPost->slug }}" />
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Số thứ tự hiển thị</label>
                                <input type="number" class="form-control" name="location" placeholder="Số thứ tự hiển thị" value="{{ $typeSubPost->location }}" />
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Hiển thị trong lựa chọn menu</label>
                                <input type="checkbox" class="flat-red" value="1" name="show_menu" placeholder="Hiển thị trong lựa chọn menu"
                                {{ ($typeSubPost->show_menu == 1) ? 'checked' : '' }}/>
                            </div>

                            <div class="form-group">
                                <label>
                                    <input type="checkbox" name="have_sort" value="1" class="flat-red" @if($typeSubPost->have_sort == 1) checked @endif />
                                    Có lựa chọn số thứ tự sắp xếp
                                </label>
                            </div>

                            <div class="form-group">
                                <label>
                                    <input type="checkbox" name="is_index_hot" value="1" class="flat-red" @if($typeSubPost->is_index_hot == 1) checked @endif />
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
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
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
                                        <option value="{{ $template->slug }}"
                                                @if($template->slug == $typeSubPost->template) selected @endif >{{ $template->title }}</option>
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
                                    <input type="checkbox" name="input_default_used[]" value="title" class="flat-red" @if(strpos($typeSubPost->input_default_used, 'title') !== false) checked @endif>
                                    Tiêu đề
                                </label>
                            </div>
                            <div class="form-group">
                                <label>
                                    <input type="checkbox" name="input_default_used[]" value="content" class="flat-red" @if(strpos($typeSubPost->input_default_used, 'content') !== false) checked @endif/>
                                    Trình soạn thảo
                                </label>
                            </div>
                            <div class="form-group">
                                <label>
                                    <input type="checkbox" name="input_default_used[]" value="tags" class="flat-red" @if(strpos($typeSubPost->input_default_used, 'tags') !== false) checked @endif/>
                                    Tags
                                </label>
                            </div>
                            <div class="form-group">
                                <label>
                                    <input type="checkbox" name="input_default_used[]" value="image" class="flat-red" @if(strpos($typeSubPost->input_default_used, 'image') !== false) checked @endif>
                                    Ảnh nổi bật
                                </label>
                            </div>
                            <div class="form-group">
                                <label>
                                    <input type="checkbox" name="input_default_used[]" value="description" class="flat-red" @if(strpos($typeSubPost->input_default_used, 'description') !== false) checked @endif>
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

