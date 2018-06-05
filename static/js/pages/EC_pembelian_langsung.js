var range_harga = ['-', '-'],
    base_url = $("#base-url").val(),
    kodeParent = $("#kodeParent").val(),
    searctTag = $("#tag").val(),
    urlll = '/get_data/',
    listMode = 1,
    compare = [],
    limitMin = 0, 
    limitMax = 12,
    pageMax = 1,
    pageMaxOld = 0,
    mode = "list",
    compareCntrk = []; 
$(document).ready(function(){
	console.log('mulai');
	$("#tag").val('');
	loadTree();

	$('.date').datepicker({
        format: 'dd-mm-yyyy',
        defaultDate: new Date(),
        autoclose: true,
        todayHighlight: true
    }).on('change', function(){
        $('.datepicker').hide();
    }).on('show.bs.modal', function(event) {
        // prevent datepicker from firing bootstrap modal "show.bs.modal"
        event.stopPropagation();
    });

	$('label.tree-toggler').click(function() {
		$(this).parent().children('ul.tree').toggle(300);
	});
	
	$.ajax({
		url : $("#base-url").val() + 'EC_Ecatalog_Marketplace/get_data_cart/',
		type : 'POST',
		dataType : 'json'
	}).done(function(data) {
		console.log(data.jumlah);
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
			// $("#budgett").text('Rp ' + numberWithCommas(data.budget));
			$("#hid_current_budget").val(data.budget);
		}
		budget = data.budget
		$("#budgett").text($("#curre").val() + " " + numberWithCommas(data.budget));
		$("#totalsisa").text($("#curre").val() + " " + numberWithCommas(data.budget-$("#harga1").val()));
		$("#sisa").val(data.budget-$("#harga1").val());
		//$("#buyyy").removeAttr('disabled')
	}).fail(function() {
		// console.log("error");
	}).always(function(data) {
		//console.log(data);
	});
	/***********************************************/
	if (window.location.pathname.indexOf('listCatalog') > -1) {
		$.ajax({
			url : $("#base-url").val() + 'EC_Ecatalog_Marketplace/rangeHarga/ssssssssssss',
			type : 'POST',
			dataType : 'json'
		}).done(function(data) {
			// console.log('range ' + data[0].MAX + "-" + data[0].MIN);
			$("#ex2").slider({
				min : parseInt(data[0].MIN),
				max : parseInt(data[0].MAX),
				value : [parseInt(data[0].MAX / 4), parseInt(data[0].MIN / 4)],
				step : 10
			})
			// $("#ex2").data('slider').setValue([data[0].MAX, data[0].MIN])
		}).fail(function() {
			// console.log("error");
		}).always(function(data) {
			//console.log(data);
		});

		$("#ex2").on("slideStop", function(slideEvt) {
			$("#txtharga").val(numberWithCommas(slideEvt.value[0]) + " - " + numberWithCommas(slideEvt.value[1]))
			// console.log(slideEvt.value)
		});
		$("#btnTampilkan").on("click", function() {
			range_harga = $("#ex2").data('slider').getValue()
			// console.log($("#ex2").data('slider').getValue())
			base_url = $("#base-url").val()
			// kodeParent = $("#kodeParent").val()
			// searctTag = $("#tag").val();
			loadDataList()
		})
		$("#removeTAG").on("click", function() {
			$("#txtsearch").val('');
		})
	}

	/***********************************************/
	$('#listmode').on('change', function(e) {
		var optionSelected = $("option:selected", this);
		listMode = this.value;
		// console.log(listMode)
		if (listMode == 2) {
			$(location).attr('href', $("#base-url").val() + 'EC_Ecatalog_Marketplace/listCatalogLsgs')
		} else if (listMode == 1) {
			$(location).attr('href', $("#base-url").val() + 'EC_Ecatalog_Marketplace/listCatalog')
		} else if (listMode == 3) {
			$(location).attr('href', $("#base-url").val() + 'EC_Ecatalog_Marketplace/listCatalogLsgs')
		}
	});

	

	/***********************************************/
	$(".qtyy").val('1')
	$("#buyyy").prop('disabled', false);
	harga = $("#harga1").val()
	$(".qtyy").change(function() {
		if ($(this).val() > 0 && $(this).val().search(/[A-Za-z]/g) == -1) {
		$("#buyyy").prop('disabled', false);
			// console.log('Rp ' + ($(this).val() +" "+ harga))
			$("#totall").text($("#curre").val() + " " + numberWithCommas($(this).val() * harga))
			$("#totalsisa").text($("#curre").val() + ' ' + numberWithCommas(budget - ($(this).val() * harga)));
			$("#sisa").val(budget - ($(this).val() * harga))
		}else if($(this).val() == 0){
			$(".qtyy").val('1')
		}
	});

	$(".qtyy").keyup(function() {
		// console.log($(this).val()+" "+harga+" "+budget)
		if ($(this).val() > 0 && $(this).val().search(/[A-Za-z]/g) == -1) {
		$("#buyyy").prop('disabled', false);
			$("#totall").text($("#curre").val() + " " + numberWithCommas($(this).val() * harga))
			$("#totalsisa").text($("#curre").val() + ' ' + numberWithCommas(budget - ($(this).val() * harga)));
			$("#sisa").val(budget - ($(this).val() * harga))
		}else if($(this).val() == 0){
			$(".qtyy").val('1')
		}
	});

	

});

