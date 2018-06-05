function numberWithCommas(x) {
    return x == null || x == "0" ? "" : x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

function loadTable_() {

    $('#table_inv').DataTable().destroy();
    $('#table_inv tbody').empty();
    mytable = $('#table_inv').DataTable({
        "bSort": true,
        "dom": 'rtpli',
        "deferRender": true,
        "colReorder": true,
        "pageLength": 25,
        "order": [],
        // "fixedHeader" : true,
        // "scrollX" : true,
        // "lengthMenu" : [5, 10, 25, 50, 75, 100],
        "language": {
            "loadingRecords": "<center><b>Please wait - Updating and Loading Data List PO...</b></center>"
        },
        "ajax": $("#base-url").val() + 'EC_Shipment/getPORelease',

        /*"columnDefs": [{
            "searchable": false,
            "orderable": true,
            "targets": 0
        }],*/
        // "order": [[ 1, 'asc' ]],
        "fnInitComplete": function () {
            $('#table_inv tbody tr').each(function () {
                $(this).find('td').attr('nowrap', 'nowrap');
                // $(this).find('td').addClass('text-center');
            });
        },
        /*"fnCreatedRow": function (row, data, index) {
            $('td', row).eq(0).html("<div class='col-md-12 text-center'>"+(index + 1)+"</div>");
        },*/
        "drawCallback": function (settings) {
            $('#table_inv tbody tr').each(function () {
                $(this).find('td').attr('nowrap', 'nowrap');
            });
        },
        "columns": [/*{
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += (full.NOMERPO);
                a += "</div>";
                return a;
            }
        }, */{
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += (full.PO_NO);
                a += "</div>";
                return a;
            }
        }, {
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.MATNO;
                a += "</div>";
                return a;
            }
        }, {
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.STOCK_COMMIT==null?'-':full.STOCK_COMMIT;
                a += "</div>";
                return a;
            }
        }, {
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.QTY_SHIPMENT==null?'-':full.QTY_SHIPMENT;
                a += "</div>";
                return a;
            }
        }, {
            mRender: function (data, type, full) {
                status = '';
                if(full.STATUS==1){
                    status = 'Waiting to Send';
                }else if(full.STATUS==2){
                    status = 'Waiting to Accept';
                }else if(full.STATUS==3){
                    status = 'Accepted';
                }
                else if(full.STATUS==4){
                    status = 'Retur';
                }
                
                if(full.STOCK_COMMIT==full.QTY_SHIPMENT){
                    status = 'Complete'
                }
                a = "<div class='col-md-12 text-center'>";
                a += status;
                a += "</div>";
                return a;
            }
        }, {
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.GR_NO==null?'-':full.GR_NO;
                a += "</div>";
                return a;
            }
        }, {
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.GR_DATE==null?'-':full.GR_DATE;
                a += "</div>";
                return a;
            }
        },{
            mRender: function (data, type, full) {
                hidden = '';
                /*if(full.STATUS!=1){
                    hidden = 'hidden';
                }*/
                if(full.STOCK_COMMIT==full.QTY_SHIPMENT){
                    hidden = 'hidden';
                }
               /* a = "<div class='col-md-12 text-center'>" +
                    '<a href="javascript:send(' + (full.KODE_SHIPMENT) + ')" '+hidden+'><span class="glyphicon glyphicon-send" aria-hidden="true"></span></a>&nbsp;&nbsp;' +                    
                    '<a href="javascript:void(0)" data-toggle="modal" data-target="#modalDetil" data-pono="' + (full.NOMERPO) + '" data-curr="' + (full.CURR) + '"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span></a>&nbsp;&nbsp;' +
                    '<a href="javascript:void(0)" data-toggle="modal" data-target="#modalHistory" data-pono="' + (full.NOMERPO) + '"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></a>' +
                    '</div>';*/
					a = "<div class='col-md-12 text-center'>" +
                    '<a href="javascript:void(0)" data-toggle="modal" data-target="#modalShipment" data-kodeshipment="'+(full.KODE_SHIPMENT)+'" data-stokcommit="'+(full.STOCK_COMMIT)+'" data-qtyshipment="'+(full.QTY_SHIPMENT)+'" '+hidden+'><span class="glyphicon glyphicon-send" aria-hidden="true"></span></a>&nbsp;&nbsp;' +                    
                    '<a href="javascript:void(0)" data-toggle="modal" data-target="#modalDetil" data-pono="' + (full.NOMERPO) + '" data-kodeshipment="' + (full.KODE_SHIPMENT) + '"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span></a>&nbsp;&nbsp;' +
                    '<a href="javascript:void(0)" data-toggle="modal" data-target="#modalHistory" data-pono="' + (full.NOMERPO) + '" data-kodeshipment="' + (full.KODE_SHIPMENT) + '"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></a>' +
                    '</div>';
                return a;
            }
        }],

    });

    mytable.columns().every(function () {
        var that = this;
        $('.srch', this.header()).on('keyup change', function () {
            if (that.search() !== this.value) {
                that.search(this.value).draw();
            }
        });
    });

    $('#table_inv').find("th").off("click.DT");
    /*$('.ts0').on('dblclick', function () {
        if (t0) {
            mytable.order([0, 'asc']).draw();
            t0 = false;
        } else {
            mytable.order([0, 'desc']).draw();
            t0 = true;
        }
    });*/
    $('.ts1').on('dblclick', function () {
        if (t1) {
            mytable.order([1, 'asc']).draw();
            t1 = false;
        } else {
            mytable.order([1, 'desc']).draw();
            t1 = true;
        }
    });
    $('.ts2').on('dblclick', function () {
        if (t2) {
            mytable.order([2, 'asc']).draw();
            t2 = false;
        } else {
            mytable.order([2, 'desc']).draw();
            t2 = true;
        }
    });
    $('.ts3').on('dblclick', function () {
        if (t3) {
            mytable.order([3, 'asc']).draw();
            t3 = false;
        } else {
            mytable.order([3, 'desc']).draw();
            t3 = true;
        }
    });
    $('.ts4').on('dbldblclick', function () {
        if (t4) {
            mytable.order([4, 'asc']).draw();
            t4 = false;
        } else {
            mytable.order([4, 'desc']).draw();
            t4 = true;
        }
    });
    $('.ts5').on('dblclick', function () {
        if (t5) {
            mytable.order([5, 'asc']).draw();
            t5 = false;
        } else {
            mytable.order([5, 'desc']).draw();
            t5 = true;
        }
    });
    $('.ts6').on('dblclick', function () {
        if (t6) {
            mytable.order([6, 'asc']).draw();
            t6 = false;
        } else {
            mytable.order([6, 'desc']).draw();
            t6 = true;
        }
    });
    $('.ts7').on('dblclick', function () {
        if (t7) {
            mytable.order([7, 'asc']).draw();
            t7 = false;
        } else {
            mytable.order([7, 'desc']).draw();
            t7 = true;
        }
    });
    /*$('.ts8').on('dblclick', function () {
        if (t8) {
            mytable.order([8, 'asc']).draw();
            t8 = false;
        } else {
            mytable.order([8, 'desc']).draw();
            t8 = true;
        }
    });
    $('.ts9').on('dblclick', function () {
        if (t9) {
            mytable.order([9, 'asc']).draw();
            t9 = false;
        } else {
            mytable.order([9, 'desc']).draw();
            t9 = true;
        }
    });*/
}

