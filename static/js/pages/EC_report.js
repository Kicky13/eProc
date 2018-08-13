function numberWithCommas(x) {
    return x == null || x == "0" ? "0" : x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

function loadTable_App() {

    $('#table_report').DataTable().destroy();
    $('#table_report tbody').empty();
    mytable = $('#table_report').DataTable({
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
        "ajax": $("#base-url").val() + 'EC_Report_PL/getPOReport',

        /*"columnDefs": [{
            "searchable": false,
            "orderable": true,
            "targets": 0
        }],*/
        // "order": [[ 1, 'asc' ]],
        "fnInitComplete": function () {
            $('#table_report tbody tr').each(function () {
                $(this).find('td').attr('nowrap', 'nowrap');
                // $(this).find('td').addClass('text-center');
            });
        },
        /*"fnCreatedRow": function (row, data, index) {
            $('td', row).eq(0).html("<div class='col-md-12 text-center'>"+(index + 1)+"</div>");
        },*/
        "drawCallback": function (settings) {
            $('#table_report tbody tr').each(function () {
                $(this).find('td').attr('nowrap', 'nowrap');
            });
        },
        "columns": [{
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += (full.VENDOR_NAME);
                a += "</div>";
                return a;
            }
        }, {
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += (full.PO_NO);
                a += "</div>";
                return a;
            }
        }, {
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.MEINS;
                a += "</div>";
                return a;
            }
        },{
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += numberWithCommas(full.VALUE_ITEM);
                a += "</div>";
                return a;
            }
        }, {
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.CURRENCY;
                a += "</div>";
                return a;
            }
        }, {
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.PLANT+" - "+full.PLANT_NAME;
                a += "</div>";
                return a;
            }
        },{
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.DOC_DATE;
                a += "</div>";
                return a;
            }
        }, {
            mRender: function (data, type, full) {
                status = '';                
                if(full.STATUS==1){
                    status = 'Commited';
                }else if(full.STATUS==2){
                    status = 'Approved'; 
                }else if(full.STATUS==3){
                    status = 'Processed'; 
                }else if(full.STATUS==4){
                    status = 'Closed'; 
                }
                a = "<div class='col-md-12 text-center'>";
                a += status;
                a += "</div>";
                return a;
            }
        },{
            mRender: function (data, type, full) {                
                a = "<div class='col-md-12 text-center'>";
                a += '<a href="javascript:void(0)" data-toggle="modal" data-target="#modalHistory2" data-pono="' + (full.PO_NO) + '"><span title="Tracking" class="glyphicon glyphicon-search" aria-hidden="true"></span></a> ';
                a += '<a href="javascript:void(0)" data-toggle="modal" data-target="#modalDetailPo" data-pono="' + full.PO_NO + '"><span title="Detail" class="glyphicon glyphicon-th-list" aria-hidden="true"></span></a>';
                a += "</div>";
                return a;
            }
        }],

    });

    mytable.columns().every(function () {
        var that = this;
        $('.srch3', this.header()).on('keyup change', function () {
            if (that.search() !== this.value) {
                that.search(this.value).draw();
            }
        });
    });

    $('#table_report').find("th").off("click.DT");
    $('.ts0').on('dblclick', function () {
        if (t0) {
            mytable.order([0, 'asc']).draw();
            t0 = false;
        } else {
            mytable.order([0, 'desc']).draw();
            t0 = true;
        }
    });
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
    $('.ts4').on('dblclick', function () {
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
    $('.ts8').on('dblclick', function () {
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
    });
    $('.ts10').on('dblclick', function () {
        if (t10) {
            mytable.order([10, 'asc']).draw();
            t10 = false;
        } else {
            mytable.order([10, 'desc']).draw();
            t10 = true;
        }
    });
    $('.ts11').on('dblclick', function () {
        if (t11) {
            mytable.order([11, 'asc']).draw();
            t11 = false;
        } else {
            mytable.order([11, 'desc']).draw();
            t11 = true;
        }
    });
    $('.ts12').on('dblclick', function () {
        if (t12) {
            mytable.order([12, 'asc']).draw();
            t12 = false;
        } else {
            mytable.order([12, 'desc']).draw();
            t12 = true;
        }
    });
    $('.ts13').on('dblclick', function () {
        if (t13) {
            mytable.order([13, 'asc']).draw();
            t13 = false;
        } else {
            mytable.order([13, 'desc']).draw();
            t13 = true;
        }
    });
    $('.ts14').on('dblclick', function () {
        if (t14) {
            mytable.order([14, 'asc']).draw();
            t14 = false;
        } else {
            mytable.order([14, 'desc']).draw();
            t14 = true;
        }
    });
    $('.ts15').on('dblclick', function () {
        if (t15) {
            mytable.order([15, 'asc']).draw();
            t15 = false;
        } else {
            mytable.order([15, 'desc']).draw();
            t15 = true;
        }
    });
}
$('#modalHarga').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget)
    var po = button.data('po')
    var matno = button.data('matno')
    var desc = button.data('desc')
    var ven = button.data('ven')
    var modal = $(this)
    modal.find('.matno-harga').text(matno)
    modal.find('.desc-harga').text(desc)

    $.ajax({ 
        url: $("#base-url").val() + 'EC_PO_PL_Approval/historyHarga/',
        type: 'POST',
        data: {
            "po": po,
            "matno": matno
        },
        dataType: 'json'
    }).done(function (data) {
        var teks = ""        
        $("#bodyTableHarga").empty()
        for (var i = 0; i < data.length; i++) {
            teks += "<tr>";
            if(ven==data[i]['VENDOR_NO']){
                teks += "<td class=\"text-center\"><strong>" + (i + 1) + "</strong></td>";
                teks += "<td class=\"text-center\"><strong>" + data[i]['VENDOR_NO'] + "</strong></td>"
                teks += "<td class=\"text-center\"><strong>" + data[i]['VENDOR_NAME'] + "</strong></td>"
                teks += "<td class=\"text-center\"><strong>" + data[i]['STOK'] + "</strong></td>"
                teks += "<td class=\"text-center\"><strong>" + data[i]['HARGA'] + "</strong></td>"
                teks += "<td class=\"text-center\"><strong>" + data[i]['SATUAN'] + "</strong></td>"
                teks += "<td class=\"text-center\"><strong>" + data[i]['DELIVERY'] + "</strong></td>"            
                teks += "</tr>"
            }else{
                teks += "<td class=\"text-center\">" + (i + 1) + "</td>";
                teks += "<td class=\"text-center\">" + data[i]['VENDOR_NO'] + "</td>"
                teks += "<td class=\"text-center\">" + data[i]['VENDOR_NAME'] + "</td>"
                teks += "<td class=\"text-center\">" + data[i]['STOK'] + "</td>"
                teks += "<td class=\"text-center\">" + data[i]['HARGA'] + "</td>"
                teks += "<td class=\"text-center\">" + data[i]['SATUAN'] + "</td>"
                teks += "<td class=\"text-center\">" + data[i]['DELIVERY'] + "</td>"            
                teks += "</tr>"
            }
        }
        $("#bodyTableHarga").html(teks)
    }).fail(function () {
        // console.log("error");
    }).always(function (data) {
        // console.log(data);

    });
});
function send(kode) {
    bootbox.confirm('Konfirmasi Kirim Barang?', function (result) {
        if (result)
            window.location.href = $("#base-url").val() + 'EC_Shipment/send/' + kode
    });
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

$('#modalHistory2').on('show.bs.modal', function (event) {
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
var dataStok = [];

$('#modalShipment').on('hidden.bs.modal', function(e) { 
    infoStok = [];
    dataStok = [];
  console.log(infoStok);
  //return this.render(); //DOM destroyer
  //datepicker.clear();
  $('#viewtglShipment').val('')
  
});


$('#modalShipment').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget)
    //array.push({Group: group});
	infoStok.push(button.data('stokcommit'));
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
 //$("#viewQtyShipmenttotal").val(button.data('qtyshipment'))	
 $("#kodeShipment").val(button.data('kodeshipment'))
	/*if (button.data('stokcommit') != null && button.data('qtyshipment') != null && button.data('kodeshipment') != null) {
            $("#viewStockCommit").val(button.data('stokcommit'))    
             $("#viewQtyShipmenttotal").val(button.data('qtyshipment')) 
             $("#kodeShipment").val(button.data('kodeshipment'))
        }*/

});

