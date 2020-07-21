<?php
  //this model the object: product
  /**
   * Class model product;
   */
  class ModelProduct
  {
    static public function modViewProduct($table, $item, $value)
    {
      if ($item != null) {
        $stmt = Connection::connect()->prepare("SELECT * FROM $table WHERE $item = :$item");
        $stmt->bindParam(":".$item, $value, PDO::PARAM_STR);
        $stmt -> execute();
        return $stmt -> fetch(PDO::FETCH_ASSOC);

        // --if ($item != null)
      } else {
        $stmt = Connection::connect()->prepare("SELECT * FROM $table");
        $stmt -> execute();
        return $stmt -> fetchAll(PDO::FETCH_ASSOC);

        // -- else of if ($item != null)
      }
      // erase the instaces (best practice);
      $stmt -> close();
      $stmt = null;

      // -- static public function modViewProduct($table, $item, $value)
    }


    // -- class ModelProduct
  }

?>
