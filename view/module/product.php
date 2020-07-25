<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Product Management
      <small>Control Panel</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="dashboard"><i class="fa fa-dashboard"></i> Home</a></li>

      <li class="active">Product Management</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="box">
      <div class="box-header with-border">
        <button class="btn btn-primary"
         data-toggle="modal" data-target="#modalAddProduct">Add Product</button>
         <!-- /.ini bootstrap modal untuk add user -->

      </div>
      <div class="box-body">
        <!-- here we will write the table of all users; -->
        <table class="table table-bordered table-striped dt-responsive" id="productTable">
          <!-- the table classes are from the plugin -->
          <thead>
            <tr>
              <th style="width:10px">#</th>
              <th>Gambar</th>
              <th>Code</th>
              <th>Keterangan</th>
              <th>Supplier</th>
              <th>Stock</th>
              <th>HPP</th>
              <th>Harga Jual</th>
              <th>Tanggal Entry</th>
              <th>Action</th>
            </tr>
          </thead>

        </table>
      </div>
      <!-- /.box-body -->
      <!-- <div class="box-footer">
        Footer
      </div> -->
      <!-- /.box-footer-->
    </div>
    <!-- /.box -->

  </section>
  <!-- /.content -->
</div>
<!-- this is the modal pop ups; -->
<!-- Modal Add Product-->
<div id="modalAddProduct" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <form role="form" class="" action="" method="post" enctype="multipart/form-data">
        <!-- modal header -->
        <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Product</h4>
        </div>
        <!-- modal body -->
        <div class="modal-body">
          <div class="box-body">

            <!-- input to select the Supplier; -->
            <div class="form-group">
              <div class="input-group">
                <!-- form and input groups are classes from bootstrap -->
                <span class="input-group-addon"><i class="fa fa-users"></i></span>
                <select class="form-control input-lg" name="newSupplier" id="newSupplier" required>
                  <option value="">Pilih Supplier</option>
                  <?php
                    // we will show all the supplier in the list;
                    $supplierData = ControllerSupplier::ctrDataSupplier(null,null);

                    foreach ($supplierData as $key => $value) {
                      echo '
                      <option value="'.$value["id"].'">'.$value["supname"].'</option>
                      ';

                      // -- foreach ($supplierData as $key => $value)
                    }
                  ?>

                </select>
              </div>
            </div>
            <!-- form for add code-->
            <div class="form-group">
              <div class="input-group">
                <!-- form and input groups are classes from bootstrap -->
                <span class="input-group-addon"><i class="fa fa-product-hunt"></i></span>
                <input type="text" name="newCode" id="newCode" placeholder="add product code" readonly
                  class="form-control input-lg">
              </div>
            </div>
            <!-- form for add description-->
            <div class="form-group">
              <div class="input-group">
                <!-- form and input groups are classes from bootstrap -->
                <span class="input-group-addon"><i class="fa fa-product-hunt"></i></span>
                <input type="text" name="newDescription" placeholder="add description" required
                  class="form-control input-lg">
              </div>
            </div>

            <!-- form for add stock-->
            <div class="form-group">
              <div class="input-group">
                <!-- form and input groups are classes from bootstrap -->
                <span class="input-group-addon"><i class="fa fa-check"></i></span>
                <input type="number" name="newStock" min="0" placeholder="add stock" required
                  class="form-control input-lg">
              </div>
            </div>
            <!-- form for add buy price-->
            <div class="form-group row">
              <div class="col-xs-6">
                <div class="input-group">
                  <!-- form and input groups are classes from bootstrap -->
                  <span class="input-group-addon"><i class="fa fa-arrow-up"></i></span>
                  <input type="number" name="newBuyingPrice" min="0" placeholder="add Buying Price" required
                    class="form-control input-lg">
                </div>
              </div>

            <!-- form for add selling price-->
              <div class="col-xs-6">
                <div class="input-group">
                  <!-- form and input groups are classes from bootstrap -->
                  <span class="input-group-addon"><i class="fa fa-arrow-down"></i></span>
                  <input type="number" name="newSellingPrice" min="0" placeholder="add Selling Price" required
                    class="form-control input-lg">
                </div> <br>
                <!-- CHECKBOX FOR PERCENTAGE -->
                <div class="col-xs-6">
                  <div class="form-group">
                    <label>
                      <input type="checkbox" class="minimal percentage" checked>
                      Use Percentage
                    </label>
                  </div>
                </div>
                <!-- INPUT FOR THE PERCENTAGE -->
                <div class="col-xs-6" style="padding:0">
                  <div class="input-group">
                    <input type="number" class="form-control input-lg newPercentage" min="0" value="40" required>
                    <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                  </div>
                </div>
              </div>


            </div>
            <!-- input file for the picture -->
            <div class="form-group">
              <div class="panel">
                Upload Photo
                <input type="file" id="newPictProduct" name="newPictProduct">
                <p class="help-block">Max 2MB</p>
                <img src="view/img/product/default/anonymousbox.png"
                      class="img-thumbnail" width="40px">
              </div>

            </div>

          </div>
        </div>
        <!-- modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Save Product</button>
        </div>
        <!-- /.end model-content; -->
      </form>

    </div>

  </div>
</div>
