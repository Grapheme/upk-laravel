<?php

class sI18nPage {

	public static function show($url){

		if(I18nPage::count() == 0)
			return View::make('guests.wellcome');

        ## Страница /de упорно не хотела открываться, пытаясь найти страницу со slug = "de", пришлось сделать вот такой хак:
        if ($url == Config::get('app.locale'))
            $url = '';

        if ($url != '')
    		$page = I18nPage::where('slug', $url)->where('publication',1)->first();
        else
            $page = I18nPage::where('start_page', '1')->where('publication',1)->first();

		if(!is_object($page) || !$page->id)
			return App::abort(404);

        ## Если текущая страница - главная, и по какой-то необъяснимой причине у нее задан SLUG - обязательно редиректом юзера на главную страницу для его локали, чтобы не было дублей контента
        if (isset($page->slug) && $page->slug != '' && $page->slug == $url && $page->start_page == 1) {        	## А чтобы ссылка на главную страницу была правильной - делаем вот такую штуку
        	## Вся соль в том, что если в данный момент текущая локаль - дефолтная, то в slink::createLink() нужно передавать пустую строку. Дефолтная локаль устанавливается равной той же, что и 'app.locale', в файле filters.php        	$str = Config::get('app.default_locale') == Config::get('app.locale') ? "" : Config::get('app.locale');	    	Redirect(slink::createLink($str));
        }

		$page_meta = I18nPageMeta::where('page_id',$page->id)->where('language',Config::get('app.locale'))->first();
		if(!is_object($page_meta) || !$page_meta->id)
			return App::abort(404);

        #print_r($page_meta);
        #echo $page->template;

		if(!empty($page->template) && View::exists('templates.'.$page->template)):
			$content = self::content_render($page_meta->content);
			return View::make(
			    'templates.'.$page->template,
			    array(
			        'page_title' => $page_meta->seo_title,
			        'page_description' => $page_meta->seo_description,
					'page_keywords' => $page_meta->seo_keywords,
					'page_author' => '',
					'page_h1' => $page_meta->seo_h1,
					'menu' => I18nPage::getMenu($page->template),
					'content' => $content
				)
			);
		else:
			App::abort(404,'Отсутствует шаблон: templates/'.$page->template.'.php');
		endif;
	}

	public static function content_render($page_content, $page_data = NULL){

		$regs = $change = $to = array();
		preg_match_all('/\[(.*?)\]/', $page_content, $matches);
		for($j=0; $j<count($matches[0]); $j++):
			$regs[trim($matches[0][$j])] = trim($matches[1][$j]);
		endfor;
		if(!empty($regs)):
			foreach($regs as $tocange => $clear):
				if(!empty($clear)):
					$change[] = $tocange;
					$tag = explode(' ',$clear);
					if(isset($tag[0]) && $tag[0] == 'view'):
						$to[] = self::shortcode($clear, $page_data);
					else:
						$to[] = self::shortcode($clear);
					endif;
				endif;
			endforeach;
		endif;
		return str_replace($change, $to, $page_content);
	}

	private static function shortcode($clear, $data = NULL){

		$str = explode(" ", $clear);
		$type = $str[0];
		$options = NULL;
		if(isset($str[1])):
			for($i=1;$i<count($str);$i++):
				preg_match_all('/(.*?)=\"(.*?)\"/', $str[$i], $rendered);
				if(!empty($rendered[0])):
					$options[$rendered[1][0]] = $rendered[2][0];
				endif;
			endfor;
		endif;

		if(method_exists('shortcode', $type)):
			return shortcode::$type($options,$data);
		else:
			return '['.$clear.']';
		endif;
	}

}
