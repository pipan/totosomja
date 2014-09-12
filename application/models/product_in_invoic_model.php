<?php
class Product_in_invoic_model extends MY_Model{
	
	public function __construct(){
		parent::__construct('product_in_invoic');
		$this->select = array('product_in_invoic.product_id', 'product_in_invoic.invoic_id', 'product_in_invoic.quantity');
		$this->select_id = array('product_in_invoic.id', 'product_in_invoic.product_id', 'product_in_invoic.invoic_id', 'product_in_invoic.quantity');
		$this->relation = array(
				'invoic' => array(
						'join' => 'invoic',
						'on' => 'product_in_invoic.invoic_id=invoic.id',
						'type' => 'inner',
						'select' => Invoic_model::get_select(),
				),
				'product' => array(
						'join' => 'product',
						'on' => 'product_in_invoic.product_id=product.id',
						'type' => 'inner',
						'select' => Product_model::get_select(),
				),
		);
	}
	
	public static function get_select(){
		return array('product_in_invoic.product_id', 'product_in_invoic.invoic_id', 'product_in_invoic.quantity');
	}
	public static function get_select_id(){
		return array('product_in_invoic.id', 'product_in_invoic.product_id', 'product_in_invoic.invoic_id', 'product_in_invoic.quantity');
	}
	
	public function get_by_invoic($invoic_id, $join = array()){
		$this->db->select($this->join($join, $this->select_id));
		$query = $this->db->get_where($this->table, array('invoic_id' => $invoic_id));
		return $query->result_array();
	}
	
	public function detach_by_invoic($invoic_id){
		$sql = "DELETE FROM product_in_invoic WHERE invoic_id=".$invoic_id;
		$this->db->query($sql);
	}
}