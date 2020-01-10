<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Userblog extends MY_Controller 
{
    //private $connection;
        public function __construct()
        {            
            parent::__construct();
            $this->load->model('user_blogmodel');
            // $this->load->model('blogs_model');
            $this->load->helper('my_helper');
            $page = '';
        }
        public function index()
        {
            // $this->load->view('blog_view'); 
            $data=new stdClass();            
            $data->results = $this->user_blogmodel->SelectRecord('blogs','*',array(),'id desc');
            $data->title = 'List Blogs';
            $data->field = 'Datatable';
            $data->page = 'list_blogs';
            // $this->load->view('admin/includes/header',$data);       
            $this->load->view('blog_view',$data);
            // $this->load->view('admin/includes/footer',$data);       
        }
         public function readmore($id)
        {
            // $this->load->view('blog_view'); 
            $data=new stdClass();
            $data->results = $this->user_blogmodel->SelectSingleRecord('blogs','*',array('id'=>$id),'id desc');
            //print_r($data->results);die();
            
            $data->recent_blogs = $this->user_blogmodel->SelectRecord('blogs','*',array('id !='=>$id),'id desc');
            //echo "<pre>"; print_r($data->recent_blogs); die;
            // $data->title = 'List Blogs';
            // $data->field = 'Datatable';
            // $data->page = 'list_blogs';
            $this->load->view('readmore_view',$data);
        }
}

?>