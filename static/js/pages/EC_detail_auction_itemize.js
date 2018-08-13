base_url = $("#base-url").val();

function numberWithDot(x) {
	return x == null || x == "0" ? "" : x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}
function removeDot(x) {
	return x.replace(/\./g, "");
}

var t0 = true,
t1 = true,
t2 = true,
t3 = true,
t4 = true,
t5 = true,
t6 = true;
t7 = true;
function log(NO_TENDER,ID_PESERTA,ID_ITEM){

	$.ajax({
		url : $("#base-url").val() + 'EC_Auction_itemize_negotiation/getLog/' + NO_TENDER +'/'+ ID_PESERTA+'/'+ID_ITEM,
		data : {
		},
		type : 'POST',
		dataType : 'json'
	}).done(function(data) {
		
		$("#Log").empty()
		if (data.length == 0)
			$("#Log").append('<div class="row text-center">Data Tidak Ditemukan!!</div>')
			//$("#tbh-Log").modal() 
			else
				$("#tbh-Log").modal();
			for (var i = 0; i < data.length; i++) {
				teks = '<tr style="border-bottom: 1px solid #ccc;">'
				teks += '<td class="text-left">' + (i + 1) + '</td>'
				teks += '<td class="text-left">' + data[i].TGL + '</td>'
				teks += '<td class="text-left">' + data[i].ITER + '</td>'
				// teks += '<td class="text-center">' + data[i].NAMA_VENDOR + ' (' + data[i].VENDOR_NO + ')</td>'
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
	// alert(NO_TENDER+" "+ID_PESERTA+" "+ID_ITEM);
}
function loadTable() {
	// no = 1;
	var NO_TENDER = $('.NO_TENDER').val();
	var NO_BATCH = $('.NO_BATCH').val();
	var TYPE_RANKING = $('#type_ranking').val();
	mytable = $('#tableMT').DataTable({
		"bSort" : true,
		"info" : false,
		"scrollY" : "400px",
		"scrollCollapse": true,
		"dom" : 'rti',
		"deferRender" : true,
		"language" : {
			"loadingRecords" : "<center><b>Please wait - Loading Data...</b></center>"
		},
		"language": {
			"decimal": ",",
			"thousands": "."
		},
		"paging": false,
		// "lengthChange": true,
		// "lengthMenu": [ 10, 25, 50, 75, 100 ],
		//"scrollY": $( window ).height()/2,
		//"pagingType": "scrolling",

		"ajax" : $("#base-url").val() + 'EC_Auction_itemize_negotiation/get_data/'+NO_TENDER+'/'+NO_BATCH,

		"columnDefs" : [{
			"searchable" : false,
			"orderable" : true,
			// "targets" : 0
		}],
		"columns" : [{
			mRender : function(data, type, full) {
				if (full[11] != null){
					a = "<div class='col-md-12 text-center'>";
					a += full[11];
					// a += "<button type='button' class='btn btn-success btn-sm btn-Log' onclick='hahaha("+"'"+NO_TENDER+"'"+")'>Log</button>"
					a += "<button type='button' class='btn btn-success btn-sm btn-Log' onclick='log(\"" + NO_TENDER+ "\",\"" + full[14]+ "\",\"" + full[5]+ "\")'>Log</button>"
					a += "</div>";
					return a;
				} else
				return "";
			}
		}, {
			mRender : function(data, type, full) {
				// console.log(full);
				if (full[1] != null) {
					a = ''
					a += "<div class='col-md-12 text-center'>";
					a += full[1];
					a += "</div>";
					return a;
				} else
				return "";
			}
		},{
			mRender : function(data, type, full) {
				if (full[10] !=null){
					a = "<div class='col-md-12 text-center merk"+full[10].replace(/\s/g,'')+"'>";
					a += full[10];
					a += "</div>";
					return a;
				} else
				return "";
			}
		}, {
			mRender : function(data, type, full) {
				// console.log(full);
				if (full[7] != null) {
					a = ''
					a += "<div class='col-md-12 text-center'>";
					a += full[7];
					a += "</div>";
					return a;
				} else
				return "";
			}
		}, {
			mRender : function(data, type, full) {
				if (full[2] != null) {
					a = "<div class='col-md-12'>";
					a += full[6]+" "+numberWithDot(full[2]);
					a += "</div>";
					return a;
				} else
				return "";
			}
		}, {
			mRender : function(data, type, full) {
				if (full[3] != null) {
					a = ''
					a += '<div class="itemGanti2 itemGanti2'+full[5]+'" style="display:none;">'+numberWithDot(full[3])+'</div>';
					a += '<div class="col-md-12 itemGantiHtml itemGantiHtml'+full[5]+'">';
					a += "</div>";
					return a;
				} else
				return "";
			}
		}, {
			mRender : function(data, type, full) {
				if (full[3] != null) {
					a = "<div class='col-md-12 text-center'>";
					a += '<div class="itemGanti2 itemGanti2'+full[5]+'" style="display:none;">'+numberWithDot(full[3])+'</div>';
					a += '<input type="hidden" class="itemCur itemCur'+full[5]+'" value="'+full[6]+'">';
					a += '<input type="hidden" class="itemDefault itemDefault'+full[5]+'" value="'+full[2]+'">';
					a += '<input type="hidden" class="item item'+full[5]+'" value="'+full[3]+'">';
					a += '<input type="hidden" class="itemReset itemReset'+full[5]+'" value="'+full[3]+'">';
					a += '<input type="hidden" class="itemCheck itemCheck'+full[5]+'" value="'+full[10]+'">';
					a += '<input type="text" style="font-weight: bold; text-align: center;" class="itemGanti itemGanti'+full[5]+'" value="'+numberWithDot(full[3])+'" readonly>';
					a += "</div>";
					return a;
				} else
				return "";
			}
		}, {
			mRender : function(data, type, full) {
				a = ''
				a += "<div class='col-md-12 text-center' data-toggle='checkboxes' data-range='true'>";
				if(full[12]==""){
					a += '<input name="checkItem[]" type="checkbox" id="id_chk'+full[5]+'" class="chkbox '+full[10].replace(/\s/g,'')+'" value="'+full[5]+'" >'
				}
				a += "</div>";
				return a;
				//console.log(full[6]);
				// if (full[7] != ("0"))

				// else
				// 	return '<input value="' + full[1] + '" class="chk col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1" data-matnr="' + full[1] + '" onclick="chk(this)" type="checkbox">'
			}
		},{
			mRender : function(data, type, full) {
				if (TYPE_RANKING == 1){
					if (full[2] != null) {
						a = "<div class='col-md-12 text-center itemGambar itemGambar"+full[5]+"'>";
						a += full[8]+full[9];
						a += "</div>";
						return a;
					} else
					return "";
				} else {
					return "";
				}
			}
		}],
	});
	/*
	 class="btn btn-default btn-sm glyphicon glyphicon-check"
	 */
	 mytable.columns().every(function() {
	 	var that = this;

	 	$('.srch', this.header()).on('keyup change', function() {
	 		if (that.search() !== this.value) {
	 			mytable.ajax.reload();
	 			that.search(this.value).draw();
	 		}
	 	});
	 	$('input:checkbox', this.header()).on('keyup change', function() {
	 		var a = [];
	 		if ($('#checkAll:checked').length === 1) {
	 			$('input:checkbox', mytable.table().body()).prop('checked', true);
	 			$('input:checkbox', mytable.table().body()).each(function() {
	 				a.push(this.value);
	 				//chk2("1", this.value);
	 			});
	 		} else if ($('#checkAll:checked').length === 0) {
	 			$('input:checkbox', mytable.table().body()).prop('checked', false);
	 			$('input:checkbox', mytable.table().body()).each(function() {
	 				a.push(this.value);
	 				//chk2("0", this.value);
	 			});
	 		}

	 		console.log(a);
	 	});
	 });

	 //mytable.find("td").off("click.DT");
	 // for(var i=0; i< mytable.fnSettings().aoColumns.length; i++){
	 // 	mytable.fnSortListener($('thead.theadergray td:eq('+i+')'), i);
	 // } 
	 $("table thead td").off("click.DT");
	 $('.ts0').on('click', function() {
	 	if (t0) {
	 		mytable.order([0, 'asc']).draw();
	 		t0 = false;
	 	} else {
	 		mytable.order([0, 'desc']).draw();
	 		t0 = true;
	 	}
	 });
	 $('.ts1').on('click', function() {
	 	if (t1) {
	 		mytable.order([1, 'asc']).draw();
	 		t1 = false;
	 	} else {
	 		mytable.order([1, 'desc']).draw();
	 		t1 = true;
	 	}
	 });
	 $('.ts2').on('click', function() {
	 	if (t2) {
	 		mytable.order([3, 'asc']).draw();
	 		t2 = false;
	 	} else {
	 		mytable.order([3, 'desc']).draw();
	 		t2 = true;
	 	}
	 });
	 $('.ts3').on('click', function() {
	 	if (t3) {
	 		mytable.order([4, 'asc']).draw();
	 		t3 = false;
	 	} else {
	 		mytable.order([4, 'desc']).draw();
	 		t3 = true;
	 	}
	 });
	 $('.ts4').on('click', function() {
	 	if (t4) {
	 		mytable.order([5, 'asc']).draw();
	 		t4 = false;
	 	} else {
	 		mytable.order([5, 'desc']).draw();
	 		t4 = true;
	 	}
	 });
	 $('.ts5').on('click', function() {
	 	if (t5) {
	 		mytable.order([6, 'asc']).draw();
	 		t5 = false;
	 	} else {
	 		mytable.order([6, 'desc']).draw();
	 		t5 = true;
	 	}
	 });
	 $('.ts6').on('click', function() {
	 	if (t6) {
	 		mytable.ajax.reload();
	 		mytable.order([8, 'asc']).draw();
	 		t6 = false;
	 	} else {
	 		mytable.order([8, 'desc']).draw();
	 		t6 = true;
	 	}
	 });
	 $('.ts7').on('click', function() {
	 	if (t6) {
	 		mytable.ajax.reload();
	 		mytable.order([2, 'asc']).draw();
	 		t6 = false;
	 	} else {
	 		mytable.order([2, 'desc']).draw();
	 		t6 = true;
	 	}
	 });
	 setTimeout(function(){
	 	$(".chkbox").change(function(e) {
	 		var clas = $(e.target).attr('class').split(' ');
	 		console.log(clas[1]);
	 		if(this.checked)
	 			$('.'+clas[1]).prop('checked',true);
	 		else
	 			$('.'+clas[1]).prop('checked',false);
	 	});
	 }, 1000);
	}




	var base_url = $('#base-url').val(),
	undo = removeDot(removeCommas($('.hraga_terakhir:eq(0)').text()));
	// var lastChecked = null;

	$(function(){
		
	});

	$(document).ready(function() {


		$(".format-koma").keyup(function() {
			if ($(this).val() < 0 || $(this).val().search(/[A-Za-z]/g) != -1)
				$(this).val(1)
			else
				$(this).val(numberWithDot(removeDot($(this).val())))
		});



		jQuery(function($) {
			$('#tableMT').checkboxes('range', true);
		});

		// $('#tableMT:checkbox').shiftcheckbox();

		// var $chkboxes = $('.chkbox');
		// $chkboxes.click(function(e) {
		// 	if(!lastChecked) {
		// 		lastChecked = this;
		// 		return;
		// 	}

		// 	if(e.shiftKey) {
		// 		var start = $chkboxes.index(this);
		// 		var end = $chkboxes.index(lastChecked);

		// 		$chkboxes.slice(Math.min(start,end), Math.max(start,end)+ 1).prop('checked', lastChecked.checked);

		// 	}

		// 	lastChecked = this;
		// });

		$('.id_item_centang').val('');
		$('.id_harga_centang').val('');

		$('body').on('click', '.btn_decrease', function ()
		{
			// alert('diclick')
			angka 		= $(this).attr('data-id');
			nilaiKelipatan 	= removeDot($('.nilaiKelipatan').val());
			
			if (document.getElementById('plus').checked) {
				rate_value = document.getElementById('plus').value;
			} else {
				rate_value = document.getElementById('minus').value;
			}

			// alert(angka);
			// alert(nilaiKelipatan);
			// alert(rate_value);
			
			var checkboxes = document.getElementsByName('checkItem[]');
			var vals = "";
			var hargas = "";
			var merks = "";
			for (var i=0, n=checkboxes.length;i<n;i++) 
			{
				if (checkboxes[i].checked) 
				{

					vals += ","+checkboxes[i].value;

					var total = parseInt(angka) * parseInt(nilaiKelipatan);
					hargaItem 	= $('.item'+checkboxes[i].value).val();
					curItem 	= $('.itemCur'+checkboxes[i].value).val();
					if(rate_value=="plus"){
						total_akhir = parseInt(hargaItem) + parseInt(total);
					} else {
						total_akhir = parseInt(hargaItem) - parseInt(total);
					}
					
					var itemReset = $('.itemReset'+checkboxes[i].value).val();
					var itemDefault = $('.itemDefault'+checkboxes[i].value).val();					
					
					if(parseInt(total_akhir)>=parseInt(itemDefault)){ //jika lebih besar dari harga item
						total_akhir = itemDefault;	
						// alert(total_akhir)
						// alert(numberWithDot(total_akhir))
						$('.itemGanti'+checkboxes[i].value).val(numberWithDot(total_akhir));
						$('.itemGanti2'+checkboxes[i].value).html(numberWithDot(total_akhir));
					} else if(parseInt(total_akhir)<=0){ //jika kurang dari 0
						total_akhir = 0;	
						// alert(total_akhir)						
						$('.itemGanti'+checkboxes[i].value).val(total_akhir);
						$('.itemGanti2'+checkboxes[i].value).html(total_akhir);
					} else { //normal
						// alert(total_akhir)
						// alert(numberWithDot(total_akhir))
						$('.itemGanti'+checkboxes[i].value).val(numberWithDot(total_akhir));
						$('.itemGanti2'+checkboxes[i].value).html(numberWithDot(total_akhir));
					}

					hargas += ","+total_akhir;

					$('.item'+checkboxes[i].value).val(total_akhir);
					//$('.itemGantiHtml'+checkboxes[i].value).val(total_akhir.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1."));
					// alert(total_akhir)

					var itemCheckDefault = $('.itemCheck'+checkboxes[i].value).val();					
					merks += ","+itemCheckDefault;					
				}
			}
			if (vals) vals = vals.substring(1);
			if (hargas) hargas = hargas.substring(1);
			if (merks) merks = merks.substring(1);

			$('.id_item_centang').val(vals);
			$('.id_harga_centang').val(hargas);
			$('.id_merk').val(merks);
			// alert(merks);
		});

		$('body').on('click', '.btn-reset', function ()
		{
			$('.id_item_centang').val('');
			$('.id_harga_centang').val('');
			$('.id_merk').val('');
			
			var checkboxes = document.getElementsByName('checkItem[]');
			var vals = "";
			for (var i=0, n=checkboxes.length;i<n;i++) 
			{
				if (checkboxes[i].checked) 
				{
					vals += ","+checkboxes[i].value;

					var itemReset = $('.itemReset'+checkboxes[i].value).val();
					curItem 	= $('.itemCur'+checkboxes[i].value).val();
					
					$('.item'+checkboxes[i].value).val(itemReset);
					$('.itemGanti'+checkboxes[i].value).val(numberWithDot(itemReset));
					$('.itemGanti2'+checkboxes[i].value).html(numberWithDot(itemReset));
					// alert(total_akhir)
				}
			}
			if (vals) vals = vals.substring(1);

		});

		$('#tableMT').DataTable().destroy();
		$('#tableMT tbody').empty();
		loadTable();

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
				url : $("#base-url").val() + 'EC_Auction_itemize_negotiation/getTimeServer/',
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
					pialaItemize();
					getPiala();
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
		// $('#tableMT').DataTable().destroy();
		// $('#tableMT tbody').empty();
		// loadTable();
	}, 1000);
		getPiala();
		pialaItemize();

		


		// $('.btn_decrease').click(function() {
		// 	if (parseInt(removeDot(removeCommas($('#penawaran').val()))) - (parseInt(removeDot($('#pengurangan').text())) * parseInt($(this).text())) > 0)
		// 		$('#penawaran').val(numberWithCommas(parseInt(removeDot(removeCommas($('#penawaran').val()))) - (parseInt(removeDot($('#pengurangan').text())) * parseInt($(this).text()))))
		// });
		$('#submit').click(function() {
			// undo = removeDot(removeCommas($('#penawaran').val()))
			// bid($('#no_tender').text())
			// $('.hraga_terakhir').text($('#penawaran').val())
			bid();
			pialaItemize();
		});
		$('#undo').click(function() {
			$('#penawaran').val(numberWithCommas(undo))
		});
	});
function piala(no_tender) {
	$.ajax({
		url : $("#base-url").val() + 'EC_Auction_itemize_negotiation/piala/' + no_tender,
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

function pialaItemize() {
	var NO_TENDER = $('.NO_TENDER').val();
	var NO_BATCH = $('.NO_BATCH').val();
	$.ajax({
		url : $("#base-url").val() + 'EC_Auction_itemize_negotiation/pialaItemize/' + NO_TENDER+'/'+NO_BATCH,
		type : 'POST',
		dataType : 'json'
	}).always(function(data) {
		console.log('tes');
		for (var i = 0; i < data.length; i++) {
				// alert(data[i]['ID_ITEM']);
				// alert(data[i]['piala']);
				//alert(data[i]['RANKING']);
				$('.itemGambar'+data[i]['ID_ITEM']).html('');
				$('.itemReset'+data[i]['ID_ITEM']).val(data[i]['HARGATERKINI']);
				if(data[i]['piala'] == true){
					$('.itemGambar'+data[i]['ID_ITEM']).html(data[i]['RANKING']+'<img src="'+data[i]['piala_gmbr']+'" width="50" height="50">');
					$('.itemGantiHtml'+data[i]['ID_ITEM']).html(data[i]['CURR']+numberWithDot(data[i]['HARGATERKINI']));
				} else {
					$('.itemGambar'+data[i]['ID_ITEM']).html(data[i]['RANKING']);
					$('.itemGantiHtml'+data[i]['ID_ITEM']).html(data[i]['CURR']+numberWithDot(data[i]['HARGATERKINI']));
				}
			}
			//alert(data.length);
		})
}

function pialaItemizeitemGanti() {
	var NO_TENDER = $('.NO_TENDER').val();
	var NO_BATCH = $('.NO_BATCH').val();
	$.ajax({
		url : $("#base-url").val() + 'EC_Auction_itemize_negotiation/pialaItemize/' + NO_TENDER+'/'+NO_BATCH,
		type : 'POST',
		dataType : 'json'
	}).always(function(data) {
		console.log('tes');
		for (var i = 0; i < data.length; i++) {
				// alert(data[i]['ID_ITEM']);
				// alert(data[i]['piala']);
				//alert(data[i]['RANKING']);
				$('.itemGambar'+data[i]['ID_ITEM']).html('');
				$('.itemReset'+data[i]['ID_ITEM']).val(data[i]['HARGATERKINI']);
				if(data[i]['piala'] == true){
					$('.itemGanti'+data[i]['ID_ITEM']).val(numberWithDot(data[i]['HARGATERKINI']));
				} else {
					$('.itemGanti'+data[i]['ID_ITEM']).val(numberWithDot(data[i]['HARGATERKINI']));
				}
			}
			//alert(data.length);
		})
}

function getPiala() {
	var NO_TENDER = $('.NO_TENDER').val();
	var NO_BATCH = $('.NO_BATCH').val();
	$.ajax({
		url : $("#base-url").val() + 'EC_Auction_itemize_negotiation/getPialaItemize/' + NO_TENDER+'/'+NO_BATCH,
		type : 'POST',
		dataType : 'json'
	}).always(function(data) {
		$('.pialaGet').html('<img src="'+data['piala_gmbr']+'" width="50" height="50"> = ' + data['RANKING'])
	})
}

function bid() {
	vals = $('.id_item_centang').val();
	hargas = $('.id_harga_centang').val();
	merks = $('.id_merk').val();
	NO_TENDER = $('.NO_TENDER').val();
	NO_BATCH = $('.NO_BATCH').val();
	
	$.ajax({
		url : $("#base-url").val() + 'EC_Auction_itemize_negotiation/bid',
		type : 'POST',
		data : {
			vals: vals,
			hargas: hargas,
			merks: merks,
			NO_TENDER: NO_TENDER,
			NO_BATCH: NO_BATCH,
		},
		dataType : 'json'
	}).always(function(data) {
		console.log(data);
		pialaItemizeitemGanti();
		if (data.data0 != ''){
			swal({
				title: "Data tidak boleh 0",
				text: "",
				type: "warning",
				showCancelButton: false,
				confirmButtonColor: '#92c135',
				cancelButtonColor: '#d33',
				confirmButtonText: 'OK',
				confirmButtonClass: 'btn btn-success',
				cancelButtonClass: 'btn btn-danger',
				cancelButtonText: "Tidak",
				closeOnConfirm: true,
				closeOnCancel: true
			},
			function(isConfirm) {
			})	
		} 
		else {
		}
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



// function removeDot(x) {
// 	return x.replace(/\./g, "");
// }
