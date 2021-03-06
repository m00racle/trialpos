<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Create Sales
      <small>Control Panel</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="index.php?route=dashboard"><i class="fa fa-dashboard"></i> Home</a></li>

      <li class="active">Create Sales</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-lg-5 col-xs-12">
        <div class="box box-success">
          <!-- this is the initial default box colored as green meaning success but when things went bad it will turns yellow as warning -->
          <div class="box-header with-border">
            <!-- empty space just to fill some sort of white space -->
          </div>
          <div class="box">
            <form class="salesForm" action="" method="post" role="form">
              <div class="box-body">
                <!-- SELLER INPUT -->
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    <input type="text" class="form-control" id="newSeller" name="newSeller" value="<?php echo $_SESSION['username']; ?>" readonly>
                    <!-- we need to add user id for the sales record but we must do this hidden -->
                    <input type="hidden" name="sellerId" value="<?php echo $_SESSION["userid"]; ?>">
                  </div>
                </div>
                <!-- BILLING CODE -->
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-key"></i></span>
                    <?php
                      $salesData = ControllerSales::ctrDataSales(null,null);
                      if (!$salesData) {
                        echo '<input type="text" class="form-control" id="newSale" name="newSale" value="1001" readonly>';
                        // code...if (!salesData)
                      } else {
                        foreach ($salesData as $key => $value) {
                          // code...just let it roll we only need the last
                        }
                        $salesCode = $value["code"] + 1;
                        echo '<input type="text" class="form-control" id="newSale" name="newSale" value="'.$salesCode.'" readonly>';
                        // else...if (!salesData)
                      }
                    ?>

                  </div>
                </div>
                <!-- CUSTOMER INPUT -->
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>

                    <select class="form-control" id="selectCustomer" name="selectCustomer" required>
                      <option value="">Select Customer</option>
                      <?php
                        $customerData = ControllerCustomer::ctrDataCustomer(null,null);
                        foreach ($customerData as $key => $value) {
                          echo '<option value="'.$value["id"].'">'.$value["name"].'</option>';
                          // code...foreach ($customerData as $key => $value)
                        }
                      ?>
                    </select>
                    <!-- add button for new customer -->
                    <span class="input-group-addon"><button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#modalAddCustomer" data-dismiss="modal">Add Customer</button></span>
                  </div>
                </div>
                <!-- ENTRY FOR NEW PRODUCT -->
                <div class="form-group row newProduct">
                  <!-- uses the jQuery  -->
                </div>
                <!-- this is the hidden input to store the JSON data of the transaction -->
                <input type="hidden" id="hiddenJson" name="hiddenJson" value="">
                <!-- the button to add products; this is for the mobile device only since in the desktop user can pick the product from the list in the right side of the form-->
                <button type="button" class="btn btn-default hidden-lg" data-toggle="modal" data-target="#modalAddProduct" data-dismiss="modal">Add Product</button><hr>
                <div class="row">
                  <div class="col-xs-8 pull-right">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>Pajak</th>
                          <th>Total</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <!-- tax and total amount -->
                          <td style="width:40%">
                            <div class="input-group">
                              <input type="number" class="form-control input-lg" min="0" id="newSalesTax" name="newSalesTax" value="0">
                              <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                            </div>
                          </td>
                          <td style="width:60%">
                            <div class="input-group">
                              <span class="input-group-addon"></span>
                              <input type="text" class="form-control input-lg" id="newTotalSales" name="newTotalSales"  beforeTax="" placeholder="00000" required readonly>
                              <input type="hidden" name="beforeTaxTotalSales" id="beforeTaxTotalSales" value="">
                              <input type="hidden" name="plainTotalSales" id="plainTotalSales" value="">
                            </div>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <hr>
                <!-- select payment methods -->
                <div class="form-group row">
                  <div class="col-xs-6" style="padding-right:0px">
                    <div class="input-group">
                      <select class="form-control" id="newPaymentMethod" name="newPaymentMethod" required>
                        <option value="">Pilih Metode Pembayaran</option>
                        <option value="cash">Cash</option>
                        <option value="CC">Credit Card</option>
                        <option value="DC">Debit Card</option>
                        <option value="App">Payment Apps</option>
                        <option value="other">Pembayaran Lain</option>
                      </select>
                    </div>
                    <input type="hidden" name="paymentCode" id="paymentCode" value="">
                    <input type="hidden" name="paymentJson" id="paymentJson" value="">
                  </div>
                  <!-- THIS IS WHERE THE VIEW WILL BE CHANGED ACCORDING TO PAYMENT METHOD -->
                  <div class="col-xs-6" id="paymentHandler" style="padding-left:0px">
                    <div class="input-group">
                      <p>Pilih Metode Pembayaran!</p>
                    </div>
                  </div>
                </div>
              </div><hr>
              <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right">Save Sales</button>
              </div>
              <!-- SUBMIT TO THE ControllerSales class to the ctrCreateSales method -->
              <?php
                $createSales = new ControllerSales();
                $createSales -> ctrCreateSales();
              ?>
            </form>
          </div>
        </div>
      </div>
      <div class="col-lg-7 hidden-md hidden-sm hidden-xs">
        <div class="box box-warning">
          <!-- this is the initial default box colored as green meaning success but when things went bad it will turns yellow as warning -->
          <div class="box-header with-border">
            <!-- just left it blank because just whitespace -->
          </div>
          <div class="box-body">
            <table class="table table-bordered table-striped dt-responsive tableProducts" id="mainTable">
              <thead>
                <tr>
                  <th style="width:10px">#</th>
                  <th>Picture</th>
                  <th>Code</th>
                  <th>Description</th>
                  <th>Stock</th>
                  <th>Action</th>
                </tr>
              </thead>

            </table>
          </div>
        </div>
      </div>

    </div>


  </section>
  <!-- /.content -->
