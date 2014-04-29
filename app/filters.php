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