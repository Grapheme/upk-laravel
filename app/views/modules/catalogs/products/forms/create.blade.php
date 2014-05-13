{{ Form::open(array('url'=>slink::createAuthLink('catalogs/products/store'),'role'=>'form','class'=>'smart-form','id'=>'catalog-product-form','method'=>'post','files' => true)) }}
	{{ Form::hidden('sort',0) }}
	<div class="row margin-top-10">
		<section class="col col-6">
			<div class="well">
				<header>Для создания продукта заполните форму:</header>
				<fieldset>
					<ul class="nav nav-tabs bordered" id="myTab1">
						<li class="active">
							<a data-toggle="tab" href="#data">Данные</a>
						</li>
					@if(!empty($data_fields))
						<li>
							<a data-toggle="tab" href="#advanced">Дополнительные данные</a>
						</li>
					@endif
						<li>
							<a data-toggle="tab" href="#options">Опции</a>
						</li>
					@if(Allow::valid_access('downloads'))
						<li>
							<a data-toggle="tab" href="#images">Изображения</a>
						</li>
					@endif
					</ul>
					<div class="tab-content padding-10" id="productTabContent">
						<div id="data" class="tab-pane fade active in">
							<section>
								<label class="label">Название</label>
								<label class="input">
									{{ Form::text('title','') }}
								</label>
							</section>
						@if(Allow::valid_access('downloads'))
							<section>
								<label class="label">Основное изображение</label>
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
						</div>
						<div id="advanced" class="tab-pane fade">
					@if(!empty($data_fields))
						@foreach($data_fields as $field)
							<section>
							@if(!empty($field->name))
								@if($field->type == 'input')
									<label class="label">{{ $field->label }}</label>
									<label class="input">
										{{ Form::text('attribute['.$field->name.']',NULL) }}
									</label>
								@elseif($field->type == 'textarea')
									<label class="label">{{ $field->label }}</label>
									<label class="textarea">
										{{ Form::textarea('attribute['.$field->name.']',NULL,array('class'=>'redactor')) }}
									</label>
								@elseif($field->type == 'checkbox')
									<div class="row">
										<div class="col col-10">
											<label class="checkbox">
												<input type="checkbox" name="{{ 'attribute['.$field->name.']' }}">
												<i></i>{{ $field->label }}
											</label>
										</div>
									</div>
								@endif
							@endif
							</section>
						@endforeach
					@endif
					@if(!empty($productsExtendedAttributes))
						@foreach($productsExtendedAttributes as $attrName => $attributes)
							<section>
								<?php $productAttr = array();?>
								<label class="label">{{ $attrName }}</label>
								<label class="select">
									@foreach($attributes as $attribute)
										<?php $productAttr[$attribute->title] = $attribute->title;?>
									@endforeach
									{{ Form::select('attribute['.$attrName.']', $productAttr,NULL, array('autocomplete'=>'off')) }} <i></i>
								</label>
							</section>
						@endforeach
					@endif
						</div>
						<div id="options" class="tab-pane fade">
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
									{{ Form::select('template', $temps,'product', array('class'=>'template-change','autocomplete'=>'off')) }} <i></i>
								</label>
							</section>
						@endif
						@if($catalogs->count() > 1)
							<section>
								<label class="label">Каталог продукции:</label>
								<label class="select">
									@foreach($catalogs as $catalog)
										<?php $catalogList[$catalog->id] = $catalog->title;?>
									@endforeach
									{{ Form::select('catalog_id', $catalogList,NULL, array('autocomplete'=>'off')) }} <i></i>
								</label>
							</section>
						@else
							{{ Form::hidden('catalog_id',$catalogs->first()->id) }}
						@endif
						@if($category_groups->count() > 1)
							<section>
								<label class="label">Группа категорий:</label>
								<label class="select">
									@foreach($category_groups as $category_group)
										<?php $categoryGroupList[$category_group->id] = $category_group->title;?>
									@endforeach
									{{ Form::select('category_group_id', $categoryGroupList,NULL, array('autocomplete'=>'off')) }} <i></i>
								</label>
							</section>
						@elseif($category_groups->count() == 1)
							{{ Form::hidden('category_group_id',$category_groups->first()->id) }}
						@else
							{{ Form::hidden('category_group_id',0) }}
						@endif
						@if($category_groups->count())
							<section id="select-product-categories" data-category-group="{{ $category_groups->first()->id }}" data-action="{{ slink::createAuthLink('catalogs/products/search-catalog-category') }}">
								<section>
									<label class="label">Показывать в категориях:</label>
									{{ Form::text('categories',NULL,array('id'=>'set-product-categories')) }}
									<div class="note">Воспользуйтесь поиском для указания категорий к которым относится продукт</div>
								</section>
							</section>
						@endif
							<section>
								<label class="label">Цена</label>
								<label class="input"> <i class="icon-append fa fa-credit-card"></i>
									{{ Form::text('price','') }}
								</label>
							</section>
							<section>
								<label class="label">Теги</label>
								<label class="input">
									{{ Form::text('tags','') }}
								</label>
								<div class="note">разделяются запятой</div>
							</section>
						</div>
					@if(Allow::valid_access('downloads'))
						<div id="images" class="tab-pane fade">
							<div action="{{ slink::createAuthLink('catalogs/products/upload-product-photo') }}" class="dropzone dz-clickable" id="ProductImageDropZone"></div>
						</div>
					@endif
					</div>
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
				@include('modules.seo.catalog-product')
			</div>
		</section>
	@endif
	</div>
{{ Form::close() }}