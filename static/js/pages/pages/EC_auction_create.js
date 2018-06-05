function numberWithCommas(x) {
	if (isNaN(x))
		return x;
	var parts = x.toString().split(".");
	parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	return parts.join(".");
}

function numberWithDot(x) {
	return x == null || x == "0" ? "" : x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

function removeCommas(x) {
	return x.replace(/,/g, "");
}
function removeDot(x) {
	return x.replace(/\./g, "");
}

function openmodal (ID_ITEM) {
  // MATNR='341-107-0083';//341-107-0083  301-200410
    $.ajax({
        url: $("#base-url").val() + 'EC_Auction/getDetailItem/' + ID_ITEM,
        type: 'get',
        dataType: 'json',
    })
    .done(function(data) { 
         console.log(data.ID_ITEM[0]);              
         dt = data.ID_ITEM[0];
	         if(dt!=null){
	         $("#formUp").attr("action", "EC_Auction/updateItem/" + dt.MATNR);  
             $("#ID_ITEM").val(dt.ID_ITEM);       
	         $("#KODE_BARANG").val(dt.KODE_BARANG);
	         $("#NAMA_BARANG").val(dt.NAMA_BARANG);
	         $("#JUMLAH").val(dt.JUMLAH);
	         $("#UNIT").val(dt.UNIT);
	         $("#PRICE").val(numberWithDot(dt.PRICE));
	         
         $("#edit-item").modal('show')	
         }         
    })
    .fail(function() {
        console.log("error");
    })
    .always(function(data) {
        // console.log(MATNR);
    });
}

function openmodal1 (KODE_VENDOR) {
  // MATNR='341-107-0083';//341-107-0083  301-200410
    $.ajax({
        url: $("#base-url").val() + 'EC_Auction/getDetailUser/' + KODE_VENDOR,
        type: 'get',
        dataType: 'json',
    })
    .done(function(data) { 
         console.log(data.KODE_VENDOR[0]);              
         dt = data.KODE_VENDOR[0];
	         if(dt!=null){
	         $("#formUp").attr("action", "EC_Auction/updateUser/" + dt.MATNR);  
             $("#ID_USER").val(dt.ID_USER);       
	         $("#KODE_VENDOR").val(dt.KODE_VENDOR);
	         $("#NAMA_VENDOR").val(dt.NAMA_VENDOR);
	         $("#USERID").val(dt.USERID);
	         $("#PASS").val(dt.PASS);
	         $("#HARGAAWAL").val(numberWithDot(dt.HARGAAWAL));
	         
         $("#edit-peserta").modal('show')	
         }         
    })
    .fail(function() {
        console.log("error");
    })
    .always(function(data) {
        // console.log(MATNR);
    });
}

// $('#edit-item').on('show.bs.modal', function(event) {
// 		var button = $(event.relatedTarget)
// 		$("#kd_itm").val(button.data('kd_itm'))
// 		$("#desc_itm").val(button.data('desc_itm'))
// 		$("#qty").val(button.data('qty'))
// 		$("#uom").val(button.data('uom'))
// 		$("#ece").val(button.data('ece'))
// 		$("#idItem").val(button.data('idItem'))
// 	})


$('.input-group.date').datetimepicker({
	format : 'DD/MM/YYYY HH:mm:ss',
	// sideBySide: true,
	ignoreReadonly : true,
	minDate : new Date()
});

$('.input-group.date input').attr("readonly", true);

$(document).ready(function() {
	//console.log(new Date());
	$("#TGL_TUTUP").val('');
	$('.glyphicon-refresh').click(function() {
		$(this).parent().prev().val(Math.random().toString(36).substr(2, 5))
	});
	$('#tipeHPS').change(function() {
		if ($(this).val() == 'S')
			$('#HPS').val($('#hargaSatu').val())
		else
			$('#HPS').val($('#hargaTot').val())
	});

	$("#passw,#user").keyup(function() {
		if ($(this).val().length < 3)
			$(this).val(Math.random().toString(36).substr(2, 8))
	})
	$(".nmr").keyup(function() {
		if ($(this).val() < 0 || $(this).val().search(/[A-Za-z]/g) != -1)
			$(this).val(1)
	})
	$(".format-koma").keyup(function() {
		if ($(this).val() < 0 || $(this).val().search(/[A-Za-z]/g) != -1)
			$(this).val(1)
		else
		$(this).val(numberWithDot(removeDot($(this).val())))
	})

	$(".printt").on("click", function() {
		var printContents = document.getElementById('printin').innerHTML;
		var originalContents = document.body.innerHTML;
		document.body.innerHTML = printContents;
		window.print();
		document.body.innerHTML = originalContents;
	})
})
