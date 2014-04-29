<?php

class ManufacturersController extends \BaseController {

	protected $manufacturer;
	
	public function __construct(Manufacturer $manufacturer){
		
		$this->manufacturer = $manufacturer;
		$this->beforeFilter('catalogs');
	}
	
	public function getIndex(){
		
		$manufacturers = $this->manufacturer->all();
		return View::make('modules.catalogs.manufacturers.index', compact('manufacturers'));
	}
	
	public function getCreate(){
		
		$this->moduleActionPermission('catalogs','create');
		return View::make('modules.catalogs.manufacturers.create',array('templates'=>Template::all(),'languages'=>Language::all()));
	}
	
	public function postStore(){
		
		$this->moduleActionPermission('catalogs','create');
		$json_request = array('status'=>FALSE,'responseText'=>'','responseErrorText'=>'','redirect'=>FALSE);
		if(Request::ajax()):
			if(Manufacturer::validate(Input::all())):
				self::saveManufacturerModel();
				$json_request['responseText'] = 'Производитель создан';
				$json_request['redirect'] = slink::createAuthLink('catalogs/manufacturers');
				$json_request['status'] = TRUE;
			else:
				$json_request['responseText'] = 'Неверно заполнены поля';
				$json_request['responseErrorText'] = Manufacturer::$errors;
			endif;
		else:
			return App::abort(404);
		endif;
		return Response::json($json_request,200);
	}
	
	public function getEdit($id){
		
		$this->moduleActionPermission('catalogs','edit');
		$manufacturer = $this->manufacturer->find($id);
		if(is_null($manufacturer)):
			return App::abort(404);
		endif;
		return View::make('modules.catalogs.manufacturers.edit',array('manufacturer'=>$manufacturer,'templates'=>Template::all(),'languages'=>Language::all()));
	}
	
	public function postUpdate($id){
		
		$this->moduleActionPermission('catalogs','edit');
		$json_request = array('status'=>FALSE,'responseText'=>'','responseErrorText'=>'','redirect'=>FALSE);
		if(Request::ajax()):
			if(Manufacturer::validate(Input::all())):
				$manufacturer = $this->manufacturer->find($id);
				self::saveManufacturerModel($manufacturer);
				$json_request['responseText'] = 'Производитель сохранен';
				$json_request['redirect'] = slink::createAuthLink('catalogs/manufacturers');
				$json_request['status'] = TRUE;
			else:
				$json_request['responseText'] = 'Неверно заполнены поля';
				$json_request['responseErrorText'] = Manufacturer::$errors;
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
			$manufacturer = $this->manufacturer->find($id);
			if(!is_null($manufacturer) && $manufacturer->delete()):
				if(!empty($manufacturer->logo) && File::exists(base_path($manufacturer->logo))):
					File::delete(base_path($manufacturer->logo));
				endif;
				$json_request['responseText'] = 'Производитель удален';
				$json_request['status'] = TRUE;
			endif;
		else:
			return App::abort(404);
		endif;
		return Response::json($json_request,200);
	}
	
	private function saveManufacturerModel($manufacturer = NULL){
		
		if(is_null($manufacturer)):
			$manufacturer = $this->manufacturer;
		endif;
		$manufacturer->title = Input::get('title');
		$manufacturer->description = Input::get('description');
		$manufacturer->sort = (int)Manufacturer::max('sort')+1;
		$manufacturer->publication = 1;
		if(Allow::enabled_module('languages')):
			$manufacturer->language = Input::get('language');
		else:
			$manufacturer->language = App::getLocale();
		endif;
		if(Allow::enabled_module('templates')):
			$manufacturer->template = Input::get('template');
		else:
			$manufacturer->template = 'manufacturer';
		endif;
		if(Allow::valid_access('downloads')):
			if(Input::hasFile('file')):
				if(!empty($manufacturer->logo) && File::exists(base_path($manufacturer->logo))):
					File::delete(base_path($manufacturer->logo));
				endif;
				if(!File::isDirectory(base_path('public/uploads/catalogs/manufacturers'))):
					File::makeDirectory(base_path('public/uploads/catalogs/manufacturers'),777,TRUE);
				endif;
				$fileName = str_random(16).'.'.Input::file('file')->getClientOriginalExtension();
				ImageManipulation::make(Input::file('file')->getRealPath())->resize(250,250,TRUE)->save(base_path('public/uploads/catalogs/manufacturers/'.$fileName));
				$manufacturer->logo = 'public/uploads/catalogs/manufacturers/'.$fileName;
			endif;
		endif;
		if(Allow::enabled_module('seo')):
			if(is_null(Input::get('seo_url'))):
				$manufacturer->seo_url = '';
			elseif(Input::get('seo_url') === ''):
				$manufacturer->seo_url = $this->stringTranslite(Input::get('title'));
			else:
				$manufacturer->seo_url = $this->stringTranslite(Input::get('seo_url'));
			endif;
			if(Input::get('seo_title') == ''):
				$manufacturer->seo_title = $manufacturer->title;
			else:
				$manufacturer->seo_title = trim(Input::get('seo_title'));
			endif;
			$manufacturer->seo_description = Input::get('seo_description');
			$manufacturer->seo_keywords = Input::get('seo_keywords');
			$manufacturer->seo_h1 = Input::get('seo_h1');
		else:
			$manufacturer->seo_url = $this->stringTranslite(Input::get('title'));
			$manufacturer->seo_title = Input::get('title');
			$manufacturer->seo_description =$manufacturer->seo_keywords = $manufacturer->seo_h1 = '';
		endif;
		$manufacturer->save();
		$manufacturer->touch();
		return $manufacturer->id;
	}
}