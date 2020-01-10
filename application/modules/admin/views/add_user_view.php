<?php $this->load->view('admin/includes/sidebar'); ?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add User
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
                  <h3 class="box-title">Add User</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <form role="form" id="add_user_form" name="" method="post" action="<?php echo base_url().'admin/add_user'; ?>" enctype="multipart/form-data">
                        <!-- text input -->
                        <section class="col-lg-12 connectedSortable">
                            <div class="form-group">
                                <label>First Name </label>
                                <input type="text" class="form-control" name="f_name" placeholder="First Name" value="">
                             </div>
                            <div class="form-group">
                                <label>Last Name </label>
                                <input type="text" class="form-control" name="l_name" placeholder="Last Name" value="">
                             </div>
                             <div class="form-group">
                                <label>Username </label>
                                <input type="text" class="form-control" name="username" placeholder="Username" value="">
                             </div>
                             <div class="form-group">
                                <label>Email </label>
                                <input type="email" class="form-control" name="email" placeholder="Email" value="">
                             </div>
                             <div class="form-group">
                                <label>Contact</label>
                                <input type="text" class="form-control" name="contact" placeholder="Contact Number" value="">
                             </div>
                             <div class="form-group">
                                <label>User Profile Image </label>
                                <input type="file" class="form-control" name="profile_image" >                                
                             </div>
                             <div class="form-group">
                                <label>User Cover Image </label>
                                <input type="file" class="form-control" name="cover_image" >                                
                             </div>
                             <div class="form-group">
                                <label>Address</label>
                                <input type="text" class="form-control" name="address" placeholder="Address" value="">
                             </div>
                             <div class="form-group">
                                <label>About Me</label>
                                <textarea class="form-control" name="about_me" rows='5' placeholder="About me" ></textarea>
                             </div>
                             <!-- <div class="form-group">
                                <label>Category</label>                                
                                
                                <select  id="boot-multiselect-demo" name="category[]"  multiple="multiple" required>                            
                                    <?php foreach($categories as $c):?>
                                    <option value="<?=$c['id']?>" ><?=$c['name']?></option>
                                    <?php endforeach;?>
                                </select>
                             </div>    -->                          
                             <div class="form-group">
                                <label>Gender</label><br>
                                Male <input type="radio"  name="gender" value="male" checked>
                                Female <input type="radio"  name="gender" value="female" >
                             </div>
                             <div class="form-group">
                                <label>Date of Birth</label>
                                <input type="text" placeholder="Enter Your DOB" class="input-text form-control" id="datepicker" name="dob" value="">
                                
                             </div>
                             <div class="form-group">
                                <label>Company name (if any)</label>
                                <input type="text" class="form-control" name="companyname" placeholder=" Company name (if any)" value="">
                             </div>
                             <div class="form-group">
                                <label>Company Logo (if any)</label>
                                <input type="file" class="form-control" name="companylogo" >                                
                             </div>
                             <div class="form-group">
                                <label>Designation</label>
                                <input type="text" class="form-control" name="designation" placeholder=" Your Current Designation (if any)" value="">
                             </div>
                             <div class="form-group">
                                <label>Experience</label>
                                <input type="text" class="form-control" name="experience" placeholder="Your Experience" value="">
                             </div>
                             <div class="form-group">
                                <label>Password </label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password" value="">
                             </div>
                             <div class="form-group">
                                <label>Confirm Password</label>
                                <input type="password" class="form-control" id="repassword" name="repassword" placeholder="Confirm Password" value="">
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
