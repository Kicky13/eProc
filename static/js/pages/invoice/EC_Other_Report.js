function loadTable_invoice() {

	$('#table_inv').DataTable().destroy();
	$('#table_inv tbody').empty();
	mytable = $('#table_inv').DataTable({
		"bSort" : true,
		"dom" : 'rtpli',
		"deferRender" : true,
		"colReorder" : true,
		"pageLength" : 15,
		// "fixedHeader" : true,
		// "scrollX" : true,
		"lengthMenu" : [5, 10, 15, 25, 50, 75, 100],
		"language" : {
			"loadingRecords" : "<center><b>Please wait - Updating and Loading Data List Contract...</b></center>"
		},
		"ajax" : {
			url : $("#base-url").val() + 'EC_Invoice_Report/dataOtherReport',
			data : {company : $('form').serializeArray()},
			type : 'POST'
		},

		"columnDefs" : [{
			"searchable" : false,
			"orderable" : true,
			"targets" : 0
		}],
		// "order": [[ 1, 'asc' ]],
		"fnInitComplete" : function() {
			$('#table_inv tbody tr').each(function() {
				$(this).find('td').attr('nowrap', 'nowrap');
			});
		},
        "fnCreatedRow": function (row, data, index) {
                    $('td', row).eq(0).html(index + 1);
                },
		"drawCallback" : function(settings) {
			$('#table_inv tbody tr').each(function() {
				$(this).find('td').attr('nowrap', 'nowrap');
			});
		},
		"columns" : [
                 {
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += "#";
				a += "</div>";
				return a;
			}
		}, {
			mRender : function(data, type, full) {
				a = "<div class='col-md-12'>";
				a += full.NAME1;
				a += "</div>";
				return a;
			}
		}, {
			mRender : function(data, type, full) {
				a = "<div class='col-md-12'>";
				a += full.JENIS;
				a += "</div>";
				return a;
			}
		}, {
			mRender : function(data, type, full) {
				a = "<div class='col-md-12'>";
				a += full.JUM_GR;
				a += "</div>";
				return a;
			}
		}, {
			mRender : function(data, type, full) {
				a = "<div class='col-md-12'>";
				a += full.JUM_INV;
				a += "</div>";
				return a;
			}
		}],

	});

	mytable.columns().every(function() {
		var that = this;
		$('.srch', this.header()).on('keyup change', function() {
			if (that.search() !== this.value) {
				that.search(this.value).draw();
			}
		});
	});

	$('#table_inv').find("th").off("click.DT");
	$('.ts0').on('dblclick', function() {
		if (t0) {
			mytable.order([0, 'asc']).draw();
			t0 = false;
		} else {
			mytable.order([0, 'desc']).draw();
			t0 = true;
		}
	});
	$('.ts1').on('dblclick', function() {
		if (t1) {
			mytable.order([1, 'asc']).draw();
			t1 = false;
		} else {
			mytable.order([1, 'desc']).draw();
			t1 = true;
		}
	});
	$('.ts2').on('dblclick', function() {
		if (t2) {
			mytable.order([2, 'asc']).draw();
			t2 = false;
		} else {
			mytable.order([2, 'desc']).draw();
			t2 = true;
		}
	});
	$('.ts3').on('dblclick', function() {
		if (t3) {
			mytable.order([3, 'asc']).draw();
			t3 = false;
		} else {
			mytable.order([3, 'desc']).draw();
			t3 = true;
		}
	});
	$('.ts4').on('dbldblclick', function() {
		if (t4) {
			mytable.order([4, 'asc']).draw();
			t4 = false;
		} else {
			mytable.order([4, 'desc']).draw();
			t4 = true;
		}
	});
	$('.ts5').on('dblclick', function() {
		if (t5) {
			mytable.order([5, 'asc']).draw();
			t5 = false;
		} else {
			mytable.order([5, 'desc']).draw();
			t5 = true;
		}
	});
	$('.ts6').on('dblclick', function() {
		if (t6) {
			mytable.order([6, 'asc']).draw();
			t6 = false;
		} else {
			mytable.order([6, 'desc']).draw();
			t6 = true;
		}
	});
	$('.ts7').on('dblclick', function() {
		if (t7) {
			mytable.order([7, 'asc']).draw();
			t7 = false;
		} else {
			mytable.order([7, 'desc']).draw();
			t7 = true;
		}
	});
	$('.ts8').on('dblclick', function() {
		if (t8) {
			mytable.order([8, 'asc']).draw();
			t8 = false;
		} else {
			mytable.order([8, 'desc']).draw();
			t8 = true;
		}
	});
	$('.ts9').on('dblclick', function() {
		if (t9) {
			mytable.order([9, 'asc']).draw();
			t9 = false;
		} else {
			mytable.order([9, 'desc']).draw();
			t9 = true;
		}
	});
	$('.ts10').on('dblclick', function() {
		if (t10) {
			mytable.order([10, 'asc']).draw();
			t10 = false;
		} else {
			mytable.order([10, 'desc']).draw();
			t10 = true;
		}
	});
}


