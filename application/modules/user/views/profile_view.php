<?php echo $this->load->view('header'); ?>
<section class="breadcrumb_outer">
  <div class="container">
    <div class="row">
      <div class="col-lg-6">
        <h2 class="text-capitalize">Profile</h2>
      </div>
      <div class="col-lg-6">
        <ol class="breadcrumb pull-right">
          <li class="breadcrumb-item"><a href="<?php echo site_url('user');?>">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Profile</li>
        </ol>
      </div>
    </div>
  </div>
</section>
<section class="template2_outer template2_outer_height">
  <div class="container">
  <div class="template2_in">
    <div class="row">
      <?php
      if(isset($message)) {         
        if($success){
      ?>
            <div class="alert alert-dismissible alert-success">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Success!</strong> <?php print_r($message); ?>
            </div>
          <?php
          }else{
          ?>
            <div class="alert alert-dismissible alert-danger">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Error!</strong> <?php print_r($message); ?>
            </div>
      <?php
        }
      }
      ?>
      <div class="col-md-4">
        <div class="customer_detail">
          <div class="buyer_profile_box  profile_image">
            <?php if($result->social_type){?>
                <img style="border: 1px solid #a47966;" id="pImg" src="<?php echo $result->image;?>">
            <?php } else { ?>
                <img style="border: 1px solid #a47966;" id="pImg" src="<?php echo base_url('upload/profile_image/'.$result->image);?>">
            <?php } ?>
            <form method="post" action="<?php echo site_url('user/upload_image'); ?>" enctype="multipart/form-data">
              <div class="form-group">
                <input onchange="document.getElementById('pImg').src = window.URL.createObjectURL(this.files[0])" id="myId" style="display: none;" type="file" name="profile_pic" class="form-control" required>
              </div>
              <button onclick="$('#myId').click();" type="submit" class="btn btn-warning">Select Picture</button>
              <br><br><br>
              <button type="submit" class="btn btn-danger">Update Picture</button>
            </form>
            <h2><?php echo ($result->username) ? $result->username : ''; ?></h2>
            <span><?php echo ($result->email) ? $result->email : ''; ?></span>  
            <br><br><br>
            <a href="vendor_services">
            <button type="button" class="btn btn-info">Service List</button>                                  
            </a>
          </div>
        </div>
      </div>
      <div class="col-md-8">
        <form method="post" id="updateuserform" action="<?php echo site_url('user/profile');?>">
          <div class="right_profile_content">
            <h2>My Profile</h2>
            <?php if($result->user_type == 2){?>
            <div class="input_profile_box">
              <div class="col-md-3">
                <span>Shop name</span>
              </div>
              <div class="col-md-9">
                <div class="input_fields">
                  <input type="text" name="shop_name" placeholder="Shop Name (if empty then your name will be shown to customers)" value="<?=$result->shop_name?>">
                </div>
              </div>
            </div>
            <?php } ?>
            <div class="input_profile_box">
              <div class="col-md-3">
                <span>First name</span>
              </div>
              <div class="col-md-9">
                <div class="input_fields">
                  <input type="text" name="f_name" placeholder="First Name" value="<?=$result->f_name?>">
                </div>
              </div>
            </div>
            <div class="input_profile_box">
              <div class="col-md-3">
                <span>Last name</span>
              </div>
              <div class="col-md-9">
                <div class="input_fields">
                  <input type="text" name="l_name" placeholder="Last Name" value="<?=$result->l_name?>">
                </div>
              </div>
            </div>
            <div class="input_profile_box">
              <div class="col-md-3">
                <span>Email</span>
              </div>
              <div class="col-md-9">
                <div class="input_fields">
                  <input type="email" name="email" placeholder="Your Email" value="<?=$result->email?>">
                </div>
              </div>
            </div>
            <div class="input_profile_box">
              <div class="col-md-3">
                <span>Password</span>
              </div>
              <div class="col-md-9">
                <div class="input_fields">
                  <input type="text" name="password" placeholder="Password" value="">
                </div>
              </div>
            </div>
            <div class="input_profile_box">
              <div class="col-md-3">
                <span>Confirm Password</span>
              </div>
              <div class="col-md-9">
                <div class="input_fields">
                  <input type="text" name="confirm_password" placeholder="Confirm Password" value="">
                </div>
              </div>
            </div>
            <div class="input_profile_box">
              <div class="col-md-3">
                <span>Date of Birth</span>
              </div>
              <div class="col-md-9">
                <div class="input_fields">
                  <input type="text" name="dob" id="dob" placeholder="Date of Birth" value="<?=$result->dob?>" autocomplete="off" readonly>
                </div>
              </div>
            </div>
            <div class="input_profile_box">
              <div class="col-md-3">
                <span>Contact</span>
              </div>
              <div class="col-md-9">
                <div class="input_fields">
                  <input type="number" name="contact" placeholder="Your Contact Number" value="<?=$result->phone?>">
                </div>
              </div>
            </div>
          </div>
          <div class="right_profile_content">
            <div class="content_border"></div>
            <h2>Address</h2>
            <div class="input_profile_box">
              <div class="col-md-3">
                <span>Address</span>
              </div>
              <div class="col-md-9">
                <div class="input_fields">
                  <input type="text" id="address" name="address" placeholder="Your Street Address" value="<?=$result->address?>" autocomplete="off" >
                  <input type="hidden" name="address_hidden">
                </div>
              </div>
            </div>

            <input type="hidden" id="placeName" name="placeName" value="<?php echo $result->placeName; ?>" /> 
            <input type="hidden" id="placeLat" name="placeLat" value="<?php echo $result->placeLat; ?>" /> 
            <input type="hidden" id="placeLong" name="placeLong" value="<?php echo $result->placeLong; ?>" /> 

            <div class="input_profile_box">
              <div class="col-md-3">
                <span>Country</span>
              </div>
              <div class="col-md-9">
                <div class="input_fields">
                  <input type="text" name="country" placeholder="Country" value="<?=$result->country?>">
                </div>
              </div>
            </div>
            <div class="input_profile_box">
              <div class="col-md-3">
                <span>Post Code</span>
              </div>
              <div class="col-md-9">
                <div class="input_fields">
                  <input type="phone" name="zip_code" placeholder="Post Code" value="<?=$result->zip_code?>">
                </div>
              </div>
            </div>
            <div class="profile_map_section">
              
              <div id="map" style="width: 800px; height:200PX"></div>

              <!-- <iframe src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d6633805.364206802!2d-87.88941902534398!3d35.722215099780996!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1skingsland+!5e0!3m2!1sen!2sin!4v1555570498807!5m2!1sen!2sin" frameborder="0" style="border:0" allowfullscreen></iframe> -->



            </div>
          </div>
          <div class="profile_buttons">
            <button type="submit" class="button-1">save changes</button>
            <button type="reset" class="button-2">cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>



