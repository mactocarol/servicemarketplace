<?php $this->load->view('header');?>
    <!-- breadcrumb Start -->
<section class="breadcrumb_outer">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h2 class="text-capitalize">Login</h2>
            </div>
            <div class="col-lg-6">
                <ol class="breadcrumb pull-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Login</li>
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
                    <h1><i class="fa fa-gift"></i>Create New Promo Code</h1></div>
                <div class="login-form">
                    <form id="addPromoCode" method="post" action="<?php echo site_url('dashboard/addPromo');?>">
                        
                        <div class="form-group">
                            <input type="text" name="promoName" id="promoName" placeholder="Promo code Name" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <input type="text" id="promoCode" name="promoCode" placeholder="Promo code" class="form-control" maxlength="6" style="text-transform:uppercase" required>
                        </div>

                        <div class="form-group">
                        <a href="javascript:void(0)" onclick="generate();" type="button" class="btn_view">Generate Promo code</a>
                        </div>

                        <div class="form-group">
                            <input type="text" id="discountPresent" onkeyup="checkPresent();"  name="discountPresent" placeholder="Discount Present" class="number form-control" required>
                        </div>

                        <div class="form-group">
                            <input id="datepicker1" type="text" name="startDate" placeholder="Start Date" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <input id="datepicker2" type="text" name="endDate" placeholder="End Date" class="form-control" required>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6"><a href="javascript:void(0);" class="forget-link"></a></div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-secondry pull-right">Create</button>
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
                  <span>My Promo Listing</span>
                </div>
                <div class="table_section">
                    <table class="table table-customize">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Promo code Name</th>
                                <th>Promo Code</th>
                                <th>Discount Present</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $i = 1;foreach($promoCode as $onePromo){ ?>
                            <tr>     
                                <td><?php echo $i; ?></td>
                                <td><?php echo $onePromo['promoName']; ?></td>
                                <td><?php echo $onePromo['promoCode']; ?></td>
                                <td><?php echo $onePromo['discountPresent']; ?></td>
                                <td><?=($onePromo['startDate'])?date('d M, Y',strtotime($onePromo['startDate'])):''?></td>
                                <td><?=($onePromo['endDate'])?date('d M, Y',strtotime($onePromo['endDate'])):''?></td>
                                <td>
                                <a href="<?php echo base_url('dashboard/deletePromo/').base64_encode($onePromo['promoId']); ?>" href="javascript:void(0)" type="button" class="btn btn_view">Delete</a>
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
    function generate(){
        $('#promoCode').val(Math.random().toString(36).substring(2,8).toUpperCase());
    }

    var dates = $('#datepicker2 , #datepicker1').datepicker({
        minDate:'+0',
        defaultDate: '+1',                    
    });
    //$('#datepicker2 , #datepicker1').datepicker('setDate', '+0');

    function checkPresent(){
        var discountPresent = $('#discountPresent').val();
        if(discountPresent > 100){
            $('#discountPresent').val(Number(localStorage.num))
        }else{
            localStorage.num = discountPresent;
        }
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

<!-- validation start -->
<script src="<?php echo base_url('front/js');?>/bootstrapValidator.min.js"></script>
<script>
    $(document).ready(function()
    {
        //alert('http://localhost/caroldata.com/hmvc_hotel_booking/registration/register_email_exists');
        $('#addPromoCode').bootstrapValidator({
            //container: '#messages',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                promoName: {
                    validators: {
                        notEmpty: {
                            message: 'The Promo Name is required'
                        },
                    }
                },
                promoCode: {
                    validators: {
                        notEmpty: {
                            message: 'The Promo Code is required'
                        },
                    }
                },
                
                discountPresent: {
                   validators: {
                       notEmpty: {
                           message: 'The Discount Present is required'
                       },
                   }
                },
                datepicker1: {
                    validators: {
                        notEmpty: {
                            message: 'The Start Date is required'
                        },
                    }
                },
                  datepicker2: {
                    validators: {
                        notEmpty: {
                            message: 'The End Date is required'
                        },
                    }
                },                   
            }
        });
    });    
</script>
<!-- validation end -->