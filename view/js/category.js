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

// EDIT SUPPLIER - SHOWING CURRENT DATA IN THE MODAL-
$(document).on("click", ".btnEditSupplier", function() {
  var idSupplier = $(this).attr("idSupplier");

  var datos = new FormData();
  datos.append("idSupplier", idSupplier);

  $.ajax({
    url:"ajax/categoryajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(response){
      $("#editSupplier").val(response["supname"]);
      $("#editStatus").val(response["status"]);
      $("#editStatus").html(response["status"]);
      $("#editBankAcc").val(response["bankacc"]);
      $("#editAccNum").val(response["accnum"]);
    }
  })

  // --$(document).on("click", ".btnEditSupplier", function()
})

// DELETE SUPPLIER - handle delete button click;
$(document).on("click", ".btnDeleteSupplier", function() {
  var idSupplier = $(this).attr("idSupplier");
  var nameSupplier = $(this).attr("nameSupplier");

      Swal.fire({
    title: 'Anda Yakin Menghapus Supplier: '+nameSupplier+'?',
    text: "Anda tidak bisa mengembalikan data setelah terhapus!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya, hapus user!'
    }).then((result) => {
    if (result.value) {
      window.location = "index.php?route=category&idSupplier="+idSupplier+"&nameSupplier="+nameSupplier;
      }
    })

  // -- $(document).on("click", ".btnDeleteSupplier", function()
})
