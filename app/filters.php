<?php

App::before(function($request){
	//
});

App::after(function($request, $response){
	//
});

App::error(function(Exception $exception, $code){

	switch($code):
		case 403: return 'Access denied!';
		case 404:
			if(Page::where('seo_url','404')->exists()):
				return spage::show('404',array('message'=>$exception->getMessage()));
			else:
				return View::make('error404',array('message'=>$exception->getMessage()));
			endif;
	endswitch;
});

Route::filter('auth', function(){

	if(Auth::guest()):
		return App::abort(404);
	endif;
});

Route::filter('login', function(){
	if(Auth::check()):
		return Redirect::to(AuthAccount::getStartPage());
	endif;
});

Route::filter('auth.basic', function(){
	return Auth::basic();
});

Route::filter('admin.auth', function(){

	if(!AuthAccount::isAdminLoggined()):
		return Redirect::to('/');
	endif;
});

Route::filter('user.auth', function(){

	if(!AuthAccount::isUserLoggined()):
		return Redirect::to('/');
	endif;
});

/*
|--------------------------------------------------------------------------
| Permission Filter
|--------------------------------------------------------------------------
*/
if(Auth::check()):
	Allow::modulesFilters();
endif;

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
*/

Route::filter('guest', function(){
	if(Auth::check()):
		return Redirect::to('/');
	endif;
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
*/

Route::filter('csrf', function(){
	if (Session::token() != Input::get('_token')):
		throw new Illuminate\Session\TokenMismatchException;
	endif;
});

/*
|--------------------------------------------------------------------------
| Internationalization-in-url filter (I18N)
|--------------------------------------------------------------------------
*/

/*
Route::filter('detectLang', function($lang = "auto") {
    if($lang != "auto" && in_array($lang , Config::get('app.locales'))) {
        Config::set('app.locale', $lang);
    } else {
        $browser_lang = !empty($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? strtok(strip_tags($_SERVER['HTTP_ACCEPT_LANGUAGE']), ',') : '';
        $browser_lang = substr($browser_lang, 0,2);
        $userLang = (in_array($browser_lang, Config::get('app.available_language'))) ? $browser_lang : Config::get('app.locale');
        Config::set('app.locale', $userLang);
    }
});
*/

Route::filter('i18n_url', function(){
    ####
    #### Работает в паре с кодом в app/start/global.php !!!
    ####
	## Если мы на главной странице - просто сохраним текущую локаль в сессию.
	if (Request::path() == "/") {
		## Сохраним в сессию дефолтную локаль
    	Session::put('locale', Config::get('app.locale'));
    	## Дальше ничего не выполняется
	}
    ## Если мы находимся на главной странице дефолтного языка - редиректим на / (чтобы не было дублей главной страницы)
	if (Request::path() == Config::get('app.default_locale')) {
		## Сохраним в сессию дефолтную локаль
    	Session::put('locale', Config::get('app.locale'));
    	Redirect("/");
	}
    ## Если первый сегмент URL является одним из определенных в конфиге языков - переопределяем текущую локаль.
    if (in_array(Request::segment(1), Config::get('app.locales')) ) {
    	Config::set('app.locale', Request::segment(1));
    	Session::put('locale', Request::segment(1));
    } elseif (
        Request::path() != '/' ## не главная
        #&& Request::segment(1) != 'admin' ## не админка - вот тут могут быть проблемы, если поменяется первый сегмент адреса админки (хоть и маловероятно). С другой стороны, если убрать это условие, то редирект на URL с языковой локалью в первом сегменте будет работать и для админки, что пригодится, когда захотим сделать и ее мультиязычной
    ) {
    	## Если же первый сегмент URL - не локаль, то делаем 301 редирект на страницу с префиксом - языком по умолчанию
        ## Редирект выполняется стандартными методами PHP, т.к. ларавелевский Redirect::to() нифига не работает.
    	$redir = "/".Config::get('app.locale')."/".Request::path();
    	Redirect($redir);
    }
});

function Redirect($url = '', $code = '301 Moved Permanently') {
	header("HTTP/1.1 {$code}");
    header("Location: {$url}");
    die;
}

## Выводит на экран все SQL-запросы
#Event::listen('illuminate.query',function($query){ echo "<pre>" . print_r($query, 1) . "</pre>\n"; });
