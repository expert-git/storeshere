<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Admin controller for the users module
 *
 * @author		 PyroCMS Dev Team
 * @package	 PyroCMS\Core\Modules\Users\Controllers
 */
class Admin extends Admin_Controller
{

	protected $section = 'facility';

	/**
	 * Validation for basic profile
	 * data. The rest of the validation is
	 * built by streams.
	 *
	 * @var array
	 */
	private $validation_rules = array(
		'email' => array(
			'field' => 'email',
			'label' => 'lang:global:email',
			'rules' => 'required|max_length[60]|valid_email'
		),
		'password' => array(
			'field' => 'password',
			'label' => 'lang:global:password',
			'rules' => 'min_length[6]|max_length[20]'
		),
		'username' => array(
			'field' => 'username',
			'label' => 'lang:user_username',
			'rules' => 'required|alpha_dot_dash|min_length[3]|max_length[20]'
		),
		array(
			'field' => 'group_id',
			'label' => 'lang:user_group_label',
			'rules' => 'required|callback__group_check'
		),
		array(
			'field' => 'active',
			'label' => 'lang:user_active_label',
			'rules' => ''
		),
		array(
			'field' => 'display_name',
			'label' => 'lang:profile_display_name',
			'rules' => 'required'
		)
	);

	/**
	 * Constructor method
	 */
	public function __construct()
	{
		parent::__construct();

		// Load the required classes
		$this->load->model('facility_m');
		$this->load->library('form_validation');
	}

	/**
	 * List all users
	 */
	public function index()
	{	
		$base_where = array('active' => 0);

		// ---------------------------
		// User Filters
		// ---------------------------

		// Determine active param
		$base_where['active'] = $this->input->post('f_module') ? (int)$this->input->post('f_active') : $base_where['active'];

		// Determine group param
		// $base_where = $this->input->post('f_group') ? $base_where + array('group_id' => (int)$this->input->post('f_group')) : $base_where;

		// Keyphrase param
		$base_where = $this->input->post('f_keywords') ? $base_where + array('name' => $this->input->post('f_keywords')) : $base_where;
        
		// Create pagination links
		$pagination = create_pagination('admin/facility/index', $this->facility_m->count_by($base_where));
		$this->db->limit($pagination['limit'], $pagination['offset']);

		// Skip admin
		// $skip_admin = ( $this->current_user->group != 'admin' ) ? 'admin' : '';

		// Using this data, get the relevant results
		// $this->db->order_by('active', 'desc')
		// 	->join('groups', 'groups.id = users.group_id')
		// 	->where_not_in('groups.name', $skip_admin)
		// 	->limit($pagination['limit'], $pagination['offset']);

		$facility = $this->facility_m->getFacilities($base_where);

		// Unset the layout if we have an ajax request
		if ($this->input->is_ajax_request())
		{
			$this->template->set_layout(false);
		}

		// Render the view
		$this->template
			->title($this->module_details['name'])
			->set('pagination', $pagination)
			->set('facility', $facility)
			->set_partial('filters', 'admin/partials/filters')
			->append_js('admin/filter.js')
			->append_js('admin/custom.js')
			->append_js('admin/jquery.form.min.js')
			->append_js('admin/jquery.validate.min.js');

		$this->input->is_ajax_request() ? $this->template->build('admin/tables/facility') : $this->template->build('admin/index');
	}

	/**
	 * Method for handling different form actions
	 */
	public function action()
	{
		// Pyro demo version restrction
		if (PYRO_DEMO)
		{
			$this->session->set_flashdata('notice', lang('global:demo_restrictions'));
			redirect('admin/users');
		}

		// Determine the type of action
		switch ($this->input->post('btnAction'))
		{
			case 'activate':
				$this->activate();
				break;
			case 'delete':
				$this->delete();
				break;
			default:
				redirect('admin/users');
				break;
		}
	}
   
    /**
	 * Method for Add Facility
	*/
	public function addFacility(){
        $post = $this->input->post();        
        $res['status'] = false;
        $res['message'] = 'Unable to add facility';           
        $data = array(
        	'name' => $post['name'],
		    'address' => $post['address'],
		    'city' => $post['city'],
		    'county' => $post['county'],
		    'state' => $post['state'],
		    'country' => $post['country'],
		    'zip_code' => $post['postcode'],
		    'money_option' => $post['money_option'],
		    'photo_option' => $post['photo_option']
        );
        if($post['photo_option'] == 1){
        	$data['photo_size'] = $post['photo_size'];
        	$data['photo_resolution'] = $post['photo_resolution'];
        	$data['no_of_photos'] = $post['no_of_photos'];
        	$data['price_per_photo'] = $post['photo_price'];
        	$data['shipping_charge_per_photo'] = $post['photo_shipping_price'];	
        	$data['photo_lab_email'] = $post['photo_email'];
        }
        if($post['money_option'] == 1){
        	$data['processing_fee'] = $post['processing_fee'];
        	$data['fee_unit'] = $post['fee_unit'];
        	$data['amount'] = str_replace('$', '', $post['amount']);
        }
	    $insert = $this->facility_m->addFacility($data);
	    if($insert){
	    	$res['status'] = true;
            $res['message'] = 'Facility Added Successfully!';
	    }
        exit(json_encode($res));
	}

