@extends('templates.'.AuthAccount::getStartPage())
@section('content')
@if(Allow::valid_action_permission('galleries','create'))
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="pull-right margin-bottom-25 margin-top-10 ">
			<a class="btn btn-primary" href="{{slink::createAuthLink('galleries/create')}}">Добавить галерею</a>
		</div>
	</div>
</div>
@endif
@if($galleries->count())
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th class="col-lg-10 text-center">Название гелереи</th>
					<th class="col-lg-1 text-center"></th>
				</tr>
			</thead>
			<tbody>
			@foreach($galleries as $gallery)
				<tr>
					<td>{{ $gallery->name }}</td>
					<td>
						@if(Allow::valid_action_permission('galleries','edit'))
							<a class="btn btn-labeled btn-success pull-left margin-right-10" href="{{slink::createAuthLink('galleries/edit/'.$gallery->id)}}">
								<span class="btn-label"><i class="fa fa-edit"></i></span> Ред.
							</a>
						@endif
						@if(Allow::valid_action_permission('galleries','delete'))
							<form method="POST" action="{{slink::createAuthLink('galleries/destroy/'.$gallery->id)}}">
								<button type="button" class="btn btn-labeled btn-danger remove-gallery">
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
				В данном разделе находятся галереи
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
		$('.gallery-delete-btn').click(function(){
			var $that = $(this).parent().parent();
			var $id = $(this).attr('data-id');
			$.ajax({
				url: '{{URL::to('admin/galleries/delete')}}',
				data: { id: $id },
				type: 'post',
            }).done(function(){
            	$that.fadeOut('fast');
            });
			return false;
		});
	});
</script>
@stop