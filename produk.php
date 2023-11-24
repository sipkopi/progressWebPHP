<?php
require './koneksi/koneksi.php';

$kode_kopi = $_GET["kode_kopi"];

// Jalankan query
$result = query("SELECT 
    dk.*,
    dl.*,
    dp.*,
    du.*
FROM 
    data_kopi dk
JOIN 
    data_peremajaan dp ON dk.kode_peremajaan = dp.kode_peremajaan
JOIN 
    data_lahan dl ON dp.kode_lahan = dl.kode_lahan
JOIN 
    data_user du ON dl.user = du.user
WHERE 
    dk.kode_kopi = '$kode_kopi'");

// Periksa apakah hasil query tidak kosong
if (!empty($result)) {
    $swa = $result[0];
    // Lakukan sesuatu dengan data yang ditemukan
} else {
    // Tindakan yang diambil jika tidak ada hasil ditemukan
    echo "Data tidak ditemukan";
}
?>


<!DOCTYPE HTML>
<html>
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Data Produk</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<meta name="author" content="" />

  <!-- Facebook and Twitter integration -->
	<meta property="og:title" content=""/>
	<meta property="og:image" content=""/>
	<meta property="og:url" content=""/>
	<meta property="og:site_name" content=""/>
	<meta property="og:description" content=""/>
	<meta name="twitter:title" content="" />
	<meta name="twitter:image" content="" />
	<meta name="twitter:url" content="" />
	<meta name="twitter:card" content="" />

	<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
	<link rel="shortcut icon" href="favicon.ico">

	<link href="https://fonts.googleapis.com/css?family=Karla:400,700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,400i,700" rel="stylesheet">
	
	<!-- Animate.css -->
	<link rel="stylesheet" href="asetproduk/css/animate.css">
	<!-- Icomoon Icon Fonts-->
	<link rel="stylesheet" href="asetproduk/css/icomoon.css">
	<!-- Bootstrap  -->
	<link rel="stylesheet" href="asetproduk/css/bootstrap.css">
	<!-- Owl Carousel -->
	<link rel="stylesheet" href="asetproduk/css/owl.carousel.min.css">
	<link rel="stylesheet" href="asetproduk/css/owl.theme.default.min.css">
	<!-- Magnific Popup -->
	<link rel="stylesheet" href="asetproduk/css/magnific-popup.css">

	<link rel="stylesheet" href="./asetproduk/css/style.css">


	<!-- Modernizr JS -->
	<script src="asetproduk/js/modernizr-2.6.2.min.js"></script>
	<!-- FOR IE9 below -->
	<!--[if lt IE 9]>
	<script src="js/respond.min.js"></script>
	<![endif]-->

	</head>
	<body>

	<div id="colorlib-page">

		<div id="colorlib-about">
			<div class="container">
				<div class="row text-center">
					<h2 class="bold">Produk</h2>
				</div>
				<div class="row">
					<div class="col-md-5 animate-box">
						
							<div class="item">
								<img style="border-radius: 10px;" height="500" width="500" class="img-responsive about-img" src="<?php echo $swa['gambar2']; ?>" alt="html5 bootstrap template by colorlib.com">
							</div>
					
					</div>
					<div class="col-md-6 col-md-push-1 animate-box">
						<div class="about-desc">
							
								<div class="item">
									<h2><span><?php echo $swa['varietas_kopi']; ?></span></h2>
								</div>
						
							<div class="desc">
								<div class="rotate">
									<h2 class="heading">Produk</h2>
								</div>
								<p><?php echo $swa['deskripsi']; ?></p>

								<p><a href="<?php echo $swa['nohp']; ?>" class="btn btn-primary btn-outline">Contact Me!</a></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div id="colorlib-services">
			<div class="container">
				<div class="row text-center">
					<h2 class="bold">Informasi</h2>
				</div>
				<div class="row ">
					<div class="col-md-12 ">
						<div class="">
							<div class="one-third">
								<div class="row">
									<div class="col-md-12 col-md-offset-0 animate-box intro-heading">
										<span></span>
										<h2>Beberapa Informasi Tentang produk</h2>
									</div>
								</div>
								<div class="row ">
									<div class="col-md-12">
										<div class="rotate">
											<h2 class="heading">Informasi</h2>
										</div>
									</div>


										<div class="d-flex col-6 col-md-6">
										<div class="services animate-box">
											<h3>> Pemilik</h3>
											<ul>
												<li class="me-4">Nama: <span> <?php echo $swa['nama']; ?></span></li>
												<li class="me-4">Email: <span> <?php echo $swa['email']; ?></span></li>
												<li class="me-4">NoHp: <span> <?php echo $swa['nohp']; ?></span></li>
												
											</ul>
                                           
										</div>
										<div class="services text-dark animate-box">
											<h3>> Data Produk Kopi</h3>
											<ul>
												<li class=" text-dark me-4">Varietas: <span> <?php echo $swa['varietas_kopi']; ?></span></li>
												<li class=" text-dark me-4">Metode Pngolahan: <span> <?php echo $swa['metode_pengolahan']; ?></span></li>
                                                <li class=" text-dark me-4">Tanggal Panen: <span> <?php echo $swa['tgl_panen']; ?></span></li>
												<li class=" text-dark me-4">Tanggal Roasting: <span> <?php echo $swa['tgl_roasting']; ?></span></li>
												<li class=" text-dark me-4">Tanggal EXPIRED: <span> <?php echo $swa['tgl_exp']; ?></span></li>
												<li class=" text-dark me-4">berat: <span> <?php echo $swa['berat']; ?> GRAM</span></li>
                                            </ul>
										</div>
									</div>



									<div class="d-flex col-6 col-md-6">
										<div class="services animate-box">
											<h3>> Data Lahan</h3>
											<ul>
												<li class=" text-dark me-4">Varietas Pohon: <span> <?php echo $swa['varietas_pohon']; ?></span></li>
												<li class=" text-dark me-4">Total Bibit: <span> <?php echo $swa['total_bibit']; ?></span></li>
												<li class=" text-dark me-4">Luas Lahan: <span> <?php echo $swa['luas_lahan']; ?></span></li>
												<li class=" text-dark me-4">Ketinggian Tanam: <span> <?php echo $swa['ketinggian_tanam']; ?> M</span></li>
												<li class=" text-dark me-4">Tanggal Tanam: <span> <?php echo $swa['tanggal']; ?></span></li>
                                            </ul>
										</div>

										<div class="services animate-box">
											<h3>> Peremajaan</h3>
											<ul>
												<li class=" text-dark me-4" >Melakukan: <span> <?php echo $swa['perlakuan']; ?></span></li>
												<li class=" text-dark me-4">Tangal: <span> <?php echo $swa['tanggal']; ?></span></li>
												<li class=" text-dark me-4">Kebutuhan: <span> <?php echo $swa['kebutuhan']; ?> Liter</span></li>
												<li class=" text-dark me-4">Pupuk: <span> <?php echo $swa['pupuk']; ?></span></li>
                                            </ul>
										</div>
									</div>



								</div>
							</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

<div class="testmaps mb-5 container">
    <div class="mt-4 mb-4 text-center">
    <h1>Lokasi</h1>
    </div>

    <div class="card">
    <div class="card-body ">
            <!-- Tambahkan elemen div untuk menampung peta -->
            <div id="map" style="height: 400px; border-radius: 10px;"></div>
        </div>
    </div>
</div>

<style>
        /* Tambahkan border radius pada kartu */
        .card {
            border-radius: 15px;
        }
    </style>

		<footer class="mt-2">
			<div id="footer">
				<div class="container">

					<div class="row">
						<div class="col-md-12 text-center">
							<p>
								&copy; <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | <i class="icon-heart4" aria-hidden="true"></i> by <a href="https://sipkopi.com" target="_blank">SIP-KOPI</a>
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
							</p>
						</div>
					</div>
				</div>
			</div>
		</footer>
	
	</div>



    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap">
</script>

<script>
    // Fungsi untuk menginisialisasi peta
    function initMap() {
        // Lokasi default (contoh: Jakarta, Indonesia)
        var myLatLng = {lat: -6.2088, lng: 106.8456};

        // Buat peta dengan lokasi default
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 12,
            center: myLatLng
        });

        // Tambahkan marker pada peta
        var marker = new google.maps.Marker({
            position: myLatLng,
            map: map,
            title: 'Lokasi Anda'
        });
    }
