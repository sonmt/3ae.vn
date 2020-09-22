@extends('admin.layout.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ $typePost }}
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Danh sách {{ $typePost }}</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <a  href="{{ route('sub-posts.create', ['typePost' => $typePost]) }}"><button class="btn btn-primary">Thêm mới</button> </a>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="subPosts" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    @if ($typeSubPost->have_sort == 1)
                                        <th width="5%">Thứ tự hiển thị</th>
                                    @endif
                                    <th width="5%">ID</th>
                                    <th>Tiêu đề</th>
                                        @if ($typeSubPost->is_index_hot == 1)
                                            <th>hiển thị ngoài trang chủ</th>
                                        @endif
                                    <th>Hình ảnh</th>
                                    <th>Hiển thị</th>
                                    <th>Thuộc tính bổ sung</th>
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
    @include('admin.partials.index_hot')
    @include('admin.partials.visiable')
@endsection
@push('scripts')
<script>
    $(function() {
        $('#subPosts').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('datatable_sub_posts', ['typePost' => $typePost]) !!}',
            columns: [
                    <?php if ($typeSubPost->have_sort == 1) {?>
                { data: 'sort', name: 'sort' },
                    <?php } ?>
                { data: 'post_id', name: 'post_id' },
                { data: 'title', name: 'title' },
                    @if ($typeSubPost->is_index_hot == 1)
                { data: 'index' ,name: 'index_hot',},
                    @endif
                { data: 'image', name: 'image', orderable: false,
                    render: function ( data, type, row, meta ) {
                        return '<img src="'+data+'" width="100" />';
                    },
                    searchable: false  },
                { data: 'visiable', name: 'visiable', orderable: false,
                    render: function ( data, type, row, meta ) {
                        if (data == 0) {
                            return '<input type="checkbox" class="icheckbox_flat-green" value="'+row.post_id+'" onclick="return visiablePost(this)" checked/>';
                        }

                        return '<input type="checkbox" class="icheckbox_flat-green" value="'+row.post_id+'" onclick="return visiablePost(this)" />';
                    },
                    searchable: false  },
                { data: 'additional', name: 'additional', render: function(data) {
                    var string = '';
                    $.each(data, function(index, element) {
                        string += element + '<br>';
                    });

                    return string;
                } },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        });
    });
</script>
@endpush
