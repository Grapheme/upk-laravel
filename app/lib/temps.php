<?php

class temps {

	public static function all()
	{
		$dir = app_path().'/views/tmp/tpl';
		foreach (scandir($dir) as $file) {
			$files[] = $file;
		}

		print_r($files);
	}

	public static function open($name)
	{
		$file = app_path().'/views/tmp/'.$name;
		$fh = fopen($file, 'r');
	 	$data = fread($fh, filesize($file));
		fclose($fh);
		return nl2br($data);
	}
}