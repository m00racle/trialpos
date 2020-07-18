<?php
  //this model the object: category
  require_once "connectdb.php";

  /**
   * model supplier!
   */
  class ModelSupplier
  {
    // CREATE SUPPLIER;
    static public function mdlCreateCategory($table, $data)
    {
      $stmt = Connection::connect()->prepare("INSERT INTO $table(supname, status, bankacc, accnum)
              VALUES (:supname, :status, :bankacc, :accnum)");
      $stmt->bindParam(":supname", $data['supname'], PDO::PARAM_STR);
      $stmt->bindParam(":status", $data['status'], PDO::PARAM_STR);
      $stmt->bindParam(":bankacc", $data['bankacc'], PDO::PARAM_STR);
      $stmt->bindParam(":accnum", $data['accnum'], PDO::PARAM_STR);

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

      // --static public function mdlCreateCategory($table, $data)
    }

    // VIEW SUPPLIERS;
    static public function modViewSupplier($table, $item, $value)
    {
      if ($item != null) {
        // code...fetch only specific data;
        $stmt = Connection::connect()->prepare("SELECT * FROM $table WHERE $item = :$item");
        $stmt->bindParam(":".$item, $value, PDO::PARAM_STR);
        $stmt -> execute();
        return $stmt -> fetch(PDO::FETCH_ASSOC);

        // --if ($item != null)
      } else {
        // code...fetch all suppliers data;
        $stmt = Connection::connect()->prepare("SELECT * FROM $table");
        $stmt -> execute();
        return $stmt -> fetchAll(PDO::FETCH_ASSOC);

        // -- else of if ($item != null)
      }

      // erase the instaces (best practice);
      $stmt -> close();
      $stmt = null;

      // -- static public function modViewSupplier($table, $item, $value)
    }

    static public function modEditSupplier($table, $data)
    {
      $stmt = Connection::connect()->prepare("UPDATE $table SET status = :status, bankacc = :bankacc,
              accnum = :accnum WHERE supname = :supname");

      $stmt->bindParam(":supname", $data["supname"], PDO::PARAM_STR);
      $stmt->bindParam(":status", $data["status"], PDO::PARAM_STR);
      $stmt->bindParam(":bankacc", $data["bankacc"], PDO::PARAM_STR);
      $stmt->bindParam(":accnum", $data["accnum"], PDO::PARAM_STR);

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

      // --static public function modEditSupplier($table, $data)
    }

    static public function mdlDeleteSupplier($table, $data)
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

      // -- static public function mdlDeleteSupplier($table, $data)
    }

    // -- class ModelSupplier
  }

 ?>
