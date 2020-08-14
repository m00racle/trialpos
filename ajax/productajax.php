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

      // --static public function ajaxReadProductCode($idSupplier)
    }

    static public function ajaxEditProduct($idProduct, $bringProducts="notOK")
    {
      if ($bringProducts == "ok") {
        // code...
        $response = ControllerProduct::ctrDataProduct(null, null);

        echo json_encode($response);
      } else {
        // code...
        $productData = ControllerProduct::ctrDataProduct("id",$idProduct);
        $supplierData = ControllerSupplier::ctrDataSupplier("id", $productData["id_supplier"]);
        $supName = array("supname"=>$supplierData["supname"]);

        // echo "<script>console.log('response',".json_encode($supplierData).")</script>";

        $response = array_merge($productData,$supName);
        // NOTE: this $response is added by array if supplier name data from the supplier data controller used as the additional data for the whole process.


        echo json_encode($response);
      }

      // --static public function ajaxEditProduct($idProduct)
    }

    // --class AjaxProduct
  }

  // OBJECT;
  if (isset($_POST["idSupplier"])) {
    // code...
    $reader = new AjaxProduct();
    $reader->ajaxReadProductCode($_POST["idSupplier"]);
  }

  // OBJECT FETCH DATA FOR EDIT MODAL;
  if (isset($_POST["idProduct"])) {
    // code...
    $editor = new AjaxProduct();
    $editor -> ajaxEditProduct($_POST["idProduct"]);
  }

  // OBJECT FOR ADD PRODUCT IN CREATE SALES VIEW;
  if (isset($_POST["bringProducts"])) {
    // code...
    $getter = new AjaxProduct();
    $getter -> ajaxEditProduct(null, $_POST["bringProducts"]);
  }

 ?>
