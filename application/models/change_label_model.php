<?php
class Change_label_model extends Select_model{
	
	public static $select = array('change_label.change_name');
	public static $select_id = array('change_label.id' ,'change_label.change_name');
	
	public function __construct(){
		parent::__construct('change_label', 'id', 'change_name');
	}
}