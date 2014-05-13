<?php

class Allow {
	
	/*
	| функция проверяет разрешения пользователя на выполнения действий в модуле (создание, редактирование и т.д.)
	*/
	
	public static function valid_action_permission($module_name,$perimission_name){
		
		$access = FALSE;
		if(Auth::check() && Allow::valid_access($module_name)):
			$module = Modules::where('url',$module_name)->first();
			$permission = Permission::where('name',$perimission_name)->first();
			if(!is_null($module) && !is_null($permission)):
				if($permissions = json_decode($module->permissions,TRUE)):
					if(in_array($permission->id,$permissions)):
						$modulePermission = ModulePermission::where('user_id',Auth::user()->id)->where('module_id',$module->id)->where('permission_id',$permission->id)->first();
						if(!is_null($modulePermission) && $modulePermission->value == 1):
							$access = TRUE;
						elseif($permission->default == 1):
							$access = TRUE;
						endif;
					endif;
				else:
					$access = TRUE;
				endif;
			endif;
		endif;
		return $access;
	}
	
	/*
	| функция проверяет разрешения пользователя на использования модуля (pages,news и т.д.)
	*/
	
	public static function valid_access($module_name){
		
		$access = FALSE;
		if(Auth::check()):
			if($groups = User::find(Auth::user()->id)->groups):
				$roleArray = array();
				foreach($groups as $group):
					foreach(Group::find($group->id)->roles as $role):
						$roleArray[] = $role->name;
					endforeach;
				endforeach;
				if(Allow::enabled_module($module_name) && !empty($roleArray)):
					if(in_array($module_name,$roleArray)):
						$access = TRUE;
					endif;
				endif;
			endif;
		endif;
		return $access;
	}
	/*
	| функция проверяет разрешения пользователя на использования отдельных модулей не входящие в роли (seo и т.д.)
	*/
	
	public static function enabled_module($module_name){
		
		if(Modules::where('url',$module_name)->exists() && Modules::where('url',$module_name)->first()->on == 1):
			return TRUE;
		elseif(!Modules::where('url',$module_name)->exists() && SystemModules::getModules($module_name,3)):
			return TRUE;
		else:
			return FALSE;
		endif;
	}
	
	/*
	| Создание фильтров для роутеров
	*/
	
	/* **************************************************************************** */
	public static function modulesFilters(){
		
		$roles = array();
		foreach(Role::all() as $role):
			$roles[] = $role->name;
		endforeach;
		Allow::mFilters($roles);
	}
	
	private static function mFilters($permissions){
		
		if(!empty($permissions)):
			foreach($permissions as $permission):
				Allow::mFilter($permission);
			endforeach;
		endif;
	}
	
	private static function mFilter($permission){
		
		Route::filter($permission,function() use ($permission){
			if(Auth::check()):
				if(!Allow::valid_access($permission)):
					return App::abort(403);
				endif;
			else:
				return App::abort(404);
			endif;
		});
	}
	/* **************************************************************************** */
}
