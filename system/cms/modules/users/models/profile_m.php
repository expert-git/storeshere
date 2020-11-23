<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Users\Models
 */
class Profile_m extends MY_Model
{
	/**
	 * Get a user profile
	 *
	 * 
	 * @param array $params Parameters used to retrieve the profile
	 * @return object
	 */
	public function get_profile($params = array())
	{
		$query = $this->db->get_where('profiles', $params);

		return $query->row();
	}
	
	public function getSendPhotos($id){
	    $sql = "SELECT dsp.id, concat(dp.first_name, dp.last_name) username, di.inmates_name inmates_name,  df.name facility_name, dsp.no_of_photos photos_sent, dpay.amount, dsp.destruction_clause if_not_delivered, dsp.sent_date,  dsp.`status` 
                FROM default_send_photos dsp LEFT JOIN default_profiles dp ON dsp.sent_by=dp.id
                LEFT JOIN default_inmates di ON di.inmates_id=dsp.sent_to
                LEFT JOIN default_facility df ON df.id = di.facility_id
                LEFT JOIN default_payments dpay ON dsp.payment_id=dpay.id
                WHERE dp.id=".$id;
	    $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
	}
	
	public function getSendFunds($id){
	    $sql = "SELECT dsf.id, concat(dp.first_name, dp.last_name) username, dpay.amount total_amount,di.inmates_name inmates_name, df.name facility_name, dsf.processing_fees,dsf.sent_date, dsf.original_amount amount, dsf.`status` 
            FROM default_send_funds dsf LEFT JOIN default_profiles dp ON dsf.paid_by=dp.id
            LEFT JOIN default_inmates di ON di.inmates_id=dsf.paid_to
            LEFT JOIN default_facility df ON df.id = di.facility_id
            LEFT JOIN default_payments dpay ON dsf.payment_id=dpay.id
            WHERE dp.id=".$id;
	    $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public function getProfileDetails($id){
    	 $sql = "SELECT first_name,middle_name,last_name,user_email,street_address,postcode,city,state,country,mobile,notified_by
    	        FROM default_profiles WHERE user_id=".$id;
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }
	
	/**
	 * Update a user's profile
	 *
	 * 
	 * @param array $input A mirror of $_POST
	 * @param int $id The ID of the profile to update
	 * @return bool
	 */
	public function update_profile($input, $id)
	{
		$set = array(
			'gender'		=> 	$input['gender'],
			'bio'			=> 	$input['bio'],
			'phone'			=>	$input['phone'],
			'mobile'		=>	$input['mobile'],
			'address_line1'	=>	$input['address_line1'],
			'address_line2'	=>	$input['address_line2'],
			'address_line3'	=>	$input['address_line3'],
			'postcode'		=>	$input['postcode'],
	 		'website'		=>	$input['website'],
			'updated_on'	=>	now()
		);

		if (isset($input['dob_day']))
		{
			$set['dob'] = mktime(0, 0, 0, $input['dob_month'], $input['dob_day'], $input['dob_year']);
		}

		// Does this user have a profile already?
		if ($this->db->get_where('profiles', array('user_id' => $id))->row())
		{
			$this->db->update('profiles', $set, array('user_id'=>$id));
		}	
		else
		{
			$set['user_id'] = $id;
			$this->db->insert('profiles', $set);
		}
		
		return true;
	}

    public function updateProfile($data,$where){
    	$query = $this->db->where($where)
    	                  ->update('default_profiles',$data);
        if($query){
        	return true;
        }else{
        	return false;
        }
    }

    public function updateInmate($data,$id){
    	$this->db->where('inmates_id',$id);
    	$res = $this->db->update('default_inmates',$data);
    	return $res;
    }

    public function updateForgetPassCode($code){
    	$data = array('forgotten_password_code'=>0);
    	$this->db->where('forgotten_password_code',$code)
    	         ->update('default_users',$data);
    	$affectedRows = $this->db->affected_rows();
    	return $affectedRows;
    }

	public function checkPassword($pass, $id){
		$this->db->select('*');
		$this->db->where('id',$id);
		$this->db->where('password',$pass);
		$query = $this->db->get('default_users');
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

	public function updatePassword($data,$id){
		$query = $this->db->where('id',$id)
		         		  ->update('default_users',$data);
        if($query){
        	return true;
        }else{
        	return false;
        }
	}

	public function getallFacilities($active = 0){
		$this->db->select('*');
		$this->db->from('default_facility');
		if($active == 1){
		   $this->db->where('active',1);	
		}
		$this->db->order_by('name', 'ASC');
		$query = $this->db->get();
		$result = $query->result_array();		
        return $result;
	}

	public function getMoneyFacility(){
		$query = $this->db->select('*')
		                  ->from('default_facility')
		                  ->where('money_option',1)
		                  ->where('active',1)
		                  ->order_by('name', 'ASC')
		                  ->get();
		                  // print_r($this->db->last_query());die;
		$result = $query->result_array();                  
        return $result;
	}

	public function getPhotoFacility(){
		$query = $this->db->select('*')
		                  ->from('default_facility')
		                  ->where('photo_option',1)
		                  ->where('active',1)
		                  ->order_by('name', 'ASC')
		                  ->get();
		                  // print_r($this->db->last_query());die;
		$result = $query->result_array();                  
        return $result;
	}

	public function getPhotoLibrary($id){
		$query = $this->db->select('*')
							->from('default_photo_library')
							->where('user_id',$id)
							->get();
		$result = $query->result_array();
		return $result;
	}

	public function addInmates($data){
		$sql = "INSERT INTO default_inmates (user_id, inmates_name, inmates_middle_name, inmates_last_name,inmates_booking_no,facility_id) SELECT 
		         '".$data['user_id']."','".$data['first_name']."','".$data['middle_name']."','".$data['last_name']."','".$data['bookingId']."','".$data['facility']."'
		         FROM DUAL WHERE NOT EXISTS (SELECT * FROM default_inmates WHERE user_id = '".$data['user_id']."'
		         AND inmates_booking_no = '".$data['bookingId']."') LIMIT 1";
		$query = $this->db->query($sql);
		$insertID = $this->db->insert_id();
		return $insertID;
	}

	public function getInmatesList($id){
		$query = $this->db->select('i.*, f.name as facility_name')
						  ->from('default_inmates as i')
						  ->join('default_facility as f','i.facility_id=f.id','left')
						  ->where('user_id',$id)
						  ->order_by('i.inmates_id','DESC')
						  ->get();
		$result = $query->result_array();
		return $result;
	}

	public function getFacilityInmates($id,$facility){
		$query = $this->db->select('*')
		                  ->from('default_inmates')
		                  ->where('user_id',$id)
		                  ->where('facility_id',$facility)
		                  ->get();
		$result = $query->result_array();                  
        return $result;
	}

	public function getCountry(){
		$query = $this->db->query("SELECT nicename FROM default_country ORDER BY FIELD(id,226,138,38) DESC");
		$result = $query->result_array();
		return $result;
	}

	public function getFacilityAmount($facility){
		$query = $this->db->select('amount,processing_fee,fee_unit')
							->from('default_facility')
							->where('id',$facility)
							->get();
		$result = $query->result_array();
		return $result;
	}

	public function getFacilityDetails($facility_id){
		$query = $this->db->select('*')
						->from('default_facility')
						->where('id',$facility_id)
						->get();
		$result = $query->result_array();
		return $result;
	}

	public function getUserDetails($id){
		$query = $this->db->select('user.email,user.username,profile.first_name,profile.last_name,profile.mobile,profile.country,profile.notified_by')							
							->from('default_users as user')
							->join('default_profiles as profile','user.id = profile.user_id','left')
							->where('user.id',$id)
							->get();
		$result = $query->result_array();
		return $result;
	}

	public function getInmateDetails($id){
		$query = $this->db->select('inmate.*,facility.id as facility_id,facility.name as facility_name, facility.address, facility.city,facility.county,facility.state,facility.country, facility.price_per_photo, facility.shipping_charge_per_photo')
							->from('default_inmates as inmate')
							->join('default_facility as facility','inmate.facility_id = facility.id')

							->where('inmate.inmates_id',$id)
							->get();
	
		$result = $query->result_array();
		return $result;
	}
	public function getInmatedd($id){
	    $query = $this->db->select('inmates_name, inmates_middle_name, inmates_last_name, inmates_booking_no')
							->from('default_inmates as inmate')
							->where('inmate.inmates_id',$id)
							->get();
	
		$result = $query->result_array();
		return $result;
							
	}
	public function getusermobile($id){
	    $query = $this->db->select('mobile')
							->from('default_profiles as profiles')
							->where('profiles.user_id',$id)
							->get();
	
		$result = $query->result_array();
		return $result;
							
	}
	

	public function getFranchiseDetails($id){
		$query = "SELECT user.email,profile.first_name,profile.last_name, profile.facility_id FROM default_users as user LEFT JOIN default_profiles as profile ON user.id = profile.user_id WHERE user.group_id = 3 AND profile.facility_id LIKE '%".'"'.$id.'"'."%'
				ORDER BY `profile`.`facility_id` ASC";									
		$result = $this->db->query($query);
		return $result->result_array();
	}

	public function savePayPalDetails($data){
		$this->db->insert('default_payments',$data);
		return $this->db->insert_id();	
	}

	public function getPayPalDetails($custom){
		$query = $this->db->select('*')
							->from('default_payments')
							->where('custom',$custom)
							->get();
	
		$result = $query->result_array();
		return $result;
	}

	public function saveTmpData($data){
		$this->db->insert('default_tmp_data',$data);
		return $this->db->insert_id();
	}
	
	public function savePhotoDetails($data){

		if($data->payment_id == 0)
		{
			$this->db->insert('default_send_photos',$data);
			return $this->db->insert_id();
		}	
		else
		{
			$query = $this->db->select('id')
							->from('default_send_photos')
							->where('payment_id',$data->payment_id)
							->get();
	
			$result = $query->row_array();

			if(isset($result['id'])){
				return $result['id'];
			}else{
				$this->db->insert('default_send_photos',$data);
				return $this->db->insert_id();
			}
		}

			
	}

	public function updatePhotoDetails($data,$id){
    	$this->db->where('custom',$id);
    	$res = $this->db->update('default_send_photos',$data);
    	return $res;
    }
	
	public function saveFundDetails($data){

		if($data->payment_id == 0)
		{
			$this->db->insert('default_send_funds',$data);
			// echo $this->db->last_query();
				return $this->db->insert_id();
		}
		else
		{
			$query = $this->db->select('id')
							->from('default_send_funds')
							->where('payment_id',$data->payment_id)
							->get();
	
			$result = $query->row_array();

			if(isset($result['id'])){
				return $result['id'];
			}else{
				$this->db->insert('default_send_funds',$data);
				return $this->db->insert_id();
			}	
		}
			
	}

// 	public function savePhotoDetails($data){

// 		$query = $this->db->select('id')
// 							->from('default_send_photos')
// 							->where('payment_id',$data->payment_id)
// 							->get();
	
// 		$result = $query->row_array();

// 		if(isset($result['id'])){
// 			return $result['id'];
// 		}else{
// 			$this->db->insert('default_send_photos',$data);
// 			return $this->db->insert_id();
// 		}	
// 	}
	
// 	public function saveFundDetails($data){

// 		$query = $this->db->select('id')
// 							->from('default_send_funds')
// 							->where('payment_id',$data->payment_id)
// 							->get();
	
// 		$result = $query->row_array();

// 		if(isset($result['id'])){
// 			return $result['id'];
// 		}else{
// 			$this->db->insert('default_send_funds',$data);
// 			return $this->db->insert_id();
// 		}	
// 	}

	public function savePhotoInLibrary($data){
		$this->db->insert('default_photo_library',$data);
		return $this->db->insert_id();			
	}

	public function getTmpData($id){
		$this->db->select('tmp_data');
		$this->db->where('id',$id);
		$query = $this->db->get('default_tmp_data');
		return $query->result_array();
	}

	public function getSentPhotosList($id){
		// print_r($id);die;
		$query = "SELECT CONCAT(profile.first_name,' ',profile.last_name) as user_name, user.email, inmate.inmates_name, facility.name as facility_name,photo.id,photo.sent_by,photo.no_of_photos,photo.sent_date,photo.status,photo.invoice,payment.amount
FROM default_send_photos as photo
LEFT JOIN default_users as user on photo.sent_by = user.id
LEFT JOIN default_profiles as profile on photo.sent_by = profile.user_id
LEFT JOIN default_inmates as inmate on photo.sent_to = inmate.inmates_id
LEFT JOIN default_facility as facility on inmate.facility_id = facility.id
LEFT JOIN default_payments as payment on photo.payment_id = payment.id
WHERE photo.sent_by = ".$id." ORDER BY photo.id DESC ";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}

	public function getImages($id){
		$this->db->select('photo_name,sent_by,msg_photo');
		$this->db->where('id',$id);
		$query = $this->db->get('default_send_photos');
		return $query->result_array();
	}

	public function getSentFundList($id){

		$query = "SELECT CONCAT(profile.first_name,' ',profile.last_name) as user_name, user.email, inmate.inmates_name, facility.name as facility_name,fund.id,fund.paid_by,fund.paid_to,fund.sent_date,fund.status,fund.invoice,fund.fee,fund.unit,fund.original_amount,fund.processing_fees, payment.amount
FROM default_send_funds as fund
LEFT JOIN default_users as user on fund.paid_by = user.id
LEFT JOIN default_profiles as profile on fund.paid_by = profile.user_id
LEFT JOIN default_inmates as inmate on fund.paid_to = inmate.inmates_id
LEFT JOIN default_facility as facility on inmate.facility_id = facility.id
LEFT JOIN default_payments as payment on fund.payment_id = payment.id
WHERE fund.paid_by = ".$id." ORDER BY fund.id DESC";
 // print_r($this->db->last_query());die;
		$result = $this->db->query($query);
		return $result->result_array();
	}

	public function deleteImage($name){
		$this->db->where('photo_name',$name);
		$query = $this->db->delete('default_photo_library');
		return $query;
	}

	public function deleteInmate($id){
		$this->db->where('inmates_id',$id);
		$query = $this->db->delete('default_inmates');
		return $query;
	}

	public function getDetails($id){
		$query = "SELECT CONCAT(profile.first_name,' ',profile.last_name) as user_name, user.email, inmate.inmates_name,inmate.inmates_booking_no, facility.name as facility_name,facility.photo_lab_email,facility.address,facility.city,facility.county,facility.state,facility.country,facility.zip_code,photo.id,photo.sent_by,photo.no_of_photos,photo.sent_date,photo.status, payment.amount,photo.receipient_name,photo.address,photo.city,photo.state,photo.zipcode,photo.country
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
	public function getImagess($id){
		$this->db->select('photo_name,sent_by');
		$this->db->where('id',$id);
		$query = $this->db->get('default_send_photos');
		return $query->result_array();
	}
}