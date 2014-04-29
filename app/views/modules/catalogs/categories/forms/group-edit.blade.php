{{ Form::model($category,array('url'=>slink::createAuthLink('catalogs/categories/update/'.$category->id),'class'=>'smart-form','id'=>'catalog-category-group-form','role'=>'form','method'=>'post')) }}
	<div class="row margin-top-10">
		<section class="col col-6">
			<div class="well">
				<header>Для изменения группы категории воспользуйтесь формой:</header>
				<fieldset>
					<section>
						<label class="label">Название</label>
						<label class="input"> <i class="icon-append fa fa-list-alt"></i>
							{{ Form::text('title',NULL) }}
						</label>
					</section>
				@if(Allow::valid_access('languages') && !empty($languages))
					<section>
						<label class="label">Язык:</label>
						<label class="select">
							@foreach($languages as $language)
								<?php $langs[$language->code] = $language->name;?>
							@endforeach
							{{ Form::select('language', $langs,NULL, array('class'=>'lang-change','autocomplete'=>'off')) }} <i></i>
						</label>
					</section>
				@endif
				@if(Allow::valid_access('templates'))
					<section>
						<label class="label">Шаблон:</label>
						<label class="select">
							@foreach($templates as $template)
								<?php $temps[$template->name] = $template->name;?>
							@endforeach
							{{ Form::select('template', $temps,NULL, array('class'=>'template-change','autocomplete'=>'off')) }} <i></i>
						</label>
					</section>
				@endif
					<section>
						<label class="label">Описание</label>
						<label class="textarea">
							{{ Form::textarea('description',NULL,array('class'=>'redactor')) }}
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