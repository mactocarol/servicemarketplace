<?php $this->load->view('header'); ?>
       
        <!-- breadcrumb Start -->
    <section class="breadcrumb_outer breadcrumb_outer_new">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h4 class="text-capitalize">Payment</h4>
                </div>
                <div class="col-lg-6">
                     <ol class="breadcrumb pull-right">
                        <li class="breadcrumb-item"><a href="<?=site_url();?>">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">payment</li>
                      </ol>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb End -->
    
    <div class="service_checkout">
        <div class="container"> 
            <div class="row">
                <div class="col-md-12">
                    <!-- list wrap end -->
                    <div class="service_check_list">
                        <div class="service_list servicename">
                            <div class="s_list">
                              <span class="s_label">Service Name</span>
                              <span class="s_text">
                                <?php echo ($this->session->userdata('services')) ? $this->session->userdata('services')->title : ''; ?>
                              </span>
                            </div>
                        </div>
                        <?php //echo "<pre>"; print_r($_SESSION);  ?>
                        <div class="service_list service">
                        <?php $service = ($this->session->userdata('service_cart')) ? $this->session->userdata('service_cart') : $this->session->userdata('service_cart1'); ?>
                        <?php if($this->session->userdata('service_cart')){
                                foreach($this->session->userdata('service_cart') as $key => $value){ //print_r($value); ?>
                                    <?php if(is_array($value)){ ?>
                                    <div class="s_list">
                                      <span class="s_label"><?=$key?></span>

                                        <?php foreach($value as $one){ ?>
                                            <span class="s_text"><?=$one?></span>
                                        <?php  } ?>
                                    </div>
                        <?php } } } ?>
                        
                        <?php
                        if($this->session->userdata('service_cart1')){
                        foreach($this->session->userdata('service_cart1') as $key=>$value){            
                            if($value['list'] != '_'){
                                if(!in_array($value['list'],$listt)){
                                    $listt[] = $value['list'];
                                    echo '<div class="s_list"><h4>'.implode(' ',explode('_',$value['list'])).'</h4></div>';
                                }            
                            }
                            
                            foreach($value as $keyy=>$row){
                                if($keyy != 'list'){
                                    if($keyy == 'label'){                        
                                        echo '<div class="s_list"><span class="s_label">'.ucwords(implode(' ',explode('_',$value['keylabel']))).'</span><span class="s_text">'.$row.'</span></div>';
                                    }
                                    if($keyy == 'select'){                        
                                        echo '<div class="s_list"><span class="s_label">'.ucwords(implode(' ',explode('_',$value['keyselect']))).'</span><span class="s_text">'.$row.'</span></div>';
                                    }
                                    if($keyy == 'qty'){                        
                                        echo '<div class="s_list"><span class="s_label">'.ucwords(implode(' ',explode('_',$value['keyqty']))).'</span><span class="s_text"> '.$row.'</span></div>';
                                    }
                                }                
                            }
                        }
                        }
                        ?>

                        </div>
                        <div class="service_list location">
                            <div class="s_list">
                               <span class="s_label">Location</span>
                               <span class="s_text">
                                 <?php echo ($this->session->userdata('location_cart')) ? ($this->session->userdata('location_cart')['location']) : '--'; ?>
                               </span>
                            </div>
                        <div class="s_list">
                          <span class="s_label">Landmark</span>
                          <span class="s_text"> <?php echo ($this->session->userdata('location_cart')) ? ($this->session->userdata('location_cart')['landmark']) : '--'; ?></span>
                        </div>
                        </div>
                        
                        <?php if($schedule = $this->session->userdata('payment_method')) {?>

                            <?php 
                            //print_r($this->session->userdata('schedule_cart'));
                            $payment_type = $this->session->userdata('payment_method')['payment_type'];
                            $endDate = $startData = strtotime($this->session->userdata('schedule_cart')['dateslots']);//strtotime($this->session->userdata('payment_method')['date']);
                            $time = $this->session->userdata('schedule_cart')['timeslots'];//strtotime($this->session->userdata('payment_method')['time']);
                            if($payment_type == 'week'){
                                $endDate = strtotime("+7 day", $startData);
                                $frequency = 'Every Week On '.date('D', $startData);
                            }else if($payment_type == 'month'){
                                $endDate = strtotime("+1 months", $startData);
                                $frequency = 'Every Month On '.date('d', $startData).' date of month';
                            }else if($payment_type == 'year'){
                                $endDate = strtotime("+1 years", $startData);
                                $frequency = 'Every Year On '.date('d M', $startData);
                            }
                            ?>

                        <?php if($this->session->userdata('schedule_cart') != 1){?>
                        <div class="service_list schedule">
                            <div class="s_list">
                              <span class="s_label">Schedule Time</span>
                              <span class="s_text"><?php echo ($schedule) ? $time : '--'; ?></span>
                            </div>        
                        </div>

                        <div class="service_list schedule">
                            <div class="s_list">
                                <?php if($payment_type == 'day'){ ?>
                                    <span class="s_label">Date</span>
                                    <span class="s_text"><?php echo ($schedule) ? date('Y-m-d', $startData) : '--'; ?></span>
                                <?php }else{ ?>
                                    <span class="s_label">Schedule Date</span>
                                    <span class="s_text"><?php echo ($frequency) ? $frequency : '--'; ?></span>
                                <?php } ?>
                            </div>        
                        </div>
                        <?php } ?>
                        <?php } ?>
                        <div class="service_list provider">
                            <div class="s_list">
                              <span class="s_label">Provider</span>
                              <span class="s_text"><?php echo ($vendor->shop_name) ? $vendor->shop_name : ($vendor->f_name.' '.$vendor->l_name); ?></span>
                            </div>
                            <div class="s_list">
                              <span class="s_label">Charge</span>
                              <?php if($payment_type == 'day'){
                                $price = $vendor_services_price[0]['price'];
                              } else if($payment_type == 'week') {
                                $price = $vendor_services_price[0]['weekPrice'];
                              } else if($payment_type == 'month') {
                                $price = $vendor_services_price[0]['monthPrice'];
                              } else if($payment_type == 'year') {
                                $price = $vendor_services_price[0]['yearPrice'];
                              }?>
                              <span class="s_text"><?php echo ($vendor_services_price) ? ($price).' AED' : '--'; ?></span>
                            </div>
                        </div>
                        <div class="service_list Billing">
                            <?php $billing = ($this->session->userdata('billing_cart')) ? $this->session->userdata('billing_cart') : ''; ?>
                            <?php // print_r($_SESSION); ?>
                            <?php if(!empty($billing)){ foreach($billing as $key => $value){ ?>
                                <span class="bl_text"><?=$key?></span>
                                <span class="s_text"><?=$value?></span>
                            <?php } }  ?>
                            <?php ?>
                        </div>
                    </div>
                    <!-- list wrap end -->
                    <div class="check_pay_btn">
                        <!-- <form method="post" action="<?php echo site_url('payment');?>">
                        <input type="hidden" name="payment_method" value="paypal">
                        <button class="ck_payment_btns">Pay</button>
                        </form> -->

                        
                        <?php if($this->session->userdata('payment_method')['payment_method'] != 'paypal'){ ?>
                            <form method="post" action="<?php echo site_url('payment');?>">
                                <input type="hidden" name="payment_method" value="cashOnDelivery">
                                <button class="btn btn-primary">Pay After work</button>
                            </form>
                        <?php }else{ ?>
                            <form method="post" action="<?php echo site_url('payment');?>">
                                <input type="hidden" name="payment_method" value="stripe">
                                <button class="btn btn-primary">Pay After accept request</button>
                            </form>
                        <?php } ?>



                    </div>
                </div>
            </div>
        </div>        
    </div>    
    

<?php $this->load->view('footer'); ?>