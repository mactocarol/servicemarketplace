<?php $this->load->view('header');?>

    <section class="breadcrumb_outer">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h2 class="text-capitalize">Signup Step 2</h2>
                </div>
                <div class="col-lg-6">
                     <ol class="breadcrumb pull-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Signup Step 2</li>
                      </ol>
                </div>
            </div>
        </div>
    </section>
    <!-- signup form Start -->
    <div class="signup_wrapper pad_top_bottom_50">
        <div class="container">
            <div class="form_wrapper_main">
                <div class="signup_header">
                    <h3>Apply now as a service provider</h3>
                    <p>Simply fill out the application</p>
                </div>
                <div class="step_wizard">
                    <a href="signup_step1.html" class="step_circle active"><i class="fas fa-check"></i></a>
                    <a href="#" class="step_circle current">2</a>
                    <a href="#" class="step_circle">3</a>
                    <a href="#" class="step_circle">4</a>
                </div>
                <div class="signup_header">
                    <h3>Tell us about yourself</h3>
                    <p>Where are you based?</p> 
                </div>
                <!-- form Start -->
                <div class="col-lg-6 col-md-8 col-lg-offset-3 col-md-offset-2 col-xs-12">
                    <div class="register_form_wrap">
                        <form id="form" method="post" action="<?php echo site_url('user/service_register_two');?>">
                            <div class="form_group">
                                <div class="form_input">
                                    <input type="text" id="locationn" name="location" placeholder="Enter a location">
                                </div>
                            </div>
                            <div class="form_group">
                                <div class="form_input">                                   
                                   <div id="map" style="width:100%; height:300px;"></div>
                                </div>
                            </div>
                            <!--<div class="form_group">
                                <div class="form_input">
                                    <select name="city" class="">
                                        <option value="">Select City</option>
                                        <option value="Tehran">Tehran </option>
                                        <option value="Mashhad">Mashhad</option>
                                        <option value="Isfahan">Isfahan</option>
                                    </select>
                                </div>
                            </div>-->
                            <input type="hidden" id="placeName" name="placeName" value="" /> 
                            <input type="hidden" id="placeLat" name="placeLat" value="" /> 
                            <input type="hidden" id="placeLong" name="placeLong" value="" />
                            <input type="hidden" name="sellerid" value="<?=$sellerid?>">
                            <div class="button_wrap">
                                <button type="button" name="" onclick="submit_form();" class="red_button submit_btn">Next</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- form End -->
            </div>
        </div>
    </div>
    <!-- signup form End -->
    

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        function submit_form(){
            if($.trim($('#locationn').val()) == ''){
                swal('Please Select Location');
                return false;
            }
            $('#form').submit();
        }
    </script>
   

<script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyCCQzJ9DJLTRjrxLkRk6jaSrvcc5BfDtWM" type="text/javascript"></script>
<?php $this->load->view('footer');?>    
<script>    
     var options = {        
        types: ['geocode'] //this should work !        
      };
	var input = document.getElementById('locationn');
	
    
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
     // autocomplete.addListener('place_changed', function() {
     google.maps.event.addListener(autocomplete, 'place_changed', function() {
            var place = autocomplete.getPlace();
            document.getElementById('placeName').value = place.name;
            document.getElementById('placeLat').value = place.geometry.location.lat();
            document.getElementById('placeLong').value = place.geometry.location.lng();
            //console.log(place);
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
initialize(25.2048, 55.2708);    
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