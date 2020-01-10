<?php echo $this->load->view('header'); ?>
<section class="breadcrumb_outer">
     <div class="container">
          <div class="row">
               <div class="col-lg-6">
                    <h2 class="text-capitalize">Blog</h2>
               </div>
               <div class="col-lg-6">
                    <ol class="breadcrumb pull-right">
                         <li class="breadcrumb-item"><a href="<?php echo site_url('user');?>">Home</a></li>
                         <li class="breadcrumb-item active" aria-current="page">Blog</li>
                    </ol>
               </div>
          </div>
     </div>
</section>
<div class="blog_wrapper_section">
<section class="blog-details mt-4 ptb-4">
    <div class="container">
        <div class="row">
            <?php 
                if(isset($results)) 
                {
                    if($results->image=="")
                    {

                         $path = base_url('upload/blog/thumb/avatar.png');
                    }
                    else
                    {
                        $path=base_url('upload/blog/thumb/'.$results->image);
                    } 
            ?> 
                <div class="col-md-12">
                        </div>
                        <div class="col-md-9 sm-padding-right">
                            <div class="blog_div">
                                <div class="blog-title">
                                    <h2 class="bolder"><?php echo isset($results->title) ? $results->title : ''; ?></h2>
                                    <span><strong>Category :</strong> <a href="/en/category/ac-services"><?php echo isset($results->category_id) ? $results->title : ''; ?></a></span>
                                </div>
                                <div class="blog_thumb">
                                    <img src="<?php echo $path; ?>" class="blog-img">
                                    <div class="blog-date">
                                        <span class="b_date"><?php echo date('M d,Y', strtotime($results->created_at)); ?></span>
                                        <span class="b_time"><?php echo date('h:m A', strtotime($results->created_at)); ?></span>
                                    </div>
                                </div>

                                <div class="blog_desc">
                                    <p><?php echo isset($results->description) ? substr($results->description,0,500) : ''; ?></p>
                                </div>
                    
                            </div>
                        <?php } ?>    
                        </div>
                        <?php  
                            if(isset($recent_blogs)) 
                            {
                          ?>      
                        <div class="col-md-3">
                            <div class="sidebar">
                                <div class="s_widget recent-blogs">
                                    <div class="blog_title">
                                        <h5>Recent Blogs</h5>
                                    </div>
                                    <div class="blog_text">
                                        <ul>
                                        <?php
                                            foreach($recent_blogs as $recent_blog) { ?>
                                            <li>
                                                <a href="<?php echo $recent_blog['id']; ?>">
                                                    <?php echo $recent_blog['title'];?>      
                                                </a>
                                            </li>
                                        <?php } ?>
                                        </ul>
                                    </div>
                                    </div>
                            <?php } ?>        
        </div>
    </div>
</section>
</div>
<?php echo $this->load->view('footer'); ?>
