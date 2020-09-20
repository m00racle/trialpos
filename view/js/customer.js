$('#newCustomerName').change(function(){
  // insert new document id based on the last doc id;
  var customerName = $(this).val();

  var datos = new FormData();
  datos.append("customerName", customerName);
  // console.log("datos", datos.get("customerName"));// TEMP:

  $.ajax({
    url:"ajax/customerajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(response){
      // console.log("response", response);// TEMP:
      var newDocId = Number(response[0]["doc_id"]) + 1;

      $("#newDocumentId").val(newDocId);
    }
  })
})

// EDIT CUSTOMER;
$(document).on("click", ".btnEditCustomer", function(){
  var idCustomer = $(this).attr("idCustomer");
  // console.log("idCustomer", idCustomer);// TEMP:

  var datos = new FormData();
  datos.append("idCustomer", idCustomer);
  // console.log("datos", datos.get("idCustomer"));// TEMP:

  $.ajax({
    url: "ajax/customerajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(response){
      // console.log("response", response);// TEMP:
      $("#editCustomerName").val(response["name"]);
      $("#editDocumentId").val(response["doc_id"]);
      $("#editCustomerEmail").val(response["email"]);
      $("#editCustomerPhone").val(response["phone"]);
      $("#editCustomerAddress").val(response["address"]);
      $("#editCustomerBirthDate").val(response["birthdate"]);
    }
  })
  // --$(document).on("click", ".btnEditCustomer", function()
})

$(document).on("click", ".btnDeleteCustomer", function(){
  var deleteCustomerId = $(this).attr("delCustomer");
  // console.log("id", deleteCustomerId);
  var customerName = $(this).attr("nameCustomer");

    Swal.fire({
  title: 'Anda Yakin Menghapus Customer: '+customerName+'?',
  text: "Anda tidak bisa mengembalikan data setelah terhapus!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Ya, hapus Customer!'
  }).then((result) => {
  if (result.value) {
    // var location = "index.php?route=customer&idCustomer="+deleteCustomerId;
    // console.log("location", location);
    window.location = "index.php?route=customer&idCustomer="+deleteCustomerId;
    }
  })

  // --$(document).on("click", ".btnDeleteCustomer", function()
})
