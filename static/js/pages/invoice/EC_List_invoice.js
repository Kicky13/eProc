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
				a += "<a href='javascript:void(0)' data-toggle=\"modal\" data-target=\"#Print\" title='Cetak Invoice'><span class='glyphicon glyphicon-print' aria-hidden='true'></span></a>&nbsp;&nbsp;";
				a += "<a href='javascript:void(0)' data-toggle=\"modal\" data-id_invoice='" + full.ID_INVOICE + "' data-target=\"#modalTracking\" title='History Invoice'><span class='glyphicon glyphicon-search' aria-hidden='true'></span></a>&nbsp;&nbsp;";
				a += "<input type='checkbox' data-id_invoice ='"+full.ID_INVOICE+"'>";
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
    var invTerpilih = $('#table_inv').find(':checked');
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
    clicks = 0,
    timer = null;
var t = [t0, t1, t2, t3, t4, t5, t6, t7, t8, t9];

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