<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCCQzJ9DJLTRjrxLkRk6jaSrvcc5BfDtWM&libraries=places&sensor=false&amp;libraries=places"></script>
<script src="<?php echo base_url('front/js');?>/bootstrapValidator.min.js"></script>

<script type="text/javascript">

$(function() {
    $("#dob").datepicker({
        dateFormat: "dd MM yy",
        changeMonth: true,
        changeYear: true,
        maxDate: "-18Y",
        yearRange: "-50:+0",
    });
});

function initializez() {
    var input = document.getElementById('address');
    var autocomplete = new google.maps.places.Autocomplete(input);
    google.maps.event.addListener(autocomplete, 'place_changed', function () {
        var place = autocomplete.getPlace();
        document.getElementById('placeName').value = place.name;
        document.getElementById('placeLat').value = place.geometry.location.lat();
        document.getElementById('placeLong').value = place.geometry.location.lng();
    });
}
//google.maps.event.addDomListener(window, 'load', initialize);

$(document).ready(function() {
    
    var address = $('#address').val();
    var placeName = $('#placeName').val();
    var placeLat = $('#placeLat').val();
    var placeLong = $('#placeLong').val();
    initialize(placeLat, placeLong);   
    //var options = {
    //  zoom: 10,
    //  center: new google.maps.LatLng(placeLat,placeLong), // centered US
    //  mapTypeId: google.maps.MapTypeId.TERRAIN,
    //  mapTypeControl: false
    //};
    //var map = new google.maps.Map(document.getElementById('map_canvas'), options);
    //
    //var i = 1;
    //var icon = {
    //    url: "https://cdn4.iconfinder.com/data/icons/small-n-flat/24/map-marker-128.png", // url
    //    scaledSize: new google.maps.Size(30, 30), // scaled size
    //    origin: new google.maps.Point(0,0), // origin
    //    anchor: new google.maps.Point(0, 0) // anchor
    //};
    //
    //var marker = new google.maps.Marker({
    //    position: new google.maps.LatLng(placeLat,placeLong),
    //    map: map,
    //    title: placeName,
    //    icon: icon,
    //    //draggable: true,
    //    animation: google.maps.Animation.DROP,
    //});
    //
    //(function(marker, i) {
    //    google.maps.event.addListener(marker, 'click', function() {
    //        infowindow = new google.maps.InfoWindow({
    //            content: address
    //        });
    //        infowindow.open(map, marker);
    //    });
    //})(marker, i);

    $('#updateuserform').bootstrapValidator({
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            email: {
                validators: {
                    notEmpty: {
                        message: 'The email Field is required'
                    },
                    remote: {
                        type: 'POST',
                        url: "<?php echo site_url();?>user/check_email_exists1",
                        data: function(validator) {
                            return {
                                email: validator.getFieldElements('email').val()
                            };
                        },
                        message: 'This email is already in use.'
                    }
                },
            },
            password: {
                validators: {
                    identical: {
                        field: 'repassword',
                        message: 'The password and its confirm are not the same'
                    },
                    stringLength: {
                        min: 6,
                        max: 15,
                        message: 'The password length min 6 and max 15 character Long'
                    }
                }
            },
            confirm_password: {
                validators: {
                    identical: {
                        field: 'password',
                        message: 'The password and its confirm are not the same'
                    }
                }
            },
        }
    });
});
</script>


