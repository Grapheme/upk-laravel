<?php

class CategoriesController extends \BaseController {

	protected $categories_group;
	
	public function __construct(CategoryGroup $categories_group){
		
		$this->categories_group = $categories_group;
		$this->beforeFilter('catalogs');
	}
	
	public function getIndex(){
		
		$categories = $this->categories_group->all();
		return View::make('modules.catalogs.categories.group-index', compact('categories'));
	}
	
	public function getCreate(){
		
		$this->moduleActionPermission('catalogs','create');
		return View::make('modules.catalogs.categories.group-create',array('templates'=>Template::all(),'languages'=>Language::retArray()));
	}
	
	public function postStore(){
		
		$this->moduleActionPermission('catalogs','create');
		$json_request = array('status'=>FALSE,'responseText'=>'','responseErrorText'=>'','redirect'=>FALSE);
		if(Request::ajax()):
			if(CategoryGroup::validate(Input::all())):
				self::saveCategoryGroupModel();
				$json_request['responseText'] = 'Группа категорий создана';
				$json_request['redirect'] = slink::createAuthLink('catalogs/categories');
				$json_request['status'] = TRUE;
			else:
				$json_request['responseText'] = 'Неверно заполнены поля';
				$json_request['responseErrorText'] = CategoryGroup::$errors;
			endif;
		else:
			return App::abort(404);
		endif;
		return Response::json($json_request,200);
	}
	
	public function getEdit($id){
		
		$this->moduleActionPermission('catalogs','edit');
		$category = $this->categories_group->find($id);
		if(is_null($category)):
			return App::abort(404);
		endif;
		return View::make('modules.catalogs.categories.group-edit',array('category'=>$category,'templates'=>Template::all(),'languages'=>Language::retArray()));
	}
	
	public function postUpdate($id){
		
		$this->moduleActionPermission('catalogs','edit');
		$json_request = array('status'=>FALSE,'responseText'=>'','responseErrorText'=>'','redirect'=>FALSE);
		if(Request::ajax()):
			if(CategoryGroup::validate(Input::all())):
				$category = $this->categories_group->find($id);
				self::saveCategoryGroupModel($category);
				$json_request['responseText'] = 'Группа катагорий сохранена';
				$json_request['redirect'] = slink::createAuthLink('catalogs/categories');
				$json_request['status'] = TRUE;
			else:
				$json_request['responseText'] = 'Неверно заполнены поля';
				$json_request['responseErrorText'] = CategoryGroup::$errors;
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
			$categories = Category::where('category_group_id',$id)->get();
			if(!is_null($categories)):
				foreach($categories as $category):
					if(!empty($category->logo) && File::exists(public_path($category->logo))):
						File::delete(public_path($category->logo));
					endif;
				endforeach;
				Category::where('category_group_id',$id)->delete();
			endif;
			$this->categories_group->find($id)->delete();
			$json_request['responseText'] = 'Группа катагорий удалена';
			$json_request['status'] = TRUE;
		else:
			return App::abort(404);
		endif;
		return Response::json($json_request,200);
	}
	
	private function saveCategoryGroupModel($category_group = NULL){
		
		if(is_null($category_group)):
			$category_group = $this->categories_group;
		endif;
		$category_group->title = Input::get('title');
		$category_group->description = Input::get('description');
		$category_group->publication = 1;
		if(Allow::enabled_module('languages')):
			$category_group->language = Input::get('language');
		else:
			$category_group->language = App::getLocale();
		endif;
		if(Allow::enabled_module('templates')):
			$category_group->template = Input::get('template');
		else:
			$category_group->template = 'category';
		endif;
		$category_group->save();
		$category_group->touch();
		return $category_group->id;
	}

	/*
	* Поиск категориий
	*/
		
