<?php
  require_once "../controller/controluser.php";
  require_once "../model/usermodel.php";

  // code...make a class;
  /**
   * AjaxUser construct $idUser and control response using Ajax;
   */
  class AjaxUser
  {
    // class property;
    private $idUser;

    function __construct($idUser)
    {
      // code...construct the Class with the argumen idUser;
      $this -> idUser = $idUser;
    }

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
    $editor = new AjaxUser($_POST["idUser"]);
    // $editor -> idUser = ; // NOTE: this is a bad practice!
    $editor -> ajaxEditUser();
  }
 ?>
