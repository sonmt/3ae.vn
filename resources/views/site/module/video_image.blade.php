<section class="videoImg wow fadeInUp" data-wow-offset="300">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <h2 class="titleLote titleBlack mb50"><span class="line bgred"></span>Video</h2>
                <div class="ShowVideo">
                    <div id="Video" style="display:none;"></div>
                    <div class="playVideo"></div>
                    @foreach (\App\Entity\SubPost::showSubPost('quan-ly-video', 1) as $id => $new)
                    <img src="{{ !empty($new->image) ?  asset($new->image) : asset('/site/img/no_image.png') }}" id="imageID" alt="{{ $new->title }}" title="{{ $new->title }}" />
                    <script type="text/javascript">
                        $('.playVideo').click(function() {
                            $('#Video').show();
                            $('#Video').append('{!! $new['nhung-video'] !!}');
                            $('#imageID').hide();
                            $('.playVideo').hide();
                        });
                    </script>
                    @endforeach
                </div>
            </div>

            <div class="col-md-5 listImg" id="listImage">
                <h2 class="titleLote titleBlack mb50"><span class="line bgred"></span>{{ $languageSetup['hinh-anh'] }} <span class="red">{{ $languageSetup['nha-hang'] }}</span></h2>
                <div class="row">
                    @foreach (\App\Entity\SubPost::showSubPost('quan-ly-hinh-anh', 9) as $id => $new)
                    <div class="col-md-4 col-xs-6 item">
                        <div class="CropImg">
                            <a href="{{ asset($new->image) }}" class="Mark"></a>
                            <a class="thumbs" href="{{ asset($new->image) }}">
                                <img src="{{ !empty($new->image) ?  asset($new->image) : asset('/site/img/no_image.png') }}" alt="{{ $new->title }}" title="{{ $new->title }}" />
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <script>
                $('#listImage a:first-child').tosrus({
                    buttons: 'inline',
                    pagination	: {
                        add			: true,
                        type		: 'thumbnails'
                    }
                });
            </script>
            <div>
            </div>
</section>
