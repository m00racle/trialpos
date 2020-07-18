<?php
  require_once "../controller/controlcategory.php";
  require_once "../model/categorymodel.php";

  /**
   * Ajax for handling Suppliers data;
   */
  class AjaxSupplier
  {
    // VALIDATE SUPPLER NAME HAS NOT BEING USED BY OTHERS;
    static public function ajaxValidateSupplier($validateSup)
    {
      $item = "supname";
      $value = $validateSup;

      $response = ControllerSupplier::ctrDataSupplier($item, $value);

      echo json_encode($response);

      // --static public function ajaxValidateSupplier($validateSup)
    }

    // EDIT SUPPLIER DATA;
    static public function ajaxEditSupplier($idSupplier)
    {
      $item = "id";
      $value = $idSupplier;

      $response = ControllerSupplier::ctrDataSupplier($item, $value);

      echo json_encode($response);

      // -- static public function ajaxEditSupplier($idSupplier)
    }

    // -- class AjaxSupplier
  }

  // OBJECT VALIDATE SUPPLIER NAME;
  if (isset($_POST["validateSup"])) {
    // code...use AjaxSupplier to validate;
    $validator = new AjaxSupplier();
    $validateSup = $_POST["validateSup"];
    $validator -> ajaxValidateSupplier($validateSup);
  }

  // OBJECT EDIT SUPPLIER;
  if (isset($_POST["idSupplier"])) {
    // code... use ajax to stream supplier data into modal;
    $editor = new AjaxSupplier();
    $idSupplier = $_POST["idSupplier"];
    $editor -> ajaxEditSupplier($idSupplier);
  }

?>
