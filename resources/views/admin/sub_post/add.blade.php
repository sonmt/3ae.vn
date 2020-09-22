@extends('admin.layout.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Thêm mới {{ $typePost }}
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">{{ $typePost }}</a></li>
            <li class="active">Thêm mới</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('sub-posts.store', ['typePost' => $typePost]) }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('POST') }}
                <div class="col-xs-12 col-md-12">
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
                            @if ($typeSubPost->have_sort == 1)
                            <div class="form-group">
                                <label>Số thứ tự hiển thị</label>
                                <input type="number" class="form-control" name="sort" placeholder="Lựa chọn số thứ tự hiển thị" />
                            </div>
                            @endif

                            @if ($typeSubPost->is_index_hot == 1)
                                <div class="form-group">
                                    <label>Nội bật (tích chọn để hiển thị mục nổi bật ngoài trang chủ)</label>
                                    <input type="checkbox" value="1" class="form-control flat-red" name="index_hot" placeholder="" />
                                </div>
                            @endif

                            @foreach ($typeInputsGeneral as $typeInput)
                                <div class="form-group">
                                    <label>{{ $typeInput->title }} </label>
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
                                        <textarea class="editor" id="{{$typeInput->slug}}{{ $language->language }}" name="{{$typeInput->slug}}" rows="10" cols="80"/></textarea>
                                    @endif

                                    @if($typeInput->type_input == 'text_color')
                                        <input type="text" class="form-control my-colorpicker1" name="{{$typeInput->slug}}" placeholder="{{ $typeInput->placeholder }}"  />
                                    @endif

                                    @if(!in_array($typeInput->type_input, array('one_line', 'multi_line', 'image', 'editor', 'text_color', 'image_list'), true))
                                        <select name="{{$typeInput->slug}}" class="form-control select2">
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
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Nội dung {{ $language->language }}</h3>
                                </div>
                                <!-- /.box-header -->

                                <div class="box-body">

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Tiêu đề {{ $language->language }}</label>
                                        <input type="text" class="form-control" name="title[]" placeholder="Tiêu đề" />
                                    </div>
                                    @if (in_array('content', explode(',', $typeSubPost->input_default_used)))
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Nội dung {{ $language->language }}</label>
                                            <textarea class="editor" id="content{{ $language->language }}" name="content[]" rows="10" cols="80"/></textarea>
                                        </div>
                                    @endif

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">slug {{ $language->language }}</label>
                                        <input type="text" class="form-control" name="slug[]" placeholder="đường dẫn tĩnh" >
                                    </div>

                                    @if (in_array('description', explode(',', $typeSubPost->input_default_used)))
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Mô tả {{ $language->language }}</label>
                                            <textarea rows="4" class="form-control" name="description[]"
                                                      placeholder=""></textarea>
                                        </div>
                                    @endif

                                    @if (in_array('tags', explode(',', $typeSubPost->input_default_used)))
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Tags {{ $language->language }} (Viết tag cách nhau bởi dấu ,)</label>
                                        <input type="text" class="form-control" name="tags[]" placeholder="Tags" >
                                    </div>
                                    @endif

                                    @if (in_array('image', explode(',', $typeSubPost->input_default_used)) > 0)
                                        <div class="form-group">
                                            <input type="button" onclick="return uploadImage(this);" value="Chọn ảnh {{ $language->language }}"
                                                   size="20"/>
                                            <img src="" width="80" height="70"/>
                                            <input name="image[]" type="hidden" value=""/>
                                        </div>
                                    @endif

                                    <div class="form-group" style="color: red;">
                                        @if ($errors->has('title'))
                                            <label for="exampleInputEmail1">{{ $errors->first('title') }}</label>
                                        @endif
                                    </div>
                                </div>
                                <!-- /.box-body -->
                            </div>

                            <div class="box box-primary">
                                <div class="box-body">
                                    @foreach ($typeInputs as $typeInput)
                                        <div class="form-group">
                                            <label>{{ $typeInput->title }} {{ $language->language }}</label>
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
                                                <textarea class="editor" id="{{$typeInput->slug}}{{ $language->language }}" name="{{$typeInput->slug}}[]" rows="10" cols="80"/></textarea>
                                            @endif

                                            @if($typeInput->type_input == 'text_color')
                                                <input type="text" class="form-control my-colorpicker1" name="{{$typeInput->slug}}[]" placeholder="{{ $typeInput->placeholder }}"  />
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
                        @endforeach
                    </div>
                    <!-- Nội dung thêm mới -->
                    <!-- /.box -->
                </div>

                <div class="col-xs-12 col-md-12">

                    <!-- Bổ sung -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Thêm mới</button>
                    </div>
                    <!-- /.box -->

                </div>
            </form>
        </div>
    </section>
@endsection

