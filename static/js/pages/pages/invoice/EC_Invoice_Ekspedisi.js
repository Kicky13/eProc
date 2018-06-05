function loadTable_invoice() {

	$('#table_inv').DataTable().destroy();
	$('#table_inv tbody').empty();
	mytable_inv = $('#table_inv').DataTable({
		"bSort" : true,
		"dom" : 'rtpli',
		"deferRender" : true,
		"colReorder" : true,
		"pageLength" : 15,
		// "fixedHeader" : true,
		// "scrollX" : true,
		"lengthMenu" : [5, 10, 15, 25, 50, 75, 100],
		"language" : {
			"loadingRecords" : "<center><b>Please wait - Updating and Loading Data Invoice...</b></center>"
		},
		"ajax" : $("#base-url").val() + 'EC_Invoice_Ekspedisi/Get_all_invoice',

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
				a += '<a href="../upload/EC_invoice/'+full.INVOICE_PIC+'" target="_blank">'+full.NO_INVOICE+'</a>';
				a += "</div>";
				return a;
			}
		},{
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += full.FI_NUMBER_SAP;
				a += "</div>";
				return a;
			}
		},{
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += full.COMPANY_CODE;
				a += "</div>";
				return a;
			}
		},{
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += full.FI_YEAR;
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
				a = "<div class='col-md-12 '>";
				a += "<a href='EC_Invoice_Report/detail/"+full.ID_INVOICE+"/' title='Detail Invoice'><span class='glyphicon glyphicon-share-alt' aria-hidden='true'></span></a>&nbsp;&nbsp;";
				//a += "<a href='javascript:void(0)' data-toggle=\"modal\" data-target=\"#Print\" title='Cetak Invoice'><span class='glyphicon glyphicon-print' aria-hidden='true'></span></a>&nbsp;&nbsp;";
				if(full.APPROVAL != null){
					a += "<a href='EC_Approval/Invoice/cetakLembarVerifikasi/"+full.ID_INVOICE+"' title='Cetak Lembar Verifikasi' target='_blank'><span class='glyphicon glyphicon-print' aria-hidden='true'></span></a>&nbsp;&nbsp;";	
				}
				
				
				a += "<a href='javascript:void(0)' data-toggle=\"modal\" data-id_invoice='" + full.ID_INVOICE + "' data-target=\"#modalTracking\" title='History Invoice'><span class='glyphicon glyphicon-search' aria-hidden='true'></span></a>&nbsp;&nbsp;";
				a += "<input type='checkbox' onclick='checkPilihan(this)' data-company='"+full.COMPANY_CODE+"' data-id_invoice ='"+full.ID_INVOICE+"'>";
				a += "</div>";
				return a;
			}
		}],

	});

	mytable_inv.columns().every(function() {
		var that = this;
		$('.srch', this.header()).on('keyup change', function() {
			if (that.search() !== this.value) {
				that.search(this.value).draw();
			}
		});
	});

	var clicks = 0;
	mytable_inv.on("click",'thead>tr>th.ts' ,function(e) {
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

	$('#table_inv').find("th").off("click.DT");
	mytable_inv.on('dblclick','thead>tr>th.ts' ,function() {
		var _index = $(this).index();
		var _sort = $(this).data('sorting') || 'asc';
		var _nextSort = _sort == 'asc' ? 'desc' : 'asc';
		$(this).data('sorting',_nextSort);
		mytable_inv.order([_index, _sort]).draw();
	});
}

function loadTable_Request() {

	$('#table_Request').DataTable().destroy();
	$('#table_Request tbody').empty();
	mytable_request = $('#table_Request').DataTable({
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
		"ajax" : $("#base-url").val() + 'EC_Invoice_Ekspedisi/Get_all_invoice/0',

		"columnDefs" : [{
			"searchable" : false,
			"orderable" : true,
			"targets" : 0
		}],
		// "order": [[ 1, 'asc' ]],
		"fnInitComplete" : function() {
			$('#table_Request tbody tr').each(function() {
				$(this).find('td').attr('nowrap', 'nowrap');
			});
		},
        "fnCreatedRow": function (row, data, index) {
                    $('td', row).eq(0).html(index + 1);
                },
		"drawCallback" : function(settings) {
			$('#table_Request tbody tr').each(function() {
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
				a += '<a href="../upload/EC_invoice/'+full.INVOICE_PIC+'" target="_blank">'+full.NO_INVOICE+'</a>';
				a += "</div>";
				return a;
			}
		},{
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += full.FI_NUMBER_SAP;
				a += "</div>";
				return a;
			}
		},{
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += full.COMPANY_CODE;
				a += "</div>";
				return a;
			}
		},{
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += full.FI_YEAR;
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
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += full.CURRENCY + " <strong>" + numberWithCommas(full.TOTAL_AMOUNT) + "</strong>";
				a += "</div>";
				return a;
			}
		}, {
			mRender : function(data, type, full) {
				if (full.STATUS_APPROVAL == '0') {
					status = "Request Approval 1";
				} else if (full.STATUS_APPROVAL == '1') {
					status = "Request Approval 2";
				}else if (full.STATUS_APPROVAL == '2') {
					status = "Request Approval 3";
				}
				a = "<div class='col-md-12 text-center'>";
				a += status;
				a += "</div>";
				return a;
			}
		}, {
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 '>";
				a += "<a href='EC_Invoice_Report/detail/"+full.ID_INVOICE+"/' title='Detail Invoice'><span class='glyphicon glyphicon-share-alt' aria-hidden='true'></span></a>&nbsp;&nbsp;";
				a += "</div>";
				return a;
			}
		}],

	});

	mytable_request.columns().every(function() {
		
		var that1 = this;
		$('.srch1', this.header()).on('keyup change', function() {
			if (that1.search() !== this.value) {
				that1.search(this.value).draw();
			}
		});
	});

	var clicks1 = 0;
	mytable_request.on("click",'thead>tr>th.ts1' ,function(e) {
		clicks1++;
		if (clicks1 === 1) {
			timer1 = setTimeout(function() {
				$(".sear1").toggle();
				clicks1 = 0;
			}, 300);
		} else {
			clearTimeout(timer1);
			$(".sear1").hide();
			clicks1 = 0;
		}
	}).on("dblclick", function(e) {
		e.preventDefault();
	});

	$('#table_Request').find("th").off("click.DT");
	mytable_request.on('dblclick','thead>tr>th.ts1' ,function() {
		var _index1 = $(this).index();
		var _sort1 = $(this).data('sorting') || 'asc';
		var _nextSort1 = _sort1 == 'asc' ? 'desc' : 'asc';
		$(this).data('sorting',_nextSort1);
		mytable_request.order([_index1, _sort1]).draw();
	});
}

