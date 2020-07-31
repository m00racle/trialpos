$('#newCustomerName').change(function(){
  // insert new document id based on the last doc id;
  var customerName = $(this).val();

  var datos = new FormData();
  datos.append("customerName", customerName);

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
