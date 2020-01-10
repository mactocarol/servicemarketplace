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

        <li class="treeview <?php if($page == 'add_category' || $page == 'list_category' || $page == 'edit_category' ) { echo 'menu-open'; }?> ">

          <a href="#">

            <i class="fa fa-edit"></i> <span>Category</span>

            <span class="pull-right-container">

              <i class="fa fa-angle-left pull-right"></i>

            </span>

          </a>

          <ul class="treeview-menu" style="<?php if($page == 'add_category' || $page == 'list_category' || $page == 'edit_category' ) { echo 'display:block'; }?>">

            <li <?php if($page == 'add_category') { echo 'class="active"'; }?> ><a href="<?php echo site_url('category/add');?>"><i class="fa fa-circle-o"></i> Add</a></li>

            <li <?php if($page == 'list_category') { echo 'class="active"'; }?>><a href="<?php echo site_url('category');?>"><i class="fa fa-circle-o"></i> List</a></li>            

          </ul>

        </li>

        

        <li class="treeview <?php if($page == 'add_blogs' || $page == 'list_blogs' || $page == 'edit_blogs' ) { echo 'menu-open'; }?> ">

          <a href="#">

            <i class="fa fa-edit"></i> <span>Blogs</span>

            <span class="pull-right-container">

              <i class="fa fa-angle-left pull-right"></i>

            </span>

          </a>

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

            <li <?php if($page == 'contact_us') { echo 'class="active"'; }?>><a href="<?php echo site_url('pages/contact_us');?>"><i class="fa fa-circle-o"></i> Contact Us</a></li>

            <li <?php if($page == 'terms & conditions') { echo 'class="active"'; }?>><a href="<?php echo site_url('pages/terms_and_conditions');?>"><i class="fa fa-circle-o"></i>Terms & Conditions</a></li>

            <li <?php if($page == 'faq') { echo 'class="active"'; }?>><a href="<?php echo site_url('pages/faq');?>"><i class="fa fa-circle-o"></i> Faq</a></li>            

          </ul>

        </li>

        <li <?php if($page == 'content') { echo 'class="active"'; }?>>

          <a href="<?php echo site_url('content');?>">

            <i class="fa fa-cogs"></i> <span>Featured Page</span>            

          </a>          

        </li>

        <li <?php if($page == 'settings') { echo 'class="active"'; }?>>

          <a href="<?php echo site_url('settings');?>">

            <i class="fa fa-cogs"></i> <span>Content Management</span>            

          </a>          

        </li>

        <li <?php if($page == 'upload_logo') { echo 'class="active"'; }?>>

          <a href="<?php echo site_url('admin/upload_logo');?>">

            <i class="fa fa-cogs"></i> <span>Change Logo</span>            

          </a>          

        </li>

      </ul>

    </section>

    <!-- /.sidebar -->

  </aside>