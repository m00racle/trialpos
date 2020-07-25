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
