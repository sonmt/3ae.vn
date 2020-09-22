@extends('admin.layout.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Chỉnh sửa danh mục  {{$category->title}}
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Danh mục bài viết</a></li>
            <li class="active">Chỉnh sửa</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('categories.update', ['category_id' => $category->category_id]) }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('PUT') }}
                <div class="col-xs-12 col-md-8">

                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Nội dung</h3>
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body">

                            <div class="form-group">
                                <label>Danh mục cha</label>
                                <select class="form-control" name="parent">
                                    <option value="0">------------------</option>
                                    @foreach($categories as $cate)
                                        <option value="{{ $cate->category_id }}"
                                                @if($cate->category_id == $category->parent) selected @endif  >{{ $cate->title }}</option>
                                        @foreach($cate['sub_children'] as $child)
                                            <option value="{{ $child['category_id']}}"
                                            @if($child['category_id'] == $category->parent) selected @endif >{{ $child['title'] }}</option>
                                        @endforeach
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Chọn template</label>
                                <select class="form-control" name="template">
                                    <option value="default">Mặc định</option>
                                    @foreach($templates as $template)
                                        <option value="{{ $template->slug }}"
                                        @if($template->slug == $category->template) selected @endif>{{ $template->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="box box-primary">
                        <div class="box-body">
                            <div>
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" role="tablist">
                                    @foreach ($languages as $id => $language)
                                        <li role="presentation" class="{{ ($id == 0) ? 'active' : '' }}">
                                            <a href="#{{ $language->acronym }}" aria-controls="{{ $language->acronym }}" role="tab" data-toggle="tab">{{ $language->language }}</a>
                                        </li>
                                    @endforeach
                                </ul>

                                <div class="tab-content clearfix">
                                    @foreach ($languages as $id => $language)
                                        @foreach ($categorieLanguages as $cate)
                                            @if ($cate->language == $language->acronym)
                                                <div role="tabpanel" class="tab-pane {{ ($id == 0) ? 'active' : '' }}" id="{{ $language->acronym }}">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Tiêu đề {{ $language->language }}</label>
                                                        <input type="text" class="form-control" name="title[]" placeholder="Tiêu đề {{ $language->language }}"
                                                               value="{{ $cate->title }}" required>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">slug {{ $language->language }}</label>
                                                        <input type="text" class="form-control" name="slug[]" placeholder="đường dẫn tĩnh {{ $language->language }}"
                                                               value="{{ $cate->slug }}" />
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Mô tả {{ $language->language }}</label>
                                                        <textarea rows="4" class="form-control" name="description[]"
                                                                  placeholder="">{{ $cate->description }}</textarea>
                                                    </div>

                                                    <div class="form-group">
                                                        <input type="button" onclick="return uploadImage(this);" value="Chọn ảnh {{ $language->language }}"
                                                               size="20"/>
                                                        <img src="{{ $cate->image }}" width="80" height="70"/>
                                                        <input name="image[]" type="hidden" value="{{ $cate->image }}"/>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                        </div>
                    </div>
                    <!-- /.box -->

                </div>
            </form>
        </div>
    </section>
@endsection

