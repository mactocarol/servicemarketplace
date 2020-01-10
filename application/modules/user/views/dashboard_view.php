<?php $this->load->view('header');?>
<section class="breadcrumb_outer">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h2 class="text-capitalize">My Listing</h2>
            </div>
            <div class="col-lg-6">
                 <ol class="breadcrumb pull-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">My Orders</li>
                  </ol>
            </div>
        </div>
    </div>
</section>  
<section class="body_btn">    
    <div class="container tab tabs_menu">        
        <button type="button" class="btn btn-danger-custom tablinks active" onclick="orderDetails(event, 'All');">All</button>
        <button type="button" class="btn btn-success-custom tablinks" onclick="orderDetails(event, 'Accepted');">Accepted</button>
        <button type="button" class="btn btn-primary-custom tablinks" onclick="orderDetails(event, 'Pending');">Pending</button>
        <button type="button" class="btn btn-warning-custom tablinks" onclick="orderDetails(event, 'Canceled');">Cancelled</button>  
    </div>
</section>

<section class="body_content">
    <div class="container">
      <div class="row">
        <div class="col-md-12 ">
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
         <div id="All" class="tabcontent">
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
                                <th>Order No.</th>
                                <th>Service Requested</th>
                                <th>Date</th>
                                <th>Frequency</th>
                                <th>Scheduled Time</th>
                                <th>Request type</th>
                                <th>Payment Method</th>
                                <th>Status</th>
                                <th>Cost</th>
                                <th>Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($orders)){?>
                            <?php foreach($orders as $row){?>
                            <?php //echo '<pre>'; print_r($row);die(); ?>
                            <tr>
                                <td><?=($row['order_id'])?($row['order_id']):''?></td>
                                <td><?php echo ($row['servicename'])?json_decode($row['servicename']):''?></td>
                                <td>
                                    <?php
                                    if($row['startDate']){
                                        if($row['payment_type'] == 'day'){
                                            echo date('d M Y',strtotime($row['startDate']));
                                        }
                                        if($row['payment_type'] == 'week'){
                                            echo 'On '.date('D',strtotime($row['startDate']));
                                        }
                                        if($row['payment_type'] == 'month'){
                                            echo 'On '.date('d',strtotime($row['startDate']));
                                        }
                                        if($row['payment_type'] == 'year'){
                                            echo 'On '.date('d M',strtotime($row['startDate']));
                                        }
                                    }else{
                                        echo "N/A";
                                    }
                                    ?>
                                    </td>
                                <td><?=($row['payment_type'] != 'day')? 'Every '.$row['payment_type']:'One Time'?></td>
                                <td><?=($row['time'])?$row['time']:'N/A'?></td>
                                <td><?=($row['schedule'] != 1)?'On Site':'Collect & Return'?></td>
                                <td><?=($row['payment_method'] == 'stripe')?'credit / debit Card':'Cash'?></td>
                                <td>
                                    <?php if($row['order_status'] == 1){?>
                                    <a href="#" type="button" class="btn btn_pending">Pending</a>
                                    <?php } ?>
                                    <?php if($row['order_status'] == 2){?>
                                    <a href="#" type="button" class="btn btn_accepted">Accepted</a>
                                    <?php } ?>
                                    <?php if($row['order_status'] == 3){?>
                                    <a href="#" type="button" class="btn btn_cancel">Cancle</a>
                                    <?php } ?>
                                </td>
                                <td><?=($row['amount'])?($row['amount']):'NA'?></td>
                                <td><a href="<?php echo site_url('user/orderDetail/'.base64_encode($row['order_id'])); ?>" type="button" class="btn btn_view"> view</a></td>
                            </tr>
                            <?php } } else { ?>
                            <tr>
                                <td colspan="7"><center>No Orders Yet.</center></td>                                
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
         </div><!--All tab -->
         
         <div id="Accepted" class="tabcontent">
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
                                <th>Order No.</th>
                                <th>Service Requested</th>
                                <th>Date</th>
                                <th>Frequency</th>
                                <th>Scheduled Time</th>
                                <th>Request type</th>
                                <th>Payment Method</th>
                                <th>Status</th>
                                <th>Cost</th>
                                <th>Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($accepted_orders)){?>
                            <?php foreach($accepted_orders as $row){?>
                            <?php //echo '<pre>'; print_r($row);die(); ?>
                            <tr>
                                <td><?=($row['order_id'])?($row['order_id']):''?></td>
                                <td><?php echo ($row['servicename'])?json_decode($row['servicename']):''?></td>
                                <td>
                                    <?php
                                    if($row['startDate']){
                                        if($row['payment_type'] == 'day'){
                                            echo date('d M Y',strtotime($row['startDate']));
                                        }
                                        if($row['payment_type'] == 'week'){
                                            echo 'On '.date('D',strtotime($row['startDate']));
                                        }
                                        if($row['payment_type'] == 'month'){
                                            echo 'On '.date('d',strtotime($row['startDate']));
                                        }
                                        if($row['payment_type'] == 'year'){
                                            echo 'On '.date('d M',strtotime($row['startDate']));
                                        }
                                    }else{
                                        echo "N/A";
                                    }
                                    ?>
                                    </td>
                                <td><?=($row['payment_type'] != 'day')? 'Every '.$row['payment_type']:'One Time'?></td>
                                <td><?=($row['time'])?$row['time']:'N/A'?></td>
                                <td><?=($row['schedule'] != 1)?'On Site':'Collect & Return'?></td>
                                <td><?=($row['payment_method'] == 'stripe')?'credit / debit Card':'Cash'?></td>
                                <td>
                                    <?php if($row['order_status'] == 1){?>
                                    <a href="#" type="button" class="btn btn_pending">Pending</a>
                                    <?php } ?>
                                    <?php if($row['order_status'] == 2){?>
                                    <a href="#" type="button" class="btn btn_accepted">Accepted</a>
                                    <?php } ?>
                                    <?php if($row['order_status'] == 3){?>
                                    <a href="#" type="button" class="btn btn_cancel">Cancle</a>
                                    <?php } ?>
                                </td>
                                <td><?=($row['amount'])?($row['amount']):'NA'?></td>
                                <td><a href="<?php echo site_url('user/orderDetail/'.base64_encode($row['order_id'])); ?>" type="button" class="btn btn_view"> view</a></td>
                            </tr>
                            <?php } } else { ?>
                            <tr>
                                <td colspan="7"><center>No Orders Yet.</center></td>                                
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
         </div><!--Accepted tab -->
         
         <div id="Pending" class="tabcontent">
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
                                <th>Order No.</th>
                                <th>Service Requested</th>
                                <th>Date</th>
                                <th>Frequency</th>
                                <th>Scheduled Time</th>
                                <th>Request type</th>
                                <th>Payment Method</th>
                                <th>Status</th>
                                <th>Cost</th>
                                <th>Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($pending_orders)){?>
                            <?php foreach($pending_orders as $row){?>
                            <?php //echo '<pre>'; print_r($row);die(); ?>
                            <tr>
                                <td><?=($row['order_id'])?($row['order_id']):''?></td>
                                <td><?php echo ($row['servicename'])?json_decode($row['servicename']):''?></td>
                                <td>
                                    <?php
                                    if($row['startDate']){
                                        if($row['payment_type'] == 'day'){
                                            echo date('d M Y',strtotime($row['startDate']));
                                        }
                                        if($row['payment_type'] == 'week'){
                                            echo 'On '.date('D',strtotime($row['startDate']));
                                        }
                                        if($row['payment_type'] == 'month'){
                                            echo 'On '.date('d',strtotime($row['startDate']));
                                        }
                                        if($row['payment_type'] == 'year'){
                                            echo 'On '.date('d M',strtotime($row['startDate']));
                                        }
                                    }else{
                                        echo "N/A";
                                    }
                                    ?>
                                    </td>
                                <td><?=($row['payment_type'] != 'day')? 'Every '.$row['payment_type']:'One Time'?></td>
                                <td><?=($row['time'])?$row['time']:'N/A'?></td>
                                <td><?=($row['schedule'] != 1)?'On Site':'Collect & Return'?></td>
                                <td><?=($row['payment_method'] == 'stripe')?'credit / debit Card':'Cash'?></td>
                                <td>
                                    <?php if($row['order_status'] == 1){?>
                                    <a href="#" type="button" class="btn btn_pending">Pending</a>
                                    <?php } ?>
                                    <?php if($row['order_status'] == 2){?>
                                    <a href="#" type="button" class="btn btn_accepted">Accepted</a>
                                    <?php } ?>
                                    <?php if($row['order_status'] == 3){?>
                                    <a href="#" type="button" class="btn btn_cancel">Cancle</a>
                                    <?php } ?>
                                </td>
                                <td><?=($row['amount'])?($row['amount']):'NA'?></td>
                                <td><a href="<?php echo site_url('user/orderDetail/'.base64_encode($row['order_id'])); ?>" type="button" class="btn btn_view"> view</a></td>
                            </tr>
                            <?php } } else { ?>
                            <tr>
                                <td colspan="7"><center>No Orders Yet.</center></td>                                
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
         </div><!--Pending tab -->
         
         
         <div id="Canceled" class="tabcontent">
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
                                <th>Order No.</th>
                                <th>Service Requested</th>
                                <th>Date</th>
                                <th>Frequency</th>
                                <th>Scheduled Time</th>
                                <th>Request type</th>
                                <th>Payment Method</th>
                                <th>Status</th>
                                <th>Cost</th>
                                <th>Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($cancelled_orders)){?>
                            <?php foreach($cancelled_orders as $row){?>
                            <?php //echo '<pre>'; print_r($row);die(); ?>
                            <tr>
                                <td><?=($row['order_id'])?($row['order_id']):''?></td>
                                <td><?php echo ($row['servicename'])?json_decode($row['servicename']):''?></td>
                                <td>
                                    <?php
                                    if($row['startDate']){
                                        if($row['payment_type'] == 'day'){
                                            echo date('d M Y',strtotime($row['startDate']));
                                        }
                                        if($row['payment_type'] == 'week'){
                                            echo 'On '.date('D',strtotime($row['startDate']));
                                        }
                                        if($row['payment_type'] == 'month'){
                                            echo 'On '.date('d',strtotime($row['startDate']));
                                        }
                                        if($row['payment_type'] == 'year'){
                                            echo 'On '.date('d M',strtotime($row['startDate']));
                                        }
                                    }else{
                                        echo "N/A";
                                    }
                                    ?>
                                    </td>
                                <td><?=($row['payment_type'] != 'day')? 'Every '.$row['payment_type']:'One Time'?></td>
                                <td><?=($row['time'])?$row['time']:'N/A'?></td>
                                <td><?=($row['schedule'] != 1)?'On Site':'Collect & Return'?></td>
                                <td><?=($row['payment_method'] == 'stripe')?'credit / debit Card':'Cash'?></td>
                                <td>
                                    <?php if($row['order_status'] == 1){?>
                                    <a href="#" type="button" class="btn btn_pending">Pending</a>
                                    <?php } ?>
                                    <?php if($row['order_status'] == 2){?>
                                    <a href="#" type="button" class="btn btn_accepted">Accepted</a>
                                    <?php } ?>
                                    <?php if($row['order_status'] == 3){?>
                                    <a href="#" type="button" class="btn btn_cancel">Cancel</a>
                                    <?php } ?>
                                </td>
                                <td><?=($row['amount'])?($row['amount']):'NA'?></td>
                                <td><a href="<?php echo site_url('user/orderDetail/'.base64_encode($row['order_id'])); ?>" type="button" class="btn btn_view"> view</a></td>
                            </tr>
                            <?php } } else { ?>
                            <tr>
                                <td colspan="7"><center>No Orders Yet.</center></td>                                
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
         </div><!--Canceled tab -->
        
        </div>
     </div>
    </div>
</section>
<script>
    $(".tabs_menu .tablinks").on('click',function(){
        $(".tabs_menu .tablinks").removeClass("active");
        $(this).addClass("active");
    });

    orderDetails(event, 'All')
    function orderDetails(evt, cityName){
      var i, tabcontent, tablinks;
      tabcontent = document.getElementsByClassName("tabcontent");
      for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
      }
      tablinks = document.getElementsByClassName("tablinks");
      for (i = 0; i < tablinks.length; i++) {
        //tablinks[i].className = tablinks[i].className.replace("active", "");
      }
      document.getElementById(cityName).style.display = "block";
      //evt.currentTarget.className += " active";    
    }
</script>
<?php $this->load->view('footer');?> 