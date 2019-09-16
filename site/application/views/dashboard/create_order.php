<script>
var placeSearch, pickupaddress,dropaddress;
var componentForm = {
  street_number: 'short_name',
  route: 'long_name',
  locality: 'long_name',
  administrative_area_level_1: 'short_name',
  country: 'long_name',
  postal_code: 'short_name'
};

function initAutocomplete() {
  pickupaddress = new google.maps.places.Autocomplete(
      /** @type {!HTMLInputElement} */(document.getElementById('pickupaddress')),
      {types: ['geocode']});

  pickupaddress.addListener('place_changed', fillInAddress);

  dropaddress = new google.maps.places.Autocomplete(
      /** @type {!HTMLInputElement} */(document.getElementById('dropaddress')),
      {types: ['geocode']});

  // When the user selects an address from the dropdown, populate the address
  // fields in the form.
  dropaddress.addListener('place_changed', fillInAddress);
}

function fillInAddress() {
  // Get the place details from the autocomplete object.
  var place = pickupaddress.getPlace();

  for (var component in componentForm) {
    document.getElementById(component).value = '';
    document.getElementById(component).disabled = false;
  }

  // Get each component of the address from the place details
  // and fill the corresponding field on the form.
  for (var i = 0; i < place.address_components.length; i++) {
    var addressType = place.address_components[i].types[0];
    if (componentForm[addressType]) {
      var val = place.address_components[i][componentForm[addressType]];
      document.getElementById(addressType).value = val;
    }
  }
}

// Bias the autocomplete object to the user's geographical location,
// as supplied by the browser's 'navigator.geolocation' object.
function geolocate() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var geolocation = {
        lat: position.coords.latitude,
        lng: position.coords.longitude
      };

      var circle = new google.maps.Circle({
        center: geolocation,
        radius: position.coords.accuracy
      });
      autocomplete.setBounds(circle.getBounds());
    });
  }
  calcDistance();
}

function getLatLong(address,id){
  var geocoder = new google.maps.Geocoder();
  geocoder.geocode( { 'address': address}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        var latitude = results[0].geometry.location.lat();
        var longitude = results[0].geometry.location.lng();
        $("#"+id).val(latitude+","+longitude);
      } 
    }); 
    calcDistance();
}

