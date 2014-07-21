@extends('templates.default')
@section('style')
	<link rel="stylesheet" href="/css/fotorama.css">
@stop
@section('content')

<main class="container news">
    <div class="news-list news-one">
        <div class="news-item">
            <div class="news-cont">
                <p class="news-date">{{ date("d/m/Y", strtotime($new->published_at)) }}</p>
                <h1>
                    {{$news->title}}
                </h1>
                @if (is_object($gall))
                <div class="fotorama" data-nav="false" data-width="100%" data-fit="contain">
				@foreach($gall->photos as $photo)
                    <img src="{{ $photo->path() }}">
                @endforeach
                </div>
                @endif
                <div class="news-desc">
                     {{ sPage::content_render($news->content) }}
                </div>
            </div>
        </div>
    </div>
</main>

@stop
@section('scripts')
    <script src="/js/vendor/fotorama.js"></script>
@stop