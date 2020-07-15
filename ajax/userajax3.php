<?php
  require_once "../controller/controluser.php";
  require_once "../model/usermodel.php";

  // code...make a class;
  /**
   *Class ajaxUser to operate the ajax through method;
   */
  class AjaxUser
  {
    // properties;
    // NOTE: A bit warning this class uses direct properties assignment which is a bad practice!
    public $idUser;

    public function ajaxEditUser()
    {
      // code...execute the query and parse it in JSON;
      $item = "userid";
      $value = $this->idUser;

      $response = UserController::ctrDataUser($item, $value);

      echo json_encode($response);
    }

  }

  if (isset($_POST["idUser"])) {
    $editor = new AjaxUser();
    $editor -> idUser = $_POST["idUser"]; // NOTE: this is a bad practice!
    $editor -> ajaxEditUser();
  }
 ?>
