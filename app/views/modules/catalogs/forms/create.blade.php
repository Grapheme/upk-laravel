{{ Form::open(array('url'=>slink::createAuthLink('catalogs/store'),'role'=>'form','class'=>'smart-form','id'=>'catalog-form','method'=>'post','files' => true)) }}
	<div class="row margin-top-10">
		<section class="col col-6">
			<div class="well">
				<header>Для создания каталога заполните форму:</header>
				<fieldset>
					<section>
						<label class="label">Название</label>
						<label class="input"> <i class="icon-append fa fa-list-alt"></i>
							{{ Form::text('title','') }}
						</label>
					</section>
				@if(Allow::valid_access('downloads'))
					<section>
						<label class="label">Логотип</label>
						<label class="input input-file" for="file">
							<div class="button"><input type="file" onchange="this.parentNode.nextSibling.value = this.value" name="file">Выбрать</div><input type="text" readonly="" placeholder="Выбирите файл">
						</label>
					</section>
				@endif
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
							{{ Form::select('template', $temps,'catalog', array('class'=>'template-change','autocomplete'=>'off')) }} <i></i>
						</label>
					</section>
				@endif
					<section>
						<label class="label">Содержание</label>
						<label class="textarea">
							{{ Form::textarea('description','',array('class'=>'redactor')) }}
						</label>
					</section>
				</fieldset>
				<fieldset>
					<section>
						<label class="label">Дополнительные поля для продуктов</label>
					</section>
					<ul id="catalog-fields-list" class="list-unstyled ">
						<li class="row">
							<section class="col col-4">
								<label class="input">
									<input type="text" value="" name="fields[title][]" placeholder="Название поля [name]">
								</label>
							</section>
							<section class="col col-4">
								<label class="input">
									<input type="text" value="" name="fields[label][]" placeholder="Подпись поля [label]">
								</label>
							</section>
							<section class="col col-3">
								<label class="select">
									<select name="fields[type][]" autocomplete="off" >
										<option value="input"selected="">Input</option>
										<option value="textarea">Textarea</option>
										<option value="checkbox">Checkbox</option>
									</select> <i></i>
								</label>
							</section>
						</li>
					</ul>
					<section>
						<div class="row pull-right margin-right-5">
							<button type="button" id="add-catalog-field"><i class="fa fa-plus"></i></button>
							<button type="button" id="remove-catalog-field"><i class="fa fa-trash-o"></i></button>
						</div>
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