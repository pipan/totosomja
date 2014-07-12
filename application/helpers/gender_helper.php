<?php
if (!function_exists("gender_to_string")){
	function gender_to_string($gender){
		if ($gender == 0){
			return "male";
		}
		elseif ($gender == 1){
			return "female";
		}
		else{
			return "unknown";
		}
	}
}