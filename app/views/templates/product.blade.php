@extends('templates.default')
@section('style')
<link rel="stylesheet" href="{{ slink::path('css/fancybox.css') }}" />
@stop
@section('content')
	<article class="news row margin-bottom-40">
		<section class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
			<h2 class="regular-20">{{ $product->title }}</h2>
			<div class="main-new">
				<div style="background: url({{ url('image/catalog-product/'.$product->id) }}) no-repeat 0 0 / cover;" class="new-head relative">
				@if(!empty($product->price))
					<h3 class="new-capt">Цена: {{ $product->price }} руб.</h3>
				@endif
				</div>
			</div>
		</section>
	@if(!empty($product->attributes))
		<section class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
			<h3 class="regular-20">Свойства товара</h3>
			<ul class="news-list list-unstyled regular-12 margin-bottom-10">
			@foreach($product->attributes as $attrLable => $attrValue)
				<li class="news-item margin-bottom-10">
					<div class="news-text">
						{{ $attrLable }}: {{ $attrValue }}
					</div>
				 </li>
			@endforeach
			</ul>
		</section>
	@endif
	@if(!empty($product->images))
		<section class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
			<h3 class="regular-20">Изображения товара</h3>
			<ul class="artcl-list list-unstyled regular-12 margin-bottom-10">
			@foreach($product->images as $image)
				<li class="news-item margin-bottom-10">
					<a class="fancybox" rel="group" data-fancybox-type="image" href="{{ url('image/slider-image/'.$image->id) }}" alt="{{ $image->title }}">
						<img alt="" src="{{ url('image/slider-image-thumbnail/'.$image->id) }}">
					</a>
				</li>
			@endforeach
			</ul>
		</section>
	@endif
	</article>
	<article class="news row margin-top-20">
		<section class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			{{ sPage::content_render($product->description) }}
		</section>
	</article>
@stop
@section('scripts')
<script src="{{ slink::path('js/vendor/jquery.fancybox.pack.js') }}"></script>
<script type="text/javascript">
	$(".fancybox").fancybox({type : "image",padding: 15,helpers: {overlay: {locked: false}}});
</script>
@stop