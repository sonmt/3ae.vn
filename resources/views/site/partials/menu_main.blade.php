<div class="headMenu hidePhone {{ $classHome }}">
    <nav class="navbar navbar-default">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse headMenuTop" id="bs-example-navbar-collapse-1">
            <div class="container position">
                <?php echo \App\Entity\MenuElement::showMenuElementPage('menu-chinh', 'nav navbar-nav', true) ?>
                 <div class="cart clearfix">
                     <div class="headOrder">
                         <i class="fa fa-shopping-basket" aria-hidden="true"></i>
                         Giỏ hàng
                         <?php $countOrder = \App\Entity\Order::countOrder();?>
                         <span class="count">{{ $countOrder }}</span>
                     </div>
                     <div class="bodyOrder">
                         <div class="loading">
                         </div>
                         @if ($countOrder == 0)
                        <div class="item">
                            <div class="row">
                                <div class="col-xs-4 col-md-3"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></div>
                                <div class="col-xs-8 col-md-9">Hiện không có sản phẩm nào trong giỏ hàng</div>
                            </div>
                        </div>
                         @else
                         <?php $sumPrice = 0; ?>
                         @foreach(\App\Entity\Order::getOrderItems() as $orderItem)
                         <div class="item">
                             <div class="row">
                                 <div class="col-xs-4 col-md-3">
                                     <div class="CropImg CropImgV">
                                         <a class="thumbs" href="{{ route('product', [ 'post_slug' => $orderItem->slug]) }}">
                                             <img src="{{ !empty($orderItem->image) ?  asset($orderItem->image) : asset('/site/img/no_image.png') }}" alt="{{ $orderItem->title }}"/>
                                         </a>
                                     </div>
                                 </div>
                                 <div class="col-xs-8 col-md-9">
                                     <h4 class="title" href="{{ route('product', [ 'post_slug' => $orderItem->slug]) }}" >
                                         <a>{{ \App\Ultility\Ultility::textLimit($orderItem->title, 6) }}</a>
                                     </h4>
                                     <div class="price ">
                                         @if (!empty($orderItem->discount))
                                             <span class="priceOld">{{ number_format($orderItem->price  , 0, ',', '.') }}</span>
                                             <span class="priceDiscount">{{ number_format($orderItem->discount  , 0, ',', '.') }} VND</span>
                                         @else
                                             <span class="priceDiscount">{{ number_format($orderItem->price  , 0, ',', '.') }} VNĐ</span>
                                         @endif
                                     </div>
                                     <p>Số lượng: {{ $orderItem->quantity }}</p>
                                 </div>
                             </div>
                             <input type="hidden" value="{{ $orderItem->product_id }}" />
                             <i class="fa fa-times" aria-hidden="true" onclick="return deleteOrderItem(this)" data-loading-text=" ..."></i>
                         </div>
                         <?php $sumPrice += !empty($orderItem->discount) ? ($orderItem->discount*$orderItem->quantity) : ($orderItem->price*$orderItem->quantity) ?>
                         @endforeach
                         <div class="item">
                             <p>Tổng: <span class="priceDiscount">{{ number_format($sumPrice  , 0, ',', '.') }} VNĐ</span></p>
                             <button class="btn btn-default closeCart" >Đóng giỏ hàng</button>
                             <a href="/dat-hang" class="btn btn-primary">Thanh toán</a>
                         </div>
                         @endif
                     </div>
                 </div>
            </div>
        </div><!-- /.navbar-collapse -->
    </nav>
</div>
<script>
    $('.cart .headOrder').click (function() {
        if ($('.cart .bodyOrder').is(":visible")) {
            $('.cart .bodyOrder').hide();
        }  else {
            $('.cart .bodyOrder').show();
        }
    });
    $('.closeCart').click(function() {
        $('.cart .bodyOrder').hide();
    });
	$(document).mouseup(function(e) 
	{
		var container = $(".cart .bodyOrder");

		// if the target of the click isn't the container nor a descendant of the container
		if (!container.is(e.target) && container.has(e.target).length === 0) 
		{
			container.hide();
		}
	});
    function deleteOrderItem(e) {
        var productId = $(e).prev().val();
        $(e).button('loading');
        
        $.ajax({
            type: "get",
            url: '{!! route('deleteItemCart') !!}',
            data: {
                product_id: productId,
            },
            success: function(result){
                $(e).parent().hide();
                $(e).button('reset');
            },
            error: function(error) {
               alert('Có lỗi không thể xóa được đơn hàng.');
                $(e).button('reset');
            }

        });

        return false;
    }
</script>
