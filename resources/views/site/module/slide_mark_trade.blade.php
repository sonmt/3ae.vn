<?php $slides = \App\Entity\Post::getSlideLogo($markTrade)?>
<div id="SlideRestourant" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        @foreach ($slides as $id => $slide)
            <li data-target="#carousel-example-generic" data-slide-to="{{ $id }}" class="{{ ($id ==0 ) ? 'active' : '' }}"></li>
        @endforeach
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">
        @foreach ($slides as $id => $slide)
            <div class="item {{ ($id ==0 ) ? 'active' : '' }}">
                <a href="{{ $slide['duong-dan-slide'] }}">
                    <img src="{{ !empty($slide->image) ?  asset($slide->image) : asset('/site/img/no_image.png') }}" alt="{{ $slide->title }}" title="{{ $slide->title }}" />
                </a>
            </div>
        @endforeach
    </div>

    <!-- Controls -->
    <a class="left carousel-control" href="#SlideRestourant" role="button" data-slide="prev">
        <i class="fa fa-angle-left" aria-hidden="true"></i>
    </a>
    <a class="right carousel-control" href="#SlideRestourant" role="button" data-slide="next">
        <i class="fa fa-angle-right" aria-hidden="true"></i>
    </a>
</div>
