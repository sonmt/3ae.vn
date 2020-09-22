@extends('admin.layout.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Đăng ký nhận email
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Đăng ký nhận email</a></li>
        </ol>
    </section>
    <section class="content">

        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#email" aria-controls="email" role="tab" data-toggle="tab">Email subcribe</a></li>
            <li role="presentation"><a href="#setting" aria-controls="setting" role="tab" data-toggle="tab">Cài đặt và gửi mail</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="email">
                <div class="row">
                    <div class="col-xs-12 col-md-12">
                        <div class="box">
                            <div class="box-header">
                                <a  href="{{ route('subcribe-email.create') }}"><button class="btn btn-primary">Thêm mới</button> </a>
                                <a href="{{ route('exportEmail') }}" class="btn btn-success">Xuất file Excel</a>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <table id="posts" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th width="5%">ID</th>
                                        <th>Email</th>
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
            </div>
            <div role="tabpanel" class="tab-pane" id="setting">
                <div class="row">
                    <div class="col-md-6 col-xs-12">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Cài đặt</h3>
                            </div>
                            <!-- /.box-header -->

                            <div class="box-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th width="5%">STT</th>
                                        <th>Tên group</th>
                                        <th>Mô tả</th>
                                        <th>Thao tác</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($groupMails as $id => $groupMail)
                                        <tr>
                                            <td>{{ ($id+1) }}</td>
                                            <td>{{ $groupMail->name }}</td>
                                            <td>{{ $groupMail->description }}</td>
                                            <td>
                                                <a  href="{{route('group_mail.destroy', ['group_mail_id' => $groupMail->group_mail_id])}}" class="btn btn-danger btnDelete" data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-body">
                                <h4 class="box-title">Thêm mới phí ship</h4>
                                <form action="{{ route('group_mail.create') }}" method="post">
                                    {!! csrf_field() !!}
                                    <div class="form-group">
                                        <label>Tên group</label>
                                        <input type="text" class="form-control" name="name" required/>
                                    </div>
                                    <div class="form-group">
                                        <label>Mô tả</label>
                                        <textarea class="form-control" name="description"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Thêm mới</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-xs-12">
                    <div class="box box-info">
                        <div class="box-header">
                            <i class="fa fa-envelope"></i>

                            <h3 class="box-title">Gửi mail</h3>
                            <!-- tools box -->
                            <!-- /. tools -->
                        </div>
                        <form action="{{ route('subcribe-email_send') }}" method="post">
                            {!! csrf_field() !!}
                            <div class="box-body">
                                <div class="form-group">
                                    <label>Chọn group</label>
                                    <select class="form-control" name="group">
                                        @foreach($groupMails as $id => $groupMail)
                                            <option value="{{ $groupMail->group_mail_id }}">{{ $groupMail->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Chọn email cấu hình (nếu chọn không cần điền ô ở dưới)</label>
                                    <select class="form-control" name="email-setting">
                                        <option>-----------------------------</option>
                                        @foreach(\App\Entity\SubPost::showSubPost('cau-hinh-email', 100) as $id => $mail)
                                            <option value="{{ $mail->slug }}">{{ $mail->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Người gửi</label>
                                    <input type="text" class="form-control" name="from" placeholder="Chủ đề">
                                </div>
                                <div class="form-group">
                                    <label>Chủ đề</label>
                                    <input type="text" class="form-control" name="subject" placeholder="Chủ đề">
                                </div>
                                <div>
                                    <label>Nội dung</label>
                                    <textarea class="editor" id="content" name="content" rows="10" cols="80" placeholder="Nội dung"/></textarea>
                                </div>

                            </div>
                            <div class="box-footer clearfix">
                                <button type="submit" class="pull-right btn btn-default" id="sendEmail">Send
                                    <i class="fa fa-arrow-circle-right"></i></button>
                            </div>
                        </form>
                    </div>
                    </div>
                </div>
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
            ajax: '{!! route('subcribe-email-data') !!}',
            columns: [
                { data: 'subcribe_email_id', name: 'subcribe_email_id' },
                { data: 'email', name: 'email' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        });
    });
</script>
@endpush

