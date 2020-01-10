<?php $this->load->view('admin/includes/sidebar'); ?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        All Earnings
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
                  <h3 class="box-title">Earnings</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                 
                 <div class="panel-body">
                        <div class="table-responsive">                                                 
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                  <th>Sr. No.</th>                        
                                  <th>Title</th>
                                  <th>Payment By</th>
                                  <th>Payment To</th>
                                  <th>Total Amount</th>
                                  <th>Earning</th>                                                                                      
                                  <th>Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                      <?php if(isset($earnings)) {
                                            $count = 0;                              
                                            foreach($earnings as $row){ ?>
                                        <tr>
                                            <td><?= ++$count; ?></td>
                                            <td>
                                                <?php echo ($row['product_id']) ? '<a href="'.site_url('products/view/'.$row['product_id']).'">'.get_product($row['product_id'])->title.'</a>' : '<a href="#">By Contract Deal </a>'; ?>
                                              </td>
                                            <td>
                                                <?php echo '<a href="'.site_url('admin/edit_user/'.$row['user_id']).'">'.get_user($row['user_id'])->username.'</a>'; ?>
                                            </td>
                                            <td>
                                                <?php echo ($row['seller_id']) ? '<a href="'.site_url('admin/edit_user/'.$row['seller_id']).'">'.get_user($row['seller_id'])->username.'</a>' : ''; ?>
                                            </td>
                                            <td>                                    
                                               <?php echo isset($row['seller_commission']) ? '$ '.((($row['seller_commission']*100)/(100-$charge))) : ''; ?>                                    
                                            </td>
                                            <td>                                    
                                               <?php echo isset($row['seller_commission']) ? '$ '.($charge*(($row['seller_commission']*100)/(100-$charge))/100) : ''; ?>                                    
                                            </td>
                                            <td>
                                                <?php echo isset($row['created_at']) ? date('d M Y h:i:s',strtotime($row['created_at'])) : ''; ?>
                                            </td>
                                        </tr>                          
                                <?php  } }?>                       
                                                                   
                                </tfoot>
                            </table>
                        </div>
                        </div>
              
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
  