	/**
	 * Method for Edit Facility
	*/
	public function editFacility(){
        $post = $this->input->post();
        $res['status'] = false;
        $res['message'] = 'Unable to update facility';
        $facility_id = $post['id'];        
        $data = array(
        	'name' => $post['name'],
		    'address' => $post['address'],
		    'city' => $post['city'],
		    'county' => $post['county'],
		    'state' => $post['state'],
		    'country' => $post['country'],
		    'zip_code' => $post['postcode'],
		    'money_option' => $post['money_option'],
		    'photo_option' => $post['photo_option']
        );
        if(isset($post['photo_option']) && $post['photo_option'] == 1){
        	$data['photo_size'] = $post['photo_size'];
        	$data['photo_resolution'] = $post['photo_resolution'];
        	$data['no_of_photos'] = $post['no_of_photos'];
        	$data['price_per_photo'] = $post['photo_price'];
        	$data['shipping_charge_per_photo'] = $post['photo_shipping_price'];
        	$data['photo_lab_email'] = $post['photo_email'];
        }
        if(isset($post['money_option']) && $post['money_option'] == 1){
        	$data['processing_fee'] = $post['processing_fee'];
        	$data['fee_unit'] = $post['fee_unit'];
        	$data['amount'] = str_replace('$', '', $post['amount']);
        }
	    $update = $this->facility_m->editFacility($data,$facility_id);
	    if($update){
	    	$res['status'] = true;
            $res['message'] = 'Facility Updated Successfully!';
	    }
        exit(json_encode($res));
	}
    
    /**
	 * Method for Update Facility Table's active Status, money option and photo option
	*/
    public function updateFacilityTable(){
    	$post = $this->input->post();
    	$data = array($post['key'] => $post['action']);
    	$id = $post['id'];
    	$update = $this->facility_m->updateFacilityTable($data,$id);
    	if($update){
			$res['status'] = true;
			$res['message'] = 'Update Sucessfully!';
		}else{
			$res['status'] = false;
			$res['message'] = 'Unable to update records';
		}
		exit(json_encode($res));
    }

	/**
	 * Create a new user
	 */
	public function create()
	{
		// Extra validation for basic data
		$this->validation_rules['email']['rules'] .= '|callback__email_check';
		$this->validation_rules['password']['rules'] .= '|required';
		$this->validation_rules['username']['rules'] .= '|callback__username_check';

		// Get the profile fields validation array from streams
		$this->load->driver('Streams');
		$profile_validation = $this->streams->streams->validation_array('profiles', 'users');

		// Set the validation rules
		$this->form_validation->set_rules(array_merge($this->validation_rules, $profile_validation));

		$email = strtolower($this->input->post('email'));
		$password = $this->input->post('password');
		$username = $this->input->post('username');
		$group_id = $this->input->post('group_id');
		$activate = $this->input->post('active');

		// keep non-admins from creating admin accounts. If they aren't an admin then force new one as a "user" account
		$group_id = ($this->current_user->group !== 'admin' and $group_id == 1) ? 2 : $group_id;

		// Get user profile data. This will be passed to our
		// streams insert_entry data in the model.
		$assignments = $this->streams->streams->get_assignments('profiles', 'users');
		$profile_data = array();

		foreach ($assignments as $assign)
		{
			$profile_data[$assign->field_slug] = $this->input->post($assign->field_slug);
		}

		// Some stream fields need $_POST as well.
		$profile_data = array_merge($profile_data, $_POST);

		$profile_data['display_name'] = $this->input->post('display_name');

		if ($this->form_validation->run() !== false)
		{
			if ($activate === '2')
			{
				// we're sending an activation email regardless of settings
				Settings::temp('activation_email', true);
			}
			else
			{
				// we're either not activating or we're activating instantly without an email
				Settings::temp('activation_email', false);
			}

			$group = $this->group_m->get($group_id);

			// Register the user (they are activated by default if an activation email isn't requested)
			if ($user_id = $this->ion_auth->register($username, $password, $email, $group_id, $profile_data, $group->name))
			{
				if ($activate === '0')
				{
					// admin selected Inactive
					$this->ion_auth_model->deactivate($user_id);
				}

				// Fire an event. A new user has been created. 
				Events::trigger('user_created', $user_id);

				// Set the flashdata message and redirect
				$this->session->set_flashdata('success', $this->ion_auth->messages());

				// Redirect back to the form or main page
				$this->input->post('btnAction') === 'save_exit' ? redirect('admin/users') : redirect('admin/users/edit/'.$user_id);
			}
			// Error
			else
			{
				$this->template->error_string = $this->ion_auth->errors();
			}
		}
		else
		{
			// Dirty hack that fixes the issue of having to
			// re-add all data upon an error
			if ($_POST)
			{
				$member = (object) $_POST;
			}

		}

		if ( ! isset($member))
		{
			$member = new stdClass();
		}

		// Loop through each validation rule
		foreach ($this->validation_rules as $rule)
		{
			$member->{$rule['field']} = set_value($rule['field']);
		}

		$stream_fields = $this->streams_m->get_stream_fields($this->streams_m->get_stream_id_from_slug('profiles', 'users'));

		// Set Values
		$values = $this->fields->set_values($stream_fields, null, 'new');

		// Run stream field events
		$this->fields->run_field_events($stream_fields, array(), $values);

		$this->template
			->title($this->module_details['name'], lang('user:add_title'))
			->set('member', $member)
			->set('display_name', set_value('display_name', $this->input->post('display_name')))
			->set('profile_fields', $this->streams->fields->get_stream_fields('profiles', 'users', $values))
			->build('admin/form');
	}

