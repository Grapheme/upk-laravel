<?php

class ProductsController extends \BaseController {
	
	protected $product;
	
	public function __construct(Product $product){
		
		$this->product = $product;
		$this->beforeFilter('catalogs');
	}
	
	public function getIndex(){
		
		$products = $this->product->where('user_id',Auth::user()->id)->orderBy('sort','asc')->orderBy('created_at','desc')->get();
		return View::make('modules.catalogs.products.index', compact('products'));
	}

	public function getCreate(){
		
		$this->moduleActionPermission('catalogs','create');
		$catalogs = Catalog::all();
		$category_groups = CategoryGroup::all();
		if(!$catalogs->count()):
			return Redirect::to(slink::createAuthLink('catalogs/products'))
				->with('message','Для добавления продукта предварительно нужно создать каталог продуктов!<p class="margin-top-10"><a class="btn btn-primary" href="'.slink::createAuthLink('catalogs/create').'">Добавить каталог</a></p>');
		endif;
		$data_fields = array();
		if($catalogs->count() == 1):
			if(!empty($catalogs->first()->fields)):
				$data_fields = json_decode($catalogs->first()->fields);
			endif;
		endif;
		ImageController::deleteImages('catalogs',0);
		$templates = Template::all();
		$languages = Language::all();
		$productsExtendedAttributes = array();
		foreach(Products_attributes_groups::all() as $key => $value):
			$productsExtendedAttributes[$value->title] = Products_attributes_groups::find($value->id)->productAttributes()->get();
		endforeach;
		return View::make('modules.catalogs.products.create',compact('catalogs','category_groups','data_fields','productsExtendedAttributes','templates','languages'));
	}

	public function postStore(){
		
		$this->moduleActionPermission('catalogs','create');
		$json_request = array('status'=>FALSE,'responseText'=>'','responseErrorText'=>'','redirect'=>FALSE);
		if(Request::ajax()):
			if(Product::validate(Input::all(),Product::$rules,Product::$rules_messages)):
				self::saveProductModel();
				$json_request['responseText'] = 'Продукт создан';
				$json_request['redirect'] = slink::createAuthLink('catalogs/products');
				$json_request['status'] = TRUE;
			else:
				$json_request['responseText'] = 'Неверно заполнены поля';
				$json_request['responseErrorText'] = implode(Product::$errors,'<br />');
			endif;
		else:
			return App::abort(404);
		endif;
		return Response::json($json_request,200);
	}

	public function getEdit($product_id){
		
		$this->moduleActionPermission('catalogs','edit');
		$catalogs = Catalog::all();
		$category_groups = CategoryGroup::all();
		$product = $this->product->find($product_id);
		if(is_null($product)):
			return App::abort(404);
		endif;
		$data_fields = json_decode($product->catalog->fields);
		if(!empty($product->attributes)):
			$product->attributes = json_decode($product->attributes,TRUE);
		endif;
		if($product->tags = json_decode($product->tags)):
			$product->tags = implode($product->tags,', ');
		endif;
		$product->categories = $product->categories()->get()->toArray();
		ImageController::deleteImages('catalogs',0);
		$module = Modules::where('url','catalogs')->first();
		if($loadProductImages = Image::where('user_id',Auth::user()->id)->where('module_id',$module->id)->where('item_id',$product_id)->get()):
			foreach($loadProductImages as $key => $image):
				if($sliderImage = json_decode($image->paths)):
					if(File::exists(base_path($sliderImage->image))):
						$loadProductImages[$key]->filename = 'Загруженное изображение';
						$loadProductImages[$key]->filesize = round(File::size(base_path($sliderImage->image))/1024, 2);
					else:
						$loadProductImages[$key]->filename = 'Файл отсутствует на диске';
					endif;
				endif;
			endforeach;
		endif;
		$templates = Template::all();
		$languages = Language::all();
		$productsExtendedAttributes = array();
		foreach(Products_attributes_groups::all() as $key => $value):
			$productsExtendedAttributes[$value->title] = Products_attributes_groups::find($value->id)->productAttributes()->get();
		endforeach;
		return View::make('modules.catalogs.products.edit',compact('product','catalogs','category_groups','data_fields','productsExtendedAttributes','loadProductImages','templates','languages'));
	}

	public function postUpdate($id){
		
		$this->moduleActionPermission('catalogs','create');
		$json_request = array('status'=>FALSE,'responseText'=>'','responseErrorText'=>'','redirect'=>FALSE);
		if(Request::ajax()):
			if(Product::validate(Input::all(),Product::$rules,Product::$rules_messages)):
				$product = $this->product->find($id);
				self::saveProductModel($product);
				$json_request['responseText'] = 'Продукт сохранен';
				$json_request['redirect'] = slink::createAuthLink('catalogs/products');
				$json_request['status'] = TRUE;
			else:
				$json_request['responseText'] = 'Неверно заполнены поля';
				$json_request['responseErrorText'] = implode(Product::$errors,'<br />');
			endif;
		else:
			return App::abort(404);
		endif;
		return Response::json($json_request,200);
	}

