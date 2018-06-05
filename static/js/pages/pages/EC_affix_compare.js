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

$(document).ready(function() {
	$('#bayangan').hide()
	$(window).scroll(function() {
		if ($(this).scrollTop() > 127) {
			$('#bayangan').show()
			$('#bayangan').css('height', $('.fixed-compare-gbr').height())
			$('#bayangan').css('width', $('.fixed-compare-gbr').width())
			$('.fixed-compare').addClass('fixed');
			$('.fixed-compare-gbr').addClass('fixed-gbr');
			$('#gbr').css('width', $('#isi').width())
			$('.fixed-compare-gbr').css('width', $('#konten').width())
			$('#headh').css('width', $('#konten').width())
		} else {
			$('#bayangan').hide()
			$('.fixed-compare').removeClass('fixed');
			$('.fixed-compare-gbr').removeClass('fixed-gbr');

		}
	});

	$('#isi').scroll(function() {
		$('#label').scrollTop($(this).scrollTop());
	});
	$('#isi').scroll(function() {
		$('#gbr').scrollLeft($(this).scrollLeft());
	});
	console.log($('#tes1').height())
	console.log($('#tes2').height())
	$('#tes2').height($('#tes1').height())
	$('#label1').height($('#tes1').height())

	//setHeight
	var max = 0;
	$(".li-longteks").each(function() {
		if ($(this).height() > max) {
			max = $(this).height();
		}
	});
	$('#label-longteks').height(max);

	var max = 0;
	$(".li-measure").each(function() {
		if ($(this).height() > max) {
			max = $(this).height();
		}
	});
	$('#label-measure').height(max);

	var max = 0;
	$(".li-group").each(function() {
		if ($(this).height() > max) {
			max = $(this).height();
		}
	});
	$('#label-group').height(max);

	var max = 0;
	$(".li-type").each(function() {
		if ($(this).height() > max) {
			max = $(this).height();
		}
	});
	$('#label-type').height(max);

	var max = 0;
	$(".li-vendor").each(function() {
		if ($(this).height() > max) {
			max = $(this).height();
		}
	});
	$('#label-vendor').height(max);

	var max = 0;
	$(".li-principal").each(function() {
		if ($(this).height() > max) {
			max = $(this).height();
		}
	});
	$('#label-principal').height(max);

	var max = 0;
	$(".li-contractno").each(function() {
		if ($(this).height() > max) {
			max = $(this).height();
		}
	});
	$('#label-contractno').height(max);

	var max = 0;
	$(".li-validdate").each(function() {
		if ($(this).height() > max) {
			max = $(this).height();
		}
	});
	$('#label-validprice').height(max);

	var max = 0;
	$(".li-org").each(function() {
		if ($(this).height() > max) {
			max = $(this).height();
		}
	});
	$('#label-org').height(max);

	var max = 0;
	$(".li-plant").each(function() {
		if ($(this).height() > max) {
			max = $(this).height();
		}
	});
	$('#label-plant').height(max);

	var max = 0;
	$(".li-uom").each(function() {
		if ($(this).height() > max) {
			max = $(this).height();
		}
	});
	$('#label-contract').height(max);

	var max = 0;
	$(".li-price").each(function() {
		if ($(this).height() > max) {
			max = $(this).height();
		}
	});
	$('#label-price').height(max);

	var max = 0;
	$(".li-gross").each(function() {
		if ($(this).height() > max) {
			max = $(this).height();
		}
	});
	$('#label-gross').height(max);

	var max = 0;
	$(".li-curr").each(function() {
		if ($(this).height() > max) {
			max = $(this).height();
		}
	});
	$('#label-curr').height(max);

	var max = 0;
	$(".li-tod").each(function() {
		if ($(this).height() > max) {
			max = $(this).height();
		}
	});
	$('#label-tod').height(max);

	var max = 0;
	$(".li-top").each(function() {
		if ($(this).height() > max) {
			max = $(this).height();
		}
	});
	$('#label-top').height(max);

	var max = 0;
	$(".produk").each(function() {
		if ($(this).height() > max) {
			max = $(this).height();
		}
	});
	$(".produk").each(function() {
		$(this).height(max);
	});
	$.ajax({
		url : $("#base-url").val() + 'EC_Ecatalog/get_data_cart/',
		type : 'POST',
		dataType : 'json'
	}).done(function(data) {
		console.log(data);
		$(".jml").text(data.jumlah);
		$(".budget").text(numberWithCommas(data.budget));
		$(".jmlCompare").text(data.compare)

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
	});
});

function numberWithCommas(x) {
	return x == null || x == "0" ? "" : x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

function geser(elm, matno, contract_no, kode) {
	console.log(matno + ' ' + contract_no)
	$.ajax({
		url : $("#base-url").val() + 'EC_Ecatalog/geser/' + matno,
		data : {
			"contract_no" : contract_no,
			"kode" : kode
		},
		type : 'POST',
		dataType : 'json'
	}).done(function(data) {
		//$(".jmlCompare").text(data);
	}).fail(function() {
		// console.log("error");
	}).always(function(data) {
		//console.log('cmp ' + data);
		location.reload(); 
	});
}