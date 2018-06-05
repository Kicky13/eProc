function removeCommas(x){
    return Number(x.replace(/,/g, ""));
}
var timer;

function Hide() {
  // timer = setTimeout(
  //   function() {
  //     tr.find(".label_new").hide(200);
  //   }, 2000);
}

function clearTime(){
	clearTimeout(timer);
}


function updateRangking(){
	var rangking=1;
	var rows = $('.table-vendor tbody  tr.tr_vnd');
	rows.each(function(){
		$(this).children('td').eq(0).html(rangking);		
		rangking++;
	});
}

function sortTable(){
	  var rows = $('.table-vendor tbody  tr').get();
	  // console.log(rows);

	  rows.sort(function(a, b) {

	  var A = removeCommas($(a).children('td.harga_terkini').text());
	  var B = removeCommas($(b).children('td.harga_terkini').text());

	  // console.log(B);


	  if(A < B) {
	    return -1;
	  }

	  if(A > B) {
	    return 1;	    
	  }

	  return 0;

	  });
	  
	  $.each(rows, function(index, row) {	  			  	
	    $('.table-vendor').children('tbody').append(row);
	  });
}

var base_url = $('#base-url').val();
function initializeClock(endTime,startTime) {
			var clock = $('#time_remaining');
			var currentTime;
		 	$.getJSON(base_url+'Auction/getCurrentTime', function(data, textStatus) {
				var data = new Date(data);
				currentTime = data;
			});
		 	
		 	
			var timeInterval = setInterval(function() {
				var t = getTimeRemaining(endTime,currentTime);

				var s = getTimeRemaining(startTime,currentTime);
				if (s.total <= 0) {
					$('.countdownmonitor').show();
					$('.mulaimonitor').hide();
				};
				currentTime = new Date(currentTime.valueOf() + 1000);
				var textTimer = $('.timer');
				$(textTimer[0]).text(t.days);
				$(textTimer[1]).text(t.hours);
				$(textTimer[2]).text(t.minutes);
				$(textTimer[3]).text(t.seconds);
				if (t.total <= 0) {
					$('.countdownmonitor').hide();
					$('.selesaimonitor').show();
					clearInterval(timeInterval);
					$('.tombolmonitor').show();
					// alert($('#status').val());
					if($('#status').val() == 'sedang' || $('#status').val() == 'belum'){
						$('.back-btn').attr('href',base_url+'Auction/index/proses');
					} else if($('#status').val() == 'selesai'){
						$('.back-btn').attr('href',base_url+'Auction/index/tutup');
					} else if($('#status').val() == 'sudah'){
						$('.back-btn').attr('href',base_url+'Auction/index/history');
					}
					//$('#btn-close').addClass("hidden");
					// setTimeout(function() {
					 	$('#btn-close').removeClass("hidden");
					// }, 1000);
				}else{					
					$('.back-btn').attr('href',base_url+'Auction/index/proses');
				}	;
			}, 1000);
		}

		var intervalUpdatePrice = setInterval(function() {
			$.ajax({
				url: base_url+'Auction/getCurrentPrice/'+$("#paqh_id").val(),
				type: 'POST',
				dataType: 'json',
				beforeSend: function() {
			        $('#loading').hide();
					$('#freeze').hide();
			    },
			})
			.done(function(data) {
				paqd = data.paqd;
				trmin = null;
				minval = Infinity;
				for (var i = paqd.length - 1; i >= 0; i--) {
					each = paqd[i];
					tr = null;
					$(".vendor_code").each(function() {
						if ($(this).val() == each.PTV_VENDOR_CODE) {
							tr = $(this).parent().parent();
						}
					});
					if (tr == null) {
						// console.log('kok null ya?');
						break;
					}
					terkini = tr.find('.harga_terkini');
					if (terkini.html() == each.PAQD_FINAL_PRICE) {
						ece = $(".ece").val();
						if(ece > removeCommas(each.PAQD_FINAL_PRICE)){
							tr.find(".label_ece").show(200);
							// tr.find(".label_ece").data('counter', 10);
						}
						$labelnew = tr.find(".label_new");
						$labelnew.data('counter', $labelnew.data('counter') - 1);
						if ($labelnew.data('counter') == 0) {
							$labelnew.hide(200);
						}
					} else {
						clearTime();
						ece = $(".ece").val();
						if(ece >= removeCommas(each.PAQD_FINAL_PRICE)){
							tr.find(".label_ece").show(200);
						}
						terkini.html(each.PAQD_FINAL_PRICE);
						// tr.find(".label_new").hide(200);
						tr.find(".label_new").data('counter', 13);
						tr.find(".label_new").show(200);
						// Hide();
					}
					if (minval > removeCommas(each.PAQD_FINAL_PRICE)) {
						minval = removeCommas(each.PAQD_FINAL_PRICE);
						trmin = tr;
					}
					tr.removeClass('success');
					sortTable();
					updateRangking();					
				};
				//trmin.addClass('success');
			})
			.fail(function() {
				// console.log("error");
			})
			.always(function(data) {
				//console.log(data);
				if($('#status').val() == 'sedang' || $('#status').val() == 'belum'){
					$('.back-btn').attr('href',base_url+'Auction/index/proses');
				} else if($('#status').val() == 'selesai'){
					$('.back-btn').attr('href',base_url+'Auction/index/tutup');
					$('#btn-close').removeClass("hidden");
				} else if($('#status').val() == 'sudah'){
					$('.back-btn').attr('href',base_url+'Auction/index/history');
				}				
			});
			
		}, 500);
		
		function getTimeRemaining (endtime,currentTime) {
			var t = endtime - currentTime;
			var seconds = Math.floor((t/1000) % 60);
			var minutes = Math.floor((t/1000/60) % 60);
			var hours = Math.floor((t/(1000*60*60)) % 24);
			var days = Math.floor(t/(1000*60*60*24));
			seconds = (seconds > 0) ? seconds : 0;
			minutes = (minutes > 0) ? minutes : 0;
			hours = (hours > 0) ? hours : 0;
			days = (days > 0) ? days : 0;
			return {
				'total': t,
				'days': days,
				'hours': hours,
				'minutes': minutes,
				'seconds': seconds
			}
		};
		
$(document).ready(function(){	
	$(".label_new").hide();
	$(".label_new").removeClass('hidden');
	$(".label_ece").hide();
	$(".label_ece").removeClass('hidden');
	$('#btn-close').addClass("hidden");
	// $('.tombolmonitor').hide();
	$('.tombolmonitor').show();
	$('.mulaimonitor').hide();
	$('.selesaimonitor').hide();
	$('.countdownmonitor').hide();
	if($('#status').val() == 'selesai'){
		$('.selesaimonitor').show();
	} else {
		if($('#status').val() == "proses"){
			$('.mulaimonitor').show();
		}
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
		console.log($('#PAQH_AUC_START').val());
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
		initializeClock(dead, start);
	}
});