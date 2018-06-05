base_url = $("#base-url").val();

function openmodal(MATNR) {
	// MATNR='341-107-0083';//341-107-0083  301-200410
	$.ajax({
		url : $("#base-url").val() + 'EC_Strategic_material/getDetail/' + MATNR,
		type : 'get',
		dataType : 'json',
	}).done(function(data) {
		console.log(data.MATNR[0]);
		dt = data.MATNR[0];
		if (dt != null) {
			$("#formUp").attr("action", "EC_Strategic_material/upload/" + dt.MATNR);
			$("#MATNR").val(dt.MATNR);
			$("#MAKTX").val(dt.MAKTX);
			$("#MTART").val(dt.MTART);
			$("#MEINS").val(dt.MEINS);
			$("#MATKL").val(dt.MATKL);
			$("#created").val(dt.ERNAM + ", " + dt.ERSDA.substring(6) + "-" + dt.ERSDA.substring(4, 6) + "-" + dt.ERSDA.substring(0, 4));
			$("#lastChg").val(dt.AENAM + ", " + dt.LAEDA.substring(6) + "-" + dt.LAEDA.substring(4, 6) + "-" + dt.LAEDA.substring(0, 4));
			if (dt.PICTURE != null || dt.DRAWING != null) {
				$("#pic").attr('src', $("#base-url").val() + $("#UPLOAD_PATH").val() + "material_strategis/" + dt.PICTURE);
				$("#draw").attr('src', $("#base-url").val() + $("#UPLOAD_PATH").val() + "material_strategis/" + dt.DRAWING);
			} else {
				$("#pic").attr('src', $("#base-url").val() + $("#UPLOAD_PATH").val() + "material_strategis/default_post_img.png");
				$("#draw").attr('src', $("#base-url").val() + $("#UPLOAD_PATH").val() + "material_strategis/default_post_img.png");
			}
			if (dt.LNGTX != null) {
				$("#TDLINE").val(dt.LNGTX);
			} else
				$("#TDLINE").val("");
			$("#modalholder").modal('show')
		}
	}).fail(function() {
		console.log("error");
	}).always(function(data) {
		// console.log(MATNR);
	});
}

