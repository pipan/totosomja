<?php
if (!function_exists("delivery_to_sec")){
	function delivery_to_sec($delivery_count, $delivery_time_kind){
		$n = 0;
		if ($delivery_time_kind > 0 && $delivery_time_kind < 4){
			$n = 24*60*60;
		}
		if ($delivery_time_kind == 2){
			$n *= 7;
		}
		if ($delivery_time_kind == 3){
			$n *= 30;
		}
		$n *= $delivery_count;
		return $n;
	}
}

if (!function_exists("delivery_to_form")){
	function delivery_to_form($delivery){
		$day = 24*60*60;
		$ret[0] = 0;
		$ret[1] = 0;
		$delivery /=$day;
		$ret[0] = $delivery;
		$ret[1] = 1;
		if (($delivery % 30) == 0){
			$ret[1] = 3;
			$ret[0] = $delivery / 30;
		}
		elseif (($delivery % 7) == 0){
			$ret[1] = 2;
			$ret[0] = $delivery / 7;
		}
		return array($ret[0], $ret[1]);
	}
}

if (!function_exists("delivery_to_form_text")){
	function delivery_to_form_text($delivery){
		$day = 24*60*60;
		$ret[0] = 0;
		$ret[1] = "";
		$delivery /=$day;
		$ret[0] = $delivery;
		$ret[1] = "day";
		if (($delivery % 30) == 0){
			$ret[1] = "month";
			$ret[0] = $delivery / 30;
		}
		elseif (($delivery % 7) == 0){
			$ret[1] = "week";
			$ret[0] = $delivery / 7;
		}
		return array($ret[0], $ret[1]);
	}
}