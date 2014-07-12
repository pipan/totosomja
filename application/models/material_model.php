<?php
class Material_model extends Select_model{
	
	public static $select = array('material.material_name');
	public static $select_id = array('material.id' ,'material.material_name');
	
	public function __construct(){
		parent::__construct('material', 'id', 'material_name');
	}
}