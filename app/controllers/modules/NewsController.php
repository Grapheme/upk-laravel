<?php

class NewsController extends BaseController {
	
	protected $news;
	
	public function __construct(News $news){
		
		$this->news = $news;
		$this->beforeFilter('news');
	}

	public function getIndex(){
		
		$news = $this->news->all();
		return View::make('modules.news.index',compact('news'));
	}

	public function getCreate(){
		
		$this->moduleActionPermission('news','create');
		return View::make('modules.news.create',array('templates'=>Template::all(),'languages'=>Language::retArray()));
	}
	
	public function postStore(){
		
		$this->moduleActionPermission('news','create');
		$json_request = array('status'=>FALSE,'responseText'=>'','responseErrorText'=>'','redirect'=>FALSE);
		if(Request::ajax()):
			if(News::validate(Input::all())):
				self::savePageModel();
				$json_request['responseText'] = 'Новость создана';
				$json_request['redirect'] = slink::createAuthLink('news');
				$json_request['status'] = TRUE;
			else:
				$json_request['responseText'] = 'Неверно заполнены поля';
				$json_request['responseErrorText'] = News::$errors;
			endif;
		else:
			return App::abort(404);
		endif;
		return Response::json($json_request,200);
	}

	public function getEdit($id){
		
		$this->moduleActionPermission('news','edit');
		$news = $this->news->find($id);
		if(is_null($news)):
			return App::abort(404);
		endif;
		return View::make('modules.news.edit',array('news'=>$news,'templates'=>Template::all(),'languages'=>Language::retArray()));
	}

	public function postUpdate($id){
		
		$this->moduleActionPermission('news','edit');
		$json_request = array('status'=>FALSE,'responseText'=>'','responseErrorText'=>'','redirect'=>FALSE);
		if(Request::ajax()):
			if(News::validate(Input::all())):
				$news = $this->news->find($id);
				self::savePageModel($news);
				$json_request['responseText'] = 'Новость сохранена';
				$json_request['redirect'] = slink::createAuthLink('news');
				$json_request['status'] = TRUE;
			else:
				$json_request['responseText'] = 'Неверно заполнены поля';
				$json_request['responseErrorText'] = News::$errors;
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
			if($this->news->find($id)->delete()):
				$json_request['responseText'] = 'Новость удалена';
				$json_request['status'] = TRUE;
			endif;
		else:
			return App::abort(404);
		endif;
		return Response::json($json_request,200);
	}
	
	private function savePageModel($news = NULL){
		
		if(is_null($news)):
			$news = $this->news;
		endif;
		$news->title = trim(Input::get('title'));
		$news->sort = (int)News::max('sort')+1;
		$news->preview = Input::get('preview');
		$news->content = Input::get('content');
		$news->publication = 1;
		if(Allow::enabled_module('languages')):
			$news->language = Input::get('language');
		else:
			$news->language = App::getLocale();
		endif;
		if(Allow::enabled_module('templates')):
			$news->template = Input::get('template');
		else:
			$news->template = 'news';
		endif;
		if(Allow::enabled_module('seo')):
			if(is_null(Input::get('seo_url'))):
				$news->seo_url = '';
			elseif(Input::get('seo_url') === ''):
				$news->seo_url = $this->stringTranslite(Input::get('title'));
			else:
				$news->seo_url = $this->stringTranslite(Input::get('seo_url'));
			endif;
			if(Input::get('seo_title') == ''):
				$news->seo_title = $news->title;
			else:
				$news->seo_title = trim(Input::get('seo_title'));
			endif;
			$news->seo_description = Input::get('seo_description');
			$news->seo_keywords = Input::get('seo_keywords');
			$news->seo_h1 = Input::get('seo_h1');
		else:
			$news->seo_url = $this->stringTranslite(Input::get('title'));
			$news->seo_title = Input::get('title');
			$news->seo_description =$news->seo_keywords = $news->seo_h1 = '';
		endif;
		$news->save();
		$news->touch();
		return $news->id;
	}
}
