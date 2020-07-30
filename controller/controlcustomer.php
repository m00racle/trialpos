<?php

  /**
   * Controller for customer;
   */
  class ControllerCustomer
  {
    static public function ctrDataCustomer($item, $value)
    {
      $response = ModelCustomer::modDataCustomer("customer", $item, $value);
      return $response;
      // --static public function ctrDataCustomer($item, $value)
    }
    // --class ControllerCustomer
  }

 ?>
