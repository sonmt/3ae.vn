@extends('admin.layout.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Thêm mới bài viết
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Bài viết</a></li>
            <li class="active">Thêm mới</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('posts.store') }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('POST') }}
                <div class="col-xs-12 col-md-6">

                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary boxCateScoll">
                        <div class="box-header with-border">
                            <h3 class="box-title">Chọn danh mục</h3>
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body">

                            @foreach($categories as $cate)
                                <div class="form-group">
                                    <label>
                                        <input type="checkbox" name="parents[]" value="{{ $cate->category_id }}" class="flat-red">
                                        {{ $cate->title }}
                                    </label>
                                </div>
                                @foreach($cate['sub_children'] as $child)
                                    <div class="form-group">
                                        <label>
                                            <input type="checkbox" name="parents[]" value="{{ $child['category_id'] }}" class="flat-red" >
                                            {{ $child['title'] }}
                                        </label>
                                    </div>
                                @endforeach
                            @endforeach


                        </div>

                    </div>
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

                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Hỗ trợ seo</h3>
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body">

                            <div class="form-group">
                                <label for="exampleInputEmail1">Thẻ title</label>
                                <input type="text" class="form-control" name="meta_title" placeholder="Thẻ title" />
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Thẻ description</label>
                                <input type="text" class="form-control" name="meta_description" placeholder="Thẻ description" />
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Thẻ keyword</label>
                                <input type="text" class="form-control" name="meta_keyword" placeholder="Thẻ keyword" />
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                    

                    <!-- /.box -->

                </div>

                <div class="col-xs-12 col-md-6">
                    <div class="box box-primary">
                        <div class="box-body">
                            @foreach ($typeInputsGeneral as $typeInput)
                                <div class="form-group">
                                    <label>{{ $typeInput->title }}</label>
                                    @if($typeInput->type_input == 'one_line')
                                        <input type="text" class="form-control" name="{{$typeInput->slug}}" placeholder="{{ $typeInput->placeholder }}" />
                                    @endif

                                    @if($typeInput->type_input == 'multi_line')
                                        <textarea rows="4" class="form-control" name="{{$typeInput->slug}}" placeholder="{{ $typeInput->placeholder }}"></textarea>
                                    @endif

                                    @if($typeInput->type_input == 'image')
                                        <input type="button" onclick="return uploadImage(this);" value="Chọn ảnh"
                                               size="20"/>
                                        <img src="" width="80" height="70"/>
                                        <input name="{{$typeInput->slug}}" type="hidden" value=""/>
                                    @endif

                                    @if($typeInput->type_input == 'image_list')
                                        <div class="form-group">
                                            <input type="button" onclick="return openKCFinder(this);" value="Chọn ảnh"
                                                   size="20"/>
                                            <div class="imageList">
                                            </div>
                                            <input name="{{$typeInput->slug}}" type="hidden" value=""/>
                                        </div>
                                    @endif

                                    @if($typeInput->type_input == 'editor')
                                        <textarea class="editor" id="{{$typeInput->slug}}" name="{{$typeInput->slug}}" rows="10" cols="80"/></textarea>
                                    @endif

                                    @if(!in_array($typeInput->type_input, array('one_line', 'multi_line', 'image', 'editor', 'text_color', 'image_list'), true))
                                        <select name="{{$typeInput->slug}}" class="form-control">
                                            <option value="">-------------</option>
                                            @foreach(\App\Entity\SubPost::showSubPost($typeInput->type_input, 100) as $subPost)
                                                <option value="{{ $subPost->title }}">{{ $subPost->title }}</option>
                                            @endforeach
                                        </select>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                
                <div class="col-xs-12 col-md-12">

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        @foreach ($languages as $id => $language)
                        <li role="presentation" class="{{ ($id == 0) ? 'active' : '' }}">
                            <a href="#{{ $language->acronym }}" aria-controls="{{ $language->acronym }}" role="tab" data-toggle="tab">{{ $language->language }}</a>
                        </li>
                        @endforeach
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content clearfix">
                        @foreach ($languages as $id => $language)
                            <div role="tabpanel" class="tab-pane {{ ($id == 0) ? 'active' : '' }}" id="{{ $language->acronym }}">
                                <div class="row">
                                    <div class="col-xs-12 col-md-7">

                                        <!-- Nội dung thêm mới -->
                                        <div class="box box-primary">
                                            <div class="box-header with-border">
                                                <h3 class="box-title">Nội dung ngôn ngữ {{ $language->language }}</h3>
                                            </div>
                                            <!-- /.box-header -->

                                            <div class="box-body">

                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">title {{ $language->language }}</label>
                                                    <input type="text" class="form-control" name="title[]" placeholder="Tiêu đề" >
                                                </div>

                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Nội dung {{ $language->language }}</label>
                                                    <textarea class="editor" id="content{{ $language->acronym }}" name="content[]" rows="10" cols="80"/></textarea>
                                                </div>


                                                <div class="form-group" style="color: red;">
                                                    @if ($errors->has('title'))
                                                        <label for="exampleInputEmail1">{{ $errors->first('title') }}</label>
                                                    @endif
                                                </div>
                                            </div>
                                            <!-- /.box-body -->
                                        </div>
                                        <!-- /.box -->
                                    </div>

                                    <div class="col-xs-12 col-md-5">
                                        <!-- Bổ sung -->
                                        <div class="box box-primary">
                                            <div class="box-body">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">slug {{ $language->language }}</label>
                                                    <input type="text" class="form-control" name="slug[]" placeholder="đường dẫn tĩnh" >
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

                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Tags {{ $language->language }} (Viết tag cách nhau bởi dấu ,)</label>
                                                    <input type="text" class="form-control" name="tags[]" placeholder="Tags" >
                                                </div>
                                                <div class="form-group">
                                                    <label>Thời gian tin hot:</label>
                                                    <input type="checkbox" name="is_hotnews[]" value="1" class="flat-red" /> có hot
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-clock-o"></i>
                                                        </div>
                                                        <input type="text" class="form-control pull-right" id="reservationtime" name="hotnews_start_end[]" />
                                                    </div>
                                                    <!-- /.input group -->
                                                </div>
                                                @foreach ($typeInputs as $typeInput)
                                                    <div class="form-group">
                                                        <label>{{ $typeInput->title }}</label>
                                                        @if($typeInput->type_input == 'one_line')
                                                            <input type="text" class="form-control" name="{{$typeInput->slug}}[]" placeholder="{{ $typeInput->placeholder }}" />
                                                        @endif

                                                        @if($typeInput->type_input == 'multi_line')
                                                            <textarea rows="4" class="form-control" name="{{$typeInput->slug}}[]" placeholder="{{ $typeInput->placeholder }}"></textarea>
                                                        @endif

                                                        @if($typeInput->type_input == 'image')
                                                            <input type="button" onclick="return uploadImage(this);" value="Chọn ảnh"
                                                                   size="20"/>
                                                            <img src="" width="80" height="70"/>
                                                            <input name="{{$typeInput->slug}}[]" type="hidden" value=""/>
                                                        @endif

                                                        @if($typeInput->type_input == 'image_list')
                                                            <div class="form-group">
                                                                <input type="button" onclick="return openKCFinder(this);" value="Chọn ảnh"
                                                                       size="20"/>
                                                                <div class="imageList">
                                                                </div>
                                                                <input name="{{$typeInput->slug}}[]" type="hidden" value=""/>
                                                            </div>
                                                        @endif

                                                        @if($typeInput->type_input == 'editor')
                                                            <textarea class="editor" id="{{$typeInput->slug}}" name="{{$typeInput->slug}}[]" rows="10" cols="80"/></textarea>
                                                        @endif

                                                        @if(!in_array($typeInput->type_input, array('one_line', 'multi_line', 'image', 'editor', 'text_color', 'image_list'), true))
                                                            <select name="{{$typeInput->slug}}[]" class="form-control">
                                                                    <option value="">-------------</option>
                                                                @foreach(\App\Entity\SubPost::showSubPost($typeInput->type_input, 100) as $subPost)
                                                                    <option value="{{ $subPost->title }}">{{ $subPost->title }}</option>
                                                                @endforeach
                                                            </select>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>

                </div>      
                 <div class="col-xs-12 col-md-6">
                     <div class="box-footer">
                         <button type="submit" class="btn btn-primary">Thêm mới</button>
                     </div>
                 </div>

            </form>
        </div>
    </section>
@endsection

