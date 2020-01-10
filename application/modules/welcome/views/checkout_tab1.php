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
                                            <span><i class="fab fa-cc-paypal"></i>Paypal</span>
                                            <p>Your payment will transferred to vendor once you satisfied.</p>
                                        </div>
                                    </label>
                                </div>
                            </div>                                                                                                        
                        </div>
                                                
                    </div>
                    
                    <!--<p><input type="checkbox" name="shipping"> Shipping Address Same as Billing Address</p>-->
                    <button class="btn btn-primary" type="submit">Continue</button>
                	</div>
<input type="hidden" id="next_tab" value="finished">
</form>
</div>
<div id="loader" style="display:none;"><img src="https://media.theaustralian.com.au/fe/sop/wait.gif"></div>
                    