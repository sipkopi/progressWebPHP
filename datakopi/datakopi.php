<?php

ob_start(); // Mulai output buffering

session_start();
if (!isset($_SESSION['nama'])) {
    header("Location: ../admin/indexlogin.php");
    exit(); // Terminate script execution after the redirect
}

?>



<?php
require '../koneksi/koneksi.php';


	$query=query("SELECT * FROM data_kopi");


  $queryy = "SELECT kode_kopi FROM data_kopi ORDER BY	kode_kopi DESC LIMIT 1";
  $resultt = mysqli_query($koneksi, $queryy);
  
  if ($resultt) {
      $row = mysqli_fetch_assoc($resultt);
      if ($row) {
          $lastCode = $row['kode_kopi'];
  
          // Extract nomor urut dari kode PPK terakhir
          $lastNumber = (int)substr($lastCode, 2);
  
          // Tambahkan 1 ke nomor urut
          $newNumber = $lastNumber + 1;
  
          // Format nomor urut dengan nol di depan jika kurang dari 10
          if ($newNumber < 10) {
              $newCode = "KP000" . $newNumber;
          } elseif ($newNumber < 100) {
              $newCode = "KP00" . $newNumber;
          } else {
              $newCode = "KP0" . $newNumber;
          }
      } else {
          // Kode PPK awal jika tidak ada data
          $newCode = "KP0001";
      }
  } else {
      // Handle jika query tidak berhasil
      // Misalnya, Anda bisa mengatur kode PPK awal di sini
      $newCode = "KP0001";
  }


// ambil data 
if( isset($_POST["submit"]) ) {
		
  // hubungkan metod dan jika data > 0 / maka terisi succes paham!!
  if (tambahkopi ($_POST) > 0 ) {
    echo "
    <script>
        document.location.href = 'datakopi.php';
    </script>
    ";
  }else {
    echo "
      <script>
        document.location.href = 'datakopi.php';
      </script>
    ";
  }		
}

?>

<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">

  <!-- alert data berhasil -->
  <?php
    if (isset($_GET['alert']) && $_GET['alert'] == 'success') {
        echo '<div class="alert alert-primary" role="alert">Data Baru Telah Ditambah</div>';
    }
    ?>
        <script>
        // Fungsi untuk menghilangkan pesan alert setelah 3 detik
        setTimeout(function() {
            var alertDiv = document.querySelector('.alert');
            if (alertDiv) {
                alertDiv.style.display = 'none';
            }
        }, 5000); // 3000 milidetik (3 detik)
    </script>



<div class="card">
        <div class="card-header">
 <div class=" d-flex flex-column mb-3 flex-md-row justify-content-between align-items-center"> <!-- Menambahkan class align-items-center -->
    <h2>Data Kopi</h2>
    <div >

    
        <div class="btn btn-label-primary dropdown-toggle me-2" data-bs-toggle="dropdown" ><i class="ti ti-file-export me-sm-1"></i> <span class="d-none d-sm-inline-block">Export</span></div>
        <button type="button" data-bs-toggle="modal" class="btn btn-primary" data-bs-target="#tambahModal"><i class="ti ti-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Tambah Data</span></button>

        <div class="dropdown-menu">
         <a class="dropdown-item" href="javascript:void(0);" id="printTable"
         ><i class="ti ti-copy me-1" ></i>Copy</a>
         <a class="dropdown-item ssedtt" href="javascript:void(0);" id="csvTable"
         ><i class="ti ti-file-spreadsheet me-1" ></i>Exel</a>
         <a class="dropdown-item ssedtvt" href="javascript:void(0);" id="excelTable"
          ><i class="ti ti-file-text me-1"></i>CSV</a>
          <a class="dropdown-item ssdele" href="javascript:void(0);" id="pdfTable"
          ><i class="ti ti-file-description me-1"></i>Pdf</a>
          <a class="dropdown-item " href="javascript:void(0);"  id="copyTable"
          ><i class="ti ti-printer me-1" ></i>Print</a>
        </div>
    </div>