</div>

<!-- Modal Add Customer-->
<div id="modalAddCustomer" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <form role="form" class="" action="" method="post">
        <!-- modal header -->
        <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Customer</h4>
        </div>
        <!-- modal body -->
        <div class="modal-body">
          <div class="box-body">

            <!-- form for add customer name-->
            <div class="form-group">
              <div class="input-group">
                <!-- form and input groups are classes from bootstrap -->
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input type="text" name="newCustomerName" placeholder="insert name" required
                  id="newCustomerName" class="form-control input-lg">
              </div>
            </div>
            <!-- form for insert customer document id -->
            <div class="form-group">
              <div class="input-group">
                <!-- form and input groups are classes from bootstrap -->
                <span class="input-group-addon"><i class="fa fa-file"></i></span>
                <input type="number" name="newDocumentId" placeholder="Document ID" readonly
                  id="newDocumentId" class="form-control input-lg" required>
              </div>
            </div>
            <!-- form for customer email -->
            <div class="form-group">
              <div class="input-group">
                <!-- form and input groups are classes from bootstrap -->
                <span class="input-group-addon"><i class="fa fa-at"></i></span>
                <input type="email" name="newCustomerEmail" placeholder="E mail" required
                  class="form-control input-lg">
              </div>
            </div>
            <!-- form for customer phone -->
            <div class="form-group">
              <div class="input-group">
                <!-- form and input groups are classes from bootstrap -->
                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                <input type="text" name="newCustomerPhone" placeholder="nomor telepon" required
                  class="form-control input-lg" data-inputmask="'mask': ['+(62) 999-9999-9999']"
                  data-mask>
              </div>
            </div>
            <!-- form for add customer address-->
            <div class="form-group">
              <div class="input-group">
                <!-- form and input groups are classes from bootstrap -->
                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                <input type="text" name="newCustomerAddress" placeholder="Alamat" required
                  class="form-control input-lg">
              </div>
            </div>
            <!-- form for customer birth date -->
            <div class="form-group">
              <div class="input-group">
                <!-- form and input groups are classes from bootstrap -->
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <input type="text" name="newCustomerBirthDate" placeholder="tanggal lahir" required
                  class="form-control input-lg" data-inputmask="'alias': 'yyyy/mm/dd'"
                  data-mask>
              </div>
            </div>

          </div>
        </div>
        <!-- modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Save Customer</button>
        </div>
        <!-- /.end model-content; -->
        <?php
          $addCustomer = new ControllerCustomer();
          $addCustomer -> ctrAddCustomer();
        ?>
      </form>

    </div>

  </div>
</div>

<!-- Modal add product -->
<div id="modalAddProduct" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <!-- modal header -->
      <div class="modal-header" style="background:#3c8dbc; color:white">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Customer</h4>
      </div>
      <div class="box box-warning">
        <!-- this is the initial default box colored as green meaning success but when things went bad it will turns yellow as warning -->
        <div class="box-header with-border">
          <!-- just left it blank because just whitespace -->
        </div>
        <div class="box-body">
          <table class="table table-bordered table-striped dt-responsive tableProducts" id="modalTable">
            <thead>
              <tr>
                <th style="width:10px">#</th>
                <th>Picture</th>
                <th>Code</th>
                <th>Description</th>
                <th>Stock</th>
                <th>Action</th>
              </tr>
            </thead>

          </table>
        </div>
      </div>
      <!-- modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Done</button>
        <!-- <button type="submit" class="btn btn-primary">Save Customer</button> -->
      </div>
    </div>

  </div>
</div>
