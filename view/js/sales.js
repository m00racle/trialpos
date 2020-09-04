// LOAD THE DYNAMIC DATA TABLE;
// $.ajax({
//   url: "ajax/managesalesajax.php",
//   success:function(response){
//     console.log("response",response); // NOTE: debug initial syntax test!
//
//     // --success:function(response)
//   }
//
//   // --$.ajax
// })

// IDEA: when refreshing the page all must be cleared and all add button must be back to active again. Thus all data in the local storage must be cleared to prevent bugs in the add button on both main and modal data tables.
var idUpdateProduct = [];
localStorage.setItem("updateProduct", JSON.stringify(idUpdateProduct));

$("#manageSalesData").DataTable( {
        "ajax": "ajax/managesalesajax.php",
        "deferRender": true,
        "retrieve": true,
        "processing": true,
        "order": [[ 0, "desc" ]]
    } );
// NOTE: in the #manageSalesData table remove the .tables from its class attribute since it creates confusion bug!; also note that we use "order": to set the order of the data list descending according to the 0th column!

$(".tableProducts").DataTable( {
        "ajax": "ajax/datatablesalesajax.php",
        "deferRender": true,
        "retrieve": true,
        "processing": true
    } );

// ADD THE PRODUCT FROM THE PRODUCT TABLE FOR SALE WHEN THE ADD BUTTON IS CLICKED;
$(".tableProducts tbody").on("click", "button.addProduct", function(){
  // IDEA: prepare the localStorage connection;
  if (localStorage.getItem("updateProduct") == null) {
    var idUpdateProduct = [];
    // NOTE: this is to prevent error if the local storage has never been initiated usually when the web app is first accessed.
  } else {
      var idUpdateProduct = JSON.parse(localStorage.getItem("updateProduct"));
  }
  // first we capture the product id;
  var idProduct = $(this).attr("idProduct");
  var tableId = $(this).parent().parent().parent().parent().parent().attr("id");
  if (tableId == "mainTable") {
    var otherTable = "#modalTable ";
    var targetButton = otherTable + "tbody tr td button[idProduct='"+idProduct+"']";
  } else {
    var otherTable = "#mainTable ";
    var targetButton = otherTable + "tbody tr td button[idProduct='"+idProduct+"']";
  }

  // console.log("idProduct ", idProduct);// DEBUG:
  // console.log("table id", tableId);// DEBUG:
  // console.log("other table", $(targetButton).length);// DEBUG:

  // deactivate the button on the product list when already added;
  $(this).removeClass("btn-primary addProduct");
  $(this).addClass("btn-default");

  if ($(targetButton).length) {
    // console.log("target button true");// DEBUG:
    $(targetButton).removeClass("btn-primary addProduct");
    $(targetButton).addClass("btn-default");
  }else {
    // IDEA: put the changes into the localStorage;
    idUpdateProduct.push({"tableId":otherTable,"update":"add","idProduct":idProduct});
    localStorage.setItem("updateProduct", JSON.stringify(idUpdateProduct));
  }


  var datos = new FormData();
  datos.append("idProduct", idProduct);
  // console.log("idProductData", datos.get("idProduct"));// DEBUG:

  // use the product ajax to send the idProduct and get the response in JSON on the specific product;
  $.ajax({
    url: "ajax/productajax.php",
    method: "POST",
    data: datos,
    cache:false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(response){
      // console.log("response", response); // DEBUG:
      var description = response["description"];
      var stock = response["stock"];
      var price = response["sell_price"];

      // NOTE: check if the stock of the product is zero then cancel the product addition to the sell list;
      if (stock == 0) {
        // IDEA: put sweetalert2 then the response is none but in the end of the test just put return to escape the success function;
        Swal.fire({
          icon: 'error',
          title: 'Stock ' +description+ ' Habis!',
          text: 'sementara produk tidak tersedia!',
          confirmButtonText: 'OK!'
        });
        // IDEA: change the button to be deactivated to prevent future addition before restocking!
        $("button.recoverButton[idProduct='"+idProduct+"']").addClass("btn-primary addProduct");
        if (!$(targetButton).length) {
          // console.log("reverse target button");// DEBUG:
          // IDEA: put the changes into the localStorage;
          idUpdateProduct.push({"tableId":otherTable,"update":"remove","idProduct":idProduct});
          localStorage.setItem("updateProduct", JSON.stringify(idUpdateProduct));
        }

        return;
      }

      // put the response to the appropriate html structure;
      $(".newProduct").append(
        '<div class="row" style="padding:5px 5px">' +
          '<div class="col-xs-6" style="padding-right:0px">' +
            '<div class="input-group">'+
              '<span class="input-group-addon"><button class="btn btn-danger removeProduct" idProduct="'+idProduct+'"><i class="fa fa-times" style="font-size:15px"></i></button></span>' +
            '<input type="text" class="form-control addProduct newProductDescription" name="addProduct" idProduct="'+idProduct+'" value="'+description+'" required readonly>' +
            '</div>' +
          '</div>' +
          '<!-- product quantity -->' +
          '<div class="col-xs-2 productQuantity">' +
            '<input type="number" class="form-control newProductQuantity" name="newProductQuantity" min="1" value="1" stock="'+stock+'" required>' +
          '</div>' +
          '<!-- product price -->' +
          '<div class="col-xs-4 productPrice" style="padding-left:0px">' +
            '<div class="input-group">' +
              '<span class="input-group-addon"></span>' +
              '<input type="text" class="form-control newProductPrice" name="newProductPrice"  value="'+price+'" unitPrice="'+price+'" required readonly>' +
            '</div>' +
          '</div>' +
        '</div>'
      );
      // IDEA: format the number of each price according to JQuery custom format;
      $("input.newProductPrice").number(true, 2, ',', '.');
      // IDEA: call the totalPrice function to sum all prices and put it into total price input form;
      totalPrice();

      // IDEA: make JSON data array with data on the transaction real time;
      jsonTransaction();

      // IDEA: if the payment is cash auto calculate the chages;
      if ($("input#newCashPayment").length) {
        cashChanges();
      }
    }
  })
  // --$(".tableProducts tbody").on("click", "button.addProduct", function()
})


