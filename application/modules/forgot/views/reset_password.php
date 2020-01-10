<?php $this->load->view('header');?>
    <!-- breadcrumb Start -->
<section class="breadcrumb_outer">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h2 class="text-capitalize">Forget Password</h2>
            </div>
            <div class="col-lg-6">
                <ol class="breadcrumb pull-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Forget Password</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<!-- breadcrumb End -->
<section class="login_outer">
    
    <div class="container">
        <div class="col-md-6 col-md-offset-3">
            <?php
            // display error & success messages
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
            <div class="login-inner">
                <div class="login-header">
                    <h1><i class="fa fa-lock"></i>Reset your password</h1></div>
                <div class="login-form">
                    <form method="post" action="<?php echo site_url('forgot/reset_password'); ?>">
                        <div class="form-group">
                            <input type="password" name="password" placeholder="Your Password" class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="password" name="cpassword" placeholder="Your Password" class="form-control">
                        </div>
                        <input type="hidden" name="key" value="<?php echo $key; ?>">
                        <div class="row">                            
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-secondry pull-left">Reset</button>
                            </div>
                        </div>
                        
                        <div class="row">
                            <h3><a href="<?php echo site_url('user'); ?>">Signin</a></h3>
                        </div>
                    </form>
                </div>
                <div class="another-login text-center col-md-12">
                    <div class="row">
                        <div class="col-md-6 facebook">
                            <div id="loginBtn" class="social-login"><a href="javascript:void(0)"><i class="fab fa-facebook-f"></i> Facebook </a></div>
                        </div>
                        <div class="col-md-6 google">
                            <div id="customBtn" class="social-login"><a href="javascript:void(0)"><i class="fab fa-google"></i> Google </a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://apis.google.com/js/platform.js" async defer></script>
<meta name="google-signin-client_id" content="611631231591-lh1g9i6u5jlnfuv02fmfhl7ls4thuo6h.apps.googleusercontent.com">
<script src="https://apis.google.com/js/api:client.js"></script>
<script src="<?php echo base_url('js/social_login.js'); ?>"></script>

<?php $this->load->view('footer');?>



