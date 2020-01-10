<?php
class Cities_model extends MY_Model 
{
	function __construct() {
		parent::__construct();		
	}
     
   function UpdateRecord($TableName,$Data,$WhereData=NULL){		
		if($WhereData!=NULL){$this->db->where($WhereData);}

		$Result = $this->db->update($TableName,$Data);  
		
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE; 
	//	return $Result;

	}
}