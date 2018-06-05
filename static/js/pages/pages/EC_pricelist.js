var range_harga = ['-', '-'],
    base_url = $("#base-url").val(),
    kodeParent = $("#kodeParent").val(),
    searctTag = $("#tag").val(),
    urlll = '/get_data/',
    compare = [],
    limitMin = 0,
    limitMax = 10,
    pageMax = 1,
    pageMaxOld = 0,
    compareCntrk = [];
function loadDataList() {
	$('.breadcrumb').empty()
	$('.breadcrumb').append('<li><a href="' + base_url + 'EC_Pricelist"><span style="color:#e74c3c;"  class="glyphicon glyphicon-home" aria-hidden="true"></span></a><a onclick="setCode(\'-\',this)" href="javascript:void(0)">&nbsp;&nbsp;Home</a></li>')
	if (kodeParent != null && kodeParent != '-') {
		urlll = '/get_data_category/' + kodeParent;
		splitt = kodeParent.split("-")
		teks = splitt[0]
		for (var i = 0; i < splitt.length; i++) {
			$(".lvl" + (i + 1)).each(function() {
				if ($(this).data('kode') == teks) {
					$('.breadcrumb').append('<li><a href="javascript:void(0)"  onclick="setCode(\'' + $(this).data('kode') + '\',this)" data-id="' + $(this).data('id') + '" data-kode="' + $(this).data('kode') + '" data-desc="' + $(this).data('desc') + '" >' + $(this).data('desc') + '</a></li>')
				}
			});
			teks += ('-' + splitt[i + 1])
		};
		getCategoryBread(kodeParent);
		// limitMin=(limitMin!=0)?0:0
	}
	if (searctTag != null && searctTag != '-') {
		urlll = '/get_data_tag/' + searctTag
		if ($('.breadcrumb').text().indexOf('Search') < 0) {
			$('.breadcrumb').empty()
			$('.breadcrumb').append('<li><span style="color:#e74c3c;"  class="glyphicon glyphicon-home" aria-hidden="true"></span><a onclick="setCode(\'-\',this)" href="javascript:void(0)">&nbsp;&nbsp;Home</a></li>')
			$('.breadcrumb').append('<li><a href="javascript:void(0)">Filter Search</a></li>')
		}
		// limitMin=(limitMin!=0)?0:0
	}
	if (range_harga != null && range_harga[0] != '-') {
		urlll = '/get_data_harga/' + searctTag
		if ($('.breadcrumb').text().indexOf('Harga') < 0) {
			$('.breadcrumb').empty()
			$('.breadcrumb').append('<li><span style="color:#e74c3c;"  class="glyphicon glyphicon-home" aria-hidden="true"></span><a onclick="setCode(\'-\',this)" href="javascript:void(0)">&nbsp;&nbsp;Home</a></li>')
			$('.breadcrumb').append('<li><a href="javascript:void(0)">Filter Harga</a></li>')
		}
		// limitMin=(limitMin!=0)?0:0
	}
	$.ajax({
		url : $("#base-url").val() + 'EC_Pricelist' + urlll,
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
		//var setCurrency = currency();
		//console.log(setCurrency);
		$("#divAttributes").empty()
		if (data.data.length == 0)
			$("#divAttributes").append('<div class="row text-center">Data Tidak Ditemukan!!</div>')
		else
			for (var i = limitMin; i < data.data.length; i++) {
				// if (data.data[i][11].substring(0, 1) == 3) {
				// 	plant = 'Semen Padang';
				// } else if (data.data[i][11].substring(0, 1) == 4) {
				// 	plant = 'Semen Tonasa';
				// } else if (data.data[i][11].substring(0, 1) == 5) {
				// 	plant = 'Semen Gresik';
				// } else if (data.data[i][11].substring(0, 1) == 7) {
				// 	plant = 'KSO';
				// } else if (data.data[i][11].substring(0, 1) == 2) {
				// 	plant = 'Holding SMI';
				// }
				if (i == data.data.length - 1) {
					teks = ('<div class="row" style=" margin:3px;">')
				} else {
					teks = '<div class="row" style=" margin:3px; border-bottom: 1px solid #ccc;">'
				}

				// var color = null;
				// //var datenow = new Date();
				// var today = new Date();
				// var dd = today.getDate();
				// var mm = today.getMonth() + 1;
				// //January is 0!
				// var yyyy = today.getFullYear();

				// if (dd < 10) {
				// 	dd = '0' + dd;
				// }

				// if (mm < 10) {
				// 	mm = '0' + mm;
				// }

				// var now = yyyy + '-' + mm + '-' + dd;
				// //document.write(today);
				// //console.log(a);
				// var startdate = data.data[i][9].substring(0, 4) + '-' + data.data[i][9].substring(4, 6) + '-' + data.data[i][9].substring(6);
				// var enddate = data.data[i][10].substring(0, 4) + '-' + data.data[i][10].substring(4, 6) + '-' + data.data[i][10].substring(6);
				// //console.log(startdate);

				// if (new Date(startdate).getTime() >= new Date(now).getTime() && new Date(enddate).getTime() >= new Date(now).getTime()) {
				// 	color = "blue";
				// } else if (new Date(startdate).getTime() <= new Date(now).getTime() && new Date(enddate).getTime() <= new Date(now).getTime()) {
				// 	color = "red";
				// } else {
				// 	color = "green";
				// }
				var masterCurrency = '';
				for (var c = 0; c < data.curr.length ; c++) {
					masterCurrency += ('<option value="'+data.curr[c].CURR_CODE+'">'+data.curr[c].CURR_CODE+' ('+data.curr[c].CURR_NAME+')</option>')
				}

				var dateS = 'dateS';
				var dateE = 'dateE';
				var cekStatus = '';
				var disable = '';
				var dp = 'datepicker';
				if (data.data[i][8] == 'Y') {
					cekStatus = 'checked';
					disable = 'disabled';
					// dp = '';
				}
				teks += ('<div class="row" style=" margin:3px; padding:3px;">')
				teks += ('<div class="col-md-1" style="  padding-left: 3px;">')
				teks += ('<a href="javascript:void(0)" data-backdrop="true" data-toggle="modal" data-target="#modaldetail" data-produk="' + data.data[i][1] + '">')
				teks += ('<img src="' + $("#base-url").val() + $("#UPLOAD_PATH").val() + "EC_material_strategis/" + data.data[i][3] + '" class="img-responsive"></a>')
				teks += ('</div>' + '<div class="col-md-3" style="  padding-left: 20px;">' + '<div class="row" style="font-size:11px">Nomor Material: <a href="javascript:void(0)" data-backdrop="true" data-toggle="modal" data-target="#modaldetail" data-produk="' + data.data[i][1] + '">' + data.data[i][1] + '</a></div>')
				//teks += ('<div class="row" style="font-size:11px">' + plant + '-' + data.data[i][11] + '</div>')
				teks += ('<div class="row" style="font-size:14px">')
				teks += ('<strong><a href="javascript:void(0)" data-backdrop="true" data-toggle="modal" data-target="#modaldetail" data-produk="' + data.data[i][1] + '">' + data.data[i][2] + '</a></strong></div>')
				//teks += ('<div class="row" style="font-size:14px"><a href="javascript:void(0)" data-backdrop="true" data-toggle="modal" data-target="#modaldetail" data-produk="' + data.data[i][1] + '">' + data.data[i][1] + '</a></div>')
				teks += ('</div>' + '<div class="col-md-7" style="padding-left: 20px;">')
				//teks += ('<form class="form-inline">')
				//teks += ('<div class="form-group">')
				teks += ('<div class="row">')
				
				//teks += ('<div class="row" style="font-size:14px">Harga: <span id="lblprice"><strong>' + data.data[i][15] + ' ' + numberWithCommas(data.data[i][3]) + '</strong></span></div>')
				//teks += ('<div class="row" style="font-size:12px">Open Kuantitas : ' + numberWithCommas(data.data[i][6]) + ' ' + data.data[i][13] + '</div>')
				//teks += ('<div class="row" style="font-size:12px">Nomor kontrak: ' + data.data[i][5] + '</div>')
				//teks += ('<div class="row" style="font-size:12px">Penyedia: <a href="javascript:void(0)" data-backdrop="true" data-toggle="modal" data-target="#modalpenyedia" data-vendor="' + data.data[i][14] + '">' + data.data[i][7] + '</a></div>')
				//teks += ('<div class="row" style="font-size:12px">Principal: <a href="javascript:void(0)" data-backdrop="true" data-toggle="modal" data-target="#modalprincipal" data-principal="' + data.data[i][8] + '">' + data.data[i][8] + '</a></div>')
				//teks += ('<div class="row" style="font-size:12px; color:' + color + '"><strong>Tanggal Berlaku: ' + data.data[i][9].substring(6) + '/' + data.data[i][9].substring(4, 6) + '/' + data.data[i][9].substring(0, 4) + ' - ' + data.data[i][10].substring(6) + '/' + data.data[i][10].substring(4, 6) + '/' + data.data[i][10].substring(0, 4) + '</strong></div>')
				teks += ('<div class="col-md-2">')
				teks += ('<label for="harga">Harga</label>')
				teks += ('</div><div class="col-md-2">')
				teks += ('<label for="currency">Currency</label>')
				teks += ('</div><div class="col-md-4">')
				teks += ('<label for="startdate">Valid From</label>')
				teks += ('</div><div class="col-md-4">')
				teks += ('<label for="enddate">Valid End</label>')
				teks += ('</div></div>')

				//teks += ('<form class="form-inline">')
				//teks += ('<div class="form-group">')
				teks += ('<div class="row">')
				
				//teks += ('<div class="row" style="font-size:14px">Harga: <span id="lblprice"><strong>' + data.data[i][15] + ' ' + numberWithCommas(data.data[i][3]) + '</strong></span></div>')
				//teks += ('<div class="row" style="font-size:12px">Open Kuantitas : ' + numberWithCommas(data.data[i][6]) + ' ' + data.data[i][13] + '</div>')
				//teks += ('<div class="row" style="font-size:12px">Nomor kontrak: ' + data.data[i][5] + '</div>')
				//teks += ('<div class="row" style="font-size:12px">Penyedia: <a href="javascript:void(0)" data-backdrop="true" data-toggle="modal" data-target="#modalpenyedia" data-vendor="' + data.data[i][14] + '">' + data.data[i][7] + '</a></div>')
				//teks += ('<div class="row" style="font-size:12px">Principal: <a href="javascript:void(0)" data-backdrop="true" data-toggle="modal" data-target="#modalprincipal" data-principal="' + data.data[i][8] + '">' + data.data[i][8] + '</a></div>')
				//teks += ('<div class="row" style="font-size:12px; color:' + color + '"><strong>Tanggal Berlaku: ' + data.data[i][9].substring(6) + '/' + data.data[i][9].substring(4, 6) + '/' + data.data[i][9].substring(0, 4) + ' - ' + data.data[i][10].substring(6) + '/' + data.data[i][10].substring(4, 6) + '/' + data.data[i][10].substring(0, 4) + '</strong></div>')
				teks += ('<div class="col-sm-2">')
				teks += ('<input ' + disable + ' id="harga" style="width: 70px;" type="text" class="form-control harga" value="' + data.data[i][4] + '">' )
				teks += ('</div><div class="col-sm-2">')
				//teks += ('<input ' + disable + ' id="currency" style="width: 60px;" type="text" class="form-control curr" value="' + data.data[i][5] + '">' )
				teks += ('<select ' + disable + ' id="sel'+i+'" class="form-control" style="width: 75px;">')
				teks += masterCurrency
				teks += ('</select>')
				teks += ('</div><div class="col-sm-4" id="' +dateS+ i + '">')
				//teks += ('<div class="input-group date startDate" data-date-format="dd/mm/yyyy" data-provide="' + dp + '"><input disabled id="startdate" type="text" value="' + data.data[i][6] + '" class="form-control start-date" ><div class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></div></div>')
				teks += ('<div class="input-group date startDate"><input readonly id="startdate" type="text" value="' + data.data[i][6] + '" class="form-control start-date" ><span class="input-group-addon"><a href="javascript:void(0)"><i class="glyphicon glyphicon-calendar"></i></a></span></div>')
				teks += ('</div><div class="col-sm-4" id="' +dateE+ i + '">')
				//teks += ('<div class="input-group date endDate" data-date-format="dd/mm/yyyy" data-provide="' + dp + '"><input disabled id="enddate" type="text" value="' + data.data[i][7] + '" class="form-control end-date" ><div class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></div></div>')
				teks += ('<div class="input-group date endDate"><input readonly id="enddate" type="text" value="' + data.data[i][7] + '" class="form-control end-date" ><span class="input-group-addon"><a href="javascript:void(0)"><i class="glyphicon glyphicon-calendar"></i></a></span></div>')
				teks += ('</div></div>')
				//teks += ('<div class="row"><input type="text" class="form-control start-date" placeholder="Start Date"></div>' )
				//teks += ('<div class="row" style="margin-top: 5px;"><input type="text" class="form-control end-date" placeholder="End Date"></div>' )

				teks += ('</div> <div class="col-md-1" style="text-align: center;">')// + '<form class="form-horizontal">' )
				teks += ('<input ' + cekStatus + ' onchange="offer(this, \'' + data.data[i][1] + '\',\'' +dateS+ i + '\',\'' +dateE+ i + '\',\'sel' +i+' \')" type="checkbox" style="margin-top: 20px;"> Offer')
				teks += ('</div>' + '</div>' + '</div>')
				//teks += ('<a href="' + base_url + 'EC_Ecatalog/detail_prod/' + data.data[i][5] + '/' + data.data[i][1] + '" style="font-size:12px;"  class="btn btn-primary form-control beli"><i class="glyphicon glyphicon-usd" ></i>&nbsp&nbspBuy</a>' )
				//teks += ('<p></p><a href="javascript:void(0)" style="font-size:12px;padding: 5px;" class="btn btn-info form-control beli"  onclick="addCart(this,\'' + data.data[i][1] + '\',\'' + data.data[i][5] + '\')"><i class="glyphicon glyphicon-shopping-cart"></i> Add to Cart</a>' )
				//teks += ('<p></p><a href="javascript:addCompare(this,\'' + data.data[i][1] + '\',\'' + data.data[i][5] + '\')" style="font-size:12px;" class="btn btn-primary form-control" style="padding: 5px;"><i class="glyphicon glyphicon-tasks"></i>&nbsp&nbsp&nbspOffer</a>' + '</form>' + '</div>' + '</div>' + '</div>')
				$("#divAttributes").append(teks)
				$('#sel'+i).val(data.data[i][5]);
				if (data.data[i][8] != 'Y') {
					$('#' +dateS+ i + ' .startDate').datepicker({
						format: "dd/mm/yyyy",
			        	autoclose: true,
			        	todayHighlight: true
			    	});

			    	$('#' +dateE+ i + ' .endDate').datepicker({
			    		format: "dd/mm/yyyy",
			        	autoclose: true,
			        	todayHighlight: true
			    	});
				}			
			}
			
		// }

	}).fail(function() {
		// console.log("error");
	}).always(function(data) {
		// console.log(data);
		
	});

}

