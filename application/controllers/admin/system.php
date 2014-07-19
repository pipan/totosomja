<?php
class system extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->library('bcrypt');
		$this->load->helper('string');
	}
	/*
	 * vytvaranie tabuliek, vsetko create table if not exists
	 */
	public function DB_init(){
		if (is_admin_login($this)){
			$this->load->dbforge();
			
			//Table size
			$this->dbforge->add_field('id');
			$fields = array(
					'size_name' => array(
							'type' => 'varchar',
							'constraint' => '20',
					),
					'size_name_en' => array(
							'type' => 'varchar',
							'constraint' => '20',
					),
			);
			$this->dbforge->add_field($fields);
			$this->dbforge->create_table('size', true);
			
			//Table color
			$this->dbforge->add_field('id');
			$fields = array(
					'color_name' => array(
							'type' => 'varchar',
							'constraint' => '30',
					),
					'color_name_en' => array(
							'type' => 'varchar',
							'constraint' => '30',
					),
			);
			$this->dbforge->add_field($fields);
			$this->dbforge->create_table('color', true);
			
			//Table material
			$this->dbforge->add_field('id');
			$fields = array(
					'material_name' => array(
							'type' => 'varchar',
							'constraint' => '30',
					),
					'material_name_en' => array(
							'type' => 'varchar',
							'constraint' => '30',
					),
			);
			$this->dbforge->add_field($fields);
			$this->dbforge->create_table('material', true);
			
			//Table type
			$this->dbforge->add_field('id');
			$fields = array(
					'type_name' => array(
							'type' => 'varchar',
							'constraint' => '30',
					),
					'type_name_en' => array(
							'type' => 'varchar',
							'constraint' => '30',
					),
					'type_image' => array(
							'type' => 'VARCHAR',
							'constraint' => '100',
							'null' => TRUE,
					)
			);
			$this->dbforge->add_field($fields);
			$this->dbforge->create_table('type', true);
			
			//Table category
			$this->dbforge->add_field('id');
			$fields = array(
					'category_name' => array(
							'type' => 'varchar',
							'constraint' => '30',
					),
					'category_name_en' => array(
							'type' => 'varchar',
							'constraint' => '30',
					),
					'category_image' => array(
							'type' => 'VARCHAR',
							'constraint' => '100',
							'null' => TRUE,
					),
			);
			$this->dbforge->add_field($fields);
			$this->dbforge->create_table('category', true);
			
			//Table supplier
			$this->dbforge->add_field('id');
			$fields = array(
					'supplier_name' => array(
							'type' => 'varchar',
							'constraint' => '30',
					),
					'supplier_delivery' => array(
							'type' => 'int',
							'constraint' => '11',
					),
			);
			$this->dbforge->add_field($fields);
			$this->dbforge->create_table('supplier', true);
			
			//Table address
			$this->db->query("CREATE TABLE IF NOT EXISTS address(
					id int(9) NOT NULL AUTO_INCREMENT,
					town varchar(50) NOT NULL,
					postal_code varchar(10) NOT NULL,
					street varchar(50) NOT NULL,
					street_number varchar(10) NOT NULL,
					country varchar(40) NOT NULL,
					creator_id int(9),
					PRIMARY KEY (id))
					COLLATE utf8_general_ci,
					ENGINE innoDB");
			
			//Table customer
			$this->db->query("CREATE TABLE IF NOT EXISTS customer(
					id int(9) NOT NULL AUTO_INCREMENT,
					email varchar(100) NOT NULL,
					salt varchar(16) NOT NULL,
					password varchar(64) NOT NULL,
					customer_nickname varchar(50) NOT NULL,
					customer_name varchar(50) NOT NULL,
					customer_surname varchar(50) NOT NULL,
					customer_gender tinyint(1),
					customer_birthday date,
					address_id int(9) NOT NULL,
					PRIMARY KEY (id),
					INDEX customer_nickname_id USING BTREE (customer_nickname),
					FOREIGN KEY (address_id) REFERENCES address(id))
					COLLATE utf8_general_ci,
					ENGINE innoDB");
			
			//Table invoic
			$this->db->query("CREATE TABLE IF NOT EXISTS invoic(
					id int(9) NOT NULL AUTO_INCREMENT,
					customer_id int(9) NOT NULL,
					shipping_address_id int(9) NOT NULL,
					PRIMARY KEY (id),
					FOREIGN KEY (customer_id) REFERENCES customer(id),
					FOREIGN KEY (shipping_address_id) REFERENCES address(id))
					COLLATE utf8_general_ci,
					ENGINE innoDB");
			
			//Table product
			$this->db->query("CREATE TABLE IF NOT EXISTS product(
					id int(9) NOT NULL AUTO_INCREMENT,
					product_name varchar(70) NOT NULL,
					product_slug varchar(70) NOT NULL,
					product_name_en varchar(70) NOT NULL,
					product_slug_en varchar(70) NOT NULL,
					type_id int(9) NOT NULL,
					category_id int(9),
					color_id int(9),
					size_id int(9),
					material_id int(9),
					supplier_id int(9),
					gender tinyint(2) NOT NULL,
					store int(11) NOT NULL,
					product_image varchar(100),
					price float(4,2) NOT NULL,
					sellable tinyint(1) NOT NULL,
					canceled tinyint(1) NOT NULL,
					created datetime NOT NULL,
					PRIMARY KEY (id),
					INDEX product_slug_id USING BTREE (product_slug),
					INDEX product_slug_en_id USING BTREE (product_slug_en),
					FOREIGN KEY (type_id) REFERENCES type(id),
					FOREIGN KEY (category_id) REFERENCES category(id),
					FOREIGN KEY (color_id) REFERENCES color(id),
					FOREIGN KEY (size_id) REFERENCES size(id),
					FOREIGN KEY (material_id) REFERENCES material(id),
					FOREIGN KEY (supplier_id) REFERENCES supplier(id))
					COLLATE utf8_general_ci,
					ENGINE innoDB");
			
			//Table product_in_invoic
			$this->db->query("CREATE TABLE IF NOT EXISTS product_in_invoic(
					id int(9) NOT NULL AUTO_INCREMENT,
					product_id int(9) NOT NULL,
					invoic_id int(9) NOT NULL,
					PRIMARY KEY (id),
					FOREIGN KEY (product_id) REFERENCES product(id),
					FOREIGN KEY (invoic_id) REFERENCES invoic(id))
					COLLATE utf8_general_ci,
					ENGINE innoDB");
			
			//Table change_label
			$this->dbforge->add_field('id');
			$fields = array(
					'change_name' => array(
							'type' => 'varchar',
							'constraint' => '40',
					),
			);
			$this->dbforge->add_field($fields);
			$this->dbforge->create_table('change_label', true);
			
			//Table admin
			$this->dbforge->add_field('id');
			$fields = array(
					'admin_nick' => array(
							'type' => 'varchar',
							'constraint' => '30',
					),
					'admin_name' => array(
							'type' => 'varchar',
							'constraint' => '50',
					),
					'admin_surname' => array(
							'type' => 'varchar',
							'constraint' => '50',
					),
					'admin_email' => array(
							'type' => 'varchar',
							'constraint' => '100',
					),
					'salt' => array(
							'type' => 'varchar',
							'constraint' => '16',
					),
					'password' => array(
							'type' => 'varchar',
							'constraint' => '256',
					),
			);
			$this->dbforge->add_field($fields);
			$this->dbforge->create_table('admin', true);
			
			//Table product_changelog
			$this->db->query("CREATE TABLE IF NOT EXISTS product_changelog(
					id int(9) NOT NULL AUTO_INCREMENT,
					product_id int(9) NOT NULL,
					admin_id int(9) NOT NULL,
					change_id int(9) NOT NULL,
					change_date datetime,
					PRIMARY KEY (id),
					FOREIGN KEY (product_id) REFERENCES product(id),
					FOREIGN KEY (admin_id) REFERENCES admin(id),
					FOREIGN KEY (change_id) REFERENCES change_label(id))
					COLLATE utf8_general_ci,
					ENGINE innoDB");
			
			//Table comment
			$this->db->query("CREATE TABLE IF NOT EXISTS comment(
					id int(9) NOT NULL AUTO_INCREMENT,
					product_id int(9) NOT NULL,
					customer_id int(9) NOT NULL,
					post_date datetime,
					value int(11) NOT NULL DEFAULT '0',
					PRIMARY KEY (id),
					FOREIGN KEY (product_id) REFERENCES product(id),
					FOREIGN KEY (customer_id) REFERENCES customer(id))
					COLLATE utf8_general_ci,
					ENGINE innoDB");
			
			//Table wishlist
			$this->db->query("CREATE TABLE IF NOT EXISTS wishlist(
					id int(9) NOT NULL AUTO_INCREMENT,
					product_id int(9) NOT NULL,
					customer_id int(9) NOT NULL,
					wish_date datetime,
					PRIMARY KEY (id),
					FOREIGN KEY (product_id) REFERENCES product(id),
					FOREIGN KEY (customer_id) REFERENCES customer(id))
					COLLATE utf8_general_ci,
					ENGINE innoDB");
			
			//Table blog_series
			$this->db->query("CREATE TABLE IF NOT EXISTS blog_series(
					id int(9) NOT NULL AUTO_INCREMENT,
					admin_id int(9) NOT NULL,
					series_name varchar(50) NOT NULL,
					series_name_en varchar(50) NOT NULL,
					PRIMARY KEY (id),
					FOREIGN KEY (admin_id) REFERENCES admin(id))
					COLLATE utf8_general_ci,
					ENGINE innoDB");
			
			//Table blog
			$this->db->query("CREATE TABLE IF NOT EXISTS blog(
					id int(9) NOT NULL AUTO_INCREMENT,
					admin_id int(9) NOT NULL,
					title varchar(70) NOT NULL,
					slug varchar(70) NOT NULL,
					title_en varchar(70),
					slug_en varchar(70),
					series_id int(9),
					post_date datetime,
					thumbnail varchar(100),
					PRIMARY KEY (id),
					INDEX slug_id USING BTREE (slug),
					INDEX slug_en_id USING BTREE (slug_en),
					FOREIGN KEY (admin_id) REFERENCES admin(id),
					FOREIGN KEY (series_id) REFERENCES blog_series(id))
					COLLATE utf8_general_ci,
					ENGINE innoDB");
			
			//Table newsletter
			$this->db->query("CREATE TABLE IF NOT EXISTS newsletter(
					id int(9) NOT NULL AUTO_INCREMENT,
					admin_id int(9) NOT NULL,
					post_date datetime,
					PRIMARY KEY (id),
					FOREIGN KEY (admin_id) REFERENCES admin(id))
					COLLATE utf8_general_ci,
					ENGINE innoDB");
			
			//Table comment_blog
			$this->db->query("CREATE TABLE IF NOT EXISTS comment_blog(
					id int(9) NOT NULL AUTO_INCREMENT,
					blog_id int(9) NOT NULL,
					customer_id int(9) NOT NULL,
					post_date datetime,
					value int(11) NOT NULL DEFAULT '0',
					PRIMARY KEY (id),
					FOREIGN KEY (blog_id) REFERENCES blog(id),
					FOREIGN KEY (customer_id) REFERENCES customer(id))
					COLLATE utf8_general_ci,
					ENGINE innoDB");
			
			//Table newsletter_subscriber
			$this->db->query("CREATE TABLE IF NOT EXISTS newsletter_subscriber(
					id int(9) NOT NULL AUTO_INCREMENT,
					email varchar(100) NOT NULL,
					subscribe_date datetime NOT NULL,
					PRIMARY KEY (id),
					INDEX email_id USING BTREE (email))
					COLLATE utf8_general_ci,
					ENGINE innoDB");
			
			//Table language
			$this->db->query("CREATE TABLE IF NOT EXISTS language(
					id int(9) NOT NULL AUTO_INCREMENT,
					language_name varchar(2) NOT NULL,
					PRIMARY KEY (id))
					COLLATE utf8_general_ci,
					ENGINE innoDB");
			
			//Table tag
			$this->db->query("CREATE TABLE IF NOT EXISTS tag(
					id int(9) NOT NULL AUTO_INCREMENT,
					tag_name varchar(30) NOT NULL,
					tag_slug varchar(30) NOT NULL,
					language_id int(9) NOT NULL,
					PRIMARY KEY (id),
					INDEX tag_slug_id USING BTREE (tag_slug, language_id),
					FOREIGN KEY (language_id) REFERENCES language(id))
					COLLATE utf8_general_ci,
					ENGINE innoDB");
			
			//Table blog_in_tag
			$this->db->query("CREATE TABLE IF NOT EXISTS blog_in_tag(
					id int(9) NOT NULL AUTO_INCREMENT,
					blog_id int(9) NOT NULL,
					tag_id int(9) NOT NULL,
					PRIMARY KEY (id),
					FOREIGN KEY (blog_id) REFERENCES blog(id),
					FOREIGN KEY (tag_id) REFERENCES tag(id))
					COLLATE utf8_general_ci,
					ENGINE innoDB");
			
			//Table poll
			$this->db->query("CREATE TABLE IF NOT EXISTS poll(
					id int(9) NOT NULL AUTO_INCREMENT,
					admin_id int(9) NOT NULL,
					question varchar(40) NOT NULL,
					question_en varchar(40) NOT NULL,
					poll_post_date datetime NOT NULL,
					PRIMARY KEY (id),
					FOREIGN KEY (admin_id) REFERENCES admin(id))
					COLLATE utf8_general_ci,
					ENGINE innoDB");
			
			//Table message
			$this->db->query("CREATE TABLE IF NOT EXISTS message(
					id int(9) NOT NULL AUTO_INCREMENT,
					admin_id int(9) NOT NULL,
					message_name varchar(40),
					message_name_en varchar(40),
					poll_id int(9),
					post_date datetime NOT NULL,
					PRIMARY KEY (id),
					FOREIGN KEY (admin_id) REFERENCES admin(id),
					FOREIGN KEY (poll_id) REFERENCES poll(id))
					COLLATE utf8_general_ci,
					ENGINE innoDB");
			
			//Table poll_answer
			$this->db->query("CREATE TABLE IF NOT EXISTS poll_answer(
					id int(9) NOT NULL AUTO_INCREMENT,
					poll_id int(9) NOT NULL,
					answer varchar(30) NOT NULL,
					answer_en varchar(30) NOT NULL,
					PRIMARY KEY (id),
					FOREIGN KEY (poll_id) REFERENCES poll(id))
					COLLATE utf8_general_ci,
					ENGINE innoDB");
			
			//Table poll_vote
			$this->db->query("CREATE TABLE IF NOT EXISTS poll_vote(
					id int(9) NOT NULL AUTO_INCREMENT,
					customer_id int(9) NOT NULL,
					poll_answer_id int(9) NOT NULL,
					vote_date datetime NOT NULL,
					PRIMARY KEY (id),
					FOREIGN KEY (customer_id) REFERENCES customer(id),
					FOREIGN KEY (poll_answer_id) REFERENCES poll_answer(id) ON DELETE CASCADE)
					COLLATE utf8_general_ci,
					ENGINE innoDB");
			
			//Alter Address [add foreign key]
			$this->db->query("ALTER TABLE address
					ADD FOREIGN KEY (creator_id)
					REFERENCES customer(id)");
		}
		else{
			redirect("admin/manager/login");
		}
	}
	
	/*
	 * naplnanie statickych tabuliek
	*/
	public function DB_init_fill(){
		if (is_admin_login($this)){
			//change_label
			$this->db->empty_table('change_label');
			$data = array(
					'id' => '1',
					'change_name' => 'set sellable to false',
			);
			$this->db->insert('change_label', $data);
			$data = array(
					'id' => '2',
					'change_name' => 'set sellable to true',
			);
			$this->db->insert('change_label', $data);
			$data = array(
					'id' => '3',
					'change_name' => 'set new price',
			);
			$this->db->insert('change_label', $data);
			$data = array(
					'id' => '4',
					'change_name' => 'set discount',
			);
			$this->db->insert('change_label', $data);
			$data = array(
					'id' => '5',
					'change_name' => 'unset discount',
			);
			$this->db->insert('change_label', $data);
			$data = array(
					'id' => '6',
					'change_name' => 'major change',
			);
			$this->db->insert('change_label', $data);
			$data = array(
					'id' => '7',
					'change_name' => 'create',
			);
			$this->db->insert('change_label', $data);
			$data = array(
					'id' => '8',
					'change_name' => 'set new store amount',
			);
			$this->db->insert('change_label', $data);
			
			//admin
			$this->db->empty_table('admin');
			$salt = random_string('alnum', 16);
			$data = array(
					'id' => '1',
					'admin_nick' => 'admin',
					'admin_name' => 'Peter',
					'admin_surname' => 'Gasparik',
					'salt' => $salt,
					'password' => $this->bcrypt->hash_password("password".$salt),
			);
			$this->db->insert('admin', $data);
			
			//language
			$this->db->empty_table('language');
			$data = array(
					'id' => '1',
					'language_name' => 'sk',
			);
			$this->db->insert('language', $data);
			$data = array(
					'id' => '2',
					'language_name' => 'en',
			);
			$this->db->insert('language', $data);
		}
		else{
			redirect("admin/manager/login");
		}
	}
}