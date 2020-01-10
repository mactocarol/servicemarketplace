<?php $this->load->view('admin/includes/sidebar'); ?>

<!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        Edit Proposal Job

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

                  <h3 class="box-title">Edit Proposal</h3>

                </div>

                <!-- /.box-header -->

                <div class="box-body">

                  <div id="upload_msg"></div> 

                                   <form role="form" id="" name="" method="post" action="<?php echo base_url().'admin/edit_proposal/'.$reslt->id;?>" enctype="multipart/form-data">
                                          <div class="form-group">

                                            <label> Name </label> 

                                             <div class="input_box"> 

                                                 <input name="name" class="input-text form-control" required="required" type="text" value="<?php echo isset($users->name)? $users->name:'';?>" readonly>

                                             </div>

                                          </div>

                                          <!--   <div class="form-group">

                                            <label> Title </label> 

                                             <div class="input_box"> 

                                                 <input placeholder="Enter Job Title" name="job_title" class="input-text form-control" required="required" type="text" value="<?php echo isset($reslt->job_title)? $reslt->job_title:'';?>">                                               

                                             </div>

                                             </div> -->

                                              <div class="form-group">

                                                <label>Description</label>

                                             <div class="input_box"> 

                                                 <textarea placeholder="Enter Job Description" name="proposal" class="input-text form-control"><?php echo isset($reslt->proposal)? $reslt->proposal:'';?></textarea>
												 </div>                                                 

                                             </div>

                                             <!-- </div>    
                                              <div class="form-group">
                                                <label>Service</label>
                                                <div class="">
                                                   <select class="form-control" required name="title">
                                                       <option value="" selected="selected">Select Services</option>
                                                       <?php foreach($reslt as $c) {?>
                                                          <option  data-tokens="<?=$c['name']?>" <?php if($c['id'] == $reslt->title) echo "selected"; ?> value="<?=$c['id']?>"><?=$c['name']?></option>
                                                       <?php } ?>
                                                   </select>
                                                </div>
                                              </div>   -->
                                          <!-- <div class="form-group">
                                            <label> Service </label> 
                                             <div class="input_box"> 
                                                 <input name="title" class="input-text form-control" required="required" type="text" value="<?php echo isset($service->title)? $service->title:'';?>" readonly>
                                             </div>
                                          </div>                                         
 --><!-- 
                                             <div class="form-group">
                                               <label>Job Type </label> 
                                               <select name="job_type" class="form-control">
                                                    <option value="All" <?php if($reslt->gender == 'All') echo "selected";?>>All</option>
                                                    <option value="">Select Job Type</option>
                                                    <option value="Full Time" <?php if($reslt->job_type == 'Full Time') echo "selected";?>>Full Time</option>
                                                    <option value="Part Time" <?php if($reslt->job_type == 'Part Time') echo "selected";?>>Part Time</option>
                                                    <option value="Hourly" <?php if($reslt->job_type == 'Hourly') echo "selected";?>>Hourly</option>
                                                    <option value="Freelancer" <?php if($reslt->job_type == 'Freelancer') echo "selected";?>>Freelancer</option>
                                               </select> 
                                            </div> -->
                                             <!-- <div class="form-group">

                                               <label>Milestone</label>                                

                                               <input name="milestone" type="text" class="input-text form-control" value="<?php echo ($reslt->milestone) ? $reslt->milestone : ''; ?>" placeholder="Enter Milestone">

                                            </div> -->
											
                                            <div class="form-group">

                                               <!-- <label>Budget Package (<small>Annually</small>)</label>                                                                                -->
                                               <label>Bid Value</label>                                                                               

                                               <!--<select class="form-control"  name="bid_value" required>

                                                    <option selected="selected" value="">Select Salary</option>													

                                                </select> -->
										 <div class="input_box"> 		
											<input type="text" name="bid_value" class="form-control" required value="<?= isset($reslt->amount) ? $reslt->amount : ''; ?>"/>
												</div>
                                            </div>
