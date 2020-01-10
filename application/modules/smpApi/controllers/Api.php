<?php 	

class Api extends CI_Controller

{
 function __construct(){
    parent::__construct();
    header('Content-Type: application/json');
    $this->load->model('Core_Model');
    $this->load->model('Common_Model');
    $this->load->model('MY_Model');
    // $this->load->library('session');
    $this->res = new stdClass();
    // $request = json_decode(rtrim(file_get_contents('php://input'), "\0"));
 }

    public function signup() 
    {
     
        $request = json_decode(rtrim(file_get_contents('php://input'), "\0")); 
        // print_r($request); die;
        $name = $request->name; 
        $email = $request->email;
        $password = $request->password; 
        $contact = $request->phone; 
        $last_login = date("Y-m-d H:i:s");
        // print_r($last_login);die();
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
        if ($this->email_check($email)) {
        $this->_error('Form error', 'Email already exists.');
        return false;
        }        

            $where = array('name'=>$name,'email'=>$email,'password'=>md5($password),'last_login'=>$last_login,'contact'=>$contact);
            // print_r($where);die;
            // $field=array('email');
            $get_email = $this->Core_Model->InsertRecord('users', $where);
            // print_r($get_email);die;
            if (!empty($get_email)) {
            $this->res->success = 'true';
            $this->res->message = "User Registered Successfully"; 

                //echo"true";
                //return true;
            }
           $this->_output();
            exit();
        }
//---------------------*-------------------
    function email_check($email) {
        $where = array('email' => $email);
        $field = 'email';
        // print_r($where);die()
        $get_email = $this->Core_Model->SelectSingleRecord('users', $field, $where);
    // print_r($get_email);die;
        if (!empty($get_email)) {
             return true;
        }
         return false;
    }
    //---------------------*-------------------
    public function signin()
    {

        $request = json_decode(rtrim(file_get_contents('php://input'), "\0"));
        $email = $request->email;
        $password = $request->password;
        // print_r($password);die();
        // print_r($this->input->request_headers());die();
        //for accesstoken check
        // echo $password;die();
        if (!$email) {
            $this->_error('Form error', 'Email-Id is not specified.');
        }
        if (!$password) {
            $this->_error('Form error', 'Password is not specified.');
        }
         $where_login = array('email' => $email, 'password' => md5($password));
         $array_login = $this->Core_Model->selectsinglerecord('users', '*', $where_login);
            // print_r($array_login);die();
         if(empty($array_login)) {
            // $this->res->status = 'Failed';
            $this->_error('error', 'Incorrect Email Id & Password.');
        } else {
            // $id=$aray_login['id'];
            // $accesstoken = base64_encode(random_bytes(32));
            $accesstoken = base64_encode(uniqid()); //other type for getting random no
            $is_login='1';
            // print_r($accesstoken);die();
            //for accesstoken show
            //update access token
            $where_update = array('email' => $email);
            $field_update = array('token'=>$accesstoken,'is_login'=>$is_login);
            // print_r($field_update);die();
            $this->Core_Model->updateFields('users', $field_update, $where_update);
            $this->res->success = 'true';
            $array_login2 = $this->Core_Model->selectsinglerecord('users', 'id,name,email,contact,gender,dob,image,token,is_login,last_login', $where_login);
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
            // print_r($result['f_name']); 
            // print_r($result['total']);die();
            $this->res->data = $result;
        }
        $this->_output();
        exit();
    }

//---------------------*-------------------

    public function logout()

