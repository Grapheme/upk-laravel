<?php

class settings extends Eloquent {
	
	protected $guarded = array();
	

	public static function retArray(){
		
		$array = array();
		if($settings = self::all()):
			foreach($settings as $set):
				$array[$set->name] = array('id'=>$set->id,'value'=>$set->value);
			endforeach;
		endif;
		return $array;
	}
}