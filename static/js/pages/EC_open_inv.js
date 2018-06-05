var arrGR = [],
    arrGRL = [];
function numberWithDot(x) {
	return x == null || x == "0" ? "" : x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

function removeCommas(x) {
	return x.replace(/,/g, "");
}

function removeDot(x) {
	return x.replace(/\./g, "");
}


$(document).ready(function() {
	// $('#profile').click(function (e) {
	// 	$("#create").hide();
	// });

	$('.tab2').on('shown.bs.tab', function(e) {
		$("#create").hide();
	});

	// $(".format-pajak").keyup(function() {
		// $(this).val(numberWithDot(removeDot($(this).val())))
	// })
	// $(".formCreate").submit(function() {
		// console.log($('#faktur').val().length)
		// if ($('#faktur').val().length != 16)
			// return false;
		// else
			// return false;
	// })
	$('.tab1').on('shown.bs.tab', function(e) {
		$("#create").show();
	});
	loadTable();
	loadDataList();
	loadDataListApp();
	loadDataListreject();
	$("#alasanreject").val('');
	$('#tambahFilter').on('click', function(e) {
		console.log(partner)
	});
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
	$('.tgll .startDate').datepicker({
		format : "dd/mm/yyyy",
		autoclose : true,
		todayHighlight : true
	});
	$('#myModal').on('show.bs.modal', function(e) {
		arrGR = []
		arrGRL = []
		$("#arrGR").val('')
		$("#arrGRL").val('')
		jumlah = 0;
		curr = $('input[type=checkbox]:checked:eq(0)').data('curr')
		$('input[type=checkbox]').each(function() {
			if ($(this).is(":checked")) {
				arrGR.push($(this).data('gr'));
				arrGRL.push($(this).data('grl'));
				$("#arrGR").val(arrGR)
				$("#arrGRL").val(arrGRL)
				jumlah += parseInt($(this).data('amount'))
			}
		});
		$("#curr").val(curr)
		$("#totalview").val(numberWithCommas(jumlah))
		$("#total").val((jumlah))
		console.log($("#arrGR").val())
		console.log($("#arrGRL").val())
	})
	$('#myModal').on('shown.bs.modal', function(e) {
		tdkAda = true
		$('input[type=checkbox]').each(function() {
			if ($(this).is(":checked")) {
				tdkAda = false
			}
		});
		if (tdkAda) {
			alert("Minimal satu GR")
			$('#myModal').modal('hide')
		};
		curr = $('input[type=checkbox]:checked:eq(0)').data('curr')
		$('input[type=checkbox]').each(function() {
			if ($(this).is(":checked")) {
				if (curr != $(this).data('curr')) {
					alert("CURRENCY harus sama!!")
					$('#myModal').modal('hide')
					return false;
				};
				// curr = $(this).data('curr')
			}
		});
		no_po = $('input[type=checkbox]:checked:eq(0)').val()
		$('input[type=checkbox]').each(function() {
			if ($(this).is(":checked")) {
				if (no_po != $(this).val()) {
					alert("Nomer PO Berbeda")
					$('#myModal').modal('hide')
					return false;
				};
				// curr = $(this).data('curr')
			}
		});
		if (curr == "")
			$('#myModal').modal('hide')
		curr = "";
	})
	$('#myModal').on('hide.bs.modal', function(e) {
		$('input[type=checkbox]').each(function() {
			if ($(this).is(":checked")) {
				$(this).removeAttr('checked')
			}
		});
		if (curr != "")
			loadTableProposal()
	})
	loadTableProposal()
	loadTableApproved()
});

function numberWithCommas(x) {
	return x == null || x == 0 ? '' : x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

function openmodal(MATNR) {
	$.ajax({
		url : $("#base-url").val() + 'EC_Strategic_material/getDetail/' + MATNR,
		type : 'get',
		dataType : 'json',
	}).done(function(data) {
		console.log(data.MATNR[0]);
		dt = data.MATNR[0];
		if (dt != null) {
			$("#formUp").attr("action", "EC_Open_invoice/upload/" + dt.MATNR);
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

function sapUpdate() {
	$.ajax({
		url : $("#base-url").val() + 'EC_Open_invoice/sapUpdate/',
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

function draftChg(sel, stat, contract_itm) {
	$.ajax({
		url : $("#base-url").val() + 'EC_Open_invoice/ubahStatDraft/' + sel,
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

function ckbk(elm, gr, grl) {
	if ($(elm).is(":checked")) {
		arrGR.push(gr);
		arrGRL.push(grl);
		$("#arrGR").val(arrGR)
		$("#arrGRL").val(arrGRL)
		console.log(arrGR)
		console.log(arrGRL)
	} else {

	}
}

function cekPOnCURR(elm, gr, grl) {
	return;
	if ($(elm).is(":checked")) {
		arrGR.push(gr);
		arrGRL.push(grl);
		$("#arrGR").val(arrGR)
		$("#arrGRL").val(arrGRL)
		console.log(arrGR)
		console.log(arrGRL)
	} else {

	}
}

function loadTable() {
	// no = 1;
	$('#tableMT').DataTable().destroy();
	$('#tableMT tbody').empty();
	mytable = $('#tableMT').DataTable({
		"bSort" : true,
		"dom" : 'rtpli',
		"deferRender" : true,
		"colReorder" : true,
		"pageLength" : 25,
		// "fixedHeader" : true,
		// "scrollX" : true,
		// "lengthMenu" : [5, 10, 25, 50, 75, 100],
		"language" : {
			"loadingRecords" : "<center><b>Please wait - Updating and Loading Data List Contract...</b></center>"
		},
		"ajax" : $("#base-url").val() + 'EC_Open_invoice/get_data',

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
			//
			// $('.ckb').change(function() {
			// if ($(this).is(":checked")) {
			// compare.push($(this).data('gr'));
			// compareCntrk.push($(this).data('grl'));
			// // $(elm).attr('enabled', false)
			// $("#arrGR").val(compare)
			// $("#arrGRL").val(compareCntrk)
			// console.log(compare)
			// } else {
			//
			// }
			// });
		},
		"columns" : [{
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += full.GR_NO;
				a += "</div>";
				return a;
			}
		}, {
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += full.GR_ITEM_NO;
				a += "</div>";
				return a;
			}
		}, {
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += full.CREATE_ON.substring(6) + '/' + full.CREATE_ON.substring(4, 6) + '/' + full.CREATE_ON.substring(0, 4);
				a += "</div>";
				return a;
			}
		}, {
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += full.GR_DATE.substring(6) + '/' + full.GR_DATE.substring(4, 6) + '/' + full.GR_DATE.substring(0, 4);
				a += "</div>";
				return a;
			}
		}, {
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += full.MAKTX == null ? "-" : full.MAKTX;
				a += "</div>";
				return a;
			}
		}, {
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += full.GR_ITEM_QTY;
				a += "</div>";
				return a;
			}
		}, {
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += full.MEINS == null ? "-" : full.MEINS;
				a += "</div>";
				return a;
			}
		}, {
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += numberWithCommas(full.GR_AMOUNT_IN_DOC);
				a += "</div>";
				return a;
			}
		}, {
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += full.GR_CURR == null || full.GR_CURR == 'null' ? "-" : full.GR_CURR;
				a += "</div>";
				return a;
			}
		}, {
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += full.PO_NO;
				a += "</div>";
				return a;
			}
		}, {
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += full.PO_ITEM_NO;
				a += "</div>";
				return a;
			}
		}, {
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				// onchange="ckbk(this,\'' + full.GR_NO + '\',\'' + full.GR_ITEM_NO + '\')"
				a += '<input type="checkbox" onchange="cekPOnCURR(this,\'' + full.GR_NO + '\',\'' + full.GR_ITEM_NO + '\')" class="ckb" value="' + full.PO_NO + '" data-curr="' + full.GR_CURR + '"  data-gr="' + full.GR_NO + '" data-amount="' + full.GR_AMOUNT_IN_DOC + '" data-grl="' + full.GR_ITEM_NO + '"';
				if (full.STATUS == 1)
					a += " checked>";
				else
					a += ">";
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

	$('#tableMT').find("th").off("click.DT");
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

function loadTableProposal() {
	// no = 1;
	$('#tableProposal').DataTable().destroy();
	$('#tableProposal tbody').empty();
	mytable = $('#tableProposal').DataTable({
		"bSort" : true,
		"dom" : 'rtpli',
		"deferRender" : true,
		"colReorder" : true,
		"pageLength" : 25,
		// "fixedHeader" : true,
		// "scrollX" : true,
		// "lengthMenu" : [5, 10, 25, 50, 75, 100],
		"language" : {
			"loadingRecords" : "<center><b>Please wait - Updating and Loading Data List Contract...</b></center>"
		},
		"ajax" : $("#base-url").val() + 'EC_Open_invoice/get_data_proposal',

		"columnDefs" : [{
			"searchable" : false,
			"orderable" : true,
			"targets" : 0
		}],
		"fnInitComplete" : function() {
			$('#tableProposal tbody tr').each(function() {
				$(this).find('td').attr('nowrap', 'nowrap');
			});
		},
		"drawCallback" : function(settings) {
			$('#tableProposal tbody tr').each(function() {
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
			//
			// $('.ckb').change(function() {
			// if ($(this).is(":checked")) {
			// compare.push($(this).data('gr'));
			// compareCntrk.push($(this).data('grl'));
			// // $(elm).attr('enabled', false)
			// $("#arrGR").val(compare)
			// $("#arrGRL").val(compareCntrk)
			// console.log(compare)
			// } else {
			//
			// }
			// });
		},
		"columns" : [{
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += full.GR_NO;
				a += "</div>";
				return a;
			}
		}, {
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += full.GR_ITEM_NO;
				a += "</div>";
				return a;
			}
		}, {
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += full.CREATE_ON.substring(6) + '/' + full.CREATE_ON.substring(4, 6) + '/' + full.CREATE_ON.substring(0, 4);
				a += "</div>";
				return a;
			}
		}, {
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += full.GR_DATE.substring(6) + '/' + full.GR_DATE.substring(4, 6) + '/' + full.GR_DATE.substring(0, 4);
				a += "</div>";
				return a;
			}
		}, {
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += full.MAKTX;
				a += "</div>";
				return a;
			}
		}, {
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += full.GR_ITEM_QTY;
				a += "</div>";
				return a;
			}
		}, {
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += full.MEINS;
				a += "</div>";
				return a;
			}
		}, {
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += numberWithCommas(full.GR_AMOUNT_IN_DOC);
				a += "</div>";
				return a;
			}
		}, {
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += full.GR_CURR == null || full.GR_CURR == 'null' ? "-" : full.GR_CURR;
				a += "</div>";
				return a;
			}
		}, {
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += full.PO_NO;
				a += "</div>";
				return a;
			}
		}, {
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += full.PO_ITEM_NO;
				a += "</div>";
				return a;
			}
		}/*
		 , {
		 mRender : function(data, type, full) {
		 a = "<div class='col-md-12 text-center'>";
		 // onchange="ckbk(this,\'' + full.GR_NO + '\',\'' + full.GR_ITEM_NO + '\')"
		 a += '<input type="checkbox" onchange="cekPOnCURR(this,\'' + full.GR_NO + '\',\'' + full.GR_ITEM_NO + '\')" class="ckb" value="' + full.PO_NO + '" data-curr="' + full.GR_CURR + '"  data-gr="' + full.GR_NO + '" data-amount="' + full.GR_AMOUNT_IN_DOC + '" data-grl="' + full.GR_ITEM_NO + '"';
		 if (full.STATUS == 1)
		 a += " checked>";
		 else
		 a += ">";
		 a += "</div>";
		 return a;
		 }
		 }*/
		],
	});
	mytable.columns().every(function() {
		var that = this;
		$('.srch', this.header()).on('keyup change', function() {
			if (that.search() !== this.value) {
				that.search(this.value).draw();
			}
		});
	});

	$('#tableProposal').find("th").off("click.DT");
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

