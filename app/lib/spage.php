<?php

class sPage {
	
	public static function show($url){
		
		if(Page::count() == 0):
			return View::make('guests.wellcome');
		endif;
		if(!$page = Page::where('seo_url',$url)->where('publication',1)->where('language',Config::get('app.locale'))->first()):
			return App::abort(404);
		endif;
		if(!empty($page->template) && View::exists('templates.'.$page->template)):
			$content = self::content_render($page->content);
			return View::make('templates.'.$page->template,array('page_title'=>$page->seo_title,'page_description'=>$page->seo_description,
					'pege_keywords'=>$page->seo_keywords,'page_author'=>'','page_h1'=>$page->seo_h1,'menu'=> Page::getMenu($page->template),'content' => $content));
		else:
			App::abort(404,'Отсутсвует шаблон: templates/'.$page->template.'.php');
		endif;
	}
	
	public static function content_render($page_content,$page_data = NULL){
		
		$regs = $change = $to = array();
		preg_match_all('/\[(.*?)\]/',$page_content,$matches);
		for($j=0;$j<count($matches[0]);$j++):
			$regs[trim($matches[0][$j])] = trim($matches[1][$j]);
		endfor;
		if(!empty($regs)):
			foreach($regs as $tocange => $clear):
				if(!empty($clear)):
					$change[] = $tocange;
					$tag = explode(' ',$clear);
					if(isset($tag[0]) && $tag[0] == 'view'):
						$to[] = self::shortcode($clear,$page_data);
					else:
						$to[] = self::shortcode($clear);
					endif;
				endif;
			endforeach;
		endif;
		return str_replace($change,$to,$page_content);
	}
	
	private static function shortcode($clear,$data = NULL){

		$str = explode(" ",$clear);
		$type = $str[0];
		$options = NULL;
		if(isset($str[1])):
			for($i=1;$i<count($str);$i++):
				preg_match_all('/(.*?)=\"(.*?)\"/',$str[$i],$rendered);
				if(!empty($rendered[0])):
					$options[$rendered[1][0]] = $rendered[2][0];
				endif;
			endfor;
		endif;
			
		if(method_exists('shortcode',$type)):
			return shortcode::$type($options,$data);
		else:
			return '['.$clear.']';
		endif;
	}

}
