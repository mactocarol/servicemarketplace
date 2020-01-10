<?php $this->load->view('admin/includes/sidebar'); ?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Offer Detail
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url('admin/dashboard');?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?=$title?></li>
      </ol>
    </section>

        <!-- Main content -->
        <section class="content">
          
          <!-- Main row -->
          <div class="row">            
            <section class="col-lg-7 connectedSortable">         
                <?php
                if($this->session->flashdata('item')) {
                    $items = $this->session->flashdata('item');
                    if($items->success){
                    ?>
                        <div class="alert alert-success" id="alert">
                                <strong>Success!</strong> <?php print_r($items->message); ?>
                        </div>
                    <?php
                    }else{
                    ?>
                        <div class="alert alert-danger" id="alert">
                                <strong>Error!</strong> <?php print_r($items->message); ?>
                        </div>
                    <?php
                    }
                }
                ?>
            </section>
            <!-- Left col -->
            <section class="col-lg-12 connectedSortable">                
               <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Offer from <b><?php echo get_user($offer->offer_from)->username; ?></b> to <b><?php echo get_user($offer->offer_to)->username; ?></b></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                 
                 <div class="container">
                    <?php
                        if($this->session->flashdata('item')) {
                            $items = $this->session->flashdata('item');
                            if($items->success){
                            ?>
                                <div class="alert alert-success" id="alert">
                                        <strong>Success!</strong> <?php print_r($items->message); ?>
                                </div>
                            <?php
                            }else{
                            ?>
                                <div class="alert alert-danger" id="alert">
                                        <strong>Error!</strong> <?php print_r($items->message); ?>
                                </div>
                            <?php
                            }
                        }
                        ?>
                    
                   <div class="col-md-10">
                    <div class="col-md-4">
						<div class="contract-inner">
							<div class="contract-title">
								<h2 class="text-capitalize">sender</h2>
							</div>							
							<ul>
								<li>
									<strong><h4><?php echo get_user($offer->offer_from)->username;?></h4></strong>      
								</li>
								<li>
									Will pay <strong><?php echo $offer->offer_amount;?> $ </strong> to <strong><?php echo get_user($offer->offer_to)->username;?></strong> to do
									<strong><?php echo $offer->task;?></strong>
								</li>
								
								<?php $milestone = json_decode($offer->milestone_amt); $days = json_decode($offer->milestone_days);?>
								<?php if(!empty($milestone)) {
										 $i = 0;
										 foreach($milestone as $row) { ?>
										 <li>
											<strong><?php echo $row;?> $ </strong> will pay after <strong><?php echo $days[$i];?></strong> days
										 </li>
								<?php $i++; } }?>
								<li>
									<strong><?php echo $offer->days;?></strong> to complete the <strong><?php echo $offer->task;?></strong> or your money will be fully refunded.                                
								</li>
								<li>
									<input type="checkbox" checked disabled> I agree to Contract's terms & conditions<br>
										<b>Sign Here</b><br>
										<textarea disabled><?php echo get_user($offer->offer_from)->username;?></textarea>
								</li>
							</ul>
						 </div>
					   </div>
					   <div class="col-md-4">
						<div class="contract-inner">
							<div class="contract-title">
								<h2 class="text-capitalize">contract offer</h2>
							</div>
							<ul>                            
								<li>
									<strong><?php echo get_user($offer->offer_from)->username;?></strong>  will pay <strong><?php echo $offer->offer_amount;?> $ </strong> to <strong><?php echo get_user($offer->offer_to)->username;?></strong> to do
									<strong><?php echo $offer->task;?></strong>
								</li>
								
								<?php $milestone = json_decode($offer->milestone_amt); $days = json_decode($offer->milestone_days);?>
								<?php if(!empty($milestone)) {
										 $i = 0;
										 foreach($milestone as $row) { ?>
										 <li>
											<strong><?php echo get_user($offer->offer_to)->username;?></strong> will get <strong><?php echo $row;?> $ </strong> after <strong><?php echo $days[$i];?></strong> days
										 </li>
								<?php $i++; } }?>
								<li>
								   <strong><?php echo get_user($offer->offer_to)->username;?></strong> have to complete the <strong><?php echo $offer->task;?></strong> within <strong><?php echo $offer->days;?></strong> or not get any money.                                
								</li>
							</ul>
						 </div>
					   </div>
					   <div class="col-md-4">
						<div class="contract-inner">
							<div class="contract-title">
								<h2 class="text-capitalize">recipient</h2>
							</div>
							<ul>
								<li>
									<strong><?php echo get_user($offer->offer_to)->username;?></strong>      
								</li>
								<li>
									Will get <strong><?php echo $offer->offer_amount;?> $ </strong> from <strong><?php echo get_user($offer->offer_from)->username;?></strong> to do
									<strong><?php echo $offer->task;?></strong>
								</li>
								
								<?php $milestone = json_decode($offer->milestone_amt); $days = json_decode($offer->milestone_days);?>
								<?php if(!empty($milestone)) {
										 $i = 0;
										 foreach($milestone as $row) { ?>
										 <li>
											<strong><?php echo $row;?> $ </strong> will get after <strong><?php echo $days[$i];?></strong> days
										 </li>
								<?php $i++; } }?>
								<li>
									Have <strong><?php echo $offer->days;?></strong> to complete the <strong><?php echo $offer->task;?></strong> or not get any money.                                
								</li>
								<li>
									<input type="checkbox"> I agree to Contract's terms & conditions<br>
										<b>Sign Here</b><br>
										<textarea disabled><?php echo get_user($offer->offer_to)->username;?></textarea>
								</li>
							</ul>
						 </div>
					   </div>
                    </div>
                
                    
                </div>
                 <hr>
                 <h4>Comments</h4>
                        <div class="table-responsive">                                                 
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                  <th>Sr. No.</th>                        
                                  <th>From</th>
                                  <th>Comment</th>                                                                                                                    
                                  <th>Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                      <?php if(isset($comments)) {
                                            $count = 0;                              
                                            foreach($comments as $row){ ?>
                                        <tr>
                                            <td><?= ++$count; ?></td>
                                            <td>
                                                <?php echo get_user($row['message_from'])->username; ?>
                                              </td>
                                            <td>
                                                <?=$row['message']?>
                                                 <?php if(($row['file'])) {?>
                                                    <div class="chat-line"> Sent you a file <a href="<?php echo site_url('offer/download/'.$row['file']);?>" target="_blank"><u><?=($row['file'])?></u></a></div>
                                                 <?php } ?>
                                            </td>
                                           
                                            <td>                                    
                                               <?=date('d M Y',strtotime($row['created_at']))?>
                                            </td>                                            
                                        </tr>                          
                                <?php  } }?>                       
                                                                   
                                </tfoot>
                            </table>
                        </div>
                </div>
                <!-- /.box-body -->
              </div>
    
            </section>
            <!-- /.Left col -->
          </div>
          <!-- /.row (main row) -->
        
        </section>

    <!-- /.content -->
  </div>
  