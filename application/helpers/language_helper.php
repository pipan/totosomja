<?php
if (!function_exists("valid_language")){
	function valid_language($language){
		$default = "sk";
		$ext = array('sk', 'en');
		if (in_array($language, $ext)){
			return $language;
		}
		return $default;
	}
}
if (!function_exists("get_language_ext")){
	function get_language_ext($language){
		if ($language != "sk"){
			return "_".$language;
		}
		return "";
	}
}