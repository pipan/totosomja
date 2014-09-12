<?php
class Address_model extends CI_Model{

	public $relation;
	public static $select = array('address.town', 'address.postal_code', 'address.street', 'address.street_number', 'address.country', 'address.creator_id');
	public static $select_id = array('address.id' ,'address.town', 'address.postal_code', 'address.street', 'address.street_number', 'address.country', 'address.creator_id');

	public function __construct(){
		parent::__construct();
		$this->relation = array(
		
		);
	}
	
	public static function get_select_as($as){
		return array($as.'.town AS '.$as.'_town', $as.'.postal_code AS '.$as.'_postal_code', $as.'.street AS '.$as.'_street', $as.'.street_number AS '.$as.'_street_number', $as.'.country AS '.$as.'_country', $as.'.creator_id AS '.$as.'_creator_id');
	}

	public function is_empty(){
		$this->db->select('id');
		$this->db->from('address');
		$this->db->limit(1, 0);
		return (!$this->db->count_all_results() > 0);
	}
	
	public function data_match($id, $data){
		$ret = true;
		$db_data = $this->get(array(), $id);
		foreach ($data as $key => $d){
			echo $key."=>".$d;
			if (!isset($db_data[$key])){
				$ret = false;
				break;
			}
			else{
				if ($d != $db_data[$key]){
					$ret = false;
					break;
				}
			}
		}
		return $ret;
	}
	
	public function creator_match($id, $data){
		$ret = true;
		$db_data = $this->get(array(), $id);
		return ($db_data['creator_id'] == $data['id']);
	}

	public function join($join, $select = false){
		if ($select == false){
			$select = Address_model::$select_id;
		}
		foreach ($join as $j){
			$this->db->join($this->relation[$j]['join'], $this->relation[$j]['on'], $this->relation[$j]['type']);
			$select = array_merge($select, $this->relation[$j]['select']);
		}
		return $select;
	}

	public function get($join = array(), $id = false){
		$this->db->select($this->join($join, Address_model::$select_id));
		if ($id == false){
			$query = $this->db->get('address');
			return $query->result_array();
		}
		else{
			$query = $this->db->get_where('address', array('id =' => $id));
			return $query->row_array();
		}
	}

	public function count_all(){
		return $this->db->count_all('address');
	}
	
	public function set_creator($id, $data){
		$this->db->where('id', $id);
		$this->db->update('address', $data);
	}

	public function save($data, $id = false){
		if ($id == false){
			$this->db->insert('address', $data);
			$ret = $this->db->insert_id();
		}
		else{
			$ret = $id;
			if ($this->creator_match($id, $data) && !$this->data_match($id, $data)){
				$this->db->insert('address', $data);
				$ret = $this->db->insert_id();
			}
		}
		return $ret;
	}
	
	public function save_override($data, $id = false){
		if ($id == false){
			$this->db->insert('address', $data);
			$ret = $this->db->insert_id();
		}
		else{
			$this->db->where(array('id =' => $id));
			$this->db->update('address', $data);
			$ret = $id;
		}
		return $ret;
	}
}