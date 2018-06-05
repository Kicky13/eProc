base_url = $("#base-url").val();

$("#update_tgl").click(function() {
	$.ajax({
		url: $("#base-url").val() + 'Negosiasi/update_tanggal_nego',
		type: 'post',
		dataType: 'json',
		data: $("#quotation-form").serialize(),
	})
	.done(function(data) {
		location.reload();
	})
	.fail(function() {
		alert('Gagal mengubah data.');
	})
	.always(function(data) {
		location.reload();
	});
});