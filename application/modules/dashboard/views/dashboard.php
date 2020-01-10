<?php $this->load->view('header');?>
<!-- breadcrumb Start -->
<section class="breadcrumb_outer">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h2 class="text-capitalize">Dashboard</h2>
            </div>
            <div class="col-lg-6">
                 <ol class="breadcrumb pull-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                  </ol>
            </div>
        </div>
    </div>
</section>



<div class="dashboard_cotent_part">
    <!-- message boxes cover start -->
    <div class="message_box_cover">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <a href="dashboard/addPromo">
                        <button type="button" name="" class="red_button submit_btn">Add Promo Card</button>
                    </a> 
                </div>

                <div class="col-lg-3 col-md-6 col-sm-12">
                    <a href="dashboard/addBank">
                        <button type="button" name="" class="red_button submit_btn">
                        <?php echo ($acc) ? 'Update Bank Acc.' :'Add Bank Acc.'; ?>
                        </button>
                    </a> 
                </div>

                <?php if($acc){ ?>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <a href="dashboard/withdrawAmount">
                        <button type="button" name="" class="red_button submit_btn">
                        Withdraw Amount
                        </button>
                    </a> 
                </div>
            <?php } ?>

            </div>
        </div>
    </div>
</div>


<!-- breadcrumb End -->
<!-- dashboard content part -->
<div class="dashboard_cotent_part">
    <!-- message boxes cover start -->
    <div class="message_box_cover">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-12">
                    
                    <div class="message_box">
                        <div class="msg_head">
                            <h4>New Message</h4>
                            <span class="msg_icon">
                                <i class="fa fa-envelope"></i>
                            </span>
                        </div>
                        <div class="msg_body">
                            <div class="counter_msg">
                                <span id="dMsgCount" >00</span>
                                <p>New Message</p>
                            </div>
                            <div class="msg_footer">
                                <a href="<?php echo site_url('chat'); ?>" class="view_link">
                                    View Details
                                    <i class="fa fa-chevron-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <script type="text/javascript">
                        $(document).ready(function() { 
                            $('#dMsgCount').html( ($('#msgCount').html()) ? $('#msgCount').html() : '00' );
                        }); 
                    </script>
                </div>

                <?php
                    $user_id = $this->session->userdata('user_id');
                    $count =  get_review_count($user_id);
                ?>

                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="message_box">
                        <div class="msg_head">
                            <h4>Reviews</h4>
                            <span class="msg_icon">
                                <i class="fa fa-star"></i>
                            </span>
                        </div>
                        <div class="msg_body">
                            <div class="counter_msg">
                                <span><?php echo ($count) ? $count : '00'; ?></span>
                                <p>New Reviews</p>
                            </div>
                            <div class="msg_footer">
                                <a href="<?php echo site_url('dashboard/reviewList');?>" class="view_link">
                                    View Details
                                    <i class="fa fa-chevron-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div> 
                <?php
                    $user_id = $this->session->userdata('user_id');
                    $count =  get_request_count($user_id);
                ?>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="message_box">
                        <div class="msg_head">
                            <h4>New Request</h4>
                            <span class="msg_icon">
                                <i class="fas fa-user-clock"></i>
                            </span>
                        </div>
                        <div class="msg_body">
                            <div class="counter_msg">
                                <span><?php echo ($count) ? $count : '00'; ?></span>
                                <p>New Request</p>
                            </div>
                            <div class="msg_footer">
                                <a href="<?php echo site_url('user/dashboard');?>" class="view_link">
                                    View Details
                                    <i class="fa fa-chevron-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="message_box">
                        <div class="msg_head">
                            <h4>New Notification</h4>
                            <span class="msg_icon">
                                <i class="fa fa-bell"></i>
                            </span>
                        </div>
                        <div class="msg_body">
                            <div class="counter_msg">
                                <span id="dNotifyCount" >00</span>
                                <p>New Notification</p>
                            </div>
                            <div class="msg_footer">
                                <a onclick="$('#notifyCount').click();" href="#" class="view_link">
                                    View Details
                                    <i class="fa fa-chevron-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <script type="text/javascript">
                    $(document).ready(function() { 
                        $('#dNotifyCount').html( ($('#notifyCount').html()) ? $('#notifyCount').html() : '00' );
                    }); 
                </script>
            </div>
        </div>
    </div>
    <!-- message boxes cover end -->
    <!-- Activity wrapper start -->
    <!-- <div class="activity_wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="activity_box">
                        <div class="activity_box_head">
                          <h4>Recent activity</h4>
                        </div>
                        <div class="activity_box_body">
                            <ul class="activity_lists">
                                <li>
                                    <span class="left_sch_date">
                                        2 Hour ago
                                    </span>
                                    <div class="schedule_text">
                                        <p>
                                            Request a new services in <span>Laptop Repair</span> From Mobile
                                        </p>
                                    </div>
                                </li>
                                <li>
                                    <span class="left_sch_date">
                                        15 Oct
                                    </span>
                                    <div class="schedule_text">
                                        <p>
                                           Make Deposit USD 700 To ESL. 
                                        </p>
                                    </div>
                                </li> 
                                <li>
                                    <span class="left_sch_date">
                                        13 Oct
                                    </span>
                                    <div class="schedule_text">
                                        <p>
                                           Request a new services in <span>Mobile Repair</span> From Mobile
                                        </p>
                                    </div>
                                </li>
                                <li>
                                    <span class="left_sch_date">
                                        13 Oct
                                    </span>
                                    <div class="schedule_text">
                                        <p>
                                           Make Deposit USD 700 To ESL. 
                                        </p>
                                    </div>
                                </li>
                                <li>
                                    <span class="left_sch_date">
                                        20 Oct
                                    </span>
                                    <div class="schedule_text">
                                        <p>
                                           Request a new services in <span>AC Repair</span> From Mobile
                                        </p>
                                    </div>
                                </li>
                                <li>
                                    <span class="left_sch_date">
                                        20 Oct
                                    </span>
                                    <div class="schedule_text">
                                        <p>
                                           Make Deposit USD 700 To ESL. 
                                        </p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="activity_box">
                        <div class="activity_box_head">
                          <h4>Calendar</h4>
                        </div>
                        <div class="activity_box_body">
                            <div class="schedule_calendar">
                                <div class="datepicker"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <!-- Activity wrapper end -->
</div>

<?php $this->load->view('footer'); ?>