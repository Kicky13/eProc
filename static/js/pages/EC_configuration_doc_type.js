base_url = $("#base-url").val();

var t0 = true,
    t1 = true,
    t2 = true,
    t3 = true,
    t4 = true,
    t5 = true,
    t6 = true;
function loadTable() {
	// no = 1;
	mytable = $('#tableMT').DataTable({
		"bSort" : true,
		"dom" : 'lrtip',
		"deferRender" : true,
		"language" : {
			"loadingRecords" : "<center><b>Please wait - Updating and Loading Data Configuration &ndash; Document Type...</b></center>"
		},
		// "paging": true,
		// "lengthChange": true,
		// "lengthMenu": [ 10, 25, 50, 75, 100 ],
		//"scrollY": $( window ).height()/2,
		//"pagingType": "scrolling",

		"ajax" : $("#base-url").val() + 'EC_Configuration_doc_type/get_data',

		"columnDefs" : [{
			"searchable" : false,
			"orderable" : true,
			"targets" : 0
		}],
		"columns" : [{
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += full[0];
				a += "</div>";
				return a;
			}
		}, {
			mRender : function(data, type, full) {
				// console.log(full);
				if (full[2] != null) {
					a = ''
					a += "<div class='col-md-12 text-center'>";
					// a += '<a href="javascript:void(0)" onclick="openmodal(\'' + full[1] + '\')" >' + full[1] + '</a>';
					a += full[2];
					//.replace(/^0+/g,"")
					a += "</div>";
					return a;
				} else
					return "";
			}
		}, {
			mRender : function(data, type, full) {
				if (full[3] != null) {
					a = "<div class='col-md-12 text-center'>";
					a += full[3];
					a += "</div>";
					return a;
				} else
					return "";
			}
		}, {
			mRender : function(data, type, full) {
				//console.log(full[6]);
				if (full[4] != ("0"))
					return '<input type="checkbox" value="' + full[1] + '" class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1" data-matnr="' + full[1] + '" onclick="chk(this)"  checked>'
				else
					return '<input value="' + full[1] + '" class="chk col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1" data-matnr="' + full[1] + '" onclick="chk(this)" type="checkbox">'
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
				that.search(this.value).draw();
			}
		});
		$('input:checkbox', this.header()).on('keyup change', function() {
			var a = [];
			if ($('#checkAll:checked').length === 1) {
				$('input:checkbox', mytable.table().body()).prop('checked', true);
				$('input:checkbox', mytable.table().body()).each(function() {
					a.push(this.value);
					chk2("1", this.value);
				});
			} else if ($('#checkAll:checked').length === 0) {
				$('input:checkbox', mytable.table().body()).prop('checked', false);
				$('input:checkbox', mytable.table().body()).each(function() {
					a.push(this.value);
					chk2("0", this.value);
				});
			}

			console.log(a);
		});
	});

	$('#tableMT').find("th").off("click.DT");

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
			mytable.order([2, 'asc']).draw();
			t2 = false;
		} else {
			mytable.order([2, 'desc']).draw();
			t2 = true;
		}
	});
}

function chk(ck) {
	var button = $(ck);
	var recipient = button.data('matnr');
	var stat = "0";
	if (button.is(":checked")) {
		stat = "1";
	}
	$.ajax({
		url : $("#base-url").val() + 'EC_Configuration_doc_type/ubahStat/' + recipient,
		data : {
			"checked" : stat
		},
		type : 'POST',
		dataType : 'json'
	}).done(function(data) {
		console.log(data);

	}).fail(function() {
		console.log("error");
	}).always(function(data) {
		//console.log(data);
		$('#tableMT').DataTable().destroy();
		$('#tableMT tbody').empty();
		loadTable();
	});

}

function chk2(stat, recipient) {
	$.ajax({
		url : $("#base-url").val() + 'EC_Configuration_doc_type/ubahStat/' + recipient,
		data : {
			"checked" : stat
		},
		type : 'POST',
		dataType : 'json'
	}).done(function(data) {
		console.log(data);

	}).fail(function() {
		console.log("error");
	}).always(function(data) {
		//console.log(data);
		$('#tableMT').DataTable().destroy();
		$('#tableMT tbody').empty();
		loadTable();
	});

}


$(document).ready(function() {
	loadTable();
});