function send(kode) {
    bootbox.confirm('Konfirmasi Kirim Barang?', function (result) {
        if (result)
            window.location.href = $("#base-url").val() + 'EC_Shipment/send/' + kode
    });t
}

function reject(PO) {
    bootbox.confirm('Konfirmasi Reject PO?', function (result) {
        if (result)
            window.location.href = $("#base-url").val() + 'EC_PO_PL_Approval/reject/' + PO
    });
}

$('#modalHistory').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget)
    var pono = button.data('pono')
    var kodeshipment = button.data('kodeshipment')

    $.ajax({
        url: $("#base-url").val() + 'EC_Shipment/detail/' + kodeshipment,
        type: 'POST',
        dataType: 'json'
    }).done(function (data) {
        var teks = ""
        var status = ""
        $("#bodyTableHistory").empty()
        for (var i = 0; i < data.length; i++) {
            if(data[i]['STATUS']==1){
                status = 'BELUM DIKIRIM';
            }else if(data[i]['STATUS']==2){
                status = 'TELAH DIKIRIM';
            }
            teks += "<tr>";
            teks += "<td class=\"text-center\">" + (i + 1) + "</td>";
            //teks += "<td class=\"text-center\">" + data[i]['KODE_SHIPMENT'] + "</td>"
            //teks += "<td class=\"text-center\">" + data[i]['PO_NO'] + "</td>"
            //teks += "<td class=\"text-center\">" + data[i]['MATNO'] + "</td>"
            //teks += "<td class=\"text-center\">" + data[i]['QTY'] + "</td>"
            teks += "<td class=\"text-center\">" + data[i]['SEND_DATE'] + "</td>"
            teks += "<td class=\"text-center\">" + status + "</td>"
            teks += "<td class=\"text-center\">USER</td>"
            
            teks += "</tr>"
        }
        $("#bodyTableHistory").html(teks)
    }).fail(function () {
        // console.log("error");
    }).always(function (data) {
        // console.log(data);

    });
});

