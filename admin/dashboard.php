<?php
session_start();
 
if (!isset($_SESSION['nama'])) {
    header("Location: indexlogin.php");
    exit(); // Terminate script execution after the redirect
}


ob_start(); // Mulai output buffering


require '../koneksi/koneksi.php';
	$queryuser=query("SELECT * FROM data_user");
    $querykopi=query("SELECT * FROM data_kopi");

?>

<?php $j_user = 0 ?>
<?php foreach ($queryuser as $getdata ) :?>
<?php $j_user = $j_user + 1 ?>
<?php endforeach; ?>

<?php $j_kopi = 0 ?>
<?php foreach ($querykopi as $getdata ) :?>
<?php $j_kopi = $j_kopi + 1 ?>
<?php endforeach; ?>

<link rel="stylesheet" href="../assets/vendor/css/pages/cards-advance.css" />
<link rel="stylesheet" href="../assets/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/apex-charts/apex-charts.css" />


<div class="row">
                <!-- Website Analytics -->


<!-- Subscriber Gained -->
<div class="col-lg-3 col-sm-6 mb-4">
                  <div class="card">
                    <div class="card-body pb-0">
                      <div class="card-icon">
                        <span class="badge bg-label-primary rounded-pill p-2">
                          <i class="ti ti-users ti-sm"></i>
                        </span>
                      </div>
                      <h5 class="card-title mb-0 mt-2"><?php echo $j_user ?></h5>
                      <small>Data User</small>
                    </div>
                    <div id="subscriberGained"></div>
                  </div>
                </div>

                <!-- Quarterly Sales -->
                <div class="col-lg-3 col-sm-6 mb-4">
                  <div class="card">
                    <div class="card-body pb-0">
                      <div class="card-icon">
                        <span class="badge bg-label-danger rounded-pill p-2">
                          <i class="ti ti-shopping-cart ti-sm"></i>
                        </span>
                      </div>
                      <h5 class="card-title mb-0 mt-2"><?php echo $j_kopi ?></h5>
                      <small>Data Produk Kopi</small>
                    </div>
                    <div id="quarterlySales"></div>
                  </div>
                </div>

                <!-- Order Received -->
                <div class="col-lg-3 col-sm-6 mb-4">
                  <div class="card">
                    <div class="card-body pb-0">
                      <div class="card-icon">
                        <span class="badge bg-label-warning rounded-pill p-2">
                          <i class="ti ti-package ti-sm"></i>
                        </span>
                      </div>
                      <h5 class="card-title mb-0 mt-2">97.5k</h5>
                      <small>Generate Barqode</small>
                    </div>
                    <div id="orderReceived"></div>
                  </div>
                </div>

                <!-- Revenue Generated -->
                <div class="col-lg-3 col-sm-6 mb-4">
                  <div class="card">
                    <div class="card-body pb-0">
                      <div class="card-icon">
                        <span class="badge bg-label-success rounded-pill p-2">
                          <i class="ti ti-credit-card ti-sm"></i>
                        </span>
                      </div>
                      <h5 class="card-title mb-0 mt-2">97.5k</h5>
                      <small>Pengunjung</small>
                    </div>
                    <div id="revenueGenerated"></div>
                  </div>
                </div>

</div>

    <!-- Vendors JS -->
    <script src="../assets/vendor/libs/apex-charts/apexcharts.js"></script>
   
    <!-- Page CSS -->
<script src="../assets/js/cards-statistics.js"></script>


<?php
$content = ob_get_clean(); // Ambil konten yang telah di-buffer

include '../admin/body.php';

?>