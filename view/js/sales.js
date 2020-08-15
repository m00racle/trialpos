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

$(".tableProducts").DataTable( {
        "ajax": "ajax/datatablesalesajax.php",
        "deferRender": true,
        "retrieve": true,
        "processing": true
    } );

// ADD THE PRODUCT FROM THE PRODUCT TABLE FOR SALE WHEN THE ADD BUTTON IS CLICKED;
$(".tableProducts tbody").on("click", "button.addProduct", function(){
  // first we capture the product id;
  var idProduct = $(this).attr("idProduct");
  var tableId = $(this).parent().parent().parent().parent().parent().attr("id");
  var otherTable = "#modalTable ";
  var targetButton = otherTable + "tbody tr td button[idProduct='"+idProduct+"']";
  // console.log("idProduct ", idProduct);// DEBUG: test if id Product does exist;
  console.log("table id", tableId);// DEBUG: active
  console.log("other table", $(targetButton));// DEBUG: active

  // deactivate the button on the product list when already added;
  $(this).removeClass("btn-primary addProduct");
  $(this).addClass("btn-default");

  $(targetButton).removeClass("btn-primary addProduct");
  $(targetButton).addClass("btn-default");

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

        return;
      }

      // put the response to the appropriate html structure;
      $(".newProduct").append(
        '<div class="row" style="padding:5px 15px">' +
          '<div class="col-xs-6" style="padding-right:0px">' +
            '<div class="input-group">'+
              '<span class="input-group-addon"><button class="btn btn-danger removeProduct" idProduct="'+idProduct+'"><i class="fa fa-times"></i></button></span>' +
            '<input type="text" class="form-control addProduct" name="addProduct" value="'+description+'" required readonly>' +
            '</div>' +
          '</div>' +
          '<!-- product quantity -->' +
          '<div class="col-xs-3">' +
            '<input type="number" class="form-control newProductQuantity" name="newProductQuantity" min="1" value="1" stock="'+stock+'" required>' +
          '</div>' +
          '<!-- product price -->' +
          '<div class="col-xs-3" style="padding-left:0px">' +
            '<div class="input-group">' +
              '<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>' +
              '<input type="number" class="form-control newProductPrice" name="newProductPrice" min="1"' + 'value="'+price+'" required readonly>' +
            '</div>' +
          '</div>' +
        '</div>'
      );
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
  if (localStorage.getItem("removedProduct") == null) {
    var idRemovedProduct = [];
    // NOTE: this is to prevent error if the local storage has never been initiated usually when the web app is first accessed.
  } else {
      var idRemovedProduct = JSON.parse(localStorage.getItem("removedProduct"));
  }


  // IDEA: if the product is already viewed just change the add button back to active but don't update the local storage;
  if ($("button.recoverButton[idProduct='"+idProduct+"']").length) {
    $("button.recoverButton[idProduct='"+idProduct+"']").removeClass("btn-default");
    $("button.recoverButton[idProduct='"+idProduct+"']").addClass("btn-primary addProduct");
  } else {
    // IDEA: if the product canceled is not inview yet just add it into the localStorage to be updated later when viewd;
    idRemovedProduct.push({"idProduct":idProduct}); // NOTE: this append the latest removed product to the array just in case the tracker does not find it in the first table view;
    localStorage.setItem("removedProduct", JSON.stringify(idRemovedProduct));
  }

  // $(".salesForm").on("click", "button.removeProduct", function()
})

// NOTE: THIS IS TO HANDLE THE MOMENT THE DATA TABLE WAS RELOADED;
$(".tableProducts").on("draw.dt", function(){
  console.log("drawtable"); // DEBUG:active
  if (localStorage.getItem("removedProduct") != null) {
    var listIdProduct = JSON.parse(localStorage.getItem("removedProduct"));

    for (var i = 0; i < listIdProduct.length; i++) {
      var idProduct = listIdProduct[i]["idProduct"];
      if ($("button.recoverButton[idProduct='"+idProduct+"']").length) {
        // NOTE: the ($("button.recoverButton[idProduct='"+idProduct+"']").length) used to test if the button exist in the view. If the value = 0 means there is none and in JQuery (Javascript) 0 means false in IF test;
        $("button.recoverButton[idProduct='"+idProduct+"']").removeClass("btn-default");
        $("button.recoverButton[idProduct='"+idProduct+"']").addClass("btn-primary addProduct");
        // NOTE: we need to pop the i th data from the array listIdProduct;
        listIdProduct.splice(i, 1);
      }
      // --for (var i = 0; i < listIdProduct.length; i++)
    }
    // console.log("listIdProduct", JSON.stringify(listIdProduct));// DEBUG:
    localStorage.setItem("removedProduct", JSON.stringify(listIdProduct));

  }
  // --$(".salesForm").on("draw.dt", function()
})
