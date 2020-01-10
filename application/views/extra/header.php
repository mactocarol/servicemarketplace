<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<meta name="description" content="">
<meta name="author" content="">
<link rel="icon" href="../../favicon.ico">
<title>khidmat</title>
<link href="<?php echo base_url('/front/css/font-awesome.min.css');?>" rel="stylesheet">
<link href="<?php echo base_url('/front/css/bootstrap.min.css');?>" rel="stylesheet">
<link href="<?php echo base_url('/front/fonts/axiforma/font.css');?>" rel="stylesheet">
<link rel="stylesheet" href="<?php echo base_url('/front/css/owl.carousel.min.css');?>">
<link rel="stylesheet" href="<?php echo base_url('front');?>/css/bootstrap-select.min.css" />
<link rel="stylesheet" href="<?php echo base_url('front');?>/js/plugins/jqueryui/jquery-ui.css">


<link rel="stylesheet" href="<?php echo base_url('front');?>/js/plugins/calendar/monthly.css">

<link href="<?php echo base_url('/front/css/style.css');?>" rel="stylesheet">
<link href="<?php echo base_url('/front/css/custom.css');?>" rel="stylesheet">
<link href="<?php echo base_url('/front/css/responsive.css');?>" rel="stylesheet">

<script src="<?php echo base_url('front');?>/js/jquery.min.js"></script>
<script src="<?php echo base_url('front');?>/js/bootstrap.min.js"></script>
<script src="<?php echo base_url('front');?>/js/plugins/jqueryui/jquery-ui.js"></script>
<script>
$( function() {
	$( "#slider-range" ).slider({
		range: true,
		min: 0,
		max: 500,
		values: [ 75, 300 ],
		slide: function( event, ui ) {
			$( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
		}
	});
	$( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) +
		" - $" + $( "#slider-range" ).slider( "values", 1 ) );
} );
</script>

<script src="<?php echo base_url('front');?>/js/bootstrap.min.js"></script>
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body>
<!-- header Start -->
<header class="main_header user_header">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-xs-12">
                <div class="site_logo">
                    <a href="<?php echo site_url();?>"><img src="<?php echo base_url('front');?>/images/logo.png"></a>
                </div>
                <button type="button" class="navbar_toggle">
                  Menu  
                </button>
            </div>
            <div class="col-md-9 col-xs-12">
                <nav class="navigation_wrap pull-right">
                  <div class="navigation_menu">
                    <ul class="">
                        <?php 
                            $user_id = $this->session->userdata('user_id');
                            $userDetail = get_user($user_id); 
                        ?>
                        
                        <?php if($userDetail && $userDetail->user_type == '2'){ ?>
                            <li><a href="<?php echo site_url('user/vendor_services');?>">My Services </a></li>
                        <?php }else{ ?>
                            <li><a href="<?php echo site_url('catalog/1');?>">Services </a></li>
                        <?php } ?>

                        <li><a href="<?php echo site_url('welcome/contactUs');?>">Help </a></li>
                        <li><a href="<?php echo site_url('blog');?>">blog</a></li>
                       
                        <?php if($user_id){ ?>
                                

                                <li class="icon">
                                    <a href="<?php echo site_url('chat'); ?>">
                                      <img src="<?php echo base_url('front/'); ?>images/message.png">
                                      <span style="display: none;" id="msgCount" class="badge-1"></span>
                                    </a>
                                </li>


                                <li class="icon">
                                    <?php $notify = get_notifications($user_id); ?>
                                    <a href="javascript:void(0)">
                                      <img src="<?php echo base_url('front/'); ?>images/notification.png">
                                        <?php 
                                        $count = isset(array_count_values(array_column($notify, 'is_read'))['0']) ? array_count_values(array_column($notify, 'is_read'))['0'] : '0'; 
                                        ?>
                                        <?php if($count){ ?>
                                            <span id="notifyCount" class="badge-1"><?php echo $count; ?></span>
                                        <?php } ?>
                                    </a>
                                     <ul class="submenu noti_submenu">
                                        <div class="noti_menu_text">
                                            Notification(<?php echo count($notify); ?>)
                                        </div>
                                        <?php foreach($notify as $oneNotify){ ?>
                                        <?php
                                            $url = "javascript:void(0)";
                                            if($oneNotify['notification_connection_type'] == 'order'){
                                                $url = site_url('user/orderDetail/'.base64_encode($oneNotify['notification_connection_id']));
                                            }
                                        ?>
                                        <li>
                                            <a href="<?php echo $url; ?>">
                                             <span class="noti_icon">
                                                 <i class="fas fa-shopping-cart"></i>
                                             </span>
                                             <div class="menu_noti_txt">
                                                 <h5><?php echo strtoupper($oneNotify['notification_connection_type']); ?></h5>
                                                 <p><?php echo $oneNotify['notification_msg']; ?></p>
                                             </div>
                                            </a>
                                        </li>
                                        <?php } ?>
                                        <?php if(empty($notify)){ ?>
                                            <p>No Notification yet</p>
                                        <?php } ?>

                                    </ul>
                                </li>
                            <?php if($userDetail->user_type == '2'){ ?>
                                <li><a href="<?php echo site_url('dashboard');?>">Dashboard</a></li>
                            <?php }else{ ?>
                                
                            <?php } ?>

                            <!-- <li><a href="<?php echo site_url('dashboard');?>">Dashboard</a></li> -->
                            <li class="login-btn">
                                <a href="javascript:void(0)">
                                    <span class="u_img">
                                        <?php if($userDetail->social_type){?>
                                            <img src="<?php echo $userDetail->image;?>" class="img-fluid" alt="User Thumb">
                                        <?php } else { ?>
                                            <img src="<?php echo base_url('upload/profile_image/'.$userDetail->image);?>" class="img-fluid" alt="User Thumb">
                                        <?php } ?>
                                    </span>
                                    <?php echo $userDetail->f_name; ?>
                                </a>
                                <ul class="submenu">
                                    <li>
                                        <a href="<?php echo site_url('user/dashboard');?>">
                                            <i class="fas fa-clipboard-list"></i>
                                            My Orders
                                        </a>
                                    </li>
                                    
                                    <li>
                                        <a href="<?php echo site_url('user/profile');?>">
                                            <i class="fas fa-user"></i>
                                            My Account
                                        </a>
                                    </li>

                                    <li class="logout_btn">
                                        <a href="<?php echo site_url('user/logout');?>">
                                            <i class="fas fa-sign-out-alt"></i>
                                            logout
                                        </a>
                                    </li>
                                </ul>
                            </li>

                        <?php } else { ?>

                            <li class="login-btn">
                                <a href="<?php echo site_url('user');?>">
                                    <span class="u_img">
                                        <img src="https://cdn2.iconfinder.com/data/icons/weby-flat-vol-1/512/1_key-danger-hack-private-protect-security_issue-512.png" class="img-fluid" alt="User Thumb">
                                    </span>
                                    login / signup
                                </a>
                            </li>

                        <?php } ?>

                    </ul>
                  </div><!--/.nav-collapse -->
              </nav>
            </div>
        </div>
    </div>
