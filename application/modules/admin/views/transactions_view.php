<?php $this->load->view('admin/includes/sidebar'); ?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        All Transactions
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
                  <h3 class="box-title">Transactions</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                 
                 <div class="panel-body">
                        <div class="table-responsive">                                                 
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                  <th>Sr. No.</th>                        
                                  <th>Order Id</th>
                                  <th>Transaction Id</th>
                                  <th>Paid By</th>
                                  <th>Amount</th>                                  
                                  <th>Payment Type</th>                      
                                  <th>Status</th>
                                  <th>Payment Mode</th>
                                  <th>Paid To</th>
                                  <th>Order Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                      <?php if(isset($transactions)) {
                                            $count = 0;                              
                                            foreach($transactions as $row){ ?>
                                        <tr>
                                            <td><?= ++$count; ?></td>
                                            <td>
                                                <?php echo isset($row['order_id']) ? $row['order_id'] : ''; ?>                                    
                                              </td>
                                            <td>                                    
                                               <?php echo ($row['txn_id']) ? ($row['txn_id']) : 'N/A'; ?>                                    
                                            </td>
                                            <td>
                                                <?php echo isset($row['user_id']) ? "<a href='admin/edit_user/".$row['id']."'>".get_user($row['user_id'])->username : ''; ?> 
                                            </td>
                                            <td>
                                                <?php echo isset($row['payment_amt']) ? $row['payment_amt'].' '.$row['currency_code'] : ''; ?> 
                                            </td>
                                            <td>
                                               <?php echo ($row['payment_type'] == 1) ? 'Membership fee' : (($row['payment_type'] == 2) ? 'Shopping Fee' : (($row['payment_type'] == 3) ? 'Contract Fee' : 'Wallet Amount')); ?>
                                            </td>
                                            <td>
                                                <?php echo isset($row['status']) ? ($row['status']) : ''; ?>
                                            </td>
                                            <td>
                                                <?php echo isset($row['payment_mode']) ? ($row['payment_mode']) : ''; ?>
                                            </td>                                            
                                            <td>
                                                <?php
                                                if($row['payment_type'] != ''){
                                                    echo isset($row['seller_id']) ? "<a href='admin/edit_user/".$row['id']."'>".get_user($row['seller_id'])->username."</a>" : 'Admin'; 
                                                } else {
                                                    echo 'Self';
                                                } ?>
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
  