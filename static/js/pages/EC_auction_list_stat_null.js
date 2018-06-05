function batal(notender){
     // alert(ID_INVOICE);
     swal({
        title: "Apakah anda yakin?",
        text: "",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#92c135',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        cancelButtonText: "Tidak",
        closeOnConfirm: false,
        closeOnCancel: true
     },
     function(isConfirm) {
        if (isConfirm) {
            $.ajax({
                url: $("#base-url").val() + 'EC_Auction_itemize/batal/' + notender,
                type: "post",
                success: function (data) {
                    if(data.success!=true){
                        location.reload();
                    } else {
                        swal("Error!", "Data gagal dikirim", "error")
                    }
                },
                error: function (xhr, status) {
                    swal("Error!", "Data gagal dikirim", "error")
                    //location.reload();
                },
                complete: function (xhr, status) {
                    //$('#showresults').slideDown('slow')
                }
            });

        } else {
        }
     })
     return this;
 }

 function buka(notender){
     // alert(notender);
     swal({
        title: "Apakah anda yakin?",
        text: "",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#92c135',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        cancelButtonText: "Tidak",
        closeOnConfirm: false,
        closeOnCancel: true
     },
     function(isConfirm) {
        if (isConfirm) {
            $.ajax({
                url: $("#base-url").val() + 'EC_Auction_itemize/open/' + notender,
                type: "post",
                success: function (data) {
                    if(data.success!=true){
                        var url1 = $("#base-url").val() + 'EC_Auction_itemize/'
                        window.location.href = url1;
                    } else {
                        swal("Error!", "Data gagal dikirim", "error")
                    }
                },
                error: function (xhr, status) {
                    swal("Error!", "Data gagal dikirim", "error")
                    //location.reload();
                },
                complete: function (xhr, status) {
                    //$('#showresults').slideDown('slow')
                }
            });

        } else {
        }
     })
     return this;
 }



$(document).ready(function(){
    
    $(".select2").select2();

})