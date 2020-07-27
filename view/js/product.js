// LOAD THE DYNAMIC DATATABLE

// $.ajax({
//   url: "ajax/datatableproductsajax.php",
//   success:function(response){
//     console.log("response",response); // NOTE: debug initial syntax test!
//
//     // --success:function(response)
//   }
//
//   // --$.ajax
// })


$('#productTable').DataTable( {
        "ajax": "ajax/datatableproductsajax.php",
        "deferRender": true,
        "retrieve": true,
        "processing": true
    } );

// SET PRODUCT CODE BASED ON THE SUPPLIER NAME;
$("#newSupplier").change(function(){
  var idSupplier = $(this).val();
  // console.log("idSupplier", idSupplier); // NOTE: debug

  var datos = new FormData();
  datos.append("idSupplier", idSupplier);
  // console.log("datos ", datos);// NOTE: debug

  $.ajax({
    url:"ajax/productajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(response){
      if (!response) {
        var newCode = idSupplier + "001"
      }else {
        var newCode = Number(response["code"]) + 1;
      }

      // console.log("new code", newCode);// NOTE: debug
      $("#newCode").val(newCode);
    }
  })

  // --$("#newSupplier").change(function()
})

// CALCULATE PERCENTAGE;
$(".percentage").click(function(){
  // console.log($(this).prop("checked"));// NOTE: debug;
  if ($(this).prop("checked")) {
    $("#newSellingPrice").attr("readonly", true);
    $(".newPercentage").attr("readonly", false);
    // console.log($(".newPercentage").val());// DEBUG:
    if ($("#newBuyingPrice").val()!="" && $(".newPercentage").val()!="") {
      var buy = $("#newBuyingPrice").val();
      var margin = $(".newPercentage").val()/100;
      $("#newSellingPrice").val(buy/(1-margin));
      // console.log($(".newPercentage").val());// DEBUG:
    }
  } else {
    $("#newSellingPrice").attr("readonly", false);
    $(".newPercentage").attr("readonly", true);
    if ($("#newSellingPrice").val()!="" && $("#newBuyingPrice").val()!="") {
      var buy = $("#newBuyingPrice").val();
      var sell = $("#newSellingPrice").val();
      $(".newPercentage").val((1-buy/sell)*100);
    }
  }

  // --$(".percentage").click(function()
})

$("#newBuyingPrice").change(function(){
  if ($(".percentage").prop("checked")) {
    var buy = $(this).val();
    var margin = $(".newPercentage").val()/100;
    // console.log(margin);// NOTE: debug;
    $("#newSellingPrice").val(buy/(1-margin));
  } else {
    if ($("#newSellingPrice").val()!="") {
      var buy = $(this).val();
      var sell = $("#newSellingPrice").val();
      $(".newPercentage").val((1-buy/sell)*100);
    }
  }

  // --$(".percentage").click(function()
})

$(".newPercentage").change(function(){
  if ($("#newBuyingPrice").val()!="" && $(".newPercentage").val()!="") {
    var buy = $("#newBuyingPrice").val();
    var margin = $(this).val()/100;
    $("#newSellingPrice").val(buy/(1-margin));
  }

  // --$(".newPercentage").change(function()
})

$("#newSellingPrice").change(function(){
  if ($("#newSellingPrice").val()!="" && $("#newBuyingPrice").val()!="") {
    var buy = $("#newBuyingPrice").val();
    var sell = $("#newSellingPrice").val();
    $(".newPercentage").val((1-buy/sell)*100);
  }

  // --$("#newSellingPrice").change(function()
})

// PREVIEW PHOTO;
$(".newPictProduct").change(function(){
  // see the image loaded;
  var pict = this.files[0];

  if (pict["type"] != "image/jpeg" && pict["type"] != "image/png") {
    $(".newPictProduct").val("");

    // put sweetalert2;
      Swal.fire({
        icon: 'error',
        title: 'Add Photo Gagal!',
        text: 'format gambar bukan jpeg atau png!',
        confirmButtonText: 'OK Ulang',
        allowOutsideClick: true
      }).then((result) => {
        if (result.value) {

        }
      });
  } else if (pict["size"] > 1000000) {
    // the file size is too big;
    $(".newPictProduct").val("");

    // put sweetalert2;
      Swal.fire({
        icon: 'error',
        title: 'Add Photo Gagal!',
        text: 'Ukuran file maksimal 1MB!',
        confirmButtonText: 'OK Ulang',
        allowOutsideClick: true
      }).then((result) => {
        if (result.value) {

        }
      })
  } else {
    var dataPict = new FileReader;
    dataPict.readAsDataURL(pict);

    $(dataPict).on("load", function(event){
      var routePict = event.target.result;

      $(".preview").attr("src", routePict);
    })
  }

  // -- $("#newPictProduct").change(function()
})

// EDIT PRODUCTS;
$(document).on("click", ".btnEditProduct", function(){
  var idProduct = $(this).attr("idProduct");
  console.log("idProduct", idProduct);// DEBUG:

  var datos = new FormData();
  datos.append("idProduct", idProduct);
  console.log("datos", datos.getAll("idProduct"));// DEBUG:

  $.ajax({
    url:"ajax/productajax.php",
    method:"POST",
    data:datos,
    cache:false,
    contentType:false,
    processData:false,
    dataType:"json",
    success: function(response){
      console.log("response", response);// DEBUG: slow AJAX compiled!

    }
  })
  // --$(document).on("click", "btnEditProduct", function()
})
