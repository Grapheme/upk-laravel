<?php

class PagesController extends BaseController {

	protected $page;

	public function __construct(Page $page){
		
		$this->page = $page;
		$this->beforeFilter('pages');
	}

	public function getIndex(){
		
		$pages = $this->page->all();
		return View::make('modules.pages.index',compact('pages'));
	}

	public function getCreate(){
		
		$this->moduleActionPermission('pages','create');
		return View::make('modules.pages.create',array('templates'=>Template::all(),'languages'=>Language::all()));
	}

	public function postStore(){
		
		$this->moduleActionPermission('pages','create');
		$json_request = array('status'=>FALSE,'responseText'=>'','responseErrorText'=>'','redirect'=>FALSE);
		if(Request::ajax()):
			$validator = Validator::make(Input::all(),Page::$rules);
			if($validator->passes()):
				self::savePageModel();
				$json_request['responseText'] = 'Страница создана';
				$json_request['redirect'] = slink::createAuthLink('pages');
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
		
		$this->moduleActionPermission('pages','edit');
		$page = $this->page->find($id);
		if(is_null($page)):
			return App::abort(404);
		endif;
		return View::make('modules.pages.edit',array('page'=>$page,'templates'=>Template::all(),'languages'=>Language::all()));
	}

	public function postUpdate($id){
		
		$this->moduleActionPermission('pages','edit');
		$json_request = array('status'=>FALSE,'responseText'=>'','responseErrorText'=>'','redirect'=>FALSE);
		if(Request::ajax()):
			$validator = Validator::make(Input::all(),Page::$rules);
			if($validator->passes()):
				$page = $this->page->find($id);
				self::savePageModel($page);
				$json_request['responseText'] = 'Страница сохранена';
				$json_request['redirect'] = slink::createAuthLink('pages');
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
		
		$this->moduleActionPermission('pages','delete');
		$json_request = array('status'=>FALSE,'responseText'=>'');
		if(Request::ajax()):
			if($this->page->find($id)->delete()):
				$json_request['responseText'] = 'Страница удалена';
				$json_request['status'] = TRUE;
			endif;
		else:
			return App::abort(404);
		endif;
		return Response::json($json_request,200);
	}

	public function getMenu(){
		
		$bread = "Menu";
		$pages = $this->page->all();
		$pages = $pages->sortBy('sort_menu');
		return View::make('modules.pages.menu',compact('bread', 'pages'));
	}

	public function postSort(){
		
		$sorts = json_decode(Input::get('menu'));
		foreach($sorts as $key => $sort):
			//print_r(Page::find($sort)->get());/*->update(array('sort_menu' => $key));*/
			$model = Page::find($sort);
			$model->sort_menu = $key;
			$model->save();
		endforeach;
	}

	private function savePageModel($page = NULL){
		
		if(is_null($page)):
			$page = $this->page;
		endif;
		$page->name = trim(Input::get('name'));
		$page->in_menu = (is_null(Input::get('in_menu')))?0:Input::get('in_menu');
		$page->sort_menu = (int)Page::max('sort_menu')+1;
		$page->content = Input::get('content');
		$page->publication = 1;
		if(Allow::enabled_module('languages')):
			$page->language = Input::get('language');
		else:
			$page->language = App::getLocale();
		endif;
		if(Allow::enabled_module('templates')):
			$page->template = Input::get('template');
		else:
			$page->template = 'default';
		endif;
		if(Allow::enabled_module('seo')):
			if(is_null(Input::get('seo_url'))):
				$page->seo_url = '';
			elseif(Input::get('seo_url') === ''):
				$page->seo_url = $this->stringTranslite(Input::get('name'));
			else:
				$page->seo_url = $this->stringTranslite(Input::get('seo_url'));
			endif;
			if(Input::get('seo_title') == ''):
				$page->seo_title = $page->name;
			else:
				$page->seo_title = trim(Input::get('seo_title'));
			endif;
			$page->seo_description = Input::get('seo_description');
			$page->seo_keywords = Input::get('seo_keywords');
			$page->seo_h1 = Input::get('seo_h1');
		else:
			$page->seo_url = $this->stringTranslite(Input::get('name'));
			$page->seo_title = Input::get('title');
			$page->seo_description =$page->seo_keywords = $page->seo_h1 = '';
		endif;
		if($page::count() == 0 || $page->start_page == 1):
			$page->seo_url = '';
			$page->start_page = 1;
		endif;
		$page->save();
		$page->touch();
		return $page->id;
	}

}
