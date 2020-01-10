<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends MY_Controller {

	 public function __construct(){
        parent::__construct();
        $this->load->model('welcome_model');
        $this->load->helper('my_helper');
        error_reporting(0);
    }
    
	public function index()
	{
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
                    
        $services = $this->welcome_model->SelectRecord('category','*',$udata=array("status"=>"1","level"=>0,"is_deleted"=>"0"),'id asc');
        $data->services = $services;
        $category = $this->welcome_model->SelectRecordlimit('services','*',$udata=array("status"=>"1","is_deleted"=>"0"),'id asc',8,'');
        $data->category = $category;
        $category3 = $this->welcome_model->mostPopularCategories();
        $data->category = $category3;
        
        $countServices = $this->welcome_model->countrecords('services',$WhereData=array("status"=>"1","is_deleted"=>"0"));
        $data->countServices = $countServices;
        $countCustomers = $this->welcome_model->countrecords('users',$WhereData=array("is_verified"=>"1","is_deleted"=>"0","user_type"=>"1"));
        $data->countCustomers = $countCustomers;
        $countVendors = $this->welcome_model->countrecords('users',$WhereData=array("is_verified"=>"1","is_deleted"=>"0","user_type"=>"2"));
        $data->countVendors = $countVendors;
        $countOrders = $this->welcome_model->countrecords('order_detail',$WhereData=array("order_status"=>"2"));
        $data->countOrders = $countOrders;
        
		$this->load->view('welcome_message',$data);
	}
    
    public function catalog($cat,$subcat=Null)
	{        
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
        
        if($subcat){
            $category = $this->welcome_model->SelectRecord('category','id,title,description,icon',$udata=array("status"=>"1","parent_id"=>$cat,"is_deleted"=>"0"),'id asc');
            $data->id = $subcat;            
        }else{
            $category = $this->welcome_model->SelectRecord('category','id,title,description,icon',$udata=array("status"=>"1","level"=>0,"is_deleted"=>"0"),'id asc');
            $data->id = $cat;
            $data->cat_name = '';
        }
        
        //print_r($category); die;
        $flag = 0;
        foreach($category as $key => $row){
            if(!empty($row)){
                $subcategory = $this->welcome_model->SelectRecord('category','id,title,description,icon',$udata=array("status"=>"1","parent_id"=>$row['id'],"is_deleted"=>"0"),'id asc');                            
                //foreach($subcategory as $keyy => $rows){
                //    //print_r($rows); die;
                //    if(!empty($rows)){
                //        $cosubcategory = $this->welcome_model->SelectRecord('category','id,title,description,icon',$udata=array("status"=>"1","parent_id"=>$rows['id'],"is_deleted"=>"0"),'id asc');                        
                //    }
                //    $subcategory[$keyy]['cosubcategory'] = $cosubcategory;
                //}
                if(empty($subcategory)){                    
                    $subcategory = $this->welcome_model->SelectRecord('services','id,title,description,icon',$udata=array("status"=>"1","category_id"=>$row['id'],"is_deleted"=>"0"),'id asc');                            
                }
                
                $category[$key]['subcategory'] = $subcategory;
            }else{
            
            }            
        }
        //print_r($category); die;
        
        foreach($category as $c){            
            if($c['id'] == $subcat){
                if(empty($c['subcategory'])){
                    $is_service_exist = $this->welcome_model->SelectRecord('services','*',$udata=array("status"=>"1","category_id"=>$c['id'],"is_deleted"=>"0"),'id asc');
                    if($is_service_exist){
                        redirect('welcome/services/'.$subcat);
                    }
                }
            }
        }
        if(empty($category)){
            redirect('welcome/services/'.$subcat);
        }
        //print_r($category); die;
        
        $data->services = $category;
		$this->load->view('catalog',$data);
	}
    
    public function delete_service(){
        $id = $_POST['id'];
        $final_session = $this->session->userdata('service_cart1');
            foreach($final_session as $k => $session)
            {                
                 if(($session['id']) == $id)
                 {
                    
                    unset($final_session[$k]);
                 }
            }            
            $final_session = array_values($final_session);
            $this->session->set_userdata('service_cart1', $final_session);
            
            
            $listt = []; $html = '';
            foreach($this->session->userdata('service_cart1') as $key=>$value){            
                if($value['list'] != '_'){
                    if(!in_array($value['list'],$listt)){
                        $listt[] = $value['list'];
                        $html .= '<p><div class="need_item_title"><h4>'.implode(' ',explode('_',$value['list'])).'</h4></div></p>';
                    }            
                }
                
                foreach($value as $keyy=>$row){
                    if($keyy != 'list'){
                        if($keyy == 'label'){
                            $var = $value['id'];                        
                            $html .= '<p><strong>'.ucwords(implode(' ',explode('_',$value['keylabel']))).'</strong> : '.$row.'<span class="pull-right del_srvc_btn" onclick="delete_service(\''.$var.'\')"><i class="fas fa-times"></i></span></p>';
                        }
                        if($keyy == 'select'){                        
                            $html .= '<p><strong>'.ucwords(implode(' ',explode('_',$value['keyselect']))).'</strong> : '.$row.'</p>';
                        }
                        if($keyy == 'qty'){                        
                            $html .= '<p><strong>'.ucwords(implode(' ',explode('_',$value['keyqty']))).'</strong> : '.$row.'</p><br>';
                        }
                    }
                    if($keyy == 'Service_Method'){
                        $servicemethod = $row;
                    }
                }
            }
            
            $html .= '<hr>';
            if($this->session->userdata('service_cart')){
                foreach($this->session->userdata('service_cart') as $key=>$value){
                    if($value){
                        $html .= '<p><strong>'.ucwords(implode(' ',explode('_',$key))).'</strong> : '.implode(', ',$value).'</p>';
                    }
                    if($key == 'Service_Method'){
                        $servicemethod = $value;
                    }
                }
            }
            print_r(json_encode((array("html"=>$html))));
    }
    
    public function services($serviceid=Null)
	{
        $data=new stdClass();
        $data->showcontinue = 0;
        if($this->session->userdata('serviceid') == $serviceid){
            $data->showcontinue = 1;
        }else{
            $this->session->unset_userdata('service_cart');
            $this->session->unset_userdata('service_cart1');
            $this->session->unset_userdata('location_cart');
            $this->session->unset_userdata('schedule_cart');
            $this->session->unset_userdata('provider_cart');
            $this->session->unset_userdata('payment_method');
        }
        $this->session->set_userdata('serviceid',$serviceid);
        //print_r($data); die;
        //echo "<pre>"; print_r($this->session->userdata('service_cart')); die;
        
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
        
        $services = $this->welcome_model->SelectSingleRecord('services','*',$udata=array("status"=>"1","id"=>$serviceid,"is_deleted"=>"0"),'id asc');
        
        $options = $this->welcome_model->SelectRecord('options','*',$udata=array("status"=>"1","service_id"=>$serviceid,"is_deleted"=>"0"),'id asc');
        
        $arr = array();
        foreach ($options as $key => $item) {
           $arr[$item['field_position']][$key] = $item;
        }
        
        ksort($arr, SORT_NUMERIC);
        
        //print_r($options); die;
        $this->session->set_userdata('services',$services);
        $data->services = $services;
        $data->options = $arr;
		$this->load->view('services',$data);
	}
    
    public function add_services($serviceid=Null)
	{        
        $data=new stdClass();
        
        //print_r($_POST); die;
        
        $this->session->set_userdata('service_cart',$_POST);
        
        $html = ''; $servicemethod = '';
        $listt = [];
        if($this->session->userdata('service_cart1')){
            foreach($this->session->userdata('service_cart1') as $key=>$value){            
                if($value['list'] != '_'){
                    if(!in_array($value['list'],$listt)){
                        $listt[] = $value['list'];
                        $html .= '<p><div class="need_item_title"><h4>'.implode(' ',explode('_',$value['list'])).'</h4></div></p>';
                    }            
                }
                foreach($value as $keyy=>$row){
                    if($keyy != 'list'){
                        if($keyy == 'label'){
                            $var = $value['id'];                        
                            $html .= '<p><strong>'.ucwords(implode(' ',explode('_',$value['keylabel']))).'</strong> : '.$row.'<span class="pull-right del_srvc_btn" onclick="delete_service(\''.$var.'\')"><i class="fas fa-times"></i></span></p>';
                        }
                        if($keyy == 'select'){
                            if(is_array($row)){
                                $html .= '<p><strong>'.ucwords(implode(' ',explode('_',$value['keyselect']))).'</strong> : '.implode(',',$row).'</p>';
                            }else{
                                $html .= '<p><strong>'.ucwords(implode(' ',explode('_',$value['keyselect']))).'</strong> : '.$row.'</p>';    
                            }                        
                        }
                        if($keyy == 'qty'){                        
                            $html .= '<p><strong>'.ucwords(implode(' ',explode('_',$value['keyqty']))).'</strong> : '.$row.'</p><br>';
                        }                    
                    }
                    if($keyy == 'Service_Method'){
                        $servicemethod = $row;
                    }
                }
            }
        }
        
        //print_r($_POST); die;
        $html .= '<hr>'; 
        foreach($_POST as $key=>$value){
            if($value && substr($key,0, 12) != 'selectvalues'){
            $html .= '<p><strong>'.ucwords(implode(' ',explode('_',$key))).'</strong> : '.implode(', ',$value).'</p>';
            }
            if($key == 'Service_Method'){
                $servicemethod = $value;
            }            
        }
        
        print_r(json_encode((array("html"=>$html,"servicemethod"=>$servicemethod))));
	}
    
    public function add_services1($serviceid=Null)
	{        
        $data=new stdClass();        
        //$this->session->unset_userdata('service_cart1'); die;
        //print_r($_POST); die;
        if(!$this->session->userdata('service_cart1')){
            $arr[] = $_POST;
            $this->session->set_userdata('service_cart1',$arr);    
        }else{
            if($_POST['isradio'] == 0){
                $arr = $this->session->userdata('service_cart1');    
            }
            
            $flag = 0;
            foreach($arr as $k=>$r){                
                if($r['label'] == $_POST['label']){
                    if(isset($_POST['select'])){
                        $arr[$k]['select'] = $_POST['select'];
                    }
                    $arr[$k]['qty'] = $_POST['qty'];
                    $flag += 1;
                }else{
                            
                }
            }
            //print_r($arr); print_r($_POST);
            if($flag == 0){
                $arr[] = $_POST;
            }
            
            //print_r($arr); die;
            $this->session->set_userdata('service_cart1',$arr);
        }
        //print_r($this->session->userdata('service_cart1')); die;
        $listt = []; $html = ''; $servicemethod = '';
        foreach($this->session->userdata('service_cart1') as $key=>$value){            
            if($value['list'] != '_'){
                if(!in_array($value['list'],$listt)){
                    $listt[] = $value['list'];
                    $html .= '<p><div class="need_item_title"><h4>'.implode(' ',explode('_',$value['list'])).'</h4></div></p>';
                }            
            }            
            
            foreach($value as $keyy=>$row){
                if($keyy != 'list'){
                    
                    if($keyy == 'label'){
                        $var = $value['id'];                        
                        $html .= '<p><strong>'.ucwords(implode(' ',explode('_',$value['keylabel']))).'</strong> : '.$row.'<span class="pull-right del_srvc_btn" onclick="delete_service(\''.$var.'\')"><i class="fas fa-times"></i></span></p>';
                    }
                    if($keyy == 'select'){
                        //$this->session->unset_userdata('service_cart1');
                        if(is_array($row)){
                            $html .= '<p><strong>'.ucwords(implode(' ',explode('_',$value['keyselect']))).'</strong> : '.implode(',',$row).'</p>';
                        }else{
                            $html .= '<p><strong>'.ucwords(implode(' ',explode('_',$value['keyselect']))).'</strong> : '.$row.'</p>';    
                        }                        
                    }
                    if($keyy == 'qty'){                        
                        $html .= '<p><strong>'.ucwords(implode(' ',explode('_',$value['keyqty']))).'</strong> : '.$row.'</p><br>';
                    }                    
                }
                if($keyy == 'Service_Method'){
                    $servicemethod = $row;
                }
            }
        }
                
        
        $html .= '<hr>';
        if($this->session->userdata('service_cart')){
            foreach($this->session->userdata('service_cart') as $key=>$value){
                if($value && substr($key,0, 12) != 'selectvalues'){
                    $html .= '<p><strong>'.ucwords(implode(' ',explode('_',$key))).'</strong> : '.implode(', ',$value).'</p>';
                }
                if($key == 'Service_Method'){
                    $servicemethod = $value;
                }
            }
        }
        print_r(json_encode((array("html"=>$html))));
	}
    
    
    public function checkout(){        
        if($_POST){
            $this->session->set_userdata('payment_method',$_POST);    
        }
        
        //print_r($_POST); die;
        $data = new stdClass();
        if(!$this->session->userdata('user_id')){
            $this->session->set_userdata('return_url','welcome/checkout');
            redirect('user');
        }
        
        $vendorid = $this->session->userdata('provider_cart')['vndor'];
        $data->vendor = $this->welcome_model->SelectSingleRecord('users','*',$udata=array("id"=>$vendorid),'id asc');
        $data->vendor_services = $this->welcome_model->SelectSingleRecord('vendor_services','*',$udata=array("vendor_id"=>$vendorid),'id asc');
        $data->vendor_services_price = $this->welcome_model->searchVendor($this->session->userdata('serviceid'));            
        //print_r($data->vendor_services_price); die;
        $services = $this->session->userdata('services');
        $this->load->view('checkout.php',$data);          
    }
    
    
    public function load_next_tab(){
        //print_r($_POST); die;
        $data = new stdClass();
        if($_POST){
            if(isset($_POST['check']) && $_POST['check'] == 2){
                    if($_POST['nextpage'] == 'location'){
                        if(($this->session->userdata('service_cart')) && ($this->session->userdata('service_cart1'))){
                            //print_r($_SESSION); die;
                                $servicemethod = '';
                                //print_r($this->session->userdata('service_cart'));die;
                                foreach($this->session->userdata('service_cart') as $key=>$value){
                                    if(is_array($value)){                                    
                                        if($value[0] == ''){                                        
                                            echo 0;
                                            return false;
                                        }
                                    }
                                    if(!is_array($value)){                                    
                                        if($value == ''){                                        
                                            echo 0;
                                            return false;
                                        }
                                    }
                                    if($key == 'Service_Method'){
                                        $servicemethod = implode('',$value);
                                    }
                                }
                                
                                foreach($this->session->userdata('service_cart1') as $key=>$value){
                                    if(isset($value['select'])){
                                        if(!$value['select']){
                                            echo 0;
                                            return false;
                                        }   
                                    }                                                                
                                } 
                                                                    
                                $data->servicemethod = $servicemethod;
                                $this->load->view('location_tab.php',$data);                    
                        }else{
                            echo 0;
                        }
                    }    
            }else if(isset($_POST['check']) && $_POST['check'] == 1){
                    if($_POST['nextpage'] == 'location'){
                        if(($this->session->userdata('service_cart1'))){
                            //print_r($_SESSION); die;
                                $servicemethod = '';
                                foreach($this->session->userdata('service_cart') as $key=>$value){
                                    if(is_array($value)){                                    
                                        if($value[0] == ''){                                        
                                            echo 0;
                                            return false;
                                        }
                                    }
                                    if(!is_array($value)){                                    
                                        if($value == ''){                                        
                                            echo 0;
                                            return false;
                                        }
                                    }
                                    if($key == 'Service_Method'){
                                        $servicemethod = implode('',$value);
                                    }
                                }
                                
                                foreach($this->session->userdata('service_cart1') as $key=>$value){                                
                                    if(!$value['select']){
                                        echo 0;
                                        return false;
                                    }                                
                                }
                                                                    
                                $data->servicemethod = $servicemethod;
                                $this->load->view('location_tab.php',$data);                    
                        }else{
                            echo 0;
                        }
                    }            
            }else if(isset($_POST['check']) && $_POST['check'] == 0){
                    if($_POST['nextpage'] == 'location'){
                        if(($this->session->userdata('service_cart'))){
                            //print_r($_SESSION); die;
                                $servicemethod = '';
                                foreach($this->session->userdata('service_cart') as $key=>$value){
                                    //print_r($this->session->userdata('service_cart'));                                
                                    if(is_array($value)){                                    
                                        if($value[0] == ''){                                        
                                            echo 0;
                                            return false;
                                        }
                                    }
                                    if(!is_array($value)){
                                        //echo substr($key,0,12);
                                        if($value == ''){                                        
                                            echo 0;
                                            return false;
                                        }
                                    }
                                    if($key == 'Service_Method'){
                                        $servicemethod = implode('',$value);
                                    }
                                }                                                            
                                //print_r($servicemethod);die;                                    
                                $data->servicemethod = $servicemethod;
                                $this->load->view('location_tab.php',$data);                    
                        }else{
                            echo 0;
                        }
                    }            
            }
            
            
            if($_POST['nextpage'] == 'schedule'){
                $this->session->unset_userdata('schedule_cart');
                if(($this->session->userdata('location_cart')) ){
                        foreach($this->session->userdata('location_cart') as $key=>$value){
                            if(!$value){
                                echo 0;
                                return false;
                            }                        
                        } 
                        $this->load->view('schedule_tab.php',$data);
                }else{
                    echo 0;
                }            
            }
            
            if($_POST['nextpage'] == 'provider'){
                
                if(($this->session->userdata('schedule_cart')) ){
                        foreach($this->session->userdata('location_cart') as $key=>$value){
                            if(!$value){
                                echo 0;
                                return false;
                            }                        
                        }                        
                        //$vendors = $this->welcome_model->joindataResult('v.vendor_id','u.id',array(),'u.*,v.charges','vendor_services as v','users as u',$orderby=Null);
                        $vendors = $this->welcome_model->searchVendor($this->session->userdata('serviceid'));
                        //print_r($vendors); die;
                        //foreach($vendors as $key=>$row){
                        //    echo $row['id'];
                        //    $vendor_services_price = $this->welcome_model->SelectSingleRecord('vendor_services_price','*',array("userId"=>$row['id'],"userServicesId"=>$this->session->userdata('serviceid')),Null);
                        //    print_r($this->db->last_query());
                        //    $vendors[$key]['price'] = $vendor_services_price;
                        //}
                        //print_r($vendors); die;
                        $data->vendors = $vendors;
                        $this->load->view('provider_tab.php',$data);
                }else{
                    echo 0;
                }            
            }
            
            if($_POST['nextpage'] == 'checkout'){                
                if(($this->session->userdata('provider_cart')) ){
                    //$data->price = $this->welcome_model->SelectSingleRecord('vendor_services_price','*',$udata=array("userId"=>$this->session->userdata('provider_cart')['vndor'],"userServicesId"=>$this->session->userdata('serviceid')),Null);
                    $data->vendors = $this->welcome_model->searchVendor($this->session->userdata('serviceid'));
                    $this->load->view('checkout_tab.php',$data);
                }else{
                    echo 0;
                }            
            }
        
        //if($_POST['nextpage'] == 'finished'){            
        //    if(($this->session->userdata('billings_cart')) ){
        //        echo 0;
        //    }else{
        //        echo 0;
        //    }            
        //}
        }
    }
    
    
    public function load_next_tab1(){
        
        $data = new stdClass();        
        
        if($_POST['nextpage'] == 'finished'){            
            if(($this->session->userdata('billing_cart')) ){
                echo 1;
            }else{
                echo 0;
            }            
        }
    }
    
    public function load_location_tab(){
        $data = new stdClass();   
        $servicemethod = '';
        foreach($this->session->userdata('service_cart') as $key=>$value){                                
            if($key == 'Service_Method'){
                $servicemethod = implode('',$value);
            }
        }                                                            
        
        if(($this->session->userdata('service_cart')) || ($this->session->userdata('service_cart1'))){                                    
            $data->servicemethod = $servicemethod;
            $this->load->view('location_tab.php',$data);
        }else{
            echo 0;
        }
    }
    
    public function load_schedule_tab(){
        $data = new stdClass();                                                                   
        
        if((($this->session->userdata('service_cart')) || ($this->session->userdata('service_cart1'))) && ($this->session->userdata('location_cart'))){                                            
            $this->load->view('schedule_tab.php',$data);
        }else{
            echo 0;
        }
    }
    
    public function load_provider_tab(){
        $data = new stdClass();   
        
        if((($this->session->userdata('service_cart')) || ($this->session->userdata('service_cart1'))) && ($this->session->userdata('location_cart')) && ($this->session->userdata('schedule_cart'))){
            //$vendors = $this->welcome_model->joindataResult('v.vendor_id','u.id',array(),'u.*,v.charges','vendor_services as v','users as u',$orderby=Null);
            $vendors = $this->welcome_model->searchVendor($this->session->userdata('serviceid'));            
            //foreach($vendors as $key=>$row){
            //    $vendor_services_price = $this->welcome_model->SelectSingleRecord('vendor_services_price','*',$udata=array("userId"=>$row['id'],"userServicesId"=>$this->session->userdata('serviceid')),Null);
            //    $vendors[$key]['price'] = $vendor_services_price;
            //}
            $data->vendors = $vendors;
            $this->load->view('provider_tab.php',$data);
        }else{
            echo 0;
        }
    }
    
    public function save_location()
	{
       
        $this->session->set_userdata('location_cart',$_POST);
        $this->session->set_userdata('schedule_cart',1);
        //print_r($_POST);
        foreach($_POST as $key=>$value){
            if($value && ($key != 'location')){
                if($key == 'address_hidden') {
                   echo '<div class="location_dv"><p><strong><i class="fas fa-map-marker-alt"></i>location</strong> '.$value.'</p></div>';
                }else{                                        
                   echo '<div class="location_dv"><p><strong><i class="fas fa-map-marker-alt"></i>'.ucwords(implode(' ',explode('_',$key))).'</strong> '.$value.'</p></div>';
                }
            }
        }
	}
    
    
    public function save_schedule()
	{
       
        $this->session->set_userdata('schedule_cart',$_POST);
        //print_r($_POST);                    
        echo '<div class="location_dv"><p><strong><i class="fas fa-calendar-alt"></i>Scheduled Time</strong>'.$_POST['dateslots'].' '.$_POST['timeslots'].'</p></div>';        
	}
    
    public function select_provider()
	{        
        $this->session->set_userdata('provider_cart',$_POST);
        $vendor = $this->welcome_model->SelectSingleRecord('users','*',$udata=array("id"=>$_POST['vndor']),'id asc');
        //$vendor_services = $this->welcome_model->SelectSingleRecord('vendor_services','*',$udata=array("vendor_id"=>$_POST['vndor']),'id asc');
        //print_r($_POST['vendor']); die;
        if($vendor->shop_name){
            echo '<div class="location_dv"><p><strong>Vendor</strong> <img src="'.base_url('upload/profile_image/'.$vendor->image).'" height="50px"> '.ucwords($vendor->shop_name).'</p></div>';
        }else{
            echo '<div class="location_dv"><p><strong>Vendor</strong> <img src="'.base_url('upload/profile_image/'.$vendor->image).'" height="50px"> '.ucwords($vendor->f_name).' '.ucwords($vendor->l_name).'</p></div>';
        }
            //echo '<p><strong>Charges</strong> : '.($vendor_services->charges).'</p>';        
	}
    
    public function save_billing()
	{
        print_r($_SESSION); die;
        //$this->session->set_userdata('billing_cart',$_POST);
        print_r($_POST);
        //foreach($_POST as $key=>$value){
        //    echo '<p><strong>'.ucwords(implode(' ',explode('_',$key))).'</strong> : '.$value.'</p>';
        //}
	}
    
    function contactUs(){
        $data = new stdClass();
        if(isset($_POST) && !empty($_POST)){
            $postData = $this->input->post();
            $htmlContent = '<h1>Contact Us Mail</h1>';
            $htmlContent .= '<p><b>Name :</b> '.$postData['uname'].'</p>';
            $htmlContent .= '<p><b>Phone :</b> '.$postData['Phone'].'</p>';
            $htmlContent .= '<p><b>E-mail :</b> '.$postData['uemail'].'</p>';
            $htmlContent .= '<p><b>Message :</b> '.$postData['message'].'</p>';
            $this->email('aishwarysingh2405@gmail.com',"Contact Us : ".$postData['subject'],$htmlContent);

            $data->error = 0;
            $data->success = 1;
            $data->message = 'Mail Send successfully.';

        }
        $this->load->view('contactUs',$data);
    }
    
    public function search_bar()
    {
        //$search = $_POST['keyword'];
        //$where = array('title' =>$search);
        $keyword = $_POST['keyword'];
        // print_r($keyword);die();

        $result = $this->welcome_model->search_record('services',$keyword,$order = '');

            // echo $this->db->last_query(); die;
             // print_r($result);die(); 
        if(!empty($result))
         {
            ?>
            <ul>
                <?php
                foreach($result as $services)
                {
                    // print_r($services);
                ?>
                <li onClick="selectServices('<?php echo $services['title']; ?>','<?php echo $services['id']; ?>');"><?php echo $services["title"]; ?></li>
                <?php } ?>
            </ul>
    <?php }
            
    }  
}
