<?php
  require_once "../controller/controlproduct.php";
  require_once "../model/productmodel.php";
  // NOTE: since this datatable also includes suppliers we need to add supplier also;
  require_once "../controller/controlsupplier.php";
  require_once "../model/suppliermodel.php";

  /**
   * the table product plugin;
   */
  class ProductTable
  {
      static public function showProductTable()
      {
        $productData = ControllerProduct::ctrDataProduct(null,null);

        // var_dump($productData);// NOTE: test data product fetch all;

        $dataJson= '{
          "data": [';
          for ($i=0; $i < count($productData); $i++) {
            $image = "<img src='".$productData[$i]["image"]."' ".
            "width='40px'>";
            // call the supplier data;
            $value = $productData[$i]["id_supplier"];
            $supplierData = ControllerSupplier::ctrDataSupplier("id", $value);

            // set action buttons;
            $actionButtons = "<div class='btn-group'>".
                    "<button class='btn btn-warning btnEditProduct' ".
                    "idProduct='".$productData[$i]["id"]."' ".
                    "data-toggle='modal' data-target='#modalEditProduct'>".
                    "<i class='fa fa-pencil'></i></button>".
                    "<button class='btn btn-danger btnDeleteProduct' ".
                    "idProduct='".$productData[$i]["id"]."' ".
                    "code='".$productData[$i]["code"]."' image='".$productData[$i]["image"]."'>".
                    "<i class='fa fa-times'></i></button>".
                  "</div>";

            // checking stocks;
            // TODO: this stock is not needed in the dynamic data table for product. Since the stock is will be handled in the inventory module.
            if ($productData[$i]["stock"] <= 10) {
              $stock = "<button class='btn btn-danger'>".$productData[$i]["stock"]."</button>";

              // --if ($productData[$i]["stock"] <= 10)
            } elseif ($productData[$i]["stock"] > 10 && $productData[$i]["stock"] <=15) {
              $stock = "<button class='btn btn-warning'>".$productData[$i]["stock"]."</button>";

              // --elseif ($productData[$i]["stock"] > 10 && $productData[$i]["stock"] <=15)
            } else {
              $stock = "<button class='btn btn-success'>".$productData[$i]["stock"]."</button>";

              // -- else of if ($productData[$i]["stock"] <= 10)
            }
            // TODO: the data JSON need to be modified to omit the stock data since this will be handled in the inventory module.

            $dataJson .= '[
              "'.$productData[$i]["id"].'",
              "'.$image.'",
              "'.$productData[$i]["code"].'",
              "'.$productData[$i]["description"].'",
              "'.$supplierData["supname"].'",
              "'.$stock.'",
              "'.$productData[$i]["buy_price"].'",
              "'.$productData[$i]["sell_price"].'",
              "'.$productData[$i]["date"].'",
              "'.$actionButtons.'"
            ],';

            // --for ($i=0; $i < count($productData); $i++)
          }
          $dataJson = substr($dataJson,0,-1); // NOTE: substract the ',' from the last table row json;

          $dataJson .= ']
        }';

        echo $dataJson;

        // --static public function showProductTable()
      }

    // --class ProductTable
  }


  // OBJECT ACTIVATE PRODUCT TABLE;
  $activator = new ProductTable();
  $activator->showProductTable();

?>
