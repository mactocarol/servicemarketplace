<?php $this->load->view('admin/includes/sidebar'); ?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Executive Cards
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
        <!-- Left col -->
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
        <section class="col-lg-12 connectedSortable">               
               <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Update Executive Cards</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <form role="form" id="edit_entrepreneur_form" name="" method="post" action="<?php echo base_url().'admin/cards'; ?>">
                        <!-- text input -->
                        <section class="col-lg-12 connectedSortable">                             
                             <div class="form-group">
                                <label>Bronze Card Required Amount (in dollar)</label>
                                <input type="number" class="form-control" name="bronze_amt" placeholder="Bronze Card Required Amount" value="<?php echo isset($cards[0]['limit'])? $cards[0]['limit']:'';?>" required>
                             </div>
                             <div class="form-group">
                                <label>Silver Card Required Amount (in dollar)</label>
                                <input type="number" class="form-control" name="silver_amt" placeholder="Silver Card Required Amount" value="<?php echo isset($cards[1]['limit'])? $cards[1]['limit']:'';?>" required>
                             </div>
                             <div class="form-group">
                                <label>Gold Card Required Amount (in dollar)</label>
                                <input type="number" class="form-control" name="gold_amt" placeholder="Gold Card Required Amount" value="<?php echo isset($cards[2]['limit'])? $cards[2]['limit']:'';?>" required>
                             </div>
                             
                             <div class="box-footer">
                                <input type="submit" class="btn btn-primary" value="Update">                                
                             </div>
                        </section>
                        
                  </form>
                </div>
               </div>
        </section>
				<section class="col-lg-12 connectedSortable">                
               <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Executive Cards <small>(user-wise)</small></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                 <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                      <th width="10%">Sr. No.</th>                        
                      <th>UserName</th>
                      <th>Email</th>                                                                
                      <th>Bronze Cards</th>
											<th>Silver Cards</th>
											<th>Gold Cards</th>
                      <th style="width:5px">Action</th>                  
                    </tr>
                    </thead>
                    <tbody>
                          
						  <?php if(isset($users)) {
                                $count = 0;                              
                                foreach($users as $row){ ?>
                            <tr>
                                <td><?= ++$count; ?></td>
                                <td>
                                    <?php echo isset($row['username']) ? $row['username'] : ''; ?>                                    
                                  </td>
                                <td>
                                    <?php echo isset($row['email']) ? $row['email'] : '';   ?>
                                </td>                               
                                <td>
                                    <?php echo isset($row['id']) ? get_cards($row['id'])[0] : '';   ?>
                                </td>
																<td>
                                    <?php echo isset($row['id']) ? get_cards($row['id'])[1] : '';   ?>
                                </td>
																<td>
                                    <?php echo isset($row['id']) ? get_cards($row['id'])[2] : '';   ?>
                                </td>
                                <td width="30%">
																	  <form method="post" action="<?php echo site_url('admin/allot_cards');?>">
																			<input name="no_of_cards" type="number" placeholder="No. of Cards" min="1" onkeypress="return false;" style="width: 100px;">
																			<select name="card_type" class="form-control">
																				<option value="1">Bronze</option>
																				<option value="2">Silver</option>
																				<option value="3">Gold</option>
																			</select>
																			<input type="hidden" name="user_id" value="<?=$row['id']?>">
																			<button type="submit" class="btn btn-primary btn-sm" onclick=" var c = confirm('Are you sure want to allot cards to this user?'); if(!c) return false;">Allot</button>
																		</form>                                    
                                </td>                                
                            </tr>                          
                    <?php  } }?>                      
                                                      
                    </tbody>
                  </table>
                 
              
                </div>
                <!-- /.box-body -->
              </div>
    
            </section>
        <!-- /.Left col -->
   
    </div>

    </section>
    <!-- /.content -->
  </div>
