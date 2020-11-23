<?php defined('BASEPATH') OR exit('No direct script access allowed.');

if(!function_exists('randomToken')){

	function randomToken($length = 10){
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}
}
if(!function_exists('unserializeMe')){

	function unserializeMe($rubble) {
		 $bricks = explode('&', $rubble);

		foreach($bricks as $key => $value) {
			$walls = preg_split('/=/', $value);
			$built[$walls[0]] = $walls[1];
		}

		return $built;
	}
}