</script>

	<!-- jQuery -->
	<script src="asetproduk/js/jquery.min.js"></script>
	<!-- jQuery Easing -->
	<script src="asetproduk/js/jquery.easing.1.3.js"></script>
	<!-- Bootstrap -->
	<script src="asetproduk/js/bootstrap.min.js"></script>
	<!-- Waypoints -->
	<script src="asetproduk/js/jquery.waypoints.min.js"></script>
	<!-- Owl Carousel -->
	<script src="asetproduk/js/owl.carousel.min.js"></script>
	<!-- Magnific Popup -->
	<script src="asetproduk/js/jquery.magnific-popup.min.js"></script>
	<script src="asetproduk/js/magnific-popup-options.js"></script>

	<!-- Main JS (Do not remove) -->
	<script src="asetproduk/js/main.js"></script>

	</body>
</html>




<!-- <h1>kopi</h1>

<p><?php echo $swa['kode_kopi']; ?></p>
<p><?php echo $swa['kode_peremajaan']; ?></p>
<p><?php echo $swa['varietas_kopi']; ?></p>
<p><?php echo $swa['metode_pengolahan']; ?></p>
<p><?php echo $swa['tgl_roasting']; ?></p>
<p><?php echo $swa['tgl_panen']; ?></p>
<p><?php echo $swa['tgl_exp']; ?></p>
<p><?php echo $swa['berat']; ?></p>
<p><?php echo $swa['link']; ?></p>
<p><?php echo $swa['deskripsi']; ?></p>
<p><?php echo $swa['gambar1']; ?></p>
<p><?php echo $swa['gambar2']; ?></p>
<p><?php echo $swa['gambarqr']; ?></p>

