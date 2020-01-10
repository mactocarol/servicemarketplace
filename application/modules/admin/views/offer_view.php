<?php $this->load->view('admin/includes/sidebar'); ?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        All Offers
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
                  <h3 class="box-title">Offers</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                 
                 <div class="panel-body">
                        <div class="table-responsive">                                                 
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Offer From</th>
                                    <th>Offer Amount</th>
                                    <th>Offer To</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                      <?php if(isset($offer)) {
                                        $count = 0;                              
                                        foreach($offer as $row){ ?>
                                        <tr>
                                            <td>
                                                <?= ++$count; ?>                                            
                                            </td>
                                            <td>
                                                <?php echo ($row['offer_from']) ? '<a href="'.site_url('admin/edit_user/'.$row['offer_from']).'">'.get_user($row['offer_from'])->username.'</a>' : ''; ?>
                                            </td>                                                          
                                            <td>
                                                <?php echo isset($row['offer_amount']) ? $row['offer_amount'] : '';   ?>
                                                <?php if($type == 'sent'){ 
                                                    echo (get_offer_money($row['id'])) ? '($'.get_offer_money($row['id']).' sent)': '';
                                                }else{
                                                    echo (get_offer_money($row['id'])) ? '($'.get_offer_money($row['id']).' received)': '';
                                                }?>
                                            </td>
                                            <td>
                                                <?php echo ($row['offer_to']) ? '<a href="'.site_url('admin/edit_user/'.$row['offer_to']).'">'.get_user($row['offer_to'])->username.'</a>' : ''; ?>
                                            </td>                            
                                            <td>
                                                <?php echo ($row['status'] == 1) ? '<button class="btn btn-info">Pending</button>' : '';   ?>
                                                <?php echo ($row['status'] == 2 && ($row['is_contract_signed'] == 0)) ? '<button class="btn-sm btn-success">Accepted</button>' : '';   ?>
                                                <?php echo ($row['status'] == 2 && ($row['is_contract_signed'] == 1)) ? '<button class="btn-sm btn-success">Accept & Contracted</button>': '';?>
                                                <?php echo ($row['status'] == 3) ? '<button class="btn btn-primary">Negotiated</button>' : '';   ?>
                                                <?php echo ($row['status'] == 4) ? '<button class="btn btn-danger">Declined</button>' : '';   ?>                                                                                    
                                            </td>
                                            <td>
                                            <a href="<?php echo site_url('admin/offer_detail/'.$row['id']);?>"><button class="btn btn-info">View </button></a>                                            
                                            
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
  