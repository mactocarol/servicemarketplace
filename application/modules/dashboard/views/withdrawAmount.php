<?php $this->load->view('header');?>
    <!-- breadcrumb Start -->
<section class="breadcrumb_outer">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h2 class="text-capitalize">Withdraw Amount</h2>
            </div>
            <div class="col-lg-6">
                <ol class="breadcrumb pull-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Withdraw Amount</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<!-- breadcrumb End -->
<section class="login_outer">
    
    <div class="container">
        <div class="col-md-6 col-md-offset-3">
            <?php
            print_r($messages);
            // display error & success messages
            if(isset($message)) {                   
                if($success){
                ?>
                  <div class="alert alert-dismissible alert-success">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Success!</strong> <?php print_r($message); ?>
                  </div>                        
                <?php
                }else{
                ?>
                    <div class="alert alert-dismissible alert-danger">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Error!</strong> <?php print_r($message); ?>
                    </div>                      
                <?php
                }
            }
            ?>
            <div class="login-inner">
                <div class="login-header">
                    <h1>Withdraw Request</h1></div>
                <div class="login-form">
                    <form method="post" action="<?php echo site_url('dashboard/withdrawAmount');?>">
                        
                        <div class="form-group">
                            <input type="text" name="amount" placeholder="Withdraw Amount" class="number form-control" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6"></div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-secondry pull-right">Send Withdraw Request</button>
                            </div>
                        </div>
                        
                    </form>
                </div>
                
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
                  <span>My Listing</span>
                  <!--<a href="#" type="button" class="btn btn-calender"><i class="fa fa-calendar" aria-hidden="true"></i>
                  Calender view</a>-->
                </div>
                <div class="table_section">
                    <table class="table table-customize">
                        <thead>
                            <tr>
                                <th>Request No.</th>
                                <th>Ammount</th>
                                <th>Request Date</th>
                                <th>Request Time</th>
                                <th>Request Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; foreach($withdrawAmount as $oneRow){ ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $oneRow['amount']; ?></td>
                                <td><?=($oneRow['crd'])?date('d M, Y',strtotime($oneRow['crd'])):''?></td>
                                <td><?=($oneRow['crd'])?date('h:i a',strtotime($oneRow['crd'])):''?></td>

                                <td>
                                    <?php if($oneRow['status'] == 1){?>
                                    <a href="javascript:void(0);" type="button" class="btn btn_pending">Pending</a>
                                    <?php } ?>
                                    <?php if($oneRow['status'] == 2){?>
                                    <a href="javascript:void(0);" type="button" class="btn btn_accepted">Accepted</a>
                                    <?php } ?>
                                    <?php if($oneRow['status'] == 3){?>
                                    <a href="javascript:void(0);" type="button" class="btn btn_cancel">Cancle</a>
                                    <?php } ?>
                                    <?php if($oneRow['status'] == 4){?>
                                    <a href="javascript:void(0);" type="button" class="btn btn_cancel">Cancle</a>
                                    <?php } ?>
                                </td>

                                <td>
                                    <?php if($oneRow['status'] == 1){?>
                                    <a href="javascript:void(0);" onclick="cancleReq(<?php echo $oneRow['withdrawId']; ?>);" type="button" class="btn btn_view"> Cancle</a>
                                    <?php } ?>
                                    <?php if($oneRow['status'] == 2){?>
                                    <a href="javascript:void(0);" type="button" class="btn btn_view"> Paid</a>
                                    <?php } ?>
                                    <?php if($oneRow['status'] == 3){?>
                                    <a href="javascript:void(0);" type="button" class="btn btn_view"> By You</a>
                                    <?php } ?>
                                    <?php if($oneRow['status'] == 4){?>
                                    <a href="javascript:void(0);" type="button" class="btn btn_view"> By Admin</a>
                                    <?php } ?>
                                </td>

                            </tr>
                            <?php $i++; } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
     </div>
    </div>
</section>



<?php $this->load->view('footer');?> 

<script type="text/javascript">

    function cancleReq(withdrawId){
        alert(withdrawId);

        $.ajax('<?php echo base_url('dashboard/cancleWithdraw'); ?>', {
            type: 'POST',  
            data: {
                withdrawId:withdrawId
            },  
            success: function (data) {
                location.reload();
                console.log(data);
            },
        });

    }

    $('.number').keypress(function(event) {
        var $this = $(this);
        if ((event.which != 46 || $this.val().indexOf('.') != -1) &&
           ((event.which < 48 || event.which > 57) &&
           (event.which != 0 && event.which != 8))) {
               event.preventDefault();
        }

        var text = $(this).val();
        if ((event.which == 46) && (text.indexOf('.') == -1)) {
            setTimeout(function() {
                if ($this.val().substring($this.val().indexOf('.')).length > 3) {
                    $this.val($this.val().substring(0, $this.val().indexOf('.') + 3));
                }
            }, 1);
        }

        if ((text.indexOf('.') != -1) &&
            (text.substring(text.indexOf('.')).length > 2) &&
            (event.which != 0 && event.which != 8) &&
            ($(this)[0].selectionStart >= text.length - 2)) {
                event.preventDefault();
        }    
    });

    $('.number').bind("paste", function(e) {
        var text = e.originalEvent.clipboardData.getData('Text');
        if ($.isNumeric(text)) {
            if ((text.substring(text.indexOf('.')).length > 3) && (text.indexOf('.') > -1)) {
                e.preventDefault();
                $(this).val(text.substring(0, text.indexOf('.') + 3));
           }
        }else{
            e.preventDefault();
        }
    });
</script>  