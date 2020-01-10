<?php $this->load->view('admin/includes/sidebar'); ?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Settings
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url('admin/dashboard');?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Settings</li>
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
                  <h3 class="box-title">Settings</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <form role="form" id="plan_form" name="" method="post" action="<?php echo base_url().'settings/update';?>" enctype="multipart/form-data">
                        <!-- text input -->
                        <section class="col-lg-12 connectedSortable">
                             <div class="form-group">
                                <label>Website Title </label>
                                <input type="text" class="form-control" name="website_title" placeholder="Website Title" value="<?php echo isset($website_title->field_value)? $website_title->field_value:'';?>">
                             </div>
														 <br>
														 <center><b>Front Page Upper-Section</b></center>
														 <div class="form-group">
                                <label>Front Page Heading </label>
                                <input type="text" class="form-control" name="front_page_heading" placeholder="Front Page Heading" value="<?php echo isset($front_page_heading->field_value)? $front_page_heading->field_value:'';?>">
                             </div>
														 
														 <div class="form-group">
                                <label>Front Page Sub-Heading </label>
                                <input type="text" class="form-control" name="front_page_subheading" placeholder="Front Page Sub-Heading" value="<?php echo isset($front_page_subheading->field_value)? $front_page_subheading->field_value:'';?>">
                             </div>
														 <br>
														 <center><b>Front Page Welcome-Section</b></center>
														 <div class="form-group">
                                <label>Welcome Content </label>
                                <textarea class="form-control" id="editor1" name="welcome_content" placeholder="Front Page Welcome Content"><?php echo isset($welcome_content->field_value)? $welcome_content->field_value:'';?></textarea>
                             </div>
														 <div class="form-group">
                                <label>Welcome Image <small>(standard size - 570x700)</small></label>
                                <input class="form-control"  name="welcome_image" type="file">
																<img src="<?php echo base_url('upload/'.$welcome_image->field_value); ?>">
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