function loadTableApproved() {
	// no = 1;
	$('#tableApproved').DataTable().destroy();
	$('#tableApproved tbody').empty();
	mytable = $('#tableApproved').DataTable({
		"bSort" : true,
		"dom" : 'rtpli',
		"deferRender" : true,
		"colReorder" : true,
		"pageLength" : 25,
		// "fixedHeader" : true,
		// "scrollX" : true,
		// "lengthMenu" : [5, 10, 25, 50, 75, 100],
		"language" : {
			"loadingRecords" : "<center><b>Please wait - Updating and Loading Data List Contract...</b></center>"
		},
		"ajax" : $("#base-url").val() + 'EC_Open_invoice/get_data_approved',

		"columnDefs" : [{
			"searchable" : false,
			"orderable" : true,
			"targets" : 0
		}],
		"fnInitComplete" : function() {
			$('#tableApproved tbody tr').each(function() {
				$(this).find('td').attr('nowrap', 'nowrap');
			});
		},
		"drawCallback" : function(settings) {
			$('#tableApproved tbody tr').each(function() {
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
			//
			// $('.ckb').change(function() {
			// if ($(this).is(":checked")) {
			// compare.push($(this).data('gr'));
			// compareCntrk.push($(this).data('grl'));
			// // $(elm).attr('enabled', false)
			// $("#arrGR").val(compare)
			// $("#arrGRL").val(compareCntrk)
			// console.log(compare)
			// } else {
			//
			// }
			// });
		},
		"columns" : [{
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += full.GR_NO;
				a += "</div>";
				return a;
			}
		}, {
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += full.GR_ITEM_NO;
				a += "</div>";
				return a;
			}
		}, {
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += full.CREATE_ON.substring(6) + '/' + full.CREATE_ON.substring(4, 6) + '/' + full.CREATE_ON.substring(0, 4);
				a += "</div>";
				return a;
			}
		}, {
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += full.GR_DATE.substring(6) + '/' + full.GR_DATE.substring(4, 6) + '/' + full.GR_DATE.substring(0, 4);
				a += "</div>";
				return a;
			}
		}, {
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += full.MAKTX;
				a += "</div>";
				return a;
			}
		}, {
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += full.GR_ITEM_QTY;
				a += "</div>";
				return a;
			}
		}, {
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += full.MEINS;
				a += "</div>";
				return a;
			}
		}, {
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += numberWithCommas(full.GR_AMOUNT_IN_DOC);
				a += "</div>";
				return a;
			}
		}, {
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += full.GR_CURR == null || full.GR_CURR == 'null' ? "-" : full.GR_CURR;
				a += "</div>";
				return a;
			}
		}, {
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += full.PO_NO;
				a += "</div>";
				return a;
			}
		}, {
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += full.PO_ITEM_NO;
				a += "</div>";
				return a;
			}
		}/*
		 , {
		 mRender : function(data, type, full) {
		 a = "<div class='col-md-12 text-center'>";
		 // onchange="ckbk(this,\'' + full.GR_NO + '\',\'' + full.GR_ITEM_NO + '\')"
		 a += '<input type="checkbox" onchange="cekPOnCURR(this,\'' + full.GR_NO + '\',\'' + full.GR_ITEM_NO + '\')" class="ckb" value="' + full.PO_NO + '" data-curr="' + full.GR_CURR + '"  data-gr="' + full.GR_NO + '" data-amount="' + full.GR_AMOUNT_IN_DOC + '" data-grl="' + full.GR_ITEM_NO + '"';
		 if (full.STATUS == 1)
		 a += " checked>";
		 else
		 a += ">";
		 a += "</div>";
		 return a;
		 }
		 }*/
		],
	});
	mytable.columns().every(function() {
		var that = this;
		$('.srch', this.header()).on('keyup change', function() {
			if (that.search() !== this.value) {
				that.search(this.value).draw();
			}
		});
	});

	$('#tableApproved').find("th").off("click.DT");
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

