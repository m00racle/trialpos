<?php
  // destroy the session;
  session_destroy();

  //redirect to login page;
  echo "<script>
    window.location = 'index.php?route=login';
  </script>";
 ?>
