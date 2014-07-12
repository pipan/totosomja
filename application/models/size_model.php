<?php
class Size_model extends Select_model{
	
	public static $select = array('size.size_name');
	public static $select_id = array('size.id' ,'size.size_name');
	
	public function __construct(){
		parent::__construct('size', 'id', 'size_name');
	}
}