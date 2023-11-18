<?php

require '../koneksi/koneksi.php';

    $user = $_GET['user'];

    if (hapususerr($user) > 0) {
        echo "
       <script>
            
               document.location.href = 'datauser.php';
       </script>
       ";
} else{
        echo "
       <script>
               document.location.href = 'datauser.php';
       </script>
       ";
}


?>
