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
