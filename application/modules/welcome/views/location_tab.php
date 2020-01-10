    <div class="servicebox">
    <form id="locationform" method="post" action="#">
        <input type="hidden" name="address_hidden" id="address_hidden" value="<?php echo ($this->session->userdata('location_cart')) ? $this->session->userdata('location_cart')['address_hidden'] : ''?>">
        <div class="form_group">
            <div class="form_input">
                <input type="text" id="location" name="location" placeholder="Enter your address" class="form-control" value="<?php echo ($this->session->userdata('location_cart')) ? $this->session->userdata('location_cart')['location'] : ''?>" required autocomplete="off">
                <div class="danger" id="location_error" role="alert" style="display: none; color:red">
                    This field is required.
                </div>
            </div>
        </div>
        
        <div class="form_group">
            <div class="row">
                <div class="col-md-6">
                     <div class="form_input">
                        <input type="text" id="street" name="street" placeholder="Enter your street name" class="form-control" value="<?php echo ($this->session->userdata('location_cart')) ? $this->session->userdata('location_cart')['street'] : ''?>" required>
                        <div class="danger" id="street_error" role="alert" style="display: none; color:red">
                            This field is required.
                        </div>
                    </div> 
                </div>
                <div class="col-md-6">
                     <div class="form_input">
                        <input type="text" id="house" name="house" placeholder="Enter your House number" class="form-control" value="<?php echo ($this->session->userdata('location_cart')) ? $this->session->userdata('location_cart')['house'] : ''?>" required>
                        <div class="danger" id="house_error" role="alert" style="display: none; color:red">
                            This field is required.
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="form_group">
            <div class="form_input">
                <input type="text" id="landmark" name="landmark" placeholder="Enter Landmark" class="form-control" value="<?php echo ($this->session->userdata('location_cart')) ? $this->session->userdata('location_cart')['landmark'] : ''?>">
                <div class="danger" id="landmark_error" role="alert" style="display: none; color:red">
                    This field is required.
                </div>
            </div>
        </div>
        <br>
        <div class="form_group">
            <div class="form_input">
               <!--<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6959761.014640264!2d50.69992317560584!3d31.566893458551075!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ef7ec2ec16b1df1%3A0x40b095d39e51face!2sIran!5e0!3m2!1sen!2sin!4v1552371736211" allowfullscreen=""></iframe>-->
               <div id="map" style="width:100%; height:300px;"></div>
            </div>
        </div>        
       <?php if(trim($servicemethod) == 'On Site'){ ?>
           <input type="hidden" value="schedule" id="next_tab">
       <?php }else{ ?>
           <input type="hidden" value="provider" id="next_tab">
       <?php } ?>
       <!--<span class="btn btn-primary" onclick="save_location();">Save</span>-->
    </form>
    </div>
    <div id="loader" style="display:none;"><img src="https://media.theaustralian.com.au/fe/sop/wait.gif"></div>
    
<script>    
     var options = {        
        //types: ['geocode'] //this should work !
        componentRestrictions: {country: "AE"}
      };
	var input = document.getElementById('location');
	
    
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
            console.log(place);
            var geo = place.geometry.location;            
            //console.log(geo.lat());
            initialize(geo.lat(), geo.lng());
            $('#address_hidden').val(place.formatted_address);
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