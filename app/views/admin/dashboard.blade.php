@extends('templates.admin')
@section('content')
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="margin-top-10">
			<ul>
			@foreach(User::find(Auth::user()->id)->groups as $group)
				<li>
					Группа: &laquo;{{$group->desc}}&raquo;
					<br>Доступ:
					<ol>
					@foreach(Group::find($group->id)->roles as $role)
						@if(allow::valid_access($role->name))
						<li>{{$role->desc}}</li>
						@endif
					@endforeach
					</ol>
				</li>
			@endforeach
			</ul>
			Текущий язык: &laquo;{{ Language::where('code',Config::get('app.locale'))->first()->name; }}&raquo;
			
		</div>
	</div>
</div>
@stop
@section('scripts')

@stop