<?php $this->load->view('header');?>
    <div class="banner_outer ">
        <div class="container">
            <div class="row">
                <h1 class="text-center text-capitalize">Ready to Live Smarter?</h1>
                <h3 class="text-center text-capitalize">Get instant access to reliable and affordable services</h3>
                <div class="form_outer">
                    <form class="row" id = "formid">
                        <div class="col-md-9">
                            <div class="form-group">
                                <input type="text" id="search-box" class="form-control" placeholder="Search For A Services" autocomplete="off">
                                <div id="suggesstion-box"></div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
                <h4 class="text-capitalize text-center">E.g. Salon at Home, Plumber, Wedding Photographer</h4>
            </div>
        </div>
    </div>
    <section class="service_outer text-center">
        <div class="container">
            <div class="title_bar">
                <h2>Our Trending Services</h2></div>
            <div class="row">
                <?php foreach($services as $row){?>
                    <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
                        <a href="<?php echo site_url('catalog/'.$row['id']);?>" class="service_box">
                            <span class="trending_services"><i class="<?php echo $row['icon'] ;?>" aria-hidden="true"></i></span>
                            <h3><?=($row['title'])?$row['title']:''?></h3>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>

    <section class="pop_category_outer ">
        <div class="container">
            <div class="title_bar text-center">
                <h2>most popular categories</h2></div>
            <div class="row">

                <!-- [id] => 53
            [title] => Apple Watch Repair
            [description] => What Apple Watch model do you need fixed at home or in store?
            [image] => default-category.png
            [icon] => far fa-clock
            [parent_id] => 52
            [level] => 2
            [order_id] => 1
            [status] => 1
            [is_deleted] => 0
            [created_at] => 2019-06-01 15:25:36
            [updated_at] => 2019-05-24 13:11:02 -->

                <?php foreach($category as $row){?>
                <div class="col-md-3 col-sm-6 col-xs-12 pop_category_col">
                    <a href="<?php echo site_url('catalog/'.$row['parent_id'].'/'.$row['id']);?>" class="pop_category_box">
                        <?php if($row['image'] == "default-category.png"){ ?>
                        <img src="https://dummyimage.com/400x250/aaaaaa/ffffff?text=<?php echo $row['title']; ?>">
                        <?php }else{ ?>
                        <img style="height:164px; width:280px;" src="<?php echo base_url('upload/category/').$row['image']; ?>">
                        <?php } ?>
                        <h4 class="text-capitalize"><?php echo $row['title']; ?></h4>
                    </a>
                </div>
                <?php } ?>

            </div>
        </div>
    </section>
    <!-- <section class="services_featured">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <img src="<?php echo base_url('front');?>/images/service/ser17.jpg">
                    <h3>Painting & Renovation Your Home ?</h3>
                    <p>Get inspiration and ideas from 1000+ projects on home renovation and design.</p>
                    <a href="javascript:void(0)">Browse ideas <i class="fa fa-angle-right"></i></a>
                </div>
                <div class="col-md-4">
                    <img src="<?php echo base_url('front');?>/images/service/ser18.jpg">
                    <h3>Beauty & Spa</h3>
                    <p>Get inspiration and ideas from 1000+ projects on home renovation and design.</p>
                    <a href="javascript:void(0)">Browse ideas <i class="fa fa-angle-right"></i></a>
                </div>
                <div class="col-md-4">
                    <img src="<?php echo base_url('front');?>/images/service/ser19.jpg">
                    <h3>Appliance Repair</h3>
                    <p>Get inspiration and ideas from 1000+ projects on home renovation and design.</p>
                    <a href="javascript:void(0)">Browse ideas <i class="fa fa-angle-right"></i></a>
                </div>
            </div>
        </div>
    </section> -->
   <!--<section class="quality_outer">
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
    </section> -->
    <!-- quantity section -->
    <section class="quality_section_wrapper">
        <div class="container">
            <div class="title_bar text-center">
                <h2>Meet The Experts.</h2>
            </div>
            <div class="row">
                <div class="col-md-4 hide_in_desktop text-center">
                    <div class="quality_center_thumb">
                        <img src="<?php echo base_url('front');?>/images/service_thumb_n.png" alt="" class="img-responsive"> 
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="quality_left">  
                        <div class="quality_text_box">
                            <h3>High Quality & Trusted Professionals</h3>
                             <p>We provide only verified, background checked and high quality professionals</p>
                        </div>
                        <div class="quality_text_box">
                            <h3>Matched to Your Needs</h3>
                             <p>We match you with the right professionals with the right budget</p>
                        </div>
                        <div class="quality_text_box">
                            <h3>Dedicated service specialists</h3>
                             <p>Each Khidmat vendor is highly skilled in their own service field. So no matter if it’s cleaning, landscaping, or home repair, you can always count on us to send the right specialist team for the job.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 hide_in_mobile">
                    <div class="quality_center_thumb">
                        <img src="<?php echo base_url('front');?>/images/service_thumb_n.png" alt="" class="img-responsive">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="quality_right">
                        <div class="quality_text_box">
                            <h3>Trained to the Khidmat Services</h3>
                             <p>All professionals undergo specialised training by the Khidmat to meet the Khidmat Services Standard and assure high quality.</p>
                        </div>
                        <div class="quality_text_box">
                            <h3>Using professional grade equipment</h3>
                             <p>All Khidmat experts work with high quality equipment and products by well-known local suppliers to deliver optimal, lasting results for each service performed.</p>
                        </div>
                        <div class="quality_text_box">
                            <h3>Fully insured</h3>
                             <p>Each Khidmat provider carries a public liability insurance of up to £5 million, guaranteeing you a trouble-free experience.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> 
   <!-- quantity section -->
   <!-- mobile app section -->
    <section class="mobileapp_section_wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-1 col-xs-12">
                <div class="row">
                    <div class="col-lg-3 col-sm-4 col-xs-12">
                        <div class="mobile_app_img">
                            <img src="<?php echo base_url('front');?>/images/mobile_app.png" alt="" class="img-responsive">
                        </div>
                    </div>
                    <div class="col-lg-9 col-sm-8 col-xs-12">
                        <div class="mobile_app_text">
                            <h3>Join khidmat With Mobile applications</h3>
                            <ul>
                                <li><i class="far fa-check-circle"></i>You can Download our application from Play Store & App Store.</li>
                                <li><i class="far fa-check-circle"></i>You can Manage Your Dashboard with mobile.</li>
                                <li><i class="far fa-check-circle"></i>Service Provider can add their services easily.</li>
                                <li><i class="far fa-check-circle"></i>Service Providers view their service schedule in their mobile.</li>
                            </ul>
                            <div class="app_part">
                                <h4>Download our app From</h4>
                                <div class="dwld_app_link">
                                    <a href="javascript:void(0)" class="link_btn"><i class="fab fa-google-play"></i>Play store</a>
                                    <a href="javascript:void(0)" class="link_btn"><i class="fab fa-apple"></i>App store</a>
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>
                </div>
            </div>
        </div>
    </section> 
    <!-- mobile app section -->
    <!-- counte section start -->
    <section class="counter_outer text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-3">

                    <h3>
                        <?php echo $countServices?> 
                    </h3>
                    <p>total services</p>
                </div>
                <div class="col-md-3">
                    <h3>
                        <?php echo $countOrders?>   
                    </h3>
                    <p>total orders</p>
                </div>
                <div class="col-md-3">
                    <h3>
                        <?php echo $countCustomers?>  
                    </h3>                    
                    <p>happy coustomers</p>
                </div>
                <div class="col-md-3">
                    <h3>
                        <?php echo $countVendors?> 
                    </h3>
                    <p>verified experties</p>
                </div>
            </div>
        </div>
    </section>
     <!-- counte section End -->
    <div id="location_hide" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">

                <div class="modal-body text-center">
                    <button type="button" class="close" data-dismiss="modal"><i class="fa fa-close"></i></button>
                    <div class="location-pin">
                        <div class='pin'></div>
                        <div class='pulse'></div>
                    </div>
                    <h2>Set Location to view services in your locality !</h2>
                    <p>Allow location access on the next step.</p>
                    <div class="button_panel">
                        <button class="btn btn-primary"> <img src="<?php echo base_url('front');?>/images/location-current.png"> use current location</button>
                        <button class="btn btn-default" data-toggle="modal" data-target="#map_location" id="manually">Enter manually</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="book_now_section">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="book_now_text">
                       <h4>Enjoy a free service please Book now</h4>
                       <div class="booking_btn_section">
                           <a href="<?php echo base_url('catalog/1'); ?>" class="red_button book_btn">Book Now</a>
                           <a href="<?php echo base_url('welcome/contactUs'); ?>" class="red_button book_btn">Request a Quote</a>
                       </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>//search bar ajax
            // AJAX call for autocomplete 
        $(document).ready(function()
        {
            $("#search-box").keyup(function()
            {
                $.ajax({
                type: "POST",
                url: '<?php echo site_url('welcome/search_bar');?>',      
                data:'keyword='+$(this).val(),
                // beforeSend: function(){
                //     $("#search-box").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
                // },
                success: function(data)
                {
                    $("#suggesstion-box").show();
                    $("#suggesstion-box").html(data);
                    $("#search-box").css("background","#FFF");
                }

                });
            });
        });
        //To select country name
        function selectServices(val,id)
         {
            $("#search-box").val(val);
            $("#suggesstion-box").hide();
            $('#formid').attr('action','<?php echo site_url('welcome/services')?>/'+id);
         }
    </script>
    <?php $this->load->view('footer'); ?>