	public function getSugestSearchCategory($category_group_id){
		
		$found_categories = array();
		if(Request::ajax()):
			if($categoriesList = Category::where('title','LIKE','%'.Input::get('q').'%')->where('category_group_id',$category_group_id)->orderBy('sort')->get()->toArray()):
				for($i=0;$i<count($categoriesList);$i++):
					$found_categories[$i]['id'] = $categoriesList[$i]['id'];
					$found_categories[$i]['name'] = $categoriesList[$i]['title'];
				endfor;
			endif;
		else:
			return App::abort(404);
		endif;
		return Response::json($found_categories,200);
	}
	
	/*
	* Категории и подкатегории
	*/
	
	public function getCategoryList($category_group_id,$parent_category_id = NULL){
		
		self::validAccessToCategory($category_group_id,$parent_category_id);
		if(is_null($parent_category_id)):
			$categories = $this->categories_group->find($category_group_id)->categories()->where('category_parent_id',0)->get();
		else:
			$categories = $this->categories_group->find($category_group_id)->categories()->where('category_parent_id',$parent_category_id)->get();
		endif;
		return View::make('modules.catalogs.categories.category-index', compact('categories','category_group_id','parent_category_id'));
	}
	
	public function getCategoryCreate($category_group_id,$parent_category_id = NULL){
		
		$this->moduleActionPermission('catalogs','create');
		self::validAccessToCategory($category_group_id,$parent_category_id);
		return View::make('modules.catalogs.categories.category-create', compact('category_group_id','parent_category_id'));
	}

	public function postCategoryStore($category_group_id){
		
		$this->moduleActionPermission('catalogs','create');
		self::validAccessToCategory($category_group_id);
		$json_request = array('status'=>FALSE,'responseText'=>'','responseErrorText'=>'','redirect'=>FALSE);
		if(Request::ajax()):
			if(Category::validate(Input::all())):
				self::saveCategoryModel();
				if(Input::get('category_parent_id') == 0):
					$json_request['redirect'] = slink::createAuthLink('catalogs/category-group/'.Input::get('category_group_id').'/categories/');
				else:
					$json_request['redirect'] = slink::createAuthLink('catalogs/category-group/'.Input::get('category_group_id').'/category/'.Input::get('category_parent_id').'/sub-categories');
				endif;
				$json_request['responseText'] = 'Категория создана';
				$json_request['status'] = TRUE;
			else:
				$json_request['responseText'] = 'Неверно заполнены поля';
				$json_request['responseErrorText'] = Category::$errors;
			endif;
		else:
			return App::abort(404);
		endif;
		return Response::json($json_request,200);
	}
	
	public function getCategoryEdit($category_group_id,$category_id,$parent_category_id = NULL){
		
		$this->moduleActionPermission('catalogs','edit');
		self::validAccessToCategory($category_group_id,$parent_category_id);
		$category = Category::find($category_id);
		if(is_null($category)):
			return App::abort(404);
		endif;
		return View::make('modules.catalogs.categories.category-edit',compact('category','category_group_id','parent_category_id'));
	}
	
	public function getSubCategoryEdit($category_group_id,$parent_category_id,$category_id){
		
		$this->moduleActionPermission('catalogs','edit');
		self::validAccessToCategory($category_group_id,$parent_category_id);
		$category = Category::find($category_id);
		if(is_null($category)):
			return App::abort(404);
		endif;
		return View::make('modules.catalogs.categories.category-edit',compact('category','category_group_id','parent_category_id'));
	}
	
	public function postCategoryUpdate($category_group_id,$category_id){
		
		$this->moduleActionPermission('catalogs','edit');
		$json_request = array('status'=>FALSE,'responseText'=>'','responseErrorText'=>'','redirect'=>FALSE);
		if(Request::ajax()):
			if(Category::validate(Input::all())):
				$category = Category::find($category_id);
				self::saveCategoryModel($category);
				if(Input::get('category_parent_id') == 0):
					$json_request['redirect'] = slink::createAuthLink('catalogs/category-group/'.Input::get('category_group_id').'/categories/');
				else:
					$json_request['redirect'] = slink::createAuthLink('catalogs/category-group/'.Input::get('category_group_id').'/category/'.Input::get('category_parent_id').'/sub-categories');
				endif;
				$json_request['responseText'] = 'Категория сохранена';
				$json_request['status'] = TRUE;
			else:
				$json_request['responseText'] = 'Неверно заполнены поля';
				$json_request['responseErrorText'] = Category::$errors;
			endif;
		else:
			return App::abort(404);
		endif;
		return Response::json($json_request,200);
	}
	
