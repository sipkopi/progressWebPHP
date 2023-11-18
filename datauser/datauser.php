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


	$query=query("SELECT * FROM data_user WHERE level IS NULL OR level != 'admin' OR level = 'petani'");

// ambil data 
if( isset($_POST["submit"]) ) {
		
  // hubungkan metod dan jika data > 0 / maka terisi succes paham!!
  if (tambahuserr ($_POST) > 0 ) {
    echo "
    <script>
        document.location.href = 'datauser.php';
    </script>
    ";
  }else {
    echo "
      <script>
        document.location.href = 'datauser.php';
      </script>
    ";
  }		
}


?>


    <link rel="stylesheet" href="../assets/vendor/libs/animate-css/animate.css" />
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link rel="stylesheet" href="../assets/vendor/libs/sweetalert2/sweetalert2.css" />

                  <!-- build:js assets/vendor/js/core.js -->
     <script src="../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../assets/vendor/libs/popper/popper.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="../assets/js/ui-modals.js"></script>
    <!-- <script src="../assets/js/pages-account-settings-account.js"></script> -->
    <script src="../assets/vendor/libs/sweetalert2/sweetalert2.js"></script>

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
        }, 3000); // 3000 milidetik (3 detik)
    </script>

<div class="card">
        <div class="card-header">
 <div class=" d-flex flex-column mb-3 flex-md-row justify-content-between align-items-center"> <!-- Menambahkan class align-items-center -->
    <h2>Data User</h2>
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
  <table id="table-user" class="table table-hove display">
    <thead class="table-light">
      <tr>
        <th>No</th>
        <th>Username</th>
        <th>Nama</th>
        <th>Email</th>
        <th>Level</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody class="table-border-bottom-0 mb-5">
    <?php $a=1; ?>
      <?php foreach ($query as $getdata) : ?>
        <tr>
        <td><?= $a; ?></td>
          <td class="p-3"><?= $getdata["user"]; ?></td>
          <td><?= $getdata["nama"]; ?></td>
          <td><?= $getdata["email"]; ?></td>

          <td><?= $getdata["level"]; ?></td>
            <!-- <img src="<?= $getdata["gambar"]; ?>" alt="Avatar" class="rounded-circle" style="width: 40px; height: 40px;"> -->
          
          <td>
            <div class="dropdown">
              <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                <i class="ti ti-dots-vertical"></i>
              </button>
              <div class="dropdown-menu">
              <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#largeModal<?= $getdata["user"]; ?>"
                  ><i class="ti ti-list-details me-1"></i></i> Detail Data</button>
                <a class="dropdown-item ssedtt" href="edituser.php?user=<?=$getdata["user"];?>"
                  ><i class="ti ti-pencil me-1"></i> Edit Data</a>
                  <a class="dropdown-item ssdele" href="javascript:void(0);"
                data-user="<?=$getdata["user"];?>"
                data-nama="<?=$getdata["nama"];?>">
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
                              <h3 class="modal-title fw-bold" id="exampleModalLabel3">Tambah Akun</h3>
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
                            <div class="d-flex align-items-start align-items-sm-center mb-3 gap-4">
                        <img
                          src=""
                          alt="user-avatar"
                          name="upload"
                          class="d-block w-px-100 h-px-100 rounded"
                          id="uploadedAvatar" />
                          <div class="button-wrapper">
                          <label for="upload" class="btn btn-primary me-2 mb-3" tabindex="0">
                            <span class="d-none d-sm-block">Upload Foto Baru</span>
                            <i class="ti ti-upload d-block d-sm-none"></i>
                            <input
                              type="file"
                              id="upload"
                              name="upload"
                              class="account-file-input"
                              hidden
                              accept="image/png, image/jpeg" />
                          </label>
                          <button type="button" class="btn btn-label-secondary account-image-reset mb-3">
                            <i class="ti ti-refresh-dot d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Reset</span>
                          </button>

                          <div class="text-muted">Diperbolehkan bentuk JPG, GIF or PNG. Maximum 5MB</div>
                        </div>

                      </div>
                          
                                <div class="col mb-3">
                                  <label for="nameLarge" class="form-label">Username</label>
                                  <input type="text" name="user" required class="form-control" placeholder="namakamu12" />
                                </div>
                              </div>
                              <div class="row g-2 mb-3">
                                <div class="col mb-0">
                                  <label for="dobLarge" class="form-label">nama</label>
                                  <input type="text" id="inputHuruf" oninput="validateInput(this)" name="nama" required class="form-control" placeholder="namakamu" />
                                   <span id="error-message" style="color: cyan;"></span>
                                </div>
                                <div class="col mb-0">
                                  <label for="emailLarge" class="form-label">Email</label>
                                  <input type="email" name="email" required class="form-control" placeholder="emailkamu@gmail.com" />
                                </div>
                              </div>
                              <div class="row g-2 mb-3">
                              <div class="col mb-0">
                                  
                              <label class="form-label" for="phoneNumber">No HP</label>
                            <div class="input-group input-group-merge">
                              <span class="input-group-text">ID (+62)</span>
                              <input
                                type="number"
                                 required
                                name="nohp"
                                class="form-control"
                                placeholder="" />
                            </div>
                              
                                </div>
                                <div class="col mb-0">
                                  <label for="emailLarge" class="form-label">Password</label>
                                  <input type="text" name="pass" required class="form-control" placeholder="" />
                                </div>
 
                                </div>
                                <input type="datetime-local" hidden name="tgl" />
                                <div class="row g-2 mb-3">
                                <div class="col mb-0">
                                  <label for="emailLarge" class="form-label">Level</label>
                                  <input type="text"  class="form-control bg-secondary text-white" name="level" readonly placeholder="Petani" value="Petani" />
                                </div>
                                <div class="col mb-0">
                                  <label for="emailLarge" class="form-label">Lokasi</label>
                                  <input type="text" name="lokasi" required class="form-control"  placeholder="Jember" />
                                </div>
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


                      <!-- Detail Modal -->
                      <?php foreach ($query as $getdataa) : ?>
                      <div class="modal fade" id="largeModal<?= $getdataa["user"]; ?>" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel3">Detail Akun</h5>
                              <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="modal"
                                aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                            <div class="d-flex align-items-start align-items-sm-center mb-3 gap-4">
                        <img
                          src="<?= $getdataa["gambar"]; ?>"
                          alt="user-avatar"
                          class="d-block w-px-100 h-px-100 rounded"
                          id="uploadedAvatar" />

                      </div>
                              <div class="row">
                                <div class="col mb-3">
                                  <label for="nameLarge" class="form-label">Username</label>
                                  <input type="text" readonly class="form-control" placeholder="" value="<?= $getdataa["user"]; ?>" />
                                </div>
                              </div>
                              <div class="row g-2 mb-3">
                                <div class="col mb-0">
                                  <label for="dobLarge" class="form-label">nama</label>
                                  <input type="text" readonly class="form-control" placeholder="" value="<?= $getdataa["nama"]; ?>" />
                                </div>
                                <div class="col mb-0">
                                  <label for="emailLarge" class="form-label">Email</label>
                                  <input type="email" value="<?= $getdataa["email"]; ?>" readonly class="form-control" placeholder="" />
                                </div>
                              </div>
                              <div class="row g-2 mb-3">
                              <div class="col mb-0">
                                  <label for="emailLarge" class="form-label">Nomor Hp</label>
                                  <input type="number" value="<?= $getdataa["nohp"]; ?>" readonly class="form-control" placeholder="" />
                                </div>
                                <div class="col mb-0">
                                  <label for="emailLarge" class="form-label">Lokasi</label>
                                  <input type="text" value="<?= $getdataa["lokasi"]; ?>" readonly class="form-control" placeholder="" />
                                </div>
 
                                </div>
                               
                                <div class="row g-2 mb-3">
                                <div class="col mb-0">
                                  <label for="emailLarge" class="form-label">Level</label>
                                  <input type="text" value="<?= $getdataa["level"]; ?>" readonly class="form-control" placeholder="" />
                                </div>
                                <div class="col mb-0">
                                  <label for="emailLarge" class="form-label">Tanggal Regis</label>
                                  <input type="datetime" class="form-control" value="<?= $getdataa["tanggal_create"]; ?>" readonly placeholder="" />
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


