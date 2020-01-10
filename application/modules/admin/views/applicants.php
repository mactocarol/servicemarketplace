<div class="container">
    <h4><b></b></h4>
    <hr>
    <div class="row">
        
        <div class="col-md-12">
        <table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0">
            <thead>
            <tr>
			  <th>Sr. No.</th>                        
			  <th>Title</th>
			  <th>Username (Email)</th>
			  <th>Resume</th>
			  <th>File (if any)</th>
			  <th>View Proposal</th>
			  <th>Action</th>
			</tr>
            </thead>
            <tbody>
                  <?php if(isset($applied_jobs)) {
							$count = 0;                              
							foreach($applied_jobs as $row){ ?>
								<tr>
									<td><?= ++$count; ?></td>
									<td>
										<a href="<?php echo site_url('jobs/view/'.$row['id']);?>"><?php echo isset($row['title']) ? $row['title'] : ''; ?></a>
									  </td>
									<td>                                    
									   <?php echo isset($row['apply_by']) ? $row['apply_by']->username.' ('.$row['apply_by']->email.')' : ''; ?>                                    
									</td>
									<td>                                                                       
									   <a href="<?php echo site_url('jobs/download?file='.urlencode($row['resume']));?>"><u><?=$row['resume']?></u></a>
									</td>
									<td>
										<?php
										 $ext = pathinfo($row['file'], PATHINFO_EXTENSION);
										 if(isset($row['file']) && $row['file'] != '' && ($ext == 'mp4' || $ext == 'avi' || $ext == 'mov')) { ?>  
										  <video width="200" height="100" controls>
											<source src="<?php echo base_url('upload/products/'.$row['file']); ?>" type="video/mp4">
											<source src="<?php echo base_url('upload/products/'.$row['file']); ?>" type="video/avi">
											<source src="<?php echo base_url('upload/products/'.$row['file']); ?>" type="video/mov">
										  Your browser does not support the video tag.
										  </video>
										<?php } else if(isset($row['file']) && $row['file'] != '' && $ext == 'mp3') { ?>
											<audio controls>
												<source src="<?php echo base_url('upload/products/'.$row['file']); ?>" type="audio/ogg">
												<source src="<?php echo base_url('upload/products/'.$row['file']); ?>" type="audio/mpeg">
											  Your browser does not support the audio element.
											</audio>                                      
										<?php } else if(isset($row['file']) && $row['file'] != '' && ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png')){  ?>
											<img src="<?php echo base_url('upload/products/'.$row['file']);?>" width="100">
										<?php } ?>                                   
									</td>
									<td>                                                                       
									   <button type="button" class="btn btn-info btn-sm showproposal" data-id="<?=$row['proposal']?>" data-toggle="modal" data-target="#proposal">View</button>
									</td>
									<td>                                                                       
									   <a href="mailto:<?=$row['apply_by']->email?>"><u>Send Mail</u></a>
									</td>
								</tr>                          
                                             
            <?php  } } else { echo "<tr><td colspan='5'>No Results</td></tr>"; }?>                      
                                               
            </tfoot>
        </table>
        </div>
    </div>
</div>
<div id="proposal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Proposal</h4>
      </div>
      <div class="modal-body">
        <p class="prpopsal_p">Some text in the modal.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<script>
     $(function () {
				$('#dataTable1').DataTable();				
			  });	
</script>
<script>
    $('.showproposal').click(function () {
        var prop = $(this).data('id');
        $("#prpopsal_p").html( prop );       
   });
    $(".showproposal").click(function(){
        var prop = $(this).data('id');
        $(".prpopsal_p").html( prop );        
    });
</script>