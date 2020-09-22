@extends('site.layout.site')

@section('title', $product->title )
@section('meta_description', 'noi dung meta description')
@section('keywords', 'noi dung keyword')

@section('content')
    @include('site.partials.menu_main', ['classHome' => ''])
    <div class="container">
        <div class="productContent clearfix">
            <div class="">
            <div class="breadrum">
                <a href="/">Trang chủ</a> <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                <a href="/cua-hang/san-pham"> Sản phẩm</a> <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                <a href="{{ route('product', [ 'post_slug' => $product->slug]) }}" class="active"> {{ $product->title}}</a>
            </div>

            <div class="productMainContent clearfix">
                    <div class="col-xs-12 col-md-5">
						<div class="gallery-sample">
							<ul class="recent_list">
								@if(!empty($product->image_list))
									@foreach(explode(',', $product->image_list) as $imageProduct)
									<li class="photo_container">
										<a href="{{$imageProduct}}" rel="gallerySwitchOnMouseOver: true, popupWin:'{{$imageProduct}}', useZoom: 'cloudZoom', smallImage: '{{$imageProduct}}'" class="cloud-zoom-gallery">
											<img itemprop="image" src="{{ !empty($imageProduct) ?  $imageProduct : asset('/site/img/no_image.png') }}" class="img-responsive"
											title="{{ $product->title }}"/>
										</a>
									</li>
									@endforeach
								@endif
							</ul>
							<a href="{{ $product->image }}" class="cloud-zoom" id="cloudZoom">
								<img src="{{ !empty($product->image) ?  $product->image : asset('/site/img/no_image.png') }}" alt="{{ $product->title }}"/>
							</a>
						</div>
                        @if (!empty($product->buy_together))
                        <div class="productSaleProduct">
                            <h3 class="titleL"><span class="line"></span>Sản phẩm thường mua cùng</h3>
                            <div class="underline"></div>
                            <?php $productRelatives = explode(',', $product->buy_together);  ?>
                            @if(!empty($productRelatives))
                            <form method="post" onsubmit="return addToOrder(this);">
                                {{ csrf_field() }}
                            <div class="productRelative">
                                <?php $totalPrice = 0; ?>
                                @foreach($productRelatives as $id => $productSlug)
                                    <?php $productRelative = \App\Entity\Product::detailProduct(trim($productSlug));?>
                                    <?php $totalPrice+= !empty($productRelative->discount) ? $productRelative->discount : $productRelative->price ?>
									<img class="PlusItem" src="{{ !empty($productRelative->image) ?  $productRelative->image : asset('/site/img/no_image.png') }}" />
                                    @if($id < (count($productRelatives) - 1) )
                                        +
                                    @endif
                                @endforeach

                                <div class="productOrder">
                                    <div class="priceDiscount"><span id="totalPrice">{{ number_format($totalPrice  , 0, ',', '.') }}</span> VNĐ</div>
									<button ><i class="fa fa-shopping-basket" aria-hidden="true"></i> Thêm vào giỏ</button>
                                </div>
                            </div>
                            @foreach($productRelatives as $id => $productSlug)
                                <?php $productRelative = \App\Entity\Product::detailProduct(trim($productSlug));?>
                                <div class="form-group buyAfterProduct">
                                    <input type="checkbox" class="checkBuy" onclick="return buyAfterProduct(this);" value="{{ $productRelative->image }}" name="" checked /> {{ $productRelative->title }}
                                    <input type="hidden" class="quantity" name="quantity[]" value="1" />
                                    <input type="hidden" class="product_id" name="product_id[]" value="{{ $productRelative->product_id }}">
                                    <input type="hidden" class="price"
                                           value="{{ !empty($productRelative->discount) ? $productRelative->discount : $productRelative->price }}"/>
                                    <span class="price">
										@if (!empty($productRelative->discount))
                                            <span class="priceOld">{{ number_format($productRelative->price  , 0, ',', '.') }}</span>
                                            <span class="priceDiscount">{{ number_format($productRelative->discount  , 0, ',', '.') }} VNĐ</span>
                                        @else
                                            <span class="priceDiscount">{{ number_format($productRelative->price  , 0, ',', '.') }} VNĐ</span>
                                        @endif
									</span>
                                </div>
                            @endforeach
                            </form>
                            @endif
                        </div>
                        @endif
                    </div>

                    <script>
                        function buyAfterProduct(e) {
                            var totalPrice = 0;
                            $('.buyAfterProduct').each(function(index) {
                                if ($(this).find('.checkBuy').prop('checked')) {
                                    $(this).find('.product_id').attr('name', 'quantity[]');
                                    $(this).find('.quantity').attr('name', 'product_id[]');
                                    totalPrice += parseInt($(this).find('.price').val());
                                } else {
                                    $(this).find('.product_id').removeAttr('name');
                                    $(this).find('.quantity').removeAttr('name');
                                }
                            });

                            $('#totalPrice').empty();
                            $('#totalPrice').append(totalPrice);
                        }
                        $('.owl-carousel').owlCarousel({
                            items:4,
                            lazyLoad:true,
                            loop:true,
                            margin:10
                        });
                    </script>
                    <div class="col-xs-12 col-md-7">
						<div class="viewPro">
							<h1>{{ $product->title }}</h1>
							<div class="likeAndShare mb10">
								@include('site.common.like_and_share', ['link' => route('product', [ 'post_slug' => $product->slug])])
							</div>
							<!-- Set rating -->

							<div class="prize">
								<b>Đánh giá</b>:
								<select class='rating' id='rating_<?php echo $product->post_id; ?>' data-id='rating_<?php echo $product->post_id; ?>'>
									<option value="1" {{ ($averageRating >= 0.5) ? 'selected' : '' }}>1</option>
									<option value="2" {{ ($averageRating >= 1.5) ? 'selected' : '' }}>2</option>
									<option value="3" {{ ($averageRating >= 2.5) ? 'selected' : '' }}>3</option>
									<option value="4" {{ ($averageRating >= 3.5) ? 'selected' : '' }}>4</option>
									<option value="5" {{ ($averageRating >= 4.5) ? 'selected' : '' }}>5</option>
								</select>
								<span id='avgrating_<?php echo $product->post_id; ?>'><?php echo $averageRating; ?></span>
								Có {{ $sumRating }} người dùng đánh giá
								<script type='text/javascript'>
                                    $(document).ready(function(){
                                        $('#rating_{!! $averageRating !!}').barrating('set', {!! $averageRating !!} );
                                        
                                        $('.rating').barrating({
                                            theme: 'fontawesome-stars',
                                            onSelect: function(value, text, event) {
                                                // Get element id by data-id attribute
                                                var el = this;
                                                var el_id = el.$elem.data('id');

                                                // rating was selected by a user
                                                if (typeof(event) !== 'undefined') {

                                                    var split_id = el_id.split("_");

                                                    var postid = split_id[1]; // postid

                                                    // AJAX Request
                                                    $.ajax({
                                                        url: '{!! route('rating') !!}',
                                                        type: 'get',
                                                        data: {postid:postid,rating:value},
                                                        dataType: 'json',
                                                        success: function(data){
                                                            // Update average
                                                            var average = parseFloat(data['averageRating']);
                                                            $('#avgrating_'+postid).text(average.toFixed(2));
                                                        }
                                                    });
                                                }
                                            }
                                        });
                                    });
								</script>
							</div>

							<div class="price mb10">
								Giá:
								@if (!empty($product->discount))
									<span class="priceOld">{{ number_format($product->price  , 0, ',', '.') }}</span>
									<span class="priceDiscount">{{ number_format($product->discount  , 0, ',', '.') }} VNĐ</span>
								@else
									<span class="priceDiscount">{{ number_format($product->price  , 0, ',', '.') }} VNĐ</span>
								@endif
								Tiết kiệm: <span class="priceDiscount">{{ round(($product->price - $product->discount) / $product->price * 100) }}%</span>
							</div>
							<p>Mã sản phẩm: {{ $product->code }}</p>
							<p>Xuất xứ: {{ $product['xuat-xu'] }}</p>
							<p>Hãng sản xuất: {{ $product['hang-san-xuat'] }}</p>
							<p>Tình trạng: {{ ($product['so-luong-trong-kho'] == 0) ? 'Hết hàng' : 'Còn hàng' }}</p>
							<p class="properties"><?= $product->properties ?></p>
							<div class="productDescription">
								<h3 class="titleL"><span class="line"></span>Mô tả</h3>
								<p><?= $product->description ?></p>
							</div>

							<div class="selectOrder">
								<form method="post" onsubmit="return addToOrder(this);">
									{{ csrf_field() }}
									<div class="form-group">
										<label>Chọn số lượng</label>
										<input type="number" name="quantity[]" value="1" />
										<input type="hidden" name="product_id[]" value="{{ $product->product_id }}">
										<button type="submit" class="btn btn-danger"><i class="fa fa-shopping-basket" aria-hidden="true"></i> Thêm vào giỏ hàng</button>
										<div class="phoneSupport">
											<span>{{ $information['so-dien-thoai'] }}</span>
										</div>
									</div>
								</form>
							</div>
							<div class="productSaleShip">
								<h3 class="titleL"><span class="line"></span>Bảng giá vận chuyển</h3>
								<div class="underline"></div>
								<p><?= $information['bang-gia-chi-tiet-van-chuyen-san-pham'] ?></p>
							</div>
						</div>
					</div>
				</div>
            </div>

            @if (!empty($product->buy_after))
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <div class="productSaleProduct productAfter clearfix">
                        <h3 class="titleL"><span class="line"></span>Sản phẩm thường mua sau đó</h3>
                        <div class="underline"></div>
                        <?php $productRelatives = explode(',', $product->buy_after);  ?>
                        @foreach($productRelatives as $id => $productSlug)
                            <?php $productRelative = \App\Entity\Product::detailProduct($productSlug);?>
                            <div class="item col-md-4 col-xs-12">
                                <img src="{{ !empty($productRelative->image) ?  $productRelative->image : asset('/site/img/no_image.png') }}" alt="{{ $productRelative->title }}"/>
                                <h3>{{ $productRelative->title }}</h3>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
             @endif

            <div class="row">
                <div class="col-xs-12 col-md-9">
                    <div class="sideBarContent mainContent clearfix">
						<div class="mainTitle lineblue">
							<h3 class="titleV bgblue"><i class="fa fa-newspaper-o" aria-hidden="true"></i>Thông tin sản phẩm</h3>
						</div>
						<div class="contentView">
							<div class="Content closed"><?= $product->content ?>
							</div>
							<div class="readMore"><span>Mở rộng</span></div>
							<p>Tag:
								@if(!empty($product->tags))
									@foreach(explode(',', $product->tags) as $tag)
											<a href="/tim-kiem?word={{ $tag }}&category=all"><span class="tag">{{ $tag }},</span></a>
									@endforeach
								@endif
							</p>
							<div class="likeAndShare">
							@include('site.common.like_and_share', ['link' => route('product', [ 'post_slug' => $product->slug])])
							</div>
						</div>
						<script>
							var height = $('.productContent .mainContent .contentView .Content').height();
							if(height < 450) {
								$('.contentView .readMore').hide();
							} else {
								$('.contentView .readMore').show();
							}
							$('.contentView .readMore span').click(function(){
								if($('.contentView .Content').hasClass('closed')){
									$('.contentView .Content').removeClass('closed');
									$('.contentView .readMore span').html('Thu gọn');
								}
								else {
									$('.contentView .Content').addClass('closed');
									$('.contentView .readMore span').html('Mở rộng');
								}
							});
						</script>
						<div class="MoreProduct">
							<div class="GroupBtnP">
								<span class="price">
									Giá: 
									@if (!empty($product->discount))
										<span class="priceOld">{{ number_format($product->price  , 0, ',', '.') }}</span>
										<span class="priceDiscount">{{ number_format($product->discount  , 0, ',', '.') }} VNĐ</span>
									@else
										<span class="priceDiscount">{{ number_format($product->price  , 0, ',', '.') }} VNĐ</span>
									@endif
								</span>
								<form method="post" onsubmit="return addToOrder(this);">
									{{ csrf_field() }}
									<input type="hidden" class="quantity" name="quantity[]" value="1" />
									<input type="hidden" class="product_id" name="product_id[]" value="{{ $product->product_id }}">
									<button type="submit" class="btn btn-danger"><i class="fa fa-shopping-basket" aria-hidden="true"></i> Thêm vào giỏ hàng</button>
								</form>
								<div class="slogan">Giao hàng tận nơi, Thanh toán khi nhận hàng </div>
							</div>
							<div class="SaleShip">
								<p><?= $information['bang-gia-chi-tiet-van-chuyen-san-pham'] ?></p>
							</div>
						</div>
                        <div class="contentView clearfix">
                            <h3 class="titleL"><span class="line"></span>Ý kiến khách hàng</h3>
                            <div class="underline"></div>
                            @include('site.partials.comment', ['post_id' => $product->post_id] )
                        </div>

                        <div class="productRelative hotDeal clearfix">
                            <h3 class="titleL"><span class="line"></span>Sản phẩm liên quan</h3>
                            <div class="underline"></div>
                            @foreach (\App\Entity\Product::relativeProduct($product->slug) as $id => $productRelative)
                                <div class="col-md-3 col-xs-6">
                                    <div class="item">
										<div class="CropImg CropImgP">
											<a href="{{ route('product', [ 'post_slug' => $productRelative->slug]) }}" class="image thumbs">
												<img src="{{ !empty($productRelative->image) ?  $productRelative->image : asset('/site/img/no_image.png') }}" />
												@if (!empty($productRelative->discount))
													<span class="discountPersent">-{{ round(($productRelative->price - $productRelative->discount) / $productRelative->price * 100) }}%</span>
												@endif
											</a>
										</div>
                                        <a href="{{ route('product', [ 'post_slug' => $productRelative->slug]) }}">
                                            <h3>{{ $productRelative->title }}</h3>
                                        </a>
                                        <div class="price">
                                            @if (!empty($productRelative->discount))
                                                <span class="priceOld">{{ number_format($productRelative->price  , 0, ',', '.') }}</span>
                                                <span class="priceDiscount">{{ number_format($productRelative->discount  , 0, ',', '.') }}</span> VNĐ
                                            @else
                                                <span class="priceDiscount">{{ number_format($productRelative->price  , 0, ',', '.') }}</span> VNĐ
                                            @endif
                                        </div>
										<form method="post" onsubmit="return addToOrder(this);">
											{{ csrf_field() }}
											<input type="hidden" class="quantity" name="quantity[]" value="1" />
											<input type="hidden" class="product_id" name="product_id[]" value="{{ $productRelative->product_id }}">
											<div class="productOrder">
												<button ><i class="fa fa-shopping-basket" aria-hidden="true"></i> Thêm vào giỏ</button>
											</div>
										</form>
                                    </div>

                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-xs-12">
                    <div class="productRunSale sideBarContent clearfix">
                        <h3 class="titleV bggreen"><i class="fa fa-cubes" aria-hidden="true"></i>Sản phẩm bán chạy</h3>
						<div class="row">
							<div class="ProSidebar">
							@foreach(\App\Entity\Product::showProduct('hot-deal', 4) as $id => $productRunSale)
								<div class="col-md-6 col-xs-12">
									<div class="item boxH4">
										<div class="CropImg CropImgP">
											<a href="{{ route('product', [ 'post_slug' => $productRunSale->slug]) }}" class="image thumbs">
												<img src="{{ !empty($productRunSale->image) ?  asset($productRunSale->image) : asset('/site/img/no_image.png') }}" />
												@if (!empty($productRunSale->discount))
													<span class="discountPersent">-{{ round(($productRunSale->price - $productRunSale->discount) / $productRunSale->price * 100) }}%</span>
												@endif
											</a>
										</div>
										<a href="{{ route('product', [ 'post_slug' => $productRunSale->slug]) }}">
											<h4>{{ $productRunSale->title }}</h4>
										</a>
									</div>
								</div>
							@endforeach
							</div>
						</div>
                    </div>
					<script>
					//Đồng bộ chiều cao các div
					$(function() {
							$('.boxH4').matchHeight();
						});
					</script>
                    <div class="blogNew clearfix mb20">
                        <h3 class="titleV bgpink"><i class="fa fa-newspaper-o" aria-hidden="true"></i>Blog</h3>
						<ul class="sideNews">
                        @foreach (\App\Entity\Post::newPost('blog') as $id => $new)
                            <li class="item">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <div class="CropImg CropImgV">
											<a class="thumbs" href="{{ route('post', ['cate_slug' => 'blog', 'post_slug' => $new->slug]) }}">
											<img src="{{ !empty($new->image) ?  asset($new->image) : asset('/site/img/no_image.png') }}" alt="{{ $new->title }}"/>
											</a>
										</div>
									</div>
                                    <div class="col-xs-9">
                                        <h4><a href="{{ route('post', ['cate_slug' => 'blog', 'post_slug' => $new->slug]) }}">{{ \App\Ultility\Ultility::textLimit($new->title, 15) }}</a></h4>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                        </ul>
                    </div>

                    <div class="sideBarContent comment clearfix mb20">
						<h3 class="titleV bgorange"><i class="fa fa-comments" aria-hidden="true"></i> Bình luận mới</h3>
						@foreach(\App\Entity\Comment::getCommentHome() as $id => $comment)
						<div class="item">
							<p class="name">{{ $comment->user_full_name }}</p>
							<p class="link"><a href="{{ ($comment->post_type == 'post') ? route('post', ['cate_slug' => 'blog', 'post_slug' => $comment->slug]) :  route('product', [ 'post_slug' => $comment->slug]) }}">
									{{ $comment->title }}</a></p>
							<p class="content"><i>"{{ $comment->content }}"</i></p>
						</div>
						@endforeach
					</div>
                </div>
            </div>
        </div>
		@if(!empty($productSeen))
        <div class="row">
            <div class="col-xs-12">
                <div class="ProductReaded">
                    <div class="hotDeal clearfix">
                        <div class="mainTitle linegreen">
                            <h2 class="titleV bggreen"><i class="fa fa-cubes" aria-hidden="true"></i>Sản phẩm đã xem</h2>
                        </div>
                        <!-- list item hot deal-->
                        @foreach ($productSeen as $id => $productReaded)
							@if ($productReaded->product_id != $product->product_id)
                            <div class="col-md-2 col-xs-6">
                                <div class="item">
									<div class="CropImg">
										<a href="{{ route('product', [ 'post_slug' => $productReaded->slug]) }}" class="image thumbs">
											<img src="{{ !empty($productReaded->image) ?  asset($productReaded->image) : asset('/site/img/no_image.png') }}" />
											@if (!empty($productReaded->discount))
												<span class="discountPersent">-{{ round(($productReaded->price - $productReaded->discount) / $productReaded->price * 100) }}%</span>
											@endif
										</a>
									</div>
                                    <a href="{{ route('product', [ 'post_slug' => $productReaded->slug]) }}">
                                        <h3>{{ $productReaded->title }}</h3>
                                    </a>
                                    <div class="price">
                                        @if (!empty($productReaded->discount))
                                            <span class="priceOld">{{ number_format($productReaded->price  , 0, ',', '.') }}</span>
                                            <span class="priceDiscount">{{ number_format($productReaded->discount  , 0, ',', '.') }}</span> VNĐ
                                        @else
                                            <span class="priceDiscount">{{ number_format($productReaded->price  , 0, ',', '.') }}</span> VNĐ
                                        @endif
                                    </div>
                                </div>
                            </div>
							@endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
@endsection
