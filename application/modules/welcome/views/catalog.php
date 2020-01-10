<?php $this->load->view('header'); ?>
        <!-- breadcrumb Start -->
    <section class="breadcrumb_outer breadcrumb_outer_new">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <h2 class="text-capitalize">
                    Category
                    </h2>
                </div>
                <div class="col-lg-8">
                     <ol class="breadcrumb pull-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <?php
                        $parent = get_parent($id);
                        print_r($parent);
                        ?>
                        <!--<li class="breadcrumb-item active" aria-current="page">custom services</li>-->
                      </ol>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb End -->
    <div class="s_progress_bar">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <div class="progress_steps">
                        <a href="#" class="prog_box active">
                            <span class="icon"><i class="fas fa-shopping-bag"></i></span>
                            <span class="icon_text">Your Need</span>
                        </a>
                        <a href="#" class="prog_box">
                            <span class="icon"><i class="fas fa-map-marker-alt"></i></span>
                            <span class="icon_text">Your Location</span>
                        </a>
                        <a href="#" class="prog_box">
                            <span class="icon"><i class="far fa-calendar-alt"></i></span>
                            <span class="icon_text">Schedule</span>
                        </a>
                        <a href="#" class="prog_box">
                            <span class="icon"><i class="fas fa-user"></i></span>
                            <span class="icon_text">select provider</span>
                        </a>
                         <a href="#" class="prog_box">
                            <span class="icon"><i class="fas fa-shopping-cart"></i></span>
                            <span class="icon_text">Checkout</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Service section Start -->
    <div class="service_page_wrapper">
        <div class="container">            
            <!-- Service tabs Start -->
            <div class="service_tabs">
                <div class="service_tabs_inner">
                    <ul class="s_tab_menu tab_menu">
                        <?php foreach($services as $key=>$value){?>
                            <li data-show="<?=($value['title'])?implode('-',explode(' ',$value['title'])):''?>" class="<?=($value['id']==$id)?'active':''?>">
                                <i class="<?=$value['icon']?>"></i><span class="tab_text"><?=($value['title'])?$value['title']:''?></span>
                            </li>
                        <?php } ?>
                       
                    </ul>
                </div>
            </div>
            <!-- Service tabs End -->
            <div class="service_tab_content">
                <?php foreach($services as $key=>$value){?>
                <div class="tab_content <?=($value['id']==$id)?'active':''?>" id="<?=($value['title'])?implode('-',explode(' ',$value['title'])):''?>">
                     <div class="tab_content_list">
                        <?php foreach($value['subcategory'] as $keyy=>$valuee){?>
                            <a href="<?php echo site_url('catalog/'.$value['id'].'/'.$valuee['id']);?>" class="cont_list_wrap hover">
                                <span class="icon"><i class="<?=$valuee['icon']?>"></i></span>
                                <div class="list_content">
                                    <span><?=($valuee['title'])?$valuee['title']:''?></span>
                                </div>
                            </a>
                        <?php } ?>
                        
                    </div>
                </div>
                <?php } ?>
                
                
            </div>
        </div>
    </div>
    <!-- Service section End -->
    
   <?php $this->load->view('footer'); ?>