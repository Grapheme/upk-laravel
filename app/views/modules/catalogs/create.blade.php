@extends('templates.'.AuthAccount::getStartPage())
@section('style')
<link rel="stylesheet" href="{{ slink::path('css/redactor.css') }}" />
<link rel="stylesheet" href="{{ slink::path('css/tokenizing/token-input.css') }}"/>
<link rel="stylesheet" href="{{ slink::path('css/tokenizing/token-input-facebook.css') }}"/>
@stop
@section('content')
	@include('modules.catalogs.forms.create')
@stop
@section('scripts')
	<script src="{{ slink::path('js/modules/catalogs.js') }}"></script>
	<script type="text/javascript">
		if(typeof pageSetUp === 'function'){pageSetUp();}
		if(typeof runFormValidation === 'function'){
			loadScript("{{asset('js/vendor/jquery-form.min.js');}}",runFormValidation);
		}else{
			loadScript("{{asset('js/vendor/jquery-form.min.js');}}");
		}
	</script>
	<script src="{{ slink::path('js/vendor/redactor.min.js') }}"></script>
	<script src="{{ slink::path('js/system/redactor-config.js') }}"></script>
@stop