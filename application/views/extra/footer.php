<!-- footer section Start -->

    <section class="footer_links">

       <div class="container">

           <div class="row">

                <div class="col-md-3 col-sm-6 col-xs-12">

                    <div class="footer_widget add_widget">

                        <h3 class="widget_title">Find Us</h3>

                        <div class="widget_text">

                            <p>2307 Beverley Rd Brooklyn, Dubai - United Arab Emirates </p>

                            <p>Open Monday to Saturday From 7h to 18h or talk to an expert 0712-0610-3314 – available 24/7 </p>

                        </div>

                    </div>

                </div>



                <!-- <?php if($userDetail->user_type == '2'){ ?>

                    <li><a href="<?php echo site_url('user/vendor_services');?>">My Services </a></li>

                <?php }else{ ?>

                    <li><a href="<?php echo site_url('catalog/1');?>">Services </a></li>

                <?php } ?> -->

                

                <?php 

                    $user_id = $this->session->userdata('user_id');

                    $userDetail = get_user($user_id); 

                ?>



                <div class="col-md-3 col-sm-6 col-xs-12">

                    <div class="footer_widget">

                        <h3 class="widget_title">Customers</h3>

                        <div class="footer_menu">

                            <ul>



                                <?php if($userDetail && $userDetail->user_type == '1'){ ?>

                                    <li><a href="<?php echo site_url('user/dashboard');?>">My service requests</a></li>

                                <?php }else{ ?>

                                    <li><a href="<?php echo base_url(); ?>">My service requests</a></li>

                                <?php } ?>



                                <li><a href="<?php echo site_url('blog');?>">Blog</a></li>

                                

                                <!-- <li>

                                    <a href="#">My service requests</a>

                                </li> -->

                                <!-- <li>

                                    <a href="#"></a>

                                </li>

                                <li>

                                    <a href="#">How it works?</a>

                                </li> -->

                            </ul>

                        </div>

                    </div>

                </div>

                <div class="col-md-3 col-sm-6 col-xs-12">

                    <div class="footer_widget">

                        <h3 class="widget_title">Provider</h3>

                        <div class="footer_menu">

                            <ul>

                                <!-- <li>

                                    <a href="#">Provider's Dashboard</a>

                                </li> -->



                                <?php if($userDetail && $userDetail->user_type == '2'){ ?>

                                    <li><a href="<?php echo site_url('dashboard');?>">Provider's Dashboard</a></li>

                                <?php }else{ ?>

                                    <li><a href="<?php echo base_url(); ?>">Provider's Dashboard</a></li>

                                <?php } ?>



                                <li><a href="<?php echo site_url('blog');?>">Blog</a></li>

                               <!--  <li>

                                    <a href="#">Become a service provider</a>

                                </li>

                                <li>

                                    <a href="#">Why join helpbit</a>

                                </li> -->

                            </ul>

                        </div>

                    </div>

                </div>



                 <div class="col-md-3 col-sm-6 col-xs-12">

                    <div class="footer_widget">

                        <h3 class="widget_title">Services</h3>

                        <div class="footer_menu">

                            <ul>

                                <?php $services = get_footer_list(); ?>

                                <?php foreach($services as $oneRow){ ?>

                                <li>

                                    <a href="<?php echo base_url('catalog/').$oneRow['id']; ?>"><?php echo $oneRow['title']; ?></a>

                                </li>

                                <?php } ?>

                                

                            </ul>

                        </div>

                    </div>

                </div>

           </div>

       </div>

    </section>