function offer(element, matno, dateS, dateE, select) {

	// console.log($(element).is(":checked"));
	console.log($(element).parent().parent().find(".endDate").data('provide'))
	var status = null;
	if ($(element).is(":checked")) {
		$('#'+dateS+' .startDate').datepicker('destroy');
		$('#'+dateE+' .endDate').datepicker('destroy');
		status = 'Y';
		$(element).parent().parent().find(".harga").attr('disabled', 'disabled');
		$(element).parent().parent().find(".curr").attr('disabled', 'disabled');
		$('#'+select).attr('disabled', 'disabled');
		//$(element).parent().parent().find(".startDate").attr('disabled', 'disabled');
		//$(element).parent().parent().find(".endDate").attr('disabled', 'disabled');
		// $(element).parent().parent().find(".startDate").data('provide', '')//attr('data-provide', '');
		// $(element).parent().parent().find(".endDate").data('provide', '')//attr('data-provide', '');
		
	} else {
		$('#'+dateS+' .startDate').datepicker('destroy');
		$('#'+dateE+' .endDate').datepicker('destroy');
		status = 'T';
		$(element).parent().parent().find(".harga").removeAttr('disabled');
		$(element).parent().parent().find(".curr").removeAttr('disabled');
		$('#'+select).removeAttr('disabled');
		$('#'+dateS+' .startDate').datepicker({
			format: "dd/mm/yyyy",
		   	autoclose: true,
		   	todayHighlight: true
		});
    	$('#'+dateE+' .endDate').datepicker({
    		format: "dd/mm/yyyy",
        	autoclose: true,
        	todayHighlight: true
    	});
		// $(element).parent().parent().find(".startDate").on('.datepicker.data-api');
		// $(element).parent().parent().find(".endDate").on('.datepicker.data-api');
		// $(element).parent().parent().find(".startDate").data('provide', 'datepicker')//attr('data-provide', 'datepicker');
		// $(element).parent().parent().find(".endDate").data('provide', 'datepicker')//attr('data-provide', 'datepicker');
	}
	$.ajax({
		url : $("#base-url").val() + 'EC_Pricelist/insertOffer/',
		data : {
			"harga" : $(element).parent().parent().find(".harga").val(),
			"curr" : $('#'+select).val(),
			"matno" : matno,
			"startdate" : $(element).parent().parent().find(".start-date").val(),
			"enddate" : $(element).parent().parent().find(".end-date").val(),
			"status" : status
		},
		type : 'POST',
		dataType : 'json'
	}).done(function(data) {
		console.log(data);
	}).fail(function(data) {
		// console.log("error");
		// $("#pocreated").text(data['RETURN'][0]['MESSAGE'])
	}).always(function(data) {
		// console.log(data)
		$("#statsPO").text(data)
	});
}

