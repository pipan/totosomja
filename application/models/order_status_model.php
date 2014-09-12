<?php
class Order_status_model extends MY_Model{
	
	public function __construct(){
		parent::__construct('order_status');
		$this->select = array('order_status.status_name', 'order_status.status_name_en');
		$this->select_id = array('order_status.id', 'order_status.status_name', 'order_status.status_name_en');
	}
	
	public static function get_select(){
		return array('order_status.status_name', 'order_status.status_name_en');
	}
	public static function get_select_id(){
		return array('order_status.id', 'order_status.status_name', 'order_status.status_name_en');
	}
}