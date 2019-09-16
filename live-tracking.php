<?php

require __DIR__.'/zippy/vendor/autoload.php';

$app = require_once __DIR__.'/zippy/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);


$booking = null;

if( $id = request('booking_id') ) {
  $booking = \App\Booking::findOrFail($id);
  $customer = $booking->customer;
  $vendor = $booking->vendor;
}

if( !$booking ) return;
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Map</title>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
    <script type="text/javascript">
      
      var aLat = '<?php echo $booking->pickup_lat; ?>';
      var aLng = '<?php echo $booking->pickup_lng; ?>';

      var bLat = '<?php echo $booking->drop_lat; ?>';
      var bLng = '<?php echo $booking->drop_lng; ?>';

    </script>
  </head>
  <body>
    
    <div class="top-bar">
            <!-- <span class="io-bus-tracker">Transport Tracker</span>
            <span class="display-time">6:00 AM, May 17th</span> -->
            <span class="google-maps-apis"></span>
        </div>
        <div class="cards"></div>
        <div class="promo-container"></div>
        <div id="map"></div>

    <script src="https://www.gstatic.com/firebasejs/3.8.0/firebase.js"></script>
    <script src="media/map-js/index.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAwyu5TbSiXZOGT2tYfHi_K7o2Zer_WnDo&callback=initMap"
    async defer></script>
  </body>
</html>