function currency(){
	var masterCurrency;
	$.ajax({
		url : $("#base-url").val() + 'EC_Pricelist/get_currency/',
		data : {
			//"qty" : $("#qtyy").val(),
			//"contract_no" : contract_no,
			//"matno" : matno
		},
		type : 'POST',
		dataType : 'json'
	}).done(function(data) {
		//console.log(data);
		//masterCurrency = data;

		var masterCurrency = '<select class="form-control">';
		for (var i = 0; i < data.length ; i++) {
			masterCurrency += ('<option>'+data[i].CURR_CODE+'</option>')
		}
		masterCurrency += ('</select>')
		console.log(masterCurrency)
		return masterCurrency;
	}).fail(function(data) {
		// console.log("error");
		// $("#pocreated").text(data['RETURN'][0]['MESSAGE'])
	}).always(function(data) {
		// console.log(data)

	});
	
	
}

function pagination(min, maks) {
	limitMin = min
	limitMax = maks
	loadDataList()
}

function paginationPrev() {
	if (limitMin >= 10) {
		limitMin -= 10
		limitMax -= 10
		loadDataList()
	};
}

function paginationNext() {
	if (limitMax < (pageMax * 10)) {
		limitMin += 10
		limitMax += 10
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
	kodeParent = $("#kodeParent").val()
	searctTag = $('#txtsearch').val()
	loadDataList()
});

