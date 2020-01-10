<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Admin extends MY_Controller 
{

    
	//private $connection;
        public function __construct(){            
            parent::__construct();
// die();
            $this->load->model('admin_model');
            $this->load->helper('MY_helper');	    
        }
        public function index(){                        
            
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
            
            $this->load->view('login_view',$data);			
        }                        
        
        
        public function login_check()
        {
            $data=new stdClass();
            $this->form_validation->set_rules('email', 'Email', 'trim|required');
            $this->form_validation->set_rules('password', 'Password', 'trim|required');       
            if ($this->form_validation->run() == FALSE)
            {
                $data->error=1;
                $data->success=0;
                $data->message=validation_errors();
            }
            else
            {
                $email = $this->security->xss_clean($this->input->post('email'));
                $password = $this->security->xss_clean($this->input->post('password'));
                $Selectdata = array('id','email','username','image');
                $udata = array("email"=>$email,"password"=>md5($password));                
                $result = $this->admin_model->SelectSingleRecord('admin',$Selectdata,$udata,$orderby=array());
                
                $udata = array("username"=>$email,"password"=>md5($password));                
                $result1 = $this->admin_model->SelectSingleRecord('admin',$Selectdata,$udata,$orderby=array());
                //echo "<pre>";
                //print_r($result1); die;
                if($result || $result1)
                {
                    if($result){
                        $sess_array = array(
                        'user_id' => $result->id,
                        'email' => $result->username,
                        'image' => $result->image,
                        'user_group_id' => 3,
                        'logged_in' => TRUE
                        );
                    }else if($result1){
                        $sess_array = array(
                        'user_id' => $result1->id,
                        'email' => $result1->username,
                        'user_group_id' => 3,
                        'image' => $result->image,
                        'logged_in' => TRUE
                        );
                    }
                        
                        //print_r($sess_array); die;
                        $this->session->set_userdata($sess_array);
                        $data->error=0;
                        $data->success=1;
                        $data->message='Login Successfull';
                        //print_r($this->session->userdata('email')); die;
                        redirect('admin/dashboard');	
                    
                }
                else
                {
                    $data->error=1;
                    $data->success=0;
                    $data->message='Invalid Username or Password.';
                    
                }
            }
            $this->session->set_flashdata('item',$data);            
            redirect('admin');
        }
        
        public function dashboard()
        {
            if($this->session->userdata('user_group_id') != 3){
                redirect('admin');
            }
            if(!$this->session->userdata('logged_in')){
                redirect('admin');
            }
            $data=new stdClass();
            if($this->session->flashdata('item')) {
                
                $items = $this->session->flashdata('item');
                if($items->success){
                    $data->error=0;
                    $data->success=1;
                    $data->msg=$items->message;
                }else{
                    $data->error=1;
                    $data->success=0;
                    $data->message=$items->message;
                }
                
            }
            $udata = array("id"=>$this->session->userdata('user_id'));                
            $data->result = $this->admin_model->SelectSingleRecord('admin','*',$udata,$orderby=array());
            
            $data->website_title = $this->admin_model->SelectSingleRecord('settings','*',$udata=array("field_key"=>"website_title"),$orderby=array());
            
            $data->total_user = $this->admin_model->countrecords('users',array());
            //$data->total_entrepreneur = $this->admin_model->SelectRecord('users','*',array("user_type"=>'1'),$orderby=array());
            //$data->total_investor = $this->admin_model->SelectRecord('users','*',array("user_type"=>'2'),$orderby=array());
            
            $data->title = 'Dashboard';
            $data->field = 'Dashboard';
            $data->page = 'dashboard';
            $this->load->view('admin/includes/header',$data);		
            $this->load->view('dashboard_view',$data);
            $this->load->view('admin/includes/footer',$data);
        }
        
        
        public function update_profile(){
            if($this->session->userdata('user_group_id') != 3){
                redirect('admin');
            }
            if(!$this->session->userdata('logged_in')){
                redirect('admin');
            }
            $data=new stdClass();
			
            //print_r($result); die;
			if($_POST){
                if($this->input->post('password') != ''){
                    $udata=array(
                        'f_name'=>$this->input->post('f_name'),
                        'l_name'=>$this->input->post('l_name'),
                        'email'=>$this->input->post('email'),
                        'username'=>$this->input->post('username'),
                        'password' => md5($this->input->post('password'))
                    );
                }else{
                    $udata=array(
                        'f_name'=>$this->input->post('f_name'),
                        'l_name'=>$this->input->post('l_name'),
                        'username'=>$this->input->post('username'),
                        'email'=>$this->input->post('email')					
                    );
                }
				if ($this->admin_model->UpdateRecord('admin',$udata,array("id"=>$this->session->userdata('user_id'))))
				{
                    $data->error=0;
                    $data->success=1;
                    $data->message='Profile Update Sucessfully.';
                     					
				}else{
                    $data->error=1;
                    $data->success=0;
                    $data->message='Network Error!';                    
                }
                //print_r($data); die;
            $this->session->set_flashdata('item',$data);
            redirect('admin/update_profile');
			//print_r($this->session->flashdata('item')); die;	
			}
            
            $udata = array("id"=>$this->session->userdata('user_id'));                
            $data->result = $this->admin_model->SelectSingleRecord('admin','*',$udata,$orderby=array());
            
            
            $data->title = 'Admin Profile';
            $data->field = 'Admin Profile';
            $data->page = 'profile';
            $this->load->view('admin/includes/header',$data);		
            $this->load->view('profile_view',$data);
            $this->load->view('admin/includes/footer',$data);			
		}
        
        public function upload_image(){
            $data=new stdClass();
            if($this->session->userdata('user_group_id') != 3){
                redirect('admin');
            }
            if(!$this->session->userdata('logged_in')){
                redirect('admin');
            }
            if($_FILES){
                //print_r($_FILES); die;
                $config=[	'upload_path'	=>'./upload/profile_image/',
                        'allowed_types'	=>'jpg|gif|png|jpeg',
                        'file_name' => strtotime(date('y-m-d h:i:s')).$_FILES["profile_pic"]['name']
                    ];
                //print_r(_FILES_); die;
                $this->load->library ('upload',$config);
                
                if ($this->upload->do_upload('profile_pic'))
                {
                    $adminpic=$this->admin_model->SelectSingleRecord('admin','*',array("id"=>$this->session->userdata('user_id')),$orderby=array());                                        
                    unlink('./upload/'.$adminpic->image);
                    unlink('./upload/thumb/'.$adminpic->image);
                    $udata = $this->upload->data();                    
                                    //resize profile image
                                    $config10['image_library'] = 'gd2';
                                    $config10['source_image'] = $udata['full_path'];
                                    $config10['new_image'] = './upload/profile_image/thumb/'.$udata['file_name'];
                                    $config10['maintain_ratio'] = TRUE;
                                    $config10['width']         = 200;
                                    $config10['height']       = 200;
                                    
                                    $this->load->library('image_lib', $config10);
                                    
                                    $this->image_lib->resize();
                    //print_r($udata); die;
                    $image_path= $udata['file_name'];
                    $this->admin_model->UpdateRecord('admin',array("image"=>$image_path),array("id"=>$this->session->userdata('user_id')));
                    $data->error=0;
                    $data->success=1;
                    $data->message='Uploaded Successfully'; 
                    $this->session->set_flashdata('item', $data);
                    redirect('admin/upload_image');	
                }
                else
                {
                    $data->error=1;
                    $data->success=0;
                    $data->message='Only jpeg/png/gif/jpg allowed!'; 
                    $this->session->set_flashdata('item', $data);
                    redirect('admin/upload_image');	
                }
            }
            $udata = array("id"=>$this->session->userdata('user_id'));                
            $data->result = $this->admin_model->SelectSingleRecord('admin','*',$udata,$orderby=array());
            $data->title = 'Admin Profile Image';
            $data->field = 'Dashboard';
            $data->page = 'upload_image';
            $this->load->view('admin/includes/header',$data);		
            $this->load->view('profile_pic_view',$data);
            $this->load->view('admin/includes/footer',$data);

		}
        
        public function logout()
        {
            $data=new stdClass();
            if($this->session->userdata('logged_in')){
                $this->session->sess_destroy();    
            }
            
            $data->error=0;
            $data->success=1;
            $data->message='Logged Out Successfully';
            $this->session->set_flashdata('item',$data);            
            redirect('admin');
        }
			                                    
        
        
        public function add_user()
        {
            // echo 1;die();
            if($this->session->userdata('user_group_id') != 3)
            {
                redirect('admin');
            }
            
            $data=new stdClass();
            if($this->session->flashdata('item'))
             {
                $items = $this->session->flashdata('item');
                if($items->success)
                {
                    $data->error=0;
                    $data->success=1;
                    $data->message=$items->message;
                }else
                {
                    $data->error=1;
                    $data->success=0;
                    $data->message=$items->message;
                }
                
            }
            
            // /print_r($data); die;
            if(!empty($_POST)){
               $this->load->library ('upload');
                
                $profile_image = 'no_image.jpg';
                $cover_image = 'bgprofile.png';
                $companylogo = 'default_logo.png';
                    if($_FILES['profile_image']['name']){
                        
                        $config=[	'upload_path'	=>'./upload/profile_image/',
                            'allowed_types'	=>'jpg|gif|png|jpeg',
                            'file_name' => strtotime(date('y-m-d h:i:s')).$_FILES["profile_image"]['name']
                        ];
                        // print_r($config); die;
                        
                        $this->upload->initialize($config);
                        if ($this->upload->do_upload('profile_image'))
                        {                                                                                    
                            $idata = $this->upload->data();                    
                                            //resize profile image
                                            $config10['image_library'] = 'gd2';
                                            $config10['source_image'] = $idata['full_path'];
                                            $config10['new_image'] = './upload/profile_image/thumb/'.$idata['file_name'];
                                            $config10['maintain_ratio'] = FALSE;
                                            $config10['width']         = 200;
                                            $config10['height']       = 200;
                                            
                                            $this->load->library('image_lib', $config10);
                                            
                                            $this->image_lib->resize();
                            //print_r($udata); die;
                            $profile_image = $idata['file_name'];                            
                        }
                        else
                        {
                            $data->error=1;
                            $data->success=0;
                            $data->message=$this->upload->display_errors(); 
                            $this->session->set_flashdata('item', $data);
                            //print_r($data); die;
                            redirect('admin/add_user');	
                        }
                        
                    }
                    if($_FILES['cover_image']['name']){
                        $config = [];
                        $this->upload->initialize($config);
                        $config1=[	'upload_path'	=>'./upload/cover_image/',
                            'allowed_types'	=>'jpg|gif|png|jpeg',
                            'file_name' => strtotime(date('y-m-d h:i:s')).$_FILES["cover_image"]['name']
                        ];
                        //print_r($config); die;
                        $this->upload->initialize($config1);
                        
                        if ($this->upload->do_upload('cover_image'))
                        {                            
                          
                            $idata1 = $this->upload->data();                    
                                            //resize profile image
                                            $config11['image_library'] = 'gd2';
                                            $config11['source_image'] = $idata1['full_path'];
                                            $config11['new_image'] = './upload/cover_image/'.$idata1['file_name'];
                                            $config11['maintain_ratio'] = False;
                                            $config11['width']         = 850;
                                            $config11['height']       = 334;
                                            
                                            $this->load->library('image_lib', $config11);
                                            
                                            $this->image_lib->resize();
                            //print_r($udata); die;
                            $cover_image = $idata1['file_name'];                            
                        }
                        else
                        {
                            $data->error=1;
                            $data->success=0;
                            $data->message=$this->upload->display_errors(); 
                            $this->session->set_flashdata('item', $data);
                            //print_r($data); die;
                            redirect('admin/add_user');	
                        }
                        
                    }
                    if($_FILES['companylogo']['name']){
                        
                        $config2=[	'upload_path'	=>'./upload/profile_image/logo/',
                            'allowed_types'	=>'jpg|gif|png|jpeg',
                            'file_name' => strtotime(date('y-m-d h:i:s')).$_FILES["companylogo"]['name']
                        ];
                        //print_r($config); die;
                        $this->upload->initialize($config2);
                        
                        if ($this->upload->do_upload('companylogo'))
                        {                            
                           
                            $idata2 = $this->upload->data();                    
                                            //resize profile image
                                            $config12['image_library'] = 'gd2';
                                            $config12['source_image'] = $idata2['full_path'];
                                            $config12['new_image'] = './upload/profile_image/logo/'.$idata2['file_name'];
                                            $config12['maintain_ratio'] = False;
                                            $config12['width']         = 150;
                                            $config12['height']       = 80;
                                            
                                            $this->load->library('image_lib', $config12);
                                            
                                            $this->image_lib->resize();
                            //print_r($udata); die;
                            $companylogo = $idata2['file_name'];                            
                        }
                        else
                        {
                            $data->error=1;
                            $data->success=0;
                            $data->message=$this->upload->display_errors(); 
                            $this->session->set_flashdata('item', $data);
                            //print_r($data); die;
                            redirect('admin/add_user');	
                        }
                        
                    }
                $udata=array(                                            
                        'f_name'=>$this->input->post('f_name'),
                        'l_name'=>$this->input->post('l_name'),
                        'email'=>$this->input->post('email'),
                        'username'=>$this->input->post('username'),
                        'contact'=>$this->input->post('contact'),
                        'image'=> $profile_image,
                        'cover_image'=> $cover_image,
                        // 'user_type'=>implode(',',$this->input->post('category')),
                        'dob'=>$this->input->post('dob'),
                        'gender'=>$this->input->post('gender'),
                        'about_me'=>$this->input->post('about_me'),
                        'address'=>$this->input->post('address'),
                        'companyname'=>$this->input->post('companyname'),
                        'companylogo'=> $companylogo,
                        'designation'=>$this->input->post('designation'),
                        'experience'=>$this->input->post('experience'),                        
                        'password'=>md5($this->input->post('password')),                        
                        'is_verified' => '1'
                    );
               if($last_id = $this->admin_model->InsertRecord('users',$udata)){                    
                    $this->admin_model->InsertRecord('membership',array("user_id"=>$last_id,"plan_id"=>"1"));
                    $this->admin_model->InsertRecord('wallet',array("user_id"=>$last_id,"amount"=>"0","user_type"=>'2'));
                    $data->error=0;
                    $data->success=1;
                    $data->message="User Added Successfully";
               }else{
                    $data->error=1;
                    $data->success=0;
                    $data->message="Network Error";
               }
               $this->session->set_flashdata('item',$data);
               redirect('admin/add_user');
            }
            $udata = array("id"=>$this->session->userdata('user_id'));                
            $data->result = $this->admin_model->SelectSingleRecord('admin','*',$udata,$orderby=array());
            $data->categories = $this->admin_model->SelectRecord('category','*',array(),$orderby=array());
            
            $data->title = 'Add User';
            $data->field = 'Add User';
            $data->page = 'add_user';
            $this->load->view('admin/includes/header',$data);		
            $this->load->view('add_user_view',$data);
            $this->load->view('admin/includes/footer',$data);                                        
        }
        
        public function list_user()
        {		
            if($this->session->userdata('user_group_id') != 3){
                redirect('admin');
            }
            if(!$this->session->userdata('logged_in')){
                redirect('user');
            }
            
            $data=new stdClass();
            if($this->session->flashdata('item'))
            {
                $items = $this->session->flashdata('item');
                if($items->success){
                    $data->error=0;
                    $data->success=1;
                    $data->message=$items->message;
                }else
                {
                    $data->error=1;
                    $data->success=0;
                    $data->message=$items->message;
                }                
            }
         

            $user_type=  $this->uri->segment(3); 


            $where=array('user_type'=>$user_type);
           
            $data->result1 = $this->admin_model->SelectSingleRecordNew('users','*',$where,$orderby=array());

           // print_r($data->result1); die;
            $data->result = $this->admin_model->SelectSingleRecord('admin','*',$udata='',$orderby=array());
            // echo "<pre>"; print_r($data); die;             
            $data->title = 'List users';
            $data->field = 'Datatable';
            $data->page = 'list_user';
            
        // echo "<pre>"; print_r($data); die; 

            $this->load->view('admin/includes/header',$data);		
            $this->load->view('list_users_view',$data);
            $this->load->view('admin/includes/footer',$data);		
        }

	public function list_jobs()
        {
            if($this->session->userdata('user_group_id') != 3){
                redirect('admin');
            }
            if(!$this->session->userdata('logged_in')){
                redirect('user');
            }
            
            $data=new stdClass();
            if($this->session->flashdata('item'))
            {
                $items = $this->session->flashdata('item');
                if($items->success){
                    $data->error=0;
                    $data->success=1;
                    $data->message=$items->message;
                }else
                {
                    $data->error=1;
                    $data->success=0;
                    $data->message=$items->message;
                }                
            }                    
           
            // $data->result1 = $this->admin_model->SelectSingleRecordNew('job_postOld','*','',$orderby=array());

            // //print_r($data->result1); die;
            $data->result = $this->admin_model->SelectSingleRecord('admin','*',$udata='',$orderby=array());                       
            // $this->db->select('job_postOld.*,users.name,category.title');    
            // $this->db->from('job_postOld');
            // $this->db->join('users', 'job_postOld.user_id = users.id');
            // $this->db->join('category', 'job_postOld.service_id =category.id');

            $this->db->select('job_post.*,users.name,category.title as ctitle');    
            $this->db->from('job_post');
            $this->db->join('users', 'job_post.user_id = users.id');
            $this->db->join('category', 'job_post.service_id =category.id');
            $query=$this->db->get();
            $data->result1= $query->result_array();

            // echo "<pre>"; print_r($data); die;             
            $data->title = 'List job post';
            $data->field = 'Datatable';
            $data->page = 'list_jobs';            
        // echo "<pre>"; print_r($data); die; 
            $this->load->view('admin/includes/header',$data);       
            $this->load->view('list_jobs_view',$data);
            $this->load->view('admin/includes/footer',$data);       
        }


         public function proposal_jobs($id)
        {
            // print_r($id);die();
            // echo"1";die();
            if($this->session->userdata('user_group_id') != 3){
                redirect('admin');
            }
            if(!$this->session->userdata('logged_in')){
                redirect('user');
            }
            
            $data=new stdClass();
            if($this->session->flashdata('item'))
            {
                $items = $this->session->flashdata('item');
                if($items->success){
                    $data->error=0;
                    $data->success=1;
                    $data->message=$items->message;
                }else
                {
                    $data->error=1;
                    $data->success=0;
                    $data->message=$items->message;
                }                
            }  
            // $data->result1 = $this->admin_model->SelectSingleRecordNew('job_postOld','*','',$orderby=array());
            // print_r($data->result1); die;
            // $this->db->select('job_postOld.*,users.f_name,category.title');    
            // $this->db->from('job_postOld');
            // $this->db->join('users', 'job_postOld.user_id = users.id');
            // $this->db->join('category', 'job_postOld.service_id =category.id');
            // $query=$this->db->get();
            // $data->result1= $query->result_array();
            // $job_postOld_id =array('job_postOld_id'=>$id);
            // print_r($job_postOld_id);die();

            // $this->db->select('proposalOld.*,users.name,job_postOld.service_id');    
            // $this->db->from('proposalOld');
            // $this->db->join('users', 'proposalOld.vendor_id = users.id');            
            // $this->db->join('job_postOld', 'proposalOld.job_postOld_id =job_postOld.id');
            // $this->db->where('job_postOld_id',$id);
            // $query=$this->db->get();
            // $data->result1= $query->result_array();
            // $data->result = $this->admin_model->SelectSingleRecord('admin','*',$udata='',$orderby=array());                       
            
            $this->db->select('proposal.*,users.id as uid,users.name, job_post.id as jp_id,job_post.title as job_title,job_post.description,job_post.service_id');    
            $this->db->from('proposal');
            $this->db->join('users', 'proposal.user_id = users.id');            
            $this->db->join('job_post', 'proposal.job_id =job_post.id');
            $this->db->where('proposal.job_id',$id);
            $query=$this->db->get();
			//echo $this->db->last_query();die;
            $data->result1= $query->result_array();
            $data->result = $this->admin_model->SelectSingleRecord('admin','*',$udata='',$orderby=array());
             // $data->result1 = $this->admin_model->SelectSingleRecordNew('proposal','*',$where =array('job_postOld_id'=>$id),$orderby=array());
            // echo "<pre>"; print_r($data); die;             
            $data->title = 'List job proposal';
            $data->field = 'Datatable';
            $data->page = 'list_proposal_view';            
        // echo "<pre>"; print_r($data); die; 
            $this->load->view('admin/includes/header',$data);       
            $this->load->view('list_proposal_view',$data);
            $this->load->view('admin/includes/footer',$data);       
        }

        public function edit_proposal($id){
            
            // print_r($id); die;
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


            $data->reslt = $this->admin_model->SelectSingleRecord('proposal','*',array('id'=>$id),$orderby=array());
			
			//echo $this->db->last_query();die;			
            $jid = $data->reslt->user_id;
            // $service_id = $data->reslt->service_id;
            $data->users = $this->admin_model->SelectSingleRecord('users','name',array('id'=>$jid),$orderby=array()); 
			$data->job_post = $this->admin_model->SelectSingleRecord('job_post','description,address',array('id'=>$jid),$orderby=array()); 
            // print_r($data);die();
            // $data->service_data= $this->admin_model->SelectRecord('users','f_name',array('id'=>$jid),$orderby=array()); 
            // $data->service = $this->admin_model->SelectSingleRecord('category','title',array('id'=>$service_id),$orderby=array());
            
            // $data->reslt = $this->admin_model->SelectSingleRecord('job_postOld','*',array('id'=>$id),$orderby=array());
            // $jid = $data->reslt->user_id;
            // $service_id = $data->reslt->service_id;
            // // print_r($service_id);die();
            // $data->users = $this->admin_model->SelectSingleRecord('users','f_name',array('id'=>$jid),$orderby=array()); 
            // // $data->service_data= $this->admin_model->SelectRecord('users','f_name',array('id'=>$jid),$orderby=array()); 
            // $data->service = $this->admin_model->SelectSingleRecord('category','title',array('id'=>$service_id),$orderby=array());
            // $data->service_data= $this->admin_model->SelectRecord('category','*',array('id'=>$service_id ),$orderby=array());
            // print_r($data->service ); die;
            if(!empty($_POST)){
               // print_r($_POST);die;                   
                // $udata['username'] = $this->input->post('username');
                // $udata['title'] = $this->input->post('title'); tomorrow will change other table
                $udata['proposal'] = $this->input->post('proposal');
                //$udata['milestone'] = $this->input->post('milestone');
                $udata['amount'] = $this->input->post('bid_value');
                $udata['status'] = $this->input->post('status'); 
				$udata['accept'] = $this->input->post('accept'); 	
                // $udata['from_date'] = $this->input->post('from_date');
                // $udata['to_date'] = $this->input->post('to_date'); 
                // print_r($udata);die();              
               if($this->admin_model->UpdateRecord('proposal',$udata,array("id"=>$id))){				   
                    $data->error=0;
                    $data->success=1;
                    $data->message="Proposal Updated Successfully";
               }else{
                    $data->error=1;
                    $data->success=0;
                    $data->message="Network Error";
               }
               $this->session->set_flashdata('item',$data);                              
               redirect('admin/edit_proposal/'.$id);
            }
                        
            $udata = array("id"=>$this->session->userdata('user_id'));
            $data->categories = $this->admin_model->SelectRecord('category','*',array(),'id desc');           
            $data->result = $this->admin_model->SelectSingleRecord('admin','*',$udata='',$orderby=array());            
            
            $data->title = 'Edit Jobs Proposal';
            $data->field = 'Proposal Jobs';
            $data->page = 'edit_proposal';
            // $data->type = $data->reslt->file_type;
            $this->load->view('admin/includes/header',$data);       
            $this->load->view('edit_proposal_view',$data);
            $this->load->view('admin/includes/footer',$data);                                        
        }	
		

			public function open_brecoli(){
				 $data=new stdClass();
				$this->db->select('job_post.*,users.name,category.title');    
				$this->db->from('job_post');
				$this->db->join('users', 'job_post.user_id = users.id');
				$this->db->join('category', 'job_post.service_id =category.id');
				$this->db->where('job_post.status', 1);
				$query=$this->db->get();				
				$data->result1= $query->result_array();				
				$data->result = $this->admin_model->SelectSingleRecord('admin','*',$udata='',$orderby=array());            
            
				$data->title = 'Open Brecoli';
				$data->field = 'Datatable';
				$data->page = 'open_brecoli';
				// $data->type = $data->reslt->file_type;
				$this->load->view('admin/includes/header',$data);       
				$this->load->view('status_brecoli_view',$data);
				$this->load->view('admin/includes/footer',$data);  
			}
			
			public function closed_brecoli(){
				$data=new stdClass();
				$this->db->select('job_post.*,users.name,category.title');    
				$this->db->from('job_post');
				$this->db->join('users', 'job_post.user_id = users.id');
				$this->db->join('category', 'job_post.service_id =category.id');
				$this->db->where('job_post.status', 3);
				$query=$this->db->get();	
				$data->result1= $query->result_array();				
				$data->result = $this->admin_model->SelectSingleRecord('admin','*',$udata='',$orderby=array());            
            
				$data->title = 'Closed Brecoli';
				$data->field = 'Datatable';
				$data->page = 'closed_brecoli';
				// $data->type = $data->reslt->file_type;
				$this->load->view('admin/includes/header',$data);       
				$this->load->view('status_brecoli_view',$data);
				$this->load->view('admin/includes/footer',$data);  
			}
			
			//Awarded job list
			public function upcoming_brecoli(){
				$data=new stdClass();
				$this->db->select('job_post.*,users.name,category.title');    
				$this->db->from('job_post');
				$this->db->join('users', 'job_post.user_id = users.id');
				$this->db->join('category', 'job_post.service_id =category.id');
				$this->db->where('job_post.status', 2);
				$query=$this->db->get();	
				$data->result1= $query->result_array();				
				$data->result = $this->admin_model->SelectSingleRecord('admin','*',$udata='',$orderby=array());            
            
				$data->title = 'Upcoming Brecoli';
				$data->field = 'Datatable';
				$data->page = 'upcoming_brecoli';
				// $data->type = $data->reslt->file_type;
				$this->load->view('admin/includes/header',$data);       
				$this->load->view('status_brecoli_view',$data);
				$this->load->view('admin/includes/footer',$data);  
			}

         public function list_offer_code()
        {
            if($this->session->userdata('user_group_id') != 3){
                redirect('admin');
            }
            if(!$this->session->userdata('logged_in')){
                redirect('user');
            }
            
            $data=new stdClass();
            if($this->session->flashdata('item'))
            {
                $items = $this->session->flashdata('item');
                if($items->success){
                    $data->error=0;
                    $data->success=1;
                    $data->message=$items->message;
                }else
                {
                    $data->error=1;
                    $data->success=0;
                    $data->message=$items->message;
                }                
            }       

            
           
            $data->result1 = $this->admin_model->SelectSingleRecordNew('job_postOld','*','',$orderby=array());

            //print_r($data->result1); die;
            $data->result = $this->admin_model->SelectSingleRecord('admin','*',$udata='',$orderby=array());
            // echo "<pre>"; print_r($data); die;             
            $data->title = 'List Offer Code';
            $data->field = 'Datatable';
            $data->page = 'list_jobs';
            
        // echo "<pre>"; print_r($data); die; 

            $this->load->view('admin/includes/header',$data);       
            $this->load->view('list_offer_code_view',$data);
            $this->load->view('admin/includes/footer',$data);       
        }
		
		public function list_user1(){
			$results = $this->admin_model->joindataResult('u.user_type','c.id',array(),array('u.*','c.name'),'users as u','category as c','u.id desc');
			echo json_encode($results);
		}
        
        public function edit_user($id)
        {
            // echo $id;die();
            if($this->session->userdata('user_group_id') != 3){
                redirect('admin');
            }
            if(!$this->session->userdata('logged_in')){
                redirect('admin');
            }
            $data=new stdClass();			
            // print_r($result); die;
			if($_POST)
            {       
                $udata=array(
                    // 'f_name'=>$this->input->post('f_name'),
                    // 'l_name'=>$this->input->post('l_name'),
                    'name'=>$this->input->post('name'),
                    'email'=>$this->input->post('email'),
                    // 'user_name'=>$this->input->post('username'),
                    'contact'=>$this->input->post('contact'),
                    // 'image'=> $profile_image,
                    'gender'=>$this->input->post('gender'),
                    'address'=>$this->input->post('address'),            
                    'city'=>$this->input->post('city'),
                    'country'=>$this->input->post('country')
                    );
                // echo "<pre>"; print_r($udata); die;
				if ($this->admin_model->UpdateRecord('users',$udata,array("id"=>$id)))
				{
                    $data->error=0;
                    $data->success=1;
                    $data->message='User Profile Updated Sucessfully.';
                     					
				}else{
                    $data->error=1;
                    $data->success=0;
                    $data->message='Network Error!';                    
                }
                // print_r($data); die;
            $this->session->set_flashdata('item',$data);
            redirect('admin/edit_user/'.$id);
			print_r($this->session->flashdata('item'));	
			}            
            // $udata = array("id"=>$this->session->userdata('user_id'));               
            
            $data->result = $this->admin_model->SelectSingleRecord('admin','*',$udata='',$orderby=array());           
            // $udata = array("id"=>$id);                
            $data->reslt = $this->admin_model->SelectSingleRecord('users','*',$where =array('id'=>$id),$orderby=array());
            $data->title = 'Edit User';
            $data->field = 'Edit User';
            $data->page = 'list_user';
            $this->load->view('admin/includes/header',$data);		
            $this->load->view('edit_user_view',$data);
            $this->load->view('admin/includes/footer',$data);			
		}
        
        public function status($id,$userid){
            if($this->session->userdata('user_group_id') != 3){
                redirect('admin');
            }
            if(!$this->session->userdata('logged_in')){
                redirect('admin');
            }
            $data=new stdClass();
			
            //print_r($id); die;
			if($userid){
                $id = ($id == 1) ? '0' : '1';
                //echo $userid; die;
                    $udata=array(
                        'is_verified'=>$id                        
                    );
               
				if ($this->admin_model->UpdateRecord('users',$udata,array("id"=>$userid)))
				{
                    //echo $this->db->last_query(); die;
                    $data->error=0;
                    $data->success=1;
                    $data->message='Status Updated Sucessfully.';
                     					
				}else{
                    $data->error=1;
                    $data->success=0;
                    $data->message='Network Error!';                    
                }
                //print_r($data); die;
            $this->session->set_flashdata('item',$data);
            redirect('admin/list_user/');
			//print_r($this->session->flashdata('item')); die;	
			}
                       			
		}
        
        public function delete($id){
            if($this->session->userdata('user_group_id') != 3){
                redirect('admin');
            }
            $data=new stdClass();
            if($this->admin_model->delete_record('users',array("id"=>$id))){
                $data->error=0;
                $data->success=1;
                $data->message="Deleted Successfully";
            }else{
                $data->error=1;
                $data->success=0;
                $data->message="Network Error";
            }					
            $this->session->set_flashdata('item',$data);			
			
			$user_details = get_user($id);
				if($user_details->user_type == 1){
					$type = 1; //user
				}else{
					$type = 2; //vendor
				}		
            redirect("admin/list_user/$type");
        }
        
        public function list_payment(){
            if($this->session->userdata('user_group_id') != 3){
                redirect('admin');
            }
            if(!$this->session->userdata('logged_in')){
                redirect('user');
            }
            
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
            $data->results = $this->admin_model->joindataResult('p.user_id','u.id',array(),array('p.*','u.username'),'booking as p','users as u','p.id desc');            
            $udata = array("id"=>$this->session->userdata('user_id'));                
            $data->result = $this->admin_model->SelectSingleRecord('admin','*',$udata,$orderby=array());
            $data->title = 'List Paymnet';
            $data->field = 'Datatable';
            $data->page = 'list_payment';
            $this->load->view('admin/includes/header',$data);		
            $this->load->view('list_payment_view',$data);
            $this->load->view('admin/includes/footer',$data);		
        }
                        
                
        function check_email_exists($id)
        {                
            if (array_key_exists('email',$_POST)) 
            {
                if ( $this->admin_model->email_exists($this->input->post('email'),$id) == TRUE ) 
                {
                    $isAvailable=false;
                } 
                else 
                {
                    $isAvailable= true;
                }
                 echo json_encode(array('valid' => $isAvailable, ));
            }
        }
        
        function check_username_exists($id)
        {               
            if (array_key_exists('username',$_POST)) 
            {
                if ( $this->admin_model->username_exists($this->input->post('username'),$id) == TRUE ) 
                {
                    $isAvailable=false;
                } 
                else 
                {
                    $isAvailable= true;
                }
                 echo json_encode(array('valid' => $isAvailable, ));
            }
        }
        
        function get_user_plan()
        {
            $id = $this->input->post('user_id');
            $data=new stdClass();
            $userplan = $this->admin_model->SelectSingleRecord('membership','*',array('user_id'=>$id),$orderby=array());
            
            $plan = $this->admin_model->SelectRecord('membership_plan','*',array(),$orderby=array());
            foreach($plan as $p){ ?>
                <option value="<?=$p['id']?>" <?php if($p['id'] == $userplan->plan_id) echo 'selected';?>><?=$p['title']?></option>
            <?php }
        }
        
        function update_user_plan()
        {
            $userid = $this->input->post('userid');
            $planid = $this->input->post('plan');
            
            if($planid != 1){
                $udata['account_type'] = 'pro';
                $udata['account_valid'] = date('Y-m-d h:i:s',strtotime($this->input->post('account_valid')));
                $udata['payment_type'] = 'one time';
                $udata['subscription_id'] = 0;
            }else{
                $udata['account_type'] = 'free';
                $udata['account_valid'] = '';
                $udata['payment_type'] = '';
                $udata['subscription_id'] = 0;
            }
            $data=new stdClass();            
            
            if($this->admin_model->UpdateRecord('membership',array("plan_id"=>$planid),array("user_id"=>$userid))){
                $this->admin_model->UpdateRecord('users',$udata,array("id"=>$userid));
                $data->error=0;
                $data->success=1;
                $data->message="Updated Successfully";
            }else{
                $data->error=1;
                $data->success=0;
                $data->message=" Network Error";
            }
            $this->session->set_flashdata('item',$data);
            redirect('admin/list_user');
        }
        
        function get_user_video()
        {
            $id = $this->input->post('user_id');
            $data=new stdClass();            
            $data->userid= get_user($id)->username;
            $data->products = $this->admin_model->joindataResult('p.genre','g.id',array("p.file_type"=>1,"p.user_id"=>$id),array('p.*','g.name'),'products as p','genre as g','p.id desc');
            echo $this->load->view('admin/user_videos',$data);
        }
        
        function get_user_audio()
        {
            $id = $this->input->post('user_id');
            $data=new stdClass();            
            $data->userid= get_user($id)->username;
            $data->products = $this->admin_model->joindataResult('p.genre','g.id',array("p.file_type"=>2,"p.user_id"=>$id),array('p.*','g.name'),'products as p','genre as g','p.id desc');
            echo $this->load->view('admin/user_audios',$data);
        }
        
        function get_user_picture()
        {
            $id = $this->input->post('user_id');
            $data=new stdClass();            
            $data->userid= get_user($id)->username;
            $data->products = $this->admin_model->SelectRecord('products','*',array("file_type"=>3,"user_id"=>$id),'id desc');
            echo $this->load->view('admin/user_pictures',$data);
        }
        
        function get_user_jobs()
        {
            $id = $this->input->post('user_id');
            $data=new stdClass();            
            $data->userid= get_user($id)->username;
            $data->jobs = $this->admin_model->joindataResult('j.category','c.id',array('j.user_id'=>$id),array('j.*','c.name'),'jobs as j','category as c','j.id desc');
            //print_r($data); die;
            echo $this->load->view('admin/user_jobs',$data);
        }
        
        function videos()
        {            
            $data=new stdClass();            
            if(!$this->session->userdata('logged_in')){
                redirect('admin');
            }
            
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
            $data->products = $this->admin_model->joindataResult('p.genre','g.id',array("p.file_type"=>1),array('p.*','g.name'),'products as p','genre as g','p.id desc');
            $udata = array("id"=>$this->session->userdata('user_id'));                
            $data->result = $this->admin_model->SelectSingleRecord('admin','*',$udata,$orderby=array());
            $data->title = 'List Videos';
            $data->field = 'Datatable';
            $data->page = 'list_videos';
            $this->load->view('admin/includes/header',$data);		
            $this->load->view('videos',$data);
            $this->load->view('admin/includes/footer',$data);	                        
        }
        
        function audios()
        {            
            $data=new stdClass();            
            if(!$this->session->userdata('logged_in')){
                redirect('admin');
            }
            
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
            $data->products = $this->admin_model->joindataResult('p.genre','g.id',array("p.file_type"=>2),array('p.*','g.name'),'products as p','genre as g','p.id desc');
            $udata = array("id"=>$this->session->userdata('user_id'));                
            $data->result = $this->admin_model->SelectSingleRecord('admin','*',$udata,$orderby=array());
            $data->title = 'List Audios';
            $data->field = 'Datatable';
            $data->page = 'list_pictures';
            $this->load->view('admin/includes/header',$data);		
            $this->load->view('audios',$data);
            $this->load->view('admin/includes/footer',$data);	                        
        }
        
        function pictures()
        {            
            $data=new stdClass();            
            if(!$this->session->userdata('logged_in')){
                redirect('admin');
            }
            
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
            $data->products = $this->admin_model->SelectRecord('products','*',array("file_type"=>3),'id desc');
            $udata = array("id"=>$this->session->userdata('user_id'));                
            $data->result = $this->admin_model->SelectSingleRecord('admin','*',$udata,$orderby=array());
            $data->title = 'List Pictures';
            $data->field = 'Datatable';
            $data->page = 'list_videos';
            $this->load->view('admin/includes/header',$data);		
            $this->load->view('pictures',$data);
            $this->load->view('admin/includes/footer',$data);	                        
        }
	
	function products()
        {            
            $data=new stdClass();            
            if(!$this->session->userdata('logged_in')){
                redirect('admin');
            }
            
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
            $data->products = $this->admin_model->SelectRecord('other_products','*',array(),'id desc');
            $udata = array("id"=>$this->session->userdata('user_id'));                
            $data->result = $this->admin_model->SelectSingleRecord('admin','*',$udata,$orderby=array());
            $data->title = 'List Products';
            $data->field = 'Datatable';
            $data->page = 'list_other_products';
            $this->load->view('admin/includes/header',$data);		
            $this->load->view('other_products',$data);
            $this->load->view('admin/includes/footer',$data);	                        
        }
        
        function jobs()
        {            
            $data=new stdClass();            
            if(!$this->session->userdata('logged_in')){
                redirect('admin');
            }
            
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
            $data->jobs = $this->admin_model->joindataResult('j.category','c.id',array(),array('j.*','c.name'),'jobs as j','category as c','j.id desc');
			foreach($data->jobs as $key=>$value){
                $total_application = $this->admin_model->SelectSingleRecord('jobs_applied','*',array('job_id'=>$value['id']),$orderby=array());
                $data->jobs[$key]['total_app'] = count($total_application);
            }
            $udata = array("id"=>$this->session->userdata('user_id'));                
            $data->result = $this->admin_model->SelectSingleRecord('admin','*',$udata,$orderby=array());
            $data->title = 'List Jobs';
            $data->field = 'Datatable';
            $data->page = 'list_jobs';
            $this->load->view('admin/includes/header',$data);		
            $this->load->view('jobs',$data);
            $this->load->view('admin/includes/footer',$data);	                        
        }
		
		public function applicants(){
			$data=new stdClass();
            if(!$this->session->userdata('logged_in')){
                redirect('admin');
            }
            
            $id = $this->input->post('job_id');
            $data->applied_jobs = $this->admin_model->joindataResult('j.job_id','c.id',array('j.job_id'=>$id),'j.apply_by,j.resume,j.file,j.proposal,c.*','jobs_applied as j','jobs as c','j.id desc');
            foreach($data->applied_jobs as $key=>$value){
                $apply_by = $this->admin_model->SelectSingleRecord('users','*',array('id'=>$value['apply_by']),$orderby=array());
                $data->applied_jobs[$key]['apply_by'] = $apply_by;
            }            
            
            //echo "<pre>"; print_r($data->applied_jobs); die;            	
            $this->load->view('applicants',$data);            	
        }
        
        public function add_jobs($id){
            
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
                        
            //print_r($data); die;
            if(!empty($_POST)){
               // print_r($_POST);die;                    
                $udata['title'] = $this->input->post('title');
                $udata['description'] = $this->input->post('description');
                $udata['category'] = $this->input->post('category');
                $udata['job_type'] = $this->input->post('job_type');
                $udata['salary'] = $this->input->post('salary');
                $udata['experience'] = $this->input->post('experience');
                $udata['gender'] = $this->input->post('gender');
                $udata['location'] = $this->input->post('location');
                $udata['specialization'] = $this->input->post('specialization');
                $udata['user_id'] = $this->input->post('userid');
                $udata['status'] = $this->input->post('status');
               if($this->admin_model->InsertRecord('jobs',$udata)){
                    $data->error=0;
                    $data->success=1;
                    $data->message="Jobs Posted Successfully";
               }else{
                    $data->error=1;
                    $data->success=0;
                    $data->message="Network Error";
               }
               $this->session->set_flashdata('item',$data);                              
               redirect('admin/jobs/'.$id);
            }
                        
            $udata = array("id"=>$this->session->userdata('user_id'));
            $data->categories = $this->admin_model->SelectRecord('category','*',array(),'id desc');
            $data->users = $this->admin_model->SelectRecord('users','*',array(),'id desc');           
            $data->result = $this->admin_model->SelectSingleRecord('admin','*',$udata,$orderby=array());
            
            
            $data->title = 'Add Jobs';
            $data->field = 'Jobs';
            $data->page = 'add_jobs';
            $data->type = $data->reslt->file_type;
            $this->load->view('admin/includes/header',$data);		
            $this->load->view('add_jobs_view',$data);
            $this->load->view('admin/includes/footer',$data);                                        
        }
        
        public function edit_jobs($id){
            
            // print_r($id); die;
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
            
            $data->reslt = $this->admin_model->SelectSingleRecord('job_post','*',array('id'=>$id),$orderby=array());
            $jid = $data->reslt->user_id;
            $service_id = $data->reslt->service_id;
            // print_r($service_id);die();
            $data->users = $this->admin_model->SelectSingleRecord('users','name',array('id'=>$jid),$orderby=array()); 
            // $data->service_data= $this->admin_model->SelectRecord('users','f_name',array('id'=>$jid),$orderby=array()); 
            $data->service = $this->admin_model->SelectSingleRecord('category','title',array('id'=>$service_id),$orderby=array());
            // $data->service_data= $this->admin_model->SelectRecord('category','*',array('id'=>$service_id ),$orderby=array());
            // print_r($data->service ); die;
            if(!empty($_POST)){
               // print_r($_POST);die;                   
                // $udata['username'] = $this->input->post('username');
                // $udata['title'] = $this->input->post('title'); tomorrow will change other table
                $udata['title'] = $this->input->post('job_title');
                $udata['description'] = $this->input->post('description');
                $udata['min_budget'] = $this->input->post('min_budget');
                $udata['max_budget'] = $this->input->post('max_budget');
                // $udata['gender'] = $this->input->post('gender');
                $udata['address'] = $this->input->post('address');
                // $udata['ufile'] = $this->input->post('attachment');
                $udata['date_time'] = $this->input->post('date_time');
                $udata['proposal_id'] = $this->input->post('proposal_id');
                $udata['status'] = $this->input->post('status');
                // $udata['from_date'] = $this->input->post('from_date');
                // $udata['to_date'] = $this->input->post('to_date'); 
                
               if($_FILES['attachment']['name'] != '')
                // print_r($_FILES['attachment']['name']);die();  

               {          
                    $upload_path = './upload/attachment/';
                    $config['upload_path'] = $upload_path;

                    $config['allowed_types'] = 'jpg|jpeg|gif|png|pdf|txt';
                    $config['overwrite'] = false;
                    // print_r($config);
                    $this->load->library ('upload',$config);
                    if ($this->upload->do_upload('attachment'))
                    {                                    
                       $uploaddata = $this->upload->data();
                        // print_r($udata); die;
                        $udata['ufile'] = $uploaddata['file_name'];
                        $conf['image_library'] = 'gd2';
                        $conf['source_image'] = './upload/attachment/'.$uploaddata['file_name'];
                        $conf['new_image'] = './upload/category/thumb/'.$uploaddata['file_name'];
                        $conf['create_thumb'] = False;
                        $conf['maintain_ratio'] = False;
                        $conf['width']         = 600;
                        $conf['height']       = 400;
                        $this->load->library('image_lib', $conf);
                        $this->image_lib->resize();                                                               

                   }
                    else
                    {                                                    
                        $datas->error=1;
                        $datas->success=0;
                        $datas->message=$this->upload->display_errors(); 
                        $this->session->set_flashdata('item', $datas);
                        redirect('admin/edit_jobs/'.$id);  
                    }

           } 

               if($this->admin_model->UpdateRecord('job_post',$udata,array("id"=>$id))){
                    $data->error=0;
                    $data->success=1;
                    $data->message="Jobs Updated Successfully";
               }else{
                    $data->error=1;
                    $data->success=0;
                    $data->message="Network Error";
               }
               $this->session->set_flashdata('item',$data);                              
               redirect('admin/edit_jobs/'.$id);
            }
                        
            // $udata = array("id"=>$this->session->userdata('user_id'));
            // $data->categories = $this->admin_model->SelectRecord('category','*',array(),'id desc');           
            $data->result = $this->admin_model->SelectSingleRecord('admin','*',$udata='',$orderby=array());           
            
            $data->title = 'Edit Jobs';
            $data->field = 'Jobs';
            $data->page = 'edit_jobs';
            // $data->type = $data->reslt->file_type;
            $this->load->view('admin/includes/header',$data);		
            $this->load->view('edit_jobs_view',$data);
            $this->load->view('admin/includes/footer',$data);                                        
        }
        
        public function delete_job($id,$type=Null){            
            
            $data=new stdClass();
            if($this->admin_model->delete_record('job_post',array("id"=>$id))){
                $data->error=0;
                $data->success=1;
                $data->message="Job Deleted Successfully";
            }else{
                $data->error=1;
                $data->success=0;
                $data->message="Network Error";
            }
            $this->session->set_flashdata('item',$data);
            
            redirect('admin/list_jobs');
        }

        public function delete_proposal($id,$type=Null){            
            
            $data=new stdClass();
            if($this->admin_model->delete_record('proposal',array("id"=>$id))){
                $data->error=0;
                $data->success=1;
                $data->message="Proposal Deleted Successfully";
            }else{
                $data->error=1;
                $data->success=0;
                $data->message="Network Error";
            }
            $this->session->set_flashdata('item',$data);
            
            redirect('admin/proposal_jobs');
        }
        
        public function edit_products($id){
            
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
            
            $data->reslt = $this->admin_model->SelectSingleRecord('products','*',array('id'=>$id),$orderby=array());
            //print_r($data); die;
            if(!empty($_POST)){
               // print_r($_POST);die;
               if($_FILES['file']['name'] != ''){                               
                                
                                $upload_path = './upload/products/';
                                $config['upload_path'] = $upload_path;
                                if($data->reslt->file_type == 1){
                                    $config['allowed_types'] = 'mp4|avi|mov';                                
                                    $config['max_size'] = '0';                                
                                    $config['max_filename'] = '500';                                
                                    $config['encrypt_name'] = FALSE;
                                }
                                if($data->reslt->file_type == 2){
                                    $config['allowed_types'] = 'mp3|';                                                                    
                                }
                                if($data->reslt->file_type == 3){
                                    $config['allowed_types'] = 'jpg|jpeg|gif|png';                                                                    
                                }
                                
                                //print_r($config);die;
                                $this->load->library ('upload',$config);
                                                                
                                if ($this->upload->do_upload('file'))
                                {                                    
                                    $uploaddata = $this->upload->data();                                    
                                    $udata['file'] = $uploaddata['file_name'];
                                    if($data->reslt->file_type == 3){
                                        $conf['image_library'] = 'gd2';
                                        $conf['source_image'] = './upload/products/'.$uploaddata['file_name'];
                                        $conf['new_image'] = './upload/products/image_thumb/'.$uploaddata['file_name'];
                                        $conf['create_thumb'] = False;
                                        $conf['maintain_ratio'] = False;
                                        $conf['width']         = 800;
                                        $conf['height']       = 600;
                                        
                                        $this->load->library('image_lib', $conf);
                                        
                                        $this->image_lib->resize();                                                                
                                    }
                                }
                                else
                                {
                                    //print_r($this->upload->display_errors()); die;
                                    $data->error=1;
                                    $data->success=0;
                                    $data->message=$this->upload->display_errors(); 
                                    $this->session->set_flashdata('item', $data);
                                    print_r('<font class="red">'.$this->upload->display_errors().'</font>'); die;
                                    redirect('admin/edit_products/'.$id);	
                                }
                       
                       }
                       
                       if($_FILES['image_thumb']['name'] != ''){                               
                                
                                $upload_path = './upload/products/audio_thumb/';
                                $thumb_name = uniqid().'.png';
                                //echo $upload_path; die;
                                if (move_uploaded_file($_FILES['image_thumb']['tmp_name'],$upload_path.$thumb_name))
                                {                                                                        
                                    //print_r($udata); die;
                                    $udata['thumb'] = $thumb_name;                                    
                                }
                                else
                                {
                                    
                                    $data->error=1;
                                    $data->success=0;
                                    $data->message='image not uploaded'; 
                                    $this->session->set_flashdata('item', $data);
                                    print_r('<font class="red">image not uploaded</font>'); die;
                                    redirect('admin/edit_products/'.$id);	
                                }
                       
                       }
                       
                if($_POST['thumb']){                        
                        $img = $_POST['thumb'];
                        $img = str_replace('data:image/png;base64,', '', $img);
                        $img = str_replace(' ', '+', $img);
                        $dta = base64_decode($img);
                        $thumbfile = uniqid() . '.png';
                        $file = './upload/products/video_thumb/' . $thumbfile;
                        $success = file_put_contents($file, $dta);
                        if($success){
                            $udata['thumb'] = $thumbfile;    
                        }                        
                       }
                       
               $udata['title'] = $this->input->post('title');
               $udata['description'] = $this->input->post('description');
               $udata['genre'] = $this->input->post('genre');
               $udata['tags'] = $this->input->post('tags');
               $udata['price'] = $this->input->post('price');
               if($this->admin_model->UpdateRecord('products',$udata,array("id"=>$id))){
                    $data->error=0;
                    $data->success=1;
                    $data->message="Products Updated Successfully";
               }else{
                    $data->error=1;
                    $data->success=0;
                    $data->message="Network Error";
               }
               $this->session->set_flashdata('item',$data);
               print_r(site_url('admin/edit_products/'.$id)); die;
               //print_r("<font color='green'>Products Updated successfully</font>"); die;
               redirect('admin/edit_products/'.$id);
            }
                        
            $udata = array("id"=>$this->session->userdata('user_id'));
            $data->genres = $this->admin_model->SelectRecord('genre','*',array(),'id desc');           
            $data->result = $this->admin_model->SelectSingleRecord('admin','*',$udata,$orderby=array());
            
            if($data->reslt->file_type == 1)   { $data->title = 'Edit Videos'; }
            else if($data->reslt->file_type == 2)   { $data->title = 'Edit Audios'; }
            else if($data->reslt->file_type == 3)   { $data->title = 'Edit Images'; }
            else { $data->title = 'Edit Products'; }
            $data->field = 'Products';
            $data->page = 'edit_products';
            $data->type = $data->reslt->file_type;
            $this->load->view('admin/includes/header',$data);		
            $this->load->view('edit_products_view',$data);
            $this->load->view('admin/includes/footer',$data);                                        
        }
	
	public function edit_other_products($id){
            
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
            
            $data->reslt = $this->admin_model->SelectSingleRecord('other_products','*',array('id'=>$id),$orderby=array());
            //print_r($data); die;
            if(!empty($_POST)){
               // print_r($_POST);die;
               if($_FILES['file']['name'] != ''){                               
                                
                                $upload_path = './upload/other_products/';
                                $config['upload_path'] = $upload_path;
                                
                                $config['allowed_types'] = 'jpg|jpeg|gif|png|pdf|docx';                                                                    
                                
                                
                                //print_r($config);die;
                                $this->load->library ('upload',$config);
                                                                
                                if ($this->upload->do_upload('file'))
                                {                                    
                                    $uploaddata = $this->upload->data();                                    
                                    $udata['file'] = $uploaddata['file_name'];                                    
                                }
                                else
                                {
                                    //print_r($this->upload->display_errors()); die;
                                    $data->error=1;
                                    $data->success=0;
                                    $data->message=$this->upload->display_errors(); 
                                    $this->session->set_flashdata('item', $data);
                                    print_r('<font class="red">'.$this->upload->display_errors().'</font>'); die;
                                    redirect('admin/edit_other_products/'.$id);	
                                }
                       
                       }
                       
                       if($_FILES['image_thumb']['name'] != ''){                               
                                
                                $upload_path = './upload/other_products/thumb';
				$iconfig['upload_path'] = $upload_path;
				$iconfig['allowed_types'] = 'jpg|jpeg|gif|png';
				$this->upload->initialize($iconfig);
                                $thumb_name = uniqid().'.png';
				
				if ($this->upload->do_upload('image_thumb'))
                                {                                    
                                    $iuploaddata = $this->upload->data();
                                    //print_r($udata); die;
                                    $udata['thumb'] = $iuploaddata['file_name'];
                                    
                                        $iconf['image_library'] = 'gd2';
                                        $iconf['source_image'] = './upload/other_products/thumb/'.$iuploaddata['file_name'];
                                        $iconf['new_image'] = './upload/other_products/thumb/small/'.$iuploaddata['file_name'];
                                        $iconf['create_thumb'] = False;
                                        $iconf['maintain_ratio'] = False;
                                        $iconf['width']         = 600;
                                        $iconf['height']       = 400;
                                        
                                        $this->load->library('image_lib', $iconf);
                                        
                                        $this->image_lib->resize();                                                                
                                    
                                }
                                else
                                {
                                    //print_r("Other_products Added Failed"); die;
                                    print_r('<font style="color:red"><h5>'.strip_tags($this->upload->display_errors()).'<a href="'.$actual_link.'">Try Again!</a></h5></font>'); die;
                                    $data->error=1;
                                    $data->success=0;
                                    $data->message=$this->upload->display_errors(); 
                                    $this->session->set_flashdata('item', $data);
                                    redirect('admin/edit_other_products/'.$id);	
                                }
                                
                       }
                                       
                       
               $udata['title'] = $this->input->post('title');
               $udata['description'] = $this->input->post('description');               
               $udata['tags'] = $this->input->post('tags');
               $udata['price'] = $this->input->post('price');
               if($this->admin_model->UpdateRecord('other_products',$udata,array("id"=>$id))){
                    $data->error=0;
                    $data->success=1;
                    $data->message="Products Updated Successfully";
               }else{
                    $data->error=1;
                    $data->success=0;
                    $data->message="Network Error";
               }
               $this->session->set_flashdata('item',$data);
               print_r(site_url('admin/edit_other_products/'.$id)); die;
               //print_r("<font color='green'>Products Updated successfully</font>"); die;
               redirect('admin/edit_other_products/'.$id);
            }
                        
            $udata = array("id"=>$this->session->userdata('user_id'));                
            $data->result = $this->admin_model->SelectSingleRecord('admin','*',$udata,$orderby=array());
            
            $data->title = 'Edit Products';
            $data->field = 'Products';
            $data->page = 'edit_other_products';
            $this->load->view('admin/includes/header',$data);		
            $this->load->view('edit_other_products_view',$data);
            $this->load->view('admin/includes/footer',$data);                                        
        }
        
        public function add_products($type=NULL){            
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
            
            $admindata = array("id"=>$this->session->userdata('user_id'));                
            $data->result = $this->admin_model->SelectSingleRecord('admin','*',$admindata,$orderby=array());
                        
            $data->genres = $this->admin_model->SelectRecord('genre','*',array(),'id desc');
            $data->users = $this->admin_model->SelectRecord('users','*',array(),'id desc');           
                if(!empty($_POST)){                    
                       // print_r($_FILES);die;
                       if($_FILES['file']['name'] != ''){                               
                                
                                $upload_path = './upload/products/';
                                $config['upload_path'] = $upload_path;
                                
                                if($type == 1){
                                    $config['allowed_types'] = 'mp4|avi|mov';                                
                                    $config['max_size'] = '0';                                
                                    $config['max_filename'] = '500';                                
                                    $config['encrypt_name'] = FALSE;
                                }
                                if($type == 2){
                                    $config['allowed_types'] = 'mp3|';                                                                    
                                }
                                if($type == 3){
                                    $config['allowed_types'] = 'jpg|jpeg|gif|png';                                                                    
                                }
                                $config['overwrite'] = false;
                                //print_r($config);
                                $this->load->library ('upload',$config);
                                

                                
                                if ($this->upload->do_upload('file'))
                                {                                    
                                    $uploaddata = $this->upload->data();
                                    //print_r($udata); die;
                                    $udata['file'] = $uploaddata['file_name'];
                                    
                                    if($type == 3){
                                        $conf['image_library'] = 'gd2';
                                        $conf['source_image'] = './upload/products/'.$uploaddata['file_name'];
                                        $conf['new_image'] = './upload/products/image_thumb/'.$uploaddata['file_name'];
                                        $conf['create_thumb'] = False;
                                        $conf['maintain_ratio'] = False;
                                        $conf['width']         = 800;
                                        $conf['height']       = 600;
                                        
                                        $this->load->library('image_lib', $conf);
                                        
                                        $this->image_lib->resize();                                                                
                                    }
                                }
                                else
                                {
                                    //print_r("Products Added Failed"); die;
                                    print_r('<font class="red"><h3>'.$this->upload->display_errors().'</h3></font>'); die;
                                    $data->error=1;
                                    $data->success=0;
                                    $data->message=$this->upload->display_errors(); 
                                    $this->session->set_flashdata('item', $data);
                                    redirect('products/add/'.$type);	
                                }
                       
                       }
                       if($_FILES['image_thumb']['name'] != ''){                               
                                
                                $upload_path = './upload/products/audio_thumb/';
                                $thumb_name = uniqid().'.png';

                                if (move_uploaded_file($_FILES['image_thumb']['tmp_name'],$upload_path.$thumb_name))
                                {                                                                        
                                    //print_r($udata); die;
                                    $udata['thumb'] = $thumb_name;                                    
                                }
                                else
                                {
                                    
                                    $data->error=1;
                                    $data->success=0;
                                    $data->message='image not uploaded'; 
                                    $this->session->set_flashdata('item', $data);
                                    print_r('<font class="red"><h3>Image not uploaded</h3></font>'); die;
                                    redirect('products/add/'.$type);	
                                }
                       
                       }
                       
                       
                       if($_POST['thumb']){
                        define('UPLOAD_DIR', './upload/products/video_thumb/');
                        $img = $_POST['thumb'];
                        $img = str_replace('data:image/png;base64,', '', $img);
                        $img = str_replace(' ', '+', $img);
                        $dta = base64_decode($img);
                        $thumbfile = uniqid() . '.png';
                        $file = UPLOAD_DIR . $thumbfile;
                        $success = file_put_contents($file, $dta);
                        if($success){
                            $udata['thumb'] = $thumbfile;    
                        }                        
                       }
                       
                        $udata['title'] = $this->input->post('title');
                        $udata['description'] = $this->input->post('description');
                        $udata['file_type'] = $type;
                        $udata['genre'] = $this->input->post('genre');
                        $udata['user_id'] = $this->input->post('userid');
                        $udata['price'] = $this->input->post('price');
                        $udata['tags'] = $this->input->post('tags');
                        //print_r($udata); die;
                        if($this->admin_model->InsertRecord('products',$udata)){
                             $data->error=0;
                             $data->success=1;
                             $data->message="Products Added Successfully";
                        }else{
                             $data->error=1;
                             $data->success=0;
                             $data->message="Network Error";
                        }
                       
                    
                    $this->session->set_flashdata('item',$data);
                    print_r(site_url('admin/add_products/'.$type)); die;
                    //print_r("<font color='green'>Products Added successfully</font>"); die;
                    redirect('products/add/'.$type);
                }
                        
            if($type == 1)   { $data->title = 'Add Videos'; }
            else if($type == 2)   { $data->title = 'Add Audios'; }
            else if($type == 3)   { $data->title = 'Add Images'; }
            else { $data->title = 'Add Products'; }
            $data->field = 'Products';
            $data->page = ($type == '2') ? "audios" : (($type == '1')  ? "videos" : "pictures");
            $data->page ='add_'.$data->page;
            $data->type = $type;
            
            $this->load->view('admin/includes/header',$data);		
            $this->load->view('add_products_view',$data);
            $this->load->view('admin/includes/footer',$data);                                        
        }
	
	public function add_other_products($type=NULL){            
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
            
            $admindata = array("id"=>$this->session->userdata('user_id'));                
            $data->result = $this->admin_model->SelectSingleRecord('admin','*',$admindata,$orderby=array());
                                    
            $data->users = $this->admin_model->SelectRecord('users','*',array(),'id desc');           
                if(!empty($_POST)){                    
                       // print_r($_FILES);die;
                       if($_FILES['file']['name'] != ''){                               
                                
                                $upload_path = './upload/other_products/';
                                $config['upload_path'] = $upload_path;
                                
                                $config['allowed_types'] = 'jpg|jpeg|gif|png|pdf|docx';                                                                    
                                
                                
                                //print_r($config);die;
                                $this->load->library ('upload',$config);
                                                                
                                if ($this->upload->do_upload('file'))
                                {                                    
                                    $uploaddata = $this->upload->data();                                    
                                    $udata['file'] = $uploaddata['file_name'];                                    
                                }
                                else
                                {
                                    //print_r($this->upload->display_errors()); die;
                                    $data->error=1;
                                    $data->success=0;
                                    $data->message=$this->upload->display_errors(); 
                                    $this->session->set_flashdata('item', $data);
                                    print_r('<font class="red">'.$this->upload->display_errors().'</font>'); die;
                                    redirect('admin/add_other_products/');	
                                }
                       
                       }
                       
                       if($_FILES['image_thumb']['name'] != ''){                               
                                
                                $upload_path = './upload/other_products/thumb';
				$iconfig['upload_path'] = $upload_path;
				$iconfig['allowed_types'] = 'jpg|jpeg|gif|png';
				$this->upload->initialize($iconfig);
                                $thumb_name = uniqid().'.png';
				
				if ($this->upload->do_upload('image_thumb'))
                                {                                    
                                    $iuploaddata = $this->upload->data();
                                    //print_r($udata); die;
                                    $udata['thumb'] = $iuploaddata['file_name'];
                                    
                                        $iconf['image_library'] = 'gd2';
                                        $iconf['source_image'] = './upload/other_products/thumb/'.$iuploaddata['file_name'];
                                        $iconf['new_image'] = './upload/other_products/thumb/small/'.$iuploaddata['file_name'];
                                        $iconf['create_thumb'] = False;
                                        $iconf['maintain_ratio'] = False;
                                        $iconf['width']         = 600;
                                        $iconf['height']       = 400;
                                        
                                        $this->load->library('image_lib', $iconf);
                                        
                                        $this->image_lib->resize();                                                                
                                    
                                }
                                else
                                {
                                    //print_r("Other_products Added Failed"); die;
                                    print_r('<font style="color:red"><h5>'.strip_tags($this->upload->display_errors()).'<a href="'.$actual_link.'">Try Again!</a></h5></font>'); die;
                                    $data->error=1;
                                    $data->success=0;
                                    $data->message=$this->upload->display_errors(); 
                                    $this->session->set_flashdata('item', $data);
                                    redirect('admin/add_other_products/');	
                                }
                                
                       }
                                                               
                       
                        $udata['title'] = $this->input->post('title');
                        $udata['description'] = $this->input->post('description');                                        
                        $udata['user_id'] = $this->input->post('userid');
                        $udata['price'] = $this->input->post('price');
                        $udata['tags'] = $this->input->post('tags');
                        //print_r($udata); die;
                        if($this->admin_model->InsertRecord('other_products',$udata)){
                             $data->error=0;
                             $data->success=1;
                             $data->message="Products Added Successfully";
                        }else{
                             $data->error=1;
                             $data->success=0;
                             $data->message="Network Error";
                        }
                       
                    
                    $this->session->set_flashdata('item',$data);
                    print_r(site_url('admin/add_other_products/')); die;
                    //print_r("<font color='green'>Products Added successfully</font>"); die;
                    redirect('products/add/'.$type);
                }
                        
            $data->title = 'Add Products';
            $data->field = 'Products';            
            $data->page ='add_other_products';            
            
            $this->load->view('admin/includes/header',$data);		
            $this->load->view('add_other_products_view',$data);
            $this->load->view('admin/includes/footer',$data);                                        
        }
        
        public function delete_product($id,$type=Null){
            $products = $this->admin_model->SelectSingleRecord('products','*',array('id'=>$id),$orderby=array());
            if(isset($products->products)){
                unlink('./upload/products/'.$products->products);    
            }
            
            $data=new stdClass();
            if($this->admin_model->delete_record('products',array("id"=>$id))){
                $data->error=0;
                $data->success=1;
                $data->message="Products Deleted Successfully";
            }else{
                $data->error=1;
                $data->success=0;
                $data->message="Network Error";
            }
            $this->session->set_flashdata('item',$data);
            $type = ($type == '2') ? "audios" : (($type == '1')  ? "videos" : "pictures");
            redirect('admin/'.$type);
        }
	
	public function delete_other_product($id,$type=Null){
            $products = $this->admin_model->SelectSingleRecord('other_products','*',array('id'=>$id),$orderby=array());
            if(isset($products->products)){
                unlink('./upload/other_products/'.$products->products);    
            }
            
            $data=new stdClass();
            if($this->admin_model->delete_record('other_products',array("id"=>$id))){
                $data->error=0;
                $data->success=1;
                $data->message="Products Deleted Successfully";
            }else{
                $data->error=1;
                $data->success=0;
                $data->message="Network Error";
            }
            $this->session->set_flashdata('item',$data);
            
            redirect('admin/products');
        }
        
        public function transaction_fee(){
            if($this->session->userdata('user_group_id') != 3){
                redirect('admin');
            }
            if(!$this->session->userdata('logged_in')){
                redirect('admin');
            }
            $data=new stdClass();
			
            //print_r($result); die;
			if($_POST){
                
                    $udata=array(                                            
                        'transaction_fee'=>$this->input->post('transaction_fee')                                            
                        );                                    
               
				if ($this->admin_model->UpdateRecord('admin',$udata,array("id"=>1)))
				{
                    $data->error=0;
                    $data->success=1;
                    $data->message='Updated Sucessfully.';
                     					
				}else{
                    $data->error=1;
                    $data->success=0;
                    $data->message='Network Error!';                    
                }
                //print_r($data); die;
            $this->session->set_flashdata('item',$data);
            redirect('admin/transaction_fee/');
			//print_r($this->session->flashdata('item')); die;	
			}
            
            $udata = array("id"=>$this->session->userdata('user_id'));                
            $data->result = $this->admin_model->SelectSingleRecord('admin','*',$udata,$orderby=array());
                        
            $data->title = 'Transaction Fee';
            $data->field = 'Transaction Fee';
            $data->page = 'transaction_fee';
            $this->load->view('admin/includes/header',$data);		
            $this->load->view('edit_transaction_fee_view',$data);
            $this->load->view('admin/includes/footer',$data);			
	}
	
	public function cards(){
            if($this->session->userdata('user_group_id') != 3){
                redirect('admin');
            }
            if(!$this->session->userdata('logged_in')){
                redirect('admin');
            }
            $data=new stdClass();
			
            //print_r($result); die;
		if($_POST){
                
			$udata=array(                                            
			     'limit'=>$this->input->post('gold_amt')			     
                        );
			$this->admin_model->UpdateRecord('card_type',$udata,array('name'=>'Gold'));
			
			$udata=array(                                            			     
			     'limit'=>$this->input->post('silver_amt')			     
                        );
			$this->admin_model->UpdateRecord('card_type',$udata,array('name'=>'Silver'));
			
			$udata=array(                                            			     
			     'limit'=>$this->input->post('bronze_amt')
                        );
			$this->admin_model->UpdateRecord('card_type',$udata,array('name'=>'Bronze'));
               
		
                    $data->error=0;
                    $data->success=1;
                    $data->message='Updated Sucessfully.';
                     							                
		    $this->session->set_flashdata('item',$data);
		    redirect('admin/cards/');
			//print_r($this->session->flashdata('item')); die;	
		}
            
            $udata = array("id"=>$this->session->userdata('user_id'));                
            $data->result = $this->admin_model->SelectSingleRecord('admin','*',$udata,$orderby=array());
	    $data->cards = $this->admin_model->SelectRecord('card_type','*',array(),$orderby=array());
	    
	    $data->users = $this->admin_model->SelectRecord('users','*',array(),$orderby=array());
            //echo "<pre>"; print_r($data->cards); die;          
            $data->title = 'Executive Cards';
            $data->field = 'Datatable';
            $data->page = 'executive_cards';
            $this->load->view('admin/includes/header',$data);		
            $this->load->view('executive_cards_view',$data);
            $this->load->view('admin/includes/footer',$data);			
	}
	
	public function allot_cards(){
            if($this->session->userdata('user_group_id') != 3){
                redirect('admin');
            }
            if(!$this->session->userdata('logged_in')){
                redirect('admin');
            }
            $data=new stdClass();
			
            //print_r($result); die;
		if($_POST){
			$no_of_cards = $this->input->post('no_of_cards');
			for($i=0; $i<$no_of_cards; $i++){
				$udata=array(
					'user_id'=>$this->input->post('user_id'),
					'card_type'=>$this->input->post('card_type')			     
				   );
				   
				   $this->admin_model->InsertRecord('cards',$udata);	
			}
			
			
		
                    $data->error=0;
                    $data->success=1;
                    $data->message='Cards Alloted Sucessfully.';
                     							                
		    $this->session->set_flashdata('item',$data);
		    redirect('admin/cards/');
			//print_r($this->session->flashdata('item')); die;	
		}
                    
	}
        
        public function transactions(){            
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
            $udata = array("id"=>$this->session->userdata('user_id'));                
            $data->result = $this->admin_model->SelectSingleRecord('admin','*',$udata,$orderby=array());                                               
            
            
            $data->transactions = $this->admin_model->SelectRecord('transactions','*',array(),'id desc');                                        
            
            //print_r($data->pending); die;
            $data->title = 'All Transactions';
            $data->field = 'Datatable';
            $data->page = 'transactions';
            $this->load->view('admin/includes/header',$data);		
            $this->load->view('transactions_view',$data);
            $this->load->view('admin/includes/footer',$data);
           
        }
        
        public function orders(){
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
            
            $udata = array("id"=>$this->session->userdata('user_id'));                
            $data->result = $this->admin_model->SelectSingleRecord('admin','*',$udata,$orderby=array());
            
            $data->orders = $this->admin_model->SelectRecord('order','*',array(),'id desc');
            
            //echo "<pre>"; print_r($data); die;
            $data->title = 'All Orders';
            $data->field = 'Datatable';
            $data->page = 'orders';            
            
            $this->load->view('admin/includes/header',$data);		
            $this->load->view('order_view',$data);
            $this->load->view('admin/includes/footer',$data);
        }
        
        public function earnings(){            
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
            $udata = array("id"=>$this->session->userdata('user_id'));                
            $data->result = $this->admin_model->SelectSingleRecord('admin','*',$udata,$orderby=array());
            
            $data->charge = $this->get_Charge();
            
            $data->wallet = $this->admin_model->SelectSingleRecord('wallet','*',array('user_id'=>0),$orderby=array());                                                                             
            //$data->earnings1 = $this->earnings_model->joindataResult('o.product_id','p.id',array("o.seller_id"=>$this->session->userdata('user_id'),'product_id !='=>0),'p.title,p.id as product_id,o.*','order_detail as o','products as p','o.id desc');
            //$data->earnings = $this->earnings_model->SelectRecord('order_detail','*',array('seller_id'=>$this->session->userdata('user_id')),'id desc');
            $data->earnings = $this->admin_model->joindataResult('od.order_id','o.order_no',array(),'od.*,o.user_id','order_detail as od','order as o','od.id desc');
            
            //echo "<pre>"; print_r($data->earnings); die;
            $data->title = 'All Earnings';
            $data->field = 'Datatable';
            $data->page = 'earnings';
            $this->load->view('admin/includes/header',$data);		
            $this->load->view('earnings_view',$data);
            $this->load->view('admin/includes/footer',$data);
           
        }
        
        public function offers(){
            if(!$this->session->userdata('logged_in')){                
                redirect('user');
            }
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
            $udata = array("id"=>$this->session->userdata('user_id'));                
            $data->result = $this->admin_model->SelectSingleRecord('admin','*',$udata,$orderby=array());
            
            $data->offer = $this->admin_model->SelectRecord('offer','*',[],'id desc');
            
            $data->title = 'All Offer';
                                    
            
            //echo "<pre>"; print_r($data->offer); die;                        
            $data->field = 'Datatable';            
            $data->page = 'offer';
            $this->load->view('admin/includes/header',$data);		
            $this->load->view('offer_view',$data);
            $this->load->view('admin/includes/footer',$data);           
        }
        
        public function offer_detail($id=NULL){
            if(!$this->session->userdata('logged_in')){                
                redirect('admin/offers');
            }
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
            $udata = array("id"=>$this->session->userdata('user_id'));                
            $data->result = $this->admin_model->SelectSingleRecord('admin','*',$udata,$orderby=array());
            if($id > 0 && is_numeric($id)){
                $data->offer = $this->admin_model->SelectSingleRecord('offer','*',['id'=>$id],$orderby=array());
                if(empty($data->offer)) redirect('admin/offers');
            }else{
                redirect('admin/offers');
            }
            
            $data->comments = $this->admin_model->SelectRecord('comments','*',['offer_id'=>$id],'id asc');            
            //print_r($data->comments); die;
            $data->title = 'Offer';
            $data->field = 'Datatable';
            $data->page = 'offer';            
            
            $this->load->view('admin/includes/header',$data);		
            $this->load->view('offer_detail_view',$data);
            $this->load->view('admin/includes/footer',$data);
        }
        
        public function offer_contract($id=0){
            
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
            $udata = array("id"=>$this->session->userdata('user_id'));                
            $data->result = $this->admin_model->SelectSingleRecord('admin','*',$udata,$orderby=array());
            
            if($id > 0 && is_numeric($id)){
                $data->offer = $this->admin_model->SelectSingleRecord('offer','*',['id'=>$id],$orderby=array());    
            }else{
                redirect('admin/offers');
            }
            
            
            $data->comments = $this->admin_model->SelectRecord('comments','*',['offer_id'=>$id],'id asc');    
            //print_r($data->pending); die;
            $data->title = 'Sign Contract';
            $data->field = 'Datatable';
            $data->page = 'sign_contract';
            $data->offer_id = $id;
            
            $this->load->view('admin/includes/header',$data);		
            $this->load->view('contract_view',$data);
            $this->load->view('admin/includes/footer',$data);
        }
		
		function featured_products()
        {            
            $data=new stdClass();            
            if(!$this->session->userdata('logged_in')){
                redirect('admin');
            }
            
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
            $data->products = $this->admin_model->SelectRecord('featured_products','*',array("status"=>1),$orderby=array());
            $udata = array("id"=>$this->session->userdata('user_id'));                
            $data->result = $this->admin_model->SelectSingleRecord('admin','*',$udata,$orderby=array());
            $data->title = 'List Featured Recordings';
            $data->field = 'Datatable';
            $data->page = 'list_featured_products';
            $this->load->view('admin/includes/header',$data);		
            $this->load->view('featured_products',$data);
            $this->load->view('admin/includes/footer',$data);	                        
        }
		
		public function add_featured_products($type=NULL){            
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
            
            $admindata = array("id"=>$this->session->userdata('user_id'));                
            $data->result = $this->admin_model->SelectSingleRecord('admin','*',$admindata,$orderby=array());
                        
            $data->genres = $this->admin_model->SelectRecord('genre','*',array(),'id desc');
            $data->users = $this->admin_model->SelectRecord('users','*',array(),'id desc');           
                if(!empty($_POST)){                    
                       // print_r($_FILES);die;
                       if($_FILES['file']['name'] != ''){                               
                                
                                $upload_path = './upload/products/';
                                $config['upload_path'] = $upload_path;
                                $config['allowed_types'] = 'mp3|';                                                                    
                                
                                $config['overwrite'] = false;
                                //print_r($config);
                                $this->load->library ('upload',$config);
                                

                                
                                if ($this->upload->do_upload('file'))
                                {                                    
                                    $uploaddata = $this->upload->data();
                                    //print_r($udata); die;
                                    $udata['file'] = $uploaddata['file_name'];                                                                        
                                }
                                else
                                {
                                    //print_r("Products Added Failed"); die;
                                    print_r('<font class="red"><h3>'.$this->upload->display_errors().'</h3></font>'); die;
                                    $data->error=1;
                                    $data->success=0;
                                    $data->message=$this->upload->display_errors(); 
                                    $this->session->set_flashdata('item', $data);
                                    redirect('products/add/'.$type);	
                                }
                       
                       }
                       if($_FILES['image_thumb']['name'] != ''){                               
                                
                                $upload_path = './upload/products/audio_thumb/';
                                $thumb_name = uniqid().'.png';

                                if (move_uploaded_file($_FILES['image_thumb']['tmp_name'],$upload_path.$thumb_name))
                                {                                                                        
                                    //print_r($udata); die;
                                    $udata['thumb'] = $thumb_name;                                    
                                }
                                else
                                {
                                    
                                    $data->error=1;
                                    $data->success=0;
                                    $data->message='image not uploaded'; 
                                    $this->session->set_flashdata('item', $data);
                                    print_r('<font class="red"><h3>Image not uploaded</h3></font>'); die;
                                    redirect('products/add/'.$type);	
                                }
                       
                       }
                       
                       
                       
                        $udata['title'] = $this->input->post('title');
                        $udata['description'] = $this->input->post('description');                                                                                                
                        $udata['tags'] = $this->input->post('tags');
                        //print_r($udata); die;
                        if($this->admin_model->InsertRecord('featured_products',$udata)){
                             $data->error=0;
                             $data->success=1;
                             $data->message="Added Successfully";
                        }else{
                             $data->error=1;
                             $data->success=0;
                             $data->message="Network Error";
                        }
                       
                    
                    $this->session->set_flashdata('item',$data);
                    print_r(site_url('admin/add_featured_products/')); die;
                    //print_r("<font color='green'>Products Added successfully</font>"); die;
                    redirect('products/add/'.$type);
                }
                        
            $data->title = 'Add Featured Products';
            $data->field = 'Products';
            $data->page = 'add_featured_products';                        
            
            $this->load->view('admin/includes/header',$data);		
            $this->load->view('add_featured_products_view',$data);
            $this->load->view('admin/includes/footer',$data);                                        
        }
        
		public function edit_featured_products($id){
            
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
            
            $data->reslt = $this->admin_model->SelectSingleRecord('featured_products','*',array('id'=>$id),$orderby=array());
            //print_r($data); die;
            if(!empty($_POST)){
               // print_r($_POST);die;
               if($_FILES['file']['name'] != ''){                               
                                
                                $upload_path = './upload/products/';
                                $config['upload_path'] = $upload_path;
                                $config['allowed_types'] = 'mp3|';                                                                    
                                
                                //print_r($config);die;
                                $this->load->library ('upload',$config);
                                                                
                                if ($this->upload->do_upload('file'))
                                {                                    
                                    $uploaddata = $this->upload->data();                                    
                                    $udata['file'] = $uploaddata['file_name'];                                    
                                }
                                else
                                {
                                    //print_r($this->upload->display_errors()); die;
                                    $data->error=1;
                                    $data->success=0;
                                    $data->message=$this->upload->display_errors(); 
                                    $this->session->set_flashdata('item', $data);
                                    print_r('<font class="red">'.$this->upload->display_errors().'</font>'); die;
                                    redirect('admin/edit_products/'.$id);	
                                }
                       
                       }
                       
                       if($_FILES['image_thumb']['name'] != ''){                               
                                
                                $upload_path = './upload/products/audio_thumb/';
                                $thumb_name = uniqid().'.png';
                                //echo $upload_path; die;
                                if (move_uploaded_file($_FILES['image_thumb']['tmp_name'],$upload_path.$thumb_name))
                                {                                                                        
                                    //print_r($udata); die;
                                    $udata['thumb'] = $thumb_name;                                    
                                }
                                else
                                {
                                    
                                    $data->error=1;
                                    $data->success=0;
                                    $data->message='image not uploaded'; 
                                    $this->session->set_flashdata('item', $data);
                                    print_r('<font class="red">image not uploaded</font>'); die;
                                    redirect('admin/edit_products/'.$id);	
                                }
                       
                       }
                                       
                       
               $udata['title'] = $this->input->post('title');
               $udata['description'] = $this->input->post('description');               
               $udata['tags'] = $this->input->post('tags');               
               if($this->admin_model->UpdateRecord('featured_products',$udata,array("id"=>$id))){
                    $data->error=0;
                    $data->success=1;
                    $data->message="Updated Successfully";
               }else{
                    $data->error=1;
                    $data->success=0;
                    $data->message="Network Error";
               }
               $this->session->set_flashdata('item',$data);
               print_r(site_url('admin/edit_featured_products/'.$id)); die;
               //print_r("<font color='green'>Products Updated successfully</font>"); die;
               redirect('admin/edit_products/'.$id);
            }
                        
            $udata = array("id"=>$this->session->userdata('user_id'));            
            $data->result = $this->admin_model->SelectSingleRecord('admin','*',$udata,$orderby=array());
                        
            $data->title = 'Edit Recording';
            $data->field = 'Products';
            $data->page = 'edit_featured_products';
            
            $this->load->view('admin/includes/header',$data);		
            $this->load->view('edit_featured_products_view',$data);
            $this->load->view('admin/includes/footer',$data);                                        
        }
		
        public function delete_featured_product($id,$type=Null){
            $products = $this->admin_model->SelectSingleRecord('featured_products','*',array('id'=>$id),$orderby=array());
            if(isset($products->products)){
                unlink('./upload/products/'.$products->products);    
            }
            
            $data=new stdClass();
            if($this->admin_model->delete_record('featured_products',array("id"=>$id))){
                $data->error=0;
                $data->success=1;
                $data->message="Deleted Successfully";
            }else{
                $data->error=1;
                $data->success=0;
                $data->message="Network Error";
            }
            $this->session->set_flashdata('item',$data);
            
            redirect('admin/featured_products');
        }
	
	public function withdraw_request(){            
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
            $udata = array("id"=>$this->session->userdata('user_id'));                
            $data->result = $this->admin_model->SelectSingleRecord('admin','*',$udata,$orderby=array());                                               
            
            
            $data->withdraw = $this->admin_model->SelectRecord('withdraw','*',array('status'=>'0'),'id desc');
	    
	    $data->withdraw_history = $this->admin_model->SelectRecord('withdraw','*',array('status'=>'1'),'id desc');                                        
            
            //print_r($data->pending); die;
            $data->title = 'All Withdraw Requests';
            $data->field = 'Datatable';
            $data->page = 'withdraw';
            $this->load->view('admin/includes/header',$data);		
            $this->load->view('withdraw_request_view',$data);
            $this->load->view('admin/includes/footer',$data);
           
        }
	
	
	public function update_request($requestid){
            $data=new stdClass();
		$request = $this->admin_model->SelectSingleRecord('withdraw','*',array('id'=>$requestid),'id desc'); 
		if($this->admin_model->UpdateRecord('withdraw',array('status'=>'1'),array('id'=>$requestid))){
					   
		   
		    deduct_wallet($request->user_id,$request->amount);                        
		    $data->error=0;
		    $data->success=1;
		    $data->message= "Money has been transferred successfully to user";
		    $this->session->set_flashdata('item',$data);
		    redirect('admin/withdraw_request');
		}                
        }
	//*****************paypal**************************************
	public function pay($requestid=Null){
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
                
                $request = $this->admin_model->SelectSingleRecord('withdraw','*',array('id'=>$requestid),'id desc');
		$data->request_id = $requestid; 
                $data->price = $request->amount; 
                $data->user_id = $request->user_id;
		$data->method = $request->transfer_method;
		
		$account = $this->admin_model->SelectSingleRecord('user_account_info','*',array('user_id'=>$data->user_id),'id desc');
		$data->paypal_id = $account->paypal_id;
		$data->ifsc = $account->ifsc;
		$data->acc_no = $account->acc_no;
		$data->acc_name = $account->acc_name;
                
                if($_POST){
		    if($this->admin_model->UpdateRecord('withdraw',array('status'=>'1'),array('id'=>$requestid))){					   		   
			deduct_wallet($request->user_id,$request->amount);
			//send mail to user
				$to = get_user($this->session->userdata('user_id'))->email;
				$sub = "Your funds has been released.";
				$message="<p>Your funds has been released!</p>";
				$message .="<p>Amount Released - $".$request->amount."</p>";
				$message .="<p>Transfer Method - ".$request->transfer_method."</p>";
				if($request->transfer_method == 'Paypal') {
					$message .="<p>Paypal Id - ".$account->paypal_id."</p>";
				}else{
					$message .="<p>IFSC Code - ".$account->paypal_id."</p>";
					$message .="<p>Account Number - ".$account->acc_no."</p>";
					$message .="<p>Account Holder Name - ".$account->acc_name."</p>";
				}
				$message .="<p><a href='".site_url()."withdraw'>Click here</a> to view detail.</p>";
								
				$this->sendemail($to,$sub,$message);
				//
				$to = $this->get_admin_email();				
				$sub = "You have released funds for ".get_user($request->user_id)->f_name;
				$message="<p>You have released fund for ".get_user($request->user_id)->f_name." !</p>";
				$message .="<p>Amount Released - $".$request->amount."</p>";
				$message .="<p>Transfer Method - ".$request->transfer_method."</p>";
				if($request->transfer_method == 'Paypal') {
					$message .="<p>Paypal Id - ".$account->paypal_id."</p>";
				}else{
					$message .="<p>IFSC Code - ".$account->paypal_id."</p>";
					$message .="<p>Account Number - ".$account->acc_no."</p>";
					$message .="<p>Account Holder Name - ".$account->acc_name."</p>";
				}
				$message .="<p><a href='".site_url()."admin/withdraw_request'>Click here</a> to view detail.</p>";
				
				//// insert notifications				
				$idata['url'] = 'withdraw';
				$idata['message'] = "Your funds has been released!";
				$idata['user_id'] = $request->user_id;
				$idata['is_read'] = 0;
				$this->admin_model->InsertRecord('notifications',$idata);
				
				$this->sendemail($to,$sub,$message);
			$data->error=0;
			$data->success=1;
			$data->message= "Money has been transferred successfully to user";
			$this->session->set_flashdata('item',$data);
			redirect('admin/withdraw_request');
		    }  
                               
                }
		 
	    $udata = array("id"=>$this->session->userdata('user_id'));                
            $data->result = $this->admin_model->SelectSingleRecord('admin','*',$udata,$orderby=array());   
		
	    $data->title = 'User Account Information';
            $data->field = '';
            $data->page = 'user_account';
            $this->load->view('admin/includes/header',$data);		
            $this->load->view('transfer_money_view',$data);
            $this->load->view('admin/includes/footer',$data);
            
        }
        
        public function success(){
            $data=new stdClass();
            $paypalInfo = $this->input->get();
                //print_r($paypalInfo); die;
                $data->user_id = $this->session->userdata('user_id');
                $data->request_id = $paypalInfo['item_number'];
                $data->seller_id = $paypalInfo['item_name'];
                $data->txn_id = $paypalInfo["tx"];
                $data->payment_amt = $paypalInfo["amt"];
                $data->currency_code = $paypalInfo["cc"];
                $data->status = $paypalInfo["st"];                    
                $data->cm = $paypalInfo["cm"];
                
                $is_txn = $this->admin_model->SelectSingleRecord('transactions_withdraw','*',array('txn_id'=>$data->txn_id),'id desc');
                //print_r($is_txn); die;
                if(empty($is_txn)){                    
		    $udata['request_id'] = $data->request_id; 
                    $udata['txn_id'] = $data->txn_id;
                    $udata['order_id'] = $data->cm;
                    $udata['payment_amt'] = $data->payment_amt;
                    $udata['currency_code'] = $data->currency_code;
                    $udata['status'] = $data->status;                    
                    $udata['payment_mode'] = 'Paypal';
                    $udata['seller_id'] = $data->seller_id;
                    
                    if($this->admin_model->InsertRecord('transactions_withdraw',$udata)){
                                               
                       $this->admin_model->UpdateRecord('withdraw',array('status'=>'1'),array('id'=>$data->request_id));
                        deduct_wallet($data->seller_id,$data->payment_amt);                        
                        $data->error=0;
                        $data->success=1;
                        $data->message= "Money has been transferred successfully to user";
                        $this->session->set_flashdata('item',$data);
                        redirect('admin/withdraw_request');
                    }
                }
        }
        
        public function cancel(){
                $data=new stdClass();
                    $data->error=1;
                    $data->success=0;
                    $data->message= "Payment Failed , Plese Try Again.";
                    $this->session->set_flashdata('item',$data);
                    redirect('admin/withdraw_request');
        }
	
	public function upload_logo(){
            $data=new stdClass();
            if($this->session->userdata('user_group_id') != 3){
                redirect('admin');
            }
            if(!$this->session->userdata('logged_in')){
                redirect('admin');
            }
            if($_FILES){
                //print_r($_FILES); die;
                $config=[	'upload_path'	=>'./front/images/',
                        'allowed_types'	=>'jpg|gif|png|jpeg',
                        'file_name' => strtotime(date('y-m-d h:i:s')).$_FILES["profile_pic"]['name']
                    ];
                //print_r(_FILES_); die;
                $this->load->library ('upload',$config);
                //unlink('./front/images/logo.png');
                if ($this->upload->do_upload('profile_pic'))
                {
		    
                    $udata = $this->upload->data();                    
                                    //resize profile image
                                    $config10['image_library'] = 'gd2';
                                    $config10['source_image'] = $udata['full_path'];
                                    $config10['new_image'] = './front/images/'.$udata['file_name'];
                                    $config10['maintain_ratio'] = TRUE;
                                    $config10['width']         = 200;
                                    $config10['height']       = 200;
                                    
                                    $this->load->library('image_lib', $config10);
				                    
                                    $this->image_lib->resize();
                    //print_r($udata); die;
                    $image_path= $udata['file_name'];
                    $this->admin_model->UpdateRecord('admin',array("logo"=>$image_path),array("id"=>$this->session->userdata('user_id')));
                    $data->error=0;
                    $data->success=1;
                    $data->message='Uploaded Successfully'; 
                    $this->session->set_flashdata('item', $data);
                    redirect('admin/upload_logo');	
                }
                else
                {
                    $data->error=1;
                    $data->success=0;
                    $data->message='Only jpeg/png/gif/jpg allowed!'; 
                    $this->session->set_flashdata('item', $data);
                    redirect('admin/upload_logo');	
                }
            }
            $udata = array("id"=>$this->session->userdata('user_id'));                
            $data->result = $this->admin_model->SelectSingleRecord('admin','*',$udata,$orderby=array());
            $data->title = 'Change Logo';
            $data->field = 'Dashboard';
            $data->page = 'upload_logo';
            $this->load->view('admin/includes/header',$data);		
            $this->load->view('logo_pic_view',$data);
            $this->load->view('admin/includes/footer',$data);

	}
}
?>