function loadDataList() {
	$.ajax({
		url : $("#base-url").val() + 'EC_Open_invoice/get_approved',
		data : {
			// "min" : range_harga[0],
			// "max" : range_harga[1],
			// "limitMin" : limitMin,
			// "limitMax" : limitMax
		},
		type : 'POST',
		dataType : 'json'
	}).done(function(data) {
		var plant = null;

		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth() + 1;
		//January is 0!
		var yyyy = today.getFullYear();
		if (dd < 10) {
			dd = '0' + dd;
		}

		if (mm < 10) {
			mm = '0' + mm;
		}

		var now = yyyy + '/' + mm + '/' + dd;

		$("#divAttributes").empty()
		if (data.data.length == 0)
			$("#divAttributes").append('<div class="row text-center">Data Tidak Ditemukan!!</div>')
		else
			for (var i = 0; i < data.data.length; i++) {

				var startdate = data.data[i][2].substring(6, 10) + '/' + data.data[i][2].substring(3, 5) + '/' + data.data[i][2].substring(0, 2);
				//var enddate = data.data[i][10].substring(0, 4) + '-' + data.data[i][10].substring(4, 6) + '-' + data.data[i][10].substring(6);
				// console.log(now);
				// console.log(startdate);
				var oneDay = 24 * 60 * 60 * 1000;
				// hours*minutes*seconds*milliseconds
				var firstDate = new Date(startdate);
				var secondDate = new Date(now);
				var diffDays = Math.round(Math.round((secondDate.getTime() - firstDate.getTime()) / (oneDay)));
				//$("#x_Date_Difference").val(diffDays);

				teks = '<tr class="proposal">'
				teks += '<td>' + data.data[i][2] + '</td>'
				teks += '<td style="text-align: center;">' + diffDays + '</td>'
				teks += '<td><a href="javascript:void(0)" data-backdrop="true" data-toggle="modal" data-target="#modalInvoinceNo" data-invoince="' + data.data[i][6] + '">' + data.data[i][1] + '</a></td>'
				teks += '<td><a href="javascript:void(0)" data-backdrop="true" data-toggle="modal" data-target="#modalFaktur" data-faktur="' + data.data[i][7] + '">' + data.data[i][3] + '</a></td>'
				teks += '<td>' + data.data[i][5] + '</td>'
				teks += '<td>' + data.data[i][4] + '</td>'
				//teks += '<td><a href="javascript:void(0)"><i class="glyphicon glyphicon-arrow-right"></i></a></td>'
				teks += '<td onclick="viewdetail(this,\'' + data.data[i][1] + '\',\'' + data.data[i][2] + '\')"><a href="javascript:void(0)">Detail</a></td>'
				teks += '/<tr>'
				$("#divAttributes").append(teks);

			}

		// }

	}).fail(function() {
		// console.log("error");
	}).always(function(data) {
		// console.log(data);

	});

}

