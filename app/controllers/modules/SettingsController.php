<?php

class SettingsController extends BaseController {


	public function __construct(Page $page){
		
		$this->model = $page;
		$this->beforeFilter('settings');
	}
	
	public function getIndex(){
		
		$settings = Settings::retArray();
		$languages = Language::retArray();
		return View::make('modules.settings.index', compact('settings','languages'));
	}

	public function postAdminlanguagechange(){
		
		$id = Input::get('id');
		$model = settings::where('name', 'admin_language')->first();
		$model->value = language::find($id)->code;
		$model->save();
	}

	public function postModule(){
		
		$json_request = array('status'=>TRUE,'responseText'=>'Сохранено');
		if($module = Modules::where('url',Input::get('url'))->first()):
			$module->update(array('on'=>Input::get('value')));
			$module->touch();
		else:
			Modules::create(array('url'=>Input::get('url'),'on'=>Input::get('value')));
		endif;
		if(Input::get('value') == 1):
			$json_request['responseText'] = "Модуль &laquo;".SystemModules::getModules(Input::get('url'),0)."&raquo; включен";
		else:
			$json_request['responseText'] = "Модуль &laquo;".SystemModules::getModules(Input::get('url'),0)."&raquo; выключен";
		endif;
		return Response::json($json_request,200);
	}
}
