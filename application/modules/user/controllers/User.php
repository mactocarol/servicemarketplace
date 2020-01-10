<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User extends MY_Controller 
{
    //private $connection;
        public function __construct(){            
            parent::__construct();
            $this->load->model('user_model');
            $this->load->helper('my_helper');
            $page = '';
            if($this->session->userdata('user_group_id') == 3){
                redirect('user');
            }
        }
        public function index(){
            if($this->session->userdata('logged_in')){
                redirect('user/dashboard');


            //       echo"true";
            // }
            // else{ echo"false"; }

            }
            
            $data=new stdClass();
            if($this->session->flashdata('item')) {
                $items = $this->session->flashdata('item');
                //print_r($items); die;
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
            $data->return_url = isset($_GET['return']) ? $_GET['return'] : '' ;
            $data->title = "Login | Khidmat";
            $this->load->view('login_view',$data);          
        }
        
        public function register(){
//        $this->load->library('email');    
        //$this->email("mss.parvezkhan@gmail.com","My subject",'$msg');
        
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
                            
                
            if(!empty($_POST)){                
               // print_r($_POST);die;
               if ( $this->user_model->email_exists($this->input->post('email')) == TRUE ) 
                {
                    $data->error=1;
                    $data->success=0;
                    $data->message='Email Already Exists';
                    $this->session->set_flashdata('item',$data);
                    redirect('user/register');
                } 
                
                        $key=md5 (uniqid());
                        //sending conformation mail to signup user
                        
                        $to = $this->input->post('email');
                        $sub = "Confirm Your Account";                                                                  
            

                               $udata=array(                                            
                                    'email'=>$this->input->post('email'),
                                    'username'=>$this->input->post('username'),                                    
                                    'password'=>md5($this->input->post('password')),
                                    'user_type'=> ($this->input->post('user') == 'buyer') ? '1' : '2',
                                    'key'=> $key,
                                    //'is_verified' => '0'
                                    'is_verified' => ($this->input->post('user') == 'buyer') ? '0' : '0',
                                );
                                    $new_id = $this->user_model->new_user($udata);
                                    
                                    $body['to'] = get_user($new_id)->f_name;                        
                                    $body['title'] = 'Thank You Registration';          
                                    $message = "<a href='".base_url()."user/register_user/$key'>Click here</a>"." to confirm your account";                             
                                    $this->email($to,$sub,$message);
                                if($this->input->post('user') == 'seller'){
                                    redirect('user/service_register/'.base64_encode($new_id));
                                }
                                    //$this->user_model->InsertRecord('wallet',array("user_id"=>$new_id,"amount"=>"0","user_type"=>'2'));
                                    //$this->user_model->InsertRecord('membership',array("user_id"=>$new_id,"plan_id"=>"1"));
                                    $data->error=0;
                                    $data->success=1;
                                    $data->message='You are successfully registered, please verify your mail to avail all services.';
                                    $this->session->set_flashdata('item',$data);
                       
                }                                              
               //print_r($this->db->last_query()); die;
               $data->title = "Register | Khidmat";
               $this->load->view('register_view',$data);
                
        }
        
        
        public function service_register($id=Null){
        //print_r($id);   
        //$this->sendemail("parvezkhan03@gmail.com","My subject",'$msg');
            
            $data=new stdClass();
            $data->sellerid = ($id);
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
                            
                
            if(!empty($_POST)){                
                //print_r($_POST);die;                               
                        $key=md5 (uniqid());
                        //sending conformation mail to signup user
                                                            
                                    $udata=array(                                            
                                        'vendor_id'=>base64_decode($this->input->post('sellerid')),
                                        'services'=>json_encode(array_merge($this->input->post('category'),$this->input->post('subcategory'))),
                                        'services_search' => implode(",",array_merge($this->input->post('category'),$this->input->post('subcategory')))
                                    );  
                                    
                                    $this->user_model->InsertRecord('vendor_services',$udata);
                                                                                                            
                                    redirect('user/service_register_two/'.($this->input->post('sellerid')));                                   
                }                                              
               //print_r($this->db->last_query()); die;
               $categories = $this->user_model->SelectRecord('category','*',array("level"=>0,"status"=>'1',"is_deleted"=>"0"),'id asc');
               foreach($categories as $key => $value){
                    $subcategories = $this->user_model->SelectRecord('category','*',array("parent_id"=>$value['id'],"status"=>'1',"is_deleted"=>"0"),'id asc');
                    $categories[$key]['subcategories'] = $subcategories;
               }
               $data->categories = $categories;
               $data->title = "Register | Khidmat";
               $this->load->view('seller_register_one_view',$data);
                
        }
        
        
        public function service_register_two($id=Null){     
        //$this->sendemail("parvezkhan03@gmail.com","My subject",'$msg');
            
            $data=new stdClass();
            $data->sellerid = ($id);
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
                            
                
            if(!empty($_POST)){                
                
                    $udata=array(                                            
                          'address'=>$this->input->post('location'),
                          'placeName'=>$this->input->post('placeName'),
                          'placeLat'=>$this->input->post('placeLat'),
                          'placeLong'=>$this->input->post('placeLong'),
                     );                                    
                         $this->user_model->UpdateRecord('users',$udata,array("id"=>base64_decode($this->input->post('sellerid'))));
                                                                                                
                         redirect('user/service_register_three/'.($this->input->post('sellerid')));                                   
            }
            $data->users = $this->user_model->SelectSingleRecord('users','*',array("id"=>base64_decode($this->input->post('sellerid'))),'id desc');
               //print_r($data->users); die;
               $data->title = "Register | Khidmat";
               $this->load->view('seller_register_two_view',$data);
                
        }
        
        public function service_register_three($id=Null){       
        //$this->sendemail("parvezkhan03@gmail.com","My subject",'$msg');
            
            $data=new stdClass();
            $data->sellerid = ($id);
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
                            
                
            if(!empty($_POST)){                
                //print_r($_POST);die;                                                                                          
                    $udata=array(                                            
                         'f_name'=>$this->input->post('fname'),
                         'l_name'=>$this->input->post('lname'),
                         'phone'=>$this->input->post('phone')
                     );                                    
                         $this->user_model->UpdateRecord('users',$udata,array("id"=>base64_decode($this->input->post('sellerid'))));
                                                                                                
                         redirect('user/service_register_fourth/'.($this->input->post('sellerid')));                                   
                }                                              
               $data->users = $this->user_model->SelectSingleRecord('users','*',array("id"=>base64_decode($id)),'id desc');
               
               $data->title = "Register | Khidmat";
               $this->load->view('seller_register_three_view',$data);
                
        }
        
        public function service_register_fourth($id=Null){      
        //$this->sendemail("parvezkhan03@gmail.com","My subject",'$msg');
            
            $data=new stdClass();
            $data->sellerid = ($id);
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
                            
                
            if(!empty($_POST)){                
                //print_r(base64_decode($this->input->post('sellerid')));die;                                                                                           
                    $udata=array(                                            
                         'license'=>$_FILES['fileupload']['name']                                                                                                
                     );                                    
                         $this->user_model->UpdateRecord('users',$udata,array("id"=>base64_decode($this->input->post('sellerid'))));
                                                                                                
                    $result1 = $this->user_model->SelectSingleRecord('users','*',array("id"=>base64_decode($this->input->post('sellerid'))),'id desc');    
                        //$sess_array = array(
                        //'user_id' => $result1->id,
                        //'email' => $result1->username,
                        //'image' => $result1->image,
                        //'user_group_id' => 2,
                        //'logged_in' => TRUE
                        //);
                        //
                        //
                        ////print_r($sess_array); die;
                        //$this->session->set_userdata($sess_array);
                        $data->error=0;
                        $data->success=1;
                        $data->message='Registration Successful, please verify your account to login.';
                        $this->session->set_flashdata('item',$data);                      
                        redirect('user');                                 
                }                                              
               $data->users = $this->user_model->SelectSingleRecord('users','*',array("id"=>base64_decode($id)),'id desc');
               
               $data->title = "Register | Khidmat";
               $this->load->view('seller_register_fourth_view',$data);
                
        }
        
        public function register_user($key){
            if(!empty($key)){                
                if ($this->user_model->is_key_valid($key))
                {
                    //$user = $this->user_model->UpdateRecord('users',array("status"=>'1'),array());
                    //$userdata = array("user_id"=>$user->parent_id,"child_id"=>$user->id);
                    //$this->user_model->InsertRecord('downline',$userdata);
                    $data= new stdClass();
                    $data->page_title = "Registration";
                    $data->page_text = "New User Registration!";
                    $data->page = "signup";
                    
                    $data->error=0;
                    $data->success=1;
                    $data->message='verified successfully, you can login now.';
                    $this->session->set_flashdata('item',$data);
                    //echo "<script>alert('verified successfully, you can login now.') </script>";
                    redirect('user');
                }else{
                    $data->error=1;
                    $data->success=0;
                    $data->message='Invalid key.';
                    $this->session->set_flashdata('item',$data);
                    redirect('user/register');
                }
            }            
        }
        
        function check_username_exists()
        {                
            if (array_key_exists('username',$_POST)) 
            {
                if ( $this->user_model->username_exists($this->input->post('username')) == TRUE ) 
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
        
        function check_username_exists1()
        {                
            if (array_key_exists('username',$_POST)) 
            {
                if ( $this->user_model->username_exists_user($this->input->post('username')) == TRUE ) 
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
        
        function check_email_exists()
        {                
            if (array_key_exists('email',$_POST)) 
            {
                if ( $this->user_model->email_exists($this->input->post('email')) == TRUE ) 
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
        
        function check_email_exists1()
        {                
            if (array_key_exists('email',$_POST)) 
            {
                if ( $this->user_model->email_exists_user($this->input->post('email')) == TRUE ) 
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
                $Selectdata = array('id','email','username','image','user_type');
                $udata = array("email"=>$email,"password"=>md5($password),"is_verified"=>'1');                
                $result = $this->user_model->SelectSingleRecord('users',$Selectdata,$udata,$orderby=array());
                
                $udata = array("username"=>$email,"password"=>md5($password),"is_verified"=>'1');                
                $result1 = $this->user_model->SelectSingleRecord('users',$Selectdata,$udata,$orderby=array());
                //echo "<pre>";
                //print_r($result); die;
                if($result || $result1)
                {
                    if($result){
                        $sess_array = array(
                        'user_id' => $result->id,
                        'email' => $result->username,
                        'image' => $result->image,
                        'user_group_id' => $result->user_type,
                        'logged_in' => TRUE
                        );
                    }else if($result1){
                        $sess_array = array(
                        'user_id' => $result1->id,
                        'email' => $result1->username,
                        'image' => $result1->image,
                        'user_group_id' => $result->user_type,
                        'logged_in' => TRUE
                        );
                    }
                        
                        //print_r($sess_array); die;
                        $this->session->set_userdata($sess_array);
                        $data->error=0;
                        $data->success=1;
                        $data->message='Login Successful';
                        //print_r($this->session->userdata('email')); die;
                        if($this->input->post('return_url')){ redirect(($this->input->post('return_url'))); }
                        redirect('user/dashboard'); 
                    
                }
                else
                {
                    $data->error=1;
                    $data->success=0;
                    $data->message='Invalid Username or Password.';
                    
                }
            }
            $data->msg = 1;
            $this->session->set_flashdata('item',$data);            
            redirect('user');
        }
        
        public function dashboard()
        {            
            if(!$this->session->userdata('logged_in')){
                redirect('user');

            //       echo"false";
            // }
            // else{ echo"true"; } 

            } 
            $data=new stdClass();
            if($this->session->flashdata('item')) {
                $items = $this->session->flashdata('item');
                //print_r($items); die;                
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
            $data->result = $this->user_model->SelectSingleRecord('users','*',$udata,$orderby=array());
            
            /*echo "<pre>";
            print_r($data->result->user_type);die();*/

            if($data->result->user_type == 1){
                $where = array('o.user_id'=>$this->session->userdata('user_id'));
            }else{
                //$where = array('o.user_id'=>$this->session->userdata('user_id'));
                $where = array('od.vendor_id'=>$this->session->userdata('user_id'));
            }
            //echo $this->session->userdata('user_id'); die;
            $data->orders = $this->user_model->joindataResult('o.order_no','od.order_id',$where,'o.payment_status,o.payment_type,od.*','order as o','order_detail as od','o.id desc');
            
            $where_array = array('od.order_status'=>1);
            $where1 = array_merge($where,$where_array);            
            $data->pending_orders = $this->user_model->joindataResult('o.order_no','od.order_id',$where1,'o.payment_status,o.payment_type,od.*','order as o','order_detail as od','o.id desc');
            
            $where_array = array('od.order_status'=>2);
            $where2 = array_merge($where,$where_array);            
            $data->accepted_orders = $this->user_model->joindataResult('o.order_no','od.order_id',$where2,'o.payment_status,o.payment_type,od.*','order as o','order_detail as od','o.id desc');
            
            $where_array = array('od.order_status'=>3);
            $where3 = array_merge($where,$where_array);            
            $data->cancelled_orders = $this->user_model->joindataResult('o.order_no','od.order_id',$where3,'o.payment_status,o.payment_type,od.*','order as o','order_detail as od','o.id desc');
            // print_r($data->orders); die;
                      
            $data->title = 'Dashboard';
            $data->field = 'Dashboard';
            $data->page = 'dashboard';
           
            $this->load->view('dashboard_view',$data);            
        }
        
        
        public function orderDetail($id)
        {

            $data=new stdClass();
            $data->pageId = $id;
            $id = base64_decode($id);
            
            if(!$this->session->userdata('logged_in')){
                redirect('user');

            //           echo"false";
            // }
            // else{ echo"true"; } 

            }
            
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
            $data->result = $this->user_model->SelectSingleRecord('users','*',$udata,$orderby=array());
            
            if($data->result->user_type == 1){
                $where = array('o.order_no'=>$id,'o.user_id'=>$this->session->userdata('user_id'));
            }else{
                //$where = array('o.user_id'=>$this->session->userdata('user_id'));
                $where = array('o.order_no'=>$id,'od.vendor_id'=>$this->session->userdata('user_id'));
            }


            
            
            $udata1['is_read'] = '1';
            $user_id = $this->session->userdata('user_id');
            $this->user_model->UpdateRecord('notification',$udata1,array("notification_connection_id"=>$id,'user_id' => $user_id));

            $data->order = $this->user_model->joindata('o.order_no','od.order_id',$where,'o.user_id,o.payment_status,o.payment_type,od.*','order as o','order_detail as od','o.id desc');
            
            //print_r($data->order); die;
                      
            $data->title = 'Dashboard';
            $data->field = 'Dashboard';
            $data->page = 'dashboard';
            
            $this->load->view('order_detail_view',$data);            
        }

        function changeOrderStatus(){
            $status = $this->input->post('status');
            $id = $this->input->post('id');
            $udata['order_status'] = $status;
            $this->user_model->UpdateRecord('order_detail',$udata,array("id"=>$id));
            echo 1;
        }
        
        public function profile(){
            //print_r($this->session->userdata());die();
            if(!$this->session->userdata('logged_in')){
                redirect('user');
            }
            if($this->session->userdata('user_group_id') != 2){
                
            }
            $data=new stdClass();
            
            $udata = array("id"=>$this->session->userdata('user_id'));                
            $data->result = $this->user_model->SelectSingleRecord('users','*',$udata,$orderby=array());
            
           
            
            if($_POST){                                                
                
                $udata=array(                                            
                        'placeName'=>$this->input->post('placeName'),
                        'placeLat'=>$this->input->post('placeLat'),
                        'placeLong'=>$this->input->post('placeLong'),
                        
                        'email'=>$this->input->post('email'),
                        'phone'=>$this->input->post('contact'),
                        'f_name'=>$this->input->post('f_name'),
                        'l_name'=>$this->input->post('l_name'),
                        'shop_name'=>$this->input->post('shop_name'),
                        'dob'=>$this->input->post('dob'),                        
                        'address'=>$this->input->post('address'),
                        'country'=>$this->input->post('country'),
                        'zip_code'=>$this->input->post('zip_code')                        
                        );
                    
                    if($this->input->post('password') != ''){
                        $udata=array(                                            
                        'placeName'=>$this->input->post('placeName'),
                        'placeLat'=>$this->input->post('placeLat'),
                        'placeLong'=>$this->input->post('placeLong'),
                        
                        'email'=>$this->input->post('email'),                        
                        'phone'=>$this->input->post('contact'),                        
                        'f_name'=>$this->input->post('f_name'),
                        'l_name'=>$this->input->post('l_name'),
                        'shop_name'=>$this->input->post('shop_name'),
                        'dob'=>$this->input->post('dob'),                        
                        'address'=>$this->input->post('address'),                        
                        'country'=>$this->input->post('country'),
                        'zip_code'=>$this->input->post('zip_code'),
                        'password'=>md5($this->input->post('password'))
                        );
                    }
                    //echo '<pre>';
                    //print_r($udata); die;
                if ($this->user_model->UpdateRecord('users',$udata,array("id"=>$this->session->userdata('user_id'))))
                {
                    $data->error=0;
                    $data->success=1;
                    $data->message='Profile Update Sucessfully.';
                                        
                }else{
                    $data->error=1;
                    $data->success=0;
                    $data->message='Network Error!';                    
                }
                //print_r($this->db->last_query()); die;
            $this->session->set_flashdata('item',$data);
            //redirect('user/profile');
            //print_r($this->session->flashdata('item')); die;  
            }                        
            $data->result = $this->user_model->SelectSingleRecord('users','*',$udata,$orderby=array());                                    
            $data->title = 'User Profile';
            $data->field = 'User Profile';
            $data->page = 'profile';                
            $this->load->view('profile_view',$data);            
        }
        
        
        public function upload_image(){
            
            $data=new stdClass();
            
            //$data = $_POST['image'];
            //
            //list($type, $data) = explode(';', $data);
            //list(, $data)      = explode(',', $data);
            //
            //$data = base64_decode($data);
            //$imageName = uniqid().time().'.png';
            //file_put_contents('./upload/profile_image/thumb/'.$imageName, $data);
            //
            //$userpic=$this->user_model->SelectSingleRecord('users','*',array("id"=>$this->session->userdata('user_id')),$orderby=array());
            //if($userpic->image != 'no_image.jpg'){
            //    unlink('./upload/profile_image/thumb/'.$userpic->image);    
            //}            
            //
            //$this->user_model->UpdateRecord('users',array("image"=>$imageName),array("id"=>$this->session->userdata('user_id')));
            //
            //echo 'done';
            
            if($_FILES){
                
                $config=[   'upload_path'   =>'./upload/profile_image/',
                        'allowed_types' =>'jpg|gif|png|jpeg',
                        'file_name' => strtotime(date('y-m-d h:i:s')).$_FILES["profile_pic"]['name']
                    ];
                //print_r($_FILES); die;
                $this->load->library ('upload',$config);
                
                if ($this->upload->do_upload('profile_pic'))
                {
                    $userpic=$this->user_model->SelectSingleRecord('users','*',array("id"=>$this->session->userdata('user_id')),$orderby=array());                                        
                    unlink('./upload/profile_image/'.$userpic->image);
                    unlink('./upload/profile_image/thumb/'.$userpic->image);
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
                    $this->user_model->UpdateRecord('users',array("image"=>$image_path),array("id"=>$this->session->userdata('user_id')));
                    $data->error=0;
                    $data->success=1;
                    $data->message='Uploaded Successfully'; 
                    $this->session->set_flashdata('item', $data);
                    redirect('user/profile');   
                }
                else
                {
                    //print_r($this->upload->display_errors()); die;
                    $data->error=1;
                    $data->success=0;
                    $data->message='Only jpeg/png/gif/jpg allowed!'; 
                    $this->session->set_flashdata('item', $data);
                    //redirect('user/profile'); 
                }
            }
            $data->result = $this->user_model->SelectSingleRecord('users','*',$udata,$orderby=array());                                    
            $data->title = 'User Profile';
            $data->field = 'User Profile';
            $data->page = 'profile';                
            $this->load->view('profile_view',$data);

        }
        
        public function cover_image(){
            
            $data=new stdClass();
            
            $data = $_POST['image'];

            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            
            $data = base64_decode($data);
            $imageName = uniqid().time().'.png';
            file_put_contents('./upload/cover_image/'.$imageName, $data);
            
            $userpic=$this->user_model->SelectSingleRecord('users','*',array("id"=>$this->session->userdata('user_id')),$orderby=array());
            if($userpic->cover_image != 'bgprofile.png'){
                unlink('./upload/cover_image/'.$userpic->cover_image);    
            }
            
            
            $this->user_model->UpdateRecord('users',array("cover_image"=>$imageName),array("id"=>$this->session->userdata('user_id')));
            
            echo 'done';            

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
            redirect('user');
        }
            
        public function update_notification($id){
            if($this->session->userdata('user_group_id') != 2){
                redirect('user');
            }
            $data=new stdClass();
                $udata = array("id"=>$id);                
                $url = $this->user_model->SelectSingleRecord('notifications','*',$udata,$orderby=array());        
                if ($this->user_model->UpdateRecord('notifications',array("status"=>1),array("id"=>$id)))
                {                                                           
                }else{
                    
                }
            redirect(site_url().''.$url->url);
            
        }

        function vendor_services(){
            $where = array("vendor_id"=>$this->session->userdata('user_id'));                
            $data = $this->user_model->SelectSingleRecord('vendor_services','*',$where,$orderby=array());
            $services = json_decode($data->services);
            $servicesArr = array();

            //echo "<pre>";
            //print_r($data);die();

            foreach ($services as $key => $value) {
                $where = array("id"=>$value);     
                $oneArr = $this->user_model->SelectSingleRecord('category','*',$where,$orderby=array());

                $where1['userId'] = $this->session->userdata('user_id');
                $where1['userServicesId'] = $value;
                $data = $this->user_model->SelectSingleRecord('vendor_services_price','*',$where1,$orderby=array());
                if(isset($data) && !empty($data)){
                    $oneArr->price = $data->price;
                    $oneArr->weekPrice = $data->weekPrice;
                    $oneArr->monthPrice = $data->monthPrice;
                    $oneArr->yearPrice = $data->yearPrice;
                }else{
                    $oneArr->price = '';
                    $oneArr->weekPrice = '';
                    $oneArr->monthPrice = '';
                    $oneArr->yearPrice = '';
                }
                
                $servicesArr['servicesArr'][] = $oneArr;
            }
            //echo '<pre>';
            //print_r($servicesArr);die();
            $this->load->view('vendor_services',$servicesArr);  
        }

        function add_price(){
            $postData = $this->input->post();
            if($postData['price'] != 0){
                $where['userId'] = $this->session->userdata('user_id');
                $where['userServicesId'] = $postData['id'];
                $data = $this->user_model->SelectSingleRecord('vendor_services_price','*',$where,$orderby=array());
                if(empty($data)){
                    $insert = $where;
                    $insert['price'] = $postData['price'];
                    $this->user_model->InsertRecord('vendor_services_price',$insert);
                }else{
                    $insert = $where;
                    $insert['price'] = $postData['price'];
                    $this->user_model->UpdateRecord('vendor_services_price',$insert,$where);
                }
            }
        }

        function add_vendor_services(){
            $categories = $this->user_model->SelectRecord('category','*',array("level"=>0,"status"=>'1',"is_deleted"=>"0"),'id asc');
            $where = array("vendor_id"=>$this->session->userdata('user_id'));                
            $data = $this->user_model->SelectSingleRecord('vendor_services','*',$where,$orderby=array());
            $services = json_decode($data->services);
            foreach($categories as $key => $value){
                $subcategories = $this->user_model->SelectRecord('category','*',array("parent_id"=>$value['id'],"status"=>'1',"is_deleted"=>"0"),'id asc');
                $isAdded = 0;

                if (in_array($value['id'], $services)){ 
                    $isAdded = 1;
                }


                foreach ($subcategories as $key1 => $value) {
                    $subcategories[$key1]['isAdded'] = 0;
                    if (in_array($value['id'], $services)){ 
                        $subcategories[$key1]['isAdded'] = 1;
                        $isAdded = 1;
                    } 
                }
                $categories[$key]['isAdded'] = $isAdded;
                $categories[$key]['subcategories'] = $subcategories;
            }
            
            //echo '<pre>';
            //print_r($categories);
            $this->load->view('add_vendor_services',array('categories' => $categories,'sellerid'=>$this->session->userdata('user_id')));
        }

        function update_vendor_services(){

            $category = $this->input->post('category');
            $subcategory = $this->input->post('subcategory');
            $where = array("vendor_id"=>$this->session->userdata('user_id'));
            
            $update = array(
               'services' =>  json_encode(array_merge($category,$subcategory)),
               'services_search' => implode(",",array_merge($category,$subcategory))
            );
            
            // [vendor_id] => 16 [services] => ["electronics","fashionservices","Beauty"] [services_search]
            
            $d = $this->db->get_where('vendor_services',array())->result_array();
            //print_r($d);die();
            foreach($d as $f){
                $this->db->where(array('vendor_id' => $f['vendor_id']));
                $this->db->update('vendor_services',array('services_search' => implode(",",json_decode($f['services'])) ));
            }
            
            //print_r($this->db->last_query());die();
            
            $this->user_model->UpdateRecord('vendor_services',$update,$where);         
            redirect('user/vendor_services');

            /*$data = $this->user_model->SelectSingleRecord('vendor_services','*',$where,$orderby=array());
            if(!empty($data)){
                $this->user_model->UpdateRecord('vendor_services',$update,$where); 
            }else{
                $this->user_model->UpdateRecord('vendor_services',$update,$where);
                $this->user_model->InsertRecord('vendor_services',$udata);
            }*/
            
        }

        function social_login(){
            $postData = $this->input->post();
            //print_r($postData); die;
            $where = array(
                'social_id !=' => Null,
                'social_id' => $postData['socialId'],
                'social_type' => $postData['socialType'],
            );

            $data = $this->user_model->SelectSingleRecord('users','*',$where,$orderby=array());

            if(empty($data)){
                $insert = array(                                            
                    'f_name' => $postData['firstName'],
                    'l_name' => $postData['lastName'],
                    'email' => $postData['email'],
                    'username' => $postData['fullName'],
                    'password' => md5(rand()),
                    'image' => $postData['image'],
                    'user_type' => '1',
                    'is_verified' => '1',
                    'social_id' => $postData['socialId'],
                    'social_type' => $postData['socialType'],
                );
                //print_r($insert); die;
                $new_id = $this->user_model->new_user($insert);

                $sess_array = array(
                    'user_id' => $new_id,
                    'email' => $postData['email'],
                    'image' => $postData['image'],
                    'user_group_id' => 1,
                    'logged_in' => TRUE
                );
                        
                $this->session->set_userdata($sess_array);
                $data->error=0;
                $data->success=1;
                $data->message='Login Successful';
                redirect('user/dashboard'); 

            }else{
                //print_r($data); die;
                $sess_array = array(
                    'user_id' => $data->id,
                    'email' => $data->email,
                    'image' => $data->image,
                    'user_group_id' => 1,
                    'logged_in' => TRUE
                );
                        
                $this->session->set_userdata($sess_array);
                $data->error=0;
                $data->success=1;
                $data->message='Login Successful';
                redirect('user/dashboard');
            }

        }

    function reviewRating(){
        $postData = $this->input->post();
        

        $review = trim($this->input->post('review_text'));
        $rating = trim($this->input->post('rating'));
        $orderId = $redirectId = trim($this->input->post('orderId'));

        if($review == '' || $review == '' || $review == ''){
            $data->error=1;
            $data->success=0;
            $data->message='Please Fill Review Rating.'; 
            $this->session->set_flashdata('item', $data);
            redirect('user/orderDetail/'.$redirectId);
        }else{
            $orderId = base64_decode($orderId);
            $data = $this->user_model->SelectSingleRecord('order_detail','*',array('order_id' => $orderId),$orderby=array());
            $inserData = array(
                'senderId' => $this->session->userdata('user_id'),
                'receiverId' => $data->vendor_id,
                'orderId' => $orderId,
                'review' => $review,
                'rating' => $rating,
            );

            $this->user_model->InsertRecord('review',$inserData);
            $this->user_model->UpdateRecord('order_detail',array('review_status' => 'sent'),array('order_id' => $orderId));

            $data->error=0;
            $data->success=1;
            $data->message='Rating Successfully Done.'; 
            $this->session->set_flashdata('item', $data);
            redirect('user/orderDetail/'.$redirectId);
        }

    }

    function updatePrice($id){
        $id = base64_decode($id);
        $where = array(
            "userId" => $this->session->userdata('user_id'),
            "userServicesId" => $id
        );
        $data=new stdClass();
        if(isset($_POST) && !empty($_POST)){
            $price = $this->input->post('price');
            $weekPrice = $this->input->post('weekPrice');
            $monthPrice = $this->input->post('monthPrice');
            $yearPrice = $this->input->post('yearPrice');
            if(!empty($price) || !empty($weekPrice) || !empty($monthPrice) || !empty($yearPrice)){
                
                $check = $this->user_model->SelectSingleRecord('vendor_services_price','*',$where,$orderby=array());
                if(isset($check) && !empty($check)){
                    $this->user_model->UpdateRecord('vendor_services_price',$_POST,$where);
                }else{
                    $this->user_model->InsertRecord('vendor_services_price',$where);
                    $this->user_model->UpdateRecord('vendor_services_price',$_POST,$where);
                }
                
                $data->error = 0;
                $data->success = 1;
                $data->message ='price add / update successfully.';
            }else{
                $data->error = 1;
                $data->success = 0;
                $data->message ='Something going wrong';
            }
        }

        $data->newId = $id;

        $data->data = $this->user_model->SelectSingleRecord('vendor_services_price','*',$where,$orderby=array());
        $this->load->view('updatePrice',$data);
    }

    function forgotPassword(){
        $data = new stdClass();

        if($this->session->flashdata('item')) {
            $items = $this->session->flashdata('item');
            if($items->success){
                $data->error = 0;
                $data->success = 1;
                $data->message = $items->message;
            }else{
                $data->error = 1;
                $data->success = 0;
                $data->message = $items->message;
            }
        }

        if(isset($_POST) && !empty($_POST)){
            $data = $this->user_model->SelectSingleRecord('users','*',array('email' => $_POST['email']),$orderby=array());
            if(!empty($data)){
                
                $key = md5 (uniqid().rand());
                
                $this->user_model->UpdateRecord('users',array('key'=>$key),array('email'=>$_POST['email']));
                
                $htmlContent = '<h1>Forgot Password</h1>';
                $htmlContent .= "<a href='".base_url()."user/updatePassword/$key'>Click here</a>"." to update your password";
                $this->email($_POST['email'],"FORGOT PASSWORD",$htmlContent);
                
                $data->error = 0;
                $data->success = 1;
                $data->message ='Your mail has been sent successfuly !';
            }else{
                $data->error = 1;
                $data->success = 0;
                $data->message ='Invalid Email Account';
            }
        }

        $this->load->view('forgotPassword',$data);
    }
    
    function updatePassword($key){
        $data = new stdClass();

        if(isset($_POST) && !empty($_POST)){
            $this->user_model->UpdateRecord('users',array('password'=>md5($_POST['nPassword'])),array('id'=>$_POST['id']));
            $data->error=0;
            $data->success=1;
            $data->message='Please login with your new password';
            $this->session->set_flashdata('item',$data);
            redirect('user/');
        }

        $data->userDetail = $this->user_model->SelectSingleRecord('users','*',array('key'=>$key),$orderby=array());
        if(!isset($data->userDetail) && empty($data->userDetail)){
            $data->error=1;
            $data->success=0;
            $data->message='The password reset link is no longer valid. Please request another password reset email';
            $this->session->set_flashdata('item',$data);
            redirect('user/forgotPassword');
        }

        $this->user_model->UpdateRecord('users',array('key'=>md5(rand())),array('key'=>$key));
        $this->load->view('updatePassword',$data);

    }

    function changePaymentStatus(){
        $postData = $this->input->post();
        $requestId = $postData['id'];
        
        $data = $this->user_model->SelectSingleRecord('order_detail','*',array('id'=>$requestId),$orderby=array());

        $cardAccount['cardToken'] = 'NA';
        $cardAccount['cardType'] = 'NA';
        $cardAccount['custId'] = 'NA';
        $cardAccount['custEmail'] = 'NA';
        $cardAccount['refundedId'] = 'NA';
        $cardAccount['transactionId'] = 'NA';


        $cardAccount['requestId'] = $data->order_id;
        $cardAccount['mainPrice'] = $data->amount*100;
        $cardAccount['discountPresent'] = 0;
        $cardAccount['price'] = $data->amount*100;
        $cardAccount['userId'] = $this->session->userdata('user_id');
        
        //print_r($cardAccount); die;
        $this->db->insert('payment',$cardAccount);

        $this->db->where(array('order_id' => $data->order_id));
        $this->db->update('order_detail',array('payment_status' => 'paid'));

    }

}
?>