function loadDataListApp() {
	$.ajax({
		url : $("#base-url").val() + 'EC_Open_invoice/get_approved2',
		data : {
			// "min" : range_harga[0],
			// "max" : range_harga[1],
			// "limitMin" : limitMin,
			// "limitMax" : limitMax
		},
		type : 'POST',
		dataType : 'json'
	}).done(function(data) {
		var plant = null;

		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth() + 1;
		//January is 0!
		var yyyy = today.getFullYear();
		if (dd < 10) {
			dd = '0' + dd;
		}

		if (mm < 10) {
			mm = '0' + mm;
		}

		var now = yyyy + '/' + mm + '/' + dd;

		$("#divAttributesApp").empty()
		if (data.data.length == 0)
			$("#divAttributesApp").append('<div class="row text-center">Data Tidak Ditemukan!!</div>')
		else
			for (var i = 0; i < data.data.length; i++) {

				var startdate = data.data[i][2].substring(6, 10) + '/' + data.data[i][2].substring(3, 5) + '/' + data.data[i][2].substring(0, 2);
				//var enddate = data.data[i][10].substring(0, 4) + '-' + data.data[i][10].substring(4, 6) + '-' + data.data[i][10].substring(6);
				// console.log(now);
				// console.log(startdate);
				var oneDay = 24 * 60 * 60 * 1000;
				// hours*minutes*seconds*milliseconds
				var firstDate = new Date(startdate);
				var secondDate = new Date(now);
				var diffDays = Math.round(Math.round((secondDate.getTime() - firstDate.getTime()) / (oneDay)));
				//$("#x_Date_Difference").val(diffDays);

				teks = '<tr class="approved">'
				teks += '<td>' + data.data[i][2] + '</td>'
				teks += '<td style="text-align: center;">' + diffDays + '</td>'
				teks += '<td><a href="javascript:void(0)" data-backdrop="true" data-toggle="modal" data-target="#modalInvoinceNo" data-invoince="' + data.data[i][6] + '">' + data.data[i][1] + '</a></td>'
				teks += '<td><a href="javascript:void(0)" data-backdrop="true" data-toggle="modal" data-target="#modalFaktur" data-faktur="' + data.data[i][7] + '">' + data.data[i][3] + '</a></td>'
				teks += '<td>' + data.data[i][5] + '</td>'
				teks += '<td>' + data.data[i][4] + '</td>'
				//teks += '<td><a href="javascript:void(0)"><i class="glyphicon glyphicon-arrow-right"></i></a></td>'
				teks += '<td onclick="viewdetailApp(this,\'' + data.data[i][1] + '\',\'' + data.data[i][2] + '\')"><a href="javascript:void(0)">Detail</a></td>'
				teks += '/<tr>'
				$("#divAttributesApp").append(teks);

			}

		// }

	}).fail(function() {
		// console.log("error");
	}).always(function(data) {
		// console.log(data);

	});

}

