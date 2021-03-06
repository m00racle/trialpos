<?php
  require_once "connectdb.php";

  /**
   * Model user object
   */
  class ModelUser
  {

    // function __construct(argument)
    // {
    //   // code...non contructed!
    // }
    static public function modViewUser($table, $item, $value)
    {
      // code...this will call the user data from the  database using SELECT;
      // NOTE: this method is static since it is called using ::
      //prepare the statement;
      if ($item != null) {
        // code...
        $stmt = Connection::connect()->prepare("SELECT * FROM $table WHERE $item = :$item");
        $stmt -> bindParam(":".$item, $value, PDO::PARAM_STR); // NOTE: this means the parameter is string;
        $stmt -> execute();
        return $stmt -> fetch(PDO::FETCH_ASSOC);
      } else {
        // code...select the whole table;
        $stmt = Connection::connect()->prepare("SELECT * FROM $table");
        $stmt -> execute();
        return $stmt -> fetchAll(PDO::FETCH_ASSOC); // NOTE: fetch all including table number index;
      }

      // erase the instaces (best practice);
      $stmt -> close();
      $stmt = null;
    }

    static public function addNewUser($table, $data)
    {
      // code...insert the data to the database table;
      $stmt = Connection::connect()->prepare("INSERT INTO $table(fullname, username, password, role, picture)
              VALUES (:fullname, :username, :password, :role, :picture)");

      // link the parameters;
      $stmt->bindParam(":fullname", $data['fullname'], PDO::PARAM_STR);
      $stmt->bindParam(":username", $data['username'], PDO::PARAM_STR);
      $stmt->bindParam(":password", $data['password'], PDO::PARAM_STR);
      $stmt->bindParam(":role", $data['role'], PDO::PARAM_STR);
      $stmt->bindParam(":picture", $data['picture'], PDO::PARAM_STR);

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
    }

    static public function editDataUser($table, $data)
    {
      // code...
      $stmt = Connection::connect()->prepare("UPDATE $table SET fullname = :fullname, password = :password,
              role = :role, picture = :picture WHERE username = :username");

      // bind parameters;
      $stmt->bindParam(":fullname", $data['fullname'], PDO::PARAM_STR);
      $stmt->bindParam(":username", $data['username'], PDO::PARAM_STR);
      $stmt->bindParam(":password", $data['password'], PDO::PARAM_STR);
      $stmt->bindParam(":role", $data['role'], PDO::PARAM_STR);
      $stmt->bindParam(":picture", $data['picture'], PDO::PARAM_STR);

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

      // end of static public function editDataUser($table, $data)
    }

    // UPDATE USER STATUS;
    static public function mdlActivateUser($table, $item1, $value1, $item2, $value2)
    {
      $stmt = Connection::connect()->prepare("UPDATE $table SET $item1 = :$item1 WHERE $item2 = :$item2");
      $stmt->bindParam(":".$item1, $value1, PDO::PARAM_STR);
      $stmt->bindParam(":".$item2, $value2, PDO::PARAM_STR);

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
    }

    // DELETE THE USER;
    static public function mdlDeleteUser($table, $data)
    {
      $stmt = Connection::connect()->prepare("DELETE FROM $table WHERE userid = :userid");
      $stmt->bindParam(":userid", $data, PDO::PARAM_INT);

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
    }

    // end of class ModelUser
  }

?>
