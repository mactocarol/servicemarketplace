<?php $this->load->view('admin/includes/sidebar'); ?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        All Withdraw Requests
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
                  <h3 class="box-title">Withdraw Request</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                 
                 <div class="panel-body">
                        <div class="table-responsive">                                                 
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                  <th>Sr. No.</th>                                                          
                                  <th>Request By</th>
                                  <th>Wallet Amount</th>                      
                                  <th>Requested Amount</th>                                                                                                                                    
                                  <th>Date</th>
                                  <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                      <?php if(isset($withdraw)) {
                                            $count = 0;                              
                                            foreach($withdraw as $row){ ?>
                                        <tr>
                                            <td><?= ++$count; ?></td>                                           
                                            <td>
                                                <?php echo isset($row['user_id']) ? "<a href='edit_user/".$row['user_id']."'>".get_user($row['user_id'])->username."</a>" : ''; ?> 
                                            </td>
                                            <td>
                                                <?php echo isset($row['user_id']) ? "$".get_wallet($row['user_id'])->amount : ''; ?> 
                                            </td>
                                            <td>
                                                <?php echo isset($row['amount']) ? '$'.$row['amount'] : ''; ?> 
                                            </td>                                                                                        
                                            
                                            <td>
                                                <?php echo isset($row['created_at']) ? date('d M Y h:i:s',strtotime($row['created_at'])) : ''; ?>
                                            </td>
                                            <td>
                                                <a href="<?php echo site_url('admin/pay/'.$row['id']);?>"><i class="fa fa-eye"></i></a>
                                            </td>
                                        </tr>                          
                                <?php  } }?>                      
                                                                   
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <hr>
                    <h4>History</h4>
                    <div class="panel-body">
                        <div class="table-responsive">                                                 
                            <table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                  <th>Sr. No.</th>                                                          
                                  <th>To</th>                                                    
                                  <th>Amount</th>
                                  <th>Transfer Method</th>
                                   <th>Paypal Id</th>
                                    <th>IFSC Code</th>
                                    <th>Bank Account Number</th>
                                    <th>Account Holder name</th>
                                  <th>Date</th>                                  
                                </tr>
                                </thead>
                                <tbody>
                                      <?php if(isset($withdraw_history)) {
                                            $count = 0;                              
                                            foreach($withdraw_history as $row){ ?>
                                        <tr>
                                            <td><?= ++$count; ?></td>                                           
                                            <td>
                                                <?php echo isset($row['user_id']) ? "<a href='edit_user/".$row['user_id']."'>".get_user($row['user_id'])->username."</a>" : ''; ?> 
                                            </td>                                            
                                            <td>
                                                <?php echo isset($row['amount']) ? '$'.$row['amount'] : ''; ?> 
                                            </td>                                                                                        
                                             <td>
                                                <?php echo isset($row['transfer_method']) ? $row['transfer_method'] : ''; ?> 
                                            </td>
                                             <td>
                                                <?php echo isset($row['paypal_id']) ? $row['paypal_id'] : 'N/A'; ?> 
                                            </td>
                                            <td>
                                                <?php echo isset($row['ifsc']) ? $row['ifsc'] : 'N/A'; ?> 
                                            </td>
                                            <td>
                                                <?php echo isset($row['acc_no']) ? $row['acc_no'] : 'N/A'; ?> 
                                            </td>
                                            <td>
                                                <?php echo isset($row['acc_name']) ? $row['acc_name'] : 'N/A'; ?> 
                                            </td>
                                            <td>
                                                <?php echo isset($row['updated_at']) ? date('d M Y h:i:s',strtotime($row['updated_at'])) : ''; ?>
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
  