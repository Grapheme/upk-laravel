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
		<h1>{{ trans('interface.PAGES_FOR_REQUEST_ACCESS') }}</h1>
		<div class="content">
			@if(isset($content))
				{{ $content }}
			@endif
			<div class="apply-form">
			{{ Form::open(array('route'=>'request-to-access','role'=>'form','id'=>'request-to-access-form')) }}
				<table class="apply-table">
					<tr class="apply-row">
						<td><label for="name">{{ trans('interface.FORM_REQUEST_FOR_ACCESS_LABEL_FIO') }}</label></td>
						<td><input type="text" name="name" id="name"></input></td>
					</tr>
						<tr class="apply-row">
						<td><label for="organisation">{{ trans('interface.FORM_REQUEST_FOR_ACCESS_LABEL_ORGANISATION') }}</label></td>
						<td><input type="text" name="organisation" id="organisation"></input></td>
					</tr>
					<tr class="apply-row">
						<td><label for="email">{{ trans('interface.FORM_REQUEST_FOR_ACCESS_LABEL_EMAIL') }}</label></td>
						<td><input type="text" name="email" id="email"></input></td>
					</tr>
					<tr class="apply-row">
						<td><label for="phone">{{ trans('interface.FORM_REQUEST_FOR_ACCESS_LABEL_PHONE') }}</label></td>
						<td><input type="text" name="phone" id="phone"></input></td>
					</tr>
				</table>
			<button class="apply-btn">{{ trans('interface.FORM_REQUEST_FOR_ACCESS_SUBMIT') }}</button>
			{{ Form::close() }}
			</div>
		</div>
	</main>
	@include('templates.default.footer')
	@include('templates.default.scripts')
	@yield('scripts')
</body>
</html>