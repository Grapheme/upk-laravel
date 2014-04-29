<?php

class GalleriesController extends BaseController {
	
	public function __construct(){
		
		$this->beforeFilter('galleries');
	}
	
	public function getIndex(){
		
		$galleries = gallery::all();
		return View::make('modules.galleries.index', compact('galleries'));
	}

	public function getEdit($id){
		
		$gall = gallery::findOrFail($id);
		$bread = $gall->name;
		return View::make('modules.galleries.edit', compact('gall', 'bread'));
	}

	public function postUpload(){
		
		$file = Input::file('file');
		$id = Input::get('gallery-id');

		$rules = array(
        	'file' => 'image'
	    );
	 
	    $validation = Validator::make(array('file' => $file), $rules);
	 
	    if ($validation->fails()){
	        return Response::json('This extension is not allowed', 400);
	        exit;
	    }
 
		$destinationPath = public_path().Config::get('app-default.galleries_photo_dir');
		$extension =$file->getClientOriginalExtension();
		$filename = time()."_".rand(1000,1999).".".$extension; 
		$upload_success = Input::file('file')->move($destinationPath, $filename);
		 
		if( $upload_success ) {
			photo::create(array(
				"name" => $filename,
				"gallery_id" => $id,
			));
		   return Response::json('success', 200);
		} else {
		   return Response::json('error', 400);
		}
	 
	}

	public function postPhotodelete() {
		$id = Input::get('id');

		$model = photo::find($id);


		$db_delete = $model->delete();

		if( $db_delete )
		{
			$file_delete = File::delete(public_path().Config::get('app-default.galleries_photo_dir').'/'.$model->name);
		}

		if( $db_delete && $file_delete )
		{
			return Response::json('success', 200);
		} else {
			return Response::json('error', 400);
		}
	}

	public function postCreate(){
		
		$input = Input::all();
		$validation = Validator::make($input, gallery::getRules());
		if($validation->fails())
		{
			return Response::json($validation->messages()->toJson(), 400);
		} else {
			$id = gallery::create($input)->id;
			$href = slink::createLink('admin/galleries/edit/'.$id);
			return Response::json($href, 200);
		}
	}

	public function postDelete(){
		
		$id = Input::get('id');
		$model = gallery::find($id);

		if($model->delete())
		{
			return Response::json('success', 200);
		} else {
			return Response::json('error', 400);
		}
	}

}
