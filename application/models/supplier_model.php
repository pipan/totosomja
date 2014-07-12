<?php
class Supplier_model extends Select_model{
	
	public static $select = array('supplier.supplier_name', 'supplier.supplier_delivery');
	public static $select_id = array('supplier.id' ,'supplier.supplier_name', 'supplier.supplier_delivery');
	
	public function __construct(){
		parent::__construct('supplier', 'id', 'supplier_name');
	}
}