<?php
class Product_model extends CI_Model{
	
	public $relation;
	public static $select = array('product.product_name', 'product.product_name_en', 'product.product_slug', 'product.product_slug_en', 'product.category_id', 'product.type_id', 'product.color_id', 'product.size_id', 'product.material_id', 'product.supplier_id', 'product.gender', 'product.store', 'product.product_image', 'product.price', 'product.paypal_button', 'product.sellable', 'product.canceled', 'product.created');
	public static $select_id = array('product.id', 'product.product_name', 'product.product_name_en', 'product.product_slug', 'product.product_slug_en', 'product.category_id', 'product.type_id', 'product.color_id', 'product.size_id', 'product.material_id', 'product.supplier_id', 'product.gender', 'product.store', 'product.product_image', 'product.price', 'product.paypal_button', 'product.sellable', 'product.canceled', 'product.created');
	
	public function __construct(){
		parent::__construct();
		$this->relation = array(
				'category' => array(
						'join' => 'category',
						'on' => 'product.category_id=category.id',
						'type' => 'left',
						'select' => Category_model::$select,
				),
				'type' => array(
						'join' => 'type',
						'on' => 'product.type_id=type.id',
						'type' => 'inner',
						'select' => Type_model::$select,
				),
				'color' => array(
						'join' => 'color',
						'on' => 'product.color_id=color.id',
						'type' => 'left',
						'select' => Color_model::$select,
				),
				'size' => array(
						'join' => 'size',
						'on' => 'product.size_id=size.id',
						'type' => 'left',
						'select' => Size_model::$select,
				),
				'material' => array(
						'join' => 'material',
						'on' => 'product.material_id=material.id',
						'type' => 'left',
						'select' => Material_model::$select,
				),
				'supplier' => array(
						'join' => 'supplier',
						'on' => 'product.supplier_id=supplier.id',
						'type' => 'left',
						'select' => Supplier_model::$select,
				),
		);
	}
	
	public static function get_select(){
		return array('product.product_name', 'product.product_name_en', 'product.product_slug', 'product.product_slug_en', 'product.category_id', 'product.type_id', 'product.color_id', 'product.size_id', 'product.material_id', 'product.supplier_id', 'product.gender', 'product.store', 'product.product_image', 'product.price', 'product.paypal_button', 'product.sellable', 'product.canceled', 'product.created');
	}
	public static function get_select_id(){
		return array('product.id', 'product.product_name', 'product.product_name_en', 'product.product_slug', 'product.product_slug_en', 'product.category_id', 'product.type_id', 'product.color_id', 'product.size_id', 'product.material_id', 'product.supplier_id', 'product.gender', 'product.store', 'product.product_image', 'product.price', 'product.paypal_button', 'product.sellable', 'product.canceled', 'product.created');
	}
	
	public function is_sellable($where = array()){
		$where = array_merge(array('canceled =' => '0', 'sellable =' => '1'), $where);
		$this->db->select('id');
		$this->db->from('product');
		$this->db->where($where);
		$this->db->limit(1, 0);
		if ($this->db->count_all_results() > 0){
			return true;	
		}
		else{
			return false;
		}
	}
	
	public function is_unique_sellable($name){
		$slug = url_title(convert_accented_characters($name), '-', TRUE);
		if ($this->is_sellable(array('product_slug =' => $slug))){
			return $this->get_sellable(array('product_slug =' => $slug), false)['id'];
		}
		return true;
	}
	
	public function is_unique_sellable_en($name){
		$slug = url_title(convert_accented_characters($name), '-', TRUE);
		if ($this->is_sellable(array('product_slug_en =' => $slug))){
			return $this->get_sellable(array('product_slug_en =' => $slug), false)['id'];
		}
		return true;
	}
	
	public function join($join, $select = false){
		if ($select == false){
			$select = Product_model::$select_id;
		}
		foreach ($join as $j){
			$this->db->join($this->relation[$j]['join'], $this->relation[$j]['on'], $this->relation[$j]['type']);
			$select = array_merge($select, $this->relation[$j]['select']);
		}
		return $select;
	}
	
	public function get($id){
		$where = array('canceled =' => '0', 'sellable =' => '1', 'id' => $id);
		$this->db->select(Product_model::$select_id);
		$this->db->where($where);
		$query = $this->db->get('product');
		return $query->row_array();
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
	public function get_by_slug($slug, $ext){
		$where = array('canceled =' => '0', 'sellable =' => '1', 'product_slug'.$ext => $slug);
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
		$this->db->insert('product', $data);
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
		$this->db->set('paypal_button', null);
		$this->db->update('product');
	}
}