<?php $this->load->view('header');?>
    
<section class="breadcrumb_outer">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h2 class="text-capitalize">Pay</h2>
            </div>
            <div class="col-lg-6">
                 <ol class="breadcrumb pull-right">
                    <li class="breadcrumb-item"><a href="<?php echo site_url('user/dashboard'); ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo site_url('user/orderDetail/'.$this->uri->segment('3')); ?>">Order Detail</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Payment</li>
                  </ol>
            </div>
        </div>
    </div>
</section>
<section class="login_outer">
    <div class="container">
        <div class=" col-md-8 col-md-offset-2">
            
            <?php
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
                <div class="login-header"><h1><i class="fa fa-lock"></i> Stripe Payment</h1></div>
                <div class="login-form">
                    <form method="post" id="registerform" action="<?php echo site_url('stripe_pay');?>">
                        
                        <div class="form-group">
                            <input value="aish sing" type="text" placeholder="Card Holder Name" name="cardHolderName" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <input value="4242424242424242" type="text" placeholder="Card Number xxxx xxxx xxxx xxxx" name="cardNumber" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <input value="12" type="text" placeholder="Card Exp. Month , ex : 12" name="cardExpMonth" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <input value="21" type="text" placeholder="Card Exp. Year , ex : 21" name="cardExpYear" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <input value="123" type="text" placeholder="CVV , ex : 123" name="cardCvv" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <input value="<?php echo $amount; ?>" type="hidden" placeholder="price ex : 10" name="price" class="form-control" readonly="">
                        </div>

                        <div class="form-group">
                            <input value="<?php echo $id; ?>" type="hidden" placeholder="id" name="requestId" class="form-control" readonly="">
                        </div>

                        <div class="form-group">
                            <input style="text-transform:uppercase" id="promo" type="hiddenn" placeholder="Promo Code" name="promoCode" class="form-control" autocomplete="off">
                            <p id="promoMsg" ></p>
                        </div>
                        
                        
                        <div class="row">
                            
                            <div  class="col-md-12"><button id="buttonId" type="submit" class="btn btn-primary pull-right">PAY- AED <?php echo $amount; ?></button></div>
                        </div>
 

                        
                    </form>
                </div>
                
                
            </div>
        </div>
    </div>
</section>

<?php $this->load->view('footer'); ?>

<script type="text/javascript">

    var  amount = '<?php echo $amount; ?>';

    $('#promo').keyup(function() {
        $('#promoMsg').html('');
        var promo = $(this).val();
        $('#buttonId').html('PAY- AED '+ amount)
        if(promo.length > 5){
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('stripe_pay/checkPromo'); ?>",
                data: {
                    'promo' : promo,
                    'postId' : "<?php echo $id; ?>",
                },
                success: function(resultData){
                    if (resultData != '0') {
                        var resultData = JSON.parse(resultData);
                        
                        $('#promoMsg').html('Promo Code Match , Discount Present : '+resultData.discountPresent+'%');
                        $('#promoMsg').css("color", "green");

                        var discount = (amount / 100) * resultData.discountPresent;
                        $('#buttonId').html('PAY- AED '+ (amount-discount))

                    }else{
                        $('#promoMsg').html('Invalid Promo Code');
                        $('#promoMsg').css("color", "red");

                        $('#buttonId').html('PAY- AED '+ amount)
                    }
                    
                }
            });
        }
    })
</script>