	/**
	 * Edit an existing user
	 *
	 * @param int $id The id of the user.
	 */
	public function edit($id)
	{
		$facility = $this->facility_m->getFacilityDetails($id);
		$this->template
			->title($this->module_details['name'])
			->set('facility', $facility)
			->append_js('admin/custom.js')
			->append_js('admin/jquery.form.min.js')
			->append_js('admin/jquery.validate.min.js')
			->build('admin/form');
	}

	/**
	 * Show a user preview
	 *
	 * @param	int $id The ID of the user.
	 */
	public function preview($id = 0)
	{
		$user = $this->ion_auth->get_user($id);

		$this->template
			->set_layout('modal', 'admin')
			->set('user', $user)
			->build('admin/preview');
	}

	/**
	 * Activate users
	 *
	 * Grabs the ids from the POST data (key: action_to).
	 */
	public function activate()
	{
		// Activate multiple
		if ( ! ($ids = $this->input->post('action_to')))
		{
			$this->session->set_flashdata('error', lang('user:activate_error'));
			redirect('admin/users');
		}

		$activated = 0;
		$to_activate = 0;
		foreach ($ids as $id)
		{
			if ($this->ion_auth->activate($id))
			{
				$activated++;
			}
			$to_activate++;
		}
		$this->session->set_flashdata('success', sprintf(lang('user:activate_success'), $activated, $to_activate));

		redirect('admin/users');
	}

	/**
	 * Delete an existing user
	 *
	 * @param int $id The ID of the user to delete
	 */
	public function delete($id = 0)
	{
	    $data = array('active' => 2);
    	$update = $this->facility_m->updateFacilityTable($data,$id);
    	redirect('admin/facility');
	}

	/**
	 * Username check
	 *
	 * @author Ben Edmunds
	 *
	 * @param string $username The username.
	 *
	 * @return bool
	 */
	public function _username_check()
	{
		if ($this->ion_auth->username_check($this->input->post('username')))
		{
			$this->form_validation->set_message('_username_check', lang('user:error_username'));
			return false;
		}
		return true;
	}

	/**
	 * Email check
	 *
	 * @author Ben Edmunds
	 *
	 * @param string $email The email.
	 *
	 * @return bool
	 */
	public function _email_check()
	{
		if ($this->ion_auth->email_check($this->input->post('email')))
		{
			$this->form_validation->set_message('_email_check', lang('user:error_email'));
			return false;
		}

		return true;
	}

	/**
	 * Check that a proper group has been selected
	 *
	 * @author Stephen Cozart
	 *
	 * @param int $group
	 *
	 * @return bool
	 */
	public function _group_check($group)
	{
		if ( ! $this->group_m->get($group))
		{
			$this->form_validation->set_message('_group_check', lang('regex_match'));
			return false;
		}
		return true;
	}

}