@extends('admin.layout.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Chỉnh sửa bài viết {{$post->title}}
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Bài viết</a></li>
            <li class="active">Chỉnh sửa</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('posts.update', ['post_id' => $post->post_id]) }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('PUT') }}
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
                                        <input type="checkbox" name="parents[]" value="{{ $cate->category_id }}" class="flat-red"
                                               @if(in_array($cate->category_id, $categoryPost)) checked @endif/>
                                        {{ $cate->title }}
                                    </label>
                                </div>
                                @foreach($cate['sub_children'] as $child)
                                    <div class="form-group">
                                        <label>
                                            <input type="checkbox" name="parents[]" value="{{ $child['category_id'] }}" class="flat-red"
                                                   @if(in_array($child['category_id'], $categoryPost)) checked @endif/>
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
                                        <option value="{{ $template->slug }}"
                                                @if($template->slug == $post->template) selected @endif >{{ $template->title }}</option>
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
                                <input type="text" class="form-control" name="meta_title" placeholder="Thẻ title" value="{{ $post->meta_title }}" />
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Thẻ description</label>
                                <input type="text" class="form-control" name="meta_description" placeholder="Thẻ description" value="{{ $post->meta_description }}"  />
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Thẻ keyword</label>
                                <input type="text" class="form-control" name="meta_keyword" placeholder="Thẻ keyword" value="{{ $post->meta_keyword }}"  />
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
                                        <input type="text" class="form-control" name="{{$typeInput->slug}}" placeholder="{{ $typeInput->placeholder }}" value="{{ $post[$typeInput->slug] }}" />
                                    @endif

                                    @if($typeInput->type_input == 'multi_line')
                                        <textarea rows="4" class="form-control" name="{{$typeInput->slug}}" placeholder="{{ $typeInput->placeholder }}">{{ $post[$typeInput->slug] }}</textarea>
                                    @endif

                                    @if($typeInput->type_input == 'image')
                                        <input type="button" onclick="return uploadImage(this);" value="Chọn ảnh"
                                               size="20"/>
                                        <img src="{{ $post[$typeInput->slug] }}" width="80" height="70"/>
                                        <input name="{{$typeInput->slug}}" type="hidden" value="{{ $post[$typeInput->slug] }}"/>
                                    @endif

                                    @if($typeInput->type_input == 'image_list')
                                        <div class="form-group">
                                            <input type="button" onclick="return openKCFinder(this);" value="Chọn ảnh"
                                                   size="20"/>
                                            <div class="imageList">
                                                @if(!empty($post[$typeInput->slug]))
                                                    @foreach(explode(',',$post[$typeInput->slug]) as $image)
                                                        <img src="{{$image}}" width="80" height="70" style="margin-left: 5px; margin-bottom: 5px;"/>
                                                    @endforeach
                                                @endif
                                            </div>
                                            <input name="{{$typeInput->slug}}" type="hidden" value="{{ $post[$typeInput->slug] }}"/>
                                        </div>
                                    @endif

                                    @if($typeInput->type_input == 'editor')
                                        <textarea class="editor" id="{{$typeInput->slug}}" name="{{$typeInput->slug}}" rows="10" cols="80"/>{{ $post[$typeInput->slug] }}</textarea>
                                    @endif

                                    @if(!in_array($typeInput->type_input, array('one_line', 'multi_line', 'image', 'editor', 'text_color', 'image_list'), true))
                                        <select name="{{$typeInput->slug}}" class="form-control">
                                            <option value="">-------------</option>
                                            @foreach(\App\Entity\SubPost::showSubPost($typeInput->type_input, 100) as $subPost)
                                                <option value="{{ $subPost->title }}"
                                                        @if($post[$typeInput->slug] == $subPost->title) selected @endif>
                                                    {{ $subPost->title }}</option>
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
                            @foreach($posts as $id => $postLanguage)
                                @if($postLanguage->language == $language->acronym)

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
                                                    <input type="text" class="form-control" name="title[]" placeholder="Tiêu đề" value="{{ $postLanguage->title }}" >
                                                </div>

                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Nội dung {{ $language->language }}</label>
                                                    <textarea class="editor" id="content{{ $language->acronym }}" name="content[]" rows="10" cols="80"/>{{ $postLanguage->content }}</textarea>
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
                                                    <input type="text" class="form-control" name="slug[]" placeholder="đường dẫn tĩnh" value="{{ $postLanguage->slug }}"/>
                                                </div>

                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Mô tả {{ $language->language }}</label>
                                                    <textarea rows="4" class="form-control" name="description[]"
                                                              placeholder="">{{ $postLanguage->description }}</textarea>
                                                </div>

                                                <div class="form-group">
                                                    <input type="button" onclick="return uploadImage(this);" value="Chọn ảnh {{ $language->language }}"
                                                           size="20"/>
                                                    <img src="{{ $postLanguage->image }}" width="80" height="70"/>
                                                    <input name="image[]" type="hidden" value="{{ $postLanguage->image }}"/>
                                                </div>

                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Tags {{ $language->language }} (Viết tag cách nhau bởi dấu ,)</label>
                                                    <input type="text" class="form-control" name="tags[]" placeholder="Tags" value="{{ $postLanguage->tags }}" />
                                                </div>
                                                <div class="form-group">
                                                    <label>Thời gian tin hot:</label>
                                                    <input type="checkbox" name="is_hotnews[]" value="1" class="flat-red"
                                                           @if(!empty($postLanguage->hotnews_start)) checked @endif/> Là tin hot
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-clock-o"></i>
                                                        </div>
                                                        <?php
                                                        $date = new DateTime($postLanguage->hotnews_start);
                                                        $hotnewsStart = $date->format('m/d/Y h:mm A');

                                                        $date = new DateTime($postLanguage->hotnews_end);
                                                        $hotnewsEnd = $date->format('m/d/Y h:mm A');
                                                        ?>
                                                        <input type="text" class="form-control pull-right" id="reservationtime" name="hotnews_start_end[]"
                                                               @if(!empty($postLanguage->hotnews_start)) value="{{ $hotnewsStart }} - {{ $hotnewsEnd }}" @endif/>
                                                    </div>
                                                </div>
                                                @foreach ($typeInputs as $typeInput)
                                                    <div class="form-group">
                                                        <label>{{ $typeInput->title }}</label>
                                                        @if($typeInput->type_input == 'one_line')
                                                            <input type="text" class="form-control" name="{{$typeInput->slug}}[]" placeholder="{{ $typeInput->placeholder }}" value="{{ $postLanguage[$typeInput->slug] }}" />
                                                        @endif

                                                        @if($typeInput->type_input == 'multi_line')
                                                            <textarea rows="4" class="form-control" name="{{$typeInput->slug}}[]" placeholder="{{ $typeInput->placeholder }}">{{ $postLanguage[$typeInput->slug] }}</textarea>
                                                        @endif

                                                        @if($typeInput->type_input == 'image')
                                                            <input type="button" onclick="return uploadImage(this);" value="Chọn ảnh"
                                                                   size="20"/>
                                                            <img src="{{ $postLanguage[$typeInput->slug] }}" width="80" height="70"/>
                                                            <input name="{{$typeInput->slug}}[]" type="hidden" value="{{ $postLanguage[$typeInput->slug] }}"/>
                                                        @endif

                                                        @if($typeInput->type_input == 'image_list')
                                                            <div class="form-group">
                                                                <input type="button" onclick="return openKCFinder(this);" value="Chọn ảnh"
                                                                       size="20"/>
                                                                <div class="imageList">
                                                                    @if(!empty($postLanguage[$typeInput->slug]))
                                                                        @foreach(explode(',',$postLanguage[$typeInput->slug]) as $image)
                                                                            <img src="{{$image}}" width="80" height="70" style="margin-left: 5px; margin-bottom: 5px;"/>
                                                                        @endforeach
                                                                    @endif
                                                                </div>
                                                                <input name="{{$typeInput->slug}}[]" type="hidden" value="{{ $postLanguage[$typeInput->slug] }}"/>
                                                            </div>
                                                        @endif

                                                        @if($typeInput->type_input == 'editor')
                                                            <textarea class="editor" id="{{$typeInput->slug}}" name="{{$typeInput->slug}}[]" rows="10" cols="80"/>{{ $postLanguage[$typeInput->slug] }}</textarea>
                                                        @endif

                                                        @if(!in_array($typeInput->type_input, array('one_line', 'multi_line', 'image', 'editor', 'text_color', 'image_list'), true))
                                                            <select name="{{$typeInput->slug}}[]" class="form-control">
                                                                <option value="">-------------</option>
                                                                @foreach(\App\Entity\SubPost::showSubPost($typeInput->type_input, 100) as $subPost)
                                                                    <option value="{{ $subPost->title }}"
                                                                            @if($postLanguage[$typeInput->slug] == $subPost->title) selected @endif>
                                                                        {{ $subPost->title }}</option>
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
                                @endif
                            @endforeach
                        @endforeach

                    </div>

                </div>
                <div class="col-xs-12 col-md-6">
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Chỉnh sửa</button>
                    </div>
                </div>

            </form>
        </div>
    </section>
@endsection