$('#modalDetil').on('hidden.bs.modal', function (event) {
    itemship = []
    console.log(itemship);
    //console.log(teksin);
});

$('#modalDetil').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget)
    var pono = button.data('pono')
    // var kodeshipment = button.data('kodeshipment')

    $.ajax({
        url: $("#base-url").val() + 'EC_Shipment/detailHistory/' + pono,
        type: 'POST',
        dataType: 'json'
    }).done(function (data) {
        console.log(data.length);
        var teks = ""
        var status = ''
        if(data.length>0){
            $("#bodyTableDetail").empty()
            for (var i = 0; i < data.length; i++) {
                if(data[i]['STATUS']==1){
                    status = 'Send'
                }else if(data[i]['STATUS']==2){
                    status = 'Accept'
                }else if(data[i]['STATUS']==3){
                    status = 'Reject'
                } 
                teks += "<tr>"
                teks += "<td class=\"text-center\">" + data[i]['NO_SHIPMENT'] + "</td>"
                teks += "<td class=\"text-center\">" + data[i]['PO_NO'] + "</td>"
                teks += "<td class=\"text-center\">" + data[i]['LINE_ITEM'] + "</td>"
                teks += "<td class=\"text-center\">" + data[i]['MAKTX'] + "</td>"
                teks += "<td class=\"text-center\">" + data[i]['STOK_COMMIT'] + "</td>"
                teks += "<td class=\"text-center\">" + data[i]['QTY'] + "</td>"
                teks += "<td class=\"text-center\">" + data[i]['PLANT'] +"-"+ data[i]['PLANT_NAME'] + "</td>"
                teks += "<td class=\"text-center\">" + (data[i]['GR_NO']==null?'-':data[i]['GR_NO']) +"</td>"
                teks += "<td class=\"text-center\">" + (data[i]['IN_DATE_GR']==null?'-':data[i]['IN_DATE_GR']) +"</td>"
                teks += "<td class=\"text-center\">" + data[i]['DATE_SEND'] +"</td>"
                teks += "<td class=\"text-center\">" + status +"</td>"
                teks += "<td class=\"text-center\"><input type='checkbox' data-kodeshipment=" + data[i]['KODE_DETAIL_SHIPMENT'] + " class='itemship'></td>"
                
                teks += "</tr>"
            }
            $("#bodyTableDetail").html(teks)
        }else{
            $("#bodyTableDetail").empty()
            teks += "<div class='row text-center'>"
            teks += "No data history . . ."
            teks += "</div>"
            $("#bodyTableDetail").html(teks)
        }
        
    }).fail(function () {
        // console.log("error");
    }).always(function (data) {
        // console.log(data);

    });
});