	public function deleteDestroy($product_id){
		
		$this->moduleActionPermission('catalogs','delete');
		$json_request = array('status'=>FALSE,'responseText'=>'');
		if(Request::ajax()):
			$product = $this->product->where('id',$product_id)->where('user_id',Auth::user()->id)->first();
			if(!is_null($product) && $product->delete()):
				if($productImages = json_decode($product->image)):
					if(!empty($productImages->image) && File::exists(base_path($productImages->image))):
						File::delete(base_path($productImages->image));
					endif;
					if(!empty($productImages->thumbnail) && File::exists(base_path($productImages->thumbnail))):
						File::delete(base_path($productImages->thumbnail));
					endif;
				endif;
				ImageController::deleteImages('catalogs',$product_id);
				$json_request['responseText'] = 'Продукт удален';
				$json_request['status'] = TRUE;
			endif;
		else:
			return App::abort(404);
		endif;
		return Response::json($json_request,200);
		
	}
	
	private function saveProductModel($product = NULL){
		
		if(is_null($product)):
			$product = $this->product;
		endif;
		
		$product->user_id = Auth::user()->id;
		$product->catalog_id = Input::get('catalog_id');
		$product->category_group_id = Input::get('category_group_id');
		
		$product->sort = Input::get('sort');
		$product->title = Input::get('title');
		$product->description = Input::get('description');
		$product->price = Input::get('price');
		$product->attributes = json_encode(Input::get('attribute'));
		$product->tags = json_encode(explode(',',Input::get('tags')));

		$product->publication = 1;
		if(Allow::valid_access('downloads')):
			if(Input::hasFile('file')):
				if(AuthAccount::isAdminLoggined()):
					$dirPath = 'public/uploads/catalogs';
				elseif(AuthAccount::isUserLoggined()):
					$dirPath = 'usersfiles/account-'.Auth::user()->id.'/catalogs';
				else:
					$dirPath = 'usersfiles/temporary/catalogs';
				endif;
				if($productImages = json_decode($product->image)):
					if(!empty($productImages->image) && File::exists(base_path($productImages->image))):
						File::delete(base_path($productImages->image));
					endif;
					if(!empty($productImages->thumbnail) && File::exists(base_path($productImages->thumbnail))):
						File::delete(base_path($productImages->thumbnail));
					endif;
				endif;
				if(!File::isDirectory(base_path($dirPath.'/thumbnail'))):
					File::makeDirectory(base_path($dirPath.'/thumbnail'),0777,TRUE);
				endif;
				$fileName = str_random(24).'.'.Input::file('file')->getClientOriginalExtension();
				ImageManipulation::make(Input::file('file')->getRealPath())->resize(100,100,TRUE)->save(base_path($dirPath.'/thumbnail/'.$fileName));
				Input::file('file')->move(base_path($dirPath),$fileName);
				$product->image = json_encode(array('image' => $dirPath.'/'.$fileName,'thumbnail'=> $dirPath.'/thumbnail/'.$fileName));
			endif;
		endif;
		if(Allow::enabled_module('languages') && !is_null(Input::get('language'))):
			$product->language = Input::get('language');
		else:
			$product->language = App::getLocale();
		endif;
		if(Allow::enabled_module('templates') && !is_null(Input::get('template'))):
			$product->template = Input::get('template');
		else:
			$product->template = 'product';
		endif;
		if(Allow::enabled_module('seo')):
			if(is_null(Input::get('seo_url'))):
				$product->seo_url = '';
			elseif(Input::get('seo_url') === ''):
				$product->seo_url = $this->stringTranslite(Input::get('title'));
			else:
				$product->seo_url = $this->stringTranslite(Input::get('seo_url'));
			endif;
			if(Input::get('seo_title') == ''):
				$product->seo_title = $product->title;
			else:
				$product->seo_title = trim(Input::get('seo_title'));
			endif;
			$product->seo_description = Input::get('seo_description');
			$product->seo_keywords = Input::get('seo_keywords');
			$product->seo_h1 = Input::get('seo_h1');
		else:
			$product->seo_url = $this->stringTranslite(Input::get('title'));
			$product->seo_title = Input::get('title');
			$product->seo_description =$product->seo_keywords = $product->seo_h1 = '';
		endif;
		$product->save();
		$product->touch();

		/*
		* Присвоение ранее загруженных файлов к товару
		*/
		
		$module = Modules::where('url','catalogs')->first();
		if(Session::has($module->url.'_product')):
			Image::where('user_id',Auth::user()->id)->where('module_id',$module->id)->whereIn('id',Session::get($module->url.'_product'))->update(array('item_id' => $product->id,'title' => $product->title));
			Session::forget($module->url.'_product');
		endif;
		
		/*
		* Присвоение ранее загруженных файлов к товару
		*/
		
		$categoriesIDs = explode(',',Input::get('categories'));
		$product->categories()->sync($categoriesIDs);
		
		return $product->id;
	}
	
}