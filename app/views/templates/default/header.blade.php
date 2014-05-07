<header class="header">
@if(Request::is('/'))
	<div class="logo logo-{{Config::get('app.locale')}}"></div>
@else
	<a href="{{ slink::createLink2('/') }}" class="logo logo-{{Config::get('app.locale')}}"></a>
@endif
	<div class="header-content">
		<div class="top-menu">
			<ul>
			@if(Auth::guest())
				<li class="intranet"><a href="javascript:void(0);">{{ trans('interface.MENU_INTRANET') }}</a></li>
				{{ Form::open(array('route'=>'signin','role'=>'form','class'=>'sign-up','id'=>'signin-secure-page-form-1')) }}
					<input type="text" name="login" placeholder="{{ trans('interface.FORM_INPUT_PLACEHOLDER_LOGIN') }}">
					<input type="password" name="password" placeholder="{{ trans('interface.FORM_INPUT_PLACEHOLDER_PASSWORD') }}">
					<button type="submit" class="sign-up-btn">{{ trans('interface.FORM_SIGNIN_SUBMIT') }}</button>
				{{ Form::close() }}
			@else
				<li class="intranet"><a href="{{ slink::createLink2(Config::get('app-default.secure_page_link')) }}">{{ trans('interface.MENU_INTRANET') }}</a></li>
			@endif
				<ul class="sub-nav">
					<li class="sub-item"><a href="{{ slink::createLink2('career') }}">{{ trans('interface.MENU_CAREER') }}</a></li>
					<li class="sub-item"><a href="{{ slink::createLink2('tenders') }}">{{ trans('interface.MENU_TENDERS') }}</a></li>
					<li class="sub-item"><a href="{{ slink::createLink2('sitemap') }}">{{ trans('interface.MENU_SITEMAP') }}</a></li>
				</ul>
			</ul>
		</div>
		<nav class="nav">
			<ul>
				<li class="nav-item"><a href="{{ slink::createLink2('/') }}">{{ trans('interface.MENU_INDEX') }}</a></li>
				<li class="nav-item"><a href="{{ slink::createLink2('about') }}">{{ trans('interface.MENU_ABOUT') }}</a></li>
				<li class="nav-item"><a href="{{ slink::createLink2('news') }}">{{ trans('interface.MENU_NEWS') }}</a></li>
				<li class="nav-item"><a href="{{ slink::createLink2('services') }}">{{ trans('interface.MENU_SERVICES') }}</a></li>
				<li class="nav-item"><a href="{{ slink::createLink2('investors') }}">{{ trans('interface.MENU_INVESTORS') }}</a></li>
				<ul class="contacts">
					<li class="nav-item"><a href="{{ slink::createLink2('contacts') }}">{{ trans('interface.MENU_CONTACTS') }}</a></li>
					<ul class="languages">
						 <li class="language{{ (Config::get("app.locale")=='ru'?" active-lang":"") }}"><a href="/ru">RU</a>
						<li class="language{{ (Config::get("app.locale")=='en'?" active-lang":"") }}"><a href="/en">EN</a>
						<li class="language{{ (Config::get("app.locale")=='de'?" active-lang":"") }}"><a href="/de">DE</a>
					</ul>
				</ul>
			</ul>
		</nav>
	</div>
</header>