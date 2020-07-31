<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Customer Management
      <small>Control Panel</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="dashboard"><i class="fa fa-dashboard"></i> Home</a></li>

      <li class="active">Customer Management</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="box">
      <div class="box-header with-border">
        <button class="btn btn-primary"
         data-toggle="modal" data-target="#modalAddCustomer">Add Customer</button>
         <!-- /.ini bootstrap modal untuk add user -->

      </div>
      <div class="box-body">
        <!-- here we will write the table of all users; -->
        <table class="table table-bordered table-striped dt-responsive tables">
          <!-- the table classes are from the plugin -->
          <thead>
            <tr>
              <th style="width:10px">#</th>
              <th>Name</th>
              <th>Document ID</th>
              <th>Email</th>
              <th>Phone</th>
              <th>Alamat</th>
              <th>Birthdate</th>
              <th>Total Purchase</th>
              <th>Last Purchase</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
              // fetch all customer data to be presented
              $dataCustomer = ControllerCustomer::ctrDataCustomer(null, null);
              // echo "<script>console.log('dataCustomer,".json_encode($dataCustomer)."')</script>";// DEBUG:
              foreach ($dataCustomer as $key => $value) {
                echo '
                <tr>
                  <td>'.$value["id"].'</td>
                  <td>'.$value["name"].'</td>
                  <td>'.$value["doc_id"].'</td>
                  <td>'.$value["email"].'</td>
                  <td>'.$value["phone"].'</td>
                  <td>'.$value["address"].'</td>
                  <td>'.$value["birthdate"].'</td>
                  <td>'.$value["total_purchase"].'</td>
                  <td>'.$value["last_purchase"].'</td>
                  <td>
                    <div class="btn-group">
                      <button class="btn btn-warning btnEditCustomer" idCustomer="'.$value["id"].'"
                      data-toggle="modal" data-target="#modalEditCustomer"><i class="fa fa-pencil"></i></button>
                      <button class="btn btn-danger btnDeleteCustomer" delCustomer="'.$value["id"].'">
                      <i class="fa fa-times"></i></button>
                    </div>
                  </td>';
                // code...foreach ($dataCustomer as $key => $value)
              }
            ?>

          </tbody>
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
          <button type="submit" class="btn btn-primary">Save Supplier</button>
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
