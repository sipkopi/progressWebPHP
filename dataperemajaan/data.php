<?php

ob_start(); // Mulai output buffering

session_start();
if (!isset($_SESSION['nama'])) {
    header("Location: ../admin/indexlogin.php");
    exit(); // Terminate script execution after the redirect
}

?>



<?php
// menghubungkan ke file koneksi
require '../koneksi/koneksi.php';

// menampilkan seluruh data peremajaan
	$query=query("SELECT * FROM data_peremajaan");


  $queryy = "SELECT kode_peremajaan FROM data_peremajaan ORDER BY	kode_peremajaan DESC LIMIT 1";
$resultt = mysqli_query($koneksi, $queryy);

if ($resultt) {
    $row = mysqli_fetch_assoc($resultt);
    if ($row) {
        $lastCode = $row['kode_peremajaan'];

        // Extract nomor urut dari kode PPK terakhir
        $lastNumber = (int)substr($lastCode, 3);

        // Tambahkan 1 ke nomor urut
        $newNumber = $lastNumber + 1;

        // Format nomor urut dengan nol di depan jika kurang dari 10
        if ($newNumber < 10) {
            $newCode = "KPR000" . $newNumber;
        } elseif ($newNumber < 100) {
            $newCode = "KPR00" . $newNumber;
        } else {
            $newCode = "KPR0" . $newNumber;
        }
    } else {
        // Kode PPK awal jika tidak ada data
        $newCode = "KPR001";
    }
} else {
    // Handle jika query tidak berhasil
    // Misalnya, Anda bisa mengatur kode PPK awal di sini
    $newCode = "KPR001";
}


// ambil data 
if( isset($_POST["submit"]) ) {
		
  // hubungkan metod dan jika data > 0 / maka terisi succes paham!!
  if (tambahprj ($_POST) > 0 ) {
    echo "
    <script>
        document.location.href = 'data.php';
    </script>
    ";
  }else {
    echo "
      <script>
        document.location.href = 'data.php';
      </script>
    ";
  }		
}

?>

