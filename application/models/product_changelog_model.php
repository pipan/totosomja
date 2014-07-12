<?php
class Product_changelog_model extends CI_Model{
	
	public $relation;
	public static $select = array('product_changelog.product_id', 'product_changelog.admin_id', 'product_changelog.change_id', 'product_changelog.change_date');
	public static $select_id = array('product_changelog.id', 'product_changelog.product_id', 'product_changelog.admin_id', 'product_changelog.change_id', 'product_changelog.change_date');
	
	public function __construct(){
		parent::__construct();
		$this->relation = array(
				'product' => array(
						'join' => 'product',
						'on' => 'product_changelog.product_id=product.id',
						'type' => 'inner',
						'select' => Product_model::$select,
				),
				'admin' => array(
						'join' => 'type',
						'on' => 'product_changelog.admin_id=admin.id',
						'type' => 'inner',
						'select' => Admin_model::$select,
				),
				'change' => array(
						'join' => 'change_label',
						'on' => 'product_changelog.change_id=change_label.id',
						'type' => 'inner',
						'select' => Change_label_model::$select,
				),
		);
	}
	
	public function join($join, $select = false){
		if ($select == false){
			$select = Product_changelog_model::$select_id;
		}
		foreach ($join as $j){
			$this->db->join($this->relation[$j]['join'], $this->relation[$j]['on'], $this->relation[$j]['type']);
			$select = array_merge($select, $this->relation[$j]['select']);
		}
		return $select;
	}
	
	public function save($data){
		$this->db->insert('product_changelog', $data);
		$ret = $this->db->insert_id();
		return $ret;
	}
}