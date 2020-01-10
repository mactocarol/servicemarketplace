<?php $this->load->view('admin/includes/sidebar'); ?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        List Pictures
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url('admin/dashboard');?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">List Pictures</li>
      </ol>
    </section>

        <!-- Main content -->
        <section class="content">
          
          <!-- Main row -->
          <div class="row">            
            <section class="col-lg-7 connectedSortable">         
                <?php
                if($this->session->flashdata('item')) {
                    $items = $this->session->flashdata('item');
                    if($items->success){
                    ?>
                        <div class="alert alert-success" id="alert">
                                <strong>Success!</strong> <?php print_r($items->message); ?>
                        </div>
                    <?php
                    }else{
                    ?>
                        <div class="alert alert-danger" id="alert">
                                <strong>Error!</strong> <?php print_r($items->message); ?>
                        </div>
                    <?php
                    }
                }
                ?>
            </section>
            <!-- Left col -->
            <section class="col-lg-12 connectedSortable">
                
               <div class="box">
                <div class="box-header">
                  <h3 class="box-title">List Pictures</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                 <table class="table table-bordered" id="dataTable" cellspacing="0">
                    <thead>
                    <tr>
                      <th width="10%">Sr. No.</th>                        
                      <th width="15%">Title</th>                      
                      <th width="15%">Tags</th>
                      <th width="15%">Created By</th>
                      <th width="15%">Audio</th>              
                      <th width="15%">Action</th>                   
                    </tr>
                    </thead>
                    <tbody>
                          <?php if(isset($products)) {
                                $count = 0;                              
                                foreach($products as $row){ ?>
                            <tr>
                                <td><?= ++$count; ?></td>
                                <td>
                                    <?php echo isset($row['title']) ? $row['title'] : ''; ?>                                    
                                </td>                                                     
                                
                                <td>
                                    <?php echo isset($row['tags']) ? $row['tags'] : '';   ?>
                                </td>
                                <td>
                                    <a href="<?php echo site_url('admin/edit_user/'.$row['user_id']);?>"><?php echo isset($row['user_id']) ? get_user($row['user_id'])->username : '';   ?></a>
                                </td>
                                <td>
                                    <img src="<?php echo base_url('upload/products/'.$row['file']);?>" width="150">                                    
                                </td>
                                <td>
                                    <a href="<?php echo base_url(); ?>admin/edit_products/<?php echo $row['id'];?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                    <a href="<?php echo base_url(); ?>admin/delete_product/<?php echo $row['id'];?>/3" onclick=" var c = confirm('Are you sure want to delete?'); if(!c) return false;"><i class="fa fa-close" aria-hidden="true"></i></a>&nbsp;&nbsp;                                    
                                </td>                                
                            </tr>                          
                    <?php  } }?>                      
                                                       
                    </tfoot>
                </table>
                 
              
                </div>
                <!-- /.box-body -->
              </div>
    
            </section>
            <!-- /.Left col -->
          </div>
          <!-- /.row (main row) -->
        
        </section>

    <!-- /.content -->
  </div>  