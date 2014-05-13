<?php

class AuthAccount {
	
	public static function getStartPage($url = NULL){
		
		$StartPage = '';
		if(Auth::check()):
			$StartPage = Auth::user()->groups()->first()->dashboard;
		endif;
		if(!is_null($url)):
			return $StartPage.'.'.$url;
		else:
			return $StartPage;
		endif;
	}
	
	public static function getGroupID(){
		
		if(Auth::check()):
			return  Auth::user()->groups()->first()->id;
		else:
			return FALSE;
		endif;
	}
	
	public static function isAdminLoggined(){
		
		if(self::getGroupID() == 1):
			return TRUE;
		else:
			return FALSE;
		endif;
	}
	
	public static function isUserLoggined(){
		
		if(self::getGroupID() == 2):
			return TRUE;
		else:
			return FALSE;
		endif;
	}
}
?>