<?php
  session_start();
 ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Omah|POS</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <link rel="icon" href="view/img/template/logomini.png">
  <!-- CSS PLUGINS -->
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="view/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="view/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="view/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="view/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="view/dist/css/skins/_all-skins.min.css">

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

  <!-- THIS IS THE JAVASCRIPT SECTION!! -->
  <!-- jQuery 3 -->
  <script src="view/bower_components/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap 3.3.7 -->
  <script src="view/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <!-- SlimScroll -->
  <script src="view/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
  <!-- FastClick -->
  <script src="view/bower_components/fastclick/lib/fastclick.js"></script>
  <!-- AdminLTE App -->
  <script src="view/dist/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <!-- <script src="view/dist/js/demo.js"></script>
    This demo.js is where the templates resides thus I will only take themm when
    needed-->
  <!-- <script>
    $(document).ready(function () {
      NOT NEEDED ALREADY BEING MOVED TO js/template.js
    })
  </script> -->

</head>
<!-- DOCUMENT BODY -->
<body class="hold-transition skin-blue sidebar-collapse sidebar-mini login-page">

  <!-- header will be presented as modules -->
  <!-- Left side column. contains the sidebar -->
  <!-- aside left also in the modules -->

  <!-- Content Wrapper. Contains page content in modules-->
<?php
  if (isset($_SESSION['login']) && $_SESSION['login']=='ok') {
    // code...then the user is logged in;
    echo "<div class='wrapper'>";
    // HEADER MENU:
    include 'view/module/header.php';
    // SIDEBAR MENU:
    include 'view/module/menu.php';
    // DASHBOARD;
    if (isset($_GET["route"])) {
      // code...the reoute exist then confirm that it is goes to dashboard;
      if ($_GET["route"]=="dashboard" ||
          $_GET["route"]=="user" ||
          $_GET["route"]=="category" ||
          $_GET["route"]=="product" ||
          $_GET["route"]=="supplier" ||
          $_GET["route"]=="customer" ||
          $_GET["route"]=="manage-sales" ||
          $_GET["route"]=="create-sales" ||
          $_GET["route"]=="logout" ||
          $_GET["route"]=="sales-report") {
        // code...includes all things related to dashboard
          include 'view/module/'.$_GET["route"].'.php';
      } else {
        // code...if the url designated not in the list open the 404.php;
        include 'view/module/404.php';
      }
    } else {
      // code...if not using the rule just go to index.php;
      include 'view/module/dashboard.php';
    }

    // FOOTER:
    include 'view/module/footer.php';
    echo "</div>";
  } else {
    // code...the user is not yet logged in;
    include 'view/module/login.php';
  }

 ?>


<!-- </div> -->
<!-- ./wrapper -->
<script src="view/js/template.js"></script>

</body>
</html>
