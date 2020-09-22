@extends('site.layout.site')


@section('title', $category->title)
@section('meta_description',  $category->description )
@section('keywords', '')

@section('content')
    @include('site.partials.menu_main', ['classHome' => ''])
    <section class="contentCategoryProduct">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-xs-12">
                    @include('site.partials.sidebar_cate_product', ['cateSlug' => $category->slug])
                </div>
                <div class="col-md-9 col-xs-12">
                     <div class="breadrum">
                         <a href="/">Trang chủ</a> <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                         <a href="/cua-hang/{{ $category->slug }}" class="active"> {{$category->title}}</a>
                     </div>
                    <div class="categoryProduct">
                        <div class="hotDeal clearfix">
                            <div class="mainTitle lineblue">
								<h1 class="titleV bgblue">
                                <i class="fa fa-cubes" aria-hidden="true"></i>{{$category->title}}
								</h1>
                            </div>
                            <!-- list item hot deal-->
                            @foreach ($products as $id => $product)
                                <div class="col-md-3 col-xs-6">
                                    <div class="item boxPro">
										<div class="CropImg CropImgP">
											<a href="{{ route('product', [ 'post_slug' => $product->slug]) }}" class="image thumbs">
												<img src="{{ !empty($product->image) ?  asset($product->image) : asset('/site/img/no_image.png') }}"
                                                     alt="{{ $product->title }}" title="{{ $product->title }}" />
												@if (!empty($product->discount))
													<span class="discountPersent">-{{ round(($product->price - $product->discount) / $product->price * 100) }}%</span>
												@endif
											</a>
										</div>
                                        <a alt="{{ $product->title }}" href="{{ route('product', [ 'post_slug' => $product->slug]) }}">
                                            <h3>{{ \App\Ultility\Ultility::textLimit($product->title, 9) }}</h3>
                                        </a>
                                        <div class="price">
                                            @if (!empty($product->discount))
                                                <span class="priceOld">{{ number_format($product->price, 0, ',', '.') }}</span>
                                                <span class="priceDiscount">{{ number_format($product->discount, 0, ',', '.') }}</span> VND
                                            @else
                                                <span class="priceDiscount">{{ number_format($product->price, 0, ',', '.') }}</span> VND
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="paginationProduct col-xs-12 col-md-12">
                                @if($products instanceof \Illuminate\Pagination\LengthAwarePaginator )
                                    {{ $products->links() }}
                                @endif
                            </div>
                        </div>
						<script>
						//Đồng bộ chiều cao các div
						$(function() {
							$('.boxPro').matchHeight();
						});
						</script>
                    </div>
                </div>
            </div>


                <div class="row">
                    <div class="menuPicture">
                    @foreach(\App\Entity\MenuElement::showMenuElementInfor('anh-menu') as $menu)
                        <div class="col-xs-3">
                            <a href="{{ $menu->url }}"><img src="{{ !empty($post->image) ?  $menu->menu_image : asset('/site/img/no_image.png') }}" alt="{{ $menu->title_show }}"
                                                            title="{{ $menu->title_show }}"/></a>
                        </div>
                    @endforeach
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
                                <div class="col-md-3 col-xs-6">
                                    <div class="item">
                                        <div class="CropImg CropImgP">
                                            <a href="{{ route('product', [ 'post_slug' => $productReaded->slug]) }}" class="image thumbs">
                                                <img src="{{ !empty($productReaded->image) ?  $productReaded->image : asset('/site/img/no_image.png') }}"
                                                        alt="{{ $productReaded->title }}" title="{{ $productReaded->title }}" />
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
                            @endforeach
                        </div>
						
                    </div>
                </div>
            </div>
            @endif
        </div>
    </section>
@endsection
