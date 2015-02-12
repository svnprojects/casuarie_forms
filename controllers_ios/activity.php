<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require('application/libraries/REST_Controller.php');  


class Activity extends REST_Controller {

	public function Activity() {
		parent::__construct();
		$this->load->model('activity_model');
	}
	
	function add_favorite_post() {
		$serviceName = 'add_favorite';
		//getting posted values
		$ip['post_id'] = trim($this->input->post('post_id'));
		$ip['user_id'] = trim($this->input->post('user_id'));
		$ipJson = json_encode($ip);
		//validation
		$validation_array = 1;
		$ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "user_id is empty.");
		$ip_array[] = array("post_id", $ip['post_id'], "not_null", "post_id", "post_id is empty.");
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->activity_model->add_favorite($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	function add_reported_abuse_post() {
		$serviceName = 'add_reported_abuse';
		//getting posted values
		$ip['post_id'] = trim($this->input->post('post_id'));
		$ip['user_id'] = trim($this->input->post('user_id'));
		$ipJson = json_encode($ip);
		//validation
		$validation_array = 1;
		$ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "user_id is empty.");
		$ip_array[] = array("post_id", $ip['post_id'], "not_null", "post_id", "post_id is empty.");
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->activity_model->add_reported_abuse($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	function invite_friend_post() {
		$serviceName = 'invite_friend';
		//getting posted values
		$ip['user_id'] = trim($this->input->post('user_id'));
		$ip['name'] = trim($this->input->post('name'));
		$ip['social_media_user_id'] = trim($this->input->post('social_media_user_id'));
		$ip['friend_email_id'] = trim($this->input->post('friend_email_id'));
		$ip['friend_phone_number'] = trim($this->input->post('friend_phone_number'));
		$ipJson = json_encode($ip);
		//validation
		$validation_array = 1;
		$ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "user_id is empty.");
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else if ($ip['social_media_user_id'] == "" && $ip['friend_email_id']!= "") {
		
							$this->load->library('email');
							$config = array (
									  'mailtype' => 'html',
									  'charset'  => 'utf-8',
									  'priority' => '1'
									   );
							$this->email->initialize($config);
							$this->email->from('admin@seekahoo.com', 'Seekahoo');
							$this->email->to($ip['friend_email_id']);
							$this->email->subject('Invitation from seekahoo');
							
							$message= $ip['name']." has invited you to join Seekahoo. Click on the link below to download the app from the App Store. https://itunes.apple.com/us/app/seekahoo/id922497295?ls=1&mt=8.";
	
							$this->email->message($message);
							
							if($this->email->send()) {
								$retVals = $this->activity_model->add_invite($ip, $serviceName);
							}	
							else {
								$data['message'] = "Failed sending mail";
								$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
							}
		} 
		else if ($ip['social_media_user_id'] == "" && $ip['friend_phone_number']!= "") {
		
							$this->load->library('twilio');

							$from = '+14124555440';
							$to = $ip['friend_phone_number'];
					
							$message = $ip['name']." has invited you to join Seekahoo. Click on the link below to download the app from the App Store. https://itunes.apple.com/us/app/seekahoo/id922497295?ls=1&mt=8.";
			
							$response = $this->twilio->sms($from, $to, $message);
			
							if($response->IsError) {
								$data['message'] = 'Error: ' . $response->ErrorMessage;
								$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
							}	
							else {
								$retVals = $this->activity_model->add_invite($ip, $serviceName);
							}
		} 
		else {
			$retVals = $this->activity_model->add_invite($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	function accept_invite_post() {
		$serviceName = 'accept_invite';
		//getting posted values
		$ip['user_id'] = trim($this->input->post('user_id'));
		$ip['social_media_user_id'] = trim($this->input->post('social_media_user_id'));
		$ip['friend_email_id'] = trim($this->input->post('friend_email_id'));
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
			$retVals = $this->activity_model->accept_invite($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	function add_follow_post() {
		$serviceName = 'add_follow';
		$flag=5;
		//getting posted values
		$ip['user_id'] = trim($this->input->post('user_id'));
		$ip['friend_user_id'] = trim($this->input->post('friend_user_id'));
		$ip['social_media_user_id'] = trim($this->input->post('social_media_user_id'));
		$ip['friend_email_id'] = trim($this->input->post('friend_email_id'));
		$ip['friend_phone_number'] = trim($this->input->post('friend_phone_number'));
		$ipJson = json_encode($ip);
		//validation
		$validation_array = 1;
		$ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "user_id is empty.");
		$ip_array[] = array("friend_user_id", $ip['friend_user_id'], "not_null", "friend_user_id", "friend_user_id is empty.");
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->activity_model->add_follow($ip,$flag,$serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	function follow_all_post() {
		$serviceName = 'follow_all';
		$flag=5;
		//getting posted values
		$ip['user_id'] = trim($this->input->post('user_id'));
		$ip['friend_users'] = trim($this->input->post('friend_users'));
		// $ip['friend_users'] ='{"friend_users":[{"friend_user_id":"8","friend_social_media_user_id":"","friend_email_id":"kate-bell@mac.com","friend_phone_number":"5555648583"},{"friend_user_id":"8","friend_social_media_user_id":"","friend_email_id":"d-higgins@mac.com","friend_phone_number":"5554787672"},{"friend_user_id":"8","friend_social_media_user_id":"","friend_email_id":"John-Appleseed@mac.com","friend_phone_number":"8885555512"}]}';
		$ipJson = json_encode($ip);
		//validation
		$validation_array = 1;
		$ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "user_id is empty.");
		$ip_array[] = array("friend_users", $ip['friend_users'], "not_null", "friend_users", "friend_users is empty.");
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->activity_model->follow_all($ip,$flag,$serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	function accept_follow_post() {
		$serviceName = 'accept_follow';
		$flag=5;
		//getting posted values
		$ip['user_id'] = trim($this->input->post('user_id'));
		$ip['friend_user_id'] = trim($this->input->post('friend_user_id'));
		$ip['social_media_user_id'] = trim($this->input->post('social_media_user_id'));
		$ip['friend_email_id'] = trim($this->input->post('friend_email_id'));
		$ipJson = json_encode($ip);
		//validation
		$validation_array = 1;
		$ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "user_id is empty.");
		$ip_array[] = array("friend_user_id", $ip['friend_user_id'], "not_null", "friend_user_id", "friend_user_id is empty.");
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->activity_model->accept_follow($ip,$flag,$serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	
	function add_unfollow_post() {
		$serviceName = 'add_unfollow';
		//getting posted values
		$ip['user_id'] = trim($this->input->post('user_id'));
		$ip['friend_user_id'] = trim($this->input->post('friend_user_id'));
		$ipJson = json_encode($ip);
		//validation
		$validation_array = 1;
		$ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "user_id is empty.");
		$ip_array[] = array("friend_user_id", $ip['friend_user_id'], "not_null", "friend_user_id", "friend_user_id is empty.");
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->activity_model->add_unfollow($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	function friend_status_post() {
		$serviceName = 'friend_status';
		//getting posted values
		
		 $ip['users'] = trim($this->input->post('users'));
		 // $ip['users'] ='{"users":[{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"kate-bell@mac.com","friend_phone_number":"5555648583"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"d-higgins@mac.com","friend_phone_number":"5554787672"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"John-Appleseed@mac.com","friend_phone_number":"8885555512"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"anna-haro@mac.com","friend_phone_number":"5555228243"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"hank-zakroff@mac.com","friend_phone_number":"5557664823"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"(null)","friend_phone_number":"5556106679"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"cganesh88@facebook.com","friend_phone_number":"(null)"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"vhvardhanreddy@facebook.com","friend_phone_number":"919008759854"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"ananth.nagarajan.50@facebook.com","friend_phone_number":"(null)"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"chinturj@gmail.com","friend_phone_number":"(null)"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"(null)","friend_phone_number":"918344444033"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"jamshu.kp@facebook.com","friend_phone_number":"(null)"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"sonudec24@gmail.com","friend_phone_number":"(null)"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"sridhar.ras@facebook.com","friend_phone_number":"919789580304"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"rajkishore.kumar.545@facebook.com","friend_phone_number":"(null)"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"shankaronvengeance@gmail.com","friend_phone_number":"(null)"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"vignesh.kumar.503@facebook.com","friend_phone_number":"(null)"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"rejin.mukundan@facebook.com","friend_phone_number":"(null)"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"kumar55suresh@facebook.com","friend_phone_number":"(null)"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"vs.theshant@facebook.com","friend_phone_number":"(null)"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"jamespaul.adukalil@facebook.com","friend_phone_number":"(null)"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"1735742178@facebook.com","friend_phone_number":"(null)"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"sanjukrishnang@facebook.com","friend_phone_number":"(null)"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"sidhantkumar.tiwari@facebook.com","friend_phone_number":"919790982308"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"oommen.ak@facebook.com","friend_phone_number":"(null)"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"adithyananilkumar@facebook.com","friend_phone_number":"(null)"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"(null)","friend_phone_number":"61498268885"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"er.janarthanan@gmail.com","friend_phone_number":"(null)"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"rajesh.eee.pvp@facebook.com","friend_phone_number":"(null)"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"100001767559058@facebook.com","friend_phone_number":"(null)"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"danial712@gmail.com","friend_phone_number":"(null)"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"pradeep.mjp7@facebook.com","friend_phone_number":"919444547347"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"nithin.kavintarikath@facebook.com","friend_phone_number":"97455109507"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"binugopi1986@gmail.com","friend_phone_number":"(null)"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"(null)","friend_phone_number":"919894821754"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"shan@shanmuganathan.in","friend_phone_number":"(null)"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"priyadarsh777@gmail.com","friend_phone_number":"(null)"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"manojkranti@facebook.com","friend_phone_number":"(null)"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"manu.mohan.7796@facebook.com","friend_phone_number":"919567867175"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"100002749818686@facebook.com","friend_phone_number":"(null)"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"(null)","friend_phone_number":"919566479888"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"bharan.ninja@gmail.com","friend_phone_number":"(null)"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"rathishp4@gmail.com","friend_phone_number":"(null)"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"1455487447@facebook.com","friend_phone_number":"918147477112"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"prasanna.rkv@gmail.com","friend_phone_number":"(null)"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"harimohanrai@gmail.com","friend_phone_number":"(null)"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"jesu.dass.796@facebook.com","friend_phone_number":"(null)"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"(null)","friend_phone_number":"(null)"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"(null)","friend_phone_number":"971556671450"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"bipin.jacob.7@facebook.com","friend_phone_number":"(null)"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"(null)","friend_phone_number":"2015552398"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"(null)","friend_phone_number":"3331560987"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"(null)","friend_phone_number":"7124779070"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"(null)","friend_phone_number":"5438880123"}]}';
		
		$ipJson = json_encode($ip);
		//validation
		$validation_array = 1;
		
		$ip_array[] = array("users", $ip['users'], "not_null", "users", "users is empty.");
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->activity_model->friend_status($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	
	function friend_status_android_post() {
		$serviceName = 'friend_status_android';
		//getting posted values
		
		 $ip['users'] = trim($this->input->post('users'));
		 // $ip['users'] ='{"users":[{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"kate-bell@mac.com","friend_phone_number":"5555648583"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"d-higgins@mac.com","friend_phone_number":"5554787672"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"John-Appleseed@mac.com","friend_phone_number":"8885555512"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"anna-haro@mac.com","friend_phone_number":"5555228243"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"hank-zakroff@mac.com","friend_phone_number":"5557664823"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"(null)","friend_phone_number":"5556106679"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"cganesh88@facebook.com","friend_phone_number":"(null)"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"vhvardhanreddy@facebook.com","friend_phone_number":"919008759854"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"ananth.nagarajan.50@facebook.com","friend_phone_number":"(null)"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"chinturj@gmail.com","friend_phone_number":"(null)"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"(null)","friend_phone_number":"918344444033"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"jamshu.kp@facebook.com","friend_phone_number":"(null)"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"sonudec24@gmail.com","friend_phone_number":"(null)"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"sridhar.ras@facebook.com","friend_phone_number":"919789580304"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"rajkishore.kumar.545@facebook.com","friend_phone_number":"(null)"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"shankaronvengeance@gmail.com","friend_phone_number":"(null)"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"vignesh.kumar.503@facebook.com","friend_phone_number":"(null)"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"rejin.mukundan@facebook.com","friend_phone_number":"(null)"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"kumar55suresh@facebook.com","friend_phone_number":"(null)"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"vs.theshant@facebook.com","friend_phone_number":"(null)"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"jamespaul.adukalil@facebook.com","friend_phone_number":"(null)"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"1735742178@facebook.com","friend_phone_number":"(null)"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"sanjukrishnang@facebook.com","friend_phone_number":"(null)"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"sidhantkumar.tiwari@facebook.com","friend_phone_number":"919790982308"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"oommen.ak@facebook.com","friend_phone_number":"(null)"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"adithyananilkumar@facebook.com","friend_phone_number":"(null)"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"(null)","friend_phone_number":"61498268885"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"er.janarthanan@gmail.com","friend_phone_number":"(null)"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"rajesh.eee.pvp@facebook.com","friend_phone_number":"(null)"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"100001767559058@facebook.com","friend_phone_number":"(null)"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"danial712@gmail.com","friend_phone_number":"(null)"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"pradeep.mjp7@facebook.com","friend_phone_number":"919444547347"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"nithin.kavintarikath@facebook.com","friend_phone_number":"97455109507"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"binugopi1986@gmail.com","friend_phone_number":"(null)"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"(null)","friend_phone_number":"919894821754"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"shan@shanmuganathan.in","friend_phone_number":"(null)"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"priyadarsh777@gmail.com","friend_phone_number":"(null)"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"manojkranti@facebook.com","friend_phone_number":"(null)"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"manu.mohan.7796@facebook.com","friend_phone_number":"919567867175"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"100002749818686@facebook.com","friend_phone_number":"(null)"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"(null)","friend_phone_number":"919566479888"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"bharan.ninja@gmail.com","friend_phone_number":"(null)"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"rathishp4@gmail.com","friend_phone_number":"(null)"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"1455487447@facebook.com","friend_phone_number":"918147477112"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"prasanna.rkv@gmail.com","friend_phone_number":"(null)"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"harimohanrai@gmail.com","friend_phone_number":"(null)"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"jesu.dass.796@facebook.com","friend_phone_number":"(null)"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"(null)","friend_phone_number":"(null)"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"(null)","friend_phone_number":"971556671450"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"bipin.jacob.7@facebook.com","friend_phone_number":"(null)"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"(null)","friend_phone_number":"2015552398"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"(null)","friend_phone_number":"3331560987"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"(null)","friend_phone_number":"7124779070"},{"user_id":"8","friend_social_media_user_id":"","friend_email_id":"(null)","friend_phone_number":"5438880123"}]}';
		
		$ipJson = json_encode($ip);
		//validation
		$validation_array = 1;
		
		$ip_array[] = array("users", $ip['users'], "not_null", "users", "users is empty.");
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->activity_model->friend_status_android($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	
	function search_history_post() {
		$serviceName = 'add_search_history';
		//getting posted values
		$ip['user_id'] = trim($this->input->post('user_id'));
		$ip['search_keyword'] = trim($this->input->post('search_keyword'));
		$ipJson = json_encode($ip);
		//validation
		$validation_array = 1;
		$ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "user_id is empty.");
		$ip_array[] = array("search_keyword", $ip['search_keyword'], "not_null", "search_keyword", "search_keyword is empty.");
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->activity_model->add_search_keyword($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	function get_search_history_post() {
	
		$serviceName = 'get_search_history';
		//getting posted values
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
			$retVals = $this->activity_model->search_history_retrieve($ip, $serviceName);
		}
		
		header("content-type: application/json");
		echo $retVals;
		exit;
	}	
	
	function clear_search_history_post() {
		$serviceName = 'clear_search_history';
		//getting posted values
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
			$retVals = $this->activity_model->clear_search_keyword($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}		
	
	function user_endorse_post() {
		$serviceName = 'user_endorse';
		$flag=7;
		//getting posted values
		$ip['user_id'] = trim($this->input->post('user_id'));
		$ip['friend_user_id'] = trim($this->input->post('friend_user_id'));
		$ipJson = json_encode($ip);
		//validation
		$validation_array = 1;
		$ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "user_id is empty.");
		$ip_array[] = array("friend_user_id", $ip['friend_user_id'], "not_null", "friend_user_id", "friend_user_id is empty.");
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->activity_model->add_endorse($ip,$flag,$serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	function user_unendorse_post() {
		$serviceName = 'user_unendorse';
		//getting posted values
		$ip['user_id'] = trim($this->input->post('user_id'));
		$ip['friend_user_id'] = trim($this->input->post('friend_user_id'));
		$ipJson = json_encode($ip);
		//validation
		$validation_array = 1;
		$ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "user_id is empty.");
		$ip_array[] = array("friend_user_id", $ip['friend_user_id'], "not_null", "friend_user_id", "friend_user_id is empty.");
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->activity_model->add_unendorse($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	function view_profile_post() {
		$serviceName = 'view_profile';
		//getting posted values
		$ip['user_id'] = trim($this->input->post('user_id'));
		$ip['notification_user_id'] = trim($this->input->post('notification_user_id'));
		$ip['flag'] = trim($this->input->post('flag'));
		$ipJson = json_encode($ip);
		//validation
		$validation_array = 1;
		$ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "user_id is empty.");
		$ip_array[] = array("notification_user_id", $ip['notification_user_id'], "not_null", "notification_user_id", "notification_user_id is empty.");
		$ip_array[] = array("flag", $ip['flag'], "not_null", "flag", "flag is empty.");
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->activity_model->add_view_profile($ip,$serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	function view_post_post() {
		$serviceName = 'view_post';
		//getting posted values
		$ip['user_id'] = trim($this->input->post('user_id'));
		$ip['notification_user_id'] = trim($this->input->post('notification_user_id'));
		$ip['post_id'] = trim($this->input->post('post_id'));
		$ip['flag'] = trim($this->input->post('flag'));
		$ipJson = json_encode($ip);
		//validation
		$validation_array = 1;
		$ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "user_id is empty.");
		$ip_array[] = array("notification_user_id", $ip['notification_user_id'], "not_null", "notification_user_id", "notification_user_id is empty.");
		$ip_array[] = array("post_id", $ip['post_id'], "not_null", "post_id", "post_id is empty.");
		$ip_array[] = array("flag", $ip['flag'], "not_null", "flag", "flag is empty.");
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->activity_model->add_view_post($ip,$serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	function add_share_post() {
		$serviceName = 'add_share';
		//getting posted values
		$ip['user_id'] = trim($this->input->post('user_id'));
		$ip['post_id'] = trim($this->input->post('post_id'));
		$ip['flag'] = trim($this->input->post('flag'));
		$ipJson = json_encode($ip);
		//validation
		$validation_array = 1;
		$ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "user_id is empty.");
		$ip_array[] = array("post_id", $ip['post_id'], "not_null", "post_id", "post_id is empty.");
		$ip_array[] = array("flag", $ip['flag'], "not_null", "flag", "flag is empty.");
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->activity_model->add_share($ip,$serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	function get_user_activity_post() {
		$serviceName = 'get_user_activity';
		//getting posted values
		$ip['user_id'] = trim($this->input->post('user_id'));
		$ip['scroll_position'] = trim($this->input->post('scroll_position'));
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
			$retVals = $this->activity_model->get_user_activity($ip,$serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	// version 1.1
	function get_user_activity_1_post() {
		$serviceName = 'get_user_activity';
		//getting posted values
		$ip['user_id'] = trim($this->input->post('user_id'));
		$ip['scroll_position'] = trim($this->input->post('scroll_position'));
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
			$retVals = $this->activity_model->get_user_activity_1($ip,$serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	function get_own_user_activity_post() {
		$serviceName = 'get_own_user_activity';
		//getting posted values
		$ip['user_id'] = trim($this->input->post('user_id'));
		$ip['scroll_position'] = trim($this->input->post('scroll_position'));
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
			$retVals = $this->activity_model->get_own_user_activity($ip,$serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	function send_feedback_post() {
		$serviceName = 'send_feedback';
		//getting posted values
		$ip['user_id'] = trim($this->input->post('user_id'));
		$ip['rating'] = trim($this->input->post('rating'));
		$ip['feedback'] = trim($this->input->post('feedback'));
		$ipJson = json_encode($ip);
		//validation
		$validation_array = 1;
		$ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "user_id is empty.");
		$ip_array[] = array("rating", $ip['rating'], "not_null", "rating", "rating is empty.");
		// $ip_array[] = array("feedback", $ip['feedback'], "not_null", "feedback", "feedback is empty.");
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->activity_model->send_feedback($ip,$serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	
	function send_sms_request_post() {
		$serviceName = 'send_sms_request';
		//getting posted values
		$ip['user_id'] = trim($this->input->post('user_id'));
		$ip['first_name'] = trim($this->input->post('first_name'));
		$ip['last_name'] = trim($this->input->post('last_name'));
		$ip['zipcode'] = trim($this->input->post('zipcode'));
		$ip['phone_number'] = trim($this->input->post('phone_number'));
		$ip['media_id'] = trim($this->input->post('media_id'));
		$ip['job_tag'] = trim($this->input->post('job_tag'));
		$ipJson = json_encode($ip);
		//validation
		$validation_array = 1;
		$ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "user_id is empty.");
		$ip_array[] = array("first_name", $ip['first_name'], "not_null", "first_name", "first_name is empty.");
		$ip_array[] = array("last_name", $ip['last_name'], "not_null", "last_name", "last_name is empty.");
		$ip_array[] = array("zipcode", $ip['zipcode'], "not_null", "zipcode", "zipcode is empty.");
		$ip_array[] = array("phone_number", $ip['phone_number'], "not_null", "phone_number", "phone_number is empty.");
		$ip_array[] = array("media_id", $ip['media_id'], "not_null", "media_id", "media_id is empty.");
		$ip_array[] = array("job_tag", $ip['job_tag'], "not_null", "job_tag", "job_tag is empty.");
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->activity_model->send_sms_request($ip,$serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	function get_location_post() {
		$serviceName = 'get_location';
		//getting posted values
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
			$retVals = $this->activity_model->get_location($ip,$serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	function get_response_status_post() {
		$serviceName = 'get_response_status';
		//getting posted values
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
			$retVals = $this->activity_model->get_response_status($ip,$serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	/*function get_response_post() {
		$serviceName = 'get_response';
		//getting posted values
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
			$retVals = $this->activity_model->get_response($ip,$serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}*/
	
}