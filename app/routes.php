<?php

#################################################
## Internationalization - detect locale by url ##
#################################################
###
### Перенесено в фильтр: i18n_url
###
/*
## Возможно в будущем этот функционал нужно будет оформить в виде отдельного фильтра и применять его _перед_ нужной группой роутов (или перед каждым отдельным роутом, что менее удобно).
if (in_array(Request::segment(1), Config::get('app.locales')) ) {
    ## Если первый сегмент URL является одним из определенных в конфиге языков - переопределяем текущую локаль.
	Config::set('app.locale', Request::segment(1));
} elseif (
    Request::path() != '/' ## не главная
    && Request::segment(1) != 'admin' ## не админка - вот тут могут быть проблемы, если поменяется первый сегмент адреса админки (хоть и маловероятно). С другой стороны, если убрать это условие, то редирект на URL с языковой локалью в первом сегменте будет работать и для админки, что пригодится, когда захотим сделать и ее мультиязычной
) {
	## Если же первый сегмент URL - не локаль, и мы не на главной странице (и не в админке) - делаем 301 редирект на страницу с префиксом - языком по умолчанию
    ## Редирект выполняется стандартными методами PHP, т.к. ларавелевский Redirect::to() нифига не работает.
	$redir = "/".Config::get('app.locale')."/".Request::path();
	header("HTTP/1.1 301 Moved Permanently");
    header("Location: {$redir}");
    die;
}
#*/
#################################################

$prefix = 'guest';
if(Auth::check()):
	$prefix = AuthAccount::getStartPage();
endif;

	/*
	| Общие роутеры независящие от условий
	*/

Route::get('image/{image_group}/{id}', 'ImageController@showImage')->where('id','\d+');
Route::get('redactor/get-uploaded-images', 'DownloadsController@redactorUploadedImages');
Route::post('redactor/upload','DownloadsController@redactorUploadImage');


	/*
	| Роутеры доступные для всех групп авторизованных пользователей
	*/

Route::group(array('before'=>'auth','prefix'=>$prefix),function(){

	Route::controller('pages', 'PagesController');
	Route::controller('galleries', 'GalleriesController');
	Route::controller('downloads', 'DownloadsController');
	Route::controller('news', 'NewsController');
	Route::controller('articles','ArticlesController');

    ## I18n controllers
	Route::controller('i18n_news', 'I18nNewsController');
	Route::controller('i18n_pages', 'I18nPagesController');

	Route::delete('image/destroy/{id}', 'ImageController@deleteImage')->where('id','\d+');
	Route::post('catalogs/products/upload-product-photo', 'DownloadsController@postUploadCatalogProductImages');
	Route::post('catalogs/products/upload-product-photo/product/{product_id}', 'DownloadsController@postUploadCatalogProductImages')->where('product_id','\d+');
	Route::get('catalogs/products/search-catalog-category/{category_group_id}', 'CategoriesController@getSugestSearchCategory')->where('category_group_id','\d+');
	Route::controller('catalogs/products', 'ProductsController');
});

	/*
	| Роутеры доступные для группы Администраторы
	*/

