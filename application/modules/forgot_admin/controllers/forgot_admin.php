<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forgot_admin extends HT_Controller {

	function __construct() {
		parent::__construct();

			$this->load->library('form_validation');
			$this->load->model('forgot_model');
		}
	public function index()
	{
		 $data=new stdClass();
            if($this->session->flashdata('item')) {
                $items = $this->session->flashdata('item');
                if($items->success){
                    $data->error=0;
                    $data->success=1;
                    $data->message=$items->message;
                }else{
                    $data->error=1;
                    $data->success=0;
                    $data->message=$items->message;
                }
                
            }                    
		$data->page_title = "Forgot";
        $data->page_text = "Forgot";
        $data->page = "forgot_password";
        $this->load->view('forgot_password',$data);
	}
	public function reset_link(){
        //print_r($_POST); die;
		$this->form_validation->set_rules('email','Email','required|trim|callback_validate_credentials');
		if($this->form_validation->run())
		{
			$key=md5 (uniqid());
			//sending conformation mail to signup user
			$to = $this->input->post('email');
            $sub = "Reset Password!";
            $message="<p>Reset Password!</p>";
			$message .="<p><a href='".base_url()."forgot_admin/reset_user/$key'>Click here</a> to reset your account.</p>";
            
            $this->load->helper('ht_helper');
            phpmailer($to,$sub,$message);

			$this->email->message($message);
			$this->email->send();
			$this->session->set_userdata($key);
			if ($this->forgot_model->add_key($key)){
                $data->error = 0;
                $data->success = 1;
                $data->message = "Password reset link has been sent to your mail!";
                $this->session->set_flashdata('item',$data);				
			}
			redirect ('forgot_admin');	
		}
		else
		{
			$data->error = 1;
            $data->success = 0;
            $data->message = "Enter Valid Email";
			$this->session->set_flashdata('item',$data);
			redirect ('forgot_admin');
		}
	}
	public function validate_credentials(){
		
		$email=$this->input->post('email');
		if ($this->forgot_model->check_email($email)){
			return true;
		}
		else
		{
			$this->form_validation->set_message('validate_credentials','Email does not exist in database .');
			return false;
		}
	}
	public function reset_user($key){
         $data=new stdClass();
            if($this->session->flashdata('item')) {
                $items = $this->session->flashdata('item');
                if($items->success){
                    $data->error=0;
                    $data->success=1;
                    $data->message=$items->message;
                }else{
                    $data->error=1;
                    $data->success=0;
                    $data->message=$items->message;
                }
                
            }                    
		
		if ($this->forgot_model->is_key_valid($key))
		{
            $data->key = $key;
			$data->page_title = "Forgot";
            $data->page_text = "Forgot";
            $data->page = "forgot_password";
            $this->load->view('reset_password',$data);
		}
		else
		{
            $data->error = 1;
            $data->success = 0;
            $data->message = "Invalid Key";
			$this->session->set_flashdata('item',$data);
			redirect ('forgot_admin');
		}

	}
	public function reset_password(){
		$this->form_validation->set_rules('password','Password','trim|required|min_length[6]');
		$this->form_validation->set_rules('cpassword','Confirm Password', 'trim|required|min_length[6]|matches[password]');
		if ($this->form_validation->run()){
			if ($this->forgot_model->reset_password()){
				$data= new stdClass();
				$data->page_title = "Reset Password";
        		$data->page_text = "Password Change Sucessfully!";
        		$data->page = "reset_password";
                $data->error = 0;
                $data->success = 1;
                $data->message = "Password has been reset successfully.";
                $this->session->set_flashdata('item',$data);	
        		redirect(site_url().'admin');
			}

		}
		else
		{
            $data->error = 1;
            $data->success = 0;
            $data->message = validation_errors();
			$this->session->set_flashdata('item',$data);			
			redirect ('forgot_admin/reset_user/'.$_POST['key']);
		}
		
	}
	
	

}
		