$('#modalDetailPo').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var pono = button.data('pono');    
    //var kodeshipment = button.data('kodeshipment')
    console.log("tes "+ pono);
    $.ajax({
        url: $("#base-url").val() + 'EC_Report_PL/getPODetail/' + pono,
        type: 'POST',
        dataType: 'json'
    }).done(function (data) {
        console.log(data);
        var teks = "";
        $("#tableDetailPO").empty()
        for (var i = 0; i < data.length; i++) {
            console.log("masuk");
            teks += "<tr>";
            //teks += "<td class=\"text-center\">" + (i + 1) + "</td>";
            teks += "<td class=\"text-center\">" + data[i]['LINE_ITEM'] + "</td>";
            teks += "<td class=\"text-center\">" + data[i]['MAKTX'] + "</td>";
            teks += "<td class=\"text-center\">" + data[i]['QTY_ORDER'] + "</td>";
            teks += "<td class=\"text-center\">" + data[i]['MEINS'] + "</td>";
            teks += "<td class=\"text-center\">" + numberWithCommas(data[i]['PRICE']) + "</td>";
            teks += "<td class=\"text-center\">" + data[i]['CURRENCY'] + "</td>";
            teks += "<td class=\"text-center\">" + numberWithCommas(data[i]['VALUE_ITEM']) + "</td>";
            teks += "<td class=\"text-center\">" + data[i]['PLANT'] +" - "+ data[i]['PLANT_NAME'] +"</td>";
            teks += "<td class=\"text-center\" style=\"color: red;\"><strong>" + data[i]['EXPIRED_DATE'] + "</strong></td>";
            teks += "<td class=\"text-center\"><a href=\"javascript:void(0)\" data-toggle=\"modal\" data-target=\"#modalHarga\" data-po="+ pono +" data-matno="+data[i]['MATNO']+" data-desc=\""+data[i]['MAKTX']+"\" data-ven="+data[i]['VENDORNO']+"><span title=\"Detail Harga Penawaran Vendor\" class=\"glyphicon glyphicon-list-alt\" aria-hidden=\"true\"></span></a></td>"            
            teks += "</tr>";
        }
        $("#tableDetailPO").html(teks)
    }).fail(function () {
        console.log("error");
    }).always(function (data) {
        console.log(data);
    });
});

