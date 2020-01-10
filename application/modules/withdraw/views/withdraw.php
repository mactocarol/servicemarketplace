<?php $this->load->view('admin/includes/sidebar'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
    List Category
    <small>Control panel</small>
  </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('admin/dashboard');?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">List Category</li>
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
                        <strong>Success!</strong>
                        <?php print_r($items->message); ?>
                    </div>
                    <?php
                }else{
                ?>
                        <div class="alert alert-danger" id="alert">
                            <strong>Error!</strong>
                            <?php print_r($items->message); ?>
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
                        <h3 class="box-title">List Category</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Name</th>
                                    <th>Amount</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Request Date / Time</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                              <?php if(isset($withdrawAmount)) {
                                $count = 0;                              
                                foreach($withdrawAmount as $key => $oneRow){ 
                                  
                              ?>
                                    <tr>
                                      <td>
                                        <?php echo ++$count; ?>
                                      </td>
                                      <td>
                                        <?php echo ($oneRow['f_name']) ? $oneRow['f_name'].' '.$oneRow['l_name'] : $oneRow['username']; ?>
                                      </td>
                                      <td>
                                        <?php echo ($oneRow['amount']) ? $oneRow['amount'] : 'NA'; ?>
                                      </td>
                                      <td>
                                        <?php echo ($oneRow['phone']) ? $oneRow['phone'] : 'NA'; ?>
                                      </td>
                                      <td>
                                        <?php echo ($oneRow['address']) ? $oneRow['address'] : 'NA'; ?>
                                      </td>
                                      <td>
                                        <?php echo date('d M, Y',strtotime($oneRow['crd'])).' / '.date('h:i a',strtotime($oneRow['crd'])); ?>
                                      </td>
                                      <td>
                                        <?php if($oneRow['status'] == 1){?>
                                        <a class="btn" href="javascript:void(0);" type="button" style="color: orange">PENDING</a>
                                        <?php } ?>
                                        <?php if($oneRow['status'] == 2){?>
                                        <a class="btn" href="javascript:void(0);" type="button" style="color: green">ACCEPTED</a>
                                        <?php } ?>
                                        <?php if($oneRow['status'] == 3){?>
                                        <a class="btn" href="javascript:void(0);" type="button" style="color: red">CANCLE</a>
                                        <?php } ?>
                                        <?php if($oneRow['status'] == 4){?>
                                        <a class="btn" href="javascript:void(0);" type="button" style="color: red">CANCLE</a>
                                        <?php } ?>
                                      </td>
                                      <td>
                                        <?php if($oneRow['status'] == 1){?>
                                        <a href="<?php echo base_url('withdraw/cancle/').$oneRow['withdrawId']; ?>" type="button" class="btn btn_view"> 
                                          <i class="fa fa-close"></i> Cancle
                                        </a>
                                        <a href="<?php echo base_url('withdraw/paid/').$oneRow['withdrawId']; ?>" type="button" class="btn btn_view">
                                          <i class="fa fa-check"></i> Paid
                                        </a>
                                        <?php } ?>
                                        <?php if($oneRow['status'] == 2){?>
                                        <a href="javascript:void(0);" type="button" class="btn btn_view"> Paid</a>
                                        <?php } ?>
                                        <?php if($oneRow['status'] == 3){?>
                                        <a href="javascript:void(0);" type="button" class="btn btn_view"> By User</a>
                                        <?php } ?>
                                        <?php if($oneRow['status'] == 4){?>
                                        <a href="javascript:void(0);" type="button" class="btn btn_view"> By You</a>
                                        <?php } ?>
                                      </td>
                                    </tr>
                              <?php  
                                  
                                } 
                              } 
                              ?>
                            </tbody>
                            
                            <tfoot>
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