<footer class="footer_bottom">

        <div class="container">

            <div class="footer_bottom_inr">

                <div class="row">

                    <div class="col-md-4">

                        <div class="footer_logo">

                            <a href="#"><img src="<?php echo base_url('front');?>/images/logo-footer.png" width="200"></a>

                        </div>

                    </div>

                    <div class="col-md-4">

                        <div class="copyright_txt">

                            <p>&copy; Copyright 2019. All Rights Reserved.</p>

                        </div>

                    </div>

                    <div class="col-md-4">

                        <div class="social_icon">

                            <ul>

                                <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>

                                <li><a href="#"><i class="fab fa-twitter"></i></a></li>

                                <li><a href="#"><i class="fab fa-linkedin"></i></a></li>

                                <li><a href="#"><i class="fab fa-youtube"></i></a></li>

                                <li><a href="#"><i class="fab fa-google"></i></a></li>

                            </ul>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </footer>



    



    <div id="map_location" class="modal fade" role="dialog">

        <div class="modal-dialog modal-lg">

            <!-- Modal content-->

            <div class="modal-content">



                <div class="modal-body text-center">

                    <button type="button" class="close" data-dismiss="modal"><i class="fas fa-times"></i></button>

                    <div class="map_location">

                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d24433.023023143018!2d54.37932032304359!3d24.451111350665986!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e5e440f723ef2b9%3A0xc7cc2e9341971108!2sAbu+Dhabi+-+United+Arab+Emirates!5e0!3m2!1sen!2sin!4v1548838726553" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>



                        <div class="maplocation_content">

                            <form>

                                <div class="form-group">

                                    <div class="search_location">

                                        <input type="text" name="search" placeholder="Your Location: Eg:- Jaya Nagar,Bangalore..." class="form-control"> <i class="fa fa-search"></i></div>

                                </div>

                                <div class="form-group">

                                    <div class="button_panel">

                                        <button class="btn btn-primary"> <img src="<?php echo base_url('front');?>/images/location-current.png"> use current location</button>

                                    </div>

                                </div>

                                <div class="button_panel action_button">

                                    <button class="btn btn-primary"> Set location</button>

                                    <button class="btn btn-default" class="close" data-dismiss="modal">cancel</button>

                                </div>

                            </form>

                        </div>



                    </div>

                </div>



            </div>



        </div>

    </div>



</body>





<script src="<?php echo base_url('front');?>/js/owl.carousel.js"></script>

<script src="<?php echo base_url('front');?>/js/bootstrap-select.min.js"></script>

<script src="<?php echo base_url('front');?>/js/custom.js"></script>



<script src="<?php echo base_url('front');?>/js/plugins/calendar/monthly.js"></script>



<script>

    $(document).ready(function() {

        $('.owl-carousel').owlCarousel({

            loop: true,

            margin: 10,

            responsiveClass: true,

            responsive: {

                0: {

                    items: 1,

                    nav: true

                },

                600: {

                    items: 3,

                    nav: true

                },

                1000: {

                    items: 4,

                    nav: true,

                    loop: false,

                    margin: 20

                }

            }

        })

    })

</script>

<script src="<?php echo base_url('front');?>/js/easyResponsiveTabs.js"></script>

<script type="text/javascript">

    $(document).ready(function() {

        //Horizontal Tab

        $('#parentHorizontalTab').easyResponsiveTabs({

            type: 'default', //Types: default, vertical, accordion

            width: 'auto', //auto or any width like 600px

            fit: true, // 100% fit in a container

            tabidentify: 'hor_1', // The tab groups identifier

            activate: function(event) { // Callback function if tab is switched

                var $tab = $(this);

                var $info = $('#nested-tabInfo');

                var $name = $('span', $info);

                $name.text($tab.text());

                $info.show();

            }

        });



    });

</script>

<script type="text/javascript" src="<?php echo base_url('front');?>/js/typeahead.bundle.js"></script>

<script type="text/javascript">

    $(document).ready(function() {

        // Defining the local dataset

        var cars = ['Abu Dhabi  ', 'Aden', '    Doha', '    Dubai', '   Hawalli', 'Jeddah', 'Sharjah', 'Dammam', 'Riyadh', '    Mecca'];



        // Constructing the suggestion engine

        var cars = new Bloodhound({

            datumTokenizer: Bloodhound.tokenizers.whitespace,

            queryTokenizer: Bloodhound.tokenizers.whitespace,

            local: cars

        });



        // Initializing the typeahead

        $('.typeahead').typeahead({

            hint: true,

            highlight: true,

            /* Enable substring highlighting */

            minLength: 1 /* Specify minimum characters required for showing result */

        }, {

            name: 'cars',

            source: cars

        });

    });

</script>

<script>

$(document).ready(function(){        

   $('#manually').click(function(){        

   			$('#location').modal('hide');

    }); 

    }); 

</script>

<script>

$(document).ready(function(){

  $(".filter_section h4").click(function(){

    $(this).next(".form_panel").slideToggle();

	  $(this).find("i").toggleClass("fa-plus");

  });

});

</script>

</html>