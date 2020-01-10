<?php $this->load->view('header'); ?>
       
        <!-- breadcrumb Start -->
    <section class="breadcrumb_outer breadcrumb_outer_new">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <h4 class="text-capitalize"><?php
                    //$parent = get_parent($services->category_id);
                    //print_r($parent);
                    ?> <?=($services)?$services->title:''?></h4>
                </div>
                <div class="col-lg-8">
                     <ol class="breadcrumb pull-right">
                        <li class="breadcrumb-item"><a href="<?=site_url();?>">Home</a></li>
                        <?php $parent = get_parent($services->category_id);print_r($parent); ?>
                        <li class="breadcrumb-item active" aria-current="page"><?=($services)?$services->title:''?></li>
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
                        <a href="javascript:void(0)" onclick="your_need();" class="prog_box needs active">
                            <span class="icon"><i class="fas fa-shopping-bag"></i></span>
                            <span class="icon_text">Your Need</span>
                        </a>
                        <a href="javascript:void(0)" onclick="" class="prog_box location">
                            <span class="icon"><i class="fas fa-map-marker-alt"></i></span>
                            <span class="icon_text">Your Location</span>
                        </a>
                        <a href="javascript:void(0)" onclick="" class="prog_box schedule" style="display: none;">
                            <span class="icon"><i class="far fa-calendar-alt"></i></span>
                            <span class="icon_text">Schedule</span>
                        </a>
                        <a href="javascript:void(0)" onclick="" class="prog_box provider">
                            <span class="icon"><i class="fas fa-user"></i></span>
                            <span class="icon_text">select provider</span>
                        </a>
                         <a href="javascript:void(0)" class="prog_box checkout">
                            <span class="icon"><i class="fas fa-shopping-cart"></i></span>
                            <span class="icon_text">Checkout</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Service section Start -->
    <div class="service_need_wrapper">
        <div class="container">
        	<div class="row">                
            	<div class="col-md-7 tab">                    
                	<h1><?=($services)?$services->description:''?></h1>
                    <div class="servicebox">
                    <form id="form" method="post">
                        <?php foreach($options as $row) { ?>
							<?php //print_r(count($row)); ?>    
                            <?php foreach($row as $key => $value) { ?>
							<?php if(count($row) == 1){?>
							<?php if($value['field_type'] == 'select-box'){?>
							<div class="form-group col-md-12">
								<label><?=($value['field_key'])?$value['field_key']:''?></label>
                                <?php $field_name = implode('_',explode(' ',$value['field_name']));?>
								<select class="<?=($value['is_multiple'])?'selectpicker':''?> form-control" id="<?=($value['field_name'])?$field_name:''?>" name="<?=($value['field_name'])?$value['field_name']:''?>[]" <?=($value['is_multiple'])?'multiple':''?> onclick="submit_form('<?=($value['field_name'])?$field_name:''?>');" required>
									<?php foreach(explode(',',$value['field_value']) as $k => $res) { ?>                                        
										<option <?php if($this->session->userdata('service_cart')) { echo (in_array(trim($res),$this->session->userdata('service_cart')[$field_name])) ? 'selected' : ''; }else{ echo ($k == 0) ? '' : '';  } ?>><?=$res?></option>
									<?php } ?>
								  </select>
                                  <?php if($value['is_multiple']) {?>
                                  <input name="selectvalues<?=($field_name)?$field_name:''?>" id="selectvalues<?=($field_name)?$field_name:''?>" type="hidden" value="<?php echo ($this->session->userdata('service_cart')) ? implode(', ',$this->session->userdata('service_cart')[implode('_',explode(' ',$value['field_name']))]) : ''; ?>">
                                  <?php } ?>
							</div>                        
							<?php } ?>
							<?php if($value['field_type'] == 'input'){?>
							<div class="form-group col-md-12">
								<label><?=($value['field_key'])?$value['field_key']:''?></label>                                
								<input class="form-control" id="<?=($value['field_name'])?$value['field_name']:''?>" name="<?=($value['field_name'])?$value['field_name']:''?>[]" value="<?php echo ($this->session->userdata('service_cart')) ? $this->session->userdata('service_cart')[implode('_',explode(' ',$value['field_name']))][0] : ''; ?>" onchange="submit_form();" required>                                                    
							</div>                        
							<?php } ?>
							<?php if($value['field_type'] == 'radio'){?>
							<?php if(count(explode(',',$value['field_value'])) >= 2){ ?>
                            <div class="form-group">
								<label><?=($value['field_key'])?$value['field_key']:''?></label>
								<div class="form-radio-option col-md-12">
									<?php foreach(explode(',',$value['field_value']) as $key => $res) { ?>
									<div class="option1">
									 <input type="radio" id="<?=$res?>" name="<?=($value['field_name'])?$value['field_name']:''?>[]" value="<?=$res?>" <?=($key==0)?'checked':''?> <?php echo ($this->session->userdata('service_cart') && $this->session->userdata('service_cart')['Service_Method'][0] ==  $res) ? 'checked' : ''; ?> onclick="submit_form();">
										<label for="<?=$res?>"><i class="<?php echo explode(',',$value['field_icon'])[$key]; ?>"></i> <span><?=$res?></span></label>                                               
									</div>
									<?php } ?>
								</div>
							</div>
                            <?php }else{ ?>
                            <input type="hidden" id="<?=$res?>" name="<?=($value['field_name'])?$value['field_name']:''?>[]" value="<?=explode(',',$value['field_value'])[0]?>">
                            <?php } ?>
                            <div class="service_text_bottom" id="service_text_bottom" >
                            <p>We will send a trusted courier to collect your device from your location (home or office) and take it to be repaired in-store. We will bring the fixed device back to your location_This is your lowest cost option. </p>
                            </div>
                            <div class="service_text_bottom" id="service_text_bottom1" style="display: none;">
                            <p>Your hired handpicked professional will arrive at your location (home or office) on-time and with all the necessary parts and equipment they need to complete the service. This is your fastest option. </p>
                            </div>
							<?php } ?>
							<input id="servicetype" type="hidden" value="1">
							<?php }else{ ?>
							
							<?php if(count($row) == 2) { $col1 = 3; $col = 5; $col3 = 4; }?>
							<?php if(count($row) == 3) { $col1 = ($options[0][1]['is_required']) ? '2': '3'; $col = ($options[0][1]['is_required']) ? '4': '6'; $col3 = ($options[0][1]['is_required']) ? '2': '3'; }?>
							<?php if($value['list_name']) {   $l = implode('_',explode(' ',$value['list_name'])); }else{ $l = '_'; }?>
							<?php if($value['field_type'] == 'label'){?>
							<div class="<?php echo ($value['list_name']) ? 'panel_cover' : 'panel_down'; ?>">
                                <?php if($value['list_name'] && ($value['is_open'] == 0)) { ?>
								<div class="panel_heading">
									<h4><?php echo $value['list_name'];?></h4>
									<span class="p_icon"><i class="fas fa-plus"></i></span>
								</div>
                                <?php } ?>
								<!-- panel content end -->
								<div class="<?php echo ($value['list_name'] && ($value['is_open'] == 0)) ? 'panel_content' : ''; ?>">									
									<div class="row">
										<div class="col-md-<?=$col1?>">
											<div class="service_col">
                                                <input type="hidden" id="keylabel" value="<?=($value['field_key'])?$value['field_key']:''?>">
												<label><small><?=($value['field_key'])?$value['field_key']:''?></small></label>                                                
												<?php $mm = count(explode(',',$value['field_value'])); ?>
												<?php foreach(explode(',',$value['field_value']) as $k=>$res) { ?>
												<div class="form-group">
													<div class="serv_type_name"><?=$res?></div>
													<input id="label<?=$k.$l?>" type="hidden" value="<?=$res?>">
												</div>    
												<?php  } ?>                                                
											</div>
										</div>
										<?php } ?>
										<?php if($value['field_type'] == 'select-box'){?>										
										<div class="col-md-<?=$col?>">
                                            <input type="hidden" id="keyselect"  value="<?=($value['field_key'])?$value['field_key']:''?>">                                            
											<div class="service_col">
											<label><small><?=($value['field_key'])?$value['field_key']:''?></small></label>
											<?php for($i=0;$i<$mm;$i++){?>
												<div class="form-group">                         
													<select class="<?=($value['is_multiple'])?'selectpicker':''?> form-control" id="select<?=$i.$l?>"  <?=($value['is_multiple'])?'multiple':''?>>
														<?php foreach(explode(',',$value['field_value']) as $res) { ?>                
															<option><?=$res?></option>
														<?php } ?>
													  </select>
												</div>                                                
											<?php } ?>    
											</div>
										</div>
										<?php } ?>
										<?php if($value['field_type'] == 'qty'){?>
                                        <?php if($value['is_required'] == 1){?>										
										<div class="col-md-<?=$col?>">
                                            <input type="hidden" id="keyqty"  value="<?=($value['field_key'])?$value['field_key']:''?>">
											<div class="service_col">
											<label><small><?=($value['field_key'])?$value['field_key']:''?></small></label>
											<?php for($i=0;$i<$mm;$i++){?>
												<div class="form-group">                        
													<div class="number_counter">
													<input type="text" id="qty<?=$i.$l?>" class="show_number" value="1">
												 </div>
												</div>
												
											<?php } ?>    
											</div>
										</div>
                                        <?php  }else{ ?>
                                        <input type="hidden" id="keyqty"  value="<?=($value['field_key'])?$value['field_key']:''?>">
                                            <?php for($i=0;$i<$mm;$i++){?>                                            
                                                <input type="hidden" id="qty<?=$i.$l?>" class="show_number" value="1">
                                            <?php } ?>
                                        <?php  } ?>
										<?php  } ?>
										<?php if($value['field_type'] == 'qty'){?>
										<div class="col-md-<?=$col3?>">
                                            <input type="hidden" id="isradio"  value="<?=($value['is_radio'])?$value['is_radio']:''?>">
											<div class="service_col">
											<label><small>&nbsp;<?php ($value['field_key'])?$value['field_key']:''?></small></label>
											<?php for($i=0;$i<$mm;$i++){?>
												<div class="form-group">                    
													<span class="srvc_add_btn" onclick="submit_form1(<?=$i?>,'<?=$l?>');"><?=($value['field_value'])?$value['field_value']:''?></span>                                             
												</div>
											<?php } ?>    
											</div>
										</div>
									</div>
								</div>
							<!-- panel content end -->
							</div>
							<?php } ?>
							<input id="servicetype1" type="hidden" value="1">                            
							<?php } ?>
							
								<?php } ?>
							<?php } ?>
                    </form>                    
                    
                    </div>
                    <div id="loader" style="display:none;"><img src="https://media.theaustralian.com.au/fe/sop/wait.gif"></div>
                </div>
                <div class="col-md-5">
                	
                    <div class="basket_panel_outer">
                    	<h2>Your Basket</h2>
                        <div class="basket_panel_inner">
                        	<div class="basket_need_item">
                            	<div class="need_item_title row"><h3><?=($services)?$services->title:''?> <!--<i class="far fa-times-circle"></i>--></h3></div>
                                <div id="cart">                                    
                                    <?php
                                    $listt = []; $html = ''; $servicemethod = '';
                                    if($this->session->userdata('service_cart1')){
                                        foreach($this->session->userdata('service_cart1') as $key=>$value){            
                                            if($value['list'] != '_'){
                                                if(!in_array($value['list'],$listt)){
                                                    $listt[] = $value['list'];
                                                    $html .= '<p><div class="need_item_title"><h4>'.implode(' ',explode('_',$value['list'])).'</h4></div></p>';
                                                }            
                                            }
                                            
                                            foreach($value as $keyy=>$row){
                                                if($keyy != 'list'){
                                                    if($keyy == 'label'){
                                                        $var = $value['id'];                        
                                                        $html .= '<p><strong>'.ucwords(implode(' ',explode('_',$value['keylabel']))).'</strong> : '.$row.'<span class="pull-right del_srvc_btn" onclick="delete_service(\''.$var.'\')"><i class="fas fa-times"></i></span></p>';
                                                    }
                                                    if($keyy == 'select'){                        
                                                        $html .= '<p><strong>'.ucwords(implode(' ',explode('_',$value['keyselect']))).'</strong> : '.$row.'</p>';
                                                    }
                                                    if($keyy == 'qty'){                        
                                                        $html .= '<p><strong>'.ucwords(implode(' ',explode('_',$value['keyqty']))).'</strong> : '.$row.'</p><br>';
                                                    }
                                                }
                                                if($keyy == 'Service_Method'){
                                                    $servicemethod = $row;
                                                }
                                            }
                                        }
                                    }
                                        $html .= '<hr>';
                                        if($this->session->userdata('service_cart')){                                            
                                            foreach($this->session->userdata('service_cart') as $key=>$value){
                                                if(is_array($value)){
                                                    $html .= '<p><strong>'.ucwords(implode(' ',explode('_',$key))).'</strong> : '.implode(', ',$value).'</p>';
                                                }
                                                if($key == 'Service_Method'){
                                                    $servicemethod = $value;
                                                }
                                            }
                                        }
                                        
                                        if($html != '' && $html != '<hr>'){
                                            echo $html;    
                                        }else{
                                            echo 'Your Cart is Empty! Add Service Now';
                                        }                                                                                
                                    ?>
                                                            
                                </div>
                                
                                <div id="location_cart">
                                    
                                </div>
                                
                                <div id="schedule_cart">
                                    
                                </div>
                                
                                <div id="provider_cart">
                                    
                                </div>
                                
                                <!--<p>Types of services : Classic Manicure</p>
                                <p>Broken back cover, Broken Screen</p>
                                <div class="spinner_outer row">
                               <!--<span> Number Of Customer : </span>
                                     <div class="spinner_inner">
                                    <button class="btn btn-dark btn-sm" id="minus-btn"><i class="fa fa-minus"></i></button>
                                    <input type="text" id="qty_input" class="" value="1" min="1">
                                     <button class="btn btn-dark btn-sm" id="plus-btn"><i class="fa fa-plus"></i></button>
                                </div>--
                                </div>-->
                            </div>
                            
                            
                             
                           <!--<div class="total_panel">
                           	<div class="row">
                            	<strong>Total</strong>
                            	<span>$349.0</span>
                            </div>
                           </div>-->
                            <div class="continue_div">
                                <button class="red_button text-uppercase" id="continue" style="<?php echo (($html != '' && $html != '<hr>')) ? '' : 'display: none;' ?>" onclick="load_next_tab();">Continue <i class="fas fa-long-arrow-alt-right"></i></button>
                            </div>
                            <br>
                            <span class="error alert-danger" role="alert" style="display: none"><strong>Error : </strong> Please Select atleast one service</span>
                            <span class="error1 alert-danger" style="display: none"><strong>Error : </strong> Please save your location</span>
                            <span class="error11 alert-danger" style="display: none"><strong>Error : </strong> Please set your scheduled time</span>
                            <span class="error2 alert-danger" style="display: none"><strong>Error : </strong> Please select any provider</span>
                            <span class="error3 alert-danger" style="display: none"><strong>Error : </strong> Please save billing or shipping address</span>
                            <input type="hidden" id="errorflag">
                        </div>
                    </div>
                	
                </div>
            </div>
           
            
        </div>
    </div>
    <!-- Service section End -->
    
   
