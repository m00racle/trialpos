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
  require_once '../../../controller/controlsales.php';
  require_once '../../../controller/controlcustomer.php';
  require_once '../../../controller/controluser.php';
  require_once '../../../model/salesmodel.php';
  require_once '../../../model/customermodel.php';
  require_once '../../../model/usermodel.php';

  /* // TODO: add class that handle all data request and then print it out;
  *
  * the class will be called when the GET request is called then here is how it must handle data request:
  * 1. user name;
  * 2. custmomer name;
  * 3. sales code
  * 4. sales data in JSON data
  * then based to those JSON data fill the receipt POS for the transaction..
  */


  /* // TODO: add functionalities to call the class when request with $_GET["idSales"]
  *
  * The functionalities will make a new instantiation object based on the class print handler and then call the staztic function for print and pass the idSales from the $_GET["idSales"]
  * Remember the function in the class is static thus we need to add the idSales directly as parameter to the function;
  * I still undecided if the print module should be positioned below here or inside the class.
  * If the print module is located inside the class then the class will be called PrintModule class;
  * else then the class wil be just named as data fetcher.
  */
  if (isset($_GET["idSales"])) {
    // IDEA: fetch the sales data from the database based on the idSales;
    $idSales = $_GET["idSales"];
    $salesData = ControllerSales::ctrDataSales("id", $idSales);
    $productList = json_decode($salesData["product"]);
    // var_dump($salesData);// DEBUG:
    // var_dump($productList);// DEBUG:

    /* // TODO: decide the format of the print pdf result;
    *
    * page size : A7 (the closest to the 80 mm rolls)
    * margins : 5 mm (left, top, right)
    * logo on header : under consideration; learn more on locating the header logo from the example_001.php;
    * header margin: if considered will be 5 mm
    *
    */

    // IDEA: instantiate new TCPDF object;
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A7', true, 'UTF-8', false);

    // IDEA: set document info;
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetTitle('POS receipt');
    $pdf->SetSubject('POS Receipt');

    // IDEA: set header and footer (no footer for this time)
    // BUG: this header just does not work!! maybe this is because the size is too big. Consider to use inline image to the body of the text and use no header altogether.
    // $pdf->setPrintFooter(false);
    // $pdf->SetHeaderData('logoFinalBW3.jpg', 10, '', '');
    // $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

    // IDEA: set monospaced font style; by default courier
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    // IDEA: set margins (header and page);
    $pdf->SetMargins(5, 5, 5); // NOTE: I change this to test the margins in real life example; in mm
    // $pdf->SetHeaderMargin(PDF_MARGIN_HEADER); // NOTE: margin header is already set 5 mm by default;

    // set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    // set default font subsetting mode
    $pdf->setFontSubsetting(true);

    // Set font
    // dejavusans is a UTF-8 Unicode font, if you only need to
    // print standard ASCII chars, you can use core fonts like
    // helvetica or times to reduce file size.
    $pdf->SetFont('dejavusans', '', 10, '', true);

    // Add a page
    // This method has several options, check the source code documentation for more information.
    $pdf->AddPage();

    $html = <<<EOD
    <h1>Welcome to ID SALES= $idSales</h1>
    <i>This is the first example of TCPDF library with idSales Code = $idSales.</i>
    EOD;

    // Print text using writeHTMLCell()
    $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

    // Close and output PDF document
    // This method has several options, check the source code documentation for more information.
    $pdf->Output('POSreceipt.pdf', 'I');

    // code...if (isset($_GET["idSales"]))
  }
 ?>
