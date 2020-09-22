<div class="RelatedNews">
    <div class="container">
        <ul class="nav nav-tabs navTab" id="tabBar" role="tablist">
            <li role="presentation" class="active"><a href="#tab1" aria-controls="home" role="tab" data-toggle="tab">{{ $languageSetup['tin-moi-nhat'] }}</a></li>
            <li role="presentation"><a href="#tab2" aria-controls="home" role="tab" data-toggle="tab">{{ $languageSetup['tin-noi-bat'] }}</a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="tab1">
                <div class="row">
                    <div class="listRelate">
                        @foreach (\App\Entity\Post::newPost('tin-tuc', 4) as $id => $new)
                            <div class="col-md-3 col-sm-6 itemm">
                                <a href="{{ route('post', ['cate_slug' => 'tin-tuc', 'post_slug' => $new->slug, 'languageCurrent' => $languageCurrent]) }}">
                                    <img src="{{ !empty($new->image) ?  asset($new->image) : asset('/site/img/no_image.png') }}" title="{{ $new->title }}" alt="{{ $new->title }}"/>
                                    <h3>{{ $new->title }}</h3>
                                </a>
                            </div>
                        @endforeach
						<div class="clear"></div>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="tab2">
                <div class="row">
                    <div class="listRelate">
                        @foreach (\App\Entity\Post::newPost('tin-noi-bat', 4) as $id => $new)
                            <div class="col-md-3 col-sm-6 itemm">
                                <a href="{{ route('post', ['cate_slug' => 'tin-noi-bat', 'post_slug' => $new->slug, 'languageCurrent' => $languageCurrent]) }}">
                                    <img src="{{ !empty($new->image) ?  asset($new->image) : asset('/site/img/no_image.png') }}" title="{{ $new->title }}" alt="{{ $new->title }}"/>
                                    <h3>{{ $new->title }}</h3>
                                </a>
                            </div>
                        @endforeach
						<div class="clear"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