function calcDistance() {
      var source = $("#pickupaddress").val();
      var destination = $("#dropaddress").val();
      var service = new google.maps.DistanceMatrixService();
      service.getDistanceMatrix({
          origins: [source],
          destinations: [destination],
          travelMode: google.maps.TravelMode.DRIVING,
          unitSystem: google.maps.UnitSystem.METRIC,
          avoidHighways: false,
          avoidTolls: false
      }, function (response, status) {
          if (status == google.maps.DistanceMatrixStatus.OK && response.rows[0].elements[0].status != "ZERO_RESULTS") {
              var distance = response.rows[0].elements[0].distance.text;
              var duration = response.rows[0].elements[0].duration.text;
              distancefinel = distance.split(" ");
              $('#distance').html(distance);
              $('#total_distance').val(distance);
          } else {
             // alert("Unable to find the distance via road.");
          }
      });
}
</script>
<section class="admin-order">
  <div class="container">
    <div class="row">
      <div class="new-order">
        <h1>New Order</h1>
        <div id="conf_msg" class="right-head hide">
          <h1>confirm detail to get suggestions</h1>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="admin-wrapper">
  <form id="booking" name="booking" action="<?= site_url('dashboard/create_order') ?>" method="post">
  <div id="booking-form" class="container">
    <div class="row">
      <div class="col-sm-6 col-md-6">
        <div class="picup-wrap login-form pichup-frm ">
            <?php echo validation_errors('<div class="alert alert-danger">','</div>'); ?>
            <?php 
              if(isset($error)){
                if($error == '1'){
                  foreach($errorData as $err){
                    foreach($err as $key => $value){
                      echo '<div class="alert alert-danger">';
                      echo $value;
                      echo '</div>';
                    }
                  }
                }else{
                  if(isset($message)){
                    echo '<div class="alert alert-success">';
                    echo $message;
                    echo '</div>';
                  }
                }
              }
            ?>
            <div class="form-group">
              <label>1. Provide pickup location</label>
              <input type="text" name="pickup_address" onFocus="geolocate()" onblur="getLatLong(this.value,'pickuplatlong')" id="pickupaddress" class="form-control" placeholder="Pickup location">
              <input type="hidden" name="pickup_coordinates" id="pickuplatlong" />
              <img src="<?= base_url() ?>assets/images/location-1.png">
            </div>
            <div class="form-group">
              <label>2. Provide drop location</label>
              <input type="text" name="drop_address" onFocus="geolocate()" onblur="getLatLong(this.value,'droplatlong')" id="dropaddress" class="form-control" placeholder="Drop location">
              <input type="hidden" name="drop_coordinates" id="droplatlong" />
              <img src="<?= base_url() ?>assets/images/location-2.png">
            </div>
            <div class="form-group new-set">
              <label>3. Type of cargo</label>
              <select name="cargo_type_id" class="form-control" onfocus="calcDistance()">
                <option value=""> Select cargo</option>
                <?php
                  foreach($cargos as $cargo){ ?>
                ?>
                  <option value="<?= $cargo['cargo_type_id'] ?>"> <?= $cargo['title'] ?></option>
                <?php } ?>
              </select>
              <img src="<?= base_url() ?>assets/images/cargo.png">
            </div>

            <div class="form-group new-set">
              <label>4. Type of vehicle required</label>
              <select name="vehicle_type_id" class="form-control">
                <option  value=""> Select vehicle</option>
                <?php
                  foreach($vehicles as $vehicle){ ?>
                ?>
                  <option value="<?= $vehicle['vehicle_type_id'] ?>"> <?= $vehicle['title'] ?></option>
                <?php } ?>
              </select>
              <img src="<?= base_url() ?>assets/images/cargo.png">
            </div>

            <div class="form-group">
              <label>5. Gross weight (Approx in Kilograms)</label>
              <input type="text" name="gross_weight" class="form-control" placeholder="e.g 100">
              <img src="<?= base_url() ?>assets/images/weight.png">
            </div>
            <div class="form-group inches-list">
              <label>6. Gross of Carton (in inches)</label>
              <div class="row">
                <div class="col-md-4 col-sm-4">
                  <div class="form-group">
                    <input type="text" name="carton_lenght" class="form-control" placeholder="Length">
                    <img src="<?= base_url() ?>assets/images/scale.png">
                  </div>
                </div>
                <div class="col-md-4 col-sm-4">
                  <div class="form-group">
                    <input type="text" name="carton_breadth" class="form-control" placeholder="Breadth">
                    <img src="<?= base_url() ?>assets/images/scale.png">
                  </div>
                </div>
                <div class="col-md-4 col-sm-4">
                  <div class="form-group">
                    <input type="text" name="carton_height" class="form-control" placeholder="Height">
                    <img src="<?= base_url() ?>assets/images/scale.png">
                  </div>
                </div>
              </div>
            </div>
            <input type="hidden" name="total_distance" id="total_distance" />
            <div class="btn-group" id="firstbtn">
              <button type="reset" class="btn btn-main cler">clear</button>
              <button type="button" onclick="confirm_booking()" class="btn btn-main">next</button>
            </div>
            <div class="btn-group hide" id="scndbtn">
              <button type="button" onclick="go_back()" class="btn btn-main cler">Back</button>
              <button type="button" onclick="submit_booking()" class="btn btn-main">Submit</button>
            </div>
        </div>
      </div>
      <div class="col-sm-5 col-md-5">
        <div class="loavc-total">
          <div class="total-dis">
            <img src="<?= base_url() ?>assets/images/distance.png"> 
            <p>total distance (approx)</p>
            <h4 id="distance"></h4>
          </div>
        </div>
      </div>
    </div>
  </div>


  <div id="suggested-vehicles" class="container hide">
    <input type="hidden" name="vehicle_category_id" id="vehicle_category_id" />
    <div class="cnft-book">
      <h6>Based on your requirements. we have below suggestions for you :-</h6>
      <div class="listed-vehicles">
        <?php
          foreach($vehiclesList as $vehicles){
        ?>
        <div id="veh-<?= $vehicles['id'] ?>" onclick="selectVehicle('<?= $vehicles['id'] ?>')" class="booked-cf">
          <div class="row">
            <div class="col-md-3 col-sm-3">
              <div class="veh-block">
                <img src="<?= IMAGEPATH ?><?= $vehicles['image'] ?>">
              </div>
            </div>
            <div class="col-md-3 col-sm-3">
              <p>Vehicle Type</p>
              <h3>Mini Truck</h3>
            </div>
            <div class="col-md-3 col-sm-3">
              <p>Vehicle Name</p>
              <h3><?= $vehicles['title'] ?></h3>
            </div>
            <div class="col-md-3 col-sm-3">
              <div class="add-cnf">
                <p>Tentative Cost</p>
                <h3><i class="fa fa-inr"></i> <?= $vehicles['price'] ?></h3>
              </div>
              <div class="cnf-log">
                <img src="<?= base_url() ?>assets/images/selected.gif" alt="img">
              </div>
            </div>
          </div>
        </div>
        <?php } ?>
      </div>
      <div class="btn-group">
        <a href="<?= site_url('dashboard/create_order') ?>" class="btn-main cler">Cancle</a>
        <button id="confirm-booking" onclick="book_now()" disabled class="btn btn-main">Confirm booking</button>
      </div>
    </div>
  </div>
</form>
</section>
<script type="text/javascript">

function confirm_booking(){
  $("#firstbtn").addClass('hide');
  $("#conf_msg").removeClass('hide');
  $(".picup-wrap").addClass('disable-frm');
  $("#scndbtn").removeClass('hide');
  $(".form-control").attr("disabled","true");
}
function go_back(){
  $("#firstbtn").removeClass('hide');
  $("#conf_msg").addClass('hide');
  $(".picup-wrap").removeClass('disable-frm');
  $("#scndbtn").addClass('hide');
  $(".form-control").removeAttr("disabled");
}
function submit_booking(){
    $("#conf_msg").addClass('hide');
  $(".form-control").removeAttr("disabled");
  $("#booking-form").addClass("hide");
  $("#suggested-vehicles").removeClass("hide");
}
function selectVehicle(id){
  $(".booked-cf").removeClass("active");
  $("#veh-"+id).addClass("active");
  $("#vehicle_category_id").val(id);
  var vehicle = $("#vehicle_category_id").val();
  if(vehicle == ''){
    $("#confirm-booking").attr("disabled",'true');
  }else{
    $("#confirm-booking").removeAttr("disabled");
  }
   var vehicle = $("#vehicle_category_id").val();
    if(vehicle == ''){
      $("#confirm-booking").attr("disabled",'true');
    }else{
      $("#confirm-booking").removeAttr("disabled");
    }
}
function book_order(){
  $("#booking").submit();
}

</script>