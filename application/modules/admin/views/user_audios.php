<div class="container">
    <h4><b><?php echo $userid."'s  Uploaded Audios";?></b></h4>
    <hr>
    <div class="row">
        
        <div class="col-md-12">
        <table class="table table-bordered" id="dataTable2" width="100%" cellspacing="0">
            <thead>
            <tr>
              <th width="10%">Sr. No.</th>                        
              <th width="15%">Title</th>
              <th width="10%">Genre</th>
              <th>Product</th>              
              <th style="width:5px">Action</th>                    
            </tr>
            </thead>
            <tbody>
                  <?php if(isset($products) && !empty($products)) {
                        $count = 0;                              
                        foreach($products as $row){ ?>
                    <tr>
                        <td><?= ++$count; ?></td>
                        <td>
                            <?php echo isset($row['title']) ? $row['title'] : ''; ?>                                    
                        </td>                                                     
                        <td>
                            <?php echo isset($row['name']) ? $row['name'] : '';   ?>
                        </td>
                        
                        <td>
                            <img src="<?php echo base_url('upload/products/audio_thumb/'.$row['thumb']);?>" width="100">
                            <audio controls controlsList="">
                                <source src="<?php echo base_url('upload/products/'.$row['file']); ?>" type="audio/ogg">
                                <source src="<?php echo base_url('upload/products/'.$row['file']); ?>" type="audio/mpeg">
                             Your browser does not support the audio element.
                            </audio>
                        </td>
                        <td>
                            <a href="<?php echo base_url(); ?>admin/edit_products/<?php echo $row['id'];?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                            <a href="<?php echo base_url(); ?>admin/delete_product/<?php echo $row['id'];?>" onclick=" var c = confirm('Are you sure want to delete?'); if(!c) return false;"><i class="fa fa-close" aria-hidden="true"></i></a>&nbsp;&nbsp;                                    
                        </td>                                
                    </tr>                          
            <?php  } } else { echo "<tr><td colspan='5'>No Results</td></tr>"; }?>                      
                                               
            </tfoot>
        </table>
        </div>
    </div>
</div>
<script>
     $(function () {
				$('#dataTable2').DataTable();				
			  });
</script>