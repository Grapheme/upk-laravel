<?php

class UserCabinetController extends BaseController {
	
	public function __construct(){
		
		parent::__construct();
	}
	
	public function mainPage(){
		
		return View::make('user-cabinet.dashboard');
	}
	
	public function getSecurePageIntranet(){
		
		$url = Config::get('app-default.secure_page_link');
		
		return sPage::show($url);
	}
}