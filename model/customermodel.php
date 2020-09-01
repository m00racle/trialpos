<?php
  //this model the object: customer
  require_once 'connectdb.php';

  /**
   *
   */
  class ModelCustomer
  {
    // VIEW DATA CUSTOMER;
    static public function modDataCustomer($table, $item, $value, $order="ASC")
    {
      if ($item != null) {
        $stmt = Connection::connect()->prepare("SELECT * FROM $table WHERE $item = :$item ORDER BY id $order");
        $stmt->bindParam(":".$item, $value, PDO::PARAM_STR);
        $stmt -> execute();
        return $stmt -> fetch(PDO::FETCH_ASSOC);
        // code...if ($item != null)
      } else {
        $stmt = Connection::connect()->prepare("SELECT * FROM $table ORDER BY id $order");
        $stmt -> execute();
        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
        // code...else...if ($item != null)
      }
      $stmt -> close();
      $stmt = null;
      // --static public function modDataCustomer($table, $item, $value)
    }

    static public function modCreateCustomer($table, $data)
    {
      $stmt = Connection::connect()->prepare("INSERT INTO $table(name, doc_id, email, phone,
              address, birthdate)
              VALUES (:name, :doc_id, :email, :phone, :address, :birthdate)");
      $stmt->bindParam(":name", $data['name'], PDO::PARAM_STR);
      $stmt->bindParam(":doc_id", $data['doc_id'], PDO::PARAM_STR);
      $stmt->bindParam(":email", $data['email'], PDO::PARAM_STR);
      $stmt->bindParam(":phone", $data['phone'], PDO::PARAM_STR);
      $stmt->bindParam(":address", $data['address'], PDO::PARAM_STR);
      $stmt->bindParam(":birthdate", $data['birthdate'], PDO::PARAM_STR);

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
      // --static public function modCreateCustomer($table, $data)
    }

    static public function modEditCustomer($table, $data)
    {
      $stmt = Connection::connect()->prepare("UPDATE $table
              SET name = :name, email = :email, phone = :phone,
              address = :address, birthdate = :birthdate WHERE doc_id = :doc_id");

      $stmt->bindParam(":doc_id", $data['doc_id'], PDO::PARAM_STR);
      $stmt->bindParam(":name", $data['name'], PDO::PARAM_STR);
      $stmt->bindParam(":email", $data['email'], PDO::PARAM_STR);
      $stmt->bindParam(":phone", $data['phone'], PDO::PARAM_STR);
      $stmt->bindParam(":address", $data['address'], PDO::PARAM_STR);
      $stmt->bindParam(":birthdate", $data['birthdate'], PDO::PARAM_STR);

      if ($stmt->execute()) {
        return "ok";
      } else {
        return "error";
      }

      $stmt->close();
      $stmt = null;
      // --static public function modEditCustomer($table, $data)
    }
    // TODO: make a new method to update certain attribute of the customer entity in the customer relation;

    static public function modDeleteCustomer($table, $data)
    {
      $stmt = Connection::connect()->prepare("DELETE FROM $table WHERE id = :id");
      $stmt->bindParam(":id", $data, PDO::PARAM_INT);

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
      // --static public function modDeleteCustomer($table, $data)
    }
    // --class ModelCustomer
  }

?>