function loadDataList(){
	$('.breadcrumb').empty();
	$('.breadcrumb').append('<li><a href="' + base_url + 'EC_Ecatalog_Marketplace"><span style="color:#e74c3c;"  class="glyphicon glyphicon-home" aria-hidden="true"></span></a><a onclick="setCode(\'-\',this)" href="javascript:void(0)">&nbsp;&nbsp;Home</a></li>');
	if (kodeParent != null && kodeParent != '-' && range_harga[0] == '-' && kodeParent != ''){
		urlll = '/get_data_category/' + kodeParent;
		splitt = kodeParent.split("-");
		teks = splitt[0];
		for (var i = 0; i < splitt.length; i++){
			$(".lvl" + (i + 1)).each(function(){
				if ($(this).data('kode') == teks) {
					$('.breadcrumb').append('<li><a href="javascript:void(0)"  onclick="setCode(\'' + $(this).data('kode') + '\',this)" data-id="' + $(this).data('id') + '" data-kode="' + $(this).data('kode') + '" data-desc="' + $(this).data('desc') + '" >' + $(this).data('desc') + '</a></li>');
				}
			});
			teks += ('-' + splitt[i + 1]);
		};
		getCategoryBread(kodeParent);
	}
	if (searctTag != null && searctTag != '-' && searctTag != ''){
		urlll = '/get_data_tag/' + searctTag;
		if ($('.breadcrumb').text().indexOf('Search') < 0){
			$('.breadcrumb').empty();
			$('.breadcrumb').append('<li><span style="color:#e74c3c;"  class="glyphicon glyphicon-home" aria-hidden="true"></span><a onclick="setCode(\'-\',this)" href="javascript:void(0)">&nbsp;&nbsp;Home</a></li>');
			$('.breadcrumb').append('<li><a href="javascript:void(0)">Filter Search</a></li>');
		}
	}
	if (range_harga != null && range_harga[0] != '-'){
		urlll = '/get_data_harga/' + kodeParent;
		splitt = kodeParent.split("-");
		teks = splitt[0];
		for (var i = 0; i < splitt.length; i++) {
			$(".lvl" + (i + 1)).each(function() {
				if ($(this).data('kode') == teks) {
					$('.breadcrumb').append('<li><a href="javascript:void(0)"  onclick="setCode(\'' + $(this).data('kode') + '\',this)" data-id="' + $(this).data('id') + '" data-kode="' + $(this).data('kode') + '" data-desc="' + $(this).data('desc') + '" >' + $(this).data('desc') + '</a></li>')
				}
			});
			teks += ('-' + splitt[i + 1]);
		};
		$('.breadcrumb').append('<li><a href="javascript:void(0)">Filter Harga</a></li>');
		getCategoryBread(kodeParent);
	}

	$.ajax({
		url : $("#base-url").val() + 'EC_Ecatalog_Marketplace' + urlll,
		data : {
			"min" : range_harga[0],
			"max" : range_harga[1],
			"limitMin" : limitMin,
			"limitMax" : limitMax,
			"listMode" : listMode
		},
		type : 'POST',
		dataType : 'json'
	}).done(function(data) {
		console.log(data);
		// console.log(limitMin + " " + limitMax);
		var plant = null;
		//limitMin < pageMax
		// if (limitMin < pageMax) {
		$('.pagination').empty()
		pageMax = Math.ceil(data.page / 12)
		pageMaxOld = (pageMaxOld == 0) ? pageMax : pageMaxOld
		if (pageMax != pageMaxOld) {
			limitMin = 0
			pageMaxOld = 0
			loadDataList()
			return ''
		} else {
			pageMaxOld = pageMax
		}
		$('.pagination').append('<li><a href="javascript:paginationPrev(this)" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>')
		for (var i = 0; i < Math.ceil(data.page / 12); i++) {
			$('.pagination').append('<li class="' + (i == (limitMin / 12) ? "active" : "") + '"><a href="javascript:pagination(this,' + (i * 12) + ',' + ((i + 1) * 12) + ')">' + (i + 1) + '</a></li>')
		}
		$('.pagination').append('<li><a href="javascript:paginationNext(this)" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>')

		$("#divAttributes").empty()
		if (data.data.length == 0)
			$("#divAttributes").append('<div class="row text-center">Data Tidak Ditemukan!!</div>')
		else
			for (var i = limitMin; i < data.data.length; i++) {
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

				var color = null;
				//var datenow = new Date();
				var today = new Date();
				var dd = today.getDate();
				var mm = today.getMonth() + 1;
				//January is 0!
				var yyyy = today.getFullYear();

				if (dd < 10) {
					dd = '0' + dd;
				}

				if (mm < 10) {
					mm = '0' + mm;
				}

				var now = yyyy + '-' + mm + '-' + dd;
				//document.write(today);
				//console.log(a);
				var startdate = data.data[i][9].substring(0, 4) + '-' + data.data[i][9].substring(4, 6) + '-' + data.data[i][9].substring(6);
				var enddate = data.data[i][10].substring(0, 4) + '-' + data.data[i][10].substring(4, 6) + '-' + data.data[i][10].substring(6);
				// console.log(new Date(startdate).getTime());
				//console.log(new Date(startdate).getTime());

				if (new Date(startdate).getTime() > new Date(now).getTime() && new Date(enddate).getTime() > new Date(now).getTime()) {
					color = "blue";
				} else if (new Date(startdate).getTime() < new Date(now).getTime() && new Date(enddate).getTime() <= new Date(now).getTime()) {
					color = "red";
				} else {
					color = "green";
				}

				if (mode == 'list') {
					if (i == data.data.length - 1) {
						teks = ('<div class="row" style=" margin:3px;">')
					} else {
						teks = '<div class="row" style=" margin:3px; border-bottom: 1px solid #ccc;">'
					}
					teks += ('<div class="row" style=" margin:3px; padding:3px;">')
					teks += ('<div class="col-md-2" style="  padding-left: 5px;">')
					teks += ('<a href="javascript:void(0)" data-backdrop="true" data-toggle="modal" data-target="#modaldetail" data-produk="' + data.data[i][1] + '">')
					teks += ('<img src="' + $("#base-url").val() + $("#UPLOAD_PATH").val() + "EC_material_strategis/" + data.data[i][12] + '" class="img-responsive"></a>')
					teks += ('</div>' + '<div class="col-md-4" style="  padding-left: 35px;">' + '<div class="row" style="font-size:11px">Kategori: <strong>' + data.data[i][16] + '</strong></div>')

					teks += ('<div class="row" style="font-size:18px">')
					teks += ('<strong><a href="javascript:void(0)" data-backdrop="true" data-toggle="modal" data-target="#modaldetail" data-produk="' + data.data[i][1] + '">' + data.data[i][2] + '</a></strong></div>')
					teks += ('<div class="row" style="font-size:14px"><a href="javascript:void(0)" data-backdrop="true" data-toggle="modal" data-target="#modaldetail" data-produk="' + data.data[i][1] + '">' + data.data[i][1] + '</a></div>')
					teks += ('</div>' + '<div class="col-md-4" style="padding-left: 35px;">')
					teks += ('<div class="row" style="font-size:14px">Harga: <span id="lblprice"><strong>' + data.data[i][15] + ' ' + numberWithCommas(data.data[i][3]) + '</strong></span></div>')
					teks += ('<div class="row" style="font-size:11px">' + plant + '-' + data.data[i][11] + '</div>')
					teks += ('<div class="row" style="font-size:11px">' + data.data[i][17] + '&nbsp' + data.data[i][18] + '</div>')
					teks += ('<div class="row" style="font-size:12px">Open Kuantitas: ' + numberWithCommas(data.data[i][6]) + ' ' + data.data[i][13] + '</div>')
					teks += ('<div class="row" style="font-size:12px">Nomor kontrak: ' + data.data[i][5] + '</div>')
					teks += ('<div class="row" style="font-size:12px">Penyedia: <a href="javascript:void(0)" data-backdrop="true" data-toggle="modal" data-target="#modalpenyedia" data-vendor="' + data.data[i][14] + '">' + data.data[i][7] + '</a></div>')
					teks += ('<div class="row" style="font-size:12px">Principal: <a href="javascript:void(0)" data-backdrop="true" data-toggle="modal" data-target="#modalprincipal" data-principal="' + data.data[i][8] + '">' + data.data[i][20] + '</a></div>')
					teks += ('<div class="row" style="font-size:12px; color:' + color + '"><strong>Tanggal Berlaku: ' + data.data[i][9].substring(6) + '/' + data.data[i][9].substring(4, 6) + '/' + data.data[i][9].substring(0, 4) + ' - ' + data.data[i][10].substring(6) + '/' + data.data[i][10].substring(4, 6) + '/' + data.data[i][10].substring(0, 4) + '</strong></div>')
					teks += ('</div>' + '<div class="col-md-2">' + '<form class="form-horizontal">' )
					// teks += ('<a href="' + base_url + 'EC_Ecatalog_Marketplace/detail_prod/' + data.data[i][5] + '/' + data.data[i][1] + '" style="font-size:12px;box-shadow: 1px 1px 1px #ccc"  class="btn btn-primary form-control beli" onclick="buyOneCheck(this,\'' + data.data[i][5] + '\',\'' + data.data[i][1] + '\',\'' + data.data[i][19] + '\')"><i class="glyphicon glyphicon-usd" ></i>&nbsp&nbspBuy</a>' )
					teks += ('<a href="javascript:void(0)" style="font-size:12px;box-shadow: 1px 1px 1px #ccc"  class="btn btn-primary form-control beli" onclick="buyOneCheck(this,\'' + data.data[i][5] + '\',\'' + data.data[i][1] + '\',\'' + data.data[i][19] + '\')"><i class="glyphicon glyphicon-usd" ></i>&nbsp&nbspBuy</a>' )
					teks += ('<p></p><a href="javascript:void(0)" style="font-size:12px;padding: 5px;box-shadow: 1px 1px 1px #ccc" class="btn btn-info form-control beli"  onclick="addCart(this,\'' + data.data[i][1] + '\',\'' + data.data[i][5] + '\',\'' + data.data[i][19] + '\')"><i class="glyphicon glyphicon-shopping-cart"></i> Add to Cart</a>' )
					teks += ('<p></p><a href="javascript:addCompare(this,\'' + data.data[i][1] + '\',\'' + data.data[i][5] + '\',\'' + data.data[i][19] + '\')" style="box-shadow: 1px 1px 1px #ccc;font-size:12px;" class="btn btn-warning form-control" style="padding: 5px;"><i class="glyphicon glyphicon-tasks"></i>&nbspCompare</a>' + '</form>' + '</div>' + '</div>' + '</div>')
				} else {
					teks = ''
					if (i % 3 == 0 || i == 0) {
						teks += '<div class="row">'
						teks += '</div>'
					};
					teks += '<div class="col-md-4 kotak" onmouseleave="remvHover(this)" onmouseenter="hoverMouse(this)">'
					teks += '<div class="row" style="padding:20px; height:250px; width:250px; margin: 0 auto;">'
					teks += ('<a href="javascript:void(0)" data-backdrop="true" data-toggle="modal" data-target="#modaldetail" data-produk="' + data.data[i][1] + '">')
					teks += ('<img src="' + $("#base-url").val() + $("#UPLOAD_PATH").val() + "EC_material_strategis/" + data.data[i][12] + '" class=""></a>')
					teks += '</div>'
					teks += '<div class="row" style="font-size:11px;padding-left:5px;padding-right:5px;">Kategori: ' + data.data[i][16] + '</div>'
					teks += ('<div class="row" style="font-size:16px;padding-left:5px;padding-right:5px; height:50px;">')
					teks += ('<strong><a href="javascript:void(0)" data-backdrop="true" data-toggle="modal" data-target="#modaldetail" data-produk="' + data.data[i][1] + '">' + data.data[i][2] + '</a></strong></div>')
					teks += ('<div class="row" style="font-size:14px;padding-left:5px;padding-right:5px;"><a href="javascript:void(0)" data-backdrop="true" data-toggle="modal" data-target="#modaldetail" data-produk="' + data.data[i][1] + '">' + data.data[i][1] + '</a></div>')

					teks += ('<div class="row" style="font-size:14px;padding-left:5px;padding-right:5px;">Harga: <span id="lblprice"><strong>' + data.data[i][15] + ' ' + numberWithCommas(data.data[i][3]) + '</strong></span></div>')
					teks += ('<div class="row" style="font-size:11px;padding-left:5px;padding-right:5px;">' + plant + '-' + data.data[i][11] + '</div>')
					teks += ('<div class="row" style="font-size:11px;padding-left:5px;padding-right:5px;">' + data.data[i][17] + '&nbsp' + data.data[i][18] + '</div>')
					teks += ('<div class="row" style="font-size:12px;padding-left:5px;padding-right:5px;">Open Kuantitas : ' + numberWithCommas(data.data[i][6]) + ' ' + data.data[i][13] + '</div>')
					teks += ('<div class="row" style="font-size:12px;padding-left:5px;padding-right:5px;">Nomor kontrak: ' + data.data[i][5] + '</div>')
					teks += ('<div class="row" style="font-size:12px;padding-left:5px;padding-right:5px;">Penyedia: <a href="javascript:void(0)" data-backdrop="true" data-toggle="modal" data-target="#modalpenyedia" data-vendor="' + data.data[i][14] + '">' + data.data[i][7] + '</a></div>')
					teks += ('<div class="row" style="font-size:12px;padding-left:5px;padding-right:5px;">Principal: <a href="javascript:void(0)" data-backdrop="true" data-toggle="modal" data-target="#modalprincipal" data-principal="' + data.data[i][8] + '">' + data.data[i][8] + '</a></div>')
					teks += ('<div class="row" style="font-size:12px;padding-left:5px;padding-right:5px; color:' + color + '"><strong>Tanggal Berlaku: ' + data.data[i][9].substring(6) + '/' + data.data[i][9].substring(4, 6) + '/' + data.data[i][9].substring(0, 4) + ' - ' + data.data[i][10].substring(6) + '/' + data.data[i][10].substring(4, 6) + '/' + data.data[i][10].substring(0, 4) + '</strong></div>')

					teks += '<div class="row" style="padding-left:35px">'
					// teks += '<a href="' + base_url + 'EC_Ecatalog_Marketplace/detail_prod/' + data.data[i][5] + '/' + data.data[i][1] + '" style="font-size:12px;margin:5px;width:80%;box-shadow: 2px 2px 2px 2px #ccc"  class="btn btn-primary form-control beli" data-category="'+data.data[i][19]+'"><i class="glyphicon glyphicon-usd" ></i>&nbsp&nbspBuy</a>'
					teks += '<a href="javascript:void(0)" style="font-size:12px;margin:5px;width:80%;box-shadow: 2px 2px 2px 2px #ccc"  class="btn btn-primary form-control beli" onclick="buyOneCheck(this,\'' + data.data[i][5] + '\',\'' + data.data[i][1] + '\',\'' + data.data[i][19] + '\')"><i class="glyphicon glyphicon-usd" ></i>&nbsp&nbspBuy</a>'
					teks += '<a href="javascript:void(0)" style="font-size:12px;padding: 5px;margin:5px;width:80%;box-shadow: 2px 2px 2px 2px #ccc" class="btn btn-info form-control beli"  onclick="addCart(this,\'' + data.data[i][1] + '\',\'' + data.data[i][5] + '\',\'' + data.data[i][19] + '\')"><i class="glyphicon glyphicon-shopping-cart"></i> Add to Cart</a>'
					teks += '<a href="javascript:addCompare(this,\'' + data.data[i][1] + '\',\'' + data.data[i][5] + '\',\'' + data.data[i][19] + '\')" style="font-size:12px;margin:5px;width:80%;box-shadow: 2px 2px 2px 2px #ccc" class="btn btn-warning form-control" style="padding: 5px;"><i class="glyphicon glyphicon-tasks"></i>&nbspCompare</a>'
					teks += '</div>'
					teks += '</div>'
				}
				$("#divAttributes").append(teks)

			}
		// }

	}).fail(function() {
		// console.log("error");
	}).always(function(data) {
		// console.log(data);

	});

}

