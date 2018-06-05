function loadTable() {

	$('#table_log').DataTable().destroy();
	$('#table_log tbody').empty();
	mytable = $('#table_log').DataTable({
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
		"ajax" : $("#base-url").val() + 'EC_Cronjob/getAllLogCronJob',

		"columnDefs" : [{
			"searchable" : false,
			"orderable" : true,
			"targets" : 0
		}],
		// "order": [[ 1, 'asc' ]],
		"fnInitComplete" : function() {
			$('#table_log tbody tr').each(function() {
				$(this).find('td').attr('nowrap', 'nowrap');
			});
		},
        "fnCreatedRow": function (row, data, index) {
                    $('td', row).eq(0).html(index + 1);
                },
		"drawCallback" : function(settings) {
			$('#table_log tbody tr').each(function() {
				$(this).find('td').attr('nowrap', 'nowrap');
			});
		},
		"columns" : [
                 {
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += full.NO;
				a += "</div>";
				return a;
			}
		}, {
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += full.DATE2;
				a += "</div>";
				return a;
			}
		}, {
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += full.DATE_TRANSACTION;
				a += "</div>";
				return a;
			}
		},{
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += full.ACTION;
				a += "</div>";
				return a;
			}
		},{
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += full.DONE_BY;
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

	$('#table_log').find("th").off("click.DT");
	mytable.on('dblclick','thead>tr>th.ts' ,function() {
		var _index = $(this).index();
		var _sort = $(this).data('sorting') || 'asc';
		var _nextSort = _sort == 'asc' ? 'desc' : 'asc';
		$(this).data('sorting',_nextSort);
		mytable.order([_index, _sort]).draw();
	});
}

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
    clicks = 0,
    timer = null;
var t = [t0, t1, t2, t3, t4, t5, t6, t7, t8, t9];

function manualRefreshGR(elm){
	var _url = $(elm).data('href');
	var _hariini = $(elm).data('hariini');
	bootbox.prompt('Masukkan Tanggal Buat GR',function(t){
		if(t){
			window.location.href = _url+'/'+t;
		}
	}).on('shown.bs.modal', function(e) {
			$(this).find('input').datepicker({
					format: "yyyymmdd",
					autoclose: true,
					todayHighlight: true,
			}).datepicker('setDate',new Date()).prop('readonly',1);

	});
	return false;
}

function manualRefreshPomut(elm){
	var _url = $(elm).data('href');
	var _hariini = $(elm).data('hariini');
	bootbox.prompt('Masukkan Tanggal Periode Analisa Mutu',function(t){
		if(t){
			window.location.href = _url+'/'+t;
		}
	}).on('shown.bs.modal', function(e) {
			$(this).find('input').datepicker({
					format: "yyyymmdd",
					autoclose: true,
					todayHighlight: true,
			}).datepicker('setDate',new Date()).prop('readonly',1);

	});
	return false;
}

function manualRefreshLandedCost(elm){
	var _url = $(elm).data('href');
	var _hariini = $(elm).data('hariini');
	bootbox.prompt('Masukkan Tanggal Buat GR',function(t){
		if(t){
			window.location.href = _url+'/'+t;
		}
	}).on('shown.bs.modal', function(e) {
			$(this).find('input').datepicker({
					format: "yyyymmdd",
					autoclose: true,
					todayHighlight: true,
			}).datepicker('setDate',new Date()).prop('readonly',1);

	});
	return false;
}

$(document).ready(function() {

	loadTable();
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

});
