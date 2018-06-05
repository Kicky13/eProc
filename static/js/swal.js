/*$('#huahua').on("click", function(e) {
  e.preventDefault();
  var url = $(this).attr('value');
  console.log(url);
  swal({
    title: "Apakah Anda yakin?",
    text: "Segala tindakan tidak dapat dibatalkan",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: '#DD6B55',
    confirmButtonText: 'Lanjutkan',
    cancelButtonText: "Batalkan",
    closeOnConfirm: false,
    closeOnCancel: false
 },
 function(isConfirm){

   if (isConfirm){
     swal("Sukses", "", "success");
     window.location.href = url;
    } else {
      swal("Batal", "", "error");
         e.preventDefault();
         return false;
    }
 });
});*/

function swalconfirm(subjudul, judul) {
  if (subjudul == null) {
    subjudul = $('.subjudul').attr('value');
  }
  if (judul == null) {
    judul = "Apakah Anda yakin?";
  }
  swal({
    title: judul,
    text: subjudul,
    type: 'warning',
    showCancelButton: true,
    cancelButtonColor: '#92c135',
    confirmButtonColor: '#d33',
    cancelButtonText: 'Ya',
    confirmButtonText: 'Tidak',
    cancelButtonClass: 'btn btn-success',
    confirmButtonClass: 'btn btn-danger',
    closeOnConfirm: true,
    closeOnCancel: true
  },
  function(isConfirm) {
    return isConfirm;
  });
}

function swalwarning(subjudul, judul) {
  if (judul == null) {
    judul = "";
  }
  swal({
    title: judul,
    text: subjudul,
    type: 'warning',
    // showCancelButton: true,
    // cancelButtonColor: '#92c135',
    confirmButtonColor: '#d33',
    // cancelButtonText: 'OK',
    confirmButtonText: 'OK',
    // cancelButtonClass: 'btn btn-success',
    confirmButtonClass: 'btn btn-success',
    closeOnConfirm: true
    // closeOnCancel: true
  },
  function(isConfirm) {
    return isConfirm;
  });
}

$(".formsubmit").click(function(e){
    e.preventDefault();
    var judul = $('.judul').attr('value');
    var subjudul = $('.subjudul').attr('value');
    if(!judul) judul = "Apakah Anda yakin?";
    console.log(judul);
    swal({
      title: judul,
      text: subjudul,
      type: 'warning',
      showCancelButton: true,
      cancelButtonColor: '#92c135',
      confirmButtonColor: '#d33',
      cancelButtonText: 'Ya',
      confirmButtonText: 'Tidak',
      cancelButtonClass: 'btn btn-success',
      confirmButtonClass: 'btn btn-danger',
      closeOnConfirm: true,
      closeOnCancel: true
    },
    function(isConfirm) {
      if (isConfirm === true) {
        console.log('isConfirm === true');
      } else if (isConfirm === false) {
        console.log('isConfirm === false');
        $("form.submit").submit();
        console.log($("form.submit"));
      } else {
        
      }
      return isConfirm;
    })
});