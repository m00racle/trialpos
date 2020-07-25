<?php
require_once "../controller/controlproduct.php";
require_once "../model/productmodel.php";
// NOTE: since this datatable also includes suppliers we need to add category also;
require_once "../controller/controlcategory.php";
require_once "../model/categorymodel.php";

  /**
   *
   */
  class AjaxProduct
  {
    static public function ajaxReadProductCode($idSupplier){
      $response = ControllerProduct::ctrDataProduct("id_supplier", $idSupplier);
      

      echo json_encode($response);

    }

    // --class AjaxProduct
  }

  // OBJECT;
  if (isset($_POST["idSupplier"])) {
    // code...
    $reader = new AjaxProduct();
    $reader->ajaxReadProductCode($_POST["idSupplier"]);
  }

 ?>