// CANCEL OR DELETE SALES AND GIVE THE ADD BUTTON BACK;
$(".salesForm").on("click", "button.removeProduct", function(){
  // NOTE: here we must delete all 4 level pf parents that surrounded the button delete;
  $(this).parent().parent().parent().parent().remove();

  var idProduct = $(this).attr("idProduct");
  // NOTE: using the idProduct we will search the add button that has the attribute idProduct attribute with the value of the idProduct variable;
  if (localStorage.getItem("updateProduct") == null) {
    var idUpdateProduct = [];
    // NOTE: this is to prevent error if the local storage has never been initiated usually when the web app is first accessed.
  } else {
      var idUpdateProduct = JSON.parse(localStorage.getItem("updateProduct"));
  }


  // IDEA: if the product is already viewed just change the add button back to active but don't update the local storage;
  if ($("#mainTable tbody tr td button[idProduct='"+idProduct+"']").length) {
    $("#mainTable tbody tr td button[idProduct='"+idProduct+"']").removeClass("btn-default");
    $("#mainTable tbody tr td button[idProduct='"+idProduct+"']").addClass("btn-primary addProduct");
  } else {
    // IDEA: if the product canceled is not inview yet just add it into the localStorage to be updated later when viewd;
    idUpdateProduct.push({"tableId":"#mainTable ","update":"remove","idProduct":idProduct});
    localStorage.setItem("updateProduct", JSON.stringify(idUpdateProduct));
  }

  if ($("#modalTable tbody tr td button[idProduct='"+idProduct+"']").length) {
    $("#modalTable tbody tr td button[idProduct='"+idProduct+"']").removeClass("btn-default");
    $("#modalTable tbody tr td button[idProduct='"+idProduct+"']").addClass("btn-primary addProduct");
  } else {
    // IDEA: if the product canceled is not inview yet just add it into the localStorage to be updated later when viewd;
    idUpdateProduct.push({"tableId":"#modalTable ","update":"remove","idProduct":idProduct});
    localStorage.setItem("updateProduct", JSON.stringify(idUpdateProduct));
  }

  // IDEA: if the remove button only one then we just reverse the totalPrice back to zero;
  if ($("div.newProduct").children().length == 0) {
    $("input#newTotalSales").val(0);
    $("input#plainTotalSales").val(0);
  } else {
    // IDEA: call the totalPrice function to sum all prices and put it into total price input form;
    totalPrice();
  }

  // IDEA: make JSON data array with data on the transaction real time;
  jsonTransaction();

  // IDEA: if the payment is cash auto calculate the chages;
  if ($("input#newCashPayment").length) {
    cashChanges();
  }

  // $(".salesForm").on("click", "button.removeProduct", function()
})

