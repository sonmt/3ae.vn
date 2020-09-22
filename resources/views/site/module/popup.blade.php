<div class="modal fade" id="popup" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <a href="{{ $information['link-popup-quang-cao'] }}"><img class="ImgPopUp" src="{{ !empty($information['anh-popup-quang-cao']) ?  asset($information['anh-popup-quang-cao']) : asset('/site/img/no_image.png') }}"/></a>
            </div>
        </div>
    </div>
</div>
<script>
    setTimeout(function() {
        $('#popup').modal('show');
        $('body').css({padding: 0});
    }, 10000);
</script>
