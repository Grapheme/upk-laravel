@extends('templates.'.AuthAccount::getStartPage())
@section('content')
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="pull-right margin-bottom-25 margin-top-10 ">
			@if(Allow::valid_action_permission('catalogs','create'))
				<a class="btn btn-primary" href="{{slink::createAuthLink('catalogs/categories/create')}}">Добавить группу катагорий</a>
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
					@if(Allow::valid_action_permission('catalogs','publication'))
						<th class="text-center">Публикация</th>
					@endif
						<th></th>
					</tr>
				</thead>
				<tbody>
				@foreach($categories as $category)
					<tr>
						<td><a href="{{slink::createAuthLink('catalogs/category-group/'.$category->id.'/categories')}}">{{ $category->title }}</a></td>
						@if(Allow::valid_action_permission('catalogs','publication'))
						<td class="wigth-100">
							<div class="smart-form">
								<label class="toggle pull-left">
									<input type="checkbox" name="publication" disabled="" checked="" value="1">
									<i data-swchon-text="да" data-swchoff-text="нет"></i>
								</label>
							</div>
						</td>
						@endif
						<td class="wigth-350">
							<a class="btn btn-labeled btn-success pull-left margin-right-10" href="{{slink::createAuthLink('catalogs/category-group/'.$category->id.'/categories')}}">
								<span class="btn-label"><i class="fa fa-th-list"></i></span> Управ.
							</a>
						@if(Allow::valid_action_permission('catalogs','edit'))
							<a class="btn btn-labeled btn-success pull-left margin-right-10" href="{{slink::createAuthLink('catalogs/categories/edit/'.$category->id)}}">
								<span class="btn-label"><i class="fa fa-edit"></i></span> Ред.
							</a>
						@endif
						@if(Allow::valid_action_permission('catalogs','delete'))
							<form method="POST" action="{{slink::createAuthLink('catalogs/categories/destroy/'.$category->id)}}">
								<button type="button" class="btn btn-labeled btn-danger remove-catalog-category-group">
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
					В данном разделе находятся группы категорий продукции
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