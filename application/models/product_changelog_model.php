<?php
class Product_model extends CI_Model{
	
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
	
	public function get_sellable($where = array(), $list = true){
		$where = array_merge(array('canceled =' => '0', 'sellable =' => '1'), $where);
		$join = array('category', 'type', 'color', 'size', 'material', 'supplier');
		$this->db->select($this->join($join, Product_model::$select_id));
		$this->db->where($where);
		$query = $this->db->get('product');
		if ($list){
			return $query->result_array();
		}
		else{
			return $query->row_array();
		}
	}
	
	/**
	 * @param integet $limit_from - od ktoreo zaznamu treba vytvarat dopyt
	 * @param integer $limit - aky je maximalny pocet (limit) v zazname
	 * @return array - pole zaznamov, maximalny pocet je $limit
	 */
	public function get_sellable_list($where, $limit_from, $limit){
		$where = array_merge($where, array('canceled =' => '0', 'sellable =' => '1'));
		$join = array('category', 'type', 'color', 'size', 'material', 'supplier');
		$this->db->select($this->join($join, Product_model::$select_id));
		$this->db->where($where);
		$query = $this->db->get('product', $limit, $limit_from);
		return $query->result_array();
	}
	
	/**
	 * ziskanie zoznamu jedneho produktu na zaklade slugu - specialneho nazvu
	 * @return row jeden zaznam - produkt
	 */
	public function get_by_slug($slug){
		$where = array('canceled =' => '0', 'sellable =' => '1', 'product_slug' => $slug);
		$join = array('category', 'type', 'color', 'size', 'material', 'supplier');
		$this->db->select($this->join($join, Product_model::$select_id));
		$query = $this->db->get_where('product', $where);
		return $query->row_array();
	}
	
	public function count_all_sellable($where = array()){
		$where = array_merge($where, array('canceled =' => '0', 'sellable =' => '1'));
		$this->db->where($where);
		return $this->db->count_all_results('product');
	}
	
	public function save($data){
		$this->db->insert('product_changelog', $data);
		$ret = $this->db->insert_id();
		return $ret;
	}
	
	public function update($id, $set){
		$this->db->where(array('id =' => $id));
		$this->db->set($set);
		$this->db->update('product');
	}
	
	public function set_canceled($id){
		$this->db->where(array('id =' => $id));
		$this->db->set('canceled', '1');
		$this->db->update('product');
	}
}