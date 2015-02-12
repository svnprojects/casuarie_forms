<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require('application/libraries/REST_Controller.php');  


class Settings extends REST_Controller {

	public function Settings() {
		parent::__construct();
		$this->load->model('setting_model');
	}


	function update_settings_post() {
		$serviceName = 'update_settings';
		$ip['user_id'] = trim($this->input->post('user_id'));
		$ip['is_private_post'] = trim($this->input->post('is_private_post'));
		$ip['share_pref'] = trim($this->input->post('share_pref')); //   {"sharing_pref" : [{"preference":"facebook"},{"preference":"twitter"}]}
		$ip['req_auth'] = trim($this->input->post('req_auth'));
		$ip['notification'] = trim($this->input->post('notification'));
		$ipJson = json_encode($ip);
		//validation
		$validation_array = 1;
		$ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "user_id is empty.");
		// $ip_array[] = array("is_private_post", $ip['is_private_post'], "not_null", "is_private_post", "is_private_post is empty.");
		// $ip_array[] = array("req_auth", $ip['req_auth'], "not_null", "req_auth", "req_auth is empty.");
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->setting_model->update_settings($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	function get_user_settings_post() {
		$serviceName = 'get_user_settings';
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
			$retVals = $this->setting_model->get_user_settings($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	
}
