<?php
/**
 *
 */
class Connection
{
  //
  // function __construct(argument)
  // {
  //   // code...non constructed;
  // }
  static public function connect()
  {
    // code...connect to the database using PDO;
    $hostname="localhost";
    $db_name="pos_db";
    $db_serv="mysql:host=".$hostname.";dbname=".$db_name;
    $db_account="root"; // NOTE: this is the default user account for localhost db!
    // NOTE: change when using cloud base hosting database!
    $db_pass = ""; // NOTE: default setting for localhost: no password!
    try {
      $conn = new PDO($db_serv,$db_account,$db_pass);
    } catch (PDOException $e) {
      echo "Connection failed: ". $e->getMessage();
    }
    // now we need to ensure all returns are in alphanumeric utf 8 standard;
    $conn->exec("set names utf8");

    // return connection that already configured for PDO;
    return $conn;
  }
}

 ?>
