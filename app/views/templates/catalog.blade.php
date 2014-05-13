<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
	@if(isset($products) && $products->count())
		@foreach($products as $product)
		<div class="row">
			<div class="margin-top-10">
				<hr>
				<h3><a href="{{ slink::createLink('catalog/'.$product->seo_url.'-'.$product->id) }}">{{$product->title}}</a></h3>
				<div>
				@if(!empty($product->image))
					<figure class="avatar-container">
						<img src="{{url('image/catalog-product-thumbnail/'.$product->id)}}" alt="{{ $product->title }}" class="avatar bordered circle">
					</figure>
				@endif
				</div>
				<a href="{{ slink::createLink('catalog/'.$product->seo_url.'-'.$product->id) }}" class="btn btn-primary no-margin regular-10 uppercase pull-left btn-spinner">
					<span class="btn-response-text">Просмотр</span><i class="glyphicon glyphicon-chevron-right hidden"></i>
				</a>
			</div>
		</div>
		@endforeach
		{{ $products->links() }}
	@endif
	</div>
</div>