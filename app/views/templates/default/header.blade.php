<header class="header">
@if(Request::is('/'))
	<div class="logo"></div>
@else
	<a href="{{ url('/') }}" class="logo"></a>
@endif
	<div class="header-content">
		<div class="top-menu">
			<ul>
				<li class="intranet"><a href="#">Интранет</a></li>
				<div class="sign-up">
					<input type="text" placeholder="логин">
					<input type="text" placeholder="пароль">
					<a href="#" class="sign-up-btn">Войти</a>
				</div>
				<ul class="sub-nav">
					<li class="sub-item"><a href="{{ url('career') }}">Карьера</a></li>
					<li class="sub-item"><a href="{{ url('tenders') }}">Тендеры</a></li>
					<li class="sub-item"><a href="{{ url('map') }}">Карта сайта</a></li>
				</ul>
			</ul>
		</div>
		<nav class="nav">
			<ul>
				<li class="nav-item"><a href="{{ url('/') }}">Главная</a></li>
				<li class="nav-item"><a href="{{ url('about') }}">О компании</a></li>
				<li class="nav-item"><a href="{{ url('news') }}">Пресс-центр</a></li>
				<li class="nav-item"><a href="{{ url('services') }}">Услуги</a></li>
				<li class="nav-item"><a href="{{ url('investors') }}">Инвесторам</a></li>
				<ul class="contacts">
					<li class="nav-item"><a href="{{ url('contacts') }}">Контакты</a></li>
					<ul class="languages">
						<li class="language active-lang"><a href="#">RU</a></li>
						<li class="language"><a href="#">EN</a></li>
						<li class="language"><a href="#">DE</a></li>
					</ul>
				</ul>
			</ul>
		</nav>
	</div>
</header>