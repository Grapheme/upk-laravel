<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	protected $table = 'users';

	protected $guarded = array();

	protected $hidden = array('password');

	public static $rules = array(
		'name' => 'required',
		'surname' => 'required',
		'email' => 'required|email',
		'password' => 'required|min:6'
	);

	public function getAuthIdentifier(){
		return $this->getKey();
	}

	public function getAuthPassword(){
		return $this->password;
	}

	public function getReminderEmail(){
		return $this->email;
	}

	public function groups(){
		return $this->belongsToMany('Group');
	}
	
	public function getRememberToken(){
		
		return $this->remember_token;
	}

	public function setRememberToken($value){
		
		$this->remember_token = $value;
	}

	public function getRememberTokenName(){
		
		return 'remember_token';
	}
	
}