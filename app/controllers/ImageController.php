<?php

class ImageController extends \BaseController {
	
	var $acceptedTypes = array();
	var $defaultImages = array();
	
	public function __construct(){
		
		parent::__construct();
		
		$this->defaultImages = array('default' => 'public/img/no-photo.jpg','avatar-female' => 'public/img/avatars/female.png','avatar-male'=>'public/img/avatars/male.png','avatar-female-thumbnail' => 'public/img/avatars/female.png','avatar-male-thumbnail' => 'public/img/avatars/male.png');
		
		$this->acceptedTypes = array(
			'text/plain' => asset('img/icons/txt.png'),'application/pdf' => asset('img/icons/pdf.png'),'application/zip' => asset('img/icons/zip.png'),
			'application/x-zip-compressed' => asset('img/icons/zip.png'),'application/msword' => asset('img/icons/word.png'),
			'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => asset('img/icons/word.png'),
			'application/vnd.ms-excel' => asset('img/icons/excel.png'),'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => asset('img/icons/excel.png'),
			'application/vnd.ms-powerpoint' => asset('img/icons/powerpoint.png'),'application/vnd.openxmlformats-officedocument.presentationml.presentation' => asset('img/icons/powerpoint.png'),
			'audio/mp3' => asset('img/icons/sound.png'),'audio/mpeg' => asset('img/icons/sound.png'),'audio/ogg'=> asset('img/icons/sound.png'),
			'audio/webm'=> asset('img/icons/sound.png'),'audio/aac'=> asset('img/icons/sound.png'),'audio/mp4'=> asset('img/icons/sound.png'),
			'audio/wav'=> asset('img/icons/sound.png'),'audio/x-wav'=> asset('img/icons/sound.png')
		);
	}
	
	public function showImage($image_group,$id){
		
		$image = ''; $filePath = NULL;
		switch($image_group):
			case 'avatar-female':$filePath = User::findOrFail($id)->avatar; break;
			case 'avatar-female-thumbnail':$filePath = User::findOrFail($id)->thumbnail; break;
			case 'avatar-male':$filePath = User::findOrFail($id)->avatar; break;
			case 'avatar-male-thumbnail':$filePath = User::findOrFail($id)->thumbnail; break;
			case 'catalog-manufacturer':$filePath = Manufacturer::findOrFail($id)->logo; break;
			
			case 'catalog-product-thumbnail':
				if($productImage = json_decode(Product::findOrFail($id)->image,TRUE)):
					$filePath = $productImage['thumbnail'];
				endif;
				break;
			case 'catalog-product':
				if($productImage = json_decode(Product::findOrFail($id)->image,TRUE)):
					$filePath = $productImage['image'];
				endif;
				break;
			case 'slider-image-thumbnail':
				if($sliderImage = json_decode(Image::findOrFail($id)->paths,TRUE)):
					$filePath = $sliderImage['thumbnail'];
				endif;
				break;
			case 'slider-image':
				if($sliderImage = json_decode(Image::findOrFail($id)->paths,TRUE)):
					$filePath = $sliderImage['image'];
				endif;
				break;
		endswitch;
		if(!is_null($filePath) && File::exists(base_path($filePath))):
			$image = File::get(base_path($filePath));
		endif;
		if(empty($image)):
			if(isset($this->defaultImages[$image_group])):
				$image = File::get(base_path($this->defaultImages[$image_group]));
				$filePath = $this->defaultImages[$image_group];
			else:
				$image = File::get(base_path($this->defaultImages['default']));
				$filePath = $this->defaultImages['default'];
			endif;
		endif;
		$MimeType = 'image/png';
		if(File::exists($filePath)):
			$MimeType = ImageManipulation::open(base_path($filePath))->mime;
		endif;
		header('Content-type: '.$MimeType);
		echo $image;
	}
	
	public function deleteImage($id){
	
		if(Allow::valid_access('downloads')):
			$json_request = array('status'=>FALSE,'responseText'=>'','responseErrorText'=>'','redirect'=>FALSE);
			if(Request::ajax()):
				if($image = Image::where('user_id',Auth::user()->id)->findOrFail($id)):
					if($jsonImageData = json_decode($image->paths)):
						if(File::exists(base_path($jsonImageData->image))):
							File::delete(base_path($jsonImageData->image));
						endif;
						if(File::exists(base_path($jsonImageData->thumbnail))):
							File::delete(base_path($jsonImageData->thumbnail));
						endif;
					endif;
					$image->delete();
					$json_request['responseText'] = 'Изображение удалено';
					$json_request['status'] = TRUE;
				endif;
			else:
				return App::abort(404);
			endif;
			return Response::json($json_request,200);
		else:
			return App::abort(404);
		endif;
	}
	
	public static function deleteImages($module_name,$item_id){
	
		if(Allow::valid_access('downloads')):
			$module = Modules::where('url',$module_name)->first();
			if($loadProductImages = Image::where('user_id',Auth::user()->id)->where('module_id',$module->id)->where('item_id',$item_id)->get()):
				foreach($loadProductImages as $key => $image):
					if($jsonImageData = json_decode($image->paths)):
						if(File::exists(base_path($jsonImageData->image))):
							File::delete(base_path($jsonImageData->image));
						endif;
						if(File::exists(base_path($jsonImageData->thumbnail))):
							File::delete(base_path($jsonImageData->thumbnail));
						endif;
					endif;
				endforeach;
				Image::where('user_id',Auth::user()->id)->where('module_id',$module->id)->where('item_id',$item_id)->delete();
			endif;
			return TRUE;
		else:
			return FALSE;
		endif;
	}
}