$('#shipment').on('show.bs.modal', function (event) {

    

    var button = $(event.relatedTarget)
    var teks = ''
    
    //var pono = button.data('pono')
    //var kodeshipment = button.data('kodeshipment')
    
    $("#reviewShipment").empty()
    for (var po = 0; po < items.length; po++) {
        teks += '<div class="row">'
        teks += '<div class="col-md-3">'
        teks += 'Nomor PO: '+items[po]+''
        teks += '</div>'
        teks += '<div class="col-md-9">'
        teks += '<button type="button" id="" class="btn btn-success btn-xs pull-right" onclick="showItems('+po+','+items[po]+')">Show List Items</button>'
        teks += '</div>'
        teks += '</div>'
        teks += '<div class="row">'
                teks += '<div class="col-md-12">'
                teks += '<table id="tablebody'+po+'" class="table table-striped nowrap" width="100%">'
                teks += '<thead>'
                teks += '<tr>'+
                            '<th class="text-center">Line Item</th>'+
                            '<th class="text-center">Deskripsi</th>'+
                            '<th class="text-center">QTY</th>'+
                            '<th class="text-center">UoM</th>'+
                            '<th class="text-center">Price</th>'+
                            '<th class="text-center">Currency</th>'+
                            '<th class="text-center">Value</th>'+
                            '<th class="text-center">Ship To</th>'+
                            '<th class="text-center">Expired Date</th>'+                            
                            '<th class="text-center">QTY Shipment</th>'+
                            '<th class="text-center"></th>'+
                        '</tr>'
                teks += '</thead>'
                teks += '<tbody id="body'+po+'">'
                teks += '</tbody>'
                teks += '</table>'
                teks += '</div></div>'
                teks += '<br><hr>'
        $("#reviewShipment").html(teks)  
    }
    //showDetail();  
});

