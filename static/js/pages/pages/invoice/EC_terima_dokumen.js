function terimaDokumen(elm){
    var id_invoice = $(elm).data('invoice');
    var url = $("#base-url").val() + 'EC_Invoice_Management/listDokumen';
    $.get(url,{invoice : id_invoice, proses : 'terima'},function(html){
        bootbox.dialog({
            title : 'Daftar Dokumen',
            message : html,
            className: 'bb-alternate-modal',
            callback : function(){

            }
        });
    },'html');
}

function SubmitDokumen(elm){
    /* pastikan semua checkbox sudah dipilih */
    var _table = $(elm).closest('table');
    var _tbody = _table.find('tbody');
    var _ld = _tbody.find('input:checked');
    var _totalDoc = _tbody.find('tr').length - 1;
    var _invoice = $(elm).data('invoice');
    var _proses =  $(elm).data('proses');
    $(elm).closest('div').hide();
    if(_ld.length == _totalDoc){
        var _url = $("#base-url").val() +'EC_Invoice_Management/updatePosisiDokumen';
        $.post(_url,{invoice : _invoice, proses : _proses},function(data){
            if(data.status){
                bootbox.alert(data.message,function(){
                    /* refresh datatable */
                    bootbox.hideAll();
                    loadTable_invoice();
                });
            }else{
                bootbox.alert(data.message);
            }
        },'json');
    }else{
        bootbox.alert({
            title : 'Warning !!!',
            message : 'Dokumen harus dipilih semua',
            callback : function(){
                $(elm).closest('div').show();
            }
        })
    }
}

function RejectDokumen(elm){
    /* pastikan semua checkbox sudah dipilih */
    var _table = $(elm).closest('table');
    var _tbody = _table.find('tbody');
    var _ld = _tbody.find('input:checked');
    var _totalDoc = _tbody.find('tr').length;
    var _invoice = $(elm).data('invoice');
    //$(elm).closest('div').hide();
  
    
   bootbox.prompt({
        title: "Alasan Dokumen Di Reject",
        inputType: 'textarea',
        callback: function (result) {
        		//var alasan = result;
        		console.log(result);
        		if(result){var _url = $("#base-url").val() +'EC_Invoice_Management/updatePosisiDokumen';
   				$.post(_url,{invoice : _invoice, alasan_reject: result, reject : 1},function(data){
            		if(data.status){
               		 	bootbox.alert(data.message,function(){
                    		// refresh datatable 
                    		bootbox.hideAll();
                    		loadTable_invoice();
                		});
            		}else{
                		bootbox.alert(data.message);
            		}
        		},'json');
   			}
        }

    });

 		
}

function loadTable_invoice() {
	no = 1;
	$('#table_inv').DataTable().destroy();
	$('#table_inv tbody').empty();
	mytable = $('#table_inv').DataTable({
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
		"ajax" : $("#base-url").val() + 'EC_Invoice_ver/get_invoice_terima_dokumen',

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
				return '';
			}
		}, {
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += full.NO_EKSPEDISI;
				a += "</div>";
				return a;
			}
		}, {
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += full.TGL_KIRIM;
				a += "</div>";
				return a;
			}
		},{
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += '<a href="#">'+full.NO_INVOICE+'</a>';
				a += "</div>";
				return a;
			}
		},{
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += '<a href="#">'+full.NO_SP_PO+'</a>';
				a += "</div>";
				return a;
			}
		}, {
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += '<a href="#">'+full.VEND_NAME+'</a>';
				a += "</div>";
				return a;
			}
		},{
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
                                if (full.STATUS_HEADER == '3') {
					a += "<a href='#' data-invoice='"+full.ID_INVOICE+"' onclick='terimaDokumen(this)' title='Terima Dokumen'><span class='glyphicon glyphicon-check' aria-hidden='true'></span></a>&nbsp;&nbsp;"
				}
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
	/*$('.ts10').on('dblclick', function() {
	 if (t10) {
	 mytable.order([10, 'asc']).draw();
	 t10 = false;
	 } else {
	 mytable.order([10, 'desc']).draw();
	 t10 = true;
	 }
	 });*/
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

function Select(elm){
	if($(elm).is(':checked')){
		$('.item-cb').selected(true);
	}else{
		$('.item-cb').selected(false);
	}
}
