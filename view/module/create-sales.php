<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Create Sales
      <small>Control Panel</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>

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
            <form class="" action="" method="post" role="form">
              <div class="box-body">
                <!-- SELLER INPUT -->
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    <input type="text" class="form-control" id="newSeller" name="newSeller" value="User Admin" readonly>
                  </div>
                </div>
                <!-- BILLING CODE -->
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-key"></i></span>
                    <input type="text" class="form-control" id="newSale" name="newSale" value="100002343" readonly>
                  </div>
                </div>
                <!-- CUSTOMER INPUT -->
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>

                    <select class="form-control" id="selectCustomer" name="selectCustomer" required>
                      <option value="">Select Customer</option>
                    </select>
                    <!-- add button for new customer -->
                    <span class="input-group-addon"><button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#modalAddCustomer" data-dismiss="modal">Add Customer</button></span>
                  </div>
                </div>
                <!-- ENTRY FOR NEW PRODUCT -->
                <div class="form-group row newProduct">
                  <!-- description of the product -->
                  <div class="col-xs-6" style="padding-right:0px">
                    <div class="input-group">
                      <span class="input-group-addon"><button class="btn btn-danger"><i class="fa fa-times"></i></button></span>
                    <input type="text" class="form-control" id="addProduct" name="addProduct" placeholder="Product Description" required>
                    </div>
                  </div>
                  <div class="col-xs-3">
                    <!-- product quantity -->
                    <input type="number" class="form-control" id="newProductQuantity" name="newProductQuantity" min="1" placeholder="0" required>
                  </div>
                  <div class="col-xs-3" style="padding-left:0px">
                    <!-- product price -->
                    <div class="input-group">
                      <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                      <input type="number" class="form-control" id="newProductPrice" name="newProductPrice" min="1" placeholder="00000" required readonly>
                    </div>
                  </div>
                </div>
                <!-- the button to add products; this is for the mobile device only since in the desktop user can pick the product from the list in the right side of the form-->
                <button type="button" class="btn btn-default hidden-lg">Add Product</button><hr>
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
                          <td style="width:50%">
                            <div class="input-group">
                              <input type="number" class="form-control" min="0" id="newSalesTax" name="newSalesTax" placeholder="0" required>
                              <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                            </div>
                          </td>
                          <td style="width:50%">
                            <div class="input-group">
                              <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                              <input type="number" class="form-control" id="newTotalSales" name="newTotalSales"  placeholder="00000" required readonly>
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
                        <option value="">Select Payment Method</option>
                        <option value="cash">Cash</option>
                        <option value="creditCard">Credit Card</option>
                        <option value="debitCard">Debit Card</option>
                      </select>
                    </div>
                  </div>
                  <!-- enter transaction code from card transaction -->
                  <div class="col-xs-6" style="padding-left:0px">
                    <div class="input-group">
                      <input type="text" class="form-control" id="newTransactionCode" name="newTransactionCode" placeholder="Transaction Code" required>
                      <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                    </div>
                  </div>
                </div>
              </div><hr>
              <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right">Save Sales</button>
              </div>
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
            <table class="table table-bordered table-striped dt-responsive tables">
              <thead>
                <tr>
                  <th style="width:10px">#</th>
                  <th>Picture</th>
                  <th>Code</th>
                  <th>Description</th>
                  <th>Supplier</th>
                  <th>Stock</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1</td>
                  <td><img src="view\img\product\default\anonymousbox.png" class="img-thumbnail" width="40px"></td>
                  <td>1002</td>
                  <td>Lorem ipsum dolor</td>
                  <td>Sularno</td>
                  <td>20</td>
                  <td>
                    <div class="btn-group">
                      <button type="button" class="btn btn-primary">Add</button>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

    </div>


  </section>
  <!-- /.content -->
</div>

<!-- Modal -->
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
