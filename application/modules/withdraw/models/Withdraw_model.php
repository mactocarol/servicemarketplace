<?php
class Withdraw_model extends MY_Model 
{
	function __construct() {
		parent::__construct();		
	}

	function withdrawAmount(){
		$data = $this->db->select(
			'*'
		)->join('users','users.id = withdrawamount.userId')->get_where('withdrawamount',array())->result_array();
		return $data;

	}
        
}