function remvHover(elm) {
	$(elm).css("border", "0px solid #fff");
	$(elm).css("box-shadow", "0px 0px 0px #ccc");
}

function hoverMouse(elm) {
	$(elm).css("border", "1px solid #ccc");
	$(elm).css("box-shadow", "1px 1px 1px #ccc");
}

function loadDataListPricelist() {
	$('.breadcrumb').empty()
	$('.breadcrumb').append('<li><a href="' + base_url + 'EC_Pricelist"><span style="color:#e74c3c;"  class="glyphicon glyphicon-home" aria-hidden="true"></span></a><a onclick="setCode(\'-\',this)" href="javascript:void(0)">&nbsp;&nbsp;Home</a></li>')
	$.ajax({
		url : $("#base-url").val() + 'EC_Ecatalog_Marketplace' + '/get_data_pricelist', //urlll,
		data : {
			"min" : range_harga[0],
			"max" : range_harga[1],
			"limitMin" : limitMin,
			"limitMax" : limitMax
		},
		type : 'POST',
		dataType : 'json'
	}).done(function(data) {
		// console.log(limitMin + " " + limitMax);
		var plant = null;
		//limitMin < pageMax
		// if (limitMin < pageMax) {
		// $('.pagination').empty()
		// pageMax = Math.ceil(data.page / 10)
		// pageMaxOld = (pageMaxOld == 0) ? pageMax : pageMaxOld
		// if (pageMax != pageMaxOld) {
		// 	limitMin = 0
		// 	pageMaxOld = 0
		// 	loadDataList()
		// 	return ''
		// } else {
		// 	pageMaxOld = pageMax
		// }
		// $('.pagination').append('<li><a href="javascript:paginationPrev()" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>')
		// for (var i = 0; i < Math.ceil(data.page / 10); i++) {
		// 	$('.pagination').append('<li><a href="javascript:pagination(' + (i * 10) + ',' + ((i + 1) * 10) + ')">' + (i + 1) + '</a></li>')
		// }
		// $('.pagination').append('<li><a href="javascript:paginationNext()" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>')

		$("#divAttributes").empty()
		if (data.data.length == 0)
			$("#divAttributes").append('<div class="row text-center">Data Tidak Ditemukan!!</div>')
		else
			for (var i = limitMin; i < data.data.length; i++) {
				if (i == data.data.length - 1) {
					teks = ('<div class="row" style=" margin:3px;">')
				} else {
					teks = '<div class="row" style=" margin:3px; border-bottom: 1px solid #ccc;">'
				}
				var dp = 'datepicker';
				disable = 'disabled';

				teks += ('<div class="row" style=" margin:3px; padding:3px;">')
				teks += ('<div class="col-md-1" style="  padding-left: 3px;">')
				teks += ('<a href="javascript:void(0)" data-backdrop="true" data-toggle="modal" data-target="#modaldetail" data-produk="' + data.data[i][1] + '">')
				teks += ('<img src="' + $("#base-url").val() + $("#UPLOAD_PATH").val() + "EC_material_strategis/" + data.data[i][3] + '" class="img-responsive"></a>')
				teks += ('</div>' + '<div class="col-md-5" style="  padding-left: 20px;">' + '<div class="row" style="font-size:11px">Kategori: ' + data.data[i][1] + '</div>')
				teks += ('<div class="row" style="font-size:14px">')
				teks += ('<strong><a href="javascript:void(0)" data-backdrop="true" data-toggle="modal" data-target="#modaldetail" data-produk="' + data.data[i][1] + '">' + data.data[i][2] + '</a></strong></div>')
				teks += ('</div>' + '<div class="col-md-3" style="padding-left: 20px;">')
				teks += ('<div class="row" style="font-size:14px"><a href="javascript:void(0)" data-backdrop="true" data-toggle="modal" data-target="#modaldetail" data-produk="' + data.data[i][1] + '">' + data.data[i][1] + '</a></div>')
				teks += ('</div>' + '<div class="col-md-1" style="padding-left: 20px;">')
				teks += ('</div> <div class="col-md-2" style="text-align: center;">')// + '<form class="form-horizontal">' )
				// teks += ('<input onchange="offer(this, \'' + data.data[i][1] + '\')" type="checkbox" style="margin-top: 20px;"> Offer')
				teks += ('<a href="javascript:void(0)" style="font-size:12px;"  class="btn btn-primary form-control beli"><i class="glyphicon glyphicon-usd" ></i>&nbsp&nbspTawaran</a>' )
				teks += ('</div>' + '</div>' + '</div>')
				$("#divAttributes").append(teks)
			}

	}).fail(function() {
		// console.log("error");
	}).always(function(data) {
		// console.log(data);

	});

}

