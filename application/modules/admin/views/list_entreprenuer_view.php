<?php $this->load->view('admin/includes/sidebar'); ?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        List Entrepreneur
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url('admin/dashboard');?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?=$title?></li>
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
                  <h3 class="box-title">List Entrepreneur</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                 <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                      <th>Sr. No.</th>                        
                      <th>UserName</th>
                      <th>Company Name</th>
                      <th>Category</th>
                      <th>Status</th>
                      <th style="width:5px">Action</th>                    
                    </tr>
                    </thead>
                    <tbody>
                          <!--<?php if(isset($results)) {
                                $count = 0;                              
                                foreach($results as $row){ ?>
                            <tr>
                                <td><?= ++$count; ?></td>
                                <td>
                                    <?php echo isset($row['username']) ? $row['username'] : ''; ?>                                    
                                  </td>
                                <td>
                                    <?php echo isset($row['companyname']) ? $row['companyname'] : '';   ?>
                                </td>                               
                                <td>
                                    <?php echo isset($row['category']) ? $row['category'] : '';   ?>
                                </td> 
                                <td>
                                    <?php echo ($row['is_verified'] == 1) ? '<a href="'.site_url('admin/status/'.$row['is_verified'].'/'.$row['id']).'"><button class="btn btn-success"><i class="fa fa-check" aria-hidden="true"></i></button></a>' : '<a href="'.site_url('admin/status/'.$row['is_verified'].'/'.$row['id']).'"><button class="btn btn-danger"><i class="fa fa-close" aria-hidden="true"></i></button></a>';   ?>
                                </td>
                                <td>
                                    <a href="<?php echo base_url(); ?>admin/edit_entrepreneur/<?php echo $row['id'];?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                    <a href="<?php echo base_url(); ?>admin/delete/<?php echo $row['id'];?>" onclick=" var c = confirm('Are you sure want to delete?'); if(!c) return false;"><i class="fa fa-close" aria-hidden="true"></i></a>&nbsp;&nbsp;                                    
                                </td>                                
                            </tr>                          
                    <?php  } }?>   -->                   
                                
                                
                                
                                <tr>
                                <td>1</td>
                                <td> brian</td>
                                <td>Creative Movement Specialist </td>                               
                                <td>Model </td> 
                                <td><span class="active-s"> Actived</span>
                                </td>
                                <td align="center"><a href="#" class="action"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                    <a href="#" class="action"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                     <a href="#" class="action"><i class="fa fa-eye" aria-hidden="true"></i></a></td>                               </tr>  
                                <tr>
                                    <td>2</td>
                                    <td> brian</td>
                                    <td>Creative Movement Specialist </td>                               
                                    <td>Model </td> 
                                    <td><span class="pending-s"> Pending</span>
                                    </td>
                                    <td align="center"><a href="#" class="action"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                        <a href="#" class="action"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                         <a href="#" class="action"><i class="fa fa-eye" aria-hidden="true"></i></a></td>                               </tr> 
                               <tr>
                                    <td>3</td>
                                    <td> brian</td>
                                    <td>Creative Movement Specialist </td>                               
                                    <td>Model </td> 
                                    <td><span class="reject-s"> Rejected</span>
                                    </td>
                                    <td align="center"><a href="#" class="action"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                        <a href="#" class="action"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                         <a href="#" class="action"><i class="fa fa-eye" aria-hidden="true"></i></a></td>                               </tr>   
                                                          
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
  