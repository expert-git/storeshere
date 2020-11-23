<?php
ini_set('memory_limit', '-1');
defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * User controller for the users module (frontend)
 *
 * @author       Phil Sturgeon
 * @author      PyroCMS Dev Team
 * @package     PyroCMS\Core\Modules\Users\Controllers
 */
class Stores extends Public_Controller{
    public function __construct(){
        parent::__construct();
        // ini_set('display_errors', 1);
        // ini_set('display_startup_errors', 1);
        // error_reporting(E_ALL);
        $this->load->model('user_m');
        $this->load->model('profile_m');
        $this->load->model('ion_auth_model');
        $this->load->helper('common');
        // $this->lang->load('user');
        $this->load->library('form_validation');
        
    }

    public function deleteImage(){
        $post = $this->input->post();
        if(file_exists($post['path'])){
            unlink($post['path']);
            if($this->profile_m->deleteImage($post['imageName'])){
                echo "done";
                return 1;
            }
            else{
                echo "not done";
                return 0;
            }
        }
        else {
            echo $post['path'];
            echo "file path not exists";
            return 0;
        }
    }

    public function phoneImages(){
        if(!is_logged_in()){
            redirect('');
        }
        if(isset($_FILES) && !empty($_FILES['imgData'])){
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $config['max_size']             = 15000;
            $config['max_width']            = 5000;
            $config['max_height']           = 4000;

            $path = $_SERVER['DOCUMENT_ROOT'].BASE_URI.'uploads/';
            $id = $this->current_user->id; 
            $folder_path = $path.$id.'/';            
            $picPath = $folder_path.'photos/';            
            
            if(!is_dir($folder_path)){
                mkdir($folder_path);
            }
            if(!is_dir($picPath)){
                mkdir($picPath);
            }
            $config['upload_path']          = $picPath;
            $file = trim(str_replace('[removed]', '', $file));
            $filename = time();
            $random_text = randomToken(5);
            $ext = '.jpeg';            
            $fullfilename = $filename.'_'.$random_text.$ext;   
            $config['file_name'] = $fullfilename;
            $this->load->library('upload', $config);

            if ( ! $this->upload->do_upload('imgData'))
            {
                
                exit(json_encode(array('status' => 0,'message' => $this->upload->display_errors())));
            }
            else
            {
                $savedata = new stdClass();
                $savedata->user_id = $id;
                $savedata->photo_name = $fullfilename;
                $savedata->photo_type = 1;
                $savedata->is_sent = 0;
                $savedata->created_date = date('Y-m-d H:i:s');
                $save = $this->profile_m->savePhotoInLibrary($savedata);
                
                exit(json_encode(array('status' => 1,'message' => $this->upload->data())));
            }
        }
    }

    public function test(){
        error_reporting(E_ALL);
        ini_set('display_errors', true);        
        // $result = mail('business.devpatidar1224@gmail.com', 'test', 'test email');
        // print_r($result);die;        
        $result = Events::trigger('email', array(                       
                        'sender_ip' => $this->input->ip_address(),
                        'sender_agent' => $this->agent->browser().' '.$this->agent->version(),
                        'sender_os' => $this->agent->platform(),
                        'slug' => 'registered',
                        'to' => 'rajkumaarpateel@gmail.com',
                    ), 'array');
        echo '<pre>'.$this->email->print_debugger().'</pre>';
        print_r($result);die;
    }

    public function signUp($error=''){
        
       
        $data['country_names'] = $this->profile_m->getCountry();
        if(!is_logged_in()){
            
            if($error == '1'){
                $data['error_string'] = "Sorry! Username is not available";
            }
            if($error == '2'){
                $data['error_string'] = "Sorry! Email is already registered with us";
            }

             if($error == '3'){
                $data['error_string'] = "Sorry! Phone is already registered with us";
            }


            $data['scripts'] = array('developer.js','chosen.jquery.js','dataTable.js'); 
            $this->template->build('stores/signup',$data); 

        }else{
            
           
           redirect('');
        }
    }

    public function signup_success(){
        if(!is_logged_in()){
           $this->template->build('signup_success'); 
        }else{
           redirect('');
        }
    }

    public function signup_mobile(){

        if(!is_logged_in()){
           $this->template->build('signup_mobile'); 
        }else{
           redirect('');
        }
    }

    public function verifyOTP() {

        if(!empty($_POST)){

            $this->db->where("id",$_POST['user_id']);
            $this->db->limit(1);
            $obj = $this->db->get("default_users");

            if($obj->num_rows() > 0){

                $row = $obj->row();

                if(trim($_POST['otp']) == $row->activation_code){

                    $this->db->where("id",$_POST['user_id']);
                    $this->db->limit(1);
                    $obj = $this->db->update("default_users",array("active"=>1));

                    $responce['status'] = true;
                    $responce['message'] =  'Account has been verified successfuly. You can login now.';

                   
                }else{

                    $responce['status'] = false;
                    $responce['message'] =  'Invalid otp.';
                }

            }else{

                $responce['status'] = false;
                $responce['message'] =  'User not exists.';
            }

             exit(json_encode($responce));



        }else{
            redirect('');
        }
        
    }





    public function loginSuccess(){
        if(is_logged_in()){
            $id = $this->current_user->id;
            $data['show'] = 0;
            $data['profile'] = $this->profile_m->getProfileDetails($id);
            $data['facility'] = $this->profile_m->getallFacilities(1);
            $data['inmates'] = $this->profile_m->getInmatesList($id);           
            $data['moneyFacility'] = $this->profile_m->getMoneyFacility();
            $data['sentPhotos'] = $this->profile_m->getSentPhotosList($id);
            $data['sentFunds'] = $this->profile_m->getSentFundList($id);            
            $data['scripts'] = array('developer.js','chosen.jquery.js','dataTable.js'); 
            $this->template->build('stores/login_success',$data); 
        }else{
           redirect('');
        }
    }

    public function change_pass(){
        if(is_logged_in()){
            $id = $this->current_user->id;
            $data['show'] = 0;
            $data['profile'] = $this->profile_m->getProfileDetails($id);
            $data['scripts'] = array('developer.js','chosen.jquery.js','dataTable.js'); 
            $this->session->set_flashdata('msg', array('type' => 'info', 'message' => 'You can anytime change your password'));
            $this->template->build('stores/change_pass',$data); 
        }else{
            redirect('');
        }
    }

    public function add_inmate(){
        if(is_logged_in()){
            // $data['paypalURL'] = 'https://www.sandbox.paypal.com/cgi-bin/webscr'; //Test PayPal API URL 
            // $data['paypalID'] = 'business.devpatidar1224@gmail.com'; //Business Email
            $data['paypalURL'] = 'https://www.api.paypal.com/cgi-bin/webscr'; //Main PayPal API URL 
            $data['paypalID'] = 'ron_api1.ronniecase.com'; //Business Email
            $id = $this->current_user->id;
            $data['show'] = 0;
            $data['profile'] = $this->profile_m->getProfileDetails($id);
            $data['facility'] = $this->profile_m->getallFacilities(1);          
            $data['scripts'] = array('developer.js','chosen.jquery.js','dataTable.js');             
            $this->template->build('stores/add_inmate',$data); 
        }else{
           redirect('');
        }
    }

    public function inmate_list(){
        if(is_logged_in()){
            // $data['paypalURL'] = 'https://www.sandbox.paypal.com/cgi-bin/webscr'; //Test PayPal API URL
            // $data['paypalID'] = 'business.devpatidar1224@gmail.com'; //Business Email
            $data['paypalURL'] = 'https://www.api.paypal.com/cgi-bin/webscr'; //Main PayPal API URL 
            $data['paypalID'] = 'ron_api1.ronniecase.com'; //Business Email
            $id = $this->current_user->id;
            $data['show'] = 0;          
            $data['inmates'] = $this->profile_m->getInmatesList($id);
            $data['scripts'] = array('developer.js','chosen.jquery.js','dataTable.js'); 
            $this->session->set_flashdata('msg', array('type' => 'info', 'message' => 'You can view all the inmates you added into the system'));
            $this->template->build('stores/inmate_list',$data); 
        }else{
           redirect('');
        }
    }

    public function photos_sent(){
        if(is_logged_in()){         
            $id = $this->current_user->id;
            $data['show'] = 0;
            $data['profile'] = $this->profile_m->getProfileDetails($id);            
            $data['sentPhotos'] = $this->profile_m->getSentPhotosList($id);
            $data['scripts'] = array('developer.js','chosen.jquery.js','dataTable.js');
            $this->session->set_flashdata('msg', array('type' => 'info', 'message' => 'You can view here all the photos you previously sent to your inmate(s)')); 
            $this->template->build('stores/photos_sent',$data); 
        }else{
           redirect('');
        }
    }

    public function funds_sent(){
        if(is_logged_in()){         
            $id = $this->current_user->id;
            $data['show'] = 0;
            $data['profile'] = $this->profile_m->getProfileDetails($id);            
            $data['sentFunds'] = $this->profile_m->getSentFundList($id);            
            $data['scripts'] = array('developer.js','chosen.jquery.js','dataTable.js');
            $this->session->set_flashdata('msg', array('type' => 'info', 'message' => 'You can view here all the funds you previously sent to your inmate(s)')); 
            $this->template->build('stores/funds_sent',$data); 
        }else{
           redirect('');
        }
    }

    public function sendFunds(){
        if(is_logged_in()){
            // $data['paypalURL'] = 'https://www.sandbox.paypal.com/cgi-bin/webscr'; //Test PayPal API URL         
            // $data['paypalID'] = 'business.devpatidar1224@gmail.com'; //Business Email
            $data['paypalURL'] = 'https://www.api.paypal.com/cgi-bin/webscr'; //Main PayPal API URL 
            $data['paypalID'] = 'ron_api1.ronniecase.com'; //Business Email
            $id = $this->current_user->id;
            $data['show'] = 0;
            $data['profile'] = $this->profile_m->getProfileDetails($id);
            $data['facility'] = $this->profile_m->getallFacilities(1);
            $data['inmates'] = $this->profile_m->getInmatesList($id);            
            $data['moneyFacility'] = $this->profile_m->getMoneyFacility();

            $data['sentPhotos'] = $this->profile_m->getSentPhotosList($id);
            $data['sentFunds'] = $this->profile_m->getSentFundList($id);            
            $data['scripts'] = array('developer.js','chosen.jquery.js','dataTable.js'); 
 
            $this->template->build('stores/sendfunds',$data); 
        }else{
           redirect('');
        }
    }

    public function contact(){
        $data['scripts'] = array('custom.js');
        if(is_logged_in()){
            $data['show'] = 0;
            $id = $this->current_user->id;
            $data['profile'] = $this->profile_m->getProfileDetails($id);
            $data['facility'] = $this->profile_m->getallFacilities(1);
            $data['inmates'] = $this->profile_m->getInmatesList($id);
            $data['sentPhotos'] = $this->profile_m->getSentPhotosList($id);
            $data['sentFunds'] = $this->profile_m->getSentFundList($id);
            $data['scripts'] = array('developer.js','chosen.jquery.js','dataTable.js');
        }
        $this->template->build('stores/contact',$data); 
    }

    public function setPassword(){
        $post = $this->input->post();
        $res['status'] = false;
        $res['message'] = "Invalid Request!";
        $code = $post['id'];
        $id = $this->user_m->getUserIdByCode($code);
        if($id){
            $new_pass = $post['password'];
            $encoded_new_pass = $this->ion_auth_model->hash_password_db($id, $new_pass);
            $data = new stdClass();
            $data->password = $encoded_new_pass;
            $resp = $this->profile_m->updatePassword($data, $id);
            $resp = $this->profile_m->updateForgetPassCode($code);
            if($resp){
                $res['status'] = true;
                $res['message'] = "Password changed successfully!";
            }else{
                $res['status'] = false;
                $res['message'] = "Unable to change Password!";
            }
        }
        exit(json_encode($res));
    }

    public function generateCaptcha(){
        $var = 'abcdefghijklmnopqrstuvwxyz';
        // $var .= strtolower($var);
        $var = str_shuffle($var);
        echo substr($var,0,6);die;
    }

    public function profile(){
        if(is_logged_in()){
            $data['show'] = 1;
            $id = $this->current_user->id;
            $data['country_names'] = $this->profile_m->getCountry();
            $data['user'] = $this->profile_m->getUserDetails($id);
            $data['profile'] = $this->profile_m->getProfileDetails($id);
            $data['facility'] = $this->profile_m->getallFacilities(1);
            $data['inmates'] = $this->profile_m->getInmatesList($id);
            $data['sentPhotos'] = $this->profile_m->getSentPhotosList($id);
            $data['sentFunds'] = $this->profile_m->getSentFundList($id);
            $data['scripts'] = array('developer.js','chosen.jquery.js','dataTable.js');
            $this->template->build('stores/profile',$data);
        }else{
            redirect('');
        } 
    }