</div>


<div class="table-responsive text-nowrap mb-2">
  <table id="table-user" class="table table-hover display">
    <thead class="table-light">
      <tr>
        <th>No</th>
        <th>Kode Kopi</th>
        <th>Kode Peremajaan</th>
        <th>Metode Pengolahan</th>
        <th>Tgl Panen</th>
        <th>Tgl EXP</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody class="table-border-bottom-0 mb-5">
    <?php $a=1; ?>
      <?php foreach ($query as $getdata) : ?>
        <tr>
        <td><?= $a; ?></td>
          <td class="p-3"><?= $getdata["kode_kopi"]; ?></td>
          <td><?= $getdata["kode_peremajaan"]; ?></td>
          <td><?= $getdata["metode_pengolahan"]; ?></td>
          <td><?= $getdata["tgl_panen"]; ?></td>
          <td><?= $getdata["tgl_exp"]; ?></td>
            <!-- <img src="<?= $getdata["gambar"]; ?>" alt="Avatar" class="rounded-circle" style="width: 40px; height: 40px;"> -->
          
          <td>
            <div class="dropdown">
              <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                <i class="ti ti-dots-vertical"></i>
              </button>
              <div class="dropdown-menu">
              <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#largeModal<?= $getdata["kode_kopi"]; ?>"
                  ><i class="ti ti-list-details me-1"></i></i> Detail Data</button>
                <a class="dropdown-item ssedtt" href="editkopi.php?kode_kopi=<?=$getdata["kode_kopi"];?>"
                  ><i class="ti ti-pencil me-1"></i> Edit</a>
                  <a class="dropdown-item ssdele" href="javascript:void(0);"
                data-KP="<?=$getdata["kode_kopi"];?>"
                data-vari="<?=$getdata["varietas_kopi"];?>">
                <i class="ti ti-trash me-1"></i> Hapus Data
                </a>
              </div>
            </div>
          </td>
          
        </tr>
        <?php  $a++; ?>
      <?php endforeach; ?>
    </tbody>
  
  </table >
  </div>
  </div>


                    <!-- Detail Modal -->
                    <?php foreach ($query as $getdataa) : ?>
                      <div class="modal fade" id="largeModal<?= $getdataa["kode_kopi"]; ?>" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel3">Detail Kopi</h5>
                              <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="modal"
                                aria-label="Close"></button>
                            </div>
                            <div class="modal-body">

                              <div class="row">
                                <div class="col mb-3">
                                  <label for="nameLarge" class="form-label">Kode Kopi</label>
                                  <input type="text" readonly class="form-control" placeholder="" value="<?= $getdataa["kode_kopi"]; ?>" />
                                </div>
                              </div>
                              <div class="row g-2 mb-3">
                                <div class="col mb-0">
                                  <label for="dobLarge" class="form-label">Kode Peremajaan</label>
                                  <input type="text" readonly class="form-control" placeholder="" value="<?= $getdataa["kode_peremajaan"]; ?>" />
                                </div>
                                <div class="col mb-0">
                                  <label for="emailLarge" class="form-label">Varietas Kopi</label>
                                  <input type="email" value="<?= $getdataa["varietas_kopi"]; ?>" readonly class="form-control" placeholder="" />
                                </div>
                              </div>
                              <div class="row g-2 mb-3">

                              <div class="col mb-0">
                                  <label for="emailLarge" class="form-label">Metode Pengolahan</label>
                                  <input type="text" value="<?= $getdataa["metode_pengolahan"]; ?>" readonly class="form-control" placeholder="" />
                                </div>
                                <div class="col mb-0">
                                  <label for="emailLarge" class="form-label">Berat ( GRAM )</label>
                                  <input type="number" value="<?= $getdataa["berat"]; ?>" readonly class="form-control" placeholder="" />
                                </div>
 
                                </div>
                               
                                <div class="row g-2 mb-3">
                                <div class="col mb-0">
                                  <label for="emailLarge" class="form-label">Tanggal Panen</label>
                                  <input type="date" value="<?= $getdataa["tgl_panen"]; ?>" readonly class="form-control" placeholder="" />
                                </div>

                                <div class="col mb-0">
                                  <label for="emailLarge" class="form-label">Tanggal Roasting</label>
                                  <input type="date" value="<?= $getdataa["tgl_roasting"]; ?>" readonly class="form-control" placeholder="" />
                                </div>


                                <div class="col mb-0">
                                  <label for="emailLarge" class="form-label">Tgl Expired</label>
                                  <input type="date" class="form-control" value="<?= $getdataa["tgl_exp"]; ?>" readonly placeholder="" />
                                </div>
                                </div>


                                <div class="row g-2 mb-2 mt-2">
                                <label for="exampleFormControlTextarea1">Deskripsi</label>
                                <textarea type="text" class="form-control mt-1 mb-4" readonly rows="3"><?= $getdataa["deskripsi"]; ?></textarea>
                                </div>

                                <div class="row g-2 mb-3 mt-3">
                                <div class="col mb-0">
                                  <h6 for="" class="form">Gambar 1</h6>
                                 <img src="<?= $getdataa["gambar1"]; ?>" style="width: 100%; height: 200px; border-radius:10px;" alt="Gambar Tidak Ada">
                                </div>
                                <div class="col mb-0">
                                  <h6 for="" class="form">Gambar 2</h6>
                                  <img src="<?= $getdataa["gambar2"]; ?>" style="width: 100%; height: 200px; border-radius:10px;" alt="Gambar Tidak Ada">
                                </div>
                                </div>

                                <div class="row mb-3 mt-5">
                                <h5 for="">Gambar QR</h5>
                                <div class="col mb-0">
                                <a href="<?= $getdataa["gambarqr"]; ?>" class="btn btn-info" target="_blank">Lihat QR Code</a>
                                 <a type="button" download="<?= $getdataa["gambarqr"]; ?>" class="btn text-white btn-primary">Download QR Code</a>
                                 </div>

                                 <div class="col mb-0">
                                
                                </div>

                                </div>
                                
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                Close
                              </button>
                              <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                            </div>
                          </div>
                        </div>
                      </div>
                      <?php endforeach; ?>
