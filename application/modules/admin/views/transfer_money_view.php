<?php $this->load->view('admin/includes/sidebar'); ?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Transfer Money
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
        <!-- Left col -->
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
        <section class="col-lg-12 connectedSortable">                
               <div class="box">
                <div class="box-header">
                  <h3 class="box-title">User Account Info</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <div id="upload_msg"></div> 
                    
                    
                                   <form role="form" id="" name="" method="post" action="<?php echo base_url().'admin/pay/'.$request_id?>">
                                            
                                            <div class="form-group">
                                            <label> Amount </label> 
                                             <div class="input_box"> 
                                                 <input   class="input-text form-control" type="text" value="<?php echo isset($price)? $price:'';?>" readonly>                                                 
                                             </div>
                                             </div>
                                            <div class="form-group">
                                            <label> Transfer Method </label> 
                                             <div class="input_box"> 
                                                 <input  class="input-text form-control" type="text" value="<?php echo isset($method)? $method:'';?>" readonly>                                                 
                                             </div>
                                             </div>
                                             <?php if($method == 'Paypal') { ?>
                                             <div class="form-group">
                                            <label> Paypal Id </label> 
                                             <div class="input_box"> 
                                                 <input  class="input-text form-control" type="text" value="<?php echo isset($paypal_id)? $paypal_id:'';?>" readonly>                                                 
                                             </div>
                                             </div>
                                             <?php } else { ?>
                                             <div class="form-group">
                                            <label> IFSC Code </label> 
                                             <div class="input_box"> 
                                                 <input  class="input-text form-control" type="text" value="<?php echo isset($ifsc)? $ifsc:'';?>" readonly>                                                 
                                             </div>
                                             </div>
                                             <div class="form-group">
                                            <label> Bank Account Number </label> 
                                             <div class="input_box"> 
                                                 <input  class="input-text form-control" type="text" value="<?php echo isset($acc_no)? $acc_no:'';?>" readonly>                                                 
                                             </div>
                                             </div>
                                             <div class="form-group">
                                            <label> Account Holder Name</label> 
                                             <div class="input_box"> 
                                                 <input  class="input-text form-control" type="text" value="<?php echo isset($acc_name)? $acc_name:'';?>" readonly>                                                 
                                             </div>
                                             </div>
                                             <?php } ?>
                                             
                                             
                                             <div class="form-group">
                                                <!--<input type="submit" class="btn btn-primary" value="Submit">-->
                                                <input type="submit" name='submit_image' class="btn btn-primary" value="Update Status"/> 
                                             
                                             </div>
                                             
                                     
                                </form>
                                                                
                            </div> 
                </div>
               </div>
        </section>
        <!-- /.Left col -->
   
    </div>

    </section>
    <!-- /.content -->
  </div>
