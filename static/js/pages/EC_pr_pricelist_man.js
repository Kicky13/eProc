$(document).ready(function() {
	loadTable();
	// loadDropdown();
	$('#tambahFilter').on('click', function(e) {
		// $('.breadcrumb').append('<li >Library&nbsp;<a href="javascript:void(0)" onclick="removeFilter(this)" data-id="as"><i data-id="as" class="ico-circle-cross"></i></a></li>');
		// var table = $('#tableMT').DataTable();
		// table.columns([0,3]).visible(false, false);
		// table.columns.adjust().draw(false);
		console.log(partner)
	});
	$("#sear").hide();
	for (var i = 0; i < t.length; i++) {
		$(".ts" + i).on("click", function(e) {
			clicks++;
			if (clicks === 1) {
				timer = setTimeout(function() {
					$("#sear").toggle();
					clicks = 0;
				}, 300);
			} else {
				clearTimeout(timer);
				$("#sear").hide();
				clicks = 0;
			}
		}).on("dblclick", function(e) {
			e.preventDefault();
		});
	};
});

function partnerChg(sel) {
	partner = (sel.options[sel.selectedIndex].value);
}

function loadDropdown() {
	$.ajax({
		url : $("#base-url").val() + 'EC_Pricelist_management/getAllFilter',
		type : 'get',
		dataType : 'json',
	}).done(function(data) {
		for (var i = 0; i < data.Partner.length; i++) {
			$('#Partner').append('<option value="' + data.Partner[i].VENDOR_ID + '">' + data.Partner[i].VENDOR_NAME + '</option>');
		};
	}).fail(function() {
		console.log("error");
	}).always(function(data) {
		// console.log(MATNR);
	});

}

