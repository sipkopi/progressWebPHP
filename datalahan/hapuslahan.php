<?php

require '../koneksi/koneksi.php';

    $kode_lahan = $_GET['kode_lahan'];

    if (hapuslahan($kode_lahan) > 0) {
        echo "
       <script>
            
               document.location.href = 'datalahan.php';
       </script>
       ";
} else{
        echo "
       <script>
               document.location.href = 'datalahan.php';
       </script>
       ";
}


?>