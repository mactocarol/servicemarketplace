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
<!-- Main content -->
<div class="blog_wrapper_section">
     <!-- Main row -->
     <div class="container">
          <div class="row">
               <?php if(isset($results)) 
                    {
                    foreach($results as $row)
                    { ?>
               <?php if($row['image']=="")
                    {
                         $path = base_url('upload/blog/thumb/avatar.png');
                    }
                    else
                    {
                         $path=base_url('upload/blog/thumb/'.$row['image']);
                    } ?>
               <div class="col-md-4">
                    <div class="blog_div">
                         <div class="blog_thumb">
                              <a href="/en/post/why-you-need-efficient-ac-services"><img src="<?php echo $path; ?>" ></a>
                         </div>
                         <div class="blog_desc">
                              <h5 class="card-title">
                                   <?php echo isset($row['title']) ? $row['title'] : ''; ?>
                              </h5>
                              <p class="card-text"><?php echo isset($row['description']) ? truncate($row['description'],50) : ''; ?></p>
                              <a class="blog_btn" href="<?php echo site_url('blog/'.$row['id']);?>">Read More</a></a>
                         </div>
                    </div>
               </div>

               <?php     }
                    }?> 
          </div>
     </div>
</div>
<?php echo $this->load->view('footer'); ?>
