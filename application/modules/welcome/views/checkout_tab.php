<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<div class="servicebox">
    <form method="post" id="" action="<?php echo site_url('welcome/checkout');?>">
        <div class="checkout_panel">
            <div class="row">
                
                <div class="col-md-12">
                    <h1>Payment Method</h1>
                    <div class="form-group">
                        <div class="radio_box">

                            <label>
                                <input type="radio" class="form-control" name="payment_method" value="cash" checked>
                                <span class="r_check"></span>
                                <div class="r_texts">
                                    <span><i class="fas fa-money-bill-alt"></i> Cash </span>
                                    <p>You pay after service completion</p>
                                </div>
                            </label>

                            <label>
                                <input type="radio" class="form-control" name="payment_method" value="paypal">
                                <span class="r_check"></span>
                                <div class="r_texts">
                                    <span><i class="fab fa-cc-paypal"></i> credit / debit Card </span>
                                    <p>Your payment will transferred to vendor once you satisfied.</p>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <h1>Service Type</h1>
                    <div class="form-group">
                        <div class="radio_box">

                            <?php
                            
                            $checked = 0;

                            $priceChecked = '';
                            $weekPriceChecked = '';
                            $monthPriceChecked = '';
                            $yearPriceChecked = '';
                            
                            if(!empty($vendors[0]['price'])){
                                if($checked == 0){
                                    $checked = 1;
                                    $priceChecked = 'checked';
                                }
                            }

                            if(!empty($vendors[0]['weekPrice'])){
                                if($checked == 0){
                                    $checked = 1;
                                    $weekPriceChecked = 'checked';
                                }
                            }

                            if(!empty($vendors[0]['monthPrice'])){
                                if($checked == 0){
                                    $checked = 1;
                                    $monthPriceChecked = 'checked';
                                }
                            }

                            if(!empty($vendors[0]['yearPrice'])){
                                if($checked == 0){
                                    $checked = 1;
                                    $yearPriceChecked = 'checked';
                                }
                            }
                            ?>
                            <?php  if(!empty($vendors[0]['price'])){ ?>
                            <label>
                                <input onclick="changeStatus()" type="radio" class="form-control" name="payment_type" value="day" <?php echo $priceChecked; ?> >
                                <span class="r_check"></span>
                                <div class="r_texts">
                                    <span> One Time </span>
                                </div>
                            </label>
                            <?php } ?>

                            
                            <?php  if(!empty($vendors[0]['weekPrice'])){ ?>
                            <label>
                                <input onclick="changeStatus()" type="radio" class="form-control" name="payment_type" value="week" <?php echo $weekPriceChecked; ?>>
                                <span class="r_check"></span>
                                <div class="r_texts">
                                    <span> Every Week (<?php echo ($this->session->userdata('schedule_cart') != 1) ? 'On '.date('D',strtotime($this->session->userdata('schedule_cart')['dateslots'])).' @'.$this->session->userdata('schedule_cart')['timeslots'] : 'Once in a week';?>)</span>
                                </div>
                            </label>
                            <?php } ?>


                            
                            <?php  if(!empty($vendors[0]['monthPrice'])){ ?>
                            <label>
                                <input onclick="changeStatus()" type="radio" class="form-control" name="payment_type" value="month" <?php echo $monthPriceChecked; ?>>
                                <span class="r_check"></span>
                                <div class="r_texts">
                                    <span> Every Month (<?php echo ($this->session->userdata('schedule_cart') != 1) ? 'On '.date('d',strtotime($this->session->userdata('schedule_cart')['dateslots'])).' date @'.$this->session->userdata('schedule_cart')['timeslots'] : 'Once in a month';?>)</span>
                                </div>
                            </label>
                            <?php } ?>


                            <?php  if(!empty($vendors[0]['yearPrice'])){ ?>
                            <label>
                                <input onclick="changeStatus()" type="radio" class="form-control" name="payment_type" value="year" <?php echo $yearPriceChecked; ?>>
                                <span class="r_check"></span>
                                <div class="r_texts">
                                    <span> Every Year (<?php echo ($this->session->userdata('schedule_cart') != 1) ? 'On '.date('d M',strtotime($this->session->userdata('schedule_cart')['dateslots'])).' @'.$this->session->userdata('schedule_cart')['timeslots'] : 'Once in a year';?>)</span>
                                </div>
                            </label>
                            <?php } ?>

                        </div>
                    </div>
                </div>

                <!--<div class="col-md-12">
                    <h1>Appointment / Start Date</h1>
                    <div class="form-group">
                        
                        <!-- <div class="radio_box oneDate">
                            <input placeholder="date" style="border : 1px solid #c5c5c5" id="datepicker1" type="text" class="form-control" name="Date">
                        </div><br><br> --

                        <div class="radio_box seDate">
                            <input placeholder="Appointment / Start Date" style="border : 1px solid #c5c5c5" id="datepicker2" type="text" class="form-control" name="date">
                        </div><br><br>

                        <div class="radio_box seDate">
                            <input placeholder="End Date" style="border : 1px solid #c5c5c5" id="timepicker" type="time" class="form-control" name="time" value='now'>
                        </div>

                    </div>
                </div>-->

                <!-- <?php  if(!empty($price)){ ?>
                    <script type="text/javascript">$('.seDate').hide();</script>
                <?php }else{ ?>
                    <script type="text/javascript">$('.oneDate').hide();</script>
                <?php } ?> -->

            </div>
            <!--<p><input type="checkbox" name="shipping"> Shipping Address Same as Billing Address</p>-->
            <button class="btn btn-primary" type="submit">Continue</button>
        </div>
        <input type="hidden" id="next_tab" value="finished">
    </form>
</div>

<div id="loader" style="display:none;"><img src="https://media.theaustralian.com.au/fe/sop/wait.gif"></div>

<script>
    $(function() {
        $("#datepicker1").datepicker();
        $("#datepicker3").datepicker();

        var dates = $('#datepicker2').datepicker({
            minDate:'+0',
            defaultDate: '+1',                    
        });
        $('#datepicker2').datepicker('setDate', '+0');
    });



    $(function(){     
        var d = new Date(),        
        h = d.getHours(),
        m = d.getMinutes();
        if(h < 10) h = '0' + h; 
        if(m < 10) m = '0' + m; 
        $('input[type="time"][value="now"]').each(function(){ 
            $(this).attr({'value': h + ':' + m});
        });
    });

    function changeStatus(){
        /*var payment_type = $("input[name='payment_type']:checked").val();
        if(payment_type == 'day'){
            $('.seDate').hide();
            $('.oneDate').show();
        }else{
            $('.oneDate').hide();
            $('.seDate').show();
        }*/
    }

</script>