$('#modalTracking').on('show.bs.modal', function(event) {
	var button = $(event.relatedTarget)
	var Invoince = button.data('id_invoice')

	$.ajax({
		url : $("#base-url").val() + 'EC_Invoice_Management/tracking/' + Invoince,
		type : 'POST',
		dataType : 'json'
	}).done(function(data) {
		var teks = ""
		$("#bodyTableTrack").empty()
		//1->Draft,2->Submited,3->Approved,4->Rejected,5->Posted,6->Paid,9->Delete
                var _status_track = {
                    1 : 'DRAFT',
                    2 : 'SUBMITTED',
                    3 : 'APPROVED',
                    4 : 'REJECTED',
                    5 : 'POSTED',
                    6 : 'PAID'
                };

		for (var i = 0; i < data.length; i++) {
                        teks += "<tr>";
                        teks += "<td class=\"text-center\">" + (i + 1) + "</td>";
			teks += "<td class=\"text-center\">" + data[i]['TRACK_DATE'] + "</td>"
			teks += "<td class=\"text-center\">" + _status_track[data[i]['STATUS_TRACK']] + "</td>"
		//	teks += "<td class=\"text-center\">" + data[i]['DESC'] + "</td>"
                        teks += "<td class=\"text-center\">" + data[i]['POSISI'] + "</td>"
												teks += "<td class=\"text-center\">" + data[i]['STATUS_DOC'] + "</td>"
                        teks += "<td class=\"text-center\">" + data[i]['USER'] + "</td>"
			teks += "</tr>"
		}
		$("#bodyTableTrack").html(teks)
	}).fail(function() {
		// console.log("error");
	}).always(function(data) {
		// console.log(data);

	});
});

var t0 = true,
    t1 = true,
    t2 = true,
    t3 = true,
    t4 = true,
    t5 = true,
    t6 = true,
    t7 = true,
    t8 = true,
    t9 = true,
    t10 = true,
    clicks = 0,
    timer = null;
var t = [t0, t1, t2, t3, t4, t5, t6, t7, t8, t9, t10];




$(document).ready(function() {

	loadTable_invoice();
        $(".sear").hide();
	for (var i = 0; i < t.length; i++) {
		$(".ts" + i).on("click", function(e) {
			clicks++;
			if (clicks === 1) {
				timer = setTimeout(function() {
					$(".sear").toggle();
					clicks = 0;
				}, 300);
			} else {
				clearTimeout(timer);
				$(".sear").hide();
				clicks = 0;
			}
		}).on("dblclick", function(e) {
			e.preventDefault();
		});
	};


/*CHART*/
	var _gr_brg = $("#data-chart").data('t_brg');
	var _bapp_jsa = $("#data-chart").data('t_jsa');
	var _i_brg = $("#data-chart").data('i_brg');
	var _i_jsa = $("#data-chart").data('i_jsa');

	if (_i_brg == "") _i_brg= 0;
	if (_i_jsa == "") _i_jsa= 0;

var barChartData = {
	labels : ["BARANG","JASA"],
	datasets : [
		{
			label: "GR/BAPP",
			fillColor : "rgba(20,220,20,0.5)",
			strokeColor : "rgba(11,209,9,1)",
			highlightFill: "rgba(20,220,20,0.75)",
			highlightStroke: "rgba(11,209,9,1)",
			data : [
				_gr_brg,
				_bapp_jsa
			]
		},{
			label: "INVOICE",
			fillColor : "rgba(220,20,20,0.5)",
			strokeColor : "rgba(211,09,9,1)",
			highlightFill: "rgba(220,20,20,0.75)",
			highlightStroke: "rgba(211,09,9,1)",
			data : [
				_i_brg,
				_i_jsa
			]
		}
	]

}
	$("#Chart").appear(function() {
		var ctx = $("#Chart").get(0).getContext("2d");
		var barCanvas = new Chart(ctx)
			.Bar(barChartData, {
				responsive : true,
				multiTooltipTemplate: "<%= datasetLabel %> : <%= value %>",

			}
		);
		document.getElementById('js-legend').innerHTML = barCanvas.generateLegend();
	});
});