// NOTE: THIS IS TO HANDLE THE MOMENT THE DATA TABLE WAS RELOADED;
$(".tableProducts").on("draw.dt", function(){
  // console.log("drawtable"); // DEBUG:
  if (localStorage.getItem("updateProduct") != null) {
    var listIdProduct = JSON.parse(localStorage.getItem("updateProduct"));

    var i=0;
    while (i < listIdProduct.length) {
      var tableId = listIdProduct[i]["tableId"];
      var idProduct = listIdProduct[i]["idProduct"];
      var updateAction = listIdProduct[i]["update"];
      var targetButton = tableId + "tbody tr td button[idProduct='"+idProduct+"']";
      if ($(targetButton + "[idProduct='"+idProduct+"']").length) {
        // NOTE: the ($("button.recoverButton[idProduct='"+idProduct+"']").length) used to test if the button exist in the view. If the value = 0 means there is none and in JQuery (Javascript) 0 means false in IF test;
        if (updateAction == "remove") {
          $("button.recoverButton[idProduct='"+idProduct+"']").removeClass("btn-default");
          $("button.recoverButton[idProduct='"+idProduct+"']").addClass("btn-primary addProduct");
        } else {
          $("button.recoverButton[idProduct='"+idProduct+"']").removeClass("btn-primary addProduct");
          $("button.recoverButton[idProduct='"+idProduct+"']").addClass("btn-default");
        }

        // NOTE: we need to pop the i th data from the array listIdProduct;
        listIdProduct.splice(i, 1);
        i--; // IDEA: when splice the list index also shofted thus the index must be substracted;
      }
      i++;
      // --while (i < listIdProduct.length)
    }
    // console.log("listIdProduct", JSON.stringify(listIdProduct));// DEBUG:
    localStorage.setItem("updateProduct", JSON.stringify(listIdProduct));

  }
  // --$(".salesForm").on("draw.dt", function()
})

// UPDATE PRODUCT PRICE WHEN QUANTITY CHANGES;
$(".salesForm").on("change", "input.newProductQuantity", function(){
  // console.log("product quantity change");// DEBUG:

  if (Number($(this).val()) > Number($(this).attr("stock"))) {
    // IDEA: if the stock is not sufficient return the value of the quantity back to 1;
    $(this).val(1);
    // IDEA: if the product added larger than the stock available invoke error;
    Swal.fire({
      icon: 'error',
      title: 'Stock maksimal: ' + Number($(this).attr("stock")),
      text: 'Permintaan anda tidak dapat dipenuhi!',
      confirmButtonText: 'OK!'
    });
  }
  // IDEA: take the unit price from the input.newProductPrice;
  var objectPrice = $(this).parent().parent().children(".productPrice").children().children(".newProductPrice");
  // console.log("objectPrice", objectPrice);// DEBUG:
  var unitPrice = $(objectPrice).attr("unitPrice");
  // console.log("unitPrice", unitPrice);// DEBUG:

  // IDEA: put the quntity * unit price to the input objectPrice value;
  $(objectPrice).val(Number($(this).val()) * Number(unitPrice));

  // IDEA: call the totalPrice function to sum all prices and put it into total price input form;
  totalPrice();

  // IDEA: make JSON data array with data on the transaction real time;
  jsonTransaction();

  // IDEA: if the payment is cash auto calculate the chages;
  if ($("input#newCashPayment").length) {
    cashChanges();
  }
  // --$(".salesForm").on("change", "input.newProductQuantity", function()
})