    public function testing(){
        $client = get_twilio_client();

        try {
            $client->messages->create(
                '+919755511094',
                array(
                    'from' => '+14088907359',
                    'body' => 'It is working inside from codeigniter'
                )
            );
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
                
    }

    public function aboutUs(){
        if(is_logged_in()){
            $id = $this->current_user->id;
            $data['show'] = 0;
            $data['scripts'] = array('developer.js','chosen.jquery.js','dataTable.js','fabric/fabric.min.js','emojione.js');
            $data['inmates'] = $this->profile_m->getInmatesList($id);
            $data['sentPhotos'] = $this->profile_m->getSentPhotosList($id);
            $data['sentFunds'] = $this->profile_m->getSentFundList($id);
            $this->template->build('stores/aboutus',$data);
        } else{
            $this->template->build('stores/aboutus');   
        }
    }

    public function editPhotos(){
        if(is_logged_in()){
            $fd = $_GET['data'];
            $this->load->view('stores/editor/editor.php',array('fd'=>$fd));
        }else{
            redirect('');
        }        
    }

    public function saveImageToLibrary(){
        if(!is_logged_in()){
            redirect('');
        }
        $post = $this->input->post();
        if(isset($post['imgData']) && !empty($post['imgData'])){
            $id = $this->current_user->id;            
            $file = $post['imgData'];
            $path = $_SERVER['DOCUMENT_ROOT'].BASE_URI.'uploads/';
            $folder_path = $path.$id.'/';            
            $picPath = $folder_path.'photos/';            
            
            if(!is_dir($folder_path)){
                mkdir($folder_path);
            }
            if(!is_dir($picPath)){
                mkdir($picPath);
            }

            $file = trim(str_replace('[removed]', '', $file));
            $filename = time();
            $random_text = randomToken(5);
            $ext = '.jpeg';            
            $fullfilename = $filename.'_'.$random_text.$ext;   
            $data = base64_decode($file);
            $filepath = $picPath.$fullfilename;
            $handle = fopen($filepath, 'w', 0777);
            fwrite($handle, $data);
            fclose($handle);
            $savedata = new stdClass();
            $savedata->user_id = $id;
            $savedata->photo_name = $fullfilename;
            $savedata->photo_type = 1;
            $savedata->is_sent = 0;
            $savedata->created_date = date('Y-m-d H:i:s');
            $save = $this->profile_m->savePhotoInLibrary($savedata);
            if($save){
                $res['status'] = 1;
                $res['message'] = 'Photo saved';
            }else{
                $res['status'] = 0;
                $res['message'] = 'Some error occured';
            }
            exit(json_encode($res));
        }
    }

    public function sendPhotos($fd=''){

        if(is_logged_in()){
            $id = $this->current_user->id;
            $data['show'] = 0;
            if(isset($fd) && !empty($fd)){
                $fd = base64_decode($fd);
                $fd = unserializeMe($fd); 
            }
            $data['fd'] = $fd;
            if(isset($fd['name'])){
                $data['inmate_names'] = $this->profile_m->getFacilityInmates($id,$fd['facility']);
            }
            if($_GET['data']) {
                $data['upload_result'] = "Image uploaded successfully";
            } else if($_GET['errror']) {
                $data['upload_result'] = "Image not uploaded";
            }
            $data['profile'] = $this->profile_m->getProfileDetails($id);
            $data['facility'] = $this->profile_m->getallFacilities(1);
            $data['inmates'] = $this->profile_m->getInmatesList($id);
            $data['sentPhotos'] = $this->profile_m->getSentPhotosList($id);
            $data['sentFunds'] = $this->profile_m->getSentFundList($id);
            $data['photoFacility'] = $this->profile_m->getPhotoFacility();
            $data['photoLibrary'] = $this->profile_m->getPhotoLibrary($id);            
            // print_r($data['photoFacility']);die;
            // $emojiPath = $_SERVER['DOCUMENT_ROOT'].BASE_URI.$this->template->get_theme_path().'img/emoji';
            // $dir = scandir($emojiPath);          
            // $slice = array_slice($dir, 1000);
            // $data['emoji'] = $slice;            
            $data['emoji'] = array();           
            $data['scripts'] = array('developer.js','chosen.jquery.js','dataTable.js','fabric/fabric.min.js','emojione.js');
            $this->template->build('stores/photos',$data);
        }else{
            redirect('');
        }
    }

    public function getEmojis(){
        if(is_logged_in()){
            $emojiPath = $_SERVER['DOCUMENT_ROOT'].BASE_URI.$this->template->get_theme_path().'img/emoji';
            $dir = scandir($emojiPath);
            $slice = array_slice($dir, 2);

            $data['emoji'] = $slice;
        }
    }

    public function fundingOptions(){
        if(is_logged_in()){
            $id = $this->current_user->id;
            $data['show'] = 0;
            $data['scripts'] = array('developer.js','chosen.jquery.js','dataTable.js','fabric/fabric.min.js','emojione.js');
            $data['inmates'] = $this->profile_m->getInmatesList($id);
            $data['sentPhotos'] = $this->profile_m->getSentPhotosList($id);
            $data['facility'] = $this->profile_m->getallFacilities(1);
            $data['sentFunds'] = $this->profile_m->getSentFundList($id);
            $this->template->build('stores/fundings',$data);
        }
        else{
            $this->template->build('stores/fundings');   
        }
    }


    public function updateProfile(){
        if(!is_logged_in()){
            redirect('');
        }
        $post = $this->input->post();
        $data = array(
             'first_name' => $post['first_name'],
             'middle_name' => $post['middle_name'],
             'last_name' => $post['last_name'],
             'street_address' => $post['address'],
             'user_email' => $post['user_email'],
             'postcode' => $post['postcode'],
             'city' => $post['city'],
             'state' => $post['state'],
             'country' => $post['country'],
             'mobile' => $post['mobile'],
             'notified_by' => $post['notify']
            );
        $where = array('user_id'=>$this->current_user->id);
        $update = $this->profile_m->updateProfile($data,$where);
        if($update){
            $this->session->set_flashdata('msg', array('type' => 'success', 'message' => 'Your profile details have been successfully updated.'));
            redirect('profile');
            // $res['status'] = true;
            // $res['message'] = 'Profile Updated Successfully.'; 
        }else{
            $this->session->set_flashdata('msg', array('type' => 'error', 'message' => 'Unable to update profile, please try again.'));
            redirect('profile');
            // $res['status'] = false;
            // $res['message'] = 'Unable to Update Profile'; 
        }
        exit(json_encode($res));
    }

    public function editInmate($id){
        if(is_logged_in()){
            $data = $this->profile_m->getInmateDetails($id);
            if(!empty($data)){
                $res['data'] = $data;
                $res['facility'] = $this->profile_m->getallFacilities(1);
                $this->template->build('stores/editinmate',$res);
            }else{
                redirect('profile');
            }           
        }else{
            redirect('');
        }       
    }

    public function updateInmate(){
        $post = $this->input->post();
        if(!empty($post)){
            $data = new stdClass();
            $data->inmates_name = $post['name'];
            $data->inmates_booking_no = $post['bookingId'];
            $data->facility_id = $post['facility'];
            $id = $post['id'];
            $res = $this->profile_m->updateInmate($data, $id);
            if($res){
                exit(json_encode(array('status' => true, 'message' => 'Inmate detail updated successfully')));
                $this->session->set_flashdata('msg', array('type' => 'success', 'message' => 'The Inmate details have been successfully updated'));
                redirect('inmate_list');
            }else{
                exit(json_encode(array('status' => false, 'message' => 'Some error had occured')));
                $this->session->set_flashdata('msg', array('type' => 'error', 'message' => 'Some error occured please try again'));
                redirect('inmate_list');
            }
        }else{
            redirect('');
        }
    }

    public function updatePassword(){
        if(!is_logged_in()){
            redirect('');
        }
        $post = $this->input->post();
        $res['status'] = false;
        $res['message'] = "Invalid Request!";
        if(!empty($post)){
            $id = $this->current_user->id;
            $curr_pass = $post['current_pass'];
            $new_pass = $post['new_pass'];
            $conf_pass = $post['c_pass'];
            $encoded_pass = $this->ion_auth_model->hash_password_db($id, $curr_pass);
            $checkPass = $this->profile_m->checkPassword($encoded_pass, $id);
            if($checkPass){
                $encoded_new_pass = $this->ion_auth_model->hash_password_db($id, $new_pass);
                $data = new stdClass();
                $data->password = $encoded_new_pass;
                $resp = $this->profile_m->updatePassword($data, $id);
                
                if($resp){
                    $client = get_twilio_client(); 
                    $Email = $this->profile_m->getUserDetails($id);
                    $pc = $this->db->query("select phonecode from default_country where nicename = '".$Email[0]['country']."'")->result_array();
                    
                        $mobile = '+'.$pc[0]['phonecode'].$Email[0]['mobile'];
                        
                    
                        try {
                            $client->messages->create(
                                $mobile,
                                array(
                                    'from' => '+14088907359',
                                    'body' => 'Your password has been changed successfully'
                                )
                            );
                        } catch (Exception $e) {
                            //Log::error($e->getMessage());
                            $e->getMessage();
                        }
                    exit(json_encode(array('status' => true, 'message' => 'Your password has been changed successfully')));
                    
                    
                    $this->session->set_flashdata('msg', array('type' => 'success', 'message' => 'Your password has been successfully changed.'));
                    redirect('change_pass');                    
                }else{
                    exit(json_encode(array('status' => false, 'message' => 'some error have occured')));
                    $this->session->set_flashdata('msg', array('type' => 'error', 'message' => 'Some error occured, please try again'));
                    redirect('change_pass');                    
                }
            }else{
                exit(json_encode(array('status' => false, 'message' => 'You entered wrong password, please confirm and try again')));
                $this->session->set_flashdata('msg', array('type' => 'error', 'message' => 'You entered wrong password, please confirm and try again'));
                redirect('change_pass');                
            }
        }       
    }

    public function addInmates(){
        if(!is_logged_in()){
            redirect('');
        }
        $post = $this->input->post();
        $res['status'] = false;
        $res['message'] = "Invalid Request!";
        if(!empty($post)){
            $data = array(
                'user_id' => $this->current_user->id,
                'first_name' => $post['first_name'],
                'middle_name' => $post['middle_name'],
                'last_name' => $post['last_name'],
                'bookingId' => $post['bookingId'],
                'facility' => $post['facility']
            );
            $resp = $this->profile_m->addInmates($data);
            if($resp){
                $userData = $this->profile_m->getInmateDetails($resp);
                $mailData['slug'] = 'admin-inmate-template';      
                $mailData['to'] = "admin@storeshere.com";                         
                $mailData['admin'] = 'Admin'; 
                $mailData['user_name'] = $this->current_user->username;
                $mailData['facility_name'] = $userData[0]['facility_name'];
                $mailData['facility_address'] = $userData[0]['address'].', '.$userData[0]['city'].', '.$userData[0]['county'].', '.$userData[0]['state'].', '.$userData[0]['country'];
                $mailData['inmate_name'] = $userData[0]['inmates_name']." ".$userData[0]['inmates_middle_name']." ".$userData[0]['inmates_last_name'];
                $mailData['booking_no'] = $userData[0]['inmates_booking_no'];  
                
                $email_admin = Events::trigger('email',$mailData, 'array');

                exit(json_encode(array('status' => true, 'message' => 'Inmate added successfully')));
                $this->session->set_flashdata('msg', array('type' => 'success', 'message' => 'Inmate has been successfully added, you can continue adding more inmates OR can start sending funds/photos using above navigation.'));
                redirect('add_inmate');             
            }else{
                exit(json_encode(array('status' => false, 'message' => 'Sorry some error occur')));
                $this->session->set_flashdata('msg', array('type' => 'error', 'message' => 'Inmate with the given booking number already exists, please add another.'));
                redirect('add_inmate');
            }
        }       
    }

    public function getFacilityInmates(){
        $post = $this->input->post();
        $id = $post['id'];
        $facility = $post['facility'];
        $data['resp'] = $this->profile_m->getFacilityInmates($id,$facility);
        if(isset($post['getamount']) && $post['getamount']){
            $data['amount'] = $this->profile_m->getFacilityAmount($facility);
        }
        if(!empty($data['resp'])){
            $data['status'] = true;
            $data['message'] = 'success';
        }else{
            $data['status'] = false;
            $data['message'] = 'No Inmates Found For This Facility';
        }
        exit(json_encode($data));
    }

    public function addImage(){
        $post = $this->input->post();
        print_r($post);die;
        $path = $_SERVER['DOCUMENT_ROOT'].BASE_URI.'uploads/';
        $folder_path = $path.$id.'/';
        if($type == 0){
          $picPath = $folder_path.'items/';
        }else{
          $picPath = $folder_path.'message_items/';
        }
        
        if(!is_dir($folder_path)){
            mkdir($folder_path);
        }
        if(!is_dir($picPath)){
            mkdir($picPath);
        }

        $file = trim(str_replace('[removed]', '', $file));
        $filename = time();
        $ext = '.jpg';
        $fullfilename = $filename.$ext;     
        $data = base64_decode($file);
        $filepath = $picPath.$fullfilename;
        $handle = fopen($filepath, 'w', 0777);
        fwrite($handle, $data);
        fclose($handle);
        return $fullfilename;
    }

    public function _payThroughPaypal(){
        $post = $this->input->post();
        print_r($post);die;
        
        $req = 'cmd=_notify-validate';
        foreach ($post as $key => $value) {
            $value = urlencode(stripslashes($value));
            $value = preg_replace('/(.*[^%^0^D])(%0A)(.*)/i','${1}%0D%0A${3}',$value);// IPN fix
            $req .= "&$key=$value";
        }       
        $data['inmate_id']          = $post['name'];
        $data['facility']       = $post['facility'];
        $data['booking_no']     = $post['bookingNo'];
        $data['payment_amount']     = $post['amount'];
        $data['payment_currency']   = $post['currency_code'];           
        $data['receiver_email']     = PAYPAL_EMAIL;
        // $data['payer_email']         = $_POST['payer_email'];
        // $data['custom']          = $_POST['custom'];

        $header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
        $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
                
        // $fp = fsockopen ('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30);
        $fp = fsockopen ('ssl://www.api.paypal.com', 443, $errno, $errstr, 30); 
        if (!$fp) {
        // HTTP ERROR
        echo 'http error';
        } else {
            fputs($fp, $header . $req);
            while (!feof($fp)) {
                $res = fgets ($fp, 1024);
                print_r($res);die;
                if (strcmp($res, "VERIFIED") == 0) {

                } else if (strcmp ($res, "INVALID") == 0) {
                
                    // PAYMENT INVALID & INVESTIGATE MANUALY!
                    // E-mail admin or alert user
                    
                    // Used for debugging
                    //@mail("user@domain.com", "PAYPAL DEBUGGING", "Invalid Response<br />data = <pre>".print_r($post, true)."</pre>");
                }
            }
        fclose ($fp);
        }
        
    }

    public function uploadPhotos(){
        date_default_timezone_set("America/New_York");
        if(!is_logged_in()){
            redirect('');
        }
        $this->load->library('payments_pro');
        $post = $this->input->post();
        $id = $this->current_user->id;
        $finalData = array();
        if(isset($post['photo_id']) && !empty($post['photo_id'])){
            $no_of_photos = count($post['photo_id']);
            foreach($post['photo_name'] as $k => $v){
                $finalData['image'][] = $v;
            }
        }else{
            $this->session->set_flashdata('msg', array('type' => 'error', 'message' => 'Please select at least one photo to send.'));
            redirect('sendPhotos');
        }        
        $facility_info = $this->profile_m->getFacilityDetails($post['facility']);
        if(!empty($_FILES) && isset($_FILES['doc'])){
            $fileData = $_FILES['doc'];
            $tmppath = $fileData['tmp_name'];
            $random_text = randomToken(5);
            $ext = strtolower(pathinfo($fileData['name'], PATHINFO_EXTENSION));
            $path = $_SERVER['DOCUMENT_ROOT'].BASE_URI.'uploads/';
            $folder_path = $path.$id.'/';
            $picPath = $folder_path.'docs/';                
            $filename = time();
            $fullfilename = $filename.'_'.$random_text.'.'.$ext;
            $filepath = $picPath.$fullfilename; 
                  
            if(!is_dir($folder_path)){
                mkdir($folder_path);
                if(!is_dir($picPath)){
                    mkdir($picPath);
                }
            }else{
                if(!is_dir($picPath)){
                    mkdir($picPath);
                }
            }
            if(move_uploaded_file($tmppath,$filepath)){ 
                $finalData['doc'] = $fullfilename;
            }
        }

        $calculate_amount = ($facility_info[0]['price_per_photo']*$no_of_photos)+($facility_info[0]['shipping_charge_per_photo']);
        $finalData['sent_by'] = $id;

        $finalData['sent_to'] = $post['name'];
        $finalData['no_of_photos'] = $no_of_photos;
        $finalData['sent_date'] = date('Y-m-d H:i:s');
        $finalData['status'] = 1;
        $finalData['amount'] = $calculate_amount;
        $finalData['currency_code'] = $currency_code = 'USD';

        if(isset($post['receipient_name'])){
            $finalData['receipient_name'] = $post['receipient_name'];
        }
        if(isset($post['address'])){
            $finalData['address'] = $post['address'];
        }
        if(isset($post['city'])){
            $finalData['address'] = $post['city'];
        }
        if(isset($post['state'])){
            $finalData['state'] = $post['state'];
        }
        if(isset($post['zipcode'])){
            $finalData['zipcode'] = $post['zipcode'];
        }
        if(isset($post['country'])){
            $finalData['country'] = $post['country'];
        }
        if(isset($post['message'])){
            $finalData['message_text'] = $post['message'];
        }
        
        if(isset($post['destruction_clause'])){
            $finalData['destruction_clause'] = $post['destruction_clause'];
        }
        if(isset($post['messager'])){
            $finalData['return_msg'] = $post['messager'];
        }
        
        $transaction_id = randomToken(15);
        $finalData['transaction_id'] = $transaction_id;

        $savedata = new stdClass();
        $savedata->tmp_data = serialize($finalData);
        $savedata->create_date = date('Y-m-d H:i:s');
        $savedata->refrence = 1;
     
        $save_id = $this->profile_m->saveTmpData($savedata);
        
        $data['custom'] = $transaction_id;
        $data['return'] = base_url().'paypalSuccess/?amt='.$calculate_amount.'&id='.$save_id.'&no_of_photos='.$no_of_photos;       
        $data['cancel_return'] = base_url().'paypal_cancel';
        $data['notify_url'] = base_url().'paypal_notify';
        $data['amt'] = $calculate_amount;
        $data['currency_code'] = $currency_code;
        
        // $var = $this->payments_pro->Set_express_checkout($data);
        // return true;

        $enableSandbox = false;
        $paypalUrl = $enableSandbox ? 'https://www.sandbox.paypal.com/cgi-bin/webscr' : 'https://www.paypal.com/cgi-bin/webscr';
        // $paypalUrl = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
        // Set the PayPal account.
        $data['business'] = 'PayPal@storeshere.com'; //'dgupta.arun-facilitator@gmail.com';// 
        $data['cmd'] = '_xclick';
        $data['amount'] = $calculate_amount;
        $data['item_name']='Storeshere';
        
        // Build the query string from the data.
        $queryString = http_build_query($data);
    
        // Redirect to paypal IPN
        header('location:' . $paypalUrl . '?' . $queryString);
        exit();

    }

    public function upload_photos(){
        if(!is_logged_in()){
            redirect('');
        }
        $this->load->helper('genie-payment');
        $this->load->library('payments_pro');
        $post = $this->input->post();
        $id = $this->current_user->id;
        $finalData = array();
        $cashbox = 9992588011;
        if(isset($post['photo_id']) && !empty($post['photo_id'])){
            $no_of_photos = count($post['photo_id']);
            foreach($post['photo_name'] as $k => $v){
                $finalData['image'][] = $v;
            }
        }else{
            $this->session->set_flashdata('msg', array('type' => 'error', 'message' => 'Please select at least one photo to send.'));
            redirect('sendPhotos');
        }        
        $facility_info = $this->profile_m->getFacilityDetails($post['facility']);
        $user = $this->profile_m->getProfileDetails($id);
        $cellphone = $user[0]['mobile'];
        $email = $user[0]['user_email'];
        $firstname = $user[0]['first_name'];
        $lastname = $user[0]['last_name'];
        $country = $user[0]['country'];
        $address1 = $address2 = $user[0]['street_address'];
        $city = $user[0]['city'];
        $state = $user[0]['state'];
        $zip = $user[0]['postcode'];
        $description = "this is test description";
        $expiremin = '10';
        $random_text = randomToken(5);
        
        if(!empty($_FILES) && isset($_FILES['doc'])){
            $fileData = $_FILES['doc'];
            $tmppath = $fileData['tmp_name'];
            $random_text = randomToken(5);
            $ext = strtolower(pathinfo($fileData['name'], PATHINFO_EXTENSION));
            $path = $_SERVER['DOCUMENT_ROOT'].BASE_URI.'uploads/';
            $folder_path = $path.$id.'/';
            $picPath = $folder_path.'docs/';                
            $filename = time();
            $fullfilename = $filename.'_'.$random_text.'.'.$ext;
            $filepath = $picPath.$fullfilename;         
            if(!is_dir($folder_path)){
                mkdir($folder_path);
                if(!is_dir($picPath)){
                    mkdir($picPath);
                }
            }else{
                if(!is_dir($picPath)){
                    mkdir($picPath);
                }
            }
            if(move_uploaded_file($tmppath,$filepath)){    
                $finalData['doc'] = $fullfilename;
            }
        }

        $calculate_amount = ($facility_info[0]['price_per_photo']*$no_of_photos)+($facility_info[0]['shipping_charge_per_photo']);
        $finalData['sent_by'] = $id;

        $finalData['sent_to'] = $post['name'];
        $finalData['no_of_photos'] = $no_of_photos;
        $finalData['sent_date'] = date('Y-m-d H:i:s');
        $finalData['status'] = 1;
        $finalData['amount'] = $calculate_amount;
        $finalData['currency_code'] = $currency_code = 'USD';
        if(isset($post['receipient_name'])){
            $finalData['receipient_name'] = $post['receipient_name'];
        }
        if(isset($post['address'])){
            $finalData['address'] = $post['address'];
        }
        if(isset($post['city'])){
            $finalData['address'] = $post['city'];
        }
        if(isset($post['state'])){
            $finalData['state'] = $post['state'];
        }
        if(isset($post['zipcode'])){
            $finalData['zipcode'] = $post['zipcode'];
        }
        if(isset($post['country'])){
            $finalData['country'] = $post['country'];
        }
        if(isset($post['destruction_clause'])){
            $finalData['destruction_clause'] = $post['destruction_clause'];
        }
        if(isset($post['message'])){
            $finalData['message_text'] = $post['message'];
        }
        if(isset($post['messager'])){
            $finalData['return_msg'] = $post['messager'];
        }
        
        $savedata = new stdClass();
        $savedata->tmp_data = serialize($finalData);
        $savedata->create_date = date('Y-m-d H:i:s');
        $savedata->refrence = 1;
     
        $save_id = $this->profile_m->saveTmpData($savedata);
        $return_url = base_url()."genie_success?id=".$save_id."%26return=";

        $param = "cashbox=$cashbox&amount=$calculate_amount&orderid=$random_text&cellphone=$cellphone&email=$email&firstname=$firstname&lastname=$lastname&company=belllabs&country=$country&address1=$address1&address2=$address1&city=$city&state=$state&zip=$zip&description=$description&expiremin=$expiremin&ReturnURL=$return_url";

        $enc_url = encrypt_pol($param);

        redirect('https://geniecashbox.com/pol/?'.$enc_url);
        return true;
    }

    public function genie_success (){
        date_default_timezone_set("America/New_York");
        if(!is_logged_in()){
            redirect('');
        }
        
        // date.timezone = "America/New_York";
        $this->load->library('zip');
        $this->load->helper('genie-payment');
        
        //parse_str(substr(strrchr($_SERVER['REQUEST_URI'], "?"), 1), $_GET);
        $code = $_GET;
        
        $return = $code['return'];
        $return = substr($return, 1);

        $id = $code['id'];

        $var = decrypt_pol(substr($return,0));
        
        $value              = explode('&',$var);   

        // Get Order ID
        $order              = explode('=',$value[0]); 
        $order_id           = $order[1];

        // Get Order Status 
        $status_detail      = explode('=',$value[1]); 
        $status             = $status_detail[1];


        // Request No 
        $requestno_detail   = explode('=',$value[3]); 
        $requestno          = $requestno_detail[1];

        // Transaction Result 0 for success
        $result_detail      = explode('=',$value[4]); 
        $result             = $result_detail[1];        

        // Retured Message
        $msg_detail         = explode('=',$value[5]); 
        $msg            = $msg_detail[1];
        
        $getTmpData = $this->profile_m->getTmpData($id);        
        $getTmpData = unserialize($getTmpData[0]['tmp_data']);  

        $genieData = new stdClass();
        $genieData->token = $order_id;      
        $genieData->payer_id = $requestno;
        $genieData->amount = $getTmpData['amount'];
        $genieData->currency_code = 'USD';
        $genieData->payment_date = date('Y-m-d H:i:s');
        $genieData->payment_status = 1;
        $res = $this->profile_m->savePayPalDetails($genieData);

        if($res){
            $data = new stdClass();
            $mailData = array();
            $data->sent_by = $getTmpData['sent_by'];
            $data->sent_to = $getTmpData['sent_to'];
            
            if(isset($getTmpData['receipient_name']) && !empty($getTmpData['receipient_name'])){
                $data->receipient_name = $getTmpData['receipient_name'];
                $mailData['rname'] = $getTmpData['receipient_name'];
            }else{
                $data->receipient_name = '';
            }
            if(isset($getTmpData['address']) && !empty($getTmpData['address'])){
                $data->address = $getTmpData['address'];
                $mailData['raddress'] = $getTmpData['address'];
            }else{
                $data->address = '';
            }
            if(isset($getTmpData['city']) && !empty($getTmpData['city'])){
                $data->city = $getTmpData['city'];
                $mailData['rcity'] = $getTmpData['address'];
            }else{
                $data->city = '';
            }
            if(isset($getTmpData['state']) && !empty($getTmpData['state'])){
                $data->state = $getTmpData['state'];
                $mailData['rstate'] = $getTmpData['state'];
            }else{
                $data->state = '';
            }
            if(isset($getTmpData['zipcode']) && !empty($getTmpData['zipcode'])){
                $data->zipcode = $getTmpData['zipcode'];
                $mailData['rzip'] = $getTmpData['zipcode'];
            }else{
                $data->zipcode = '';
            }
            if(isset($getTmpData['country']) && !empty($getTmpData['country'])){
                $data->country = $getTmpData['country'];
                $mailData['rcountry'] = $getTmpData['country'];
            }else{
                $data->country = '';
            }
            if(isset($getTmpData['destruction_clause']) && !empty($getTmpData['destruction_clause'])){
                $data->destruction_clause = $getTmpData['destruction_clause'];
                $mailData['destruction'] = "User authorized photo lab to destroy his/her photos and data";
            }
            else{
                $mailData['destruction'] = "User wants to delivered to respected receipient";
            }


        
            $data->no_of_photos = $getTmpData['no_of_photos'];
            $data->photo_name = serialize($getTmpData['image']);                
            if(isset($getTmpData['doc']) && !empty($getTmpData['doc'])){
                $data->document = $getTmpData['doc'];
            }
            if(isset($getTmpData['message_text']) && !empty($getTmpData['message_text'])){
                $data->text_message = $getTmpData['message_text'];
            }

            if(isset($getTmpData['msg_photo']) && !empty($getTmpData['msg_photo'])){
                $data->msg_photo = serialize($getTmpData['msg_photo']);
            }
              if(isset($getTmpData['return_msg']) && !empty($getTmpData['return_msg'])){
                $data->return_msg = $getTmpData['return_msg'];
            }
             // print_r($getTmpData);die;
            $data->sent_date = date('Y-m-d H:i:s');
            $data->status = 1;
            $data->payment_id = $res;
            $data->payment_type = "genie";
            if($data->sent_by == '' || empty($data->sent_by)){
                redirect('');
            }else{
                $resp = $this->profile_m->savePhotoDetails($data);
            }
            // $resp = $this->profile_m->savePhotoDetails($data);
            // $resp = true;

            if($resp){
                    $data->from = 'photos';
                    $data->amount = $getTmpData['amount'];
                    $data->paypal_token = $order_id;
                    $data->paypal_payer_id = $requestno;
                    
                    $respData['data'] = $data;

                   
                    $Email = $this->profile_m->getUserDetails($getTmpData['sent_by']);       
                    $Email_data = $this->profile_m->getProfileDetails($getTmpData['sent_by']);       
                    $userData = $this->profile_m->getInmateDetails($getTmpData['sent_to']);
                    $franchise = $this->profile_m->getFranchiseDetails($userData[0]['facility_id']);

                    $root_path = $_SERVER['DOCUMENT_ROOT'].BASE_URI;
                    $folderName = time();
                    $folder = $root_path.'uploads/'.$folderName;
                    $zipName = 'zipfolder.zip';
                    
                    if(!empty($getTmpData['image'])){            
                        if(isset($data->document)){
                            $path = $root_path.'uploads/'.$this->current_user->user_id.'/docs/'.$data->document;
                            $this->zip->read_file($path);
                        }
                        foreach($getTmpData['image'] as $k => $v){
                            $path = $root_path.'uploads/'.$this->current_user->user_id.'/photos/'.$v;
                            if(file_exists($path)){
                                $this->zip->read_file($path);
                            }
                        }
                        $this->zip->archive('./uploads/'.$folderName.'.zip');
                    }

                    $mailData['attach'][] = 'uploads/'.$folderName.'.zip';    

                    if($Email[0]['notified_by'] == 1 || $Email[0]['notified_by'] == 3){
                        $mailData['slug'] = 'paypal-photo-template';
                        $mailData['to'] = $Email_data[0]['user_email'];
                        $mailData['first_name'] = ucfirst($Email[0]['first_name']).' '.$Email[0]['last_name'];                      
                        $mailData['email'] = ucfirst($Email[0]['email']);
                        $mailData['mobile'] = ucfirst($Email[0]['mobile']);                     
                        $mailData['country'] = ucfirst($Email[0]['country']);
                        $mailData['facility_name'] = $userData[0]['facility_name'];
                        $mailData['facility_address'] = $userData[0]['address'].', '.$userData[0]['city'].', '.$userData[0]['county'].', '.$userData[0]['state'].', '.$userData[0]['country'];
                        $mailData['inmate_name'] = $userData[0]['inmates_name'];
                        $mailData['booking_no'] = $userData[0]['inmates_booking_no'];
                        $mailData['amount'] = $getTmpData['amount'].' USD';
                        $mailData['no_of_photos'] = $getTmpData['no_of_photos'];
                        $mailData['transaction_token'] = $requestno;
                        $mailData['order_id'] = $resp;
                        $mailData['payment_mode'] = "genie";
                        $mailData['order_detail'] = base_url('genieSuccess').'?id='.$id.'&return=?'.$return;
                        $results = Events::trigger('email', $mailData, 'array');
                    }
                    
                    $mailData['slug'] = 'admin-photo-template';
                    //$mailData['to'] = "ronniecase@gmail.com";
                    $mailData['to'] = "admin@storeshere.com";                
                    $mailData['admin'] = 'Admin';
                    $mailData['first_name'] = ucfirst($Email[0]['first_name']).' '.$Email[0]['last_name'];
                    $mailData['email'] = ucfirst($Email[0]['email']);
                    $mailData['mobile'] = ucfirst($Email[0]['mobile']);                     
                    $mailData['country'] = ucfirst($Email[0]['country']);
                    $mailData['payment_mode'] = "genie";

                    $mailData['order_detail'] = base_url('genieSuccess').'?id='.$id.'&return=?'.$return;

                    $mailData['facility_name'] = $userData[0]['facility_name'];
                    $mailData['facility_address'] = $userData[0]['address'].', '.$userData[0]['city'].', '.$userData[0]['county'].', '.$userData[0]['state'].', '.$userData[0]['country'];
                    
                    $mailData['inmate_name'] = $userData[0]['inmates_name'];
                    $mailData['booking_no'] = $userData[0]['inmates_booking_no'];
                    $mailData['no_of_photos'] = $getTmpData['no_of_photos'];
                    $mailData['transaction_token'] = $requestno;
                    $mailData['order_id'] = $resp;

                    $mailData['amount'] = $getTmpData['amount'].' USD';   
                    
                    if($Email[0]['notified_by'] == 2 || $Email[0]['notified_by'] == 3) {
                        $client = get_twilio_client(); 
                        $pc = $this->db->query("select phonecode from default_country where nicename = '".$Email[0]['country']."'")->result_array();
                    
                        $mobile = '+'.$pc[0]['phonecode'].$Email[0]['mobile'];
                    
                        try {
                            $client->messages->create(
                                $mobile,
                                array(
                                    'from' => '+14088907359',
                                    'body' => 'Your order '.$resp.' for sending photos is successfully submitted and received - storeshere'
                                )
                            );
                        } catch (Exception $e) {
                            //Log::error($e->getMessage());
                            $e->getMessage();
                        }
                       
                        
                    }  
                    
                    unset($mailData['attach'][0]);
                    
                    $email_admin = Events::trigger('email',$mailData, 'array');
                    
                    if($email_admin && !empty($franchise)){                     
                        $mailData['to'] = $franchise[0]['email'];
                        $mailData['admin'] = $franchise[0]['first_name'].' '.$franchise[0]['last_name'];
                        $email_franchise = Events::trigger('email',$mailData,'array');
                    }
                    $rdata['order_id'] = $order_id;
                    $rdata['status'] = $status;
                    $rdata['requestno'] = $requestno;
                    $rdata['result'] = $result;

                    $respData['data'] = $rdata;
                    //update_genie_order($order_id,$result,$requestno,$msg,$status);

                    $this->template->build('stores/genie_response',$respData);
                }
            }
         else{
            redirect('');
        }
    }

    public function uploadPhotos_org(){
        if(!is_logged_in()){
            redirect('');
        }
        $this->load->library('payments_pro');
        $post = $this->input->post();
        $files = $_FILES;
        $id = $this->current_user->id;
        $finalData = array();
        $no_of_photos = 0;      
        $facility_info = $this->profile_m->getFacilityDetails($post['facility']);

        if(!empty($files) && isset($files['doc'])){
            $fileData = $files['doc'];
            $tmppath = $fileData['tmp_name'];
            $random_text = randomToken(5);
            $ext = strtolower(pathinfo($fileData['name'], PATHINFO_EXTENSION));
            $path = $_SERVER['DOCUMENT_ROOT'].BASE_URI.'uploads/';
            $folder_path = $path.$id.'/';
            $picPath = $folder_path.'docs/';                
            $filename = time();
            $fullfilename = $filename.'_'.$random_text.'.'.$ext;
            $filepath = $picPath.$fullfilename;         
            if(!is_dir($folder_path)){
                mkdir($folder_path);
                if(!is_dir($picPath)){
                    mkdir($picPath);
                }
            }else{
                if(!is_dir($picPath)){
                    mkdir($picPath);
                }
            }
            if(move_uploaded_file($tmppath,$filepath)){                     
                $finalData['doc'] = $fullfilename;
            }
        }

        if(!empty($post['editedphoto'])){
            foreach($post['editedphoto'] as $k => $photo){                
                if(!empty($photo)){                    
                    $file = $photo;
                    $random_text = randomToken(5);
                    $ext = 'png';
                    $path = $_SERVER['DOCUMENT_ROOT'].BASE_URI.'uploads/';
                    $folder_path = $path.$id.'/';
                    $picPath = $folder_path.'photos/';              
                    $filename = time();
                    $fullfilename = $filename.'_'.$random_text.'.'.$ext;
                    $filepath = $picPath.$fullfilename;
                    if(!is_dir($folder_path)){
                        mkdir($folder_path);
                        if(!is_dir($picPath)){
                            mkdir($picPath);
                        }
                    }else{
                        if(!is_dir($picPath)){
                            mkdir($picPath);
                        }
                    }

                    $file = trim(str_replace('[removed]', '', $file));
                    $filedata = base64_decode($file);                       
                    $handle = fopen($filepath, 'w', 0777);              
                    fwrite($handle, $filedata);
                    fclose($handle);
                    $finalData['image'][] = $fullfilename;
                    $finalData['msg_photo'][] = $post['msg'][$k];
                    $no_of_photos++;
                }
            }
        }                

        // if(!empty($files) && isset($files['photo_file'])){
        //  $photos = $files['photo_file'];         
        //  foreach($photos['name'] as $k => $v){               
        //      if(!empty($v)){
        //          $random_text = randomToken(5);
                    // $ext = strtolower(pathinfo($v, PATHINFO_EXTENSION));
                    // $path = $_SERVER['DOCUMENT_ROOT'].BASE_URI.'uploads/';
        //          $folder_path = $path.$id.'/';
                    // $picPath = $folder_path.'photos/';
                    // $filename = time();
                    // $fullfilename = $filename.'_'.$random_text.'.'.$ext;
                    // $filepath = $picPath.$fullfilename;
                    // $tmppath = $photos['tmp_name'][$k];                  
                    // if(!is_dir($folder_path)){
                    //  mkdir($folder_path);
                    //  if(!is_dir($picPath)){
                    //      mkdir($picPath);
                    //  }
                    // }else{
                    //  if(!is_dir($picPath)){
                    //      mkdir($picPath);
                    //  }
                    // }
        //          if(move_uploaded_file($tmppath,$filepath)){                     
        //              $finalData['image'][$k] = $fullfilename;
        //          }
        //          $no_of_photos++;
        //      }               
        //  }
        // }
        // $calculate_amount = ($facility_info[0]['price_per_photo']*$no_of_photos)+($facility_info[0]['shipping_charge_per_photo']*$no_of_photos);
        $calculate_amount = ($facility_info[0]['price_per_photo']*$no_of_photos)+($facility_info[0]['shipping_charge_per_photo']);
        $finalData['sent_by'] = $id;

        $finalData['sent_to'] = $post['name'];
        $finalData['no_of_photos'] = $no_of_photos;
        $finalData['sent_date'] = date('Y-m-d H:i:s');
        $finalData['status'] = 1;
        $finalData['amount'] = $calculate_amount;
        $finalData['currency_code'] = $currency_code = 'USD';
        if(isset($post['message'])){
            $finalData['message_text'] = $post['message'];
        }
        if(isset($post['messager'])){
            $finalData['return_msg'] = $post['messager'];
        }
        // print_r($finalData);die;
        $transaction_id = randomToken(15);
        $finalData['transaction_id'] = $transaction_id;
        
        $savedata = new stdClass();
        $savedata->tmp_data = serialize($finalData);
        $savedata->create_date = date('Y-m-d H:i:s');
        $savedata->refrence = 1;
     // print_r($savedata);die;
        $save_id = $this->profile_m->saveTmpData($savedata);
        // print_r($save_id);die;
        // $transaction_id = randomToken(15);
        
        $data['custom'] = $transaction_id;
        $data['return'] = base_url().'paypalSuccess/?amt='.$calculate_amount.'&id='.$save_id.'&no_of_photos='.$no_of_photos;       
        $data['cancel_return'] = base_url().'paypal_cancel';
        $data['notify_url'] = base_url().'paypal_notify';
        $data['amt'] = $calculate_amount;
        $data['currency_code'] = $currency_code;
        
        // $var = $this->payments_pro->Set_express_checkout($data);
        // return true;

        $enableSandbox = false;
        $paypalUrl = $enableSandbox ? 'https://www.sandbox.paypal.com/cgi-bin/webscr' : 'https://www.paypal.com/cgi-bin/webscr';
        // Set the PayPal account.
        $data['business'] = 'PayPal@storeshere.com'; //'dgupta.arun-facilitator@gmail.com';// 
        $data['cmd'] = '_xclick';
        $data['amount'] = $calculate_amount;
        $data['item_name']='Storeshere';
        //echo print_r($data); exit();
        
        // Build the query string from the data.
        $queryString = http_build_query($data);
    
        // Redirect to paypal IPN
        header('location:' . $paypalUrl . '?' . $queryString);
        exit();
    }

    public function payThroughGenie(){
        if(!is_logged_in()){
            redirect('');
        }
        $this->load->helper('genie-payment');
        $post = $this->input->post();
        $id = $this->current_user->id;
        $transaction_id = randomToken(15);
        $user = $this->profile_m->getProfileDetails($id);
        $cashbox = 9992588011;
        $finalAmount = $post['amount'];
        $facility_data = $this->profile_m->getFacilityDetails($post['facility']);
        $fees = $facility_data[0]['processing_fee'];
        $unit = $facility_data[0]['fee_unit'];
        
        if($unit == 1){
            // Fixed
            $finalAmount = $finalAmount + $fees;
            $data['fee'] = $fees;
            $data['unit'] = 1;
            $data['processing_fees'] = $fees;
            $data['fee'].'<br>';
            $data['unit'].'<br>';
        }else{
            // Percentage
            $percent = ($fees/100)*$finalAmount;
            $percent_explode = explode('.', $percent);
            if(isset($percent_explode[1])){
                $before_decimal = $percent_explode[0];
                $after_decimal = substr($percent_explode[1], 0,2);
                $percent = $before_decimal.'.'.$after_decimal;
            }
            $finalAmount = $finalAmount + $percent;
            $data['fee'] = $fees;
            $data['unit'] = 2;
            $data['processing_fees'] = $percent;
        }
        $data['amount'] = $finalAmount;
        $cellphone = $user[0]['mobile'];
        $email = $user[0]['user_email'];
        $firstname = $user[0]['first_name'];
        $lastname = $user[0]['last_name'];
        $country = $user[0]['country'];
        $address1 = $user[0]['street_address'];
        $city = $user[0]['city'];
        $state = $user[0]['state'];
        $zip = $user[0]['postcode'];
        $description = "this is a test description";
        $expiremin = '10';

        $data['currency_code'] = $currency_code = 'USD';
        $data['amt'] = $finalAmount;
        $data['original_amount'] = $post['amount'];     
        $data['inmate_id'] = $post['name'];
        $data['user_id'] = $id;
        $data['transaction_id'] = $transaction_id;  

        $savedata = new stdClass();
        $savedata->tmp_data = serialize($data);
        $savedata->create_date = date('Y-m-d H:i:s');
        $savedata->refrence = 1;

        $save_id = $this->profile_m->saveTmpData($savedata);
        $return_url = base_url()."genieSuccess?id=".$save_id."%26return=";

        $param = "cashbox=$cashbox&amount=$finalAmount&orderid=$transaction_id&cellphone=$cellphone&email=$email&firstname=$firstname&lastname=$lastname&company=belllabs&country=$country&address1=$address1&address2=$address1&city=$city&state=$state&zip=$zip&description=$description&expiremin=$expiremin&ReturnURL=$return_url";

        $enc_url = encrypt_pol($param);

        redirect('https://geniecashbox.com/pol/?'.$enc_url);
    }

    public function genieSuccess (){
        date_default_timezone_set("America/New_York");
        $this->load->helper('genie-payment');
        
        //parse_str(substr(strrchr($_SERVER['REQUEST_URI'], "?"), 1), $_GET);
        $code = $_GET;
        
        $return = $code['return'];
        $return = substr($return, 1);

        $id = $code['id'];

        $var = decrypt_pol(substr($return,0));
        
        $value              = explode('&',$var);   

        // Get Order ID
        $order              = explode('=',$value[0]); 
        $order_id           = $order[1];

        // Get Order Status 
        $status_detail      = explode('=',$value[1]); 
        $status             = $status_detail[1];


        // Request No 
        $requestno_detail   = explode('=',$value[3]); 
        $requestno          = $requestno_detail[1];

        // Transaction Result 0 for success
        $result_detail      = explode('=',$value[4]); 
        $result             = $result_detail[1];        

        // Retured Message
        $msg_detail         = explode('=',$value[5]); 
        $msg            = $msg_detail[1];
        
        $getTmpData = $this->profile_m->getTmpData($id);        
        $getTmpData = unserialize($getTmpData[0]['tmp_data']);  

        $genieData = new stdClass();
        $genieData->token = $order_id;      
        $genieData->payer_id = $requestno;
        $genieData->amount = $getTmpData['amt'];
        $genieData->currency_code = 'USD';
        $genieData->payment_date = date('Y-m-d H:i:s');
        $genieData->payment_status = 1;
        $res = $this->profile_m->savePayPalDetails($genieData);

        if($res){
                $data = new stdClass();                     
                $data->paid_by = $getTmpData['user_id'];
                $data->paid_to = $getTmpData['inmate_id'];
                $data->sent_date = date('Y-m-d H:i:s');
                $data->status = 1;
                $data->payment_id = $res;
                $data->fee = $getTmpData['fee'];
                $data->unit = $getTmpData['unit'];
                $data->original_amount = $getTmpData['original_amount'];
                $data->processing_fees = $getTmpData['processing_fees'];
                $data->payment_type = "genie";
                $resp = $this->profile_m->saveFundDetails($data);
                // $resp = true;
                if($resp){
                    $data->from = 'funds';
                    $data->amount = $getTmpData['amt'];
                    $data->paypal_token = $order_id;
                    $data->paypal_payer_id = $requestno;
                    $respData['data'] = $data;  
                    
                    $Email = $this->profile_m->getUserDetails($getTmpData['user_id']);
                    $Email_data = $this->profile_m->getProfileDetails($getTmpData['user_id']);
                    // $Email = $this->profile_m->getUserDetails(22);
                    $userData = $this->profile_m->getInmateDetails($getTmpData['inmate_id']);
                    $franchise = $this->profile_m->getFranchiseDetails($userData[0]['facility_id']);
                    
                    $mailData = array();
                    if($Email[0]['notified_by'] == 1 || $Email[0]['notified_by'] == 3){                     
                        $mailData['slug'] = 'paypal-fund-template';
                            $mailData['to'] = $Email_data[0]['user_email'];
                            $mailData['first_name'] = ucfirst($Email[0]['first_name']).' '.$Email[0]['last_name'];                      
                            $mailData['facility_name'] = $userData[0]['facility_name'];
                            $mailData['facility_address'] = $userData[0]['address'].', '.$userData[0]['city'].', '.$userData[0]['county'].', '.$userData[0]['state'].', '.$userData[0]['country'];
                            $mailData['inmate_name'] = $userData[0]['inmates_name'];
                            $mailData['booking_no'] = $userData[0]['inmates_booking_no'];
                            $mailData['amount_transfered'] = $getTmpData['original_amount'].' USD';
                            $mailData['fee'] = $getTmpData['processing_fees'].' USD';
                            $mailData['amount'] = $getTmpData['amt'].' USD';
                            $mailData['order_id'] = $resp; 
                            $mailData['payment_mode'] = "genie"; 
                            $mailData['email'] = ucfirst($Email[0]['email']);
                            $mailData['mobile'] = ucfirst($Email[0]['mobile']);
                            $mailData['country'] = ucfirst($Email[0]['country']);
                            $mailData['transaction_token'] = $requestno;
                            $mailData['order_detail'] = base_url('genieSuccess').'?id='.$id.'&return=?'.$return;
                        $results = Events::trigger('email', $mailData, 'array');
                    }
                    
                    $mailData['slug'] = 'admin-fund-template';
                    $mailData['to'] = Settings::get('contact_email');                       
                    $mailData['admin'] = 'Admin';
                    $mailData['first_name'] = ucfirst($Email[0]['first_name']).' '.$Email[0]['last_name'];                      
                    $mailData['facility_name'] = $userData[0]['facility_name'];
                    $mailData['facility_address'] = $userData[0]['address'].', '.$userData[0]['city'].', '.$userData[0]['county'].', '.$userData[0]['state'].', '.$userData[0]['country'];
                    $mailData['inmate_name'] = $userData[0]['inmates_name'];
                    $mailData['booking_no'] = $userData[0]['inmates_booking_no'];                       
                    $mailData['amount_transfered'] = $getTmpData['original_amount'].' USD';
                    $mailData['fee'] = $getTmpData['processing_fees'].' USD';
                    $mailData['amount'] = $getTmpData['amt'].' USD';
                    $mailData['payment_mode'] = "genie"; 
                    $mailData['email'] = ucfirst($Email[0]['email']);
                    $mailData['mobile'] = ucfirst($Email[0]['mobile']);
                    $mailData['country'] = ucfirst($Email[0]['country']);
                    $mailData['transaction_token'] = $requestno;
                    $mailData['order_detail'] = base_url('genieSuccess').'?id='.$id.'&return=?'.$return;
                    
                    if($Email[0]['notified_by'] == 2 || $Email[0]['notified_by'] == 3) {
                        $client = get_twilio_client(); 
                        $pc = $this->db->query("select phonecode from default_country where nicename = '".$Email[0]['country']."'")->result_array();
                    
                        $mobile = '+'.$pc[0]['phonecode'].$Email[0]['mobile'];
                    
                        try {
                            $client->messages->create(
                                $mobile,
                                array(
                                    'from' => '+14088907359',
                                    'body' => 'Your order '.$resp.' for sending photos is successfully submitted and received - storeshere'
                                )
                            );
                        } catch (Exception $e) {
                            //Log::error($e->getMessage());
                            $e->getMessage();
                        }
                    }  
    
                    
                    $email_admin = Events::trigger('email',$mailData, 'array');
                    if($email_admin && !empty($franchise)){                     
                        $mailData['to'] = $franchise[0]['email'];
                        $mailData['admin'] = $franchise[0]['first_name'].' '.$franchise[0]['last_name'];
                        $email_franchise = Events::trigger('email',$mailData,'array');
                    }
                    $rdata['order_id'] = $order_id;
                    $rdata['status'] = $status;
                    $rdata['requestno'] = $requestno;
                    $rdata['result'] = $result;

                    $respData['data'] = $rdata;
                    //update_genie_order($order_id,$result,$requestno,$msg,$status);

                    $this->template->build('stores/genie_response',$respData);
                }
            }
        else{
            redirect('');
        }
    }

    public function payThroughPaypal(){   
        if(!is_logged_in()){
            redirect('');
        }
        $post = $this->input->post();   
        $id = $this->current_user->id;
        $transaction_id = randomToken(15);
        $finalAmount = $post['amount'];
        $facility_data = $this->profile_m->getFacilityDetails($post['facility']);
        $fees = $facility_data[0]['processing_fee'];
        $unit = $facility_data[0]['fee_unit'];
        if($unit == 1){
            // Fixed
            $finalAmount = $finalAmount + $fees;
            $data['fee'] = $fees;
            $data['unit'] = 1;
            $data['processing_fees'] = $fees;
        }else{
            // Percentage
            $percent = ($fees/100)*$finalAmount;
            $percent_explode = explode('.', $percent);
            if(isset($percent_explode[1])){
                $before_decimal = $percent_explode[0];
                $after_decimal = substr($percent_explode[1], 0,2);
                $percent = $before_decimal.'.'.$after_decimal;
            }
            $finalAmount = $finalAmount + $percent;
            $data['fee'] = $fees;
            $data['unit'] = 2;
            $data['processing_fees'] = $percent;
        }       
        $data['currency_code'] = $currency_code = 'USD';
        $data['amt'] = $finalAmount;
        $data['original_amount'] = $post['amount'];     
        $data['inmate_id'] = $post['name'];
        $Inmdet = $this->profile_m->getInmatedd($data['inmate_id']);
        $data['user_id'] = $id;
        $data['transaction_id'] = $transaction_id;      
        
        $savedata = new stdClass();
        $savedata->tmp_data = serialize($data);
        $savedata->create_date = date('Y-m-d H:i:s');
        $savedata->refrence = 1;

        $save_id = $this->profile_m->saveTmpData($savedata);
        $data['return'] = base_url().'paypal_success/?amt='.$finalAmount.'&id='.$save_id;
        $data['cancel_return'] = base_url().'paypal_cancel'; 
        $data['notify_url'] = base_url().'paypal_notify';
        $data['custom'] = $transaction_id;//randomToken(15)
        // $var = $this->payments_pro->Set_express_checkout($data);

        // return true;  
        $enableSandbox = false;
        $paypalUrl = $enableSandbox ? 'https://www.sandbox.paypal.com/cgi-bin/webscr' : 'https://www.paypal.com/cgi-bin/webscr';
        // $paypalUrl = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
        // Set the PayPal account.
        $data['business'] = 'PayPal@storeshere.com';
        $data['cmd'] = '_xclick';
        $data['amount'] = $finalAmount;
        $data['item_name']= $Inmdet[0]['inmates_name'].' '.$Inmdet[0]['inmates_middle_name'].' '.$Inmdet[0]['inmates_last_name']. " : ". $Inmdet[0]['inmates_booking_no'];
        $queryString = http_build_query($data);
    
        // Redirect to paypal IPN
        header('location:' . $paypalUrl . '?' . $queryString);
        exit();
    }
    
    public function payThroughPaypal_old(){   
        if(!is_logged_in()){
            redirect('');
        }
        $this->load->library('payments_pro');
        $post = $this->input->post();   
        //   print_r($post); echo "rajat"; die;
        $id = $this->current_user->id;
        $transaction_id = randomToken(15);
        $finalAmount = $post['amount'];
        $facility_data = $this->profile_m->getFacilityDetails($post['facility']);
        // print_r($facility_data);die;
        $fees = $facility_data[0]['processing_fee'];
        $unit = $facility_data[0]['fee_unit'];
        if($unit == 1){
            // Fixed
            $finalAmount = $finalAmount + $fees;
            $data['fee'] = $fees;
            $data['unit'] = 1;
            $data['processing_fees'] = $fees;
        }else{
            // Percentage
            $percent = ($fees/100)*$finalAmount;
            $percent_explode = explode('.', $percent);
            if(isset($percent_explode[1])){
                $before_decimal = $percent_explode[0];
                $after_decimal = substr($percent_explode[1], 0,2);
                $percent = $before_decimal.'.'.$after_decimal;
            }
            $finalAmount = $finalAmount + $percent;
            $data['fee'] = $fees;
            $data['unit'] = 2;
            $data['processing_fees'] = $percent;
        }       
        $data['currency_code'] = $currency_code = 'USD';
        $data['amt'] = $finalAmount;
        $data['original_amount'] = $post['amount'];     
        $data['inmate_id'] = $post['name'];
        $data['user_id'] = $id;
        $data['transaction_id'] = $transaction_id;      
        
        $savedata = new stdClass();
        $savedata->tmp_data = serialize($data);
        $savedata->create_date = date('Y-m-d H:i:s');
        $savedata->refrence = 1;

        $save_id = $this->profile_m->saveTmpData($savedata);
        $data['return_url'] = base_url().'paypal_success/?amt='.$finalAmount.'&id='.$save_id;
        $data['cancel_url'] = base_url().'paypal_cancel';       
        $var = $this->payments_pro->Set_express_checkout($data);

        return true;        
    }



public function paypalSuccess(){  
    date_default_timezone_set("America/New_York");
    if(!is_logged_in()){
        redirect('');
    }
    $this->load->library('zip');    
    $request = $_GET;

    $id = $request['id'];       
    $getTmpData = $this->profile_m->getTmpData($id);        
    $getTmpData = unserialize($getTmpData[0]['tmp_data']);
    $custom = $getTmpData['transaction_id'];
    
    $paymentData = $this->profile_m->getPayPalDetails($custom);
    while(!isset($paymentData[0])){
        sleep(1);
        $paymentData = $this->profile_m->getPayPalDetails($custom);
    }
    if(!isset($paymentData[0]))
    {
        $mdata = new stdClass();
        $mdata->meurl = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $rtryData['data'] = $mdata;
        $this->template->build('stores/waitretry',$rtryData);
    }
    else
    {
        $paymentData = $paymentData[0];  
    
        $res = $paymentData['id'];
        $txnid = $paymentData['token'];
        $payer_id = $paymentData['payer_id'];

    if(isset($request['lvisit']) && $request['lvisit'] == 1){
        $data = new stdClass();
        $data->id = $request['id'];
        $data->amount = $request['amt'];
        $data->paypal_token = $txnid;
        $data->paypal_payer_id = $payer_id;
        $data->from = 'photos';
        $data->no_of_photos = $request['no_of_photos'];
        $respData['data'] = $data;
        
        $this->template->build('stores/paypalsuccess',$respData);
    }
    else{
        if(isset($request['id']) && !empty($request['id'])){  

            if($res){
                $data = new stdClass();
                $mailData = array();
                $data->sent_by = $getTmpData['sent_by'];
                $data->sent_to = $getTmpData['sent_to'];
                
                if(isset($getTmpData['receipient_name']) && !empty($getTmpData['receipient_name'])){
                $data->receipient_name = $getTmpData['receipient_name'];
                
                $mailData['rname'] = $getTmpData['receipient_name'];
            }else{
                $data->receipient_name = '';
            }
            if(isset($getTmpData['address']) && !empty($getTmpData['address'])){
                $data->address = $getTmpData['address'];
                $mailData['raddress'] = $getTmpData['address'];
            }else{
                $data->address = '';
            }
            if(isset($getTmpData['city']) && !empty($getTmpData['city'])){
                $data->city = $getTmpData['city'];
                $mailData['rcity'] = $getTmpData['address'];
            }else{
                $data->city = '';
            }
            if(isset($getTmpData['state']) && !empty($getTmpData['state'])){
                $data->state = $getTmpData['state'];
                $mailData['rstate'] = $getTmpData['state'];
            }else{
                $data->state = '';
            }
            if(isset($getTmpData['zipcode']) && !empty($getTmpData['zipcode'])){
                $data->zipcode = $getTmpData['zipcode'];
                $mailData['rzip'] = $getTmpData['zipcode'];
            }else{
                $data->zipcode = '';
            }
            if(isset($getTmpData['country']) && !empty($getTmpData['country'])){
                $data->country = $getTmpData['country'];
                $mailData['rcountry'] = $getTmpData['country'];
            }else{
                $data->country = '';
            }
            if(isset($getTmpData['destruction_clause']) && !empty($getTmpData['destruction_clause'])){
                $data->destruction_clause = $getTmpData['destruction_clause'];
                $mailData['destruction'] = "User authorized photo lab to destroy his/her photos and data";
            }
            else{
                $mailData['destruction'] = "User wants to delivered to respected receipient";
            }


                $data->no_of_photos = $getTmpData['no_of_photos'];
                $data->photo_name = serialize($getTmpData['image']);

                if(isset($getTmpData['doc']) && !empty($getTmpData['doc'])){
                    $data->document = $getTmpData['doc'];
                    $mailData['message'] = "Inside the document in attached zip";
                }
                if(isset($getTmpData['message_text']) && !empty($getTmpData['message_text'])){
                    $data->text_message = $getTmpData['message_text'];
                    $mailData['message'] = $getTmpData['message_text'];
                }

                if(isset($getTmpData['msg_photo']) && !empty($getTmpData['msg_photo'])){
                    $data->msg_photo = serialize($getTmpData['msg_photo']);
                }
                  if(isset($getTmpData['return_msg']) && !empty($getTmpData['return_msg'])){
                    $data->return_msg = $getTmpData['return_msg'];
                }
                
                $data->sent_date = date('Y-m-d H:i:s');
                $data->status = 1;
                $data->payment_id = $res;
                $data->payment_type = "paypal";
                if($data->sent_by == '' || empty($data->sent_by)){
                    redirect('');
                }else{
                    $resp = $this->profile_m->savePhotoDetails($data);
                }
                
                if($resp){
                    $data->from = 'photos';
                    $data->amount = $getTmpData['amount'];
                    $data->paypal_token = $txnid;
                    $data->paypal_payer_id = $payer_id;
                    $respData['data'] = $data;
                    $data->order_id = $resp;
                    
                    $Email = $this->profile_m->getUserDetails($getTmpData['sent_by']); 
                    $data->sentby = ucfirst($Email[0]['email']);
                    $data->fname  = ucfirst($Email[0]['first_name']);
                    $data->lname  = ucfirst($Email[0]['last_name']);
                    $Inmdet = $this->profile_m->getInmatedd($getTmpData['sent_to']);
                    $data->sentto = $Inmdet[0]['inmates_name'].' '.$Inmdet[0]['inmates_middle_name'].' '.$Inmdet[0]['inmates_last_name'];
                    $Email_data = $this->profile_m->getProfileDetails($getTmpData['sent_by']);       
                    $userData = $this->profile_m->getInmateDetails($getTmpData['sent_to']);
                    $franchise = $this->profile_m->getFranchiseDetails($userData[0]['facility_id']);          

                    $root_path = $_SERVER['DOCUMENT_ROOT'].BASE_URI;
                    $folderName = time();
                    $folder = $root_path.'uploads/'.$folderName;
                    $zipName = 'zipfolder.zip';
                    $zipPath = 'https://www.storeshere.com/uploads/'.$folderName.'.zip';

                    if(!empty($getTmpData['image'])){            
                        if(isset($data->document)){
                            $path = $root_path.'uploads/'.$this->current_user->user_id.'/docs/'.$data->document;
                            $this->zip->read_file($path);
                        }
                        foreach($getTmpData['image'] as $k => $v){
                            $path = $root_path.'uploads/'.$this->current_user->user_id.'/photos/'.$v;
                            if(file_exists($path)){
                                $this->zip->read_file($path);
                            }
                        }
                        $this->zip->archive('./uploads/'.$folderName.'.zip');
                    }       
                    $mailData['attach'][] = 'uploads/'.$folderName.'.zip';
                    if($Email[0]['notified_by'] == 1 || $Email[0]['notified_by'] == 3){

                        $mailData['slug'] = 'paypal-photo-template';
                        $mailData['to'] = $Email_data[0]['user_email'];
                        $mailData['first_name'] = ucfirst($Email[0]['first_name']).' '.$Email[0]['last_name'];                      
                        $mailData['facility_name'] = $userData[0]['facility_name'];
                        $mailData['facility_address'] = $userData[0]['address'].', '.$userData[0]['city'].', '.$userData[0]['county'].', '.$userData[0]['state'].', '.$userData[0]['country'];
                        $mailData['email'] = ucfirst($Email[0]['email']);
                        $mailData['mobile'] = ucfirst($Email[0]['mobile']);                     
                        $mailData['country'] = ucfirst($Email[0]['country']);
                        $mailData['inmate_name'] = $userData[0]['inmates_name'].' '.$userData[0]['inmates_middle_name'].' '.$userData[0]['inmates_last_name'];
                        $mailData['booking_no'] = $userData[0]['inmates_booking_no'];
                        $mailData['no_of_photos'] = $payer_id;
                        $mailData['amount'] = $getTmpData['amount'].' USD';
                        $mailData['no_of_photos'] = $getTmpData['no_of_photos'];
                        $mailData['transaction_token'] = $txnid;
                        $mailData['order_id'] = $resp;
                        $mailData['payment_mode'] = "paypal";
                        $mailData['order_detail'] = base_url('paypalSuccess').'?amt='.$getTmpData['amount'].'&id='.$request['id'].'&token='.$txnid.'&PayerID='.$payer_id."&no_of_photos=".$getTmpData['no_of_photos']."&lvisit=1";
                        try{
                            $results = Events::trigger('email', $mailData, 'array');
                        }
                        catch(Exception $e) {
                          echo 'Mail Error Message: ' .$e->getMessage();
                          unset($mailData['attach']);
                          $results = Events::trigger('email', $mailData, 'array');
                          
                        }
                    }
                    $mailData['slug'] = 'admin-photo-template';
                    $mailData['to'] = "photolab@storeshere.com, admin@storeshere.com";
                    $mailData['admin'] = 'Admin';
                    $mailData['first_name'] = ucfirst($Email[0]['first_name']).' '.$Email[0]['last_name'];
                    $mailData['email'] = ucfirst($Email[0]['email']);
                    $mailData['mobile'] = ucfirst($Email[0]['mobile']);                     
                    $mailData['country'] = ucfirst($Email[0]['country']);
                    $mailData['payment_mode'] = "paypal";

                    $mailData['order_detail'] = base_url('paypalSuccess').'?amt='.$getTmpData['amount'].'&id='.$request['id'].'&token='.$txnid.'&PayerID='.$payer_id."&no_of_photos=".$getTmpData['no_of_photos']."&lvisit=1";

                    $mailData['facility_name'] = $userData[0]['facility_name'];
                    $mailData['facility_address'] = $userData[0]['address'].', '.$userData[0]['city'].', '.$userData[0]['county'].', '.$userData[0]['state'].', '.$userData[0]['country'];

                    $mailData['inmate_name'] = $userData[0]['inmates_name'].' '.$userData[0]['inmates_middle_name'].' '.$userData[0]['inmates_last_name'];
                    $mailData['booking_no'] = $userData[0]['inmates_booking_no'];
                    $mailData['no_of_photos'] = $getTmpData['no_of_photos'];
                    $mailData['transaction_token'] = $txnid;
                    $mailData['order_id'] = $resp;

                    $mailData['amount'] = $getTmpData['amount'].' USD'; 
                    
                    unset($mailData['attach']);
                    
                    $mailData['zipPath'] = $zipPath; //zipPath Added by R.S 2019-06-21

                    $email_admin = Events::trigger('email',$mailData, 'array');
                    if($Email[0]['notified_by'] == 2 || $Email[0]['notified_by'] == 3) {
                        $client = get_twilio_client(); 
                        $pc = $this->db->query("select phonecode from default_country where nicename = '".$Email[0]['country']."'")->result_array();
                    
                        $mobile = '+'.$pc[0]['phonecode'].$Email[0]['mobile'];
                    
                        try {
                            $client->messages->create(
                                $mobile,
                                array(
                                    'from' => '+14088907359',
                                    'body' => 'Your order '.$resp.' for sending photos is successfully submitted and received - storeshere'
                                )
                            );
                        } catch (Exception $e) {
                            //Log::error($e->getMessage());
                            $e->getMessage();
                        }
                        
                    }  

                    if($email_admin && !empty($franchise)){                     
                        $mailData['to'] = $franchise[0]['email'];
                        $mailData['admin'] = $franchise[0]['first_name'].' '.$franchise[0]['last_name'];
                        $email_franchise = Events::trigger('email', $mailData,'array');
                    }
                    //$this->emailZip($resp);
                    $this->template->build('stores/paypalsuccess',$respData);
                }               
            }   
        }else{
            redirect('');
        }
    }
    }
    
}

public function paypalSuccess_old(){   
        date_default_timezone_set("America/New_York");
        if(!is_logged_in()){
            redirect('');
        }
        
        $this->load->library('zip');    
        $request = $_GET;

        if(isset($request['lvisit']) && $request['lvisit'] == 1){
            $data = new stdClass();
            $data->id = $request['id'];
            $data->amount = $request['amt'];
            $data->paypal_token = $request['token'];
            $data->paypal_payer_id = $request['PayerID'];
            $data->from = 'photos';
            $data->no_of_photos = $request['no_of_photos'];
            $respData['data'] = $data;
            
            $this->template->build('stores/paypalsuccess',$respData);
        }
        else{
        // print_r($request);die;
        // echo "string";die;
            // $request['id'] = 13;
            // $request['token'] = '13aasdsada';
            // $request['PayerID'] = '13sdfasdsada';
        if(isset($request['id']) && !empty($request['id'])){
            $id = $request['id'];
            $getTmpData = $this->profile_m->getTmpData($id);        
            $getTmpData = unserialize($getTmpData[0]['tmp_data']);  

            $paypalData = new stdClass();
            $paypalData->token = $request['token'];     
            $paypalData->payer_id = $request['PayerID'];
            $paypalData->amount = $getTmpData['amount'];
            $paypalData->currency_code = 'USD';
            $paypalData->payment_date = date('Y-m-d H:i:s');
            $paypalData->payment_status = 1;
            $res = $this->profile_m->savePayPalDetails($paypalData);
            // $res = 10;       

            if($res){
                $data = new stdClass();
                $mailData = array();
                $data->sent_by = $getTmpData['sent_by'];
                $data->sent_to = $getTmpData['sent_to'];
                
                if(isset($getTmpData['receipient_name']) && !empty($getTmpData['receipient_name'])){
                $data->receipient_name = $getTmpData['receipient_name'];
                
                $mailData['rname'] = $getTmpData['receipient_name'];
                }else{
                    $data->receipient_name = '';
                }
                if(isset($getTmpData['address']) && !empty($getTmpData['address'])){
                    $data->address = $getTmpData['address'];
                    $mailData['raddress'] = $getTmpData['address'];
                }else{
                    $data->address = '';
                }
                if(isset($getTmpData['city']) && !empty($getTmpData['city'])){
                    $data->city = $getTmpData['city'];
                    $mailData['rcity'] = $getTmpData['address'];
                }else{
                    $data->city = '';
                }
                if(isset($getTmpData['state']) && !empty($getTmpData['state'])){
                    $data->state = $getTmpData['state'];
                    $mailData['rstate'] = $getTmpData['state'];
                }else{
                    $data->state = '';
                }
                if(isset($getTmpData['zipcode']) && !empty($getTmpData['zipcode'])){
                    $data->zipcode = $getTmpData['zipcode'];
                    $mailData['rzip'] = $getTmpData['zipcode'];
                }else{
                    $data->zipcode = '';
                }
                if(isset($getTmpData['country']) && !empty($getTmpData['country'])){
                    $data->country = $getTmpData['country'];
                    $mailData['rcountry'] = $getTmpData['country'];
                }else{
                    $data->country = '';
                }
                if(isset($getTmpData['destruction_clause']) && !empty($getTmpData['destruction_clause'])){
                    $data->destruction_clause = $getTmpData['destruction_clause'];
                    $mailData['destruction'] = "User authorized photo lab to destroy his/her photos and data";
                }
                else{
                    $mailData['destruction'] = "User wants to delivered to respected receipient";
                }


                $data->no_of_photos = $getTmpData['no_of_photos'];
                $data->photo_name = serialize($getTmpData['image']);

                if(isset($getTmpData['doc']) && !empty($getTmpData['doc'])){
                    $data->document = $getTmpData['doc'];
                    $mailData['message'] = "Inside the document in attached zip";
                }
                if(isset($getTmpData['message_text']) && !empty($getTmpData['message_text'])){
                    $data->text_message = $getTmpData['message_text'];
                    $mailData['message'] = $getTmpData['message_text'];
                }

                if(isset($getTmpData['msg_photo']) && !empty($getTmpData['msg_photo'])){
                    $data->msg_photo = serialize($getTmpData['msg_photo']);
                }
                  if(isset($getTmpData['return_msg']) && !empty($getTmpData['return_msg'])){
                    $data->return_msg = $getTmpData['return_msg'];
                }
                 // print_r($getTmpData);die;
                $data->sent_date = date('Y-m-d H:i:s');
                $data->status = 1;
                $data->payment_id = $res;
                $data->payment_type = "paypal";
                if($data->sent_by == '' || empty($data->sent_by)){
                    redirect('');
                }else{
                    $resp = $this->profile_m->savePhotoDetails($data);
                }
                // $resp = $this->profile_m->savePhotoDetails($data);
                // $resp = true;
                
                if($resp){
                    $data->from = 'photos';
                    $data->amount = $getTmpData['amount'];
                    $data->paypal_token = $request['token'];
                    $data->paypal_payer_id = $request['PayerID'];
                    $respData['data'] = $data;
                    $data->order_id = $resp;
                    
                    $Email = $this->profile_m->getUserDetails($getTmpData['sent_by']); 
                    $data->sentby = ucfirst($Email[0]['email']);
                    $data->fname  = ucfirst($Email[0]['first_name']);
                    $data->lname  = ucfirst($Email[0]['last_name']);
                    $Inmdet = $this->profile_m->getInmatedd($getTmpData['sent_to']);
                    $data->sentto = $Inmdet[0]['inmates_name'];
                    $Email_data = $this->profile_m->getProfileDetails($getTmpData['sent_by']);       
                    $userData = $this->profile_m->getInmateDetails($getTmpData['sent_to']);
                    $franchise = $this->profile_m->getFranchiseDetails($userData[0]['facility_id']);          

                    $root_path = $_SERVER['DOCUMENT_ROOT'].BASE_URI;
                    $folderName = time();
                    $folder = $root_path.'uploads/'.$folderName;
                    $zipName = 'zipfolder.zip';
                    
                    if(!empty($getTmpData['image'])){            
                        if(isset($data->document)){
                            $path = $root_path.'uploads/'.$this->current_user->user_id.'/docs/'.$data->document;
                            $this->zip->read_file($path);
                        }
                        foreach($getTmpData['image'] as $k => $v){
                            $path = $root_path.'uploads/'.$this->current_user->user_id.'/photos/'.$v;
                            if(file_exists($path)){
                                $this->zip->read_file($path);
                            }
                        }
                        $this->zip->archive('./uploads/'.$folderName.'.zip');
                    }       
                    $mailData['attach'][] = 'uploads/'.$folderName.'.zip';
                    if($Email[0]['notified_by'] == 1 || $Email[0]['notified_by'] == 3){

                        $mailData['slug'] = 'paypal-photo-template';
                        $mailData['to'] = $Email_data[0]['user_email'];
                        $mailData['first_name'] = ucfirst($Email[0]['first_name']).' '.$Email[0]['last_name'];                      
                        $mailData['facility_name'] = $userData[0]['facility_name'];
                        $mailData['facility_address'] = $userData[0]['address'].', '.$userData[0]['city'].', '.$userData[0]['county'].', '.$userData[0]['state'].', '.$userData[0]['country'];
                        $mailData['email'] = ucfirst($Email[0]['email']);
                        $mailData['mobile'] = ucfirst($Email[0]['mobile']);                     
                        $mailData['country'] = ucfirst($Email[0]['country']);
                        $mailData['inmate_name'] = $userData[0]['inmates_name'];
                        $mailData['booking_no'] = $userData[0]['inmates_booking_no'];
                        $mailData['no_of_photos'] = $request['PayerID'];
                        $mailData['amount'] = $getTmpData['amount'].' USD';
                        $mailData['no_of_photos'] = $getTmpData['no_of_photos'];
                        $mailData['transaction_token'] = $request['token'];
                        $mailData['order_id'] = $resp;
                        $mailData['payment_mode'] = "paypal";
                        $mailData['order_detail'] = base_url('paypalSuccess').'?amt='.$getTmpData['amount'].'&id='.$request['id'].'&token='.$request['token'].'&PayerID='.$request['PayerID']."&no_of_photos=".$getTmpData['no_of_photos']."&lvisit=1";
                        $results = Events::trigger('email', $mailData, 'array');
                    }
                    $mailData['slug'] = 'admin-photo-template';
                    //$mailData['to'] = "ronniecase@gmail.com";
                    $mailData['to'] = "admin@storeshere.com";
                    $mailData['admin'] = 'Admin';
                    $mailData['first_name'] = ucfirst($Email[0]['first_name']).' '.$Email[0]['last_name'];
                    $mailData['email'] = ucfirst($Email[0]['email']);
                    $mailData['mobile'] = ucfirst($Email[0]['mobile']);                     
                    $mailData['country'] = ucfirst($Email[0]['country']);
                    $mailData['payment_mode'] = "paypal";

                    $mailData['order_detail'] = base_url('paypalSuccess').'?amt='.$getTmpData['amount'].'&id='.$request['id'].'&token='.$request['token'].'&PayerID='.$request['PayerID']."&no_of_photos=".$getTmpData['no_of_photos']."&lvisit=1";

                    $mailData['facility_name'] = $userData[0]['facility_name'];
                    $mailData['facility_address'] = $userData[0]['address'].', '.$userData[0]['city'].', '.$userData[0]['county'].', '.$userData[0]['state'].', '.$userData[0]['country'];

                    $mailData['inmate_name'] = $userData[0]['inmates_name'];
                    $mailData['booking_no'] = $userData[0]['inmates_booking_no'];
                    $mailData['no_of_photos'] = $getTmpData['no_of_photos'];
                    $mailData['transaction_token'] = $request['token'];
                    $mailData['order_id'] = $resp;

                    $mailData['amount'] = $getTmpData['amount'].' USD'; 
                    
                    unset($mailData['attach'][0]);
                    
                    $email_admin = Events::trigger('email',$mailData, 'array');
                    if($Email[0]['notified_by'] == 2 || $Email[0]['notified_by'] == 3) {
                        $client = get_twilio_client(); 
                        $pc = $this->db->query("select phonecode from default_country where nicename = '".$Email[0]['country']."'")->result_array();
                    
                        $mobile = '+'.$pc[0]['phonecode'].$Email[0]['mobile'];
                    
                        try {
                            $client->messages->create(
                                $mobile,
                                array(
                                    'from' => '+14088907359',
                                    'body' => 'Your order '.$resp.' for sending photos is successfully submitted and received - storeshere'
                                )
                            );
                        } catch (Exception $e) {
                            //Log::error($e->getMessage());
                            $e->getMessage();
                        }
                        
                    }  

                    if($email_admin && !empty($franchise)){                     
                        $mailData['to'] = $franchise[0]['email'];
                        $mailData['admin'] = $franchise[0]['first_name'].' '.$franchise[0]['last_name'];
                        // $email_franchise = Events::trigger('email',$mailData,'array');
                    }
                    //$this->emailZip($resp);
                    $this->template->build('stores/paypalsuccess',$respData);
                }               
            }   
        }else{
            redirect('');
        }
    }
}
    public function emailZip($id){          
        $this->load->library('zip');        
        $images = $this->profile_m->getImages($id);
        $info = $this->profile_m->getDetails($id);              
        $email = $info[0]['photo_lab_email'];       

        $root_path = $_SERVER['DOCUMENT_ROOT'].BASE_URI;
        $folderName = time();
        $folder = $root_path.'uploads/'.$folderName;
        $zipName = 'zipfolder.zip';
        $textFile = 'Info.txt';     
        $message_text = $info;
        $text = '';
        $text .= "User Name : ".$info[0]['user_name'].PHP_EOL;
        $text .= "Inmate Name : ".$info[0]['inmates_name'].PHP_EOL;
        $text .= "Facility Name : ".$info[0]['facility_name'].PHP_EOL;
        $text .= "No of Photos : ".$info[0]['no_of_photos'].PHP_EOL;
        $text .= "Inmates No.  :".$info[0]['inmates_booking_no'].PHP_EOL;       
        $text .= "Receipient_name  :".$info[0]['receipient_name'].PHP_EOL;       
        $text .= "Address : ".$info[0]['address'].$info[0]['city'].$info[0]['state'].$info[0]['country'].$info[0]['zip_code'];
        if(!empty($images)){            
            $data = unserialize($images[0]['photo_name']);
            $text_msg = unserialize($images[0]['msg_photo']);
            foreach($data as $k => $v){
                $path = $root_path.'uploads/'.$images[0]['sent_by'].'/photos/'.$v;              
                if(file_exists($path)){
                    $text .=" Photo Name : ".$v." Message :".$text_msg[$k];                    
                    $this->zip->read_file($path);                   
                }
            }
            $this->zip->add_data($textFile,$text);
            $this->zip->archive('./uploads/'.$folderName.'.zip');
        }       
        $mailData['slug'] = 'email-photos-to-lab';
        $mailData['to'] = $email;
        $mailData['attach'][] = './uploads/'.$folderName.'.zip';
        $results = Events::trigger('email', $mailData, 'array');
        return true;
    }
    
    public function paypal_success(){
        date_default_timezone_set("America/New_York");
        $request = $_GET;       
        
        $id = $request['id'];       
        $getTmpData = $this->profile_m->getTmpData($id); 
        $getTmpData = unserialize($getTmpData[0]['tmp_data']);
        $custom = $getTmpData['transaction_id'];
        
        $paymentData = $this->profile_m->getPayPalDetails($custom);
        
        while(!isset($paymentData[0])){
            sleep(1);
            $paymentData = $this->profile_m->getPayPalDetails($custom);
        }
        
        if(!isset($paymentData[0]))
        {
            $mdata = new stdClass();
            $mdata->meurl = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            $rtryData['data'] = $mdata;
            $this->template->build('stores/waitretry',$rtryData);
        }
        else
        {
            $paymentData = $paymentData[0]; 
            $res = $paymentData['id'];
            $txnid = $paymentData['token'];
            $payer_id = $paymentData['payer_id'];
            if(isset($request['lvisit'])){
                $data = new stdClass();
                $data->id = $request['id'];
                $data->amount = $request['amt'];
                $data->paypal_token = $txnid;
                $data->paypal_payer_id = $payer_id;
                $data->from = 'photos';
                $respData['data'] = $data;
                $this->template->build('stores/paypal_success',$respData);
            }
            else{
                if(isset($request['id']) && !empty($request['id'])){
                    if($res){
                        $data = new stdClass();                     
                        $data->paid_by = $getTmpData['user_id'];
                        $data->paid_to = $getTmpData['inmate_id'];
                        $data->sent_date = date('Y-m-d H:i:s');
                        $data->status = 1;
                        $data->payment_id = $res;
                        
                        $data->fee = $getTmpData['fee'];
                        $data->unit = $getTmpData['unit'];
                        $data->original_amount = $getTmpData['original_amount'];
                        $data->processing_fees = $getTmpData['processing_fees'];
                        $data->payment_type = "paypal";
                        
                        if($data->paid_by == '' || empty($data->paid_by)){
                            redirect('');
                        }else{
                            $resp = $this->profile_m->saveFundDetails($data);
                        }
                        if($resp){
                            $data->from = 'funds';
                            $data->amount = $getTmpData['amt'];
                            $data->paypal_token = $txnid;
                            $data->paypal_payer_id = $payer_id;
                            $data->order_id = $resp;
                            $respData['data'] = $data;  
                            
                            $Email = $this->profile_m->getUserDetails($getTmpData['user_id']);
                            $data->sentby = ucfirst($Email[0]['email']);
                            $data->fname  = ucfirst($Email[0]['first_name']);
                            $data->lname  = ucfirst($Email[0]['last_name']);
                            $Inmdet = $this->profile_m->getInmatedd($getTmpData['inmate_id']);
                            $data->sentto = $Inmdet[0]['inmates_name'].' '.$Inmdet[0]['inmates_middle_name'].' '.$Inmdet[0]['inmates_last_name'];
                            $Email_data = $this->profile_m->getProfileDetails($getTmpData['user_id']);
                            $userData = $this->profile_m->getInmateDetails($getTmpData['inmate_id']);
                            $franchise = $this->profile_m->getFranchiseDetails($userData[0]['facility_id']);
                            
                            $mailData = array();
                            if($Email[0]['notified_by'] == 1 || $Email[0]['notified_by'] == 3){                     
                                $mailData['slug'] = 'paypal-fund-template';
                                $mailData['to'] = $Email_data[0]['user_email'];
                                $mailData['first_name'] = ucfirst($Email[0]['first_name']).' '.$Email[0]['last_name'];                      
                                $mailData['facility_name'] = $userData[0]['facility_name'];
                                $mailData['facility_address'] = $userData[0]['address'].', '.$userData[0]['city'].', '.$userData[0]['county'].', '.$userData[0]['state'].', '.$userData[0]['country'];
                                $mailData['inmate_name'] = $userData[0]['inmates_name'].' '.$userData[0]['inmates_middle_name'].' '.$userData[0]['inmates_last_name'];
                                $mailData['booking_no'] = $userData[0]['inmates_booking_no'];
                                $mailData['amount_transfered'] = $getTmpData['original_amount'].' USD';
                                $mailData['fee'] = $getTmpData['processing_fees'].' USD';
                                $mailData['amount'] = $getTmpData['amt'].' USD';
                                $mailData['order_id'] = $resp; 
                                $mailData['payment_mode'] = "paypal"; 
                                $mailData['email'] = ucfirst($Email[0]['email']);
                                $mailData['mobile'] = ucfirst($Email[0]['mobile']);
                                $mailData['country'] = ucfirst($Email[0]['country']);
                                $mailData['transaction_token'] = $txnid;
                                $mailData['order_detail'] = base_url('paypal_success').'/?amt='.$getTmpData['amt'].'&id='.$request['id'].'&token='.$txnid.'&PayerID='.$payer_id;
                                $results = Events::trigger('email', $mailData, 'array'); 
                            }    
                            
                            $mailData['slug'] = 'admin-fund-template';     
                            $mailData['to'] = "admin@storeshere.com, orders@storeshere.com";                                
                            $mailData['admin'] = 'Admin';
                            $mailData['first_name'] = ucfirst($Email[0]['first_name']).' '.$Email[0]['last_name'];   
                            $mailData['facility_name'] = $userData[0]['facility_name'];
                            $mailData['facility_address'] = $userData[0]['address'].', '.$userData[0]['city'].', '.$userData[0]['county'].', '.$userData[0]['state'].', '.$userData[0]['country'];
                            $mailData['inmate_name'] = $userData[0]['inmates_name'].' '.$userData[0]['inmates_middle_name'].' '.$userData[0]['inmates_last_name'];
                            $mailData['booking_no'] = $userData[0]['inmates_booking_no'];  
    
                            $mailData['order_detail'] = base_url('paypal_success').'/?amt='.$getTmpData['amt'].'&id='.$request['id'].'&token='.$txnid.'&PayerID='.$payer_id;
    
                            $mailData['amount_transfered'] = $getTmpData['original_amount'].' USD';
                            $mailData['fee'] = $getTmpData['processing_fees'].' USD';
                            $mailData['amount'] = $getTmpData['amt'].' USD';
                            $mailData['order_id'] = $resp; 
                            $mailData['payment_mode'] = "paypal"; 
                            $mailData['email'] = ucfirst($Email[0]['email']);
                            $mailData['mobile'] = ucfirst($Email[0]['mobile']);                     
                            $mailData['country'] = ucfirst($Email[0]['country']);
                            $mailData['transaction_token'] = $txnid;
                            
                            if($Email[0]['notified_by'] == 2 || $Email[0]['notified_by'] == 3) {
                                $client = get_twilio_client(); 
                                $pc = $this->db->query("select phonecode from default_country where nicename = '".$Email[0]['country']."'")->result_array();
                            
                                $mobile = '+'.$pc[0]['phonecode'].$Email[0]['mobile'];
                                try {
                                    $client->messages->create(
                                        $mobile,
                                        array(
                                            'from' => '+14088907359',
                                            'body' => 'Your order '.$resp.' for sending funds is successfully submitted and received - storeshere'
                                        )
                                    );
                                } catch (Exception $e) {
                                    $e->getMessage();
                                }
                            }  
            
                            
                            $email_admin = Events::trigger('email', $mailData, 'array');
                            if($email_admin && !empty($franchise)){                     
                                $mailData['to'] = $franchise[0]['email'];
                                $mailData['admin'] = $franchise[0]['first_name'].' '.$franchise[0]['last_name'];
                                $email_franchise = Events::trigger('email',$mailData,'array');
                            }
                            $this->template->build('stores/paypalsuccess',$respData);
                        }
                    }
                }else{
                    redirect('');
                }
            }
        }
        
    }

    public function paypal_success_old(){
        date_default_timezone_set("America/New_York");
        $request = $_GET;       
        
        if(isset($request['lvisit'])){
            $data = new stdClass();
            $data->id = $request['id'];
            $data->amount = $request['amt'];
            $data->paypal_token = $request['token'];
            $data->paypal_payer_id = $request['PayerID'];
            $data->from = 'photos';
            $respData['data'] = $data;

            $this->template->build('stores/paypal_success',$respData);
        }
        else{
            $PayPalResult = $this->paypal_pro->GetExpressCheckoutDetails($request['token']);
            //print_r($PayPalResult); die();
            if(isset($request['id']) && !empty($request['id'])){
                $id = $request['id'];       
                $getTmpData = $this->profile_m->getTmpData($id);        
                $getTmpData = unserialize($getTmpData[0]['tmp_data']);
                
                $paypalData = new stdClass();
                $paypalData->token = $request['token'];     
                $paypalData->payer_id = $request['PayerID'];
                $paypalData->amount = $getTmpData['amt'];
                $paypalData->currency_code = 'USD';
                $paypalData->payment_date = date('Y-m-d H:i:s');
                $paypalData->payment_status = 1;
                $res = $this->profile_m->savePayPalDetails($paypalData);
                // $res = 10;

                if($res){
                    $data = new stdClass();                     
                    $data->paid_by = $getTmpData['user_id'];
                    $data->paid_to = $getTmpData['inmate_id'];
                    $data->sent_date = date('Y-m-d H:i:s');
                    $data->status = 1;
                    $data->payment_id = $res;
                    
                    $data->fee = $getTmpData['fee'];
                    $data->unit = $getTmpData['unit'];
                    $data->original_amount = $getTmpData['original_amount'];
                    $data->processing_fees = $getTmpData['processing_fees'];
                    $data->payment_type = "paypal";
                    if($data->paid_by == '' || empty($data->paid_by)){
                        redirect('');
                    }else{
                        $resp = $this->profile_m->saveFundDetails($data);
                    }
                    // $resp = true;
                    if($resp){
                        $data->from = 'funds';
                        $data->amount = $getTmpData['amt'];
                        $data->paypal_token = $request['token'];
                        $data->paypal_payer_id = $request['PayerID'];
                        $data->order_id = $resp;
                        $respData['data'] = $data;  
                        
                        $Email = $this->profile_m->getUserDetails($getTmpData['user_id']);
                        $data->sentby = ucfirst($Email[0]['email']);
                        $data->fname  = ucfirst($Email[0]['first_name']);
                        $data->lname  = ucfirst($Email[0]['last_name']);
                        $Inmdet = $this->profile_m->getInmatedd($getTmpData['inmate_id']);
                        $data->sentto = $Inmdet[0]['inmates_name'];
                        $Email_data = $this->profile_m->getProfileDetails($getTmpData['user_id']);
                        // $Email = $this->profile_m->getUserDetails(22);
                        $userData = $this->profile_m->getInmateDetails($getTmpData['inmate_id']);
                        $franchise = $this->profile_m->getFranchiseDetails($userData[0]['facility_id']);
                        
                        $mailData = array();
                        if($Email[0]['notified_by'] == 1 || $Email[0]['notified_by'] == 3){                     
                            $mailData['slug'] = 'paypal-fund-template';
                            $mailData['to'] = $Email_data[0]['user_email'];
                            $mailData['first_name'] = ucfirst($Email[0]['first_name']).' '.$Email[0]['last_name'];                      
                            $mailData['facility_name'] = $userData[0]['facility_name'];
                            $mailData['facility_address'] = $userData[0]['address'].', '.$userData[0]['city'].', '.$userData[0]['county'].', '.$userData[0]['state'].', '.$userData[0]['country'];
                            $mailData['inmate_name'] = $userData[0]['inmates_name'];
                            $mailData['booking_no'] = $userData[0]['inmates_booking_no'];
                            $mailData['amount_transfered'] = $getTmpData['original_amount'].' USD';
                            $mailData['fee'] = $getTmpData['processing_fees'].' USD';
                            $mailData['amount'] = $getTmpData['amt'].' USD';
                            $mailData['order_id'] = $resp; 
                            $mailData['payment_mode'] = "paypal"; 
                            $mailData['email'] = ucfirst($Email[0]['email']);
                            $mailData['mobile'] = ucfirst($Email[0]['mobile']);
                            $mailData['country'] = ucfirst($Email[0]['country']);
                            $mailData['transaction_token'] = $request['token'];
                            $mailData['order_detail'] = base_url('paypal_success').'/?amt='.$getTmpData['amt'].'&id='.$request['id'].'&token='.$request['token'].'&PayerID='.$request['PayerID'];
                            // var_dump($mailData); die;
                            $results = Events::trigger('email', $mailData, 'array'); 
                        }    
                        
                        $mailData['slug'] = 'admin-fund-template';
                        //$mailData['to'] = "ronniecase@gmail.com";       
                        $mailData['to'] = "admin@storeshere.com";                                
                        $mailData['admin'] = 'Admin';
                        $mailData['first_name'] = ucfirst($Email[0]['first_name']).' '.$Email[0]['last_name'];   
                        $mailData['facility_name'] = $userData[0]['facility_name'];
                        $mailData['facility_address'] = $userData[0]['address'].', '.$userData[0]['city'].', '.$userData[0]['county'].', '.$userData[0]['state'].', '.$userData[0]['country'];
                        $mailData['inmate_name'] = $userData[0]['inmates_name'];
                        $mailData['booking_no'] = $userData[0]['inmates_booking_no'];  

                        $mailData['order_detail'] = base_url('paypal_success').'/?amt='.$getTmpData['amt'].'&id='.$request['id'].'&token='.$request['token'].'&PayerID='.$request['PayerID'];

                        $mailData['amount_transfered'] = $getTmpData['original_amount'].' USD';
                        $mailData['fee'] = $getTmpData['processing_fees'].' USD';
                        $mailData['amount'] = $getTmpData['amt'].' USD';
                        $mailData['order_id'] = $resp; 
                        $mailData['payment_mode'] = "paypal"; 
                        $mailData['email'] = ucfirst($Email[0]['email']);
                        $mailData['mobile'] = ucfirst($Email[0]['mobile']);                     
                        $mailData['country'] = ucfirst($Email[0]['country']);
                        $mailData['transaction_token'] = $request['token'];
                        
                        if($Email[0]['notified_by'] == 2 || $Email[0]['notified_by'] == 3) {
                            $client = get_twilio_client(); 
                            $pc = $this->db->query("select phonecode from default_country where nicename = '".$Email[0]['country']."'")->result_array();
                        
                            $mobile = '+'.$pc[0]['phonecode'].$Email[0]['mobile'];
                            try {
                                $client->messages->create(
                                    $mobile,
                                    array(
                                        'from' => '+14088907359',
                                        'body' => 'Your order '.$resp.' for sending funds is successfully submitted and received - storeshere'
                                    )
                                );
                            } catch (Exception $e) {
                                //Log::error($e->getMessage());
                                $e->getMessage();
                            }
                            
                
                        }  
        
                        
                        $email_admin = Events::trigger('email',$mailData, 'array');
                        if($email_admin && !empty($franchise)){                     
                            $mailData['to'] = $franchise[0]['email'];
                            $mailData['admin'] = $franchise[0]['first_name'].' '.$franchise[0]['last_name'];
                            $email_franchise = Events::trigger('email',$mailData,'array');
                        }
                        $this->template->build('stores/paypalsuccess',$respData);
                    }
                }
            }else{
                redirect('');
            }
        }
    }

    public function paypal_cancel(){
        $data['token'] = $_GET['token'];
        $this->template->build('stores/paypalcancel',$data);
    }

    public function paypal_notify(){
        // $req_dump = print_r($_REQUEST, TRUE);
        // $fp = fopen('request.log', 'a');
        // fwrite($fp, $req_dump);
        // fclose($fp);
        
        // echo print_r($_REQUEST);exit();
        
        $paypalData = new stdClass();
        $paypalData->token = $_REQUEST['txn_id'];     
        $paypalData->payer_id = $_REQUEST['payer_email'];
        $paypalData->amount = $_REQUEST['mc_gross'];
        $paypalData->custom = $_REQUEST['custom'];
        $paypalData->currency_code = 'USD';
        $paypalData->payment_date = date('Y-m-d H:i:s');
        $paypalData->payment_status = 1;
        
        
        // $data = [
        //     'item_name' => $_POST['item_name'],
        //     'item_number' => $_POST['item_number'],
        //     'payment_status' => $_POST['payment_status'],
        //     'payment_amount' => $_POST['mc_gross'],
        //     'payment_currency' => $_POST['mc_currency'],
        //     'txn_id' => $_POST['txn_id'],
        //     'receiver_email' => $_POST['receiver_email'],
        //     'payer_email' => $_POST['payer_email'],
        //     'custom' => $_POST['custom'],
        // ];
        
        // if ($this->verifyTransaction($_POST)) {
            $res = $this->profile_m->savePayPalDetails($paypalData);
        // }
    }
    
    public function verifyTransaction($data) {
        $enableSandbox = false;
        $paypalUrl = $enableSandbox ? 'https://www.sandbox.paypal.com/cgi-bin/webscr' : 'https://www.paypal.com/cgi-bin/webscr';
    
        $req = 'cmd=_notify-validate';
        foreach ($data as $key => $value) {
            $value = urlencode(stripslashes($value));
            $value = preg_replace('/(.*[^%^0^D])(%0A)(.*)/i', '${1}%0D%0A${3}', $value); // IPN fix
            $req .= "&$key=$value";
        }
    
        $ch = curl_init($paypalUrl);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        curl_setopt($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
        $res = curl_exec($ch);
    
        if (!$res) {
            $errno = curl_errno($ch);
            $errstr = curl_error($ch);
            curl_close($ch);
            throw new Exception("cURL error: [$errno] $errstr");
        }
    
        $info = curl_getinfo($ch);
    
        // Check the http response
        $httpCode = $info['http_code'];
        if ($httpCode != 200) {
            throw new Exception("PayPal responded with http code $httpCode");
        }
    
        curl_close($ch);
    
        return $res === 'VERIFIED';
    }
    
    public function paypal_notify_old(){
        $request = $_GET;
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            if($id == 1){ // funds
                $data['from'] = 'funds';                
            }else{ // photos
                $data['from'] = 'photos';
            }
            $this->template->build('stores/paypalnotify',$data);
        }
    }

    public function getImagesFromId(){
        $post = $this->input->post();
        $id = $post['id'];  
        $imagesData = $this->profile_m->getImages($id);        
        $sent_by = $imagesData[0]['sent_by'];
        $images = unserialize($imagesData[0]['photo_name']);
        $text = unserialize($imagesData[0]['msg_photo']);        
        foreach($images as $k => $img){
            $res[] = ["href" => base_url().'uploads/'.$sent_by.'/photos/'.$img , "title" => $text[$k],"type"=> "image", "isDom"=> true ];
        }
        exit(json_encode($res));
    }

    public function getSentPhotosListing(){
        if(!is_logged_in()){
            redirect('');
        }
        $id = $this->current_user->id;
        $post = $this->input->post();
        $data = $this->profile_m->getSentPhotosList($id);
        // print_r($post);die;
    }

    public function deleteInmate(){
        $post = $this->input->post();
        if(!empty($post) && isset($post['del_inmate'])){
            $id = $post['del_inmate'];
            $res = $this->profile_m->deleteInmate($id);
            if($res){
                exit(json_encode(array('status' => true, 'message' => 'Inmate deleted successfully')));
                $this->session->set_flashdata('msg', array('type' => 'success', 'message' => 'Inmate has been successfully deleted.'));
                redirect('inmate_list');
            }else{
                exit(json_encode(array('status' => false, 'message' => 'Some error occured')));
                $this->session->set_flashdata('msg', array('type' => 'error', 'message' => 'Some error occured, please try again'));
                redirect('inmate_list');
            }
        }
    }
    
    public function waitretry(){
        $mdata = new stdClass();
        $mdata->meurl = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $rtryData['data'] = $mdata;
        $this->template->build('stores/waitretry',$rtryData);
    }

}
?>