//  onclick="buyOne(this,\'' + data.data[i][1] + '\',\'' + data.data[i][5] + '\',\'' + data.data[i][1] + '\')"
function buyOne(elm, id, contract_no, matno) {
	qty = parseInt($("#qtyy").val())
	// console.log(contract_no + "  " + matno)
	//if (qty > 0 && qty.search(/[A-Za-z]/g) == -1)//
	$.ajax({
		url : $("#base-url").val() + 'EC_Pricelist/confirmOne/',
		data : {
			"qty" : $("#qtyy").val(),
			"contract_no" : contract_no,
			"matno" : matno
		},
		type : 'POST',
		dataType : 'json'
	}).done(function(data) {
		console.log(data);
	}).fail(function(data) {
		// console.log("error");
		// $("#pocreated").text(data['RETURN'][0]['MESSAGE'])
	}).always(function(data) {
		// console.log(data)
		$("#statsPO").text(data)
	});
	// else {
	// 	alert('Minimal 1 dan hanya angka!!')
	// 	$(elm).val($(elm).data('old'))
	// }
}

function chgPic(id, path) {
	//'.base_url(UPLOAD_PATH).'/material_strategis/'.
	$("#picSRC").attr('src', $("#base-url").val() + 'upload/EC_material_strategis/' + path)
}

