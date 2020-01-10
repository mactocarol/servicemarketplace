<?php $this->load->view('admin/includes/sidebar'); ?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        All Orders
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
                  <h3 class="box-title">Orders</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                 
                 <div class="panel-body">
                        <div class="table-responsive">                                                 
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                  <th>Sr. No.</th>                        
                                  <th width="30%">Products</th>                      
                                  <th>Price</th>
                                  <th>Order Id</th>
                                  <th>Status</th>
                                  <th>Payment Mode</th>
                                  <th>Order By</th>
                                  <th>Transaction Id</th>
                                </tr>
                                </thead>
                                <tbody>
                                       <?php 
                                            $count = 0; $total=0;
                                            if(!empty($orders)){
                                            foreach($orders as $row){ 
                                            if(get_order_detail($row['order_no'])) { ?>
                                                <tr>
                                                    <td><?= ++$count; ?></td>
                                                    <td>
                                                        <?php 
                                                            foreach(get_order_detail($row['order_no']) as $order){
                                                                echo "<a href='view/".$order->id."'>".$order->title."</a> <a href='download/?file=".$order->file."'><u>Download Link</u></a>"."<br><br>";
                                                            }
                                                            ?>                                  
                                                    </td>                                
                                                    <td>
                                                        $ <?php echo isset($row['amount']) ? $row['amount'] : ''; ?> 
                                                    </td>
                                                    <td>
                                                        <?php echo isset($row['order_no']) ? $row['order_no'] : ''; ?> 
                                                    </td>
                                                    <td>
                                                        <?php echo isset($row['payment_status']) ? (($row['payment_status']==2)?'Accepted':'Pending') : ''; ?> 
                                                    </td>
                                                    <td>
                                                        <?php echo isset($row['payment_type']) ? $row['payment_type'] : ''; ?> 
                                                    </td>
                                                    <td>
                                                        <?php echo isset($row['user_id']) ? "<a href='admin/edit_user/".$row['id']."'>".get_user($row['user_id'])->username : ''; ?> 
                                                    </td>
                                                    <td>
                                                        <?php echo isset($row['transaction_id']) ? $row['transaction_id'] : 'N/A'; ?> 
                                                    </td>
                                                    
                                                </tr>                                                                                
                                        
                                <?php } } } else { ?>
                                <tr><td colspan="4">No Orders</td></tr>                    
                                <?php } ?>
                                </tbody>
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
  