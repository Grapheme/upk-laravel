<?php

class shortcode {
	
	public static $config = array('path'=>'','name'=>'','limit'=>'','order'=>'');
	
	public static function view($options, $data = NULL){

		if(isset($options['path'])):
			if(View::exists($options['path'])):
				if(!is_null($data) && is_array($data)):
					return View::make($options['path'],$data);
				else:
					return View::make($options['path']);
				endif;
			else: 
				return "Отсутсвует шаблон: ".$options['path'];
			endif;
		else:
			return "Путь к представлению не указан";
		endif;
	}

	public static function news($options = NULL, $data = NULL){
		
		//Настройки по-умолчанию
		static::$config['path'] = Config::get('app-default.news_template');
		static::$config['limit'] = Config::get('app-default.news_count_on_page');
		static::$config['order'] = BaseController::stringToArray(News::$order_by);
		//Настройки переданные пользователем
		self::setUserConfig($options);
		if(Allow::enabled_module('news')):
			$selected_news = News::where('publication',1)->where('language',Config::get('app.locale'));
			if(!empty(static::$config['order'])):
				foreach(static::$config['order'] as $order):
					if(isset($order[1])):
						$selected_news = $selected_news->orderBy($order[0],$order[1]);
					else:
						$selected_news = $selected_news->orderBy($order[0]);
					endif;
				endforeach;
			endif;
			$news = $selected_news->paginate(static::$config['limit']);
			if($news->count()):
				if(View::exists('templates.'.static::$config['path'])):
					return View::make('templates.'.static::$config['path'],compact('news'));
				else: 
					return "Отсутсвует шаблон: templates.".static::$config['path'];
				endif;
			endif;
		else:
			return '';
		endif;
	}
	
	public static function articles($options = NULL, $data = NULL){
		
		//Настройки по-умолчанию
		static::$config['path'] = Config::get('app-default.articles_template');
		static::$config['limit'] = Config::get('app-default.articles_count_on_page');
		static::$config['order'] = BaseController::stringToArray(Article::$order_by);
		//Настройки переданные пользователем
		self::setUserConfig($options);
		if(Allow::enabled_module('articles')):
			$selected_articles = Article::where('publication',1)->where('language',Config::get('app.locale'));
			if(!empty(static::$config['order'])):
				foreach(static::$config['order'] as $order):
					if(isset($order[1])):
						$selected_articles = $selected_articles->orderBy($order[0],$order[1]);
					else:
						$selected_articles = $selected_articles->orderBy($order[0]);
					endif;
				endforeach;
			endif;
			$articles = $selected_articles->paginate(static::$config['limit']);
			if($articles->count()):
				if(View::exists('templates.'.static::$config['path'])):
					return View::make('templates.'.static::$config['path'],compact('articles'));
				else: 
					return "Отсутсвует шаблон: templates.".static::$config['path'];
				endif;
			endif;
		else:
			return '';
		endif;
	}
	
	public static function catalog($options = NULL, $data = NULL){
		
		//Настройки по-умолчанию
		static::$config['path'] = Config::get('app-default.catalog_template');
		static::$config['limit'] = Config::get('app-default.catalog_count_on_page');
		static::$config['order'] = BaseController::stringToArray(Product::$order_by);
		$catalog = Catalog::where('language',Config::get('app.locale'))->first();
		if(is_null($catalog)):
			return "Отсутствуют каталоги продукции!";
		endif;
		static::$config['name'] = $catalog->title;
		//Настройки переданные пользователем
		self::setUserConfig($options);
		if(Allow::enabled_module('catalog')):
			$catalog = Catalog::where('language',Config::get('app.locale'))->where('title',static::$config['name'])->first();
			if(is_null($catalog)):
				return "Отсутсвует каталоги продукции: ".static::$config['name'];
			endif;
			$selected_products = Product::where('publication',1)->where('language',Config::get('app.locale'))->where('catalog_id',$catalog->id);
			if(!empty(static::$config['order'])):
				foreach(static::$config['order'] as $order):
					if(isset($order[1])):
						$selected_products = $selected_products->orderBy($order[0],$order[1]);
					else:
						$selected_products = $selected_products->orderBy($order[0]);
					endif;
				endforeach;
			endif;
			$products = $selected_products->paginate(static::$config['limit']);
			if($products->count()):
				if(View::exists('templates.'.static::$config['path'])):
					return View::make('templates.'.static::$config['path'],compact('products'));
				else: 
					return "Отсутсвует шаблон: templates.".static::$config['path'];
				endif;
			endif;
		else:
			return '';
		endif;
		
	}
	
	public static function gallery($options = NULL, $data = NULL){
		
		if(isset($options['name'])){
			$name = $options['name'];
	        if(gallery::where('name', $name)->exists()){
	        	$gall = gallery::where('name', $name)->first();
	        	$photos = $gall->photos;
	        	$str = "";
	        	foreach($photos as $photo)
	        	{
	        		$str .= "<li><img src=\"{$photo->path()}\" alt=\"\" style=\"max-width: 150px;\"></li>";
	        	}
	        	return "<ul>".$str."</ul>";

	        } else {
	        	return "Error: Gallery {$name} doesn't exist";
	        }
	    } else {
			return "Error: name of gallery is not defined!";
		}
	}
	
	public static function map($options){
		if(!isset($options['width'])) 	$options['width'] = '500';
		if(!isset($options['height'])) 	$options['height'] = '500';
		if(!isset($options['zoom'])) 	$options['zoom'] = '5';
		//Default options

		if(!isset($options['title'])) 	{ $title = null; } 		else { $title = "hintContent: '{$options['title']}'"; }
		if(!isset($options['preview']))	{ $preview = null; }	else { $preview = "balloonContent: '{$options['preview']}'"; }
		
		if( $title == null && $preview == null)
		{
			$placemark = null;
		} else {
			$placemark = 	'myPlacemark = new ymaps.Placemark(['.$options['position'].'], {
			                '.$title.'
			                '.$preview.'
			            	});
							myMap.geoObjects.add(myPlacemark);';
		}

		$map = '<script src="http://api-maps.yandex.ru/2.0-stable/?load=package.standard&lang=ru-RU" type="text/javascript"></script>
			    <script type="text/javascript">
			        ymaps.ready(init);
			        var myMap, 
			            myPlacemark;

			        function init(){ 
			            myMap = new ymaps.Map ("map", {
			                center: ['.$options['position'].'],
			                zoom: '.$options['zoom'].'
			            }); 
			            '.$placemark.'
			        }
			    </script>';
		$div = '<div id="map" style="width: '.$options['width'].'px; height: '.$options['height'].'px;"></div>';
		return $map.$div;
	}

	private static function setUserConfig($options){
		
		if(!is_null($options) && !empty($options)):
			if(isset($options['field']) && !empty($options['field'])):
				static::$config['order'] = array();
				static::$config['order'][0] = array($options['field'],'asc');
				if(isset($options['direction']) && !empty($options['direction'])):
					static::$config['order'][0] = array($options['field'],$options['direction']);
				endif;
			endif;
			unset($options['field']);
			unset($options['direction']);
			foreach($options as $option => $value):
				if(!empty($value)):
					static::$config[$option] = $value;
				endif;
			endforeach;
		endif;
	}
}