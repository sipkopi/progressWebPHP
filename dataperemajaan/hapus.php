<?php

require '../koneksi/koneksi.php';

    $kode_peremajaan = $_GET['kode_peremajaan'];

    if (hapusKP($kode_peremajaan) > 0) {
        echo "
       <script>
            
               document.location.href = 'data.php';
       </script>
       ";
} else{
        echo "
       <script>
               document.location.href = 'data.php';
       </script>
       ";
}


?>