<!-- Detail Modal -->


                    <!-- Modal Tambah -->
                      <div class="modal fade" id="tambahModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                        <form  method="POST" enctype="multipart/form-data">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title" id="exampleModalLabel3">Tambah Data Kopi</h4>
                              <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="modal"
                                aria-label="Close"></button>
                            </div>
                            <br>
                            
                            <hr class="my-0" />
                            <div class="modal-body">

                              <div class="row">
                                <div class="col mb-3">
                                  <label for="nameLarge" class="form-label">Kode Kopi</label>
                                  <input type="text" name="kdkopi" readonly value="<?php echo $newCode; ?>" class="form-control" placeholder="" />
                                </div>
                              </div>
                              <div class="row g-2 mb-3">
                                <div class="col mb-0">
                                  <label for="dobLarge" class="form-label">Kode Peremajaan</label>
                                  <select name="pere" class="select2 form-select">
                                  <?php
                                  $pere_query = mysqli_query($koneksi, "SELECT kode_peremajaan FROM data_peremajaan"); // Ganti 'nama_pengguna' dengan nama kolom yang sesuai
                                  
                                  if ($pere_query) {
                                      while ($getdataa = mysqli_fetch_assoc($pere_query)) {
                                          echo "<option value='" . $getdataa["kode_peremajaan"] . "'>" . $getdataa["kode_peremajaan"] . "</option>";
                                      }
                                  } else {
                                      echo "<option value=''>Data lahan tidak tersedia</option>";
                                  }
                                  ?>
                                </select>
                                </div>
                                <div class="col mb-0">
                                  <label for="emailLarge" class="form-label">Varietas Kopi</label>
                                  <input type="text"  name="vari" required class="form-control" placeholder="Arabika late" />
                                </div>
                              </div>
                              <div class="row g-2 mb-3">

                              <div class="col mb-0">
                                  <label for="emailLarge" class="form-label">Tanggal Panen</label>
                                  <input type="text" placeholder="YYYY-MM-DD" name="tglpan" required id="flatpickr-datee" class="form-control"  />
                                </div>

                                <div class="col mb-0">
                                  <label for="emailLarge" class="form-label">Tanggal Roasting</label>
                                  <input type="text" placeholder="YYYY-MM-DD" name="tglroas" required id="flatpickr-date" class="form-control"  />
                                </div>

                                <div class="col mb-0">
                                  <label for="emailLarge" class="form-label">Tgl Expired</label>
                                  <input type="text" placeholder="YYYY-MM-DD" name="tglexp" required id="flatpickr-dateee" class="form-control"  />
                                </div>
 
                                </div>
                               
                                <div class="row g-2 mb-3">
                                <div class="col mb-0">
                                  <label for="emailLarge" class="form-label">Berat ( Gram )</label>
                                  <input type="number" placeholder="750" name="berat"  class="form-control"  />
                                </div>

                                <div class="col mb-0">
                                  <label for="emailLarge" class="form-label">Metode Pengolahan</label>
                                  <select id="defaultSelect" name="metode" class="form-select">
                          <option value="Basah">Basah</option>
                          <option value="Kering">Kering</option>
                                </select>
                                </div>
                                </div>

                                <div class="row g-2 mb-2">
                          <label for="exampleFormControlTextarea1">Deskripsi</label>
                          <textarea type="text" class="form-control mt-1 mb-4"  name="desk" rows="3"></textarea>
                          </div>

                                <div class="row g-2 mb-3 mt-2">
                                <div class="col mb-0">
                                <label for="emailLarge" class="form-label">Gambar 1 (Pastikan gambar PNG/JPG dan ukuran 1:1 (1000x1000) pixel)</label>
                                <input class="form-control" type="file" id="img" name="img1"/>
                                </div>
                                <div class="col mb-0">
                                  <label for="emailLarge" class="form-label">Gambar 2 (Pastikan gambar PNG/JPG dan ukuran 1:1 (1000x1000) pixel)</label>
                                  <input class="form-control" type="file" id="img2" name="img2" />
                                </div>
                                </div>

                                <div class="row g-2 mb-3">
                                <div class="col mb-0">
                                <div id="gambar-preview" ></div>
                                </div>
                                <div class="col mb-0">
                                <div id="gambar-preview2" ></div>
                                </div>
                                </div>


                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                Close
                              </button>
                              <button type="submit" name="submit"  class="btn btn-primary me-2">Tambah Data</button>
                            </div>
                          </div>
                          </form>
                        </div>
                      </div>
