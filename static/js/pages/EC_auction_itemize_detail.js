var editor_style = "replace";
CKEDITOR.replace( 'Note' );

function numberWithCommas(x) {
	if (isNaN(x))
		return x;
	var parts = x.toString().split(".");
	parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
	return parts.join(".");
}

function removeCommas(x) {
	return x.replace(/,/g, "");
}

function removeDot(x) {
	return x.replace(/\./g, "");
}

function showItem(NO_TENDER, NO_BATCH) {
	$.ajax({
		url : $("#base-url").val() + 'EC_Auction_itemize/get_item/' + NO_TENDER+'/'+NO_BATCH,
		data : {
		},
		type : 'POST',
		dataType : 'json'
	}).done(function(data) {
		//alert('a');
		$("#item").empty()
		if (data.data.length == 0)
			$("#item").append('<div class="row text-center">Data Tidak Ditemukan!!</div>')
		else
			for (var i = 0; i < data.data.length; i++) {
				teks = '<tr style="border-bottom: 1px solid #ccc;">'
				teks += '<td class="text-left">' + (i + 1) + '</td>'
				teks += '<td class="text-left">' + data.data[i][2] + '</td>'
				teks += '<td class="text-left">' + data.data[i][3] + '</td>'
				teks += '<td class="text-center">' + data.data[i][4] + '</td>'
				teks += '<td class="text-center">' + data.data[i][5] + '</td>'
				teks += '<td class="text-center">' + data.data[i][9] + '</td>'
				teks += '<td class="text-center">' + data.data[i][8] + ' ' + numberWithCommas(data.data[i][6]) + '</td>'
				teks += '<td class="text-center">' + data.data[i][8] + ' ' + numberWithCommas(data.data[i][7]) + '</td>'
				teks += '/<tr>'
				$("#item").append(teks);
			}
		}).fail(function() {
		//alert('b');
		// console.log("error");
	}).always(function(data) {
		//alert('c');
		// console.log(data);
	});
}

function showPeserta(NO_TENDER, NO_BATCH) {
	$.ajax({
		url : $("#base-url").val() + 'EC_Auction_itemize/getListpeserta/' + NO_TENDER + '/' + NO_BATCH,
		data : {
		},
		type : 'POST',
		dataType : 'json'
	}).done(function(data) {
		//alert('a');
		$("#peserta").empty()
		if (data.data.length == 0)
			$("#peserta").append('<div class="row text-center">Data Tidak Ditemukan!!</div>')
		else
			for (var i = 0; i < data.data.length; i++) {
				teks = '<tr style="border-bottom: 1px solid #ccc;">'
				teks += '<td class="text-left">' + (i + 1) + '</td>'
				teks += '<td class="text-left">' + data.data[i][1] + '</td>'
				teks += '<td class="text-left">' + data.data[i][2] + '</td>'
				teks += '<td class="text-center">' + data.data[i][3] + '</td>'
				teks += '<td class="text-center">' + data.data[i][4] + '</td>'
				// teks += '<td class="text-center">' + data.data[i][5] + '%</td>'
				teks += '<td class="text-center">IDR ' + numberWithCommas(data.data[i][6]) + '</td>'
				teks += '/<tr>'
				$("#peserta").append(teks);
			}
		}).fail(function() {
		//alert('b');
		// console.log("error");
	}).always(function(data) {
		//alert('c');
		// console.log(data);
	});
}

// function showListPeserta(NO_TENDER) {
// 	$.ajax({
// 		url : $("#base-url").val() + 'EC_Auction_itemize/get_Peserta/' + NO_TENDER,
// 		data : {
// 		},
// 		type : 'POST',
// 		dataType : 'json'
// 	}).done(function(data) {

// 		$("#Peserta").empty()
// 		if (data.data.length == 0)
// 			$("#Peserta").append('<div class="row text-center">Data Tidak Ditemukan!!</div>')
// 		else
// 			for (var i = 0; i < data.data.length; i++) {
// 				teks = '<tr style="border-bottom: 1px solid #ccc;">'
// 				teks += '<td class="text-left">' + (i + 1) + '</td>'
// 				teks += '<td class="text-left">' + data.data[i][1] + '</td>'
// 				teks += '<td class="text-left">' + data.data[i][2] + '</td>'
// 				teks += '<td class="text-left">' + data.data[i][3] + '</td>'
// 				// teks += '<td class="text-center">' + $("#CURR").text() + ' ' + numberWithCommas(data.data[i][3]) + '</td>'
// 				// teks += '<td class="text-center">' + $("#CURR").text() + ' ' + numberWithCommas(data.data[i][4]) + ' ' + (parseInt(data.data[i][4]) < parseInt(removeDot($("#hps").text())) ? '<img width="8%" height="8%" src="' + $("#base-url").val() + '/upload/EC_auction/giphy.gif" />' : "") + '</td>'
// 				teks += '/<tr>'
// 				$("#Peserta").append(teks);
// 			}
// 		}).fail(function() {
// 		// console.log("error");
// 	}).always(function(data) {
// 		// console.log(data);
// 	});
// }

