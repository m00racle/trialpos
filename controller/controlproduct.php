<?php
  // controller for products;
  /**
   * Control every aspect of product data;
   */
  class ControllerProduct
  {
    static public function ctrDataProduct($item, $value)
    {
      $table = "product";

      $response = ModelProduct::modViewProduct($table, $item, $value);

      return $response;

      // --static public function ctrDataProduct($item, $value)
    }

    static public function ctrCreateProduct()
    {
      // check if there is a newProduct incoming with POST request;
      if (isset($_POST["newDescription"])) {
        // check if the syntax of the description does not contain unwanted chars;
        if (preg_match('/^[a-zA-Z0-9 ]+$/', $_POST['newDescription'])
          && preg_match('/^[0-9]+$/', $_POST['newStock'])
          && preg_match('/^[0-9]+$/', $_POST['newBuyingPrice'])
          && preg_match('/^[0-9]+$/', $_POST['newSellingPrice'])) {

            $route = "";
            if (isset($_FILES["newPictProduct"]["tmp_name"])
                && $_FILES["newPictProduct"]["tmp_name"] != null) {
              // echo "<script>console.log(".json_encode($_FILES["newPictProduct"]["tmp_name"]).")</script>"; // NOTE: debug
              list($width, $height) = getimagesize($_FILES["newPictProduct"]["tmp_name"]);
              $newWidth = 500;
              $newHeight = 500;

              $pictDir = "view/img/product/".$_POST["newCode"];
              mkdir($pictDir, 0755);

              if ($_FILES["newPictProduct"]["type"] == "image/jpeg") {
                $randomNumber = mt_rand(100,999);

                $route = $pictDir."/".$randomNumber.".jpg";

                $oriPict = imagecreatefromjpeg($_FILES["newPictProduct"]["tmp_name"]);
                $finalPictSize = imagecreatetruecolor($newWidth, $newHeight);

                imagecopyresized($finalPictSize, $oriPict, 0,0,0,0, $newWidth, $newHeight, $width, $height);

                imagejpeg($finalPictSize, $route);

                // code...if ($_FILES["newPict"]["type"] == "image/jpeg")
              } elseif ($_FILES["newPictProduct"]["type"] == "image/png") {
                $randomNumber = mt_rand(100,999);

                $route = $pictDir."/".$randomNumber.".png";

                $oriPict = imagecreatefrompng($_FILES["newPictProduct"]["tmp_name"]);
                $finalPictSize = imagecreatetruecolor($newWidth, $newHeight);

                imagecopyresized($finalPictSize, $oriPict, 0,0,0,0, $newWidth, $newHeight, $width, $height);

                imagepng($finalPictSize, $route);

                // code...elseif $_FILES["newPict"]["type"] == "image/png")
              } else {
                $route = "view/img/product/default/anonymousbox.png";
                // code...elseif $_FILES["newPict"]["type"] == "image/png")
              }

              // --if (isset($_FILES["newPictProduct"]["tmp_name"]))
            } else {
              $route = "view/img/product/default/anonymousbox.png";

              // else of if (isset($_FILES["newPictProduct"]["tmp_name"]))
            }

            $table = "product";
            $trials = array('id_supplier' => $_POST["newSupplier"],
                            'code' => $_POST["newCode"],
                            'description' => $_POST["newDescription"],
                            'image' => $route,
                            'stock' => $_POST["newStock"],
                            'buy_price' => $_POST["newBuyingPrice"],
                            'sell_price' => $_POST["newSellingPrice"]);

            // echo "<script>console.log(".json_encode($trials).")</script>"; // DEBUG:
            $response = ModelProduct::modAddProduct($table, $trials);

            if ($response == "ok") {
              echo "<script>
              Swal.fire({
                icon: 'success',
                title: 'Add Product: ".$_POST['newDescription']." Berhasil!',
                text: 'Product telah masuk ke dalam database!',
                confirmButtonText: 'OK Lanjut',
                allowOutsideClick: false
              }).then((result) => {
                if (result.value) {
                    window.location = 'product';
                }
              })
                </script>";
              // code...if (response = "ok")
            }else {
              echo "<script>
              Swal.fire({
                icon: 'error',
                title: 'Add Product: ".$_POST['newDescription']." Gagal!',
                text: 'Upload ke database gagal',
                confirmButtonText: 'OK Ulang',
                allowOutsideClick: true
              }).then((result) => {
                if (result.value) {
                    window.location = 'product';
                }
              })
                </script>";
              // else...if (response = "ok")
            }

          // code...if (preg_match('/^[a-zA-Z0-9 ]+$/', $_POST['newDescription'])
            // && preg_match('/^[0-9]+$/', $_POST['newStock']))
        } else {
          echo "<script>
          Swal.fire({
            icon: 'error',
            title: 'Add Product: ".$_POST['newDescription']." Gagal!',
            text: 'ada karakter input yang tidak pada tempatnya!',
            confirmButtonText: 'OK Ulang',
            allowOutsideClick: true
          }).then((result) => {
            if (result.value) {
                window.location = 'product';
            }
          })
            </script>";

          // else.. if (preg_match('/^[a-zA-Z0-9 ]+$/', $_POST['newDescription'])
            // && preg_match('/^[0-9]+$/', $_POST['newStock']))
        }

        // code... if (isset($_POST["newDescription"]))
      }

      // -- static public function ctrCreateProduct()
    }

    // --class ControllerProduct
  }


 ?>
