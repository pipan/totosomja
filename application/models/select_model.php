<?php
class Select_model extends CI_Model{
	
	protected $table = "";
	protected $select_id_field = "";
	protected $select_name_field = "";
	
	public function __construct($table = "", $select_id = "", $select_name = ""){
		parent::__construct();
		$this->table = $table;
		$this->select_id_field = $select_id;
		$this->select_name_field = $select_name;
	}
	
	public function is_id($id){
		if (sizeof($this->get($id)) > 0){
			return true;
		}
		return false;
	}
	
	public function is_empty(){
		$this->db->select($this->select_id_field);
		$this->db->from($this->table);
		$this->db->limit(1, 0);
		return (!$this->db->count_all_results() > 0);
	}
	
	public function get($id = false){
		if ($id == false){
			$query = $this->db->get($this->table);
			return $query->result_array();
		}
		else{
			$query = $this->db->get_where($this->table, array('id =' => $id));
			return $query->row_array();
		}
	}
	
	public function select_form($id, $name, $select = 0, $class= "" ){
		$tmp = $this->get();
		?>
		<select id="<?php echo $id;?>" class="<?php echo $class;?>" name="<?php echo $name;?>">
			<option value="">none</option>
			<?php
			foreach ($tmp as $t){
				if ($select == $t[$this->select_id_field]){
					?>
					<option value="<?php echo $t[$this->select_id_field];?>" selected="<?php echo $t[$this->select_name_field];?>"><?php echo $t[$this->select_name_field];?></option>
					<?php
				}
				else{
					?>
					<option value="<?php echo $t[$this->select_id_field];?>"><?php echo $t[$this->select_name_field];?></option>
					<?php 
				}	
			}
		?>
		</select>
		<?php	
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
}