<?php $this->load->view('admin/includes/sidebar'); ?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Admin Profile
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url('admin/dashboard');?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Profile</li>
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
                  <h3 class="box-title">Update Profile</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <form role="form" id="profile_update_form" name="" method="post" action="<?php echo base_url().'admin/update_profile'; ?>">
                        <!-- text input -->
                        <section class="connectedSortable">
                        
                        <div class="row">
                        	<div class="col-md-4">
                            	<div class="form-group">
                                <label>First Name </label>
                                <input type="text" class="form-control" name="f_name" placeholder="First Name" value="<?php echo isset($result->f_name)? $result->f_name:'';?>">
                             	</div>
                            </div>
                            <div class="col-md-4">
                            	<div class="form-group">
                                    <label>Last Name </label>
                                    <input type="text" class="form-control" name="l_name" placeholder="Last Name" value="<?php echo isset($result->l_name)? $result->l_name:'';?>">
                                 </div>
                            </div>
                            <div class="col-md-4">
                            	<div class="form-group">
                                    <label>Username </label>
                                    <input type="text" class="form-control" name="username" placeholder="Username" value="<?php echo isset($result->username)? $result->username:'';?>">
                                 </div>
                            </div>
                            
                        </div>
                        
                        <div class="form-group">
                                <label>Email </label>
                                <input type="email" class="form-control" name="email" placeholder="Email" value="<?php echo isset($result->email)? $result->email:'';?>" readonly>
                             </div>
                        
                            <div class="row">
                               <div class="col-md-6"> 
                                        <div class="form-group">
                                        <label>Password </label>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="(Should be blank if not want to change)" value="">
                                     </div>
                             </div>
                             
                             <div class="col-md-6">
                             	<div class="form-group">
                                    <label>Confirm Password</label>
                                    <input type="password" class="form-control" id="repassword" name="repassword" placeholder="(Should be blank if not want to change)" value="">
                                 </div>
                             </div>
                             
                            </div> 
                             
                             <div class="box-footer">
                                <input type="submit" class="btn btn-primary" name="Update_profile" value="Update">
                                
                             </div>
                           </section>
                        
                  </form>
                </div>
               </div>
        </section>
        <!-- /.Left col -->   
    </div>
    </section>
    <!-- /.content -->
  </div>
