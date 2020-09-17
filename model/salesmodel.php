<?php
  require_once "connectdb.php";
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
    static public function modCreateSales($table, $data)
    {
      $stmt = Connection::connect()->prepare("INSERT INTO $table(code, id_customer, id_seller, product, tax, net_price, total, method, method_json) VALUES (:code, :id_customer, :id_seller, :product, :tax, :net_price, :total, :method, :method_json)");
      // bind parameters
      $stmt->bindParam(":code", $data['code'], PDO::PARAM_STR);
      $stmt->bindParam(":id_customer", $data['id_customer'], PDO::PARAM_STR);
      $stmt->bindParam(":id_seller", $data['id_seller'], PDO::PARAM_STR);
      $stmt->bindParam(":product", $data['product'], PDO::PARAM_STR);
      $stmt->bindParam(":tax", $data['tax'], PDO::PARAM_STR);
      $stmt->bindParam(":net_price", $data['net_price'], PDO::PARAM_STR);
      $stmt->bindParam(":total", $data['total'], PDO::PARAM_STR);
      $stmt->bindParam(":method", $data['method'], PDO::PARAM_STR);
      $stmt->bindParam(":method_json", $data['method_json'], PDO::PARAM_STR);

      // test the execute;
      if ($stmt->execute()) {
        // code...return 'ok'
        return "ok";
      } else {
        // code...return error;
        return "error";
      }

      // best paractice
      $stmt -> close();
      $stmt = null;
      //  --static public function modCreateSales($table, $data)
    }

    // --class ModelSales
  }

?>
