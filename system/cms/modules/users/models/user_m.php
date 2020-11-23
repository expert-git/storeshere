<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * The User model.
 *
 * @author PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Users\Models
 */
class User_m extends MY_Model
{
	public function __construct()
	{
		parent::__construct();

		$this->profile_table = $this->db->dbprefix('profiles');
	}

	// --------------------------------------------------------------------------

	/**
	 * Get a specified (single) user
	 *
	 * @param array $params
	 *
	 * @return object
	 */
	public function get($params)
	{
		if (isset($params['id']))
		{
			$this->db->where('users.id', $params['id']);
		}

		if (isset($params['email']))
		{
			$this->db->where('LOWER('.$this->db->dbprefix('users.email').')', strtolower($params['email']));
		}

		if (isset($params['role']))
		{
			$this->db->where('users.group_id', $params['role']);
		}

		$this->db
			->select($this->profile_table.'.*, users.*')
			->limit(1)
			->join('profiles', 'profiles.user_id = users.id', 'left');

		return $this->db->get('users')->row();
	}

	// --------------------------------------------------------------------------

	/**
	 * Get recent users
	 *
	 * @param     int  $limit defaults to 10
	 *
	 * @return     object
	 */
	public function get_recent($limit = 10)
	{
		$this->db->order_by('users.created_on', 'desc');
		$this->db->limit($limit);
		return $this->get_all();
	}

	// --------------------------------------------------------------------------

