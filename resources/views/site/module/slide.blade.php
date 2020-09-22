<section class="slider">
	<div id="SlideHome" class="carousel slide" data-ride="carousel">
	  <!-- Wrapper for slides -->
		<div class="carousel-inner" role="listbox">
		@foreach(\App\Entity\SubPost::showSubPost('slide', 8) as $id => $slide)
			<div class="item {{ ($id ==0 ) ? 'active' : '' }}">
				<a href="<?= $slide['duong-dan-slide'] ?>">
					<img src="{{ !empty($slide->image) ?  asset($slide->image) : asset('/site/img/no_image.png') }}" alt="{{ $slide->title }}">
				</a>
			</div>
		@endforeach
		</div>

	  <!-- Controls -->
		<a class="left carousel-control" href="#SlideHome" role="button" data-slide="prev">
			<i class="fa fa-angle-left" aria-hidden="true"></i>
		</a>
		<a class="right carousel-control" href="#SlideHome" role="button" data-slide="next">
			<i class="fa fa-angle-right" aria-hidden="true"></i>
		</a>
	</div>

</section>
