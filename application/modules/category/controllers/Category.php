<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category extends MY_Controller 

{

	//private $connection;

        public function __construct(){

            parent::__construct();

            $this->load->model('category_model');

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

            

            $html = "";

            $categories2 = $this->category_model->SelectRecord('category','*',$udata=array("is_deleted"=>"0","parent_id"=>"0"),'order_id asc');

            

            $cname = [];

            $level = 1; 

    

            foreach ($categories2 as $key => $value) {

                 

                $cname[$value['title']][] = ['id'=>$value['id'], 'cname'=>$value['title'],'level'=>$value['level']];

    

                $arr[] = ['id'=>$value['id'], 'parent_id'=>$value['parent_id'], 'cname'=>$value['title'],'level'=>$value['level'],'order_id'=>$value['order_id']];

    

    

                $html .= str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $value['level']).$value['title'];

                $r = '';

                $html  .= '<br>';

    

                $cat = $this->category_model->SelectRecord('category','*',$udata=array("is_deleted"=>"0","parent_id"=>$value['id']),'order_id asc');             

                

                foreach ($cat as $key => $result) {

                    $parent_id = $result['id']; 

    

                    $cname[$value['title']][$result['id']][] = ['id'=>$result['id'], 'parent_id'=>$result['parent_id'],'cname'=>$result['title'],'level'=>$result['level'],'order_id'=>$result['order_id']];

                    $html  .= str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $result['level']).$result['title'];

                    $r = $result['id'];

                    $html  .= '<br>';

                    $arr[] = ['id'=>$result['id'], 'parent_id'=>$result['parent_id'], 'cname'=>$result['title'],'level'=>$result['level'],'order_id'=>$result['order_id']];

    

                    while (1) {

    

                        $data = $this->category_model->SelectRecord('category','*',$udata=array("is_deleted"=>"0","parent_id"=>$parent_id),'order_id asc');

                        //print_r($data);die;

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

                                     

                                     

                                     

                                     

                                     

                                    //$dataa = $this->category_model->SelectRecord('category','*',$udata=array("status"=>"1","is_deleted"=>"0","parent_id"=>$parent_id),'order_id asc'); 

                                    // 

                                    //// print_r($dataa); die;

                                    //foreach ($dataa as $keyy => $reslt) {

                                    //    $parent_id = $reslt['id']; 

                                    //

                                    //    $cname[$value['title']][$result['id']][$reslt['id']][] = ['id'=>$reslt['id'], 'parent_id'=>$reslt['parent_id'],'cname'=>$result['title'],'level'=>$reslt['level'],'order_id'=>$reslt['order_id']];

                                    //    $html  .= str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $reslt['level']).$reslt['title'];

                                    //    $r = $reslt['id'];

                                    //    $html  .= '<br>';

                                    //    $arr[] = ['id'=>$reslt['id'], 'parent_id'=>$reslt['parent_id'], 'cname'=>$reslt['title'],'level'=>$reslt['level'],'order_id'=>$reslt['order_id']];

                                    //

                                    //    while (1) {

                                    //

                                    //        $datass = $this->category_model->SelectRecord('category','*',$udata=array("status"=>"1","is_deleted"=>"0","parent_id"=>$parent_id),'order_id asc');

                                    //        //print_r($datas);die;

                                    //        if(count($datass)>1){

                                    //

                                    //            foreach ($datass  as $ke => $daata) {

                                    //                if($daata)

                                    //                {

                                    //                    $level++;

                                    //                    $parent_id = $daata['id'];

                                    //

                                    //                    $cname[$value['title']][$result['id']][$reslt['id']][$parent_id][] = ['id'=>$daata['id'],'parent_id'=>$daata['parent_id'],'cname'=>$daata['title'],'level'=>$daata['level'],'order_id'=>$data['order_id']];

                                    //

                                    //                     $html  .= str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $daata['level']).$daata['title'];

                                    //                     $r         = $daata['id'];

                                    //                     $html  .= '<br>';

                                    //                     $arr[]  = ['id'=>$daata['id'], 'parent_id'=>$daata['parent_id'],'cname'=>$daata['title'],'level'=>$daata['level'],'order_id'=>$daata['order_id']];

                                    //                }else{

                                    //                    break;

                                    //                }

                                    //            }

                                    //

                                    //        }else{

                                    //            $datass = $this->category_model->SelectSingleRecord('category','*',$udata=array("status"=>"1","is_deleted"=>"0","parent_id"=>$parent_id),'order_id asc');                            

                                    //

                                    //        if(!empty($datass))

                                    //        {

                                    //            //print_r($data); die;

                                    //            

                                    //            $level++;

                                    //            $parent_id = $datass->id;

                                    //

                                    //            $cname[$value['title']][$result['id']][$reslt['id']][$parent_id][] = ['id'=>$datass->id,'parent_id'=>$datass->parent_id,'cname'=>$datass->title,'level'=>$datass->level,'order_id'=>$datass->order_id];

                                    //

                                    //             $html  .= str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $datass->level).$datass->title;

                                    //             $r         = '';

                                    //             $html  .= '<br>';

                                    //             $arr[]  = ['id'=>$datass->id, 'parent_id'=>$datass->parent_id,'cname'=>$datass->title,'level'=>$datass->level,'order_id'=>$datass->order_id];

                                    //        }else{

                                    //            break;

                                    //        }

                                    //        }

                                    //    } 

                                    //} 

                                     

                                     

                            

                                }else{

                                    break;

                                }

                            }

    

                        }else{

                            $data = $this->category_model->SelectSingleRecord('category','*',$udata=array("is_deleted"=>"0","parent_id"=>$parent_id),'order_id asc');                            

    

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

            //header("Content-Type: text/html");

            //print_r($html);

            //print_r($result_set); die;

            $datas->categories = $result_set;

            $datas->categories_html = $html;

            $udata = array("id"=>$this->session->userdata('user_id'));                

            $datas->result = $this->category_model->SelectSingleRecord('admin','*',$udata,$orderby=array());

            $datas->website_title = $this->category_model->SelectSingleRecord('settings','*',$udata=array("field_key"=>"website_title"),$orderby=array());

            $datas->title = 'List Category';

            $datas->field = 'Datatable';

            $datas->page = 'list_category';

            $this->load->view('admin/includes/header',$datas);		

            $this->load->view('list_category_view',$datas);

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

               $udata['parent_id'] = explode(';',$this->input->post('parent'))[0];               

               $orderid = $this->category_model->SelectRecordpaginatoin('category','*',array("parent_id"=>explode(';',$this->input->post('parent'))[0]),'order_id desc', '1','0');

               //print_r($orderid); die;

               $udata['order_id'] = ($orderid[0]['order_id'] + 1);

               

               $udata['level'] = (explode(';',$this->input->post('parent'))[1] + 1);

               $udata['title'] = $this->input->post('name');

               $udata['description'] = $this->input->post('description');

               //print_r($udata); die;

               if($_FILES['image']['name'] != '')
               {                               

                                

                        $upload_path = './upload/category/';

                        $config['upload_path'] = $upload_path;

                        

                        $config['allowed_types'] = 'jpg|jpeg|gif|png';                                                                    

                       

                        $config['overwrite'] = false;

                        //print_r($config);

                        $this->load->library ('upload',$config);

                                                

                        if ($this->upload->do_upload('image'))

                        {                                    

                            $uploaddata = $this->upload->data();

                            //print_r($udata); die;

                            $udata['image'] = $uploaddata['file_name'];

                            

                            

                                $conf['image_library'] = 'gd2';

                                $conf['source_image'] = './upload/category/'.$uploaddata['file_name'];

                                $conf['new_image'] = './upload/category/thumb/'.$uploaddata['file_name'];

                                $conf['create_thumb'] = False;

                                $conf['maintain_ratio'] = False;

                                $conf['width']         = 600;

                                $conf['height']       = 400;

                                

                                $this->load->library('image_lib', $conf);

                                

                                $this->image_lib->resize();                                                                

                            

                        }

                        else

                        {                                                    

                            $datas->error=1;

                            $datas->success=0;

                            $datas->message=$this->upload->display_errors(); 

                            $this->session->set_flashdata('item', $datas);

                            redirect('category/add/');	

                        }

               

               }

               //print_r($udata); die;

               if($this->category_model->InsertRecord('category',$udata)){

                    $data->error=0;

                    $data->success=1;

                    $data->message="Category Added Successfully";

               }else{

                    $data->error=1;

                    $data->success=0;

                    $data->message="Network Error";

               }

               $this->session->set_flashdata('item',$data);

               redirect('category/add');

            }

            

            $html = "";

            $categories2 = $this->category_model->SelectRecord('category','*',$udata=array("status"=>"1","is_deleted"=>"0","parent_id"=>"0"),'order_id asc');

            $cname = [];

            $level = 1; 

    

            foreach ($categories2 as $key => $value) {

                 

                $cname[$value['title']][] = ['id'=>$value['id'], 'cname'=>$value['title'],'level'=>$value['level']];

    

                $arr[] = ['id'=>$value['id'], 'parent_id'=>$value['parent_id'], 'cname'=>$value['title'],'level'=>$value['level'],'order_id'=>$value['order_id']];

    

    

                $html .= str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $value['level']).$value['title'];

                $r = '';

                $html  .= '<br>';

    

                $cat = $this->category_model->SelectRecord('category','*',$udata=array("status"=>"1","is_deleted"=>"0","parent_id"=>$value['id']),'order_id asc');             

    

                foreach ($cat as $key => $result) {

                    $parent_id = $result['id']; 

    

                    $cname[$value['title']][$result['id']][] = ['id'=>$result['id'], 'parent_id'=>$result['parent_id'],'cname'=>$result['title'],'level'=>$result['level'],'order_id'=>$result['order_id']];

                    $html  .= str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $result['level']).$result['title'];

                    $r = $result['id'];

                    $html  .= '<br>';

                    $arr[] = ['id'=>$result['id'], 'parent_id'=>$result['parent_id'], 'cname'=>$result['title'],'level'=>$result['level'],'order_id'=>$result['order_id']];

    

                    while (1) {

    

                        $data = $this->category_model->SelectRecord('category','*',$udata=array("status"=>"1","is_deleted"=>"0","parent_id"=>$parent_id),'order_id asc');

                        

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

                            $data = $this->category_model->SelectSingleRecord('category','*',$udata=array("status"=>"1","is_deleted"=>"0","parent_id"=>$parent_id),'order_id asc');                            

    

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

            $datas->result = $this->category_model->SelectSingleRecord('admin','*',$udata,$orderby=array());

            $datas->website_title = $this->category_model->SelectSingleRecord('settings','*',$udata=array("field_key"=>"website_title"),$orderby=array());

            $datas->title = 'Category';

            $datas->field = 'Category';

            $datas->page = 'add_category';

            $this->load->view('admin/includes/header',$datas);		

            $this->load->view('add_category_view',$datas);

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

            if(!empty($_POST))
            {

                //print_r($_POST);die;

               //$udata['parent_id'] = explode(';',$this->input->post('parent'))[0];               

               $orderid = $this->category_model->SelectRecordpaginatoin('category','*',array("parent_id"=>explode(';',$this->input->post('parent'))[0]),'order_id desc', '1','0');

               //print_r($orderid); die;

               //$udata['order_id'] = ($orderid[0]['order_id'] + 1);

               

               //$udata['level'] = (explode(';',$this->input->post('parent'))[1] + 1);

               $udata['title'] = $this->input->post('name');

               $udata['description'] = trim($this->input->post('description'));

               $udata['icon'] = $this->input->post('icon');

               // $udata['image'] = $this->input->post('image');

               $udata['status'] = $this->input->post('status');

               //print_r($udata); die;
               if($_FILES['image']['name'] != '')
               {          
                        $upload_path = './upload/category/';
                        $config['upload_path'] = $upload_path;

                        $config['allowed_types'] = 'jpg|jpeg|gif|png';
                        $config['overwrite'] = false;
                        //print_r($config);
                        $this->load->library ('upload',$config);
                        if ($this->upload->do_upload('image'))
                        {                                    
                           $uploaddata = $this->upload->data();
                            //print_r($udata); die;
                            $udata['image'] = $uploaddata['file_name'];
                                $conf['image_library'] = 'gd2';
                                $conf['source_image'] = './upload/category/'.$uploaddata['file_name'];
                                $conf['new_image'] = './upload/category/thumb/'.$uploaddata['file_name'];
                                $conf['create_thumb'] = False;
                                $conf['maintain_ratio'] = False;
                                $conf['width']         = 600;
                                $conf['height']       = 400;
                                $this->load->library('image_lib', $conf);
                                $this->image_lib->resize();                                                                

                       }
                        else
                        {                                                    
                            $datas->error=1;
                            $datas->success=0;
                            $datas->message=$this->upload->display_errors(); 
                            $this->session->set_flashdata('item', $datas);
                            redirect('category/edit/');  
                        }

               }                

               

               if($this->category_model->UpdateRecord('category',$udata,array("id"=>$id))){

                    $data->error=0;

                    $data->success=1;

                    $data->message="Category Updated Successfully";

               }else{

                    $data->error=1;

                    $data->success=0;

                    $data->message="Network Error";

               }

               $this->session->set_flashdata('item',$data);

               redirect('category/edit/'.base64_encode($id));

            }

            

            $html = "";

            $categories2 = $this->category_model->SelectRecord('category','*',$udata=array("status"=>"1","is_deleted"=>"0","parent_id"=>"0"),'order_id asc');

            $cname = [];

            $level = 1; 

    

            foreach ($categories2 as $key => $value) {

                 

                $cname[$value['title']][] = ['id'=>$value['id'], 'cname'=>$value['title'],'level'=>$value['level']];

    

                $arr[] = ['id'=>$value['id'], 'parent_id'=>$value['parent_id'], 'cname'=>$value['title'],'level'=>$value['level'],'order_id'=>$value['order_id']];

    

    

                $html .= str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $value['level']).$value['title'];

                $r = '';

                $html  .= '<br>';

    

                $cat = $this->category_model->SelectRecord('category','*',$udata=array("status"=>"1","is_deleted"=>"0","parent_id"=>$value['id']),'order_id asc');             

    

                foreach ($cat as $key => $result) {

                    $parent_id = $result['id']; 

    

                    $cname[$value['title']][$result['id']][] = ['id'=>$result['id'], 'parent_id'=>$result['parent_id'],'cname'=>$result['title'],'level'=>$result['level'],'order_id'=>$result['order_id']];

                    $html  .= str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $result['level']).$result['title'];

                    $r = $result['id'];

                    $html  .= '<br>';

                    $arr[] = ['id'=>$result['id'], 'parent_id'=>$result['parent_id'], 'cname'=>$result['title'],'level'=>$result['level'],'order_id'=>$result['order_id']];

    

                    while (1) {

    

                        $data = $this->category_model->SelectRecord('category','*',$udata=array("status"=>"1","is_deleted"=>"0","parent_id"=>$parent_id),'order_id asc');

                        

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

                            $data = $this->category_model->SelectSingleRecord('category','*',$udata=array("status"=>"1","is_deleted"=>"0","parent_id"=>$parent_id),'order_id asc');                            

    

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

            

            $datas->reslt = $this->category_model->SelectSingleRecord('category','*',array('id'=>$id),$orderby=array());

            $udata = array("id"=>$this->session->userdata('user_id'));                

            $datas->result = $this->category_model->SelectSingleRecord('admin','*',$udata,$orderby=array());

            $datas->website_title = $this->category_model->SelectSingleRecord('settings','*',$udata=array("field_key"=>"website_title"),$orderby=array());

            $datas->title = 'Category';

            $datas->field = 'Category';

            $datas->page = 'edit_category';

            $this->load->view('admin/includes/header',$datas);		

            $this->load->view('edit_category_view',$datas);

            $this->load->view('admin/includes/footer',$datas);                                        

        }                        

        

        public function delete($id){

            $id = base64_decode($id);

            $data=new stdClass();

            if($this->category_model->UpdateRecord('category',array("is_deleted"=>1),array("id"=>$id))){

                $data->error=0;

                $data->success=1;

                $data->message="Category Deleted Successfully";

            }else{

                $data->error=1;

                $data->success=0;

                $data->message="Network Error";

            }

            $this->session->set_flashdata('item',$data);

            redirect('category');

        }

                		        	

}

?>