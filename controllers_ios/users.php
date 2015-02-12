<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require('application/libraries/REST_Controller.php');  
// require('application/libraries/skhoocommon.php'); 

class Users extends REST_Controller {

	public function Users() {
		parent::__construct();

		$this->load->model('user_model');
	}
	
	function login_post(){
		$serviceName = 'login';
		//getting posted values
		$ip['email'] = trim($this->input->post('email'));
		$ip['password'] = trim($this->input->post('password'));
		$ip['is_social_media_user'] = trim($this->input->post('is_social_media_user'));
		$ip['social_media_user_id'] = trim($this->input->post('social_media_user_id'));
		$ipJson = json_encode($ip);
		//validation
		$validation_array = 1;
		if ($ip['is_social_media_user'] == '2') {
			$ip_array[] = array("email", $ip['email'], "email", "email_id", "Wrong or Invalid Email address.");
			$ip_array[] = array("password", $ip['password'], "not_null", "password", "Password is empty.");
			$validation_array = $this->validator->validate($ip_array);
			if ($validation_array !=1) {
				$data['message'] = $validation_array;
				$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
			} 
			else {
				$retVals = $this->user_model->check_login($ip, $serviceName);
			}
		} else {
			$retVals = $this->user_model->check_login($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}

	/*function register_post() {
		$serviceName = 'register';
		//getting posted values
		// 1- from social media 2 - sekahooo user
		$ip['is_social_media_user'] = $this->input->post('is_social_media_user'); 
		if ($ip['is_social_media_user'] == 1) {
			$ip['social_media_user_id'] = $this->input->post('social_media_user_id'); 
			$ip['profile_thumb_url'] = $this->input->post('profile_thumb_url'); 
			$ip['profile_org_url'] = $this->input->post('profile_org_url'); 
			$ip_array[] = array("social_media_user_id", $ip['social_media_user_id'], "not_null", "social_media_user_id", "social_media_user_id is empty.");
			// $ip_array[] = array("profile_thumb_url", $ip['profile_thumb_url'], "not_null", "profile_thumb_url", "profile_thumb_url is empty.");
			// $ip_array[] = array("profile_org_url", $ip['profile_org_url'], "not_null", "profile_org_url", "profile_org_url is empty.");
		}
		$ip['email'] = trim($this->input->post('email'));
		$ip['social_media_flag'] = trim($this->input->post('social_media_flag'));
		$ip['password'] = trim($this->input->post('password'));
		$ip['tag_name'] = trim($this->input->post('tag_name'));
		$ip['user_type'] = trim($this->input->post('user_type'));
		// 1- personal 2- Business
		$ip['name'] = '';
		$ip['tag_name'] = '';
		if ($ip['user_type'] == 2 || $ip['is_social_media_user'] == 1) {
			$ip['name'] = trim($this->input->post('name'));
			$ip['tag_name'] = trim($this->input->post('tag_name'));
			$ip_array[] = array("name", $ip['name'], "not_null", "name", "name is empty.");
			$ip_array[] = array("tag_name", $ip['tag_name'], "not_null", "tag_name", "tag_name is empty.");
		}
		$ipJson = json_encode($ip);
		//validation
		$validation_array = 1;
		if(isset($ip['social_media_flag']) && $ip['social_media_flag'] != 'twitter') {
			$ip_array[] = array("email", $ip['email'], "email", "email", "Wrong or Invalid email.");
		}
		$ip_array[] = array("is_social_media_user", $ip['is_social_media_user'], "not_null", "is_social_media_user", "Wrong or Invalid is_social_media_user.");
		if ($ip['is_social_media_user'] == 2) {
			$ip_array[] = array("password", $ip['password'], "not_null", "password", "password is empty.");
		}
		$ip_array[] = array("user_type", $ip['user_type'], "not_null", "user_type", "Wrong or Invalid user_type.");
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} else if ($ip['is_social_media_user'] == 1 && $this->user_model->check_social_media_id($ip['email'],$ip['social_media_user_id'])) {
				// print_r($result); exit;
				$result = $this->user_model->check_social_media_id($ip['email'],$ip['social_media_user_id']);
				$data['user_id']= $result[0]->user_id; 
				$data['user_type']= $result[0]->user_type_id; 
				$data['message'] = 'Social media id is already registered!';
				$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
				// $data['message'] = 'The email address associated with this social media account has already been used.  Please choose the social media account you first used to sign into Seekahoo';
			}
			else if ($ip['is_social_media_user'] == 2 && $this->user_model->check_email($ip['email'])) {
				$data['message'] = 'Email address already registered!';
				$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
			}
		else {
			$retVals = $this->user_model->user_register($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}*/
	
	function add_media_post() {
		$serviceName = 'add_media';
		$flag = $this->input->post('flag');
		$ip['user_id'] = $this->input->post('user_id');
		$ip['flag'] = $flag;
		$ipJson = json_encode($ip);
		$validation_array = 1;
		$ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "Wrong or Invalid user_id.");
		$ip_array[] = array("flag", $ip['flag'], "not_null", "flag", "flag is empty.");
		$ipJson = json_encode($ip);
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$this->load->library('uploader');
			foreach($_FILES as $key => $value) {
				$uploadPhoto[] = $this->uploader->upload_image($value, $flag,$ip);
			}
			if ($uploadPhoto[0] == 'failed') {
				$data['message'] = 'Upload Failed. Please try again';
				$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
			} else {
				$uploadDb = $this->user_model->add_photo($uploadPhoto, $ip);
				if (!$uploadDb) {
					$data['message'] = 'Failed to add media to database';
					$status = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
				} else {
					$data['uploaded_data'] = $uploadDb;
					$data['message'] = 'Successfully Uploaded';
					$retVals = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);
				}
			}
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	function update_user_details_post() {
		$serviceName = 'update_user_details';
		//getting posted values
		$ip['user_id'] = trim($this->input->post('user_id'));
		$ip['name'] = trim($this->input->post('name'));
		$ip['tag_name'] = trim($this->input->post('tag_name'));
		$ip['description'] = trim($this->input->post('description'));
		$ip['flag'] = trim($this->input->post('flag'));
		$ip['user_type'] = trim($this->input->post('user_type'));
		$ip['is_social_media_user'] = trim($this->input->post('is_social_media_user'));
		$ip['zip'] = trim($this->input->post('zip'));
		$ip['latitude'] = trim($this->input->post('latitude'));
		$ip['longitude'] = trim($this->input->post('longitude'));
		
		if ($ip['user_type'] == '2') {
		
			$ip['web_address'] = trim($this->input->post('web_address'));
			$ip['skills'] = trim($this->input->post('skills'));
			$ip['address'] = trim($this->input->post('address'));
			$ip['phone_number'] = trim($this->input->post('phone_number'));
			$ip['city'] = trim($this->input->post('city'));
			$ip['state'] = trim($this->input->post('state'));
			$ip['is_licensed'] = trim($this->input->post('is_licensed'));
			$ip['is_insured'] = trim($this->input->post('is_insured'));
			$ip['business_hours'] = trim($this->input->post('business_hours'));
		}
		$ipJson = json_encode($ip);
		//validation
		$validation_array = 1;
		if ($ip['user_type'] == '2') {
			$ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "Wrong or Invalid user_id.");
			$ip_array[] = array("flag", $ip['flag'], "not_null", "flag", "Wrong or Invalid flag.");
			$ip_array[] = array("user_type", $ip['user_type'], "not_null", "user_type", "user_type is empty.");
			$ip_array[] = array("is_social_media_user", $ip['is_social_media_user'], "not_null", "is_social_media_user", "is_social_media_user is empty.");
			// $ip_array[] = array("web_address", $ip['web_address'], "not_null", "web_address", "web_address is empty.");
			// $ip_array[] = array("skills", $ip['skills'], "not_null", "skills", "skills is empty.");
			// $ip_array[] = array("address", $ip['address'], "not_null", "address", "address is empty.");
			$ip_array[] = array("city", $ip['city'], "not_null", "city", "city is empty.");
			$ip_array[] = array("state", $ip['state'], "not_null", "state", "state is empty.");
			$ip_array[] = array("phone_number", $ip['phone_number'], "not_null", "phone_number", "phone_number is empty.");
			$ip_array[] = array("is_licensed", $ip['is_licensed'], "not_null", "is_licensed", "is_licensed is empty.");
			$ip_array[] = array("is_insured", $ip['is_insured'], "not_null", "is_insured", "is_insured is empty.");
			// $ip_array[] = array("business_hours", $ip['business_hours'], "not_null", "business_hours", "business_hours is empty.");
			}
			
			$ip_array[] = array("zip", $ip['zip'], "not_null", "zip", "zip is empty.");
			$ip_array[] = array("name", $ip['name'], "not_null", "name", "name is empty.");
			$ip_array[] = array("tag_name", $ip['tag_name'], "not_null", "tag_name", "tag_name is empty.");
			// $ip_array[] = array("description", $ip['description'], "not_null", "description", "description is empty.");
			
			$validation_array = $this->validator->validate($ip_array);
			if ($validation_array !=1) {
				$data['message'] = $validation_array;
				$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
			} 
			else {
					// if($ip['latitude']==0 || $ip['longitude']==0 || $ip['latitude']=="" || $ip['longitude']=="" || $ip['latitude']=="(null)" || $ip['longitude']=="(null)") {
						if($ip['zip']) {
							$coordinates = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($ip['zip']) . '&sensor=true');
							$coordinates = json_decode($coordinates);
			 
							$ip['latitude'] = $coordinates->results[0]->geometry->location->lat;
							$ip['longitude'] = $coordinates->results[0]->geometry->location->lng;	
						}
				$retVals = $this->user_model->update_user_details($ip, $serviceName);
			}
			
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	function get_user_details_post() {
		$serviceName = 'get_user_details';
		//getting posted values
		$ip['user_id'] = trim($this->input->post('user_id'));
		$ip['user_type'] = trim($this->input->post('user_type'));
		$validation_array = 1;
		$ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "Wrong or Invalid user_id.");
		$ip_array[] = array("user_type", $ip['user_type'], "not_null", "user_type", "user_type is empty.");
		$ipJson = json_encode($ip);
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->user_model->get_user_details($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	function get_more_user_details_post() {
		$serviceName = 'get_more_user_details';
		//getting posted values
		$ip['user_id'] = trim($this->input->post('user_id'));
		$ip['user_type'] = trim($this->input->post('user_type'));
		$ip['own_user_id'] = trim($this->input->post('own_user_id'));
		$validation_array = 1;
		$ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "Wrong or Invalid user_id.");
		$ip_array[] = array("user_type", $ip['user_type'], "not_null", "user_type", "user_type is empty.");
		$ip_array[] = array("own_user_id", $ip['own_user_id'], "not_null", "own_user_id", "own_user_id is empty.");
		$ipJson = json_encode($ip);
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->user_model->get_more_user_details($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	function get_followers_details_post() {
		$serviceName = 'get_followers_details';
		//getting posted values
		$ip['user_id'] = trim($this->input->post('user_id'));
		$validation_array = 1;
		$ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "Wrong or Invalid user_id.");
		$ipJson = json_encode($ip);
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->user_model->get_followers_details($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	function get_following_details_post() {
		$serviceName = 'get_following_details';
		//getting posted values
		$ip['user_id'] = trim($this->input->post('user_id'));
		$validation_array = 1;
		$ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "Wrong or Invalid user_id.");
		$ipJson = json_encode($ip);
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->user_model->get_following_details($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	/*function get_pro_details_post() {
		$serviceName = 'get_pro_details';
		//getting posted values
		$ip['user_id'] = trim($this->input->post('user_id'));
		$validation_array = 1;
		$ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "Wrong or Invalid user_id.");
		$ipJson = json_encode($ip);
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->user_model->get_pro_details($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}*/
	
	function get_user_pros_details_post() {
		$serviceName = 'get_user_pros_details';
		//getting posted values
		$ip['user_id'] = trim($this->input->post('user_id'));
		$ip['distance'] = trim($this->input->post('distance'));
		$validation_array = 1;
		$ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "Wrong or Invalid user_id.");
		$ip_array[] = array("distance", $ip['distance'], "not_null", "distance", "Wrong or Invalid distance.");
		$ipJson = json_encode($ip);
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->user_model->get_user_pros_details($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	function get_user_pro_endorsement_details_post() {
		$serviceName = 'get_user_pro_endorsement_details';
		//getting posted values
		$ip['user_id'] = trim($this->input->post('user_id'));
		$validation_array = 1;
		$ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "Wrong or Invalid user_id.");
		$ipJson = json_encode($ip);
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->user_model->get_user_pro_endorsement_details($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	function get_user_pro_connection_details_post() {
		$serviceName = 'get_user_pro_connection_details';
		//getting posted values
		$ip['personal_user_id'] = trim($this->input->post('personal_user_id'));
		$ip['business_user_id'] = trim($this->input->post('business_user_id'));
		$validation_array = 1;
		$ip_array[] = array("personal_user_id", $ip['personal_user_id'], "not_null", "personal_user_id", "Wrong or Invalid personal_user_id.");
		$ip_array[] = array("business_user_id", $ip['business_user_id'], "not_null", "business_user_id", "Wrong or Invalid business_user_id.");
		$ipJson = json_encode($ip);
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->user_model->get_user_pro_connection_details($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	function get_business_endorsement_details_post() {
		$serviceName = 'get_business_endorsement_details';
		//getting posted values
		$ip['user_id'] = trim($this->input->post('user_id'));
		$validation_array = 1;
		$ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "Wrong or Invalid user_id.");
		$ipJson = json_encode($ip);
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->user_model->get_business_endorsement_details($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	function forgot_password_post() {
		$serviceName = 'forgot_password';
		//getting posted values
		$ip['email_id'] = trim($this->input->post('email_id'));
		$validation_array = 1;
		$ip_array[] = array("email_id", $ip['email_id'], "email", "email_id", "Wrong or Invalid Email address.");
		$ipJson = json_encode($ip);
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else if (!$this->user_model->check_email($ip['email_id'])) {
			$data['message'] = 'Email address is not registered with seekahoo';
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		}
		else {
			$retVals = $this->user_model->forgot_password($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	function reset_password_post() {
		$serviceName = 'reset_password';
		//getting posted values
		$ip['email_id'] = trim($this->input->post('email_id'));
		$ip['new_password'] = trim($this->input->post('new_password'));
		$ip['con_password'] = trim($this->input->post('con_password'));
		$validation_array = 1;
		$ip_array[] = array("email_id", $ip['email_id'], "email", "email_id", "Wrong or Invalid email_id.");
		$ipJson = json_encode($ip);
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->user_model->reset_password($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	function change_password_post() {
		$serviceName = 'change_password';
		//getting posted values
		$ip['user_id'] = trim($this->input->post('user_id'));
		$ip['current_password'] = trim($this->input->post('current_password'));
		$ip['new_password'] = trim($this->input->post('new_password'));
		$ip['con_password'] = trim($this->input->post('con_password'));
		$validation_array = 1;
		$ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "Wrong or Invalid user_id.");
		$ip_array[] = array("new_password", $ip['new_password'], "not_null", "new_password", "Wrong or Invalid new_password.");
		$ip_array[] = array("current_password", $ip['current_password'], "not_null", "current_password", "current_password is empty.");
		$ip_array[] = array("con_password", $ip['con_password'], "not_null", "con_password", "con_password is empty.");
		$ipJson = json_encode($ip);
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->user_model->change_password($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	function change_description_post() {
		$serviceName = 'change_description';
		//getting posted values
		$ip['user_id'] = trim($this->input->post('user_id'));
		$ip['description'] = trim($this->input->post('description'));
		$validation_array = 1;
		$ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "Wrong or Invalid user_id.");
		$ip_array[] = array("description", $ip['description'], "not_null", "description", "Wrong or Invalid description.");
		$ipJson = json_encode($ip);
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->user_model->change_description($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	function update_email_post() {
		$serviceName = 'update_email';
		//getting posted values
		$ip['user_id'] = trim($this->input->post('user_id'));
		$ip['email'] = trim($this->input->post('email'));
		$validation_array = 1;
		$ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "Wrong or Invalid user_id.");
		$ip_array[] = array("email", $ip['email'], "email", "email_id", "Wrong or Invalid Email address.");
		$ipJson = json_encode($ip);
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->user_model->update_email($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	function get_user_type_post() {
		$serviceName = 'get_user_type';
		//getting posted values
		$ip['user_id'] = trim($this->input->post('user_id'));
		$validation_array = 1;
		$ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "Wrong or Invalid user_id.");
		$ipJson = json_encode($ip);
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->user_model->get_user_type($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	function get_user_count_post() {
		$serviceName = 'get_user_count';
		//getting posted values
		$ip['user_id'] = trim($this->input->post('user_id'));
		$validation_array = 1;
		$ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "Wrong or Invalid user_id.");
		$ipJson = json_encode($ip);
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->user_model->get_user_count($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	function update_zipcode_post() {
		$serviceName = 'update_zipcode';
		//getting posted values
		$ip['user_id'] = trim($this->input->post('user_id'));
		$ip['email_id'] = trim($this->input->post('email_id'));
		$ip['zipcode'] = trim($this->input->post('zipcode'));
		$validation_array = 1;
		$ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "Wrong or Invalid user_id.");
		$ip_array[] = array("zipcode", $ip['zipcode'], "not_null", "zipcode", "Wrong or Invalid zipcode.");
		$ipJson = json_encode($ip);
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else if ($this->user_model->check_email($ip['email_id']) && $ip['email_id']!="") {
			$result = $this->user_model->check_email($ip['email_id']);
			$data['user_id']= $result[0]->user_id; 
			$data['user_type']= $result[0]->user_type_id; 
			$data['message'] = 'Email-id is already registered!';
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		}
		else {
			$retVals = $this->user_model->update_zipcode($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	function user_sign_up_post() {
		$serviceName = 'user_sign_up';
		
		//getting posted values
		// 1- from social media 2 - sekahooo user
		$ip['is_social_media_user'] = $this->input->post('is_social_media_user');
		$ip['tag_name'] = trim($this->input->post('tag_name'));
		$ip['user_type'] = trim($this->input->post('user_type'));
		$ip['name'] = trim($this->input->post('name'));
		$ip['description'] = trim($this->input->post('description'));
		$ip['email'] = trim($this->input->post('email'));
		$ip['password'] = trim($this->input->post('password'));
		$ip['social_media_flag'] = trim($this->input->post('social_media_flag'));
		$ip['zipcode'] = trim($this->input->post('zipcode'));
		$ip['latitude'] = trim($this->input->post('latitude'));
		$ip['longitude'] = trim($this->input->post('longitude'));
		
		if ($ip['is_social_media_user'] == 1) {
			$ip['social_media_user_id'] = $this->input->post('social_media_user_id'); 
			$ip['profile_thumb_url'] = $this->input->post('profile_thumb_url'); 
			$ip['profile_org_url'] = $this->input->post('profile_org_url'); 
			$ip_array[] = array("social_media_user_id", $ip['social_media_user_id'], "not_null", "social_media_user_id", "social_media_user_id is empty.");
		}
		
		if ($ip['user_type'] == 2) {
			$ip['web_address'] = trim($this->input->post('web_address'));
			$ip['skills'] = trim($this->input->post('skills'));
			$ip['address'] = trim($this->input->post('address'));
			$ip['phone_number'] = trim($this->input->post('phone_number'));
			$ip['city'] = trim($this->input->post('city'));
			$ip['state'] = trim($this->input->post('state'));
			$ip['is_licensed'] = trim($this->input->post('is_licensed'));
			$ip['is_insured'] = trim($this->input->post('is_insured'));
			$ip['business_hours'] = trim($this->input->post('business_hours'));
			
			
			// $ip_array[] = array("web_address", $ip['web_address'], "not_null", "web_address", "web_address is empty.");
			// $ip_array[] = array("skills", $ip['skills'], "not_null", "skills", "skills is empty.");
			// $ip_array[] = array("address", $ip['address'], "not_null", "address", "address is empty.");
			$ip_array[] = array("city", $ip['city'], "not_null", "city", "city is empty.");
			$ip_array[] = array("state", $ip['state'], "not_null", "state", "state is empty.");
			$ip_array[] = array("phone_number", $ip['phone_number'], "not_null", "phone_number", "phone_number is empty.");
			$ip_array[] = array("is_licensed", $ip['is_licensed'], "not_null", "is_licensed", "is_licensed is empty.");
			$ip_array[] = array("is_insured", $ip['is_insured'], "not_null", "is_insured", "is_insured is empty.");
		}
		
		if ($ip['is_social_media_user'] == 2) {
			$ip_array[] = array("password", $ip['password'], "not_null", "password", "password is empty.");
		}
		$ip_array[] = array("user_type", $ip['user_type'], "not_null", "user_type", "Wrong or Invalid user_type.");
		$ip_array[] = array("is_social_media_user", $ip['is_social_media_user'], "not_null", "is_social_media_user", "Wrong or Invalid is_social_media_user.");
		$ip_array[] = array("email", $ip['email'], "not_null", "email", "Wrong or Invalid email.");
		$ip_array[] = array("name", $ip['name'], "not_null", "name", "Wrong or Invalid name.");
		$ip_array[] = array("tag_name", $ip['tag_name'], "not_null", "tag_name", "Wrong or Invalid tag_name.");
		// $ip_array[] = array("description", $ip['description'], "not_null", "description", "Wrong or Invalid description.");
		$ip_array[] = array("zipcode", $ip['zipcode'], "not_null", "zipcode", "Wrong or Invalid zipcode.");
		
		$ipJson = json_encode($ip);
		//validation
		$validation_array = 1;
		
		$validation_array = $this->validator->validate($ip_array);
				if ($validation_array !=1) {
					$data['message'] = $validation_array;
					$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
				} 
		
		
				else if ($ip['is_social_media_user'] == 1 && $this->user_model->check_social_media_id($ip['email'],$ip['social_media_user_id'])) {
						// print_r($result); exit;
						$result = $this->user_model->check_social_media_id($ip['email'],$ip['social_media_user_id']);
						$data['user_id']= $result[0]->user_id; 
						$data['user_type']= $result[0]->user_type_id; 
						$data['message'] = 'Social media id is already registered!';
						$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
						/*$data['message'] = 'The email address associated with this social media account has already been used.  Please choose the social media account you first used to sign into Seekahoo';*/
					}
			
				else if ($ip['is_social_media_user'] == 2 && $this->user_model->check_email($ip['email'])) {
					$data['message'] = 'Email address already registered!';
					$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
					}
					
					
				else {
					   if($ip['zipcode']) {
								$coordinates = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($ip['zipcode']) . '&sensor=true');
								$coordinates = json_decode($coordinates);
				 
								$ip['latitude'] = $coordinates->results[0]->geometry->location->lat;
								$ip['longitude'] = $coordinates->results[0]->geometry->location->lng;	
					}
						
			$retVals = $this->user_model->user_sign_up($ip, $serviceName);
			// echo "<pre>"; echo json_decode($retVals)->data->user_id; exit;
			$user_id = json_decode($retVals)->data->user_id;
			if(json_decode($retVals)->status == 'success') {
			
					$result = $this->sendwelcomeemail($user_id, $ip['email'],$ip['name'], $ip['user_type']);					
			}			
		}
		header("content-type: application/json");
		echo $retVals;
	//call mandrill function to generate seekahoo welcome email.
     // if ($retVals == "success") 
	  //{
		//$result = $this->skhoocommon->sendwelcomeemail($ip['email'],$ip['name'], $ip['user_type']);		
	  //}
		exit;
	}
	
	
		function sendwelcomeemail($user_id, $toemail,$tousername, $usertype)
			{
			
				$api_key = 'YRXhN8UPpCP4HrRrFIahsQ'; //Mandrill API Key
				$subject = 'Welcome to Seekahoo'; //subject
				$from = 'support@seekahoo.com';
				$email_id = $toemail; // recipient emailaddress
				$uri = 'https://mandrillapp.com/api/1.0/messages/send-template.json';
				$user_name = $tousername; //username/businesssname
				$templatename = "";
				//templates
				$business_template ="Seekahoo_Business_Welcome_Email";
				$user_template ="Seekahoo_Welcome_Email";
				
				if ($usertype == "1") {
					$templatename = $user_template;
				} else {
				   $templatename = $business_template;
				}
				
				
				//added for user preference on subscription
				$enc_user_id = base64_encode($user_id);
				$query_string = "kDrgfHfj=".$enc_user_id;
				$url = "http://www.seekahoo.com/preference.php?".$query_string;
				
				
				//json template and email details
				$postString = '{
					"key": "' . $api_key . '",
					"template_name": "' . $templatename . '",
					"template_content": [
						{
							"name": "CEMAIL",
							"content": "support@seekahoo.com"
						}
					],
					"message": {
						"html": "<p>Seekahoo</p>",
						"subject": "' . $subject . '",
						"from_email": "' . $from . '",
						"from_name": "Seekahoo",
						"to": [
							{
								"email": "' . $email_id . '",
								"name": "' . $user_name . '",
								"type": "to"
							}
						],        
						"important": false,
						"track_opens": null,
						"track_clicks": null,
						"auto_text": null,
						"auto_html": null,
						"inline_css": null,
						"url_strip_qs": null,
						"preserve_recipients": null,
						"view_content_link": null,
						"bcc_address": null,
						"tracking_domain": null,
						"signing_domain": null,
						"return_path_domain": null,
						"merge": true,
						"merge_language": "mailchimp",
						"global_merge_vars": [
							{
								"name": "NAME",
								"content": "' . $user_name . '"
							}
						],       	
						 "merge_vars": [
							{
								"rcpt": "' . $email_id . '",
								"vars": [
									{
										
												"name":"UNSUB",
												"content": "' . $url . '"					
									},
							{
											"name": "UEMAIL",
											"content": "' . $toemail . '"
										}
								]
						 
							}
						]
						 },
					"async": false
				}';
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $uri);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true );
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
				$result = curl_exec($ch);
				//print_r($result);
				
		}

	
	function add_view_details_post() {
		$serviceName = 'add_view_details';
		//getting posted values
		$ip['user_id'] = trim($this->input->post('user_id'));
		$ip['view_no'] = trim($this->input->post('view_no'));
		$validation_array = 1;
		$ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "Wrong or Invalid user_id.");
		$ip_array[] = array("view_no", $ip['view_no'], "not_null", "view_no", "view_no is empty.");
		$ipJson = json_encode($ip);
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->user_model->add_view_details($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
		
}

