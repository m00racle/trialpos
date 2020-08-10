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

$('#tableProductsForSale').DataTable( {
        "ajax": "ajax/datatablesalesajax.php",
        "deferRender": true,
        "retrieve": true,
        "processing": true
    } );

// ADD THE PRODUCT FROM THE PRODUCT TABLE FOR SALE WHEN THE ADD BUTTON IS CLICKED;
$("#tableProductsForSale tbody").on("click", "button.addProduct", function(){
  // first we capture the product id;
  var idProduct = $(this).attr("idProduct");
  // console.log("idProduct ", idProduct);// DEBUG: test if id Product does exist;

  // deactivate the button on the product list when already added;
  $(this).removeClass("btn-primary addProduct");
  $(this).addClass("btn-default");

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

      // put the response to the appropriate html structure;
      $(".newProduct").append(
        '<div class="row" style="padding:5px 15px">' +
          '<div class="col-xs-6" style="padding-right:0px">' +
            '<div class="input-group">'+
              '<span class="input-group-addon"><button class="btn btn-danger removeProduct" idProduct="'+idProduct+'"><i class="fa fa-times"></i></button></span>' +
            '<input type="text" class="form-control" id="addProduct" name="addProduct" value="'+description+'" required readonly>' +
            '</div>' +
          '</div>' +
          '<!-- product quantity -->' +
          '<div class="col-xs-3">' +
            '<input type="number" class="form-control" id="newProductQuantity" name="newProductQuantity" min="1" value="1" stock="'+stock+'" required>' +
          '</div>' +
          '<!-- product price -->' +
          '<div class="col-xs-3" style="padding-left:0px">' +
            '<div class="input-group">' +
              '<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>' +
              '<input type="number" class="form-control" id="newProductPrice" name="newProductPrice" min="1"' + 'value="'+price+'" required readonly>' +
            '</div>' +
          '</div>' +
        '</div>'
      );
    }
  })
  // --$("#tableProductsForSale tbody").on("click", "button.addProduct", function()
})

// CANCEL OR DELETE SALES AND GIVE THE ADD BUTTON BACK;
$(".salesForm").on("click", "button.removeProduct", function(){
  // NOTE: here we must delete all 4 level pf parents that surrounded the button delete;
  $(this).parent().parent().parent().parent().remove();

  var idProduct = $(this).attr("idProduct");
  // NOTE: using the idProduct we will search the add button that has the attribute idProduct attribute with the value of the idProduct variable;

  $("button.recoverButton[idProduct='"+idProduct+"']").removeClass("btn-default");
  $("button.recoverButton[idProduct='"+idProduct+"']").addClass("btn-primary addProduct");
  // $(".salesForm").on("click", "button.removeProduct", function()
})
