<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Blogs extends MY_Controller 
{
	//private $connection;
        public function __construct(){
            parent::__construct();
            $this->load->model('blogs_model');
            if( $this->session->userdata('user_group_id') != 3){
                redirect('admin');
            }
        }
        public function index()
        {   
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
            $data->results = $this->blogs_model->SelectRecord('blogs','*',array(),'id desc');
            $udata = array("id"=>$this->session->userdata('user_id'));                
            $data->result = $this->blogs_model->SelectSingleRecord('admin','*',$udata,$orderby=array());
            $data->title = 'List Blogs';
            $data->field = 'Datatable';
            $data->page = 'list_blogs';
            $this->load->view('admin/includes/header',$data);		
            $this->load->view('list_blogs_view',$data);
            $this->load->view('admin/includes/footer',$data);		
        }        
        public function add()
        {
            
            $data=new stdClass();
            if($this->session->flashdata('item')) 
            {
                $items = $this->session->flashdata('item');
                // print_r($this->session->flashdata('item'));die();
                if($items->success)
                {
                    $data->error=0;
                    $data->success=1;
                    $data->message=$items->message;
                }else{
                    $data->error=1;
                    $data->success=0;
                    $data->message=$items->message;
                }
                
            }
            
            // print_r($data); die;
            if(!empty($_POST))
            {
               // print_r($_POST);die;
                    if($_FILES)
                    {
                     // print_r($_FILES); die;
                     $config=[	'upload_path'	=>'./upload/blog/',
                             'allowed_types'	=>'jpg|gif|png|jpeg',
                             'file_name' => strtotime(date('y-m-d h:i:s')).$_FILES["image"]['name']
                         ];
                     // print_r($config); die;
                     $this->load->library ('upload',$config);
                     
                     if ($this->upload->do_upload('image'))
                     {                         
                         $idata = $this->upload->data();                    
                                         //resize profile image
                                         $config10['image_library'] = 'gd2';
                                         $config10['source_image'] = $idata['full_path'];
                                         $config10['new_image'] = './upload/blog/thumb/'.$idata['file_name'];
                                         $config10['maintain_ratio'] = False;
                                         $config10['width']         = 600;
                                         $config10['height']       = 400;
                                         
                                         $this->load->library('image_lib', $config10);
                                         
                                         $this->image_lib->resize();
                         $udata['image']= $idata['file_name'];                        
                     }
                     else
                     {
                         $data->error=1;
                         $data->success=0;
                         $data->message=$this->upload->display_errors(); 
                         $this->session->set_flashdata('item', $data);
                         redirect('blogs/add'); 
                     }
                 }
               
               $udata['title'] = $this->input->post('title');
               $udata['description'] = $this->input->post('description');
               $udata['tags'] = $this->input->post('tags');  
               if($this->blogs_model->InsertRecord('blogs',$udata))
               {
                    $data->error=0;
                    $data->success=1;
                    $data->message="Blogs Added Successfully";
               }else{
                    $data->error=1;
                    $data->success=0;
                    $data->message="Network Error";
               }
               $this->session->set_flashdata('item',$data);
               redirect('blogs/add');
            }
            $udata = array("id"=>$this->session->userdata('user_id'));                
            $data->result = $this->blogs_model->SelectSingleRecord('admin','*',$udata,$orderby=array());
            $data->title = 'Blogs';
            $data->field = 'Blogs';
            $data->page = 'add_blogs';
            $this->load->view('admin/includes/header',$data);		
            $this->load->view('add_blogs_view',$data);
            $this->load->view('admin/includes/footer',$data);                                        
        }
        
        public function edit($id)
        {
            
            $data=new stdClass();
            if($this->session->flashdata('item')) 
            {
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
            
            ///print_r($data); die;
                if(!empty($_POST))
                {
                
                    if($_FILES["image"]['name'])
                    {
                     //print_r($_FILES); die;
                     $config=[	'upload_path'	=>'./upload/blog/',
                             'allowed_types'	=>'jpg|gif|png|jpeg',
                             'file_name' => strtotime(date('y-m-d h:i:s')).$_FILES["image"]['name']
                         ];
                     //print_r(_FILES_); die;
                     $this->load->library ('upload',$config);
                     
                     if ($this->upload->do_upload('image'))
                     {                         
                         $idata = $this->upload->data();                    
                                         //resize profile image
                                         $config10['image_library'] = 'gd2';
                                         $config10['source_image'] = $idata['full_path'];
                                         $config10['new_image'] = './upload/blog/thumb/'.$idata['file_name'];
                                         $config10['maintain_ratio'] = TRUE;
                                         $config10['width']         = 600;
                                         $config10['height']       = 400;
                                         
                                         $this->load->library('image_lib', $config10);
                                         
                                         $this->image_lib->resize();
                         //print_r($udata); die;
                         $udata['image']= $idata['file_name'];                        
                     }
                     else
                     {
                         $data->error=1;
                         $data->success=0;
                         $data->message=$this->upload->display_errors(); 
                         $this->session->set_flashdata('item', $data);
                         redirect('blogs/add');	
                     }
                 }
               // print_r($_POST);die;
               $udata['title'] = $this->input->post('title');
               $udata['description'] = $this->input->post('description');
               $udata['tags'] = $this->input->post('tags');  
               if($this->blogs_model->UpdateRecord('blogs',$udata,array("id"=>$id))){
                    $data->error=0;
                    $data->success=1;
                    $data->message="Blogs Updated Successfully";
               }else{
                    $data->error=1;
                    $data->success=0;
                    $data->message="Network Error";
               }
               $this->session->set_flashdata('item',$data);
               redirect('blogs/edit/'.$id);
            }
            
            $data->reslt = $this->blogs_model->SelectSingleRecord('blogs','*',array('id'=>$id),$orderby=array());
            $udata = array("id"=>$this->session->userdata('user_id'));                
            $data->result = $this->blogs_model->SelectSingleRecord('admin','*',$udata,$orderby=array());
            $data->title = 'Blogs';
            $data->field = 'Blogs';
            $data->page = 'edit_blogs';
            $this->load->view('admin/includes/header',$data);		
            $this->load->view('edit_blogs_view',$data);
            $this->load->view('admin/includes/footer',$data);                                        
        }                        
        
        public function delete($id){
            $data=new stdClass();
            if($this->blogs_model->delete_record('blogs',array("id"=>$id))){
                $data->error=0;
                $data->success=1;
                $data->message="Blogs Deleted Successfully";
            }else{
                $data->error=1;
                $data->success=0;
                $data->message="Network Error";
            }
            $this->session->set_flashdata('item',$data);
            redirect('blogs');
        }
                		        	
}
?>