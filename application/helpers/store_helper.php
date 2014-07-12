<?php
if (!function_exists("store_to_string")){
	function store_to_string($store){
		if ($store == 0){
			return "nie je na sklade";
		}
		else{
			return "na sklade";
		}
	}
}