<!-- Modal Tambah -->




<style>
  .ssdele:hover{
    background-color:#DE3163;
    color:#eaeaea;
  }
  .ssedtt:hover{
    background-color:#53B956;
    color:#eaeaea;
  }
  .ssedtvt:hover{
    background-color:#EAE041;
    color: #fff;;
  }
  #table-controls {
    margin-bottom: 10px;
}

  /* Menyembunyikan tombol-tombol JS bawaan DataTables */
.dt-buttons {
    display: none;
    z-index: 100;
}

div.dataTables_length {
    float: left;
}
div.dataTables_filter {
    float: right;
}


div.dataTables_info {
    float: left;
}
div.dataTables_paginate {
    float: right;
}
  
</style>




                <script src="../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../assets/vendor/libs/popper/popper.js"></script>
    <link rel="stylesheet" href="../assets/vendor/libs/flatpickr/flatpickr.css" />
 <script src="../assets/vendor/libs/flatpickr/flatpickr.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script> 

<!-- ALERT HAPUS -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const deleteButtons = document.querySelectorAll(".ssdele");
    deleteButtons.forEach(function (button) {
        button.addEventListener("click", function () {
            const dataKP = button.getAttribute("data-KP");
            const datavari = button.getAttribute("data-vari");

            Swal.fire({
                title: "Konfirmasi Hapus Data",
                text: `Apakah Anda yakin ingin menghapus data "${datavari}"?`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Ya",
                cancelButtonText: "Batal",
                customClass: {
                    confirmButton: "btn btn-danger",
                    cancelButton: "btn btn-secondary",
                },
            }).then((result) => {
                if (result.isConfirmed) {
                  Swal.fire({
  icon: 'success',
  title: 'Data Terhapus',
  showConfirmButton: false,
  timer: 1500
})

            setTimeout(() => {
              window.location.href = `hapuskopi.php?kode_kopi=${dataKP}`;
            }, 1500);
                   
                }
            });
        });
    });
});
</script>
<!-- ALERT HAPUS -->



    <script>