<h1>lahan</h1>
<p><?php echo $swa['kode_lahan']; ?></p>
<p><?php echo $swa['user']; ?></p>
<p><?php echo $swa['varietas_pohon']; ?></p>
<p><?php echo $swa['total_bibit']; ?></p>
<p><?php echo $swa['luas_lahan']; ?></p>
<p><?php echo $swa['tanggal']; ?></p>
<p><?php echo $swa['ketinggian_tanam']; ?></p>
<p><?php echo $swa['longtitude']; ?></p>
<p><?php echo $swa['latitude']; ?></p>

<h1>peremajaan</h1>
<p><?php echo $swa['kode_peremajaan']; ?></p>
<p><?php echo $swa['kode_lahan']; ?></p>
<p><?php echo $swa['perlakuan']; ?></p>
<p><?php echo $swa['tanggal']; ?></p>
<p><?php echo $swa['kebutuhan']; ?></p>
<p><?php echo $swa['pupuk']; ?></p>

<h1>user</h1>
<p><?php echo $swa['user']; ?></p>
<p><?php echo $swa['nama']; ?></p>
<p><?php echo $swa['email']; ?></p>
<p><?php echo $swa['nohp']; ?></p>
<p><?php echo $swa['pass']; ?></p>
<p><?php echo $swa['lokasi']; ?></p>
<p><?php echo $swa['level']; ?></p>
<p><?php echo $swa['tanggal_create']; ?></p>
<p><?php echo $swa['gambar']; ?></p> -->