<?php $this->load->view('footer');?>    
<script>    
     var options = {        
        types: ['geocode'] //this should work !        
      };
	var input = document.getElementById('address');
	
    
      var componentForm = {
        street_number: 'short_name',
        route: 'long_name',
        premise: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'short_name',
        sublocality_level_1:'short_name',
        country: 'long_name',
        postal_code: 'short_name'
      };
      var autocomplete = new google.maps.places.Autocomplete(input,options);
        var place = autocomplete.getPlace();        
     // autocomplete.addListener('place_changed', function() {
     google.maps.event.addListener(autocomplete, 'place_changed', function() {
            var place = autocomplete.getPlace();
            //console.log(place);           
            document.getElementById('placeName').value = place.name;
            document.getElementById('placeLat').value = place.geometry.location.lat();
            document.getElementById('placeLong').value = place.geometry.location.lng();
            //code for remove other locality
            var addr = '';
            for (var i = 0; i < place.address_components.length; i++) {
              var addressType = place.address_components[i].types[0];
              //console.log(addressType);
              if (componentForm[addressType]) {
                
                var val = place.address_components[i][componentForm[addressType]];
                                
                if(addressType == 'premise'){
                    //console.log(val);
                    addr += val+' ';
                }
                if(addressType == 'route'){
                    //console.log(val);
                    addr += val+' ';
                }
                if(addressType == 'sublocality_level_1'){
                    //console.log(val);
                    addr += val+' ';
                }            
              }
            }            
            var geo = place.geometry.location;            
            //console.log(geo.lat());
            initialize(geo.lat(), geo.lng());
            $('#address_hidden').val(addr);
            //code for remove other locality
    });
</script>

<script type="text/javascript">
 
function initialize(lat, long) {    
    var latlng = new google.maps.LatLng(lat,long);
    var map = new google.maps.Map(document.getElementById('map'), {
      center: latlng,
      zoom: 10,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });
	
	var marker = new google.maps.Marker({
        position: latlng,
        map: map        
      });    
	  
}

</script>