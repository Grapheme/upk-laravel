<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
	@if(isset($news) && $news->count())
		@foreach($news as $new)
		<div class="row">
			<div class="margin-top-10">
				<hr>
				<h3><a href="{{slink::createLink('news/'.$new->seo_url)}}">{{$new->title}}</a></h3>
				<p><span class="glyphicon glyphicon-time"></span> {{ myDateTime::SwapDotDateWithTime($new->created_at) }}</p>
				<div>
					{{$new->preview}}
				</div>
				<a href="{{slink::createLink('news/'.$new->seo_url)}}" class="btn btn-default no-margin regular-10 uppercase pull-left btn-spinner">
					<span class="btn-response-text">Просмотр</span><i class="glyphicon glyphicon-chevron-right hidden"></i>
				</a>
			</div>
		</div>
		@endforeach
		{{ $news->links() }}
	@endif
	</div>
</div>