function showOlehRanking(NO_TENDER, NO_BATCH) {
	$.ajax({
		url : $("#base-url").val() + 'EC_Auction_itemize/resultOlehRanking',
		data : {
			NO_TENDER: NO_TENDER,
			NO_BATCH: NO_BATCH
		},
		type : 'POST',
		dataType : 'html'
	}).done(function(data) {
		$('#resultOlehRanking').html(data);
	}).fail(function() {
		//alert('b');
		// console.log("error");
	}).always(function(data) {
		//alert('c');
		// console.log(data);
	});
}

function reportOlehRanking(NO_TENDER, NO_BATCH) {
	$.ajax({
		url : $("#base-url").val() + 'EC_Auction_itemize/reportOlehRanking',
		data : {
			NO_TENDER: NO_TENDER,
			NO_BATCH: NO_BATCH
		},
		type : 'POST',
		dataType : 'html'
	}).done(function(data) {
		$('.reportOlehRanking').html(data);
	}).fail(function() {
		//alert('b');
		// console.log("error");
	}).always(function(data) {
		//alert('c');
		// console.log(data);
	});
}

function showLog(NO_TENDER, NO_ITEM) {
	$.ajax({
		url : $("#base-url").val() + 'EC_Auction_itemize/getLog/' + NO_TENDER +'/'+ NO_ITEM,
		data : {
		},
		type : 'POST',
		dataType : 'json'
	}).done(function(data) {
		$("#Log").empty()
		if (data.length == 0)
			$("#Log").append('<div class="row text-center">Data Tidak Ditemukan!!</div>')
		else
			for (var i = 0; i < data.length; i++) {
				teks = '<tr style="border-bottom: 1px solid #ccc;">'
				teks += '<td class="text-left">' + (i + 1) + '</td>'
				teks += '<td class="text-left">' + data[i].TGL + '</td>'
				teks += '<td class="text-left">' + data[i].ITER + '</td>'
				teks += '<td class="text-center">' + data[i].NAMA_VENDOR + ' (' + data[i].VENDOR_NO + ')</td>'
				teks += '<td class="text-center">' + data[i].CURRENCY + ' ' + numberWithCommas(data[i].PRICE) + '</td>'
				teks += '<td class="text-center">' + ((parseInt(data[i].PRICE) * parseInt(data[i].KONVERSI)) < parseInt(removeDot(data[i].HPS)) ? "YA" : "") + '</td>'
				teks += '/<tr>'
				$("#Log").append(teks);
			}
		}).fail(function() {
		// console.log("error");
	}).always(function(data) {
		// console.log(data);
	});
}

function cetak(NO_TENDER , NAME) {
	for ( instance in CKEDITOR.instances ){
		CKEDITOR.instances[instance].updateElement();
	}
	$.ajax({
		url : $("#base-url").val() + 'EC_Auction_itemize/save_note/' + NO_TENDER + '/' + NAME,
		data : {
			NOTE : $('#Note').val()
		},
		type : 'POST',
		dataType : 'json'
	}).done(function(data) {

	}).fail(function() {
		// console.log("error");
	}).always(function(data) {
		// console.log(data);
		// location.reload();
		window.open($("#base-url").val() + 'EC_Auction_itemize/print_e_auction2/' + NO_TENDER + '/' + NAME, "_blank");
	});

}