<!-- 
                                            <div class="form-group">

                                               <label>Experience Required</label>                                

                                               <select class="form-control" data-live-search="true" name="experience">

                                                    <option selected="selected" value="0">Select Experience</option>

                                                    <option data-tokens="0" value="0">Fresher</option>

                                                    <?php for($i=1; $i<=10; $i++){ ?>

                                                        <option data-tokens="<?=$i?>" value="<?=$i?>" <?php if($reslt->experience == $i) echo "selected";?>><?=$i?> +</option>

                                                    <?php } ?>                    

                                                </select> 

                                            </div>
 --><!-- 
                                            <div class="form-group">

                                               <label>Job For </label>                                

                                               <select name="gender" class="form-control">

                                                    <option value="All" <?php if($reslt->gender == 'All') echo "selected";?>>All</option>

                                                    <option value="Male" <?php if($reslt->gender == 'Male') echo "selected";?>>Male</option>

                                                    <option value="Female" <?php if($reslt->gender == 'Female') echo "selected";?>>Female</option>                                                               

                                               </select>    

                                            </div> -->

                                            <div class="form-group">

                                               <label>Address</label>                                

                                               <input name="address" readonly="" type="text" class="input-text form-control" value="<?php echo ($job_post->address) ? $job_post->address : ''; ?>" placeholder="Job Address">

                                            </div>

                                             <!-- <div class="form-group">
                                               <label>Day</label>
                                               <input name="day" type="text" class="input-text form-control" value="<?php echo ($reslt->day) ? $reslt->day : ''; ?>" placeholder="Day">
                                            </div> -->

                                           <!--  <div class="form-group">

                                               <label>Specialization</label>                                

                                               <input name="specialization" type="text" class="input-text form-control" value="<?php echo ($reslt->specialization) ? $reslt->specialization : ''; ?>" placeholder="Any Specialization Required for this Job">

                                            </div> -->

                                            <div class="form-group">

                                                <label>Job Status </label>                                

                                                <select name="status" class="form-control">

                                                     <option value="1" <?php if($reslt->status == '1') echo "selected";?>>Open</option>

                                                     <option value="2" <?php if($reslt->status == '2') echo "selected";?>>Awarded</option>  

                                                     <option value="3" <?php if($reslt->status == '3') echo "selected";?>>Completed</option>                                                            

                                                </select>    

                                            </div>
											
											<div class="form-group">

                                                <label>Accept/Reject </label>                                

                                                <select name="accept" class="form-control">

                                                     <option value="0" <?php if($reslt->accept == '0') echo "selected";?>>Pending</option>

                                                     <option value="1" <?php if($reslt->accept == '1') echo "selected";?>>Accept</option>  

                                                     <option value="2" <?php if($reslt->accept == '2') echo "selected";?>>Reject</option>                                                            

                                                </select>    

                                            </div>
 
                                             <div class="form-group">

                                                <input type="submit" class="btn btn-primary" value="Submit"><!-- 
                                                <input type="submit" name='submit_image' class="btn btn-primary" id="get-thumbnail" value="Submit" onclick='upload_image();'/> --> 

                                             </div>
                                </form>                               

                                <video id="main-video" controls style="display:none">
                                    <source type="video/mp4">
                                </video>
                                <canvas id="video-canvas" style="display:none"></canvas>
                    

                            <div class='progress' id="progress_div">
                            <div class='bar' id='bar'></div>
                            <div class='percent' id='percent'>0%</div>
                            </div> 

                </div>

               </div>

        </section>

        <!-- /.Left col -->

   

    </div>



    </section>

    <!-- /.content -->

  </div>

<style>

   /* progress bar*/

#myForm 

{ 

width:400px;

margin-top:50px;

margin: 20px; 

background: #A9BCF5; 

border-radius: 10px; 

padding: 15px 

}

.red p{

    color: red;

}

.progress {text-align:left;margin-top:20px;display:none; height:30px !important; position:relative; width:100%; border: 1px solid #ddd; padding: 1px; border-radius: 3px; }

#bar.bar { background-color:#13b5ea; width:0%; height:30px; border-radius: 3px; }

.percent { position:absolute; display:inline-block; top:8px; left:48%; }

/* progress bar end */

</style>

<script type="text/javascript" src="<?php echo base_url('front');?>/js/jquery.form.js"></script>

<script>   

            

	function upload_image() 

	{

		var bar = $('#bar');

		var percent = $('#percent');

		

		$('#myForm1').ajaxForm({

			beforeSubmit: function() {

				document.getElementById("progress_div").style.display="block";

				var percentVal = '0%';

				bar.width(percentVal)

				percent.html(percentVal);

			},

			uploadProgress: function(event, position, total, percentComplete) {

				var percentVal = percentComplete + '%';

				bar.width(percentVal)

				percent.html(percentVal);

			},

			success: function(data) {

				var percentVal = '100%';

				bar.width(percentVal)

				percent.html(percentVal);

                document.getElementById("upload_msg").innerHTML=data;

                var res = data.split("://");

                if(res[0] == 'http' || res[0] == 'https'){

                    window.location.href = data;

                }

                

			},

			complete: function(xhr) {

				if(xhr.responseText)

				{

                    document.getElementById("upload_msg").innerHTML=data;

					//location.reload();

                    document.getElementById("output_image").innerHTML=xhr.responseText;

				}

			}

		}); 

        

    }    

         var _CANVAS = document.querySelector("#video-canvas"),

                _CTX = _CANVAS.getContext("2d"),

                _VIDEO = document.querySelector("#main-video");

            

            document.querySelector("#upload_file").addEventListener('change', function() {

                

                document.querySelector("#main-video source").setAttribute('src', URL.createObjectURL(document.querySelector("#upload_file").files[0]));

                

                _VIDEO.load();

            

                _VIDEO.addEventListener('loadedmetadata', function() { console.log(_VIDEO.duration);

                  

                    _CANVAS.width = _VIDEO.videoWidth;

                    _CANVAS.height = _VIDEO.videoHeight;

                   

                });

            });

    

        document.querySelector("#get-thumbnail").addEventListener('click', function() {

                _CTX.drawImage(_VIDEO, 0, 0, _VIDEO.videoWidth, _VIDEO.videoHeight);

                console.log('parvez');

                console.log(_VIDEO.videoWidth);

                if(_VIDEO.videoWidth){

                    $('#thumb').val(_CANVAS.toDataURL());    

                }                                

            });

            console.log('khan');

    

    

            

</script> 