selectize_vendor = null;

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



function thitheTes(e){
	alert($(this).val());
	if ($(this).val() < 0 || $(this).val().search(/[A-Za-z]/g) != -1)
		$(this).val(1)
	else
		$(this).val(numberWithDot(removeDot($(this).val())))
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

function modalHargaawal (id_peserta) {
	$("#edit-hargaawal").modal() 

	$.ajax({
		url : $("#base-url").val() + 'EC_Auction_itemize/getHargaawal',
		data : {
			id_peserta: id_peserta
		},
		type : 'POST',
		dataType : 'json'
	}).done(function(data) {
		$("#formHargaAwal").empty()
		if (data.data.length == 0)
			$("#formHargaAwal").append('<div class="row text-center">Data Tidak Ditemukan!!</div>')
		else

			for (var i = 0; i < data.data.length; i++) {
				teks = '<tr style="border-bottom: 1px solid #ccc;">'
				teks += '<input type="hidden" class="form-control" name="kd_itm[]" id="kd_itm[]" required="" value="'+data.data[i][1]+'">'
				teks += '<td class="text-left">' + (i + 1) + '</td>'
				teks += '<td class="text-left">' + data.data[i][1] + '</td>'
				teks += '<td class="text-left">' + data.data[i][2] + '</td>'
				teks += '<td class="text-center"><input type="text" onkeyup="thitheTes()" class="form-control format-koma" name="harga_awal[]" id="harga_awal[]" required="" placeholder="Harga Awal" value="'+numberWithDot(data.data[i][3])+'"></td>'
				teks += '</tr>'
				$("#formHargaAwal").append(teks);
			}
		}).fail(function() {
			// console.log("error");
		}).always(function(data) {
			// console.log(data);
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

function pilih() {
	var criteria = $("#criteria option:selected").data('value');	

	inputs = '';
	inputs += '<input name="criteria['+criteria.ID_CRITERIA+'][keterangan]" value="' + criteria.CRITERIA_NAME + ' | ' + criteria.CRITERIA_DETAIL + '">';
	inputs += '<input name="criteria['+criteria.ID_CRITERIA+'][criteria_id]" value="' + criteria.ID_CRITERIA + '">';
	inputs += '<input name="criteria['+criteria.ID_CRITERIA+'][sign]" value="' + criteria.CRITERIA_SCORE_SIGN + '">';
	inputs += '<input name="criteria['+criteria.ID_CRITERIA+'][skor]" value="' + criteria.CRITERIA_SCORE + '">';
		// alert(inputs);

		tbody = $("#kriteria-pilih").find('tbody');
		tr = $('<tr class="criteria_row">')
		.append('<td class="hidden">' + inputs + '</td>')
		.append('<td>' + criteria.CRITERIA_NAME + ' | ' + criteria.CRITERIA_DETAIL + '</td>')
		.append('<td class="text-center">' + criteria.CRITERIA_SCORE_SIGN + criteria.CRITERIA_SCORE + '</td>')
		.append('<td class="text-center"><button type="button" class="btn btn-danger" onclick="$(this).parent().parent().remove()">Hapus</button></td>')
		tbody.append(tr)
	}

	function showOlehRanking() {
		$.ajax({
			url : $("#base-url").val() + 'EC_Auction_itemize/hasilawal',
			// data : {
			// 	NO_TENDER: NO_TENDER,
			// 	NO_BATCH: NO_BATCH
			// },
			type : 'POST',
			dataType : 'html'
		}).done(function(data) {
			$('#hasilawal').html(data);
		}).fail(function() {
		//alert('b');
		// console.log("error");
	}).always(function(data) {
		//alert('c');
		// console.log(data);
	});
}

$(document).ready(function() {

	$(".select2").select2();

	// $('.currency').on('change', function(event) {
 //        var index = $(this).prop('selectedIndex');
 //        // alert(index);
 //        if (index == 0) {
 //            $('.bm').prop('disabled', true);
 //        }
 //        else {
 //            $('.bm').prop('disabled', false);
 //        }
 //    });

 //    $('.currency').trigger('change');

	// $('#currency').change(function() {
	// 	$(".curr").prop('disabled', true);
	// 	if ($(this).is("keyup change")) {
	// 		$(".curr").prop('disabled', false);
	// 	}
	// });

	$('#example').DataTable( {
		"searching": false, 
		"scrollY":        "400px",
		"scrollCollapse": true,
		"paging":         false,
		"info" : false,
	});

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

	$(".btn-hasilawal").on("click", function() {
		$("#hasilall").modal() 
		// id_peserta = $(this).attr('data-id');
		
		$.ajax({
			url: $("#base-url").val() + 'EC_Auction_itemize/hasilawal',
			type: "post",
			dataType: "html",
			success: function (data) {
				// var result = $('<div />').append(data).find('#resultHargaAwal').html();
				$('#hasilawal').html(data);
			},
			error: function (xhr, status) {
				alert("Sorry, there was a problem!");
			},
			complete: function (xhr, status) {
            	//$('#showresults').slideDown('slow')
            }
        });
	})

	$(".btn-hargaawal").on("click", function() {
		$("#tbh-hargaawal").modal() 
		id_peserta = $(this).attr('data-id');
		
		$.ajax({
			url: $("#base-url").val() + 'EC_Auction_itemize/formHargaAwal',
			data: {
				id_peserta: id_peserta
			},
			type: "post",
			dataType: "html",
			success: function (data) {
				// var result = $('<div />').append(data).find('#resultHargaAwal').html();
				$('#resultHargaAwal').html(data);
			},
			error: function (xhr, status) {
				alert("Sorry, there was a problem!");
			},
			complete: function (xhr, status) {
            	//$('#showresults').slideDown('slow')
            }
        });
	})

	$(".btn-upload-hargaawal").on("click", function() {
		// alert('a')
		$("#upload-harga").modal() 
		id_peserta = $(this).attr('data-id');
		$(".id_peserta").val(id_peserta);
	})


	$("#vendor").change(function(){
		var veno = $("#vendor").val();
		$("#kd_vnd").val(veno);

		$.ajax({
			url:base_url+'EC_Auction_itemize/getvendorname',
			method : 'post',
			data : "veno="+veno,
			dataType: 'json',
			success: function(data){
				// alert(data.VENDOR_NAME);
				$("#nama_vnd").val(data.VENDOR_NAME);
			}
		});
		// $("#cek_eproc").val(1);
	})

})
