@extends('admin.layout.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Danh mục bài viết
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Danh mục bài viết</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <a  href="{{ route('categories.create') }}"><button class="btn btn-primary">Thêm mới</button> </a>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Tiêu đề</th>
                                <th>Danh mục cha</th>
                                <th>Hình ảnh</th>
                                <th>Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($categories as $id => $cate )
                                <tr>
                                    <td>{{ $cate->category_id }}</td>
                                    <td>{{ $cate->title }}</td>
                                    <td>{{ $cate->slug }}</td>
                                    <td><img width="100" src="{{ $cate->image }}" /></td>
                                    <td>
                                        <a href="{{ route('categories.edit', ['category_id' => $cate->category_id]) }}">
                                            <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                        </a>
                                        <a  href="{{ route('categories.destroy', ['category_id' => $cate->category_id]) }}" class="btn btn-danger btnDelete" data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                                @foreach ($cate['sub_children'] as $child)
                                    <tr>
                                        <td>{{ $child['category_id'] }}</td>
                                        <td>{{ $child['title'] }}</td>
                                        <td>{{ $child['slug'] }}</td>
                                        <td><img width="100" src="{{ $child['image'] }}" /></td>
                                        <td>
                                            <a href="{{ route('categories.edit', ['category_id' => $child['category_id']]) }}">
                                                <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                            </a>
                                            <a  href="{{ route('categories.destroy', ['category_id' => $child['category_id']]) }}" class="btn btn-danger btnDelete" data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Tiêu đề</th>
                                <th>Danh mục cha</th>
                                <th>Hình ảnh</th>
                                <th>Thao tác</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
    @include('admin.partials.popup_delete')
@endsection