function pagination(elm, min, maks) {
	limitMin = min
	limitMax = maks
	loadDataList()
}

function paginationPrev(elm) {
	if (limitMin >= 12) {
		limitMin -= 12
		limitMax -= 12
		loadDataList()
	};
}

function paginationNext(elm) {
	if (limitMax < (pageMax * 12)) {
		limitMin += 12
		limitMax += 12
		loadDataList()
	};
}

function getCategoryBread(id) {
	$(".abuu").each(function() {
		$(this).css('color', '#666')
		if ($(this).data('kode') == id)
			$(this).css('color', '#e74c3c')
	});
	return ''
}


$("#formsearch").submit(function(event) {
	event.preventDefault();
	range_harga = ['-', '-']
	base_url = $("#base-url").val()
	kodeParent = $('#txtsearch').val()//$("#kodeParent").val()
	searctTag = $('#txtsearch').val()
	urlll = '/get_data/'
	loadDataList()
});

$('#modalPO').on('hidden.bs.modal', function (event) {
    // window.location=$("#base-url").val() + 'EC_Ecatalog_Marketplace/listCatalog/';
});

//  onclick="buyOne(this,\'' + data.data[i][1] + '\',\'' + data.data[i][5] + '\',\'' + data.data[i][1] + '\')"
//function buyOne(elm, id, contract_no, matno) {
//	var sukses = 0;
//	// console.log(qty + " < " + $("#avl").val() + "  " + $("#sisa").val())	 
//	if($("#docdate").val()=='' || $("#sel1").val()==null || $("#delivdate").val()=='' || $("#selOrg").val()==null || $("#selGroup").val()==null){
//		alert('Purchasing Organization, Purchasing Group, Document type, Document date dan Delivery date harus di isi')
//	}else{
//		qty = parseInt($(".qtyy").val())
//		if (confirm("Konfirmasi Order?")){
//			$('#modalBeli').modal('hide');
//			if (qty > 0 && $(".qtyy").val().search(/[A-Za-z]/g) == -1){//
//				if (qty < $("#avl").val()){
//					if ($("#sisa").val() > 0){
//						$.ajax({
//							url : $("#base-url").val() + 'EC_Ecatalog_Marketplace/confirmOne/',
//							data : {
//								"company" : $("#selComp").val(),
//								"qty" : $(".qtyy").val(),
//								"contract_no" : contract_no,
//								"matno" : matno,
//								"docdate" : $("#docdate").val(),
//								"doctype" : $("#sel1").val(),
//								"deliverydate" : $("#delivdate").val(),
//								"purcorg" : $("#selOrg").val(),
//								"purcgroup" : $("#selGroup").val(),
//								"kode_penawaran":'1'
//							},
//							type : 'POST',
//							dataType : 'json'
//						}).done(function(data) {
//							// console.log(data);
//						}).fail(function(data) {
//							// console.log("error");
//							// $("#pocreated").text(data['RETURN'][0]['MESSAGE'])
//						}).always(function(data) {
//							// console.log(data)
//							// $("#statsPO").text(data)
//							var cnt = 0;
//							$('#tbodyPO').empty()
//							po = "-"
//							// for (var i = 0; i < data.length; i++) {
//							if(data.suksesReturn.length > 0){
//								sukses = 1;
//								po = (data.suksesReturn[0].PO_NO) != po ? (data.suksesReturn[0].PO_NO) : ""
//								$('#tbodyPO').append('<tr></tr>')
//								$('#tbodyPO tr:eq(' + 0 + ')').append('<td>' + (po == "null" ? "gagal" : po) + '</td>')
//								$('#tbodyPO tr:eq(' + 0 + ')').append('<td>' + (data.suksesReturn[0].MAKTX) + '   (' + (data.suksesReturn[0].MATNO) + ')</td>')
//								$('#tbodyPO tr:eq(' + 0 + ')').append('<td>' + (data.suksesReturn[0].curr) + ' ' + numberWithCommas((data.suksesReturn[0].netprice*100) * $(".qtyy").val()) + '</td>')
//							}
//
//							if(data.gagalReturn.length > 0){
//					            //console.log('masuk');
//					            $('#tbodyPO').append('<tr><td>Gagal: </td></tr>');
//					            for (var i = 0; i < data.gagalReturn.length; i++) {
//					                // $('#tbodyPO').append('<tr><td>&mdash;</td></tr>');
//					                // for (var j = 0; j < data.gagalReturn[i].length; j++) {
//					                    $('#tbodyPO').append('<tr id="cnt' + cnt + '"></tr>')
//					                    $('#cnt' + cnt).append('<td>' + data.gagalReturn[i] + '</td>')
//					                    // $('#cnt' + cnt).append('<td>' + (data.gagalReturn[i][j].MESSAGE) + '</td>')
//					                    // $('#cnt' + cnt).append('<td>' + (data.gagalReturn[i][j].MESSAGE_V1) + '</td>')
//					                    // $('#cnt' + cnt).append('<td>' + (data.gagalReturn[i][j].PARAMETER) + '</td>')
//					                    cnt++
//					                // }
//					            }
//					        }
//
//							$('#modalPO').modal('show')
//							var fiveMinutes = 15,
//							    display = document.querySelector('#dtk');
//							startTimer(fiveMinutes, display);
//							setTimeout(function() {
//								if(sukses==1){
//									window.location=$("#base-url").val() + 'EC_Ecatalog_Marketplace/listCatalog/';	
//								}
//								// window.location.reload();
//								
//							}, 14700);
//						});
//					}else{
//						alert('Budget Exceeded!!')
//					}
//				}else{
//					alert('Maksimal jumlah order: ' + $("#avl").val() + ' !!')
//				}
//			}else {
//				alert('Minimal 1 dan hanya angka!!')
//				$(elm).val($(elm).data('old'))
//			}
//		}
//	}
//}

