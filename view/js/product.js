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
$(".newSupplier").change(function(){
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
      $(".newCode").val(newCode);
    }
  })

  // --$("#newSupplier").change(function()
})

// CALCULATE PERCENTAGE;
$(".percentage").click(function(){
  // console.log($(this).prop("checked"));// NOTE: debug;
  if ($(this).prop("checked")) {
    $(".newSellingPrice").attr("readonly", true);
    $(".newPercentage").attr("readonly", false);
    // console.log($(".newPercentage").val());// DEBUG:
    if ($(".newBuyingPrice").val()!="" && $(".newPercentage").val()!="") {
      var buy = $(".newBuyingPrice").val();
      var margin = $(".newPercentage").val()/100;
      $(".newSellingPrice").val(buy/(1-margin));
      // console.log($(".newPercentage").val());// DEBUG:
    }
  } else {
    $(".newSellingPrice").attr("readonly", false);
    $(".newPercentage").attr("readonly", true);
    if ($(".newSellingPrice").val()!="" && $(".newBuyingPrice").val()!="") {
      var buy = $(".newBuyingPrice").val();
      var sell = $(".newSellingPrice").val();
      $(".newPercentage").val((1-buy/sell)*100);
    }
  }

  // --$(".percentage").click(function()
})

$(".newBuyingPrice").change(function(){
  if ($(".percentage").prop("checked")) {
    var buy = $(this).val();
    var margin = $(".newPercentage").val()/100;
    // console.log(margin);// NOTE: debug;
    $(".newSellingPrice").val(buy/(1-margin));
  } else {
    if ($(".newSellingPrice").val()!="") {
      var buy = $(this).val();
      var sell = $(".newSellingPrice").val();
      $(".newPercentage").val((1-buy/sell)*100);
    }
  }

  // --$(".percentage").click(function()
})

$(".newPercentage").change(function(){
  if ($(".newBuyingPrice").val()!="" && $(".newPercentage").val()!="") {
    var buy = $(".newBuyingPrice").val();
    var margin = $(this).val()/100;
    $(".newSellingPrice").val(buy/(1-margin));
  }

  // --$(".newPercentage").change(function()
})

$(".newSellingPrice").change(function(){
  if ($(".newSellingPrice").val()!="" && $(".newBuyingPrice").val()!="") {
    var buy = $(".newBuyingPrice").val();
    var sell = $(".newSellingPrice").val();
    $(".newPercentage").val((1-buy/sell)*100);
  }

  // --$(".newSellingPrice").change(function()
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
  // console.log("idProduct", idProduct);// DEBUG:

  var datos = new FormData();
  datos.append("idProduct", idProduct);
  // console.log("datos", datos.getAll("idProduct"));// DEBUG:

  $.ajax({
    url:"ajax/productajax.php",
    method:"POST",
    data:datos,
    cache:false,
    contentType:false,
    processData:false,
    dataType:"json",
    success: function(response){
<<<<<<< HEAD
      // console.log("response", response);// DEBUG: slow AJAX compiled!
=======
      console.log("response", response);// DEBUG: slow AJAX compiled!
>>>>>>> 44b9b77a5dec16e32e59cbb207ef42aaf015b3cd
      $("#editSupplier").val(response["supname"]);
      $("#editSupplier").html(response["supname"]);
      $("#editCode").val(response["code"]);
      $("#editDescription").val(response["description"]);
      $("#editStock").val(response["stock"]);
      $("#editBuyingPrice").val(response["buy_price"]);
      $("#editSellingPrice").val(response["sell_price"]);
      var margin = 1-(Number(response["buy_price"])/Number(response["sell_price"]));
      $("#editPercentage").val(margin*100);
      $(".preview").attr("src", response["image"]);
      $("#currentProductPicture").val(response["image"]);

    }
  })
  // --$(document).on("click", "btnEditProduct", function()
})

// percentage function of edit modal;
$("#editCheckPercent").click(function(){
  // console.log($(this).prop("checked"));// NOTE: debug;
  if ($(this).prop("checked")) {
    $("#editSellingPrice").attr("readonly", true);
    $("#editPercentage").attr("readonly", false);
    // console.log($(".newPercentage").val());// DEBUG:
    if ($("#editBuyingPrice").val()!="" && $("#editPercentage").val()!="") {
      var buy = $("#editBuyingPrice").val();
      var margin = $("#editPercentage").val()/100;
      $("#editSellingPrice").val(buy/(1-margin));
      // console.log($(".newPercentage").val());// DEBUG:
    }
  } else {
    $("#editSellingPrice").attr("readonly", false);
    $("#editPercentage").attr("readonly", true);
    if ($("#editSellingPrice").val()!="" && $("#editBuyingPrice").val()!="") {
      var buy = $("#editBuyingPrice").val();
      var sell = $("#editSellingPrice").val();
      $("#editPercentage").val((1-buy/sell)*100);
    }
  }

  // --$("#editCheckPercent").click(function(
})

$("#editBuyingPrice").change(function(){
  if ($("#editCheckPercent").prop("checked")) {
    var buy = $(this).val();
    var margin = $("#editPercentage").val()/100;
    // console.log(margin);// NOTE: debug;
    $("#editSellingPrice").val(buy/(1-margin));
  } else {
    if ($("#editSellingPrice").val()!="") {
      var buy = $(this).val();
      var sell = $("#editSellingPrice").val();
      $("#editPercentage").val((1-buy/sell)*100);
    }
  }

  // --$("#editBuyingPrice").change(function()
})

$("#editPercentage").change(function(){
  if ($("#editBuyingPrice").val()!="" && $("#editPercentage").val()!="") {
    var buy = $("#editBuyingPrice").val();
    var margin = $(this).val()/100;
    $("#editSellingPrice").val(buy/(1-margin));
  }

  // --$("#editPercentage").change(function()
})

$("#editSellingPrice").change(function(){
  if ($("#editSellingPrice").val()!="" && $("#editBuyingPrice").val()!="") {
    var buy = $("#editBuyingPrice").val();
    var sell = $("#editSellingPrice").val();
    $("#editPercentage").val((1-buy/sell)*100);
  }

  // --$("#editSellingPrice").change(function()
})
