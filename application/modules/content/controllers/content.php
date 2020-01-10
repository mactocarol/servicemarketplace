<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Content extends HT_Controller 
{
	//private $connection;
        public function __construct(){
            parent::__construct();
            $this->load->model('content_model');
            if( $this->session->userdata('user_group_id') != 3){
                redirect('admin');
            }
        }
        public function index(){
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
            $data->results = $this->content_model->SelectRecord('content','*',array(),'id desc');
            $udata = array("id"=>$this->session->userdata('user_id'));                
            $data->result = $this->content_model->SelectSingleRecord('admin','*',$udata,$orderby=array());
            $data->title = 'List Content';
            $data->field = 'Datatable';
            $data->page = 'list_content';
            $this->load->view('admin/includes/header',$data);		
            $this->load->view('list_content_view',$data);
            $this->load->view('admin/includes/footer',$data);		
        }
        
        public function add(){
            
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
            
            ///print_r($data); die;
            if(!empty($_POST)){
               // print_r($_POST);die;
                    if($_FILES){
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
                                         $config10['maintain_ratio'] = False;
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
                         redirect('content/add');	
                     }
                 }
               
               $udata['title'] = $this->input->post('title');
               $udata['description'] = $this->input->post('description');
               $udata['tags'] = $this->input->post('tags');  
               if($this->content_model->InsertRecord('content',$udata)){
                    $data->error=0;
                    $data->success=1;
                    $data->message="Content Added Successfully";
               }else{
                    $data->error=1;
                    $data->success=0;
                    $data->message="Network Error";
               }
               $this->session->set_flashdata('item',$data);
               redirect('content/add');
            }
            $udata = array("id"=>$this->session->userdata('user_id'));                
            $data->result = $this->content_model->SelectSingleRecord('admin','*',$udata,$orderby=array());
            $data->title = 'Content';
            $data->field = 'Content';
            $data->page = 'add_content';
            $this->load->view('admin/includes/header',$data);		
            $this->load->view('add_content__view',$data);
            $this->load->view('admin/includes/footer',$data);                                        
        }
        
        public function edit($id=2){
            
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
            
            ///print_r($data); die;
                if(!empty($_POST)){
                
                    if($_FILES["image"]['name']){
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
                         redirect('content/edit');	
                     }
                 }
               // print_r($_POST);die;
               $udata['title'] = $this->input->post('title');
               $udata['description'] = $this->input->post('description');
               $udata['tags'] = $this->input->post('tags');  
               if($this->content_model->UpdateRecord('content',$udata,array("id"=>$id))){
                    $data->error=0;
                    $data->success=1;
                    $data->message="Content Updated Successfully";
               }else{
                    $data->error=1;
                    $data->success=0;
                    $data->message="Network Error";
               }
               $this->session->set_flashdata('item',$data);
               redirect('content/edit/');
            }
            
            $data->reslt = $this->content_model->SelectSingleRecord('content','*',array('id'=>$id),$orderby=array());
            $udata = array("id"=>$this->session->userdata('user_id'));                
            $data->result = $this->content_model->SelectSingleRecord('admin','*',$udata,$orderby=array());
            $data->title = 'Content';
            $data->field = 'Content';
            $data->page = 'edit_content';
            $this->load->view('admin/includes/header',$data);		
            $this->load->view('edit_content_view',$data);
            $this->load->view('admin/includes/footer',$data);                                        
        }                        
        
        public function delete($id){
            $data=new stdClass();
            if($this->content_model->delete_record('content',array("id"=>$id))){
                $data->error=0;
                $data->success=1;
                $data->message="Content Deleted Successfully";
            }else{
                $data->error=1;
                $data->success=0;
                $data->message="Network Error";
            }
            $this->session->set_flashdata('item',$data);
            redirect('content');
        }
                		        	
}
?>