<script>
	$(document).ready(function(){
    $('#qty_input').prop('disabled', true);
    $('#plus-btn').click(function(){
    	$('#qty_input').val(parseInt($('#qty_input').val()) + 1 );
    	    });
        $('#minus-btn').click(function(){
    	$('#qty_input').val(parseInt($('#qty_input').val()) - 1 );
    	if ($('#qty_input').val() == 0) {
			$('#qty_input').val(1);
		}

    	    });
 });
</script>

<script>
    function submit_form(fieldname = null){
        //alert(fieldname);
        if(fieldname !== null){
          $('#selectvalues'+fieldname).val($('#'+fieldname).val());  
        }
        
        
        $('#continue').show();
        $.ajax({
            type: 'post',
            url: '<?php echo site_url('welcome/add_services');?>',
            data: $('#form').serialize(),
            success: function (response) {
              //alert('form was submitted');
              console.log(response);
              var obj = JSON.parse(response);              
              $('#cart').html(obj.html);
              console.log(obj.servicemethod);
                if(obj.servicemethod == 'On Site' || obj.servicemethod == ' On Site'){
                  $('.schedule').show();                  
                  $('#service_text_bottom1').show(500);
                  $('#service_text_bottom').hide(500);
                }else{
                  $('.schedule').hide();
                  $('#service_text_bottom').show(500);
                  $('#service_text_bottom1').hide(500);
                }
              
            }
          });
    }
    
    function submit_form1(id,lab){
        $('#continue').show();
        var label = $('#label'+id+lab).val();
        var keylabel = $('#keylabel').val();
        var keyselect = $('#keyselect').val();
        var keyqty = $('#keyqty').val();
        var list = lab;
        var isradio = $('#isradio').val();
        //alert(id+lab);
        //console.log({'id':id+lab,'label':label,'select':select,'qty':qty,'list':lab,'keylabel':keylabel,'keyselect':keyselect,'keyqty':keyqty});
        var select = $('#select'+id+lab).val();
        var qty = $('#qty'+id+lab).val();
        $.ajax({
            type: 'post',
            url: '<?php echo site_url('welcome/add_services1');?>',
            data: {'id':id+lab,'label':label,'select':select,'qty':qty,'list':lab,'keylabel':keylabel,'keyselect':keyselect,'keyqty':keyqty,'isradio':isradio},
            success: function (response) {
              //alert('form was submitted');
              var obj = JSON.parse(response);
              $('#cart').html(obj.html);              
            }
          });
    }
    
    function delete_service(id){        
        $.ajax({
            type: 'post',
            url: '<?php echo site_url('welcome/delete_service');?>',
            data: {'id':id},
            success: function (response) {
                var obj = JSON.parse(response);
                $('#cart').html(obj.html);
            }
          });
    }
    
    function save_location(){
        if($('#location').val() === '' || $('#address_hidden').val() === ''){
            $('#location_error').show();
            return true;
        }
        $('#location_error').hide();
        
        if($('#street').val() === ''){
            $('#street_error').show();
            return true;
        }
        $('#street_error').hide();
        
        if($('#house').val() === ''){
            $('#house_error').show();
            return true;
        }
        $('#house_error').hide();
        
        if($('#landmark').val() === ''){
            $('#landmark_error').show();
            return true;
        }
        $('#landmark_error').hide();
        $('.error1').hide();
        
        
        $.ajax({
            type: 'post',
            url: '<?php echo site_url('welcome/save_location');?>',
            data: $('#locationform').serialize(),
            success: function (response) {
              console.log(response);
              $('#location_cart').html('<div class="border_line"></div><div style="text-align:right;"><a onclick="your_location()"><i class="far fa-edit" title="edit"></i></a></div>'+response);              
              $('#continue').attr("onclick","load_next_tab()");
            }
          });
    }
    
    function save_schedule(){
        $.ajax({
            type: 'post',
            url: '<?php echo site_url('welcome/save_schedule');?>',
            data: $('#scheduleform').serialize(),
            success: function (response) {
              console.log(response);
              $('#schedule_cart').html('<div class="border_line"></div>'+response);
              $('.error11').hide();
            }
          });
    }
    
    function select_provider(){    
        if($('input[name="vndor"]:checked').length == 0){
            $('.error2').show();
            return true;
        }
        
        $.ajax({
            type: 'post',
            url: '<?php echo site_url('welcome/select_provider');?>',
            data: $('#providerform').serialize(),
            success: function (response) {
              console.log(response);
              $('#provider_cart').html('<div class="border_line"></div>'+response);
              $('.error2').hide();
              $('#continue').attr("onclick","load_next_tab()");
            }
          });
        
    }
    
    function save_billing(){
        
        $.ajax({
            type: 'post',
            url: '<?php echo site_url('welcome/save_billing');?>',
            data: $('#billingform').serialize(),
            success: function (response) {
              console.log(response);
              //$('#location_cart').html('<hr>'+response);
            }
          });
    }
    
    
    function load_next_tab(){
        //alert(nextlink);
        var nextpage = 'location';
        if($('#next_tab').val()){
          nextpage = $('#next_tab').val();  
        }        
        if(nextpage == 'location'){
            submit_form();
            if($("#servicetype").val()){
                var check = 0;
            }
            if($("#servicetype1").val()){
                var check = 1;
            }
            if($("#servicetype").val() && $("#servicetype1").val()){
                var check = 2;
            }
            //alert(check);
        }
        
        if(nextpage == 'finished'){
            var url = '<?php echo site_url('welcome/load_next_tab1/');?>';
        }else{
            var url = '<?php echo site_url('welcome/load_next_tab/');?>';
        }
        
        $.ajax({
            type: 'post',
            url: url,
            data: {'nextpage':nextpage,'check':check},
            beforeSend: function() {
                // show loader
                $('#loader').show();
                $('.servicebox').hide();                
            },
            success: function (response) {
              console.log(response);
              //alert(nextpage);
                if(response == 0){
                  $('#loader').hide();
                  $('.servicebox').show();   
                  if(nextpage == 'location'){
                      $('.error').show();
                  }
                  if(nextpage == 'schedule'){
                      $('.error1').show();
                      $('#errorflag').val(1);
                  }
                  if(nextpage == 'provider'){                    
                      if($('#errorflag').val() === '1') {
                          //alert($('#errorflag').val());
                          $('.error11').show();
                      }else{
                          $('.error1').show();
                      }
                  }
                  if(nextpage == 'checkout'){
                      $('.error2').show();
                  }
                  if(nextpage == 'finish'){
                      $('.error3').show();
                  }                    
                }else{
                  if(nextpage == 'schedule'){                   
                      $('#errorflag').val(1);
                  }  
                  setTimeout(function() {
                      if(nextpage == 'location'){
                          $('.tab').html(response);
                          $('.error').hide();
                          $('.needs').removeClass('active');
                          $('.location').addClass('active');
                          
                          $('#continue').attr("onclick","save_location()");
                          
                      }
                      if(nextpage == 'schedule'){                        
                          $('.tab').html(response);
                          $('.error').hide();
                          $('.error1').hide();                        
                          $('.location').removeClass('active');
                          $('.schedule').addClass('active');
                          $('#continue').attr("onclick","load_next_tab()");
                          $('.location').attr("onclick","your_location()");
                      }
                      if(nextpage == 'provider'){
                          $('.tab').html(response);
                          $('.error').hide();
                          $('.error1').hide();
                          $('.error11').hide();
                          $('.location').removeClass('active');
                          $('.schedule').removeClass('active');
                          $('.provider').addClass('active');
                          $('#continue').attr("onclick","select_provider()");
                          $('.location').attr("onclick","your_location()");
                          $('.schedule').attr("onclick","your_schedule()");
                      }
                      if(nextpage == 'checkout'){
                          $('.tab').html(response);
                          $('.error1').hide();
                          $('.error11').hide();
                          $('.error2').hide();
                          $('.provider').removeClass('active');
                          $('.checkout').addClass('active');
                          $('#continue').hide();
                          $('.provider').attr("onclick","your_provider()");
                      }
                      if(nextpage == 'finished'){
                          window.location = "<?php echo site_url('welcome/checkout'); ?>";
                      }
                
                    }, 500);
                }
            },
            complete: function() {
               
            }
          });
    }
    
    
    function your_need(){
        location.reload();
    }
    
    function your_location(){
        
          $.ajax({
            type: 'post',
            url: '<?php echo site_url('welcome/load_location_tab');?>',
            beforeSend: function() {
                // show loader
                $('#loader').show();
                $('.servicebox').hide();                
            },
            success: function (response) {
              //console.log(response);
              setTimeout(function() {
                    if(response != 0){
                        $('.tab').html(response);
                        $('.error').hide();
                        $('.needs').removeClass('active');
                        $('.schedule').removeClass('active');
                        $('.provider').removeClass('active');
                        $('.checkout').removeClass('active');
                        $('.location').addClass('active');
                        $('#schedule_cart').html('');
                        $('#provider_cart').html('');                        
                        $('#continue').show();
                        $('#continue').attr("onclick","load_next_tab()");
                        $('.error2').hide();
                    }
              }, 500); 
            }
          });
        
    }
    
    function your_schedule(){
        
          $.ajax({
            type: 'post',
            url: '<?php echo site_url('welcome/load_schedule_tab');?>',
            beforeSend: function() {
                // show loader
                $('#loader').show();
                $('.servicebox').hide();                
            },
            success: function (response) {
              //console.log(response);
              setTimeout(function() {
                if(response != 0){
                    $('.tab').html(response);                    
                    $('.error').hide();
                    $('.error1').hide();                        
                    $('.location').removeClass('active');
                    $('.provider').removeClass('active');
                    $('.checkout').removeClass('active');
                    $('.schedule').addClass('active');
                    $('#provider_cart').html('');
                    $('#continue').show();
                    $('#continue').attr("onclick","load_next_tab()");
                    $('.error2').hide();
                }
              }, 500); 
            }
          });    
    }
    
    function your_provider(){
        
          $.ajax({
            type: 'post',
            url: '<?php echo site_url('welcome/load_provider_tab');?>',
            beforeSend: function() {
                // show loader
                $('#loader').show();
                $('.servicebox').hide();                
            },
            success: function (response) {
              //console.log(response);
              setTimeout(function() {
                if(response != 0){
                    $('.tab').html(response);
                    $('.error').hide();
                    $('.error1').hide();
                    $('.error11').hide();
                    $('.location').removeClass('active');
                    $('.schedule').removeClass('active');
                    $('.checkout').removeClass('active');
                    $('.provider').addClass('active');
                    $('#continue').show();
                }
              }, 500);   
            }
          });    
    }
</script>

<script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyCCQzJ9DJLTRjrxLkRk6jaSrvcc5BfDtWM" type="text/javascript"></script>

<?php $this->load->view('footer'); ?>