// SUM THE PRODUCT PRICE TO FILL THE TOTAL PRICE ;
function totalPrice(){
  // IDEA: fetch all individual product price in an array;
  var objectProductPrice = $(".newProductPrice");
  // console.log("objectProductPrice", objectProductPrice);// DEBUG:

  // IDEA: iterate all selectors in the objectProductPrice and push it into the array of product price;
  var totalProductPrice = [];
  for (var i = 0; i < objectProductPrice.length; i++) {
    var productPrice = Number($(objectProductPrice[i]).val());
    totalProductPrice.push(productPrice);
  }
  // console.log("totalProductPrice", totalProductPrice);// DEBUG:

  // IDEA: sum all numbers in totalProductPrice using JQuery reduce() function;
  var totalPrice = totalProductPrice.reduce(sumTotalPrice);
  // console.log("totalPrice", totalPrice);// DEBUG:

  // IDEA: I want to add tax to the equation thus the total Price will be put on the before tax attribute to accomaodate if the tax value is changing;
  $("input#newTotalSales").attr("beforeTax",totalPrice);
  $("input#beforeTaxTotalSales").val(totalPrice);
  var taxValue = $("input#newSalesTax").val();

  var totalAfterTax = (1 + taxValue/100) * totalPrice;
  // console.log("tax value", totalAfterTax - totalPrice); // DEBUG:

  // IDEA: put the totalPrice into the input #newTotalSales;
  $("input#newTotalSales").number(true, 2, ',', '.');
  $("input#newTotalSales").val(totalAfterTax);
  $("input#plainTotalSales").number(true,2);
  $("input#plainTotalSales").val(totalAfterTax);

  function sumTotalPrice(total, num){
    return total + num;
  }
  // --function totalPrice()
}

// HANDLE CHANGES IN TAX INPUT WILL CHANGE THE TOTAL AFTER TAX;
$(".salesForm").on("change", "input#newSalesTax", function(){
  // IDEA: all the neccessary calculations are already being presented in the totalPrice function including fetching the tax value and add it into the total price after tax.
  totalPrice();

  // IDEA: make JSON data array with data on the transaction real time;
  jsonTransaction();

  // IDEA: if the payment is cash auto calculate the chages;
  if ($("input#newCashPayment").length) {
    cashChanges();
  }
  // --$(".salesForm").on("change", "input#newSalesTax", function()
})

