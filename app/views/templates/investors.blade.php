<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
 <head>
	@include('templates.default.head')
	@yield('style')
</head>
<body>
	<!--[if lt IE 7]>
		<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
	<![endif]-->
	@include('templates.default.header')
	<main class="container investors">
		<h1>{{ $page_title }}</h1>
		<div class="content">
			@if(isset($content))
				{{ $content }}
			@endif
			@if(Auth::guest())
				{{ Form::open(array('route'=>'signin','role'=>'form','class'=>'auth-form','id'=>'signin-secure-page-form-2')) }}
					<div class="form-header">{{ trans('interface.FORM_SIGNIN_SECURE_2_HEADER') }}</div>
					<input type="text" name="login" placeholder="{{ trans('interface.FORM_INPUT_PLACEHOLDER_LOGIN') }}">
					<input type="password" name="password" placeholder="{{ trans('interface.FORM_INPUT_PLACEHOLDER_PASSWORD') }}">
					<button type="submit">{{ trans('interface.FORM_SIGNIN_SUBMIT') }}</button>
				{{ Form::close() }}
			@endif
		</div>
	</main>
	@include('templates.default.footer')
	@include('templates.default.scripts')
	@yield('scripts')
</body>
</html>