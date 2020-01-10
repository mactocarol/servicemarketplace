<?php $this->load->view('header');?>
<section class="breadcrumb_outer">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h2 class="text-capitalize">Order Detail</h2>
            </div>
            <div class="col-lg-6">
                 <ol class="breadcrumb pull-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Order Detail</li>
                  </ol>
            </div>
        </div>
    </div>
</section>  
<section class="template2_outer">
  <div class="container">
      <div class="template2_in">
          <div class="row">
              <div class="col-md-8">
                  <div class="template2_left">
                  <h2><?=($order['servicename'])?json_decode($order['servicename']):''?></h2>
                    <div class="section_box">
                        <div class="section_content">
                            <!-- <?php if($order['payment_status'] == 2){ ?>    
                            <img src="<?php echo base_url('front');?>/images/right.png">
                            <span>Accepted</span>
                            <?php } else { ?>
                            <span>Pending</span>
                            <?php } ?>  -->

                            <?php if($order['order_status'] == 2){ ?>    
                              <img src="<?php echo base_url('front');?>/images/right.png">
                              <span>Accepted</span>
                            <?php }elseif($order['order_status'] == 1){ ?>
                              <span style="color: orange;">Pending</span>
                            <?php }else{ ?> 
                              <img height="25" width="25" src="https://2.bp.blogspot.com/-SCbOaY9CwqU/WsJPsDgZbWI/AAAAAAAABqU/NiSJaXtY1tEdDYcyBFU8LNFAxfCWQNmcgCLcBGAs/s1600/wrong.png">
                              <span style="color: red;">Cancle</span>  
                            <?php } ?>    


                        </div>
                        <div class="section_content">
                          <i class="far fa-calendar-alt"></i>
                          <span><?=date('d M Y h:i:s',strtotime($order['created_at']))?></span>
                        </div>
                        <div class="section_content">
                          <i class="fas fa-map-marker-alt"></i>
                          <span><?=($order['location'])?json_decode($order['location'])->location.', '.json_decode($order['location'])->city:'--'?></span>
                        </div>
                        <div class="section_content">     
                          <i class="fas fa-wallet"></i>
                          <span>AED <?=($order['amount'])? $order['amount'] : '' ;?>(<?=($order['payment_type'])? $order['payment_type'] : '' ;?>)</span>
                        </div>
                        <div class="section_content">
                          <i class="fa fa-cog" aria-hidden="true"></i>
                          <span>Order No : <?=($order['order_id'])?($order['order_id']):''?></span>
                        </div>
                        
                        <?php $schedule = json_decode($order['schedule']); ?>
                        
                        <?php if($schedule != '' && $schedule != '1'){?>
                        <div class="section_content">
                          <i class="fa fa-cog" aria-hidden="true"></i>
                          <span>Schedule Time : <?=($schedule)?($schedule->dateslots.' '.$schedule->timeslots):''?></span>
                        </div>
                        <?php } ?>
                    
                        <div class="section_content">
                        <h4>Services</h4>    
                            <p>
                            <?php $service = json_decode($order['services']); ?>                            
                            <?php foreach($service as $key => $value){ ?>
                                <?php if(isset($value->label)){
                                    //print_r($value);
                                    if($value->list != '_'){
                                        if(!in_array($value->list,$listt)){
                                            $listt[] = $value->list;
                                            echo '<p><h4>'.implode(' ',explode('_',$value->list)).'</h4></p>';
                                        }            
                                    }
                                    
                                    foreach($value as $keyy=>$row){
                                        if($keyy != 'list'){
                                            if($keyy == 'label'){                        
                                                echo '<strong>'.ucwords(implode(' ',explode('_',$value->keylabel))).'</strong> : '.$row.'<br>';
                                            }
                                            if($keyy == 'select'){                        
                                                echo '<strong>'.ucwords(implode(' ',explode('_',$value->keyselect))).'</strong> : '.$row.'</br>';
                                            }
                                            if($keyy == 'qty'){                        
                                                echo '<strong>'.ucwords(implode(' ',explode('_',$value->keyqty))).'</strong> : '.$row.'</br>';
                                            }
                                        }                
                                    }
                                }else{ ?>
                                <strong><?=$key?> : </strong><?=$value?><br>
                            <?php } }?>
                            <?php ?>
                            </p>
                        </div>
                        
                        <div class="section_content">
                        <h4>Billing Address</h4>    
                        <?php $billing = json_decode($order['billing']);
                        if(!empty($billing)){ ?>
                          <p>
                            <strong>Name : </strong><?=$billing->name?><br>
                            <strong>Email : </strong><?=$billing->email?><br>
                            <strong>Address : </strong><?=$billing->address?><br>
                            <strong>City : </strong><?=$billing->city?><br>
                            <strong>State : </strong><?=$billing->state?><br>
                            <strong>Zipcode : </strong><?=$billing->zipcode?><br>
                          </p>
                        <?php } else { ?>
                            <p>No Information Provided</p>
                        <?php } ?>
                        </div>
                        <!--<div class="Request_btn button">
                          <button class="btn btn_start"><i class="fa fa-play" aria-hidden="true"></i><span>Start</span></button>
                          <span class="btn_or">OR</span>
                          <button class="btn btn_stop"><i class="fa fa-times" aria-hidden="true"></i><span>Cancel</span></button>
                        </div>-->

                        <?php 
                        
                        if($order['order_status'] != '2'){
                        if($result->user_type == 2){
                        ?>
                          <div class="Request_btn button">
                            <button onclick="changeStatus('2')" class="btn btn_start"><i class="fa fa-play" aria-hidden="true"></i><span>Start</span></button>
                            
                            <?php if($order['order_status'] != 3){ ?>
                            <button onclick="changeStatus('3')" class="btn btn_stop"><i class="fa fa-times" aria-hidden="true"></i><span>Cancel</span></button>
                            <?php } ?>

                          </div>
                        <?php
                        }
                        }
                        ?>

                    </div>
                  </div>
                </div>
              <div class="col-md-4">
                <div class="customer_detail">
                  

                  <?php
                  /*echo '<pre>';
                  print_r($result);
                  print_r($order);
                  die();*/

                  if($result->user_type == 1){
                    $vendor = get_user($order['vendor_id']);
                    $text = 'Service Provider Detail';
                  }else{
                    $vendor = get_user($order['user_id']);
                    $text = 'Request User Detail';
                  }

                  ?>
                  <h3><?php echo $text; ?></h3>
                  
                  <div class="buyer_detail_box template2_inr">
                    <img width="200" height="200" onerror="$(this).attr('src','https://dummyimage.com/200x200/ffffff/e12454?text=<?=($vendor->f_name); ?>')"  src="<?php echo base_url('upload/profile_image/').$vendor->image; ?>">
                    <h2><?=($vendor->f_name).' '.($vendor->l_name)?></h2>
                    <span><?=($vendor->country).', '.($vendor->city)?></span>
                    <span><i class="fa fa-phone" aria-hidden="true"></i><?=($vendor->phone)?></span>
                    <span><i class="fa fa-envelope" aria-hidden="true"></i><?=($vendor->email)?></span>                  
                  </div>
                  <div class="map_section">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d6633805.364206802!2d-87.88941902534398!3d35.722215099780996!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1skingsland+!5e0!3m2!1sen!2sin!4v1555570498807!5m2!1sen!2sin" frameborder="0" style="border:0" allowfullscreen></iframe>
                  </div>
                </div>
              </div>

              </div>
            </div>
          </div>
</section>

<script type="text/javascript">
  function  changeStatus(status) {
    $.ajax({
      url: "<?php echo base_url('user/changeOrderStatus'); ?>",
      data : {
        status:status,
        id:"<?php echo $order['id']; ?>",
      },
      type:'POST',
      success: function(result){
        location.reload();
      }
    });
  }
</script>

<?php $this->load->view('footer');?> 