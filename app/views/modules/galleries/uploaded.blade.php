<div class="superbox col-sm-12">

    @if (@is_object($gall) && @$gall->gallery_id)
	<input type="hidden" name="gallery_id" value="{{ $gall->gallery_id }}" />
    @endif

    @if (@is_object($gall) && @$gall->photos)
	@foreach ($gall->photos as $photo)
	<div style="display:inline-block; width:100px; height:100px; background:url({{$photo->thumb()}}) no-repeat 50% 50%; background-size:cover; overflow:hidden; position:relative;">
		<!--<img src="{{$photo->thumb()}}" data-img="{{$photo->path()}}" alt="Photo alt" title="Title" class="superbox-img">-->
		<a href="{{$photo->path()}}" target="_blank" style="color:#090; background:#000">Full</a>
		<a href="#" class="photo-delete" data-photo-id="{{$photo->id}}" style="color:#f00; background:#000">Delete</a>
	</div>
	@endforeach
    @endif

	<div class="superbox-float"></div>
	
</div>

<div style="float:none; clear:both"></div>