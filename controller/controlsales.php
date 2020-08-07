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
    // --class ControllerSales
  }

 ?>
