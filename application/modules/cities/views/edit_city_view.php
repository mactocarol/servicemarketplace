<?php $this->load->view('admin/includes/sidebar'); ?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?= $title ?>
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url('admin/dashboard');?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Category</li>
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
                  <h3 class="box-title"><?= $title ?></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <form role="form" id="link_form" name="" method="post" action="<?php echo base_url().'cities/editcity'; ?>/<?= $city->id;?>" enctype="multipart/form-data">
                        <!-- text input -->
                        <section class="col-lg-12 connectedSortable">                             
                              <input type="hidden" class="form-control" name="id" placeholder="Ctiy Name" value="<?= $city->id ?>" required>
                             <div class="form-group">
                                <label>Name </label>
                                <input type="text" class="form-control" name="title" placeholder="Ctiy Name" value="<?= $city->title ?>" required>
                             </div>     
							 
                             <div class="form-group">
                                <label>Status </label>
                               <select name="status" class="form-control">
							   <option value="" disabled>Please Select</option>
							   <option value="1" <?= ($city->status == 1) ? 'selected' : ''; ?>>Active</option>
							   <option value="0" <?= ($city->status == 0) ? 'selected' : ''; ?>>Inactive</option>
							   </select>
                             </div>                           
                             
                             <div class="box-footer">
                                <input type="submit" class="btn btn-primary" name="Update_profile" value="Edit">
                                
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