</header>
<!-- header End -->

<!--Firebase chat conf.-->
<script src="https://www.gstatic.com/firebasejs/5.0.4/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/5.0.4/firebase-auth.js"></script>
<script src="https://www.gstatic.com/firebasejs/5.0.4/firebase-database.js"></script>
<script src="https://www.gstatic.com/firebasejs/5.0.4/firebase-storage.js"></script>
<script src="https://www.gstatic.com/firebasejs/5.0.4/firebase-messaging.js"></script>
<script src="https://www.gstatic.com/firebasejs/5.0.4/firebase-functions.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script>
    var firebaseConfig = {
        apiKey: "AIzaSyDK0Od5d-KORjXsaw6xpZlb6e_jbx7ocEA",
        authDomain: "khidmat-3ecc6.firebaseapp.com",
        databaseURL: "https://khidmat-3ecc6.firebaseio.com",
        projectId: "khidmat-3ecc6",
        storageBucket: "khidmat-3ecc6.appspot.com",
        messagingSenderId: "740228995285",
        appId: "1:740228995285:web:f7b78de99163a1d3"
    };
    firebase.initializeApp(firebaseConfig);
</script>
<!--Firebase chat conf.-->
<?php $user_id = $this->session->userdata('user_id'); $userDetail = get_user($user_id); ?>
<?php if($user_id){ ?>
    <script type="text/javascript">
        firebase.database().ref().child('users/').child(<?php echo $user_id; ?>).set(<?php echo json_encode($userDetail); ?>);
        var userRef = firebase.database().ref('online/' + '<?php echo $user_id; ?>');
        connectedRef = firebase.database().ref('.info/connected');
        connectedRef.on('value', function(snap) {
            if (snap.val()) {
                userRef.onDisconnect().set('Last Seen : '+moment($.now()).format('MMMM D, YYYY h:m A'));
                userRef.set('online');
            }
        });
        
        var countMsg = localStorage.getItem('countMsg');
        if(countMsg != null){
            $('#msgCount').show();
            $('#msgCount').html(countMsg);
        }else{
            $('#msgCount').hide();
        }
        firebase.database().ref("history").child(<?php echo $user_id; ?>).once('value', function(history){
            var history = history.val();
            var i = 0;
            $.each(history, function( key, value ) {
                if(typeof value != 'undefined'){
                    if(typeof value.senderId != 'undefined'){
                        i = i + value.unread;
                        localStorage.setItem('countMsg',i);
                        if(i != 0){
                            $('#msgCount').show();
                            $('#msgCount').html(i);
                        }else{
                            $('#msgCount').hide();
                            localStorage.removeItem('countMsg');
                        }
                    }
                }
            });
        });

    </script>
<?php } ?>