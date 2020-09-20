<?php

  /**
   * Controller for customer;
   */
  class ControllerCustomer
  {
    static public function ctrDataCustomer($item, $value, $order="ASC")
    {
      $response = ModelCustomer::modDataCustomer("customer", $item, $value, $order);
      return $response;
      // --static public function ctrDataCustomer($item, $value)
    }

    static public function ctrAddCustomer()
    {
      if (isset($_POST["newCustomerName"])) {
        if (preg_match('/^[a-zA-Z0-9 ]+$/', $_POST["newCustomerName"])) {
          // check if customer is already exist;
          $check = ModelCustomer::modDataCustomer("customer", "name", $_POST["newCustomerName"]);
          if ($check == false && $check["address"] != $_POST["newCustomerAddress"]
              && $check["birthdate"] != $_POST["newCustomerBirthDate"]) {
                $data = array('name' => $_POST["newCustomerName"],
                              'doc_id' => $_POST["newDocumentId"],
                              'email' => $_POST["newCustomerEmail"],
                              'phone' => $_POST["newCustomerPhone"],
                              'address' => $_POST["newCustomerAddress"],
                              'birthdate' => $_POST["newCustomerBirthDate"],);
                $response = ModelCustomer::modCreateCustomer("customer", $data);
                if ($response == "ok") {
                  echo "<script>
                  Swal.fire({
                    icon: 'success',
                    title: 'Add Customer: ".$_POST['newCustomerName']." Berhasil!',
                    text: 'Customer sudah ditambahkan ke database!',
                    confirmButtonText: 'OK Lanjut!',
                    allowOutsideClick: false
                  }).then((result) => {
                    if (result.value) {
                        window.location = 'index.php?route=customer';
                    }
                  })
                    </script>";
                  // code...if ($response == "ok")
                } else {
                  echo "<script>
                  Swal.fire({
                    icon: 'error',
                    title: 'Add Customer: ".$_POST['newCustomerName']." Gagal!',
                    text: 'Customer gagal ditambahkan ke category!',
                    confirmButtonText: 'OK Ulang',
                    allowOutsideClick: true
                  }).then((result) => {
                    if (result.value) {

                    }
                  })
                    </script>";
                  // code...else of if ($response == "ok")
                }
            // code...if ($check == false && $check["address"] != $_POST["newCustomerAddress"]
          } else {
            echo "<script>
            Swal.fire({
              icon: 'warning',
              title: 'Customer: ".$_POST['newCustomerName']." sudah terdaftar!',
              text: 'Customer telah terdaftar dengan doc id:".$check['doc_id']."!',
              confirmButtonText: 'OK',
              allowOutsideClick: true
            }).then((result) => {
              if (result.value) {
                window.location = 'index.php?route=customer';
              }
            })
              </script>";
            // code...else of if ($check == false && $check["address"] != $_POST["newCustomerAddress"]
          }

          // code...if (preg_match('/^[a-zA-Z0-9 ]+$/', $_POST["newCustomerName"]))
        } else {
          echo "<script>
          Swal.fire({
            icon: 'error',
            title: 'Add Customer: ".$_POST['newCustomerName']." Gagal!',
            text: 'Hanya karakter huruf dan angka yang diperbolehkan untuk nama lengkap Supplier!',
            confirmButtonText: 'OK Ulang',
            allowOutsideClick: true
          }).then((result) => {
            if (result.value) {

            }
          })
            </script>";
          // code...else of if (preg_match('/^[a-zA-Z0-9 ]+$/', $_POST["newCustomerName"]))
        }
        // code...if (isset($_POST["newCustomerName"]))
      }

      // --static public function ctrAddCustomer()
    }

    static public function ctrEditCustomer()
    {
      if (isset($_POST["editCustomerName"])) {
        if (preg_match('/^[a-zA-Z0-9 ]+$/', $_POST["editCustomerName"])) {
          $data = array('name' => $_POST["editCustomerName"],
                        'doc_id' => $_POST["editDocumentId"],
                        'email' => $_POST["editCustomerEmail"],
                        'phone' => $_POST["editCustomerPhone"],
                        'address' => $_POST["editCustomerAddress"],
                        'birthdate' => $_POST["editCustomerBirthDate"]);
          // echo "<script>console.log(".json_encode($data).")</script>"; // TEMP:
          $response = ModelCustomer::modEditCustomer("customer", $data);

          if ($response == "ok") {
            echo "<script>
            Swal.fire({
              icon: 'success',
              title: 'Edit Customer: ".$_POST['newCustomerName']." Berhasil!',
              text: 'Customer sudah diupdate di database!',
              confirmButtonText: 'OK Lanjut!',
              allowOutsideClick: false
            }).then((result) => {
              if (result.value) {
                  window.location = 'index.php?route=customer';
              }
            })
              </script>";
            // code...if ($response == "ok")
          } else {
            echo "<script>
            Swal.fire({
              icon: 'error',
              title: 'Edit Customer: ".$_POST['newCustomerName']." Gagal!',
              text: 'Customer gagal diupdate ke database!',
              confirmButtonText: 'OK Ulang',
              allowOutsideClick: true
            }).then((result) => {
              if (result.value) {

              }
            })
              </script>";
            // else...if ($response == "ok")
          }
          // code...if (preg_match('/^[a-zA-Z0-9 ]+$/', $_POST["editCustomerName"]))
        } else {
          echo "<script>
          Swal.fire({
            icon: 'error',
            title: 'Edit data Customer: ".$_POST['editCustomerName']." Gagal!',
            text: 'Hanya karakter huruf dan angka yang diperbolehkan untuk nama lengkap Supplier!',
            confirmButtonText: 'OK Ulang',
            allowOutsideClick: true
          }).then((result) => {
            if (result.value) {

            }
          })
            </script>";
          // else...if (preg_match('/^[a-zA-Z0-9 ]+$/', $_POST["editCustomerName"]))
        }
        // code...if (isset($_POST["editCustomerName"]))
      }
      // --static public function ctrEditCustomer()
    }

    static public function ctrDeleteCustomer()
    {
      if (isset($_GET["idCustomer"])) {
        // echo "<script>console.log('id', ".json_encode($_GET["idCustomer"]).")</script>";// TEMP:
        $response = ModelCustomer::modDeleteCustomer("customer", $_GET["idCustomer"]);

        if ($response == "ok") {
          echo "<script>
          Swal.fire({
            icon: 'success',
            title: 'Customer Telah Dihapus!',
            text: 'Customer sudah dihapus dari basis data. Klik lanjut untuk melanjutkan',
            confirmButtonText: 'OK Lanjut',
            allowOutsideClick: true
          }).then((result) => {
            if (result.value) {
                window.location = 'index.php?route=customer';
            }
          })
            </script>";
          // code...if ($response == "ok")
        } else {
          echo "<script>
          Swal.fire({
            icon: 'error',
            title: 'Customer Gagal Dihapus!',
            text: 'Customer gagal dihapus dari basis data. Klik ok untuk mengulang',
            confirmButtonText: 'OK Ulang',
            allowOutsideClick: true
          }).then((result) => {
            if (result.value) {
                window.location = 'index.php?route=customer';
            }
          })
            </script>";
          // else...if ($response == "ok")
        }
        // code...if (isset($_GET["idCustomer"]))
      }
      // --static public function ctrDeleteCustomer()
    }
    // --class ControllerCustomer
  }

 ?>
