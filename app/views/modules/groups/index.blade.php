@extends('templates.'.AuthAccount::getStartPage())
@section('content')
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="pull-right margin-bottom-25 margin-top-10 ">
		@if(Allow::valid_action_permission('users','create'))
			<!--<a class="btn btn-primary" href="{{slink::createAuthLink('groups/create')}}">Добавить группу</a>-->
		@endif
		</div>
	</div>
</div>
@if($groups->count())
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th class="col-lg-1 text-center">ID</th>
					<th class="col-lg-10 text-center">Название группы</th>
					<th class="col-lg-1 text-center"></th>
				</tr>
			</thead>
			<tbody>
			@foreach($groups as $group)
				<tr>
					<td class="text-center">{{ $group->id }}</td>
					<td>{{ $group->desc }}</td>
					<td>
						<a class="btn btn-labeled btn-success pull-left margin-right-10" href="{{slink::createAuthLink('groups/edit/'.$group->id)}}">
							<span class="btn-label"><i class="fa fa-edit"></i></span> Ред. роли
						</a>
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
				В данном разделе находятся группы пользователей
				<p><br><i class="regular-color-light fa fa-th-list fa-3x"></i></p>
			</div>
		</div>
	</div>
</div>
@endif
@stop
@section('scripts')
<script>
	function ajaxGroupRole($url, $box){
		$.ajax({
			url: $url,
			data: { group_id: $box.attr('data-group'), role_id: $box.attr('data-role') },
			type: 'post'
		}).fail(function(data){
			console.log(data);
		});
	}

	$('.roles-checkbox').click(function(){
		
		var $box = $(this);

		if($box.is(':checked')){
			ajaxGroupRole('{{slink::createLink('admin/groups/attach')}}', $box);
		} else {
			ajaxGroupRole('{{slink::createLink('admin/groups/detach')}}', $box);
		}
	});
</script>
@stop
