@extends('templates.default')

@section('content')
<div id="page_notfound">
	<div class="page-header-top">
		<div class="container">
			<h1>Whoops <small>this page could not be found</small></h1>
		</div>
	</div>
	<div class="container">
		<div class="content">
			<div class="row">
				<div class="span3">&nbsp;</div>
				<div class="span13">
					<h1 class="extra_big">error 404</h1>
				@if(!isset($message) || empty($message))
					<h2>We're not sure what happened,<br>but we do know this page doesn't exist.</h2>
				@else
					<h2>{{ $message }}</h2>
				@endif
				</div>
			</div>
		</div>
	</div>
</div>
@stop