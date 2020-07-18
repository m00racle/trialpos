<?php
  // controller for supplier;
  /**
   *
   */
  class ControllerSupplier
  {
    // controller for supplier;
    static public function ctrCreateSupplier()
    {
      if (isset($_POST["newSupplier"])) {
        // code...we are make new Supplier
        if (preg_match('/^[a-zA-Z0-9 ]+$/', $_POST["newSupplier"])) {
          $table = "supplier";
          $data = array('supname' => $_POST['newSupplier'],
                        'status' => $_POST['newStatus'],
                        'bankacc' => $_POST['newBankAcc'],
                        'accnum' => $_POST['newAccNum'],);

          $response = ModelSupplier::mdlCreateCategory($table, $data);

          if ($response == "ok") {
            // code...supplier created;
            echo "<script>
            Swal.fire({
              icon: 'success',
              title: 'Add Supplier: ".$_POST['newSupplier']." Berhasil!',
              text: 'Supplier sudah ditambahkan ke database!',
              confirmButtonText: 'OK Lanjut!',
              allowOutsideClick: false
            }).then((result) => {
              if (result.value) {
                  window.location = 'category';
              }
            })
              </script>";

              // end: if ($response == "ok");
          } else {
            // code...suplier gagal ditambahkan ke database;
            echo "<script>
            Swal.fire({
              icon: 'error',
              title: 'Add Supplier: ".$_POST['newSupplier']." Gagal!',
              text: 'User gagal ditambahkan ke category!',
              confirmButtonText: 'OK Ulang',
              allowOutsideClick: true
            }).then((result) => {
              if (result.value) {

              }
            })
              </script>";

              // end: else of if ($response == "ok")
          }

          // end of if (preg_match('/^[a-zA-Z0-9 ]+$/', $_POST["newSupplier"]))
        } else {
          // code...sweetalert;
          echo "<script>
          Swal.fire({
            icon: 'error',
            title: 'Add Supplier: ".$_POST['newSupplier']." Gagal!',
            text: 'Hanya karakter huruf dan angka yang diperbolehkan untuk nama lengkap Supplier!',
            confirmButtonText: 'OK Ulang',
            allowOutsideClick: true
          }).then((result) => {
            if (result.value) {
                window.location = 'category';
            }
          })
            </script>";

            // end of else from if (preg_match('/^[a-zA-Z0-9 ]+$/', $_POST["newSupplier"]))
        }
      }

      // end of static public function ctrCreateSupplier()
    }

    static public function ctrDataSupplier($item,$value)
    {
      //control the supllier data fetch;
      $table = "supplier";

      $response = ModelSupplier::modViewSupplier($table, $item, $value);

      return $response;

      // -- static public function ctrDataSupplier($item,$value)
    }

    static public function ctrEditSupplier()
    {
      if (isset($_POST["editSupplier"])) {
        // code...edit the user data;
        $table = "supplier";

        $data = array("supname" => $_POST["editSupplier"],
                      "status" => $_POST["editStatus"],
                      "bankacc" => $_POST["editBankAcc"],
                      "accnum" => $_POST["editAccNum"]);

        $response = ModelSupplier::modEditSupplier($table, $data);

        if ($response == "ok") {
          // code...alert success!
          echo "<script>
          Swal.fire({
            icon: 'success',
            title: 'Update Data Supplier: ".$_POST['editSupplier']." Berhasil!',
            text: 'Supplier berhasil dimodifikasi di basis data. Klik lanjut untuk melanjutkan',
            confirmButtonText: 'OK Lanjut',
            allowOutsideClick: true
          }).then((result) => {
            if (result.value) {
                window.location = 'category';
            }
          })
            </script>";

            // --if ($response == "ok")
        } else {
          echo "<script>
          Swal.fire({
            icon: 'error',
            title: 'Update Supplier: ".$_POST['editSupplier']." Gagal!',
            text: 'Upload ke basis data gagal!',
            confirmButtonText: 'OK Ulang!',
            allowOutsideClick: true
          }).then((result) => {
            if (result.value) {

            }
          })
            </script>";

          // -- else of if ($response == "ok")
        }

        // -- if (isset($_POST["editSupplier"]))
      }

      // --static public function ctrEditSupplier()
    }

    // DELETE SUPPLIER!
    static public function ctrDeleteSupplier()
    {
      // the supplier delete is denoted by the uri get idSupplier
      if (isset($_GET["idSupplier"])) {
        $table = "supplier";
        $data = $_GET["idSupplier"];

        $response = ModelSupplier::mdlDeleteSupplier($table, $data);

        if ($response = "ok") {
          echo "<script>
          Swal.fire({
            icon: 'success',
            title: 'Supplier: ".$_GET['nameSupplier']." Telah Dihapus!',
            text: 'User sudah dihapus dari basis data. Klik lanjut untuk melanjutkan',
            confirmButtonText: 'OK Lanjut',
            allowOutsideClick: true
          }).then((result) => {
            if (result.value) {
                window.location = 'category';
            }
          })
            </script>";

          // --if ($response = "ok")
        } else {
          echo "<script>
          Swal.fire({
            icon: 'error',
            title: 'Supplier: ".$_GET['nameSupplier']." Gagal Dihapus!',
            text: 'User gagal dihapus dari basis data. Klik ok untuk mengulang',
            confirmButtonText: 'OK Ulang',
            allowOutsideClick: true
          }).then((result) => {
            if (result.value) {
                window.location = 'category';
            }
          })
            </script>";

          // -- else of if ($response = "ok")
        }

        // --if (isset($_GET["idSupplier"]))
      }

      // --static public function ctrDeleteSupplier()
    }

    // end of class ControllerSupplier
  }

 ?>
