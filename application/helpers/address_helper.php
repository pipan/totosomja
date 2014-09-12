<?php
if (!function_exists("invoic_address_match")){
	function invoic_address_match($input){
		$ret = true;
		$tables = array('ia', 'sa');
		$columns = array('town', 'postal_code', 'street', 'street_number', 'country');
		foreach ($columns as $c){
			$prev = "";
			foreach ($tables as $t){
				if ($input->post($t."_".$c) == false){
					$ret = false;
					break;
				}
				if ($prev != "" && $input->post($t."_".$c) != $prev){
					$ret = false;
					break;
				}
				$prev = $input->post($t."_".$c);
			}
			if ($ret == false){
				break;
			}
		}
		return $ret;
	}
}