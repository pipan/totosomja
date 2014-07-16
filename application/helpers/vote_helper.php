<?php
if (!function_exists("vote_percentage")){
	function vote_percentage($vote, $all){
		if ($all == 0){
			return 0;
		}
		else{
			return round(($vote / $all) * 100, 2);
		}
	}
}