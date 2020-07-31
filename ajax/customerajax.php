<?php
  require_once '../controller/controlcustomer.php';
  require_once '../model/customermodel.php';

  /**
   * Ajax handler for customer;
   */
  class AjaxCustomer
  {
    static public function ajaxReadDocId($customerName)
    {
      $response = ControllerCustomer::ctrDataCustomer(null,null,"DESC");

      echo json_encode($response);
      // --static public function ajaxReadDocId($customerName)
    }
    // --class AjaxCustomer
  }

  // object for checking doc id;
  if (isset($_POST["customerName"])) {
    $reader = new AjaxCustomer();
    $reader -> ajaxReadDocId($_POST["customerName"]);
    // code...if (isset($_POST["customerName"]))
  }

?>
