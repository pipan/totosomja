<?php
class Blog_model extends CI_Model{
	
	public $relation;
	public static $select = array('blog.title', 'blog.slug', 'blog.admin_id', 'blog.series_id', 'blog.post_date', 'blog.thumbnail');
	public static $select_id = array('blog.id' ,'blog.title', 'blog.slug', 'blog.admin_id', 'blog.series_id', 'blog.post_date', 'blog.thumbnail');
	
	public function __construct(){
		parent::__construct();
		$this->relation = array(
				'admin' => array(
						'join' => 'admin',
						'on' => 'blog.admin_id=admin.id',
						'type' => 'inner',
						'select' => array('admin.admin_name', 'admin.admin_surname'),
				),
				'series' => array(
						'join' => 'blog_series',
						'on' => 'blog.series_id=blog_series.id',
						'type' => 'left',
						'select' => array('blog_series.series_name'),
				),
		);
	}
	
	public function is_empty(){
		$this->db->select('id');
		$this->db->from('blog');
		$this->db->limit(1, 0);
		return (!$this->db->count_all_results() > 0);
	}
	
	public function exists($id){
		$this->db->select('id');
		$this->db->from('blog');
		$this->db->where('id', $id);
		return ($this->db->count_all_results() > 0);
	}
	
	public function join($join, $select = false){
		if ($select == false){
			$select = Blog_model::$select_id;
		}
		foreach ($join as $j){
			$this->db->join($this->relation[$j]['join'], $this->relation[$j]['on'], $this->relation[$j]['type']);
			$select = array_merge($select, $this->relation[$j]['select']);
		}
		return $select;
	}
	
	public function get($join = array(), $id = false){
		$this->db->select($this->join($join, Blog_model::$select_id));
		if ($id == false){
			$query = $this->db->get('blog');
			return $query->result_array();
		}
		else{
			$query = $this->db->get_where('blog', array('id =' => $id));
			return $query->row_array();
		}
	}
	
	/**
	 * @param integet $limit_from - od ktoreo zaznamu treba vytvarat dopyt
	 * @param integer $limit - aky je maximalny pocet (limit) v zazname
	 * @return array - pole zaznamov, maximalny pocet je $limit
	 */
	public function get_list($limit_from, $limit){
		$this->db->select($this->join(array('admin', 'series'), Blog_model::$select_id));
		$query = $this->db->get('blog', $limit, $limit_from);
		return $query->result_array();
	}
	
	/**
	 * ziskanie zoznamu jedneho blogu na zaklade slugu - specialneho nazvu
	 * @return row jeden zaznam - blog
	 */
	public function get_by_slug($slug){
		$this->db->select($this->join(array('admin', 'series'), Blog_model::$select_id));
		$query = $this->db->get_where('blog', array('slug' => $slug));
		return $query->row_array();
	}
	
	/**
	 * funkcia pre zistenie MONTH-YEAR jedinecnych vyskytov v tabulke blog
	 * @return array jedinecne zaznamy vo formate MONTH-YEAR
	 */
	public function get_year_list(){
		$this->db->select("Distinct(DATE_FORMAT(blog.post_date, '%c-%Y')) as month_year", FALSE);
		$this->db->order_by("YEAR(post_date) DESC, MONTH(post_date) ASC");
		$query = $this->db->get('blog');
		return $query->result_array();
	}
	
	/**
	 * ziskanie zoznamu vsetkych blogov ale len ich nazov, id, a datum vo forme MONTH-YEAR
	 * @return array nazov a datum vo forme MONTH-YEAR
	 */
	public function get_blog_navigator(){
		$this->db->select("id, title, slug, DATE_FORMAT(blog.post_date, '%c-%Y') as month_year", FALSE);
		$this->db->order_by("YEAR(post_date) DESC, MONTH(post_date) ASC");
		$query = $this->db->get('blog');
		return $query->result_array();
	}
	
	public function count_all(){
		return $this->db->count_all('blog');
	}
	
	public function save($data, $id = false){
		if ($id == false){
			$this->db->insert('blog', $data);
			$ret = $this->db->insert_id();
		}
		else{
			$this->db->where(array('id =' => $id));
			$this->db->update('blog', $data);
			$ret = $id;
		}
		return $ret;
	}
}