<?php $this->load->view('header');?>
    <!-- breadcrumb Start -->
<section class="breadcrumb_outer">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h2 class="text-capitalize">Add Bank</h2>
            </div>
            <div class="col-lg-6">
                <ol class="breadcrumb pull-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add Bank</li>
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
                    <h1>Bank Detail</h1></div>
                <div class="login-form">
                    <form id="bankDetail" method="post" action="<?php echo site_url('dashboard/addBank');?>">                     
                        
                        <div class="form-group">
                            <input type="text" value="<?=($checkData) ? $checkData->firstName : ''?>" name="firstName" id="firstName" placeholder="First Name" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <input type="text" value="<?php echo ($checkData) ? $checkData->lastName : ''; ?>" name="lastName" id="lastName" placeholder="Last Name" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <input type="text" name="accountNumber" id="accountNumber" placeholder="Account Number" class="number form-control" required value="<?=base64_decode(($checkData) ? $checkData->accountNumber :'')?>">
                        </div>

                        <div class="form-group">
                            <input type="text" name="routingNumber" id="routingNumber" placeholder="routingNumber" class="number form-control" required value="<?=base64_decode(($checkData) ? $checkData->routingNumber : '')?>">
                        </div>

                        <div class="form-group">
                            <input type="text" name="ssnLast" id="ssnLast" placeholder="SSN Last" class="number form-control" required value="<?=base64_decode(($checkData) ? $checkData->ssnLast : '')?>">
                        </div>

                        <div class="form-group">
                            <input type="text" name="postalCode" id="postalCode" placeholder="Postal Code" class="number form-control" required value="<?=base64_decode(($checkData) ? $checkData->postalCode : '')?>">
                        </div>                        
                        
                        <div class="row">
                            <div class="col-md-6"></div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-secondry pull-right">Add Bank</button>
                            </div>
                        </div>                        
                    </form>
                </div>                
            </div>
        </div>
    </div>
</section>

<?php $this->load->view('footer');?> 

<script type="text/javascript">
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
        $('#bankDetail').bootstrapValidator({
            //container: '#messages',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                firstName: {
                    validators: {
                        notEmpty: {
                            message: 'The First Name is required'
                        },
                    }
                },
                lastName: {
                    validators: {
                        notEmpty: {
                            message: 'The Last Name is required'
                        },
                    }
                },
                
                accountNumber: {
                   validators: {
                       notEmpty: {
                           message: 'The Account Number is required'
                       },
                   }
                },
                routingNumber: {
                    validators: {
                        notEmpty: {
                            message: 'The Routing Number is required'
                        },
                    }
                },
                  postalCode: {
                    validators: {
                        notEmpty: {
                            message: 'The Postal Code is required'
                        },
                    }
                },
                ssnLast: {
                    validators: {
                        notEmpty: {
                            message : 'The SSN Last is required'
                        },                    
                    },
                },            
            }
        });
    });    
</script>
<!-- validation end -->