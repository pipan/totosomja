<?php
if (!function_exists("is_admin_login")){
	function is_admin_login($controller){
		return ($controller->session->userdata('admin_id') != false);
	}
}