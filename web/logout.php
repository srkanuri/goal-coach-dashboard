<?php
  session_start();
  echo '<script>
          window.location="login.php"
        </script>';
  $_SESSION = array();
  require 'utilities.php';
  $db = conn_db();
  $db.mysqli_close();
  session_destroy();
?>
