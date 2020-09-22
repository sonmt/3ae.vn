@extends('site.layout.site')

@section('title', $languageSetup['thu-vien-hinh-anh'])
@section('meta_description',  $information['meta_description'])
@section('keywords', '')

@section('content')
    <section class="viewNews wow fadeInUp slider" data-wow-offset="300">
        <div id="SlideHome" class="carousel slide" data-ride="carousel">
            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">
                @foreach(\App\Entity\SubPost::showSubPost('slide', 8) as $id => $slide)
                    <div class="item {{ ($id ==0 ) ? 'active' : '' }}">
                        <a href="<?= $slide['duong-dan-slide'] ?>">
                            <img src="{{ !empty($slide->image) ?  asset($slide->image) : asset('/site/img/no_image.png') }}"
                                 alt="{{ $slide->title }}" title="{{ $slide->title }}"/>
                        </a>
                    </div>
                @endforeach
            </div>

            <!-- Controls -->
            <a class="left carousel-control" href="#SlideHome" role="button" data-slide="prev">
                <i class="fa fa-angle-left" aria-hidden="true"></i>
            </a>
            <a class="right carousel-control" href="#SlideHome" role="button" data-slide="next">
                <i class="fa fa-angle-right" aria-hidden="true"></i>
            </a>
        </div>
        {{--end slide--}}
        <div class="mask"></div>
        <div class="RelatedNews">
            <div class="container">
                <h1 class="titleLine"><span class="line"></span><span class="title orange">{{ $languageSetup['thu-vien-hinh-anh'] }}</span><span
                            class="line"></span></h1>
            </div>
        </div>
        <div class="container">
            <div class="listNews" >
                <div id="listImage" class="mb20">
                    <div class="row listImages">
                        @foreach(\App\Entity\SubPost::showSubPost('quan-ly-hinh-anh', 6) as $id => $new)
                            <div class=" wow fadeInUp" data-wow-delay="0.2s" id="imageLibrary{{ $new->post_id }}">
                                <div class="col-md-4 col-sm-4 mb20 ">
									<div class="item">
										<div class="CropImg">
											<a href="{{ !empty($new->image) ?  asset($new->image) : asset('/site/img/no_image.png')  }}" class="Mark"></a>
											<a href="{{ !empty($new->image) ?  asset($new->image) : asset('/site/img/no_image.png') }}"
											   class="thumbs">
												<img src="{{ !empty($new->image) ?  asset($new->image) : asset('/site/img/no_image.png') }}"
													 id="imageID" alt="{{ $new->title }}" title="{{ $slide->title }}"/>
											</a>
										</div>
										<h3>{{ $new->title }}</h3>
									</div>
									
                                </div>

                                <?php $imageList = explode(',', $new['danh_sach_hinh_anh'])?>
                                @foreach ($imageList as $image)
                                    @if (!empty($image))
                                        <div style="display: none">
                                            <a href="{{ !empty($image) ?  asset($image) : asset('/site/img/no_image.png') }}">
                                                <img src="{{ !empty($image) ?  asset($image) : asset('/site/img/no_image.png') }}" alt="{{ $new->title }}" title="{{ $new->title }}"/>
                                            </a>
                                        </div>
                                    @endif
                                @endforeach

                            </div>
                            <script>
                                $('#imageLibrary{{ $new->post_id }} a:first-child').tosrus({
                                    buttons: 'inline',
                                    pagination	: {
                                        add			: true,
                                        type		: 'thumbnails'
                                    }
                                });
                            </script>
                        @endforeach

                    </div>
                </div>


                <div class="tc readMore">
                    <button onclick="return loadImageLibrary(this)" offset="6" class="BtnBlack">XEM THÊM</button>
                </div>
                <script>
                    function loadImageLibrary(e) {
                        var offset = $(e).attr('offset');

                        // gọi ajax lấy dữ liệu
                        $.ajax({
                            type: "GET",
                            url: '{!! route('next_image', ['languageCurrent' => $languageCurrent]) !!}',
                            data:{
                                offset: offset
                            },
                            success: function(data){
                                var data = jQuery.parseJSON( data);
                                $.each(data.posts, function (index, post){
                                    console.log(post)
                                    var html = '<div class=" wow fadeInUp" data-wow-delay="0.2s" id="imageLibrary'+ post.post_id +'">';
                                    html += '<div class="col-md-4 col-sm-4">';
                                    html +=    '<div class="item">';
                                    html +=        '<div class="CropImg">';
                                    html +=            '<a href="'+ post.image +'" class="thumbs" >';
                                    html +=                '<img src="'+post.image+'" alt="'+ post.title +'" title="'+post.title+'" />';
                                    html +=             '</a>';
                                    html +=         '</div>';
                                    html +=         '<h3>'+post.title+'</h3>'
                                    html +=     '</div>';
                                    html += '</div>';

                                    if (post.danh_sach_hinh_anh != undefined) {
                                        var imageList = post.danh_sach_hinh_anh.split(',');
                                        $.each(imageList, function (index, element) {
                                            if (element != undefined) {
                                                html += '<div style="display: none">';
                                                html += '<a href="' + element + '" class="thumbs">';
                                                html += '<img src="' + element + '" alt="' + post.title + '" title="' + post.title + '"/>';
                                                html += '</a>';
                                                html += '</div>'
                                            }
                                        });
                                    }

                                    html += '</div>';

                                    $('#listImage .row').append(html);

                                    $('#imageLibrary'+post.post_id+' a:first-child').tosrus({
                                        buttons: 'inline',
                                        pagination	: {
                                            add			: true,
                                            type		: 'thumbnails'
                                        }
                                    });

                                });

                                // khi hàm success trả về thì em lấy dữ liệu append vào cái row
                                if (parseInt(data.posts.length) < 6) {
                                    $(e).hide();
                                } else {
                                    $(e).attr('offset', parseInt(offset) + 6);
                                }
                            }
                        });

                        return false;

                    }
                </script>
            </div>
        </div>
		<div class="RelatedNews">
            <div class="container">
                <h2 class="titleLine"><span class="line"></span><span class="title orange">Video</span><span
                            class="line"></span></h2>
            </div>
        </div>
		<div class="container">
			<div class="listNews" >
                <div class="row wow fadeInUp" data-wow-delay="0.2s" id="videoLibrary">
                    <div class="row">
                    @foreach ($posts as $id => $new)
                            <div class="col-md-4 col-sm-4 mb20">
                                <div class="ShowVideo">
                                    <div class="Video" style="display:none;"></div>
                                    <div class="playVideo" onclick="return playVideo(this);"></div>
                                    <img src="{{ !empty($new->image) ?  asset($new->image) : asset('/site/img/no_image.png') }}" class="imageID"
                                         alt="{{ $new->title }}" title="{{ $new->title }}"/>
                                    <div class="embebbedVideo" style="display: none"z><?= $new['nhung-video'] ?></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <script type="text/javascript">
                        function playVideo(e) {
                            var embbedVideo = $(e).parent().find('.embebbedVideo').html();
                            // show and run video
                            $(e).parent().find('.Video').show();
                            $(e).parent().find('.Video').append(embbedVideo);

                            $(e).parent().find('.imageID').hide();
                            $(e).parent().find('.playVideo').hide();
                        }
                    </script>
                </div>

                <div class="pagging">
                    {{ $posts->links() }}
                </div>
			</div>
		</div>
    </section>
@endsection

