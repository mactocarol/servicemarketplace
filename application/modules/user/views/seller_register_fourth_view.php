<?php $this->load->view('header');?>  
        <!-- breadcrumb Start -->
    <section class="breadcrumb_outer">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h2 class="text-capitalize">Signup Step 4</h2>
                </div>
                <div class="col-lg-6">
                     <ol class="breadcrumb pull-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Signup Step 4</li>
                      </ol>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb End -->
    <!-- signup form Start -->
    <div class="signup_wrapper pad_top_bottom_50">
        <div class="container">
            <div class="form_wrapper_main">
                <div class="signup_header">
                    <h3>Apply now as a service provider</h3>
                    <p>Simply fill out the application</p>
                </div>
                <div class="step_wizard">
                    <a href="#" class="step_circle active"><i class="fas fa-check"></i></a>
                    <a href="#" class="step_circle active"><i class="fas fa-check"></i></a>
                     <a href="#" class="step_circle active"><i class="fas fa-check"></i></a>
                    <a href="#" class="step_circle current">4</a>
                </div>
                <div class="signup_header">
                    <h3>Upload trade License</h3>
                    <p>Upload Document</p> 
                </div>
                <!-- form Start -->
                <div class="col-lg-6 col-md-8 col-lg-offset-3 col-md-offset-2 col-xs-12">
                    <div class="register_form_wrap">
                        <form id="form"  method="post" action="<?php echo site_url('user/service_register_fourth');?>" enctype="multipart/form-data">
                            <div class="form_group">
                               <div class="file_upload_div">
                                    <label for="file_upload" class="file_text">
                                        <p>Drag And Drop A File Or Select A  File</p>
                                    </label>
                                    <input id="file_upload" name='fileupload' type="file">
                                </div> 
                            </div>
                            <div class="form_group">
                               <div class="form_input">
                                    <div class="check_box">
                                        <label>
                                            <input type="checkbox" name="termscondition" value="termscondition">
                                            <span class="ck_box"><i class="fas fa-check"></i></span>
                                            <span class="ck_text">
                                                I have read and agree to the <a href="#">Terms & Conditions</a> and the <a href="#">Privacy Policy</a>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="sellerid" value="<?=$sellerid?>">
                            <div class="button_wrap text-center">
                                <button type="button" name="" onclick="submit_form();" class="red_button submit_btn">Next</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- form End -->
            </div>
        </div>
    </div>
    <!-- signup form End -->

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        function submit_form(){
            
            var file = $('#file_upload')[0].files[0]
            if (file){
                $('#form').submit();
                return true;
            }else{
                swal('Please Select trade License.');
                return false;
            }
            
        }
    </script>
    
<?php $this->load->view('footer');?>  