/*$('#modalHistory').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget)
    var pono = button.data('pono')

    $.ajax({
        url: $("#base-url").val() + 'EC_PO_PL_Approval/history/' + pono,
        type: 'POST',
        dataType: 'json'
    }).done(function (data) {
        var teks = ""
        $("#bodyTableHistory").empty()

        teks += "<tr>";
        teks += "<td class=\"text-center\">1</td>";
        teks += "<td class=\"text-center\">" + data[0]['TANGGAL'] + "</td>"
        teks += "<td class=\"text-center\">PO requested</td>"
        teks += "<td class=\"text-center\">" + data[0]['NAMA_USER'] + "</td>"
        teks += "</tr>"
        for (var i = 1; i < data.length; i++) {
            teks += "<tr>";
            teks += "<td class=\"text-center\">" + (i + 1) + "</td>";
            teks += "<td class=\"text-center\">" + data[i]['TANGGAL'] + "</td>"
            teks += "<td class=\"text-center\">Approved</td>"
            teks += "<td class=\"text-center\">" + data[i]['NAMA_USER'] + "</td>"
            teks += "</tr>"
        }
        $("#bodyTableHistory").html(teks)
    }).fail(function () {
        // console.log("error");
    }).always(function (data) {
        // console.log(data);

    });
});*/

var infoStok = [];

$('#modalShipment').on('hidden.bs.modal', function(e) { 
    infoStok = [];
  console.log(infoStok);
  //return this.render(); //DOM destroyer
  //datepicker.clear();
  $('#viewtglShipment').val('')
  
});


$('#modalShipment').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget)
    //array.push({Group: group});
	infoStok.push(button.data('stokcommit'));
    infoStok.push(button.data('qtyshipment'));
    infoStok.push(button.data('kodeshipment'));

   /* $("#viewcc").val(button.data('cc')).trigger("change");
    $("#viewvalueFrom").val(button.data('valuefrom'))
    $("#viewvalueTo").val(button.data('valueto'))
    $("#viewusername").val(button.data('userid')+':'+button.data('username')).trigger("change");
    $("#viewcnf").val(button.data('cnf'))

    $("#costCenter").val(button.data('cc'))
    $("#setCnf").val(button.data('cnf')) */
	 $("#viewQtyShipment").val('');
	//$("#viewQtyShipment").val('');
 $("#viewStockCommit").val(button.data('stokcommit'))	
 $("#viewQtyShipmenttotal").val(button.data('qtyshipment'))	
 $("#kodeShipment").val(button.data('kodeshipment'))
	/*if (button.data('stokcommit') != null && button.data('qtyshipment') != null && button.data('kodeshipment') != null) {
            $("#viewStockCommit").val(button.data('stokcommit'))    
             $("#viewQtyShipmenttotal").val(button.data('qtyshipment')) 
             $("#kodeShipment").val(button.data('kodeshipment'))
        }*/

});

$('#modalDetil').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget)
    var pono = button.data('pono')
    var kodeshipment = button.data('kodeshipment')

    $.ajax({
        url: $("#base-url").val() + 'EC_Shipment/detail/' + kodeshipment,
        type: 'POST',
        dataType: 'json'
    }).done(function (data) {
        var teks = ""
        $("#bodyTableDetail").empty()
        for (var i = 0; i < data.length; i++) {
            teks += "<tr>";
            teks += "<td class=\"text-center\">" + (i + 1) + "</td>";
            teks += "<td class=\"text-center\">" + data[i]['KODE_SHIPMENT'] + "</td>"
            teks += "<td class=\"text-center\">" + data[i]['PO_NO'] + "</td>"
            teks += "<td class=\"text-center\">" + data[i]['MATNO'] + "</td>"
            teks += "<td class=\"text-center\">" + data[i]['QTY'] + "</td>"
            teks += "<td class=\"text-center\">" + data[i]['SEND_DATE'] + "</td>"
            teks += "<td class=\"text-center\">" + data[i]['STATUS'] + "</td>"
            teks += "<td class=\"text-center\">" + data[i]['QTY'] +"</td>"
            
            teks += "</tr>"
        }
        $("#bodyTableDetail").html(teks)
    }).fail(function () {
        // console.log("error");
    }).always(function (data) {
        // console.log(data);

    });
});