function loadDataListreject() {
	$.ajax({
		url : $("#base-url").val() + 'EC_Open_invoice/get_reject',
		data : {
			// "min" : range_harga[0],
			// "max" : range_harga[1],
			// "limitMin" : limitMin,
			// "limitMax" : limitMax
		},
		type : 'POST',
		dataType : 'json'
	}).done(function(data) {
		var plant = null;

		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth() + 1;
		//January is 0!
		var yyyy = today.getFullYear();
		if (dd < 10) {
			dd = '0' + dd;
		}

		if (mm < 10) {
			mm = '0' + mm;
		}

		var now = yyyy + '/' + mm + '/' + dd;

		$("#divAttributesReject").empty()
		if (data.data.length == 0)
			$("#divAttributesReject").append('<div class="row text-center">Data Tidak Ditemukan!!</div>')
		else
			for (var i = 0; i < data.data.length; i++) {

				var startdate = data.data[i][2].substring(6, 10) + '/' + data.data[i][2].substring(3, 5) + '/' + data.data[i][2].substring(0, 2);
				//var enddate = data.data[i][10].substring(0, 4) + '-' + data.data[i][10].substring(4, 6) + '-' + data.data[i][10].substring(6);
				// console.log(now);
				// console.log(startdate);
				var oneDay = 24 * 60 * 60 * 1000;
				// hours*minutes*seconds*milliseconds
				var firstDate = new Date(startdate);
				var secondDate = new Date(now);
				var diffDays = Math.round(Math.round((secondDate.getTime() - firstDate.getTime()) / (oneDay)));
				//$("#x_Date_Difference").val(diffDays);

				teks = '<tr class="approved">'
				teks += '<td style="text-align: center;">' + data.data[i][2] + '</td>'
				teks += '<td style="text-align: center;">' + diffDays + '</td>'
				teks += '<td style="text-align: center;"><a href="javascript:void(0)" data-backdrop="true" data-toggle="modal" data-target="#modalInvoinceNo" data-invoince="' + data.data[i][6] + '">' + data.data[i][1] + '</a></td>'
				teks += '<td style="text-align: center;"><a href="javascript:void(0)" data-backdrop="true" data-toggle="modal" data-target="#modalFaktur" data-faktur="' + data.data[i][7] + '">' + data.data[i][3] + '</a></td>'
				teks += '<td style="text-align: center;">' + data.data[i][5] + '</td>'
				teks += '<td style="text-align: center;">' + data.data[i][4] + '</td>'
				//teks += '<td><a href="javascript:void(0)"><i class="glyphicon glyphicon-arrow-right"></i></a></td>'
				teks += '<td onclick="viewdetailreject(this,\'' + data.data[i][8] + '\')"><a href="javascript:void(0)">Alasan Reject</a></td>'
				teks += '/<tr>'
				$("#divAttributesReject").append(teks);

			}

		// }

	}).fail(function() {
		// console.log("error");
	}).always(function(data) {
		// console.log(data);

	});

}

