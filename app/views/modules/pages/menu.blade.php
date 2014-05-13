@extends('templates.admin.index')

@section('plugins')

<script src="{{slink::path('admin_template/js/plugin/jquery-nestable/jquery.nestable.js')}}"></script>
<script>

		$(document).ready(function() {
	
			$('#nestable').nestable({
				group : 1
			}).on('change', function(){
				var $i = 0;
				var $menu = [];
				$('.dd-item').each(function(){
					$menu[$i] = $(this).attr('data-id');
					$i++;
				});

				$.ajax({
					url: '{{slink::createLink('admin/pages/sort')}}',
					data: { menu: JSON.stringify($menu) },
					type: 'post'
				}).fail(function(data){
					console.log(data);
				});
			});

		});

</script>

@stop

@section('content')

	<div class="dd" id="nestable">
		<ol>
			@foreach($pages as $page)
			<li class="dd-item" data-id="{{$page->id}}">
				<div class="dd-handle">
					{{$page->name}}
				</div>
			</li>
			@endforeach
		</ol>
	</div>

@stop