    {
        $request = json_decode(rtrim(file_get_contents('php://input'), "\0"));
         // $user_id = $request->user_id;
         $id = $request->user_id;
         // print_r($id);die();
         $header = $this->input->request_headers();
         $accesstoken = $header['Accesstoken'];
         // print_r($accesstoken);die();
        if($this->check_accesstoken($id,$accesstoken)){
            // $where_update = array('id' => $user_id);
            $where_update = array('id' => $id);
            // $field_update = array('accesstoken'=>0,'is_user_login'=>0);
            $field_update = array('token'=>0,'is_login'=>0);
            $this->Core_Model->updateFields('users', $field_update, $where_update);
            $this->res->success = 'true';
            $this->res->message = 'User Logout Successfully';
        }else{
            // $this->res->status = 'Failed';
            $this->_error('error', 'Invalid accesstoken.');
        }
        $this->_output();
          exit();
    }
    public function check_accesstoken($id,$accesstoken)
    {
        // $where = array('id'=>$user_id,'accesstoken'=>$accesstoken);
        $where = array('id'=>$id,'token'=>$accesstoken);
        $selectdata = 'id,token';
        $res = $this->Core_Model->SelectSingleRecord('users',$selectdata,$where,$order='');
       if($res){
        return true;
       }else
       return false;
    }
     //---------------------*-------------------   
    public function userJobPost()
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
            $status = $request->status; 
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
            if (!$status) {

                        $this->_error('Form error', 'Status is not specified.');

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

            $where = array('user_id'=>$user_id,'service_id'=>$service_id,'job_title'=>$job_title,'description'=>$description,'date_time'=>$date_time,'address'=>$address,'ufile'=>$attachment,'budget'=>$budget,'status'=>$status);
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
            $this->_error('error', 'Invalid accesstoken.');
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

    //---------------------*-------------------
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
    //---------------------*-------------------

   public function category() 
    {
        $categories2 = $this->MY_Model->SelectRecord('category','*',$udata=array("is_deleted"=>"0","parent_id"=>"0"),'order_id asc');            
            $cname = [];
            $level = 1; 
    
            foreach ($categories2 as $key => $value)
            {
                $cname[$value['title']][] = ['id'=>$value['id'], 'cname'=>$value['title'],'level'=>$value['level']];
    
                // $arr[] = ['id'=>$value['id'], 'parent_id'=>$value['parent_id'], 'cname'=>$value['title'],'level'=>$value['level'],'order_id'=>$value['order_id'],'description'=>$value['description'],'image' => base_url('upload/category/').$value['image'],'icon'=>$value['icon']];

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
    
                                     // $arr[]  = ['id'=>$data['id'], 'parent_id'=>$data['parent_id'],'cname'=>$data['title'],'level'=>$data['level'],'order_id'=>$data['order_id'],'description'=>$data['description'],'image' => base_url('upload/category/').$value['image'],'icon'=>$data['icon']];                     
                                       
                                     $arr[]  = ['id'=>$data['id'],'cname'=>$data['title'],'description'=>$data['description'],'image' => base_url('upload/category/').$value['image']]; 
                                        // print_r($arr);die();
                                }
                                else{ break; }
                            }
                        }
                        else
                        {
                            $data = $this->MY_Model->SelectSingleRecord('category','*',$udata=array("is_deleted"=>"0","parent_id"=>$parent_id),'order_id asc'); 

                        if(!empty($data))
                        {
                            // print_r($data); die;
                            $level++;
                            $parent_id = $data->id;
    
                            $cname[$value['title']][$result['id']][$parent_id][] = ['id'=>$data->id,'parent_id'=>$data->parent_id,'cname'=>$data->title,'level'=>$data->level,'order_id'=>$data->order_id,'description'=>$data->description,'image'=>$data->image,'icon'=>$data->icon];
    
                             // $arr[]  = ['id'=>$data->id, 'parent_id'=>$data->parent_id,'cname'=>$data->title,'level'=>$data->level,'order_id'=>$data->order_id,'description'=>$data->description,'image'=>$data->image,'icon'=>$data->icon];

                             $arr[]  = ['id'=>$data->id,'cname'=>$data->title,'description'=>$data->description,'image'=>$data->image];
                            // print_r($arr);die();           
                        }
                        else
                        { break; }
                    }
                } 
            }
            $result_set  = $arr; 
            $arr    = []; 
         }
            if (empty($result_set)) 
            {
                // $this->res->status = 'Failed';
                $this->res->success = 'false';
                $this->_error('error', 'Incorrect data.');
            } else 
            {
                $this->res->success = 'true';
                $this->res->data = $result_set;
            }
            $this->_output();
              exit();
            // print_r($result_set); die;
            // $datas->categories = $result_set;
    }
    //---------------------*-------------------
    public function PostJobsProposal()
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
            $this->_error('error', 'Invalid accesstoken.');
        }  
        $this->_output();
        exit();
    }
    //---------------------*-------------------
    public function GetJobsProposal()
    { 
        $request = json_decode(rtrim(file_get_contents('php://input'), "\0"));
        $header = $this->input->request_headers();
        $id = $request->job_post_id;    
        $user_id = $request->user_id;    
        $accesstoken = $header['Accesstoken'];
         // print_r($accesstoken);die();
        if($this->check_accesstoken($user_id,$accesstoken))
        {
           // $res = $this->Core_Model->joindataResult($place1 =' job_post.service_id', $place2 = 'category.id',$where='','job_post.user_id,job_post.service_id,job_post.id,job_post.description,job_post.budget,category.id,category.title','category','job_post',$order='');
            $res = $this->MY_Model->SelectRecord('proposal','*',$udata=array("is_deleted"=>"0","job_post_id"=>$id),'id asc');
            // print_r($res);die();
            $userdata = [];
            foreach ($res as $key => $value)
            {
                $arr[]  = ['id'=>($value['id']) ? $value['id'] : '','job_post_id'=>($value['job_post_id']) ? $value['job_post_id'] : '','user_id'=>($value['user_id']) ? $value['user_id'] : '','description'=>($value['description']) ? $value['description'] : '','bid_value'=>($value['bid_value']) ? $value['bid_value'] : '','day' => ($value['day']) ? $value['day'] : ''];
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

        }else
        {
            // $this->res->status = 'Failed';
            $this->_error('error', 'Invalid accesstoken.');
        }  
        $this->_output();
        exit();
    }
    //---------------------*-------------------
    public function awardedUser()
    { 
        $request = json_decode(rtrim(file_get_contents('php://input'), "\0"));
        $header = $this->input->request_headers();
        $id = $request->job_post_id;    
        $user_id = $request->user_id;    
        // $status = $request->status;    
        $awardedProposalId = $request->awardedProposalId;    
         // print_r($awarded_user);die();
        $accesstoken = $header['Accesstoken'];
        if($this->check_accesstoken($user_id,$accesstoken))
        {
            $where_login = array('id' => $id,'user_id' => $user_id);
            $where_update = array('id' => $id,'user_id' => $user_id);
            $field_update = array('awardedProposalId' => $awardedProposalId);
            $result = $this->Core_Model->updateFields('job_post', $field_update, $where_update);
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
            $this->_error('error', 'Invalid accesstoken.');
        }  
        $this->_output();
        exit();
    }
    //---------------------*-------------------
     function update_profile()
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
            $password = $request->password; 
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
            if (!$password) {
            $this->_error('Form error', 'Password is not specified.');
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
            $field_update = array('name' => $name,'contact' => $contact,'gender' => $gender,'dob' => $dob,'image' => $image,'password' => $password,'about' => $about);

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
            $this->_error('error', 'Invalid accesstoken.');
        }  
    $this->_output();
        exit();
    }
    //---------------------*-------------------
    function reviewRatePost()
    { 
        $request = json_decode(rtrim(file_get_contents('php://input'), "\0"));
        $header = $this->input->request_headers();
        $senderId = $request->senderId;    
        $accesstoken = $header['Accesstoken'];
         // print_r($accesstoken);die();
        if($this->check_accesstoken($senderId,$accesstoken))
        {        
            $request = json_decode(rtrim(file_get_contents('php://input'), "\0"));
            // $senderId = $request->senderId;
            $user_id = $request->user_id;
            $review = $request->review;
            $rating = $request->rating;
            $job_post_id = $request->job_post_id; 

            if (!$senderId) {
            $this->_error('Form error', 'Sender Id is not specified.');
            return false;
            }
             if (!$user_id) {
            $this->_error('Form error', 'User Id is not specified.');
            return false;
            }
            if (!$job_post_id) {
            $this->_error('Form error', 'Job Post Id is not specified.');
            return false;
            }

            $where = array('senderId'=>$senderId,'receiverId'=>$user_id,'review'=>$review,'rating'=>$rating,'job_post_id'=>$job_post_id);
            // print_r($where);die;
            $get_data = $this->Core_Model->InsertRecord('review', $where);

            $this->db->select('proposal.*,users.name,job_post.job_title');    
            $this->db->from('proposal');
            $this->db->join('users', 'proposal.user_id = users.id');
            $this->db->join('job_post', 'proposal.job_post_id = job_post.id');
            $this->db->where('proposal.user_id',$user_id);
            $query=$this->db->get();
            $result1= $query->result_array();
            // print_r($data);die();
            $userdata = [];
            foreach ($result1 as $key=>$total) 
            {
                // print_r($total);die();
                $user_id = $total['user_id'];
                $where3 = array('receiverId' => $user_id);
                $result3 = $this->Core_Model->SelectRecord('review', '*', $where3, $order = '');
                $totalrating = 0;
                 foreach ($result3 as $total3) 
                {
                //     $totalrating += $total3['rating'];
                //     // $total_review = $total3['review'];
                // }
                // $rating = 0;
                // if(count($result3)){
                //     $rating = $totalrating/count($result3);  
                // // print_r($rating);die();
                }
            }
            $userdata[] = Array('user_id' => $total['user_id'],'job_post_id' => $total['job_post_id'],'name' => $total['name'],'job_title' => $total['job_title'],'created_date' => $total3['created_date'],'bid_value' => $total['bid_value'],'review' => $total3['review'],'rating' => $total3['rating']);
            // die;
            if (empty($userdata)) 
            {
                $this->res->success = false;
                $this->_error('error', 'Incorrect id or data.');
            } else
             {
                $this->res->success = 'true';
                $this->res->data = $userdata;
                $this->res->message = 'Rating added Successfully';
            }
        }else
        {
            // $this->res->status = 'Failed';
            $this->_error('error', 'Invalid accesstoken.');
        }  
        $this->_output();
            exit();
    }    
    //---------------------*-------------------    
    function getServiceProvider() //pending 03-08-2019
    { 
        $request = json_decode(rtrim(file_get_contents('php://input'), "\0"));
        $service_id = $request->service_id;
        // $address = $request->location;
        // print_r($service_id);die();
        $where = "CONCAT(',', services_search, ',') 
            LIKE '%,".$service_id.",%' ";
        // $where =  array('user_id' =>$user_id);
            // print_r($where);die();
        $result = $this->Core_Model->SelectRecord('service_provider', '*', $where, $order = '');
            // print_r($result);die();
        $proposal_data = [];
        foreach ($result as $value)
        {
            $sp_data[] = array($value['spId']);
        }      
            // $where2 =  array('id',$sp_data);
            // print_r($sp_data);die();
            // $res = $this->Core_Model->joindataResult($place1 ='proposal.user_id', $place2 = 'users.id',$where,'proposal.id,proposal.user_id,proposal.job_post_id,proposal.bid_value,users.name','users','proposal',$order='');

            // $res = $this->Core_Model->joindataResult2($place1 ='proposal.user_id', $place2 = 'users.id',$where2,',proposal.user_id,proposal.id,proposal.job_post_id,users.name,proposal.description,users.address,users.image','users','proposal',$order='');

            // $categories = array('10', '12');
            $this->db->select('*');
            $this->db->from('proposal');
            $this->db->join('users','users.id = proposal.user_id');
            $this->db->where_in('users.id',$sp_data);
            $query = $this->db->get();
            print_r($query);die();
            $result1= $query->result_array();

            //PENDING WORK HERE 1IMAGE,NAME,ADDRESS-USERS!description-PROPOSAL TABLE!rating-REVIEW TABLE
            // $this->db->select('proposal.*,users.name,users.address,users.image,job_post.job_title');    
            // $this->db->from('proposal');
            // $this->db->join('users', 'proposal.user_id = users.id');
            // $this->db->join('job_post', 'proposal.job_post_id = job_post.id');
            // $this->db->where('proposal.user_id',$user_id);
            // $query=$this->db->get();
            // $result1= $query->result_array();
            // print_r($data);die();

            print_r($res);die();
            $userdata = [];
            foreach ($res as $key=>$total) 
            {
            print_r($total);die();
                $user_id = $total['user_id'];
                $where3 = array('receiverId' => $user_id);
                $result3 = $this->Core_Model->SelectRecord('review', '*', $where3, $order = '');
                $totalrating = 0;
                 foreach ($result3 as $total3) 
                {
                    $totalrating += $total3['rating'];
                }               

                $rating = 0;
                if(count($result3)){
                    $rating = $totalrating/count($result3);  
                // print_r($rating);die();

                }
                   $userdata[] = ['user_id' => $total['user_id'],'job_post_id' => $total['job_post_id'],'name' => $total['name'],'bid_value' => $total['bid_value'],'rating' => $rating];
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

    //---------------------*-------------------
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

    //---------------------*-------------------

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

    //---------------------*-------------------

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

    //---------------------*-------------------

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

    //---------------------*-------------------

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

    //---------------------*-------------------

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

//---------------------*-------------------

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

    //---------------------*-------------------

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

    //---------------------*-------------------

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

    //---------------------*-------------------

    public function create_order_no()

        {

            $order = "ORDER_".uniqid();                   

            if($this->MY_Model->SelectRecord('order','*',array("order_no"=>$order),$orderby=array())){

                $this->create_order_no();

            }

            return $order;

        }

    //---------------------*-------------------

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

    //---------------------*-------------------

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

     //---------------------*-------------------

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

     //---------------------*-------------------

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

    //---------------------*-------------------

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

    //---------------------*-------------------

    function _output() {

        // header('Content-Type: application/json');

        //$this->res->request = $this->req->request;

        $this->res->datetime = date('Y-m-d\TH:i:sP');

        echo json_encode($this->res);

    }

    //---------------------*-------------------

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



?>