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
