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
          $item = "username"; //<- this the variable to  test in the database we want username key;
          $value = $_POST["txtusername"];

          // response from the test should come from the model class of the user;
          $response = ModelUser::modViewUser($table, $item, $value);
          // NOTE: the ModelUser here is class with static method call modViewUser;
          // var_dump($response); // NOTE: test delete/comment out after use!

          // NOTE: remember this is newer version of php when it failed to find the usernmae
          //      instead of returning NULL it will return bollean type false; thus to override it;
          if ($response == false || $response['username'] == NULL) {
            // code...user not found;
            //echo "user not found!"; // NOTE: for test only! comment out or delete!
            echo "<script>
              $(document).ready(function(){
                Swal.fire({
                  icon: 'error',
                  title: 'Login Gagal!',
                  text: 'User ".$_POST['txtusername']." tidak terdaftar! hubungi admin apabila ada masalah',
                  confirmButtonText: 'OK Ulang',
                  allowOutsideClick: true
                }).then((result) => {
                  if (result.value) {

                  }
                })
              });

              </script>";

          } elseif ($response["password"] == $_POST["txtpass"]) {
            // code... user match can login; start collect session;
            // echo "<div class='alert alert-success'>Welcome!</div>"; // NOTE: test only
            $_SESSION['login'] = 'ok';
            // $_SESSION['username'] = $response['username'];
            echo "<script>
              $(document).ready(function(){
                Swal.fire({
                  icon: 'success',
                  title: 'Login ".$response['username']." Berhasil!',
                  text: 'anda masuk sebagai ".$response['role']."',
                  confirmButtonText: 'OK Lanjut!',
                  allowOutsideClick: false
                }).then((result) => {
                  if (result.value) {
                    window.location.replace('dashboard')
                  }
                })
              });

              </script>";

          } else {
            // code...wrong password;
            echo "<script>
              $(document).ready(function(){
                Swal.fire({
                  icon: 'warning',
                  title: 'Login ".$response['username']." Gagal!',
                  text: 'password yang anda masukkan salah! Hubungi admin apabila ada masalah atau anda lupa',
                  confirmButtonText: 'OK Ulang',
                  allowOutsideClick: true
                }).then((result) => {
                  if (result.value) {

                  }
                })
              });

              </script>";
          }
        } else {
          // code...alert only alphanumeric allowed;
          echo "<script>
            $(document).ready(function(){
              Swal.fire({
                icon: 'error',
                title: 'Login ".$_POST['txtusername']." Gagal!',
                text: 'Hanya karakter huruf dan angka tanpa spasi yang diperbolehkan untuk nama user dan password!',
                confirmButtonText: 'OK Ulang',
                allowOutsideClick: true
              }).then((result) => {
                if (result.value) {

                }
              })
            });

            </script>";
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
