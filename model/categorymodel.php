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

    // -- class ModelSupplier
  }

 ?>
