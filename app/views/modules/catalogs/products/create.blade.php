@extends('templates.'.AuthAccount::getStartPage())
@section('style')
<link rel="stylesheet" href="{{slink::path('css/redactor.css')}}" />
<link rel="stylesheet" href="{{ slink::path('css/tokenizing/token-input.css') }}"/>
<link rel="stylesheet" href="{{ slink::path('css/tokenizing/token-input-facebook.css') }}"/>
@stop
@section('content')
	@include('modules.catalogs.products.forms.create')
@stop
@section('scripts')
	<script src="{{ slink::path('js/modules/catalogs.js') }}"></script>
	<script src="{{ slink::path('js/vendor/jquery.tokeninput.js') }}"></script>
	<script src="{{ slink::path('js/vendor/jquery.fancybox.pack.js') }}"></script>
	<script type="text/javascript">
		if(typeof pageSetUp === 'function'){pageSetUp();}
		if(typeof runFormValidation === 'function'){
			loadScript("{{asset('js/vendor/jquery-form.min.js');}}",runFormValidation);
		}else{
			loadScript("{{asset('js/vendor/jquery-form.min.js');}}");
		}
		window.onbeforeunload = function(){
			if(BASIC.inputChanged === true){
				return "Покинуть страницу? Все не сохраненные данные будут утеряны! Продоолжить?";
			}else{
				return null;
			}
		};
		$("#set-product-categories").tokenInput($("#select-product-categories").attr('data-action')+'/'+$("#select-product-categories").attr("data-category-group"),{
			theme: "facebook",
			hintText: "Введите название категории",
			noResultsText: "Ничего не найдено",
			searchingText: "Поиск...",
			tokenDelimiter: ','
		});
	</script>
	<script src="{{slink::path('js/vendor/redactor.min.js')}}"></script>
	<script src="{{slink::path('js/system/redactor-config.js')}}"></script>
	<script src="{{slink::path('js/vendor/dropzone.min.js')}}"></script>
@stop