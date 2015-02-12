<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	
require(APPPATH.'libraries/REST_Controller.php');  

class push extends REST_Controller {
	
	public function push() {
    	parent::__construct();
		$this->load->model('push_model');
		$this->load->library('push_notification');
	}

	function  add_deviceid_post(){
		$serviceName = 'add_deviceid';
		$ip['user_id'] = $this->input->post('user_id');
	//	$ip['device_id'] = $this->input->post('device_id');
		$ip['device_token'] = $this->input->post('device_token');
		$ipJson = json_encode($ip);
		if (empty($ip['user_id']) || empty($ip['device_token']) ) {
			$data['message'] = 'Required fields are empty';
			// $retVals = $this->privue_lib->return_status('error', $serviceName, $data, $ipJson);
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->push_model->add_device($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
   }
   
   function send_verification_code_post() {
		$serviceName = 'send_verification_code';
		//getting posted values
		$ip['phone_number'] = trim($this->input->post('phone_number'));
		$ipJson = json_encode($ip);
		//validation
		$validation_array = 1;
		$ip_array[] = array("phone_number", $ip['phone_number'], "not_null", "phone_number", "phone_number is empty.");
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		}
		else if ($this->push_model->check_phone($ip['phone_number'])) {
				$data['message'] = 'This phone number is already registered!';
				$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
			}
		else {
			$retVals = $this->push_model->send_verification_code($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	function send_verification_code_email_post() {
		$serviceName = 'send_verification_code_email';
		//getting posted values
		$ip['email_id'] = trim($this->input->post('email_id'));
		$ipJson = json_encode($ip);
		//validation
		$validation_array = 1;
		$ip_array[] = array("email_id", $ip['email_id'], "not_null", "email_id", "Email address is empty.");
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else if ($this->push_model->check_email($ip['email_id'])) {
				$data['message'] = 'Email address is already registered!';
				$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
			}
		else {
			$retVals = $this->push_model->send_verification_code_email($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	 function send_notification_post(){
		 $message= 'hi'; 
		 $view_id = 15;
		 $device_tokens = array('0ca25a029a0fd2eec396f7dfd0e191c58de8a39ebbdcacc02b7b958765967229','c8efcbcd5a15121ec0e83db5b3282f0a1b628676064d944c3e7028cf24521b6c','0ee410f41f12e6ee3dd68d7f1ceb5b9c70543e212e5683b1cf1ea019579b69f6','d628d66c8561e867b787c2d7a7aa01b37cfce4b638a8af25bd00094c57749502','263b23e40dfda980840251d11a48cebf1338ab1beb00b99f50663e15eca363f3','07a6134f13e6f8a687be6497fe02ee0478dfba0420a05d0668e76d1b7787f45d','f40f1b5d97c7457b69c7a83347a347e046258a82eaa6672aa231102c84541872');
	 	$retVals = $this->push_notification->send_notification($message, $device_tokens);
		echo $retVals;
		exit;
	 }
	 
	 function test_url_post(){
	 	// $retVals = $this->push_model->add_value($message, $device_tokens);
		// $sam = json_encode($_POST);
		$addArray = array(
			'phone_number' => '11111111',
			'unique_id' => 55,
			'response_content' => 'welcome',
			'is_post' => date('Y-m-d H:i:s'),
			'response_received_date' => date('Y-m-d H:i:s'),
		);
		echo date('Y-m-d H:i:s'); echo "<br>";
		for($i=0; $i< 10000; $i++) {
		$insert = $this->db->insert('feedback_response', $addArray);
		}
		echo date('Y-m-d H:i:s'); echo "<br>";
		echo "completed"; echo "<br>";
		exit;
	 }
	 
	 
	 function send_sms_post(){
		 $this->load->library('twilio');

		$from = '+15005550006';
		$to = '+919003868987';
		$message = 'This is a test...';

		$response = $this->twilio->sms($from, $to, $message);


		if($response->IsError)
			echo 'Error: ' . $response->ErrorMessage;
		else
			echo 'Sent message to ' . $to;

		// echo "success";
		exit;
	 }

}
	
/* End of file users.php */
/* Location: ./application/controllers/users.php */