<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cities extends MY_Controller 
{
	//private $connection;
        public function __construct(){ 
            parent::__construct();
			
            $this->load->model('cities_model'); 			
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
            $data->result = $this->cities_model->SelectSingleRecord('admin','*',$udata,$orderby=array());
			 $data->cities = $this->cities_model->SelectRecord('cities','*','','');
	  	  
            $data->title = 'Cities';
            $data->field = '';
            $data->page = 'list_city';
            $this->load->view('admin/includes/header',$data);		
            $this->load->view('cities_view',$data);
            $this->load->view('admin/includes/footer',$data);		
        }
		
		public function addcity(){
			
			$data=new stdClass();
			$udata = array("id"=>$this->session->userdata('user_id'));                
            $data->result = $this->cities_model->SelectSingleRecord('admin','*',$udata,$orderby=array());
			if($this->input->post()){
				$datas['title'] = $this->input->post('title');
				//$datas['status'] = $this->input->post('status');
					$res = $this->cities_model->InsertRecord('cities',$datas);
					
			 if($res) {
               // $items = $this->session->flashdata('item');
               
                    $data->error=0;
                    $data->success=1;
                    $data->message= "City Added Successfully";
                }else{
                    $data->error=1;
                    $data->success=0;
                    $data->message= "City Not Added";
                } 
					$this->session->set_flashdata('item',$data);
			}			
			
            $data->title = 'Add City';
            $data->field = '';
            $data->page = 'addcity';
            $this->load->view('admin/includes/header',$data);		
            $this->load->view('add_city_view',$data);
            $this->load->view('admin/includes/footer',$data);	
		}
        
        public function editcity($id){				
           $data=new stdClass();
			$udata = array("id"=>$this->session->userdata('user_id')); 
			$id = base64_decode($id);
			$where = array("id" => $id);	
            $data->result = $this->cities_model->SelectSingleRecord('admin','*',$udata,$orderby=array());
			$data->city = $this->cities_model->SelectSingleRecord('cities','*',$where,$orderby=array());
			
			if($this->input->post()){
				$id = $this->input->post('id');
				$where = array('id' => $id);
				$datas['title'] = $this->input->post('title');
				$datas['status'] = $this->input->post('status');
					$res = $this->cities_model->UpdateRecord('cities',$datas, $where);					
			 if($res) {
               // $items = $this->session->flashdata('item');
               
                    $data->error=0;
                    $data->success=1;
                    $data->message= "City Updated Successfully";
                }else{
                    $data->error=1;
                    $data->success=0;
                    $data->message= "City Not Updated";
                } 
					$this->session->set_flashdata('item',$data);	
					redirect("cities");
			}			
			
            $data->title = 'Edit City';
            $data->field = '';
            $data->page = 'editcity';
            $this->load->view('admin/includes/header',$data);		
            $this->load->view('edit_city_view',$data);
            $this->load->view('admin/includes/footer',$data);	
        }   

            public function delete($id){
            if($this->session->userdata('user_group_id') != 3){
                redirect('admin');
            }
            $data=new stdClass();
            if($this->cities_model->UpdateRecord('cities',array('is_deleted' => '1'),array("id"=>base64_decode($id)))){
			
                $data->error=0;
                $data->success=1;
                $data->message="Deleted Successfully";
            }else{
                $data->error=1;
                $data->success=0;
                $data->message="City not Deleted";
            }					
            $this->session->set_flashdata('item',$data);				
            redirect("cities");
        }   
                		        	
}
?>