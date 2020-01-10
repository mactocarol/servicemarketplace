<?php
class Dashboard_model extends MY_Model{

	function __construct() {
		parent::__construct();		
	}

	function countReviewListData(){
		$user_id = $this->session->userdata('user_id');
		$result = $this->db->select('COUNT(reviewId) as count')->get_where('review',array('receiverId' => $user_id))->row_array();
		return $result['count'];
	}

	function reviewListData($limit,$start){
		$user_id = $this->session->userdata('user_id');
		$result = $this->db->join('users','review.senderId = users.id')->get_where('review',array('receiverId' => $user_id),$limit,$start)->result_array();
		return $result;
	}

}