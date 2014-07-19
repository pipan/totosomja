<?php
class Material_model extends Select_model{
	
	public static $select = array('material.material_name', 'material.material_name_en');
	public static $select_id = array('material.id' ,'material.material_name', 'material.material_name_en');
	
	public function __construct(){
		parent::__construct('material', 'id', 'material_name');
	}
}