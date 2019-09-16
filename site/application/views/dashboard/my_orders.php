<div class="loader"></div>
<section class="admin-order">
  <div class="container">
    <div class="row">
      <div class="new-order">
        <h1>My Orders</h1>
      </div>
    </div>
  </div>
</section>

<section class="admin-wrapper">
  <div class="container">
  <div class="row">
    <div class="col-md-11 col-lg-11">
      <div class="myorders">
        <div class="table-responsive">
          <table id="example" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
          <thead>
              <tr>
                  <th class="no-sort"></th>
                  <th>Vehicle Category</th>
                  <th>Vehicle Type</th>
                  <th>Pickup Address</th>
                  <th>Drop Address</th>
                  <th>Distance</th>
                  <th>Total Amount</th>
              </tr>
          </thead>
          <tbody>
            <?php foreach($orders as $order){ ?>
              <tr onclick="submitform('f<?= $order['booking_id'] ?>')">
                  <td><img src="<?= IMAGEPATH ?><?= $order['vehicle_category']['image'] ?>" width="100" /></td>
                  <td><?= $order['vehicle_category']['title'] ?></td>
                  <td><?= $order['vehicle_type']['title'] ?></td>
                  <td><?= $order['pickup_address'] ?></td>
                  <td><?= $order['drop_address'] ?></td>
                  <td><?= $order['total_distance'] ?> Kms</td>
                  <td><i class="fa fa-inr"></i>
                    <?= $order['total_amount'] ?>
                    <form method="post" action="<?= site_url('dashboard/order_detail') ?>" id="f<?= $order['booking_id'] ?>" name="f<?= $order['booking_id'] ?>">
                      <textarea class="hide" name="order_data"><?= json_encode($order) ?></textarea>
                    </form>
                  </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
    </div>
  </div>
</div>
</section>

<script>
function submitform(id){
  $("#"+id).submit();
}
</script>