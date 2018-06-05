$(document).ready(function() {
	$("form").submit(function(e) { 
		if($(".harusmilih_publicjs").val() == 'accept'){			
			if ($("#assign").val() == '') {
	                sweetAlert(
	                   'Assign to Kosong',
	                   'Pilih Data',
	                   'warning'
	                )
	            e.preventDefault();
	             return false;
	        }
        }

        var form = this;
        e.preventDefault();
        swal({
            title: "Apakah Anda Yakin?",
            text: "Pastikan Semua Data Yang Anda Masukkan Sudah Benar!",
            type: "warning",
            showCancelButton: true,
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
                    form.submit();
            } else {
            }
        }) 
	}) 
})