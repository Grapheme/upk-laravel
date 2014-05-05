<?php

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