<?php
class Color_model extends Select_model{
	
	public static $select = array('color.color_name');
	public static $select_id = array('color.id' ,'color.color_name');
	
	public function __construct(){
		parent::__construct('color', 'id', 'color_name');
	}
}