<!-- Modal -->
<div class="modal fade" id="myModalDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content_1">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Bạn có chắc chắn muốn xóa?</h4>
            </div>
            <form action="/xoa-binh-luan" class="submitDelete" method="post" >
                {!! csrf_field() !!}
                <input type="hidden" name="comment_id" class="comment_id"/>
                <input type="hidden" name="url_curent" value="<?= (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>"/>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Xóa</button>
                </div>
            </form>
        </div>
    </div>
</div>
 <script>
     function submitDeleteComment(e) {
         var commentId = $(e).prev().val();

         $('.submitDelete').find('.comment_id').val(commentId);
         return false;
     }
 </script>
<style>
    .modal-content_1 {
        background: #fff;
    }
</style>
