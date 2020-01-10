<?php $this->load->view('admin/includes/sidebar'); ?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Options
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url('admin/dashboard');?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Options</li>
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
                  <h3 class="box-title">Add Service Options</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <form role="form" id="link_form" name="" method="post" action="<?php echo base_url().'services/add_options'; ?>" enctype="multipart/form-data">
                        <!-- text input -->
                        <section class="col-lg-12 connectedSortable">
                             <div class="form-group">
                                <label>Services </label>
                                <select class="form-control" name="service_id">
                                    <?php foreach($services as $key => $service){?>
                                        <option value="" disabled><?=get_category($key)->title?></option>
                                        <?php foreach($service as $row){?>                                        
                                        <option value="<?=$row['id']?>">                                            
                                            ----<?=$row['title']?>                                            
                                        </option>                                        
                                    <?php } } ?>
                                    <option></option>
                                </select>    
                             </div>
                             
                             <div class="form-group">
                                <label>Field Key ( or  Title of option)</label>
                                <input type="text" class="form-control" name="field_key" placeholder="for eg. (What's wrong with your mobile? , what's your mobile color?  etc.) " value="">
                             </div>
                             
                             <div class="form-group">
                                <label>Field Name ( this name will be shown in the cart)</label>
                                <input type="text" class="form-control" name="field_name" placeholder="for eg. (Issues , Color etc.)" value="">
                             </div>
                             
                             <div class="form-group">
                                <label>Field Type </label>
                                <select class="form-control" name="field_type">
                                        <option value="input">Input Box</option>
                                        <option value="label">Label</option>
                                        <option value="qty">Add Button</option>
                                        <option value="radio">Radio Button</option>
                                        <option value="select-box">Select Box</option>                                                                                                                
                                </select>    
                             </div>
                             
                             <div class="form-group">
                                <label>Is Multiple ( if you select select-box then please mention it, otherwise leave it)?</label>
                                <select class="form-control" name="is_multiple">                                        
                                        <option value="0">no</option>
                                        <option value="1">yes</option>
                                </select>    
                             </div>
                             
                             <div class="form-group">
                                <label>Is that option is showing in List ? Then Please enter list name otherwise left blank </label>
                                <input type="text" class="form-control" name="list_name" placeholder="for eg. ( Hair Service , Nail, Men Articles etc.)" value="">
                             </div>
                             
                             <div class="form-group">
                                <label>Field Value ( this may be multiple with comma separated values)</label>
                                <input type="text" class="form-control" name="field_value" placeholder="for eg. (Broken Screen, Broken Back Cover, Water Damage etc.)" value="">
                             </div>
                             
                             <div class="form-group">
                                <label>Field icon </label>
                                <input type="text" class="form-control" name="field_icon" placeholder="for eg. (far fa-handshake, fas fa-truck)">
                             </div>                                                          
                             
                             <div class="form-group">
                                <label>Is Required ?</label>
                                <select class="form-control" name="is_required">
                                        <option value="1">yes</option>
                                        <option value="0">no</option>                                        
                                </select>    
                             </div>
                             
                             <div class="form-group">
                                <label>Status</label>
                                <select class="form-control" name="status">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>                                        
                                </select>    
                             </div>
                             
                             <div class="box-footer">
                                <input type="submit" class="btn btn-primary" name="Update_profile" value="Add">
                                
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
