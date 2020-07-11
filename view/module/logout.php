<?php
  // destroy the session;
  session_destroy();

  //redirect to login page;
  echo "<script>
    window.location = 'login';
  </script>";
 ?>
