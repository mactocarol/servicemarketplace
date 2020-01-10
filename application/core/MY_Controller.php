<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/* load the MX_Router class */
require APPPATH . "third_party/MX/Controller.php";

class MY_Controller extends MX_Controller
{	

	function __construct() 
	{
		parent::__construct();
		$this->_hmvc_fixes();
	}
	
	function _hmvc_fixes()
	{		
		//fix callback form_validation		
		//https://bitbucket.org/wiredesignz/codeigniter-modular-extensions-hmvc
		$this->load->library('form_validation');
		$this->form_validation->CI =& $this;
	}
    
    
    function sendemail($MailData){
		
		$config['mailtype'] = 'html';
		$config['wordwrap'] = TRUE;
		$this->email->initialize($config);
		$this->email->from($MailData['FromEmail'], $MailData['FromName']);
		$this->email->to($MailData['To']); 
		if(!empty($MailData['Cc'])){
			$this->email->cc($MailData['Cc']); 
		}
		if(!empty($MailData['Bcc'])){
			$this->email->bcc($MailData['Bcc']); 
		}
		$this->email->subject($MailData['Subject']);
		$this->email->message($MailData['Message']);
	
		$this->email->send();
	}
    
    public function email($to, $subject, $msg) {
        $config = array(
            'mailtype' => 'html',
            'charset' => 'utf-8'
        );
        //$body = $this->load->view('Common', $msg, TRUE);
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from('info@mactosys.com', 'Khidmat');
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($msg);
        $this->email->send();
    }
}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */
