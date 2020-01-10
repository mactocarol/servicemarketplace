<?php $this->load->view('header');?>
<section class="breadcrumb_outer">
	<div class="container">
    	<div class="row">
        	<div class="col-lg-6">
            	<h2 class="text-capitalize">Registration</h2>
            </div>
            <div class="col-lg-6">
            	 <ol class="breadcrumb pull-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Registration</li>
                  </ol>
            </div>
        </div>
    </div>
</section>
<section class="login_outer">
	<div class="container">
    	<div class=" col-md-6 col-md-offset-3">
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
            	<div class="login-header"><h1><i class="fa fa-lock"></i> create an account</h1></div>
                <div class="login-form">
                	<form method="post" id="registerform" action="<?php echo site_url('user/register');?>">
                    	<div class="form-group">
                        	<input type="text" placeholder="UserName" name="username" class="form-control" required>
                        </div>
                        <div class="form-group">
                        	<input type="email" placeholder="Your Email" name="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                        	<input type="password" placeholder="Your Password" name="password" class="form-control" required>
                        </div>
                        <div class="form-group">
                        	<input type="password" placeholder="Your Confirm Password" name="confirm_password" class="form-control" required>
                        </div>
                        <div class="form-group">
                        	<div class="row">
                            	<div class="col-md-12">
                                 <div class="form-user">
                                        <input class="form-check-input" type="radio" id="user" name="user" value="seller">
                                        <label class="form-check-label" for="user">Seller</label>
                                    </div>
                                     <div class="form-user">
                                        <input class="form-check-input" type="radio" id="buyer" name="user" value="buyer" checked>
                                        <label class="form-check-label" for="buyer">Buyer</label>
                                    </div>
                             </div>
                             </div>
                        </div>
                        <div class="row">
                        	<div class="col-md-8"><div class="form-groupcheckbox">
                                <div class="form-group">
                                    <input class="form-check-input" type="radio" id="terms" name="terms" >
                                    <label class="form-check-label" for="terms">
                                        I Agree <a href="#">Terms and Condition</a>
                                    </label>
                                </div>
                            </div></div>
                            <div class="col-md-4"><button type="submit" class="btn btn-primary pull-right">Register</button></div>
                        </div>
                        <div class="row">
                        	<h3>already have account? <a href="<?php echo site_url('user')?>">Login</a></h3>
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
 
<section class="quality_outer">
    <div class="container">
        <div class="row">
        	<div class="col-md-4">
            	<div class="quality_inner">
                	<i class="fa fa-shield"></i>
                	<h3>High Quality & Trusted Professionals</h3>
                    <p>We provide only verified, background checked and high quality professionals</p>
                </div>
            </div>
            <div class="col-md-4">
            	<div class="quality_inner">
                	<i class="fa fa-user"></i>
                	<h3>Matched to Your Needs</h3>
                    <p>We match you with the right professionals with the right budget</p>
                </div>
            </div>
            <div class="col-md-4">
            	<div class="quality_inner">
                	<i class="fa fa-thumbs-up"></i>
                	<h3>Hassle Free Service Delivery</h3>
                    <p>Super convenient, guaranteed service from booking to delivery</p>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="counter_outer text-center">
    <div class="container">
        <div class="row">
        	<div class="col-md-3">
            	<h3>254</h3>
                	<p>total services</p>
            </div>
            <div class="col-md-3">
            	<h3>172</h3>
                	<p>won awards</p>
            </div>
            <div class="col-md-3">
            	<h3>12168</h3>
                	<p>happy coustomer every year</p>
            </div>
            <div class="col-md-3">
            	<h3>254</h3>
                	<p>verified experties</p>
            </div>
		</div>
    </div>
</section>


<script src="https://apis.google.com/js/platform.js" async defer></script>
<meta name="google-signin-client_id" content="611631231591-lh1g9i6u5jlnfuv02fmfhl7ls4thuo6h.apps.googleusercontent.com">
<script src="https://apis.google.com/js/api:client.js"></script>
<script src="<?php echo base_url('js/social_login.js'); ?>"></script>


<script src="<?php echo base_url('front/js');?>/bootstrapValidator.min.js"></script>
<script>
    $(document).ready(function() {
	//alert('http://localhost/caroldata.com/hmvc_hotel_booking/registration/register_email_exists');
    $('#registerform').bootstrapValidator({
        //container: '#messages',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            username: {
                validators: {
					notEmpty: {
						message : 'The Username Field is required'
					},
					 remote: {  
					 type: 'POST',
					 url: "<?php echo site_url();?>user/check_username_exists",
					 data: function(validator) {
						 return {
							 //email: $('#email').val()
							 email: validator.getFieldElements('username').val()
							 };
						},
					 message: 'This Username is already in use.'     
					 },
                     callback: {
                        message: 'please enter only letters and numbers',
                        callback: function(value, validator, $field) {
                            if (!isUsernameValid(value)) {
                              return {
                                valid: false,
                              };
                            }
                            else
                            {
                              return {
                                valid: true,
                              };    
                            }

                        }
                    },
                    stringLength: {
						min: 3 ,
						max: 15,
						message: 'The Username length min 3 and max 15 character Long'
					}
				},
			},
            f_name: {
                validators: {
                    notEmpty: {
                        message: 'The First Name is required'
                    },
                }
            },
			contact: {
                validators: {
                    notEmpty: {
                        message: 'The Contact is required'
                    },
                }
            },
            
            //dob: {
            //    validators: {
            //        notEmpty: {
            //            message: 'The Date Of Birth is required and cannot be empty'
            //        },
            //    }
            //},
            terms: {
                validators: {
                    notEmpty: {
                        message: 'Please accept terms & conditions'
                    },
                }
            },
			email: {
                validators: {
					notEmpty: {
						message : 'The email Field is required'
					},
					 remote: {  
					 type: 'POST',
					 url: "<?php echo site_url();?>user/check_email_exists",
					 data: function(validator) {
						 return {
							 //email: $('#email').val()
							 email: validator.getFieldElements('email').val()
							 };
						},
					 message: 'This email is already in use.'     
					 }
				},
			},    
			
			password: {
				validators: {
                    notEmpty: {
						message : 'The password Field is required'
					},
					identical: {
                        field: 'repassword',
                        message: 'The password and its confirm are not the same'
                    },
					stringLength: {
						min: 6 ,
						max: 15,
						message: 'The password length min 6 and max 15 character Long'
					}
				}
			},
			confirm_password: {
				validators: {
                    notEmpty: {
						message : 'The password Field is required'
					},
					identical: {
                        field: 'password',
                        message: 'The password and its confirm are not the same'
                    }
					
				}
			},
        }
    });

});
    
function isUsernameValid(value)
{
  var fieldNum = /^[a-z0-9]+$/i;

  if ((value.match(fieldNum))) {
      return true
  }
  else
  {
      return false
  }

}
</script>
<?php $this->load->view('footer');?>