// HANDLE THE PAYMENT METHOD;
// IDEA: when the customer payment select input changed then handle the payment according to which method chosen;
$(".salesForm").on("change", "select#newPaymentMethod", function(){
  // console.log("the choice: ", $(this).val()); // DEBUG:
  // IDEA: lock on the payment handler related to this object; is it need to be or not?
  var paymentHandler = $(this).parent().parent().parent().children("#paymentHandler").children();
  // IDEA: switch to each case whenever the method used;
  switch ($(this).val()) {
    case "":
      $(paymentHandler).html(
        '<p>Pilih Metode Pembayaran!</p>'
      );
      break;
    case "cash":
      // console.log("cashier select cash");// DEBUG:
      // IDEA: use cash handler consist of amount paid and change from transaxtion;
      $(paymentHandler).html(
        '<input type="text" class="form-control cashAmount" id="newCashPayment" name="newCashPayment" placeholder="uang dibayar" required>'
      );
      $("input#newCashPayment").number(true, 2, ',', '.');
      $("input#paymentCode").val("cash");
      break;
    case "creditCard":
      // console.log("cashier select credit card");// DEBUG:
      // IDEA: select the credit card provider and then the transaction code;
      $(paymentHandler).html(
        '<select class="form-control selectPayTool" id="creditCardVendor" name="creditCardVendor" required>' +
          '<option value="">Pilih Credit Card Provider</option>' +
          '<option value="visa">Visa</option>' +
          '<option value="masterCard">Master Card</option>' +
          '<option value="other">other</option>' +
        '</select>' +
        '<br><br><input type="text" class="form-control idPayTool" id="newCCNumber" name="newCCNumber" placeholder="nomor Credit Card" required>' +
        '<br><input type="text" class="form-control transactionPayTool" id="newCCTransaction" name="newCCTransaction" placeholder="nomor Transaksi" required>'
      );
      break;
    case "debitCard":
      // console.log("cashier select debit card");// DEBUG:
      // IDEA: select debit card bank provider and the input transaction code after payment;
      $(paymentHandler).html(
        '<select class="form-control selectPayTool" id="debitCardVendor" name="debitCardVendor" required>' +
          '<option value="">Pilih Debit Card Provider</option>' +
          '<option value="bca">BCA</option>' +
          '<option value="mandiri">Mandiri</option>' +
          '<option value="other">other</option>' +
        '</select>' +
        '<br><br><input type="text" class="form-control idPayTool" id="newDCNumber" name="newDCNumber" placeholder="nomor Debit Card" required>' +
        '<br><input type="text" class="form-control transactionPayTool" id="newDCTransaction" name="newDCTransaction" placeholder="nomor Transaksi" required>'
      );
      break;

    case "payApp":
      // console.log("select pay app");// DEBUG:
      // IDEA: select the payment apps and then input its ID and transaction refs;
      $(paymentHandler).html(
        '<select class="form-control selectPayTool" id="payAppVendor" name="payAppVendor" required>' +
          '<option value="">Pilih Payment App Provider</option>' +
          '<option value="gopay">Gopay</option>' +
          '<option value="ovo">OVO</option>' +
          '<option value="linkAja">Link Aja</option>' +
        '</select>' +
        '<br><br><input type="text" class="form-control idPayTool" id="newPayAppId" name="newPayAppId" placeholder="ID Payment App" required>' +
        '<br><input type="text" class="form-control transactionPayTool" id="newAppTransaction" name="newAppTransaction" placeholder="nomor Transaksi" required>'
      );
      break;

    default:
      // console.log("other?");// DEBUG:
      // IDEA: input the payment method and amunt and reference or note;?
      $(paymentHandler).html(
        '<input type="text" class="form-control selectPayTool" id="newOtherPayment" name="newOtherPayment" placeholder="Note what payment type" required>' +
        '<br><br><input type="text" class="form-control" id="newOtherAmount" name="newOtherAmount" placeholder="Jumlah Transaksi" required>' +
        '<br><br><input type="text" class="form-control transactionPayTool" id="newOtherTransaction" name="newOtherTransaction" placeholder="Note refs. transaksi" required>'
      );
  }
  // --$(".salesForm").on("change", "select#newCustomerPayment", function()
})

// HANDLE IF THE PAYMENT HAS CHANGES;
// IDEA: this change form only happens when there is left over from the payment;
$(".salesForm").on("change", "input#newCashPayment", function(){
  cashChanges();
  // --$(".salesForm").on("change", "input#newCashPayment", function()
})

