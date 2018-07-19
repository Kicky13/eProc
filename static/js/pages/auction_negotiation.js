function numberWithCommas(x) {
	var parts = x.toString().split(".");
	parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	return parts.join(".");
}

function removeCommas(x) {
    return x.replace(/,/g, "");
}

// function errorjs() {
// 	$(".panel_waktu").hide();
// 	$(".panel_bidder").hide();
// 	alert('Error. Try using uptodate chrome web browser.')
// 	console.log('Error. Try using uptodate chrome web browser.')
// }

var base_url = $('#base-url').val();
$(document).ready(function(){

	$('.btn_decrease').click(function(){
		var set_decrease = $('#dec_val').val();
		var bid_now = $('#harga_bid').val();
		var times = $(this).html();
		var end_val = Number(bid_now) - Number(set_decrease) * Number(times);
		if(Number(end_val) > 0){
			$('#harga_bid').val(end_val);	
			$('#harga_bids').val(numberWithCommas(end_val));
		}
	});

	$('#btn_increase').click(function(){
		penawaran_akhir = $('#penawaran_akhir').html().replace(/,/g, '');
		console.log(penawaran_akhir);
		$('#harga_bid').val(penawaran_akhir);
		$('#harga_bids').val(numberWithCommas(penawaran_akhir));
	});

	$('#btn_bid_submit').click(function(){
		inputpost = {
				paqh: $("#paqh").val(),
				tit_id: $("#tit_id").val(),
				bid: $('#harga_bid').val(),
				ptv_vendor_code: $('#vendor_code').val()
			};
		console.log(inputpost);
		$.ajax({
			type: 'POST',
			url: base_url+'Auction_negotiation/update_bid',
			data: inputpost,
			success: function(data) {
				// console.log(data);
				if (data == 'true') {
					$('#penawaran_akhir').text(numberWithCommas($('#harga_bid').val()));
					$('#hargapenawaran').html("Harga Terakhir: " + numberWithCommas($('#harga_bid').val()));
					var hargabid;
					var titprice;
					if($('#paqh_price_type').val()=='Harga Satuan'){
						hargabid=Number(removeCommas($('#penawaran_akhir').html()));
						titprice=Number($('#tot_sat_price').val());						
					}else if($('#paqh_price_type').val()=='Harga Total'){
						hargabid=Number(removeCommas($('#penawaran_akhir').html()));
						titprice=Number($('#tot_tit_price').val());						
					}
					console.log(hargabid+'|'+titprice);
					if( hargabid < titprice || hargabid == titprice){
						$(".label_ece").removeClass('hidden');
					}else{
						$(".label_ece").addClass('hidden');
					}
				} else {
					// console.log("Fail")
					// console.log(data)
				}
			}
		})
	});

	var endDate = $('#PAQH_AUC_END').val();
	endDate = endDate.split(' ');
	var date = endDate[0];
	date = date.split('-');
	date = date[1]+' '+date[0]+' 20'+date[2];
	var time = endDate[1];
	time = time.split('.');
	time = time[0]+':'+time[1]+':'+time[2];
	var deadline = date+' '+time;

	var startDate = $('#PAQH_AUC_START').val();
	startDate = startDate.split(' ');
	var date = startDate[0];
	date = date.split('-');
	date = date[1]+' '+date[0]+' 20'+date[2];
	var time = startDate[1];
	time = time.split('.');
	time = time[0]+':'+time[1]+':'+time[2];
	var startline = date+' '+time;

	var dead = new Date(deadline);
	var start = new Date(startline);
	var min = dead - start;

	initializeClock(dead);
	var currentTime;

	function initializeClock (endTime) {
		var clock = $('#time_remaining');
		data = $("#time").val();
		var data = new Date(data);
		currentTime = data;

		var timeInterval = setInterval(function() {
			var t = getTimeRemaining(endTime,currentTime);

			currentTime = new Date(currentTime.valueOf() + 1000);
			var textTimer = $('.timer');
			$(textTimer[0]).text(t.days);
			$(textTimer[1]).text(t.hours);
			$(textTimer[2]).text(t.minutes);
			$(textTimer[3]).text(t.seconds);
			if (t.total <= 0) {
				clearInterval(timeInterval);
				// $('.bid_button').fadeOut('slow');
				$('.bid_button').remove();
				$('.bid_button').hide();
				setTimeout(function() {
				}, 1000);
			};
		}, 1000);
	}
	
	function getTimeRemaining (endtime,currentTime) {
		// console.log(endtime)
		// console.log(currentTime)
		var t = endtime - currentTime;
		var seconds = Math.floor((t/1000) % 60);
		var minutes = Math.floor((t/1000/60) % 60);
		var hours = Math.floor((t/(1000*60*60)) % 24);
		var days = Math.floor(t/(1000*60*60*24));
		return {
			'total': t,
			'days': days,
			'hours': hours,
			'minutes': minutes,
			'seconds': seconds
		}
	}

	// function getSelisih(starttime, endtime){
	// 	var selisih = Date.parse(endtime) - Date.parse(starttime);
	// 	return selisih;
	// }

	var timeInterval2 = setInterval(function() {
		$.ajax({
			url: base_url+'Auction_negotiation/get_min_bid',
			type: 'POST',
			dataType: 'json',
			data: {paqh: $('#paqh').val()},
		})
		.done(function(data) {
			vc = data.PTV_VENDOR_CODE;
			// console.log(vc);
			if ($('#vendor_code').val() == vc) {
				$('#bidderContainer').removeClass('panel-default');
				$('#bidderContainer').addClass('panel-eproc-success');
				$('#win').slideDown('slow');
			}
			else {
				$('#bidderContainer').removeClass('panel-eproc-success');
				$('#bidderContainer').addClass('panel-default');
				$('#win').slideUp('slow');
			}
			var hargabid=0;
			var titprice=0;
			if($('#paqh_price_type').val()=='Harga Satuan'){
				hargabid=Number(removeCommas($('#penawaran_akhir').html()));
				titprice=Number($('#tot_sat_price').val());						
			}else if($('#paqh_price_type').val()=='Harga Total'){
				hargabid=Number(removeCommas($('#penawaran_akhir').html()));
				titprice=Number($('#tot_tit_price').val());						
			}
			console.log(hargabid+'|'+titprice);
			if( hargabid < titprice || hargabid == titprice){
				$(".label_ece").removeClass('hidden');
			}else{
				$(".label_ece").addClass('hidden');
			}
		})
		.always(function(data) {
			// console.log(data);
		});
		
	}, 1000);

	var timeInterval3 = setInterval(function() {
		$.ajax({
			url: base_url+'Auction_negotiation/getOpeningTime', // gawe sing oleh json waktu
			type: 'POST',
			dataType: 'json',
			data: {paqh: $('#paqh').val()},
		})
		.done(function(time) {
			time = time.split(' ');
			var date_start = time[0];
			date_start = date_start.split('-');
			date_start = date_start[1]+' '+date_start[0]+' 20'+date_start[2];
			var time_start = time[1];
			time_start = time_start.split('.');
			time_start = time_start[0]+':'+time_start[1]+':'+time_start[2];
			var startline = date_start+' '+time_start;
			var dateDiff = new Date(startline);
			dateDiff = dateDiff - currentTime;
			if (dateDiff >= 0) {
				$('.bid_button').hide();
			}
			else {
				if($("#countdown").hasClass("hidden")){
					$("#countdown").removeClass("hidden");
					$("#buttonsubmit").removeClass("hidden");
					$("#status_auction").addClass("hidden");
				}
				if (!$('.bid_button').is(":visible")) {
					$('.bid_button').show();
				}
			};
		});
	}, 1000);
});