Route::group(array('before'=>'admin.auth','prefix'=>'admin'),function(){
	Route::get('/','AdminCabinetController@mainPage');
	Route::controller('users', 'UsersController');
	Route::controller('languages', 'LangController');
	Route::controller('templates', 'TempsController');
	Route::controller('groups', 'GroupsController');
	Route::controller('settings', 'SettingsController');
	Route::controller('catalogs/categories', 'CategoriesController');
	Route::controller('catalogs/manufacturers', 'ManufacturersController');

	Route::get('catalogs/category-group/{category_group_id}/categories', 'CategoriesController@getCategoryList')->where('category_group_id','\d+');
	Route::get('catalogs/category-group/{category_group_id}/categories/create', 'CategoriesController@getCategoryCreate')->where('category_group_id','\d+');
	Route::post('catalogs/category-group/{category_group_id}/categories/store', 'CategoriesController@postCategoryStore')->where('category_group_id','\d+');
	Route::get('catalogs/category-group/{category_group_id}/categories/edit/{category_id}', 'CategoriesController@getCategoryEdit')->where('category_group_id','\d+')->where('category_id','\d+');
	Route::post('catalogs/category-group/{category_group_id}/categories/update/{category_id}', 'CategoriesController@postCategoryUpdate')->where('category_group_id','\d+')->where('category_id','\d+');
	Route::delete('catalogs/category-group/{category_group_id}/categories/destroy/{category_id}', 'CategoriesController@postCategoryDestroy')->where('category_group_id','\d+')->where('category_id','\d+');

	Route::get('catalogs/category-group/{category_group_id}/category/{parent_category_id}/sub-categories', 'CategoriesController@getCategoryList')->where('category_group_id','\d+')->where('parent_category_id','\d+');
	Route::get('catalogs/category-group/{category_group_id}/category/{parent_category_id}/sub-categories/create', 'CategoriesController@getCategoryCreate')->where('category_group_id','\d+')->where('parent_category_id','\d+');
	Route::get('catalogs/category-group/{category_group_id}/category/{parent_category_id}/sub-categories/edit/{category_id}', 'CategoriesController@getSubCategoryEdit')->where('category_group_id','\d+')->where('parent_category_id','\d+')->where('category_id','\d+');

	Route::controller('catalogs', 'CatalogsController');
});

	/*
	| Роутеры доступные для группы Пользователи
	*/

Route::group(array('before'=>'user.auth','prefix'=>'dashboard'),function(){
	Route::get('/','UserCabinetController@mainPage');
});

	/*
	| Роутеры доступные только для не авторизованных пользователей
	*/

Route::group(array('before'=>'guest','prefix'=>Config::get('app.local')),function(){
	Route::post('signin',array('as'=>'signin','uses'=>'GlobalController@signin'));
	Route::post('signup',array('as'=>'signup','uses'=>'GlobalController@signup'));
	Route::get('activation',array('as'=>'activation','uses'=>'GlobalController@activation'));
});

	/*
	| Роутеры доступные только для авторизованных пользователей "UPK"
	*/

Route::group(array('before'=>'auth','prefix'=>Config::get('app.local')),function(){
	Route::get('intranet','UserCabinetController@getSecurePageIntranet');
});

	/*
	| Роутеры доступные для гостей и авторизованных пользователей
	*/
Route::post('request-to-access',array('as'=>'request-to-access','uses'=>'GlobalController@postRequestToAccess'));

Route::get('login',array('before'=>'login','as'=>'login','uses'=>'GlobalController@loginPage'));
Route::get('logout',array('before'=>'auth','as'=>'logout','uses'=>'GlobalController@logout'));

#Route::get('/news/{news_url}','HomeController@showNews'); # i18n_news enabled
Route::get('/articles/{article_url}','HomeController@showArticle');

Route::get('catalog/{url}','HomeController@showProduct');

	/*
	| Роуты для страниц с мультиязычностью (I18N)
	*/
foreach(Config::get('app.locales') as $locale) {
	## Генерим роуты с префиксом (первый сегмент), который будет указывать на текущую локаль
	## Также указываем before-фильтр i18n_url, для выставления текущей локали
    Route::group(array('prefix' => $locale, 'before' => 'i18n_url'), function(){
        Route::get('/{url}','HomeController@showI18nPage'); ## I18n Pages
        Route::get('/', 'HomeController@showI18nPage'); ## I18n Main Page
        Route::get('/news/{url}', array('as' => 'news_full', 'uses' => 'HomeController@showI18nNews')); ## I18n News
    });
    ## Генерим те же самые роуты, но уже без префикса, и назначаем before-фильтр i18n_url
    ## Это позволяет нам делать редирект на урл с префиксом только для этих роутов, не затрагивая, например, /admin и /login
    Route::group(array('before' => 'i18n_url'), function(){
        Route::get('/{url}','HomeController@showI18nPage'); ## I18n Pages
        Route::get('/', 'HomeController@showI18nPage'); ## I18n Main Page
        
        Route::get('/news/{url}', array('as' => 'news_full',
        	function($url) {
        		return HomeController::showI18nNews($url);
        	}
        )); ## I18n News
    });
}

#Route::get('/','HomeController@showPage');

## На всякий случай объявим шаблон с ошибкой 404
App::missing(function ($exception) {
    return Response::view('error404', array(), 404);
});
