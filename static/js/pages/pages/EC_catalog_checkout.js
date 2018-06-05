var curBdg,
    qtyOld,
    contract_no_old,
    contract_no,
    contract_H,
    base_url = $("#base-url").val();

function chk23() {
	$.ajax({
		url : $("#base-url").val() + 'EC_Ecatalog/get_data_checkout/',
		data : {
			"checked" : null
		},
		type : 'POST',
		dataType : 'json'
	}).done(function(data) {
		// console.log(data.data.length);
		$("#goods").empty()
		$("#totall").text('Rp ' + numberWithCommas(data.total))
		$("#totalBiaya").text('Rp ' + numberWithCommas(data.total))
		var tottt = data.total

		$(".budget").attr('title', 'cart: ' + numberWithCommas(tottt))
		$('.budget').tooltip();

		$("#budgett").text('Rp ' + numberWithCommas(curBdg));
		$("#hid_current_budget").val(data.budget);
		$("#totalsisa").text('Rp ' + numberWithCommas(curBdg - tottt))
		if ((curBdg - tottt) < 0) {
			console.log('minus')
			$('#totalsisa').append(' <a href="#javascript:void(0)">(Exceeded)</a>')
			$('#btn_confirm').removeClass("btn-success").addClass("btn-danger").addClass("disabled");
			$('#btn_confirm').attr('data-target', '#');
		} else {
			$("#totalsisa").text('Rp ' + numberWithCommas(curBdg - tottt))
			$('#btn_confirm').removeClass("btn-danger").addClass("btn-success").removeClass("disabled");
			$('#btn_confirm').attr('data-target', '#cnfrm');
		}
		/************************hard code enable confirm button********************************/
		// $('#btn_confirm').toggleClass("btn-danger btn-success").removeClass("disabled");
		/************************^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^********************************/
		var plant = null
		contract_no = 0
		var countSameCon = 0;
		contract_H = 0

		for (var i = 0; i < data.data.length; i++) {
			disable = ''
			act = 'cancelcart' 
			btn = 'Hold'
			clr = 'danger'
			qtyOld = data.data[i][17]

			qty = '<div class="row"><div class="input-group col-md-11">'
			qty += '<i class="input-group-addon tangan" data-avl="' + data.data[i][6] + '" onclick="minqtycart(this,\'' + data.data[i][15] + '\')"><span class="glyphicon glyphicon-minus" aria-hidden="true"></span></i>'
			qty += '<input type="number" value="' + data.data[i][17] + '" data-id="' + data.data[i][15] + '" data-avl="' + data.data[i][6] + '" data-old="' + data.data[i][17] + '" class="form-control text-center qtyy">'
			qty += '<i class="input-group-addon tangan" data-avl="' + data.data[i][6] + '" onclick="plsqtycart(this,\'' + data.data[i][15] + '\')"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></i>'
			qty += '<span class="input-group-addon">' + data.data[i][13] + '</span>'
			qty += '</div></div><br>'
			del = ''
			chk = ' checked'
			header = ''
			// teks = '<div class="row chrt' + data.data[i][15] + '" style=" margin:3px; border-bottom: 1px solid #ccc;">'
			if (contract_H != data.data[i][5]) {
				contract_H = data.data[i][5]
				header = '<div class="row" style="padding:3px;">Nomor Kontrak: ' + contract_H + '</div>'
				teks = '<div class="row chrt' + data.data[i][15] + '" style=" margin:3px; border-top: 1px solid #ccc;">'
			} else {
				teks = ('<div class="row chrt' + data.data[i][15] + '" style=" margin:3px;">')
			}
			if (data.data[i][16] == '8') {
				disable = ' disableddiv'
				act = 'addcart'
				btn = 'Re-assign'
				clr = 'default'
				qty = ''
				chk = ''
				del = '<a href="javascript:void(0)" onclick="deletecart(this,\'' + data.data[i][15] + '\')" class="btn btn-danger form-control" >Remove</a><p></p>'
			} else {
				contract_no = data.data[i][5]
				countSameCon++
			}
			if (data.data[i][11].substring(0, 1) == 3) {
				plant = 'Semen Padang';
			} else if (data.data[i][11].substring(0, 1) == 4) {
				plant = 'Semen Tonasa';
			} else if (data.data[i][11].substring(0, 1) == 5) {
				plant = 'Semen Gresik';
			} else if (data.data[i][11].substring(0, 1) == 7) {
				plant = 'KSO';
			} else if (data.data[i][11].substring(0, 1) == 2) {
				plant = 'Holding SMI';
			}
			if (i == data.data.length - 1) {
				teks = ('<div class="row chrt' + data.data[i][15] + '"  style=" margin:3px; border-bottom: 1px solid #ccc;">')
			}
			teks += header
			teks += '<div class="row" style=" margin:10px; padding:3px;">'
			teks += '<div class="col-md-2' + disable + '" style="  padding-left: 5px;">'
			teks += '<a href="javascript:void(0)" data-backdrop="true" data-toggle="modal" data-target="#modaldetail" data-produk="' + data.data[i][1] + '"><img src="' + $("#base-url").val() + $("#UPLOAD_PATH").val() + "EC_material_strategis/" + data.data[i][12] + '" class="img-responsive"></a>'
			teks += '</div>' + '<div class="col-md-3' + disable + '" style="  padding-left: 35px;">'
			teks += '<div class="row" style="font-size:11px">Kategori: (kategori)</div>'
			teks += '<div class="row" style="font-size:11px">' + plant + '-' + data.data[i][11]
			teks += '</div>' + '<div class="row" style="font-size:18px"><strong><a href="javascript:void(0)" data-backdrop="true" data-toggle="modal" data-target="#modaldetail" data-produk="' + data.data[i][1] + '">' + data.data[i][2] + '</a></strong></div>'
			teks += '<div class="row" style="font-size:14px"><a href="javascript:void(0)" data-backdrop="true" data-toggle="modal" data-target="#modaldetail" data-produk="' + data.data[i][1] + '">' + data.data[i][1] + '</a></div>' + '</div>'
			teks += '<div class="col-md-4' + disable + '" style="padding-left: 35px;">' + '<div class="row" style="font-size:14px">Harga: <span id="lblprice"><strong>Rp. ' + numberWithCommas(data.data[i][3]) + '</strong></span></div>'
			teks += '<div class="row" style="font-size:12px">Kuantitas kontrak: ' + numberWithCommas(data.data[i][6]) + ' ' + data.data[i][13] + '</div>'
			teks += '<div class="row" style="font-size:12px">Nomor kontrak: ' + data.data[i][5] + '</div>'
			teks += '<div class="row" style="font-size:12px">Penyedia: <a href="javascript:void(0)" data-backdrop="true" data-toggle="modal" data-target="#modalpenyedia" data-vendor="' + data.data[i][14] + '">' + data.data[i][7] + '</a></div>'
			teks += '<div class="row" style="font-size:12px">Principal: <a href="javascript:void(0)" data-backdrop="true" data-toggle="modal" data-target="#modalprincipal" data-principal="' + data.data[i][8] + '">' + data.data[i][8] + '</a></div>'
			teks += '<div class="row" style="font-size:12px">Tanggal Berlaku: ' + data.data[i][9].substring(6) + '/' + data.data[i][9].substring(4, 6) + '/' + data.data[i][9].substring(0, 4) + ' - ' + data.data[i][10].substring(6) + '/' + data.data[i][10].substring(4, 6) + '/' + data.data[i][10].substring(0, 4) + '</div>'
			teks += '</div>' + '<div class="col-md-3">' + qty + '<form class="form-horizontal">'
			// teks += del + '<a href="javascript:void(0)" onclick="' + act + '(this,\'' + data.data[i][15] + '\')" class="btn btn-' + clr + ' form-control" >' + btn + '</a>'
			teks += del + '<div class="col-md-6 col-md-offset-3"><input type="checkbox" ' + chk + ' onchange="' + act + '(this,\'' + data.data[i][15] + '\')" /></div>'
			teks += '</form>' + '</div>' + '</div>' + '</div>'
			$("#goods").append(teks)

		}
		// $("#myModalLabel").text('Konfirmasi Crate PO dengan ' + countSameCon + ' tipe barang berbeda')

		// $("#myModalLabel").text('Tiap nomer PO terbit berdasarkan nomer kontrak barang yang sama')
		$("#btnCofirmmm").show()
		jml = 0,
		cntrk = 0;
		contract_no = "-"
		for (var i = 0; i < data.data.length; i++) {
			if (data.data[i][16] == '0') {
				jml++
				if (contract_no != data.data[i][5]) {
					cntrk++
					contract_no = data.data[i][5]
					// console.log('minus')
					// $('#btn_confirm').toggleClass("btn-danger btn-success").addClass("disabled");
					// $("#myModalLabel").text('Tiap nomer PO terbit berdasarkan nomer kontrak barang yang sama')
					// $("#btnCofirmmm").hide()
				}
			}//status

		}
		$("#jmlPO").text(cntrk)
		$("#jmlBrg").text(jml)
		if (countSameCon == 0)
			$('#btn_confirm').removeClass("btn-success").addClass("btn-danger").addClass("disabled");
	}).fail(function() {
		console.log("error");
	}).always(function(data) {
		//console.log(data);
		$(".qtyy").keyup(function() {
			that=this
			setTimeout(function() {
				updQtycart(that, $(that).val(), $(that).data('id'))
			}, 1500);
		});
	});
}

