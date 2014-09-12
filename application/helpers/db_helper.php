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
if(!function_exists("database_link")){
	function database_link(){
		return "http://nibiru.zarea.net/sqladmin/";
	}
}