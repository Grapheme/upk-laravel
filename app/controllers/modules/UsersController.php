<?php

class UsersController extends BaseController {

	protected $user;

	public function __construct(User $user){
		
		$this->model = $user;
		$this->beforeFilter('users');
	}

	public function getIndex(){
		
		$users = $this->model->all();
		$groups = $this->model->find(Auth::user()->id)->groups;
		foreach($groups as $group):
			$groups_ids_array[] = $group->id;
		endforeach;
		$all_groups = group::all();
		return View::make('modules.users.index', compact('users', 'groups', 'all_groups', 'groups_ids_array'));
	}

	public function postCreate(){
		
		$user = Input::get('user');
		$password = Hash::make(Input::get('password'));
		$input = array(
				'user' => $user,
				'password' => $password
			);

		$v = Validator::make($input, User::$rules);
		if($v->passes()):
			$this->model->create($input);
			return slink::createLink('admin/users');
		else:
			return Response::json($v->messages()->toJson(), 400);
		endif;
	}

	public function postAttach(){
		
		if(!DB::table('group_user')->where('user_id', Input::get('user_id'))->where('group_id', Input::get('group_id'))->exists()):
			$user = User::find(Input::get('user_id'));
			$user->groups()->attach(Input::get('group_id'));
		endif;
	}
}
