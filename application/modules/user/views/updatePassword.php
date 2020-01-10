<?php $this->load->view('header');?>
<style type="text/css">
    .err{
        color: red;
    }
</style>
    <!-- breadcrumb Start -->
<section class="breadcrumb_outer">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h2 class="text-capitalize">Change Password</h2>
            </div>
            <div class="col-lg-6">
                
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
                    <h1><i class="fa fa-lock"></i>Update Password</h1></div>
                <div class="login-form">
                    <form id="target" method="post" action="<?php echo site_url('user/updatePassword');?>">
                        <div class="form-group">
                            <input type="hidden" name="id" value="<?php echo $userDetail->id; ?>" placeholder="New Password" class="form-control" required="" >
                        </div>

                        <div class="form-group">
                            <input type="text" id="nPassword" name="nPassword" placeholder="New Password" class="form-control" required="">
                            <p id="nPasswordErr" class="err"></p>
                        </div>

                        <div class="form-group">
                            <input type="text" id="cPassword"  name="cPassword" placeholder="Confirm Password" class="form-control" required="">
                            <p id="cPasswordErr" class="err"></p>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6"></div>
                            <div class="col-md-6">
                                <button id="submitBtn" type="button" class="btn btn-secondry pull-right">Update</button>
                            </div>
                        </div>
                        
                    </form>
                </div>
                
            </div>
        </div>
    </div>
</section>
<?php $this->load->view('footer');?> 

<script type="text/javascript">
    $('#submitBtn').click(function(){
        
        $('.err').html('');
        var check = true;
        var nPassword = $.trim($('#nPassword').val());
        var cPassword = $.trim($('#cPassword').val());

        if(nPassword == ''){
            $('#nPasswordErr').html('Please fill required field');
            check = false;
        }else{
            if(nPassword.length < 6){
                $('#nPasswordErr').html('Password must be of minimum 6 characters length');
                check = false;
            }

            if(nPassword != cPassword){
                $('#cPasswordErr').html('Password and confirm password does not match');
                check = false;
            }

        }
        if(check == true){
            $( "#target" ).submit(); 
        }
    })
</script>  