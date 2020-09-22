<!-- Modal -->
<div class="modal fade" id="modelAddToCart" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content_1">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Đặt hàng</h4>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <a href="<?= (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>" class="btn btn-default" data-dismiss="modal">Tiếp tục mua hàng</a>
                <a href="/dat-hang" class="btn btn-primary">Giỏ hàng</a>
            </div>
        </div>
    </div>
</div>
<style>
    .modal-content_1 {
        background: #fff;
    }
    .modal-title {
        margin-top: 10px;
        margin-left: 15px;
    }
</style>
