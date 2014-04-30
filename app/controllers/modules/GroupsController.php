<?php

class GroupsController extends BaseController {

	protected $group;

	public function __construct(Group $group){
		
		$this->group = $group;
		$this->beforeFilter('users');
	}

	public function getIndex(){
		
		$groups = $this->group->all();
		$roles = Role::all();
		return View::make('modules.groups.index', compact('groups', 'roles'));
	}

	public function getEdit($id){
		
		$group = $this->group->find($id);
		$roles = Role::all();
		foreach(Group::find($id)->roles()->get() as $key => $role):
			$group->roles[$role->name] = $role->id;
		endforeach;
		return View::make('modules.groups.edit', compact('group', 'roles'));
	}

	public function postAttach(){
		
		$group_id = Input::get('group_id');
		$role_id = Input::get('role_id');

		$group = Group::find($group_id);
		$group->roles()->attach($role_id);
	}

	public function postDetach(){
		
		$group_id = Input::get('group_id');
		$role_id = Input::get('role_id');
		
		$group = Group::find($group_id);
		$group->roles()->detach($role_id);
	}

	public function postCreate(){
		
		$input = Input::all();

		$v = Validator::make($input, Group::$rules);
		if($v->passes())
		{
			$this->group->create($input);
			return slink::createLink('admin/groups');
		} else {
			return Response::json($v->messages()->toJson(), 400);
		}
	}
	
	public function postUpdate($group_id){
		
		//$this->moduleActionPermission('users','update');
		$json_request = array('status'=>FALSE,'responseText'=>'','responseErrorText'=>'','redirect'=>FALSE);
		if(Request::ajax()):
			if(!$group = Group::find($group_id)):
				$json_request['responseText'] = 'Запрашиваемая группа не найдена!';
				return Response::json($json_request,400);
			endif;
			$rules = array('name' => 'required','desc' => 'required','dashboard' => 'required');
			$validation = Validator::make(Input::all(),$rules);
			if($validation->passes()):
				$group->name = Input::get('name');
				$group->desc = Input::get('desc');
				$group->save();
				$group->touch();
				$group->roles()->sync(Input::get('roles'));
				$json_request['responseText'] = 'Группа обновлена';
				$json_request['redirect'] = slink::createAuthLink('groups');
				$json_request['status'] = TRUE;
			else:
				$json_request['responseText'] = 'Неверно заполнены поля';
				$json_request['responseErrorText'] = implode($validation->messages()->all(),'<br />');
			endif;
		else:
			return App::abort(404);
		endif;
		return Response::json($json_request,200);

		
	}

}
