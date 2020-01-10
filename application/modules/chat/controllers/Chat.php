<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chat extends MY_Controller {

	 public function __construct(){
        parent::__construct();
    }
    
	public function index(){
        $this->load->view('chat');
	}

	function message($id){
		$data['id'] = base64_decode($id);
		$this->load->view('message',$data);
	}
}