function chgPic(id, path) {
	//'.base_url(UPLOAD_PATH).'/material_strategis/'.
	$("#picSRC").attr('src', $("#base-url").val() + 'upload/EC_material_strategis/' + path)
}

function addCart(elm, matno, contract_no, category) {
    console.log(matno + ' ' + contract_no + ' ' + category);
	$.ajax({
		url : $("#base-url").val() + 'EC_Ecatalog_Marketplace/cekAuthorize/',
		data : {
            "id_category" : category            
		},
		type : 'POST',
		dataType : 'json'
	}).done(function(data) {
		// console.log(data.sukses);
		if(data.sukses){
			$.ajax({
				url : $("#base-url").val() + 'EC_Ecatalog_Marketplace/addCart/' + matno,
				data : {
		            "contract_no" : contract_no,
		            "kode_penawaran": '1',
		            "COSCENTER": '0'
				},
				type : 'POST',
				dataType : 'json'
			}).done(function(data) {
				// console.log(data);
				$(".jml").text(data);
			}).fail(function() {
				// console.log("error");
			}).always(function(data) {
				//console.log(data);
			});
		}else{
			bootbox.alert("You don't have authorized");
		}
		// console.log(cek);
	}).fail(function() {
		// console.log("error");
	}).always(function(data) {
		//console.log(data);
	});

	/*console.log(cek);
	if(cek==1){
		alert("Authorized");
	}else{
		alert("You don't have authorized");
	}*/
	/*$.ajax({
		url : $("#base-url").val() + 'EC_Ecatalog_Marketplace/addCart/' + matno,
		data : {
            "contract_no" : contract_no,
            "kode_penawaran": '1',
            "COSCENTER": '0'
		},
		type : 'POST',
		dataType : 'json'
	}).done(function(data) {
		// console.log(data);
		$(".jml").text(data);
	}).fail(function() {
		// console.log("error");
	}).always(function(data) {
		//console.log(data);
	});*/
}

