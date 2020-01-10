<?php $this->load->view('admin/includes/sidebar'); ?>

<!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        Dashboard

        <small>Control panel</small>

      </h1>

      <ol class="breadcrumb">

        <li><a href="<?php echo site_url('admin/dashboard');?>"><i class="fa fa-dashboard"></i> Home</a></li>

        <li class="active">Dashboard</li>

      </ol>

    </section>



    <!-- Main content -->

    <section class="content">

      <!-- Small boxes (Stat box) -->

      <div class="row">

        <div class="col-lg-3 col-xs-6">

          <!-- small box -->

          <div class="small-box bg-red">

            <div class="inner">

              <h3><?php echo get_wallet(0)->amount;?> </h3>



              <p>Total Jobs (10)</p>

            </div>

            <div class="icon">

              <i class="ion ion-bag"></i>

            </div>

            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>

          </div>

        </div>  

		<div class="col-lg-3 col-xs-6">

          <!-- small box -->

          <div class="small-box bg-green">

            <div class="inner">

              <h3>0<?php //echo count(get_all_orders());?></h3>



              <p>Total Offers</p>

            </div>

            <div class="icon">

              <i class="ion ion-stats-bars"></i>

            </div>

            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>

          </div>

        </div>

		<div class="col-lg-3 col-xs-6">

          <!-- small box -->

          <div class="small-box bg-red">

            <div class="inner">

              <h3>22<?php //echo round(get_total_transactions()->payment_amt,2);?> </h3>



              <p>Total Blogs</p>

            </div>

            <div class="icon">

              <i class="ion ion-bag"></i>

            </div>

            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>

          </div>

        </div>

        <!-- ./col -->

		

		

        <!-- ./col -->

		<!-- ./col -->       

		

		<!-- ./col -->

        

        <!-- ./col -->

        <div class="col-lg-3 col-xs-6">

          <!-- small box -->

          <div class="small-box bg-yellow">

            <div class="inner">

              <h3><?php echo $total_user; ?></h3>



              <p>Total Users</p>

            </div>

            <div class="icon">

              <i class="ion ion-pie-graph"></i>

            </div>

            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>

          </div>

        </div>

        <!-- ./col -->

      </div>

      <!-- /.row -->

      <!-- Main row -->

      <div class="row">

        <!-- Left col -->

        <section class="col-lg-7 connectedSortable">

         

			<?php

			if($this->session->flashdata('item')) {

				$items = $this->session->flashdata('item');

				if($items->success){

				?>

					<div class="alert alert-success">

							<strong>Success!</strong> <?php print_r($items->message); ?>

					</div>

				<?php

				}else{

				?>

					<div class="alert alert-danger">

							<strong>Error!</strong> <?php print_r($items->message); ?>

					</div>

				<?php

				}

			}

			?>

        </section>

        <!-- /.Left col -->

      </div>

      <!-- /.row (main row) -->



    </section>

    <!-- /.content -->

  </div>

  