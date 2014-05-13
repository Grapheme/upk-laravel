@extends('templates.'.AuthAccount::getStartPage())
@section('content')
@if($users->count())
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th class="col-lg-1 text-center">ID</th>
					<th class="col-lg-1 text-center">Аватар</th>
					<th class="col-lg-5 text-center">ФИО, Email</th>
					<th class="col-lg-4 text-center"></th>
				</tr>
			</thead>
			<tbody>
			@foreach($users as $user)
				<tr>
					<td class="text-center">{{ $user->id }}</td>
					<td class="text-center">
					@if(!empty($user->thumbnail))
						<figure class="avatar-container">
							<img src="{{url('image/avatar-male-thumbnail/'.$user->id)}}" alt="{{ $user->name }} {{ $user->surname }}" class="avatar bordered circle">
						</figure>
					@endif
					</td>
					<td>
						{{ $user->name }} {{ $user->surname }}
						<p>[{{ HTML::mailto($user->email,$user->email) }}]</p>
						@if($user->active == 0)
						<div class="alert alert-warning fade in">
							<i class="fa-fw fa fa-warning"></i> <strong>Внимание</strong> Аккаунт не активировн
						</div>
						@endif
					</td>
					<td>
				@if(Auth::user()->id != $user->id)
					@if(Allow::valid_action_permission('users','edit'))
						<a class="btn btn-labeled btn-success pull-left margin-right-10" href="{{slink::createAuthLink('users/edit/'.$user->id)}}">
							<span class="btn-label"><i class="fa fa-edit"></i></span> Ред.
						</a>
					@endif
					@if(Allow::valid_action_permission('users','delete'))
						<form method="POST" action="{{slink::createAuthLink('users/destroy/'.$user->id)}}">
							<button type="button" class="btn btn-labeled btn-danger remove-user">
								<span class="btn-label"><i class="fa fa-trash-o"></i></span> Удал.
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
				В данном разделе находятся пользователи сайта
				<p><br><i class="regular-color-light fa fa-th-list fa-3x"></i></p>
			</div>
		</div>
	</div>
</div>
@endif
@stop
@section('scripts')
<script>
	$('.group-add-select').on('change', function(){
		var $_select = $(this);
		if($_select.val() != 0)
		{
			$.ajax({
				url: '{{slink::createLink('admin/users/attach')}}',
				data: { group_id: $_select.val(), user_id: $_select.attr('data-user')},
				type: 'post'
			}).always(function(data){
				console.log(data);
			});
		}
	});
</script>
@stop