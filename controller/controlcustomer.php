<?php

  /**
   * Controller for customer;
   */
  class ControllerCustomer
  {
    static public function ctrDataCustomer($item, $value)
    {
      $response = ModelCustomer::modDataCustomer("customer", $item, $value);
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
                        window.location = 'customer';
                    }
                  })
                    </script>";
                  // code...if ($response == "ok")
                } else {
                  echo "<script>
                  Swal.fire({
                    icon: 'error',
                    title: 'Add Supplier: ".$_POST['newCustomerName']." Gagal!',
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
                window.location = 'customer';
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
            title: 'Add Supplier: ".$_POST['newCustomerName']." Gagal!',
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
    // --class ControllerCustomer
  }

 ?>
