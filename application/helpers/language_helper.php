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
if (!function_exists("get_lang_labe")){
	function get_lang_label($link, $replace, $selected){
		return array(
				'en' => array(
						'class' => lang_label_class('en', $selected),
						'link' => lang_link_replace($link, $replace, 'en'),
						'text' => "English",
				),
				'sk' => array(
						'class' => lang_label_class('sk', $selected),
						'link' => lang_link_replace($link, $replace, 'sk'),
						'text' => "Slovenčina",
				),
		);
	}
}
if (!function_exists("lang_link_replace")){
	function lang_link_replace($link, $replace, $lang){
		$link = str_replace('%l', $lang, $link);
		if (isset($replace[$lang])){
			foreach($replace[$lang] as $search => $replace){
				$link = str_replace($search, $replace, $link);
			}
		}
		return $link;
	}
}
if (!function_exists("lang_label_class")){
	function lang_label_class($lang, $selected){
		if ($lang == $selected){
			return "light_blue_bg";
		}
		else{
			return "";
		}
	}
}