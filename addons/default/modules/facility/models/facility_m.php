<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * The User model.
 *
 * @author PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Users\Models
 */
class Facility_m extends MY_Model
{
	public function __construct()
	{
		parent::__construct();

		$this->profile_table = $this->db->dbprefix('profiles');
	}

	// --------------------------------------------------------------------------

	/**
	 * Create a new user
	 *
	 * @param array $input
	 *
	 * @return int|true
	 */
	public function add($input = array())
	{
		$this->load->helper('date');

		return parent::insert(array(
			'email' => $input->email,
			'password' => $input->password,
			'salt' => $input->salt,
			'role' => empty($input->role) ? 'user' : $input->role,
			'active' => 0,
			'lang' => $this->config->item('default_language'),
			'activation_code' => $input->activation_code,
			'created_on' => now(),
			'last_login' => now(),
			'ip' => $this->input->ip_address()
		));
	}

    // --------------------------------------------------------------------------

	/**
	 * Count by
	 *
	 * @param array $params
	 *
	 * @return int
	 */
	public function count_by($params = array())
	{
		if(!empty($params['active'])){
			if($params['active'] == 1)
			$where = 'WHERE active ='.$params['active'];

		    if($params['active'] == 2)
			$where = 'WHERE active = 0';

		    if($params['active'] == 0)
			$where = '';
		}else{
			$where = '';
		}
		$sql = "SELECT count(*) as numrows FROM default_facility ".$where;
		$query = $this->db->query($sql);
		$result = $query->result_array();
        return $result[0]['numrows'];
	}

	// --------------------------------------------------------------------------

	/**
	 * Get by many
	 *
	 * @param array $params
	 *
	 * @return object
	 */
	public function getFacilities($params = array()){
		$where = 'WHERE active != 2';
		if($params['active'] >= 0){
			if($params['active'] == 1){
				$where .= ' AND active = 1';
				if(!empty($params['name'])){
               	   $where .= ' AND name LIKE "%'.$params['name'].'%" OR county LIKE "%'.$params['name'].'%"';
                }
            }

		    if($params['active'] == 2){
		    	$where .= ' AND active = 0';
		    	if(!empty($params['name'])){
               	   $where .= ' AND name LIKE "%'.$params['name'].'%" OR county LIKE "%'.$params['name'].'%"';
                }
		    }

		    if($params['active'] == 0){
                if(!empty($params['name'])){
           		   $where .= ' AND name LIKE "%'.$params['name'].'%" OR county LIKE "%'.$params['name'].'%"';
               	}
		    }
		}
		$sql = "SELECT * FROM default_facility ".$where;
		$query = $this->db->query($sql);
		$result = $query->result_array();
        return $result;
	}

    /**
	 * Get by many
	 *
	 * @param array $params
	 *
	 * @return object
	 */
	public function getFacilityDetails($id){
		$sql = "SELECT * FROM default_facility WHERE id=".$id;
		$query = $this->db->query($sql);
		$result = $query->result_array();
		if(!empty($result)){
		   return $result[0];	
		}else{
		   return $result;
		}
        
	}

	public function addFacility($data){
		$query = $this->db->insert('default_facility',$data);
		if($query){
			return true;
		}else{
			return false;
		}
	}

	public function editFacility($data,$facility_id){
		$query = $this->db->where('id',$facility_id)
						  ->update('default_facility',$data);
		if($query){
			return true;
		}else{
			return false;
		}
	}

	public function updateFacilityTable($data,$facility_id){
		$update = $this->db->where('id',$facility_id)
						   ->update('default_facility',$data);
		if($update){
			return true;
		}else{
			return false;
		}		   
	}
}