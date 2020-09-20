<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Sales Management
      <small>Control Panel</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="index.php?route=dashboard"><i class="fa fa-dashboard"></i> Home</a></li>

      <li class="active">Sales Management</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="box">
      <div class="box-header with-border">
        <a href="index.php?route=create-sales">
        <button class="btn btn-primary">Kasir</button>
         </a>
         <!-- /.ini bootstrap modal untuk add user -->

      </div>
      <div class="box-body">
        <!-- here we will write the table of all users; -->
        <table class="table table-bordered table-striped dt-responsive" id="manageSalesData">
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