	public function postCategoryDestroy($category_group_id,$category_id){
		
		$this->moduleActionPermission('catalogs','delete');
		$json_request = array('status'=>FALSE,'responseText'=>'');
		if(Request::ajax()):
			$category = Category::find($category_id);
			if(!is_null($category)):
				$sub_categories = Category::where('category_parent_id',$category_id)->get();
				if(!is_null($sub_categories)):
					foreach($sub_categories as $sub_category):
						if(!empty($sub_category->logo) && File::exists(public_path($sub_category->logo))):
							File::delete(public_path($sub_category->logo));
						endif;
					endforeach;
					Category::where('category_parent_id',$category_id)->delete();
				endif;
				if(!empty($category->logo) && File::exists(public_path($category->logo))):
					File::delete(public_path($category->logo));
				endif;
				$category->delete();
				$json_request['responseText'] = 'Катагория удалена';
				$json_request['status'] = TRUE;
			endif;
		else:
			return App::abort(404);
		endif;
		return Response::json($json_request,200);
	}
	
	private function saveCategoryModel($category = NULL){
		
		if(is_null($category)):
			$category = new Category;
		endif;
		$category->title = Input::get('title');
		$category->description = Input::get('description');
		$category->category_group_id = Input::get('category_group_id');
		$category->category_parent_id = Input::get('category_parent_id');
		
		if(Allow::valid_access('downloads')):
			if(Input::hasFile('file')):
				if(!empty($category->logo) && File::exists(public_path($category->logo))):
					File::delete(public_path($category->logo));
				endif;
				if(!File::isDirectory(public_path('uploads/catalogs'))):
					File::makeDirectory(public_path('uploads/catalogs'),777,TRUE);
				endif;
				$fileName = str_random(16).'.'.Input::file('file')->getClientOriginalExtension();
				ImageManipulation::make(Input::file('file')->getRealPath())->resize(250,250,TRUE)->save(public_path('uploads/catalogs/'.$fileName));
				$category->logo = 'uploads/catalogs/'.$fileName;
			endif;
		endif;
		if(Allow::enabled_module('seo')):
			if(is_null(Input::get('seo_url'))):
				$category->seo_url = '';
			elseif(Input::get('seo_url') === ''):
				$category->seo_url = $this->stringTranslite(Input::get('title'));
			else:
				$category->seo_url = $this->stringTranslite(Input::get('seo_url'));
			endif;
			if(Input::get('seo_title') == ''):
				$category->seo_title = $category->title;
			else:
				$category->seo_title = trim(Input::get('seo_title'));
			endif;
			$category->seo_description = Input::get('seo_description');
			$category->seo_keywords = Input::get('seo_keywords');
			$category->seo_h1 = Input::get('seo_h1');
		else:
			$category->seo_url = $this->stringTranslite(Input::get('title'));
			$category->seo_title = Input::get('title');
			$category->seo_description =$category->seo_keywords = $category->seo_h1 = '';
		endif;

		$category->save();
		$category->touch();
		return $category->id;
	}
	
	private function validAccessToCategory($category_group_id,$parent_category_id = NULL){
		
		$category_group = $this->categories_group->find($category_group_id);
		if(is_null($category_group)):
			return App::abort('404');
		endif;
		if(!is_null($parent_category_id)):
			$category = Category::find($parent_category_id);
			if(is_null($category)):
				return App::abort('404');
			endif;
		endif;
	}
}