function viewdetail(element, invoiceno, docdate) {
	var masterCurrency;
	var today = new Date();
	var dd = today.getDate();
	var mm = today.getMonth() + 1;
	//January is 0!
	var yyyy = today.getFullYear();
	if (dd < 10) {
		dd = '0' + dd;
	}

	if (mm < 10) {
		mm = '0' + mm;
	}

	var now = dd + '/' + mm + '/' + yyyy;

	$("#InvoiceNo").val(invoiceno)
	$("#InvoiceNoApp").val(invoiceno)
	$("#DocumentDate").val(docdate)
	$("#PostingDate").val(now)
	$("#PaymentBlock").val('3')
	$.ajax({
		url : $("#base-url").val() + 'EC_Open_invoice/get_invoiceDetail/' + invoiceno,
		data : {
			//"qty" : $("#qtyy").val(),
			//"contract_no" : contract_no,
			//"matno" : matno
		},
		type : 'POST',
		dataType : 'json'
	}).done(function(data) {
		//console.log(data);
		$(".proposal").removeClass("success")
		$(element).parent().addClass("success")
		$("#InvoiceDetail").empty()
		if (data.data.length == 0)
			$("#InvoiceDetail").append('<div class="row text-center">Data Tidak Ditemukan!!</div>')
		else
			for (var i = 0; i < data.data.length; i++) {
				teks = '<tr>'
				teks += '<td>' + data.data[i][1] + '</td>'
				teks += '<td>' + data.data[i][1] + '</td>'
				teks += '<td>' + data.data[i][2] + '</td>'
				teks += '<td>' + data.data[i][3] + '</td>'
				teks += '<td>' + data.data[i][4] + '</td>'
				teks += '<td>' + data.data[i][5] + '</td>'
				teks += '<td>' + data.data[i][6] + '</td>'
				teks += '<td>' + data.data[i][7] + '</td>'
				//teks += '<td><a href="javascript:void(0)"><i class="glyphicon glyphicon-arrow-right"></i></a></td>'
				//teks += '<td><a href="javascript:void(0)" onclick="viewdetail(this,\'' + data.data[i][1] + '\')">Detail</a></td>'
				teks += '/<tr>'
				$("#InvoiceDetail").append(teks);

			}
	}).fail(function(data) {
		// console.log("error");
		// $("#pocreated").text(data['RETURN'][0]['MESSAGE'])
	}).always(function(data) {
		// console.log(data)

	});

}