function numberWithCommas(x) {
	return x == null || x == "0" ? "" : x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

function voidd() {

}

function confirm(elm, id) {
	console.log(contract_no)
	$.ajax({
		url : $("#base-url").val() + 'EC_Ecatalog/confirm/',
		type : 'POST',
		dataType : 'json'
	}).done(function(data) {
		console.log(data);
		$('#cnfrm').modal('hide')
	}).fail(function(data) {
		console.log("error");
		// $("#pocreated").text(data['RETURN'][0]['MESSAGE'])
	}).always(function(data) {
		console.log(data)
		// $("#pocreated").text(data)
		$('#cnfrm').modal('hide')

		$('#tbodyPO').empty()
		po = "-"
		for (var i = 0; i < data.length; i++) {
			po = (data[i].PO_NO) != po ? (data[i].PO_NO) : ""
			$('#tbodyPO').append('<tr></tr>')
			$('#tbodyPO tr:eq(' + i + ')').append('<td>' + (po == "null" ? "gagal" : po) + '</td>')
			$('#tbodyPO tr:eq(' + i + ')').append('<td>' + (data[i].MAKTX) + '   (' + (data[i].MATNO) + ')</td>')
			$('#tbodyPO tr:eq(' + i + ')').append('<td>' + (data[i].curr) + ' ' + numberWithCommas(data[i].netprice) + '</td>')
		};

		$('#modalPO').modal('show')
		chk23();
	});

}

function updQtycart(elm, qty, id) {
	if (qty > 0 && qty.search(/[A-Za-z]/g) == -1)//
		if (qty < $(elm).data('avl'))
			$.ajax({
				url : $("#base-url").val() + 'EC_Ecatalog/updQtycart/' + id,
				data : {
					"qty" : qty
				},
				type : 'POST',
				dataType : 'json'
			}).done(function(data) {
				// console.log('hide ' + data);
			}).fail(function() {
				console.log("error");
			}).always(function(data) {
				chk23();
			});
		else {
			$(elm).val($(elm).data('old'))
			alert('Maksimal jumlah order: ' + $(elm).data('avl') + ' !!')
		}
	else {
		alert('Minimal 1 dan hanya angka!!')
		$(elm).val($(elm).data('old'))
	}
}

function deletecart(elm, id) {
	$.ajax({
		url : $("#base-url").val() + 'EC_Ecatalog/deletecart/' + id,
		type : 'POST',
		dataType : 'json'
	}).done(function(data) {
		console.log('hide ' + data);
	}).fail(function() {
		console.log("error");
	}).always(function(data) {
		chk23();
	});
}

function minqtycart(elm, id) {
	if ($(elm).next().val() > 1)
		$.ajax({
			url : $("#base-url").val() + 'EC_Ecatalog/minqtycart/' + id,
			type : 'POST',
			dataType : 'json'
		}).done(function(data) {
			console.log('hide ' + data);
		}).fail(function() {
			console.log("error");
		}).always(function(data) {
			chk23();
		});

}

function plsqtycart(elm, id) {
	// console.log($(elm).prev().val() + "<" + $(elm).data('avl'))
	if ($(elm).prev().val() < $(elm).data('avl'))
		$.ajax({
			url : $("#base-url").val() + 'EC_Ecatalog/plsqtycart/' + id,
			type : 'POST',
			dataType : 'json'
		}).done(function(data) {
			console.log('hide ' + data);
		}).fail(function() {
			console.log("error");
		}).always(function(data) {
			chk23();
		});
	else
		alert('Maksimal jumlah order: ' + $(elm).data('avl') + ' !!')
}

function addcart(elm, id) {
	$.ajax({
		url : $("#base-url").val() + 'EC_Ecatalog/readdcart/' + id,
		type : 'POST',
		dataType : 'json'
	}).done(function(data) {
		console.log('hide ' + data);
	}).fail(function() {
		console.log("error");
	}).always(function(data) {
		chk23();
	});
}

function cancelcart(elm, id) {
	$.ajax({
		url : $("#base-url").val() + 'EC_Ecatalog/cancelcart/' + id,
		type : 'POST',
		dataType : 'json'
	}).done(function(data) {
		console.log('hide ' + data);
	}).fail(function() {
		console.log("error");
	}).always(function(data) {
		chk23();
	});
}


$(document).ready(function() {
	$.ajax({
		url : $("#base-url").val() + 'EC_Ecatalog/get_data_cart/',
		type : 'POST',
		dataType : 'json'
	}).done(function(data) {
		console.log(data);
		$(".jml").text(data.jumlah);
		$(".budget").text(numberWithCommas(data.budget));
		$(".jmlCompare").text(data.compare)
		curBdg = data.budget;
		$(".budget").attr('title', 'cart: ' + numberWithCommas(data.total))
		$('.budget').tooltip();

		$('#tbody').empty()
		$('#tbody').append('<tr class="success"></tr>')
		$('#tbody tr').append('<td>' + (data.cost_center) + '</td>')
		$('#tbody tr').append('<td>' + (data.cost_center_desc) + '</td>')
		$('#tbody tr').append('<td>&nbsp;</td>')
		$('#tbody tr').append('<td>&nbsp;</td>')
		$('#tbody tr').append('<td>' + numberWithCommas(data.current_budget) + '</td>')
		$('#tbody tr').append('<td>' + numberWithCommas(data.commit_budget).replace('-', '') + '</td>')
		$('#tbody tr').append('<td>' + numberWithCommas(data.actual_budget).replace('-', '') + '</td>')
		$('#tbody tr').append('<td>' + numberWithCommas(data.budget) + '</td>')
		$('#tbody tr').append('<td>' + numberWithCommas(data.total) + '</td>')

		for (var i = 0; i < data.detailActualCommit.length; i++) {
			$('#tbody').append('<tr></tr>')
			$('#tbody tr:eq(' + (i + 1) + ')').append('<td> </td>')
			$('#tbody tr:eq(' + (i + 1) + ')').append('<td> </td>')
			$('#tbody tr:eq(' + (i + 1) + ')').append('<td>' + (data.detailActualCommit[i].glItem) + '</td>')
			$('#tbody tr:eq(' + (i + 1) + ')').append('<td>' + numberWithCommas(data.detailActualCommit[i].glDesc.SHORT_TEXT) + '</td>')
			$('#tbody tr:eq(' + (i + 1) + ')').append('<td></td>')
			$('#tbody tr:eq(' + (i + 1) + ')').append('<td>' + numberWithCommas(data.detailActualCommit[i].budgetCommit).replace('-', '') + '</td>')
			$('#tbody tr:eq(' + (i + 1) + ')').append('<td>' + numberWithCommas(data.detailActualCommit[i].budgetActual).replace('-', '') + '</td>')
			$('#tbody tr:eq(' + (i + 1) + ')').append('<td></td>')
			$('#tbody tr:eq(' + (i + 1) + ')').append('<td></td>')
		};

		if (window.location.pathname.indexOf('checkout') > -1) {
			$("#budgett").text('Rp ' + numberWithCommas(data.budget));
			$("#hid_current_budget").val(data.budget);
		}

	}).fail(function() {
		// console.log("error");
	}).always(function(data) {
		//console.log(data);
		// });
		chk23();
	});

	$('label.tree-toggler').click(function() {
		$(this).parent().children('ul.tree').toggle(300);
	});
	$('#checkbox1').change(function() {
		if ($(this).is(":checked")) {
			var returnVal = confirm("Are you sure?");
			$(this).attr("checked", returnVal);
		}
		$('#textbox1').val($(this).is(':checked'));
	});
});

$('#modaldetail').on('show.bs.modal', function(event) {
	var button = $(event.relatedTarget)
	var MATNR = button.data('produk')
	//var id = button.data('id')
	//var modal = $(this)
	$.ajax({
		url : $("#base-url").val() + 'EC_Strategic_material/getDetail/' + MATNR,
		type : 'POST',
		dataType : 'json'
	}).done(function(data) {
		// console.log(data);
		$("#detail_MATNR").text(data.MATNR[0].MATNR == null ? "-" : data.MATNR[0].MATNR);
		$("#detail_MAKTX").text(data.MATNR[0].MAKTX == null ? "-" : data.MATNR[0].MAKTX);
		$("#detail_LNGTX").text(data.MATNR[0].LNGTX == null ? "-" : data.MATNR[0].LNGTX);
		$("#detail_MEINS").text(data.MATNR[0].MEINS == null ? "-" : data.MATNR[0].MEINS);
		$("#detail_MATKL").text(data.MATNR[0].MATKL == null ? "-" : data.MATNR[0].MATKL);
		$("#detail_MTART").text(data.MATNR[0].MTART == null ? "-" : data.MATNR[0].MTART);
		$("#detail_created").text(data.MATNR[0].ERNAM + ", " + data.MATNR[0].ERSDA.substring(6) + "-" + data.MATNR[0].ERSDA.substring(4, 6) + "-" + data.MATNR[0].ERSDA.substring(0, 4));
		if (data.MATNR[0].PICTURE != null || data.MATNR[0].DRAWING != null) {
			$("#pic").attr('src', $("#base-url").val() + $("#UPLOAD_PATH").val() + "EC_material_strategis/" + data.MATNR[0].PICTURE);
			$("#draw").attr('src', $("#base-url").val() + $("#UPLOAD_PATH").val() + "EC_material_strategis/" + data.MATNR[0].DRAWING);
		} else {
			$("#pic").attr('src', $("#base-url").val() + $("#UPLOAD_PATH").val() + "EC_material_strategis/default_post_img.png");
			$("#draw").attr('src', $("#base-url").val() + $("#UPLOAD_PATH").val() + "EC_material_strategis/default_post_img.png");
		}
	}).fail(function() {
		// console.log("error");
	}).always(function(data) {
		//console.log(data);
	});

	//$("#Category").val('');
	//$("#CODE_Category").val('');
	//console.log('nama: ', nama);
	//loadTableBPA(id);
});

$('#modalpenyedia').on('show.bs.modal', function(event) {
	var button = $(event.relatedTarget)
	var vendor_no = button.data('vendor')
	//var id = button.data('id')
	//var modal = $(this)
	$.ajax({
		url : $("#base-url").val() + 'EC_Ecatalog/getVendorNo/' + vendor_no,
		type : 'POST',
		dataType : 'json'
	}).done(function(data) {
		// console.log(data);
		$("#VENDOR_NAME").text(data[0].VENDOR_NAME == null ? "-" : data[0].VENDOR_NAME);
		$("#ADDRESS").text((data[0].ADDRESS_STREET == null ? "-" : data[0].ADDRESS_STREET) + ' ' + (data[0].NAMA == null ? "" : data[0].NAMA));
		$("#ADDRESS_COUNTRY").text(data[0].COUNTRY_NAME == null ? "-" : data[0].COUNTRY_NAME);
		$("#EMAIL_ADDRESS").text(data[0].EMAIL_ADDRESS == null ? "-" : data[0].EMAIL_ADDRESS);
		$("#ADDRESS_WEBSITE").text(data[0].ADDRESS_WEBSITE == null ? "-" : data[0].ADDRESS_WEBSITE);
		$("#NPWP_NO").text(data[0].NPWP_NO == null ? "-" : data[0].NPWP_NO);
		$("#CONTACT_NAME").text(data[0].CONTACT_NAME == null ? "-" : data[0].CONTACT_NAME);
		$("#CONTACT_PHONE_NO").text(data[0].CONTACT_PHONE_NO == null ? "-" : data[0].CONTACT_PHONE_NO);
		$("#CONTACT_EMAIL").text(data[0].CONTACT_EMAIL == null ? "-" : data[0].CONTACT_EMAIL);
	}).fail(function() {
		// console.log("error");
	}).always(function(data) {
		//console.log(data);
	});

	//$("#Category").val('');
	//$("#CODE_Category").val('');
	//console.log('nama: ', nama);
	//loadTableBPA(id);
});

$('#modalprincipal').on('show.bs.modal', function(event) {
	var button = $(event.relatedTarget)
	var pc_code = button.data('principal')
	//var id = button.data('id')
	//var modal = $(this)
	$.ajax({
		url : $("#base-url").val() + 'EC_Ecatalog/getPrincipal/' + pc_code,
		type : 'POST',
		dataType : 'json'
	}).done(function(data) {
		// console.log(data);
		$("#PC_NAME").text(data.principal[0].PC_NAME == null ? "-" : data.principal[0].PC_NAME);
		$("#LOGO").attr('src', $("#base-url").val() + $("#UPLOAD_PATH").val() + "EC_principal_manufacturer/" + data.principal[0].LOGO);
		$("#ADDRESS_P").text(data.principal[0].ADDRESS == null ? "-" : data.principal[0].ADDRESS);
		$("#COUNTRY").text(data.principal[0].COUNTRY == null ? "-" : data.principal[0].COUNTRY);
		$("#MAIL").text(data.principal[0].MAIL == null ? "-" : data.principal[0].MAIL);
		$("#WEBSITE").text(data.principal[0].WEBSITE == null ? "-" : data.principal[0].WEBSITE);
		$("#PHONE").text(data.principal[0].PHONE == null ? "-" : data.principal[0].PHONE);
		$("#FAX").text(data.principal[0].FAX == null ? "-" : data.principal[0].FAX);
		$("#divPartner").empty();
		for (var i = 0; i < data.partner.length; i++) {
			teks = '<div class="row">'
			teks += '<div class="col-lg-3 text-center">' + (data.partner[i].VENDOR_NAME == null ? "-" : data.partner[i].VENDOR_NAME) + '</div>'
			teks += '<div class="col-lg-1 text-center">' + (data.partner[i].ADDRESS_COUNTRY == null ? "-" : data.partner[i].ADDRESS_COUNTRY) + '</div>'
			teks += '<div class="col-lg-2 text-center">' + (data.partner[i].ADDRESS_WEBSITE == null ? "-" : data.partner[i].ADDRESS_WEBSITE) + '</div>'
			teks += '<div class="col-lg-4 text-center">' + (data.partner[i].EMAIL_ADDRESS == null ? "-" : data.partner[i].EMAIL_ADDRESS) + '</div>'
			teks += '<div class="col-lg-2 text-center">' + (data.partner[i].ADDRESS_PHONE_NO == null ? "-" : data.partner[i].ADDRESS_PHONE_NO) + '</div>'
			teks += '</div>'
			$("#divPartner").append(teks)
		}
	}).fail(function() {
		// console.log("error");
	}).always(function(data) {
		//console.log(data);
	});

	//$("#Category").val('');
	//$("#CODE_Category").val('');
	//console.log('nama: ', nama);
	//loadTableBPA(id);
});
