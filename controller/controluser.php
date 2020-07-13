<?php
  /**
   * // controller for user;
   */
  class UserController
  {

    // function __construct(argument)
    // {
    //   // code...non constructed class;
    // }
    static public function ctrUserLogin()
    {
      // code...control the user login;
      if (isset($_POST["txtusername"])) {
        // code...check if all the username characters are alphanumerics;
        if (preg_match('/^[a-zA-Z0-9]+$/', $_POST["txtusername"])
            && preg_match('/^[a-zA-Z0-9]+$/', $_POST["txtpass"])) {
          // code...then call the database for table user;
          $table = 'user';
          // then we consult to the model user which will verify if the user is valid;
          $item = "username"; //<- this the variable to  test;
          $value = $_POST["txtusername"];

          // response from the test should come from the model class of the user;
          $response = ModelUser::modViewUser($table, $item, $value);
          // NOTE: the ModelUser here is class with static method call modViewUser;
          // var_dump($response); // NOTE: test delete/comment out after use!

          // NOTE: remember this is newer version of php when it failed to find the usernmae
          //      instead of returning NULL it will return bollean type false; thus to override it;
          if ($response == false) {
            // code...user not found;
            echo "<br><div class='alert alert-danger'>User not found!</div>";
          } elseif ($response["password"] == $_POST["txtpass"]) {
            // code... user match can login; start collect session;
            // echo "<div class='alert alert-success'>Welcome!</div>"; // NOTE: test only
            $_SESSION['login'] = 'ok';
            echo "<script>
              window.location = 'dashboard';
            </script>";
          } else {
            // code...wrong password;
            echo "<br><div class='alert alert-warning'>Failed to Login: Password is wrong!</div>";
          }
        }
      }
    }

    static public function ctrCreateUser()()
    {
      // code...create and add new user;
      if (isset($_POST["newUser"])) {
        // code...validate if the syntax for username contains only alphanumeric with no spaces
        // validate the newName must be alphanumeric but allows spaces
        // for the password is the same as the username
        if (preg_match('/^[a-zA-Z0-9]+$/', $_POST['newUser'])
            && preg_match('/^[a-zA-Z0-9 ]+$/', $_POST['newName'])
            && preg_match('/^[a-zA-Z0-9]+$/', $_POST['newPass'])) {
          // code...
        } else {
          // code...the input is not valid due to preg_match restriction;
          echo "input not valid!"; // NOTE: change this to sweetalert later!
        }
      }
    }
  }

 ?>
