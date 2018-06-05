var base_url = $('#base-url').val(),
    undo = removeDot(removeCommas($('.hraga_terakhir:eq(0)').text()));
$(document).ready(function() {

	var timeServer = $("#Tanggal").val();
	var timeServer2 = $("#Tanggal2").val();
	var tgl_buka = $("#TGL_BUKA").text();
	var tgl_tutup = $("#TGL_TUTUP").text();
	var date1 = tgl_buka.substring(6, 10) + '/' + tgl_buka.substring(3, 5) + '/' + tgl_buka.substring(0, 2) + ' ' + tgl_buka.substring(11, 13) + ':' + tgl_buka.substring(14, 16) + ':' + tgl_buka.substring(17, 19);
	console.log('date1 ' + date1);
	var date2 = tgl_tutup.substring(6, 10) + '/' + tgl_tutup.substring(3, 5) + '/' + tgl_tutup.substring(0, 2) + ' ' + tgl_tutup.substring(11, 13) + ':' + tgl_tutup.substring(14, 16) + ':' + tgl_tutup.substring(17, 19);
	console.log('date2 ' + date2);
	var start = new Date(tgl_buka.substring(6, 10), tgl_buka.substring(3, 5), tgl_buka.substring(0, 2), tgl_buka.substring(11, 13), tgl_buka.substring(14, 16), tgl_buka.substring(17, 19), 0);
	var end = new Date(tgl_tutup.substring(6, 10), tgl_tutup.substring(3, 5), tgl_tutup.substring(0, 2), tgl_tutup.substring(11, 13), tgl_tutup.substring(14, 16), tgl_tutup.substring(17, 19), 0);
	var timetoday = new Date(timeServer2.substring(6, 10), timeServer2.substring(3, 5), timeServer2.substring(0, 2), timeServer2.substring(11, 13), timeServer2.substring(14, 16), timeServer2.substring(17, 19), 0);
	var diff = (end.getTime() / 1000) - (start.getTime() / 1000);
	if (timeServer > date1 && timeServer < date2)
		var diff = (end.getTime() / 1000) - (timetoday.getTime() / 1000);
	var clocks = $('.your-clock').FlipClock(diff, {
		clockFace : 'MinuteCounter',
		autoStart : false,
		callbacks : {
			interval : function() {
				var time = clocks.getTime().time;
				// console.log(time);
				if (time == 0) {
					clearInterval(timeInterval3)
					$('#submit').remove()
					$('.your-clock').hide();
					$("#SUDAH").show();
				}
			}
		},
		countdown : true
	});
	$('#freeze').remove();
	$('#loading').remove();
	mulai = 1
	var timeInterval3 = setInterval(function() {
		piala($('#no_tender').text());
		$.ajax({
			url : $("#base-url").val() + 'EC_Auction_negotiation/getTimeServer/',
			type : 'POST',
			dataType : 'json'
		}).always(function(data) {
			if (data > date1 && data < date2) {
				if (mulai == 1) {
					mulai = 2
					clocks.start();
					$('#submit').show()
					console.log('kusam')
				}
				$("#BELUM").hide();
				$("#SUDAH").hide();
				//console.log('ok');
			} else if (data > date1 && data > date2) {
				$("#BELUM").hide();
				$('#submit').remove()
				$('.your-clock').remove()
				$("#SUDAH").show();
			} else {
				$("#SUDAH").hide();
				$("#BELUM").show();
				$('#submit').hide()
				console.log('salah');
			}
		})
	}, 1000);

	$('.btn_decrease').click(function() {
		if (parseInt(removeDot(removeCommas($('#penawaran').val()))) - (parseInt(removeDot($('#pengurangan').text())) * parseInt($(this).text())) > 0)
			$('#penawaran').val(numberWithCommas(parseInt(removeDot(removeCommas($('#penawaran').val()))) - (parseInt(removeDot($('#pengurangan').text())) * parseInt($(this).text()))))
	});
	$('#submit').click(function() {
		undo = removeDot(removeCommas($('#penawaran').val()))
		bid($('#no_tender').text())
		$('.hraga_terakhir').text($('#penawaran').val())
	});
	$('#undo').click(function() {
		$('#penawaran').val(numberWithCommas(undo))
	});
});
function piala(no_tender) {
	$.ajax({
		url : $("#base-url").val() + 'EC_Auction_negotiation/piala/' + no_tender,
		type : 'POST',
		dataType : 'json'
	}).always(function(data) {
		// console.log(data)
		if (data)
			$(".piala").removeClass('hidden')
		else
			$(".piala").addClass('hidden')
	})
}

function bid(no_tender) {
	$.ajax({
		url : $("#base-url").val() + 'EC_Auction_negotiation/bid/' + no_tender + '/' + removeDot(removeCommas($('#penawaran').val())),
		type : 'POST',
		dataType : 'json'
	}).always(function(data) {
		console.log(data)
		if (data.STATUS == 'ece')
			$(".label_ece").removeClass('hidden')
		else
			$(".label_ece").addClass('hidden')
	})
}

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
