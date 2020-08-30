<?php
  /**
   * Controller for sales
   */
  class ControllerSales
  {
    static public function ctrDataSales($item,$value,$order="ASC")
    {
      $response = ModelSales::modViewSales("sales",$item,$value,$order);

      return $response;
      // --static public function ctrDataSales($item,$value,$order="ASC")
    }

    static public function ctrCreateSales(){
      if (isset($_POST["newSeller"])) {
        echo '<script>';
        echo 'console.log("transaction id",'. json_encode( $_POST["newSale"] ) .');';
        echo 'console.log("customer id",'. json_encode( $_POST["selectCustomer"] ) .');';
        echo 'console.log("seller id",'. json_encode( $_POST["sellerId"] ) .');';
        echo 'console.log("product sold", '. json_encode( $_POST["hiddenJson"] ) .');';
        echo 'console.log("sales tax", '. json_encode( $_POST["newSalesTax"] ) .');';
        echo 'console.log("net price", '. json_encode( $_POST["beforeTaxTotalSales"] ) .');';
        echo 'console.log("total sales formatted", '. json_encode( $_POST["newTotalSales"] ) .');';
        echo 'console.log("non formatted total sales", '. json_encode( $_POST["plainTotalSales"] ) .');';
        echo 'console.log("payment code", '. json_encode( $_POST["paymentCode"] ) .');';
        echo '</script>';
        // code...if (isset($_POST["newSeller"]))
      }
      // static public function ctrCreateSales()
    }
    // --class ControllerSales
  }

 ?>
