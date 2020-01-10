<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Withdraw extends MY_Controller{
    
    public function __construct(){
        parent::__construct();
        $this->load->model('withdraw_model');
        if( $this->session->userdata('user_group_id') != 3){
            redirect('admin');
        }            
    }
     
    function index(){
        $datas->withdrawAmount = $this->withdraw_model->withdrawAmount();
        $datas->title = 'List Withdraw';
        $datas->field = 'Datatable';
        $datas->page = 'list_withdraw';

        /*echo "<pre>";
        print_r($datas);die();*/

        $this->load->view('admin/includes/header',$datas);      
        $this->load->view('withdraw',$datas);
        $this->load->view('admin/includes/footer',$datas);
    } 

    function cancle($withdrawId){
        $this->withdraw_model->UpdateRecord('withdrawAmount',array('status' => 4),array("withdrawId"=>$withdrawId));
        redirect('withdraw');
    }

    function paid($withdrawId){
        $this->withdraw_model->UpdateRecord('withdrawAmount',array('status' => 2),array("withdrawId"=>$withdrawId));
        redirect('withdraw');
    } 
}
?>