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
    public $idUser;

    // setter;
    public function setIdUser($input='')
    {
      // code...set the idUser variable;
      $this->idUser = $input;
    }

    public function ajaxEditUser()
    {
      // code...
      $item = "userid";
      $value = $this->idUser;

      $response = UserController::ctrDataUser($item, $value);

      echo json_encode($response);
    }

  }

  if (isset($_POST["idUser"])) {
    $editor = new AjaxUser();
    $editor -> setIdUser($_POST["idUser"]);
    $editor -> ajaxEditUser();
  }
 ?>