function loadTable_Rejected() {

	$('#table_Rejected').DataTable().destroy();
	$('#table_Rejected tbody').empty();
	mytable_rejected = $('#table_Rejected').DataTable({
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
		"ajax" : $("#base-url").val() + 'EC_Invoice_Ekspedisi/Get_all_invoice/4',

		"columnDefs" : [{
			"searchable" : false,
			"orderable" : true,
			"targets" : 0
		}],
		// "order": [[ 1, 'asc' ]],
		"fnInitComplete" : function() {
			$('#table_Rejected tbody tr').each(function() {
				$(this).find('td').attr('nowrap', 'nowrap');
			});
		},
        "fnCreatedRow": function (row, data, index) {
                    $('td', row).eq(0).html(index + 1);
                },
		"drawCallback" : function(settings) {
			$('#table_Rejected tbody tr').each(function() {
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
				a += '<a href="../upload/EC_invoice/'+full.INVOICE_PIC+'" target="_blank">'+full.NO_INVOICE+'</a>';
				a += "</div>";
				return a;
			}
		},{
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += full.FI_NUMBER_SAP;
				a += "</div>";
				return a;
			}
		},{
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += full.COMPANY_CODE;
				a += "</div>";
				return a;
			}
		},{
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += full.FI_YEAR;
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
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += full.CURRENCY + " <strong>" + numberWithCommas(full.TOTAL_AMOUNT) + "</strong>";
				a += "</div>";
				return a;
			}
		}, {
			mRender : function(data, type, full) {
				if (full.STATUS_APPROVAL == '4') {
					status = "Rejeted";
				}else{
					status = "Not Defined";
				}
				a = "<div class='col-md-12 text-center'>";
				a += status;
				a += "</div>";
				return a;
			}
		}, {
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 '>";
				a += "<a href='EC_Invoice_Report/detail/"+full.ID_INVOICE+"/' title='Detail Invoice'><span class='glyphicon glyphicon-share-alt' aria-hidden='true'></span></a>&nbsp;&nbsp;";
				a += "<a href='#' data-id_invoice='"+full.ID_INVOICE+"' onclick='reverseInvoice(this)' title='Reverse Invoice'><span class='glyphicon glyphicon-refresh' aria-hidden='true'></span></a>&nbsp;&nbsp;";
				a += "<a href='#' data-id_invoice='"+full.ID_INVOICE+"' onclick='reRequestApproval(this) 'title='Re-Request Approval'><span class='glyphicon glyphicon-repeat' aria-hidden='true'></span></a>&nbsp;&nbsp;";
				a += "</div>";
				return a;
			}
		}],

	});

	mytable_rejected.columns().every(function() {
		var that2 = this;
		$('.srch2', this.header()).on('keyup change', function() {
			if (that2.search() !== this.value) {
				that2.search(this.value).draw();
			}
		});
	});
	var clicks2 = 0;
	mytable_rejected.on("click",'thead>tr>th.ts2' ,function(e) {
		clicks2++;
		if (clicks2 === 1) {
			timer2 = setTimeout(function() {
				$(".sear2").toggle();
				clicks2 = 0;
			}, 300);
		} else {
			clearTimeout(timer2);
			$(".sear2").hide();
			clicks2 = 0;
		}
	}).on("dblclick", function(e) {
		e.preventDefault();
	});
	$('#table_Rejected').find("th").off("click.DT");
	mytable_rejected.on('dblclick','thead>tr>th.ts2' ,function() {
		var _index2 = $(this).index();
		var _sort2 = $(this).data('sorting') || 'asc';
		var _nextSort2 = _sort2 == 'asc' ? 'desc' : 'asc';
		$(this).data('sorting',_nextSort2);
		mytable_rejected.order([_index2, _sort2]).draw();
	});
}



