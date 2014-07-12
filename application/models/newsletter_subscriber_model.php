<?php
class Newsletter_subscriber_model extends CI_Model{
	
	public static $select = array('newsletter_subscriber.email', 'newsletter_subscriber.subscribe_date');
	public static $select_id = array('newsletter_subscriber.id', 'newsletter_subscriber.email', 'newsletter_subscriber.subscribe_date');
	
	public function __construct(){
		parent::__construct();
	}
	
	public function is_empty(){
		$this->db->select('id');
		$this->db->from('newsletter_subscriber');
		$this->db->limit(1, 0);
		return (!$this->db->count_all_results() > 0);
	}
		
	public function save($data){
		$this->db->insert('newsletter_subscriber', $data);
		$ret = $this->db->insert_id();
		return $ret;
	}
}