function addCart_pl(matno, category, vendor, penawaran) {
	console.log('addCart_pl' + matno + ' ' + ' ' + category + ' ' + vendor);
        $.ajax({
		url : $("#base-url").val() + 'EC_Ecatalog_Marketplace/cekAuthorize/',
		data : {
            "id_category" : category            
		},
		type : 'POST', 
		dataType : 'json'
	}).done(function(data) {
		// console.log(data.sukses);
		if(data.sukses){
			$.ajax({
				url : $("#base-url").val() + 'EC_Ecatalog_Marketplace/addCart/' + matno,
				data : {
		            "vendor" : vendor,
		            "kode_penawaran": penawaran,
		            "COSCENTER": '0'
				},
				type : 'POST',
				dataType : 'json'
			}).done(function(data) {
				// console.log(data);
				$(".jml").text(data);
			}).fail(function() {
				// console.log("error");
			}).always(function(data) {
				//console.log(data);
			});
		}else{
			bootbox.alert("You don't have authorized");
		}
		// console.log(cek);
	}).fail(function() {
		// console.log("error");
	}).always(function(data) {
		//console.log(data);
	});
}

function addCompare2(elm, matno, contract_no) {
	// console.log("id : " + id + " " + compare.indexOf(id));
	// if ((id != 'null' && matno != null) && (compare.indexOf(matno) < 0)) {
	compare.push(matno);
	compareCntrk.push(contract_no);
	$(elm).attr('enabled', false)
	// }

	$("#compare").text('Compare (' + compare.length + ')');
	$("#arr").val(compare)
	$("#arrC").val(compareCntrk)
	// console.log("compare : " + $("#arr").val());
}

