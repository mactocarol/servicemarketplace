<?php $this->load->view('admin/includes/sidebar'); ?>

<!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        <?= $title; ?>

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

                  <h3 class="box-title"><?= $title ?></h3>

                </div>

                <!-- /.box-header -->

                <div class="box-body">

                 <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                    <thead>

                    <tr>

                      <th width="10%">Sr. No.</th>                        
                      <th>Name</th>  
                      <th>Service</th>
                      <th>Description</th>
                      <th>Budget</th> 
                      <th>Date & Time</th>  
                    </tr>
                    </thead>
                    <tbody> 

						  <?php if(isset($result1)) {

                                $count = 0;                              

                                foreach($result1 as $row){
                                  ?>                                  

                            <tr>

                                <td><?= ++$count; ?></td>
                                <td>
                                    <?php echo isset($row['name']) ? $row['name'] : ''; ?>
                                </td>                                
                                 <td>

                                    <?php echo isset($row['title']) ? $row['title'] : ''; ?>

                                </td>                                                          

                                <td>

                                    <?php echo isset($row['description']) ? $row['description'] : ''; ?>                                    

                                </td>

                                <td>

                                    <?php echo isset($row['min_budget'] ) ? 'Min Budget '.$row['min_budget'] : '';   ?>
									<?php echo isset($row['max_budget'] ) ? '<br>Max Budget '.$row['max_budget'] : '';   ?>
                                </td>
                               
                               
                                <td>

                                    <?php echo isset($row['date_time']) ? $row['date_time'] : '';   ?>

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

          <!-- /.row (main row) -->        

        </section>

    <!-- /.content -->

  </div>

  <!-- Modal -->

<div id="planModal" class="modal fade" role="dialog">

  <div class="modal-dialog">



    <!-- Modal content-->

    <div class="modal-content">

      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal">&times;</button>

        <h4 class="modal-title">User Membership</h4>

      </div>

      <div class="modal-body">

        <p>

            <form method="post" action="<?php echo site_url('admin/update_user_plan');?>">

                <div class="form-group">

                <label>Plan</label>

                <select name="plan" id="plan" class="form-control">

                    <option value="">Select Plan</option>

                    <?php if(!empty($plan)){

                            foreach($plan as $p){ ?>

                                <option value="<?=$p['id']?>"><?=$p['title']?></option>            

                    <?php   }

                    }

                    ?>                    

                </select>

                <input name="userid" type="hidden" id="userid" value="">

                </div>

                <div class="form-group">

                    <div class="form-group">

                        <label>Account Validity (till Date)</label>

                        <input type="text" placeholder="select account validity date" class="input-text form-control" id="datepicker1" name="account_valid" value="" required>

                        

                     </div>

                </div>

                <div class="box-footer">

                    <input type="submit" class="btn btn-primary" value="Update">                                

                 </div>

            </form>

        </p>

      </div>

      <div class="modal-footer">

        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

      </div>

    </div>



  </div>

</div>



<!-- video Modal -->

<div id="videoModal" class="modal fade" role="dialog">

  <div class="modal-dialog" style="width: auto";>



    <!-- Modal content-->

    <div class="modal-content">

      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal">&times;</button>

        <h4 class="modal-title">User Videos</h4>

      </div>

      <div class="modal-body">

        <p>

            <div id="video">

                

            </div>

        </p>

      </div>

      <div class="modal-footer">

        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

      </div>

    </div>



  </div>

</div>

<!-- audio Modal -->

<div id="audioModal" class="modal fade" role="dialog">

  <div class="modal-dialog" style="width: auto";>



    <!-- Modal content-->

    <div class="modal-content">

      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal">&times;</button>

        <h4 class="modal-title">User Audios</h4>

      </div>

      <div class="modal-body">

        <p>

            <div id="audio">

                

            </div>

        </p>

      </div>

      <div class="modal-footer">

        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

      </div>

    </div>



  </div>

</div>

<!-- video Modal -->

<div id="pictureModal" class="modal fade" role="dialog">

  <div class="modal-dialog" style="width: auto";>



    <!-- Modal content-->

    <div class="modal-content">

      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal">&times;</button>

        <h4 class="modal-title">User Pictures</h4>

      </div>

      <div class="modal-body">

        <p>

            <div id="picture">

                

            </div>

        </p>

      </div>

      <div class="modal-footer">

        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

      </div>

    </div>



  </div>

</div>
