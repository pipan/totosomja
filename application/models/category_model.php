<?php
class Category_model extends Select_model{
	
	public static $select = array('category.category_name', 'category.category_name_en', 'category.category_image');
	public static $select_id = array('category.id' ,'category.category_name', 'category.category_name_en', 'category.category_image');
	
	public function __construct(){
		parent::__construct('category', 'id', 'category_name');
	}
}