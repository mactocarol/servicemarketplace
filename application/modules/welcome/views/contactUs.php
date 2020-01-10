<?php $this->load->view('header');?>
<section class="breadcrumb_outer">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h2 class="text-capitalize">contact</h2>
            </div>
            <div class="col-lg-6">
                 <ol class="breadcrumb pull-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">contact</li>
                  </ol>
            </div>
        </div>
    </div>
</section> 
<!-- contact Section -->
<div class="section contact_wrapper pad_top_50">
    <div class="container">
        <!-- row start -->
        <div class="row">
            <div class="col-lg-6">


                <?php
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
                
                <div class="contact_heading">
                    <h2>Send Message</h2>
                </div>
                <div class="contact_form">
                    <form method="post" action="<?php echo site_url('welcome/contactUs');?>">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form_group">
                                    <label>Username</label>
                                    <div class="input_group">
                                        <input type="text" name="uname" placeholder="Username" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form_group">
                                    <label>Email</label>
                                    <div class="input_group">
                                        <input type="email" name="uemail" placeholder="Email" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form_group">
                                    <label>Phone</label>
                                    <div class="input_group">
                                        <input type="text" name="Phone" placeholder="Phone" required>
                                    </div> 
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form_group">
                                    <label>subject</label>
                                    <div class="input_group">
                                        <input type="text" name="subject" placeholder="Subject" required>
                                    </div> 
                                </div>
                            </div>
                        </div>
                        <div class="form_group">
                            <label>Message</label>
                            <div class="input_group">
                                <textarea placeholder="Enter Your Problem.." name="message" required></textarea>
                            </div> 
                        </div>
                        <input type="submit" value="Submit" class="red_button contact_btn">
                    </form>
                </div>
            </div>
             <div class="col-lg-6">
                <div class="contact_heading">
                    <h2>Get In touch</h2>
                </div>
                <div class="address_bar">
                    <div class="adress_list">
                        <span class="address_icon"><i class="fas fa-map-marker-alt"></i></span>
                        <div class="address_text">
                            <h5>Address</h5>
                            <p>Flat 57k Campbell Fall, Zachberg, BN6 8DA</p>
                        </div>
                    </div>
                    <div class="adress_list">
                        <span class="address_icon"><i class="fa fa-phone"></i></span>
                        <div class="address_text">
                            <h5>Phone</h5>
                            <p>9912345625</p>
                        </div>
                    </div>
                    <div class="adress_list">
                        <span class="address_icon"><i class="fa fa-envelope"></i></span>
                        <div class="address_text">
                            <h5>Email</h5>
                            <p><a href="mailto:tutor@gmail.com" class="dis_none">khidmat@gmail.com</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- contact Banner Section -->
<?php $this->load->view('footer'); ?>