@if(isset($news) && $news->count())
	<ul class="news-list">
	@foreach($news as $new)
		<li class="news-item">
			<div class="news-cont">
				<h3 data-date="{{ myDateTime::getNewsDate($new->created_at) }}">{{$new->title}}</h3>
				<div class="news-desc">
					{{$new->content}}
				</div>
			</div>
		</li>
	@endforeach
	</ul>
	{{ $news->links() }}
@endif