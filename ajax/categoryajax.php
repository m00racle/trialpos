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

    // -- class AjaxSupplier
  }

  // OBJECT VALIDATE SUPPLIER NAME;
  if (isset($_POST["validateSup"])) {
    // code...use AjaxSupplier to validate;
    $validator = new AjaxSupplier();
    $validateSup = $_POST["validateSup"];
    $validator -> ajaxValidateSupplier($validateSup);
  }
  
?>