<script>

function validateInput(inputElement) {
      const inputValue = inputElement.value;
      const forbiddenCharacters = /[@1234567890!#^&*]/g; // Karakter yang tidak diinginkan

      if (forbiddenCharacters.test(inputValue)) {
        document.getElementById('error-message').textContent = 'Tidak boleh mengandung karakter tertentu, seperti @, angka, atau karakter lainnya.';
        inputElement.value = inputValue.replace(forbiddenCharacters, ''); // Menghapus karakter yang tidak diinginkan
      } else {
        document.getElementById('error-message').textContent = '';
      }
    }


document.addEventListener('DOMContentLoaded', function () {
  (function () {
    // Update/reset user image on the account page
    const accountUserImage = document.getElementById('uploadedAvatar');
    const fileInput = document.querySelector('.account-file-input');
    const resetFileInput = document.querySelector('.account-image-reset');

    if (accountUserImage) {
      const resetImage = accountUserImage.src;

      fileInput.onchange = () => {
        if (fileInput.files[0]) {
          accountUserImage.src = window.URL.createObjectURL(fileInput.files[0]);
        }
      };

      resetFileInput.onclick = () => {
        fileInput.value = '';
        accountUserImage.src = resetImage;
      };
    }
  })();
});

</script>



<script>
document.addEventListener("DOMContentLoaded", function () {
    const deleteButtons = document.querySelectorAll(".ssdele");
    deleteButtons.forEach(function (button) {
        button.addEventListener("click", function () {
            const dataUser = button.getAttribute("data-user");
            const dataNama = button.getAttribute("data-nama");

            Swal.fire({
                title: "Konfirmasi Hapus Data",
                text: `Apakah Anda yakin ingin menghapus data "${dataNama}"?`,
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
              window.location.href = `hapus.php?user=${dataUser}`;
            }, 1500);
                   
                }
            });
        });
    });
});
</script>



    <script>

document.addEventListener('DOMContentLoaded', function (e) {
  (function () {
    // Update/reset user image of account page
    const accountUserImage = document.getElementById('uploadedAvatar');
    const fileInput = document.querySelector('.account-file-input');
    const resetFileInput = document.querySelector('.account-image-reset');

    if (accountUserImage) {
      const resetImage = accountUserImage.src;

      fileInput.onchange = () => {
        if (fileInput.files[0]) {
          accountUserImage.src = window.URL.createObjectURL(fileInput.files[0]);
        }
      };

      resetFileInput.onclick = () => {
        fileInput.value = '';
        accountUserImage.src = resetImage;
      };
    }
  })();
});



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



<?php
$content = ob_get_clean(); // Ambil konten yang telah di-buffer

include '../admin/body.php';

?>