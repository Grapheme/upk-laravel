<?php

class BaseModel extends Eloquent {
	
	public static $errors = array();

	public static function validate($data,$rules = NULL,$messages = array()){
		
		if(is_null($rules)):
			$rules = static::$rules;
		endif;
		$validation = Validator::make($data,$rules,$messages);
		if($validation->fails()):
			static::$errors = $validation->messages()->all();
			return FALSE;
		endif;
		return TRUE;
	}

}