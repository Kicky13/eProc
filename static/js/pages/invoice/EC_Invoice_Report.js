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
		"lengthMenu" : [5, 10, 15, 25, 50, 75, 100,-1],
		"language" : {
			"loadingRecords" : "<center><b>Please wait - Updating and Loading Data List Contract...</b></center>"
		},
		"ajax" : $("#base-url").val() + 'EC_Invoice_Report/Get_all_invoice',

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
			setHrefPublic();
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
				a += full.NO;
				a += "</div>";
				return a;
			}
		}, {
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += full.INVOICE_DATE;
				a += "</div>";
				return a;
			}
		}, {
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += '<a href="'+$("#base-url").val()+'upload/EC_invoice/'+full.INVOICE_PIC+'" target="_blank">'+full.NO_INVOICE+'</a>';
				a += "</div>";
				return a;
			}
		}, {
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += full.INVOICE_SAP;
				a += "</div>";
				return a;
			}
		}, {
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += full.FI_NUMBER_SAP;
				a += "</div>";
				return a;
			}
		},{
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += full.FISCALYEAR_SAP;
				a += "</div>";
				return a;
			}
		},{
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += full.VEND_NAME;
				a += "</div>";
				return a;
			}  
		},{ 
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += full.NO_SP_PO;
				a += "</div>";
				return a;
			}   
		}, {
                    mRender: function (data, type, full) {
                        if(full.BSART=='ZPL'){
                            z = "Pembelian Langsung";
                        }else{
                            z = "Pengadaan";
                        };
                        a = "<div class='col-md-12 text-center'>";
                        a += z;
                        a += "</div>";
                        return a;
                    }
                },{
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += full.CURRENCY + " <strong>" + numberWithCommas(full.TOTAL_AMOUNT) + "</strong>";
				a += "</div>";
				return a;
			}
		}, {
			mRender : function(data, type, full) {
				if (full.STATUS_HEADER == '1') {
					status = "Draft";
				} else if (full.STATUS_HEADER == '2') {
					status = "Submited";
				} else if (full.STATUS_HEADER == '3') {
					status = "Approved";
				} else if (full.STATUS_HEADER == '4') {
					status = "Rejected";
				} else if (full.STATUS_HEADER == '5') {
					status = "Posted";
				} else if (full.STATUS_HEADER == '6') {
					status = "Paid";
				}
				a = "<div class='col-md-12 text-center'>";
				a += status;
				a += "</div>";
				return a;
			}
		}, {
			mRender : function(data, type, full) {
				ket = '';
                if(full.STATUS_HEADER!='1'&&full.STATUS_HEADER!='2'){
                    if(full.POSISI=='VENDOR' && full.STATUS_DOC=='BELUM KIRIM') ket = 'APPROVE-1';
                    else if(full.POSISI=='EKSPEDISI' && full.STATUS_DOC=='KIRIM') ket = 'APPROVE-2';
                    else if(full.POSISI=='VERIFIKASI' && full.STATUS_DOC=='TERIMA') ket = 'APPROVE-3';
                    else if(full.POSISI=='VERIFIKASI' && full.STATUS_DOC=='BELUM KIRIM') ket = 'POSTED-1';
                    else if(full.POSISI=='VERIFIKASI' && full.STATUS_DOC=='KIRIM') ket = 'POSTED-2';
                    else if(full.POSISI=='BENDAHARA' && full.STATUS_DOC=='TERIMA') ket = 'POSTED-3';
                }

				a = "<div class='col-md-12 text-center'>";
				a += ket;
				a += "</div>";
				return a;
			}
		},{
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += full.POSISI ;
				a += "</div>";
				return a;
			}
		},{
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += full.STATUS_DOC ;
				a += "</div>";
				return a;
			}
		},{
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 '>";
				a += "<a href='EC_Invoice_Report/detail/"+full.ID_INVOICE+"/' title='Detail Invoice'><span class='glyphicon glyphicon-share-alt' aria-hidden='true'></span></a>&nbsp;&nbsp;"+
					 "<a href='javascript:void(0)' data-toggle=\"modal\" data-id_invoice='" + full.ID_INVOICE + "' data-target=\"#modalTracking\" title='History Invoice'><span class='glyphicon glyphicon-search' aria-hidden='true'></span></a>&nbsp;&nbsp;";
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

});

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
		"ajax" : $("#base-url").val() + 'EC_Invoice_Report/get_data',

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
			cnt=-1;
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
		"columns" : [ {
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
		},  {
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += full.DESCRIPTION == null ? "-" : full.DESCRIPTION;
				a += "</div>";
				return a;
			}
		},
                {
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += full.GR_ITEM_QTY;
				a += "</div>";
				return a;
			}
		}, {
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += full.GR_ITEM_UNIT == null ? "-" : full.GR_ITEM_UNIT;
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
				a += '<input type="checkbox" onclick="cekGRSelected(this)" class="ckb" value="' + full.PO_NO + '" data-curr="' + full.GR_CURR + '"  data-gr="' + full.GR_NO + '" data-amount="' + full.GR_AMOUNT_IN_DOC + '" data-grl="' + full.GR_ITEM_NO + '" data-tahun="'+full.GR_YEAR+'" data-uom="'+full.GR_ITEM_UNIT+'" data-item_qty="'+full.GR_ITEM_QTY+'" data-po_item_no="' + full.PO_ITEM_NO + '"';
                                a += 'data-grdate="' + full.CREATE_ON + '"  data-grposting="' + full.GR_DATE + '" data-description="' + full.DESCRIPTION + '" data-item_cat="'+full.TYPE_TRANSAKSI+'"';
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
