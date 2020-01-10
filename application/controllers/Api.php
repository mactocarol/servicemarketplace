<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends MY_Controller  {    
 function __construct(){
    parent::__construct();    
    header('Content-Type: application/json');
    $this->load->model('Core_Model');    
    $this->load->model('MY_Model');
    $this->load->library('session');
    $this->res = new stdClass();
    // $request = json_decode(rtrim(file_get_contents('php://input'), "\0"));
 } 
 
//****************************************************************************************************  
  public function signup() 
    {
        $request = json_decode(rtrim(file_get_contents('php://input'), "\0"));         
        $name = isset($request->name) ? $request->name : ''; 
        $email = isset($request->email) ? $request->email : '';
        $password = isset($request->password) ? $request->password : '';  
        $contact = isset($request->phone) ? $request->phone : ''; 
        $cities = isset($request->cities) ? $request->cities : '';        
        $services = isset($request->services) ? $request->services : '';
        $user_type = isset($request->user_type) ? $request->user_type : '';       
        $device_type = isset($request->device_type) ? $request->device_type : '';       
        $device_token = isset($request->device_token) ? $request->device_token : '';       
        $lat = isset($request->lat) ? $request->lat : '';       
        $long = isset($request->long) ? $request->long : '';       
        $social_type = isset($request->social_type) ? $request->social_type : '';       
        $social_id = isset($request->social_id) ? $request->social_id : ''; 
        $last_login = date("Y-m-d h:i:s");                

        if (!$name) {
        $this->_error('Form error', 'Name is not specified.');
        return false;
        }
         if (!$email) {
        $this->_error('Form error', 'Email is not specified.');
        return false;
        }
        if (!$password) {
        $this->_error('Form error', 'Password is not specified.');
        return false;
        }
        if (!$contact) {
        $this->_error('Form error', 'Phone No is not specified.');
        return false;
        }
        if (!$cities) {
        $this->_error('Form error', 'City is not specified.');
        return false;
        }
        if (!$user_type) {
        $this->_error('Form error', 'User Type is not specified.');
        return false;
        }
        if ($this->email_check($email)) {
        $this->_error('Form error', 'Email already exists.');
        return false;
        }
        //print_r($request); die;
            $activation_code =  rand(100000,999999); //$this->generateRandomString();
            $userdata = array('name'=>$name,'email'=>$email,'password'=>md5($password),'contact'=>$contact,'cities'=>$cities,'user_type'=>$user_type,
                              'key'=>$activation_code,'device_type'=>$device_type,'device_token'=>$device_token,'lat'=>$lat,'long'=>$long,'social_type'=>$social_type,'social_id'=>$social_id);            
            if($user_type == 2){
                if (!$services) {
                $this->_error('Form error', 'Services is not specified.');
                return false;
                }
                $userdata = array('name'=>$name,'email'=>$email,'password'=>md5($password),'contact'=>$contact,'cities'=>$cities,'skills'=>$services,'user_type'=>$user_type,'key'=>$activation_code,'device_type'=>$device_type,'device_token'=>$device_token,'lat'=>$lat,'long'=>$long,'social_type'=>$social_type,'social_id'=>$social_id);                
            }
            
            $result = $this->Core_Model->InsertRecord('users', $userdata);
                                 
            if($result) 
            { 
                $to = $email;                
                $subject = "Please Verify Your Account on Bricole";            
                $msg = "Please Verify Your Account. This is your OTP to verify your account :"." ".$activation_code;           
                $email = $this->email($to, $subject, $msg);
                
                $this->res->success = 'true';
                $this->res->data = ["user_id"=>$result,"email"=>$email];
                $this->res->message = "You are registered successfully, an OTP has been sent to your registered mail Id";                    
                    //return true;
            }
        
           $this->_output();
            exit();
        }
//---------------------*-------------------
    function email_check($email) {
        $where = array('email' => $email,"is_deleted"=>'0');
        $field = 'email';      
        $get_email = $this->Core_Model->SelectSingleRecord('users', $field, $where);    
        if (!empty($get_email)) {
             return true;
        }
         return false;
    }
    //---------------------*-------------------
    public function resend_otp() 
    {
        $request = json_decode(rtrim(file_get_contents('php://input'), "\0"));         
        $email = isset($request->email) ? $request->email : '';                                         

        if (!$email) {
        $this->_error('Form error', 'Email is not specified.');
        return false;
        }
         
            //if email is exist in record
            $result = $this->Core_Model->SelectSingleRecord('users', '*', array("email"=>$email) );                          
            if($result){
                if($result->is_verified == 0){                                            
                        
                            // updating otp
                            $activation_code =  rand(100000,999999); //$this->generateRandomString();
                            $this->Core_Model->updateFields('users', array("key"=>$activation_code), array("email"=>$email) );

                            $to = $email;                
                            $subject = "Please Verify Your Account on Bricole";            
                            $msg = "Please Verify Your Account. This is your OTP to verify your account :"." ".$activation_code;           
                            $email = $this->email($to, $subject, $msg);
                                                                                    
                            $this->res->success = 'true';
                            $this->res->message = "OTP Send Successfully";                   
                                //return true;
                       
                }else{
                    $this->res->data = [];
                    $this->res->success = 'false';
                    $this->res->message = "Email is already verified, please login to continue";
                }
            }else{
                $this->res->data = [];
                $this->res->success = 'false';
                $this->res->message = "Email is not found in our record";
            }
        
           $this->_output();
            exit();
        }
    //---------------------*-------------------
    public function email_verification() 
    {
        $request = json_decode(rtrim(file_get_contents('php://input'), "\0"));         
        $email = isset($request->email) ? $request->email : ''; 
        $otp = isset($request->otp) ? $request->otp : '';      
        $device_type = isset($request->device_type) ? $request->device_type : '';       
        $device_token = isset($request->device_token) ? $request->device_token : '';       
        $lat = isset($request->lat) ? $request->lat : '0';       
        $long = isset($request->long) ? $request->long : '0';                                   

        if (!$email) {
        $this->_error('Form error', 'Email is not specified.');
        return false;
        }
         if (!$otp) {
        $this->_error('Form error', 'OTP is not specified.');
        return false;
        }
        if (!$device_type) {
        $this->_error('Form error', 'Device Type is not specified.');
        return false;
        }
        if (!$device_token) {
        $this->_error('Form error', 'Device Token is not specified.');
        return false;
        }
        
            //if email is exist in record
            $result = $this->Core_Model->SelectSingleRecord('users', '*', array("email"=>$email) );                          
            if($result){
                if($result->is_verified == 0){
                        // match email and OTP
                        $result = $this->Core_Model->SelectSingleRecord('users', '*', array("email"=>$email,"key"=>$otp) );                          
                                             
                        if($result) 
                        { 
                            // updating token and lat long
                            $accesstoken = base64_encode(uniqid()); //other type for getting random no
                            $is_login='1'; 
                            $last_login = date("Y-m-d h:i:s");            
                            $this->Core_Model->updateFields('users', array("is_verified"=>'1','token'=>$accesstoken,'is_login'=>$is_login,'last_login'=>$last_login
                                                            ,'device_type'=>$device_type,'device_token'=>$device_token,'lat'=>$lat,'long'=>$long), array("email"=>$email) );
                                                                                                           
                            $userdata['user_id'] = ($result->id) ? $result->id : '';
                            $userdata['name'] = ($result->name) ? $result->name : '';
                            $userdata['email'] = ($result->email) ? $result->email : '';
                            $userdata['phone'] = ($result->contact) ? $result->contact : '';               
                            $userdata['token'] = $accesstoken;
                            $userdata['lat'] = $lat;
                            $userdata['long'] = $long;
                            $userdata['user_type'] = ($result->user_type) ? $result->user_type : ''; 
                            $userdata['is_login'] = '1';                        

                            if($result->user_type == 1){
                                $userdata['upcoming_bricoles'] = '0';   
                                $userdata['open_bricoles'] = '0';
                                $userdata['completed_bricoles'] = '0';
                                $userdata['inbox'] = '0';
                            }else{
                                $userdata['upcoming_bricoles'] = '0';   
                                $userdata['open_bricoles'] = '0';
                                $userdata['completed_bricoles'] = '0';
                                $userdata['inbox'] = '0';
                            }
                            
                            $this->res->data = $userdata;
                            $this->res->success = 'true';
                            $this->res->message = "Email Verified Successfully";                   
                                //return true;
                        }else{
                            $this->res->data = [];
                            $this->res->success = 'false';
                            $this->res->message = "Invalid OTP"; 
                        }
                }else{
                    $this->res->data = [];
                    $this->res->success = 'false';
                    $this->res->message = "Email is already verified, please login to continue";
                }
            }else{
                $this->res->data = [];
                $this->res->success = 'false';
                $this->res->message = "Email is not found in our record";
            }
        
           $this->_output();
            exit();
        }
//*********************************************************************************************************
    public function signin()
    {
        $request = json_decode(rtrim(file_get_contents('php://input'), "\0"));
        $email = $request->email;
        $password = $request->password; 
        $device_type = isset($request->device_type) ? $request->device_type : '';       
        $device_token = isset($request->device_token) ? $request->device_token : '';       
        $lat = ($request->lat) ? $request->lat : '0';       
        $long = ($request->long) ? $request->long : '0';       
        $social_type = isset($request->social_type) ? $request->social_type : '';       
        $social_id = isset($request->social_id) ? $request->social_id : '';        
        // print_r($this->input->request_headers());die();        
        if (!$email) {
            $this->_error('Form error', 'Email-Id is not specified.');
        }
        if (!$password) {
            $this->_error('Form error', 'Password is not specified.');
        }
        if (!$device_type) {
        $this->_error('Form error', 'Device Type is not specified.');
        return false;
        }
        if (!$device_token) {
        $this->_error('Form error', 'Device Token is not specified.');
        return false;
        }

        $user = $this->Core_Model->selectsinglerecord('users', '*', array('email' => $email, 'password' => md5($password)));            
        if(empty($user)) {            
            $this->_error('error', 'Incorrect Email Id or Password.');
        } else {
            // updating token and lat long
            $accesstoken = base64_encode(uniqid()); //other type for getting random no
            $is_login='1'; 
            $last_login = date("Y-m-d h:i:s");            
            $this->Core_Model->updateFields('users', array('token'=>$accesstoken,'is_login'=>$is_login,'last_login'=>$last_login,'device_type'=>$device_type,'device_token'=>$device_token,'lat'=>$lat,'long'=>$long,'social_type'=>$social_type,'social_id'=>$social_id), array("email"=>$email) );            
            
            $userdata['user_id'] = ($user->id) ? $user->id : '';
            $userdata['name'] = ($user->name) ? $user->name : '';
            $userdata['email'] = ($user->email) ? $user->email : '';
            $userdata['phone'] = ($user->contact) ? $user->contact : '';               
            $userdata['token'] = $accesstoken;
            $userdata['lat'] = $lat;
            $userdata['long'] = $long;
            $userdata['user_type'] = ($user->user_type) ? $user->user_type : ''; 
            

            // calculate bricoles for user and vendor
            if($user->user_type == 1){
                $open_bricoles = $this->Core_Model->selectRecord('job_post', '*', array('user_id' => $user->id,'is_deleted'=>'0','status'=>'1'));
                $upcoming_bricoles = $this->Core_Model->selectRecord('job_post', '*', array('user_id' => $user->id,'is_deleted'=>'0','status'=>'2'));
                $completed_bricoles = $this->Core_Model->selectRecord('job_post', '*', array('user_id' => $user->id,'is_deleted'=>'0','status'=>'3'));


                $userdata['upcoming_bricoles'] = count($upcoming_bricoles);   
                $userdata['open_bricoles'] = count($open_bricoles);
                $userdata['completed_bricoles'] = count($completed_bricoles);
                $userdata['inbox'] = 0;
            }else{
                $open_bricoles = $this->Core_Model->selectRecord('proposal', '*', array('user_id' => $user_id,'is_deleted'=>'0','status'=>'2','accept'=>'0'));
                $upcoming_bricoles = $this->Core_Model->selectRecord('proposal', '*', array('user_id' => $user_id,'is_deleted'=>'0','status'=>'2','accept'=>'1'));
                $completed_bricoles = $this->Core_Model->selectRecord('proposal', '*', array('user_id' => $user->id,'is_deleted'=>'0','status'=>'3'));

                $userdata['upcoming_bricoles'] = count($upcoming_bricoles);   
                $userdata['open_bricoles'] = count($open_bricoles);
                $userdata['completed_bricoles'] = count($completed_bricoles);
                $userdata['inbox'] = 0;
            } 
            $userdata['is_verified'] = ($user->is_verified) ? '1' : '0';
            $this->res->data = $userdata;
            $this->res->success = 'true';
            $this->res->message = ($user->is_verified) ? 'User Login Successfully' : 'Email is not verified';
        }
        $this->_output();
        exit();
    }
//*********************************************************************************************************
    public function forgotPassword()
    {
        $request = json_decode(rtrim(file_get_contents('php://input'), "\0"));                
        $email= $request->email;
        // print_r($email);die();
        // $order = "ORDER_".uniqid();   
        // $password =  uniqid();
        $password = $this->generateRandomString();               
        if (!$email) {
                    $this->_error('Form error', 'Email Id is not specified.');
        }
        if ($this->email_verify($email)) 
        {
            $where_update = array('email' => $email);
            $field_update = array('password'=>md5($password));            
            $rdata = $this->Core_Model->updateFields('users', $field_update, $where_update);           

            $where_login = array('email' => $email);
            $aray_login = $this->Core_Model->selectsinglerecord('users', 'email', $where_login);
            $to = $aray_login->email;
            // $activation_code =  $this->generateRandomString();
            $subject = "forgot password";
            // $msg = site_url("Api/forgotPassword/".$password."/".$rdata);
            $msg = "Password Generated Successfully. Your New Password:"." ".$password;           
            $email = $this->email($to, $subject, $msg);
             if (!empty($rdata)) 
            {                
                $this->res->success = true;
                $this->res->data = ["Password"=>$password];
                $this->res->message = "New Password Generated Successfully";                
            }            
        }      
        else
         {
            $this->_error('Form error', 'Incorrect Email Id.');                      
        } 
        $this->_output();
        exit();
    }
//-----------------------forgotPassword codes-------------------------------------
    function generateRandomString() 
    {
        $letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $digits = '1234567890';
        $randomString = '';
        for ($i = 0; $i < 3; $i++) {
            $randomString .= $letters[rand(0, strlen($letters) - 1)];
        }
        for ($i = 0; $i < 3; $i++) {
            $randomString .= $digits[rand(0, strlen($digits) - 1)];
        }
        return $randomString;
    }
//-----------------------forgotPassword codes-------------------------------------
    function email($to, $subject, $msg) 
    {
        $config = array(
            'mailtype' => 'html',
            'charset' => 'utf-8'
        );
        // $subject = "Group activation";
        // $body = $this->load->view('Common', $msg, TRUE);
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        // $this->email->from('info@mactosys.com', 'Pewny Parking');
        $this->email->from('admin@bricoleur.com', 'Bricoleurs');
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($msg);        
        $this->email->send();
    }
//-----------------------forgotPassword codes-------------------------------------
    function email_verify($email) {
        $where = array('email' => $email);
        $field = 'email';        
        $get_email = $this->Core_Model->SelectSingleRecord('users', $field, $where);    
        if (!empty($get_email)) {
             return true;
        }
         return false;
    }
//*********************************************************************************************************      
    public function logout()
    {
        $request = json_decode(rtrim(file_get_contents('php://input'), "\0"));        
         $id = $request->user_id;         
         $header = $this->input->request_headers();
         $accesstoken = $header['Accesstoken'];         
        if($this->check_accesstoken($id,$accesstoken))
        {            
            $where_update = array('id' => $id);            
            $field_update = array('token'=>0,'is_login'=>0);
            $this->Core_Model->updateFields('users', $field_update, $where_update);
            $this->res->success = 'true';
            $this->res->message = 'User Logout Successfully';
        }else{           
            $this->_error('error', 'Invalid accesstoken.');
        }
        $this->_output();
          exit();
    }
    public function check_accesstoken($id,$accesstoken)
    {        
        $where = array('id'=>$id,'token'=>$accesstoken);
        $selectdata = 'id,token';
        $res = $this->Core_Model->SelectSingleRecord('users',$selectdata,$where,$order='');
       if($res){
        return true;
       }else
       return true;
    }
//*********************************************************************************************************
    public function post_job()
    { 
        $request = json_decode(rtrim(file_get_contents('php://input'), "\0"));
        $header = $this->input->request_headers();            
        $accesstoken = $header['Accesstoken'];
        $user_id = ($request->user_id) ? $request->user_id : '';
        if (!$user_id) {
                    $this->_error('Form error', 'User Id is not specified.');
                    return false;
        }

        if($this->check_accesstoken($user_id,$accesstoken))
        {
            $service_id = isset($request->service_id) ? $request->service_id : '';
            $title = isset($request->title) ? $request->title : '';
            $description = isset($request->description) ? $request->description : '';
            $date_time = isset($request->date_time) ? $request->date_time : '';            
            $min_budget = isset($request->min_budget) ? $request->min_budget : '';
            $max_budget = isset($request->max_budget) ? $request->max_budget : '';
            $address = isset($request->address) ? $request->address : '';
            $city = $request->city;
            $lat = isset($request->lat) ? $request->lat : '';
            $long = isset($request->long) ? $request->long : '';
            
            // print_r($attachment);die();            
            
             if (!$service_id) {
                        $this->_error('Form error', 'Service Id is not specified.');
                        return false;
            }
            if (!$title) {
                        $this->_error('Form error', 'Job Title is not specified.');
                        return false;
            }            
            if (!$description) {
                        $this->_error('Form error', 'Description is not specified.');
                        return false;
            }              
            if (!$date_time) {
                        $this->_error('Form error', 'Date and Time is not specified.');
                        return false;
            }                
            if (!$min_budget) {
                        $this->_error('Form error', 'Minimum Budget is not specified.');
                        return false;
            }   
            if (!$max_budget) {
                        $this->_error('Form error', 'Maximum Budget is not specified.');
                        return false;
            }
            if (!$address) {
                        $this->_error('Form error', 'Address is not specified.');
                        return false;
            }  
            if (!$lat) {
                        $this->_error('Form error', 'Latitude is not specified.');
                        return false;
            }
            if (!$long) {
                        $this->_error('Form error', 'Longitude is not specified.');
                        return false;
            }

            $user = $this->Core_Model->SelectSingleRecord('users','*',array("id"=>$user_id),$order='');
            if($user && $user->user_type != 1){
                        $this->_error('Form error', 'Vendor can not post job.');
                        return false;   
            }
            if($user && $user->is_verified != 1){
                        $this->_error('Form error', 'Verify your email before post a job.');
                        return false;   
            }

            $city = $this->MY_Model->SelectSingleRecord('cities','*',array("title"=>$city),'id asc');
            
            $job_data = array('user_id'=>$user_id,'service_id'=>$service_id,'title'=>$title,'description'=>$description,'date_time'=>$date_time,'address'=>$address,'city'=>(($city) ? $city->id : '0'),'min_budget'=>$min_budget,'max_budget'=>$max_budget,'lat'=>$lat,'long'=>$long,'status'=>1);            
            $result = $this->Core_Model->InsertRecord('job_post', $job_data);

            if (empty($result))
            {                
                $this->res->success = 'false';
                $this->res->message = "Incorrect data";
            }
            else
            {
                $this->res->data    = ["job_id" => $result];
                $this->res->success = 'true';
                $this->res->message = 'Job posted Successfully';                
            } 
        }else
        {            
            $this->_error('error', 'Invalid Accesstoken.');
        }  
        $this->_output();
        exit();
    }

    public function hire_me()
    { 
        $request = json_decode(rtrim(file_get_contents('php://input'), "\0"));
        $header = $this->input->request_headers();            
        $accesstoken = $header['Accesstoken'];
        $user_id = ($request->user_id) ? $request->user_id : '';
        if (!$user_id) {
                    $this->_error('Form error', 'User Id is not specified.');
                    return false;
        }

        if($this->check_accesstoken($user_id,$accesstoken))
        {
            $service_id = isset($request->service_id) ? $request->service_id : '0';
            $title = isset($request->title) ? $request->title : '';
            $description = isset($request->description) ? $request->description : '';
            $date_time = isset($request->date_time) ? $request->date_time : '';            
            $min_budget = isset($request->min_budget) ? $request->min_budget : '';
            $max_budget = isset($request->max_budget) ? $request->max_budget : '';
            $address = isset($request->address) ? $request->address : '';
            $city = $request->city;
            $lat = isset($request->lat) ? $request->lat : '';
            $long = isset($request->long) ? $request->long : '';
            $bricoler_id = ($request->bricoler_id) ? $request->bricoler_id : '';
            // print_r($attachment);die();            
            
             if (!$service_id) {
                        //$this->_error('Form error', 'Service Id is not specified.');
                        //return false;
            }
            if (!$bricoler_id) {
                        $this->_error('Form error', 'Bricoler Id is not specified.');
                        return false;
            }
            if (!$title) {
                        $this->_error('Form error', 'Job Title is not specified.');
                        return false;
            }            
            if (!$description) {
                        $this->_error('Form error', 'Description is not specified.');
                        return false;
            }              
            if (!$date_time) {
                        $this->_error('Form error', 'Date and Time is not specified.');
                        return false;
            }                
            if (!$min_budget) {
                        $this->_error('Form error', 'Minimum Budget is not specified.');
                        return false;
            }   
            if (!$max_budget) {
                        $this->_error('Form error', 'Maximum Budget is not specified.');
                        return false;
            }
            if (!$address) {
                        $this->_error('Form error', 'Address is not specified.');
                        return false;
            }  
            if (!$lat) {
                        $this->_error('Form error', 'Latitude is not specified.');
                        return false;
            }
            if (!$long) {
                        $this->_error('Form error', 'Longitude is not specified.');
                        return false;
            }

            $user = $this->Core_Model->SelectSingleRecord('users','*',array("id"=>$user_id),$order='');
            if($user && $user->user_type != 1){
                        $this->_error('Form error', 'Vendor can not post job.');
                        return false;   
            }
            if($user && $user->is_verified != 1){
                        $this->_error('Form error', 'Verify your email before post a job.');
                        return false;   
            }

            $city = $this->MY_Model->SelectSingleRecord('cities','*',array("title"=>$city),'id asc');


            $job_data = array('user_id'=>$user_id,'service_id'=>$service_id,'title'=>$title,'description'=>$description,'date_time'=>$date_time,'address'=>$address,'city'=>(($city) ? $city->id : '0'),'min_budget'=>$min_budget,'max_budget'=>$max_budget,'lat'=>$lat,'long'=>$long,'status'=>1);            
            $job = $this->Core_Model->InsertRecord('job_post', $job_data);

            $proposal_data = array('user_id'=>$bricoler_id,'job_id'=>$job,'amount'=>0,'proposal'=>'','date_time'=>'','days'=>'','status'=>2);           
            $proposal = $this->Core_Model->InsertRecord('proposal', $proposal_data);

            $this->Core_Model->updateFields('job_post', array('status'=>2,'proposal_id'=>$proposal), array('id'=>$job));

            if (empty($job))
            {                
                $this->res->success = 'false';
                $this->res->message = "Incorrect data";
            }
            else
            {
                $this->res->data    = ["job_id" => $result];
                $this->res->success = 'true';
                $this->res->message = 'Job posted Successfully';                
            } 
        }else
        {            
            $this->_error('error', 'Invalid Accesstoken.');
        }  
        $this->_output();
        exit();
    }
//********************************************************************************************************   
      
   public function services() 
    { 
        $categories2 = $this->MY_Model->SelectRecord('category','*',$udata=array("is_deleted"=>"0","parent_id"=>"0"),'order_id asc');            
            $cname = [];
            $level = 1; 
    
            foreach ($categories2 as $key => $value)
            {
                $cname[$value['title']][] = ['id'=>$value['id'], 'cname'=>$value['title'],'level'=>$value['level']];
    
                 $arr[] = ['id'=>$value['id'],'cname'=>$value['title'],'description'=>$value['description'],'image' => base_url('upload/category/').$value['image'], 'image_select' => base_url('upload/category/').$value['image_select']];
    
                $cat = $this->MY_Model->SelectRecord('category','*',$udata=array("is_deleted"=>"0","parent_id"=>$value['id']),'order_id asc');  

                foreach ($cat as $key => $result) 
                {
                    $parent_id = $result['id']; 
    
                    $cname[$value['title']][$result['id']][] = ['id'=>$result['id'], 'parent_id'=>$result['parent_id'],'cname'=>$result['title'],'level'=>$result['level'],'order_id'=>$result['order_id']];
                    
                    // $arr[] = ['id'=>$result['id'], 'parent_id'=>$result['parent_id'], 'cname'=>$result['title'],'level'=>$result['level'],'order_id'=>$result['order_id'],'description'=>$result['description'],'image' => base_url('upload/category/').$value['image'],'icon'=>$result['icon']];

                    $arr[] = ['id'=>$result['id'],'cname'=>$result['title'],'description'=>$result['description'],'image' => base_url('upload/category/').$value['image'], 'image_select' => base_url('upload/category/').$value['image_select']];
    
                    while (1) 
                    {
                        $data = $this->MY_Model->SelectRecord('category','*',$udata=array("is_deleted"=>"0","parent_id"=>$parent_id),'order_id asc');
                        // print_r($data);die;
                        if(count($data)>1)
                        {
                            foreach ($data  as $key => $data) 
                            {
                                if($data)
                                {
                                    $level++;
                                    $parent_id = $data['id'];
    
                                    $cname[$value['title']][$result['id']][$parent_id][] = ['id'=>$data['id'],'parent_id'=>$data['parent_id'],'cname'=>$data['title'],'level'=>$data['level'],'order_id'=>$data['order_id'],'description'=>$data['description'],'image'=>$data['image']];                       
                                       
                                     $arr[]  = ['id'=>$data['id'],'cname'=>$data['title'],'description'=>$data['description'],'image' => base_url('upload/category/').$value['image'], 'image_select' => base_url('upload/category/').$value['image_select']];                               
                                }
                                else{ break; }
                            }
                        }
                        else
                        {
                            $data = $this->MY_Model->SelectSingleRecord('category','*',$udata=array("is_deleted"=>"0","parent_id"=>$parent_id),'order_id asc'); 

                        if(!empty($data))
                        {                            
                            $level++;
                            $parent_id = $data->id;
    
                            $cname[$value['title']][$result['id']][$parent_id][] = ['id'=>$data->id,'parent_id'=>$data->parent_id,'cname'=>$data->title,'level'=>$data->level,'order_id'=>$data->order_id,'description'=>$data->description,'image'=>$data->image,'icon'=>$data->icon];

                             $arr[]  = ['id'=>$data->id,'cname'=>$data->title,'description'=>$data->description,'image'=>$data->image];                                       
                        }
                        else
                        { break; }
                    }
                } 
            }

            // $skills = $this->MY_Model->SelectRecord('skills','*',array("is_deleted"=>"0"),'id asc');  
            // $skill_arr = [];          
            // foreach ($skills as $skill) {
            //     $skill_arr[] = array("id"=>$skill['id'],"title"=>$skill['title']);
            // }
            $cities = $this->MY_Model->SelectRecord('cities','*',array("is_deleted"=>"0"),'id asc');  
            $city_arr = [];          
            foreach ($cities as $city) {
                $city_arr[] = array("id"=>$city['id'],"title"=>$city['title']);
            }

            $result_set  = array("services"=>$arr,"cities"=>$city_arr); 
            //$arr    = []; 
         }
            if (empty($result_set)) 
            {                
                $this->res->success = 'false';
                $this->_error('error', 'Incorrect data.');
            } else 
            {
                $this->res->success = 'true';
                $this->res->data = $result_set;
                $this->res->message = 'Services Listed Successfully';
            }
            $this->_output();
              exit();            
    }
//*********************************************************************************************************  

    public function changePassword()
    {
        $request = json_decode(rtrim(file_get_contents('php://input'), "\0"));        
        $user_id = ($request->user_id) ? $request->user_id : '';
        if (!$user_id) {
            $this->_error('Form error', 'User-Id is not specified.');
        }
        $oldpassword = ($request->old_password) ? $request->old_password : '';
        $newpassword = ($request->new_password) ? $request->new_password : '';
        $header = $this->input->request_headers();
        $accesstoken = $header['Accesstoken'];       
        if($this->check_accesstoken($user_id,$accesstoken))
        {  
            
            if (!$oldpassword) {
                $this->_error('Form error', 'Old Password is not specified.');
            }
            if (!$newpassword) {
                $this->_error('Form error', 'New Password is not specified.');
            }
            if (strlen($newpassword) < 6)                 
            {
                $this->_error('Form error', 'Minimum 6 Password Length Required.');
            }            
            $user = $this->Core_Model->SelectsingleRecord('users', '*', array("id"=>$user_id,"password"=>md5($oldpassword)) );
            if($user){
                $where_update = array('id' => $user_id);
                $field_update = array('password'=> md5($password));                
                $this->Core_Model->updateFields('users', $field_update, $where_update);
                
                $this->res->success = 'true';                
                $this->res->message = 'Password Changed Successfully';            
            }else{
                $this->res->success = 'false';                
                $this->res->message = 'Old Password is wrong';            
            }

                
        }else{            
                $this->_error('error', 'Invalid Accesstoken.');
            }
            $this->_output();
            exit();
    }

//*************************************************************************************************
    function jobDetail()
     { 
        //error_reporting(-1);
        //ini_set('display_errors', 1);
        $request = json_decode(rtrim(file_get_contents('php://input'), "\0"));
        $header = $this->input->request_headers();            
        $accesstoken = $header['Accesstoken'];
        $user_id = ($request->user_id) ? $request->user_id : '';
        if (!$user_id) {
                    $this->_error('Form error', 'User Id is not specified.');
                    return false;
        }

        if($this->check_accesstoken($user_id,$accesstoken))
        {
                
            $job_id = ($request->job_id) ? $request->job_id : '';      
            if (!$job_id) {
                        $this->_error('Form error', 'Job Id is not specified.');
                        return false;
            }
            $result =  $this->Core_Model->joindata('job_post.service_id', 'category.id', array('job_post.id'=>$job_id), 'job_post.*,category.title as ctitle,category.image', 'job_post', 'category', 'job_post.id asc');

            $jobdata['job_id'] = $result['id'];
            $jobdata['title'] = $result['title'];
            $jobdata['description'] = $result['description'];
            $jobdata['min_budget'] = $result['min_budget'];
            $jobdata['max_budget'] = $result['max_budget'];
            $jobdata['date_time'] = $result['date_time'];
            $jobdata['category_title'] = $result['ctitle'];
            $jobdata['category_image'] = base_url('upload/category/').$result['image'];

            $proposals = $this->Core_Model->SelectRecord('proposal', '*', array('job_id' => $job_id), $order = '');

            $user = $this->Core_Model->SelectSingleRecord('users', '*', array('id' => $user_id), $order = '');    

            $jobdata['proposals'] = count($proposals);
            $jobdata['user_type'] = $user->user_type;

            $jobdata['bid_status'] = ($result->proposal_id) ? "1" : "0";

            $reviewdata = $this->Core_Model->joindataResult('r.sender_id','u.id',array('r.receiver_id' => $user_id,'r.is_deleted'=>'0'),'r.*,u.id,u.name,u.image','review as r','users as u', 'r.id desc');            
            $rating = 0; $review = []; $ratingcount = 0; 
            foreach ($reviewdata as $key => $value) {
               # code...
               if($value['rating']){
                    $rating += $value['rating'];
                    $ratingcount++;
               }               
            }

            
            //print_r($review); die;
            $jobdata['rating'] = ($rating) ? ($rating/$ratingcount) : 0; 

            $jobdata['no_of_project'] = 0;
            if($user->user_type == 1){
                $total_projects = $this->Core_Model->selectRecord('job_post', '*', array('user_id' => $user_id,'is_deleted'=>'0','status'=>'3'));
                $jobdata['no_of_project'] = count($total_projects);
            }
            
            if($result){
                $this->res->success = 'true';
                $this->res->data = $jobdata;                
                $this->res->message = 'Job Details Show Successfully';   
            }else{
                $this->res->success = 'false';                
                $this->res->message = 'No Job found';   
            }
                
        }else
        {            
            $this->_error('error', 'Invalid Accesstoken.');
        }  
        $this->_output();
        exit();                    
    }
 //**************************************************************************************
    public function place_bid()
    { 
        $request = json_decode(rtrim(file_get_contents('php://input'), "\0"));
        $header = $this->input->request_headers();
        $user_id = isset($request->user_id) ? $request->user_id : '';
        $accesstoken = $header['Accesstoken'];         

        if (!$user_id) {
                    $this->_error('Form error', 'User-Id is not specified.');
                    return false;
        }
        if($this->check_accesstoken($user_id,$accesstoken))
        {            
            $job_id = isset($request->job_id) ? $request->job_id : '';    
            $amount = isset($request->amount) ? $request->amount : '0';
            $proposal = isset($request->proposal) ? $request->proposal : ''; 
            $date_time = $request->date_time;                    

            if (!$job_id) {
                        $this->_error('Form error', 'Job Id is not specified.');
                        return false;
            }

            if (!$amount) {
                        $this->_error('Form error', 'Bid amount is not specified.');
                        return false;
            }            
            if (!$proposal) {
                        $this->_error('Form error', 'Description is not specified.');
                        return false;
            }              
            if (!$date_time) {
                        $this->_error('Form error', 'Date Time is not specified.');
                        return false;
            }

            $user = $this->Core_Model->selectsinglerecord('users', '*', array('id'=>$user_id)); 
            if($user && $user->user_type != 2){
                        $this->_error('Form error', 'User can not place a bid.');
                        return false;   
            }
            if($user && $user->is_verified != 1){
                        $this->_error('Form error', 'Verify email before place a bid.');
                        return false;   
            }
            if(!$user){
                        $this->_error('Form error', 'User-Id not found.');
                        return false;   
            }

            $job = $this->Core_Model->selectsinglerecord('job_post', '*', array('id'=>$job_id));
            if($job && $job->status != 1){
                $this->_error('Form error', 'this job is closed.');
                return false;      
            }
            $result = $this->Core_Model->selectsinglerecord('proposal', '*', array('job_id'=>$job_id,'user_id'=>$user_id));
            if($result){
                    $this->_error('Form error', 'you have already placed a bid on this job.');
                    return false;      
            }
            
            // $d1 = explode('/', $date_time);
            // $t1 = explode(' ', $d1[2]);
            // $p_time = $t1[0].'-'.$d1[1].'-'.$d1[0].' '.$t1[1];

            // $d2 = explode('/', $job->date_time);
            // $t2 = explode(' ', $d2[2]);
            // $j_time = $t2[0].'-'.$d2[1].'-'.$d2[0].' '.$t2[1];

            //$day = round( (strtotime($p_time) - strtotime($j_time) ) / (24*3600)  );
            $where = array('user_id'=>$user_id,'job_id'=>$job_id,'amount'=>$amount,'proposal'=>$proposal,'date_time'=>$date_time,'days'=>$date_time);           
            $data = $this->Core_Model->InsertRecord('proposal', $where);

            if (empty($data))
            {
                $this->res->success = 'false';
                $this->res->message = "Incorrect data";
            }
            else
            {
                //insert into notification table
                $noti_data = array('sender_id'=>$user_id,'receiver_id'=>$job->user_id,'job_id'=>$job_id,'notification_type'=>'bid','notification'=>'You received a new proposal on "'.$job->title.'"');
                $notification_id = $this->Core_Model->InsertRecord('notifications', $noti_data);                 
                //send mail to user
                $owner = $this->Core_Model->selectsinglerecord('users', '*', array('id'=>$job->user_id));
                $subject = "Bid is submitted on your job";            
                $msg = "You received a new proposal on ".$job->title;           
                $email = $this->email($owner->email, $subject, $msg);               
                // send firebase notification
                $this->push_notification_android($owner->device_token,'You received a new proposal on "'.$job->title.'"',$notification_id);

                $this->res->data = ["proposal_id" => $data];
                $this->res->success = 'true';
                $this->res->message = 'Bid Placed Successfully';                
            } 

        }else
        {            
            $this->_error('error', 'Invalid Accesstoken.');
        }  
        $this->_output();
        exit();
    }
//*****************************************************************************
  
//********************************************************************************************
  public function browse_jobs()
    { 
        $request = json_decode(rtrim(file_get_contents('php://input'), "\0"));
        $header = $this->input->request_headers();            
        $accesstoken = $header['Accesstoken'];
        $user_id = isset($request->user_id) ? $request->user_id : '';         
        if (!$user_id) {
                    $this->_error('Form error', 'User-Id is not specified.');
                    return false;
        }
        if($this->check_accesstoken($user_id,$accesstoken))
        {
            $search_string = isset($request->search_string) ? $request->search_string : '';
            $services_filter = isset($request->services_filter) ? $request->services_filter : '';
            $cities_filter = isset($request->cities_filter) ? $request->cities_filter : '';
            $sort_by = isset($request->sort_by) ? $request->sort_by : '';
            $order_by = isset($request->order_by) ? $request->order_by : ''; 
            $page = isset($request->page) ? $request->page : '1'; 

            $page = $page - 1 ;
            $limit  = 30;
            $offset = $page * $limit ;

            if (!$sort_by) {
                        $this->_error('Form error', 'Sort By is not specified.');
                        return false;
            }
            if (!$order_by) {
                        $this->_error('Form error', 'Order By is not specified.');
                        return false;
            }  

            $res = []; 
            
                if($sort_by == 'latest'){
                    $sort = 'j.id '.$order_by;
                }else if($sort_by == 'popular'){
                    $sort = 'j.id '.$order_by;                    
                }else if($sort_by == 'budget'){                    
                    $sort = 'j.max_budget '.$order_by;                    
                }else{ 
                    $sort = 'j.id DESC'; 
                }                
                
                $where = 'j.status = 1 AND j.is_deleted = 0';
                if($services_filter){
                    $where .= ' AND c.id IN ('.$services_filter.')';
                }
                if($cities_filter){
                    $where .= ' AND j.city IN ('.$cities_filter.')';
                }
                if($search_string){
                    $where .= ' AND j.title LIKE "%'.$search_string.'%"';
                }

                                
                $totalres =  $this->Core_Model->joindataResult('j.service_id','c.id',$where,'j.id','job_post as j','category as c',$sort);
                //echo $this->db->last_query(); die;
                $res = $this->Core_Model->joindatapagination('j.service_id','c.id',$where,'j.*,c.title as category_name,c.image as category_image','job_post as j','category as c',$sort,$limit,$offset);
                                
            
            
        
            $jobs = [];
            foreach ($res as $key=>$value) 
            {                                           
                $proposals = $this->Core_Model->SelectRecord('proposal', '*', array('job_id' => $value['id']), $order = '');            
                
                $job_data['job_id']       = $value['id'];
                $job_data['title']       = $value['title'];
                $job_data['description'] = $value['description'];
                $job_data['min_budget'] = $value['min_budget'];
                $job_data['max_budget'] = $value['max_budget'];
                $job_data['proposals']       = count($proposals); 
                $job_data['rating']       = '3'; 

                $jobs[] = $job_data;           
            }

            // sort by popular based on number of proposals
            if($sort_by == 'popular'){
                $proposals = array_column($jobs, 'proposals');
                $order = ($order_by == 'asc') ? 'SORT_DESC' : 'SORT_ASC';
                array_multisort($proposals, $order, $jobs);
            }

            if (empty($jobs))
            {                
                $this->res->success = 'true';
                $this->res->data = [];
                $this->res->message = "Currently, No More Jobs Available";
            }
            else
            {
            	
				$this->res->page    = $page + 1;
				$this->res->per_page    = $limit;
				$this->res->total    = count($totalres);
				$this->res->total_pages    = ceil((count($totalres) / $limit));
                $this->res->data    = $jobs;
                $this->res->success = 'true';
                $this->res->message = 'Jobs listed Successfully';                
            } 
        }else
        {            
            $this->_error('error', 'Invalid Accesstoken.');
        }  
        $this->_output();
        exit();
        
    }

//****************************************************************************************************  
//********************************************************************************************
  public function open_bricoles()
    { 
        //error_reporting(-1);
        //ini_set('display_errors', 1);  
        $request = json_decode(rtrim(file_get_contents('php://input'), "\0"));
        $header = $this->input->request_headers();            
        $accesstoken = $header['Accesstoken'];
        $user_id = isset($request->user_id) ? $request->user_id : '';         
        if (!$user_id) {
                    $this->_error('Form error', 'User-Id is not specified.');
                    return false;
        }
        if($this->check_accesstoken($user_id,$accesstoken))
        {                                    
            $user = $this->Core_Model->SelectSingleRecord('users', '*', array('id' => $user_id), 'id desc'); 

            if($user->user_type == 1){
                $res = $this->Core_Model->SelectRecord('job_post', '*', 'user_id='.$user_id.' AND (status = 1) AND is_deleted = 0', 'id desc');                
            }else{
                $res = $this->Core_Model->joindataResult('p.job_id', 'j.id', array('p.user_id' => $user_id,'p.status'=>'2','p.accept'=>'0','p.is_deleted'=>'0'), 'j.*,p.amount', 'proposal as p', 'job_post as j', 'p.id desc');
            }

            $jobs = [];
            foreach ($res as $key=>$value) 
            {   

                $proposals = $this->Core_Model->SelectRecord('proposal', '*', array('job_id' => $value['id']), $order = '');            
                
                $job_data['job_id']       = $value['id'];
                $job_data['title']       = $value['title'];                
                //$job_data['min_budget'] = $value['min_budget'];
                //$job_data['max_budget'] = $value['max_budget'];
                $job_data['date_time'] = $value['date_time'];
                $job_data['proposals']       = count($proposals);  
                if($user->user_type == 2){   
                    if($value['amount']){
                        $job_data['amount']       = $value['amount'];
                    }else{
                        $job_data['amount']       = $value['max_budget'];
                    }            
                }else{
                     $job_data['amount']       = "0";
                }
                $jobs[] = $job_data;           
            }
            
            if (empty($jobs))
            {                
                $this->res->success = 'true';
                $this->res->data    = [];
                $this->res->message = "Currently, No More Open Brocoles";
            }
            else
            {
                
                $this->res->success = 'true';
                $this->res->data    = $jobs;
                $this->res->message = 'Open bricoles listed Successfully';                
            } 
        }else
        {            
            $this->_error('error', 'Invalid Accesstoken.');
        }  
        $this->_output();
        exit();
        
    }

//****************************************************************************************************  
    //********************************************************************************************
  public function view_proposal()
    { 
        $request = json_decode(rtrim(file_get_contents('php://input'), "\0"));
        $header = $this->input->request_headers();            
        $accesstoken = $header['Accesstoken'];
        $user_id = isset($request->user_id) ? $request->user_id : '';         
        if (!$user_id) {
                    $this->_error('Form error', 'User-Id is not specified.');
                    return false;
        }
        if($this->check_accesstoken($user_id,$accesstoken))
        {               
            $job_id = isset($request->job_id) ? $request->job_id : '';                        

            if (!$job_id) {
                    $this->_error('Form error', 'Job-Id is not specified.');
                        return false;
            }

            $job = $this->Core_Model->SelectSingleRecord('job_post', '*', array('id' => $job_id), 'id desc'); 
            if($job && $job->user_id != $user_id){
                    $this->_error('Form error', 'You are not authorize to view this job proposals.');
                        return false;   
            }

            $result = $this->Core_Model->joindataResult('p.user_id', 'u.id', array('p.job_id' => $job_id), 'p.*,u.name,u.id as user_id,u.image', 'proposal as p', 'users as u', 'p.id asc');  

            $proposals = [];
            foreach ($result as $key=>$value) 
            {    
                $propsal_data['proposal_id']       = $value['id'];
                $propsal_data['name']       = $value['name'];
                $propsal_data['bricoler_id']       = $value['user_id'];
                $propsal_data['bricoler_name']       = $value['name'];
                $propsal_data['bricoler_image']       = base_url('upload/profile/').$value['image'];
                $propsal_data['proposal']       = $value['proposal'];                
                $propsal_data['amount'] = $value['amount'];
                $propsal_data['days'] = $value['days'];
                $propsal_data['status'] = $value['status'];

                $reviewdata = $this->Core_Model->joindataResult('r.sender_id','u.id',array('r.receiver_id' => $value['user_id'],'r.is_deleted'=>'0'),'r.*,u.id,u.name,u.image','review as r','users as u', 'r.id desc');            
                $rating = 0; $review = []; $ratingcount = 0; $reviewcount = 0;
                foreach ($reviewdata as $val) {                   
                   if($val['rating']){
                        $rating += $val['rating'];
                        $ratingcount++;
                   }
                   if($val['review']){                        
                        $reviewcount++;
                   }               
                }
                $propsal_data['rating'] = ($rating) ? ($rating/$ratingcount) : 0; 

                //$propsal_data['rating']       = '4';                 
                $propsal_data['reviews']       = $reviewcount;
                $propsal_data['accept']       = $value['accept'];
                $proposals[] = $propsal_data;           
            }
            
            if (empty($proposals))
            {                
                $this->res->success = 'true';
                $this->res->data    = [];
                $this->res->message = "Currently, No More Proposals to show";
            }
            else
            {
                
                $this->res->success = 'true';
                $this->res->data    = $proposals;
                $this->res->message = 'Proposals listed Successfully';                
            } 
        }else
        {            
            $this->_error('error', 'Invalid Accesstoken.');
        }  
        $this->_output();
        exit();
        
    }

//**************************************************************************************************** 
//********************************************************************************************
  public function award_job()
    { 
        $request = json_decode(rtrim(file_get_contents('php://input'), "\0"));
        $header = $this->input->request_headers();            
        $accesstoken = $header['Accesstoken'];
        $user_id = isset($request->user_id) ? $request->user_id : '';         
        if (!$user_id) {
                    $this->_error('Form error', 'User-Id is not specified.');
                    return false;
        }
        if($this->check_accesstoken($user_id,$accesstoken))
        {               
            $job_id = isset($request->job_id) ? $request->job_id : '';                        
            $proposal_id = isset($request->proposal_id) ? $request->proposal_id : '';   

            if (!$job_id) {
                    $this->_error('Form error', 'Job-Id is not specified.');
                        return false;
            }
            if (!$proposal_id) {
                    $this->_error('Form error', 'Proposal-Id is not specified.');
                        return false;
            }

            $job = $this->Core_Model->SelectSingleRecord('job_post', '*', array('id' => $job_id), 'id desc'); 
            if($job && $job->user_id != $user_id){
                    $this->_error('Form error', 'You are not authorize to award this job.');
                        return false;   
            }

            if($job && $job->proposal_id){
                    $this->_error('Form error', 'You have already awarded this job.');
                        return false;   
            }

            $this->Core_Model->updateFields('job_post',array("proposal_id"=>$proposal_id,"status" => '2'), array('id' => $job_id));
            $this->Core_Model->updateFields('proposal',array("status" => '2'), array('id' => $proposal_id));

            $proposal = $this->Core_Model->SelectSingleRecord('proposal', '*', array('id' => $proposal_id), 'id desc'); 
            //insert into notification table
            $noti_data = array('sender_id'=>$user_id,'receiver_id'=>$proposal->user_id,'job_id'=>$job_id,'notification_type'=>'award','notification'=>'You have awarded a new job of '.$job->title);
            $notification_id = $this->Core_Model->InsertRecord('notifications', $noti_data);
            //send mail to user
            $owner = $this->Core_Model->selectsinglerecord('users', '*', array('id'=>$proposal->user_id));
            $subject = "You have awarded a new job";            
            $msg = 'You have awarded a new job of '.$job->title;           
            $email = $this->email($owner->email, $subject, $msg);               
            // send firebase notification
            $this->push_notification_android($owner->device_token,'You received a new proposal on '.$job->title,$notification_id);
              
            $this->res->success = 'true';            
            $this->res->message = 'Job awarded Successfully';                
             
        }else
        {            
            $this->_error('error', 'Invalid Accesstoken.');
        }  
        $this->_output();
        exit();
        
    }

//****************************************************************************************************  

    //********************************************************************************************
  public function accept_job()
    { 
        $request = json_decode(rtrim(file_get_contents('php://input'), "\0"));
        $header = $this->input->request_headers();            
        $accesstoken = $header['Accesstoken'];
        $user_id = isset($request->user_id) ? $request->user_id : '';         
        if (!$user_id) {
                    $this->_error('Form error', 'User-Id is not specified.');
                    return false;
        }
        if($this->check_accesstoken($user_id,$accesstoken))
        {               
            $job_id = isset($request->job_id) ? $request->job_id : '';                                    

            if (!$job_id) {
                    $this->_error('Form error', 'Job-Id is not specified.');
                        return false;
            }
            
            $job = $this->Core_Model->SelectSingleRecord('proposal', '*', array('job_id' => $job_id,'status'=>'2'), 'id desc'); 
            if($job && $job->user_id != $user_id){
                    $this->_error('Form error', 'You are not authorize to accept this job.');
                        return false;   
            }

            if($job && $job->accept == 1){
                    $this->_error('Form error', 'You have already accepted this job.');
                        return false;   
            }
            
            $this->Core_Model->updateFields('proposal',array("accept" => '1'), array('id' => $job->id));
            //insert into notification table
            $job = $this->Core_Model->SelectSingleRecord('job_post', '*', array('id' => $job_id), 'id desc'); 
            $noti_data = array('sender_id'=>$user_id,'receiver_id'=>$job->user_id,'job_id'=>$job_id,'notification_type'=>'accept','notification'=>'Your job of "'.$job->title.'" has been accepted ');
            $notification_id = $this->Core_Model->InsertRecord('notifications', $noti_data);
            //send mail to user
            $owner = $this->Core_Model->selectsinglerecord('users', '*', array('id'=>$job->user_id));
            $subject = "Job has been accepted";            
            $msg = 'Your job of "'.$job->title.'" has been accepted ';           
            $email = $this->email($owner->email, $subject, $msg);               
            // send firebase notification
            $this->push_notification_android($owner->device_token,'You received a new proposal on '.$job->title,$notification_id);
              
            $this->res->success = 'true';            
            $this->res->message = 'Job accepted Successfully';                
             
        }else
        {            
            $this->_error('error', 'Invalid Accesstoken.');
        }  
        $this->_output();
        exit();
        
    }

//****************************************************************************************************  
     //********************************************************************************************
  public function reject_job()
    { 
        $request = json_decode(rtrim(file_get_contents('php://input'), "\0"));
        $header = $this->input->request_headers();            
        $accesstoken = $header['Accesstoken'];
        $user_id = isset($request->user_id) ? $request->user_id : '';         
        if (!$user_id) {
                    $this->_error('Form error', 'User-Id is not specified.');
                    return false;
        }
        if($this->check_accesstoken($user_id,$accesstoken))
        {               
            $job_id = isset($request->job_id) ? $request->job_id : '';                                    

            if (!$job_id) {
                    $this->_error('Form error', 'Job-Id is not specified.');
                        return false;
            }
            
            $job = $this->Core_Model->SelectSingleRecord('proposal', '*', array('job_id' => $job_id,'status'=>'2'), 'id desc'); 
            if(!$job){
                $this->_error('Form error', 'You have already rejected this job.');
                return false;   
            }
            if($job && $job->user_id != $user_id){
                    $this->_error('Form error', 'You are not authorize to reject this job.');
                        return false;   
            }

            if($job && $job->accept == 2){
                    $this->_error('Form error', 'You have already rejected this job.');
                        return false;   
            }
            
            $this->Core_Model->updateFields('proposal',array("accept" => '2',"status"=>'1'), array('id' => $job->id));
            $this->Core_Model->updateFields('job_post',array("status" => '1','proposal_id'=>''), array('id' => $job_id));

            //insert into notification table
            $job = $this->Core_Model->SelectSingleRecord('job_post', '*', array('id' => $job_id), 'id desc'); 
            $noti_data = array('sender_id'=>$user_id,'receiver_id'=>$job->user_id,'job_id'=>$job_id,'notification_type'=>'reject','notification'=>'Your job of "'.$job->title.'" has been rejected ');
            $notification_id = $this->Core_Model->InsertRecord('notifications', $noti_data);
            //send mail to user
            $owner = $this->Core_Model->selectsinglerecord('users', '*', array('id'=>$job->user_id));
            $subject = "Job has been rejected";            
            $msg = 'Your job of "'.$job->title.'" has been rejected ';           
            $email = $this->email($owner->email, $subject, $msg);               
            // send firebase notification
            $this->push_notification_android($owner->device_token,'You received a new proposal on '.$job->title,$notification_id);
              
            $this->res->success = 'true';            
            $this->res->message = 'Job rejected Successfully';                
             
        }else
        {            
            $this->_error('error', 'Invalid Accesstoken.');
        }  
        $this->_output();
        exit();
        
    }

//****************************************************************************************************  
    //********************************************************************************************
  public function upcoming_bricoles()
    { 
        $request = json_decode(rtrim(file_get_contents('php://input'), "\0"));
        $header = $this->input->request_headers();            
        $accesstoken = $header['Accesstoken'];
        $user_id = isset($request->user_id) ? $request->user_id : '';         
        if (!$user_id) {
                    $this->_error('Form error', 'User-Id is not specified.');
                    return false;
        }
        if($this->check_accesstoken($user_id,$accesstoken))
        {                                    
            $user = $this->Core_Model->SelectSingleRecord('users', '*', array('id' => $user_id), 'id desc'); 

            if($user->user_type == 1){
                $res = $this->Core_Model->SelectRecord('job_post', '*', array('user_id' => $user_id,'status'=>2,'is_deleted'=>0), 'id desc'); 
            }else{
                $res = $this->Core_Model->joindataResult('p.job_id', 'j.id', array('p.user_id' => $user_id,'p.status'=>2,'p.accept'=>1,'p.is_deleted'=>'0'), 'j.*', 'proposal as p', 'job_post as j', 'p.id desc');
            }

            $jobs = [];
            foreach ($res as $key=>$value) 
            {   

                $proposal = $this->Core_Model->joindata('p.user_id', 'u.id', array('p.id' => $value['proposal_id']), 'u.id,u.name,u.image,p.accept', 'proposal as p', 'users as u', 'p.id desc');         
                
                $job_data['job_id']       = $value['id'];
                $job_data['title']       = $value['title'];                
                //$job_data['min_budget'] = $value['min_budget'];
                //$job_data['max_budget'] = $value['max_budget'];
                $job_data['date_time'] = $value['date_time'];
                
                 if($user->user_type == 1){
                    $job_data['bricoler_id']       = $proposal['id'];
                    $job_data['bricoler_name']       = $proposal['name']; 
                    $job_data['bricoler_image']       = base_url('upload/profile/').$proposal['image'];
                 }else{ 
                    $bricoler = $this->Core_Model->SelectSingleRecord('users', '*', array('id' => $value['user_id']), 'id desc');                                        
                    $job_data['bricoler_id']       = $bricoler->id;
                    $job_data['bricoler_name']       = $bricoler->name;    
                    $job_data['bricoler_image']       = base_url('upload/profile/').$bricoler->image;
                 }
                $job_data['bricoler']       = $proposal['name'];
                $job_data['accept']       = $proposal['accept'];                 
                $jobs[] = $job_data;           
            }
            
            if (empty($jobs))
            {                
                $this->res->success = 'true';
                $this->res->data    = [];
                $this->res->message = "Currently, No More Upcoming Brocoles";
            }
            else
            {
                
                $this->res->success = 'true';
                $this->res->data    = $jobs;
                $this->res->message = 'Upcoming bricoles listed Successfully';                
            } 
        }else
        {            
            $this->_error('error', 'Invalid Accesstoken.');
        }  
        $this->_output();
        exit();
        
    }

//****************************************************************************************************  
    public function complete_job()
    { 
        $request = json_decode(rtrim(file_get_contents('php://input'), "\0"));
        $header = $this->input->request_headers();            
        $accesstoken = $header['Accesstoken'];
        $user_id = isset($request->user_id) ? $request->user_id : '';         
        if (!$user_id) {
                    $this->_error('Form error', 'User-Id is not specified.');
                    return false;
        }
        if($this->check_accesstoken($user_id,$accesstoken))
        {               
            $job_id = isset($request->job_id) ? $request->job_id : '';                        
            $proposal_id = isset($request->proposal_id) ? $request->proposal_id : '';   

            if (!$job_id) {
                    $this->_error('Form error', 'Job-Id is not specified.');
                        return false;
            }
            // if (!$proposal_id) {
            //         $this->_error('Form error', 'Proposal-Id is not specified.');
            //             return false;
            // }

            $job = $this->Core_Model->SelectSingleRecord('job_post', '*', array('id' => $job_id), 'id desc'); 
            if(!$job){
                $this->_error('Form error', 'You are not authorize to complete this job.');
                        return false;   
            }
            if($job && $job->user_id != $user_id){
                    $this->_error('Form error', 'You are not authorize to complete this job.');
                        return false;   
            }

            if($job && $job->status == 3){
                    $this->_error('Form error', 'You have already completed this job.');
                        return false;   
            }

            $this->Core_Model->updateFields('job_post',array("proposal_id"=>$job->proposal_id,"status" => '3'), array('id' => $job_id));
            $this->Core_Model->updateFields('proposal',array("status" => '3'), array('id' => $job->proposal_id));

            $proposal = $this->Core_Model->SelectSingleRecord('proposal', '*', array('id' => $job->proposal_id), 'id desc'); 
            //insert into notification table
            $noti_data = array('sender_id'=>$user_id,'receiver_id'=>$proposal->user_id,'job_id'=>$job_id,'notification_type'=>'complete','notification'=>'Job of "'.$job->title.'" has been completed.');
            $notification_id = $this->Core_Model->InsertRecord('notifications', $noti_data);
            //send mail to user
            $owner = $this->Core_Model->selectsinglerecord('users', '*', array('id'=>$proposal->user_id));
            $subject = "Job Completed";            
            $msg = 'Job of "'.$job->title.'" has been completed.';           
            $email = $this->email($owner->email, $subject, $msg);               
            // send firebase notification
            $this->push_notification_android($owner->device_token,'You received a new proposal on '.$job->title,$notification_id);
              
            $this->res->success = 'true';            
            $this->res->message = 'Job completed Successfully';                
             
        }else
        {            
            $this->_error('error', 'Invalid Accesstoken.');
        }  
        $this->_output();
        exit();
        
    }

//****************************************************************************************************  
     //********************************************************************************************
  public function completed_bricoles()
    { 
        $request = json_decode(rtrim(file_get_contents('php://input'), "\0"));
        $header = $this->input->request_headers();            
        $accesstoken = $header['Accesstoken'];
        $user_id = isset($request->user_id) ? $request->user_id : '';         
        if (!$user_id) {
                    $this->_error('Form error', 'User-Id is not specified.');
                    return false;
        }
        if($this->check_accesstoken($user_id,$accesstoken))
        {                                    
            $user = $this->Core_Model->SelectSingleRecord('users', '*', array('id' => $user_id), 'id desc'); 

            if($user->user_type == 1){
                $res = $this->Core_Model->SelectRecord('job_post', '*', array('user_id' => $user_id,'status'=>3,'is_deleted'=>0), 'id desc'); 
            }else{
                $res = $this->Core_Model->joindataResult('p.job_id', 'j.id', array('p.user_id' => $user_id,'p.status'=>3,'p.is_deleted'=>'0'), 'j.*', 'proposal as p', 'job_post as j', 'p.id desc');
            }

            $jobs = [];
            foreach ($res as $key=>$value) 
            {   

                $proposal = $this->Core_Model->joindata('p.user_id', 'u.id', array('p.id' => $value['proposal_id']), 'u.name', 'proposal as p', 'users as u', 'p.id desc');         
                
                $job_data['job_id']       = $value['id'];
                $job_data['title']       = $value['title'];                
                //$job_data['min_budget'] = $value['min_budget'];
                //$job_data['max_budget'] = $value['max_budget'];
                $job_data['date_time'] = $value['date_time'];
                $job_data['bricoler']       = $proposal['name'];                 
                $jobs[] = $job_data;           
            }
            
            if (empty($jobs))
            {                
                $this->res->success = 'true';
                $this->res->data    = [];
                $this->res->message = "Currently, No More Completed Brocoles";
            }
            else
            {
                
                $this->res->success = 'true';
                $this->res->data    = $jobs;
                $this->res->message = 'Completed bricoles listed Successfully';                
            } 
        }else
        {            
            $this->_error('error', 'Invalid Accesstoken.');
        }  
        $this->_output();
        exit();
        
    }

//****************************************************************************************************  

    //********************************************************************************************
  public function browse_bricolers()
    { 
        $request = json_decode(rtrim(file_get_contents('php://input'), "\0"));
        $header = $this->input->request_headers();            
        $accesstoken = $header['Accesstoken'];
        $user_id = isset($request->user_id) ? $request->user_id : '';         
        if (!$user_id) {
                    $this->_error('Form error', 'User-Id is not specified.');
                    return false;
        }
        if($this->check_accesstoken($user_id,$accesstoken))
        {
            $search_string = isset($request->search_string) ? $request->search_string : '';
            $services_filter = isset($request->services_filter) ? $request->services_filter : '';
            $cities_filter = isset($request->cities_filter) ? $request->cities_filter : '';
            $sort_by = isset($request->sort_by) ? $request->sort_by : '';
            $order_by = isset($request->order_by) ? $request->order_by : ''; 
            $page = isset($request->page) ? $request->page : '1'; 

            $page = $page - 1 ;
            $limit  = 30;
            $offset = $page * $limit ;


            $res = []; 
            
                if($sort_by == 'latest'){
                    $sort = 'j.id '.$order_by;
                }else if($sort_by == 'popular'){
                    $sort = 'j.id '.$order_by;                    
                }else if($sort_by == 'budget'){                    
                    $sort = 'j.max_budget '.$order_by;                    
                }else{ 
                    $sort = 'j.id DESC'; 
                }               
                
                $where = 'user_type = 2 AND is_deleted = 0';
                if($services_filter){
                    $where .= ' AND skills LIKE "%'.$services_filter.'%"';
                }
                if($cities_filter){
                    $where .= ' AND cities LIKE "%'.$cities_filter.'%"';
                }
                if($search_string){
                    $where .= ' AND name LIKE "%'.$search_string.'%"';
                }

                                
                $totalres = $this->Core_Model->SelectRecord('users', '*', $where, $order = '');
                //echo $this->db->last_query(); die;
                $res = $this->Core_Model->SelectRecordpaginatoin('users', '*', $where, $order = '',$limit,$offset);
                                
            
            
        
            $users = [];
            foreach ($res as $key=>$value) 
            {   
                $category = []; $services = [];
                if($value['skills']){                    
                        $where = ' id IN ('.$value['skills'].')';
                        $category = $this->Core_Model->SelectRecord('category', 'title,image', $where, $order = ''); 
                        foreach ($category as $row) {                               
                            $services[] = $row['title'];
                        }                               
                }
                                
                $user_data['user_id']        = $value['id'];
                $user_data['name']           = ($value['name']) ? $value['name'] : '';
                $user_data['category_name']  = ($category) ? $category[0]['title'] : 'No category';
                $user_data['category_image'] = ($category) ? base_url('upload/category/').$category[0]['image'] : 'No category';
                $user_data['services']       = implode(', ',$services);
                $user_data['charge']         = ($value['charge']) ? $value['charge'] : ''; 

                $reviewdata = $this->Core_Model->joindataResult('r.sender_id','u.id',array('r.receiver_id' => $value['id'],'r.is_deleted'=>'0'),'r.*,u.id,u.name,u.image','review as r','users as u', 'r.id desc');            
                $rating = 0; $review = []; $ratingcount = 0; 
                foreach ($reviewdata as $key => $value) {
                   # code...
                   if($value['rating']){
                        $rating += $value['rating'];
                        $ratingcount++;
                   }               
                }
                $user_data['rating'] = ($rating) ? ($rating/$ratingcount) : 0;
                //$user_data['rating']         = '3'; 

                $users[] = $user_data;           
            }


            if (empty($users))
            {                
                $this->res->success = 'true';
                $this->res->data = [];
                $this->res->message = "Currently, No More Bricoleurs Available";
            }
            else
            {
                
                $this->res->page    = $page + 1;
                $this->res->per_page    = $limit;
                $this->res->total    = count($totalres);
                $this->res->total_pages    = ceil((count($totalres) / $limit));
                $this->res->data    = $users;
                $this->res->success = 'true';
                $this->res->message = 'Bricoleurs listed Successfully';                
            } 
        }else
        {            
            $this->_error('error', 'Invalid Accesstoken.');
        }  
        $this->_output();
        exit();
        
    }

//****************************************************************************************************  

    //********************************************************************************************
  public function dashboard()
    { 
        $request = json_decode(rtrim(file_get_contents('php://input'), "\0"));
        $header = $this->input->request_headers();            
        $accesstoken = $header['Accesstoken'];
        $user_id = isset($request->user_id) ? $request->user_id : '';         
        if (!$user_id) {
                    $this->_error('Form error', 'User-Id is not specified.');
                    return false;
        }
        if($this->check_accesstoken($user_id,$accesstoken))
        {
        	$user = $this->Core_Model->selectsinglerecord('users', '*', array('id' => $user_id));
        	if($user){
        			$userdata['user_id'] = ($user->id) ? $user->id : '';
		            $userdata['name'] = ($user->name) ? $user->name : '';
		            $userdata['email'] = ($user->email) ? $user->email : '';
		            $userdata['phone'] = ($user->contact) ? $user->contact : '';               
		            $userdata['token'] = ($user->token) ? $user->token : '';
		            $userdata['lat'] = ($user->lat) ? $user->lat : '0'; 
		            $userdata['long'] = ($user->long) ? $user->long : '0'; 
		            $userdata['user_type'] = ($user->user_type) ? $user->user_type : ''; 
		            

		            // calculate bricoles for user and vendor
		            if($user->user_type == 1){
                        $open_bricoles = $this->Core_Model->selectRecord('job_post', '*', array('user_id' => $user_id,'is_deleted'=>'0','status'=>'1'));
                        $upcoming_bricoles = $this->Core_Model->selectRecord('job_post', '*', array('user_id' => $user_id,'is_deleted'=>'0','status'=>'2'));
                        $completed_bricoles = $this->Core_Model->selectRecord('job_post', '*', array('user_id' => $user_id,'is_deleted'=>'0','status'=>'3'));


		                $userdata['upcoming_bricoles'] = count($upcoming_bricoles);   
		                $userdata['open_bricoles'] = count($open_bricoles);
		                $userdata['completed_bricoles'] = count($completed_bricoles);
		                $userdata['inbox'] = 0;
		            }else{
                        $open_bricoles = $this->Core_Model->selectRecord('proposal', '*', array('user_id' => $user_id,'is_deleted'=>'0','status'=>'2','accept'=>'0'));
                        $upcoming_bricoles = $this->Core_Model->selectRecord('proposal', '*', array('user_id' => $user_id,'is_deleted'=>'0','status'=>'2','accept'=>'1'));
                        $completed_bricoles = $this->Core_Model->selectRecord('proposal', '*', array('user_id' => $user_id,'is_deleted'=>'0','status'=>'3'));

		                $userdata['upcoming_bricoles'] = count($upcoming_bricoles);   
                        $userdata['open_bricoles'] = count($open_bricoles);
                        $userdata['completed_bricoles'] = count($completed_bricoles);
                        $userdata['inbox'] = 0;
		            } 

		            
		                $this->res->data    = $userdata;
		                $this->res->success = 'true';
		                $this->res->message = 'Dashboard listed Successfully';                	
        	}else{
        		$this->res->success = 'false';
		        $this->res->message = 'User Not Found';                	
        	}            
            
             
        }else
        {            
            $this->_error('error', 'Invalid Accesstoken.');
        }  
        $this->_output();
        exit();
        
    }

    //**************************************************************************************
    function update_profile()
    { 
        $request = json_decode(rtrim(file_get_contents('php://input'), "\0"));
        $header = $this->input->request_headers();
        $accesstoken = $header['Accesstoken'];
        $user_id = ($_POST['user_id']) ? $_POST['user_id'] : '';        
        if (!$user_id) {
                    $this->_error('Form error', 'User-Id is not specified.');
                    return false;
        }
        if($this->check_accesstoken($user_id,$accesstoken))
        {   
            $userdata = [];

            $image = $_FILES['image'];                                                 
            if($image){
                $config['upload_path']          = './upload/profile/';
                $config['allowed_types']        = 'jpg|png|jpeg';
                $config['max_size']             = 1000;
                $config['encrypt_name']         = TRUE;
                // $config['max_width']            = 1024;
                // $config['max_height']           = 768;
                $this->load->library('upload', $config);
                if ( ! $this->upload->do_upload('image'))
                {                    
                    $this->_error('Form error', $this->upload->display_errors());
                    return false;                  
                }
                else
                {
                    $data = array('upload_data' => $this->upload->data());                 
                }                     
                $userdata['image'] = $data['upload_data']['file_name'];
            }
            if($_POST['name']){
                $userdata['name'] = $_POST['name'];
            }
            if($_POST['cities']){
                $userdata['cities'] = $_POST['cities'];
            }
            if($_POST['skills']){
                $userdata['skills'] = $_POST['skills'];
            }
            if($_POST['charge']){
                $userdata['charge'] = $_POST['charge'];
            }
            if($_POST['experience']){
                $userdata['experience'] = $_POST['experience'];
            }
            
            // print_r($image);die();
            $result = $this->Core_Model->updateFields('users', $userdata, array('id' => $user_id));

            $user = $this->Core_Model->selectsinglerecord('users', '*', array('id' => $user_id) );            

            if(!$user){
                $this->_error('Form error', 'User not found.');
                return false;
            }



            $userdata = [];                
            $userdata['id'] = ($user->id) ? $user->id : '';
            $userdata['name'] = ($user->name) ? $user->name : '';
            $userdata['email'] = ($user->email) ? $user->email : '';
            $userdata['phone'] = ($user->contact) ? $user->contact : '';            
            $userdata['user_type'] = ($user->user_type) ? $user->user_type : ''; 
            $userdata['image'] = base_url('/upload/profile/').$user->image;

            $usercity = explode(',', $user->cities);
            foreach ($usercity as $key => $value) {
                $city[] = $this->Core_Model->selectsinglerecord('cities', 'id,title', array('id' => $value) );                                 
            }

            $userdata['cities'] = ($user->cities) ? $city : [];

            $userskills = explode(',', $user->skills);
            foreach ($userskills as $key => $value) {
                $skill[] = $this->Core_Model->selectsinglerecord('category', 'id,title', array('id' => $value) );                                 
            }

            $userdata['skills'] = ($user->skills) ? $skill : [];

            $userdata['charge'] = ($user->charge) ? $user->charge : '';               
            $userdata['experience'] = ($user->experience) ? $user->experience : '';               
            
            $reviewdata = $this->Core_Model->joindataResult('r.sender_id','u.id',array('r.receiver_id' => $user->id,'r.is_deleted'=>'0'),'r.*,u.id,u.name,u.image','review as r','users as u', 'r.id desc');
            //print_r($review);
            $rating = 0; $quality = 0; $availability = 0; $review = [];
            $ratingcount = 0; $qualitycount = 0; $availabilitycount = 0;
            foreach ($reviewdata as $key => $value) {
               # code...
               if($value['rating']){
                    $rating += $value['rating'];
                    $ratingcount++;
               }
               if($value['quality']){
                    $quality += $value['quality'];
                    $qualitycount++;
               }
               if($value['availability']){
                    $availability += $value['availability'];
                    $availabilitycount++;
               } 

               if($value['review']){
                    $review[] = ["user_id"=>$value['id'],"name"=>$value['name'],"review"=>$value['review'],'image'=>base_url('upload/profile/').$value['image']];
               }
            }

            
            //print_r($review); die;
            $userdata['rating'] = ($rating) ? ($rating/$ratingcount) : 0;  
            $userdata['quality'] = ($quality) ? ($quality/$qualitycount) : 0; 
            $userdata['availability'] = ($availability) ? ($availability/$availabilitycount) : 0;                         
            $userdata['review'] = $review; 
            
            if($user->user_type == 1){
                $total_projects = $this->Core_Model->selectRecord('job_post', '*', array('user_id' => $user->id,'is_deleted'=>'0','status'=>'3'));
            }else{
                $total_projects = $this->Core_Model->selectRecord('proposal', '*', array('user_id' => $user->id,'is_deleted'=>'0','status'=>'3'));
            }

            $userdata['projects'] = count($total_projects); 

            // $userdata['rating'] = '4';  
            // $userdata['quality'] = '4'; 
            // $userdata['availability'] = '5'; 
            // $userdata['projects'] = 3; 
            // $userdata['review'] = []; 
            
            
            $this->res->success = 'true';
            $this->res->data = $userdata;
            $this->res->message = 'Profile Updated Successfully';
            
        }else
        {           
            $this->_error('error', 'Invalid Accesstoken.');
        }
    
    $this->_output();
        exit();
    }
 //**************************************************************************************
    //**************************************************************************************
    function get_profile()
    {             
        $request = json_decode(rtrim(file_get_contents('php://input'), "\0"));
        $header = $this->input->request_headers();
        $accesstoken = $header['Accesstoken'];
        $user_id = ($request->user_id) ? $request->user_id : '';        
        if (!$user_id) {
                    $this->_error('Form error', 'User-Id is not specified.');
                    return false;
        }
        if($this->check_accesstoken($user_id,$accesstoken))
        {               

            $user = $this->Core_Model->selectsinglerecord('users', '*', array('id' => $user_id) );            

            if(!$user){
                $this->_error('Form error', 'User not found.');
                return false;
            }

            $userdata = [];                
            $userdata['id'] = ($user->id) ? $user->id : '';
            $userdata['name'] = ($user->name) ? $user->name : '';
            $userdata['email'] = ($user->email) ? $user->email : '';
            $userdata['phone'] = ($user->contact) ? $user->contact : '';            
            $userdata['user_type'] = ($user->user_type) ? $user->user_type : ''; 
            $userdata['image'] = base_url('/upload/profile/').$user->image;

            $usercity = explode(',', $user->cities);
            foreach ($usercity as $key => $value) {
                $city[] = $this->Core_Model->selectsinglerecord('cities', 'id,title', array('id' => $value) );                                 
            }

            $userdata['cities'] = ($user->cities) ? $city : [];

            $userskills = explode(',', $user->skills);
            foreach ($userskills as $key => $value) {
                $skill[] = $this->Core_Model->selectsinglerecord('category', 'id,title', array('id' => $value) );                                 
            }

            $userdata['skills'] = ($user->skills) ? $skill : [];
            
            $userdata['charge'] = ($user->charge) ? $user->charge : '';               
            $userdata['experience'] = ($user->experience) ? $user->experience : '';    

            $reviewdata = $this->Core_Model->joindataResult('r.sender_id','u.id',array('r.receiver_id' => $user->id,'r.is_deleted'=>'0'),'r.*,u.id,u.name,u.image','review as r','users as u', 'r.id desc');
            //print_r($review);
            $rating = 0; $quality = 0; $availability = 0; $review = [];
            $ratingcount = 0; $qualitycount = 0; $availabilitycount = 0;
            foreach ($reviewdata as $key => $value) {
               # code...
               if($value['rating']){
                    $rating += $value['rating'];
                    $ratingcount++;
               }
               if($value['quality']){
                    $quality += $value['quality'];
                    $qualitycount++;
               }
               if($value['availability']){
                    $availability += $value['availability'];
                    $availabilitycount++;
               } 

               if($value['review']){
                    $review[] = ["user_id"=>$value['id'],"name"=>$value['name'],"review"=>$value['review'],'image'=>base_url('upload/profile/').$value['image']];
               }
            }

            
            //print_r($review); die;
            $userdata['rating'] = ($rating) ? ($rating/$ratingcount) : 0;  
            $userdata['quality'] = ($quality) ? ($quality/$qualitycount) : 0; 
            $userdata['availability'] = ($availability) ? ($availability/$availabilitycount) : 0;                         
            $userdata['review'] = $review; 
            
            if($user->user_type == 1){
                $total_projects = $this->Core_Model->selectRecord('job_post', '*', array('user_id' => $user->id,'is_deleted'=>'0','status'=>'3'));
            }else{
                $total_projects = $this->Core_Model->selectRecord('proposal', '*', array('user_id' => $user->id,'is_deleted'=>'0','status'=>'3'));
            }

            $userdata['projects'] = count($total_projects); 
            
            $this->res->success = 'true';
            $this->res->data = $userdata;
            $this->res->message = 'Profile Listed Successfully';
            
        }else
        {           
            $this->_error('error', 'Invalid Accesstoken.');
        }
    
    $this->_output();
        exit();
    }
 //**************************************************************************************
    //**************************************************************************************
    function review()
    {   
        error_reporting(-1);
        ini_set('display_errors', 1);  
             
        $request = json_decode(rtrim(file_get_contents('php://input'), "\0"));
        $header = $this->input->request_headers();
        $accesstoken = $header['Accesstoken'];
        $user_id = ($request->user_id) ? $request->user_id : '';        
        if (!$user_id) {
                    $this->_error('Form error', 'User-Id is not specified.');
                    return false;
        }
        if($this->check_accesstoken($user_id,$accesstoken))
        {   
            $job_id = ($request->job_id) ? $request->job_id : '';  
            //$receiver_id = ($request->receiver_id) ? $request->receiver_id : '';  
            $review = ($request->review) ? $request->review : '';        
            $rating = ($request->rating) ? $request->rating : '0';  
            $quality = ($request->quality) ? $request->quality : '0';  
            $availability = ($request->availability) ? $request->availability : '0';  
            if (!$job_id) {
                        $this->_error('Form error', 'Job id is not specified.');
                        return false;
            }
            // if (!$receiver_id) {
            //             $this->_error('Form error', 'Receiver id is not specified.');
            //             return false;
            // }
            if (!$review) {
                        $this->_error('Form error', 'Review is not specified.');
                        return false;
            }
            if (!$rating) {
                        $this->_error('Form error', 'Rating is not specified.');
                        return false;
            }
            if (!$quality) {
                        $this->_error('Form error', 'Quality is not specified.');
                        return false;
            }
            if (!$availability) {
                        $this->_error('Form error', 'Availability is not specified.');
                        return false;
            }
            
            $user = $this->Core_Model->selectsinglerecord('users', '*', array('id' => $user_id) );            
            $job = $this->Core_Model->selectsinglerecord('job_post', '*', array('id' => $job_id,'status'=>3) );                        
            $proposal = $this->Core_Model->selectsinglerecord('proposal', '*', array('job_id' => $job_id,'status'=>3) ); 

            if(!$job){
                $this->_error('Form error', 'You can not rate on this job.');
                return false;
            }

            if($user && $user->user_type == 1){
                if($job->user_id !=  $user_id){
                    $this->_error('Form error', 'You are not authorize to rate this bricoleur on this job.');
                    return false;
                }
                $review_data = $this->Core_Model->selectsinglerecord('review', '*', array('sender_id' => $user_id,'job_id'=>$job_id) );
                
                if($review_data){
                    $this->_error('Form error', 'You have already rated this bricoleur on this job.');
                    return false;   
                }
                $this->Core_Model->InsertRecord('review', ["rating" => $rating, "quality" => $quality, "availability" => $availability,
                                                    "review"=>$review, "sender_id" => $user_id, "receiver_id" => $proposal->user_id, "job_id"=>$job_id]);

            }else{
                if($proposal->user_id !=  $user_id){
                    $this->_error('Form error', 'You are not authorize to rate this user on this job.');
                    return false;
                }
                $review_data = $this->Core_Model->selectsinglerecord('review', '*', array('sender_id' => $user_id,'job_id'=>$job_id) );                        
                if($review_data){
                    $this->_error('Form error', 'You have already rated this user on this job.');
                    return false;   
                }
                $this->Core_Model->InsertRecord('review', ["rating" => $rating, "quality" => $quality, "availability" => $availability,
                                                    "review"=>$review, "sender_id" => $user_id, "receiver_id" => $job->user_id, "job_id"=>$job_id]);
            }                        

            $this->res->success = 'true';            
            $this->res->message = 'You have rated successfully';
            
        }else
        {           
            $this->_error('error', 'Invalid Accesstoken.');
        }
    
    $this->_output();
        exit();
    }
 //**************************************************************************************
      //********************************************************************************************
  public function chat_history()
    { 
        $request = json_decode(rtrim(file_get_contents('php://input'), "\0"));
        $header = $this->input->request_headers();            
        $accesstoken = $header['Accesstoken'];
        $user_id = isset($request->user_id) ? $request->user_id : '';         
        if (!$user_id) {
                    $this->_error('Form error', 'User-Id is not specified.');
                    return false;
        }
        if($this->check_accesstoken($user_id,$accesstoken))
        {               
            $bricoler_id = isset($request->bricoler_id) ? $request->bricoler_id : '';                      
            if(!$bricoler_id){
                $this->_error('Form error', 'Bricoler Id is not specified.');
                return false;
            }
            
            $chat = $this->Core_Model->selectRecord('chat_history', '*', array('sender_id'=>$user_id,'receiver_id'=>$bricoler_id));

            if(empty($chat)){
                $this->Core_Model->InsertRecord('chat_history', array('sender_id'=>$user_id,'receiver_id'=>$bricoler_id));
                $this->Core_Model->InsertRecord('chat_history', array('sender_id'=>$bricoler_id,'receiver_id'=>$user_id));
            }
            
                
                $this->res->success = 'true';                
                $this->res->message = 'Inserted Successfully';                
        }else
        {            
            $this->_error('error', 'Invalid Accesstoken.');
        }  
        $this->_output();
        exit();
        
    }

    public function inbox()
    { 
        $request = json_decode(rtrim(file_get_contents('php://input'), "\0"));
        $header = $this->input->request_headers();            
        $accesstoken = $header['Accesstoken'];
        $user_id = isset($request->user_id) ? $request->user_id : '';         
        if (!$user_id) {
                    $this->_error('Form error', 'User-Id is not specified.');
                    return false;
        }
        if($this->check_accesstoken($user_id,$accesstoken))
        {                          
            
            $chat = $this->Core_Model->selectRecord('chat_history', '*', array('receiver_id'=>$user_id));

            $inbox = [];
            if(!empty($chat)){
                foreach($chat as $row){                    
                    $user = $this->Core_Model->selectsinglerecord('users', '*', array('id'=>$row['sender_id']));
                    $inbox['user_id'] = $user->id;
                    $inbox['name'] = $user->name;
                    $inbox['image'] = base_url('upload/profile/').$user->image;                    
                }
            }
            
                
                $this->res->success = 'true';
                $this->res->data = $inbox;                
                $this->res->message = 'Listed Successfully';                
        }else
        {            
            $this->_error('error', 'Invalid Accesstoken.');
        }  
        $this->_output();
        exit();
        
    }
//**************************************************************************************************** 
     function getRating($value='')
     {
         # code...
     }


    function _output() {

        // header('Content-Type: application/json');

        //$this->res->request = $this->req->request;

        $this->res->datetime = date('Y-m-d\TH:i:sP');

        echo json_encode($this->res);

    }

 //**************************************************************************************

    function _error($error, $reason, $code = null) {

        // header('Content-Type: application/json');

        // $this->res->status = 'false';

        $this->res->success = 'false';

        // if (isset($this->req->request)) {

        //     $this->res->request = $this->req->request;

        // }

        $this->res->message = $reason;

        $this->res->datetime = date('Y-m-d\TH:i:sP');

        echo json_encode($this->res);

        die();

    } 


  //*************************************************************************************   
    function push_notification_android($device_id,$message,$notification_id){

        //API URL of FCM
        $url = 'https://fcm.googleapis.com/fcm/send';

        //api_key available in:
        $api_key = 'AAAA8pvacLc:APA91bFWwDrWBwwnBm4oJS6WD_XE5hMbvZc4RwVieOIo-LQQ4FgCRi7kvfvjAcpA9r_Zlt4Vw9yum_zCqnXjIJQQR-uy84Lwi6grWHdvVYBUEZvhrVDLIOQGQ66gX26ns6HIiIYAexOK';
                    
        $fields = array (
            'registration_ids' => array (
                    $device_id
            ),
            'data' => array (
                    "message" => $message
            )
        );

        //header includes Content type and api key
        $headers = array(
            'Content-Type:application/json',
            'Authorization:key='.$api_key
        );
                    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('FCM Send Error: ' . curl_error($ch));
        }
        curl_close($ch);
        $this->Core_Model->InsertRecord('notification_logs', array('data'=>$result,'notification_id'=>$notification_id,'message'=>$message));
        // echo $notification_id;
        // echo $this->db->last_query();
        // print_r($result); die;

        return $result;
    }

}





