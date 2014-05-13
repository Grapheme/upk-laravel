<?php

class Language extends Eloquent {
	
	protected $guarded = array();

	protected $table = 'languages';

	public static $rules = array(
		'code' => 'required|unique:languages',
		'name' => 'required'
	);

	public static function getRules(){
		
		return self::$rules;
	}

	public static function retArray(){
		
		$array = array();
		if($languages = language::all()):
			foreach($languages as $lang):
				$array[$lang->id] = array('name' => $lang->name, 'code' => $lang->code);
			endforeach;
		endif;
		return $array;
	}
}