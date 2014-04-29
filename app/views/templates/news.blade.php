@extends('templates.default')
@section('style')

@stop
@section('content')
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
			<h2>{{$news->title}}</h2>
			<p><span class="glyphicon glyphicon-time"></span> {{ myDateTime::SwapDotDateWithTime($news->created_at) }}</p>
			<div>
				{{ sPage::content_render($news->content) }}
			</div>
		</div>
	</div>
@stop
@section('scripts')

@stop