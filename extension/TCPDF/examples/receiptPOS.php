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

  /* // IDEA: put all needed files to make the print module works!
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


  /* // IDEA: add functionalities to call the class when request with $_GET["idSales"]
  *
  * The main function of this part is to check if there is any request with idSales attribute.
  * If yes, then begin the process of printing the pdf for the receipt.
  *
  */
  if (isset($_GET["idSales"])) {
    // IDEA: fetch the sales data from the database based on the idSales;
    $idSales = $_GET["idSales"];
    $salesData = ControllerSales::ctrDataSales("id", $idSales);
    $productList = json_decode($salesData["product"],true);
    // NOTE: CAUTION the json_decode must use second parameter to be true to return Array and not Standard Object!!

    // var_dump($salesData);// DEBUG:
    // var_dump($productList);// DEBUG:

    /* // NOTE: decide the format of the print pdf result; try to make custom size to avoid page breaking!
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

    $pdf->setPrintFooter(false);
    $pdf->setPrintHeader(false);
    // $pdf->SetHeaderData('logoFinalBW3.jpg', 10, '', '');
    // $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

    // IDEA: set monospaced font style; by default courier
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    // IDEA: set margins (page);
    $pdf->SetMargins(5, 1, 5); // NOTE: I change this to test the margins in real life example; in mm

    /* NOTE: this is we trying to set non page break;
    *
    * this is the best solution for the moment since I cannot find anything to make infinite page length or the ability to make exact page length for certain receipt data;
    *
    * // WARNING: this might caused a bug when printing using thermal roll printer since the break will make some white spaces between page breaks and the unused page portion.
    *
    * // IDEA: make function to calculate the length of the paper needed then using the setPageFormat function $format that can be set to make custom page size;
    *
    */
    $pdf->setAutoPageBreak(true);

    // set default font subsetting mode
    $pdf->setFontSubsetting(true);

    // Set font
    // dejavusans is a UTF-8 Unicode font, if you only need to
    // print standard ASCII chars, you can use core fonts like
    // helvetica or times to reduce file size.
    $pdf->SetFont('dejavusans', '', 8);

    // Add a page
    // This method has several options, check the source code documentation for more information.
    $pdf->AddPage();

    $header = <<<EOD
    <img src="images/logoFinalBW4.jpg" style="width:70px;height:70px;margin:0px;padding:0;">
    <p style="margin:0px;padding:0;font-size:5px;">
      Jl. Kebon Agung Km.5<br>
      Tlogoadi, Cebongan, Mlati, Sleman
    </p>
    EOD;
    /* //  add data for customer data and user data;
    *
    * The customer data use the data from the customer database;
    * The data that will be used is customer name.
    * If the username is "pelanggan" then it should say Kepada: Yth Tn/Ny/Sdr Pelanggan?
    *
    * For the user data will be fetched the username;
    * Then username will be just placed in the Kasir: [username]
    *
    */

    // var_dump($salesData["id_seller"]); // DEBUG:
    $userName = (UserController::ctrDataUser("userid", $salesData["id_seller"]))["username"];
    // var_dump($userData); // DEBUG:
    $customerName = (ControllerCustomer::ctrDataCustomer("id", $salesData["id_customer"]))["name"];
    // var_dump($customerData); // DEBUG:

    $partyData = <<<EOD
    <p style="margin:0px;padding:0;text-align:left;font-size:8px;">
      Yth. Tn/Ny/Sdr. $customerName <br>
      Kasir: $userName
    </p>
    EOD;

    /* // IDEA: add iteration for i to the JSON data encoded into array
    *
    * The iteration has the header for Barang, QTY, dan subtotal
    * to use the most of the HTML table we need to use writeHTML not with cell!
    * I need to learn more on this thing!
    *
    */

    $table = <<<EOD
    <table width="100%">
      <tr>
        <th width="50%" align="left">BARANG</th>
        <th width="15%" align="right">QTY</th>
        <th width="35%" align="right">SUB TOTAL</th>
      </tr>
    EOD;

    for ($i=0; $i < count($productList); $i++) {
      $table .='
        <tr>
          <td align="left">'.$productList[$i]["description"].'</td>
          <td align="right">'.$productList[$i]["quantity"].'</td>
          <td align="right">'.number_format($productList[$i]["totalPrice"], 2, ",", ".").'</td>
        </tr>';
      // code...for ($i=0; $i < count($productList); $i++)
    }

    // IDEA: this is the bottom part of the table on the transaction please add <hr> to make line between important part of the transaction;

    $table .= '
    <hr>
    <tr>
      <td align="left">SubTotal</td>
      <td></td>
      <td align="right">'.number_format($salesData["net_price"], 2, ",", ".").'</td>
    </tr>
    <tr>
      <td align="left">Pajak</td>
      <td></td>
      <td align="right">'.number_format($salesData["tax"]/100 * $salesData["net_price"], 2, ",", ".").'</td>
    </tr>
    <hr>
    <tr>
      <td align="left">Total</td>
      <td></td>
      <td align="right">'.number_format($salesData["total"], 2, ",", ".").'</td>
    </tr>';

    /* // NOTE: set the payment method data and fix the cash payment data!
    *
    * // NOTE: To make this payment data inside the receipt POS I need to modify the sales payment in js file!
    * If the payment is in cash I need to add the full amount of the customer payment!
    * Then if the payment from the customer is higher than total price then I need to capture the change
    * Then the change need to be printed also in the receipt POS!
    *
    */

    $paymentData = (json_decode($salesData["method_json"],true))[0];
    // var_dump($paymentData); // TEMP:

    if ($paymentData["method"] == "cash") {
      /* IDEA: cash payment need to be defined the amount the customer paid and the change (if any) that the customer receive.
      *
      * The number must be formatted like the finance format with . as thousand separator and add 2 decimals
      *
      */

      $table .='
      <tr>
        <td align="left">Pembayaran: cash</td>
        <td></td>
        <td align="right">'.number_format($paymentData["amount"], 2, ",", ".").'</td>
      </tr>
      <tr>
        <td align="left">Kembali: </td>
        <td></td>
        <td align="right">'.number_format($paymentData["change"], 2, ",", ".").'</td>
      </tr>
      <table/>
      <hr>';

      // code...if ($paymentData["method"] == "cash")
    } else {
      /* NOTE: the payment need to be processed with the method, provider, reference;
      *
      * // IDEA: for now the method will only consist of code only. but in the future this can be modified to include the real name of the method!
      */

      $table .='
      <tr>
        <td align="left">Pembayaran: '.$paymentData["method"].'</td>
        <td></td>
        <td align="right"></td>
      </tr>
      <tr>
        <td align="left">Provider: '.$paymentData["provider"].'</td>
        <td></td>
        <td align="right"></td>
      </tr>
      <tr>
        <td align="left">Ref: '.number_format($paymentData["code"], 0, ",", "-").'</td>
        <td></td>
        <td align="right"></td>
      </tr>
      <table/>
      <hr>';

      // else of if ($paymentData["method"] == "cash")
    }

    // IDEA: bottom part of the receiptPOS;
    $footer = <<<EOD
    <p style="margin:0px;padding:0;font-size:8px;">
      Terima Kasih atas Kunjungan Anda
    </p>
    EOD;

    // IDEA: concatenante all contents;
    $html = $header.$partyData.$table.$footer;

    // Print text
    // $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, 'C', true);
    // output the HTML content
    $pdf->writeHTML($html, true, 0, true, 0, 'C');


    // Close and output PDF document
    // This method has several options, check the source code documentation for more information.
    $pdf->Output('POSreceipt.pdf', 'I');

    // code...if (isset($_GET["idSales"]))
  }
 ?>
