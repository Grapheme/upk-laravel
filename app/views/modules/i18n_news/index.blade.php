@extends('templates.'.AuthAccount::getStartPage())
@section('content')
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="margin-bottom-25 margin-top-10 ">
			@if(Allow::valid_action_permission('news','create'))
				<a class="btn btn-primary" href="{{slink::createAuthLink('i18n_news/create')}}">Добавить новость</a>
			@endif
			@if(Allow::valid_action_permission('news','sort') && $news->count() > 2)
				<!-- <a class="btn btn-default" href="{{slink::createAuthLink('i18n_news/sort')}}">Сортировать</a> -->
			@endif
			</div>
		</div>
	</div>
	@if($news->count())
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<table class="table table-striped table-bordered min-table">
				<thead>
					<tr>
						<th class="text-center" style="width:100px">Дата</th>
						<th class="text-center">Название новости</th>
    					@if(Allow::valid_action_permission('news','publication'))
						<th class="text-center">Публикация</th>
	    				@endif
						<th></th>
					</tr>
				</thead>
				<tbody>
				@foreach($news as $new)
					<tr>
						<td class="text-center">{{ date("d.m.Y", strtotime($new->published_at)) }}</a></td>
						<td>
						    <a href="{{slink::createLink('news/'.$new->slug)}}" target="_blank">{{$new->slug}}</a>
						</td>
						@if(Allow::valid_action_permission('news','publication'))
						<td class="wigth-100">
							<div class="smart-form">
								<label class="toggle pull-left">
									<input type="checkbox" name="publication" disabled="" checked="" value="1">
									<i data-swchon-text="да" data-swchoff-text="нет"></i>
								</label>
							</div>
						</td>
						@endif
						<td class="wigth-250">
						@if(Allow::valid_action_permission('news','edit'))
							<a class="btn btn-default pull-left margin-right-10" href="{{slink::createAuthLink('i18n_news/edit/'.$new->id)}}">
								Редактировать
							</a>
						@endif
						@if(Allow::valid_action_permission('news','delete'))
							<form method="POST" action="{{slink::createAuthLink('i18n_news/destroy/'.$new->id)}}">
								<button type="button" class="btn btn-default remove-news">
									Удалить
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
					В данном разделе находятся новости сайта
					<p><br><i class="regular-color-light fa fa-th-list fa-3x"></i></p>
				</div>
			</div>
		</div>
	</div>
	@endif
@stop
@section('scripts')
	<script src="{{slink::path('js/modules/news.js')}}"></script>
	<script type="text/javascript">
		if(typeof pageSetUp === 'function'){pageSetUp();}
		if(typeof runFormValidation === 'function'){
			loadScript("{{asset('js/vendor/jquery-form.min.js');}}",runFormValidation);
		}else{
			loadScript("{{asset('js/vendor/jquery-form.min.js');}}");
		}
	</script>
@stop