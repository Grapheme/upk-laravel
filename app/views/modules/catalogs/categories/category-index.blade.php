@extends('templates.'.AuthAccount::getStartPage())
@section('content')
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="pull-right margin-bottom-25 margin-top-10">
		@if(is_null($parent_category_id))
				<a class="btn btn-default no-margin regular-10 uppercase pull-left btn-spinner margin-right-5" href="{{slink::createAuthLink('catalogs/categories')}}">
					<i class="fa fa-arrow-left hidden"></i> <span class="btn-response-text">К списку групп категорий</span>
				</a>
			@if(Allow::valid_action_permission('catalogs','create'))
				<a class="btn btn-primary" href="{{slink::createAuthLink('catalogs/category-group/'.$category_group_id.'/categories/create')}}">Добавить катагорию</a>
			@endif
		@else
				<a class="btn btn-default no-margin regular-10 uppercase pull-left btn-spinner margin-right-5" href="{{slink::createAuthLink('catalogs/category-group/'.$category_group_id.'/categories')}}">
					<i class="fa fa-arrow-left hidden"></i> <span class="btn-response-text">К списку категорий</span>
				</a>
			@if(Allow::valid_action_permission('catalogs','create'))
				<a class="btn btn-primary" href="{{slink::createAuthLink('catalogs/category-group/'.$category_group_id.'/category/'.$parent_category_id.'/sub-categories/create')}}">Добавить подкатагорию</a>
			@endif
		@endif
			</div>
		</div>
	</div>
	@if($categories->count())
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<th class="text-center">Название</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							<b>
								{{ CategoryGroup::findOrFail($category_group_id)->title; }}
								{{ !is_null($parent_category_id) ? '-> '.Category::findOrFail($parent_category_id)->title : '' }}
							</b>
						</td>
						<td></td>
					</tr>
				@foreach($categories as $category)
					<tr>
						<td>
						@if(is_null($parent_category_id))
							<a href="{{slink::createAuthLink('catalogs/category-group/'.$category_group_id.'/category/'.$category->id.'/sub-categories')}}">{{ $category->title }}</a>
						@else
							{{ $category->title }}
						@endif
						</td>
						<td class="wigth-{{ is_null($parent_category_id) ? 350 : 250 }}">
						@if(is_null($parent_category_id))
							<a class="btn btn-labeled btn-success pull-left margin-right-10" href="{{slink::createAuthLink('catalogs/category-group/'.$category_group_id.'/category/'.$category->id.'/sub-categories')}}">
								<span class="btn-label"><i class="fa fa-th-list"></i></span> Подкат.
							</a>
						@endif
						@if(Allow::valid_action_permission('catalogs','edit'))
							@if(is_null($parent_category_id))
							<a class="btn btn-labeled btn-success pull-left margin-right-10" href="{{slink::createAuthLink('catalogs/category-group/'.$category_group_id.'/categories/edit/'.$category->id)}}">
								<span class="btn-label"><i class="fa fa-edit"></i></span> Ред.
							</a>
							@else
							<a class="btn btn-labeled btn-success pull-left margin-right-10" href="{{slink::createAuthLink('catalogs/category-group/'.$category_group_id.'/category/'.$parent_category_id.'/sub-categories/edit/'.$category->id)}}">
								<span class="btn-label"><i class="fa fa-edit"></i></span> Ред.
							</a>
							@endif
						@endif
						@if(Allow::valid_action_permission('catalogs','delete'))
							<form method="DELETE" action="{{slink::createAuthLink('catalogs/category-group/'.$category_group_id.'/categories/destroy/'.$category->id)}}">
								<button type="button" class="btn btn-labeled btn-danger remove-catalog-category">
									<span class="btn-label"><i class="fa fa-trash-o"></i></span> Удал.
								</button>
							</form>
						@endif
						</td>
					</tr>
				@endforeach
				</tbody>
			</table>
		</div>
	</div>
	@else
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="ajax-notifications custom">
				<div class="alert alert-transparent">
					<h4>Список пуст</h4>
					В данном разделе находятся {{ !is_null($parent_category_id) ? 'под':'' }}категории продукций
					<p><br><i class="regular-color-light fa fa-th-list fa-3x"></i></p>
				</div>
			</div>
		</div>
	</div>
	@endif
@stop
@section('scripts')
	<script src="{{slink::path('js/modules/catalogs.js')}}"></script>
	<script type="text/javascript">
		if(typeof pageSetUp === 'function'){pageSetUp();}
		if(typeof runFormValidation === 'function'){
			loadScript("{{asset('js/vendor/jquery-form.min.js');}}",runFormValidation);
		}else{
			loadScript("{{asset('js/vendor/jquery-form.min.js');}}");
		}
	</script>
@stop