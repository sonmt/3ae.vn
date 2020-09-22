<section class="SetDesk wow fadeInUp" data-wow-offset="300">
    <img class="bgSetDesk" src="{{ !empty($information['background-dat-tiec']) ?  asset($information['background-dat-tiec']) : asset('/site/img/no_image.png') }}"/>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-xs-12">
                <h2 class="titleLote white"><span class="line"></span>{{ $languageSetup['dat-tiec'] }}</h2>
                <div class="FormSetDesk">
					
                    <form action="{{ route('sub_book', [ 'languageCurrent' => $languageCurrent]) }}" method="post" class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-12 control-label tl" for="exampleInputAmount">{{ $languageSetup['thong-bao-dien-form'] }}</label>
                        </div>
						{!! csrf_field() !!}
                        <div class="form-group">
                            <label class="col-sm-4 control-label tl" for="exampleInputAmount">{{ $languageSetup['ten-khach-hang'] }} <font color="red">(*)</font>:</label>
                            <div class="input-group col-sm-8">
                                <input type="text" class="form-control" id="exampleInputAmount" name="name" placeholder="{{ $languageSetup['ten-khach-hang'] }}" required/>
                                <div class="input-group-addon"><i class="fa fa-user-circle" aria-hidden="true"></i></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label tl" for="exampleInputAmount">{{ $languageSetup['dia-chi'] }}:</label>
                            <div class="input-group col-sm-8">
                                <input type="text" class="form-control" id="exampleInputAmount" name="address" placeholder="{{ $languageSetup['dia-chi'] }}"
                                       />
                                <div class="input-group-addon"><i class="fa fa-map-marker" aria-hidden="true"></i></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label tl" for="exampleInputAmount">{{ $languageSetup['dien-thoai'] }} <font color="red">(*)</font>:</label>
                            <div class="input-group col-sm-8">
                                <input type="text" class="form-control" id="exampleInputAmount" name="phone" placeholder="{{ $languageSetup['dien-thoai'] }}"  required />
                                <div class="input-group-addon"><i class="fa fa-phone" aria-hidden="true"></i></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-4 control-label tl" for="exampleInputAmount">Email:</label>
                            <div class="input-group col-sm-8">
                                <input type="email" class="form-control" id="exampleInputAmount" name="email" placeholder="Email"/>
                                <div class="input-group-addon"><i class="fa fa-envelope" aria-hidden="true"></i></div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-4 control-label tl" for="exampleInputAmount">{{ $languageSetup['thoi-gian-tiec'] }}:</label>
                            <div class="input-group col-sm-8">
                                <input type="text" class="form-control" name="time" id="datepicker"  placeholder="{{ $languageSetup['thoi-gian-tiec'] }}" >
                                <div class="input-group-addon"><i class="fa fa-calendar-minus-o" aria-hidden="true"></i></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label tl" for="exampleInputAmount">{{ $languageSetup['chon-nha-hang'] }}<font color="red">(*)</font>:</label>
                            <div class="input-group col-sm-8">
                                <select class="form-control" name="restaurant" required>
									<option value=""></option>
                                    @foreach (\App\Entity\SubPost::showSubPost('quan-li-dia-diem', 30) as $markTrade)
                                        <option value="{{ $markTrade->title }}:{{ $markTrade['dia-chi-nha-hang'] }};, {{ $markTrade['email-nha-hang']}}">{{ $markTrade->title }}: {{ $markTrade['dia-chi-nha-hang'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-4"></div>
                            <div class="col-sm-8" style="padding: 0;margin: 0">{!! Recaptcha::render() !!}</div>
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
            <div class="col-md-6 col-xs-12">
                <div class="sliderSetDesk">
                    <div id="slideSetdesk" class="carousel slide carousel-fade" data-ride="carousel">
                        <!-- Indicators -->
                        <ol class="carousel-indicators">
                            <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                            <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                            <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                        </ol>

                        <!-- Wrapper for slides -->
                        <div class="carousel-inner" role="listbox">
                            @foreach(\App\Entity\SubPost::showSubPost('slide-muc-dat-tiec', 8) as $id => $slide)
                            <div class="item {{ ($id == 0) ? 'active' : ''}}">
                                <a href="{{ $slide['duong-dan-slide'] }}">
                                    <img src="{{ !empty($slide->image) ?  asset($slide->image) : asset('/site/img/no_image.png') }}" alt="{{ $slide->title }}" title="{{ $slide->title }}" />
                                </a>
                                <div class="carousel-caption">
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- Controls -->
                        <a class="left carousel-control" href="#slideSetdesk" role="button" data-slide="prev">
                            <img src="{{ asset('site/img/iconPrev.png') }}"/>
                        </a>
                        <a class="right carousel-control" href="#slideSetdesk" role="button" data-slide="next">
                            <img src="{{ asset('site/img/iconNext.png') }}"/>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