// IDEA: the cash payment changes supposed to adapt to any changes from the amount paid to the changes in the total price;
function cashChanges(){
  // if ($("input#newCashPayment").length) {
  //   var test = true;
  // } else {
  //   var test = false;
  // }
  // console.log("cash payment", test);// DEBUG:
  var totalAfterTax = Number($("input#newTotalSales").val());
  // console.log("totalAfterTax", totalAfterTax);// DEBUG:
  var customerPayment = Number($("input#newCashPayment").val());
  // console.log("customerPayment", customerPayment);// DEBUG:
  // IDEA: prepare new div to contain the response;
  $("input#newCashPayment").parent().append('<div class="paymentResponse"></div>')
  // IDEA: if the amount paid by customer is less the total then add message donates payment is not sufficient;
  if (customerPayment < totalAfterTax) {
    // IDEA: remove the div paymentResponse;
    $("input#newCashPayment").parent().children(".paymentResponse").remove();
    // TODO: this need to be upgraded to proper warning!
    if (customerPayment == 0) {
      $("input#newCashPayment").parent().append(
        '<div class="paymentResponse">' +
        '<p>Menunggu Pembayaran</p>' +
        '</div>'
      );
    } else {
      $("input#newCashPayment").parent().append(
        '<div class="paymentResponse">' +
        '<p>Jumlah Uang dibayarkan kurang!</p>' +
        '</div>'
      );
    }

  } else if (customerPayment > totalAfterTax) {
    // IDEA: remove the div paymentResponse;
    $("input#newCashPayment").parent().children(".paymentResponse").remove();

    $("input#newCashPayment").parent().append(
      '<div class="paymentResponse">' +
      '<br><label for="newCustomerChange">Kembalian:</label>' +
      '<input type="text" class="form-control cashAmount" id="newCashChange" name="newCashChange" placeholder="0" required readonly>' +
      '</div>'
    );
    // IDEA: if the amount paid is bigger than total after tax then put the change input on the surface and the value is the gap between customerPayment and totalAfterTax;
    $("input#newCashChange").number(true, 2, ',', '.');
    $("input#newCashChange").val(customerPayment - totalAfterTax);
  } else {
    // IDEA: remove the div paymentResponse;
    $("input#newCashPayment").parent().children(".paymentResponse").remove();
  }
  // --function cashChanges()
}

// IDEA: make JSON data array with data on the transaction real time;
function jsonTransaction(){
  // IDEA: get all array in each product added to the sales form; the array will get from class .newProductDescription, .newProductQuantity, .newProductPrice;

  var productTransactions = [];

  var productsData = $(".newProductDescription");
  // console.log("productsData", productsData);// DEBUG:
  var quantitiesData = $(".newProductQuantity");
  // console.log("quantitiesData", quantitiesData);// DEBUG:
  var pricesData = $(".newProductPrice");
  // console.log("pricesData", pricesData);// DEBUG:

  // IDEA: iterate the whole array of product data and get these data for each product: id, description, quantity, stockLeft, unitPrice, totalPrice for each product on the sales form;
  for (var i = 0; i < productsData.length; i++) {
    productTransactions.push({
      "id":$(productsData[i]).attr("idProduct"),
      "description":$(productsData[i]).val(),
      "quantity":$(quantitiesData[i]).val(),
      "stockLeft":Number($(quantitiesData[i]).attr("stock")) - Number($(quantitiesData[i]).val()),
      "unitPrice":$(pricesData[i]).attr("unitPrice"),
      "totalPrice":$(pricesData[i]).val()
    });
  }

  // IDEA: stringify the productTransactions to make JSON formatted data;
  // console.log("productTransactions", JSON.stringify(productTransactions));// DEBUG:

  // IDEA: pick a hidden input to put the JSON data before being uploaded to database later on;
  $("input#hiddenJson").val(JSON.stringify(productTransactions));

  // --function jsonTransaction()
}

// IDEA: build dedicated function to record the transaction CODE
function transactionCodeRecorder(){
  // IDEA: transaction code is consist of payment tool selection, payment id code, payment transaction code.
  if ($("input#newOtherPayment").length) {
    // IDEA: the other payment is dedicated with other code and then the transaction code if available; but since the other is based on input type text;
    var transactionCode = $(".selectPayTool").val() + '-' + $(".transactionPayTool").val();
    $("input#paymentCode").val(transactionCode);
  } else {
    // IDEA: this is  the code from the card or app;
    var transactionCode = $(".selectPayTool").val() + '-' + $(".transactionPayTool").val();
    $("input#paymentCode").val(transactionCode);
  }
  // -- function transactionCodeRecorder()
}

// IDEA: this is the each part of payment other than cash;
$(".salesForm").on("change", ".selectPayTool", function(){
  transactionCodeRecorder();
  // -- $(".salesForm").on("change", ".selectPayTool", function()
})

$(".salesForm").on("change", ".idPayTool", function(){
  transactionCodeRecorder();
  // -- $(".salesForm").on("change", ".selectPayTool", function()
})

$(".salesForm").on("change", ".transactionPayTool", function(){
  transactionCodeRecorder();
  // -- $(".salesForm").on("change", ".selectPayTool", function()
})
