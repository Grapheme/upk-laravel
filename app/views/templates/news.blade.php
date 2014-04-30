@extends('templates.default')
@section('style')

@stop
@section('content')
<main class="container investors">
	<h1>{{$news->title}}</h1>
	<div class="content">
		<p><span class="glyphicon glyphicon-time"></span> {{ myDateTime::getDayAndMonth($news->created_at) }}</p>
			<div>
				{{ sPage::content_render($news->content) }}
			</div>
	</div>
</main>
@stop
@section('scripts')

@stop