<?php

class I18nNewsController extends BaseController {

	protected $news;

	public function __construct(I18nNews $news, I18nNewsMeta $news_meta){

		$this->news = $news;
		$this->news_meta = $news_meta;
		$this->beforeFilter('news');
        $this->locales = Config::get('app.locales');
	}

	public function getIndex(){

		#$news = $this->news->all();
		$news = $this->news->orderBy('published_at', 'DESC')->get();
		#return View::make('modules.i18n_news.index',compact('news'));
		return View::make('modules.i18n_news.index',array('news' => $news, 'locales' => $this->locales));
	}

	public function getCreate(){

		$this->moduleActionPermission('news','create');
		return View::make('modules.i18n_news.create',array('templates'=>Template::all(), 'languages'=>Language::all(), 'locales' => $this->locales));
	}

	public function postStore(){

		$this->moduleActionPermission('news','create');
		$json_request = array('status'=>FALSE,'responseText'=>'','responseErrorText'=>'','redirect'=>FALSE);
		if(Request::ajax()):
			$validator = Validator::make(Input::all(), I18nNews::$rules);

			if($validator->passes()):

			    #$json_request['responseText'] = "<pre>" . print_r($_POST, 1) . "</pre>";
			    #return Response::json($json_request,200);

				self::saveNewsModel();
				$json_request['responseText'] = 'Новость создана';
				$json_request['redirect'] = slink::createAuthLink('i18n_news');
				$json_request['status'] = TRUE;
			else:
				$json_request['responseText'] = 'Неверно заполнены поля';
				$json_request['responseErrorText'] = $validator->messages()->all();
			endif;
		else:
			return App::abort(404);
		endif;
		return Response::json($json_request,200);
	}

	public function getEdit($id){

		$this->moduleActionPermission('news','edit');
		$news = $this->news->find($id);
		if(is_null($news))
			return App::abort(404);
        #print_r($page);

        $metas = $this->news_meta->where('news_id', $news->id)->get();
		if(is_null($metas))
			return App::abort(404);

        foreach ($metas as $m => $meta) {
        	$news_meta[$meta->language] = $meta;
        }
        #print_r($news_meta);

		$gall = Rel_mod_gallery::where('module', 'news')->where('unit_id', $id)->first();
		#print_r($gall->photos);

		return View::make('modules.i18n_news.edit',array('news'=>$news, 'news_meta'=>@$news_meta, 'templates'=>Template::all(),'languages'=>Language::all(), 'locales' => $this->locales, 'gall' => $gall));
	}

	public function postUpdate($id){

		$this->moduleActionPermission('news','edit');
		$json_request = array('status'=>FALSE,'responseText'=>'','responseErrorText'=>'','redirect'=>FALSE);
		if(Request::ajax()):
			$validator = Validator::make(Input::all(), I18nNews::$rules);
			if($validator->passes()):

			    #$json_request['responseText'] = "<pre>" . print_r($_POST, 1) . "</pre>";
			    #return Response::json($json_request,200);

				$news = $this->news->find($id);
				self::saveNewsModel($news);
				$json_request['responseText'] = 'Новость сохранена';
				$json_request['redirect'] = slink::createAuthLink('i18n_news');
				$json_request['status'] = TRUE;
			else:
				$json_request['responseText'] = 'Неверно заполнены поля';
				$json_request['responseErrorText'] = $validator->messages()->all();
			endif;
		else:
			return App::abort(404);
		endif;
		return Response::json($json_request,200);
	}

	public function deleteDestroy($id){

		$this->moduleActionPermission('news','delete');
		$json_request = array('status'=>FALSE,'responseText'=>'');
		if(Request::ajax()):
            ## Следующая строка почему-то не работает:
		    #$b = $this->news_meta->where('news_id', $id)->delete;
		    ## Ну да ладно, удалим все языковые версии вот так:
		    $metas = $this->news_meta->where('news_id', $id)->get();
		    foreach ($metas as $meta)
		        @$meta->delete();
		    ## Удаляем саму страницу
		    $a = @$this->news->find($id)->delete();
            ## Возвращаем сообщение чт овсе ОК
			#if( $a && $b ):
				$json_request['responseText'] = 'Новость удалена';
				$json_request['status'] = TRUE;
			#endif;
		else:
			return App::abort(404);
		endif;
		return Response::json($json_request,200);
	}