function viewdetailApp(element, invoiceno, docdate) {
	var masterCurrency;
	var today = new Date();
	var dd = today.getDate();
	var mm = today.getMonth() + 1;
	//January is 0!
	var yyyy = today.getFullYear();
	if (dd < 10) {
		dd = '0' + dd;
	}

	if (mm < 10) {
		mm = '0' + mm;
	}

	var now = dd + '/' + mm + '/' + yyyy;

	$("#InvoiceNo").val(invoiceno)
	$("#InvoiceNoApp").val(invoiceno)
	$("#DocumentDate").val(docdate)
	$("#PostingDate").val(now)
	$("#PaymentBlock").val('3')
	$.ajax({
		url : $("#base-url").val() + 'EC_Open_invoice/get_invoiceDetail/' + invoiceno,
		data : {
			//"qty" : $("#qtyy").val(),
			//"contract_no" : contract_no,
			//"matno" : matno
		},
		type : 'POST',
		dataType : 'json'
	}).done(function(data) {
		//console.log(data);
		$(".approved").removeClass("success")
		$(element).parent().addClass("success")
		$("#InvoiceDetailApp").empty()
		if (data.data.length == 0)
			$("#InvoiceDetailApp").append('<div class="row text-center">Data Tidak Ditemukan!!</div>')
		else
			for (var i = 0; i < data.data.length; i++) {
				teks = '<tr>'
				teks += '<td>' + data.data[i][1] + '</td>'
				teks += '<td>' + data.data[i][1] + '</td>'
				teks += '<td>' + data.data[i][2] + '</td>'
				teks += '<td>' + data.data[i][3] + '</td>'
				teks += '<td>' + data.data[i][4] + '</td>'
				teks += '<td>' + data.data[i][5] + '</td>'
				teks += '<td>' + data.data[i][6] + '</td>'
				teks += '<td>' + data.data[i][7] + '</td>'
				//teks += '<td><a href="javascript:void(0)"><i class="glyphicon glyphicon-arrow-right"></i></a></td>'
				//teks += '<td><a href="javascript:void(0)" onclick="viewdetail(this,\'' + data.data[i][1] + '\')">Detail</a></td>'
				teks += '/<tr>'
				$("#InvoiceDetailApp").append(teks);

			}
	}).fail(function(data) {
		// console.log("error");
		// $("#pocreated").text(data['RETURN'][0]['MESSAGE'])
	}).always(function(data) {
		// console.log(data)

	});

}

