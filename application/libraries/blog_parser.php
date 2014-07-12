<?php
class Blog_parser{
	
	public static function parse_link($text){
		if ($text != false){
			$list = array();
			$lines = explode(PHP_EOL, $text);
			$i = 0;
			$j = 0;
			while ($i < (sizeof($lines) - 1)){
				$list[$j] = array(
						'text' => substr($lines[$i++], 6),
						'link' => substr($lines[$i++], 6),
				);
				$j++;
			}
			return $list;
		}
		else{
			return array();
		}
	}
	
	public static function parse_image($text){
		if ($text != false){
			$list = array();
			$lines = explode(PHP_EOL, $text);
			$i = 0;
			$j = 0;
			while ($i < (sizeof($lines) - 1)){
				$list[$j] = array(
						'text' => substr($lines[$i++], 6),
						'link' => substr($lines[$i++], 6),
						'width' => substr($lines[$i++], 7),
						'alignment' => substr($lines[$i++], 11),
				);
				$j++;
			}
			return $list;
		}
		else{
			return array();
		}
	}
	
	public static function parse_video($text){
		if ($text != false){
			$list = array();
			$lines = explode(PHP_EOL, $text);
			$i = 0;
			$j = 0;
			while ($i < (sizeof($lines) - 1)){
				$list[$j] = array(
						'text' => substr($lines[$i++], 6),
						'link' => substr($lines[$i++], 6),
						'code' => substr($lines[$i++], 6),
						'width' => substr($lines[$i++], 6),
						'alignment' => substr($lines[$i++], 11),
				);
				$j++;
			}
			return $list;
		}
		else{
			return array();
		}
	}
	
	public function pure_text($text, $blog_id){
		//remove image
		if (($image = read_file("./content/blog/".$blog_id."/image.txt")) != false){
			$lines = explode(PHP_EOL, $image);
			$i = 0;
			$j = 1;
			while ($i < (sizeof($lines) - 1)){
				$text = str_replace("[IMAGE-".$j."]", "", $text);
				$i += 4;
				$j++;
			}
		}
		//remove video
		if (($video = read_file("./content/blog/".$blog_id."/video.txt")) != false){
			$lines = explode(PHP_EOL, $video);
			$i = 0;
			$j = 1;
			while ($i < (sizeof($lines) - 1)){
				$text = str_replace("[VIDEO-".$j."]", "", $text);
				$i += 5;
				$j++;
			}
		}
		//replace link
		if (($link = read_file("./content/blog/".$blog_id."/link.txt")) != false){
			$lines = explode(PHP_EOL, $link);
			$i = 0;
			$j = 1;
			while ($i < (sizeof($lines) - 1)){
				$text = str_replace("[LINK-".$j."]", substr($lines[$i], 6), $text);
				$i += 2;
				$j++;
			}
		}
		return $text;
	}
}