function checkPilihan(elm){
	/* pastikan nomer PO dan item_cat sama */
	var ini = $(elm);
	var table = ini.closest('table');
	var _ck = table.find('input:checked').not(ini);
	var _op, _ic;

	if (ini.is(':checked')) {
			if (_ck.length) {
					_op = _ck.eq(0).data('company');
					var _valid = 1,
							_pesan = [];
					if (ini.data('company') != _op) {
							_valid = 0;
							_pesan.push('Company code tidak sama');
					}

					if (!_valid) {
							ini.prop('checked', 0);
							bootbox.alert({
									title: 'Warning ....',
									message: _pesan.join(' '),
									callback: function() {}
							})
					}
			}
	}
}

function createEkspedisi(elm) {
    var id_inv = get_id_invoice();
    //var _p = [1,2,8,9];
    if (id_inv.length) {
        var url = $("#base-url").val() + 'EC_Invoice_Ekspedisi/listDokumen/';
    	$.post(url, {id : id_inv}, function(html) {
    	    bootbox.dialog({
            title: 'Daftar Dokumen',
    	    message: html,
            className: 'bb-alternate-modal',
		    callback: function() {

		    }
    	}).on('shown.bs.modal', function(e) {
				$(this).find('tr[class^=dokumen]').hide();
			});
    	}, 'html');

    } else {
        bootbox.alert('Tidak ada Invoice yang dipilih');
    }

}

