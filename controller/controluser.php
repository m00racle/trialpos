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
          // encrypt the password input;
          $salt = '$2a$07$usesomesillystringforsalt$'; // NOTE: blowfish salt!
          $encryptedLogin = crypt($_POST['txtpass'], $salt);

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

          } elseif ($response["password"] == $encryptedLogin) {
            if ($response['status'] == 1) {
              // code...login allowed;
              // code... user match can login; start collect session;
              // SESSION VARIABLES:
              $_SESSION['login'] = 'ok';
              $_SESSION['userid'] = $response['userid'];
              $_SESSION['fullname'] = $response['fullname'];
              $_SESSION['username'] = $response['username'];
              $_SESSION['picture'] = $response['picture'];
              $_SESSION['role'] = $response['role'];

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
              // code...login is not activated
              echo "<script>
                $(document).ready(function(){
                  Swal.fire({
                    icon: 'warning',
                    title: 'Login ".$response['username']." Gagal!',
                    text: 'Akun anda belum diaktifkan, hubungi admin untuk mengaktifkan akun anda!',
                    confirmButtonText: 'OK!',
                    allowOutsideClick: true
                  }).then((result) => {
                    if (result.value) {

                    }
                  })
                });

                </script>";
            }


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

      // END OF ctrUserLogin method;
    }

    static public function ctrCreateUser()
    {
      // code...create and add new user;
      if (isset($_POST["newUser"])) {
        // code...validate if the syntax for username contains only alphanumeric with no spaces
        // validate the newName must be alphanumeric but allows spaces
        // for the password is the same as the username
        if (preg_match('/^[a-zA-Z0-9]+$/', $_POST['newUser'])
            && preg_match('/^[a-zA-Z0-9 ]+$/', $_POST['newName'])
            && preg_match('/^[a-zA-Z0-9]+$/', $_POST['newPass'])) {
          // code...process the data update from user static method addNewUser;

          // upload the user photo; VALIDATE IMAGE
          // NOTE: the default profile pict route needs to be defined judt in case user does not upload any photos;
          $route = '';
          if (isset($_FILES["newPict"]["tmp_name"])) {
            // code...upload the photo to the view/img/user folder;
            // trim the controller to trim the picture to the desired size;
            list($width, $height) = getimagesize($_FILES["newPict"]["tmp_name"]);
            // NOTE: this is a method from PHP the width is index 1 and the height is index 2 in result;

            $newWidth = 500;
            $newHeight = 500;
            // NOTE: these are in pixels

            // set the directory to save the photos;
            $pictDir = "view/img/user/".$_POST["newUser"];
            // NOTE: this will make the file view/img/user/[username].jpg or .png;
            mkdir($pictDir, 0755);
            // NOTE: this is the standard CGI file permission (only user can write others read and execute);

            // put the newPict filetype extension;
            if ($_FILES["newPict"]["type"] == "image/jpeg") {
              // code...save the image inside the folder created earlier;
              // the filename will be a random number between 100 to 999;
              // $randomNumber = at_rand(100,999); // NOTE: at_rand is a php method;

              // set the route to the filename;
              $route = "view/img/user/".$_POST["newUser"]."/profilepic.jpg";
              // NOTE: this will save the image as a random number.jpg;

              // prepare the image and trim it;
              $oriPict = imagecreatefromjpeg($_FILES["newPict"]["tmp_name"]);
              // NOTE: this the original picture uploaded;
              $finalPictSize = imagecreatetruecolor($newWidth, $newHeight);
              // NOTE: imagecreatetruecolor is a php method that creates image on specific width and height as param;

              // resize the image;
              imagecopyresized($finalPictSize, $oriPict, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
              // NOTE: imagecopyresized ( resource $dst_image , resource $src_image ,
              //      int $dst_x , int $dst_y , int $src_x , int $src_y , int $dst_w ,
              //      int $dst_h , int $src_w , int $src_h ) : bool

              // save the picture in the route path;
              imagejpeg($finalPictSize, $route);
              // NOTE: imagejpeg ( resource $image [, mixed $to = NULL [, int $quality = -1 ]] ) : bool
              // imagejpeg — Output image to browser or file
            } elseif ($_FILES["newPict"]["type"] == "image/png") {
              // code...file png;
              // set the route to the filename;
              $route = "view/img/user/".$_POST["newUser"]."/profilepic.png";
              // NOTE: this will save the image as a random number.jpg;

              // prepare the image and trim it;
              $oriPict = imagecreatefrompng($_FILES["newPict"]["tmp_name"]);
              // NOTE: this the original picture uploaded;
              $finalPictSize = imagecreatetruecolor($newWidth, $newHeight);
              // NOTE: imagecreatetruecolor is a php method that creates image on specific width and height as param;

              // resize the image;
              imagecopyresized($finalPictSize, $oriPict, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
              // NOTE: imagecopyresized ( resource $dst_image , resource $src_image ,
              //      int $dst_x , int $dst_y , int $src_x , int $src_y , int $dst_w ,
              //      int $dst_h , int $src_w , int $src_h ) : bool

              // save the picture in the route path;
              imagepng($finalPictSize, $route);
            } else {
              // code...just use the default user picture;
              // code...file png;
              // set the route to the filename;
              $route = "view/img/user/".$_POST["newUser"]."/profilepic.png";
              $source = "view/img/user/default/userdefault.png";

              // copy the default pics:
              copy($source, $route);
            }

            // var_dump($_FILES["newPict"]["type"]); // NOTE: test delete or comment ater;
          }

          // ENCRYPT THE PASSWORD INPUT:
          $salt = '$2a$07$usesomesillystringforsalt$'; // NOTE: blowfish salt!
          $encryptor = crypt($_POST['newPass'], $salt);
          // crypt ( string $str [, string $salt ] ) : string
          // crypt() will return a hashed string using the standard Unix DES-based
          // algorithm or alternative algorithms that may be available on the system.

          // UPLOAD NEW USER DATA TO THE DATABASE;
          $table = "user"; // NOTE: this is the table name in the database;

          $data = array('fullname' => $_POST['newName'],
                        'username' => $_POST['newUser'],
                        'password' => $encryptor,
                        'role' => $_POST['newRole'],
                        'picture' => $route);

          // call the addNewUser static method from the ModelUser class;
          $response = ModelUser::addNewUser($table, $data);

          // test if the process is done;
          if ($response == 'ok') {
            // code...give sweetalert2;
            echo "<script>
            Swal.fire({
              icon: 'success',
              title: 'Add User: ".$_POST['newUser']." Berhasil!',
              text: 'User berhasil disimpan di basis data. Klik lanjut untuk melanjutkan',
              confirmButtonText: 'OK Lanjut',
              allowOutsideClick: true
            }).then((result) => {
              if (result.value) {
                  window.location = 'user';
              }
            })
              </script>";
          } else {
            // code...think of an action will you...
            echo "<script>
            Swal.fire({
              icon: 'error',
              title: 'Add User: ".$_POST['newUser']." Gagal!',
              text: 'Upload ke basis data gagal!',
              confirmButtonText: 'OK Ulang!',
              allowOutsideClick: true
            }).then((result) => {
              if (result.value) {

              }
            })
              </script>";
          }
        } else {
          // code...the input is not valid due to preg_match restriction;
          // put a sweetalert2 and reload the user page;
          echo "<script>
          Swal.fire({
            icon: 'error',
            title: 'Add User: ".$_POST['newUser']." Gagal!',
            text: 'Hanya karakter huruf dan angka tanpa spasi yang diperbolehkan untuk nama user dan password!',
            confirmButtonText: 'OK Ulang',
            allowOutsideClick: true
          }).then((result) => {
            if (result.value) {
                window.location = 'user';
            }
          })
            </script>";
        }
      }

      // -END OF ctrCreateUser method;
    }

    static public function ctrDataUser($item, $value)
    {
      // code...CONTROL THE USER DATA VIEW;
      // connect to the ModelUser class and modViewUser to fetch data;
      $table = 'user';
      $response = ModelUser::modViewUser($table, $item, $value);
      return $response;
    }

    static public function ctrEditUser()
    {
      // code...CONTROL EDIT USER!
      if (isset($_POST["editUser"])) {
        // code...run Edit user!
        // first we check on the validity of the new fullname since username is not changeable;
        // and password is stored in the hidden input;
        // NOTE: changing the username will make the user folder render useless thus we cannot allow it!
        if (preg_match('/^[a-zA-Z0-9 ]+$/', $_POST['editName'])) {
          // code...
          // VALIDATE image
          $route = $_POST['currentPict'];
          if (isset($_FILES["editPict"]["tmp_name"])) {
            // code...upload the photo to the view/img/user folder;
            // trim the controller to trim the picture to the desired size;
            list($width, $height) = getimagesize($_FILES["editPict"]["tmp_name"]);
            // NOTE: this is a method from PHP the width is index 1 and the height is index 2 in result;

            $newWidth = 500;
            $newHeight = 500;
            // NOTE: these are in pixels

            // set the directory to save the photos;
            $pictDir = "view/img/user/".$_POST["editUser"];
            // NOTE: this will make the file view/img/user/[username].jpg or .png;

            mkdir($pictDir, 0755);
            // NOTE: this is the standard CGI file permission (only user can write others read and execute);

            // put the newPict filetype extension;
            if ($_FILES["editPict"]["type"] == "image/jpeg") {
              // code...save the image inside the folder created earlier;
              // delete the existing pict file if new one exist;
              unlink($_POST['currentPict']);
              // the filename will be a random number between 100 to 999;
              $randomNumber = mt_rand(100,999); // NOTE: at_rand is a php method;

              // set the route to the filename;
              $route = "view/img/user/".$_POST["editUser"]."/".$randomNumber.".jpg";
              // NOTE: this will save the image as a random number.jpg;

              // prepare the image and trim it;
              $oriPict = imagecreatefromjpeg($_FILES["editPict"]["tmp_name"]);
              // NOTE: this the original picture uploaded;
              $finalPictSize = imagecreatetruecolor($newWidth, $newHeight);
              // NOTE: imagecreatetruecolor is a php method that creates image on specific width and height as param;

              // resize the image;
              imagecopyresized($finalPictSize, $oriPict, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
              // NOTE: imagecopyresized ( resource $dst_image , resource $src_image ,
              //      int $dst_x , int $dst_y , int $src_x , int $src_y , int $dst_w ,
              //      int $dst_h , int $src_w , int $src_h ) : bool

              // save the picture in the route path;
              imagejpeg($finalPictSize, $route);
              // NOTE: imagejpeg ( resource $image [, mixed $to = NULL [, int $quality = -1 ]] ) : bool
              // imagejpeg — Output image to browser or file
              // end of if ($_FILES["editPict"]["type"] == "image/jpeg")
            } elseif ($_FILES["editPict"]["type"] == "image/png") {
              // code...file png;
              // delete the existing pict file if new one exist;
              unlink($_POST['currentPict']);
              // set the route to the filename;
              $randomNumber = mt_rand(100,999); // NOTE: at_rand is a php method;
              $route = "view/img/user/".$_POST["editUser"]."/".$randomNumber.".png";
              // NOTE: this will save the image as a random number.jpg;

              // prepare the image and trim it;
              $oriPict = imagecreatefrompng($_FILES["editPict"]["tmp_name"]);
              // NOTE: this the original picture uploaded;
              $finalPictSize = imagecreatetruecolor($newWidth, $newHeight);
              // NOTE: imagecreatetruecolor is a php method that creates image on specific width and height as param;

              // resize the image;
              imagecopyresized($finalPictSize, $oriPict, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
              // NOTE: imagecopyresized ( resource $dst_image , resource $src_image ,
              //      int $dst_x , int $dst_y , int $src_x , int $src_y , int $dst_w ,
              //      int $dst_h , int $src_w , int $src_h ) : bool

              // save the picture in the route path;
              imagepng($finalPictSize, $route);
              // end of elseif ($_FILES["editPict"]["type"] == "image/png")
            } else {
              // code...just use the current user picture;
              $route = $_POST['currentPict'];
              // end of else from if ($_FILES["editPict"]["type"] == "image/jpeg")
            }

            // end of if (isset($_FILES["editPict"]["tmp_name"]));
          }

          // preparing the password if changes;
          // check if the admin did change the password;
          if ($_POST["editPass"] != "") {
            // code...validate the password syntx chars;
            if (preg_match('/^[a-zA-Z0-9]+$/', $_POST['editPass'])) {
              // code...encrypt the password;
              $salt = '$2a$07$usesomesillystringforsalt$'; // NOTE: blowfish salt!
              $encryptor = crypt($_POST['editPass'], $salt);

              // end of if (preg_match('/^[a-zA-Z0-9]+$/', $_POST['newPass']))
            } else {
              // code...alert and redirect;
              echo "<script>
              Swal.fire({
                icon: 'error',
                title: 'Add User: ".$_POST['editUser']." Gagal!',
                text: 'Hanya karakter huruf dan angka tanpa spasi yang diperbolehkan untuk password!',
                confirmButtonText: 'OK Ulang',
                allowOutsideClick: true
              }).then((result) => {
                if (result.value) {
                    window.location = 'user';
                }
              })
                </script>";

                // end of else from if (preg_match('/^[a-zA-Z0-9]+$/', $_POST['editPass']))
            }

            // end of if ($_POST["editPass"] != "")
          } else {
            // code...just use the old password;
            $encryptor = $_POST["currentPass"];

            // end of else if ($_POST["editPass"] != "")
          }

          // UPLOAD EDITED USER DATA TO THE DATABASE;
          $table = "user"; // NOTE: this is the table name in the database;

          $data = array('fullname' => $_POST['editName'],
                        'username' => $_POST['editUser'],
                        'password' => $encryptor,
                        'role' => $_POST['editRole'],
                        'picture' => $route);

          // call the addNewUser static method from the ModelUser class;
          $response = ModelUser::editDataUser($table, $data);

          if ($response = "ok") {
            // code...alert;
            echo "<script>
            Swal.fire({
              icon: 'success',
              title: 'Add User: ".$_POST['editUser']." Berhasil!',
              text: 'User berhasil dimodifikasi di basis data. Klik lanjut untuk melanjutkan',
              confirmButtonText: 'OK Lanjut',
              allowOutsideClick: true
            }).then((result) => {
              if (result.value) {
                  window.location = 'user';
              }
            })
              </script>";
            // end of if ($response = "ok")
          } else {
            // code...alert;
            echo "<script>
            Swal.fire({
              icon: 'error',
              title: 'Add User: ".$_POST['newUser']." Gagal!',
              text: 'Upload ke basis data gagal!',
              confirmButtonText: 'OK Ulang!',
              allowOutsideClick: true
            }).then((result) => {
              if (result.value) {

              }
            })
              </script>";
            // end of else from if ($response = "ok")
          }


          // end - if (preg_match('/^[a-zA-Z0-9]...
        } else {
          // code...
          echo "<script>
          Swal.fire({
            icon: 'error',
            title: 'Add User: ".$_POST['editUser']." Gagal!',
            text: 'Hanya karakter huruf dan angka yang diperbolehkan untuk nama lengkap user!',
            confirmButtonText: 'OK Ulang',
            allowOutsideClick: true
          }).then((result) => {
            if (result.value) {
                window.location = 'user';
            }
          })
            </script>";

          // end of else from if (preg_match('/^[a-zA-Z0-9]...
        }

        // end of if (isset($_POST["editUser"]))
      }

      // end of static public function ctrEditUser()
    }

    // -END OF CLASS UserController
  }

 ?>
