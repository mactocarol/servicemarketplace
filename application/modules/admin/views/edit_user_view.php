<?php $this->load->view('admin/includes/sidebar'); ?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Edit User
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
                  <h3 class="box-title">Edit User</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <form role="form" id="edit_investor_form" name="" method="post" action="<?php echo base_url().'admin/edit_user/'.$reslt->id; ?>" enctype="multipart/form-data">
                        <!-- text input -->
                        <section class="col-lg-12 connectedSortable">
                            <div class="form-group">
                               <!--  <label>First Name </label>
                                <input type="text" class="form-control" name="f_name" placeholder="First Name" value="<?php echo isset($reslt->f_name)? $reslt->f_name:'';?>">
                             </div> -->
                            <!-- <div class="form-group">
                                <label>Last Name </label>
                                <input type="text" class="form-control" name="l_name" placeholder="Last Name" value="<?php echo isset($reslt->l_name)? $reslt->l_name:'';?>">
                             </div> -->
                              <label>Full Name </label>
                                <input type="text" class="form-control" name="name" placeholder="Full Name" value="<?php echo isset($reslt->name)? $reslt->name:'';?>">
                             </div>
                            <!--  <div class="form-group">
                                <label>Username </label>
                                <input type="text" class="form-control" name="username" placeholder="Username" value="<?php echo isset($reslt->user_name)? $reslt->user_name:'';?>">
                             </div> -->
                             <div class="form-group">
                                <label>Email </label>
                                <input type="email" class="form-control" name="email" placeholder="Email" value="<?php echo isset($reslt->email)? $reslt->email:'';?>">
                             </div>
                             <div class="form-group">
                                <label>Phone</label>
                                <input type="text" class="form-control" name="contact" placeholder="Contact Number" value="<?php echo isset($reslt->contact)? $reslt->contact:'';?>">
                             </div>
                             <div class="form-group">
                                <label>Gender</label><br>
                                Male <input type="radio"  name="gender" value="male" <?php if($reslt->gender == 'male') echo "checked";?>>
                                Female <input type="radio"  name="gender" value="female" <?php if($reslt->gender == 'female') echo "checked";?>>
                             </div>                                                        
                             <div class="form-group">
                                <label>Address</label>
                                <input type="text" class="form-control" name="address" placeholder="Address" value="<?php echo isset($reslt->address)? $reslt->address:'';?>">
                             </div>
                             <div class="form-group">
                                <label>City</label>
                                <input type="text" class="form-control" name="city" placeholder="City" value="<?php echo isset($reslt->city)? $reslt->city:'';?>">
                             </div>
                             <div class="form-group">
                                <label>Country</label>
                                <input type="text" class="form-control" name="country" placeholder="Country" value="<?php echo isset($reslt->country)? $reslt->country:'';?>">
                             </div>
                             <!--  <div class="form-group">
                                <label>User Profile Image </label>
                                <input type="file" class="form-control" name="image" value="<?php echo $reslt->image; ?>">
                                <img src="<?php echo base_url('upload/profile_image/thumb/'.$reslt->image);?>" width="100" height="100">
                                <?php print_r($reslt->image); ?>
                             </div> -->
                             <div class="box-footer">
                                <input type="submit" class="btn btn-primary" value="Update">
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
