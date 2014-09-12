<?php
if (!function_exists("str_replace_array")){
	function str_replace_array($array, $text){
		foreach ($array as $key => $value){
			$text = str_replace($key, $value, $text);
		}
		return $text;
	}
}