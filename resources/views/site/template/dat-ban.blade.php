@extends('site.layout.site')

@section('title', $information['meta_title'])
@section('meta_description', $information['meta_description'])
@section('keywords', $information['meta_keyword'])

@section('content')
    <section class="bgPageFull">
        <img src="{{ asset($category->image) }}" class="bgPage">
        <div class="mask"></div>
        <div class="ContentSetdesk">
            <div class="container">
                <h1 class="titleLine"><span class="line"></span><span class="title orange">{{ $category->title }}</span><span class="line"></span></h1>
                <div class="SetDeskFull row">
                    <div class="col-md-4">
                        <div class="FormSetDesk">
                            <div class="Except row mb10">
                                {{ $languageSetup['thong-bao-dien-form'] }}
                            </div>
                            <form action="{{ route('sub_book', [ 'languageCurrent' => $languageCurrent]) }}" method="post" class="form-horizontal">
                                {!! csrf_field() !!}
                                <div class="form-group">
                                    <label class="control-label tl mb10" for="exampleInputAmount">{{ $languageSetup['ten-khach-hang'] }} <font color="red">(*)</font>:</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="exampleInputAmount" name="name" placeholder="{{ $languageSetup['ten-khach-hang'] }}" required/>
                                        <div class="input-group-addon"><i class="fa fa-user-circle" aria-hidden="true"></i></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label tl mb10" for="exampleInputAmount">{{ $languageSetup['dia-chi'] }}:</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="exampleInputAmount" name="address" placeholder="{{ $languageSetup['dia-chi'] }}"/>
                                        <div class="input-group-addon"><i class="fa fa-map-marker" aria-hidden="true"></i></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label tl mb10" for="exampleInputAmount">{{ $languageSetup['dien-thoai'] }}<font color="red">(*)</font>:</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="exampleInputAmount" name="phone" placeholder="{{ $languageSetup['dien-thoai'] }}"  required />
                                        <div class="input-group-addon"><i class="fa fa-phone" aria-hidden="true"></i></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label tl mb10" for="exampleInputAmount">Email:</label>
                                    <div class="input-group">
                                        <input type="email" class="form-control" id="exampleInputAmount" name="email" placeholder="Email" />
                                        <div class="input-group-addon"><i class="fa fa-envelope" aria-hidden="true"></i></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label tl mb10" for="exampleInputAmount">{{ $languageSetup['thoi-gian-tiec'] }}:</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="time" id="datepicker"  placeholder="{{ $languageSetup['thoi-gian-tiec'] }}"/>
                                        <div class="input-group-addon"><i class="fa fa-calendar-minus-o" aria-hidden="true"></i></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label tl mb10" for="exampleInputAmount">{{ $languageSetup['chon-nha-hang'] }}<font color="red">(*)</font>:</label>
                                    <div class="input-group">
                                        <select class="form-control" name="restaurant" required>
											<option value=""></option>
                                           @foreach (\App\Entity\SubPost::showSubPost('quan-li-dia-diem', 30) as $markTrade)
                                                <option value="{{ $markTrade->title }}: {{ $markTrade['dia-chi-nha-hang'] }};, {{ $markTrade['email-nha-hang'] }}">{{ $markTrade->title }}: {{ $markTrade['dia-chi-nha-hang'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">

                                    <div style="padding: 0;margin: 0">{!! Recaptcha::render() !!}</div>
                                </div>
                                <div class="form-group" style="color: red;">
                                    @if ($errors->has('g-recaptcha-response'))
                                        <label for="exampleInputEmail1">{{ $errors->first('g-recaptcha-response') }}</label>
                                    @endif
                                </div>

                                <div class="form-group tr">
                                    <button type="submit" class="btn hvr-radial-out btnDefault">{{ $languageSetup['dat-tiec'] }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-8 borLeft">
                        <div class="listNews ">
                            @foreach ($posts as $post)
                                <?php $date=date_create($post->created_at);?>
                            <div class="itemList row wow fadeInUp" data-wow-delay="0.2s">
                                <div class="DatePosition">
                                    <span>{{ date_format($date,"d") }}</span><br>tháng {{ date_format($date,"m") }}
                                </div>
                                <div class="col-md-12 mb10">
                                    <a href="{{ route('post', ['cate_slug' => $category->slug, 'post_slug' => $post->slug, 'languageCurrent' => $languageCurrent]) }}" class="thumbs">
                                        <img src="{{ !empty($post->image) ?  asset($post->image) : asset('/site/img/no_image.png') }}" title="{{ $post->title }}" alt="{{ $post->title }}"/>
                                    </a>
                                </div>
                                <div class="col-md-12">
                                    <h3 class="tl"><a href="{{ route('post', ['cate_slug' => $category->slug, 'post_slug' => $post->slug, 'languageCurrent' => $languageCurrent]) }}">{{ $post->title }}</a></h3>
                                    <div class="DateTime">
                                        <i class="fa fa-user-circle" aria-hidden="true"></i>&nbsp;3aegroup
                                    </div>
                                    <div class="except tl">
                                        {{ $post->description }}
                                    </div>
                                    <div class="more tl"><a class="BtnBlack" href="{{ route('post', ['cate_slug' => $category->slug, 'post_slug' => $post->slug, 'languageCurrent' => $languageCurrent]) }}">{{ $languageSetup['doc-them'] }}</a></div>
                                </div>
                            </div>
                            @endforeach

                            <div class="pagging">
                               {{ $posts->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

