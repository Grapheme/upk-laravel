<?php

return array(

	'driver' => 'smtp',
	'host' => 'smtp.gmail.com',
	'port' => 587,
	'from' => array('address' => null, 'name' => null),
	'encryption' => 'tls',
	'username' => 'konferum.ru@gmail.com',
	'password' => 'hf5msdfl34',
	'sendmail' => '/usr/sbin/sendmail -bs',
	'pretend' => false,
);