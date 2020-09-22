<div class="sideBarContent menuProduct mb20">
    <?php echo \App\Entity\MenuElement::showMenuElementPage('menu-trong-trang-san-pham', 'sideMenu', true) ?>
</div>

<div class="filter mb20">
    <form action="/loc-san-pham" method="get" class="filterProduct">
        {!! csrf_field() !!}
        <div class="item">
            <h2 class="titleL"><span class="line"></span>Thương Hiệu</h2>
			<input type="text" class="searchIn" id="myInput" onkeyup="myFunction()" placeholder="Tìm kiếm thương hiệu..">
			<ul class="ListControl" id="Control">
            @foreach(\App\Entity\SubPost::showSubPost('thuong-hieu', 10) as $id => $subPost)
                <li class="form-control">
                    <a><input type="checkbox" value="{{ $subPost->title }}" name="mark[]"  class="itemFilter"
                    @if( !empty($_GET['mark']) && in_array($subPost->title, $_GET['mark']) >0) checked @endif/>
                    {{ $subPost->title }}</a>
                </li>
            @endforeach
			</ul>
        </div>
		<script>
			function myFunction() {
				// Declare variables
				var input, filter, ul, li, a, i;
				input = document.getElementById('myInput');
				filter = input.value.toUpperCase();
				ul = document.getElementById("Control");
				li = ul.getElementsByTagName('li');

				// Loop through all list items, and hide those who don't match the search query
				for (i = 0; i < li.length; i++) {
					a = li[i].getElementsByTagName("a")[0];
					if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
						li[i].style.display = "";
					} else {
						li[i].style.display = "none";
					}
				}
			}
		</script>
        <div class="item">
            <h2 class="titleL"><span class="line"></span>Xuất Xứ</h2>
            @foreach(\App\Entity\SubPost::showSubPost('xuat-xu', 10) as $id => $subPost)
                <div class="form-control">
                    <input type="checkbox" value="{{ $subPost->title }}" name="made_in_of[]"  class="itemFilter"
                           @if(!empty($_GET['made_in_of']) && in_array($subPost->title, $_GET['made_in_of']) >0) checked @endif />
                    {{ $subPost->title }}
                </div>
            @endforeach
        </div>

        <div class="item">
            <h2 class="titleL"><span class="line"></span>Khoảng giá</h2>
            @foreach(\App\Entity\SubPost::showSubPost('khoang-gia', 10) as $id => $subPost)
                <div class="form-control">
                    <input type="radio" value="{{ $subPost['gia-tu'] }}-{{ $subPost['den-gia'] }}" name="price_range" class="itemFilter"
                           @if(!empty($_GET['price_range']) && ($subPost['gia-tu'].'-'.$subPost['den-gia']) == $_GET['price_range']) checked @endif/>
                    {{ $subPost->title }}
                </div>
            @endforeach
        </div>
        <input type="hidden" value="{{ empty($cateSlug) ? '' : $cateSlug }}" name="slug_cate"/>
    </form>
        

</div>
<div class="sideBarContent fanpageFacebook mb20">
    <h2 class="titleV bggreen"><i class="fa fa-facebook-official" aria-hidden="true"></i>FANPAGE FACEBOOK</h2>
    <?= $information['fanpage-facebook'] ?>
</div>
<div class="sideBarContent hotDealProduct">
    <h2 class="titleV bgred"><i class="fa fa-flag-o" aria-hidden="true"></i>Hotdeal</h2>
    <div id="slideHotdeal" class="carousel slide" data-ride="carousel">
        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
            @foreach(\App\Entity\Product::showProduct('hot-deal', 4) as $id => $product)
                <div class="item @if($id ==0) active @endif productList" style="text-align: center;">
                    <div class="item">
						<div class="CropImg CropImgP">
							<a href="{{ route('product', [ 'post_slug' => $product->slug]) }}" class="image thumbs">
								<img src="{{ !empty($product->image) ?  asset($product->image) : asset('/site/img/no_image.png') }}" />
								@if (!empty($product->discount))
									<span class="discountPersent">-{{ round(($product->price - $product->discount) / $product->price * 100) }}%</span>
								@endif
							</a>
						</div>
                        <a href="{{ route('product', [ 'post_slug' => $product->slug]) }}">
                            <h3>{{ \App\Ultility\Ultility::textLimit($product->title, 10) }}</h3>
                        </a>
                        <div class="price">
                            @if (!empty($product->discount))
                                <span class="priceOld">{{ number_format($product->price, 0, ',', '.')}}</span>
                                <span class="priceDiscount">{{ number_format($product->discount, 0, ',', '.') }}</span> VND
                            @else
                                <span class="priceDiscount">{{ number_format($product->price, 0, ',', '.')}}</span> VND
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Controls -->
        <a class="left carousel-control" href="#slideHotdeal" role="button" data-slide="prev">
			<i class="fa fa-angle-left" aria-hidden="true"></i>
        </a>
        <a class="right carousel-control" href="#slideHotdeal" role="button" data-slide="next">
			<i class="fa fa-angle-right" aria-hidden="true"></i>
        </a>
    </div>
</div>
<script>
    $('.itemFilter').change(function() {
         $('.filterProduct').submit();
    });
</script>