function removeFilter(arg) {
	var button = $(arg)
	var id = button.data('id')
	console.log(id)
}

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
				$("#pic").attr('src', $("#base-url").val() + $("#UPLOAD_PATH").val() + "EC_material_strategis/" + dt.PICTURE);
				$("#draw").attr('src', $("#base-url").val() + $("#UPLOAD_PATH").val() + "EC_material_strategis/" + dt.DRAWING);
			} else {
				$("#pic").attr('src', $("#base-url").val() + $("#UPLOAD_PATH").val() + "EC_material_strategis/default_post_img.png");
				$("#draw").attr('src', $("#base-url").val() + $("#UPLOAD_PATH").val() + "EC_material_strategis/default_post_img.png");
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

function draftChg(sel, stat, contract_itm) {
	$.ajax({
		url : $("#base-url").val() + 'EC_Pricelist_management/ubahStatDraft/' + sel,
		data : {
			"checked" : stat,
			"contract_itm" : contract_itm
		},
		type : 'POST',
		dataType : 'json'
	}).done(function(data) {
		console.log(data);
	}).fail(function() {
		console.log("error");
	}).always(function(data) {
		//console.log(data);
		loadTable();
	});
}

function loadTable() {
	// no = 1;
	$('#tableMT').DataTable().destroy();
	$('#tableMT tbody').empty();
	mytable = $('#tableMT').DataTable({
		"bSort" : true,
		"dom" : 'irtpl',
		"deferRender" : true,
		"colReorder" : true,
		"pageLength" : 25,
		// "fixedHeader" : true,
		// "scrollX" : true,
		// "lengthMenu" : [5, 10, 25, 50, 75, 100],
		"language" : {
			"loadingRecords" : "<center><b>Please wait - Updating and Loading Data List Contract...</b></center>"
		},
		"ajax" : $("#base-url").val() + 'EC_Pricelist_management/get_data',

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
			$(".onoff").bootstrapSwitch({
				"size" : 'mini',
				"offText" : 'Draft',
				"onText" : 'Published',
				"onSwitchChange" : function(event, state) {
					console.log(state)
					draftChg($(this).val(), state ? "1" : "0")
				}
			});
		},
		"columns" : [{
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += full.NO;
				a += "</div>";
				return a;
			}
		}, {
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += '<input type="checkbox" value="' + full.MATNR + '" data-itm="' + full.MATNR + '" class="onoff"';
				if (full.PUBLISHED_PRICELIST == 1)
					a += " checked>";
				else
					a += ">";
				//full[0];
				a += "</div>";
				return a;
			}
		}, {
			mRender : function(data, type, full) {
				// console.log(full);
				if (full.MAKTX != null) {
					a = ''
					a += "<div class='col-md-12 text-center'>";
					a += full.MAKTX;
					//'<a href="javascript:void(0)" onclick="openmodal(\'' + full[1] + '\')" >' + full[1] + '</a>';
					//.replace(/^0+/g,"")
					a += "</div>";
					return a;
				} else
					return "";
			}
		}, {
			mRender : function(data, type, full) {
				if (full.MATNR != null) {
					a = ''
					a += "<div class='col-md-12 text-center'>";
					a += '<a href="javascript:void(0)" onclick="openmodal(\'' + full.MATNR + '\')" >' + full.MATNR + '</a>';
					a += "</div>";
					return a;
				} else
					return "";
			}
		}, {
			mRender : function(data, type, full) {
				if (full.MATKL != null) {
					a = ''
					a += "<div class='col-md-12 text-center'>";
					a += full.MATKL;
					a += "</div>";
					return a;
				} else
					return "";
			}
		}, {
			mRender : function(data, type, full) {
				if (full.START_DATE != null) {
					a = ''
					a += "<div class='col-md-12 text-center'>";
					a += full.START_DATE.substring(6) + "-" + full.START_DATE.substring(4, 6) + "-" + full.START_DATE.substring(0, 4);
					a += "</div>";
					return a;
				} else
					return "";
			}
		}, {
			mRender : function(data, type, full) {
				if (full.END_DATE != null) {
					a = ''
					a += "<div class='col-md-12 text-center'>";
					a += full.END_DATE.substring(6) + "-" + full.END_DATE.substring(4, 6) + "-" + full.END_DATE.substring(0, 4);
					a += "</div>";
					return a;
				} else
					return "";
			}
		}, {
			mRender : function(data, type, full) {
				if (full.PRICE != null) {
					a = ''
					a += "<div class='col-md-12 text-center'>";
					a += full.PRICE;
					a += "</div>";
					return a;
				} else
					return "";
			}
		}, {
			mRender : function(data, type, full) {
				if (full.MEINS != null) {
					a = ''
					a += "<div class='col-md-12 text-center'>";
					a += full.MEINS;
					a += "</div>";
					return a;
				} else
					return "";
			}
		}, {
			mRender : function(data, type, full) {
				if (full.CURR != null) {
					a = ''
					a += "<div class='col-md-12 text-center'>";
					a += full.CURR;
					a += "</div>";
					return a;
				} else
					return "";
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
	// for (var i = 0; i < t.length; i++) {
	// $('.ts' + i).on('click', function() {
	// if (t[i]) {
	// mytable.order([i, 'asc']).draw();
	// t[i] = false;
	// } else {
	// mytable.order([i, 'desc']).draw();
	// t[i] = true;
	// }
	// });
	// };
	//
	//
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
	$('.ts11').on('dblclick', function() {
		if (t11) {
			mytable.order([11, 'asc']).draw();
			t11 = false;
		} else {
			mytable.order([11, 'desc']).draw();
			t11 = true;
		}
	});
	$('.ts12').on('dblclick', function() {
		if (t12) {
			mytable.order([12, 'asc']).draw();
			t12 = false;
		} else {
			mytable.order([12, 'desc']).draw();
			t12 = true;
		}
	});
	$('.ts13').on('dblclick', function() {
		if (t13) {
			mytable.order([13, 'asc']).draw();
			t13 = false;
		} else {
			mytable.order([13, 'desc']).draw();
			t13 = true;
		}
	});
	$('.ts14').on('dblclick', function() {
		if (t14) {
			mytable.order([14, 'asc']).draw();
			t14 = false;
		} else {
			mytable.order([14, 'desc']).draw();
			t14 = true;
		}
	});
	$('.ts15').on('dblclick', function() {
		if (t15) {
			mytable.order([15, 'asc']).draw();
			t15 = false;
		} else {
			mytable.order([15, 'desc']).draw();
			t15 = true;
		}
	});
	$('.ts16').on('dblclick', function() {
		if (t16) {
			mytable.order([16, 'asc']).draw();
			t16 = false;
		} else {
			mytable.order([16, 'desc']).draw();
			t16 = true;
		}
	});
	$('.ts17').on('dblclick', function() {
		if (t17) {
			mytable.order([17, 'asc']).draw();
			t17 = false;
		} else {
			mytable.order([17, 'desc']).draw();
			t17 = true;
		}
	});
	$('.ts18').on('dblclick', function() {
		if (t18) {
			mytable.order([18, 'asc']).draw();
			t18 = false;
		} else {
			mytable.order([18, 'desc']).draw();
			t18 = true;
		}
	});
	$('.ts19').on('dblclick', function() {
		if (t19) {
			mytable.order([19, 'asc']).draw();
			t19 = false;
		} else {
			mytable.order([19, 'desc']).draw();
			t19 = true;
		}
	});
	$('.ts20').on('dblclick', function() {
		if (t20) {
			mytable.order([20, 'asc']).draw();
			t20 = false;
		} else {
			mytable.order([20, 'desc']).draw();
			t20 = true;
		}
	});
	$('.ts21').on('dblclick', function() {
		if (t21) {
			mytable.order([21, 'asc']).draw();
			t21 = false;
		} else {
			mytable.order([21, 'desc']).draw();
			t21 = true;
		}
	});
	/**/

}

var base_url = $("#base-url").val(),
    manufacturer,
    partner,
    matgroup,
    t0 = true,
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
    t20 = true,
    t21 = true,
    clicks = 0,
    timer = null;
var t = [t0, t1, t2, t3, t4, t5, t6, t7, t8, t9, t10, t11, t12, t13, t14, t15, t16, t17, t18, t19, t20, t21]
