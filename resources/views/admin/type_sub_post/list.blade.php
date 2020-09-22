@extends('admin.layout.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Danh sách dạng bài viết
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Danh sách dạng bài viết</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <a  href="{{ route('type-sub-post.create') }}"><button class="btn btn-primary">Thêm mới</button> </a>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">STT</th>
                                <th width="5%">ID</th>
                                <th>Tiêu đề</th>
                                <th>Slug</th>
                                <th>Số thứ tự hiển thị</th>
                                <th>Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($typeSubPosts as $id => $typeSubPost )
                                <tr>
                                    <td>{{ ($id+1) }}</td>
                                    <td>{{ $typeSubPost->type_sub_post_id }}</td>
                                    <td>{{ $typeSubPost->title }}</td>
                                    <td>{{ $typeSubPost->slug }}</td>
                                    <td>{{ $typeSubPost->location }}</td>
                                    <td>
                                        <a href="{{ route('type-sub-post.edit', ['type_sub_post_id' => $typeSubPost->type_sub_post_id]) }}">
                                            <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                        </a>
                                        <a  href="{{ route('type-sub-post.destroy', ['type_sub_post_id' => $typeSubPost->type_sub_post_id]) }}" class="btn btn-danger btnDelete" data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>STT</th>
                                <th>ID</th>
                                <th>Tiêu đề</th>
                                <th>Slug</th>
                                <th>Số thứ tự hiển thị</th>
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

