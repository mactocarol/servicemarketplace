<?php $this->load->view('admin/includes/sidebar'); ?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <!-- List Category -->
        List Services
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url('admin/dashboard');?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <!-- <li class="active">List Category</li> -->
        <li class="active">List Services</li>
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
                  <!-- <h3 class="box-title">List Category</h3> -->
                  <h3 class="box-title">List Services</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                 <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                      <th>Sr. No.</th>                        
                      <th>Title</th>
                      <th>Parent</th>                      
                      <th>Action</th>                      
                    </tr>
                    </thead>
                    <tbody>
                          <?php if(isset($categories)) {
                                $count = 0;                              
                                foreach($categories as $key => $category){ 
                                    foreach($category as $row){ ?>
                                        <tr>
                                            <td><?= ++$count; ?></td>
                                            <td>
                                                <?php echo isset($row['cname']) ? $row['cname'] : ''; ?>                                    
                                            </td>                                
                                            <td>
                                                <?php echo ($row['parent_id']) ? get_category($row['parent_id'])->title : '--'; ?>                                    
                                            </td>
                                            
                                            <td>
                                                <a href="<?php echo base_url(); ?>category/edit/<?php echo base64_encode($row['id']);?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                <?php if($row['parent_id']){?>
                                                    <a href="<?php echo base_url(); ?>category/delete/<?php echo base64_encode($row['id']);?>" onclick=" var c = confirm('Are you sure want to delete?'); if(!c) return false;"><i class="fa fa-close" aria-hidden="true"></i></a>
                                                <?php } ?>    
                                            </td>
                                        </tr>                          
                    <?php  } } } ?>                      
                                                       
                    </tfoot>
                  </table>
                 
              
                </div>
                <!-- /.box-body -->
              </div>
    
            </section>
            
            <section class="col-lg-12 connectedSortable">
                
               <div class="box">
                <div class="box-header">
                  <!-- <h3 class="box-title">Category Tree View</h3> -->
                  <h3 class="box-title">Services Tree View</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    
                    <?php print_r($categories_html); ?>
                 
              
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
  