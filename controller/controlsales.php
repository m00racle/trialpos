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
        // NOTE: this is the first test to see if the data sent to the controller is compatible with the needs;
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
        echo '</script>';// DEBUG: test

        // IDEA: update the product data on the database;
        // NOTE: to make use of the $_POST["hiddenJson"] JSON format we need to decode it first back to PHP array; please don't use JSON parse method since parse is for Javascript; for PHP the JSON use json_encode and json_decode; CAUTION: when using json_decode in PHP always add second parameter true to ensure the decode was converted to associative array;
        $productJsonDecoded = json_decode($_POST["hiddenJson"], true);

        // IDEA: iterate all $productJsonDecoded and fetch the data for that product;
        for ($i=0; $i < count($productJsonDecoded); $i++) {
          echo '<script>';
          echo 'console.log("$productSampleData id",'. json_encode( $productJsonDecoded[$i]["id"] ) .');';
          echo '</script>';// DEBUG: test

          $productData = ModelProduct::modViewProduct("product","id",$productJsonDecoded[$i]["id"]);
          echo '<script>';
          echo 'console.log("$productData",'. json_encode( $productData ) .');';
          echo '</script>';// DEBUG: test

          // var_dump($productData);// DEBUG:

          // IDEA: get the initial sales value; then add the quantity sold for the current product and then update the database;
          $updateSales = $productData["sales"] + $productJsonDecoded[$i]["quantity"];
          // var_dump($initialSales);// DEBUG:
          echo '<script>';
          echo 'console.log("$updateSales",'. json_encode( $updateSales ) .');';
          echo '</script>';// DEBUG: test

          $response = ModelProduct::updateSingleDataProduct("product", "id", $productJsonDecoded[$i]["id"], "sales", $updateSales);

          // IDEA: update the stock condition using the $productJsonDecoded["stockLeft"] as value;
          $response = ModelProduct::updateSingleDataProduct("product", "id", $productJsonDecoded[$i]["id"], "stock", $productJsonDecoded[$i]["stockLeft"]);

          // TODO: update customer data on total purchase and last purchase for the customer relation database;

          // TODO: insert the sales data into sales relation (see the php my admin database structure)

          // code...for ($i=0; $i < count($productJsonDecoded); $i++)
        }
        // code...if (isset($_POST["newSeller"]))
      }
      // static public function ctrCreateSales()
    }
    // --class ControllerSales
  }

 ?>
