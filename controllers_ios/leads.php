<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require('application/libraries/REST_Controller.php');  


class Leads extends REST_Controller {

	public function Leads() {
		parent::__construct();
		$this->load->model('leads_model');
	}
	
	function get_sub_job_tags_post() {
		$serviceName = 'get_sub_job_tags';
		$ip['job_tag_id'] = trim($this->input->post('job_tag_id'));
		$ipJson = json_encode($ip);
		//validation
		$validation_array = 1;
		$ip_array[] = array("job_tag_id", $ip['job_tag_id'], "not_null", "job_tag_id", "job_tag_id is empty.");
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->leads_model->get_sub_job_tags($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	/*function get_time_frame_post() {
		$serviceName = 'get_time_frame';
		$retVals = $this->leads_model->get_time_frame($serviceName);
		header("content-type: application/json");
		echo $retVals;
		exit;
	}*/
	
	
	function get_project_questions_post() {
		$serviceName = 'get_project_questions';
		$ip['sub_job_tag_id'] = trim($this->input->post('sub_job_tag_id'));
		$ipJson = json_encode($ip);
		//validation
		$validation_array = 1;
		$ip_array[] = array("sub_job_tag_id", $ip['sub_job_tag_id'], "not_null", "sub_job_tag_id", "sub_job_tag_id is empty.");
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->leads_model->get_project_questions($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	
	function get_contact_info_post() {
		$serviceName = 'get_contact_info';
		$ip['user_id'] = trim($this->input->post('user_id'));
		$ipJson = json_encode($ip);
		//validation
		$validation_array = 1;
		$ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "user_id is empty.");
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->leads_model->get_contact_info($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	
	function add_project_post(){
		$serviceName = 'add_project';
		$flag=12;
		//getting posted values
		$ip['user_id'] = trim($this->input->post('user_id'));
		
		$ip['job_tags'] = trim($this->input->post('job_tags'));
		// $ip['job_tags'] = '{"job_tags":[{"hash_tag":"#Carpets"}]}';
		$ip['sub_job_tags'] = trim($this->input->post('sub_job_tags'));
		// $ip['sub_job_tags'] = '{"sub_job_tags":[{"sub_job_tags":"#Carpets"}]}';
		$ip['questions'] = trim($this->input->post('questions'));
		$ip['answers'] = trim($this->input->post('answers'));
		$ip['describe'] = trim($this->input->post('describe'));
		$ip['media_id1'] = trim($this->input->post('media_id1'));
		$ip['media_id2'] = trim($this->input->post('media_id2'));
		$ip['media_id3'] = trim($this->input->post('media_id3'));
		
		$ip['first_name'] = trim($this->input->post('first_name'));
		$ip['last_name'] = trim($this->input->post('last_name'));
		$ip['address'] = trim($this->input->post('address'));
		$ip['zipcode'] = trim($this->input->post('zipcode'));
		$ip['phone_number'] = trim($this->input->post('phone_number'));
		$ip['email'] = trim($this->input->post('email'));
		
		// $ip['is_private_profile'] = trim($this->input->post('is_private_profile'));
		
		
		$ipJson = json_encode($ip);
		//validation
		$validation_array = 1;
		$ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "user_id is empty.");
		$ip_array[] = array("job_tags", $ip['job_tags'], "not_null", "job_tags", "job_tags is empty.");
		$ip_array[] = array("sub_job_tags", $ip['sub_job_tags'], "not_null", "sub_job_tags", "sub_job_tags is empty.");
		$ip_array[] = array("questions", $ip['questions'], "not_null", "questions", "questions is empty.");
		$ip_array[] = array("answers", $ip['answers'], "not_null", "answers", "answers is empty.");
		$ip_array[] = array("describe", $ip['describe'], "not_null", "describe", "describe is empty.");
		// $ip_array[] = array("media_id", $ip['media_id'], "not_null", "media_id", "media_id is empty.");
		$ip_array[] = array("first_name", $ip['first_name'], "not_null", "first_name", "first_name is empty.");
		$ip_array[] = array("last_name", $ip['last_name'], "not_null", "last_name", "last_name is empty.");
		$ip_array[] = array("address", $ip['address'], "not_null", "address", "address is empty.");
		$ip_array[] = array("zipcode", $ip['zipcode'], "not_null", "zipcode", "zipcode is empty.");
		$ip_array[] = array("phone_number", $ip['phone_number'], "not_null", "phone_number", "phone_number is empty.");
		$ip_array[] = array("email", $ip['email'], "not_null", "email", "email is empty.");
		// $ip_array[] = array("is_private_profile", $ip['is_private_profile'], "not_null", "is_private_profile", "is_private_profile is empty.");
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->leads_model->add_project($ip, $flag, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	function get_my_project_post() {
		$serviceName = 'get_my_project';
		$ip['user_id'] = trim($this->input->post('user_id'));
		$ipJson = json_encode($ip);
		//validation
		$validation_array = 1;
		$ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "user_id is empty.");
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->leads_model->get_my_project($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	
	function get_more_project_details_post() {
		$serviceName = 'get_more_project_details';
		$ip['user_id'] = trim($this->input->post('user_id'));
		$ip['project_id'] = trim($this->input->post('project_id'));
		$ipJson = json_encode($ip);
		//validation
		$validation_array = 1;
		$ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "user_id is empty.");
		$ip_array[] = array("project_id", $ip['project_id'], "not_null", "project_id", "project_id is empty.");
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->leads_model->get_more_project_details($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	
	function make_open_close_post() {
		$serviceName = 'make_open_close';
		$ip['project_id'] = trim($this->input->post('project_id'));
		$ip['status'] = trim($this->input->post('status'));
		$ipJson = json_encode($ip);
		//validation
		$validation_array = 1;
		$ip_array[] = array("project_id", $ip['project_id'], "not_null", "project_id", "project_id is empty.");
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->leads_model->make_open_close($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	
	function delete_project_post() {
		$serviceName = 'delete_project';
		$ip['project_id'] = trim($this->input->post('project_id'));
		$ipJson = json_encode($ip);
		//validation
		$validation_array = 1;
		$ip_array[] = array("project_id", $ip['project_id'], "not_null", "project_id", "project_id is empty.");
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->leads_model->delete_project($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	
	function get_my_leads_post() {
		$serviceName = 'get_my_leads';
		$ip['user_id'] = trim($this->input->post('user_id'));
		$ipJson = json_encode($ip);
		//validation
		$validation_array = 1;
		$ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "user_id is empty.");
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->leads_model->get_my_leads($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	function get_more_lead_details_post() {
		$serviceName = 'get_more_lead_details';
		$ip['leads_id'] = trim($this->input->post('leads_id'));
		$ipJson = json_encode($ip);
		//validation
		$validation_array = 1;
		$ip_array[] = array("leads_id", $ip['leads_id'], "not_null", "leads_id", "leads_id is empty.");
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->leads_model->get_more_lead_details($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	
	function make_accept_post() {
		$serviceName = 'make_accept';
		$ip['leads_id'] = trim($this->input->post('leads_id'));
		$ip['is_view'] = trim($this->input->post('is_view'));
		$ip['status'] = trim($this->input->post('status'));
		$ipJson = json_encode($ip);
		//validation
		$validation_array = 1;
		$ip_array[] = array("leads_id", $ip['leads_id'], "not_null", "leads_id", "leads_id is empty.");
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->leads_model->make_accept($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	
}