<link rel="stylesheet" href="../assets/vendor/libs/animate-css/animate.css" />
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link rel="stylesheet" href="../assets/vendor/libs/sweetalert2/sweetalert2.css" />


     <script src="../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../assets/vendor/libs/popper/popper.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="../assets/js/ui-modals.js"></script>
    <script src="../assets/vendor/libs/sweetalert2/sweetalert2.js"></script>

    <link rel="stylesheet" href="../assets/vendor/libs/flatpickr/flatpickr.css" />
 <script src="../assets/vendor/libs/flatpickr/flatpickr.js"></script>



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
    <h2>Data Peremajaan</h2>
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
        <th>Kode Peremajaan</th>
        <th>Kode_Lahan</th>
        <th>Perlakuan</th>
        <th>Tanggal</th>
        <th>Kebutuhan</th>
        <th>Pupuk</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody class="table-border-bottom-0 mb-5">
    <?php $a=1; ?>
      <?php foreach ($query as $getdata) : ?>
        <tr>
        <td><?= $a; ?></td>
          <td class="p-3"><?= $getdata["kode_peremajaan"]; ?></td>
          <td class="p-3"><?= $getdata["kode_lahan"]; ?></td>
          <td><?= $getdata["perlakuan"]; ?></td>
          <td><?= $getdata["tanggal"]; ?></td>
          <td><?= $getdata["kebutuhan"]; ?> Liter</td>
          <td><?= $getdata["pupuk"]; ?></td>

          <td>
            <div class="dropdown">
              <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                <i class="ti ti-dots-vertical"></i>
              </button>
              <div class="dropdown-menu">
                <a class="dropdown-item ssedtt" href="edit.php?kode_peremajaan=<?=$getdata["kode_peremajaan"];?>"
                  ><i class="ti ti-pencil me-1"></i> Edit Data</a>
                  <a class="dropdown-item ssdele" href="javascript:void(0);"
                data-KP="<?=$getdata["kode_peremajaan"];?>"
                data-lahan="<?=$getdata["kode_lahan"];?>">
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




      <!--  Modal Tambah-->
      <div class="modal fade" id="tambahModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                          <div class="modal-content">
                          <form  method="POST" enctype="multipart/form-data">
                            <div class="modal-header">
                              <h3 class="modal-title fw-bold" id="exampleModalLabel3">Tambah Data Peremajaan</h3>
                              <br>
                             
                              <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="modal"
                                aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                            <div class="row">
                              <hr class="my-0 mb-4" />
                                <div class="col mb-3">
                                  <label for="nameLarge" class="form-label">Kode Peremajaan</label>
                                  <input type="text" name="kodeperemajaan" value="<?php echo $newCode; ?>" required readonly class="form-control" placeholder="" />
                                </div>
                              </div>
                              <div class="row g-2 mb-3">
                                <div class="col mb-0">
                                  <label for="dobLarge" class="form-label">Kode Lahan</label>
                                  <select name="kodelahan" class="select2 form-select">
                                  <?php
                                  $nama_pengguna = $_SESSION['user'];
                                  $vari_query = mysqli_query($koneksi, "SELECT kode_lahan, user, varietas_pohon FROM data_lahan WHERE user = '$nama_pengguna'"); // Ganti 'nama_pengguna' dengan nama kolom yang sesuai
                                  
                                  if ($vari_query) {
                                      while ($getdataa = mysqli_fetch_assoc($vari_query)) {
                                          echo "<option value='" . $getdataa["kode_lahan"] . "'>" . $getdataa["kode_lahan"] ." ". $getdataa["varietas_pohon"] . "</option>";
                                      }
                                  } else {
                                      echo "<option value=''>Data lahan tidak tersedia</option>";
                                  }
                                  ?>
                                </select>
                                </div>
                                <div class="col mb-0">
                                <label for="flatpickr-datetime" class="form-label">Tanggal</label>
                                  <input type="text" class="form-control" placeholder="YYYY-MM-DD" name="tgl" id="flatpickr-date" />
                                </div>
                              </div>
                              <div class="row g-2 mb-3">
                              <div class="col mb-0">
                              <label for="emailLarge" class="form-label">Kebutuhan ( Liter )</label>
                                  <input type="number" name="kebutuhan" placeholder="100" required class="form-control"/>
                                </div>

                                <div class="col mb-0">
                                  <label for="emailLarge" class="form-label">Nama Pupuk</label>
                                  <input type="text" name="pupuk" required class="form-control"  placeholder="NPK 8000" />
                                </div>
 
                                </div>
                                <div class="col mb-3">
                                  <label for="nameLarge" class="form-label">Perlakuan</label>
                                  <textarea class="form-control" name="perlakuan" placeholder="Penyiraman" id="exampleFormControlTextarea1" rows="3"></textarea>
                                </div>
                            </div>

                            <div class="modal-footer">
                              <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                Close
                              </button>
                              
                              <button type="submit" name="submit"  class="btn btn-primary me-2">Tambah Data</button>
                              <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                            </div>
                            </form>
                          </div>
                          
                        </div>
                      </div>
                      <!--  Modal Tambah-->





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


 <!-- CUSTOM pRINT -->
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
    <!-- CUSTOM pRINT -->

<!-- CUSTOM TANGGAL -->
<script>
  'use strict';

(function () {

  const flatpickrDate = document.querySelector('#flatpickr-date');

  if (flatpickrDate) {
    flatpickrDate.flatpickr({
      monthSelectorType: 'static'
    });
  }

})();
</script>
<!-- CUSTOM TANGGAL -->

<!-- ALERT HAPUS -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const deleteButtons = document.querySelectorAll(".ssdele");
    deleteButtons.forEach(function (button) {
        button.addEventListener("click", function () {
            const dataKP = button.getAttribute("data-KP");
            const datalahan = button.getAttribute("data-lahan");

            Swal.fire({
                title: "Konfirmasi Hapus Data",
                text: `Apakah Anda yakin ingin menghapus data "${datalahan}"?`,
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
              window.location.href = `hapus.php?kode_peremajaan=${dataKP}`;
            }, 1500);
                   
                }
            });
        });
    });
});
</script>
<!-- ALERT HAPUS -->




<?php
$content = ob_get_clean(); // Ambil konten yang telah di-buffer

include '../admin/body.php';

?>