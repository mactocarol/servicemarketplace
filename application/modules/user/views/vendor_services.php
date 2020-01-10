<?php $this->load->view('header');?>
<section class="breadcrumb_outer">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h2 class="text-capitalize">My Service Listing</h2>
            </div>
            <div class="col-lg-6">
                 <ol class="breadcrumb pull-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">My Service Listing</li>
                  </ol>
            </div>
        </div>
    </div>
</section>  


<section class="body_content">
    <div class="container">
      <div class="row">
        <div class="col-md-12 ">
        <div class="custom_table">
               <div class="table_header">
                  <span>My Service Listing</span>
                  <!-- <a href="user/add_vendor_services" type="button" class="btn btn-calender red_button"><i class="fa fa-calendar" aria-hidden="true"></i>
                  Update Service</a> -->

                  <a href="user/add_vendor_services">
                  <button style="float: right;" type="button" name="" onclick="submit_form();" class="red_button submit_btn">Update Service</button></a>

                </div>
                <div class="alert alert-dismissible alert-danger">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Note: </strong> Your services will be visible only if you enter price for each.
                </div>                
                <div class="table_section">
                    <table class="table table-customize">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>image</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>One Price</th>
                                <th>Week Price</th>
                                <th>Month Price</th>
                                <th>Year Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            <?php $i=1; foreach($servicesArr as $oneRow){ ?>
                            <?php if($oneRow->level != 0){ //echo "<pre>"; print_r($oneRow); ?>
                            <tr>
                                <td><?php echo $i; ?></td>                                
                                <?php if($oneRow->image == "default-category.png"){ ?>
                                <td><img src="https://dummyimage.com/400x250/aaaaaa/ffffff?text=<?php echo $oneRow->title; ?>" width="100"></td>
                                <?php }else{ ?>
                                <td><img src="<?php echo base_url('upload/category/').$oneRow->image; ?>" width="100"></td>
                                <?php } ?>
                                <td><?php echo $oneRow->title; ?></td>
                                <td><?php echo $oneRow->description; ?></td>
                                <td><?php echo !empty($oneRow->price) ? $oneRow->price : 'NA'; ?></td>
                                <td><?php echo !empty($oneRow->weekPrice) ? $oneRow->weekPrice : 'NA'; ?></td>
                                <td><?php echo !empty($oneRow->monthPrice) ? $oneRow->monthPrice : 'NA'; ?></td>
                                <td><?php echo !empty($oneRow->yearPrice) ? $oneRow->yearPrice : 'NA'; ?></td>
                                <td>
                                    <a href="<?php echo base_url('user/updatePrice/').base64_encode($oneRow->id); ?>" onclickk="showPopUp('<?php echo $oneRow->id; ?>','<?php echo $oneRow->price; ?>');" href="javascript:void(0)" type="button" class="btn btn_view">
                                       
                                        <?php echo !empty($oneRow->price) ? 'Update' : 'Update'; ?>
                                    </a>
                                </td>
                            </tr>
                            <?php $i++; } ?>
                            <?php } ?>
                         
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
     </div>
    </div>
</section>
 <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript">
    function  showPopUp(id,price) {
        swal("Write something here:", {
        content: {
            element: "input",
            attributes: {
                value: price
            }
        }
        })
        .then((value) => {
            
            if(value != null){
                if(value != ''){
                    if(parseFloat(value) != 0){
                        $.ajax({
                            url: "<?php echo base_url(); ?>user/add_price",
                            type: 'POST',
                            data:{
                                'id':id,
                                'price':parseFloat(value),
                            },
                            success: function(result){
                                //alert(result);
                                location.reload();
                            }
                        });
                    }
                }
            }
        });
    }
</script>
<?php $this->load->view('footer');?> 