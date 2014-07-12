<?php
if (!function_exists("is_login")){
	function is_login($controller){
		if ($controller->session->userdata('login') == false){
			if ($controller->input->cookie('totosomja_login') != false){
				$customer = $controller->customer_model->get(array(), $controller->input->cookie('totosomja_login'));
				$session_data = array(
						'login' => array(
								'id' => $customer['id'],
								'nickname' => $customer['customer_nickname'],
						),
				);
				$controller->session->set_userdata($session_data);
				return true;
			}
			else{
				return false;
			}
		}
		else{
			return true;
		}
	}
}