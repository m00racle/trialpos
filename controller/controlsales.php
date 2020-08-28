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
        echo 'console.log('. json_encode( $_POST["newTotalSales"] ) .')';
        echo '</script>';
        // code...if (isset($_POST["newSeller"]))
      }
      // static public function ctrCreateSales()
    }
    // --class ControllerSales
  }

 ?>
