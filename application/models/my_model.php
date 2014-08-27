<?php
class MY_Model extends CI_Model{
	
	public $table;
	public static $relation;
	public static $select;
	public static $select_id;
	
	public function __construct($table = ""){
		parent::__construct();
		$this->table = $table;
	}
	
	public function is_empty(){
		$this->db->select('id');
		$this->db->from($this->table);
		$this->db->limit(1, 0);
		return (!$this->db->count_all_results() > 0);
	}
	
	public function exists($id){
		$this->db->select('id');
		$this->db->from($this->table);
		$this->db->where('id', $id);
		return ($this->db->count_all_results() > 0);
	}
	
	public function join($join, $select = false){
		if ($select == false){
			$select = $this->select_id;
		}
		foreach ($join as $j){
			if (strpos($j, '.') !== false){
				$explode = explode('.', $j);
				$class = ucfirst($explode[0])."_model"; 
				$rel = $class::get_relation();
				$rel = $rel[$explode[1]];
				$this->db->join($this->relation[$rel]['join'], $this->relation[$rel]['on'], $this->relation[$rel]['type']);
				$select = array_merge($select, $this->relation[$j]['select']);
			}
			else{
				$this->db->join($this->relation[$j]['join'], $this->relation[$j]['on'], $this->relation[$j]['type']);
				if (isset($this->relation[$j]['select'])){
					$tmp_sel = $this->relation[$j]['select'];
				}
				else{
					$class = ucfirst($j)."_model";
					$tmp_sel = $class::get_select();
				}
				$select = array_merge($select, $tmp_sel);
			}
		}
		return $select;
	}
	
	public function get($join = array(), $id = false){
		$this->db->select($this->join($join, $this->select_id));
		if ($id == false){
			$query = $this->db->get($this->table);
			return $query->result_array();
		}
		else{
			$query = $this->db->get_where($this->table, array($this->table.'.id =' => $id));
			return $query->row_array();
		}
	}
	
	public function get_list($join = array(), $limit_from, $limit){
		$this->db->select($this->join($join, $this->select_id));
		$query = $this->db->get($this->table, $limit, $limit_from);
		return $query->result_array();
	}
	
	public function save($data, $id = false){
		if ($id == false){
			$this->db->insert($this->table, $data);
			$ret = $this->db->insert_id();
		}
		else{
			$this->db->where(array('id =' => $id));
			$this->db->update($this->table, $data);
			$ret = $id;
		}
		return $ret;
	}
	
	public function remove($id){
		$this->db->where('id', $id);
		$this->db->delete($this->table);
	}
	
	public function count_all(){
		return $this->db->count_all($this->table);
	}
}