function addCompare(elm, matno, contract_no, category) {
	// console.log(matno + ' ' + contract_no)
	$.ajax({
		url : $("#base-url").val() + 'EC_Ecatalog_Marketplace/cekAuthorize/',
		data : {
            "id_category" : category            
		},
		type : 'POST',
		dataType : 'json'
	}).done(function(data) {
		// console.log(data.sukses);
		if(data.sukses){
			$.ajax({
				url : $("#base-url").val() + 'EC_Ecatalog_Marketplace/addCompare/' + matno,
				data : {
					"contract_no" : contract_no
				},
				type : 'POST',
				dataType : 'json'
			}).done(function(data) {
				$(".jmlCompare").text(data);
			}).fail(function() {
				// console.log("error");
			}).always(function(data) {
				// console.log('cmp ' + data);
			});
		}else{
			bootbox.alert("You don't have authorized");
		}
		// console.log(cek);
	}).fail(function() {
		// console.log("error");
	}).always(function(data) {
		//console.log(data);
	});
}

function buyOneCheck(elm, contract_no, matno, category) {
	// console.log(matno + ' ' + contract_no)
	$.ajax({
		url : $("#base-url").val() + 'EC_Ecatalog_Marketplace/cekAuthorize/',
		data : {
            "id_category" : category            
		},
		type : 'POST',
		dataType : 'json'
	}).done(function(data) {
		// console.log(data.sukses);
		if(data.sukses){
			window.location=$("#base-url").val() + 'EC_Ecatalog_Marketplace/detail_prod/'+contract_no+'/'+matno;
		}else{
			bootbox.alert("You don't have authorized");
		}
		// console.log(cek);
	}).fail(function() {
		// console.log("error");
	}).always(function(data) {
		//console.log(data);
	});
}

function getCategory(KODE_USER) {
	// $.ajax({
	// url : $("#base-url").val() + 'EC_Ecatalog_Marketplace/listCatalog/' + KODE_USER,
	// data : {
	// "checked" : null
	// },
	// type : 'POST',
	// dataType : 'json'
	// }).done(function(data) {
	// }).fail(function() {
	// console.log("error");
	// }).always(function(data) {
	// //console.log(data);
	// });

}

function numberWithCommas(x) {
	return x == 0 || x == null ? '' : x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}