	private function saveNewsModel($news = NULL){

		if(is_null($news)):
			$news = $this->news;
		endif;

        ## Собираем значения объекта
		if(Allow::enabled_module('templates')):
			$news->template = Input::get('template');
		else:
			$news->template = 'default';
		endif;
		$news->publication = 1;
		$news->published_at = date("Y-m-d", strtotime(Input::get('published_at')));
		$slug = Input::get('slug');
		if (!$slug) {
		    foreach($this->locales as $locale) {
    			if(Input::get('title.' . $locale) != '') {
    				$slug = $this->stringTranslite(Input::get('title.' . $locale));
    				if ($slug != '')
    				    break;
    	        }
		    }
		}
		$news->slug = $slug;
		## Сохраняем в БД
        $news->save();
		$news->touch();

        ## ID (только что созданный, или сохраненный ранее)
        $news_id = $news->id;
        #$news_id = 111; ## Для дебага

		#return "<pre>" . print_r($news, 1) . "</pre>";

        ## Перебираем все локали и создаем объекты _meta для каждой языковой версии
		foreach($this->locales as $locale) {
    		#$news->name = (Input::get('name.' . $locale));

            ## Ищем нужную языковую версию текущей новости
            $news_meta = I18nNewsMeta::where('news_id', $news_id)->where('language', $locale)->first();
            ## Если ее нет - создаем новую
            if (!isset($news_meta) || !$news_meta->id)
                $news_meta = new I18nNewsMeta;
            ## Заполняем свойства новости переданными данными
            $news_meta->news_id = $news_id;
            $news_meta->language = $locale;
            $news_meta->title = Input::get('title.' . $locale);
            $news_meta->preview = Input::get('preview.' . $locale);
            $news_meta->content = Input::get('content.' . $locale);
    		if(Allow::enabled_module('seo')):
    			if(is_null(Input::get('seo_url.' . $locale))):
    				$news_meta->seo_url = '';
    			elseif(Input::get('seo_url.' . $locale) === ''):
    				$news_meta->seo_url = $this->stringTranslite(Input::get('title.' . $locale));
    			else:
    				$news_meta->seo_url = $this->stringTranslite(Input::get('seo_url.' . $locale));
    			endif;
    			$news_meta->seo_url = (string)$news_meta->seo_url;
    			if(Input::get('seo_title.' . $locale) == ''):
    				$news_meta->seo_title = $news_meta->title;
    			else:
    				$news_meta->seo_title = trim(Input::get('seo_title.' . $locale));
    			endif;
    			$news_meta->seo_description = Input::get('seo_description.' . $locale);
    			$news_meta->seo_keywords = Input::get('seo_keywords.' . $locale);
    			$news_meta->seo_h1 = Input::get('seo_h1.' . $locale);
    		else:
    			$news_meta->seo_url = $this->stringTranslite(Input::get('title.' . $locale));
    			$news_meta->seo_title = Input::get('title.' . $locale);
    			$news_meta->seo_description = $page->seo_keywords = $page->seo_h1 = '';
    		endif;

    		## Дебаг перед сохранением
    		#return "<pre>" . print_r($news_meta, 1) . "</pre>";

            ## Сохраняем языковую версию в БД
            $news_meta->save();
            $news_meta->touch();
		}

		## Работа с загруженными изображениями
		$images = @Input::get('uploaded_images');
		$gallery_id = @Input::get('gallery_id');
		if (@count($images)) {

			#$gallery_id = GalleriesController::moveImagesToGallery($images, $gallery_id);
			#GalleriesController::relModuleUnitGallery('news', $news->id, $gallery_id);

			GalleriesController::imagesToUnit($images, 'news', $news->id, $gallery_id);	
		}

		return $news->id;
	}
}