	/**
	 * Get all user objects
	 *
	 * @return object
	 */
	public function get_all()
	{
		$this->db
			->select($this->profile_table.'.*, groups.description as group_name, users.*')
			->join('groups', 'groups.id = users.group_id')
			->join('profiles', 'profiles.user_id = users.id', 'left')
			->order_by('users.last_login',  'desc');


		return parent::get_all();
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
	 * Update the last login time
	 *
	 * @param int $id
	 */
	public function update_last_login($id)
	{
		$this->db->update('users', array('last_login' => now()), array('id' => $id));
	}

	// --------------------------------------------------------------------------

	/**
	 * Activate a newly created user
	 *
	 * @param int $id
	 *
	 * @return bool
	 */
	public function activate($id)
	{
		return parent::update($id, array('active' => 1, 'activation_code' => ''));
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
		$this->db->from($this->_table)
			->join('profiles', 'users.id = profiles.user_id', 'left');

		if ( ! empty($params['active']))
		{
			$params['active'] = $params['active'] === 2 ? 0 : $params['active'];
			$this->db->where('users.active', $params['active']);
		}

		if ( ! empty($params['group_id']))
		{
			$this->db->where('group_id', $params['group_id']);
		}

		if ( ! empty($params['name']))
		{
			$this->db
				->like('users.username', trim($params['name']))
				->or_like('users.email', trim($params['name']))
				->or_like('profiles.first_name', trim($params['name']))
				->or_like('profiles.last_name', trim($params['name']));
		}

		return $this->db->count_all_results();
	}

	// --------------------------------------------------------------------------
	
	public function get_ajax_data($orderby, $sortorder, $row, $rowperpage, $search_column, $searchValue=''){
	    $sql = "
	        SELECT
                du.id,
                dp.first_name,
                dp.last_name,
                du.email user_email,
                dp.phone phone,
                g.description group_name,
                du.active,
                sfa.send_funds_amount,
                spa.send_photos_amount,
                FROM_UNIXTIME(du.created_on, '%m-%d-%Y') created_on,
                FROM_UNIXTIME(du.last_login, '%m-%d-%Y') last_login,
                dia.is_verified 
                FROM
                    default_users du 
                JOIN
                    default_groups g 
                        ON g.id = du.group_id 
                LEFT JOIN
                    default_profiles dp 
                        ON dp.user_id = du.id 
                LEFT JOIN
                    default_inmates di 
                        ON di.user_id = du.id 
                LEFT JOIN
                    (
                        SELECT
                            dsf.paid_by,
                            COUNT(*) send_funds_amount 
                        FROM
                            default_send_funds dsf 
                        GROUP BY
                            dsf.paid_by 
                        ORDER BY
                            NULL
                    ) AS sfa 
                        ON sfa.paid_by = du.id 
                LEFT JOIN
                    (
                        SELECT
                            dsp.sent_by,
                            COUNT(*) send_photos_amount 
                        FROM
                            default_send_photos dsp 
                        GROUP BY
                            dsp.sent_by 
                        ORDER BY
                            NULL
                    ) AS spa 
                        ON spa.sent_by = du.id 
                LEFT JOIN
                    (
                        SELECT
                            di.user_id,
                            di.is_verified 
                        FROM
                            default_inmates di 
                        GROUP BY
                            di.is_verified,
                            di.user_id 
                        ORDER BY
                            NULL
                    ) AS dia 
                        ON dia.user_id = du.id 
                WHERE
                    g.name NOT IN (
                        ''
                    ) and ";
                
        if($search_column == 'name'){
            $sql .= "dp.first_name LIKE '%".$searchValue."%' or dp.last_name LIKE '%".$searchValue."%' GROUP BY du.id ORDER BY ".$orderby." ".$sortorder." limit ".$row.",".$rowperpage;
        }
        elseif($search_column == 'email_phone'){
            $sql .= "du.email LIKE '%".$searchValue."%' or dp.phone LIKE '%".$searchValue."%' GROUP BY du.id ORDER BY ".$orderby." ".$sortorder." limit ".$row.",".$rowperpage;
        }
        elseif($search_column == 'active'){
            if($searchValue == 'yes' || $searchValue == 'Yes' || $searchValue == ''){
                $sql .= "du.active = 1 GROUP BY du.id ORDER BY ".$orderby." ".$sortorder." limit ".$row.",".$rowperpage;
            }
            else{
                $sql .= "du.active = 0 GROUP BY du.id ORDER BY ".$orderby." ".$sortorder." limit ".$row.",".$rowperpage;
            }
        }
        elseif($search_column == 'created_on'){
            // if(DateTime::createFromFormat("m-d-Y", $searchValue)){
            //     $date = date_create_from_format("m-d-Y", $searchValue)->format("Y-m-d");
            //     $sql .= "FROM_UNIXTIME(du.created_on), '".$date."')=0 GROUP BY du.id ORDER BY ".$orderby." ".$sortorder." limit ".$row.",".$rowperpage;
            // }
            // else{
            //     $sql .= "dp.first_name LIKE '%%' GROUP BY du.id ORDER BY ".$orderby." ".$sortorder." limit ".$row.",".$rowperpage;
            // }
            $sql .= "FROM_UNIXTIME(du.created_on, '%m-%d-%Y') LIKE '%".$searchValue."%' GROUP BY du.id ORDER BY ".$orderby." ".$sortorder." limit ".$row.",".$rowperpage;
        }
        elseif($search_column == 'last_login'){
            $sql .= "FROM_UNIXTIME(du.last_login, '%m-%d-%Y') LIKE '%".$searchValue."%' GROUP BY du.id ORDER BY ".$orderby." ".$sortorder." limit ".$row.",".$rowperpage;
        }
        
	    return $this->db->query($sql)->result();
	}

    public function all_get_ajax_data($orderby, $sortorder, $search_column, $searchValue=''){
	    $sql = "
	        SELECT
                du.id
                FROM
                    default_users du 
                JOIN
                    default_groups g 
                        ON g.id = du.group_id 
                LEFT JOIN
                    default_profiles dp 
                        ON dp.user_id = du.id 
                LEFT JOIN
                    default_inmates di 
                        ON di.user_id = du.id 
                LEFT JOIN
                    (
                        SELECT
                            dsf.paid_by,
                            COUNT(*) send_funds_amount 
                        FROM
                            default_send_funds dsf 
                        GROUP BY
                            dsf.paid_by 
                        ORDER BY
                            NULL
                    ) AS sfa 
                        ON sfa.paid_by = du.id 
                LEFT JOIN
                    (
                        SELECT
                            dsp.sent_by,
                            COUNT(*) send_photos_amount 
                        FROM
                            default_send_photos dsp 
                        GROUP BY
                            dsp.sent_by 
                        ORDER BY
                            NULL
                    ) AS spa 
                        ON spa.sent_by = du.id 
                LEFT JOIN
                    (
                        SELECT
                            di.user_id,
                            di.is_verified 
                        FROM
                            default_inmates di 
                        GROUP BY
                            di.is_verified,
                            di.user_id 
                        ORDER BY
                            NULL
                    ) AS dia 
                        ON dia.user_id = du.id 
                WHERE
                    g.name NOT IN (
                        ''
                    ) and ";
                    
        if($search_column == 'name'){
            $sql .= "dp.first_name LIKE '%".$searchValue."%' or dp.last_name LIKE '%".$searchValue."%' GROUP BY du.id ORDER BY ".$orderby." ".$sortorder;
        }
        elseif($search_column == 'email_phone'){
            $sql .= "du.email LIKE '%".$searchValue."%' or dp.phone LIKE '%".$searchValue."%' GROUP BY du.id ORDER BY ".$orderby." ".$sortorder;
        }
        elseif($search_column == 'active'){
            if($searchValue == 'yes' || $searchValue == 'Yes' || $searchValue == ''){
                $sql .= "du.active = 1 GROUP BY du.id ORDER BY ".$orderby." ".$sortorder;
            }
            else{
                $sql .= "du.active = 0 GROUP BY du.id ORDER BY ".$orderby." ".$sortorder;
            }
        }
        elseif($search_column == 'created_on'){
            $sql .= "FROM_UNIXTIME(du.created_on, '%m-%d-%Y') LIKE '%".$searchValue."%' GROUP BY du.id ORDER BY ".$orderby." ".$sortorder;
            // if(DateTime::createFromFormat("m-d-Y", $searchValue)){
            //     $date = date_create_from_format("m-d-Y", $searchValue)->format("Y-m-d");
            //     $sql .= "datediff(FROM_UNIXTIME(created_on), '".$date."')=0 GROUP BY du.id ORDER BY ".$orderby." ".$sortorder;
            // }
            // else{
            //     $sql .= "dp.first_name LIKE '%%' GROUP BY du.id ORDER BY ".$orderby." ".$sortorder;
            // }
        }
        elseif($search_column == 'last_login'){
            // if(DateTime::createFromFormat("m-d-Y", $searchValue)){
            //     $date = date_create_from_format("m-d-Y", $searchValue)->format("Y-m-d");
            //     $sql .= "datediff(FROM_UNIXTIME(du.last_login), '".$date."')=0 GROUP BY du.id ORDER BY ".$orderby." ".$sortorder;
            // }
            // else{
            //     $sql .= "dp.first_name LIKE '%%' GROUP BY du.id ORDER BY ".$orderby." ".$sortorder;
            // }
            $sql .= "FROM_UNIXTIME(du.last_login, '%m-%d-%Y') LIKE '%".$searchValue."%' GROUP BY du.id ORDER BY ".$orderby." ".$sortorder;
        }
        
	    return $this->db->query($sql)->result();
	}
	/**
	 * Get by many
	 *
	 * @param array $params
	 *
	 * @return object
	 */
	public function get_many_by($params = array())
	{
		if ( ! empty($params['active']))
		{
			$params['active'] = $params['active'] === 2 ? 0 : $params['active'];
			$this->db->where('active', $params['active']);
		}

		if ( ! empty($params['group_id']))
		{
			$this->db->where('group_id', $params['group_id']);
		}

		if ( ! empty($params['name']))
		{
			$this->db
				->or_like('users.username', trim($params['name']))
				->or_like('users.email', trim($params['name']));
		}

		$me = $this->get_all();
		for($i = 0; $i < count($me); $i++) {
		    $me[$i]->send_photos_amount = $this->get_send_photos_amount((int)$me[$i]->id);
		    $me[$i]->send_funds_amount = $this->get_send_funds_amount((int)$me[$i]->id);
		}
		return $me;
	}
	
	public function get_send_photos_amount($id){
	    return $this->db->select('*')
			->from('default_send_photos')
			->where('sent_by', $id)
			->count_all_results();
	}
	
	public function get_send_funds_amount($id){
	    return $this->db->select('*')
			->from('default_send_funds')
			->where('paid_by', $id)
			->count_all_results();
	}

	// --------------------------------------------------------------------------
	
    public function getUserIdByCode($code){
    	$query = $this->db->select('id')
		    	          ->where('forgotten_password_code',$code)
		    	          ->get('default_users');
        $result = $query->result_array();
    	if(!empty($result)){
            return $result[0]['id'];
    	}else{
    		return 0;
    	}
    }

    public function getAllFacilities(){
    	$query = $this->db->select('id,name')
    						->from('default_facility')
    						->where('active',1)
    						->get();
    	$result = $query->result_array();
    	return $result;
    }

    public function getUserName($name){
    	$query = $this->db->select('username')
    						->from('default_users')
    						->where('username',$name)
    						->get();
		$result = $query->result_object();
		return $result;
    }

    public function getEmail($email){
    	$query = $this->db->select('user_email')
    						->from('default_profiles')
    						->where('user_email',$email)
    						->get();
		$result = $query->result_object();
		return $result;
    }

}