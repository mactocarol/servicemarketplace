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
                        <?php //print_r($this->session->userdata('service_cart1'));?>
                        <div class="service_list service">
                        <?php $service = ($this->session->userdata('service_cart')) ? $this->session->userdata('service_cart') : $this->session->userdata('service_cart1'); ?>
                        <?php if($this->session->userdata('service_cart')){
                                foreach($this->session->userdata('service_cart') as $key => $value){ ?>
                                <?php if($value && substr($key,0, 12) != 'selectvalues'){ ?>
                                    <div class="s_list">
                                      <span class="s_label"><?=$key?></span>
                                      <span class="s_text"><?php print_r(implode(',',$value));?></span>
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
                                 <?php //echo ($this->session->userdata('location_cart')) ? ($this->session->userdata('location_cart')['location']) : '--'; ?>
                                 <?php foreach($this->session->userdata('location_cart') as $key=>$value){?>
                                        <?php echo '<strong>'.$key.': </strong>'.$value;?>
                                 <?php } ?>
                               </span>
                            </div>
                        <!--<div class="s_list">
                          <span class="s_label">City</span>
                          <span class="s_text"> <?php echo ($this->session->userdata('location_cart')) ? ($this->session->userdata('location_cart')['city']) : '--'; ?></span>
                        </div>-->
                        </div>
                        
                        <?php if($schedule = $this->session->userdata('schedule_cart')) {?>
                        <div class="service_list schedule">
                            <div class="s_list">
                              <span class="s_label">Schedule Time</span>
                              <span class="s_text"><?php echo ($schedule) ? $schedule['dateslots'].' '.$schedule['timeslots'] : '--'; ?></span>
                            </div>        
                        </div>
                        <?php } ?>
                        <div class="service_list provider">
                            <div class="s_list">
                              <span class="s_label">Provider</span>
                              <span class="s_text"><?php echo ($vendor) ? ($vendor->f_name.' '.$vendor->l_name) : '--'; ?></span>
                            </div>
                            <div class="s_list">
                              <span class="s_label">Charge</span>
                              <span class="s_text"><?php echo ($vendor_services) ? ($vendor_services->charges).' AED' : '--'; ?></span>
                            </div>
                        </div>
                        <div class="service_list Billing">
                            <?php $payment_method = ($this->session->userdata('payment_method')) ? $this->session->userdata('payment_method') : ''; ?>
                            <?php // print_r($_SESSION); ?>
                            <?php if(!empty($payment_method)){ foreach($payment_method as $key => $value){ ?>
                                <div class="s_list">
                                    <span class="s_label">Payment Method</span>
                                    <span class="s_text"><?php echo ($value) ? ($value) : '--'; ?></span>
                                  </div>                                                                
                            <?php } }  ?>
                            <?php ?>
                        </div>
                    </div>
                    <!-- list wrap end -->
                    <div class="check_pay_btn">
                        <form method="post" action="<?php echo site_url('payment');?>">
                        <input type="hidden" name="payment_method" value="<?=$payment_method['payment_method']?>">
                        <button class="ck_payment_btns">Pay</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>        
    </div>    
    
 

<?php $this->load->view('footer'); ?>