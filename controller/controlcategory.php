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

    // end of class ControllerSupplier
  }

 ?>
