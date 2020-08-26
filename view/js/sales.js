// LOAD THE DYNAMIC DATA TABLE;
// $.ajax({
//   url: "ajax/datatablesalesajax.php",
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
            '<input type="text" class="form-control addProduct" name="addProduct" value="'+description+'" required readonly>' +
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
  } else {
    // IDEA: call the totalPrice function to sum all prices and put it into total price input form;
    totalPrice();
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
  var taxValue = $("input#newSalesTax").val();

  var totalAfterTax = (1 + taxValue/100) * totalPrice;
  // console.log("tax value", totalAfterTax - totalPrice); // DEBUG:

  // IDEA: put the totalPrice into the input #newTotalSales;
  $("input#newTotalSales").number(true, 2, ',', '.');
  $("input#newTotalSales").val(totalAfterTax);

  function sumTotalPrice(total, num){
    return total + num;
  }
  // --function totalPrice()
}

// HANDLE CHANGES IN TAX INPUT WILL CHANGE THE TOTAL AFTER TAX;
$(".salesForm").on("change", "input#newSalesTax", function(){
  // IDEA: all the neccessary calculations are already being presented in the totalPrice function including fetching the tax value and add it into the total price after tax.
  totalPrice();
  // --$(".salesForm").on("change", "input#newSalesTax", function()
})

// HANDLE THE PAYMENT METHOD;
// IDEA: when the customer payment select input changed then handle the payment according to which method chosen;
$(".salesForm").on("change", "select#newPaymentMethod", function(){
  console.log("the choice: ", $(this).val()); // DEBUG: active
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
      console.log("cashier select cash");// DEBUG: active
      // IDEA: use cash handler consist of amount paid and change from transaxtion;
      $(paymentHandler).html(
        '<input type="text" class="form-control cashAmount" id="newCashPayment" name="newCashPayment" placeholder="uang dibayar" required>' +
        '<br><label for="newCustomerChange">Kembalian:</label>' +
        '<input type="text" class="form-control cashAmount" id="newCashChange" name="newCashChange" placeholder="0" required readonly>'
      );
      break;
    case "creditCard":
      console.log("cashier select credit card");// DEBUG: active
      // IDEA: select the credit card provider and then the transaction code;
      $(paymentHandler).html(
        '<select class="form-control" id="creditCardVendor" name="creditCardVendor" required>' +
          '<option value="">Pilih Credit Card Provider</option>' +
          '<option value="visa">Visa</option>' +
          '<option value="masterCard">Master Card</option>' +
          '<option value="other">other</option>' +
        '</select>' +
        '<br><br><input type="text" class="form-control" id="newCCNumber" name="newCCNumber" placeholder="nomor Credit Card" required>' +
        '<br><input type="text" class="form-control" id="newCCTransaction" name="newCCTransaction" placeholder="nomor Transaksi" required>'
      );
      break;
    case "debitCard":
      console.log("cashier select debit card");// DEBUG: active
      // IDEA: select debit card bank provider and the input transaction code after payment;
      $(paymentHandler).html(
        '<select class="form-control" id="debitCardVendor" name="debitCardVendor" required>' +
          '<option value="">Pilih Debit Card Provider</option>' +
          '<option value="bca">BCA</option>' +
          '<option value="mandiri">Mandiri</option>' +
          '<option value="other">other</option>' +
        '</select>' +
        '<br><br><input type="text" class="form-control" id="newDCNumber" name="newDCNumber" placeholder="nomor Debit Card" required>' +
        '<br><input type="text" class="form-control" id="newDCTransaction" name="newDCTransaction" placeholder="nomor Transaksi" required>'
      );
      break;

    case "payApp":
      console.log("select pay app");// DEBUG: active
      // IDEA: select the payment apps and then input its ID and transaction refs;
      $(paymentHandler).html(
        '<select class="form-control" id="payAppVendor" name="payAppVendor" required>' +
          '<option value="">Pilih Payment App Provider</option>' +
          '<option value="gopay">Gopay</option>' +
          '<option value="ovo">OVO</option>' +
          '<option value="linkAja">Link Aja</option>' +
        '</select>' +
        '<br><br><input type="text" class="form-control" id="newPayAppId" name="newPayAppId" placeholder="ID Payment App" required>' +
        '<br><input type="text" class="form-control" id="newAppTransaction" name="newAppTransaction" placeholder="nomor Transaksi" required>'
      );
      break;

    default:
      console.log("other?");// DEBUG: active
      // IDEA: input the payment method and amunt and reference or note;?
      $(paymentHandler).html(
        '<input type="text" class="form-control" id="newOtherPayment" name="newOtherPayment" placeholder="Note what payment type" required>' +
        '<br><br><input type="text" class="form-control" id="newOtherAmount" name="newOtherAmount" placeholder="Jumlah Transaksi" required>' +
        '<br><br><input type="text" class="form-control" id="newOtherTransaction" name="newOtherTransaction" placeholder="Note refs. transaksi" required>'
      );
  }
  // --$(".salesForm").on("change", "select#newCustomerPayment", function()
})
