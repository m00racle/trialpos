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
        $stmt = Connection::connect()->prepare("SELECT * FROM $table WHERE $item = :$item ORDER BY id DESC");
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

    static public function modAddProduct($table, $data)
    {
      $stmt = Connection::connect()->prepare("INSERT
        INTO $table(id_supplier, code, description, image, stock, buy_price, sell_price)
        VALUES(:id_supplier, :code, :description, :image, :stock, :buy_price, :sell_price)");

        $stmt->bindParam(":id_supplier", $data['id_supplier'], PDO::PARAM_STR);
        $stmt->bindParam(":code", $data['code'], PDO::PARAM_STR);
        $stmt->bindParam(":description", $data['description'], PDO::PARAM_STR);
        $stmt->bindParam(":image", $data['image'], PDO::PARAM_STR);
        $stmt->bindParam(":stock", $data['stock'], PDO::PARAM_STR);
        $stmt->bindParam(":buy_price", $data['buy_price'], PDO::PARAM_STR);
        $stmt->bindParam(":sell_price", $data['sell_price'], PDO::PARAM_STR);

        if ($stmt->execute()) {
          return "ok";
        } else {
          return "error";
        }

        $stmt->close();
        $stmt = null;

      // --static public function modAddProduct($table, $data)
    }

    static public function modEditDataProduct($table, $data)
    {
      $stmt = Connection::connect()->prepare("UPDATE $table
              SET description = :description, image = :image, stock = :stock,
              buy_price = :buy_price, sell_price = :sell_price WHERE code = :code");

      $stmt->bindParam(":code", $data['code'], PDO::PARAM_STR);
      $stmt->bindParam(":description", $data['description'], PDO::PARAM_STR);
      $stmt->bindParam(":image", $data['image'], PDO::PARAM_STR);
      $stmt->bindParam(":stock", $data['stock'], PDO::PARAM_STR);
      $stmt->bindParam(":buy_price", $data['buy_price'], PDO::PARAM_STR);
      $stmt->bindParam(":sell_price", $data['sell_price'], PDO::PARAM_STR);

      if ($stmt->execute()) {
        return "ok";
      } else {
        return "error";
      }

      $stmt->close();
      $stmt = null;
              
      // --static public function modEditDataProduct($table, $data)
    }


    // -- class ModelProduct
  }

?>