var dt = 0;
function showDetail() {
    for (var po = 0; po < items.length; po++) {
        var teksin = '';
        $.ajax({
            url: $("#base-url").val() + 'EC_Shipment/getPODetail/' + items[po],
            type: 'POST',
            dataType: 'json'
        }).done(function (data) {
                for (var a = 0; a < data.length; a++) {
                    //console.log("masuk");
                    teksin += "<tr>";
                    //teks += "<td class=\"text-center\">" + (i + 1) + "</td>";
                    teksin += "<td class=\"text-center\">" + data[a]['LINE_ITEM'] + "</td>";
                    teksin += "<td class=\"text-center\">" + data[a]['MAKTX'] + "</td>";
                    teksin += "<td class=\"text-center\">" + data[a]['QTY'] + "</td>";
                    teksin += "<td class=\"text-center\">" + data[a]['MEINS'] + "</td>";
                    teksin += "<td class=\"text-center\">" + numberWithCommas(data[a]['PRICE']) + "</td>";
                    teksin += "<td class=\"text-center\">" + data[a]['CURRENCY'] + "</td>";
                    teksin += "<td class=\"text-center\">" + numberWithCommas(data[a]['TOTAL']) + "</td>";
                    teksin += "<td class=\"text-center\">" + data[a]['PLANT'] +" - "+ data[a]['DESC'] +"</td>";
                    teksin += "<td class=\"text-center\" style=\"color: red;\"><strong>" + data[a]['EXPIRED_DATE'] + "</strong></td>";                    
                    teksin += "<td class=\"text-center\"><input style=\"width: 50px;\" type=\"text\" placeholder=\"Qty\" id=\""+po+"_"+data[a]['LINE_ITEM']+"\"></td>";
                    teksin += "<td class=\"text-center\"><input type='checkbox' data-kodeship=" + data[a]['KODE_SHIPMENT'] + " data-kode=" + data[a]['ID_CHART'] + " data-po=" + po + " data-lineitem=" + data[a]['LINE_ITEM'] + " class='itemspo' onclick='enableQTY(this,"+po+","+data[a]['LINE_ITEM']+","+data[a]['QTY']+")'>"
                    teksin += "</tr>";
                }                
                $('#body'+dt).html(teksin);
                teksin = '';  
                dt++;              
        }).fail(function () {
            // console.log("error");
        }).always(function (data) {
           // console.log("error");
        });
    }
}

$('#shipment').on('hidden.bs.modal', function (event) {
    items = []
    itemShipment = []
    teksin = '';
    dt = 0;
    //console.log(items);
    //console.log(teksin);
});

function showItems(id, po) {
    var teksin = '';
    $.ajax({
            url: $("#base-url").val() + 'EC_Shipment/getPODetail/' + po,
            type: 'POST',
            dataType: 'json'
        }).done(function (data) {
                for (var a = 0; a < data.length; a++) {
                    //console.log("masuk");
                    teksin += "<tr>";
                    //teks += "<td class=\"text-center\">" + (i + 1) + "</td>";
                    teksin += "<td class=\"text-center\">" + data[a]['LINE_ITEM'] + "</td>";
                    teksin += "<td class=\"text-center\">" + data[a]['MAKTX'] + "</td>";
                    teksin += "<td class=\"text-center\">" + data[a]['QTY'] + "</td>";
                    teksin += "<td class=\"text-center\">" + data[a]['MEINS'] + "</td>";
                    teksin += "<td class=\"text-center\">" + numberWithCommas(data[a]['PRICE']) + "</td>";
                    teksin += "<td class=\"text-center\">" + data[a]['CURRENCY'] + "</td>";
                    teksin += "<td class=\"text-center\">" + numberWithCommas(data[a]['TOTAL']) + "</td>";
                    teksin += "<td class=\"text-center\">" + data[a]['PLANT'] +" - "+ data[a]['DESC'] +"</td>";
                    teksin += "<td class=\"text-center\" style=\"color: red;\"><strong>" + data[a]['EXPIRED_DATE'] + "</strong></td>";                    
                    teksin += "<td class=\"text-center\"><input style=\"width: 50px;\" type=\"text\" placeholder=\"Qty\" id=\""+po+"_"+data[a]['LINE_ITEM']+"\"></td>";
                    teksin += "<td class=\"text-center\"><input type='checkbox' data-kodeship=" + data[a]['KODE_SHIPMENT'] + " data-kode=" + data[a]['ID_CHART'] + " data-po=" + po + " data-lineitem=" + data[a]['LINE_ITEM'] + " class='itemspo' onclick='enableQTY(this,"+po+","+data[a]['LINE_ITEM']+","+data[a]['QTY']+")'>"
                    teksin += "</tr>";
                }                
                $('#body'+id).html(teksin);
                teksin = '';                
        }).fail(function () {
            // console.log("error");
        }).always(function (data) {
           // console.log("error");
        });
}

