base_url = $("#base-url").val();

$("#update_DOC_NEGO").click(function(input) {
	
	var file_data = $("#DOC_NEGO")[0].files[0];
	var ptm_number = $("#ptm_number").val();
	var nego_id = $("#nego_id").val();
	var form_data = new FormData();
	form_data.append("files", file_data);
	form_data.append("ptm_number", ptm_number);
	form_data.append("nego_id", nego_id);
	if(file_data!=undefined){
		$.ajax({
			processData: false,
			contentType: false,
			cache: false,
			url: $("#base-url").val() + 'Negosiasi/update_doc_nego',
			type: 'post',
			dataType: "json",
			// data: $("#quotation-form").serialize(),
			data: form_data,
			success: function (data) {
				if(data.result==true){
					alert('sukses');
					location.reload();
				} else {
					alert('error');
				}
			}
		});
	} else {
		alert('Belum memilih file atau file kosong');
	}
});