<?php
  require_once "../controller/controlproduct.php";
  require_once "../model/productmodel.php";
  // NOTE: since this datatable also includes suppliers we need to add category also;
  require_once "../controller/controlcategory.php";
  require_once "../model/categorymodel.php";

  /**
   * the table product plugin;
   */
  class ProductTable
  {
      static public function showProductTable()
      {
        $productData = ControllerProduct::ctrDataProduct(null,null);

        // var_dump($productData);// NOTE: test data product fetch all;

        $actionButtons = "<div class='btn-group'>".
                "<button class='btn btn-warning'><i class='fa fa-pencil'></i></button>".
                "<button class='btn btn-danger'><i class='fa fa-times'></i></button>".
              "</div>";

        $dataJson= '{
          "data": [';
          for ($i=0; $i < count($productData); $i++) {
            $image = "<img src='".$productData[$i]["image"]."' ".
            "width='40px'>";

            $dataJson .= '[
              "'.$productData[$i]["id"].'",
              "'.$image.'",
              "'.$productData[$i]["code"].'",
              "'.$productData[$i]["description"].'",
              "Omah Cafe",
              "'.$productData[$i]["stock"].'",
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
