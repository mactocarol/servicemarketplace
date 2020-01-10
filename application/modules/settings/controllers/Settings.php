<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Settings extends MY_Controller 
{
	//private $connection;
        public function __construct(){ 
            parent::__construct();
            $this->load->model('settings_model'); 
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
            $udata = array("id"=>$this->session->userdata('user_id'));                
            $data->result = $this->settings_model->SelectSingleRecord('admin','*',$udata,$orderby=array());
	    
	    $data->website_title = $this->settings_model->SelectSingleRecord('settings','*',array('field_key'=>'website_title'),$orderby=array());
	    $data->front_page_heading = $this->settings_model->SelectSingleRecord('settings','*',array('field_key'=>'front_page_heading'),$orderby=array());
	    $data->front_page_subheading = $this->settings_model->SelectSingleRecord('settings','*',array('field_key'=>'front_page_subheading'),$orderby=array());
	    $data->welcome_content = $this->settings_model->SelectSingleRecord('settings','*',array('field_key'=>'welcome_content'),$orderby=array());
	    $data->welcome_image = $this->settings_model->SelectSingleRecord('settings','*',array('field_key'=>'welcome_image'),$orderby=array());
	    $data->create_account_subtitle = $this->settings_model->SelectSingleRecord('settings','*',array('field_key'=>'create_account_subtitle'),$orderby=array());
	    $data->featured_job_subtitle = $this->settings_model->SelectSingleRecord('settings','*',array('field_key'=>'featured_job_subtitle'),$orderby=array());
	    $data->iam_recruiter_subtitle = $this->settings_model->SelectSingleRecord('settings','*',array('field_key'=>'iam_recruiter_subtitle'),$orderby=array());
	    $data->iam_jobseeker_subtitle = $this->settings_model->SelectSingleRecord('settings','*',array('field_key'=>'iam_jobseeker_subtitle'),$orderby=array());
	    $data->how_it_works_subtitle = $this->settings_model->SelectSingleRecord('settings','*',array('field_key'=>'how_it_works_subtitle'),$orderby=array());
	    $data->how_it_works_register_account = $this->settings_model->SelectSingleRecord('settings','*',array('field_key'=>'how_it_works_register_account'),$orderby=array());
	    $data->how_it_works_search_job = $this->settings_model->SelectSingleRecord('settings','*',array('field_key'=>'how_it_works_search_job'),$orderby=array());
	    $data->how_it_works_apply_job = $this->settings_model->SelectSingleRecord('settings','*',array('field_key'=>'how_it_works_apply_job'),$orderby=array());
	    $data->trending_album_subtitle = $this->settings_model->SelectSingleRecord('settings','*',array('field_key'=>'trending_album_subtitle'),$orderby=array());
	    $data->footer_left_section = $this->settings_model->SelectSingleRecord('settings','*',array('field_key'=>'footer_left_section'),$orderby=array());
	    //echo "<pre>"; print_r($data->website_title); die;
            $data->title = 'Settings';
            $data->field = '';
            $data->page = 'settings';
            $this->load->view('admin/includes/header',$data);		
            $this->load->view('settings_view',$data);
            $this->load->view('admin/includes/footer',$data);		
        }
        
        public function update(){
            
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
            //print_r($_FILES);
            //print_r($_POST); die;
	    $is_there =	$this->settings_model->SelectSingleRecord('settings','*',array('field_key'=>'welcome_image'),$orderby=array());
	    if($_FILES['welcome_image']['name'] != ''){                               
	
			$upload_path = './upload/';
			$config['upload_path'] = $upload_path;
			$config['allowed_types'] = 'jpg|png|jpeg';                                                                    
			
			$this->load->library ('upload',$config);
	
			if ($this->upload->do_upload('welcome_image'))
			{                                    
			    $uploaddata = $this->upload->data();						    
			    $value = $uploaddata['file_name'];
			    
			    if(!empty($is_there)){
				$this->settings_model->UpdateRecord('settings',array('field_value'=>$value),array('field_key'=>'welcome_image'));
			     }else{
				$this->settings_model->InsertRecord('settings',array('field_key'=>'welcome_image','field_value'=>$value));
			     }
			}						
		}
            if(!empty($_POST)){		
		foreach($_POST as $key=>$value){
			if($key != 'Update_profile'){	
				$already =	$this->settings_model->SelectSingleRecord('settings','*',array('field_key'=>$key),$orderby=array());
				
				if(!empty($already)){
				   $this->settings_model->UpdateRecord('settings',array('field_value'=>$value),array('field_key'=>$key));
				}else{
				   $this->settings_model->InsertRecord('settings',array('field_key'=>$key,'field_value'=>$value));
				}
				
			}
		}
               
                    $data->error=0;
                    $data->success=1;
                    $data->message="Settings Updated Successfully";
               
               $this->session->set_flashdata('item',$data);
               
            }
            redirect('settings');
        }                
                		        	
}
?>