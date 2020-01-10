<style>
.do-business-left {    
    width: 50%;
    float: left;    
    padding: 50px;  
	border: 1px solid #eee; 
}

.do-business-right {
    float: right;
    width: 50%;
    border: 1px solid #eee;    
    padding: 50px;
}
</style>
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
						<div class="do-business-left col-md-6">
							
							<h2>offer</h2>
							<ul>
								<li>
									<?php echo ($offer->offer) ? $offer->offer : '';?>
								</li>
								<li>
									Will pay <strong><?php echo $offer->offer_amount;?> $ </strong> to  do
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
								
							</ul>                        
							<h4>( Time to Complete - <?php echo ($offer->days) ? $offer->days : '';?> Days )</h4>                
						</div>
						<div class="do-business-right col-md-6">
							<h2>what we <span>need</span></h2>
							
							<p>
								<li><?php echo ($offer->requirement) ? $offer->requirement : '';?></li>
								<li>
											We need you  to do
											<strong><?php echo $offer->task;?></strong>
										</li>
										<li>
											Have <strong><?php echo $offer->days;?></strong> days to complete the <strong><?php echo $offer->task;?></strong> or not get any money.                                
										</li>
										<?php $milestone = json_decode($offer->milestone_amt); $days = json_decode($offer->milestone_days);?>
										<?php if(!empty($milestone)) {
												 $i = 0;
												 foreach($milestone as $row) { ?>
												 <li>
													We will pay <strong><?php echo $row;?> $ </strong>  after <strong><?php echo $days[$i];?></strong> days
												 </li>
										<?php $i++; } }?>
										
							</p>
			
						</div>
					</div>	
                    
                    
                
                    
            </div>
				<hr>
				 
							<span class="btn btn-primary">$<?php echo ($offer->offer_amount) ? $offer->offer_amount : '';?></span>
                            <?php if($offer->status == 1) { ?><a href="#" class="btn btn-primary">Pending</a><?php } ?>
                            <?php if($offer->status == 2) { ?><a href="#" class="btn btn-primary">Accepted</a><?php } ?>
                            <?php if($offer->status == 3) { ?><a href="#" class="btn btn-primary">Negotiated</a><?php } ?>
                            <?php if($offer->status == 4) { ?><a href="#" class="btn btn-primary">Declined</a><?php } ?>
                            
                            <?php if($offer->status == 2 && ($offer->is_contract_signed == 1)) { ?>                                
                                <a href="<?php echo site_url('admin/offer_contract/'.$offer->id);?>" class="btn btn-primary">Go to Contract Page</a>                                    
                            <?php } ?>
                                
                                    
                    
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
  