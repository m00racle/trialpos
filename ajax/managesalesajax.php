<?php
  // IDEA: THIS IS AJAX FILE FOR PROCESSING THE TABLE IN THE MANAGE SALES PAGE; THIS IS REQUIRED IN RESPONSE FOR THE POSSIBILITIES THAT IN THE FUTURE THE NUMBER OF TRANSACTION WILL BE SKYROCKETING;

  require_once '../controller/controlsales.php';
  require_once '../model/salesmodel.php';

  /**
   * this is the ajax class to process the sales data table using the php datatable plugin;
   */
  class SalesDataTable
  {
    static public function showSalesDataTable()
    {
      // IDEA: fetch all sales data; use descending order to make the latest transaction viewed on top of the list;
      $salesData = ControllerSales::ctrDataSales(null,null,$order="DESC");
      // var_dump($salesData);// DEBUG: test

      // IDEA: make the $salesData into table structure in JSON format;
      $dataJson = '{
        "data": [';
          for ($i=0; $i < count($salesData) ; $i++) {
            $value = $salesData[$i];
            $actionButtons = "<div class='btn-group'>".
              "<button class='btn btn-warning'><i class='fa fa-print'></i></button>".
              "<button class='btn btn-danger'><i class='fa fa-times'></i></button>".
            "</div>";
            $dataJson .= '[
              "'.$value["id"].'",
              "'.$value["code"].'",
              "'.$value["id_customer"].'",
              "'.$value["id_seller"].'",
              "'.$value["method"].'",
              "'.$value["net_price"].'",
              "'.$value["total"].'",
              "'.$value["date"].'",
              "'.$actionButtons.'"
            ],';
            // code...for ($i=0; $i < count($salesData) ; $i++)
          }
          $dataJson = substr($dataJson,0,-1);

        $dataJson .=']
      }';

      echo $dataJson;
      // -- static public function showSalesDataTable()
    }
    // --class SalesDataTable
  }
  // NOTE: object to instatiate the ajax class;
  $activator = new SalesDataTable();
  $activator->showSalesDataTable();

?>
