<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
	@if(isset($articles) && $articles->count())
		@foreach($articles as $article)
		<div class="row">
			<div class="margin-top-10">
				<hr>
				<h3><a href="{{slink::createLink('articles/'.$article->seo_url)}}">{{$article->title}}</a></h3>
				<p><span class="glyphicon glyphicon-time"></span> {{ myDateTime::SwapDotDateWithTime($article->created_at) }}</p>
				<div>
					{{$article->preview}}
				</div>
				<a href="{{slink::createLink('articles/'.$article->seo_url)}}" class="btn btn-default no-margin regular-10 uppercase pull-left btn-spinner">
					<span class="btn-response-text">Просмотр</span><i class="glyphicon glyphicon-chevron-right hidden"></i>
				</a>
			</div>
		</div>
		@endforeach
		{{ $articles->links() }}
	@endif
	</div>
</div>