function simpan_shipment() {
			/*var stock_commit = $('#viewStockCommit').val();
			var qty_shipment_total = $('#viewQtyShipmenttotal').val();
			var qty_shipment = $('#viewQtyShipment').val();*/
            var stock_commit = infoStok[0];
            var qty_shipment_total = infoStok[1];
            var qty_shipment = $('#viewQtyShipment').val();
            // console.log('stock_commit:'+stock_commit);
            // console.log('qty_shipment_total:'+qty_shipment_total);
            // console.log('qty_shipment:'+qty_shipment);
            // console.log(infoStok);
            // console.log((parseInt(qty_shipment)+parseInt(qty_shipment_total)));
            if((parseInt(qty_shipment)+parseInt(qty_shipment_total))>stock_commit){
                alert('Stok melebihi');
            }else{
                $.ajax({
                url: $("#base-url").val() + 'EC_Shipment/simpan_shipment/',
                data: {
                    "qtyShipment": $('#viewQtyShipment').val(),
                    "tglShipment": $('#viewtglShipment').val(),
                    "kodeShipment": infoStok[2]
                },
                type: 'POST',
                dataType: 'json'
                }).done(function (data) { 
                    //
                   // alert(data.responseText);
                    //$('#modalShipment').modal('hide');
                    //location.reload(true);
                    
                }).fail(function (data) {
                   // alert(data.responseText);
                    // console.log("error");
                    // $("#pocreated").text(data['RETURN'][0]['MESSAGE'])
                }).always(function (data) {
                   // if(data.responseText=='Success'){
                        location.reload();
                  //  }                
                    // console.log(data)
                    //$("#statsPO").text(data)
                });
            }

			/*if ((parseInt(qty_shipment_total) + parseInt(qty_shipment))<= parseInt(stock_commit))
			{
				
			    $.ajax({
                url: $("#base-url").val() + 'EC_Shipment/simpan_shipment/',
                data: {
                    "qtyShipment": $('#viewQtyShipment').val(),
                    "tglShipment": $('#viewtglShipment').val(),
					"kodeShipment": $('#kodeShipment').val()
                },
                type: 'POST',
                dataType: 'json'
            }).done(function (data) { 
                //
               // alert(data.responseText);
				$('#modalShipment').modal('hide');
				//location.reload(true);
                
            }).fail(function (data) {
               // alert(data.responseText);
                // console.log("error");
                // $("#pocreated").text(data['RETURN'][0]['MESSAGE'])
            }).always(function (data) {
               // if(data.responseText=='Success'){
                    location.reload(true);
              //  }                
                // console.log(data)
                //$("#statsPO").text(data)
            });
		}
		else
		{
			alert('Stock Melebihi');
		}*/
    // }

}


function addDays(days) {
    var d = new Date(Date.now() + days * 24 * 60 * 60 * 1000);
    month = '' + (d.getMonth() + 1)
    day = '' + d.getDate()
    year = d.getFullYear()

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

    return [day, month, year].join('/');
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

$(document).ready(function () {

    loadTable_();
    $(".sear").hide();
    for (var i = 0; i < t.length; i++) {
        $(".ts" + i).on("click", function (e) {
            clicks++;
            if (clicks === 1) {
                timer = setTimeout(function () {
                    $(".sear").toggle();
                    clicks = 0;
                }, 300);
            } else {
                clearTimeout(timer);
                $(".sear").hide();
                clicks = 0;
            }
        }).on("dblclick", function (e) {
            e.preventDefault();
        });
    }
    ;
	var d = new Date();

	var currDate = d.getDate();
	var currMonth = d.getMonth();
	var currYear = d.getFullYear();

	var dateStr = currDate + "-" + currMonth + "-" + currYear;

	$('.date').datepicker({
		format: 'dd-mm-yyyy',
		defaultDate: new Date(),
        autoclose: true,
        todayHighlight: true
    });
	

});


