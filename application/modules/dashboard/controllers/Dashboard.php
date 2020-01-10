<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//ini_set('display_errors', 1);

class Dashboard extends MY_Controller {

    public function __construct(){
        parent::__construct();
        if(empty($this->session->userdata('logged_in'))){
            redirect('/');
        }
        $this->load->model('dashboard_model');
    }
    
	public function index(){
        $data=new stdClass();
        $check = $this->dashboard_model->SelectSingleRecord('bankdetail','*',array("userId"=>$this->session->userdata('user_id')),'userId desc');
        if(isset($check) && !empty($check)){
            $data->acc = 1;
        }else{
            $data->acc = 0;
        }

        $this->load->view('dashboard',$data);
	}

    public function reviewList(){
        $this->load->view('reviewList');
    }

    public function reviewListData(){
        $this->load->library('ajax_pagination');
        $postData = $this->input->post();
        $config['base_url'] = base_url().'dashboard/reviewListData';
        $config['total_rows'] = $this->dashboard_model->countReviewListData();
        $config['uri_segment'] =3;
        $config['per_page'] = 10;
        $config['num_links'] = 5;
        $config['first_link'] = FALSE;
        $config['last_link'] = FALSE;
        $config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin">';
        $config['full_tag_close'] = '</ul>';
        $config['next_link'] = '&raquo;';
        $config['next_tag_open'] = '<li class="next page">';
        $config['next_tag_close'] = '</li>';
        $config['anchor_class'] = 'class="paginationlink" ';
        $config['prev_link'] = '&laquo;';
        $config['prev_tag_open'] = '<li class="prev page">';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page">';
        $config['num_tag_close'] = '</li>';
        $page = $this->uri->segment(3);
        $limit = $config['per_page'];
        $start = $page > 0 ? $page : 0;
        $this->ajax_pagination->initialize($config);
        $result['reviewListData'] = $this->dashboard_model->reviewListData($limit,$start);
        $result['links'] =$this->ajax_pagination->create_links();
        $result['startFrom'] = $start + 1;
        $this->load->view('reviewListData',$result);
    }

    function calendar(){
        $result['json'] = array();
        $this->load->view('calendar',$result);
    }

    function addPromo(){
        $data=new stdClass();

        if(isset($_POST) && !empty($_POST)){
            $postData = $this->input->post();
            $postData['promoCode'] = strtoupper($postData['promoCode']);

            $checkData = $this->dashboard_model->SelectSingleRecord('promocode','*',array("promoCode"=>$postData['promoCode'],"userId"=>$this->session->userdata('user_id')),'promoId desc');

            if(empty($checkData)){
                $postData['startDate'] = date('Y-m-d', strtotime($postData['startDate']));
                $postData['endDate'] = date('Y-m-d', strtotime($postData['endDate']));
                $postData['userId'] = $this->session->userdata('user_id');
                $this->dashboard_model->InsertRecord('promocode',$postData);

                $data->error = 0;
                $data->success = 1;
                $data->message = "Promo Code Successfully Added.";
            }else{
                $data->error = 1;
                $data->success = 0;
                $data->message = "Promo Code Already Exist.";
            }
        }

        $data->promoCode = $this->dashboard_model->SelectRecord('promocode','*',array("userId"=>$this->session->userdata('user_id')),'promoId desc');

        if($this->session->flashdata('item')) {
            $items = $this->session->flashdata('item');
            if($items->success){
                $data->error=0;
                $data->success=1;
                $data->msg=$items->message;
            }else{
                $data->error=1;
                $data->success=0;
                $data->message=$items->message;
            }
            
        }
        //print_r($data);
        $this->load->view('addPromo',$data);
    }

    function deletePromo($id){
        $this->db->where(array('promoId' => base64_decode($id)));
        $this->db->delete('promocode');
        $this->cart->destroy();
        $data->error=0;
        $data->success=1;
        $data->message= "Promo Code Successfully Deleted.";
        $this->session->set_flashdata('item',$data);
        redirect('dashboard/addPromo');
    }

    function addBank(){
        $data = new stdClass();

        if(isset($_POST) && !empty($_POST)){
            $postData = $this->input->post();
            $insertData = array(
                'firstName' => $postData['firstName'],
                'lastName' => $postData['lastName'],
                'accountNumber' => base64_encode($postData['accountNumber']),
                'routingNumber' => base64_encode($postData['routingNumber']),
                'ssnLast' => base64_encode($postData['ssnLast']),
                'postalCode' => base64_encode($postData['postalCode']),
                'userId' => $this->session->userdata('user_id'),                  
            );
            
            $checkData = $this->dashboard_model->SelectSingleRecord('bankdetail','*',array("userId"=>$this->session->userdata('user_id')),'userId desc');

            if(isset($checkData) && !empty($checkData)){
                $this->dashboard_model->UpdateRecord('bankdetail',$insertData,array("userId"=>$this->session->userdata('user_id')));
            }else{
                $this->dashboard_model->InsertRecord('bankdetail',$insertData);
            }
            redirect('dashboard/');
        }
        
        $data->checkData = $this->dashboard_model->SelectSingleRecord('bankdetail','*',array("userId"=>$this->session->userdata('user_id')),'userId desc');
        $this->load->view('addBank',$data);
    }

    function withdrawAmount(){
        $data = new stdClass();

        if(isset($_POST) && !empty($_POST)){
            
            $postData = $this->input->post();

            $insertData = array(
                'userId' => $this->session->userdata('user_id'),
                'amount' => $postData['amount'],
            );

            $this->dashboard_model->InsertRecord('withdrawAmount',$insertData);

           
            $this->cart->destroy();
            $data->error=0;
            $data->success=1;
            $data->message= 'Request Successfully Sent.';
            $this->session->set_flashdata('item',$data);
                       
            redirect('dashboard/withdrawAmount');
        }

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

        $data->withdrawAmount = $this->dashboard_model->SelectRecord('withdrawAmount','*',array("userId"=>$this->session->userdata('user_id')),'withdrawId desc');

        $this->load->view('withdrawAmount',$data);
    }

    function cancleWithdraw(){
        $postData = $this->input->post();
        $this->dashboard_model->UpdateRecord('withdrawAmount',array('status' => 3),array("withdrawId"=>$postData['withdrawId']));
    }
}
