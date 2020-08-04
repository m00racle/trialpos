<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Sales Management
      <small>Control Panel</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="dashboard"><i class="fa fa-dashboard"></i> Home</a></li>

      <li class="active">Sales Management</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="box">
      <div class="box-header with-border">
        <a href="create-sales">
        <button class="btn btn-primary">Kasir</button>
         </a>
         <!-- /.ini bootstrap modal untuk add user -->

      </div>
      <div class="box-body">
        <!-- here we will write the table of all users; -->
        <table class="table table-bordered table-striped dt-responsive tables">
          <!-- the table classes are from the plugin -->
          <thead>
            <tr>
              <th style="width:10px">#</th>
              <th>Billing Code</th>
              <th>Customer</th>
              <th>Seller</th>
              <th>Payment Method</th>
              <th>Net Price</th>
              <th>Total</th>
              <th>Transaction Date</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>1</td>
              <td>12345</td>
              <td>Customer</td>
              <td>Warji</td>
              <td>BCA:Debit</td>
              <td>75000</td>
              <td>82500</td>
              <td>2020-07-11 23:05:22</td>
              <td>
                <div class="btn-group">
                  <button class="btn btn-warning"><i class="fa fa-pencil"></i></button>
                  <button class="btn btn-danger"><i class="fa fa-times"></i></button>
                </div>
              </td>

            </tr>
            <tr>
              <td>1</td>
              <td>12345</td>
              <td>Customer</td>
              <td>Warji</td>
              <td>Cash</td>
              <td>75000</td>
              <td>82500</td>
              <td>2020-07-11 23:05:22</td>
              <td>
                <div class="btn-group">
                  <button class="btn btn-warning"><i class="fa fa-pencil"></i></button>
                  <button class="btn btn-danger"><i class="fa fa-times"></i></button>
                </div>
              </td>

            </tr>
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

            <!-- form for add user name-->
            <div class="form-group">
              <div class="input-group">
                <!-- form and input groups are classes from bootstrap -->
                <span class="input-group-addon"><i class="fa fa-th"></i></span>
                <input type="text" name="newSupplier" placeholder="insert name" required class="form-control input-lg">
              </div>
            </div>
            <!-- input to select the role; -->
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
            <!-- form for username -->
            <div class="form-group">
              <div class="input-group">
                <!-- form and input groups are classes from bootstrap -->
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                <input type="text" name="newBankAcc" placeholder="masukkan bank acc" required class="form-control input-lg">
              </div>
            </div>
            <!-- form for password -->
            <div class="form-group">
              <div class="input-group">
                <!-- form and input groups are classes from bootstrap -->
                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                <input type="text" name="newAccNum" placeholder="masukkan nomor acc" required class="form-control input-lg">
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
      </form>

    </div>

  </div>
</div>
