<h2 class="titleLote titleBlack mb50"><?= $languageSetup['tin-khuyen-mai'] ?></h2>
<div class="listNewsSideBar">
    @if (!empty($markTrade))
    @foreach (\App\Entity\Post::newPost(App\Ultility\Ultility::createSlug($markTrade), 3) as $id => $new)
    <div class="item row wow fadeInUp" data-wow-delay="0.2s">
        <div class="col-md-12 col-sm-12">
            <div class="CropImg">
                <a href="{{ route('post', ['cate_slug' => ($languageCurrent == 'vn') ? 'tin-tuc' : 'news', 'post_slug' => $new->slug, 'languageCurrent' => $languageCurrent]) }}" class="thumbs">
                    <img src="{{ !empty($new->image) ?  asset($new->image) : asset('/site/img/no_image.png') }}" alt="{{ $new->title }}"/></a>
            </div>
        </div>
        <div class="col-md-12 col-sm-12">
            <h3 class="tl">
                <a class="Color" href="{{ route('post', ['cate_slug' => ($languageCurrent == 'vn') ? 'tin-tuc' : 'news', 'post_slug' => $new->slug, 'languageCurrent' => $languageCurrent]) }}">{{ $new->title }}</a></h3>
            <div class="DateTime">
                <?php $date=date_create($new->created_at); echo date_format($date,"d/m/Y h:i:s");?>
            </div>
            <div class="except tl">{{ $new->description }}
            </div>
        </div>
    </div>
    @endforeach
    <div class="more tc"><a class="BtnBlack" href="{{ route('category', [ 'languageCurrent' => $languageCurrent, 'cate_slug' => ($languageCurrent == 'vn') ? 'tin-tuc' : 'news']) }}">{{ $languageSetup['doc-them'] }}</a></div>
    @endif
</div>
