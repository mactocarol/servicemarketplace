<?php $this->load->view('header');?>   
    <section class="breadcrumb_outer">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h2 class="text-capitalize">Signup Step 3</h2>
                </div>
                <div class="col-lg-6">
                     <ol class="breadcrumb pull-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Signup Step 3</li>
                      </ol>
                </div>
            </div>
        </div>
    </section>
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
                    <a href="#" class="step_circle current">3</a>
                    <a href="#" class="step_circle">4</a>
                </div>
                <div class="signup_header">
                    <h3>Provide us with your contact information</h3>
                    <p>What is about your personal Information</p> 
                </div>
                <!-- form Start -->
                <div class="col-lg-6 col-md-8 col-lg-offset-3 col-md-offset-2 col-xs-12">
                    <div class="register_form_wrap">
                        <form id="form" method="post" action="<?php echo site_url('user/service_register_three');?>">
                            <div class="form_group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form_input">
                                            <input id="fname" type="text" name="fname" placeholder="First Name">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form_input">
                                            <input id="lname" type="text" name="lname" placeholder="Last Name">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form_group">
                                <div class="form_input">
                                    <input id="email" type="email" name="email" placeholder="Email" value="<?=$users->email?>">
                                </div>
                            </div>
                            <div class="form_group">
                                <div class="form_input">
                                    <input id="phone" type="text" name="phone" placeholder="Phone Number" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
                                </div>
                            </div>
                            <input type="hidden" name="sellerid" value="<?=$sellerid?>">
                            <div class="button_wrap">
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
            
            if($.trim($('#fname').val()) == ''){
                swal('Please Fill Required Field.');
                return false;
            }

            if($.trim($('#lname').val()) == ''){
                swal('Please Fill Required Field.');
                return false;
            }

            if($.trim($('#email').val()) == ''){
                swal('Please Fill Required Field.');
                return false;
            }

            if($.trim($('#phone').val()) == ''){
                swal('Please Fill Required Field.');
                return false;
            }
            $('#form').submit();
        }
    </script>

<?php $this->load->view('footer');?>    