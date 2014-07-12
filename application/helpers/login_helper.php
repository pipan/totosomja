<?php
if (!function_exists("is_login")){
	function is_login($controller){
		return ($controller->session->userdata('login') != false);
	}
}