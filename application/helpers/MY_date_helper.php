<?php
if (!function_exists("get_dtw_minute")){
	function get_dtw_minute($language, $minute){
		$ret = "";
		switch ($language){
			case "en":
				if ($minute < 2){
					$ret = "minute";
				}
				else{
					$ret = "minutes";
				}
				break;
			case "sk":
			default:
				if ($minute < 2){
					$ret = "minutou";
				}
				else{
					$ret = "minutami";
				}
				break;
		}
		return $ret;
	}
}
if (!function_exists("get_dtw_hour")){
	function get_dtw_hour($language, $hour){
		$ret = "";
		switch ($language){
			case "en":
				if ($hour < 2){
					$ret = "hour";
				}
				else{
					$ret = "hours";
				}
				break;
			case "sk":
			default:
				if ($hour < 2){
					$ret = "hodinou";
				}
				else{
					$ret = "hodinami";
				}
				break;
		}
		return $ret;
	}
}
if (!function_exists("get_dtw_day")){
	function get_dtw_day($language, $day){
		$ret = "";
		switch ($language){
			case "en":
				if ($day < 2){
					$ret = "day";
				}
				else{
					$ret = "days";
				}
				break;
			case "sk":
			default:
				if ($day < 2){
					$ret = "dnom";
				}
				else{
					$ret = "dnami";
				}
				break;
		}
		return $ret;
	}
}
if (!function_exists("get_dtw_month")){
	function get_dtw_month($language, $month){
		$ret = "";
		switch ($language){
			case "en":
				if ($month < 2){
					$ret = "month";
				}
				else{
					$ret = "months";
				}
				break;
			case "sk":
			default:
				if ($month < 2){
					$ret = "mesiacom";
				}
				else{
					$ret = "mesiacmi";
				}
				break;
		}
		return $ret;
	}
}
if (!function_exists("get_dtw_year")){
	function get_dtw_year($language, $year){
		$ret = "";
		switch ($language){
			case "en":
				if ($year < 2){
					$ret = "year";
				}
				else{
					$ret = "years";
				}
				break;
			case "sk":
			default:
				if ($year < 2){
					$ret = "rokom";
				}
				else{
					$ret = "rokmi";
				}
				break;
		}
		return $ret;
	}
}
if (!function_exists("get_dtw_string")){
	function get_dtw_string($language){
		$ret = "";
		switch ($language){
			case "en":
				$ret = '%n %w ago';
				break;
			case "sk":
			default:
				$ret = 'pred %n %w';
				break;
		}
		return $ret;
	}
}
if (!function_exists("date_to_word")){
	function date_to_word($language, $datum){
		$ret = get_dtw_string($language);
		$rozdel = explode(" ", $datum);
		$rozdel2 = explode("-", $rozdel[0]);
		$rozdel3 = explode(":", $rozdel[1]);
		if ($rozdel2[2] > 30){
			$rozdel2[2] = 30;
		}
		$mesiac = date("d");
		if ($mesiac > 30){
			$mesiac = 30;
		}
		$datum_min = $rozdel3[1] + $rozdel3[0] * 60 + $rozdel2[2] * 60 * 24 + $rozdel2[1] * 60 * 24 * 30 + $rozdel2[0] * 60 * 24 * 30 * 12;
		$now_min = date("i") + date("H") * 60 + $mesiac * 60 * 24 + date("m") * 60 * 24 * 30 + date("Y") * 60 * 24 * 30 * 12;
		$rozdiel = $now_min - $datum_min;
		if ($rozdiel < 60){
			$n = $rozdiel;
			$w = get_dtw_minute($language, $n);
		}
		elseif ($rozdiel < (24 * 60)){
			$n = floor($rozdiel/60);
			$w = get_dtw_hour($language, $n);
		}
		elseif ($rozdiel < (30 * 24 * 60)){
			$n = floor($rozdiel / (60 * 24));
			$w = get_dtw_day($language, $n);
		}
		elseif ($rozdiel < (12 * 30 * 24 * 60)){
			$n = floor($rozdiel / (60 * 24 * 30));
			$w = get_dtw_month($language, $n);
		}
		else{
			$n = floor($rozdiel / (60 * 24 * 30 * 12));
			$w = get_dtw_year($language, $rozdiel);
		}
		$ret = str_replace('%n', $n, $ret);
		$ret = str_replace('%w', $w, $ret);
		return $ret;
	}
}