$('#modalpenyedia').on('show.bs.modal', function(event) {
	var button = $(event.relatedTarget)
	var vendor_no = button.data('vendor')
	$("#VENDOR_NAME").text("Loading Data.....");
	//var id = button.data('id')
	//var modal = $(this)
	$.ajax({
		url : $("#base-url").val() + 'EC_Ecatalog_Marketplace/getVendorNo/' + vendor_no,
		type : 'POST',
		dataType : 'json'
	}).done(function(data) {
		// console.log(data);
		if(data.length>0){
			$("#VENDOR_NAME").text(data[0].VENDOR_NAME == null ? "-" : data[0].VENDOR_NAME);
			$("#ADDRESS").text((data[0].ADDRESS_STREET == null ? "-" : data[0].ADDRESS_STREET) + ' ' + (data[0].NAMA == null ? "" : data[0].NAMA));
			$("#ADDRESS_COUNTRY").text(data[0].COUNTRY_NAME == null ? "-" : data[0].COUNTRY_NAME);
			$("#EMAIL_ADDRESS").text(data[0].EMAIL_ADDRESS == null ? "-" : data[0].EMAIL_ADDRESS);
			$("#ADDRESS_WEBSITE").text(data[0].ADDRESS_WEBSITE == null ? "-" : data[0].ADDRESS_WEBSITE);
			$("#NPWP_NO").text(data[0].NPWP_NO == null ? "-" : data[0].NPWP_NO);
			$("#CONTACT_NAME").text(data[0].CONTACT_NAME == null ? "-" : data[0].CONTACT_NAME);
			$("#CONTACT_PHONE_NO").text(data[0].CONTACT_PHONE_NO == null ? "-" : data[0].CONTACT_PHONE_NO);
			$("#CONTACT_EMAIL").text(data[0].CONTACT_EMAIL == null ? "-" : data[0].CONTACT_EMAIL);
			$("#nodata").empty();
		}else{
			// bootbox.alert("No data vendor");
			$("#VENDOR_NAME").text('');
			$("#ADDRESS").text('');
			$("#ADDRESS_COUNTRY").text('');
			$("#EMAIL_ADDRESS").text('');
			$("#ADDRESS_WEBSITE").text('');
			$("#NPWP_NO").text('');
			$("#CONTACT_NAME").text('');
			$("#CONTACT_PHONE_NO").text('');
			$("#CONTACT_EMAIL").text('');
			$("#nodata").text('Vendor not found...');
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

$('#modalprincipal').on('show.bs.modal', function(event) {
	var button = $(event.relatedTarget)
	var pc_code = button.data('principal')
	$("#PC_NAME").text("Loading Data.....");
	//var id = button.data('id')
	//var modal = $(this)
	$.ajax({
		url : $("#base-url").val() + 'EC_Ecatalog_Marketplace/getPrincipal/' + pc_code,
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

$('#modalBeli').on('show.bs.modal', function (event) {
   $('#docdate').val($('#tanggalNow').val());
   $('#modalProduk').val($('#namaProduk').val());
   $('#jmlItm').val($('.qtyy').val());
   numberWithCommas($('#totalBiaya').val($('#totall').val()));
});

$('#modaldetail').on('show.bs.modal', function(event) {
	var button = $(event.relatedTarget)
	var MATNR = button.data('produk')
	$("#detail_MATNR").text("Loading Data.....");
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

function loadTree() {
	$('#tree1').empty()
	$.ajax({
		url : $("#base-url").val() + 'EC_Master_category/get_data/',
		type : 'POST',
		dataType : 'json'
	}).done(function(data) {
		// console.log('cat '+data[0]);
		// cate.push(data)
		// setCat(data)
		// console.log('catt ' + cate[5].DESC)
		for (var i = 0,
		    j = data.length; i < j; i++) {
			if (data[i].KODE_PARENT == '0') {
				$('#tree1').append('<li><a href="javascript:void(0)" onclick="setCode(\'' + data[i].KODE_USER + '\',this)" data-id="' + data[i].ID_CAT + '" data-kode="' + data[i].KODE_USER + '" data-desc="' + data[i].DESC + '" class="lvl1 abuu" style="color:#666;font-size: 13px;">' + data[i].DESC + '</a><ul></ul></li>');
			};
		};
		$(".lvl1").each(function() {
			for (var i = 0,
			    j = data.length; i < j; i++) {
				if ($(this).data('id') == data[i].KODE_PARENT) {
					$(this).next().append('<li><a href="javascript:void(0)" onclick="setCode(\'' + data[i].KODE_USER + '\',this)" data-id="' + data[i].ID_CAT + '" data-kode="' + data[i].KODE_USER + '" data-desc="' + data[i].DESC + '"  class="lvl2 abuu"  style="color:#666;font-size: 13px;">' + data[i].DESC + '</a><ul></ul></li>');
				};
			};
		});

		$(".lvl2").each(function() {
			for (var i = 0,
			    j = data.length; i < j; i++) {
				if ($(this).data('id') == data[i].KODE_PARENT) {
					$(this).next().append('<li><a href="javascript:void(0)" onclick="setCode(\'' + data[i].KODE_USER + '\',this)" data-id="' + data[i].ID_CAT + '" data-kode="' + data[i].KODE_USER + '"  data-desc="' + data[i].DESC + '" class="lvl3 abuu" style="color:#666;font-size: 13px;">' + data[i].DESC + '</a><ul></ul></li>');
				};
			};
		});

		$(".lvl3").each(function() {
			for (var i = 0,
			    j = data.length; i < j; i++) {
				if ($(this).data('id') == data[i].KODE_PARENT) {
					$(this).next().append('<li><a href="javascript:void(0)" onclick="setCode(\'' + data[i].KODE_USER + '\',this)" data-id="' + data[i].ID_CAT + '" data-kode="' + data[i].KODE_USER + '"  data-desc="' + data[i].DESC + '" class="lvl4 abuu" style="color:#666;font-size: 13px;">' + data[i].DESC + '</a><ul></ul></li>');
				};
			};
		});

		$(".lvl4").each(function() {
			for (var i = 0,
			    j = data.length; i < j; i++) {
				if ($(this).data('id') == data[i].KODE_PARENT) {
					$(this).next().append('<li><a href="javascript:void(0)" onclick="setCode(\'' + data[i].KODE_USER + '\',this)" data-id="' + data[i].ID_CAT + '" data-kode="' + data[i].KODE_USER + '"  data-desc="' + data[i].DESC + '" class="lvl5 abuu" style="color:#666;font-size: 13px;">' + data[i].DESC + '</a><ul></ul></li>');
				};
			};
		});

		$(".lvl5").each(function() {
			for (var i = 0,
			    j = data.length; i < j; i++) {
				if ($(this).data('id') == data[i].KODE_PARENT) {
					$(this).next().append('<li><a href="javascript:void(0)" onclick="setCode(\'' + data[i].KODE_USER + '\',this)" data-id="' + data[i].ID_CAT + '" data-kode="' + data[i].KODE_USER + '"  data-desc="' + data[i].DESC + '" class="lvl6 abuu" style="color:#666;font-size: 13px;">' + data[i].DESC + '</a><ul></ul></li>');
				};
			};
		});
		if (window.location.pathname.indexOf('list') > -1) {
			$('#tree1').treed();
			$('#tree1 .branch').each(function() {
				var icon = $(this).children('a:first').children('i:first');
				icon.toggleClass('glyphicon-minus-sign glyphicon-plus-sign');
				$(this).children().children().toggle();

			});
		}
	}).fail(function() {
		// console.log("error");
	}).always(function(data) {
		loadDataList();
		$("ul").each(function() {
			if ($(this).find('a').length < 1)
				$(this).prev().prev().empty()
		});
	});
	// $('.lvl3').parent.removeChild(d)
}

function setCode(id, elm) {
	$(".abuu").each(function() {
		$(this).css('color', '#666')
	});
	$(elm).css('color', '#e74c3c')
	base_url = $("#base-url").val()
	searctTag = $("#tag").val()
	kodeParent = id
	if (id == '-') {
		// console.log(id)
		searctTag = "-"
		kodeParent = "-"
		urlll = '/get_data/'
	}
	range_harga = ['-', '-']
	loadDataList();
}

function modeList(model) {
	mode = model
	loadDataList()
}

budget = 0;


function startTimer(duration, display) {
	var start = Date.now(),
	    diff,
	    minutes,
	    seconds;
	function timer() {
		// get the number of seconds that have elapsed since
		// startTimer() was called
		diff = duration - (((Date.now() - start) / 1000) | 0);

		// does the same job as parseInt truncates the float
		minutes = (diff / 60) | 0;
		seconds = (diff % 60) | 0;

		minutes = minutes < 10 ? "0" + minutes : minutes;
		seconds = seconds < 10 ? "0" + seconds : seconds;

		display.textContent = minutes + ":" + seconds;

		if (diff <= 0) {
			// add one second so that the count down starts at the full duration
			// example 05:00 not 04:59
			start = Date.now() + 1000;
		}
	};
	// we don't want to wait a full second before the timer starts
	timer();
	setInterval(timer, 1000);
}
