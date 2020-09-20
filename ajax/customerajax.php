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

    static public function ajaxPrepareEdit($idCustomer)
    {
      $response = ControllerCustomer::ctrDataCustomer("id", $idCustomer);

      echo json_encode($response);
      // --static public function ajaxPrepareEdit($idCustomer)
    }
    // --class AjaxCustomer
  }

  // object for checking doc id;
  if (isset($_POST["customerName"])) {
    $reader = new AjaxCustomer();
    $reader -> ajaxReadDocId($_POST["customerName"]);
    // code...if (isset($_POST["customerName"]))
  }

  // object for preparing edit customer modal;
  if (isset($_POST["idCustomer"])) {
    // echo "<script>console.log(".json_encode($_POST["idCustomer"]).")</script>"; // TEMP:
    $editor = new AjaxCustomer();
    $editor -> ajaxPrepareEdit($_POST["idCustomer"]);
    // code...if (isset($_POST["idCustomer"]))
  }

?>
