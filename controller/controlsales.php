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
        // echo '<script>';
        // echo 'console.log("transaction id",'. json_encode( $_POST["newSale"] ) .');';
        // echo 'console.log("customer id",'. json_encode( $_POST["selectCustomer"] ) .');';
        // echo 'console.log("seller id",'. json_encode( $_POST["sellerId"] ) .');';
        // echo 'console.log("product sold", '. json_encode( $_POST["hiddenJson"] ) .');';
        // echo 'console.log("sales tax", '. json_encode( $_POST["newSalesTax"] ) .');';
        // echo 'console.log("net price", '. json_encode( $_POST["beforeTaxTotalSales"] ) .');';
        // echo 'console.log("total sales formatted", '. json_encode( $_POST["newTotalSales"] ) .');';
        // echo 'console.log("non formatted total sales", '. json_encode( $_POST["plainTotalSales"] ) .');';
        // echo 'console.log("payment code", '. json_encode( $_POST["paymentCode"] ) .');';
        // echo '</script>';// TEMP:

        // IDEA: control the cash payment if the amount paid is higher than the total after tax.
        $transactionJsonDecoded = (json_decode($_POST["paymentJson"],true))[0];
        // echo '<script>';
        // echo 'console.log("transactionJsonDecoded",'. json_encode( $transactionJsonDecoded) .');';
        // echo 'console.log("transData",'. json_encode( $transactionJsonDecoded["method"]) .');';
        // echo '</script>';// TEMP:

        if ($transactionJsonDecoded["method"]=="cash" && $transactionJsonDecoded["amount"] < $_POST["plainTotalSales"]) {
          // IDEA: the cash paid by customer is less than total after tax meaning I need to take action and decline the transaction plus give error warning

          echo "<script>
          Swal.fire({
            icon: 'error',
            title: 'Transaksi Gagal!',
            text: 'Jumlah Pembayaran Kurang!',
            confirmButtonText: 'OK Ulang!',
            allowOutsideClick: true
          }).then((result) => {
            if (result.value) {
            }
          })
            </script>";
          // code...if ($transactionJsonDecoded["method"]=="cash" && $transactionJsonDecoded["amount"] < $_POST["plainTotalSales"])
        } else {
          // IDEA: update the product data on the database;
          // WARNING: to make use of the $_POST["hiddenJson"] JSON format we need to decode it first back to PHP array; please don't use JSON parse method since parse is for Javascript; for PHP the JSON use json_encode and json_decode; CAUTION: when using json_decode in PHP always add second parameter true to ensure the decode was converted to associative array;
          $productJsonDecoded = json_decode($_POST["hiddenJson"], true);

          // IDEA: iterate all $productJsonDecoded and fetch the data for that product;
          for ($i=0; $i < count($productJsonDecoded); $i++) {
            // echo '<script>';
            // echo 'console.log("$productSampleData id",'. json_encode( $productJsonDecoded[$i]["id"] ) .');';
            // echo '</script>';// TEMP:

            $productData = ModelProduct::modViewProduct("product","id",$productJsonDecoded[$i]["id"]);
            // echo '<script>';
            // echo 'console.log("$productData",'. json_encode( $productData ) .');';
            // echo '</script>';// TEMP:

            // var_dump($productData);// TEMP:

            // IDEA: get the initial sales value; then add the quantity sold for the current product and then update the database;
            $updateSales = $productData["sales"] + $productJsonDecoded[$i]["quantity"];
            // var_dump($initialSales);// TEMP:
            // echo '<script>';
            // echo 'console.log("$updateSales",'. json_encode( $updateSales ) .');';
            // echo '</script>';// TEMP:

            // IDEA: using specific method to update product from sales to update the product data. Prepare array with stock and sales data with id data as key;
            $updateProductData = Array('stock' => $productJsonDecoded[$i]["stockLeft"], 'sales' => $updateSales, 'id' => $productJsonDecoded[$i]["id"]);
            $response = ModelProduct::updateProductFromSales($updateProductData);

            // code...for ($i=0; $i < count($productJsonDecoded); $i++)
          }

          $customerData = ModelCustomer::modDataCustomer("customer", "id", $_POST["selectCustomer"]);
          $totalPurchase = $customerData["total_purchase"] + $_POST["plainTotalSales"];
          // $transactionDate = date("Y-m-d");
          $updateCustomer = Array('total_purchase' => $totalPurchase, 'last_purchase' => date("Y-m-d"), 'id' => $_POST["selectCustomer"]);
          $customerUpdateResponse = ModelCustomer::updateCustomerFromSales($updateCustomer);

          $salesData = Array('code'=> $_POST["newSale"], 'id_customer'=> $_POST["selectCustomer"],
          'id_seller'=> $_POST["sellerId"], 'product'=> $_POST["hiddenJson"], 'tax'=> $_POST["newSalesTax"], 'net_price'=> $_POST["beforeTaxTotalSales"],
          'total'=> $_POST["plainTotalSales"], 'method'=> $_POST["paymentCode"], 'method_json'=>$_POST["paymentJson"]);
          $salesUpdateResponse = ModelSales::modCreateSales("sales", $salesData);

          // IDEA: handle the final transaction data update/create. Handle the message and redirect to the manage-sales page;
          if ($salesUpdateResponse=="ok") {
                    echo "<script>
                    Swal.fire({
                      icon: 'success',
                      title: 'Transaksi Berhasil',
                      text: 'Klik OK untuk lanjut ke halaman tabel sales!',
                      confirmButtonText: 'OK Lanjut!',
                      allowOutsideClick: true
                    }).then((result) => {
                      if (result.value) {
                          window.location = 'index.php?route=manage-sales';
                      }
                    })
                      </script>";
                    // code...if ($response == "ok")
                  } else {
                    echo "<script>
                    Swal.fire({
                      icon: 'error',
                      title: 'Transaksi Gagal!',
                      text: 'Ada kesalahan memasukkan transaksi!',
                      confirmButtonText: 'OK Ulang!',
                      allowOutsideClick: true
                    }).then((result) => {
                      if (result.value) {
                      }
                    })
                      </script>";
                    // code...else of if ($response == "ok")
                  }
          // else of if ($transactionJsonDecoded["method"]=="cash" && $transactionJsonDecoded["amount"] < $_POST["plainTotalSales"])
        }

        // code...if (isset($_POST["newSeller"]))
      }
      // static public function ctrCreateSales()
    }
    // --class ControllerSales
  }

 ?>
