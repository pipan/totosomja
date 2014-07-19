<?php
if (!function_exists("get_foreign")){
	function get_foreign($id, $zero = false){
		if ($id != '' && ($zero || $id > 0)){
			return $id;
		}
		else{
			return null;
		}
	}
}