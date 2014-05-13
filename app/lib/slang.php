<?php

class slang {

	public static function get($array = NULL){
		
		foreach(Language::all() as $lang):
			$languages[] = $lang->code;
		endforeach;
		if($array == 'array'):
			return $languages;
		else:
			$locale = Request::segment(1);
			if(in_array($locale, $languages)):
				App::setLocale($locale);
			else:
				$locale = NULL;
			endif;
			return $locale;
		endif;
	}
}
