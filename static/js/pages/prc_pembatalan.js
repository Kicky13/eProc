$(document).ready(function(){
	$("#cari").click(function(){
		$.ajax({
			url: $("#base-url").val() + 'Procurement_pembatalan/is_exist/' + $("#nomor_pengadaan").val(),
			type: 'GET',
			dataType: 'json',	
		})
		.done(function(data) {
			if (data != false && data >= 0 && data < 14) {
				$("#areyou").addClass('hidden')
				$("#serious").removeClass('hidden')
				$("#nomor_pengadaan").attr('readonly', 'true')
			} else {
				alert('Nomor pengadaan tidak ditemukan.')
			}
		})
		.fail(function() {
			console.log("error");
		})
		.always(function(data) {
			console.log(data);
		});
	})

	$("#cancel").click(function(){
		$("#areyou").removeClass('hidden')
		$("#serious").addClass('hidden')
		$("#nomor_pengadaan").removeAttr('readonly')
	})
})