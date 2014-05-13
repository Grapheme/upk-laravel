@extends('templates.'.AuthAccount::getStartPage())

@section('scripts')
	
	<!--<script src="{{slink::path('js/vendor/superbox.min.js')}}"></script>-->
	<script src="{{slink::path('js/vendor/dropzone.min.js')}}"></script>
	<script>
	$(document).ready(function() {

		var myDropzone = new Dropzone("#mydropzone", {
			addRemoveLinks : false,
			maxFilesize: 0.5,
			dictResponseError: 'Error uploading file!'
		});

		//$('.superbox').SuperBox();

		myDropzone.on("totaluploadprogress", function(data) {
			console.log(data);
		});

		$('.photo-delete').click(function(){

			var $photoDiv = $(this).parent();

			$.ajax({
				url: "{{slink::createLink('admin/galleries/photodelete')}}",
				data: { id: $(this).attr('data-photo-id') },
				type: 'post',
            }).done(function(){
            	$photoDiv.fadeOut('fast');
            }).fail(function(data){
            	console.log(data);
            });
           
			return false;
		});
	});
	</script>

@stop

@section('content')

<form action="{{slink::path('admin/galleries/upload')}}" class="dropzone dz-clickable" id="mydropzone">
	<input type="hidden" name="gallery-id" value="{{$gall->id}}">
</form>

<div class="superbox col-sm-12">

	@foreach ($gall->photos as $photo)

	<div class="superbox-list">
		<img src="{{$photo->path()}}" data-img="{{$photo->path()}}" alt="Photo alt" title="Title" class="superbox-img">
		<a href="#" class="photo-delete" data-photo-id="{{$photo->id}}">Delete</a>
	</div>

	@endforeach

	<div class="superbox-float"></div>
</div>

@stop