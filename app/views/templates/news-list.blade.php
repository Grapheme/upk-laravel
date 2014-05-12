@if(isset($news) && $news->count())
    <ul class="news-list">
	@foreach($news as $new)
        <li class="news-item">
            <div class="news-cont">
                <div class="news-photo" style="background-image: url({{ $new->image }});"></div>
                <p class="news-date">{{ myDateTime::getNewsDate($new->created_at) }}</p>
                <h3 data-date="{{ myDateTime::getNewsDate($new->created_at) }}">
                    <a href="{{ URL::route('news_full', array('url' => $new->slug)) }}">{{$new->title}}</a>
                </h3>
                <div class="news-desc">
                    {{$new->preview}}
                </div>
            </div>
        </li>
	@endforeach
    </ul>
	{{ $news->links() }}
@endif