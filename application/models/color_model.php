<?php
class Color_model extends Select_model{
	
	public static $select = array('color.color_name', 'color.color_name_en');
	public static $select_id = array('color.id' ,'color.color_name', 'color.color_name_en');
	
	public function __construct(){
		parent::__construct('color', 'id', 'color_name');
	}
}