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

    // ACTIVATE USER;
    public $activateUser;
    public $activateId;

    public function ajaxActivateUser()
    {
      $table = "user";
      $item1 = "status";
      $value1 = $this->activateUser;
      $item2 = "userid";
      $value2 = $this->activateId;
      $response = ModelUser::mdlActivateUser($table, $item1, $value1, $item2, $value2);
      
    }

  }

  // EDIT USER;
  if (isset($_POST["idUser"])) {
    $editor = new AjaxUser();
    $editor -> idUser = $_POST["idUser"]; // NOTE: this is a bad practice!
    $editor -> ajaxEditUser();
  }

  // OBJECT FOR ACTIVATE USER;
  if (isset($_POST["activateUser"])) {
    // code...
    $activator = new AjaxUser();
    $activator -> activateUser = $_POST["activateUser"];
    $activator -> activateId = $_POST["activateId"];
    $activator -> ajaxActivateUser();
  }

 ?>
