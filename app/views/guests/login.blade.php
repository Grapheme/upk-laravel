@extends('templates.default')
@section('style')

@stop
@section('content')
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-5 col-lg-4">
			<div class="well no-padding">
				@include('guests.forms.sign-in')
			</div>
		</div>
	@if(Allow::enabled_module('users'))
		<div class="col-xs-12 col-sm-12 col-md-5 col-lg-4">
			<div class="well no-padding">
				@include('guests.forms.sign-up')
			</div>
		</div>
	@endif
	</div>
@stop
@section('scripts')
<script type="text/javascript">pageSetUp();</script>
{{HTML::script('js/account/guest.js');}}
@if(Allow::enabled_module('users'))
{{HTML::script('js/modules/users.js');}}
<script type="text/javascript">
	loadScript("{{asset('js/vendor/jquery-form.min.js');}}",moduleFormValidtion);
</script>
@else
<script type="text/javascript">
	loadScript("{{asset('js/vendor/jquery-form.min.js');}}",runFormValidation);
</script>
@endif
@stop