<?php
  require_once "../controller/controluser.php";
  require_once "../model/usermodel.php";

  if (isset($_POST["idUser"])) {
    // code...
    $item="userid";
    $value=$_POST["idUser"];

    $response = UserController::ctrDataUser($item, $value);

    echo json_encode($response);
  }
 ?>
