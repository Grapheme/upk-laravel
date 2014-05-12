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

	public static function i18n_news($options = NULL, $data = NULL){

		//Настройки по-умолчанию
		static::$config['path'] = Config::get('app-default.news_template');
		static::$config['limit'] = Config::get('app-default.news_count_on_page');
		static::$config['order'] = BaseController::stringToArray(I18nNews::$order_by);
		//Настройки переданные пользователем
		self::setUserConfig($options);
		if(Allow::enabled_module('i18n_news')):
		    ## Получаем новости, делаем LEFT JOIN с news_meta, с проверкой языка и тайтла
			$selected_news = I18nNews::where('i18n_news.publication', 1)
			                        ->leftJoin('i18n_news_meta', 'i18n_news_meta.news_id', '=', 'i18n_news.id')
			                        ->where('i18n_news_meta.language', Config::get('app.locale'))
			                        ->where('i18n_news_meta.title', '!=', '')
			                        ->select('*', 'i18n_news.id AS original_id', 'i18n_news.published_at AS created_at');

            #/*
            ## Добавляем сортировку из модели
            #print_r(static::$config['order']);
			if(!empty(static::$config['order'])):
				foreach(static::$config['order'] as $order):
					if(isset($order[1])):
						$selected_news = $selected_news->orderBy($order[0],$order[1]);
					else:
						$selected_news = $selected_news->orderBy($order[0]);
					endif;
				endforeach;
			endif;
			#*/

            #$selected_news = $selected_news->where('i18n_news_meta.wtitle', '!=', '');

            ## Получаем новости с учетом пагинации
			$news = $selected_news->paginate(static::$config['limit']);

			foreach ($news as $n => $new) {
				/*
				preg_match("~<img [^>]*?src=['\"]([^'\"]+?)['\"]~is", $new->content, $matches);
				#print_r($matches);
				$new->image = @$matches[1];
				$news[$n] = $new;
				*/
				#print_r($new); #die;
				$gall = Rel_mod_gallery::where('module', 'news')->where('unit_id', $new->original_id)->first();
				#foreach ($gall->photos as $photo) {
				#	print_r($photo->path());
				#}
				#print_r($gall->photos); die;
				$new->gall = @$gall;
				$new->image = is_object(@$gall->photos[0]) ? @$gall->photos[0]->path() : "";
				$news[$n]->$new;
			}
			
			if($news->count()):
				if(View::exists('templates.'.static::$config['path'])):
					return View::make('templates.'.static::$config['path'],compact('news'));
				else:
					return "Отсутствует шаблон: templates.".static::$config['path'];
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