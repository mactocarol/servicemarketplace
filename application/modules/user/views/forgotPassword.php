<?php $this->load->view('header');?>
    <!-- breadcrumb Start -->
<section class="breadcrumb_outer">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h2 class="text-capitalize">Forgot Password</h2>
            </div>
            <div class="col-lg-6">
                <!-- <ol class="breadcrumb pull-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Login</li>
                </ol> -->
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
                    <h1><i class="fa fa-lock"></i>Forgot Password Using Your Email</h1></div>
                <div class="login-form">
                    <form method="post" action="<?php echo site_url('user/forgotPassword');?>">
                        <div class="form-group">
                            <input type="email" name="email" placeholder="Your Email" class="form-control" required="">
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6"></div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-secondry pull-right">Send</button>
                            </div>
                        </div>
                        
                    </form>
                </div>
                
            </div>
        </div>
    </div>
</section>
<?php $this->load->view('footer');?>    