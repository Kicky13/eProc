var range_harga = ['-', '-'],
    base_url = $("#base-url").val(),
    kodeParent = $("#kodeParent").val(),
    searctTag = $("#tag").val(),
    urlll = '/get_data/',
    compare = [],
    limitMin = 0,
    limitMax = 10,
    pageMax = 1,
    pageMaxOld = 0,
    compareCntrk = [];
function loadDataList() {
	$.ajax({
		url : $("#base-url").val() + 'EC_Invoice_ver' + urlll,
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
			for (var i = limitMin; i < data.data.length; i++) {

				var startdate = data.data[i][2].substring(6, 10) + '/' + data.data[i][2].substring(3, 5) + '/' + data.data[i][2].substring(0,2);
		//var enddate = data.data[i][10].substring(0, 4) + '-' + data.data[i][10].substring(4, 6) + '-' + data.data[i][10].substring(6);
				// console.log(now);
				// console.log(startdate);
				var oneDay = 24*60*60*1000; // hours*minutes*seconds*milliseconds
            	var firstDate = new Date(startdate);
            	var secondDate = new Date(now);
            	var diffDays = Math.round(Math.round((secondDate.getTime() - firstDate.getTime()) / (oneDay)));
            	//$("#x_Date_Difference").val(diffDays);

				teks = '<tr>'
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

function viewdetail(element, invoiceno, docdate){
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

	$(".btnShow").show();
	$("#InvoiceNo").val(invoiceno);
	$("#InvoiceNoApp").val(invoiceno);
	$("#DocumentDate").val(docdate);
	$("#PostingDate").val(now);
	$("#PaymentBlock").val('3');
	$.ajax({
		url : $("#base-url").val() + 'EC_Invoice_ver/get_invoiceDetail/'+invoiceno,
		data : {
			//"qty" : $("#qtyy").val(),
			//"contract_no" : contract_no,
			//"matno" : matno
		},
		type : 'POST',
		dataType : 'json'
	}).done(function(data) {
		//console.log(data);
		$("tr").removeClass("success")
		$(element).parent().addClass("success")
		$("#InvoiceDetail").empty()
		if (data.data.length == 0)
			$("#InvoiceDetail").append('<div class="row text-center">Data Tidak Ditemukan!!</div>')
		else
			for (var i = limitMin; i < data.data.length; i++) {                               
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

function offer(element, matno, dateS, dateE, select) {

	// console.log($(element).is(":checked"));
	console.log($(element).parent().parent().find(".endDate").data('provide'))
	var status = null;
	if ($(element).is(":checked")) {
		$('#'+dateS+' .startDate').datepicker('destroy');
		$('#'+dateE+' .endDate').datepicker('destroy');
		status = 'Y';
		$(element).parent().parent().find(".harga").attr('disabled', 'disabled');
		$(element).parent().parent().find(".curr").attr('disabled', 'disabled');
		$('#'+select).attr('disabled', 'disabled');
		//$(element).parent().parent().find(".startDate").attr('disabled', 'disabled');
		//$(element).parent().parent().find(".endDate").attr('disabled', 'disabled');
		// $(element).parent().parent().find(".startDate").data('provide', '')//attr('data-provide', '');
		// $(element).parent().parent().find(".endDate").data('provide', '')//attr('data-provide', '');

	} else {
		$('#'+dateS+' .startDate').datepicker('destroy');
		$('#'+dateE+' .endDate').datepicker('destroy');
		status = 'T';
		$(element).parent().parent().find(".harga").removeAttr('disabled');
		$(element).parent().parent().find(".curr").removeAttr('disabled');
		$('#'+select).removeAttr('disabled');
		$('#'+dateS+' .startDate').datepicker({
			format: "dd/mm/yyyy",
		   	autoclose: true,
		   	todayHighlight: true
		});
    	$('#'+dateE+' .endDate').datepicker({
    		format: "dd/mm/yyyy",
        	autoclose: true,
        	todayHighlight: true
    	});
		// $(element).parent().parent().find(".startDate").on('.datepicker.data-api');
		// $(element).parent().parent().find(".endDate").on('.datepicker.data-api');
		// $(element).parent().parent().find(".startDate").data('provide', 'datepicker')//attr('data-provide', 'datepicker');
		// $(element).parent().parent().find(".endDate").data('provide', 'datepicker')//attr('data-provide', 'datepicker');
	}
	$.ajax({
		url : $("#base-url").val() + 'EC_Pricelist/insertOffer/',
		data : {
			"harga" : $(element).parent().parent().find(".harga").val(),
			"curr" : $('#'+select).val(),
			"matno" : matno,
			"startdate" : $(element).parent().parent().find(".start-date").val(),
			"enddate" : $(element).parent().parent().find(".end-date").val(),
			"status" : status
		},
		type : 'POST',
		dataType : 'json'
	}).done(function(data) {
		console.log(data);
	}).fail(function(data) {
		// console.log("error");
		// $("#pocreated").text(data['RETURN'][0]['MESSAGE'])
	}).always(function(data) {
		// console.log(data)
		$("#statsPO").text(data)
	});
}

function currency(){
	var masterCurrency;
	$.ajax({
		url : $("#base-url").val() + 'EC_Pricelist/get_currency/',
		data : {
			//"qty" : $("#qtyy").val(),
			//"contract_no" : contract_no,
			//"matno" : matno
		},
		type : 'POST',
		dataType : 'json'
	}).done(function(data) {
		//console.log(data);
		//masterCurrency = data;

		var masterCurrency = '<select class="form-control">';
		for (var i = 0; i < data.length ; i++) {
			masterCurrency += ('<option>'+data[i].CURR_CODE+'</option>')
		}
		masterCurrency += ('</select>')
		console.log(masterCurrency)
		return masterCurrency;
	}).fail(function(data) {
		// console.log("error");
		// $("#pocreated").text(data['RETURN'][0]['MESSAGE'])
	}).always(function(data) {
		// console.log(data)

	});


}

function numberWithCommas(x) {
	return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
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
		"ajax" : $("#base-url").val() + 'EC_Invoice_ver/get_invoice_lanjut',

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
				a += '<a href="#">'+full.NO_SP_PO+'</a>';
				a += "</div>";
				return a;
			}
		}, {
			mRender : function(data, type, full) {
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
				a += '<a href="#">'+full.VEND_NAME+'</a>';
				a += "</div>";
				return a;
			}
		}, {
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
				a += '<a target="_blank" href="'+base_url+'upload/EC_invoice/'+full.INVOICE_PIC+'">'+full.NO_INVOICE+'</a>';
				a += "</div>";
				return a;
			}
		}, {
			mRender : function(data, type, full) {
				a = "<div class='col-md-12 text-center'>";
        if(full.FAKPJK_PIC != ''){
          a += '<a target="_blank" href="'+base_url+'upload/EC_invoice/'+full.FAKPJK_PIC+'">'+ full.FAKTUR_PJK+'</a>';
        }else{
          a += '<a href="#">'+ full.FAKTUR_PJK+'</a>';
        }

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
				a = "<div class='col-md-12 text-center'>";
				a += full.CHDATE2;
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
				if (full.STATUS_HEADER == '2') {
					a += "<a class='glyphicon glyphicon-share-alt' href='" + $("#base-url").val() + "EC_Invoice_ver/detail/" + full.ID_INVOICE +"' title='Detail Invoice'></a>&nbsp;&nbsp;"
				}
                                if (full.STATUS_HEADER == '3') {
					a += "<a class='glyphicon glyphicon-share-alt' href='" + $("#base-url").val() + "EC_Invoice_ver/detail/" + full.ID_INVOICE +"' title='Detail Invoice'></a>&nbsp;&nbsp;"
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
  
  $('a:contains("File Attachment")').click(function(){
    $(this).css({'color' : 'blue'});
  });
/*

	$('.tgll .startDate').datepicker({
		format : "dd/mm/yyyy",
		autoclose : true,
		todayHighlight : true
	});
  */
});
