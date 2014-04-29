{{ Form::open(array('url'=>slink::createAuthLink('catalogs/category-group/'.$category_group_id.'/categories/store'),'role'=>'form','class'=>'smart-form','id'=>'catalog-category-form','method'=>'post','files' => true)) }}
	{{ Form::hidden('category_group_id',$category_group_id) }}
	{{ Form::hidden('category_parent_id',is_null($parent_category_id) ? 0 : $parent_category_id ) }}
	<div class="row margin-top-10">
		<section class="col col-6">
			<div class="well">
				<header>Для создания {{ !is_null($parent_category_id) ? 'под':'' }}категории заполните форму:</header>
				<fieldset>
					<section>
						<label class="label">Название</label>
						<label class="input"> <i class="icon-append fa fa-list-alt"></i>
							{{ Form::text('title','') }}
						</label>
					</section>
				@if(Allow::valid_access('downloads'))
					<section>
						<label class="label">Изображение</label>
						<label class="input input-file" for="file">
							<div class="button"><input type="file" onchange="this.parentNode.nextSibling.value = this.value" name="file">Выбрать</div><input type="text" readonly="" placeholder="Выбирите файл">
						</label>
					</section>
				@endif
					<section>
						<label class="label">Описание</label>
						<label class="textarea">
							{{ Form::textarea('description','',array('class'=>'redactor')) }}
						</label>
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
	@if(Allow::enabled_module('seo'))
		<section class="col col-6">
			<div class="well">
				@include('modules.seo.catalog-category')
			</div>
		</section>
	@endif
	</div>
{{ Form::close() }}