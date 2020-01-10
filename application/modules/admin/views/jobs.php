<?php $this->load->view('admin/includes/sidebar'); ?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        List Jobs
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url('admin/dashboard');?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">List Jobs</li>
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
            <!-- Left col -->
            <section class="col-lg-12 connectedSortable">
                
               <div class="box">
                <div class="box-header">
                  <h3 class="box-title">List Jobs</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                 <table class="table table-bordered" id="dataTable" cellspacing="0">
                    <thead>
                    <tr>
                      <th width="5%">Sr. No.</th>                        
                      <th width="15%">Title</th>                      
                      <th width="5%">Category</th>
                      <th width="5%">Created By</th>
                      <th width="40%">Description</th>
                      <th width="5%">Status</th>
					  <th width="5%">Applicants</th>
                      <th width="10%">Action</th>                   
                    </tr>
                    </thead>
                    <tbody>
                          <?php if(isset($jobs)) {
                                $count = 0;                              
                                foreach($jobs as $row){ ?>
                            <tr>
                                <td><?= ++$count; ?></td>
                                <td>
                                    <?php echo isset($row['title']) ? $row['title'] : ''; ?>                                    
                                </td>                                                     
                                
                                <td>
                                    <?php echo isset($row['name']) ? $row['name'] : '';   ?>
                                </td>
                                <td>
                                    <a href="<?php echo site_url('admin/edit_user/'.$row['user_id']);?>"><?php echo isset($row['user_id']) ? get_user($row['user_id'])->username : '';   ?></a>
                                </td>
                                <td>
                                    <?php echo isset($row['description']) ? substr($row['description'],0,200) : '';   ?>                                   
                                </td>
                                <td>
                                    <?php echo ($row['status'] == 1) ? 'Open' : 'Close';   ?>
                                </td>
								<td>
									<a href="#" onclick="job_applicant_modal(<?=$row['id']?>);" data-toggle="modal" data-target="#applicantModal"><u><?php echo isset($row['total_app']) ? $row['total_app'].' member applied' : ''; ?></u></a>                                   
								</td>
                                <td>
                                    <a href="<?php echo base_url(); ?>admin/edit_jobs/<?php echo $row['id'];?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                    <a href="<?php echo base_url(); ?>admin/delete_job/<?php echo $row['id'];?>/3" onclick=" var c = confirm('Are you sure want to delete?'); if(!c) return false;"><i class="fa fa-close" aria-hidden="true"></i></a>&nbsp;&nbsp;                                    
                                </td>                                
                            </tr>                          
                    <?php  } }?>                      
                                                       
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
  
  <!-- video Modal -->
<div id="applicantModal" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width: auto";>

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Job Applicants</h4>
      </div>
      <div class="modal-body">
        <p>
            <div id="applicants">
                
            </div>
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<script>
function job_applicant_modal(id) {
        $(".modal-body #userid").val( id );
        $.ajax({
			url: "<?php echo site_url('admin/applicants');?>",
			type: "POST",
			data: {"job_id":id},            
			success: function (data) {
                //console.log(data);
				$(".modal-body #applicants").html( data );
			}
		});
 
   }
</script>