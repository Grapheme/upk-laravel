<?php

class Page extends Eloquent {
	
	protected $guarded = array();

	public static $rules = array(
		'name' => 'required',
		'seo_url' => 'alpha_dash'
	);

	public static function getMenu($template = 'default',$menu_template = 'menu'){
		
		$menu = array();
		if($pages = self::orderBy('sort_menu','asc')->where('in_menu',1)->get()):
			foreach($pages as $page):
				$menu[$page->seo_url] = $page->name;
			endforeach;
		endif;
		if(View::exists('templates.'.$template.'.'.$menu_template)):
			return View::make('templates.'.$template.'.'.$menu_template,compact('menu'))->render();
		elseif(View::exists('templates.default.'.$menu_template)):
			return View::make('templates.default.'.$menu_template,compact('menu'))->render();
		else:
			return App::abort(404,'Отсутсвует шаблон: templates/'.$template.'/'.$menu_template);
		endif;
		
	}
	
}
