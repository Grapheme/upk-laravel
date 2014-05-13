@extends('templates.'.AuthAccount::getStartPage())
@section('content')
@if(Allow::valid_action_permission('templates','create'))
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="pull-left margin-bottom-25 margin-top-10 ">
			<a class="btn btn-primary" href="{{slink::createAuthLink('templates/create')}}">Добавить шаблон</a>
		</div>
	</div>
</div>
@endif
@if($templates->count())
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th class="col-lg-2 text-center" style="min-width: 245px;">Название шаблона</th>
					<th class="col-lg-2 text-center">Путь к шаблону</th>
					<th class="col-lg-2 text-center" style="min-width: 245px;"></th>
				</tr>
			</thead>
			<tbody>
			@foreach($templates as $template)
				<tr>
					<td>{{ $template->name }}</td>
					<td>templates/{{ $template->name }}.blade.php</td>
					<td>
						@if(Allow::valid_action_permission('templates','edit'))
							<a class="btn btn-default pull-left margin-right-10" href="{{slink::createAuthLink('templates/edit/'.$template->id)}}">
								Редактировать
							</a>
						@endif
					@if(!$template->static)
						@if(Allow::valid_action_permission('templates','delete'))
							<form method="POST" action="{{slink::createAuthLink('templates/destroy/'.$template->id)}}">
								<button type="button" class="btn btn-default remove-template">
									Удалить
								</button>
							</form>
						@endif
					@endif
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	</div>
</div>
@else
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="ajax-notifications custom">
			<div class="alert alert-transparent">
				<h4>Список пуст</h4>
				В данном разделе находятся шаблоны
				<p><br><i class="regular-color-light fa fa-th-list fa-3x"></i></p>
			</div>
		</div>
	</div>
</div>
@endif
@stop
@section('scripts')
<script src="{{slink::path('js/modules/templates.js')}}"></script>
	<script type="text/javascript">
		if(typeof pageSetUp === 'function'){pageSetUp();}
		if(typeof runFormValidation === 'function'){
			loadScript("{{asset('js/vendor/jquery-form.min.js');}}",runFormValidation);
		}else{
			loadScript("{{asset('js/vendor/jquery-form.min.js');}}");
		}
	</script>
@stop