<?php $this->load->view('admin/includes/sidebar'); ?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Category
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
                  <h3 class="box-title">Add Category</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <form role="form" id="link_form" name="" method="post" action="<?php echo base_url().'category/add'; ?>" enctype="multipart/form-data">
                        <!-- text input -->
                        <section class="col-lg-12 connectedSortable">
                             <div class="form-group">
                                <label>Category </label>
                                <select class="form-control" name="parent">
                                    <?php foreach($categories as $category){?> 
                                        <?php foreach($category as $row){?>                                        
                                        <option value="<?=$row['id'].';'.$row['level']?>">                                            
                                            <?php echo str_repeat('--',$row['level']);?><?=$row['cname']?>                                            
                                        </option>                                        
                                    <?php } } ?>
                                    <option></option>
                                </select>    
                             </div>
                             
                             <div class="form-group">
                                <label>Name </label>
                                <input type="text" class="form-control" name="name" placeholder="Category Name" value="">
                             </div>                             
                             
                             <div class="form-group">
                                <label>Description </label>
                                <textarea class="form-control" name="description" placeholder="Category Description" value=""></textarea>
                             </div>
                             
                             <div class="form-group">
                                <label>Icon </label>
                                <input type="text" class="form-control" name="icon" placeholder="Category Icon" value="">
                             </div> 
                             
                             <div class="form-group">
                                <label>Image </label>
                                <input type="file" class="form-control" name="image" placeholder="Category Icon" value="">
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
