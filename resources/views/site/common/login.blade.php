<!-- Modal -->
<div class="modal fade" id="myModalLogin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content_1">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><i class="fa fa-user" aria-hidden="true"></i> Đăng nhập</h4>
            </div>
            <form action="/dang-nhap" class="submitDelete" method="post" >
                {!! csrf_field() !!}

                <div class="modal-body clearfix">
                    <p class="notify red"></p>
                    <div class="col-xs-6">
                        <div class="form-group">
                            <input id="email" type="email" class="form-control" name="email"  placeholder="Nhập email" required autofocus>
                        </div>

                        <div class="form-group">
                            <input id="password" type="password" class="form-control" name="password" placeholder="Nhập mật khẩu" required>
                        </div>

                        <div class="form-group">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Ghi nhớ mật khẩu
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-danger">Đăng nhập</button>
                        </div>
                        <div class="form-group">
                            <a href="{{ $urlLoginFace }}" class="btn btn-primary"><i class="fa fa-facebook-square" aria-hidden="true"></i> Facebook</a>
                            <a href="{{ route('google_login') }}" class="btn btn-danger"><i class="fa fa-google-plus-square" aria-hidden="true"></i> google</a>
                        </div>

                        <div class="form-group">
                            <a class="btn btn-link" href="#" onclick="return forgetPassword(this);">
                                Quên mật khẩu?
                            </a>
                        </div>
                    </div>

                    <div class="col-xs-6">
                        <p>Nếu bạn chưa có tài khoản</p>
                        <div class="form-group mb20">
                            <a href="/dang-ky" class="col-xs-12 btn btn-primary">Đăng ký tài khoản</a> <br>
                        </div>
                        <div class="form-group">
                            <a href="{{ $urlLoginFace }}" class="btn btn-primary"><i class="fa fa-facebook-square" aria-hidden="true"></i> Facebook</a>
                            <a href="{{ route('google_login') }}" class="btn btn-danger"><i class="fa fa-google-plus-square" aria-hidden="true"></i> google</a>
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
<script>
    function forgetPassword() {
        $('#myModalForget').modal('show');
        $('#myModalLogin').modal('hide');
    }
</script>

