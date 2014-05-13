<?php

class BaseController extends Controller {

	var $breadcrumb = array();

	public function __construct(){
	}

	protected function setupLayout(){

		if(!is_null($this->layout)):
			$this->layout = View::make($this->layout);
		endif;
	}

	public static function moduleActionPermission($module_name,$module_action){

		if(Auth::check()):
			if(!Allow::valid_action_permission($module_name,$module_action)):
				return App::abort(403);
			endif;
		else:
			return App::abort(404);
		endif;
	}

	public static function stringTranslite($string){

		$rus = array("1","2","3","4","5","6","7","8","9","0","ё","й","ю","ь","ч","щ","ц","у","к","е","н","г","ш","з","х","ъ","ф","ы","в","а","п","р","о","л","д","ж","э","я","с","м","и","т","б","Ё","Й","Ю","Ч","Ь","Щ","Ц","У","К","Е","Н","Г","Ш","З","Х","Ъ","Ф","Ы","В","А","П","Р","О","Л","Д","Ж","Э","Я","С","М","И","Т","Б"," ");
		$eng = array("1","2","3","4","5","6","7","8","9","0","yo","iy","yu","","ch","sh","c","u","k","e","n","g","sh","z","h","","f","y","v","a","p","r","o","l","d","j","е","ya","s","m","i","t","b","Yo","Iy","Yu","CH","","SH","C","U","K","E","N","G","SH","Z","H","","F","Y","V","A","P","R","O","L","D","J","E","YA","S","M","I","T","B","-");
		$string = str_replace($rus,$eng,trim($string));
		if(!empty($string)):
			$string = preg_replace('/[^a-z0-9-]/','',strtolower($string));
//			$string = preg_replace('/[^a-z0-9-\.]/','',strtolower($string));
			$string = preg_replace('/[-]+/','-',$string);
			//$string = preg_replace('/[\.]+/','.',$string);
			return $string;
		else:
			return FALSE;
		endif;
	}

	/*
	| Функция возвращает 2х-мерный массив который формируется из строки.
	| Строка сперва разбивается по запятой, потом по пробелам.
	| Используется пока для разбора строки сортировки model::orderBy() в библиотеке ShortCode
	*/
	public static function stringToArray($string){

		$ordering = array();
		if(!empty($string)):
			if($order_by = explode(',',$string)):
				foreach($order_by as $index => $order):
					if($single_orders = explode(' ',$order)):
						foreach($single_orders as $single_order):
							$ordering[$index][] = strtolower($single_order);
						endforeach;
					endif;
				endforeach;
			endif;
		endif;
		return $ordering;
	}
}