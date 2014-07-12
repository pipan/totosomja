<?php
class Admin_model extends CI_Model{
	
	public static $select = array('admin.admin_name', 'admin.admin_surname', 'admin.admin_email');
	
	public function get($id = false){
		$this->db->select(Admin_model::$select);
		if ($id === false){
			$query = $this->db->get('admin');
			return $query->result_array();
		}
		$query = $this->db->get_where('admin', array('id' => $id));
		return $query->row_array();
	}
	
	public function get_admin($id = false){
		if ($id === false){
			$query = $this->db->get('admin');
			return $query->result_array();
		}
		$query = $this->db->get_where('admin', array('id' => $id));
		return $query->row_array();
	}
	
	public function search_full_nick($name = null){
		if ($name != null){
			$query = $this->db->get_where('admin', array('admin_nick' => $name));
			return $query->row_array();
		}
	}
	
	public function save($table_data, $id = false){
		if ($id == false){
			$this->db->insert('admin', $table_data);
			return $this->db_insert_id();
		}
		else{
			$this->db->where('id', $id);
			$this->db->update('admin', $table_data);
			return $id;
		}
	}
}