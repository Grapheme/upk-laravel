{{ Form::open(array('url'=>slink::createAuthLink('groups/store'),'role'=>'form','class'=>'smart-form','id'=>'group-form','method'=>'post')) }}
	<div class="row margin-top-10">
		<section class="col col-6">
			<div class="well">
				<header>Для создания группы пользователей заполните форму:</header>
				<fieldset>
					<section>
						<label class="label">Название</label>
						<label class="input">
							{{ Form::text('name','') }}
						</label>
						<div class="note">Заполняется латинскими символами. Не должно содержать пробелов</div>
					</section>
					<section>
						<label class="label">Описание</label>
						<label class="input">
							{{ Form::text('desc','') }}
						</label>
					</section>
					<section>
						<label class="label">Стартовая страница</label>
						<label class="input">
							{{ Form::text('dashboard','') }}
						</label>
						<div class="note">Заполняется латинскими символами. Не должно содержать пробелов</div>
					</section>
				</fieldset>
				<footer>
					<a class="btn btn-default no-margin regular-10 uppercase pull-left btn-spinner" href="{{URL::previous()}}">
						<i class="fa fa-arrow-left hidden"></i> <span class="btn-response-text">Назад</span>
					</a>
					<button type="submit" autocomplete="off" class="btn btn-success no-margin regular-10 uppercase btn-form-submit">
						<i class="fa fa-spinner fa-spin hidden"></i> <span class="btn-response-text">Создать</span>
					</button>
				</footer>
			</div>
		</section>
	</div>
{{ Form::close() }}