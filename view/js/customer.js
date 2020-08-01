$('#newCustomerName').change(function(){
  // insert new document id based on the last doc id;
  var customerName = $(this).val();

  var datos = new FormData();
  datos.append("customerName", customerName);
  // console.log("datos", datos.get("customerName"));// DEBUG:

  $.ajax({
    url:"ajax/customerajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(response){
      // console.log("response", response);// DEBUG:
      var newDocId = Number(response[0]["doc_id"]) + 1;

      $("#newDocumentId").val(newDocId);
    }
  })
})

// EDIT CUSTOMER;
$(document).on("click", ".btnEditCustomer", function(){
  var idCustomer = $(this).attr("idCustomer");
  // console.log("idCustomer", idCustomer);// DEBUG:

  var datos = new FormData();
  datos.append("idCustomer", idCustomer);
  // console.log("datos", datos.get("idCustomer"));// DEBUG:

  $.ajax({
    url: "ajax/customerajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(response){
      // console.log("response", response);// DEBUG:
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
