<section class="NewsHome wow fadeInUp" data-wow-offset="300">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <h2 class="titleLote titleBlack mb50"><span class="line bgred"></span>{{ $languageSetup['tin-tuc'] }} <span class="red">{{ $languageSetup['nha-hang'] }}</span></h2>
            </div>
            @foreach (\App\Entity\Post::newPost('tin-tuc', 3) as $id => $new)
            <div class="col-md-3">
                <div class="CropImg">
                    <a href="{{ route('post', ['cate_slug' => 'tin-tuc', 'post_slug' => $new->slug, 'languageCurrent' => $languageCurrent]) }}" class="Mark"></a>
                    <a class="thumbs" href="{{ route('post', ['cate_slug' => 'tin-tuc', 'post_slug' => $new->slug, 'languageCurrent' => $languageCurrent]) }}">
                        <img src="{{ !empty($new->image) ?  asset($new->image) : asset('/site/img/no_image.png') }}" title="{{ $new->title }}" alt="{{ $new->title }}" />
                    </a>
                </div>
                <h3><a class="thumbs" href="{{ route('post', ['cate_slug' => 'tin-tuc', 'post_slug' => $new->slug, 'languageCurrent' => $languageCurrent]) }}">
                        {{ $new->title }}
                    </a></h3>
                <div class="Except">{{ $new->description }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>
