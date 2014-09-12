<?php
class Invoic_model extends MY_Model{
	
	public function __construct(){
		parent::__construct('invoic');
		$this->select = array('invoic.seller_id', 'invoic.buyer_name', 'invoic.buyer_surname', 'invoic.customer_id', 'invoic.invoic_address_id', 'invoic.shipping_address_id', 'invoic.payer_email', 'invoic.transaction_id', 'invoic.transaction_date', 'invoic.order_status_id', 'invoic.invoic_id', 'invoic.payment_status', 'invoic.tax', 'invoic.note');
		$this->select_id = array('invoic.id', 'invoic.seller_id', 'invoic.buyer_name', 'invoic.buyer_surname', 'invoic.customer_id', 'invoic.invoic_address_id', 'invoic.shipping_address_id', 'invoic.payer_email', 'invoic.transaction_id', 'invoic.transaction_date', 'invoic.order_status_id', 'invoic.invoic_id', 'invoic.payment_status', 'invoic.tax', 'invoic.note');
		$this->relation = array(
				'seller' => array(
						'join' => 'firm',
						'on' => 'invoic.seller_id=firm.id',
						'type' => 'inner',
						'select' => Firm_model::get_select(),
				),
				'customer' => array(
						'join' => 'customer',
						'on' => 'invoic.customer_id=customer.id',
						'type' => 'left',
						'select' => Customer_model::$select,
				),
				'invoic_address' => array(
						'join' => 'address',
						'on' => 'invoic.invoic_address_id=address.id',
						'type' => 'inner',
						'select' => Address_model::get_select_as('ia'),
						'as' => 'ia',
				),
				'shipping_address' => array(
						'join' => 'address',
						'on' => 'invoic.shipping_address_id=address.id',
						'type' => 'left',
						'select' => Address_model::get_select_as('sa'),
						'as' => 'sa',
				),
				'status' => array(
						'join' => 'order_status',
						'on' => 'invoic.order_status_id=order_status.id',
						'type' => 'inner',
						'select' => Order_status_model::get_select(),
				),
				'seller_address' => array(
						'join' => 'address',
						'on' => 'firm.address_id=address.id',
						'type' => 'inner',
						'select' => Address_model::get_select_as('fa'),
						'as' => 'fa',
				),
		);
	}
	
	public static function get_select(){
		return array('invoic.seller_id', 'invoic.buyer_name', 'invoic.buyer_surname', 'invoic.customer_id', 'invoic.invoic_address_id', 'invoic.shipping_address_id', 'invoic.payer_email', 'invoic.transaction_id', 'invoic.transaction_date', 'invoic.order_status_id', 'invoic.invoic_id', 'invoic.payment_status', 'invoic.tax', 'invoic.note');
	}
	public static function get_select_id(){
		return array('invoic.id', 'invoic.seller_id', 'invoic.buyer_name', 'invoic.buyer_surname', 'invoic.customer_id', 'invoic.invoic_address_id', 'invoic.shipping_address_id', 'invoic.payer_email', 'invoic.transaction_id', 'invoic.transaction_date', 'invoic.order_status_id', 'invoic.invoic_id', 'invoic.payment_status', 'invoic.tax', 'invoic.note');
	}
	
	public function exists_by_txn_id($txn_id){
		$this->db->select('id');
		$this->db->from($this->table);
		$this->db->where('transaction_id', $txn_id);
		return ($this->db->count_all_results() > 0);
	}
	
	public function exists_to_customer($invoic_id, $customer_id){
		$this->db->select('id');
		$this->db->from($this->table);
		$this->db->where('id', $invoic_id);
		$this->db->where('customer_id', $customer_id);
		return ($this->db->count_all_results() > 0);
	}
	
	public function get($join = array(), $id = false){
		$this->db->select($this->join($join, $this->select_id));
		if ($id == false){
			$this->db->order_by('transaction_date DESC');
			$query = $this->db->get($this->table);
			return $query->result_array();
		}
		else{
			$query = $this->db->get_where($this->table, array($this->table.'.id =' => $id));
			return $query->row_array();
		}
	}
	
	public function get_last($join = array()){
		if (!$this->is_empty()){
			$this->db->select($this->join($join, $this->select_id));
			$this->db->order_by('id DESC');
			$query = $this->db->get($this->table, 1, 0);
			return $query->row_array();
		}
		else{
			return false;
		}
	}
	
	public function get_by_txn_id($txn_id, $join = array()){
		$this->db->select($this->join($join, $this->select_id));
		$query = $this->db->get_where($this->table, array('transaction_id' => $txn_id));
		return $query->row_array();
	}
	
	public function get_by_customer_id($customer_id, $join = array()){
		$this->db->select($this->join($join, $this->select_id));
		$query = $this->db->get_where($this->table, array('customer_id' => $customer_id));
		return $query->result_array();
	}
	
	public function save_by_txn_id($data, $txn_id){
		$this->db->where(array('transaction_id =' => $txn_id));
		$this->db->update($this->table, $data);
		$invoic = $this->get_by_txn_id($txn_id);
		return $invoid['id'];
	}
}