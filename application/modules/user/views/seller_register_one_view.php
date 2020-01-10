<?php $this->load->view('header');?>
    <section class="breadcrumb_outer">
    	<div class="container">
        	<div class="row">
            	<div class="col-lg-6">
                	<h2 class="text-capitalize">Signup Step 1</h2>
                </div>
                <div class="col-lg-6">
                	 <ol class="breadcrumb pull-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Signup Step 1</li>
                      </ol>
                </div>
            </div>
        </div>
    </section>
    <!-- signup form Start -->
    <div class="signup_wrapper pad_top_bottom_50">
    	<div class="container">
            <div class="form_wrapper_main">
                <!-- top category Start -->
                <form method="post" id="form" action="<?php echo site_url('user/service_register');?>">
                	<div class="signup_header">
                    	<h3>Apply now as a service provider</h3>
                        <p>Simply fill out the application</p>
                    </div>
                    <div class="step_wizard">
                        <a href="signup_step1.html" class="step_circle current">1</a>
                        <a href="#" class="step_circle">2</a>
                        <a href="#" class="step_circle">3</a>
                        <a href="#" class="step_circle">4</a>
                    </div>
                    <div class="signup_header">
                        <h3>What do you do?</h3>
                        <p>Please select a category</p> 
                    </div>
                    <div class="register_form_wrap">
                        <?php foreach($categories as $row){?>
                        <div class="cat_box">
                            <label>
                                <input type="checkbox" name="category[]" value="<?=$row['id']?>"   onclick="show_subcat('cat<?=$row['id']?>','<?=$row['id']?>');">
                                <span class="label_box">
                                    <?=$row['icon']?>
                                    <span class="text"><?=$row['title']?></span>
                                </span>
                            </label>
                        </div>
                        <?php } ?>
                            
                    </div>
                    <!-- top category End -->
                    <!-- Bottom category Start -->
                    <div class="category_box_wrap2">
                        <div class="category_heading pad_top_bottom_30">
                            <h3>Please select the subcategory</h3>
                        </div>
                        <div class="row">
                            <?php for($i=0;$i<count($categories);$i++){ ?>                            
                            <?php foreach($categories[$i]['subcategories'] as $row){?>
                            <div class="col-md-3 col-sm-6 col-xs-12 cat_list <?='cat'.$categories[$i]['id']?>" style="display:none;">
                                <div class="cat_check_list">
                                    <label>
                                        <input class="checkbox<?php echo $categories[$i]['id']; ?>" type="checkbox" name="subcategory[]" value="<?=$row['id']?>">
                                        <span class="c_circle">
                                            <i class="fas fa-check"></i>
                                        </span>
                                        <span class="c_text"><?=$row['title']?></span>
                                    </label>
                                </div>
                            </div>
                            <?php } }?>
                           
                            <input type="hidden" name="sellerid" value="<?=$sellerid?>">
                            <div class="button_wrap col-sm-12 col-xs-12">
                                <button type="button" name="" onclick="submit_form();" class="red_button submit_btn">Next</button>
                            </div>
                        </div>
                    </div>
                     <!-- Bottom category End -->
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        var arr = [];
        function show_subcat(cls,id){
            
            if(jQuery.inArray(id, arr) !== -1){   
                $(".checkbox"+id).prop("checked", false);             
                arr.splice($.inArray(id, arr),1);
                $("#checkbox").prop("checked", false);
                $('.'+cls).hide(200);
            }else{                
                arr.push(id);
                $('.'+cls).show(500);    
            }            
        }
        
        function submit_form(){
            if($("input[type='checkbox'][name='category[]']:checked").length === 0){
                swal('Please Select Category');
                return false;
            }
            if($("input[type='checkbox'][name='subcategory[]']:checked").length === 0){
                swal('Please Select Sub Category');
                return false;
            }
            $('#form').submit();
        }
    </script>
<?php $this->load->view('footer');?>    
