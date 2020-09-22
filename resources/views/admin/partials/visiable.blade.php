<!-- Modal -->
<div class="modal fade" id="myModalVisiable" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content_1">
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
<script>
    function visiablePost(e) {
        var postId = $(e).val();
        var visiable = 1;
        if ($(e).prop('checked')) {
            visiable = 0;
        }
        $.ajax({
            type: "GET",
            url: '{!! route('visable_post') !!}',
            data: {
                post_id: postId,
                visiable: visiable
            },
            success: function(data){
                $('#myModalVisiable .modal-body').empty();
                if (visiable == 1) {
                    $('#myModalVisiable .modal-body').append('Ẩn');
                    $('#myModalVisiable').modal('show');

                    return true;
                }
                $('#myModalVisiable .modal-body').append('Hiện');
                $('#myModalVisiable').modal('show');

                return true;
            }
        });
        return true;
    }
</script>
<style>
    .modal-content_1 {
        background: #fff;
    }
</style>
