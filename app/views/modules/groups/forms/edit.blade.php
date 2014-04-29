{{ Form::model($group,array('url'=>slink::createAuthLink('groups/update/'.$group->id),'class'=>'smart-form','id'=>'group-form','role'=>'form','method'=>'post')) }}
	<div class="row margin-top-10">
		<section class="col col-6">
			<div class="well">
				<header>Для изменения группы пользователей заполните форму:</header>
				<fieldset>
					<section>
						<label class="label">Название</label>
						<label class="input">
							{{ Form::text('name',NULL) }}
						</label>
						<div class="note">Заполняется латинскими символами. Не должно содержать пробелов</div>
					</section>
					<section>
						<label class="label">Описание</label>
						<label class="input">
							{{ Form::text('desc',NULL) }}
						</label>
					</section>
					<section>
						<label class="label">Стартовая страница</label>
						<label class="input">
							{{ Form::text('dashboard',NULL) }}
						</label>
						<div class="note">Заполняется латинскими символами. Не должно содержать пробелов</div>
					</section>
				</fieldset>
				<fieldset>
				@if($roles->count())
					<section>
						<label class="label">Доступные роли</label>
						<div class="row">
					@foreach($roles as $role)
						<div class="col col-4">
							<label class="checkbox">
								<input type="checkbox" value="{{ $role->id }}" name="roles[]" {{ isset($group->roles[$role->name]) ? 'checked="checked"' : '' }}><i></i>{{ $role->desc; }}
							</label>
						</div>
					@endforeach
					</section>
				@endif
				</fieldset>
				<footer>
					<a class="btn btn-default no-margin regular-10 uppercase pull-left btn-spinner" href="{{URL::previous()}}">
						<i class="fa fa-arrow-left hidden"></i> <span class="btn-response-text">Назад</span>
					</a>
					<button type="submit" autocomplete="off" class="btn btn-success no-margin regular-10 uppercase btn-form-submit">
						<i class="fa fa-spinner fa-spin hidden"></i> <span class="btn-response-text">Сохранить</span>
					</button>
				</footer>
			</div>
		</section>
	</div>
{{ Form::close() }}