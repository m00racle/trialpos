<?php
  /**
   * the table product plugin;
   */
  class ProductTable
  {
      static public function showProductTable()
      {
        echo '{
          "data": [
            [
              "1",
              "anonymousbox.png",
              "10001",
              "Kopi Aroma",
              "Omah Cafe",
              "20",
              "Rp 2.000",
              "Rp 6.000",
              "2020-07-22 16:30:00",
              "action wait"
            ],
            [
              "2",
              "anonymousbox.png",
              "10002",
              "Kopi Espresso",
              "Sularno",
              "20",
              "Rp 2.500",
              "Rp 7.000",
              "2020-07-22 16:30:00",
              "action wait"
            ]
          ]
        }';

        // --static public function showProductTable()
      }

    // --class ProductTable
  }


  // OBJECT ACTIVATE PRODUCT TABLE;
  $activator = new ProductTable();
  $activator->showProductTable();

?>
