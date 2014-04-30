<header class="header">
@if(Request::is('/'))
	<div class="logo"></div>
@else
	<a href="{{ url('/') }}" class="logo"></a>
@endif
	<div class="header-content">
		<div class="top-menu">
			<ul>
			@if(Auth::guest())
				<li class="intranet"><a href="javascript:void(0);">{{ trans('interface.MENU_INTRANET') }}</a></li>
				{{ Form::open(array('route'=>'signin','role'=>'form','class'=>'sign-up','id'=>'signin-secure-page-form-1')) }}
					<input type="text" name="login" placeholder="логин">
					<input type="password" name="password" placeholder="пароль">
					<button type="submit" class="sign-up-btn">Войти</button>
				{{ Form::close() }}
			@else
				<li class="intranet"><a href="{{ url(Config::get('app-default.secure_page_link')) }}">{{ trans('interface.MENU_INTRANET') }}</a></li>
			@endif
				<ul class="sub-nav">
					<li class="sub-item"><a href="{{ url('career') }}">{{ trans('interface.MENU_CAREER') }}</a></li>
					<li class="sub-item"><a href="{{ url('tenders') }}">{{ trans('interface.MENU_TENDERS') }}</a></li>
					<li class="sub-item"><a href="{{ url('sitemap') }}">{{ trans('interface.MENU_SITEMAP') }}</a></li>
				</ul>
			</ul>
		</div>
		<nav class="nav">
			<ul>
				<li class="nav-item"><a href="{{ url('/') }}">{{ trans('interface.MENU_INDEX') }}</a></li>
				<li class="nav-item"><a href="{{ url('about') }}">{{ trans('interface.MENU_ABOUT') }}</a></li>
				<li class="nav-item"><a href="{{ url('news') }}">{{ trans('interface.MENU_NEWS') }}</a></li>
				<li class="nav-item"><a href="{{ url('services') }}">{{ trans('interface.MENU_SERVICES') }}</a></li>
				<li class="nav-item"><a href="{{ url('investors') }}">{{ trans('interface.MENU_INVESTORS') }}</a></li>
				<ul class="contacts">
					<li class="nav-item"><a href="{{ url('contacts') }}">{{ trans('interface.MENU_CONTACTS') }}</a></li>
					<ul class="languages">
						 <li class="language"><a href="#">RU</a>
						<li class="language"><a href="#">EN</a>
						<li class="language"><a href="#">DE</a>
					</ul>
				</ul>
			</ul>
		</nav>
	</div>
</header>