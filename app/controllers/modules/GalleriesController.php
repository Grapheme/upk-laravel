<?php

class GalleriesController extends BaseController {
	
	public function __construct(){
		
		$this->beforeFilter('galleries');
	}
	
	public function getIndex(){
		
		#$galleries = gallery::all();
		#return View::make('modules.galleries.index', compact('galleries'));
		$galls = gallery::all();
		return View::make('modules.galleries.index', compact('galls'));
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
 
		#$destinationPath = public_path().Config::get('app-default.galleries_photo_dir');
		#$extension =$file->getClientOriginalExtension();
		#$filename = time()."_".rand(1000,1999).".".$extension; 
		#$upload_success = Input::file('file')->move($destinationPath, $filename);

		$uploadPath = public_path().Config::get('app-default.galleries_photo_dir');
		$thumbsPath = public_path().Config::get('app-default.galleries_thumb_dir');
		if(Input::hasFile('file')):
			$fileName = time()."_".rand(1000,1999).'.'.Input::file('file')->getClientOriginalExtension();
			if(!File::exists($thumbsPath)):
				File::makeDirectory($thumbsPath,0777,TRUE);
			endif;
			$thumb_upload_success = ImageManipulation::make(Input::file('file')->getRealPath())->resize(100,100,TRUE)->save($thumbsPath.'/'.$fileName);
			$image_upload_success = ImageManipulation::make(Input::file('file')->getRealPath())->resize(800,800,TRUE)->save($uploadPath.'/'.$fileName);
			#$file = array('filelink'=>url('uploads/'.$fileName));
			#echo stripslashes(json_encode($file));

			$photo = Photo::create(array(
				'name' => $fileName,
				'gallery_id' => $id,
			));
		
			return Response::json('success', 200);
		else:
			return Response::json('error', 400);
		endif;

		/*
		if( $upload_success ) {
			photo::create(array(
				"name" => $filename,
				"gallery_id" => $id,
			));
		   return Response::json('success', 200);
		} else {
		   return Response::json('error', 400);
		}
		*/
	 
	}


	public function postAbstractupload(){

		$result = array('result' => 'error');

		if(!Input::hasFile('file')) {
			$result['desc'] = 'No input file';
	        return Response::json($result, 400);
	        exit;
		}
		
		$file = Input::file('file');
		$rules = array(
        	'file' => 'image'
	    );	 
	    $validation = Validator::make(array('file' => $file), $rules);
	    if ($validation->fails()){
	    	$result['desc'] = 'This extension is not allowed';
	        return Response::json($result, 400);
	        exit;
	    }
 
		$uploadPath = public_path().Config::get('app-default.galleries_photo_dir');
		$thumbsPath = public_path().Config::get('app-default.galleries_thumb_dir');
		$fileName = time()."_".rand(1000,1999).'.'.Input::file('file')->getClientOriginalExtension();

		if(!File::exists($thumbsPath))
			File::makeDirectory($thumbsPath,0777,TRUE);

		$thumb_upload_success = ImageManipulation::make(Input::file('file')->getRealPath())->resize(100,NULL,TRUE)->save($thumbsPath.'/'.$fileName);
		$image_upload_success = ImageManipulation::make(Input::file('file')->getRealPath())->resize(800,800,TRUE)->save($uploadPath.'/'.$fileName);

		if (!$thumb_upload_success || !$image_upload_success) {
	    	$result['desc'] = 'Error on the saving images';
	        return Response::json($result, 400);
	        exit;
		}

		$gallery_id = Input::get('gallery_id') ? (int)Input::get('gallery_id') : 0;

		$photo = Photo::create(array(
			'name' => $fileName,
			'gallery_id' => $gallery_id,
		));

		$result = array('result' => 'success', 'image_id' => $photo->id);

		return Response::json($result, 200);		
	}


	public function postPhotodelete() {
		$id = Input::get('id');

		$model = Photo::find($id);

		$db_delete = $model->delete();

		if( $db_delete ) {
			$file_delete = File::delete(public_path().Config::get('app-default.galleries_photo_dir').'/'.$model->name);
			$thumb_delete = File::delete(public_path().Config::get('app-default.galleries_thumb_dir').'/'.$model->name);
		}

		if( $db_delete && $file_delete && $thumb_delete ) {
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
		$gallery = gallery::find($id);

		@Rel_mod_gallery::where('gallery_id', $gallery->id)->delete();
		$deleted = $gallery->delete();

		if($deleted) {
			return Response::json('success', 200);
		} else {
			return Response::json('error', 400);
		}
	}

	public static function moveImagesToGallery($images = array(), $gallery_id = false) {

		if ( !isset($images) || !is_array($images) || !count($images) )
			return false;
			
		if (!$gallery_id) {
			$gallery = gallery::create(array(
				'name' => 'noname',
			));
			$gallery_id = $gallery->id;
		}
		
		foreach ($images as $i => $img_id) {
			$img = Photo::find($img_id);
			if (@$img) {
				$img->gallery_id = $gallery_id;
				#print_r($img);
				$img->save();
			}
		}
		
		return $gallery_id;
	}

	public static function relModuleUnitGallery($module = '', $unit_id = 0, $gallery_id = 0) {

		if ( !@$module || !$unit_id || !$gallery_id )
			return false;

		$rel = Rel_mod_gallery::where('module', $module)->where('unit_id', $unit_id)->where('gallery_id', $gallery_id)->first();

		if (!is_object($rel) || !@$rel->id) {
			$rel = Rel_mod_gallery::create(array(
				'module' => $module,
				'unit_id' => $unit_id,
				'gallery_id' => $gallery_id,
			));
		}

		$gallery = gallery::find($gallery_id);
		$gallery->name = $module . " - " . $unit_id;
		$gallery->save();

		return $rel->id;
	}

	public static function imagesToUnit($images = array(), $module = '', $unit_id = 0, $gallery_id = false) {

		if (
			!isset($images) || !is_array($images) || !count($images)
			|| !@$module || !$unit_id
		)
			return false;

		$gallery_id = self::moveImagesToGallery($images, $gallery_id);
		self::relModuleUnitGallery($module, (int)$unit_id, $gallery_id);

		return true;
	}

}


