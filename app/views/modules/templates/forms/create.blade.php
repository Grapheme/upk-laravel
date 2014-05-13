{{ Form::open(array('url'=>slink::createAuthLink('templates/store'),'role'=>'form','class'=>'smart-form','id'=>'template-form','method'=>'post')) }}
	<div class="row margin-top-10">
		<section class="col col-6">
			<div class="well">
				<header>Для регистрации шаблона заполните форму:</header>
				<fieldset>
					<section>
						<label class="label">Название</label>
						<label class="input"> <i class="icon-append fa fa-list-alt"></i>
							{{ Form::text('name','') }}
						</label>
					</section>
					<section>
						<label class="label">Содержание</label>
						<label class="textarea">
							{{ Form::textarea('content','',array('class'=>'height-500')) }}
						</label>
					</section>
				</fieldset>
				<footer>
					<a class="btn btn-default no-margin regular-10 uppercase pull-left btn-spinner" href="{{URL::previous()}}">
						<i class="fa fa-arrow-left hidden"></i> <span class="btn-response-text">Назад</span>
					</a>
					<button type="submit" autocomplete="off" class="btn btn-success no-margin regular-10 uppercase btn-form-submit">
						<i class="fa fa-spinner fa-spin hidden"></i> <span class="btn-response-text">Добавить</span>
					</button>
				</footer>
			</div>
		</section>
	</div>
{{ Form::close() }}