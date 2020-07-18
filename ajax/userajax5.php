<?php
  require_once "../controller/controluser.php";
  require_once "../model/usermodel.php";

  // code...make a class;
  /**
   *Class ajaxUser to operate the ajax through method;
   */
  class AjaxUser
  {

    // EDIT USER;

    static public function ajaxEditUser($idUser)
    {
      // code...execute the query and parse it in JSON;
      $item = "userid";
      $value = $idUser;

      $response = UserController::ctrDataUser($item, $value);

      echo json_encode($response);
    }

    // ACTIVATE USER;

    static public function ajaxActivateUser($activateUser, $activateId)
    {
      $table = "user";
      $item1 = "status";
      $value1 = $activateUser;
      $item2 = "userid";
      $value2 = $activateId;
      $response = ModelUser::mdlActivateUser($table, $item1, $value1, $item2, $value2);

    }

    // VALIDATE USERNAME IF THERE IS ALREADY ONE USING IT;

    static public function ajaxValidateUser($validateUser)
    {
      $item = "username";
      $value = $validateUser;

      $response = UserController::ctrDataUser($item, $value);

      echo json_encode($response);
    }

  }

  // EDIT USER;
  if (isset($_POST["idUser"])) {
    $editor = new AjaxUser();
    $idUser = $_POST["idUser"]; // NOTE: this is a bad practice!
    $editor -> ajaxEditUser($idUser);
  }

  // OBJECT FOR ACTIVATE USER;
  if (isset($_POST["activateUser"])) {
    // code...
    $activator = new AjaxUser();
    $activateUser = $_POST["activateUser"];
    $activateId = $_POST["activateId"];
    $activator -> ajaxActivateUser($activateUser, $activateId);
  }

  // OBJECT VALIDATE USERNAME IF THERE IS ALREADY ONE USING IT;
  if (isset($_POST["validateUser"])) {
    // code...use ajaxUser to validate;
    $validator = new AjaxUser();
    $validateUser = $_POST["validateUser"];
    $validator -> ajaxValidateUser($validateUser);
  }

 ?>
