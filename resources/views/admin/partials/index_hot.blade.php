<!-- Modal -->
<div class="modal fade" id="myModalIndexhot" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
    function changeIndexHot(e) {
        var postId = $(e).attr('postId');
        var index = 0;
        if ($(e).prop('checked')) {
            index = 1;
        }
        $.ajax({
            type: "GET",
            url: '{!! route('index_hot') !!}',
            data: {
                post_id: postId,
                index_hot: index
            },
            success: function(data){
                $('#myModalIndexhot .modal-body').empty();
                if (index == 0) {
                    $('#myModalIndexhot .modal-body').append('Ẩn');
                    $('#myModalIndexhot').modal('show');

                    return true;
                }
                $('#myModalIndexhot .modal-body').append('Hiện');
                $('#myModalIndexhot').modal('show');

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
