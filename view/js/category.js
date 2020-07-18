// VALIDATE THE SUPPLIER NAME HASNOT BEING USED;
$("#newSupplier").change(function(){
  // remove alert if presence;
  $(".alert").remove();
  var supName = $(this).val();

  var datos = new FormData();
  datos.append("validateSup", supName);

  $.ajax({
    url:"ajax/categoryajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(response){
      if (response) {
        // alert the user that the supplier name already taken;
        $("#newSupplier").parent().after('<div class="alert alert-warning">nama Supplier sudah terpakai!</div>');
        $("#newSupplier").val("");
      }
    }
  })
})
