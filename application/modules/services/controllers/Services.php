<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Services extends MY_Controller 
{
	//private $connection;
        public function __construct(){
            parent::__construct();
            $this->load->model('services_model');
            if( $this->session->userdata('user_group_id') != 3){
                redirect('admin');
            }            
        }
        public function index(){
            if(!$this->session->userdata('logged_in')){
                redirect('admin');
            }
            
            $datas=new stdClass();
            if($this->session->flashdata('item')) {
                $items = $this->session->flashdata('item');
                if($items->success){
                    $datas->error=0;
                    $datas->success=1;
                    $datas->message=$items->message;
                }else{
                    $datas->error=1;
                    $datas->success=0;
                    $datas->message=$items->message;
                }                
            }            
                        
            $services = $this->services_model->SelectRecord('services','*',$udata=array("is_deleted"=>"0"),'id asc');
            $datas->services = $services;
            $udata = array("id"=>$this->session->userdata('user_id'));                
            $datas->result = $this->services_model->SelectSingleRecord('admin','*',$udata,$orderby=array());
            $datas->website_title = $this->services_model->SelectSingleRecord('settings','*',$udata=array("field_key"=>"website_title"),$orderby=array());
            $datas->title = 'List Services';
            $datas->field = 'Datatable';
            $datas->page = 'list_services';
            $this->load->view('admin/includes/header',$datas);		
            $this->load->view('list_services_view',$datas);
            $this->load->view('admin/includes/footer',$datas);		
        }
        
        public function add(){
            
            $datas=new stdClass();
            if($this->session->flashdata('item')) {
                $items = $this->session->flashdata('item');
                if($items->success){
                    $datas->error=0;
                    $datas->success=1;
                    $datas->message=$items->message;
                }else{
                    $datas->error=1;
                    $datas->success=0;
                    $datas->message=$items->message;
                }
                
            }
            
            ///print_r($data); die;
            if(!empty($_POST)){
               // print_r($_POST);die;
               $udata['category_id'] = $this->input->post('category');                              
               //print_r($orderid); die;                                             
               $udata['title'] = $this->input->post('name');
               $udata['description'] = $this->input->post('description');
               $udata['icon'] = $this->input->post('icon');
                              
               //print_r($udata); die;
               if($this->services_model->InsertRecord('services',$udata)){
                    $data->error=0;
                    $data->success=1;
                    $data->message="Service Added Successfully";
               }else{
                    $data->error=1;
                    $data->success=0;
                    $data->message="Network Error";
               }
               $this->session->set_flashdata('item',$data);
               redirect('services/add');
            }
            
            $html = "";
            $categories2 = $this->services_model->SelectRecord('category','*',$udata=array("status"=>"1","is_deleted"=>"0","parent_id"=>"0"),'order_id asc');
            $cname = [];
            $level = 1; 
    
            foreach ($categories2 as $key => $value) {
                 
                $cname[$value['title']][] = ['id'=>$value['id'], 'cname'=>$value['title'],'level'=>$value['level']];
    
                $arr[] = ['id'=>$value['id'], 'parent_id'=>$value['parent_id'], 'cname'=>$value['title'],'level'=>$value['level'],'order_id'=>$value['order_id']];
    
    
                $html .= str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $value['level']).$value['title'];
                $r = '';
                $html  .= '<br>';
    
                $cat = $this->services_model->SelectRecord('category','*',$udata=array("status"=>"1","is_deleted"=>"0","parent_id"=>$value['id']),'order_id asc');             
    
                foreach ($cat as $key => $result) {
                    $parent_id = $result['id']; 
    
                    $cname[$value['title']][$result['id']][] = ['id'=>$result['id'], 'parent_id'=>$result['parent_id'],'cname'=>$result['title'],'level'=>$result['level'],'order_id'=>$result['order_id']];
                    $html  .= str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $result['level']).$result['title'];
                    $r = $result['id'];
                    $html  .= '<br>';
                    $arr[] = ['id'=>$result['id'], 'parent_id'=>$result['parent_id'], 'cname'=>$result['title'],'level'=>$result['level'],'order_id'=>$result['order_id']];
    
                    while (1) {
    
                        $data = $this->services_model->SelectRecord('category','*',$udata=array("status"=>"1","is_deleted"=>"0","parent_id"=>$parent_id),'order_id asc');
                        
                        if(count($data)>1){
    
                            foreach ($data  as $key => $data) {
                                 if($data)
                                {
                                    $level++;
                                    $parent_id = $data['id'];
    
                                    $cname[$value['title']][$result['id']][$parent_id][] = ['id'=>$data['id'],'parent_id'=>$data['parent_id'],'cname'=>$data['title'],'level'=>$data['level'],'order_id'=>$data['order_id']];
    
                                     $html  .= str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $data['level']).$data['title'];
                                     $r         = $data['id'];
                                     $html  .= '<br>';
                                     $arr[]  = ['id'=>$data['id'], 'parent_id'=>$data['parent_id'],'cname'=>$data['title'],'level'=>$data['level'],'order_id'=>$data['order_id']];
                                }else{
                                    break;
                            }
                            }
    
                        }else{
                            $data = $this->services_model->SelectSingleRecord('category','*',$udata=array("status"=>"1","is_deleted"=>"0","parent_id"=>$parent_id),'order_id asc');                            
    
                        if(!empty($data))
                        {
                            //print_r($data); die;
                            
                            $level++;
                            $parent_id = $data->id;
    
                            $cname[$value['title']][$result['id']][$parent_id][] = ['id'=>$data->id,'parent_id'=>$data->parent_id,'cname'=>$data->title,'level'=>$data->level,'order_id'=>$data->order_id];
    
                             $html  .= str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $data->level).$data->title;
                             $r         = '';
                             $html  .= '<br>';
                             $arr[]  = ['id'=>$data->id, 'parent_id'=>$data->parent_id,'cname'=>$data->title,'level'=>$data->level,'order_id'=>$data->order_id];
                        }else{
                            break;
                        }
                        }
                    } 
                }
                $result_set[$value['id']]  = $arr; 
                $arr    = []; 
            }
            $datas->categories = $result_set;
            //print_r($result_set); die;
            $udata = array("id"=>$this->session->userdata('user_id'));                
            $datas->result = $this->services_model->SelectSingleRecord('admin','*',$udata,$orderby=array());
            $datas->website_title = $this->services_model->SelectSingleRecord('settings','*',$udata=array("field_key"=>"website_title"),$orderby=array());
            $datas->title = 'Services';
            $datas->field = 'Services';
            $datas->page = 'add_services';
            $this->load->view('admin/includes/header',$datas);		
            $this->load->view('add_services_view',$datas);
            $this->load->view('admin/includes/footer',$datas);                                        
        }
                               
        public function edit($id){
            
            $datas=new stdClass();
            $id = base64_decode($id);
            if($this->session->flashdata('item')) {
                $items = $this->session->flashdata('item');
                if($items->success){
                    $datas->error=0;
                    $datas->success=1;
                    $datas->message=$items->message;
                }else{
                    $datas->error=1;
                    $datas->success=0;
                    $datas->message=$items->message;
                }
                
            }
            
            ///print_r($data); die;
            if(!empty($_POST)){
                //print_r($_POST);die;
               $udata['category_id'] = $this->input->post('category');                              
               //print_r($orderid); die;                                             
               $udata['title'] = $this->input->post('name');
               $udata['description'] = trim($this->input->post('description'));
               $udata['icon'] = $this->input->post('icon');
               $udata['status'] = $this->input->post('status');
               
               if($this->services_model->UpdateRecord('services',$udata,array("id"=>$id))){
                    $data->error=0;
                    $data->success=1;
                    $data->message="Service Updated Successfully";
               }else{
                    $data->error=1;
                    $data->success=0;
                    $data->message="Network Error";
               }
               $this->session->set_flashdata('item',$data);
               redirect('services/edit/'.base64_encode($id));
            }
            
            $html = "";
            $categories2 = $this->services_model->SelectRecord('category','*',array("status"=>"1","is_deleted"=>"0","parent_id"=>"0"),'order_id asc');
            $cname = [];
            $level = 1; 
    
            foreach ($categories2 as $key => $value) {
                 
                $cname[$value['title']][] = ['id'=>$value['id'], 'cname'=>$value['title'],'level'=>$value['level']];
    
                $arr[] = ['id'=>$value['id'], 'parent_id'=>$value['parent_id'], 'cname'=>$value['title'],'level'=>$value['level'],'order_id'=>$value['order_id']];
    
    
                $html .= str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $value['level']).$value['title'];
                $r = '';
                $html  .= '<br>';
    
                $cat = $this->services_model->SelectRecord('category','*',$udata=array("status"=>"1","is_deleted"=>"0","parent_id"=>$value['id']),'order_id asc');             
    
                foreach ($cat as $key => $result) {
                    $parent_id = $result['id']; 
    
                    $cname[$value['title']][$result['id']][] = ['id'=>$result['id'], 'parent_id'=>$result['parent_id'],'cname'=>$result['title'],'level'=>$result['level'],'order_id'=>$result['order_id']];
                    $html  .= str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $result['level']).$result['title'];
                    $r = $result['id'];
                    $html  .= '<br>';
                    $arr[] = ['id'=>$result['id'], 'parent_id'=>$result['parent_id'], 'cname'=>$result['title'],'level'=>$result['level'],'order_id'=>$result['order_id']];
    
                    while (1) {
    
                        $data = $this->services_model->SelectRecord('category','*',$udata=array("status"=>"1","is_deleted"=>"0","parent_id"=>$parent_id),'order_id asc');
                        
                        if(count($data)>1){
    
                            foreach ($data  as $key => $data) {
                                 if($data)
                                {
                                    $level++;
                                    $parent_id = $data['id'];
    
                                    $cname[$value['title']][$result['id']][$parent_id][] = ['id'=>$data['id'],'parent_id'=>$data['parent_id'],'cname'=>$data['title'],'level'=>$data['level'],'order_id'=>$data['order_id']];
    
                                     $html  .= str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $data['level']).$data['title'];
                                     $r         = $data['id'];
                                     $html  .= '<br>';
                                     $arr[]  = ['id'=>$data['id'], 'parent_id'=>$data['parent_id'],'cname'=>$data['title'],'level'=>$data['level'],'order_id'=>$data['order_id']];
                                }else{
                                    break;
                            }
                            }
    
                        }else{
                            $data = $this->services_model->SelectSingleRecord('category','*',$udata=array("status"=>"1","is_deleted"=>"0","parent_id"=>$parent_id),'order_id asc');                            
    
                        if(!empty($data))
                        {
                            //print_r($data); die;
                            
                            $level++;
                            $parent_id = $data->id;
    
                            $cname[$value['title']][$result['id']][$parent_id][] = ['id'=>$data->id,'parent_id'=>$data->parent_id,'cname'=>$data->title,'level'=>$data->level,'order_id'=>$data->order_id];
    
                             $html  .= str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $data->level).$data->title;
                             $r         = '';
                             $html  .= '<br>';
                             $arr[]  = ['id'=>$data->id, 'parent_id'=>$data->parent_id,'cname'=>$data->title,'level'=>$data->level,'order_id'=>$data->order_id];
                        }else{
                            break;
                        }
                        }
                    } 
                }
                $result_set[$value['id']]  = $arr; 
                $arr    = []; 
            }
            $datas->categories = $result_set;
            
            $datas->reslt = $this->services_model->SelectSingleRecord('services','*',array('id'=>$id),$orderby=array());
            $udata = array("id"=>$this->session->userdata('user_id'));                
            $datas->result = $this->services_model->SelectSingleRecord('admin','*',$udata,$orderby=array());
            $datas->website_title = $this->services_model->SelectSingleRecord('settings','*',$udata=array("field_key"=>"website_title"),$orderby=array());
            $datas->title = 'Services';
            $datas->field = 'Services';
            $datas->page = 'edit_services';
            $this->load->view('admin/includes/header',$datas);		
            $this->load->view('edit_services_view',$datas);
            $this->load->view('admin/includes/footer',$datas);                                        
        }                        
        
        public function delete($id){
            $id = base64_decode($id);
            $data=new stdClass();
            if($this->services_model->UpdateRecord('services',array("is_deleted"=>1),array("id"=>$id))){
                $data->error=0;
                $data->success=1;
                $data->message="Service Deleted Successfully";
            }else{
                $data->error=1;
                $data->success=0;
                $data->message="Network Error";
            }
            $this->session->set_flashdata('item',$data);
            redirect('services');
        }
        
        
         public function add_options(){
            
            $datas=new stdClass();
            if($this->session->flashdata('item')) {
                $items = $this->session->flashdata('item');
                if($items->success){
                    $datas->error=0;
                    $datas->success=1;
                    $datas->message=$items->message;
                }else{
                    $datas->error=1;
                    $datas->success=0;
                    $datas->message=$items->message;
                }
                
            }
            
            ///print_r($data); die;
            if(!empty($_POST)){
               // print_r($_POST);die;
               $udata['service_id'] = $this->input->post('service_id');                                             
               $udata['field_key'] = $this->input->post('field_key');
               $udata['field_name'] = $this->input->post('field_name');
               $udata['field_type'] = $this->input->post('field_type');
               $udata['list_name'] = $this->input->post('list_name');
               $udata['field_value'] = $this->input->post('field_value');
               $udata['field_icon'] = $this->input->post('field_icon');
               $udata['is_required'] = $this->input->post('is_required');
               $udata['is_multiple'] = $this->input->post('is_multiple');
               $udata['status'] = $this->input->post('status');                                  
                   
                   $udata['field_position'] = 0;
                   if($this->input->post('list_name')){
                        $is_service_option_exist = $this->services_model->SelectSingleRecord('options','*',array("service_id"=>$this->input->post('service_id'),"status"=>"1","is_deleted"=>"0"),'id desc');
                        if($is_service_option_exist){
                            $is_listname_exist = $this->services_model->SelectSingleRecord('options','*',array("list_name"=>$this->input->post('list_name'),"service_id"=>$this->input->post('service_id'),"status"=>"1","is_deleted"=>"0"),'id desc');                    
                            if($is_listname_exist){                             
                                $udata['field_position'] = $is_listname_exist->field_position;
                            }else{
                                $udata['field_position'] = $is_service_option_exist->field_position + 1;
                            } 
                           
                        }else{
                             $udata['field_position'] = 0;
                        }                        
                   }else{
                        $is_service_option_exist = $this->services_model->SelectSingleRecord('options','*',array("service_id"=>$this->input->post('service_id'),"status"=>"1","is_deleted"=>"0"),'id desc');                   
                        if($is_service_option_exist){                    
                           $udata['field_position'] = $is_service_option_exist->field_position + 1;
                        }else{
                             $udata['field_position'] = 0;
                        }
                   }
               
               //print_r($udata); die;
               if($this->services_model->InsertRecord('options',$udata)){
                    $data->error=0;
                    $data->success=1;
                    $data->message="Option Added Successfully";
               }else{
                    $data->error=1;
                    $data->success=0;
                    $data->message="Network Error";
               }
               $this->session->set_flashdata('item',$data);
               redirect('services/add_options');
            }
                        
            $services = $this->services_model->SelectRecord('services','*',array("status"=>"1","is_deleted"=>"0"),'id asc');
            //print_r($services);die;
            $arr = array();
            foreach ($services as $key => $item) {                
               $arr[$item['category_id']][$key] = $item;
            }            
            ksort($arr, SORT_NUMERIC);
            
            $datas->services = $arr;
            //print_r($arr); die;
            $udata = array("id"=>$this->session->userdata('user_id'));                
            $datas->result = $this->services_model->SelectSingleRecord('admin','*',$udata,$orderby=array());
            $datas->website_title = $this->services_model->SelectSingleRecord('settings','*',$udata=array("field_key"=>"website_title"),$orderby=array());
            $datas->title = 'Options';
            $datas->field = 'Options';
            $datas->page = 'add_options';
            $this->load->view('admin/includes/header',$datas);		
            $this->load->view('add_options_view',$datas);
            $this->load->view('admin/includes/footer',$datas);                                        
        }
        
        public function list_options(){
            if(!$this->session->userdata('logged_in')){
                redirect('admin');
            }
            
            $datas=new stdClass();
            if($this->session->flashdata('item')) {
                $items = $this->session->flashdata('item');
                if($items->success){
                    $datas->error=0;
                    $datas->success=1;
                    $datas->message=$items->message;
                }else{
                    $datas->error=1;
                    $datas->success=0;
                    $datas->message=$items->message;
                }                
            }            
                        
            $options = $this->services_model->SelectRecord('options','*',$udata=array("status"=>"1","is_deleted"=>"0"),'id asc');
            $datas->options = $options;
            $udata = array("id"=>$this->session->userdata('user_id'));                
            $datas->result = $this->services_model->SelectSingleRecord('admin','*',$udata,$orderby=array());
            $datas->website_title = $this->services_model->SelectSingleRecord('settings','*',$udata=array("field_key"=>"website_title"),$orderby=array());
            $datas->title = 'List Options';
            $datas->field = 'Datatable';
            $datas->page = 'list_options';
            $this->load->view('admin/includes/header',$datas);		
            $this->load->view('list_options_view',$datas);
            $this->load->view('admin/includes/footer',$datas);		
        }
        
        public function edit_options($id){
            
            $datas=new stdClass();
            $id = base64_decode($id);
            if($this->session->flashdata('item')) {
                $items = $this->session->flashdata('item');
                if($items->success){
                    $datas->error=0;
                    $datas->success=1;
                    $datas->message=$items->message;
                }else{
                    $datas->error=1;
                    $datas->success=0;
                    $datas->message=$items->message;
                }
                
            }
            
            ///print_r($data); die;
            if(!empty($_POST)){
                //print_r($_POST);die;
               $udata['service_id'] = $this->input->post('service_id');                                             
               $udata['field_key'] = $this->input->post('field_key');
               $udata['field_name'] = $this->input->post('field_name');
               $udata['field_type'] = $this->input->post('field_type');
               $udata['list_name'] = $this->input->post('list_name');
               $udata['field_value'] = $this->input->post('field_value');
               $udata['field_icon'] = $this->input->post('field_icon');
               $udata['is_required'] = $this->input->post('is_required');
               $udata['is_multiple'] = $this->input->post('is_multiple');
               $udata['status'] = $this->input->post('status');                                  
                   
                   if($this->input->post('list_name')){                    
                        $is_listname_exist = $this->services_model->SelectSingleRecord('options','*',array("list_name"=>$this->input->post('list_name'),"service_id"=>$this->input->post('service_id'),"status"=>"1","is_deleted"=>"0"),'id desc');                    
                        if($is_listname_exist){                             
                             $udata['field_position'] = 0;
                        }
                   }else{
                        $is_service_option_exist = $this->services_model->SelectSingleRecord('options','*',array("service_id"=>$this->input->post('service_id'),"status"=>"1","is_deleted"=>"0"),'id desc');                   
                        if($is_service_option_exist){                    
                           $udata['field_position'] = $is_service_option_exist->field_position + 1;
                        }else{
                             $udata['field_position'] = 0;
                        }
                   }
               //print_r($udata); die;                
               
               if($this->services_model->UpdateRecord('options',$udata,array("id"=>$id))){
                    $data->error=0;
                    $data->success=1;
                    $data->message="Option Updated Successfully";
               }else{
                    $data->error=1;
                    $data->success=0;
                    $data->message="Network Error";
               }
               $this->session->set_flashdata('item',$data);
               redirect('services/edit_options/'.base64_encode($id));
            }
            
            $services = $this->services_model->SelectRecord('services','*',array("status"=>"1","is_deleted"=>"0"),'id asc');
            //print_r($services);die;
            $arr = array();
            foreach ($services as $key => $item) {                
               $arr[$item['category_id']][$key] = $item;
            }            
            ksort($arr, SORT_NUMERIC);
            
            $datas->services = $arr;
            $datas->id = $id;
            $datas->option = $this->services_model->SelectSingleRecord('options','*',array('id'=>$id),$orderby=array());
            
            $datas->result = $this->services_model->SelectSingleRecord('admin','*',array("id"=>$this->session->userdata('user_id')),$orderby=array());
            $datas->website_title = $this->services_model->SelectSingleRecord('settings','*',$udata=array("field_key"=>"website_title"),$orderby=array());
            $datas->title = 'Options';
            $datas->field = 'Options';
            $datas->page = 'edit_options';
            $this->load->view('admin/includes/header',$datas);		
            $this->load->view('edit_options_view',$datas);
            $this->load->view('admin/includes/footer',$datas);                                        
        }
        
        public function delete_options($id){
            $id = base64_decode($id);
            $data=new stdClass();
            if($this->services_model->UpdateRecord('options',array("is_deleted"=>1),array("id"=>$id))){
                $data->error=0;
                $data->success=1;
                $data->message="Option Deleted Successfully";
            }else{
                $data->error=1;
                $data->success=0;
                $data->message="Network Error";
            }
            $this->session->set_flashdata('item',$data);
            redirect('services/list_options');
        }
                		        	
}
?>