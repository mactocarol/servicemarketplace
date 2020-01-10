<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Api1 extends MY_Controller  {    
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
        $name = $request->name; 
        $email = $request->email;
        $password = $request->password; 
        $contact = $request->phone;
        $cities = $request->cities;        
        $skills = $request->skills;        
        $user_type = $request->user_type;
        $last_login = date("Y-m-d H:i:s");        
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
        if (!$user_type) {
        $this->_error('Form error', 'User Type is not specified.');
        return false;
        }
        if ($this->email_check($email)) {
        $this->_error('Form error', 'Email already exists.');
        return false;
        }
            $where = array('name'=>$name,'email'=>$email,'password'=>md5($password),'last_login'=>$last_login,'contact'=>$contact, 'skills' => $skills, 'cities' => $cities, 'user_type' => $user_type);            
            $get_email = $this->Core_Model->InsertRecord('users', $where);    


            $where_login = array('email' => $email);
            $array_login = $this->Core_Model->selectsinglerecord('users', '*', $where_login);            
             if(!empty($array_login)) 
             { 
                $to = $email;
                $activation_code =  $this->generateRandomString();
                $subject = "Please Verify Your Account on ServiceMarketPlace";            
                $msg = "Please Verify Your Account. This is your OTP to verify your account :"." ".$activation_code;           
                $email = $this->email($to, $subject, $msg);

                $accesstoken = base64_encode(uniqid()); //other type for getting random no
                $is_login='1';
                $where_update = array('email' => $email);
                $field_update = array('token'=>$accesstoken,'is_login'=>$is_login);                 
                $this->Core_Model->updateFields('users', $field_update, $where_update);                
                $array_login2 = $this->Core_Model->selectsinglerecord('users', 'id,name,email,contact,gender,dob,image,skills,cities,skills,token,is_login,last_login,user_type', $where_login);

                $array_login2->image = base_url('upload/profile/').$array_login2->image; //image url get code

                $result = [];
                $result['id'] = ($array_login2->id) ? $array_login2->id : '';
                $result['name'] = ($array_login2->name) ? $array_login2->name : '';
                $result['email'] = ($array_login2->email) ? $array_login2->email : '';
                $result['contact'] = ($array_login2->contact) ? $array_login2->contact : '';
                $result['gender'] = ($array_login2->gender) ? $array_login2->gender : '';
                $result['dob'] = ($array_login2->dob) ? $array_login2->dob : '';
                $result['image'] = ($array_login2->image) ? $array_login2->image : '';
                $result['token'] = ($array_login2->token) ? $array_login2->token : '';
                $result['is_login'] = ($array_login2->is_login) ? $array_login2->is_login : '';
                $result['last_login'] = ($array_login2->last_login) ? $array_login2->last_login : '';
                $skills = [];
                if($array_login2->skills){
                  foreach(explode(',',$array_login2->skills) as $row){                
                    $skill = $this->Core_Model->selectsinglerecord('skills', 'title', array("id"=>$row,"is_deleted"=>0,"status"=>1));             
                    $skills[] = ['name'=>$skill->title];
                  }
                }
                $result['skills'] = $skills;

                $cities = [];
                if($array_login2->cities){
                  foreach(explode(',',$array_login2->cities) as $row){                
                    $city = $this->Core_Model->selectsinglerecord('cities', 'title', array("id"=>$row,"is_deleted"=>0,"status"=>1));             
                    $cities[] = ['name'=>$city->title];
                  }
                }
                $result['cities'] = $cities; 

                if (!empty($get_email)) {
                $this->res->success = 'true';
                $this->res->data = $result;
                $this->res->message = "User Registered Successfully";                    
                    //return true;
            }
        }
           $this->_output();
            exit();
        }
//---------------------*-------------------
    function email_check($email) {
        $where = array('email' => $email);
        $field = 'email';      
        $get_email = $this->Core_Model->SelectSingleRecord('users', $field, $where);    
        if (!empty($get_email)) {
             return true;
        }
         return false;
    }
