<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Facility extends Module {

public $version = '2.0';

public function info()
{
	return array(
		'name' => array(
			'en' => 'Facility'
		),
		'description' => array(
			'en' => 'This is a Facility module.'
		),
		'frontend' => TRUE,
		'backend'  => TRUE,
		'menu'	   => FALSE, // You can also place modules in their top level menu. For example try: 'menu' => 'facility',
		'sections' => array(
			'items' => array(
				'name' 	=> 'Facility', // These are translated from your language file
				'uri' 	=> 'admin/facility',
					'shortcuts' => array(
						'create' => array(
							'name' 	=> 'facility.create',
							'uri' 	=> 'admin/facility/create',
							'class' => 'add'
							)
						)
					)
			)
	);
}

public function admin_menu(&$menu)
{
	$menu['Facility'] = 'admin/facility';
}

public function install()
{
	$this->dbforge->drop_table('facility');
	$this->db->delete('settings', array('module' => 'facility'));

	$facility = array(
        'id' => array(
			'type' => 'INT',
			'constraint' => '11',
			'auto_increment' => TRUE
		),
		'name' => array(
			'type' => 'VARCHAR',
			'constraint' => '100'
		),
		'address' => array(
			'type' => 'VARCHAR',
			'constraint' => '100'
		),
		'city' => array(
					'type' => 'VARCHAR',
					'constraint' => '100'
				),
		'county' => array(
					'type' => 'VARCHAR',
					'constraint' => '100'
				),
		'state' => array(
					'type' => 'VARCHAR',
					'constraint' => '100'
				),
		'country' => array(
					'type' => 'VARCHAR',
					'constraint' => '100'
				),
		'zip_code' => array(
					'type' => 'INT',
				'constraint' => '11'
		),
		'money_option' => array(
					'type' => 'TINYINT',
					'constraint' => '2',
		),
		'photo_option' => array(
					'type' => 'TINYINT',
					'constraint' => '2',
		),
		'active' => array(
					'type' => 'TINYINT',
					'constraint' => '2',
					'default'=>'1'
		)		
		
	);

	$facility_setting = array(
		'slug' => 'facility_setting',
		'title' => 'facility Setting',
		'description' => 'A Yes or No option for the facility module',
		'`default`' => '1',
		'`value`' => '1',
		'type' => 'select',
		'`options`' => '1=Yes|0=No',
		'is_required' => 1,
		'is_gui' => 1,
		'module' => 'facility'
	);

	$this->dbforge->add_field($facility);
	$this->dbforge->add_field("created_on TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP");
	$this->dbforge->add_field("modified_on TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP");

	$this->dbforge->add_key('id', TRUE);

	// Let's try running our DB Forge Table and inserting some settings
	if ( ! $this->dbforge->create_table('facility') OR ! $this->db->insert('settings', $facility_setting))
	{
		return FALSE;
	}
	
	// No upload path for our module? If we can't make it then fail
	if ( ! is_dir($this->upload_path.'facility') AND ! @mkdir($this->upload_path.'facility',0777,TRUE))
	{
		return FALSE;
	}
	
	// We made it!
	return TRUE;
}

public function uninstall()
{
	$this->dbforge->drop_table('facility');
	
	$this->db->delete('settings', array('module' => 'facility'));
	
	// Put a check in to see if something failed, otherwise it worked
	return TRUE;
}


public function upgrade($old_version)
{
	// Your Upgrade Logic
	return TRUE;
}

public function help()
{
	// Return a string containing help info
	return "Here you can enter HTML with paragrpah tags or whatever you like";
	
	// You could include a file and return it here.
	return $this->load->view('help', NULL, TRUE); // loads modules/facility/views/help.php
}
}
/* End of file details.php */