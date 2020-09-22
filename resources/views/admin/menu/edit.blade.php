@extends('admin.layout.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Chỉnh sửa menu {{ $menu->title }}
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Cài đặt thông tin</a></li>
            <li class="active">Chỉnh sửa</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12 col-md-8">
                <div class="box box-primary boxMenuSource">
                    <div class="box-body">
                        <!-- category post -->
                        <div class="form-group">
                            <button class="btn btn-primary menuButton" type="button" data-toggle="collapse" data-target="#postCategory" aria-expanded="false" aria-controls="postCategory">
                                Chuyên mục bài viết
                            </button>
                            <div class="collapse" id="postCategory">
                                <ul class="sortable1" >
                                    @foreach ($postCategories as $postCategory)
                                        <li class="ui-state-default">
                                            {{ $postCategory->title }}
                                            <i class="fa fa-plus addMenu" onclick="return addMenu(this);"aria-hidden="true"></i>
                                            <i class="fa fa-caret-down menuSubButton" aria-hidden="true" data-toggle="collapse" data-target="#postCategory{{$postCategory->category_id}}" aria-expanded="false" aria-controls="postCategory"></i>

                                            <input  type="text" placeholder="cấp menu" value="1" name="menu_level[]" class="menuLevel"/>
                                            <i class="titleMenuLevel">Cấp menu</i>

                                            <div class="collapse" id="postCategory{{$postCategory->category_id}}">
                                                @foreach ($postCategory['language'] as $language)
                                                <label for="exampleInputEmail1"><i>Tiêu đề {{ $language->language }}</i></label>
                                                <input type="text" name="title_show[]" value="{{$language->title}}" class="titleShow form-control" />
                                                <!-- tiếng việt -->
                                                <input type="hidden" name="menu_image[]" class="form-control" value="{{ $language->image }}" />
                                                <input type="hidden" name="url[]" class="form-control"
                                                       value="{{ route('category', ['cate_slug' => $language->slug, 'languageCurrent' => $language->language]) }}" />
                                                <input type="hidden" name="language[]" class="form-control" value="{{ $language->language }}" />
                                                @endforeach
                                            </div>
                                        </li>
                                        @foreach ($postCategory['sub_children'] as $child)
                                            <li class="ui-state-default">
                                                {{ \App\Ultility\Ultility::textLimit($child['title'], 5) }}
                                                <i class="fa fa-plus addMenu" onclick="return addMenu(this);"aria-hidden="true"></i>
                                                <i class="fa fa-caret-down menuSubButton" aria-hidden="true" data-toggle="collapse" data-target="#postCategory{{$child['category_id']}}" aria-expanded="false" aria-controls="postCategory"></i>

                                                <input  type="text" placeholder="cấp menu" value="2" name="menu_level[]" class="menuLevel"/>
                                                <i class="titleMenuLevel">Cấp menu</i>

                                                <div class="collapse" id="postCategory{{$child['category_id']}}">
                                                    @foreach ($child['language'] as $language)
                                                    <label for="exampleInputEmail1"><i>Tiêu đề {{ $language->language }}</i></label>
                                                    <input type="text" name="title_show[]" value="{{$language->title}}" class="titleShow form-control" />

                                                    <input type="hidden" name="menu_image[]" class="form-control" value="{{$language->image}}" />
                                                    <input type="hidden" name="url[]" class="form-control"
                                                           value="{{ route('category', ['cate_slug' => $language->slug, 'languageCurrent' => $language->language]) }}" />
                                                    <input type="hidden" name="language[]" class="form-control" value="{{ $language->language }}" />
                                                    @endforeach
                                                </div>
                                            </li>
                                        @endforeach
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <div class="form-group">
                            <button class="btn btn-primary menuButton" type="button" data-toggle="collapse" data-target="#posts" aria-expanded="false" aria-controls="posts">
                                Bài viết
                            </button>
                            <div class="collapse" id="posts">
                                <ul class="sortable1" >
                                    @foreach ($posts as $post)
                                        <li class="ui-state-default">
                                            {{ $post->title }}
                                            <i class="fa fa-plus addMenu" onclick="return addMenu(this);"aria-hidden="true"></i>
                                            <i class="fa fa-caret-down menuSubButton" aria-hidden="true" data-toggle="collapse" data-target="#posts{{$post->post_id}}" aria-expanded="false" aria-controls="posts"></i>

                                            <input type="text" placeholder="cấp menu" value="1" name="menu_level[]" class="menuLevel"/>
                                            <i class="titleMenuLevel">Cấp menu</i>

                                            <div class="collapse" id="posts{{$post->post_id}}">
                                                @foreach ($post['language'] as $postLanguage)
                                                <label for="exampleInputEmail1">Tiêu đề {{ $postLanguage->language }}</label>
                                                <input type="text" name="title_show[]" value="{{$postLanguage->title}}" class="titleShow form-control" />

                                                <input type="hidden" name="menu_image[]" class="form-control" value="" placeholder="ảnh"/>
                                                <input type="hidden" name="url[]" class="form-control"
                                                       value="{{ route('post', ['cate_slug' => ($postLanguage->language == 'vn') ? 'tin-tuc' : 'news', 'post_slug' => $postLanguage->slug,
                                                       'languageCurrent' => $postLanguage->language]) }}" />
                                                <input type="hidden" name="language[]" class="form-control" value="{{ $postLanguage->language }}" />
                                                @endforeach
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        {{--<div class="form-group">--}}
                            {{--<button class="btn btn-primary menuButton" type="button" data-toggle="collapse" data-target="#productCategories" aria-expanded="false" aria-controls="posts">--}}
                                {{--Danh mục sản phẩm--}}
                            {{--</button>--}}
                            {{--<div class="collapse" id="productCategories">--}}
                                {{--<ul class="sortable1" >--}}
                                    {{--@foreach ($productCategories as $productCategory)--}}
                                        {{--<li class="ui-state-default">--}}
                                            {{--{{ \App\Ultility\Ultility::textLimit($productCategory->title, 5) }}--}}
                                            {{--<i class="fa fa-plus addMenu" onclick="return addMenu(this);"aria-hidden="true"></i>--}}
                                            {{--<i class="fa fa-caret-down menuSubButton" aria-hidden="true" data-toggle="collapse" data-target="#productCategories{{$productCategory->category_id}}" aria-expanded="false" aria-controls="productCategories"></i>--}}

                                            {{--<input type="text" placeholder="cấp menu" value="1" name="menu_level[]" class="menuLevel"/>--}}
                                            {{--<i class="titleMenuLevel">Cấp menu</i>--}}

                                            {{--<div class="collapse" id="productCategories{{$productCategory->category_id}}">--}}
                                                {{--<label for="exampleInputEmail1">Tiêu đề</label>--}}
                                                {{--<input type="text" name="title_show[]" value="{{$productCategory->title}}" class="titleShow form-control" />--}}

                                                {{--<input type="hidden" name="menu_image[]" class="form-control" value="{{ $productCategory->image }}" />--}}
                                                {{--<input type="hidden" name="url[]" class="form-control" value="/cua-hang/{{ $productCategory->slug }}" />--}}
                                            {{--</div>--}}
                                        {{--</li>--}}
                                    {{--@endforeach--}}
                                {{--</ul>--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        {{--<div class="form-group">--}}
                            {{--<button class="btn btn-primary menuButton" type="button" data-toggle="collapse" data-target="#products" aria-expanded="false" aria-controls="posts">--}}
                                {{--Sản phẩm--}}
                            {{--</button>--}}
                            {{--<div class="collapse" id="products">--}}
                                {{--<ul class="sortable1" >--}}
                                    {{--@foreach ($products as $product)--}}
                                        {{--<li class="ui-state-default">--}}
                                            {{--{{ \App\Ultility\Ultility::textLimit($product->title, 5) }}--}}
                                            {{--<i class="fa fa-plus addMenu" onclick="return addMenu(this);"aria-hidden="true"></i>--}}
                                            {{--<i class="fa fa-caret-down menuSubButton" aria-hidden="true" data-toggle="collapse" data-target="#products{{$product->product_id}}" aria-expanded="false" aria-controls="products"></i>--}}

                                            {{--<input type="text" placeholder="cấp menu" value="1" name="menu_level[]" class="menuLevel"/>--}}
                                            {{--<i class="titleMenuLevel">Cấp menu</i>--}}

                                            {{--<div class="collapse" id="products{{$product->product_id}}">--}}
                                                {{--<label for="exampleInputEmail1">Tiêu đề</label>--}}
                                                {{--<input type="text" name="title_show[]" value="{{$product->title}}" class="titleShow form-control" />--}}

                                                {{--<input type="hidden" name="menu_image[]" class="form-control" value="" />--}}
                                                {{--<input type="hidden" name="url[]" class="form-control" value="{{ route('product', [ 'post_slug' => $product->slug]) }}" />--}}
                                            {{--</div>--}}
                                        {{--</li>--}}
                                    {{--@endforeach--}}
                                {{--</ul>--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        @foreach ($typeSubPosts as $typeSubPost)
                            <div class="form-group">
                                <button class="btn btn-primary menuButton" type="button" data-toggle="collapse" data-target="#{{ $typeSubPost->slug }}" aria-expanded="false" aria-controls="{{ $typeSubPost->slug }}">
                                    {{ $typeSubPost->title }}
                                </button>
                                <div class="collapse" id="{{ $typeSubPost->slug }}">
                                    <ul class="sortable1" >
                                        @foreach ($subPosts[$typeSubPost->slug] as $subPost)
                                            <li class="ui-state-default">
                                                {{ $subPost->title }}
                                                <i class="fa fa-plus addMenu" onclick="return addMenu(this);"aria-hidden="true"></i>
                                                <i class="fa fa-caret-down menuSubButton" aria-hidden="true" data-toggle="collapse" data-target="#{{ $subPost->slug.$subPost->sub_post_id }}" aria-expanded="false" aria-controls="{{ $subPost->slug }}"></i>

                                                <input type="text" placeholder="cấp menu" value="1" name="menu_level[]" class="menuLevel"/>
                                                <i class="titleMenuLevel">Cấp menu</i>
                                                <div class="collapse" id="{{ $subPost->slug.$subPost->sub_post_id }}">
                                                    @foreach ($subPost['language'] as $postLanguage)
                                                    <label for="exampleInputEmail1">Tiêu đề {{ $postLanguage->language }}</label>
                                                    <input type="text" name="title_show[]" value="{{$postLanguage->title}}" class="titleShow form-control" />

                                                    <input type="hidden" name="menu_image[]" class="form-control" value="" />
                                                    <input type="hidden" name="url[]" class="form-control" value="{{ $postLanguage->slug }}" />
                                                    <input type="hidden" name="language[]" class="form-control" value="{{ $postLanguage->language }}" />
                                                    @endforeach
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endforeach

                        <ul class="sortable1" >
                            <li class="ui-state-default">
                                Trường tùy biến
                                <i class="fa fa-plus addMenu" onclick="return addMenu(this);"aria-hidden="true"></i>
                                <i class="fa fa-caret-down menuSubButton" aria-hidden="true" data-toggle="collapse" data-target="#submitInput" aria-expanded="false" aria-controls="submitInput"></i>

                                <input type="text" placeholder="cấp menu" value="1" name="menu_level[]" class="menuLevel"/>
                                <i class="titleMenuLevel">Cấp menu</i>


                                <div class="collapse" id="submitInput">
                                    @foreach ($languages as $id => $language)
                                    <label for="exampleInputEmail1">Tiêu đề {{ $language->language }}</label>
                                    <input type="text" name="title_show[]" value="" class="titleShow form-control" placeholder="tiêu đề hiển thị"/>
                                    <i>Đường dẫn {{ $language->language }}</i>
                                    
                                    <input type="hidden" name="menu_image[]" class="form-control" value="" />
                                    <input type="text" name="url[]" class="form-control" value="" placeholder="Nhập đường dẫn"/>
                                    <input type="hidden" name="language[]" class="form-control" value="{{ $language->acronym }}" />
                                    @endforeach
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- form start -->
            <form role="form" action="{{ route('menus.update', ['menu_id' => $menu->menu_id]) }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('PUT') }}

                <div class="col-xs-12 col-md-4">
                    <!-- Nội dung thêm mới -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Nội dung</h3>
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên menu</label>
                                <input type="text" class="form-control" name="title" placeholder="Tiêu đề"
                                       value="{{ $menu->title }}" required>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">slug</label>
                                <input type="text" class="form-control" name="slug" placeholder="đường dẫn tĩnh"
                                       value="{{ $menu->slug }}" />
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Vị trí menu</label>
                                @foreach($locationMenus as $id => $location)
                                    <p><input type="radio" value="{{ $id }}" name="location" {{ ($menu->location == $id) ? 'checked' : '' }}/> {{ $location }}</p>
                                @endforeach
                            </div>

                            <div class="form-group">
                                <input type="button" onclick="return uploadImage(this);" value="Chọn ảnh"
                                       size="20"/>
                                <img src="{{ $menu->image }}" width="80" height="70"/>
                                <input name="image" type="hidden" value="{{ $menu->image }}"/>
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
                    
                    <div class="box box-primary">
                        <div class="box-body">
                            <ul id="sortable2">
                                @foreach($menuElements as $menuElement)
                                <li class="ui-state-default">
                                    <i class="fa fa-ban removeMenu" aria-hidden="true" onclick="return removeMenu(this);"></i>
                                    {{ \App\Ultility\Ultility::textLimit($menuElement->title_show, 5) }}
                                    <i class="fa fa-caret-down menuSubButton" aria-hidden="true" data-toggle="collapse" data-target="#menuElement{{ $menuElement->menu_element_id }}" aria-expanded="false" aria-controls="menuElement"></i>

                                    <input type="text" placeholder="cấp menu" value="{{ $menuElement->menu_level }}" name="menu_level[]" class="menuLevel"/>
                                    <i class="titleMenuLevel">Cấp menu</i>

                                    <div class="collapse" id="menuElement{{ $menuElement->menu_element_id }}">
                                        @foreach ($menuElement['language'] as $language)
                                        <label for="exampleInputEmail1">Tiêu đề {{ $language->language }}</label>
                                        <input type="text" name="title_show[]" value="{{$language->title_show}}" class="titleShow form-control" />

                                        <input type="text" name="menu_image[]" placeholder="Hình ảnh" class="form-control" value="{{ $language->menu_image }}" />
                                        <input type="text" name="url[]" class="form-control" value="{{ $language->url }}" />
                                        <input type="hidden" name="language[]" class="form-control" value="{{ $language->language }}" />
                                        @endforeach
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-md-6 col-md-offset-6">


                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                    </div>
                    <!-- /.box -->

                </div>
            </form>
        </div>
    </section>
    <style>
        .sortable1, #sortable2 {
            border: 1px solid #eee;
            width: 100%;
            min-height: 20px;
            list-style-type: none;
            margin: 0;
            padding: 5px 0 0 0;
            float: left;
            margin-right: 10px;
        }
        .sortable1 li, #sortable2 li {
            margin: 0 0px 5px 0px;
            padding: 5px;
            font-size: 1.2em;
            width: 100%;
        }
        .menuButton {
            width: 100%;
        }
        .boxMenuSource {
            height: 769px;
            overflow-y:auto;
            overflow-x:hidden;
        }
        .menuSubButton {
            background: #fff;
            color: #000;
            float: right;
            margin-right: 3px;
            cursor: pointer;
        }
        .menuLevel {
            float: right;
            margin-right: 15px;
            width: 10%;
            margin-bottom: 5px;
        }
        .titleMenuLevel {
            float: right;
            margin-right: 10px;
        }
        .collapse {
            background: #fff;
            margin-top: 10px;
            padding: 10px 10px;
        }
        .collapse input[type=text] {
            border: 1px #e5e5e5 solid;
        }
        .addMenu {
            float: right;
            margin-top: 4px;
            margin-left: 20px;
            margin-right: 10px;
            color: #1fa67a;
            cursor: pointer;
        }
        .addMenu:hover {
            color: #dcd7d7;
        }
        .removeMenu {
            float: right;
            color: red;
            cursor: pointer;
            margin-top: 4px;
            margin-left: 20px;
            margin-right: 10px;
        }
        .removeMenu:hover {
            color: #dcd7d7;
        }
    </style>
@endsection