function SAPsUpdate() {
	$.ajax({
		url : $("#base-url").val() + 'EC_List_contract/sapUpdate',
		type : 'POST',
		dataType : 'json'
	}).done(function(data) {
		console.log(data);
	}).fail(function() {
		console.log("done/eror");
	}).always(function(data) {
		console.log("data: "+data);
		$('#tableMT').DataTable().destroy();
		$('#tableMT tbody').empty();
		loadTable();
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
    t10 = true,
    t11 = true,
    t12 = true,
    t13 = true,
    t14 = true,
    t15 = true,
    t16 = true,
    t17 = true,
    t18 = true,
    t19 = true,
    t20 = true;
function loadTable() {
	// no = 1;
	mytable = $('#tableMT').DataTable({
		"bSort" : true,
		"dom" : 'irtpl',
		"deferRender" : true,
		"colReorder": true,
		// "fixedHeader" : true,
		// "scrollX" : true,
		// "lengthMenu" : [5, 10, 25, 50, 75, 100],
		"language" : {
			"loadingRecords" : "<center><b>Please wait - Updating and Loading Data List Contract...</b></center>"
		},
		"ajax" : $("#base-url").val() + 'EC_List_contract/get_data',

		"columnDefs" : [{
			"searchable" : false,
			"orderable" : true,
			"targets" : 0
		}],
		"fnInitComplete" : function() {
			$('#tableMT tbody tr').each(function() {
				$(this).find('td').attr('nowrap', 'nowrap');
			});
		},
		"drawCallback" : function(settings) {
			$('#tableMT tbody tr').each(function() {
				$(this).find('td').attr('nowrap', 'nowrap');
			});
		},
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
				if (full[1] != null) {
					a = ''
					a += "<div class='col-md-12 text-center'>";
					a += full[1].replace(/^0+/, '');
					//'<a href="javascript:void(0)" onclick="openmodal(\'' + full[1] + '\')" >' + full[1] + '</a>';
					//.replace(/^0+/g,"")
					a += "</div>";
					return a;
				} else
					return "";
			}
		}, {
			mRender : function(data, type, full) {
				// console.log(full);
				if (full[2] != null) {
					a = ''
					a += "<div class='col-md-12 text-center'>";
					a += full[2];
					//'<a href="javascript:void(0)" onclick="openmodal(\'' + full[1] + '\')" >' + full[1] + '</a>';
					//.replace(/^0+/g,"")
					a += "</div>";
					return a;
				} else
					return "";
			}
		}, {
			mRender : function(data, type, full) {
				if (full[5] != null) {
					a = "<div class='col-md-12 text-center'>";
					a += full[5];
					a += "</div>";
					return a;
				} else
					return "";
			}
		}, {
			mRender : function(data, type, full) {
				if (full[8] != null) {
					a = ''
					a += "<div class='col-md-12 text-center'>";
					a += '<a href="javascript:void(0)" >' + full[8].replace(/^0+/, '') + '</a>';
					// onclick="openmodal(\'' + full[8] + '\')"
					a += "</div>";
					return a;
				} else
					return "";
			}
		}, {
			mRender : function(data, type, full) {
				if (full[9] != null) {
					a = "<div class='col-md-12 text-center'>";
					a += full[9];
					a += "</div>";
					return a;
				} else
					return "";
			}
		}, {
			mRender : function(data, type, full) {
				if (full[16] != null) {
					a = ''
					a += "<div class='col-md-12 text-center'>";
					a += full[16].substring(6) + "-" + full[16].substring(4, 6) + "-" + full[16].substring(0, 4);
					a += "</div>";
					return a;
				} else
					return "";
			}
		}, {
			mRender : function(data, type, full) {
				if (full[17] != null) {
					a = ''
					a += "<div class='col-md-12 text-center'>";
					a += full[17].substring(6) + "-" + full[17].substring(4, 6) + "-" + full[17].substring(0, 4);
					a += "</div>";
					return a;
				} else
					return "";
			}
		}, {
			mRender : function(data, type, full) {
				if (full[21] != null) {
					a = ''
					a += "<div class='col-md-12 text-center'>";
					a += '<a href="javascript:void(0)" onclick="openmodal(\'' + full[21] + '\')" >' + full[21] + '</a>';
					a += "</div>";
					return a;
				} else
					return "";
			}
		}, {
			mRender : function(data, type, full) {
				if (full[20] != null) {
					a = ''
					a += "<div class='col-md-12 text-center'>";
					a += full[20];
					a += "</div>";
					return a;
				} else
					return "";
			}
		}, {
			mRender : function(data, type, full) {
				if (full[13] != null) {
					a = ''
					a += "<div class='col-md-12 text-center'>";
					a += full[13];
					a += "</div>";
					return a;
				} else
					return "";
			}
		}, {
			mRender : function(data, type, full) {
				if (full[10] != null) {
					a = ''
					a += "<div class='col-md-12 text-center'>";
					a += full[10];
					a += "</div>";
					return a;
				} else
					return "";
			}
		}, {
			mRender : function(data, type, full) {
				if (full[11] != null) {
					a = ''
					a += "<div class='col-md-12 text-center'>";
					a += full[11];
					a += "</div>";
					return a;
				} else
					return "";
			}
		}, {
			mRender : function(data, type, full) {
				if (full[22] != null) {
					a = ''
					a += "<div class='col-md-12 text-center'>";
					a += full[22];
					a += "</div>";
					return a;
				} else
					return "";
			}
		}, {
			mRender : function(data, type, full) {
				if (full[23] != null) {
					a = ''
					a += "<div class='col-md-12 text-center'>";
					a += full[23];
					a += "</div>";
					return a;
				} else
					return "";
			}
		}, {
			mRender : function(data, type, full) {
				if (full[24] != null) {
					a = ''
					a += "<div class='col-md-12 text-center'>";
					a += full[24];
					a += "</div>";
					return a;
				} else
					return "";
			}
		}, {
			mRender : function(data, type, full) {
				if (full[25] != null) {
					a = ''
					a += "<div class='col-md-12 text-center'>";
					a += full[25];
					//.replace(/(\d)(?=(\d{3})+$)/g, '$1,');
					a += "</div>";
					return a;
				} else
					return "";
			}
		}, {
			mRender : function(data, type, full) {
				if (full[26] != null) {
					a = ''
					a += "<div class='col-md-12 text-center'>";
					a += full[26];
					a += "</div>";
					return a;
				} else
					return "";
			}
		}, {
			mRender : function(data, type, full) {
				if (full[27] != null) {
					a = ''
					a += "<div class='col-md-12 text-center'>";
					a += full[27];
					//.replace(/(\d)(?=(\d{3})+$)/g, '$1,');
					a += "</div>";
					return a;
				} else
					return "";
			}
		}, {
			mRender : function(data, type, full) {
				if (full[12] != null) {
					a = ''
					a += "<div class='col-md-12 text-center'>";
					a += full[12];
					a += "</div>";
					return a;
				} else
					return "";
			}
		}, {
			mRender : function(data, type, full) {
				//console.log(full[6]);
				a = ''
				a += "<div class='col-md-12 text-center'>";
				if (full[28] == ("1"))
					a += "Y";
				else
					a += "X";
				a += "</div>";
				return a;

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
				// $('#tableMT tbody tr').each(function() {
				// $(this).find('td').attr('nowrap', 'nowrap');
				// });
				that.search(this.value).draw();
			}
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
	$('.ts3').on('click', function() {
		if (t3) {
			mytable.order([3, 'asc']).draw();
			t3 = false;
		} else {
			mytable.order([3, 'desc']).draw();
			t3 = true;
		}
	});
	$('.ts4').on('click', function() {
		if (t4) {
			mytable.order([4, 'asc']).draw();
			t4 = false;
		} else {
			mytable.order([4, 'desc']).draw();
			t4 = true;
		}
	});
	$('.ts5').on('click', function() {
		if (t5) {
			mytable.order([5, 'asc']).draw();
			t5 = false;
		} else {
			mytable.order([5, 'desc']).draw();
			t5 = true;
		}
	});
	$('.ts6').on('click', function() {
		if (t6) {
			mytable.order([6, 'asc']).draw();
			t6 = false;
		} else {
			mytable.order([6, 'desc']).draw();
			t6 = true;
		}
	});
}


$(document).ready(function() {
	loadTable();
});

