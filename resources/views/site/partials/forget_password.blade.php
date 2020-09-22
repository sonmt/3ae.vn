<!-- Modal -->
<div class="modal fade" id="myModalForget" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content_1">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><i class="fa fa-user" aria-hidden="true"></i> Quên mật khẩu</h4>
            </div>
            <form action="{{ route('forget_password') }}" class="submitDelete" method="post" >
                {!! csrf_field() !!}

                <div class="modal-body clearfix">
                    <p class="notify red"></p>
                    <div class="col-xs-12">
                        <div class="form-group">
                            <input id="email" type="email" class="form-control" name="email"  placeholder="Nhập email đăng ký" required autofocus>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Gửi</button>
                        </div>
                    </div>


                </div>
            </form>
        </div>
    </div>
</div>
<style>
    .modal-content_1 {
        background: #fff;
    }
    .modal-body {
        background: #fff;
    }
</style>
