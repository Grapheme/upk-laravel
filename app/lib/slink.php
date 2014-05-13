<?php

################################################################################
#### Базовая функция для генерации URL-адресов ДЛЯ ОБЩЕДОСТУПНОЙ ЧАСТИ САЙТА (в случае использования мультиязычности).
################################################################################
## _url("/") => "/" - в случае, если язык дефолтный
## _url("/") => "/de" - в случае, если язык НЕ дефолтный
## _url("/about") => "/ru/about" - добавление префикса языка в любом случае, если не главная страница
################################################################################
#### В админке ссылки генерятся через slink::createLink()
################################################################################
function _url($link = false) {
	if (!$link)
	    return false;
	return slink::createLink2($link);
}

class slink {

	public static function createLink($link = NULL){

        #if ($link == "/")
        #    return url("/" . Config::get("app.locale"));

		if(!is_null($link) && $link != "/"):
			$link = '/'.$link;
		endif;
		$locale = slang::get();
		#$locale = Config::get("app.locale");
		if(!is_null($locale)):
			$string = $locale.(mb_substr($link,0,1)!="/"?"/":"").$link;
			if(Request::secure()):
				return secure_url($string);
			else:
				return url($string);
			endif;
		else:
			return url($link);
		endif;
	}

	public static function createLink2($link = NULL){

  		if(!is_null($link) && $link != "/" && mb_substr($link, 0, 1) != '/'):
			$link = '/'.$link;
		endif;

        ## Берем локаль из сесссии
        $locale_session = Session::get('locale');
        #echo "session locale = " . $locale_session; die;
        ## Если в сессии пусто - берем локаль из конфига
		$locale = Config::get("app.locale");
		if (isset($locale_session) && $locale_session != '' && $locale_session != $locale)
		    $locale = $locale_session;
        ## Сохраняем локаль в сессию
        Session::put('locale', $locale);

		if(!is_null($locale)):
			$string = $locale.(mb_substr($link,0,1)!="/"?"/":"").$link;
			if(Request::secure()):
				return secure_url($string);
			else:
				return url($string);
			endif;
		else:
			return url($link);
		endif;
	}

	public static function createAuthLink($link = NULL){

		if(!is_null($link)):
			$link = '/'.$link;
		endif;

        $_locale = Session::get('locale');
        #echo $_locale . " | ";
		#echo self::createLink2( AuthAccount::getStartPage().$link ); die;

		if(Auth::check()):
		    if (AuthAccount::isAdminLoggined())
    			return self::createLink(AuthAccount::getStartPage().$link);
            else
                return _url(AuthAccount::getStartPage().$link);
		else:
			return url($link);
		endif;
	}

	public static function path($link){

		if(ssl::is()):
			return secure_asset($link);
		else:
			return asset($link);
		endif;
	}

	public static function segment($n){

		if(!is_null(slang::get())):
			$n++;
		endif;
		return Request::segment($n);
	}
	
	public static function to($link) {
		return self::createLink($link);
	}
}