function enableQTY(elm, po, lineItem, qty) { 
    var qtyInput = $("#"+po+"_"+lineItem).val();
    if ($(elm).is(':checked')) {
        if(qtyInput>qty){   
            alert("Qty yg dimasukkan melebihi Qty Order");
            $(elm).prop('checked', false);
        }else if(qtyInput==''){
            alert("Qty yg dimasukkan minimal 1");
            $(elm).prop('checked', false);
        }else{
            itemShipment = []
            $("#"+po+"_"+lineItem).prop('disabled', true);    
        } 
    }else{
        itemShipment = []
        $("#"+po+"_"+lineItem).prop('disabled', false);
    }
}

function simpan_shipment() {
    $.ajax({
        url: $("#base-url").val() + 'EC_Shipment/cekQty/' + infoStok[1],
        data: {
                   
        },
        type: 'POST',
        dataType: 'json'
    }).done(function (data) { 
                    
    }).fail(function (data) {
                   
    }).always(function (data) {
        dataStok.push(infoStok[0]);
        dataStok.push(data[0]['TOTAL']);
        dataStok.push(infoStok[1]);
        console.log(dataStok);
                                
        var stock_commit = dataStok[0];
        var qty_shipment_total = dataStok[1];
        var qty_shipment = $('#viewQtyShipment').val();
        console.log('stock_commit:'+stock_commit);
        console.log('qty_shipment_total:'+qty_shipment_total);
        console.log('qty_shipment:'+qty_shipment);

            if((parseInt(qty_shipment)+parseInt(qty_shipment_total))>stock_commit){
                alert('Stok melebihi');
            }else{
                $.ajax({
                url: $("#base-url").val() + 'EC_Shipment/simpan_shipment/',
                data: {
                    "qtyShipment": $('#viewQtyShipment').val(),
                    "tglShipment": $('#viewtglShipment').val(),
                    "kodeShipment": dataStok[2]
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
                
    });

			/*var stock_commit = $('#viewStockCommit').val();
			var qty_shipment_total = $('#viewQtyShipmenttotal').val();
			var qty_shipment = $('#viewQtyShipment').val();*/
            //console.log(infoStok);
            
            
            // console.log((parseInt(qty_shipment)+parseInt(qty_shipment_total)));
            

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
    t10 = true,
    t11 = true,
    t12 = true,
    t13 = true,
    t14 = true,
    t15 = true,
    clicks = 0,
    timer = null;
var tt1 = [t1, t2, t3, t4, t5, t6, t7, t8, t9, t10];
var tt2 = [t1, t2, t3, t4, t5, t6, t7, t8, t9, t10];
var tt3 = [t0, t1, t2, t3, t4, t5, t6, t7, t8, t9, t10, t11, t12, t13, t14];
var items = []
var itemShipment = []
var itemship = []
$(document).ready(function () {

    //loadTable_();
    loadTable_App();
    //loadTable_Intransit();
    $(".sear1").hide();
    for (var i = 0; i < tt3.length; i++) {
        $(".ts" + i).on("click", function (e) {
            clicks++;
            if (clicks === 1) {
                timer = setTimeout(function () {
                    $(".sear1").toggle();
                    clicks = 0;
                }, 300);
            } else {
                clearTimeout(timer);
                $(".sear1").hide();
                clicks = 0;
            }
        }).on("dblclick", function (e) {
            e.preventDefault();
        });
    }
    
	var d = new Date();

	var currDate = d.getDate();
	var currMonth = d.getMonth();
	var currYear = d.getFullYear();

	var dateStr = currDate + "-" + currMonth + "-" + currYear;

    // $(".date").datepicker().on('show.bs.modal', function(event) {
    // // prevent datepicker from firing bootstrap modal "show.bs.modal"
    //     event.stopPropagation(); 
    // });

	$('.date').datepicker({
        format: 'dd-mm-yyyy',
        defaultDate: new Date(),
        autoclose: true,
        todayHighlight: true
    }).on('change', function(){
        $('.datepicker').hide();
    }).on('show.bs.modal', function(event) {
    // prevent datepicker from firing bootstrap modal "show.bs.modal"
        event.stopPropagation(); 
    });

    // $('.date').datepicker({
    //     format: "dd-mm-yyyy"
    //     }).on('change', function(){
    //     $('.datepicker').hide();
    // });

    $('#setShipment').click(function () {
        //items = []
        
        $(".items").each(function () {
            if ($(this).is(":checked"))
                if (items.indexOf($(this).data("kodeshipment")) == -1)
                    items.push(String($(this).data("kodeshipment")));
        });
        // dataitems = JSON.stringify(items)
        // console.log(dataitems)
        
        console.log(items);
        //accept(items)
    })
	
    $('#saveShipment').click(function () {
        //items = []
        
        $(".itemspo").each(function () {
            if ($(this).is(":checked"))
                // if (itemShipment.indexOf($(this).data("po")) == -1)
                    itemShipment.push(String($(this).data("po"))+"_"+String($(this).data("lineitem"))+"_"+String($(this).data("kode"))+"_"+$("#"+String($(this).data("po"))+"_"+String($(this).data("lineitem"))).val()+"_"+String($(this).data("kodeship")));
        });
        dataitems = JSON.stringify(itemShipment)
        console.log(dataitems)
        
        console.log(itemShipment);
        save(dataitems, $('#shipmentCode').val(), $('#tglShipment').val());
    })

    $('#deleteShipment').click(function () {
        itemship = []
        
        $(".itemship").each(function () {
            if ($(this).is(":checked"))
                if (itemship.indexOf($(this).data("kodeshipment")) == -1)
                    itemship.push(String($(this).data("kodeshipment")));
        });
        dataitems = JSON.stringify(itemship)
        console.log(dataitems)
        
        // console.log(itemship);
        deleteShipment(dataitems)
    })
});

function save(data, no_shipment, tglShipment) {
    $.ajax({
            url: $("#base-url").val() + 'EC_Shipment/save',
            type: 'POST',
            dataType: 'json',
            data: {
                dataall: data,
                nomor: no_shipment,
                tanggal: tglShipment
            },
        }).done(function (data) {

            window.location.href = $("#base-url").val() + 'EC_Shipment/index/' + data.sukses +'/'+data.nomor
            // $('#shipment').modal('hide');
            // console.log(data.sukses)
            // console.log(data.nomor)
        }).always(function (data) {
            // alert('Data telah disimpan');
            // location.reload(true);
            // $('#enddate').val('');

        });
}

function deleteShipment(data) {
    bootbox.confirm('Anda yakin ingin menghapus Shipment?', function (result) {
        if (result){
            $.ajax({
                url: $("#base-url").val() + 'EC_Shipment/deleteShipment',
                type: 'POST',
                dataType: 'json',
                data: {
                    dataship: data
                },
            }).done(function (data) {
                // console.log(data.vnd)
            }).always(function (data) {
                // alert('Data telah disimpan');
                location.reload(true);
                // $('#enddate').val('');

            });
        }
    });

    
}
