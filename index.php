<?php
require_once "controller/controltemp.php";
require_once "controller/controluser.php";
require_once "controller/controlsupplier.php";
require_once "controller/controlproduct.php";
require_once "controller/controlcustomer.php";
require_once "controller/controlsales.php";

require_once "model/usermodel.php";
require_once "model/suppliermodel.php";
require_once "model/productmodel.php";
require_once "model/customermodel.php";
require_once "model/salesmodel.php";
//instatiate a template object type templatecontroller;
$temmplate = new TempController();
//access the method to control the template
$temmplate -> ctrTemplate();
?>
