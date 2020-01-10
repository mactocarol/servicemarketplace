<?php

class Admin_model extends MY_Model 

{

	function __construct() {

		parent::__construct();		

	}

            

    

    function check_login($email,$pass)

    {

        $this->db->where('email', $email);

        $this->db->or_where('username', $email);

        $query = $this->db->get('hb_admin');

        if( $query->num_rows() > 0 ){ return True; } else { return False; }

    }

    

    function email_exists($email,$id)

    {

        $this->db->where('email', $email);

        $this->db->where('id !=', $id);

        $query = $this->db->get('users');

        if( $query->num_rows() > 0 ){ return True; } else { return False; }

    }

    

    function username_exists($email,$id)

    {        

        $this->db->where('username', $email);

        $this->db->where('id !=', $id);

        $query = $this->db->get('users');

        if( $query->num_rows() > 0 ){ return True; } else { return False; }

    }



    function SelectSingleRecordNew($TableName,$Selectdata,$WhereData=array(),$orderby=array()){
         
        $this->db->select($Selectdata);

        if(!empty($orderby)){

            $this->db->order_by($orderby);

        }        

        if(!empty($WhereData)){

            $this->db->where($WhereData);

        }

        $query = $this->db->get($TableName);        
       //echo $this->db->last_query(); 
        return $query->result_array();

    }

}