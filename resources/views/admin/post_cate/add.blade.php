@extends('admin.layout.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Thêm mới Danh mục bài viết
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Danh mục bài viết</a></li>
            <li class="active">Thêm mới</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('categories.store') }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('POST') }}
                <div class="col-xs-12 col-md-12">

                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Nội dung</h3>
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body">

                            <div class="form-group col-md-6 col-xs-12">
                                <label>Danh mục cha</label>
                                <select class="form-control" name="parent">
                                    <option value="0">------------------</option>
                                    @foreach($categories as $cate)
                                    <option value="{{ $cate->category_id }}">{{ $cate->title }}</option>
                                        @foreach($cate['sub_children'] as $child)
                                            <option value="{{ $child['category_id']}}">{{ $child['title'] }}</option>
                                        @endforeach
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-6 col-xs-12">
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
                                        <div role="tabpanel" class="tab-pane {{ ($id == 0) ? 'active' : '' }}" id="{{ $language->acronym }}">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Tiêu đề {{ $language->language }}</label>
                                                <input type="text" class="form-control" name="title[]" placeholder="Tiêu đề {{ $language->language }}" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputEmail1">slug {{ $language->language }}</label>
                                                <input type="text" class="form-control" name="slug[]" placeholder="đường dẫn tĩnh {{ $language->language }}" >
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Mô tả {{ $language->language }}</label>
                                                <textarea rows="4" class="form-control" name="description[]"
                                                          placeholder=""></textarea>
                                            </div>

                                            <div class="form-group">
                                                <input type="button" onclick="return uploadImage(this);" value="Chọn ảnh {{ $language->language }}"
                                                       size="20"/>
                                                <img src="" width="80" height="70"/>
                                                <input name="image[]" type="hidden" value=""/>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Thêm mới</button>
                        </div>
                    </div>
                    <!-- /.box -->

                </div>
            </form>
        </div>
    </section>
@endsection

