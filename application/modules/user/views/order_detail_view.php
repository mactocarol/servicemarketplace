<?php $this->load->view('header');?>
<section class="breadcrumb_outer">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h2 class="text-capitalize">Order Detail</h2>
            </div>
            <div class="col-lg-6">
                 <ol class="breadcrumb pull-right">
                    <li class="breadcrumb-item"><a href="<?php echo site_url('user/dashboard'); ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo site_url('user/dashboard'); ?>">Orders</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Order Detail</li>
                  </ol>
            </div>
        </div>
    </div>
</section>  
<section class="template2_outer">
  <div class="container">
      <div class="template2_in">

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


          <div class="row">
              <div class="col-md-8">
                  <div class="template2_left">
                  <h2><?=($order['servicename'])?json_decode($order['servicename']):''?></h2>
                    <div class="section_box">
                        <div class="section_content">
                            
                            <?php if($result->user_type == 1){ ?>
                                <?php if($order['order_status'] == 2 && $order['payment_status'] == 'pending'){ ?>                                  
                                  <div class="alert alert-dismissible alert-success">                                    
                                        <img src="<?php echo base_url('front');?>/images/right.png"> <strong>Accepted!</strong> Your Order has been accepted by Service Provider.
                                  </div>
                                <?php }else if($order['order_status'] == 2 && $order['payment_status'] != 'pending'){ ?>                                  
                                  <div class="alert alert-dismissible alert-success">                                    
                                        <img src="<?php echo base_url('front');?>/images/right.png"> <strong>Completed!</strong> Your Order has been completed by Service Provider.
                                  </div>
                                <?php }else if($order['order_status'] == 1){ ?>
                                  <div class="alert alert-dismissible alert-warning">                                    
                                        <strong>Pending!</strong> Confirming your Order with Service Provider.
                                  </div>                                
                                <?php }else{ ?>                               
                                  <div class="alert alert-dismissible alert-danger">                                    
                                        <img height="25" width="25" src="https://2.bp.blogspot.com/-SCbOaY9CwqU/WsJPsDgZbWI/AAAAAAAABqU/NiSJaXtY1tEdDYcyBFU8LNFAxfCWQNmcgCLcBGAs/s1600/wrong.png">
                                        <strong>Cancelled!</strong> Sorry, Service Provider is not available at this time, Please make another order with other service provider.
                                  </div> 
                                <?php } ?>
                            <?php } else { ?>
                                <?php if($order['order_status'] == 2 && $order['payment_status'] == 'pending'){ ?>                               
                                  <div class="alert alert-dismissible alert-success">                                    
                                        <img src="<?php echo base_url('front');?>/images/right.png"> <strong>Accepted!</strong> Your have accepted this order.
                                  </div>
                                <?php }else if($order['order_status'] == 2 && $order['payment_status'] != 'pending'){ ?>                                  
                                  <div class="alert alert-dismissible alert-success">                                    
                                        <img src="<?php echo base_url('front');?>/images/right.png"> <strong>Completed!</strong> Your have completed this order.
                                  </div>
                                <?php }else if($order['order_status'] == 1){ ?>
                                  <div class="alert alert-dismissible alert-warning">                                    
                                        <strong>Pending!</strong> You have not accepted this order.
                                  </div>                                
                                <?php }else{ ?>                               
                                  <div class="alert alert-dismissible alert-danger">                                    
                                        <img height="25" width="25" src="https://2.bp.blogspot.com/-SCbOaY9CwqU/WsJPsDgZbWI/AAAAAAAABqU/NiSJaXtY1tEdDYcyBFU8LNFAxfCWQNmcgCLcBGAs/s1600/wrong.png">
                                        <strong>Cancelled!</strong> You have declined this order.
                                  </div> 
                                <?php } ?>
                            <?php } ?>


                        </div>
                        <div class="section_content">
                          <i class="far fa-calendar-alt"></i>
                          <span><?=date('d M Y h:i:s',strtotime($order['created_at']))?></span>
                        </div>
                        <div class="section_content">
                          <i class="fas fa-map-marker-alt"></i>
                          <?php $location = json_decode($order['location']);?>
                          <span><?=($order['location'])? $location->house.', '.$location->street.', '.$location->location.' near '.$location->landmark:'--'?></span>
                        </div>
                        <div class="section_content">     
                          <i class="fas fa-wallet"></i>
                          <span>AED <?=($order['amount'])? $order['amount'] : '' ;?>(<?=($order['payment_type'] != 'day')? 'Every '.$order['payment_type'] : 'One Time';?>)</span>
                        </div>
                        <div class="section_content">
                          <i class="fa fa-cog" aria-hidden="true"></i>
                          <span>Order No : <?=($order['order_id'])?($order['order_id']):''?></span>
                        </div>
                        
                        <?php $schedule = json_decode($order['schedule']); ?>
                        
                        <?php if($schedule != '' && $schedule != '1'){
                        if($order['payment_type'] == 'dat'){                            
                            $frequency = 'On '.date('D', strtotime($order['startDate']));
                        }else if($order['payment_type'] == 'week'){                            
                            $frequency = 'Every Week On '.date('D', strtotime($order['startDate']));
                        }else if($order['payment_type'] == 'month'){                            
                            $frequency = 'On '.date('d', strtotime($order['startDate'])).' date of every month';
                        }else if($order['payment_type'] == 'year'){                            
                            $frequency = 'Every Year On '.date('d M', strtotime($order['startDate']));
                        }?>
                        <div class="section_content">
                          <i class="fa fa-cog" aria-hidden="true"></i>
                          <span>Schedule Time : <?=$frequency?>
                          </span>
                        </div>
                        <?php } ?>
                    
                        <div class="section_content">
                        <h3>Services</h3>                                
                            <?php $service = json_decode($order['services']); ?>                            
                            <?php foreach($service as $key => $value){  //print_r($value); 
                                if(is_array($value)){
                                if(isset($value->label)){
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
                                <div class="section_content">
                                    <span><strong><?=implode(' ',explode('_',$key))?> : </strong><?= implode(',',$value) ?></span>
                                </div>
                            <?php } } }?>
                            <?php ?>                            
                        </div>
                        
                        <h3>Payment Method</h3>                                                                              
                        <div class="section_content">                        
                            <span><strong><?php echo ($order['payment_method'] == 'stripe') ? 'credit / debit Card' : 'Cash'; ?></strong></span>
                        </div>
                        
                        <h3>Payment Status</h3>
                        <div class="section_content">
                            <?php if($result->user_type == 1){ ?>
                                <?php if($order['order_status'] == 1){ ?>
                                  <div class="alert alert-dismissible alert-warning">                                    
                                        <strong>Pending!</strong> You will make payment once your order has been accepted.
                                  </div> 
                                <?php } ?>
                                <?php if($order['order_status'] == 2 && $order['payment_status'] == 'pending'){ ?>
                                  <div class="alert alert-dismissible alert-warning">                                    
                                        <strong>Pending!</strong> Make payment once your order has been completed.
                                  </div> 
                                <?php } ?>
                                <?php if($order['order_status'] == 2 && $order['payment_status'] != 'pending'){ ?>
                                  <div class="alert alert-dismissible alert-success">                                    
                                        <strong>Paid </strong>
                                  </div> 
                                <?php } ?>
                                <?php if($order['order_status'] == 3){ ?>
                                  <div class="alert alert-dismissible alert-danger">                                    
                                        <strong>Not Applicable</strong>
                                  </div> 
                                <?php } ?>
                            <?php } else { ?>
                                <?php if($order['order_status'] == 1){ ?>
                                  <div class="alert alert-dismissible alert-warning">                                    
                                        <strong>Pending!</strong> 
                                  </div> 
                                <?php } ?>
                                <?php if($order['order_status'] == 2 && $order['payment_status'] == 'pending'){ ?>
                                  <div class="alert alert-dismissible alert-warning">                                    
                                        <strong>Pending!</strong> Payment will be done once you completed this order.
                                  </div> 
                                <?php } ?>
                                <?php if($order['order_status'] == 2 && $order['payment_status'] != 'pending'){ ?>
                                  <div class="alert alert-dismissible alert-success">                                    
                                        <strong>Paid </strong>
                                  </div> 
                                <?php } ?>
                                <?php if($order['order_status'] == 3){ ?>
                                  <div class="alert alert-dismissible alert-danger">                                    
                                        <strong>Not Applicable</strong>
                                  </div> 
                                <?php } ?>
                            <?php } ?>
                        </div>

                        <!--<div class="Request_btn button">
                          <button class="btn btn_start"><i class="fa fa-play" aria-hidden="true"></i><span>Start</span></button>
                          <span class="btn_or">OR</span>
                          <button class="btn btn_stop"><i class="fa fa-times" aria-hidden="true"></i><span>Cancel</span></button>
                        </div>-->

                        <?php 
                        
                        if($result->user_type == 2){
                          if($order['order_status'] != '2'){
                            ?>
                              <div class="Request_btn button">
                                <button onclick="changeStatus('2')" class="btn btn_start"><span>Accept</span></button>
                                
                                <?php if($order['order_status'] != 3){ ?>
                                <button onclick="changeStatus('3')" class="btn btn_stop"><i class="fa fa-times" aria-hidden="true"></i><span>Reject</span></button>
                                <?php } ?>

                              </div>
                            <?php
                          }else if($order['order_status'] == '2'){
                            if($order['payment_method'] != 'stripe'){
                              if($order['payment_status'] == 'pending'){
                                ?>
                                  <small>Once you receive payment, please verify by clicking this button.</small>  
                                  <div class="Request_btn button">                                    
                                    <button onclick="changePaymentStatus();" class="btn btn_start"><span>Payment Done</span></button>                                    
                                  </div>                                  
                                <?php
                              }
                            }
                          }
                        }
                       

                        
                        if($order['payment_method'] == 'stripe'){
                          if($order['order_status'] == '2'){
                            if($result->user_type == 1){
                              if($order['payment_status'] == 'pending'){
                                ?>
                                <div class="Request_btn button">
                                <a href="<?php echo site_url('stripe_pay/pay/'.base64_encode($order['order_id'])); ?>">
                                <button  class="btn btn_start">
                                <i class="fa fa-credit-card" aria-hidden="true"></i>
                                <span>Pay for start your work</span>
                                </button>
                                </a>
                                </div>
                                <?php
                              }else{
                                
                                if($order['review_status'] != 'sent'){
                              ?>
                                <div class="review_form_wrap">
                                  <div class="review_heading">
                                    Give us reviews
                                  </div>
                                  <div class="review_form">
                                    <form method="post" id="form" action="<?php echo site_url('user/reviewRating');?>">
                                      <div class="form_group">
                                        <label>Your Review</label>
                                        <div class="input_group">
                                        <textarea class="bg_blue_light" name="review_text" placeholder="Enter Your Comment"></textarea>
                                        </div>
                                      </div>
                                      <!-- ratings -->
                                      <input type="hidden" value="<?php echo $pageId; ?>" name="orderId">
                                      <div class="form_group">
                                        <label>Your Rating</label>
                                        <div class="input_group">
                                         <div class="radio_box">
                                          <label>
                                          <input type="radio" name="rating" value="5">
                                          <span class="r_check"></span>
                                          <span class="r_texts">
                                            <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
                                          </span>
                                          </label>
                                          <label>
                                          <input type="radio" name="rating" value="4">
                                          <span class="r_check"></span>
                                          <span class="r_texts">
                                            <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
                                          </span>
                                          </label>
                                          <label>
                                          <input type="radio" name="rating" value="3">
                                          <span class="r_check"></span>
                                          <span class="r_texts">
                                            <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
                                          </span>
                                          </label>
                                          <label>
                                          <input type="radio" name="rating" value="2">
                                          <span class="r_check"></span>
                                          <span class="r_texts">
                                            <i class="fa fa-star"></i><i class="fa fa-star"></i>
                                          </span>
                                          </label>
                                          <label>
                                          <input type="radio" name="rating" value="1">
                                          <span class="r_check"></span>
                                          <span class="r_texts">
                                            <i class="fa fa-star"></i>
                                          </span>
                                          </label>
                                        </div>
                                        </div>
                                      </div>
                                      <!-- ratings -->
                                       <div class="form_group profile_btns">
                                        <input type="submit" name="review_submit" class="red_button review_sub_btn" value="Submit">
                                      </div>
                                    </form>
                                  </div>
                                </div>
                                <?php
                              }
                              }
                            }
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
                    <h2><?=($vendor->shop_name) ? $vendor->shop_name : ($vendor->f_name).' '.($vendor->l_name)?></h2>
                    <span><?=($vendor->country).', '.($vendor->city)?></span>
                    <span><i class="fa fa-phone" aria-hidden="true"></i><?=($vendor->phone)?></span>
                    <span><i class="fa fa-envelope" aria-hidden="true"></i><?=($vendor->email)?></span>                  
                    <a href="<?php echo base_url('chat/message/'.base64_encode($vendor->id).'/'.base64_encode($order['order_id'])); ?>" type="button" class="btn btn_accepted"> Chat</a>
                  </div>

                  <div class="map_section">
                    <div id="map" style="width:100%; height:300px;"></div>
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

  function changePaymentStatus(){
    $.ajax({
      url: "<?php echo base_url('user/changePaymentStatus'); ?>",
      data : {
        id:"<?php echo $order['id']; ?>",
      },
      type:'POST',
      success: function(result){
        location.reload();
      }
    });
  }
</script>
<script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyCCQzJ9DJLTRjrxLkRk6jaSrvcc5BfDtWM" type="text/javascript"></script>
<script type="text/javascript">
initialize(<?=$vendor->placeLat?>, <?=$vendor->placeLong?>);    
function initialize(lat, long) {    
    var latlng = new google.maps.LatLng(lat,long);
    var map = new google.maps.Map(document.getElementById('map'), {
      center: latlng,
      zoom: 10,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });
	
	var marker = new google.maps.Marker({
        position: latlng,
        map: map        
      });    
	  
}

</script>

<?php $this->load->view('footer');?> 