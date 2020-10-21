<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Supplier Management
      <small>Control Panel</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="index.php?route=ashboard"><i class="fa fa-dashboard"></i> Home</a></li>

      <li class="active">Supplier Management</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="box">
      <div class="box-header with-border">
        <button class="btn btn-primary"
         data-toggle="modal" data-target="#modalAddSupplier">Add Supplier</button>
         <!-- /.ini bootstrap modal untuk add user -->

      </div>
      <div class="box-body">
        <!-- here we will write the table of all users; -->
        <table class="table table-bordered table-striped dt-responsive tables">
          <!-- the table classes are from the plugin -->
          <thead>
            <tr>
              <th style="width:10px">#</th>
              <th>Full Name</th>
              <th>Actions</th>
              <th>Status</th>
              <th>Bank Acc</th>
              <th>Acc Num</th>
              <th>Last Inv</th>
            </tr>
          </thead>
          <tbody>
            <?php
              // fetch all suppliers data;
              $item = null;
              $value = null;
              $supplierData = ControllerSupplier::ctrDataSupplier($item,$value);

              // display each data as table row;
              foreach ($supplierData as $key => $data) {
                echo '<tr>
                  <td>'.$data["id"].'</td>
                  <td>'.$data["supname"].'</td>
                  <td>
                    <div class="btn-group">
                      <button class="btn btn-warning btnEditSupplier" idSupplier="'.$data["id"].'"
                      data-toggle="modal" data-target="#modalEditSupplier"><i class="fa fa-pencil"></i></button>
                      <button class="btn btn-danger btnDeleteSupplier" idSupplier="'.$data["id"].'"
                      nameSupplier="'.$data["supname"].'"><i class="fa fa-times"></i></button>
                    </div>
                  </td>
                  <td>'.$data["status"].'</td>
                  <td>'.$data["bankacc"].'</td>
                  <td>'.$data["accnum"].'</td>
                  <td>'.$data["lastinv"].'</td>
                </tr>';
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
<!-- Modal Add Supplier-->
<div id="modalAddSupplier" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <form role="form" class="" action="" method="post">
        <!-- modal header -->
        <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Supplier</h4>
        </div>
        <!-- modal body -->
        <div class="modal-body">
          <div class="box-body">

            <!-- form for add supplier name-->
            <div class="form-group">
              <div class="input-group">
                <!-- form and input groups are classes from bootstrap -->
                <span class="input-group-addon"><i class="fa fa-th"></i></span>
                <input type="text" name="newSupplier" id="newSupplier" placeholder="insert name" required
                  class="form-control input-lg">
              </div>
            </div>
            <!-- input to select the supplier type; -->
            <div class="form-group">
              <div class="input-group">
                <!-- form and input groups are classes from bootstrap -->
                <span class="input-group-addon"><i class="fa fa-users"></i></span>
                <select class="form-control input-lg" name="newStatus">
                  <option value="">Pilih Tipe Supplier</option>
                  <option value="inhouse">Sendiri</option>
                  <option value="consignment">Konsinyasi</option>
                  <option value="rent">Sewa</option>
                </select>
              </div>
            </div>
            <!-- form for bank account -->
            <div class="form-group">
              <div class="input-group">
                <!-- form and input groups are classes from bootstrap -->
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                <input type="text" name="newBankAcc" placeholder="masukkan bank acc" required
                  class="form-control input-lg">
              </div>
            </div>
            <!-- form for account number -->
            <div class="form-group">
              <div class="input-group">
                <!-- form and input groups are classes from bootstrap -->
                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                <input type="text" name="newAccNum" placeholder="masukkan nomor acc" required
                  class="form-control input-lg">
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
          $createSupplier = new ControllerSupplier();
          $createSupplier -> ctrCreateSupplier();
        ?>
      </form>

    </div>

  </div>
</div>

<!-- modal edit supplier -->
<div id="modalEditSupplier" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <form role="form" class="" action="" method="post">
        <!-- modal header -->
        <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Supplier</h4>
        </div>
        <!-- modal body -->
        <div class="modal-body">
          <div class="box-body">

            <!-- form for add supplier name-->
            <div class="form-group">
              <div class="input-group">
                <!-- form and input groups are classes from bootstrap -->
                <span class="input-group-addon"><i class="fa fa-th"></i></span>
                <input type="text" name="editSupplier" id="editSupplier" value="" readonly
                  class="form-control input-lg">
              </div>
            </div>
            <!-- input to select the supplier type; -->
            <div class="form-group">
              <div class="input-group">
                <!-- form and input groups are classes from bootstrap -->
                <span class="input-group-addon"><i class="fa fa-users"></i></span>
                <select class="form-control input-lg" name="editStatus">
                  <option value="" id="editStatus">Pilih Tipe Supplier</option>
                  <option value="inhouse">Sendiri</option>
                  <option value="consignment">Konsinyasi</option>
                  <option value="rent">Sewa</option>
                </select>
              </div>
            </div>
            <!-- form for bank account -->
            <div class="form-group">
              <div class="input-group">
                <!-- form and input groups are classes from bootstrap -->
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                <input type="text" name="editBankAcc" id="editBankAcc" value=""
                  class="form-control input-lg">
              </div>
            </div>
            <!-- form for account number -->
            <div class="form-group">
              <div class="input-group">
                <!-- form and input groups are classes from bootstrap -->
                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                <input type="text" name="editAccNum" id="editAccNum" value=""
                  class="form-control input-lg">
              </div>
            </div>


          </div>
        </div>
        <!-- modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Update Supplier</button>
        </div>
        <!-- /.end model-content; -->
        <?php
          $editSupplier = new ControllerSupplier();
          $editSupplier -> ctrEditSupplier();
        ?>
      </form>

    </div>

  </div>
</div>
<!-- END OF MODAL EDIT SUPPLIER -->
<?php
  // DELETE USER PROCESSOR (capture the command of GET and process it in contorller);
  $deleteSupplier = new ControllerSupplier();
  $deleteSupplier -> ctrDeleteSupplier();
?>
