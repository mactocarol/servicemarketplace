<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">      
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo base_url(); ?>upload/profile_image/thumb/<?=$result->image?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>Email</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li <?php if(isset($page) && $page == 'dashboard') { echo 'class="active"'; }?>>
          <a href="<?php echo site_url('admin/dashboard');?>">
            <i class="fa fa-edit"></i> <span>Dashboard</span>            
          </a>          
        </li>
        <li class="treeview <?php if(isset($page) && $page == 'profile' || $page == 'upload_image') { echo 'menu-open'; }?> ">
        <a href="#">
          <i class="fa fa-edit"></i> <span>Profile</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu" style="<?php if(isset($page) && $page == 'profile' || $page == 'upload_image') { echo 'display:block'; }?>">
          <li <?php if(isset($page) && $page == 'profile') { echo 'class="active"'; }?> ><a href="<?php echo site_url('admin/update_profile');?>"><i class="fa fa-circle-o"></i>Update Profile</a></li>
          <li <?php if( isset($page) && $page == 'upload_image') { echo 'class="active"'; }?> ><a href="<?php echo site_url('admin/upload_image');?>"><i class="fa fa-circle-o"></i>Change Profile Picture</a></li>          
        </ul>
      </li>  
	<li class="treeview <?php if($page == 'add_user' || $page == 'list_user' || $page == 'edit_user' ) { echo 'menu-open'; }?> ">
          <a href="#">
            <i class="fa fa-edit"></i> <span>User</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu" style="<?php if($page == 'add_user' || $page == 'list_user' || $page == 'edit_user' ) { echo 'display:block'; }?>">

            <!-- <li <?php if($page == 'add_user') { echo 'class="active"'; }?> ><a href="<?php echo site_url('admin/add_user');?>"><i class="fa fa-circle-o"></i> Add</a></li> -->
            
            <li <?php if($page == 'list_user') { echo 'class="active"'; }?>><a href="<?php echo site_url('admin/list_user/1');?>"><i class="fa fa-circle-o"></i>User List</a></li>  

              <li <?php if($page == 'list_vendor') { echo 'class="active"'; }?>><a href="<?php echo site_url('admin/list_user/2');?>"><i class="fa fa-circle-o"></i>Vendor List</a></li>           
          </ul>
        </li>

        <li class="treeview <?php if($page == 'add_jobs' || $page == 'list_jobs' || $page == 'edit_jobs' || $page == 'open_brecoli' || $page == 'closed_brecoli' || $page == 'upcoming_brecoli') { echo 'menu-open'; }?> ">
          <a href="#">
            <i class="fa fa-edit"></i> <span>Jobs</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu" style="<?php if($page == 'add_jobs' || $page == 'list_jobs' || $page == 'edit_jobs' || $page == 'open_brecoli' || $page == 'closed_brecoli' || $page == 'upcoming_brecoli') { echo 'display:block'; }?>">

            
            
            <li <?php if($page == 'list_user') { echo 'class="active"'; }?>><a href="<?php echo site_url('admin/list_jobs');?>"><i class="fa fa-circle-o"></i>Job Post List</a></li>  
			<li <?php if($page == 'open_brecoli') { echo 'class="active"'; }?>><a href="<?php echo site_url('admin/open_brecoli');?>"><i class="fa fa-circle-o"></i>Open Brecoli</a></li> 
            <li <?php if($page == 'closed_brecoli') { echo 'class="active"'; }?>><a href="<?php echo site_url('admin/closed_brecoli');?>"><i class="fa fa-circle-o"></i>Closed Brecoli</a></li> 
			 <li <?php if($page == 'upcoming_brecoli') { echo 'class="active"'; }?>><a href="<?php echo site_url('admin/upcoming_brecoli');?>"><i class="fa fa-circle-o"></i>Upcoming Brecoli</a></li>  
          </ul>
        </li>


        <!--<li class="treeview <?php if($page == 'list_offer_code') { echo 'menu-open'; }?> ">
          <a href="#">
            <i class="fa fa-edit"></i> <span>Offer Code</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu" style="<?php if($page == 'list_offer_code') { echo 'display:block'; }?>">

            
            
            <li <?php if($page == 'list_offer_code') { echo 'class="active"'; }?>><a href="<?php echo site_url('admin/list_offer_code');?>"><i class="fa fa-circle-o"></i>Offer Code List</a></li>  

                     
          </ul>
        </li>-->
            


            
        <li class="treeview <?php if($page == 'add_category' || $page == 'list_category' || $page == 'edit_category' ) { echo 'menu-open'; }?> ">
          <a href="#">
            <i class="fa fa-edit"></i> <span>Services</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu" style="<?php if($page == 'add_category' || $page == 'list_category' || $page == 'edit_category' ) { echo 'display:block'; }?>">
            <li <?php if($page == 'add_category') { echo 'class="active"'; }?> ><a href="<?php echo site_url('category/add');?>"><i class="fa fa-circle-o"></i> Add</a></li>
            <li <?php if($page == 'list_category') { echo 'class="active"'; }?>><a href="<?php echo site_url('category');?>"><i class="fa fa-circle-o"></i> List</a></li>            
          </ul>
        </li>
		
		<li class="treeview <?php if($page == 'add_city' || $page == 'list_city' || $page == 'editcity') { echo 'menu-open'; }?> ">
          <a href="#">
            <i class="fa fa-edit"></i> <span>Cities</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu" style="<?php if($page == 'add_city' || $page == 'list_city' || $page == 'editcity') { echo 'display:block'; }?>">
            <li <?php if($page == 'add_city') { echo 'class="active"'; }?> ><a href="<?php echo site_url('cities/addcity');?>"><i class="fa fa-circle-o"></i> Add</a></li>
            <li <?php if($page == 'list_city' || $page == 'editcity') { echo 'class="active"'; }?>><a href="<?php echo site_url('cities');?>"><i class="fa fa-circle-o"></i> List</a></li>            
          </ul>
        </li>
       <!--  <li class="treeview <?php if($page == 'add_services' || $page == 'list_services' || $page == 'edit_services' ) { echo 'menu-open'; }?> ">
          <a href="#">
            <i class="fa fa-edit"></i> <span>Services</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu" style="<?php if($page == 'add_services' || $page == 'list_services' || $page == 'edit_services' ) { echo 'display:block'; }?>">
            <li <?php if($page == 'add_services') { echo 'class="active"'; }?> ><a href="<?php echo site_url('services/add');?>"><i class="fa fa-circle-o"></i> Add</a></li>
            <li <?php if($page == 'list_services') { echo 'class="active"'; }?>><a href="<?php echo site_url('services');?>"><i class="fa fa-circle-o"></i> List</a></li>            
          </ul>
        </li> -->
        <!-- <li class="treeview <?php if($page == 'add_options' || $page == 'list_options' || $page == 'edit_options' ) { echo 'menu-open'; }?> ">
          <a href="#">
            <i class="fa fa-edit"></i> <span>Options</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu" style="<?php if($page == 'add_options' || $page == 'list_options' || $page == 'edit_options' ) { echo 'display:block'; }?>">
            <li <?php if($page == 'add_options') { echo 'class="active"'; }?> ><a href="<?php echo site_url('services/add_options');?>"><i class="fa fa-circle-o"></i> Add</a></li>
            <li <?php if($page == 'list_options') { echo 'class="active"'; }?>><a href="<?php echo site_url('services/list_options');?>"><i class="fa fa-circle-o"></i> List</a></li>            
          </ul>
        </li> -->
       <!--  <li class="treeview <?php if($page == 'add_blogs' || $page == 'list_blogs' || $page == 'edit_blogs' ) { echo 'menu-open'; }?> ">
          <a href="#">
            <i class="fa fa-edit"></i> <span>Blogs</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a> -->
          <ul class="treeview-menu" style="<?php if($page == 'add_blogs' || $page == 'list_blogs' || $page == 'edit_blogs' ) { echo 'display:block'; }?>">
            <li <?php if($page == 'add_blogs') { echo 'class="active"'; }?> ><a href="<?php echo site_url('blogs/add');?>"><i class="fa fa-circle-o"></i> Add</a></li>
            <li <?php if($page == 'list_blogs') { echo 'class="active"'; }?>><a href="<?php echo site_url('blogs');?>"><i class="fa fa-circle-o"></i> List</a></li>            
          </ul>
        </li>     


        <li class="treeview <?php if($page == 'about_us' || $page == 'contact_us' || $page == 'terms & conditions' || $page == 'faq' ) { echo 'menu-open'; }?> ">
          <a href="#">
            <i class="fa fa-file"></i> <span>Pages</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu" style="<?php if($page == 'about_us' || $page == 'contact_us' || $page == 'terms & conditions' || $page == 'faq' ) { echo 'display:block'; }?>">
            <li <?php if($page == 'about_us') { echo 'class="active"'; }?> ><a href="<?php echo site_url('pages/about_us');?>"><i class="fa fa-circle-o"></i> About Us</a></li>

            <!-- <li <?php if($page == 'contact_us') { echo 'class="active"'; }?>><a href="<?php echo site_url('pages/contact_us');?>"><i class="fa fa-circle-o"></i> Contact Us</a></li> -->

            <li <?php if($page == 'terms & conditions') { echo 'class="active"'; }?>><a href="<?php echo site_url('pages/terms_and_conditions');?>"><i class="fa fa-circle-o"></i>Terms & Conditions</a></li>
            <li <?php if($page == 'faq') { echo 'class="active"'; }?>><a href="<?php echo site_url('pages/faq');?>"><i class="fa fa-circle-o"></i> Faq</a></li>            
          </ul>
        </li>
       <!--  <li <?php if($page == 'content') { echo 'class="active"'; }?>>
          <a href="<?php echo site_url('content');?>">
            <i class="fa fa-cogs"></i> <span>Featured Page</span>            
          </a>          
        </li> -->
        <!-- <li <?php if($page == 'settings') { echo 'class="active"'; }?>>
          <a href="<?php echo site_url('settings');?>">
            <i class="fa fa-cogs"></i> <span>Content Management</span>            
          </a>          
        </li> -->       
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>