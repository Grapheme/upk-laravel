@extends('templates.'.AuthAccount::getStartPage())
@section('content')
<form action="{{slink::path('admin/downloads/upload')}}" class="dropzone dz-clickable" id="mydropzone">
	<input type="hidden" name="path" value="{{Input::get('path')}}">
</form>
<table class="table table-bordered table-striped">
	<tbody>
		@if(isset($back_link))
			<tr><td><a href="?path={{$back_link}}"><i class="fa fa-fw fa-level-up"></i> Back</a></td></tr>
		@endif

		{{--
		@if(!empty($dirs))
			@foreach($dirs as $url => $dir)
				<tr><td><a href="?path={{$url}}"><i class="fa fa-fw fa-folder-open"></i> {{$dir}}</a></td></tr>
			@endforeach
		@endif
		--}}
		@if(!empty($files))
			@foreach($files as $url => $file)
				<tr><td><a href="{{$url}}" target="_blank"><i class="fa fa-fw fa-file-text"></i> {{$file['name']}} <span>({{$file['size']}} KB)</span></a></td></tr>
			@endforeach
		@endif
	</tbody>
</table>

@stop
@section('scripts')
<script src="{{slink::path('js/vendor/dropzone.min.js')}}"></script>
@stop