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
