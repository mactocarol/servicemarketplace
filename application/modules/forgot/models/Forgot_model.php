<?php
class Forgot_model extends MY_Model
	{

		function __construct() {
		parent::__construct();		
        }
		
		public function check_email($email){
			$this->db->where ('email',$email);
			$this->db->where ('is_verified','1');			
			$query=$this->db->get('users');
            //print_r($query->row());die;
			if ($query->num_rows()==1){
				return true;
			}
			else
			{
				return false;
			}
		}
		public function add_key($key){
			$this->db->set('key', $key); 
			$this->db->where('email',$this->input->post('email'));
			$this->db->or_where('username',$this->input->post('email'));
			$this->db->update('users'); 
			return true;
		}
		public function is_key_valid($key){
			$this->db->where('key',$key);
			$this->db->where('is_verified','1');
			$query=$this->db->get('users');
			if($query->num_rows()==1){
				return true;
			}
			else
			{
				return false;
			}
		}
		public function reset_password(){
			$this->db->set('password',md5($this->input->post('password')));
			$this->db->where('key',$this->input->post('key'));
			$this->db->update('users');
			return true;
			
		}
	}

?>