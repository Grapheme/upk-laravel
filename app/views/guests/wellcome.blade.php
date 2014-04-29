@extends('templates.default')
@section('plugins')

@stop

@section('content')
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-7 col-lg-8">
			<h1 class="txt-color-red login-header-big">Здравствуйте.</h1>
			<div class="hero">
				<div class="pull-left login-desc-box-l">
					<h4 class="paragraph-header">Спасибо что пользуетесь нашей системой.</h4>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-7 col-lg-8">
					<p>Сейчас нет страниц на сайте.<br/>Пожалуйста <a href="{{url('login')}}">авторизуйтесь</a> под администратором чтобы начать работу.</p>
				</div>
			</div>
		</div>
	</div>
@stop

@section('scripts')
	
@stop