<?php $this->load->view('admin/includes/sidebar'); ?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add Entreprenuer
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
                  <h3 class="box-title">Add Entrepreneur</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <form role="form" id="add_entrepreneur_form" name="" method="post" action="<?php echo base_url().'admin/add_entreprenuer'; ?>">
                        <!-- text input -->
                        <section class="connectedSortable"> 
                        <div class="form-group">
                                    <label>Username </label>
                                    <input type="text" class="form-control" name="username" placeholder="Username" value="">
                                 </div>  
                        <div class="row">
                        	<div class="col-md-6">
                            	
                                  <div class="form-group">
                                <label>Contact</label>
                                <input type="text" class="form-control" name="contact" placeholder="Contact Number" value="">
                             </div>
                            </div>
                            <div class="col-md-6">
                            	<div class="form-group">
                                    <label>Email </label>
                                    <input type="email" class="form-control" name="email" placeholder="Email" value="">
                                 </div>
                            </div>
                        </div>                          
                         <div class="row">
                            <div class="col-md-6">
                            	 <div class="form-group">
                                <label>Category</label>
                                <select class="form-control select-menu" name="category">
                                    <option value="">Select your category</option>
                                    <?php foreach($categories as $cat){?>
                                        <option value="<?=$cat['name']?>" ><?=$cat['name']?></option>
                                    <?php } ?>
                                </select>
                             </div> 
                            </div>
                            <div class="col-md-6">
                            	<div class="form-group">
                                <label>Company Name</label>
                                <input type="text" class="form-control" id="companyname" name="companyname" placeholder="Company Name" value="">
                             </div>
                            </div>
                          </div> 
                             
                            
                                                        
                             
                             
                              <div class="row">
                               <div class="col-md-6"> 
                                        <div class="form-group">
                                        <label>Password </label>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" value="">
                                     </div>
                             </div>
                             
                             <div class="col-md-6">
                             	<div class="form-group">
                                    <label>Confirm Password</label>
                                    <input type="password" class="form-control" id="repassword" name="repassword" placeholder="Confirm Password" value="">
                                 </div>
                             </div>
                             
                            </div> 
                             
                             
                            
                             
                             <div class="box-footer">
                                <input type="submit" class="btn btn-primary" value="Add">                                
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
