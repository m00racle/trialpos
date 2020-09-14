<?php
  /*
  * This is the file to produce receipt for POS transaction;
  * The file name of the pdf receipt will be produced is transaction code + receiptPOS.pdf;
  *
  * The printer used is common POS Printer with 80 mm roll!
  *
  */

  // Include the main TCPDF library (search for installation path).
  require_once('tcpdf_include.php');

  /* // TODO: put all needed files to make the print module works!
  *
  * Since we also need to add sales, customer, and user data we need to required once:
  * 1. controlsales.php
  * 2. controlcustomer.php
  * 3. controluser.php
  * 4. salesmodel.php
  * 5. customermodel.php
  * 6. usermodel.php
  * this will need to be added to the this php file!
  */


  /* // TODO: add class that handle all data request and then print it out;
  *
  * the class will be called when the GET request is called then here is how it must handle data request:
  * 1. user name;
  * 2. custmomer name;
  * 3. sales code
  * 4. sales data in JSON data
  * then based to those JSON data fill the receipt POS for the transaction..
  */

  /* // TODO: decide the format of the print pdf result;
  *
  * page size : A7 (the closest to the 80 mm rolls)
  * margins : 5 mm (left, top, right)
  * logo on header : under consideration; learn more on locating the header logo from the example_001.php;
  * header margin: if considered will be 5 mm
  * 
  *
  */

  /* // TODO: add functionalities to call the class when request with $_GET["idSales"]
  *
  * The functionalities will make a new instantiation object based on the class print handler and then call the staztic function for print and pass the idSales from the $_GET["idSales"]
  * Remember the function in the class is static thus we need to add the idSales directly as parameter to the function;
  * I still undecided if the print module should be positioned below here or inside the class.
  * If the print module is located inside the class then the class will be called PrintModule class;
  * else then the class wil be just named as data fetcher.
  */
 ?>