function addCart(elm, matno, contract_no) {
	$.ajax({
		url : $("#base-url").val() + 'EC_Pricelist/addCart/' + matno,
		data : {
			"contract_no" : contract_no
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

function addCompare(elm, matno, contract_no) {
	console.log(matno + ' ' + contract_no)
	$.ajax({
		url : $("#base-url").val() + 'EC_Pricelist/addCompare/' + matno,
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
		console.log('cmp ' + data);
	});
}

function getCategory(KODE_USER) {
	// $.ajax({
	// url : $("#base-url").val() + 'EC_Ecatalog/listCatalog/' + KODE_USER,
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
	return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}


$('#modalpenyedia').on('show.bs.modal', function(event) {
	var button = $(event.relatedTarget)
	var vendor_no = button.data('vendor')
	//var id = button.data('id')
	//var modal = $(this)
	$.ajax({
		url : $("#base-url").val() + 'EC_Pricelist/getVendorNo/' + vendor_no,
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
		url : $("#base-url").val() + 'EC_Pricelist/getPrincipal/' + pc_code,
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
		url : $("#base-url").val() + 'EC_Pricelist/getDetail/' + MATNR,
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
		url : $("#base-url").val() + 'EC_Pricelist/get_data_tree/',
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
		console.log("error");
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
	range_harga = ['-', '-']
	base_url = $("#base-url").val()
	searctTag = $("#tag").val()
	kodeParent = id
	// console.log(id)
	if (id == '-') {
		kodeParent = "-"
		urlll = '/get_data/'
	}
	loadDataList();
}


$(document).ready(function() {
	

	loadTree();
	//$("#divAttributes").append('')
		
	// $('.datepicker').datepicker({

	// });

	// $('.col-sm-4 input span').datepicker({
	// 	format: "dd/mm/yyyy",
	// 	autoclose: true
	// });


	//   $('.input-group .date').datepicker({
	// //format: "dd/mm/yyyy"
	//   });
	// loadDataList();
	// console.log("base_url " + base_url)
	$('label.tree-toggler').click(function() {
		$(this).parent().children('ul.tree').toggle(300);
	});
	/***********************************************/
	// $.ajax({
	// 	url : $("#base-url").val() + 'EC_Pricelist/get_data_cart/',
	// 	type : 'POST',
	// 	dataType : 'json'
	// }).done(function(data) {
	// 	console.log(data);
	// 	$(".jml").text(data.jumlah);
	// 	$(".budget").text(numberWithCommas(data.budget));
	// 	$(".jmlCompare").text(data.compare)

	// 	$(".budget").attr('title', 'cart: ' + numberWithCommas(data.total))
	// 	$('.budget').tooltip();

	// 	$('#tbody').empty()
	// 	$('#tbody').append('<tr>')
	// 	$('#tbody').append('<td> </td>')
	// 	$('#tbody').append('<td> </td>')
	// 	$('#tbody').append('<td> </td>')
	// 	$('#tbody').append('<td> </td>')
	// 	$('#tbody').append('<td>' + numberWithCommas(data.current_budget) + '</td>')
	// 	$('#tbody').append('<td>' + numberWithCommas(data.commit_budget) + '</td>')
	// 	$('#tbody').append('<td>' + numberWithCommas(data.actual_budget) + '</td>')
	// 	$('#tbody').append('<td>' + numberWithCommas(data.budget) + '</td>')
	// 	$('#tbody').append('<td>' + numberWithCommas(data.total) + '</td>')
	// 	$('#tbody').append('</tr>')
	// 	if (window.location.pathname.indexOf('checkout') > -1) {
	// 		$("#budgett").text('Rp ' + numberWithCommas(data.budget));
	// 		$("#hid_current_budget").val(data.budget);
	// 	}
	// 	/*
	// 	 $('.pagination').empty()
	// 	 $('.pagination').append('<li><a href="javascript:paginationPrev()" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>')
	// 	 for (var i = 0; i < Math.ceil(data.page / 10); i++) {
	// 	 $('.pagination').append('<li><a href="javascript:pagination(' + (i * 10) + ',' + ((i + 1) * 10) + ')">' + (i + 1) + '</a></li>')
	// 	 }
	// 	 $('.pagination').append('<li><a href="javascript:paginationNext()" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>')
	// 	 pageMax = Math.ceil(data.page / 10)*/

	// }).fail(function() {
	// 	// console.log("error");
	// }).always(function(data) {
	// 	//console.log(data);
	// });
	/***********************************************/
	// if (window.location.pathname.indexOf('listCatalog') > -1) {
	// 	$.ajax({
	// 		url : $("#base-url").val() + 'EC_Ecatalog/rangeHarga/ssssssssssss',
	// 		type : 'POST',
	// 		dataType : 'json'
	// 	}).done(function(data) {
	// 		// console.log('range ' + data[0].MAX + "-" + data[0].MIN);
	// 		$("#ex2").slider({
	// 			min : parseInt(data[0].MIN),
	// 			max : parseInt(data[0].MAX),
	// 			value : [parseInt(data[0].MAX / 4), parseInt(data[0].MIN / 4)],
	// 			step : 10
	// 		})
	// 		// $("#ex2").data('slider').setValue([data[0].MAX, data[0].MIN])
	// 	}).fail(function() {
	// 		// console.log("error");
	// 	}).always(function(data) {
	// 		//console.log(data);
	// 	});

	// 	$("#ex2").on("slideStop", function(slideEvt) {
	// 		$("#txtharga").val(numberWithCommas(slideEvt.value[0]) + " - " + numberWithCommas(slideEvt.value[1]))
	// 		// console.log(slideEvt.value)
	// 	});
	// 	$("#btnTampilkan").on("click", function() {
	// 		range_harga = $("#ex2").data('slider').getValue()
	// 		console.log($("#ex2").data('slider').getValue())
	// 		base_url = $("#base-url").val()
	// 		kodeParent = $("#kodeParent").val()
	// 		searctTag = $("#tag").val();
	// 		loadDataList()
	// 	})
	// 	$("#removeTAG").on("click", function() {
	// 		$("#txtsearch").val('');
	// 	})
	// }
});
