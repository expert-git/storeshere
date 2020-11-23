<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * The User model.
 *
 * @author PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Users\Models
 */
class Order_m extends MY_Model
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

	public function getPhotosDetails($params = array()){
		$query = "SELECT CONCAT(profile.first_name,' ',profile.last_name) as user_name, user.email,profile.mobile,profile.user_email, inmate.inmates_name, facility.name as facility_name,photo.id,photo.destruction_clause,photo.sent_by,photo.no_of_photos,photo.sent_date,photo.status,photo.invoice,photo.document,photo.text_message,photo.payment_type, payment.amount
FROM default_send_photos as photo
LEFT JOIN default_users as user on photo.sent_by = user.id
LEFT JOIN default_profiles as profile on photo.sent_by = profile.user_id
LEFT JOIN default_inmates as inmate on photo.sent_to = inmate.inmates_id
LEFT JOIN default_facility as facility on inmate.facility_id = facility.id
LEFT JOIN default_payments as payment on photo.payment_id = payment.id";
 // echo $query;die;
		if(isset($params['active']) && !empty($params['active'])){	
			$query .= " WHERE photo.status = '".$params['active']."' ";
		}

		if(isset($params['name']) && !empty($params['name'])){
			$key = $params['name'];
			if(isset($params['active']) && !empty($params['active'])){
				$query .=" and ";
			}else{
				$query .=" WHERE ";
			}
			$query .= " (CONCAT(profile.first_name,' ',profile.last_name) LIKE '%".$key."%' OR user.email like '%".$key."%' OR inmate.inmates_name LIKE '%".$key."%' OR facility.name LIKE '%".$key."%') ";
		}

		if(isset($params['facility_id']) && !empty($params['facility_id'])){
			if( (isset($params['active']) && !empty($params['active'])) || (isset($params['name']) && !empty($params['name'])) ){
				$query .=" AND facility.id IN ( ".$params['facility_id'].")";
			}else{
				$query .=" WHERE facility.id IN( ".$params['facility_id'].")";
			}			
		}
        // $query.="ORDER By photo.id, 'DESC' ";
        		$query .= " ORDER BY photo.id DESC";

		$result = $this->db->query($query);
		$result = $result->result_array();
		return $result;
	}

	public function getImages($id){
		$this->db->select('photo_name,sent_by,msg_photo');
		$this->db->where('id',$id);
		$query = $this->db->get('default_send_photos');
		return $query->result_array();
	}

	public function getFundDetails($id){
						$query = "SELECT CONCAT(profile.first_name,' ',profile.last_name) as user_name,profile.mobile,profile.user_email,profile.user_id,profile.country, user.email, inmate.inmates_name,inmate.inmates_booking_no, facility.name as facility_name,facility.address,facility.city,facility.county,facility.state,facility.country as fac_country,fund.id,fund.paid_by,fund.paid_to,fund.sent_date,fund.status,fund.invoice,fund.fee,fund.unit,fund.original_amount,fund.processing_fees, payment.amount
FROM default_send_funds as fund
LEFT JOIN default_users as user on fund.paid_by = user.id
LEFT JOIN default_profiles as profile on fund.paid_by = profile.user_id
LEFT JOIN default_inmates as inmate on fund.paid_to = inmate.inmates_id
LEFT JOIN default_facility as facility on inmate.facility_id = facility.id
LEFT JOIN default_payments as payment on fund.payment_id = payment.id 
WHERE fund.id = ".$id;
	$result = $this->db->query($query);
	return $result->result_array();
	}

	public function getPhotoDetails($id){
		$query = "SELECT CONCAT(profile.first_name,' ',profile.last_name) as user_name, user.email,profile.mobile,profile.country, inmate.inmates_name,inmate.inmates_booking_no, facility.name as facility_name,facility.address,facility.city,facility.county,facility.state,facility.country as fac_country,photo.id,photo.sent_by,photo.no_of_photos,photo.sent_date,photo.status,photo.invoice,photo.payment_type, payment.amount
FROM default_send_photos as photo
LEFT JOIN default_users as user on photo.sent_by = user.id
LEFT JOIN default_profiles as profile on photo.sent_by = profile.user_id
LEFT JOIN default_inmates as inmate on photo.sent_to = inmate.inmates_id
LEFT JOIN default_facility as facility on inmate.facility_id = facility.id
LEFT JOIN default_payments as payment on photo.payment_id = payment.id
WHERE photo.id = ".$id;
		$result = $this->db->query($query);		
		return $result->result_array();
	}

	public function updatePhotoStatus($id,$data){
		$this->db->where('id',$id);
		$res = $this->db->update('default_send_photos',$data);
		return $res;
	}

	public function updateFundStatus($id,$data){
		$this->db->where('id',$id);
		$res = $this->db->update('default_send_funds',$data);
		return $res;
	}

	public function getFundsData($params = array()){
 		$query = "SELECT CONCAT(profile.first_name,' ',profile.last_name) as user_name, user.email, inmate.inmates_name, facility.name as facility_name,fund.id,fund.paid_by,fund.paid_to,fund.sent_date,fund.status,fund.invoice,fund.fee,fund.unit,fund.original_amount,fund.processing_fees,fund.payment_type,fund.delivered_date, payment.amount
FROM default_send_funds as fund
LEFT JOIN default_users as user on fund.paid_by = user.id
LEFT JOIN default_profiles as profile on fund.paid_by = profile.user_id
LEFT JOIN default_inmates as inmate on fund.paid_to = inmate.inmates_id
LEFT JOIN default_facility as facility on inmate.facility_id = facility.id
LEFT JOIN default_payments as payment on fund.payment_id = payment.id ";

	 		if(isset($params['active']) && !empty($params['active'])){	
			$query .= " WHERE fund.status = '".$params['active']."' ";
		}

		if(isset($params['name']) && !empty($params['name'])){
			$key = $params['name'];
			if(isset($params['active']) && !empty($params['active'])){
				$query .=" and ";
			}else{
				$query .=" WHERE ";
			}
			$query .= " (CONCAT(profile.first_name,' ',profile.last_name) LIKE '%".$key."%' OR user.email like '%".$key."%' OR inmate.inmates_name LIKE '%".$key."%' OR facility.name LIKE '%".$key."%') ";
		}

		if(isset($params['facility_id']) && !empty($params['facility_id'])){
			if( (isset($params['active']) && !empty($params['active'])) || (isset($params['name']) && !empty($params['name'])) ){
				$query .=" AND facility.id IN( ".$params['facility_id'].")";
			}else{
				$query .=" WHERE facility.id IN( ".$params['facility_id'].")";
			}			
		}

		$query .= " ORDER BY fund.id DESC";		
		$result = $this->db->query($query);
		$result = $result->result_array();
		return $result;
	}

	public function getDetails($id){
		$query = "SELECT CONCAT(profile.first_name,' ',profile.last_name) as user_name, user.email, inmate.inmates_name,inmate.inmates_booking_no, facility.name as facility_name,facility.photo_lab_email,facility.address,facility.city,facility.county,facility.state,facility.country,facility.zip_code,photo.id,photo.sent_by,photo.no_of_photos,photo.sent_date,photo.status, payment.amount,photo.receipient_name,photo.address AS ret_add,photo.city AS ret_city,photo.state AS ret_state,photo.zipcode AS ret_zip,photo.country AS ret_country
FROM default_send_photos as photo
LEFT JOIN default_users as user on photo.sent_by = user.id
LEFT JOIN default_profiles as profile on photo.sent_by = profile.user_id
LEFT JOIN default_inmates as inmate on photo.sent_to = inmate.inmates_id
LEFT JOIN default_facility as facility on inmate.facility_id = facility.id
LEFT JOIN default_payments as payment on photo.payment_id = payment.id
WHERE photo.id = ".$id;
		$result = $this->db->query($query);
		$result = $result->result_array();
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