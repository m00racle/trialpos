<?php
  /**
   * Model for Sales;
   */
  class ModelSales
  {
    static public function modViewSales($table, $item, $value, $order)
    {
      if ($item != null) {
        $stmt = Connection::connect()->prepare("SELECT * FROM $table WHERE $item = :$item ORDER BY date $order");
        $stmt->bindParam(":".$item, $value, PDO::PARAM_STR);
        $stmt -> execute();
        return $stmt -> fetch(PDO::FETCH_ASSOC);
        // code...if ($item != null)
      } else {
        $stmt = Connection::connect()->prepare("SELECT * FROM $table ORDER BY date $order");
        $stmt -> execute();
        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
        // code...else...if ($item != null)
      }
      $stmt -> close();
      $stmt = null;
      // --static public function modViewSales($table, $item, $value, $order)
    }
    // TODO: make method to insert new sales entity to the sales realtion;
    
    // --class ModelSales
  }

?>