function get_id_invoice(elm) {
	var invTerpilih = mytable_inv.rows().nodes().to$().find(':checkbox:checked');
	// var invTerpilih = $('#table_inv').find(':checked');
	alert(invTerpilih);
    var id_inv = [];
    var index = 0;

    if (invTerpilih.length) {
        invTerpilih.each(function() {
            id_inv[index] = invTerpilih.eq(index).data('id_invoice');
            index +=1;
    	});
    }
    return id_inv;
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
                        teks += "<td class=\"text-center\">" + data[i]['STATUS_DOC'] + "</td>"
                        teks += "<td class=\"text-center\">" + data[i]['POSISI'] + "</td>"
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


function kirimDokumen(elm){
    var id_invoice = $(elm).data('invoice');
    var status = $(elm).data('status') || '';
    var url = $("#base-url").val() + 'EC_Invoice_Ekspedisi/listDokumen';
    $.post(url, {
        id : [id_invoice]
    }, function(html) {
        bootbox.dialog({
            title: 'Daftar Dokumen',
            message: html,
            className: 'bb-alternate-modal',
            callback: function() {

            }
        });
    }, 'html');
}

function SubmitDokumen(elm) {
    /* pastikan semua checkbox sudah dipilih */
    var _table = $(elm).closest('table');
    var _tbody = _table.find('tbody');
    var _ld = _tbody.find('input:checked');
    var _totalDoc = _tbody.find('tr[class^=dokumen]').length;
    var _invoice = $(elm).data('invoice');
    // var _proses = $(elm).data('proses');

    $(elm).hide();
    if (_ld.length == _totalDoc) {
        var _url = $("#base-url").val() + 'EC_Invoice_Ekspedisi/updatePosisiDokumen';
        $.post(_url, {
            invoice: _invoice['list_id'],
          //  proses: _proses
        }, function(data) {
            if (data.status) {
                bootbox.alert(data.message, function() {
										/*cetak ekspedisi ppl */
										$.redirect(data.urlcetak,{data : data.id},'POST','_blank');
                    /* refresh datatable */
                    bootbox.hideAll();
                    loadTable_invoice();
                });
            } else {
                bootbox.alert(data.message);
            }
        }, 'json');
    } else {
        bootbox.alert({
            title: 'Warning !!!',
            message: 'Dokumen harus dipilih semua',
            callback: function() {
                $(elm).show();
            }
        })
    }
}

function showDocument(elm){
	var _tr = $(elm).closest('tr');
	var _tbody = _tr.closest('tbody');
	var _doc = _tr.data('dokumen');
	if($(elm).hasClass('glyphicon-plus')){
		_tbody.find('tr.dokumen_'+_doc).show();
	}else{
		_tbody.find('tr.dokumen_'+_doc).hide();
	}
	$(elm).toggleClass('glyphicon-plus glyphicon-minus');
}




function checkPilihan(elm){
	/* pastikan nomer PO dan item_cat sama */
	var ini = $(elm);
	var table = ini.closest('table');
	var _ck = table.find('input:checked').not(ini);
	var _op, _ic;

	if (ini.is(':checked')) {
			if (_ck.length) {
					_op = _ck.eq(0).data('company');
					var _valid = 1,
							_pesan = [];
					if (ini.data('company') != _op) {
							_valid = 0;
							_pesan.push('Company code tidak sama');
					}

					if (!_valid) {
							ini.prop('checked', 0);
							bootbox.alert({
									title: 'Warning ....',
									message: _pesan.join(' '),
									callback: function() {}
							})
					}
			}
	}
}

function createEkspedisi(elm) {
    var id_inv = get_id_invoice();
    //var _p = [1,2,8,9];
    if (id_inv.length) {
        var url = $("#base-url").val() + 'EC_Invoice_Ekspedisi/listDokumen/';
    	$.post(url, {id : id_inv}, function(html) {
    	    bootbox.dialog({
            title: 'Daftar Dokumen',
    	    message: html,
            className: 'bb-alternate-modal',
		    callback: function() {

		    }
    	}).on('shown.bs.modal', function(e) {
				$(this).find('tr[class^=dokumen]').hide();
			});
    	}, 'html');

    } else {
        bootbox.alert('Tidak ada Invoice yang dipilih');
    }

}

function get_id_invoice(elm) {
    var invTerpilih = mytable_inv.rows().nodes().to$().find(':checkbox:checked');
    var id_inv = [];
    var index = 0;

    if (invTerpilih.length) {
        invTerpilih.each(function() {
            id_inv[index] = invTerpilih.eq(index).data('id_invoice');
            index +=1;
    	});
    }
    return id_inv;
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
                        teks += "<td class=\"text-center\">" + data[i]['STATUS_DOC'] + "</td>"
                        teks += "<td class=\"text-center\">" + data[i]['POSISI'] + "</td>"
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
    t11 = true,
    clicks = 0,
    timer = null;
var t = [t0, t1, t2, t3, t4, t5, t6, t7, t8, t9, t10, t11];

var ta0 = true,
    ta1 = true,
    ta2 = true,
    ta3 = true,
    ta4 = true,
    ta5 = true,
    ta6 = true,
    ta7 = true,
    ta8 = true,
    ta9 = true,
    ta10 = true,
    ta11 = true,
    clicksa = 0,
    timera = null;
var ta = [ta0, ta1, ta2, ta3, ta4, ta5, ta6, ta7, ta8, ta9, ta10, ta11];

var tb0 = true,
    tb1 = true,
    tb2 = true,
    tb3 = true,
    tb4 = true,
    tb5 = true,
    tb6 = true,
    tb7 = true,
    tb8 = true,
    tb9 = true,
    tb10 = true,
    tb11 = true,
    clicksb = 0,
    timerb = null;
var tb = [tb0, tb1, tb2, tb3, tb4, tb5, tb6, tb7, tb8, tb9, tb10, tb11];

$(document).ready(function() {

  loadTable_invoice();
  $(".sear").hide();


	loadTable_Request();
  $(".sear1").hide();

	loadTable_Rejected();
  $(".sear2").hide();

});


function kirimDokumen(elm){
    var id_invoice = $(elm).data('invoice');
    var status = $(elm).data('status') || '';
    var url = $("#base-url").val() + 'EC_Invoice_Ekspedisi/listDokumen';
    $.post(url, {
        id : [id_invoice]
    }, function(html) {
        bootbox.dialog({
            title: 'Daftar Dokumen',
            message: html,
            className: 'bb-alternate-modal',
            callback: function() {

            }
        });
    }, 'html');
}

function SubmitDokumen(elm) {
    /* pastikan semua checkbox sudah dipilih */
    var _table = $(elm).closest('table');
    var _tbody = _table.find('tbody');
    var _ld = _tbody.find('input:checked');
    var _totalDoc = _tbody.find('tr[class^=dokumen]').length;
    var _invoice = $(elm).data('invoice');
    // var _proses = $(elm).data('proses');

    $(elm).hide();
    if (_ld.length == _totalDoc) {
        var _url = $("#base-url").val() + 'EC_Invoice_Ekspedisi/updatePosisiDokumen';
        $.post(_url, {
            invoice: _invoice['list_id'],
          //  proses: _proses
        }, function(data) {
            if (data.status) {
                bootbox.alert(data.message, function() {
										/*cetak ekspedisi ppl */
										$.redirect(data.urlcetak,{data : data.id},'POST','_blank');
                    /* refresh datatable */
                    bootbox.hideAll();
                    loadTable_invoice();
                });
            } else {
                bootbox.alert(data.message);
            }
        }, 'json');
    } else {
        bootbox.alert({
            title: 'Warning !!!',
            message: 'Dokumen harus dipilih semua',
            callback: function() {
                $(elm).show();
            }
        })
    }
}

function showDocument(elm){
	var _tr = $(elm).closest('tr');
	var _tbody = _tr.closest('tbody');
	var _doc = _tr.data('dokumen');
	if($(elm).hasClass('glyphicon-plus')){
		_tbody.find('tr.dokumen_'+_doc).show();
	}else{
		_tbody.find('tr.dokumen_'+_doc).hide();
	}
	$(elm).toggleClass('glyphicon-plus glyphicon-minus');
}

function reverseInvoice(elm){
	var _id = $(elm).data('id_invoice');

	var _url = $('#base-url').val()+'EC_Invoice_Ekspedisi/setReverseInvoice/';
	
	bootbox.confirm('Apakah Anda Yakin Akan Mereverse Invoice?',function(a){
		if (a) {
			$.post(_url,{id_invoice:_id},function(data){
				var obj = JSON.parse(data)
				var no_mir = obj[0].INVOICE_SAP;
				var no_po = obj[0].NO_SP_PO;
				var tahun_mir = obj[0].FISCALYEAR_SAP;
				var alasan = obj[0].REJECT_NOTE;

				$.redirect($('#base-url').val()+'EC_Invoice_ver/EC_Reverse_Invoice/reverseInvoice',{mir:no_mir,tahun:tahun_mir,alasan_reject:alasan,po_number:no_po},'POST');
			});
		}
	});
	
}

function reRequestApproval(elm){
	var _url = $('#base-url').val()+'EC_Invoice_Ekspedisi/reRequestApproval/'+$(elm).data('id_invoice');
	
	bootbox.confirm('Apakah Anda Yakin akan Melakukan Re-Request Approval Invoice',function(b){
		if(b){
			$.redirect(_url);
		}
	})
}

$('.formCetak').submit(function(e){
	e.preventDefault();
	var noDoc = $('input[name=noDoc]').val();
	var thnDoc = $('input[name=tahunDoc]').val();
	var url = $('#base-url').val() + 'EC_Invoice_Ekspedisi/getIDInvoice';
	$.post(url,{no_doc:noDoc,tahun_doc:thnDoc},function(data){
		if(data.status){
			var _url = $('#base-url').val() + 'EC_Approval/Invoice/cetakLembarVerifikasi/' + data.id;
			$.redirect(_url,{},'post','_blank');
		}else{
			bootbox.alert(data.msg);
		}
	},'json');
});