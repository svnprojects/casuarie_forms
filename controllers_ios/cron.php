cxzc<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require('application/libraries/REST_Controller.php');  


class Cron extends CI_Controller {

	public function Cron() {
		parent::__construct();
		$this->load->model('cron_model');
	}
	
	function clear_user_activity() {
		//getting posted values
		
			$unixtime = strtotime('-3 month');
			$date = date("Y-m-d h:i:s",$unixtime);
			// echo $date; exit;
			
			$this->db->where('user_activity_created_date <=',$date); 
			$this->db->delete('user_activity');
			
		/*header("content-type: application/json");
		echo $retVals;*/
		exit;
	}	
	
	function mail_chimp() {
		
		// Settings
		$mcApi 	  = '36447687f0cee01e74b318b11e79fa41-us9'; // Your MailChimp API key
		$mcListId = '1'; // Your list ID


		include('MailChimp.php');
		
		// Create the wrapper object
		$mc = new \Drewm\MailChimp($mcApi);
		
		// Subscribe a user
		$result = $mc->call('lists/subscribe', array(
			'id'                => $mcListId,
			'email'             => array('email'=>'rajsmoney@yahoo.com'),
			'merge_vars'        => array('FNAME'=>'Raj', 'LNAME'=>'Gopal'),
			'double_optin'      => false,
			'update_existing'   => true,
			'send_welcome'      => true
		));
		
		if($result)
			var_dump($result);
		else
			echo "There was an issue sending the request.";

	}
	
}