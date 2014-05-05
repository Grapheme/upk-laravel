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

		if(!is_null($link) && $link != "/"):
			$link = '/'.$link;
		endif;
		#$locale = slang::get();
		$locale = Config::get("app.locale");
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

		if(Auth::check()):
			return self::createLink(AuthAccount::getStartPage().$link);
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
}