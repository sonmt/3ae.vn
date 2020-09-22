<section class="NavSearch">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="Phone">
                    <h3>{{ $information['hotline'] }}</h3>
                    <p>{{ $information['khung-gio-lam-viec'] }}</p>
                </div>
            </div>
            <div class="col-md-8">
                <div class="Search">
                    <strong>{{ $languageSetup['tim-kiem-mon-an,-thuc-don'] }}</strong>
                    <div class="SearchFull">
                        <form action="{{ route('search', [ 'languageCurrent' => $languageCurrent] ) }}" method="get">
                        <input type="text" name="word" placeholder="{{ $languageSetup['nhap-tu-khoa'] }}"/>
                        <button type="submit" class="hvr-radial-out">{{ $languageSetup['tim-kiem'] }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
