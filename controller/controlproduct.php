<?php
  // controller for products;
  /**
   * Control every aspect of product data;
   */
  class ControllerProduct
  {
    static public function ctrDataProduct($item, $value)
    {
      $table = "product";

      $response = ModelProduct::modViewProduct($table, $item, $value);

      return $response;

      // --static public function ctrDataProduct($item, $value)
    }

    // --class ControllerProduct
  }


 ?>
