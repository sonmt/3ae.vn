<?php $foods = \App\Entity\Post::getFoodConer($markTrade)?>
<section class="mainEat">
    <h2 class="titleLote titleBlack mb50"><?= $languageSetup['goc-am-thuc'] ?></h2>
    <div class="row">
        <div class="col-md-8 col-xs-12 left">
            @foreach ($foods as $id => $food)
                @if ( $id == 0)
                    <div class="item hoverZoom">
                        <a href="{{ route('post', ['cate_slug' => 'goc-am-thuc', 'post_slug' => $food->slug, 'languageCurrent' => $languageCurrent]) }}"><img src="{{ asset($food->image) }}" title="{{ $food->title }}" alt="{{ $food->title }}"/></a>
                        <h3 class="PoTop">
                            {{ $food->title }}
                        </h3>
                    </div>
                @endif
            @endforeach
        </div>
        <div class="col-md-4 col-xs-12 right">
            @foreach ($foods as $id => $food)
                @if ( $id > 0)
                    <div class="item hoverZoom">
                        <a href="{{ route('post', ['cate_slug' => 'goc-am-thuc', 'post_slug' => $food->slug, 'languageCurrent' => $languageCurrent]) }}"><img src="{{ asset($food->image) }}" title="{{ $food->title }}" alt="{{ $food->title }}"/></a>
                        <h3 class="PoTop">{{ $food->title }}</h3>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</section>
