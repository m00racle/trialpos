<?php
  require_once "../controller/controlproduct.php";
  require_once "../model/productmodel.php";


  /**
   * the table product plugin;
   */
  class ProductTableForSale
  {
      static public function showProductTableForSale()
      {
        $productData = ControllerProduct::ctrDataProduct(null,null);

        // var_dump($productData);// NOTE: test data product fetch all;
        // TODO: data JSON need to be modified since in the sales ajax will omit stock data

        $dataJson= '{
          "data": [';
          for ($i=0; $i < count($productData); $i++) {
            $image = "<img src='".$productData[$i]["image"]."' ".
            "width='40px'>";

            // set action buttons;
            $actionButtons = "<div class='btn-group'><button class='btn btn-primary addProduct recoverButton' idProduct='".$productData[$i]["id"]."'>Add</button></div>";

            // checking stocks;
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

            $dataJson .= '[
              "'.$productData[$i]["id"].'",
              "'.$image.'",
              "'.$productData[$i]["code"].'",
              "'.$productData[$i]["description"].'",
              "'.$stock.'",
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
  $activatorForSale = new ProductTableForSale();
  $activatorForSale->showProductTableForSale();

?>