//*********************************************************************************************************
    public function signin()
    {
        $request = json_decode(rtrim(file_get_contents('php://input'), "\0"));
        $email = $request->email;
        $password = $request->password;        
        // print_r($this->input->request_headers());die();        
        if (!$email) {
            $this->_error('Form error', 'Email-Id is not specified.');
        }
        if (!$password) {
            $this->_error('Form error', 'Password is not specified.');
        }
         $where_login = array('email' => $email, 'password' => md5($password));
         $array_login = $this->Core_Model->selectsinglerecord('users', '*', $where_login);            
         if(empty($array_login)) {            
            $this->_error('error', 'Incorrect Email Id & Password.');
        } else {
            // $id=$aray_login['id'];
            // $accesstoken = base64_encode(random_bytes(32));
            $accesstoken = base64_encode(uniqid()); //other type for getting random no
            $is_login='1';            
            $where_update = array('email' => $email);
            $field_update = array('token'=>$accesstoken,'is_login'=>$is_login);            
            $this->Core_Model->updateFields('users', $field_update, $where_update);
            $this->res->success = 'true';
            $array_login2 = $this->Core_Model->selectsinglerecord('users', 'id,name,email,contact,gender,dob,image,skills,cities,token,is_login,last_login,user_type', $where_login);
            $array_login2->image = base_url('upload/profile/').$array_login2->image; //image url get code
            $result = [];
            $result['id'] = ($array_login2->id) ? $array_login2->id : '';
            $result['name'] = ($array_login2->name) ? $array_login2->name : '';
            $result['email'] = ($array_login2->email) ? $array_login2->email : '';
            $result['contact'] = ($array_login2->contact) ? $array_login2->contact : '';
            $result['gender'] = ($array_login2->gender) ? $array_login2->gender : '';
            $result['dob'] = ($array_login2->dob) ? $array_login2->dob : '';
            $result['image'] = ($array_login2->image) ? $array_login2->image : '';
            $result['token'] = ($array_login2->token) ? $array_login2->token : '';
            $result['is_login'] = ($array_login2->is_login) ? $array_login2->is_login : '';
            $result['last_login'] = ($array_login2->last_login) ? $array_login2->last_login : '';            
            $result['user_type'] = $array_login2->user_type; 
            $skills = [];
            if($array_login2->skills){
              foreach(explode(',',$array_login2->skills) as $row){                
                $skill = $this->Core_Model->selectsinglerecord('skills', 'title', array("id"=>$row,"is_deleted"=>0,"status"=>1));             
                $skills[] = ['name'=>$skill->title];
              }
            }
            $result['skills'] = $skills;

            $cities = [];
            if($array_login2->cities){
              foreach(explode(',',$array_login2->cities) as $row){                
                $city = $this->Core_Model->selectsinglerecord('cities', 'title', array("id"=>$row,"is_deleted"=>0,"status"=>1));             
                $cities[] = ['name'=>$city->title];
              }
            }
            $result['cities'] = $cities; 
            $this->res->data = $result;
            $this->res->success = 'true';
            $this->res->message = "User Login Successfully";
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
    function generateRandomString()  {
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
        $this->email->from('servicemarketplace.com', 'Service Market Place');
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
            // $field_update = array('accesstoken'=>0,'is_user_login'=>0);
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
     public function userJobPost()
    { 
        $request = json_decode(rtrim(file_get_contents('php://input'), "\0"));
        $header = $this->input->request_headers();            
        $accesstoken = $header['Accesstoken'];
        $user_id = $_POST['user_id'];         
        if($this->check_accesstoken($user_id,$accesstoken))
        {
            $service_id = $_POST['service_id'];
            $job_title = $_POST['job_title'];
            $description = $_POST['description'];
            $date_time = $_POST['date_time'];
            $address = $_POST['address'];
            $skills = $_POST['skills'];
            $budget = $_POST['budget'];
            $budget_amount = $_POST['budget_amount'];
            $skills = $_POST['skills'];
            $attachment = $_FILES['attachment'];
            // print_r($attachment);die();            
             if (!$user_id) {
                        $this->_error('Form error', 'User Id is not specified.');
                        return false;
            }
             if (!$service_id) {
                        $this->_error('Form error', 'Service Id is not specified.');
                        return false;
            }
            if (!$job_title) {
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
            if (!$address) {
                        $this->_error('Form error', 'Address is not specified.');
                        return false;
            }    
             if (!$attachment) {
                        $this->_error('Form error', 'Attachment File is not specified.');
                        return false;
            }   
             if (!$budget) {
                        $this->_error('Form error', 'Budget is not specified.');
                        return false;
            }  
            if (!$budget_amount) {
                        $this->_error('Form error', 'Budget amount is not specified.');
                        return false;
            }
            if (!$skills) {
                        $this->_error('Form error', 'Skills is not specified.');
                        return false;
            }
            $config['upload_path']          = './upload/profile/';
            $config['allowed_types']        = 'gif|jpg|png|jfif|jpeg';
            // $config['max_size']             = 1000;
            // $config['max_width']            = 1024;
            // $config['max_height']           = 768;
            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload('attachment'))
            {
                    $error = array('error' => $this->upload->display_errors());
                    // $this->load->view('upload_form', $error);
            }
            else
            {
                    $data = array('upload_data' => $this->upload->data());
                    // print_r($data);die();
                    // $this->load->view('upload_success', $data); update query
            }     
            // $image = $data->upload_data['file_name'];
            $user = $this->Core_Model->selectsinglerecord('users', '*', array("id",$user_id));             
            if($user && $user->user_type == 1){
                $attachment = $data['upload_data']['file_name'];
                $where = array('user_id'=>$user_id,'service_id'=>$service_id,'job_title'=>$job_title,'description'=>$description,'date_time'=>$date_time,'address'=>$address,'ufile'=>$attachment,'budget'=>$budget,'budget_amount'=>$budget_amount,'skills'=>$skills,'status'=>1);            
                $get_data = $this->Core_Model->InsertRecord('job_post', $where);

                if (empty($get_data))
                {
                    $this->res->success = 'false';
                    $this->res->message = "Incorrect data";
                }
                else
                {
                    $this->res->success = 'true';
                    $this->res->message = 'Job posted Successfully';                
                }    
            }else{
                $this->res->success = 'false';
                $this->res->message = "Invalid access";
            }

             
        }else
        {            
            $this->_error('error', 'Invalid Accesstoken.');
        }  
        $this->_output();
        exit();
    }
//********************************************************************************************************   
    public function userJobList()
    { 

        $request = json_decode(rtrim(file_get_contents('php://input'), "\0")); 

        $res = $this->Core_Model->joindataResult($place1 =' job_post.service_id', $place2 = 'category.id',$where='','job_post.user_id,job_post.service_id,job_post.id,job_post.description,job_post.budget,category.id,category.title','category','job_post',$order='');

        $userdata = [];
        foreach ($res as $key => $value)
        {

            $arr[]  = ['id'=>($value['id']) ? $value['id'] : '','user_id'=>($value['user_id']) ? $value['user_id'] : '','service_id'=>($value['service_id']) ? $value['service_id'] : '','description'=>($value['description']) ? $value['description'] : '','budget'=>($value['budget']) ? $value['budget'] : '','title' => ($value['title']) ? $value['title'] : ''];
        }    
 
        if (empty($res)) 
        {
            $this->res->success = 'false';
            $this->_error('error', 'Jobs is not available.');
        } 
        else
        { 
            $this->res->success = 'true';
            $this->res->data = $arr;
            // $array_data1->image = base_url('upload/category/').$array_data1->image; //image code
        }  
        $this->_output();
          exit();
    }    
//*********************************************************************************************************
 public function myProject()
    { 

        $request = json_decode(rtrim(file_get_contents('php://input'), "\0")); 

        $res = $this->Core_Model->joindataResult($place1 =' job_post.service_id', $place2 = 'category.id',$where='','job_post.user_id,job_post.service_id,job_post.id as jobpostid,job_post.description,job_post.budget_amount,job_post.day,job_post.status,category.id,category.title','category','job_post',$order='');

        $userdata = [];
        foreach ($res as $key=>$total) 
        {           
            $job_post_id = $total['jobpostid'];            
            $where3 = array('job_post_id' => $job_post_id);
            $result3 = $this->Core_Model->SelectRecord('proposal', '*', $where3, $order = '');                        
             $bid = 0;
            if(count($result3)){
            $bid = count($result3);            
                }
            $arr[]  = ['id'=>($total['id']) ? $total['id'] : '','user_id'=>($total['user_id']) ? $total['user_id'] : '','service_id'=>($total['service_id']) ? $total['service_id'] : '','description'=>($total['description']) ? $total['description'] : '','average budget'=>($total['budget_amount']) ? $total['budget_amount'] : '','day'=>($total['day']) ? $total['day'] : '','bid'=>$bid ? $bid : '','skills' => ($total['title']) ? $total['title'] : '','project status' => ($total['status']) ? $total['status'] : ''];      
        }
 
        if (empty($res)) 
        {
            $this->res->success = 'false';
            $this->_error('error', 'Jobs is not available.');
        } 
        else
        { 
            $this->res->success = 'true';
            $this->res->data = $arr;
            // $array_data1->image = base_url('upload/category/').$array_data1->image; //image code
        }  
        $this->_output();
          exit();
    }  
//**************************************************************************************************************    
   public function category() 
    { 
        $categories2 = $this->MY_Model->SelectRecord('category','*',$udata=array("is_deleted"=>"0","parent_id"=>"0"),'order_id asc');            
            $cname = [];
            $level = 1; 
    
            foreach ($categories2 as $key => $value)
            {
                $cname[$value['title']][] = ['id'=>$value['id'], 'cname'=>$value['title'],'level'=>$value['level']];
    
                 $arr[] = ['id'=>$value['id'],'cname'=>$value['title'],'description'=>$value['description'],'image' => base_url('upload/category/').$value['image']];
    
                $cat = $this->MY_Model->SelectRecord('category','*',$udata=array("is_deleted"=>"0","parent_id"=>$value['id']),'order_id asc');  

                foreach ($cat as $key => $result) 
                {
                    $parent_id = $result['id']; 
    
                    $cname[$value['title']][$result['id']][] = ['id'=>$result['id'], 'parent_id'=>$result['parent_id'],'cname'=>$result['title'],'level'=>$result['level'],'order_id'=>$result['order_id']];
                    
                    // $arr[] = ['id'=>$result['id'], 'parent_id'=>$result['parent_id'], 'cname'=>$result['title'],'level'=>$result['level'],'order_id'=>$result['order_id'],'description'=>$result['description'],'image' => base_url('upload/category/').$value['image'],'icon'=>$result['icon']];

                    $arr[] = ['id'=>$result['id'],'cname'=>$result['title'],'description'=>$result['description'],'image' => base_url('upload/category/').$value['image']];
    
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
                                       
                                     $arr[]  = ['id'=>$data['id'],'cname'=>$data['title'],'description'=>$data['description'],'image' => base_url('upload/category/').$value['image']];                               
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

            $skills = $this->MY_Model->SelectRecord('skills','*',array("is_deleted"=>"0"),'id asc');  
            $skill_arr = [];          
            foreach ($skills as $skill) {
                $skill_arr[] = array("id"=>$skill['id'],"title"=>$skill['title']);
            }

            $cities = $this->MY_Model->SelectRecord('cities','*',array("is_deleted"=>"0"),'id asc');  
            $city_arr = [];          
            foreach ($cities as $city) {
                $city_arr[] = array("id"=>$city['id'],"title"=>$city['title']);
            }

            $result_set  = array("categories"=>$arr,"skills"=>$skill_arr,"cities"=>$city_arr); 
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
            }
            $this->_output();
              exit();            
    }
//*********************************************************************************************************  
     public function viewProposal()
    { 
        $request = json_decode(rtrim(file_get_contents('php://input'), "\0"));        
        $header = $this->input->request_headers();
        $id = $request->job_id;    
        $user_id = $request->user_id;    
        $accesstoken = $header['Accesstoken'];
        if($this->check_accesstoken($user_id,$accesstoken))
        { 
            $where = array('id' => $id);               
            $jresult = $this->Core_Model->selectsinglerecord('job_post', 'status,service_provider_id,proposal_id,skills', $where);             
            if ($jresult->status == 1) { $status = 1; $stts = 1; }
            else  {  $status = 3; $stts = 3; } 

            $job_detail = $this->Core_Model->selectsinglerecord('job_post','*',array("id"=>$id),'id asc');

            $skills = $job_detail->skills;
            $skills = explode(',',$skills); 
            $myskill = "";
            foreach ($skills as $value2)
            {               
                $skill = $this->Core_Model->selectsinglerecord('skills','title',array('id' => $value2));
                if($skill){
                    $myskill .= $skill->title.','; 
            // print_r($myskill);die();
                }
            }

            $now = time(); // or your date as well
            $your_date = strtotime($job_detail->date_time);
            $datediff = $your_date - $now;
            $datediff = round($datediff / (60 * 60 * 24));
            if ($datediff<=0) {
            $datediff = 0;            
            }          

            $jobDetail = [ "id" => $job_detail->id,
                            "title"=>$job_detail->job_title,
                            "description"=>$job_detail->description,
                            "project_budget"=>$job_detail->budget_amount,
                            "delivery_address"=>$job_detail->address,
                             "skills"=>rtrim($myskill,','),
                             "ends_on"=>$datediff.' days'
                         ];

            $res = $this->MY_Model->SelectRecord('proposal','*',$udata=array("is_deleted"=>"0","job_post_id"=>$id),'id asc');
            $arr = [];
            foreach ($res as $key => $value)
            {               
                $user_id = $value['user_id'];
                $where = array('id' => $user_id);               
                $presult = $this->Core_Model->selectsinglerecord('users', 'name,image,id', $where);               

                $where2 = array('receiverId' => $presult->id,'job_post_id' => $id);
                $trating = $this->Core_Model->selectsinglerecord('review', 'rating', $where2);
                $rating = $trating->rating;   

                if ($jresult->proposal_id == $value['id']) { $status = 2; } 
                else{
                     $status = $stts;
                }             

                $arr[]  = ['id'=>($value['id']) ? $value['id'] : '','job_post_id'=>($value['job_post_id']) ? $value['job_post_id'] : '','user_id'=>($value['user_id']) ? $value['user_id'] : '','name'=>$presult->name ? $presult->name : '','image'=>($presult->image? base_url('upload/profile/').$presult->image : ''),'description'=>($value['description']) ? $value['description'] : '','bid_value'=>($value['bid_value']) ? $value['bid_value'] : '','day' => ($value['day']) ? $value['day'] : '','rating' => $trating->rating ? $trating->rating : '','status' => $status];                                   
            }
            if (empty($jobDetail)) 
            {
                $this->res->success = 'false';
                $this->_error('error', 'Jobs is not available.');
            } 
            else
            { 
                $this->res->success = 'true';
                $this->res->data = $arr;
                $this->res->job_detail = $jobDetail;                
                $this->res->message = 'Proposal View Get Successfully';               
            }  

        }else
        {           
            $this->_error('error', 'Invalid Accesstoken.');
        }  
        $this->_output();
        exit();
    }
//*********************************************************************************************************   
    function update_profile()
     { 
        $flag = 0;
        $request = json_decode(rtrim(file_get_contents('php://input'), "\0"));
        $header = $this->input->request_headers();
        $user_id = $_POST['user_id'];    
        $accesstoken = $header['Accesstoken'];        
        if($this->check_accesstoken($user_id,$accesstoken))
        {            
            $name = $_POST['name']; 
            $complete = '5';//$_POST['complete'];
            $on_budget_rate = '70%';//$_POST['on_budget_rate'];
            $on_time_rate = '85%';//$_POST['on_time_rate'];
            $repeat_hire_rate = '30%';//$_POST['repeat_hire_rate'];                      

            $field_update = [];
            if(isset($_FILES['image']) && $_FILES['image']){
                $image = $_FILES['image'];
                 // print_r($image);die();                            
                $config['upload_path']          = './upload/profile/';
                $config['allowed_types']        = 'gif|jpg|png|jfif|jpeg';
                $config['max_size']             = 1000;
                // $config['max_width']            = 1024;
                // $config['max_height']           = 768;
                $this->load->library('upload', $config);
                if ( ! $this->upload->do_upload('image'))
                {
                        $error = array('error' => $this->upload->display_errors());
                        $flag = 1;
                }
                else
                {
                        $data = array('upload_data' => $this->upload->data());
                        //print_r($data);die();  
                        $image = $data['upload_data']['file_name'];    
                        $field_update['image']  = $image;                      
                }                    
                
            }    
            
            if($_POST['name']){
                $field_update['name']  = $_POST['name'];  
            }

            if($_POST['about']){
                $field_update['about']  = $_POST['about'];  
            }

            if($_POST['skills']){
                $field_update['skills']  = $_POST['skills'];         
            }

            if($_POST['cities']){
                $field_update['cities']  = $_POST['cities'];         
            }    
                   
            $where_update = array('id' => $user_id);            
            $result = $this->Core_Model->updateFields('users', $field_update, $where_update);
            
            $where_login = array('id' => $user_id); 
            $total = $this->Core_Model->selectsinglerecord('users', '*', $where_login);             
            
            $total->image = base_url('upload/profile/').$total->image; //image url get code
            $result = [];
            $result['id'] = ($total->id) ? $total->id : '';
            $result['name'] = ($total->name) ? $total->name : '';
            $result['user_type'] = $total->user_type;
            $result['complete'] = ($total->complete) ? $total->complete : '';
            $result['on_budget_rate'] = ($total->on_budget_rate) ? $total->on_budget_rate : '';
            $result['on_time_rate'] = ($total->on_time_rate) ? $total->on_time_rate : '';
            $result['repeat_hire_rate'] = ($total->repeat_hire_rate) ? $total->repeat_hire_rate : '';
            $result['about'] = ($total->about) ? $total->about : '';
            $result['image'] = ($total->image) ? $total->image : '';

            $skills = [];
            if($total->skills){
              foreach(explode(',',$total->skills) as $row){                
                $skill = $this->Core_Model->selectsinglerecord('skills', 'title', array("id"=>$row,"is_deleted"=>0,"status"=>1));             
                $skills[] = ['name'=>$skill->title];
              }
            }
            $result['skills'] = $skills;

            $cities = [];
            if($total->cities){
              foreach(explode(',',$total->cities) as $row){                
                $city = $this->Core_Model->selectsinglerecord('cities', 'title', array("id"=>$row,"is_deleted"=>0,"status"=>1));             
                $cities[] = ['name'=>$city->title];
              }
            }
            $result['cities'] = $cities;

            $myreviews = $this->Core_Model->SelectRecord('review', '*', array('receiverId' => $user_id), 'reviewId desc');  
            
            $reviews = [];
            foreach ($myreviews as $key => $review) {                             
                $reslt = $this->Core_Model->selectsinglerecord('users', '*', array("id"=>$review['receiverId']));              
                $reviews[] = ['id'=>$reslt->id,'name'=>$reslt->name,'image'=>base_url('upload/profile/').$reslt->image,'review'=>$review['review'],'rating'=>$review['rating']];
            }
            $result['reviews'] = $reviews;             
               
            if (empty($result))
            {
                $this->res->success = 'false';
                $this->res->message = "Incorrect data";
            }
            else
            {
                if($flag == 1){
                    $this->res->success = 'false';
                    $this->res->message = "Invalid Image (type)";                    
                }else{
                $this->res->success = 'true';
                $this->res->message = 'Update Profile Successfully';
                $this->res->data = $result;
                }
            }  
        }else
        {           
            $this->_error('error', 'Invalid Accesstoken.');
        }  
    $this->_output();
        exit();
    }
//*********************************************************************************************************    
    function get_profile()
     { 
        $request = json_decode(rtrim(file_get_contents('php://input'), "\0"));
        $header = $this->input->request_headers();
        $user_id = $request->user_id;    
        $accesstoken = $header['Accesstoken'];
         // print_r($accesstoken);die();
        if($this->check_accesstoken($user_id,$accesstoken))
        {
            $where_login = array('id' => $user_id); 
            $total = $this->Core_Model->selectsinglerecord('users', '*', $where_login); 
            $total->image = base_url('upload/profile/').$total->image; //image url get code
            $result = [];
            $result['id'] = ($total->id) ? $total->id : '';
            $result['name'] = ($total->name) ? $total->name : '';
            $result['email'] = ($total->email) ? $total->email : '';
            $result['user_type'] = $total->user_type;
            $result['complete'] = ($total->complete) ? $total->complete : '';
            $result['on_budget_rate'] = ($total->on_budget_rate) ? $total->on_budget_rate : '';
            $result['on_time_rate'] = ($total->on_time_rate) ? $total->on_time_rate : '';
            $result['repeat_hire_rate'] = ($total->repeat_hire_rate) ? $total->repeat_hire_rate : '';
            $result['about'] = ($total->about) ? $total->about : '';
            $result['image'] = ($total->image) ? $total->image : '';
            $skills = [];
            if($total->skills){
              foreach(explode(',',$total->skills) as $row){                
                $skill = $this->Core_Model->selectsinglerecord('skills', 'title', array("id"=>$row,"is_deleted"=>0,"status"=>1));             
                $skills[] = ['name'=>$skill->title];
              }
            }
            $result['skills'] = $skills;

            $cities = [];
            if($total->cities){
              foreach(explode(',',$total->cities) as $row){                
                $city = $this->Core_Model->selectsinglerecord('cities', 'title', array("id"=>$row,"is_deleted"=>0,"status"=>1));             
                $cities[] = ['name'=>$city->title];
              }
            }
            $result['cities'] = $cities;
            $myreviews = $this->Core_Model->SelectRecord('review', '*', array('receiverId' => $user_id), 'reviewId desc');  
            
            $reviews = [];
            foreach ($myreviews as $key => $review) {                             
                $reslt = $this->Core_Model->selectsinglerecord('users', '*', array("id"=>$review['receiverId']));              
                $reviews[] = ['id'=>$reslt->id,'name'=>$reslt->name,'image'=>base_url('upload/profile/').$reslt->image,'review'=>$review['review'],'rating'=>$review['rating']];
            }
            $result['reviews'] = $reviews;  

            if (empty($result))
            {
                $this->res->success = 'false';
                $this->res->message = "Incorrect data";
            }
            else
            {
                $this->res->success = 'true';
                $this->res->message = 'Profile Listed Successfully';
                $this->res->data = $result;
            }  
        }else
        {            
            $this->_error('error', 'Invalid Accesstoken.');
        }  
    $this->_output();
        exit();
    }
//*****************************************************************************************************    
   function reviewRatePost()
    { 
        $request = json_decode(rtrim(file_get_contents('php://input'), "\0"));
        $header = $this->input->request_headers();         
        $accesstoken = $header['Accesstoken'];
        $user_id = $request->user_id;         
        if($this->check_accesstoken($user_id,$accesstoken))
        {        
            $request = json_decode(rtrim(file_get_contents('php://input'), "\0"));
            $job_post_id = $request->job_id;
            $review = $request->review;
            $rating = $request->rating;            
            
            if (!$job_post_id) {
            $this->_error('Form error', 'Job Post Id is not specified.');
            return false;
            }
            if (!$rating) {
            $this->_error('Form error', 'Rating is not specified.');
            return false;
            }
            if ($job_post_id) {
                $where1 = array('id'=>$job_post_id);
                $return = $this->Core_Model->selectsinglerecord('job_post', 'user_id,service_provider_id', $where1);
            }

            $where = array('senderId'=>$return->user_id,'receiverId'=>$return->service_provider_id,'review'=>$review,'rating'=>$rating,'job_post_id'=>$job_post_id); 
            $treview = $this->Core_Model->InsertRecord('review', $where);

            if (empty($treview)) 
            {
                $this->res->success = false;
                $this->_error('error', 'Incorrect id or data.');
            } else
             {
                $this->res->success = 'true';                
                $this->res->message = 'Rating added Successfully';
            }
        }else
        {            
            $this->_error('error', 'Invalid Accesstoken.');
        }  
            $this->_output();
            exit();
    }
//***********************************************************************************************************
     function profile_image()
    { 
        $request = json_decode(rtrim(file_get_contents('php://input'), "\0"));
        $header = $this->input->request_headers();
        $accesstoken = $header['Accesstoken'];
        $user_id = $_POST['user_id'];        

        if($this->check_accesstoken($user_id,$accesstoken))
        {   
            $image = $_FILES['image'];                                     
    
            $config['upload_path']          = './upload/profile/';
            $config['allowed_types']        = 'gif|jpg|png/jfif';
            $config['max_size']             = 1000;
            // $config['max_width']            = 1024;
            // $config['max_height']           = 768;
            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload('image'))
            {
                $error = array('error' => $this->upload->display_errors());
               
            }
            else
            {
                $data = array('upload_data' => $this->upload->data());
                // print_r($data);die();
                // $this->load->view('upload_success', $data); update query
            }     
            // $image = $data->upload_data['file_name'];
            $image = $data['upload_data']['file_name'];
            // print_r($image);die();
            $where_login = array('id' => $user_id);        
            $where_update = array('id' => $user_id);
            $field_update = array('image' => $image);
            $result = $this->Core_Model->updateFields('users', $field_update, $where_update);

            $total = $this->Core_Model->selectsinglerecord('users', 'id,name,contact,gender,dob,password,about,image,is_login,last_login', $where_login);            
            $total->image = base_url('/upload/profile/').$total->image; //image url get code
            $result = [];
            $result['id'] = ($total->id) ? $total->id : '';
            $result['name'] = ($total->name) ? $total->name : '';
            // $result['email'] = ($total->email) ? $total->email : '';
            $result['contact'] = ($total->contact) ? $total->contact : '';
            $result['gender'] = ($total->gender) ? $total->gender : '';
            $result['dob'] = ($total->dob) ? $total->dob : '';
            $result['password'] = ($total->password) ? $total->password : '';
            $result['about'] = ($total->about) ? $total->about : '';
            $result['image'] = ($total->image) ? $total->image : '';
            $result['is_login'] = ($total->is_login) ? $total->is_login : '';
            $result['last_login'] = ($total->last_login) ? $total->last_login : '';               

            $this->res->data = $result;
            if (empty($result))
            {
                $this->res->success = 'false';
                $this->res->message = "Incorrect data";
            }
            else
            {
                $this->res->success = 'true';
                $this->res->message = 'Profile Image Updated Successfully';
                $this->res->data = $result;
            }
        }else
        {           
            $this->_error('error', 'Invalid Accesstoken.');
        }
    
    $this->_output();
        exit();
    }
//***********************************************************************************************************
    public function changePassword()
    {
        $request = json_decode(rtrim(file_get_contents('php://input'), "\0"));        
        $user_id = $request->user_id;
        $password = $request->new_password;
        $header = $this->input->request_headers();
        $accesstoken = $header['Accesstoken'];       
        if($this->check_accesstoken($user_id,$accesstoken))
        {  
            if (!$user_id) {
                $this->_error('Form error', 'User-Id is not specified.');
            }
             if (!$password) {
                $this->_error('Form error', 'Password is not specified.');
            }
            if (strlen($password) < 6)                 
            {
                $this->_error('Form error', 'Minimum 6 Password Length Required.');
            }            
                $where_update = array('id' => $user_id);
                $field_update = array('password'=> md5($password));                
                $total = $this->Core_Model->updateFields('users', $field_update, $where_update);
                 // echo $this->db->last_query();die();                                
                $this->res->success = 'true';                
                $this->res->message = 'Password Changed Successfully';            
        }else{            
                $this->_error('error', 'Invalid Accesstoken.');
            }
            $this->_output();
            exit();
    }
//***********************************************************************************************************    
    function getServiceProvider() //by service_id
    { 
        $request = json_decode(rtrim(file_get_contents('php://input'), "\0"));
        $service_id = $request->service_id;       
        $where = "CONCAT(',', services_search, ',') 
            LIKE '%,".$service_id.",%' ";
        // $where =  array('user_id' =>$user_id);           
        $result = $this->Core_Model->SelectRecord('service_provider', 'spId', $where, $order = '');         
        $proposal_data = [];
        foreach ($result as $value)
        {
            $sp_data[] = array($value['spId']);
            // print_r($sp_data);
            // $this->db->select('*');
            // $this->db->select('proposal.id,proposal.user_id,proposal.job_post_id,users.name,users.address,users.image,users.about');
            // $this->db->from('proposal');
            // $this->db->join('users','users.id = proposal.user_id');
            // $this->db->where('users.id',$value['spId']);
            $this->db->select('service_provider.id,service_provider.spId,service_provider.services_search,users.name,users.address,users.image,users.about');
            $this->db->from('service_provider');
            $this->db->join('users','users.id = service_provider.spId');
            $this->db->where('users.id',$value['spId']);
            $query = $this->db->get();
            // $result1[]= $query->result_array();
            $result1[]= $query->row_array();  
        }                     
            $userdata = [];
            foreach ($result1 as $total) 
            {                 
                $spId = $total['spId'];               
                
                $where3 = array('receiverId' => $spId);
                $result3 = $this->Core_Model->SelectRecord('review', '*', $where3, $order = '');                
                $totalrating = 0;
                 foreach ($result3 as $total3) 
                {
                    $totalrating += $total3['rating'];
                    // $feedback += count($total3['review']);
                    // print_r($feedback);
                }
                $rating = 0;
                if(count($result3)){
                    $rating = round($totalrating/count($result3));                 
                }
                 $feedback = 0;
                if(count($result3)){
                    $feedback = count($result3);
                }
                   $userdata[] = ['user_id' => $total['spId'],'services' => $total['services_search'],'name' => $total['name'],'address' => $total['address'],'about' => $total['about'],'rating' => $rating,'feedback' => $feedback,'image' => base_url('upload/profile/').$total['image']];                

                   $arr[]  = ['user_id'=>(($total['spId']) ? $total['spId'] : ''),'services'=>(($total['services_search']) ? $total['services_search'] : ''),'name'=>(($total['name']) ? $total['name'] : ''),'address'=>(($total['address']) ? $total['address'] : ''),'image' => ($total['image']? base_url('upload/profile/').$total['image'] : ''),'about' => (($total['about']) ? $total['about'] : ''),'rating' => ($rating ? $rating : ''),'feedback' => ($feedback ? $feedback : '')];
            } 
            if (empty($userdata)) 
            {
                $this->res->success = false;
                $this->_error('error', 'Incorrect Service Id.');
            } else
             {
                $this->res->success = 'true';
                $this->res->data = $arr;
            }
        $this->_output();
              exit();
    }
//***********************************************************************************************************
     function getServiceProvider2() //by service title or user name
    { 
        $request = json_decode(rtrim(file_get_contents('php://input'), "\0"));
        $title = $request->title;
        $name = $request->name;
        if (!empty($title = $request->title)) 
        {            
            $where = array('title' => $title);
            $result = $this->Core_Model->SelectRecord('category', 'id', $where, $order = '');
            $id = $result['0']['id'];       
            $where = "CONCAT(',', services_search, ',') 
                LIKE '%,".$id.",%' ";           
        }
        else
        {
            $where = array('name' => $name);
            $result = $this->Core_Model->SelectRecord('users', 'id', $where, $order = '');
            $id = $result['0']['id'];       
            $where = "CONCAT(',', spId, ',') 
                LIKE '%,".$id.",%' ";
        }        
        $result = $this->Core_Model->SelectRecord('service_provider', 'spId', $where, $order = '');         
        $proposal_data = [];
        foreach ($result as $value)
        {
            $sp_data[] = array($value['spId']);        
            $this->db->select('service_provider.id,service_provider.spId,service_provider.services_search,users.name,users.address,users.image,users.about');
            $this->db->from('service_provider');
            $this->db->join('users','users.id = service_provider.spId');
            $this->db->where('users.id',$value['spId']);
            $query = $this->db->get();
            // $result1[]= $query->result_array();
            $result1[]= $query->row_array();  
        }                      
            $userdata = [];
            foreach ($result1 as $total) 
            {                 
                $spId = $total['spId'];                
                // $user_id = $total=>'user_id';
                $where3 = array('receiverId' => $spId);
                $result3 = $this->Core_Model->SelectRecord('review', '*', $where3, $order = '');                
                $totalrating = 0;
                 foreach ($result3 as $total3) 
                {
                    $totalrating += $total3['rating'];
                    // $feedback += count($total3['review']);                    
                }
                $rating = 0;
                if(count($result3)){
                    $rating = round($totalrating/count($result3));
                }
                 $feedback = 0;
                if(count($result3)){
                    $feedback = count($result3);
                }
                   $userdata[] = ['user_id' => $total['spId'],'services' => $total['services_search'],'name' => $total['name'],'address' => $total['address'],'about' => $total['about'],'rating' => $rating,'feedback' => $feedback,'image' => base_url('upload/profile/').$total['image']];                

                   $arr[]  = ['user_id'=>(($total['spId']) ? $total['spId'] : ''),'services'=>(($total['services_search']) ? $total['services_search'] : ''),'name'=>(($total['name']) ? $total['name'] : ''),'address'=>(($total['address']) ? $total['address'] : ''),'image' => ($total['image']? base_url('upload/profile/').$total['image'] : ''),'about' => (($total['about']) ? $total['about'] : ''),'rating' => ($rating ? $rating : ''),'feedback' => ($feedback ? $feedback : '')];
            }
            if (empty($userdata)) 
            {
                $this->res->success = false;
                $this->_error('error', 'Incorrect Service Id.');
            } else
             {
                $this->res->success = 'true';
                $this->res->data = $arr;
            }
        $this->_output();
              exit();
    } 
 //*********************************************************************************************************
     public function addUserServices()
    {
        $request = json_decode(rtrim(file_get_contents('php://input'), "\0"));        
        $spId = $request->user_id;        
        $header = $this->input->request_headers();
        $accesstoken = $header['Accesstoken'];       
        if($this->check_accesstoken($spId,$accesstoken))
        {
            $services = $request->services; 
            $services_search = $request->services_search; 
            $status = $request->status;
             if (!$services){
                $this->_error('Form error', 'Services is not specified.');
                return false;
            }
            if (!$services_search) {
                $this->_error('Form error', 'Services Search is not specified.');
                return false;
            }
            if (!$status) {
                $this->_error('Form error', 'Status is not specified.');
                return false;
            }            
            $where = array('spId'=>$spId,'services'=>json_encode($services),'services_search'=>$services_search,'status'=>$status);            
            $this->Core_Model->InsertRecord('service_provider', $where);            
            $this->res->success = 'true';
            $this->res->message = 'Successfully Added User Services.';          
        }else
        {            
            $this->_error('error', 'Invalid Accesstoken.');
        }  
            $this->_output();
            exit();
    }
//*********************************************************************************************************
    public function getMyProjects()
    {
        $request = json_decode(rtrim(file_get_contents('php://input'), "\0"));        
        $user_id = $request->user_id;        
         $header = $this->input->request_headers();
         $accesstoken = $header['Accesstoken'];       
         if($this->check_accesstoken($user_id,$accesstoken))
         {
            $is_deleted = "0"; 
            //$user_id = 58;
            $where = array('user_id' => $user_id,'is_deleted' => $is_deleted);            
            $res = $this->Core_Model->get_myprojects('job_post',$user_id);
            //echo "<pre>"; print_r($res); die;
            if (empty($res)) {
                $arr2  = array();
                $this->res->success = 'true';
                $this->res->message = 'No projects available';          
                $this->res->data = $arr2;                
            }else{            
              foreach ($res as $key => $value)
              {
                $uid = $value['user_id'];
                $job_id = $value['id'];
                $where2 = array('job_post_id' => $job_id,'senderId' => $uid);
                $review_data = $this->Core_Model->SelectRecord('review', 'review,rating', $where2, $order = '');
                $treview = 0;
                 foreach ($review_data as $dreview) 
                    {
                        // print_r($dreview);
                        // $totalrating += $total3['rating'];
                        // $feedback += count($total3['review']);
                        // print_r($feedback);
                    }
                    $skills = '';
                      if($value['skills']){
                        foreach(explode(',',$value['skills']) as $row){                      
                          $skill = $this->Core_Model->SelectSingleRecord('skills','*',['id'=>$row],'id desc');
                          $skills .= $skill->title.',';
                        }
                    }
                  
                    $now = time(); // or your date as well
                    $your_date = strtotime($value['date_time']);
                    $datediff = $your_date - $now;
                    $datediff = round($datediff / (60 * 60 * 24));
                    if($datediff < 0){
                        $datediff = "0";
                    }

                    $posted_by_me = 0;
                    if($value['user_id'] == $user_id){
                        $posted_by_me = 1;
                    }

                    $bids = $this->Core_Model->SelectRecord('proposal','*',['job_post_id'=>$value['id']],'id desc');
                    $arr[]  = ['id'=>($value['id']) ? $value['id'] : '',
                               'title'=>($value['job_title']) ? $value['job_title'] : '',
                               'description'=>($value['description']) ? $value['description'] : '',
                               'skills'=>rtrim($skills,','),
                               'budget'=>($value['budget_amount']) ? $value['budget_amount'] : "0",
                               'ends_on'=>($value['date_time']) ? $datediff.' days' : 'Closed',
                               'total_bids'=>count($bids),
                               'status'=>($value['status'] == 1) ? 'Open' : (($value['status'] == 2) ? 'Awarded' : 'Closed'),
                               'posted_by_me'=>$posted_by_me,
                               'is_rated_me' => (($dreview['review']) ? 1 : 0),
                               'is_proposal' => ((count($bids)) ? 1 : 0),
                               ];
                    
                }
                $this->res->success = 'true';
                $this->res->message = 'My projects';          
                $this->res->data = $arr;
          
            }
         }else
         {            
             $this->_error('error', 'Invalid Accesstoken.');
         }  
            $this->_output();
            exit();
    }
//**********************************************************************************************************
    public function getUserServices()
    {
        $request = json_decode(rtrim(file_get_contents('php://input'), "\0"));        
        $spId = $request->user_id;
        // print_r($id);die();
        // $header = $this->input->request_headers();
        // $accesstoken = $header['Accesstoken'];       
        // if($this->check_accesstoken($spId,$accesstoken))
        // {
            $is_deleted = "0"; 
            $status = "1"; 
            $where = array('spId' => $spId,'is_deleted' => $is_deleted,'status' => $status);            
            $res = $this->Core_Model->SelectRecord('service_provider','*',$where,'id desc');
            if (empty($res)) {
                $arr2  = array();
                $this->res->success = 'true';
                $this->res->message = 'User Services is not available';          
                $this->res->data = $arr2;                
            }
            $userdata = [];
            foreach ($res as $key => $value)
            {
                $services = $value['services_search'];
                $where2 = explode(",",$services);                
                foreach ($where2 as $value2)
                {
                    $id = array('id' => $value2);
                    $res2 = $this->Core_Model->SelectRecord('category','id,title',$id); 
                    if (empty($res2))
                     {
                        $arr2  = array();
                        $this->res->success = 'true';
                        $this->res->message = 'User Services is not available';          
                        $this->res->data = $arr2;
                    }
                    else
                    {
                        $result2 = [];
                        foreach ($res2 as $key => $value3)
                        {

                        }
                        $arr[]  = ['service_id'=>($value3['id']) ? $value3['id'] : '','title'=>($value3['title']) ? $value3['title'] : ''];
                        $this->res->success = 'true';
                        $this->res->message = 'User Services';          
                        $this->res->data = $arr;
                    }                    
                } 
            }           
        // }else
        // {            
        //     $this->_error('error', 'Invalid accesstoken.');
        // }  
            $this->_output();
            exit();
    } 
//*************************************************************************************************
    function jobDetail()
     { 
        $request = json_decode(rtrim(file_get_contents('php://input'), "\0"));
        // $header = $this->input->request_headers();
        $job_post_id = $request->job_id;         
        $this->db->select('job_post.*,users.name,users.image');    
        $this->db->from('job_post');
        $this->db->join('users', 'job_post.user_id = users.id');
        // $this->db->join('review', 'job_post.user_id = review.senderId');
        $this->db->where('job_post.id',$job_post_id);
        $query=$this->db->get();
        $result1= $query->result_array();                
        $userdata = [];
            foreach ($result1 as $key=>$total) 
            {
                 foreach ($result3 as $total3) 
                {
                    $totalrating += $total3['rating'];
                }
                $rating = 0;
                if(count($result3)){
                    $rating = round($totalrating/count($result3));
                }
                 $feedback = 0;
                if(count($result3)){
                    $feedback = count($result3);
                }            
            $job_post_id = $total['id'];
            $where3 = array('job_post_id' => $job_post_id);
            $pdata = $this->Core_Model->SelectRecord('proposal', 'user_id,description', $where3, $order = '');//            $print_r($pdata);die;
            $vendor_arr = [];
            foreach ($pdata as $key=>$ptotal) 
            {                
                $vendor_id = $ptotal['user_id'];
                $where4 = array('id' => $vendor_id);
                $vdata = $this->Core_Model->SelectRecord('users', '*', $where4, $order = '');

                $vendor_id = $ptotal['user_id'];
                $where5 = array('receiverId' => $vendor_id);
                $review_data = $this->Core_Model->SelectRecord('review', 'review,rating', $where5, $order = '');                
                $treview = 0;
                 foreach ($review_data as $dreview) 
                {
                    // print_r($dreview);
                    // $totalrating += $total3['rating'];
                    // $feedback += count($total3['review']);
                    // print_r($feedback);
                }

                foreach ($vdata as $key=>$vtotal) 
                {
                               
                $vendor_arr[]  =  ['vendor_id'=>(($vtotal['id']) ? $vtotal['id'] : ''),'name'=>(($vtotal['name']) ? $vtotal['name'] : ''),'image' => ($vtotal['image']? base_url('upload/profile/').$vtotal['image'] : ''),'review' => (($ptotal['description']) ? $ptotal['description'] : ''),'rating' => (($dreview['rating']) ? $dreview['rating'] : '')];
                }
            }   
            $skills = $total['skills'];
            $where2 = explode(',',$skills); 
            $res2 = "";
            foreach ($where2 as $value2)
            {
                $id = array('id' => $value2);
                $skill = $this->Core_Model->selectsinglerecord('skills','title',$id);
                if($skill){
                    $res2 .= $skill->title.','; 
                }
            }
              $now = time(); // or your date as well
              $your_date = strtotime($total['date_time']);
              $datediff = $your_date - $now;
              $datediff = round($datediff / (60 * 60 * 24));
              if ($datediff<=0) {
                  $datediff = 0;
              }
            
            $userdata[] = Array('user_id' => $total['user_id'],'job_post_id' => $total['id'],'name' => $total['name'],'image' => base_url('upload/profile/').$total['image'],'review' => $total['review'],'rating' => $total['rating']);  

            $user_arr = ['user_id'=>(($total['user_id']) ? $total['user_id'] : ''),'job_post_id'=>(($total['id']) ? $total['id'] : ''),'title'=>(($total['job_title']) ? $total['job_title'] : ''),'description' => (($total['description']) ? $total['description'] : ''),'skills'=>$res2 ? rtrim($res2, ','): '','project_budget' => (($total['budget_amount']) ? $total['budget_amount'] : ''),'delivery_address' => (($total['address']) ? $total['address'] : ''),'ends_on' => (($total['date_time']) ?  $datediff.' days' : '0 days')];
            }           
            
            if (empty($userdata)) 
            {
                $this->res->success = false;
                $this->_error('error', 'Invalid Job Id.');
            } else
             {
                $this->res->success = 'true';
                $this->res->job_detail = $user_arr;
                $this->res->proposal = $vendor_arr;
                $this->res->message = 'Job Details Show Successfully';
            }
    $this->_output();
        exit();
    }
 //**************************************************************************************
    public function bidPlace()
    { 
        $request = json_decode(rtrim(file_get_contents('php://input'), "\0"));
        $header = $this->input->request_headers();
        $user_id = $request->user_id;
        $accesstoken = $header['Accesstoken'];         
        if($this->check_accesstoken($user_id,$accesstoken))
        {
            $user_id = $request->user_id;
            $job_post_id = $request->job_id;    
            $bid_value = $request->paid_to_you;
            $description = $request->description; 
            $day = $request->deliver_in;                    

             if (!$job_post_id) {
                        $this->_error('Form error', 'Job Id is not specified.');
                        return false;
            }

            if (!$bid_value) {
                        $this->_error('Form error', 'Paid To You is not specified.');
                        return false;
            }            
            if (!$description) {
                        $this->_error('Form error', 'Description is not specified.');
                        return false;
            }              
            if (!$day) {
                        $this->_error('Form error', 'Deliver In is not specified.');
                        return false;
            }            
             $where = array('user_id'=>$user_id,'job_post_id'=>$job_post_id,'bid_value'=>$bid_value,'description'=>$description,'day'=>$day);           
            $get_data = $this->Core_Model->InsertRecord('proposal', $where);

            if (empty($get_data))
            {
                $this->res->success = 'false';
                $this->res->message = "Incorrect data";
            }
            else
            {
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
    public function changeJobStatus()
    { 
        $request = json_decode(rtrim(file_get_contents('php://input'), "\0"));
        $header = $this->input->request_headers();        
        $id = $request->job_id;    
        $user_id = $request->user_id; 
        $proposal_id = $request->proposal_id;    
        $status = $request->status;    
        $accesstoken = $header['Accesstoken'];            
        if($this->check_accesstoken($user_id,$accesstoken))
        {     
            if (!$proposal_id) {
                        $this->_error('Form error', 'Proposal Id is not specified.');
                        return false;
            }

            if (!$id) {
                        $this->_error('Form error', 'Job Id is not specified.');
                        return false;
            }

            if (!$status) {
                        $this->_error('Form error', 'Status is not specified.');
                        return false;
            }

            $where = array('id' => $proposal_id);
            $spId_get = $this->Core_Model->selectsinglerecord('proposal', 'user_id', $where);
            $service_provider_id = $spId_get->user_id;            
            $where_update = array('id' => $id,'user_id' => $user_id);
            $field_update = array('proposal_id' => $proposal_id,'service_provider_id' => $service_provider_id,'status' => $status);            
            $result = $this->Core_Model->updateFields('job_post', $field_update, $where_update);                     
            if (empty($result))
            {
                $this->res->success = 'false';
                $this->res->message = "Incorrect data";
            }
            else
            {
                $this->res->success = 'true';
                $this->res->message = 'Job Awarded Successfully';                
            }
        }else
        {            
            $this->_error('error', 'Invalid Accesstoken.');
        }  
        $this->_output();
        exit();
    }
//***********************************************************************
    function otherUserProfile()
    { 
        $request = json_decode(rtrim(file_get_contents('php://input'), "\0"));
        $header = $this->input->request_headers();
        $user_id = $request->user_id;    
        $accesstoken = $header['Accesstoken'];         
        if($this->check_accesstoken($user_id,$accesstoken))
        {            
                   
            $where_login = array('id' => $user_id); 
            $total = $this->Core_Model->selectsinglerecord('users', '*', $where_login);
            $total->image = base_url('upload/profile/').$total->image; //image url get code
            $result = [];
            $result['id'] = ($total->id) ? $total->id : '';
            $result['name'] = ($total->name) ? $total->name : '';
            $result['email'] = ($total->email) ? $total->email : '';
            $result['complete'] = ($total->complete) ? $total->complete : '';
            $result['on_budget_rate'] = ($total->on_budget_rate) ? $total->on_budget_rate : '';
            $result['on_time_rate'] = ($total->on_time_rate) ? $total->on_time_rate : '';
            $result['repeat_hire_rate'] = ($total->repeat_hire_rate) ? $total->repeat_hire_rate : '';
            $result['about'] = ($total->about) ? $total->about : '';
            $result['image'] = ($total->image) ? $total->image : '';
            $skills = [];
            if($total->skills){
              foreach(explode(',',$total->skills) as $row){                
                $skill = $this->Core_Model->selectsinglerecord('skills', 'title', array("id"=>$row,"is_deleted"=>0,"status"=>1));             
                $skills[] = ['name'=>$skill->title];
              }
            }
            $result['skills'] = $skills;           
            $myreviews = $this->Core_Model->SelectRecord('review', '*', array('receiverId' => $user_id), 'reviewId desc');  
            
            $reviews = [];
            foreach ($myreviews as $key => $review) {                             
                $reslt = $this->Core_Model->selectsinglerecord('users', '*', array("id"=>$review['receiverId']));              
                $reviews[] = ['id'=>$reslt->id,'name'=>$reslt->name,'image'=>base_url('upload/profile/').$reslt->image,'review'=>$review['review'],'rating'=>$review['rating']];
            }
            $result['reviews'] = $reviews;  

            if (empty($result))
            {
                $this->res->success = 'false';
                $this->res->message = "Incorrect data";
            }
            else
            {
                $this->res->success = 'true';
                $this->res->message = 'Profile Show Successfully';
                $this->res->data = $result;
            }  
        }else
        {            
            $this->_error('error', 'Invalid Accesstoken.');
        }  
        $this->_output();
        exit();
    }
//********************************************************************************************
  public function browsJobs()
    { 
        $request = json_decode(rtrim(file_get_contents('php://input'), "\0")); 

        $res = $this->Core_Model->joindataResult($place1 =' job_post.service_id', $place2 = 'category.id',$where='','job_post.user_id,job_post.service_id,job_post.id as jobpostid,job_post.job_title,job_post.description,job_post.budget_amount,job_post.skills,job_post.status,category.id,category.title','category','job_post','job_post.id DESC');        
        //$skills = explode(",", $res[0]['skills']); 
        $userdata = [];
        foreach ($res as $key=>$total) 
        {   
            $skills = $total['skills'];
            $where2 = explode(',',$skills); 
            $res2 = "";
            foreach ($where2 as $value2)
            {
                $id = array('id' => $value2);
                $skill = $this->Core_Model->selectsinglerecord('skills','title',$id);
                if($skill){
                    $res2 .= $skill->title.','; 
                } 
            }

            $job_post_id = $total['jobpostid'];            
            $where3 = array('job_post_id' => $job_post_id);
            $result3 = $this->Core_Model->SelectRecord('proposal', '*', $where3, $order = '');
            // print_r($this->db->last_query());            
            $bid = 0;
            if(count($result3)){
            $bid = count($result3);
                }

            $arr1[]  = ['id'=>($total['jobpostid']) ? $total['jobpostid'] : '','user_id'=>($total['user_id']) ? $total['user_id'] : '','service_id'=>($total['service_id']) ? $total['service_id'] : '',
            'title'=>($total['job_title']) ? $total['job_title'] : '', 'description'=>($total['description']) ? $total['description'] : '','budget'=>($total['budget_amount']) ? $total['budget_amount'] : '0','proposals'=>$bid,'skills'=>$res2 ? rtrim($res2, ','): ''];
        } 
       
        $popular = [];
        $res = $this->Core_Model->get_popular_service('job_post');        
        foreach ($res as $key => $value) {
            $reslt = $this->Core_Model->joindataResult($place1 =' job_post.service_id', $place2 = 'category.id',$where=array("job_post.service_id"=>$value['service_id']),'job_post.user_id,job_post.service_id,job_post.id as jobpostid,job_post.job_title,job_post.description,job_post.budget_amount,job_post.skills,job_post.status,category.id,category.title','category','job_post','job_post.id DESC');
            if($reslt){
                $popular[] = $reslt;
            }
        }
        //echo $this->db->last_query();die;
        $userdata = [];
        foreach ($popular as $poplr){ 
            foreach ($poplr as $key=>$total) 
            {   
                $skills = $total['skills'];
                $where2 = explode(',',$skills);
                $res2 = "";
                foreach ($where2 as $value2)
                    {
                        $id = array('id' => $value2);
                        $skill = $this->Core_Model->selectsinglerecord('skills','title',$id);
                        if($skill){
                            $res2 .= $skill->title.','; 
                        }
                    }
                
                $job_post_id = $total['jobpostid'];                
                $where3 = array('job_post_id' => $job_post_id);
                $result3 = $this->Core_Model->SelectRecord('proposal', '*', $where3, $order = '');
                // print_r($this->db->last_query());            
                $bid = 0;
                if(count($result3)){
                $bid = count($result3);
                    }                

                $arr2[]  = ['id'=>($total['jobpostid']) ? $total['jobpostid'] : '','user_id'=>($total['user_id']) ? $total['user_id'] : '','service_id'=>($total['service_id']) ? $total['service_id'] : '',
                  'title'=>($total['job_title']) ? $total['job_title'] : '','description'=>($total['description']) ? $total['description'] : '','budget'=>($total['budget_amount']) ? $total['budget_amount'] : '0','proposals'=>$bid,'skills'=>$res2 ? rtrim($res2, ','): ''];
       
            } 
        }

        $res = $this->Core_Model->joindataResult($place1 =' job_post.service_id', $place2 = 'category.id',$where='','job_post.user_id,job_post.service_id,job_post.id as jobpostid,job_post.job_title,job_post.description,job_post.budget_amount,job_post.skills,job_post.status,category.id,category.title','category','job_post','job_post.id ASC');        
        //$skills = explode(",", $res[0]['skills']);        

        $userdata = [];
        foreach ($res as $key=>$total) 
        {   
            $skills = $total['skills'];
            $where2 = explode(',',$skills);
            $res2 = "";
            foreach ($where2 as $value2)
                {
                    $id = array('id' => $value2);
                    $skill = $this->Core_Model->selectsinglerecord('skills','title',$id);
                    if($skill){
                        $res2 .= $skill->title.','; 
                    } 
                }

            $job_post_id = $total['jobpostid'];            
            $where3 = array('job_post_id' => $job_post_id);
            $result3 = $this->Core_Model->SelectRecord('proposal', '*', $where3, $order = '');
            // print_r($this->db->last_query());            
            $bid = 0;
            if(count($result3)){
            $bid = count($result3);
                }
            

            $arr3[]  = ['id'=>($total['jobpostid']) ? $total['jobpostid'] : '','user_id'=>($total['user_id']) ? $total['user_id'] : '','service_id'=>($total['service_id']) ? $total['service_id'] : '','title'=>($total['job_title']) ? $total['job_title'] : '','description'=>($total['description']) ? $total['description'] : '','budget'=>($total['budget_amount']) ? $total['budget_amount'] : '0','proposals'=>$bid,'skills'=>$res2 ? rtrim($res2, ','): ''];
   
        }

        $res = $this->Core_Model->joindataResult($place1 =' job_post.service_id', $place2 = 'category.id',$where='','job_post.user_id,job_post.service_id,job_post.id as jobpostid,job_post.job_title,job_post.description,job_post.budget_amount,job_post.skills,job_post.status,category.id,category.title','category','job_post','job_post.budget_amount DESC');        
        //$skills = explode(",", $res[0]['skills']);        

        $userdata = [];
        foreach ($res as $key=>$total) 
        {   
            $skills = $total['skills'];
            $where2 = explode(',',$skills);
            $res2 = "";
            foreach ($where2 as $value2)
            {
                $id = array('id' => $value2);
                $skill = $this->Core_Model->selectsinglerecord('skills','title',$id);
                if($skill){
                    $res2 .= $skill->title.','; 
                } 
            }

            $job_post_id = $total['jobpostid'];            
            $where3 = array('job_post_id' => $job_post_id);
            $result3 = $this->Core_Model->SelectRecord('proposal', '*', $where3, $order = '');
            // print_r($this->db->last_query());            
            $bid = 0;
            if(count($result3)){
            $bid = count($result3);
                }            

            $arr4[]  = ['id'=>($total['jobpostid']) ? $total['jobpostid'] : '','user_id'=>($total['user_id']) ? $total['user_id'] : '','service_id'=>($total['service_id']) ? $total['service_id'] : '','title'=>($total['job_title']) ? $total['job_title'] : '','description'=>($total['description']) ? $total['description'] : '','budget'=>($total['budget_amount']) ? $total['budget_amount'] : '0','proposals'=>$bid,'skills'=>$res2 ? rtrim($res2, ','): ''];
   
        }

        if (empty($res)) 
        {
            $this->res->success = 'false';
            $this->_error('error', 'Jobs is not available.');
        } 
        else
        { 
            $this->res->success = 'true';
            $this->res->latest = $arr1;
            $this->res->popular = $arr2;
            $this->res->featured = $arr3;
            $this->res->budget = $arr4;
            $this->res->message = "User Jobs List Get Successfully";
            // $array_data1->image = base_url('upload/category/').$array_data1->image; //image code
        }  
        $this->_output();
          exit();
    }

//****************************************************************************************************  
 //***************************************old api start********************************
 //*************************************old api start**********************************
     public function awardedUser()
    { 
        $request = json_decode(rtrim(file_get_contents('php://input'), "\0"));
        $header = $this->input->request_headers();
        // $status = $request->status;    
        $id = $request->job_post_id;    
        $user_id = $request->user_id; 

        $awardedProposalId = $request->awardedProposalId;    
         // print_r($awardedProposalId);die();
        $accesstoken = $header['Accesstoken'];
        if($this->check_accesstoken($user_id,$accesstoken))
        {

            $where_update = array('id' => $id,'user_id' => $user_id);
            $field_update = array('awardedProposalId' => $awardedProposalId);
            // print_r($where_update);die();
            $result = $this->Core_Model->updateFields('job_post', $field_update, $where_update);
            $where_login = array('id' => $id,'user_id' => $user_id);

            $total = $this->Core_Model->selectsinglerecord('job_post', 'id,user_id,service_id,description,budget,awardedProposalId,status,date_time', $where_login);
            // print_r($total);die();
            // $total->image = base_url('upload/profile/').$total->image; //image url get code
            $result = [];
            $result['id'] = ($total->id) ? $total->id : '';
            $result['user_id'] = ($total->user_id) ? $total->user_id : '';
            $result['service_id'] = ($total->service_id) ? $total->service_id : '';
            // $result['email'] = ($total->email) ? $total->email : '';
            $result['description'] = ($total->description) ? $total->description : '';
            $result['budget'] = ($total->budget) ? $total->budget : '';
            $result['awarded_user'] = ($total->awardedProposalId) ? $total->awardedProposalId : '';
            // $result['image'] = ($total->image) ? $total->image : '';
            $result['status'] = ($total->status) ? $total->status : '';
            $result['date_time'] = ($total->date_time) ? $total->date_time : '';
                // print_r($result['f_name']);
                // print_r($result['total']);die();
                // $this->res->data = $result;
            if (empty($result))
            {
                $this->res->success = 'false';
                $this->res->message = "Incorrect data";
            }
            else
            {
                $this->res->success = 'true';
                $this->res->message = 'User Awarded Successfully';
                $this->res->data[] = $result;
            }
        }else
        {
            // $this->res->status = 'Failed';
            $this->_error('error', 'Invalid Accesstoken.');
        }  
        $this->_output();
        exit();
    }
//********************************************************************************************
     function update_profile_old()
    { 
        $request = json_decode(rtrim(file_get_contents('php://input'), "\0"));
        $header = $this->input->request_headers();
        $user_id = $request->user_id;    
        $accesstoken = $header['Accesstoken'];
         // print_r($accesstoken);die();
        if($this->check_accesstoken($user_id,$accesstoken))
        {
            // print_r($user_id);die(); 
            $name = $request->name; 
            $contact = $request->contact;
            $gender = $request->gender;
            $dob = $request->dob;
            $image = $request->image;            
            $about = $request->about; 

            if (!$name) {
            $this->_error('Form error', 'Name is not specified.');
            return false;
            }
             if (!$contact) {
            $this->_error('Form error', 'Contact is not specified.');
            return false;
            }
            if (!$gender) {
            $this->_error('Form error', 'Gender is not specified.');
            return false;
            }
            if (!$dob) {
            $this->_error('Form error', 'Date of Birth is not specified.');
            return false;
            }
            if (!$image) {
            $this->_error('Form error', 'Image is not specified.');
            return false;
            }          
            if (!$about) {
            $this->_error('Form error', 'About is not specified.');
            return false;
            }
            // $image = $request->image;
            // print_r($password);die();
            $where_login = array('id' => $user_id);        
            $where_update = array('id' => $user_id);
            $field_update = array('name' => $name,'contact' => $contact,'gender' => $gender,'dob' => $dob,'image' => $image,'about' => $about);

            $result = $this->Core_Model->updateFields('users', $field_update, $where_update);

            $total = $this->Core_Model->selectsinglerecord('users', 'id,name,contact,gender,dob,password,about,image,is_login,last_login', $where_login);             
            // print_r($total);die();
            $total->image = base_url('upload/profile/').$total->image; //image url get code
            $result = [];
            $result['id'] = ($total->id) ? $total->id : '';
            $result['name'] = ($total->name) ? $total->name : '';
            // $result['email'] = ($total->email) ? $total->email : '';
            $result['contact'] = ($total->contact) ? $total->contact : '';
            $result['gender'] = ($total->gender) ? $total->gender : '';
            $result['dob'] = ($total->dob) ? $total->dob : '';
            $result['password'] = ($total->password) ? $total->password : '';
            $result['about'] = ($total->about) ? $total->about : '';
            $result['image'] = ($total->image) ? $total->image : '';
            $result['is_login'] = ($total->is_login) ? $total->is_login : '';
            $result['last_login'] = ($total->last_login) ? $total->last_login : '';
                // print_r($result['f_name']);
                // print_r($result['total']);die();
                // $this->res->data = $result;
            if (empty($result))
            {
                $this->res->success = 'false';
                $this->res->message = "Incorrect data";
            }
            else
            {
                $this->res->success = 'true';
                $this->res->message = 'Update Profile Successfully';
                $this->res->data = $result;
            }  
        }else
        {
            // $this->res->status = 'Failed';
            $this->_error('error', 'Invalid Accesstoken.');
        }  
    $this->_output();
        exit();
    }
//*********************************************************************************************************
     public function userJobPostOld()
    { 
        $request = json_decode(rtrim(file_get_contents('php://input'), "\0"));
        $header = $this->input->request_headers();
        $user_id = $request->user_id;    
        $accesstoken = $header['Accesstoken'];
         // print_r($accesstoken);die();
        if($this->check_accesstoken($user_id,$accesstoken))
        {
            // print_r($user_id);die();
            $user_id = $request->user_id;
            $service_id = $request->service_id;    
            $job_title = $request->job_title;
            $description = $request->description; 
            $date_time = $request->date_time;    
            $address = $request->address;    
            $ufile = $request->ufile;    
            $budget = $request->budget;    
            $budget_amount = $request->budget_amount; 
            $skills = $_POST['skills'];
         // print_r($status);die(); 
             if (!$user_id) {
                        $this->_error('Form error', 'User Id is not specified.');
                        return false;
            }
             if (!$service_id) {
                        $this->_error('Form error', 'Service Id is not specified.');
                        return false;
            }
            if (!$job_title) {
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
            if (!$address) {
                        $this->_error('Form error', 'Address is not specified.');
                        return false;
            }    
             if (!$ufile) {
                        $this->_error('Form error', 'Upload File is not specified.');
                        return false;
            }   
             if (!$budget) {
                        $this->_error('Form error', 'Budget is not specified.');
                        return false;
            }  
            if (!$budget_amount) {
                        $this->_error('Form error', 'Budget amount is not specified.');
                        return false;
            }
            if (!$skills) {
                        $this->_error('Form error', 'Skills is not specified.');
                        return false;
            }            
            $target_dir = ''; // add the specific path to save the file
            $decoded_file = base64_decode($ufile); // decode the file
            $mime_type = finfo_buffer(finfo_open(), $decoded_file, FILEINFO_MIME_TYPE); // extract mime type
            $extension = $this->mime2ext($mime_type); // extract extension from mime type
            $file = uniqid() .'.'. $extension; // rename file as a unique name
            $file_dir = './uploads/' . uniqid() .'.'. $extension;
            $attachment = '';
            try {
            file_put_contents($file_dir, $decoded_file); // save
                $attachment = $file;
            } catch (Exception $e)
             {
                return false;
            }

            $where = array('user_id'=>$user_id,'service_id'=>$service_id,'job_title'=>$job_title,'description'=>$description,'date_time'=>$date_time,'address'=>$address,'ufile'=>$attachment,'budget'=>$budget,'budget_amount'=>$budget_amount,'skills'=>$skills);
            // print_r($where);die;
            $get_data = $this->Core_Model->InsertRecord('job_post', $where);

            if (empty($get_data))
            {
                $this->res->success = 'false';
                $this->res->message = "Incorrect data";
            }
            else
            {
                $this->res->success = 'true';
                $this->res->message = 'Job posted Successfully';
                // $this->res->data = $result;
            }

        }else
        {
            // $this->res->status = 'Failed';
            $this->_error('error', 'Invalid Accesstoken.');
        }  
        $this->_output();
        exit();
    }
//---------------------for userJobPost api function*-------------------
    function mime2ext($mime)
    {
        $all_mimes = '{"png":["image\/png","image\/x-png"],"bmp":["image\/bmp","image\/x-bmp",
        "image\/x-bitmap","image\/x-xbitmap","image\/x-win-bitmap","image\/x-windows-bmp",
        "image\/ms-bmp","image\/x-ms-bmp","application\/bmp","application\/x-bmp",
        "application\/x-win-bitmap"],"gif":["image\/gif"],"jpeg":["image\/jpeg",
        "image\/pjpeg"],"xspf":["application\/xspf+xml"],"vlc":["application\/videolan"],
        "wmv":["video\/x-ms-wmv","video\/x-ms-asf"],"au":["audio\/x-au"],
        "ac3":["audio\/ac3"],"flac":["audio\/x-flac"],"ogg":["audio\/ogg",
        "video\/ogg","application\/ogg"],"kmz":["application\/vnd.google-earth.kmz"],
        "kml":["application\/vnd.google-earth.kml+xml"],"rtx":["text\/richtext"],
        "rtf":["text\/rtf"],"jar":["application\/java-archive","application\/x-java-application",
        "application\/x-jar"],"zip":["application\/x-zip","application\/zip",
        "application\/x-zip-compressed","application\/s-compressed","multipart\/x-zip"],
        "7zip":["application\/x-compressed"],"xml":["application\/xml","text\/xml"],
        "svg":["image\/svg+xml"],"3g2":["video\/3gpp2"],"3gp":["video\/3gp","video\/3gpp"],
        "mp4":["video\/mp4"],"m4a":["audio\/x-m4a"],"f4v":["video\/x-f4v"],"flv":["video\/x-flv"],
        "webm":["video\/webm"],"aac":["audio\/x-acc"],"m4u":["application\/vnd.mpegurl"],
        "pdf":["application\/pdf","application\/octet-stream"],
        "pptx":["application\/vnd.openxmlformats-officedocument.presentationml.presentation"],
        "ppt":["application\/powerpoint","application\/vnd.ms-powerpoint","application\/vnd.ms-office",
        "application\/msword"],"docx":["application\/vnd.openxmlformats-officedocument.wordprocessingml.document"],
        "xlsx":["application\/vnd.openxmlformats-officedocument.spreadsheetml.sheet","application\/vnd.ms-excel"],
        "xl":["application\/excel"],"xls":["application\/msexcel","application\/x-msexcel","application\/x-ms-excel",
        "application\/x-excel","application\/x-dos_ms_excel","application\/xls","application\/x-xls"],
        "xsl":["text\/xsl"],"mpeg":["video\/mpeg"],"mov":["video\/quicktime"],"avi":["video\/x-msvideo",
        "video\/msvideo","video\/avi","application\/x-troff-msvideo"],"movie":["video\/x-sgi-movie"],
        "log":["text\/x-log"],"txt":["text\/plain"],"css":["text\/css"],"html":["text\/html"],
        "wav":["audio\/x-wav","audio\/wave","audio\/wav"],"xhtml":["application\/xhtml+xml"],
        "tar":["application\/x-tar"],"tgz":["application\/x-gzip-compressed"],"psd":["application\/x-photoshop",
        "image\/vnd.adobe.photoshop"],"exe":["application\/x-msdownload"],"js":["application\/x-javascript"],
        "mp3":["audio\/mpeg","audio\/mpg","audio\/mpeg3","audio\/mp3"],"rar":["application\/x-rar","application\/rar",
        "application\/x-rar-compressed"],"gzip":["application\/x-gzip"],"hqx":["application\/mac-binhex40",
        "application\/mac-binhex","application\/x-binhex40","application\/x-mac-binhex40"],
        "cpt":["application\/mac-compactpro"],"bin":["application\/macbinary","application\/mac-binary",
        "application\/x-binary","application\/x-macbinary"],"oda":["application\/oda"],
        "ai":["application\/postscript"],"smil":["application\/smil"],"mif":["application\/vnd.mif"],
        "wbxml":["application\/wbxml"],"wmlc":["application\/wmlc"],"dcr":["application\/x-director"],
        "dvi":["application\/x-dvi"],"gtar":["application\/x-gtar"],"php":["application\/x-httpd-php",
        "application\/php","application\/x-php","text\/php","text\/x-php","application\/x-httpd-php-source"],
        "swf":["application\/x-shockwave-flash"],"sit":["application\/x-stuffit"],"z":["application\/x-compress"],
        "mid":["audio\/midi"],"aif":["audio\/x-aiff","audio\/aiff"],"ram":["audio\/x-pn-realaudio"],
        "rpm":["audio\/x-pn-realaudio-plugin"],"ra":["audio\/x-realaudio"],"rv":["video\/vnd.rn-realvideo"],
        "jp2":["image\/jp2","video\/mj2","image\/jpx","image\/jpm"],"tiff":["image\/tiff"],
        "eml":["message\/rfc822"],"pem":["application\/x-x509-user-cert","application\/x-pem-file"],
        "p10":["application\/x-pkcs10","application\/pkcs10"],"p12":["application\/x-pkcs12"],
        "p7a":["application\/x-pkcs7-signature"],"p7c":["application\/pkcs7-mime","application\/x-pkcs7-mime"],"p7r":["application\/x-pkcs7-certreqresp"],"p7s":["application\/pkcs7-signature"],"crt":["application\/x-x509-ca-cert","application\/pkix-cert"],"crl":["application\/pkix-crl","application\/pkcs-crl"],"pgp":["application\/pgp"],"gpg":["application\/gpg-keys"],"rsa":["application\/x-pkcs7"],"ics":["text\/calendar"],"zsh":["text\/x-scriptzsh"],"cdr":["application\/cdr","application\/coreldraw","application\/x-cdr","application\/x-coreldraw","image\/cdr","image\/x-cdr","zz-application\/zz-winassoc-cdr"],"wma":["audio\/x-ms-wma"],"vcf":["text\/x-vcard"],"srt":["text\/srt"],"vtt":["text\/vtt"],"ico":["image\/x-icon","image\/x-ico","image\/vnd.microsoft.icon"],"csv":["text\/x-comma-separated-values","text\/comma-separated-values","application\/vnd.msexcel"],"json":["application\/json","text\/json"]}';
        $all_mimes = json_decode($all_mimes,true);
        foreach ($all_mimes as $key => $value) 
        {
            if(array_search($mime,$value) !== false) return $key;
        }
        return false;
    }
//*********************************************************************************************
    function get_parent()
    {    

        $request = json_decode(rtrim(file_get_contents('php://input'), "\0"));

        $category_id = $request->category_id;

        // print_r($catid);die();

        // $html='';

        $CI =& get_instance();

        $this->db->select('*');            

        $this->db->where(array('id'=>$category_id));

        $query = $this->db->get('category');            

        $result = $query->row();

        if ($result->id == "" or $result->parent_id == 0 ) {

            $this->res->success = 'false';

            $this->_error('error', 'Category or parent category is not available.');

        }

        $parent_id1 = $result->parent_id;

        $where = array('id' => $parent_id1);

        $array_data1 = $this->Core_Model->selectsinglerecord('category', 'id,parent_id,title,description,image,icon', $where);            

         // print_r($array_data1);die();

        $array_data1->image = base_url('upload/profile/').$array_data1->image; //image url get code

        $result1 = [];

        $result1['id'] = ($array_data1->id) ? $array_data1->id : '';

        $result1['parent_id'] = ($array_data1->parent_id) ? $array_data1->parent_id : '';

        $result1['title'] = ($array_data1->title) ? $array_data1->title : '';

        $result1['description'] = ($array_data1->description) ? $array_data1->description : '';

        $result1['image'] = ($array_data1->image) ? $array_data1->image : '';

        $result1['icon'] = ($array_data1->icon) ? $array_data1->icon : '';

            // print_r($array_data1);die();    

        if (!empty($array_data1)) 

        {

            $parent_id2 = $array_data1->parent_id;

            $where = array('id' => $parent_id2);

            // $array_data2 = $this->Core_Model->selectsinglerecord('category', '*', $where);

            $array_data2 = $this->Core_Model->selectsinglerecord('category', 'id,parent_id,title,description,image,icon', $where);

            // $array_data2->image = base_url('upload/profile/').$array_data2->image; //image url get code

             if (!empty($array_data2))

            {

                $array_data2 = $this->Core_Model->selectsinglerecord('category', 'id,parent_id,title,description,image,icon', $where);

                $array_data2->image = base_url('upload/profile/').$array_data2->image; //image url get code

                $result2 = [];

                $result2['id'] = ($array_data2->id) ? $array_data2->id : '';

                $result2['parent_id'] = ($array_data2->parent_id) ? $array_data2->parent_id : '';

                $result2['title'] = ($array_data2->title) ? $array_data2->title : '';

                $result2['description'] = ($array_data2->description) ? $array_data2->description : '';

                $result2['image'] = ($array_data2->image) ? $array_data2->image : '';

                $result2['icon'] = ($array_data2->icon) ? $array_data2->icon : '';

             }               

        }

        else

        {

            $this->res->success = 'false';

            $this->_error('error', 'Incorrect data.');

        }

        if (empty($array_data1)) 

        {

            $this->res->success = 'false';

            $this->_error('error', 'Incorrect data.');

        } 

        else

        {

            if (empty($array_data2)) 

            {

                $this->res->success = 'true';

                $this->res->data = $result1;

                // $result1->image = base_url('upload/category/').$result1->image; //image url get code

            }

            else

            {

              $this->res->success = 'true';

              $this->res->data[] = $result2;   

              // $result2->image = base_url('upload/category/').$result2->image;

              $this->res->data[] = $result1; 

              // $result1->image = base_url('upload/category/').$result1->image; //image url get code  

            }

        }

        $this->_output();

          exit();

    }

//**************************************************************************************

        function get_subcategory()

    {      

        $request = json_decode(rtrim(file_get_contents('php://input'), "\0"));

        $category_id = $request->category_id;

        // print_r($category_id);die();

        // $html='';

        $CI =& get_instance();

        $this->db->select('*');            

        $this->db->where(array('id'=>$category_id));

        $query = $this->db->get('category');            

        $result = $query->row();

        $id = $result->id;

        $where = array('parent_id' => $id);        

        // print_r($data);die();

         $array_data1 = $this->Core_Model->SelectRecord('category', 'id,parent_id,title,description,image,icon', $where, $order = '');

        // $array_data1->image = base_url('upload/category/').$array_data1->image; //image url get code

        //check pending for null value

        $userdata = [];

        foreach ($array_data1 as $total)

         {

            $userdata[] = array('id' => $total['id'],'parent_id' => $total['parent_id'],'title' => $total['title'],'description' => $total['description'],'image' => base_url('upload/category/').$total['image'],'icon' => $total['icon']);

        // print_r($userdata);die();

         }

        $total_new1 = [];        

         foreach( $userdata as $total_new)

         {

            $total_new1[] = array("id" => ($total_new['id']) ? $total_new['id'] : '',

                    "parent_id" => ($total_new['parent_id']) ? $total_new['parent_id'] : '',

                    'title' => ($total_new['title']) ? $total_new['title'] : '',

                    'description' => ($total_new['description']) ? $total_new['description'] : '',

                    'image' => ($total_new['image']) ? $total_new['image'] : '',

                    'icon' => ($total_new['icon']) ? $total_new['icon'] : '');   

            // print_r($total_new1);die;

         }

        // print_r($array_data1);die();

        if (empty($total_new1)) 

        {

            $this->res->success = 'false';

            $this->_error('error', 'Subcategory is not available.');

        } 

        else

        {                

            $this->res->success = 'true';

            $this->res->data = $total_new1;

            // $array_data1->image = base_url('upload/category/').$array_data1->image; //image code

        }               

        $this->_output();

          exit();

    }

 //**************************************************************************************

    function services()

    { 

        $request = json_decode(rtrim(file_get_contents('php://input'), "\0"));

        $category_id = $request->category_id;

        $where = array('category_id' => $category_id);

        $result = $this->Core_Model->SelectRecord('services', '*', $where, $order = '');

        $userdata1 = [];

        foreach ($result as $total)

         {

            $userdata[] = array('id' => $total['id'],'category_id' => $total['category_id'],'title' => $total['title'],'description' => $total['description'],'image' => base_url('upload/category/').$total['image'],'icon' => $total['icon']);

        // print_r($userdata);die();

         }

        if (empty($result))

        {

            $this->res->success = 'false';

            $this->res->message = "Incorrect data";

        }

        else

        {

            $this->res->success = 'true';

            $this->res->data = $userdata;   

        }

        $this->_output();

              exit();

    }

 //**************************************************************************************

     function blogs()

    { 

        $request = json_decode(rtrim(file_get_contents('php://input'), "\0"));

        $category_id = $request->category_id;

        if (empty($category_id))

        {

            $result1 = $this->Core_Model->SelectRecord('blogs', 'id,category_id,title,description,image', $where, $order = '');



            $userdata1 = [];

            foreach ($result1 as $total)

             {

                $userdata1[] = array('id' => $total['id'],'category_id' => $total['category_id'],'title' => $total['title'],'description' => $total['description'],'image' => base_url('upload/category/').$total['image']);

            // print_r($total);die();

             }

            if (empty($result1))

            {

                $this->res->success = 'false';

                $this->res->message = "Incorrect data";

            }

            else

            {

                $this->res->success = 'true';

                $this->res->data = $userdata1;

            }

        }

        else

        {

            $where = array('category_id' => $category_id);

            $result2 = $this->Core_Model->SelectRecord('blogs', 'id,category_id,title,description,image', $where, $order = '');

            // print_r($result2);die();



            $userdata2 = [];

            foreach ($result2 as $total)

             {

            // print_r($total);die();

                $userdata2[] = array('id' => $total['id'],'category_id' => $total['category_id'],'title' => $total['title'],'description' => $total['description'],'image' => base_url('upload/category/').$total['image'] );

             }

            if (empty($result2))

            {

                $this->res->success = 'false';

                $this->res->message = "Incorrect data";

            }

            else

            {

                $this->res->success = 'true';

                $this->res->data = $userdata2;   

            }

        }

            $this->_output();

              exit();

    }

 //**************************************************************************************

    function options()

    { 

        $request = json_decode(rtrim(file_get_contents('php://input'), "\0"));

        $service_id = $request->service_id;

        $where = array('service_id' => $service_id);

        $result = $this->Core_Model->SelectRecord('options', '*', $where, $order = '');

        // print_r($result);die();

        $userdata1 = [];

        foreach ($result as $total)

         {

            $userdata[] = array('id' => $total['id'],'service_id' => $total['service_id'],'field_key' => $total['field_key'],'field_value' => $total['field_value'],'field_type' => $total['field_type'],'field_icon' => $total['field_icon'],'field_position' => $total['field_position'],'list_name' => $total['list_name'],'is_multiple' => $total['is_multiple'],'is_radio' => $total['is_radio'],'is_required' => $total['is_required']);

        // print_r($userdata);die();

         }

        if (empty($result))

        {

            $this->res->success = 'false';

            $this->res->message = "Incorrect data";

        }

        else

        {

            $this->res->success = 'true';

            $this->res->data = $userdata;   

        }

        $this->_output();

              exit();

    }

 //**************************************************************************************

    public function add_vendor_services() {

        $request = json_decode(rtrim(file_get_contents('php://input'), "\0")); 

        // print_r($request);die();

        $f_name = $request->first_name;    

        $l_name = $request->last_name;    

        $email = $request->email;

        $phone = $request->phone;

        $gender = $request->gender;    

        $dob = $request->dob;    

        $address = $request->address;    

        $zip_code = $request->zip_code;    

        $country = $request->country;    

        $city = $request->city;    

        $username = $request->username;    

        $password = $request->password;    

        $image = $request->image;    

        $user_type = $request->user_type;    

        $is_verified = $request->is_verified;    

        $is_login = $request->is_login;    

        $is_deleted = $request->is_deleted; 

        $vendor_services = $request->vendor_services;   

        $vendor_services_search = $request->vendor_services_search;   

        $vendor_status = $request->vendor_status;    

        // print_r($request);die(); 

        // echo $f_name; die;

         if (!$email) {

                    $this->_error('Form error', 'Email is not specified.');

                    return false;

        }

        if (!$password) {

                    $this->_error('Form error', 'Password is not specified.');

                    return false;

        }

        if (!$username) {

                    $this->_error('Form error', 'User Name is not specified.');

                    return false;

        }

        

        if ($this->email_check_vendor($email)) {

                    $this->_error('Form error', 'Email already exists.');

                    return false;

        }

        

            $where = array('email'=>$email,'password'=>md5($password),'username'=>$username,'f_name'=>$f_name,'l_name'=>$l_name,'phone'=>$phone,'gender'=>$gender,'dob'=>$dob,'address'=>$address,'zip_code'=>$zip_code,'country'=>$country,'city'=>$city,'image'=>$image,'user_type'=>$user_type,'is_verified'=>$is_verified,'is_login'=>$is_login,'is_deleted'=>$is_deleted);

            // print_r($where);die;

            $get_email = $this->Core_Model->InsertRecord('users', $where);

            // print_r($get_email);die;            

            if (!empty($get_email))

            {

                $email = $request->email;

                $where = array('email' => $email);

                $result = $this->Core_Model->SelectSingleRecord('users', 'id', $where, $order = '');

                $id = $result->id;

                $where = array('vendor_id'=>$id,'services'=>json_encode($vendor_services),'services_search'=>$vendor_services_search,'status'=>$vendor_status);

                $get_vendor_services = $this->Core_Model->InsertRecord('vendor_services', $where);

                // print_r($get_vendor_services);die;

                foreach ($vendor_services as $userServicesId) 

                {

                    // print_r($total);die();

                   $where =  array('userId'=>$id,'userServicesId'=>$userServicesId,'price'=>0,'weekPrice'=>0,'monthPrice'=>0,'yearPrice'=>0);

                   $get_vendor_price = $this->Core_Model->InsertRecord('vendor_services_price', $where);

                }



                $this->res->success = 'true';   

                    return true;

                $this->_output();

                exit();

            }

        }

//**************************************************************************************

    // function email_check_vendor($email) {

    //     $where = array('email' => $email);

    //     $field = 'email';

    //     // print_r($where);die();

    //     $get_email = $this->Core_Model->SelectSingleRecord('users', $field, $where);

    // // print_r($get_email);die;

    //     if (!empty($get_email)) {

    //          return true;

    //     }

    //      return false;

    // }

   //**************************************************************************************

    public function update_vendor_services_price() 

    {

        $request = json_decode(rtrim(file_get_contents('php://input'), "\0")); 

        // print_r($request);die();

        $userId = $request->userId; 

        $userServicesId = $request->userServicesId; 

        $vendor_price = $request->vendor_price;         

        $weekPrice = $request->weekPrice;         

        $monthPrice = $request->monthPrice;         

        $yearPrice = $request->yearPrice;    

    // print_r($request);die(); 

        $where_update = array('userId' => $userId,'userServicesId' => $userServicesId);

        $field_update = array('price'=>$vendor_price,'weekPrice'=>$weekPrice,'monthPrice'=>$monthPrice,'yearPrice'=>$yearPrice);

        // print_r($field_update);die;

        $result = $this->Core_Model->updateFields('vendor_services_price', $field_update, $where_update);

        // print_r($result);die();

        $this->res->success = 'true';  

        $this->res->message = 'Successfull updated data'; 

            // return true;

       $this->_output();

        exit();

    }

    //**************************************************************************************

    public function booking_payment()

    {

        $request = json_decode(rtrim(file_get_contents('php://input'), "\0"));

        $vendor_id = $request->vendor_id;

        $amount = $request->amount;

        $order_status = $request->order_status;

        $qty = $request->qty;

        $servicename = $request->servicename;

        $payment_method = $request->payment_method;

        $payment_price = $request->payment_price;

        $payment_type = $request->payment_type;

        $startDate = $request->startDate;

        $endDate = $request->endDate;

        $time = $request->time;

        $payment_status = $request->payment_status;

        $review_status = $request->review_status;

        $services = $request->services;

        $order_no = $this->create_order_no();//"ORDER_".uniqid();

        // print_r($order_no);die();

        $location = $request->location;

        $schedule = $request->schedule;

        // print_r($request);die();

        // print_r($this->input->request_headers());die();

        //for accesstoken check

        // echo $password;die();

        if (!$vendor_id) {

            $this->_error('Form error', 'Vendor-Id is not specified.');

        }

        if (!$amount) {

            $this->_error('Form error', 'Amount is not specified.');

        }

        if (!$order_status) {

            $this->_error('Form error', 'Order Status is not specified.');

        }

        if (!$qty) {

            $this->_error('Form error', 'Quantity is not specified.');

        }

        if (!$servicename) {

            $this->_error('Form error', 'Service Name is not specified.');

        }

        if (!$payment_method) {

            $this->_error('Form error', 'Payment Method is not specified.');

        }

        if (!$payment_price) {

            $this->_error('Form error', 'Payment Price is not specified.');

        }

        if (!$payment_type) {

            $this->_error('Form error', 'Payment Type is not specified.');

        }

        if (!$startDate) {

            $this->_error('Form error', 'Start Date is not specified.');

        }

        if (!$endDate) {

            $this->_error('Form error', 'End Date is not specified.');

        }

        if (!$time) {

            $this->_error('Form error', 'Time is not specified.');

        }

        if (!$payment_status) {

            $this->_error('Form error', 'Payment Status is not specified.');

        }

        if (!$review_status) {

            $this->_error('Form error', 'Review Status is not specified.');

        }

        if (!$services) {

            $this->_error('Form error', 'Services is not specified.');

        }

        if (!$location) {

            $this->_error('Form error', 'Location is not specified.');

        }

        if (!$schedule) {

            $this->_error('Form error', 'Schedule is not specified.');

        }



        $where1 = array('vendor_id'=>$vendor_id,'order_id'=>$order_no,'qty'=>$qty,'amount'=>$amount,'servicename'=>$servicename,'payment_method'=>$payment_method,'payment_price'=>$payment_price,'payment_type'=>$payment_type,'startDate'=>$startDate,'endDate'=>$endDate,'time'=>$time,'payment_status'=>$payment_status,'review_status'=>$review_status,'services'=>json_encode($services),'location'=>json_encode($location),'schedule'=>$schedule);

        $result1 = $this->Core_Model->InsertRecord('order_detail', $where1);



              $udata['transaction_id'] = rand();

        $where2 = array('user_id'=>$vendor_id,'order_no'=>$order_no,'amount'=>$amount,'payment_type'=>$payment_type,'payment_status'=>1,'transaction_id'=>$udata['transaction_id']);

        $result2 = $this->Core_Model->InsertRecord('order', $where2);

            // print_r($result2);die;

        $this->res->success = 'true';  

        $this->res->message = 'Order has been booked and payment done';

        $this->_output();

        exit();

    }

    //**************************************************************************************

    public function create_order_no()

        {

            $order = "ORDER_".uniqid();                   

            if($this->MY_Model->SelectRecord('order','*',array("order_no"=>$order),$orderby=array())){

                $this->create_order_no();

            }

            return $order;

        }

    //**************************************************************************************

    function user_order_list()

    { 

        $request = json_decode(rtrim(file_get_contents('php://input'), "\0"));

        $user_id = $request->user_id;

        $where = array('order.user_id' => $user_id);

                //CONCAT('w3resource','.','com')

            $res = $this->Core_Model->joindataResult($place1 ='order.order_no', $place2 = 'order_detail.order_id',$where,'order.order_no,order.transaction_id,order.id,order.user_id,order_detail.id,order_detail.qty,order_detail.amount,order_detail.servicename,order_detail.payment_method,order_detail.payment_price,order_detail.payment_type,order_detail.startDate,order_detail.endDate,order_detail.time,order_detail.payment_status,order_detail.review_status,order_detail.services,order_detail.location,order_detail.schedule,order_detail.order_id','order_detail','order',$order='');

            // print_r($res);die();

            $userdata = [];

            foreach ($res as $total) 

            {

                $userdata[] = array('id' => $total['id'],'user_id' => $total['user_id'],'transaction_id' => $total['transaction_id'],'amount' => $total['amount'],'servicename' => $total['servicename'],'payment_method' => $total['payment_method'],'payment_price' => $total['payment_price'],'payment_type' => $total['payment_type'],'startDate' => $total['startDate'],'endDate' => $total['endDate'],'time' => $total['time'],'payment_status' => $total['payment_status'],'review_status' => $total['review_status'],'services' => json_decode($total['services']),'location' => json_decode($total['location']),'schedule' => $total['schedule']);

                // print_r($userdata);die();

            }

            if (empty($userdata)) 

            {

                $this->res->success = false;

                $this->_error('error', 'Incorrect id or data.');

            } else

             {

                $this->res->success = 'true';

                $this->res->data = $userdata;

            }

        $this->_output();

              exit();

    }

    //**************************************************************************************

    function vendor_order_list()

    { 

        $request = json_decode(rtrim(file_get_contents('php://input'), "\0"));

        $vendor_id = $request->vendor_id;

        $where = array('order_detail.vendor_id' => $vendor_id);

                //CONCAT('w3resource','.','com')

            $res = $this->Core_Model->joindataResult($place1 ='order_detail.order_id', $place2 = 'order.order_no',$where,'order_detail.id,order_detail.qty,order_detail.amount,order_detail.servicename,order_detail.payment_method,order_detail.payment_price,order_detail.payment_type,order_detail.startDate,order_detail.endDate,order_detail.time,order_detail.payment_status,order_detail.review_status,order_detail.services,order_detail.location,order_detail.schedule,order_detail.order_id,order.order_no,order.transaction_id,order.id,order.user_id','order','order_detail',$order='');

            // print_r($res);die();

            $userdata = [];

            foreach ($res as $total) 

            {

                $userdata[] = array('id' => $total['id'],'user_id' => $total['user_id'],'transaction_id' => $total['transaction_id'],'amount' => $total['amount'],'servicename' => $total['servicename'],'payment_method' => $total['payment_method'],'payment_price' => $total['payment_price'],'payment_type' => $total['payment_type'],'startDate' => $total['startDate'],'endDate' => $total['endDate'],'time' => $total['time'],'payment_status' => $total['payment_status'],'review_status' => $total['review_status'],'services' => json_decode($total['services']),'location' => json_decode($total['location']),'schedule' => $total['schedule']);

                // print_r($userdata);die();

            }

            if (empty($userdata)) 

            {

                $this->res->success = false;

                $this->_error('error', 'Incorrect id or data.');

            } else

             {

                $this->res->success = 'true';

                $this->res->data = $userdata;

            }

        $this->_output();

              exit();

    }

    //**************************************************************************************

    function notification()

    { 

        $request = json_decode(rtrim(file_get_contents('php://input'), "\0"));

        $user_id = $request->user_id;

        $where = array('notification.user_id' => $user_id);

                //CONCAT('w3resource','.','com')

            $res = $this->Core_Model->joindataResult($place1 ='notification.sender_id', $place2 = 'users.id',$where,'notification.notification_id,notification.sender_id,notification.notification_msg,notification.notification_connection_id,notification_connection_type,notification.notification_status,notification.is_read,users.f_name,users.l_name','users','notification',$order='');

            // print_r($res);die();

            $userdata = [];

            foreach ($res as $total) 

            {

                $userdata[] = array('id' => $total['notification_id'],'sender_id' => $total['sender_id'],'notification_connection_id' => $total['notification_connection_id'],'notification_msg' => $total['notification_msg'],'notification_connection_type' => $total['notification_connection_type'],'notification_status' => $total['notification_status'],'is_read' => $total['is_read'],'sender_name' => $total['f_name']." ".$total['l_name']);

                // print_r($userdata);die();

            }

            if (empty($userdata)) 

            {

                $this->res->success = false;

                $this->_error('error', 'Incorrect id or data.');

            } else

             {

                $this->res->success = 'true';

                $this->res->data = $userdata;

            }

        $this->_output();

              exit();

    }

     //**************************************************************************************

    function promocode()

    { 

        $request = json_decode(rtrim(file_get_contents('php://input'), "\0"));

        $user_id = $request->user_id;

        $promocode = $request->promocode;

        $where = array('userId' => $user_id,'promoCode' => $promocode);

        $selectdata = 'discountPresent,startDate,endDate';

        $result = $this->Core_Model->SelectSingleRecord('promocode',$selectdata,$where,$order='');

        $startDate = $result->startDate;

        $endDate = $result->endDate;

        // print_r($endDate);die();

        date_default_timezone_set("Asia/Kolkata"); //current indian date/time

        $today = date("Y-m-d H:i:s");

        // echo $today;

        if ($startDate==$today or $endDate>=$today) {

            // echo"yes";

            $userdata[] = array('discountPercent' => $result->discountPresent);

            $this->res->success = 'true';

            $this->res->data = $userdata;   

        }

        else

        {

           $this->res->success = 'false';

           $this->res->message = "Invalid Promocode"; 

        }

        $this->_output();

              exit();

    }
//**********************************************************************************************
     public function PostJobsProposalOld()
    { 
        $request = json_decode(rtrim(file_get_contents('php://input'), "\0"));
        $header = $this->input->request_headers();
        $user_id = $request->user_id;    
        $accesstoken = $header['Accesstoken'];
         // print_r($accesstoken);die();
        if($this->check_accesstoken($user_id,$accesstoken))
        {
            // print_r($user_id);die();
            $user_id = $request->user_id;
            $job_post_id = $request->job_post_id;    
            $bid_value = $request->paid_to_you;
            $description = $request->description; 
            $day = $request->deliver_in;
         // print_r($status);die(); 
             if (!$user_id) {
                        $this->_error('Form error', 'User Id is not specified.');
                        return false;
            }

             if (!$job_post_id) {
                        $this->_error('Form error', 'Job Post Id is not specified.');
                        return false;
            }

            if (!$bid_value) {
                        $this->_error('Form error', 'Paid To You is not specified.');
                        return false;
            }            
            if (!$description) {
                        $this->_error('Form error', 'Description is not specified.');
                        return false;
            }              
            if (!$day) {
                        $this->_error('Form error', 'Deliver In is not specified.');
                        return false;
            }            
             $where = array('user_id'=>$user_id,'job_post_id'=>$job_post_id,'bid_value'=>$bid_value,'description'=>$description,'day'=>$day);
            // print_r($where);die;
            $get_data = $this->Core_Model->InsertRecord('proposal', $where);

            if (empty($get_data))
            {
                $this->res->success = 'false';
                $this->res->message = "Incorrect data";
            }
            else
            {
                $this->res->success = 'true';
                $this->res->message = 'Jobs Proposal Posted Successfully';
                // $this->res->data = $result;
            } 

        }else
        {
            // $this->res->status = 'Failed';
            $this->_error('error', 'Invalid Accesstoken.');
        }  
        $this->_output();
        exit();
    }
//*********************************************************************************************************
    function vendor_rating()

    { 

        $request = json_decode(rtrim(file_get_contents('php://input'), "\0"));

        $service_id = $request->service_id;

        $where = "CONCAT(',', services_search, ',') 

            LIKE '%,".$service_id.",%' ";

            // print_r($where);die();

        $result = $this->Core_Model->SelectRecord('vendor_services', '*', $where, $order = '');



            // print_r($result);die();

        $vendor_services = [];

        foreach ($result as $value)

        {

            $vendor_services[] = array('vendor_id' => $value['vendor_id'],'charges' => $value['charges']);

        }

      

            $res = $this->Core_Model->joindataResult($place1 ='vendor_services.vendor_id', $place2 = 'users.id',$where,'vendor_services.id,vendor_services.vendor_id,vendor_services.charges,users.f_name,users.l_name','users','vendor_services',$order='');

            $userdata = [];

            foreach ($res as $key=>$total) 

            {

            // print_r($total);die();

                // print_r($userdata);die();

                $vendor_id = $total['vendor_id'];

                $where3 = array('receiverId' => $vendor_id);

                $result3 = $this->Core_Model->SelectRecord('review', '*', $where3, $order = '');



                $totalrating = 0;

                 foreach ($result3 as $total3) 

                {

                    $totalrating += $total3['rating'];

                }

                

                $rating = 0;

                if(count($result3)){

                    $rating = $totalrating/count($result3);    

                }

                   $userdata[] = array('service_id' => $total['id'],'vendor_id' => $total['vendor_id'],'charges' => $total['charges'],'vendor_name' => $total['f_name']." ".$total['l_name'],'rating' => $rating); 

            }

            // die;

            if (empty($userdata)) 

            {

                $this->res->success = false;

                $this->_error('error', 'Incorrect id or data.');

            } else

             {

                $this->res->success = 'true';

                $this->res->data = $userdata;

            }

        $this->_output();

              exit();

    }

 //**************************************************************************************

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

        if (isset($this->req->request)) {

            $this->res->request = $this->req->request;

        }

        $this->res->message = $reason;

        $this->res->datetime = date('Y-m-d\TH:i:sP');

        echo json_encode($this->res);

        die();

    }  

}





