@extends('templates.'.AuthAccount::getStartPage())
@section('content')
@if(Allow::valid_action_permission('languages','create'))
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="pull-right margin-bottom-25 margin-top-10 ">
			<a class="btn btn-primary" href="{{slink::createAuthLink('languages/create')}}">Добавить язык</a>
		</div>
	</div>
</div>
@endif;
@if($languages->count())
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th class="col-lg-2 text-center">Название языка</th>
					<th class="col-lg-1 text-center">Код языка</th>
					<th class="col-lg-3 text-center"></th>
				</tr>
			</thead>
			<tbody>
			@foreach($languages as $language)
				<tr>
					<td>{{ $language->name }}</td>
					<td class="text-center">{{ $language->code }}</td>
					<td>
						@if(Allow::valid_action_permission('languages','edit'))
							<a class="btn btn-labeled btn-success pull-left margin-right-10" href="{{slink::createAuthLink('languages/edit/'.$language->id)}}">
								<span class="btn-label"><i class="fa fa-edit"></i></span> Ред.
							</a>
						@endif
						@if(Allow::valid_action_permission('languages','delete'))
							<form method="POST" action="{{slink::createAuthLink('languages/destroy/'.$language->id)}}">
								<button type="button" class="btn btn-labeled btn-danger remove-language">
									<span class="btn-label"><i class="fa fa-trash-o"></i></span> Удал.
								</button>
							</form>
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
				В данном разделе находятся список возможных языков сайта
				<p><br><i class="regular-color-light fa fa-th-list fa-3x"></i></p>
			</div>
		</div>
	</div>
</div>
@endif
@stop
@section('scripts')
<script>
	$(function(){
		$('.form-ajax-submit').on('submit', function(event){
			event.preventDefault();
			var $_form = $(this);
			var $data = {};
			$_form.find('input').not('input[type=submit]').each(function(){
				$data[$(this).attr('name')] = $(this).val();
			});
			$.ajax({
				url: $_form.attr('action'),
				data: $data,
				type: 'post',
		    }).done(function(){
		    	location.reload();
		    }).fail(function(data){
		    	console.log(data);
		    	var $errors = data.responseJSON;
		        $.bigBox({
		            title : "Error!",
		            content : $errors,
		            color : "#C46A69",
		            timeout: 15000,
		            icon : "fa fa-warning shake animated",
		        });
		    });
		});
		$('.language-delete-btn').click(function(){
			var $that = $(this).parent().parent();
			var $id = $(this).attr('data-id');
			$.ajax({
				url: '{{URL::to('admin/languages/delete')}}',
				data: { id: $id },
				type: 'post',
            }).done(function(){
            	$that.fadeOut('fast');
            }).always(function(data){
            	console.log(data);
            });
			return false;
		});
	});
</script>
@stop