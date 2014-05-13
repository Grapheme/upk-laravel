{{ Form::open(array('url'=>slink::createAuthLink('pages/store'),'role'=>'form','class'=>'smart-form','id'=>'page-form','method'=>'post')) }}
	<div class="row margin-top-10">
		<section class="col col-6">
			<div class="well">
				<header>Для создания страницы заполните форму:</header>
				<fieldset>
					<section>
						<label class="label">Название</label>
						<label class="input"> <i class="icon-append fa fa-list-alt"></i>
							{{ Form::text('name','') }}
						</label>
					</section>
				@if(Allow::valid_access('languages') && !empty($languages))
					<section>
						<label class="label">Язык:</label>
						<label class="select">
							<select class="lang-change" name="language" autocomplete="off">
							@foreach($languages as $language)
								<option value="{{$language['code']}}">{{$language['name']}}</option>
							@endforeach
							</select> <i></i>
						</label>
					</section>
				@endif
				@if(Allow::valid_access('templates'))
					<section>
						<label class="label">Шаблон:</label>
						<label class="select">
							<select class="lang-change" name="template" autocomplete="off">
							@foreach($templates as $template)
								 <option value="{{$template->name}}">{{$template->name}}</option>
							@endforeach
							</select> <i></i>
						</label>
					</section>
				@endif
					<section>
						<label class="label">Содержание</label>
						<label class="textarea">
							{{ Form::textarea('content','',array('class'=>'redactor-no-filter')) }}
						</label>
					</section>
					@if(Page::count())
					<section class="pull-right">
						<label class="toggle">
							{{ Form::checkbox('in_menu', '1', NULL) }}
							<i data-swchon-text="да" data-swchoff-text="нет"></i>Показывать в меню: 
						</label>
					</section>
					@endif
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
	@if(Allow::enabled_module('seo'))
		<section class="col col-6">
			<div class="well">
				@include('modules.seo.pages')
			</div>
		</section>
	@endif
	</div>
{{ Form::close() }}