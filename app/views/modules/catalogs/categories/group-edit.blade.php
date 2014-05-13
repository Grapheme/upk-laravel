@extends('templates.'.AuthAccount::getStartPage())
@section('style')
<link rel="stylesheet" href="{{slink::path('css/redactor.css')}}" />
@stop
@section('content')
	@include('modules.catalogs.categories.forms.group-edit')
@stop
@section('scripts')
	{{HTML::script('js/modules/catalogs.js')}}
	<script type="text/javascript">
		if(typeof pageSetUp === 'function'){pageSetUp();}
		if(typeof runFormValidation === 'function'){
			loadScript("{{asset('js/vendor/jquery-form.min.js');}}",runFormValidation);
		}else{
			loadScript("{{asset('js/vendor/jquery-form.min.js');}}");
		}
	</script>
	<script src="{{slink::path('js/vendor/redactor.min.js')}}"></script>
	<script src="{{slink::path('js/system/redactor-config.js')}}"></script>
@stop