$(document).ready(function() {
    // Inisialisasi DataTables
    var table = $('#table-user').DataTable({
        "language": {
            "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
            "paginate": {
                "previous": "Sebelumnya",
                "next": "Selanjutnya"
            },
        },
        "format": {
            body: function (inner, coldex, rowdex) {
                if (!inner) return inner;
                var el = $.parseHTML(inner);
                var result = '';

                el.forEach(function (item) {
                    if (item.classList !== undefined && item.classList.contains('user-name')) {
                        result += item.textContent;
                    } else {
                        result += item.innerText || item.textContent;
                    }
                });

                return result;
            },
        },
        "lengthMenu": [10, 25, 50],
        dom: '<"top"Blfr>t<"bottom"ip>',
    });

  
    // Hapus tombol-tombol JS yang ingin Anda sembunyikan
    $('.dt-button').remove();

    // Tambahkan fungsi klik untuk tombol dropdown menu ke tombol DataTables yang sudah ada
    $("#printTable").on('click', function() {
        table.button('0').trigger();
    });
    $("#csvTable").on('click', function() {
        table.button('1').trigger();
    });
    $("#excelTable").on('click', function() {
        table.button('2').trigger();
    });
    $("#pdfTable").on('click', function() {
        table.button('3').trigger();
    });
    $("#copyTable").on('click', function() {
        table.button('4').trigger();
    });
});

    </script>




<!-- CUSTOM TANGGAL -->
<script>
  'use strict';

(function () {

  const flatpickrDate = document.querySelector('#flatpickr-datee'),
   flatpickrDatepanen = document.querySelector('#flatpickr-date'),
   flatpickrDateexp = document.querySelector('#flatpickr-dateee');

  if (flatpickrDate) {
    flatpickrDate.flatpickr({
      monthSelectorType: 'static'
    });
  }

  if (flatpickrDatepanen) {
    flatpickrDatepanen.flatpickr({
      monthSelectorType: 'static'
    });
  }

  if (flatpickrDateexp) {
    flatpickrDateexp.flatpickr({
      monthSelectorType: 'static'
    });
  }
})();
</script>
<!-- CUSTOM TANGGAL -->





<!-- CUSTOM UPLOAD GAMBAR -->
<script>
          document.getElementById('img').addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('gambar-preview').innerHTML = '<img src="' + e.target.result + '" width="300" height="300" />'; // Perhatikan perubahan tanda kutip di sini
                };
                reader.readAsDataURL(file);
            }
        });


        document.getElementById('img2').addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('gambar-preview2').innerHTML = '<img src="' + e.target.result + '" width="300" height="300" />'; // Perhatikan perubahan tanda kutip di sini
                };
                reader.readAsDataURL(file);
            }
        });
</script>
  <!-- CUSTOM UPLOAD GAMBAR -->



<?php
$content = ob_get_clean(); // Ambil konten yang telah di-buffer

include '../admin/body.php';

?>