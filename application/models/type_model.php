<?php
class Type_model extends Select_model{
	
	public static $select = array('type.type_name', 'type.type_name_en', 'type.type_image');
	public static $select_id = array('type.id' ,'type.type_name', 'type.type_name_en', 'type.type_image');
	
	public function __construct(){
		parent::__construct('type', 'id', 'type_name');
	}
}