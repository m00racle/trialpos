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
          && preg_match('/^[0-9.]+$/', $_POST['newStock'])
          && preg_match('/^[0-9.]+$/', $_POST['newBuyingPrice'])
          && preg_match('/^[0-9.]+$/', $_POST['newSellingPrice'])) {

            $route = "";
            if (isset($_FILES["newPictProduct"]["tmp_name"])
                && $_FILES["newPictProduct"]["tmp_name"] != null) {
              // echo "<script>console.log(".json_encode($_FILES["newPictProduct"]["tmp_name"]).")</script>"; // TEMP:
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

            // echo "<script>console.log(".json_encode($trials).")</script>"; // TEMP:
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
                    window.location = 'index.php?route=product';
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
                    window.location = 'index.php?route=product';
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
                window.location = 'index.php?route=product';
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

    static public function ctrEditProduct()
    {
      if (isset($_POST["editCode"])) {
        if (preg_match('/^[a-zA-Z0-9 ]+$/', $_POST['editDescription'])) {
          // edit image;
          $route = $_POST["currentProductPicture"];
          if (isset($_FILES["editPictProduct"]["tmp_name"])
              && $_FILES["editPictProduct"]["tmp_name"] != null) {
                $defaultImg = "view/img/product/default/anonymousbox.png";
                if ($_POST["currentProductPicture"]!=$defaultImg) {
                  unlink($_POST["currentProductPicture"]);
                  // code...if ($_POST["currentProductPicture"]!=$defaultImg)
                }
                list($width, $height) = getimagesize($_FILES["editPictProduct"]["tmp_name"]);
                $newWidth = 500;
                $newHeight = 500;

                $pictDir = "view/img/product/".$_POST["editCode"];
                mkdir($pictDir, 0755);

                if ($_FILES["editPictProduct"]["type"] == "image/jpeg") {
                  $randomNumber = mt_rand(100,999);

                  $route = $pictDir."/".$randomNumber.".jpg";

                  $oriPict = imagecreatefromjpeg($_FILES["editPictProduct"]["tmp_name"]);
                  $finalPictSize = imagecreatetruecolor($newWidth, $newHeight);

                  imagecopyresized($finalPictSize, $oriPict, 0,0,0,0, $newWidth, $newHeight, $width, $height);

                  imagejpeg($finalPictSize, $route);

                  // code...if ($_FILES["newPict"]["type"] == "image/jpeg")
                } elseif ($_FILES["editPictProduct"]["type"] == "image/png") {
                  $randomNumber = mt_rand(100,999);

                  $route = $pictDir."/".$randomNumber.".png";

                  $oriPict = imagecreatefrompng($_FILES["editPictProduct"]["tmp_name"]);
                  $finalPictSize = imagecreatetruecolor($newWidth, $newHeight);

                  imagecopyresized($finalPictSize, $oriPict, 0,0,0,0, $newWidth, $newHeight, $width, $height);

                  imagepng($finalPictSize, $route);

                  // code...elseif $_FILES["newPict"]["type"] == "image/png")
                } else {
                  $route = "view/img/product/default/anonymousbox.png";
                  // code...elseif $_FILES["newPict"]["type"] == "image/png")
                }

            // code...if (isset($_FILES["editPictProduct"]["tmp_name"])
          } else {
            $route = $_POST["currentProductPicture"];
            // else...if (isset($_FILES["editPictProduct"]["tmp_name"])
          }
          $table = "product";
          $editTrials = array('code' => $_POST["editCode"],
                              'description' => $_POST["editDescription"],
                              'image' => $route,
                              'stock' => $_POST["editStock"],
                              'buy_price' => $_POST["editBuyingPrice"],
                              'sell_price' => $_POST["editSellingPrice"]);
          // echo "<script>console.log(".json_encode($editTrials).")</script>"; // TEMP:
          $response = ModelProduct::modEditDataProduct($table, $editTrials);

          if ($response == "ok") {
            echo "<script>
            Swal.fire({
              icon: 'success',
              title: 'Update Product: ".$_POST['editDescription']." Berhasil!',
              text: 'data product berhasil diupdate!',
              confirmButtonText: 'OK Lanjut',
              allowOutsideClick: true
            }).then((result) => {
              if (result.value) {
                  window.location = 'index.php?route=product';
              }
            })
              </script>";
            // code...if ($response == "ok")
          } else {
            echo "<script>
            Swal.fire({
              icon: 'error',
              title: 'Update Product: ".$_POST['editDescription']." Gagal!',
              text: 'update product ke database gagal!',
              confirmButtonText: 'OK Ulang',
              allowOutsideClick: true
            }).then((result) => {
              if (result.value) {
                  window.location = 'index.php?route=product';
              }
            })
              </script>";
            // else...if ($response == "ok")
          }

          // code...if (preg_match('/^[a-zA-Z0-9 ]+$/', $_POST['editDescription']))
        } else {
          echo "<script>
          Swal.fire({
            icon: 'error',
            title: 'Update Product: ".$_POST['editDescription']." Gagal!',
            text: 'ada karakter input yang tidak pada tempatnya!',
            confirmButtonText: 'OK Ulang',
            allowOutsideClick: true
          }).then((result) => {
            if (result.value) {
                window.location = 'index.php?route=product';
            }
          })
            </script>";
          // else...if (preg_match('/^[a-zA-Z0-9 ]+$/', $_POST['editDescription']))
        }

        // code...if (isset($_POST["editCode"]))
      }
      // --static public function ctrEditProduct()
    }

    static public function ctrDeleteProduct()
    {
      if (isset($_GET["idDelProduct"])) {
        $table = "product";
        $data = $_GET["idDelProduct"];

        $defaultPict = "view/img/product/default/anonymousbox.png";
        if ($_GET["pictProduct"]!=$defaultPict) {
          unlink($_GET["pictProduct"]);
          rmdir("view/img/product/".$_GET["codeProduct"]);
          // code...if ($_GET["pictProduct"]!=$defaultPict)
        }

        $response = ModelProduct::modDeleteProduct($table, $data);

        if ($response == "ok") {

          echo "<script>
          Swal.fire({
            icon: 'success',
            title: 'Product: ".$_GET['codeProduct']." Telah Dihapus!',
            text: 'Product sudah dihapus dari basis data. Klik lanjut untuk melanjutkan',
            confirmButtonText: 'OK Lanjut',
            allowOutsideClick: true
          }).then((result) => {
            if (result.value) {
                window.location = 'index.php?route=product';
            }
          })
            </script>";
            // -- if ($response == "ok")
        }
        // code...if (isset($_GET["idDelProduct"]))
      }
      // --static public function ctrDeleteProduct()
    }

    // --class ControllerProduct
  }


 ?>
