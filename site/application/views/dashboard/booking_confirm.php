<div class="loader"></div>
<section class="admin-order">
  <div class="container">
    <div class="row">
      <div class="new-order">
        <h1>New Order</h1>
      </div>
    </div>
  </div>
</section>

<section class="admin-wrapper">
  <div class="container">
    <div class="cnft-book">
      <h6>Booking confirmation</h6>
      
      <div class="booked-cf">
        <div class="row">
          <div class="col-md-3 col-sm-3">
            <div class="veh-block">
              <img src="<?= IMAGEPATH ?><?= $bookingData['vehicle_category']['image'] ?>">
            </div>
          </div>
          <div class="col-md-3 col-sm-3">
            <p>Vehicle Type</p>
            <h3><?= $bookingData['cargo_type']['title'] ?></h3>
          </div>
          <div class="col-md-3 col-sm-3">
            <p>Vehicle Name</p>
            <h3><?= $bookingData['vehicle_type']['title'] ?></h3>
          </div>
          <div class="col-md-3 col-sm-3">
            <div class="add-cnf">
              <p>Tentative Cost</p>
              <h3><i class="fa fa-inr"></i> <?= $bookingData['total_amount'] ?></h3>
            </div>
            <div class="cnf-log">
              <img src="<?= base_url() ?>assets/images/selected.gif" alt="img">
            </div>
          </div>
        </div>
      </div>

      <div class="booking-info">
        <p>Booking ID : <strong><?= $bookingData['booking_id'] ?></strong></p>
        <!--<p>Transaction ID : <strong>0123456789ABC</strong></p>-->
        <p>Picup Location : <strong><?= $bookingData['pickup_address'] ?></strong></p>
        <p>Drop Location : <strong><?= $bookingData['drop_address'] ?></strong></p>
        <p>Estimated Distance : <strong><?= $bookingData['total_distance'] ?></strong></p>

        <h4>Thanks for booking with Zippy. We will get in touch with you shortly regarding pickup of your packages.</h4>
      </div>
    </div>
  </div>
</section>
