$('#setuju').change(function() {
	$(".stj").prop('disabled', true);
	if ($(this).is(":checked")) {
		$(".stj").prop('disabled', false);
	}
});

function undurdiri1(){
     // alert(ID_INVOICE);
     swal({
     	title: "Apakah anda yakin?",
     	text: "",
     	type: "info",
     	showCancelButton: true,
     	confirmButtonColor: '#92c135',
     	cancelButtonColor: '#d33',
     	confirmButtonText: 'Lanjut',
     	confirmButtonClass: 'btn btn-success',
     	cancelButtonClass: 'btn btn-danger',
     	cancelButtonText: "Batal",
     	closeOnConfirm: false,
     	closeOnCancel: true
     },
     function(isConfirm) {
     	if (isConfirm) {
     		undurdiri2();
     		// location.reload();
     	} else {
     		// alert('aaaa')
     	}
     })

     // swal({
     // 	title: 'Are you sure?',
     // 	text: "You won't be able to revert this!",
     // 	type: 'warning',
     // 	showCancelButton: true,
     // 	confirmButtonColor: '#3085d6',
     // 	cancelButtonColor: '#d33',
     // 	confirmButtonText: 'Yes, delete it!'
     // }).then(function () {
     // 	swal(
     // 		'Deleted!',
     // 		'Your file has been deleted.',
     // 		'success'
     // 		)
     // })

 }

 function undurdiri2(){
     // alert(ID_INVOICE);
     swal({
          title: "Apabila anda klik ok maka anda setuju bahwa anda keluar dari forum e-Auction ini dan tidak melanjutkan tender sampai dengan tahap akhir!",
          text: "",
          type: "info",
          width: '850px',
          // customClass: 'sweetalert1-lg',
          showCancelButton: true,
          confirmButtonColor: '#92c135',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ok',
          confirmButtonClass: 'btn btn-success',
          cancelButtonClass: 'btn btn-danger',
          cancelButtonText: "Batal",
          closeOnConfirm: false,
          closeOnCancel: true
     },
     function(isConfirm) {
          if (isConfirm) {
               undurdiri3();
               // location.reload();
          } else {
               // alert('aaaa')
          }
     })

     // swal({
     //   title: 'Are you sure?',
     //   text: "You won't be able to revert this!",
     //   type: 'warning',
     //   showCancelButton: true,
     //   confirmButtonColor: '#3085d6',
     //   cancelButtonColor: '#d33',
     //   confirmButtonText: 'Yes, delete it!'
     // }).then(function () {
     //   swal(
     //        'Deleted!',
     //        'Your file has been deleted.',
     //        'success'
     //        )
     // })

 }

 function undurdiri3(NO_TENDER){
     // alert(ID_INVOICE);
     swal({
     	title: "Anda telah dinyatakan mengundurkan diri",
     	text: "",
     	type: "warning",
     	showCancelButton: false,
     	confirmButtonColor: '#92c135',
     	cancelButtonColor: '#d33',
     	confirmButtonText: 'Ya',
     	confirmButtonClass: 'btn btn-success',
     	cancelButtonClass: 'btn btn-danger',
     	cancelButtonText: "Tidak",
     	closeOnConfirm: true,
     	closeOnCancel: true
     },
     function(isConfirm) {
     	if (isConfirm) {
     		var notender = $('.notender').val();
     		var setuju = $('.tidak_setuju').val();
     		$.ajax({
     			url: $("#base-url").val() + 'EC_Auction_itemize_negotiation/setuju',
     			data: {
     				notender: notender,
     				setuju: setuju
     			},
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

 $(document).ready(function() {

 	$(".select2").select2();

 });
