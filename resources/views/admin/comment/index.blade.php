@extends('admin.layout.admin')


@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Quản lý bình luận
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Danh sách Bình luận</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="posts" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th>Bài viết</th>
                                <th>Người bình luận</th>
                                <th>Nội dung bình luận</th>
                                <th>Thao tác</th>
                            </tr>
                            </thead>
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

@push('scripts')
<script>
    $(function() {
        $('#posts').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('datatable_comment') !!}',
            columns: [
                { data: 'comment_id', name: 'comment_id' },
                { data: 'title', name: 'title' },
                { data: 'name', name: 'name',
                    render: function ( data ) {
                    if (data != null) {
                        return data;
                    }
                    
                    return 'Ẩn danh';
                    }, },
                { data: 'content', name: 'content' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        });
    });
</script>
@endpush

