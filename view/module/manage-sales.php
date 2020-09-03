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
            <?php
              // IDEA: call the sales data and presented here;
              $allSalesData = ControllerSales::ctrDataSales(null,null);
              foreach ($allSalesData as $key => $value) {
                echo '
                <tr>
                  <td>'.$value["id"].'</td>
                  <td>'.$value["code"].'</td>
                  <td>'.$value["id_customer"].'</td>
                  <td>'.$value["id_seller"].'</td>
                  <td>'.$value["method"].'</td>
                  <td>'.$value["net_price"].'</td>
                  <td>'.$value["total"].'</td>
                  <td>'.$value["date"].'</td>
                  <td>
                    <div class="btn-group">
                      <button class="btn btn-warning"><i class="fa fa-print"></i></button>
                      <button class="btn btn-danger"><i class="fa fa-times"></i></button>
                    </div>
                  </td>
                </tr>
                ';
                // code...foreach ($allSalesData as $key => $value)
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
