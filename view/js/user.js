// UPLOAD THE USER Photo
$(".newPict").change(function(){
  // if the input in this case new pict is changed then we run this function;
  var pict = this.files[0]; // NOTE: this is th data on the pict in the array form
  // console.log("pict", pict); // NOTE: for test purposes only

  // validate the type of the image;
  if (pict["type"] != "image/jpeg" && pict["type"] != "image/png") {
    // if not jpeg or png then clean the variable (cancel the upload);
    $(".newPict").val("");

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
    $(".newPict").val("");

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
    // we can upload the picture file to the form;
    // first we make file reader object to save the data url;
    var dataPict = new FileReader;
    dataPict.readAsDataURL(pict);

    // the same I will make the persistence as seriable;
    $(dataPict).on("load", function(event){
      // create the route for the image url as variable;
      var routePict = event.target.result;

      // put a preview in the class named preview;
      $(".preview").attr("src", routePict);
    })
  }
})

// EDIT USER & UPDATE DATABASE USING AJAX;
// When the user click at the btnEditUser;
$(".btnEditUser").click(function() {
  //capture the inputs using the HTML attribute idUser;
  var idUser = $(this).attr("idUser");

  // console.log("idUser", idUser); // NOTE: debug;

  // instatntiate new class FormData();
  var datos = new FormData();

  // append userid which is stored in idUser variable;
  datos.append('idUser', idUser); // NOTE: remember here userid is idUser;
  // console.log("datos", datos.get("idUser")); // NOTE: debug!

  $.ajax({
    url:"ajax/userajax2.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(response){
      // console.log("response", response); // NOTE: debug!
      $("#editName").val(response["fullname"]);
      // NOTE: the #editName denotes the input id not the name!
      // NOTE: the response is just an array form of the data from the database thus the key of
      // NOTE: the full name data is still fullname
      $("#editUser").val(response["username"]);
      $("#editRole").html(response["role"]);
      // NOTE: this one uses html instead of val since the id is int he option not in select ot input!
    }
  });
})
