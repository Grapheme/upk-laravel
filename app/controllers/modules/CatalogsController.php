<?php

class CatalogsController extends \BaseController {
	
	protected $catalog;
	
	public function __construct(Catalog $catalog){
		
		$this->catalog = $catalog;
		$this->beforeFilter('catalogs');
	}
	
	public function getIndex(){
		
		$catalogs = $this->catalog->all();
		return View::make('modules.catalogs.index', compact('catalogs'));
	}

	public function getCreate(){
		
		$this->moduleActionPermission('catalogs','create');
		return View::make('modules.catalogs.create',array('templates'=>Template::all(),'languages'=>Language::all()));
	}
	
	public function postStore(){
		
		$this->moduleActionPermission('catalogs','create');
		$json_request = array('status'=>FALSE,'responseText'=>'','responseErrorText'=>'','redirect'=>FALSE);
		if(Request::ajax()):
			if(Catalog::validate(Input::all())):
				self::saveCatalogModel();
				$json_request['responseText'] = 'Каталог создан';
				$json_request['redirect'] = slink::createAuthLink('catalogs');
				$json_request['status'] = TRUE;
			else:
				$json_request['responseText'] = 'Неверно заполнены поля';
				$json_request['responseErrorText'] = Catalog::$errors;
			endif;
		else:
			return App::abort(404);
		endif;
		return Response::json($json_request,200);
	}
	
	public function getEdit($id){
		
		$this->moduleActionPermission('catalogs','edit');
		$catalog = $this->catalog->find($id);
		if(is_null($catalog)):
			return App::abort(404);
		endif;
		if(!empty($catalog['fields'])):
			$catalog['fields'] = json_decode($catalog['fields']);
		endif;
		return View::make('modules.catalogs.edit',array('catalog'=>$catalog,'templates'=>Template::all(),'languages'=>Language::retArray()));
	}
	
	public function postUpdate($id){
		
		$this->moduleActionPermission('catalogs','edit');
		$json_request = array('status'=>FALSE,'responseText'=>'','responseErrorText'=>'','redirect'=>FALSE);
		if(Request::ajax()):
			if(Catalog::validate(Input::all())):
				$catalog = $this->catalog->find($id);
				self::saveCatalogModel($catalog);
				$json_request['responseText'] = 'Каталог сохранен';
				$json_request['redirect'] = slink::createAuthLink('catalogs');
				$json_request['status'] = TRUE;
			else:
				$json_request['responseText'] = 'Неверно заполнены поля';
				$json_request['responseErrorText'] = Catalog::$errors;
			endif;
		else:
			return App::abort(404);
		endif;
		return Response::json($json_request,200);
	}
	
	public function deleteDestroy($id){
		
		$this->moduleActionPermission('catalogs','delete');
		$json_request = array('status'=>FALSE,'responseText'=>'');
		if(Request::ajax()):
			$catalog = $this->catalog->find($id);
			if(!is_null($catalog) && $catalog->delete()):
				if(!empty($catalog->logo) && File::exists(base_path($catalog->logo))):
					File::delete(base_path($catalog->logo));
				endif;
				$json_request['responseText'] = 'Каталог удален';
				$json_request['status'] = TRUE;
			endif;
		else:
			return App::abort(404);
		endif;
		return Response::json($json_request,200);
	}
	
	private function saveCatalogModel($catalog = NULL){
		
		$fields = array();
		foreach(Input::get('fields.title') as $key => $value):
			if(!empty($value)):
				$fields[] = array('label'=>Input::get('fields.label.'.$key),'type'=>Input::get('fields.type.'.$key),'name'=>Input::get('fields.title.'.$key));
			endif;
		endforeach;
		if(empty($fields)):
			$fields[] = array('label'=>'Название товара','type'=>'input','name'=>'title');
		endif;
		if(is_null($catalog)):
			$catalog = $this->catalog;
		endif;
		$catalog->title = Input::get('title');
		$catalog->description = Input::get('description');
		$catalog->fields = json_encode($fields);
		$catalog->publication = 1;
		if(Allow::enabled_module('languages')):
			$catalog->language = Input::get('language');
		else:
			$catalog->language = App::getLocale();
		endif;
		if(Allow::enabled_module('templates')):
			$catalog->template = Input::get('template');
		else:
			$catalog->template = 'catalog';
		endif;
		if(Allow::valid_access('downloads')):
			if(Input::hasFile('file')):
				if(!empty($catalog->logo) && File::exists(base_path($catalog->logo))):
					File::delete(base_path($catalog->logo));
				endif;
				if(!File::isDirectory(base_path('public/uploads/catalogs'))):
					File::makeDirectory(base_path('public/uploads/catalogs'),777,TRUE);
				endif;
				$fileName = str_random(16).'.'.Input::file('file')->getClientOriginalExtension();
				ImageManipulation::make(Input::file('file')->getRealPath())->resize(250,250,TRUE)->save(base_path('public/uploads/catalogs/'.$fileName));
				$catalog->logo = 'public/uploads/catalogs/'.$fileName;
			endif;
		endif;
		$catalog->save();
		$catalog->touch();
		return $catalog->id;
	}
	
}