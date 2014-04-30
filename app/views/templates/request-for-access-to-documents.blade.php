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
		<h1>Заявка на доступ к документам</h1>
		<div class="content">
			@if(isset($content))
				{{ $content }}
			@endif
			<div class="apply-form">
			{{ Form::open(array('route'=>'request-to-access','role'=>'form','id'=>'request-to-access-form')) }}
				<table class="apply-table">
					<tr class="apply-row">
						<td><label for="name">ФИО контактного лица</label></td>
						<td><input type="text" name="name" id="name"></input></td>
					</tr>
						<tr class="apply-row">
						<td><label for="organisation">Название организации</label></td>
						<td><input type="text" name="organisation" id="organisation"></input></td>
					</tr>
					<tr class="apply-row">
						<td><label for="email">Адрес@электронной.почты</label></td>
						<td><input type="text" name="email" id="email"></input></td>
					</tr>
					<tr class="apply-row">
						<td><label for="phone">Контактный телефон</label></td>
						<td><input type="text" name="phone" id="phone"></input></td>
					</tr>
				</table>
			<button class="apply-btn">Отправить заявку</button>
			{{ Form::close() }}
			</div>
		</div>
	</main>
	@include('templates.default.footer')
	@include('templates.default.scripts')
	@yield('scripts')
</body>
</html>