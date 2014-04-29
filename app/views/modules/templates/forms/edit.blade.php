{{ Form::model($template,array('url'=>slink::createAuthLink('templates/update/'.$template->id),'class'=>'smart-form','id'=>'template-form','role'=>'form','method'=>'post')) }}
	<div class="row margin-top-10">
		<section class="col col-6">
			<div class="well">
				<header>Для изменения шаблона воспользуйтесь формой:</header>
				<fieldset>
					<section>
						<label class="label">Название</label>
						<label class="input"> <i class="icon-append fa fa-list-alt"></i>
							{{ Form::text('name',NULL) }}
						</label>
					</section>
					<section>
						<label class="label">Содержание</label>
						<label class="textarea">
							{{ Form::textarea('content',NULL,array('class'=>'height-500')) }}
						</label>
					</section>
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