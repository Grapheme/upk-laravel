@extends('templates.'.AuthAccount::getStartPage())

@section('scripts')

	<script>
	$(function(){
		$('.form-ajax-submit').on('submit', function(event){

			event.preventDefault();

			var $_form = $(this);
			var $data = {};

			$_form.find('input').not('input[type=submit]').each(function(){
				$data[$(this).attr('name')] = $(this).val();
			});

			$.ajax({
				url: $_form.attr('action'),
				data: $data,
				type: 'post',
            }).done(function(href){
            	window.location.href = href;
            }).fail(function(data){
            	var $errors = data.responseJSON;

                $.bigBox({
                    title : "Error!",
                    content : $errors,
                    color : "#C46A69",
                    timeout: 15000,
                    icon : "fa fa-warning shake animated",
                });
            });

		});

		$('.gallery-delete-btn').click(function(){

			var $that = $(this).parent().parent();
			var $id = $(this).attr('data-id');

			$.ajax({
				url: '{{URL::to('admin/galleries/delete')}}',
				data: { id: $id },
				type: 'post',
            }).done(function(){
            	$that.fadeOut('fast');
            });

			return false;
		});
	});
	</script>

@stop

@section('content')

<div style="margin: 10px 0 25px;">
	<a class="btn btn-primary" data-toggle="modal" data-target="#gallery">Добавить галлерею</a>
</div>

@if (is_object($galls) && $galls->count())
<table class="table table-bordered table-striped min-table">
<thead>
	<tr>
		<th>Название</th>
		<th style="width: 100px;"></th>
		<th style="width: 100px;"></th>
	</tr>
</thead>
<tbody>

	@foreach($galls as $gall)
	<tr>
		<td>{{$gall->name}}</td>
		<td><a href="{{slink::to('admin/galleries/edit/'.$gall->id)}}" class="btn btn-default">Редактировать</a></td>
		<td><a class="gallery-delete-btn btn btn-default" href="#" data-id="{{$gall->id}}">Удалить</a></td>
	</tr>

	@endforeach

</tbody>
</table>
@else
	There are no galleries
@endif

<div class="modal fade in" id="gallery" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					×
				</button>
				<h4 class="modal-title" id="myModalLabel">Add new gallery</h4>
			</div>
			<div class="modal-body">

				<div class="row">
					<div class="col-md-12">
						<form id="add-lang" class="form-ajax-submit" action="{{slink::to('admin/galleries/create')}}">
							<div class="form-group">
								<label>Name:</label>
								<input class="form-control" name="name" type="text">
								<input class="form-control" name="settings" type="hidden" value="">
							</div>
							<input type="submit" class="btn btn-primary" data-id="add-lang" value="add">
						</form>
					</div>
				</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>

@stop