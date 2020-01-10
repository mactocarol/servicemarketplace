<?php $this->load->view('admin/includes/sidebar'); ?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add Recording
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
                  <h3 class="box-title">Add</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <div id="upload_msg"></div> 
                    
                    
                                   <form role="form" id="myForm1" name="" method="post" action="<?php echo base_url().'admin/add_featured_products/';?>" enctype="multipart/form-data">
                                            
                                            <div class="form-group">
                                            <label>Title </label> 
                                             <div class="input_box"> 
                                                 <input placeholder="Enter Title" name="title" class="input-text form-control" required="required" type="text" value="<?php echo isset($reslt->title)? $reslt->title:'';?>">                                                 
                                             </div>
                                             </div>
                                              <div class="form-group">
                                                <label>Description</label>
                                             <div class="input_box"> 
                                                 <textarea placeholder="Enter Description" name="description" class="input-text form-control" required><?php echo isset($reslt->description)? $reslt->description:'';?></textarea>                                                 
                                             </div>
                                             </div>
                                              
                                             <div class="form-group">
                                                 <label>Recording</label>
                                                     <input type="file" name="file" class="file" id="upload_file" required>                                                                                                         
                                             
                                             </div>
                                             
                                             
                                            <div class="form-group">
                                               <label>Audio Image (optional)</label>
                                                <input type="file" name="image_thumb" class="file1" >                                                                                                
                                           </div>
                                           
                                           
                                             <div class="form-group">
                                            <label>Keywords</label>
                                             <div class="input_box"> 
                                                 <input placeholder="Enter Tags" name="tags" class="input-text form-control"  type="text" value="<?php echo isset($reslt->tags)? $reslt->tags:'';?>">                                                 
                                             </div>
                                             </div>
                                             <input type="hidden" id="thumb" name="thumb" value="">
                                             <div class="form-group">
                                                <!--<input type="submit" class="btn btn-primary" value="Submit">-->
                                                <input type="submit" name='submit_image' class="btn btn-primary" id="get-thumbnail" value="Submit" onclick='upload_image();'/> 
                                             
                                             </div>
                                             
                                     
                                </form>
                                
                               
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