$(document).ready(function() {
	// $('[data-toggle="tooltip"]').tooltip(); 
	$('body').on('click', '.btn-Log', function()
	{
		$("#tbh-Log").modal() 
		id_tender = $(this).attr('data-tender');
		id_item = $(this).attr('data-id');
		id_link = $('#id_link').val();
		console.log('clicked');
		var a = document.getElementById('yourlinkId'); //or grab it by tagname etc
		a.href = id_link+'/'+id_item;

		$('#id_item').val(id_item);
		$('#id_tender').val(id_tender);
		showLog(id_tender, id_item);

	});
	console.log($("#TGL_BUKA").text() + " - " + $("#TGL_TUTUP").text())

	$('.input-group.date').datetimepicker({
		format : 'DD/MM/YYYY HH:mm:ss',
		// sideBySide: true,
		ignoreReadonly : true
		//, minDate : new Date()
	});

	$('.input-group.date input').attr("readonly", true);
	$("#TGL_BUKAedit").val($("#TGL_BUKA").text())
	$("#TGL_TUTUPedit").val($("#TGL_TUTUP").text())

	
	showPeserta($("#NO_TENDER").text(), $("#nobatch").text());
	showItem($("#NO_TENDER").text(), $("#nobatch").text());
	showOlehRanking($("#NO_TENDER").text(), $("#nobatch").text());
	reportOlehRanking($("#NO_TENDER").text(), $("#nobatch").text());
	//showListPeserta($("#NO_TENDER").text());
	
	$("#editBTN").hide();
	var stat = $("#statusAuction").val()
	$("#Cetak22").hide();

	//**
	var timeServer = $("#Tanggal").val();
	var timeServer2 = $("#Tanggal2").val();
	var tgl_buka = $("#TGL_BUKA").text();
	var tgl_tutup = $("#TGL_TUTUP").text();
	var date1 = tgl_buka.substring(6, 10) + '/' + tgl_buka.substring(3, 5) + '/' + tgl_buka.substring(0, 2) + ' ' + tgl_buka.substring(11, 13) + ':' + tgl_buka.substring(14, 16) + ':' + tgl_buka.substring(17, 19);
	var date2 = tgl_tutup.substring(6, 10) + '/' + tgl_tutup.substring(3, 5) + '/' + tgl_tutup.substring(0, 2) + ' ' + tgl_tutup.substring(11, 13) + ':' + tgl_tutup.substring(14, 16) + ':' + tgl_tutup.substring(17, 19);
	var start = new Date(tgl_buka.substring(6, 10), tgl_buka.substring(3, 5), tgl_buka.substring(0, 2), tgl_buka.substring(11, 13), tgl_buka.substring(14, 16), tgl_buka.substring(17, 19), 0);
	var end = new Date(tgl_tutup.substring(6, 10), tgl_tutup.substring(3, 5), tgl_tutup.substring(0, 2), tgl_tutup.substring(11, 13), tgl_tutup.substring(14, 16), tgl_tutup.substring(17, 19), 0);
	var timetoday = new Date(timeServer2.substring(6, 10), timeServer2.substring(3, 5), timeServer2.substring(0, 2), timeServer2.substring(11, 13), timeServer2.substring(14, 16), timeServer2.substring(17, 19), 0);
	var diff = (end.getTime() / 1000) - (start.getTime() / 1000);
	if (timeServer > date1 && timeServer < date2)
		var diff = (end.getTime() / 1000) - (timetoday.getTime() / 1000);
	var clocks = $('.my-clock').FlipClock(diff, {
		clockFace : 'MinuteCounter',
		autoStart : false,
		callbacks : {
			interval : function() {
				var time = clocks.getTime().time;
				// console.log(time);
				if (time == 0) {
					// clearInterval(timeInterval3)
					$('#submit').remove()
					$('.my-clock').hide();
					$("#SELESAI").show();
					$("#editBTN").show();
					$("#closeBTN").show();
				}
			}
		},
		countdown : true
	});
	mulai = 1
	var timeInterval3 = setInterval(function() {
		// console.log('tik')

		id_item = $('#id_item').val();
		id_tender = $('#id_tender').val();
		
		$.ajax({
			url : $("#base-url").val() + 'EC_Auction_itemize_negotiation/getTimeServer/',
			type : 'POST',
			dataType : 'json'
		}).always(function(data) {
			if (data > date1 && data < date2 && stat == 1) {
				if (mulai == 1) {
					mulai = 2
					clocks.start();
					console.log('kusam')
				}
				$("#Cetak22").hide();
				$("#BELUM").hide();
				$("#editBTN").show();
				$("#CLOSED").hide();
				$("#SELESAI").hide();
				$("#closeBTN").hide();
				showOlehRanking($("#NO_TENDER").text(), $("#nobatch").text());
				reportOlehRanking($("#NO_TENDER").text(), $("#nobatch").text());
				//console.log('ok');
			} else if (data > date1 && data > date2 && stat == 1) {
				// clearInterval(timeInterval3)
				$("#BELUM").hide();
				$("#CLOSED").hide();
				$('.my-clock').hide()
				$("#SELESAI").show();
				$("#closeBTN").show();
				$("#editBTN").show();
			} else if (stat == 0) {
				// clearInterval(timeInterval3)
				$("#BELUM").hide();
				$("#closeBTN").hide();
				$("#editBTN").hide();
				$("#SELESAI").hide();
				$("#CLOSED").show();
				$('.my-clock').hide()
				$("#Cetak22").show();
			} else {
				// clearInterval(timeInterval3)
				$("#SELESAI").hide();
				$("#BELUM").show();
				$("#CLOSED").hide();
				$("#closeBTN").hide();
				$("#editBTN").show();
				console.log('blm');
			}
		})

		//showListPeserta($("#NO_TENDER").text());
		
		// if(id_item!="" && id_item!=""){
		// 	showLog(id_tender, id_item);
		// }

	}, 1000);
	//*/
	/*

	 var timeInterval3 = setInterval(function() {
	 // showItem($("#NO_TENDER").text());
	 showListPeserta($("#NO_TENDER").text());
	 showLog($("#NO_TENDER").text());
	 }, 1000);

	 var timeServer = $("#Tanggal").val();
	 console.log('timeServer ' + timeServer);

	 var timeServer2 = $("#Tanggal2").val();
	 console.log('timeServer2 ' + timeServer2);

	 var tgl_buka = $("#TGL_BUKA").text();
	 var tgl_tutup = $("#TGL_TUTUP").text();
	 //console.log(tgl_buka);
	 //console.log(tgl_tutup);

	 var date1 = tgl_buka.substring(6, 10) + '/' + tgl_buka.substring(3, 5) + '/' + tgl_buka.substring(0, 2) + ' ' + tgl_buka.substring(11, 13) + ':' + tgl_buka.substring(14, 16) + ':' + tgl_buka.substring(17, 19);
	 console.log('date1 ' + date1);
	 var date2 = tgl_tutup.substring(6, 10) + '/' + tgl_tutup.substring(3, 5) + '/' + tgl_tutup.substring(0, 2) + ' ' + tgl_tutup.substring(11, 13) + ':' + tgl_tutup.substring(14, 16) + ':' + tgl_tutup.substring(17, 19);
	 console.log('date2 ' + date2);
	 //29/12/2016 16:45:00

	 if (timeServer > date1 && timeServer < date2 && stat == 1) {
	 var start = new Date(tgl_buka.substring(6, 10), tgl_buka.substring(3, 5), tgl_buka.substring(0, 2), tgl_buka.substring(11, 13), tgl_buka.substring(14, 16), tgl_buka.substring(17, 19), 0);
	 var end = new Date(tgl_tutup.substring(6, 10), tgl_tutup.substring(3, 5), tgl_tutup.substring(0, 2), tgl_tutup.substring(11, 13), tgl_tutup.substring(14, 16), tgl_tutup.substring(17, 19), 0);
	 var timetoday = new Date(timeServer2.substring(6, 10), timeServer2.substring(3, 5), timeServer2.substring(0, 2), timeServer2.substring(11, 13), timeServer2.substring(14, 16), timeServer2.substring(17, 19), 0);
	 //console.log(start);
	 //console.log(end);
	 // var start = new Date(2016, 12, 29, 9, 9, 0, 0);
	 // var end = new Date(2016, 12, 29, 9, 10, 0, 0);
	 var diff = (end.getTime() / 1000) - (timetoday.getTime() / 1000);

	 var clocks = $('.my-clock').FlipClock(diff, {
	 clockFace : 'MinuteCounter',
	 autoStart : false,
	 callbacks : {
	 interval : function() {
	 var time = clocks.getTime().time;
	 // console.log(time);
	 if (time == 0) {
	 clearInterval(timeInterval3)
	 $('#submit').remove()
	 $('.my-clock').hide();
	 $("#SELESAI").show();
	 $("#editBTN").show();
	 $("#closeBTN").show();
	 }
	 }
	 },
	 countdown : true
	 });
	 clocks.start();
	 $("#Cetak22").hide();
	 $("#BELUM").hide();
	 $("#CLOSED").hide();
	 $("#SELESAI").hide();
	 $("#closeBTN").hide();
	 //console.log('ok');
	 } else if (timeServer > date1 && timeServer > date2 && stat == 1) {
	 clearInterval(timeInterval3)
	 $("#BELUM").remove();
	 $("#CLOSED").remove();
	 $("#SELESAI").show();
	 $("#closeBTN").show();
	 $("#editBTN").show();
	 } else if (stat == 0) {
	 clearInterval(timeInterval3)
	 $("#BELUM").remove();
	 $("#closeBTN").remove();
	 $("#editBTN").remove();
	 $("#SELESAI").remove();
	 $("#CLOSED").show();
	 $("#Cetak22").show();
	 } else {
	 clearInterval(timeInterval3)
	 $("#SELESAI").remove();
	 $("#BELUM").show();
	 $("#CLOSED").remove();
	 $("#closeBTN").remove();
	 $("#editBTN").show();
	 console.log('blm');
	 }

	 */

	 $('#freeze').remove();
	 $('#loading').remove();

	})