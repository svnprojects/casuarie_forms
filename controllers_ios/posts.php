<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require('application/libraries/REST_Controller.php');  


class Posts extends REST_Controller {

	public function Posts() {
		parent::__construct();
		$this->load->model('post_model');
	}
	
	function get_job_tags_post() {
		$serviceName = 'get_job_tags';
		$retVals = $this->post_model->get_job_tags($serviceName);
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	function add_post_post(){
		$serviceName = 'add_post';
		$flag1=1;
		$flag2=9;
		//getting posted values
		$ip['post_type'] = trim($this->input->post('post_type'));
		$ip['caption'] = trim($this->input->post('caption'));
		$ip['user_id'] = trim($this->input->post('user_id'));
		$ip['media_id'] = trim($this->input->post('media_id'));
		//$ip['job_tag_id'] = trim($this->input->post('job_tag_id'));
		$ip['hash_tags'] = trim($this->input->post('hash_tags'));
		// $ip['hash_tags'] = '{"hash_tags":[{"hash_tag":"#Carpets"}]}';
		$ip['custom_tags'] = trim($this->input->post('custom_tags'));
		$ip['location'] = "";
		// $ip['custom_tags'] = '{"custom_tags":[{"custom_tag":"@AnbuPersonal","user_id":"12","user_type_id":"1"},{"custom_tag":"@vasu","user_id":"9","user_type_id":"1"},{"custom_tag":"@VasanPersonal","user_id":"23","user_type_id":"1"},{"custom_tag":"@SridharElectricalWorksprivatelimited","user_id":"5","user_type_id":"2"}]}';
		$ipJson = json_encode($ip);
		//validation
		$validation_array = 1;
		// $ip_array[] = array("post_type", $ip['post_type'], "not_null", "post_type", "post_type is empty.");
		// $ip_array[] = array("caption", $ip['caption'], "not_null", "caption", "caption is empty.");
		$ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "user_id is empty.");
		$ip_array[] = array("media_id", $ip['media_id'], "not_null", "media_id", "media_id is empty.");
		// $ip_array[] = array("job_tag_id", $ip['job_tag_id'], "not_null", "job_tag_id", "job_tag_id is empty.");
		// $ip_array[] = array("custom_tags", $ip['custom_tags'], "not_null", "custom_tags", "custom_tags is empty.");
		$ip_array[] = array("hash_tags", $ip['hash_tags'], "not_null", "hash_tags", "hash_tags is empty.");
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->post_model->add_post($ip, $flag1, $flag2, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	function update_likes_post() {
		$serviceName = 'update_likes';
		$flag=6;
		//getting posted values
		$ip['post_id'] = trim($this->input->post('post_id'));
		$ip['user_id'] = trim($this->input->post('user_id'));
		$ip['post_user_id'] = trim($this->input->post('post_user_id'));
		$ipJson = json_encode($ip);
		//validation
		$validation_array = 1;
		$ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "user_id is empty.");
		$ip_array[] = array("post_id", $ip['post_id'], "not_null", "post_id", "post_id is empty.");
		$ip_array[] = array("post_user_id", $ip['post_user_id'], "not_null", "post_user_id", "post_user_id is empty.");
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->post_model->update_likes($ip,$flag,$serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	function add_stamp_post() {
		$serviceName = 'add_stamp';
		$flag=12;
		//getting posted values
		$ip['post_id'] = trim($this->input->post('post_id'));
		$ip['user_id'] = trim($this->input->post('user_id'));
		$ip['post_user_id'] = trim($this->input->post('post_user_id'));
		$ipJson = json_encode($ip);
		//validation
		$validation_array = 1;
		$ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "user_id is empty.");
		$ip_array[] = array("post_id", $ip['post_id'], "not_null", "post_id", "post_id is empty.");
		$ip_array[] = array("post_user_id", $ip['post_user_id'], "not_null", "post_user_id", "post_user_id is empty.");
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->post_model->add_stamp($ip,$flag,$serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	function update_unlike_post() {
		$serviceName = 'update_unlike';
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
			$retVals = $this->post_model->update_unlike($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	function remove_stamp_post() {
		$serviceName = 'remove_stamp';
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
			$retVals = $this->post_model->remove_stamp($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	function update_comments_post() {
		$serviceName = 'update_comments';
		$flag1=4;
		$flag2=10;
		//getting posted values
		$ip['post_id'] = trim($this->input->post('post_id'));
		$ip['user_id'] = trim($this->input->post('user_id'));
		$ip['comment'] = trim($this->input->post('comment'));
		$ip['post_user_id'] = trim($this->input->post('post_user_id'));
		$ip['hash_tags'] = trim($this->input->post('hash_tags'));
		// $ip['hash_tags'] = '{"hash_tags":[{"hash_tag":"#Carpets"}]}';
		$ip['custom_tags'] = trim($this->input->post('custom_tags'));
		// $ip['custom_tags'] = '{"custom_tags":[{"custom_tag":"@AnbuPersonal","user_id":"12","user_type_id":"1"},{"custom_tag":"@vasu","user_id":"9","user_type_id":"1"},{"custom_tag":"@VasanPersonal","user_id":"23","user_type_id":"1"},{"custom_tag":"@SridharElectricalWorksprivatelimited","user_id":"5","user_type_id":"2"}]}';
		$ipJson = json_encode($ip);
		//validation
		$validation_array = 1;
		$ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "user_id is empty.");
		$ip_array[] = array("post_id", $ip['post_id'], "not_null", "post_id", "post_id is empty.");
		$ip_array[] = array("comment", $ip['comment'], "not_null", "comment", "comment is empty.");
		$ip_array[] = array("post_user_id", $ip['post_user_id'], "not_null", "post_user_id", "post_user_id is empty.");
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->post_model->update_comments($ip,$flag1,$flag2,$serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	// version 1.2
	function remove_comments_post() {
		$serviceName = 'remove_comments';
		
		//getting posted values
		$ip['comment_id'] = trim($this->input->post('comment_id'));
		$ip['post_id'] = trim($this->input->post('post_id'));
		$ip['user_id'] = trim($this->input->post('user_id'));
		$ipJson = json_encode($ip);
		//validation
		$validation_array = 1;
		$ip_array[] = array("comment_id", $ip['comment_id'], "not_null", "comment_id", "comment_id is empty.");
		$ip_array[] = array("post_id", $ip['post_id'], "not_null", "post_id", "post_id is empty.");
		$ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "user_id is empty.");
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->post_model->remove_comments($ip,$serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	/*function list_posts_post() {
		$serviceName = 'list_posts';
		$ip['keyword'] = trim($this->input->post('keyword'));
		$ip['flag'] = trim($this->input->post('flag'));
		$ip['scroll_position'] = trim($this->input->post('scroll_position'));
		$ipJson = json_encode($ip);
		//validation
		$validation_array = 1;
		$ip_array[] = array("scroll_position", $ip['scroll_position'], "not_null", "scroll_position", "scroll_position is empty.");
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->post_model->list_posts($serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}*/
	
	function search_by_key_post() {
		$serviceName = 'search_by_key';
		$ip['keyword'] = trim($this->input->post('keyword'));
		$ip['flag'] = trim($this->input->post('flag'));
		$ip['scroll_position'] = trim($this->input->post('scroll_position'));
		$ipJson = json_encode($ip);
		//validation
		$validation_array = 1;
		$ip_array[] = array("keyword", $ip['keyword'], "not_null", "keyword", "keyword is empty.");
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->post_model->search_by_key($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	function search_pros_post() {
		$serviceName = 'search_pros';
		$ip['keyword'] = trim($this->input->post('keyword'));
		$ip['flag'] = trim($this->input->post('flag'));
		$ip['scroll_position'] = trim($this->input->post('scroll_position'));
		$ipJson = json_encode($ip);
		//validation
		$validation_array = 1;
		$ip_array[] = array("scroll_position", $ip['scroll_position'], "not_null", "scroll_position", "scroll_position is empty.");
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->post_model->search_pros($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	
	/*function search_post_list_post() {
		$serviceName = 'search_post_list';
		// $ip['keyword'] = trim($this->input->post('keyword'));
		$ip['flag'] = trim($this->input->post('flag'));
		$ip['tag_id'] = trim($this->input->post('tag_id'));
		$ip['user_id'] = trim($this->input->post('user_id'));
		$ip['scroll_position'] = trim($this->input->post('scroll_position'));
		$ipJson = json_encode($ip);
		//validation
		$validation_array = 1;
		$ip_array[] = array("flag", $ip['flag'], "not_null", "flag", "flag is empty.");
		// $ip_array[] = array("tag_id", $ip['tag_id'], "not_null", "tag_id", "tag_id is empty.");
		// $ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "user_id is empty.");
		$ip_array[] = array("scroll_position", $ip['scroll_position'], "not_null", "scroll_position", "scroll_position is empty.");
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->post_model->search_post_list($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}*/
	
	function recent_posts_post() {
		$serviceName = 'recent_posts';
		$ip['user_id'] = trim($this->input->post('user_id'));
		$ip['distance'] = trim($this->input->post('distance'));
		// $ip['keyword'] = trim($this->input->post('keyword'));
		// $ip['flag'] = trim($this->input->post('flag'));
		$ip['scroll_position'] = trim($this->input->post('scroll_position'));
		$ipJson = json_encode($ip);
		//validation
		$validation_array = 1;
		$ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "user_id is empty.");
		$ip_array[] = array("distance", $ip['distance'], "not_null", "distance", "distance is empty.");
		// $ip_array[] = array("scroll_position", $ip['scroll_position'], "not_null", "scroll_position", "scroll_position is empty.");
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->post_model->recent_posts($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	// version - 1.1
	function recent_posts_1_post() {
		$serviceName = 'recent_posts';
		$ip['user_id'] = trim($this->input->post('user_id'));
		$ip['distance'] = trim($this->input->post('distance'));
		// $ip['keyword'] = trim($this->input->post('keyword'));
		// $ip['flag'] = trim($this->input->post('flag'));
		$ip['scroll_position'] = trim($this->input->post('scroll_position'));
		$ipJson = json_encode($ip);
		//validation
		$validation_array = 1;
		$ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "user_id is empty.");
		$ip_array[] = array("distance", $ip['distance'], "not_null", "distance", "distance is empty.");
		// $ip_array[] = array("scroll_position", $ip['scroll_position'], "not_null", "scroll_position", "scroll_position is empty.");
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->post_model->recent_posts_1($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	function recent_home_post() {
		$serviceName = 'recent_home';
		$ip['user_id'] = trim($this->input->post('user_id'));
		$ip['keyword'] = trim($this->input->post('keyword'));
		$ip['flag'] = trim($this->input->post('flag'));
		$ip['scroll_position'] = trim($this->input->post('scroll_position'));
		$ipJson = json_encode($ip);
		//validation
		$validation_array = 1;
		$ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "user_id is empty.");
		// $ip_array[] = array("scroll_position", $ip['scroll_position'], "not_null", "scroll_position", "scroll_position is empty.");
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->post_model->recent_home($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	function recent_home_more_post() {
		$serviceName = 'recent_home';
		$ip['user_id'] = trim($this->input->post('user_id'));
		$ip['keyword'] = trim($this->input->post('keyword'));
		$ip['flag'] = trim($this->input->post('flag'));
		$ip['scroll_position'] = trim($this->input->post('scroll_position'));
		$ip['distance'] = trim($this->input->post('distance'));
		$ipJson = json_encode($ip);
		//validation
		$validation_array = 1;
		$ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "user_id is empty.");
		$ip_array[] = array("distance", $ip['distance'], "not_null", "distance", "distance is empty.");
		// $ip_array[] = array("scroll_position", $ip['scroll_position'], "not_null", "scroll_position", "scroll_position is empty.");
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->post_model->recent_home_more($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	// version 1.1
	function recent_home_more_1_post() {
		$serviceName = 'recent_home_more';
		$ip['user_id'] = trim($this->input->post('user_id'));
		$ip['keyword'] = trim($this->input->post('keyword'));
		$ip['flag'] = trim($this->input->post('flag'));
		$ip['scroll_position'] = trim($this->input->post('scroll_position'));
		$ip['distance'] = trim($this->input->post('distance'));
		$ipJson = json_encode($ip);
		//validation
		$validation_array = 1;
		$ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "user_id is empty.");
		$ip_array[] = array("distance", $ip['distance'], "not_null", "distance", "distance is empty.");
		// $ip_array[] = array("scroll_position", $ip['scroll_position'], "not_null", "scroll_position", "scroll_position is empty.");
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->post_model->recent_home_more_1($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	/*function explore_posts_post() {
		$serviceName = 'explore_posts';
		$ip['user_id'] = trim($this->input->post('user_id'));
		$ip['keyword'] = trim($this->input->post('keyword'));
		$ip['flag'] = trim($this->input->post('flag'));
		$ip['scroll_position'] = trim($this->input->post('scroll_position'));
		$ipJson = json_encode($ip);
		//validation
		$validation_array = 1;
		$ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "user_id is empty.");
		// $ip_array[] = array("scroll_position", $ip['scroll_position'], "not_null", "scroll_position", "scroll_position is empty.");
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->post_model->explore_posts($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}*/
	
	function suggested_posts_post() {
		$serviceName = 'suggested_posts';
		$ip['user_id'] = trim($this->input->post('user_id'));
		$ip['scroll_position'] = trim($this->input->post('scroll_position'));
		$ip['distance'] = trim($this->input->post('distance'));
		$ipJson = json_encode($ip);
		//validation
		$validation_array = 1;
		$ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "user_id is empty.");
		$ip_array[] = array("distance", $ip['distance'], "not_null", "distance", "distance is empty.");
		// $ip_array[] = array("scroll_position", $ip['scroll_position'], "not_null", "scroll_position", "scroll_position is empty.");
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->post_model->suggested_posts($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	// version 1.1
	function suggested_posts_1_post() {
		$serviceName = 'suggested_posts';
		$ip['user_id'] = trim($this->input->post('user_id'));
		$ip['scroll_position'] = trim($this->input->post('scroll_position'));
		$ip['distance'] = trim($this->input->post('distance'));
		$ipJson = json_encode($ip);
		//validation
		$validation_array = 1;
		$ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "user_id is empty.");
		$ip_array[] = array("distance", $ip['distance'], "not_null", "distance", "distance is empty.");
		// $ip_array[] = array("scroll_position", $ip['scroll_position'], "not_null", "scroll_position", "scroll_position is empty.");
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->post_model->suggested_posts_1($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	function popular_tags_post() {
		$serviceName = 'popular_tags';
		$ip['scroll_position'] = trim($this->input->post('scroll_position'));
		$ipJson = json_encode($ip);
		//validation
		$validation_array = 1;
		$ip_array[] = array("scroll_position", $ip['scroll_position'], "not_null", "scroll_position", "scroll_position is empty.");
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->post_model->popular_tags($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	function popular_tags_post_list_post() {
		$serviceName = 'popular_tags_post_list';
		$ip['scroll_position'] = trim($this->input->post('scroll_position'));
		$ip['tag_title'] = trim($this->input->post('tag_title'));
		$ipJson = json_encode($ip);
		//validation
		$validation_array = 1;
		// $ip_array[] = array("scroll_position", $ip['scroll_position'], "not_null", "scroll_position", "scroll_position is empty.");
		$ip_array[] = array("tag_title", $ip['tag_title'], "not_null", "tag_title", "tag_title is empty.");
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->post_model->popular_tags_post_list($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	function job_tags_post_list_post() {
		$serviceName = 'job_tags_post_list';
		$ip['user_id'] = trim($this->input->post('user_id'));
		$ip['scroll_position'] = trim($this->input->post('scroll_position'));
		$ip['tag_title'] = trim($this->input->post('tag_title'));
		$ipJson = json_encode($ip);
		//validation
		$validation_array = 1;
		$ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "user_id is empty.");
		// $ip_array[] = array("scroll_position", $ip['scroll_position'], "not_null", "scroll_position", "scroll_position is empty.");
		$ip_array[] = array("tag_title", $ip['tag_title'], "not_null", "tag_title", "tag_title is empty.");
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->post_model->job_tags_post_list($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	// version 1.1
	function job_tags_post_list_1_post() {
		$serviceName = 'job_tags_post_list';
		$ip['user_id'] = trim($this->input->post('user_id'));
		$ip['scroll_position'] = trim($this->input->post('scroll_position'));
		$ip['tag_title'] = trim($this->input->post('tag_title'));
		$ipJson = json_encode($ip);
		//validation
		$validation_array = 1;
		$ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "user_id is empty.");
		// $ip_array[] = array("scroll_position", $ip['scroll_position'], "not_null", "scroll_position", "scroll_position is empty.");
		$ip_array[] = array("tag_title", $ip['tag_title'], "not_null", "tag_title", "tag_title is empty.");
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->post_model->job_tags_post_list_1($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	function custom_tags_post_list_post() {
		$serviceName = 'custom_tags_post_list';
		$ip['user_id'] = trim($this->input->post('user_id'));
		$ip['scroll_position'] = trim($this->input->post('scroll_position'));
		$ip['tag_title'] = trim($this->input->post('tag_title'));
		$ipJson = json_encode($ip);
		//validation
		$validation_array = 1;
		$ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "user_id is empty.");
		// $ip_array[] = array("scroll_position", $ip['scroll_position'], "not_null", "scroll_position", "scroll_position is empty.");
		$ip_array[] = array("tag_title", $ip['tag_title'], "not_null", "tag_title", "tag_title is empty.");
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->post_model->custom_tags_post_list($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	function friend_circle_posts_post() {
		$serviceName = 'friend_circle_posts';
		$ip['user_id'] = trim($this->input->post('user_id'));
		// $ip['keyword'] = trim($this->input->post('keyword'));
		// $ip['flag'] = trim($this->input->post('flag'));
		$ip['scroll_position'] = trim($this->input->post('scroll_position'));
		$ipJson = json_encode($ip);
		//validation
		$validation_array = 1;
		$ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "user_id is empty.");
		// $ip_array[] = array("scroll_position", $ip['scroll_position'], "not_null", "scroll_position", "scroll_position is empty.");
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->post_model->friend_circle_posts($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	// version 1.1
	function friend_circle_posts_1_post() {
		$serviceName = 'friend_circle_posts';
		$ip['user_id'] = trim($this->input->post('user_id'));
		// $ip['keyword'] = trim($this->input->post('keyword'));
		// $ip['flag'] = trim($this->input->post('flag'));
		$ip['scroll_position'] = trim($this->input->post('scroll_position'));
		$ipJson = json_encode($ip);
		//validation
		$validation_array = 1;
		$ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "user_id is empty.");
		// $ip_array[] = array("scroll_position", $ip['scroll_position'], "not_null", "scroll_position", "scroll_position is empty.");
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->post_model->friend_circle_posts_1($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	function get_pro_by_category_post() {
		$serviceName = 'get_pro_by_category';
		$ip['category_id'] = trim($this->input->post('category_id'));
		$ip['user_id'] = trim($this->input->post('user_id'));
		$ip['distance'] = trim($this->input->post('distance'));
		// $ip['scroll_position'] = trim($this->input->post('scroll_position'));
		$ipJson = json_encode($ip);
		//validation
		$validation_array = 1;
		$ip_array[] = array("category_id", $ip['category_id'], "not_null", "category_id", "category_id is empty.");
		$ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "user_id is empty.");
		$ip_array[] = array("distance", $ip['distance'], "not_null", "distance", "distance is empty.");		
		// $ip_array[] = array("scroll_position", $ip['scroll_position'], "not_null", "scroll_position", "scroll_position is empty.");
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->post_model->get_pro_by_category($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	/*function get_post_details_post() {
		$serviceName = 'get_post_details';
		$ip['user_id'] = trim($this->input->post('user_id'));
		$ip['post_id'] = trim($this->input->post('post_id'));
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
			$retVals = $this->post_model->get_post_details($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}*/
	
	function get_single_post_details_post() {
		$serviceName = 'get_single_post_details';
		$ip['user_id'] = trim($this->input->post('user_id'));
		$ip['post_id'] = trim($this->input->post('post_id'));
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
			$retVals = $this->post_model->get_single_post_details($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	// version 1.1
	function get_single_post_details_1_post() {
		$serviceName = 'get_single_post_details';
		$ip['user_id'] = trim($this->input->post('user_id'));
		$ip['post_id'] = trim($this->input->post('post_id'));
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
			$retVals = $this->post_model->get_single_post_details_1($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	function get_comments_post() {
		$serviceName = 'get_comments';
		$ip['post_id'] = trim($this->input->post('post_id'));
		$ipJson = json_encode($ip);
		//validation
		$validation_array = 1;
		$ip_array[] = array("post_id", $ip['post_id'], "not_null", "post_id", "post_id is empty.");
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->post_model->get_comments($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	// version 1.1
	function get_comments_1_post() {
		$serviceName = 'get_comments';
		$ip['post_id'] = trim($this->input->post('post_id'));
		$ipJson = json_encode($ip);
		//validation
		$validation_array = 1;
		$ip_array[] = array("post_id", $ip['post_id'], "not_null", "post_id", "post_id is empty.");
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->post_model->get_comments_1($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	function get_liked_users_post() {
		$serviceName = 'get_liked_users';
		$ip['post_id'] = trim($this->input->post('post_id'));
		$ipJson = json_encode($ip);
		//validation
		$validation_array = 1;
		$ip_array[] = array("post_id", $ip['post_id'], "not_null", "post_id", "post_id is empty.");
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->post_model->get_liked_users($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	function get_stamped_users_post() {
		$serviceName = 'get_stamped_users';
		$ip['post_id'] = trim($this->input->post('post_id'));
		$ipJson = json_encode($ip);
		//validation
		$validation_array = 1;
		$ip_array[] = array("post_id", $ip['post_id'], "not_null", "post_id", "post_id is empty.");
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->post_model->get_stamped_users($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	function get_custom_tags_post() {
		$serviceName = 'get_custom_tags';
		$ip['user_id'] = trim($this->input->post('user_id'));
		$ip['user_type'] = trim($this->input->post('user_type'));
		$ipJson = json_encode($ip);
		//validation
		$validation_array = 1;
		$ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "user_id is empty.");
		$ip_array[] = array("user_type", $ip['user_type'], "not_null", "user_type", "user_type is empty.");
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->post_model->get_custom_tags($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	function delete_post_post() {
		$serviceName = 'delete_post';
		$ip['user_id'] = trim($this->input->post('user_id'));
		$ip['post_id'] = trim($this->input->post('post_id'));
		$ip['media_thumb_url'] = trim($this->input->post('media_thumb_url'));
		$ip['media_org_url'] = trim($this->input->post('media_org_url'));
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
			$retVals = $this->post_model->delete_post($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	function delete_favorite_post() {
		$serviceName = 'delete_favorite';
		$ip['user_id'] = trim($this->input->post('user_id'));
		$ip['post_id'] = trim($this->input->post('post_id'));
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
			$retVals = $this->post_model->delete_favorite($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	function get_custom_tags_list_post() {
		$serviceName = 'get_custom_tags_list';
		$retVals = $this->post_model->get_custom_tags_list($serviceName);
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	function get_reviewed_posts_post() {
		$serviceName = 'get_reviewed_posts';
		$ip['user_id'] = trim($this->input->post('user_id'));
		// $ip['scroll_position'] = trim($this->input->post('scroll_position'));
		$ipJson = json_encode($ip);
		//validation
		$validation_array = 1;
		$ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "user_id is empty.");
		// $ip_array[] = array("scroll_position", $ip['scroll_position'], "not_null", "scroll_position", "scroll_position is empty.");
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->post_model->get_reviewed_posts($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	
	function get_post_list_post() {
		$serviceName = 'get_post_list';
		$ip['user_id'] = trim($this->input->post('user_id'));
		$ip['scroll_position'] = trim($this->input->post('scroll_position'));
		$ipJson = json_encode($ip);
		//validation
		$validation_array = 1;
		$ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "user_id is empty.");
		// $ip_array[] = array("scroll_position", $ip['scroll_position'], "not_null", "scroll_position", "scroll_position is empty.");
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->post_model->get_post_list($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	function get_favorite_post_list_post() {
		$serviceName = 'get_favorite_post_list';
		$ip['user_id'] = trim($this->input->post('user_id'));
		$ip['scroll_position'] = trim($this->input->post('scroll_position'));
		$ipJson = json_encode($ip);
		//validation
		$validation_array = 1;
		$ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "user_id is empty.");
		// $ip_array[] = array("scroll_position", $ip['scroll_position'], "not_null", "scroll_position", "scroll_position is empty.");
		$validation_array = $this->validator->validate($ip_array);
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->post_model->get_favorite_post_list($ip, $serviceName);
		}
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	
	function generate_review_posts_post() {
		
		/*ini_set('error_reporting', E_ALL);
		ini_set('display_errors', 1);*/

		$this->load->library('twilio');
	
		// $state = trim($this->input->post('FromState'));
		// $city = trim($this->input->post('FromCity'));
		$body = trim($this->input->post('Body'));
		$phone_number = trim($this->input->post('From'));
		$phone_number = substr($phone_number, 2);
		// $ip['user_id'] = trim($this->input->post('user_id'));
		// $ip['user_id'] = trim($this->input->post('user_id'));
		
		$pos = strpos($body, '#');
					
		if($pos !== false) { 
					
				$unique_id = "#".$body[$pos+1].$body[$pos+2];
				$body = trim(str_replace($unique_id,"",$body));
				
				$this->db->select('feedback_request.*, users.name');
				$this->db->from('feedback_request');
				$this->db->join('users','feedback_request.user_id = users.user_id');
				$this->db->where('feedback_request.phone_number', $phone_number);
				$this->db->where('feedback_request.unique_id', $unique_id);
				$this->db->where('feedback_request.is_response', 0);
				$query = $this->db->get();
				$result = $query->result();
				
					if($result && $result[0]->is_response == 0) {		
						
						$serviceName = 'add_review_post';
						$flag1=11;
						$flag2=9;
						$ip['post_type'] = 4;
						$ip['caption'] = $result[0]->FirstName.' '.$result[0]->LastName.' wrote '.'"'.$body.'"';
						$ip['user_id'] = $result[0]->user_id;
						$ip['media_id'] = $result[0]->media_id;
						$ip['hash_tags'] = $result[0]->job_tag;
						$ip['location'] = $result[0]->location;
						// $ip['location'] = $city.",".$state;
						$business_name = $result[0]->name;
						$user_id = $result[0]->user_id;
										
						$ipJson = json_encode($ip);
						$return = $this->post_model->add_post($ip, $flag1, $flag2, $serviceName);
						$return = json_decode($return); 
						
						if($return->status == 'success') {
						
								$post_id = $return->data->post_id;
						
								$updateArray = array(
											'is_response' => 1,
											'is_post' => 1,
											'response_content' => $body,
											'post_id' => $post_id,
											'status' => '1',
											'response_received_date' => date('Y-m-d H:i:s')
											);
											$this->db->where('request_id', $result[0]->request_id);
											$update = $this->db->update('feedback_request', $updateArray);
								
											// $from = '+15005550006';
											$from = '+14124555440';
											$to = $phone_number;
											// old one 
											// $message = 'Thank you for your reply!  Recommend '.$business_name.' to friends and family and find other trusted professionals for your next project by downloading the Seekahoo app.';
											// short link - http://appstore.com/seekahoo
											$message = 'Thank you for your reply! Recommend '.$business_name.' to friends and find more trusted pros by downloading the seekahoo app. https://itunes.apple.com/us/app/seekahoo/id922497295?ls=1&mt=8 ';
											$response = $this->twilio->sms($from, $to, $message);
												
											$this->db->select('device_token');
											$this->db->from('push_configuration');
											$this->db->where('user_id', $user_id);
											$getDevice = $this->db->get();
											$resultToken = $getDevice->result();
											if($resultToken) {
											$device_tokens = array();
											$this->load->library('push_notification');
											// @$device_tokens[] = $resultToken[0]->device_token;
											foreach($resultToken as $tokens) {
												$device_tokens[] = $tokens->device_token;
											}
											$message = $result[0]->FirstName." ".$result[0]->LastName." has responded to your review request and the review has been posted under the reviews section";
											$viewId = array ('user_id' => $user_id, 'flag' => 'reviewed_posts');
											$this->push_notification->send_notification($message, $device_tokens, $viewId);
											
											}		
						
									}					
					
							}	
				
					}

					if($pos === false || isset($result) && !$result) {
			
							$from = '+14124555440';
							$to = $phone_number;
							$message = 'Invalid code. Please reply with your comments followed by the correct code.';
							$response = $this->twilio->sms($from, $to, $message);
					}
															  								
	}
	
	function get_people_know_post() {
		$serviceName = 'get_people_know';
		$ip['user_id'] = trim($this->input->post('user_id'));
		//$ip['user_type'] = trim($this->input->post('user_type'));
		$ipJson = json_encode($ip);
		$validation_array = 1;
		$ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "user_id is empty.");
		//$ip_array[] = array("user_type", $ip['user_type'], "not_null", "user_type", "user_type is empty.");
		if ($validation_array !=1) {
			$data['message'] = $validation_array;
			$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else {
			$retVals = $this->post_model->get_people_follow($ip,$serviceName);
		}
		
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
	
	
}