function viewdetailreject(element, alasanreject) {
	// var masterCurrency;
	// var today = new Date();
	// var dd = today.getDate();
	// var mm = today.getMonth() + 1;
	// //January is 0!
	// var yyyy = today.getFullYear();
	// if (dd < 10) {
	// 	dd = '0' + dd;
	// }

	// if (mm < 10) {
	// 	mm = '0' + mm;
	// }

	// var now = dd + '/' + mm + '/' + yyyy;

	$("#alasanreject").val(alasanreject)
	// $("#InvoiceNoApp").val(invoiceno)
	// $("#DocumentDate").val(docdate)
	// $("#PostingDate").val(now)
	// $("#PaymentBlock").val('3')
	// $.ajax({
	// 	url : $("#base-url").val() + 'EC_Open_invoice/get_invoiceDetail/' + invoiceno,
	// 	data : {
	// 		//"qty" : $("#qtyy").val(),
	// 		//"contract_no" : contract_no,
	// 		//"matno" : matno
	// 	},
	// 	type : 'POST',
	// 	dataType : 'json'
	// }).done(function(data) {
	// 	//console.log(data);
	// 	$(".approved").removeClass("success")
	// 	$(element).parent().addClass("success")
	// 	$("#InvoiceDetailReject").empty()
	// 	if (data.data.length == 0)
	// 		$("#InvoiceDetailReject").append('<div class="row text-center">Data Tidak Ditemukan!!</div>')
	// 	else
	// 		for (var i = 0; i < data.data.length; i++) {
	// 			teks = '<tr>'
	// 			teks += '<td>' + data.data[i][1] + '</td>'
	// 			teks += '<td>' + data.data[i][1] + '</td>'
	// 			teks += '<td>' + data.data[i][2] + '</td>'
	// 			teks += '<td>' + data.data[i][3] + '</td>'
	// 			teks += '<td>' + data.data[i][4] + '</td>'
	// 			teks += '<td>' + data.data[i][5] + '</td>'
	// 			teks += '<td>' + data.data[i][6] + '</td>'
	// 			teks += '<td>' + data.data[i][7] + '</td>'
	// 			//teks += '<td><a href="javascript:void(0)"><i class="glyphicon glyphicon-arrow-right"></i></a></td>'
	// 			//teks += '<td><a href="javascript:void(0)" onclick="viewdetail(this,\'' + data.data[i][1] + '\')">Detail</a></td>'
	// 			teks += '/<tr>'
	// 			$("#InvoiceDetailReject").append(teks);

	// 		}
	// }).fail(function(data) {
	// 	// console.log("error");
	// 	// $("#pocreated").text(data['RETURN'][0]['MESSAGE'])
	// }).always(function(data) {
	// 	// console.log(data)

	// });

}


$('#modalInvoinceNo').on('show.bs.modal', function(event) {
	var button = $(event.relatedTarget)
	var Invoince = button.data('invoince')

	$("#picInvoince").attr('src', $("#base-url").val() + $("#UPLOAD_PATH").val() + "EC_invoice/" + Invoince);

});

$('#modalFaktur').on('show.bs.modal', function(event) {
	var button = $(event.relatedTarget)
	var Faktur = button.data('faktur')

	$("#picFaktur").attr('src', $("#base-url").val() + $("#UPLOAD_PATH").val() + "EC_invoice/" + Faktur);

});
