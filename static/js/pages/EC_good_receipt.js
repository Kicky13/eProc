function numberWithCommas(x) {
    return x == null || x == "0" ? "0" : x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}
var qtyOutstanding = 0;
function loadTable_Unprocessed() {

    $('#table_Unprocessed').DataTable().destroy();
    $('#table_Unprocessed tbody').empty();
    var shipment = 0;
    mytableUnprocessed = $('#table_Unprocessed').DataTable({
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
        "ajax": $("#base-url").val() + 'EC_Good_Receipt_PL/getPOShipment',

        /*"columnDefs": [{
            "searchable": false,
            "orderable": true,
            "targets": 0
        }],*/
        // "order": [[ 1, 'asc' ]],
        "fnInitComplete": function () {
            $('#table_Unprocessed tbody tr').each(function () {
                $(this).find('td').attr('nowrap', 'nowrap');
                // $(this).find('td').addClass('text-center');
            });
        },
        /*"fnCreatedRow": function (row, data, index) {
            $('td', row).eq(0).html("<div class='col-md-12 text-center'>"+(index + 1)+"</div>");
        },*/
        "drawCallback": function (settings) {
            $('#table_Unprocessed tbody tr').each(function () {
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
                a += full.VENDOR_NAME;
                a += "</div>";
                return a;
            }
        }, {
            mRender: function (data, type, full) {
                if (full.ROWSPAN == "YES"){
                    a = "<div class='col-md-12 text-center'>";
                    a += full.NO_SHIPMENT;
                    a += "</div>";
                } else {
                    a = "";
                }
                return a;
            }
        },{
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.PO_NO;
                a += "</div>";
                return a;
            }
        }, {
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.LINE_ITEM;
                a += "</div>";
                return a;
            }
        },{
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += "<strong><a href='javascript:void(0)' data-backdrop='true' data-toggle='modal' data-target='#modaldetail' data-produk='"+full.MATNO+"'>"+full.MAKTX+"</a></strong>";
                a += "</div>";
                return a;
            }
        },{
            mRender: function (data, type, full) {
                qtyOutstanding = parseInt(full.QTY)-(parseInt(full.QTY_RECEIPT)+parseInt(full.QTY_REJECT));
                a = "<div class='col-md-12 text-center'>";
                a += numberWithCommas(qtyOutstanding);
                a += "</div>";
                return a;
            }
        }, {
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += "<input type='number' class='form-control' onkeyup='myFunction(this.value,"+qtyOutstanding+","+full.KODE_DETAIL_SHIPMENT+")' id='qtyReceipt"+full.KODE_DETAIL_SHIPMENT+"' name='' value='' style='width: 45px;' placeholder='0'>";
                a += "</div>";
                return a;
            }
        }, /*{
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += "<input type='number' class='form-control' id='qtyReject"+full.KODE_DETAIL_SHIPMENT+"' name='' value='' style='width: 45px;' placeholder='0'>";
                a += "</div>";
                return a;
            }
        },*/ {
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.MEINS;
                a += "</div>";
                return a;
            }
        },{
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.PLANT+" - "+full.PLANT_NAME;
                a += "</div>";
                return a;
            }
        },{
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center' style='color: red;'>";
                a += "<strong>"+full.EXPIRED_DATE+"</strong>";
                a += "</div>";
                return a;
            }
        },{
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += "<input type='checkbox' data-kodeshipment=" + full.KODE_DETAIL_SHIPMENT + " data-plant=" + full.PLANT + " data-namaplant='" + full.PLANT_NAME + "' data-satuan=" + full.MEINS + " data-matno=" + full.MATNO + " data-maktx=" + full.MAKTX + "  data-po=" + full.PO_NO + " data-noshipment=" + full.NO_SHIPMENT + " class='itemShipment'>";
                a += "</div>";
                return a;
            }
        },{
            mRender: function (data, type, full) {                
                a = "<div class='col-md-12 text-center'>";
                if(shipment != full.NO_SHIPMENT){
                    a += '<button class="btn btn-sm btn-success btn-print" data-shipment=' + full.NO_SHIPMENT + ' data-po=' + full.PO_NO + ' data-vendor=' + full.VENDORNO + '><i class="fa fa-edit"></i> Cetak Shipment</button>';
                    shipment = full.NO_SHIPMENT;
                } else {
                    shipment = full.NO_SHIPMENT;
                }
                a += "</div>";
                return a;
            }
        }],

    });

    mytableUnprocessed.on('click', '.btn-print', function (e) {
        e.preventDefault();
        var _tr = $(this).closest('tr');
        var _tds = _tr.find('td');

        var po = $(this).data('po');
        var vendor = $(this).data('vendor');
        var shipment = $(this).data('shipment');
        var _data = {
            po_no: po,
            vendor: vendor,
            shipment:shipment
        };

        $.redirect($('#base-url').val() + 'EC_Good_Receipt_PL/CetakShipment', _data, 'POST', '_blank');
    });
    mytableUnprocessed.columns().every(function () {
        var that = this;
        $('.srch3', this.header()).on('keyup change', function () {
            if (that.search() !== this.value) {
                that.search(this.value).draw();
            }
        });
    });

    $('#table_Unprocessed').find("th").off("click.DT");
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
        if (tt1) {
            mytableUnprocessed.order([0, 'asc']).draw();
            tt1 = false;
        } else {
            mytableUnprocessed.order([0, 'desc']).draw();
            tt1 = true;
        }
    });
    $('.ts2').on('dblclick', function () {
        if (tt2) {
            mytableUnprocessed.order([1, 'asc']).draw();
            tt2 = false;
        } else {
            mytableUnprocessed.order([1, 'desc']).draw();
            tt2 = true;
        }
    });
    $('.ts3').on('dblclick', function () {
        if (tt3) {
            mytableUnprocessed.order([2, 'asc']).draw();
            tt3 = false;
        } else {
            mytableUnprocessed.order([2, 'desc']).draw();
            tt3 = true;
        }
    });
    $('.ts4').on('dblclick', function () {
        if (tt4) {
            mytableUnprocessed.order([3, 'asc']).draw();
            tt4 = false;
        } else {
            mytableUnprocessed.order([3, 'desc']).draw();
            tt4 = true;
        }
    });
    $('.ts5').on('dblclick', function () {
        if (tt5) {
            mytableUnprocessed.order([4, 'asc']).draw();
            tt5 = false;
        } else {
            mytableUnprocessed.order([4, 'desc']).draw();
            tt5 = true;
        }
    });
    $('.ts6').on('dblclick', function () {
        if (tt6) {
            mytableUnprocessed.order([5, 'asc']).draw();
            tt6 = false;
        } else {
            mytableUnprocessed.order([5, 'desc']).draw();
            tt6 = true;
        }
    });
    /*$('.ts7').on('dblclick', function () {
        if (tt7) {
            mytableUnprocessed.order([6, 'asc']).draw();
            tt7 = false;
        } else {
            mytableUnprocessed.order([6, 'desc']).draw();
            tt7 = true;
        }
    });*/
    $('.ts8').on('dblclick', function () {
        if (tt8) {
            mytableUnprocessed.order([7, 'asc']).draw();
            tt8 = false;
        } else {
            mytableUnprocessed.order([7, 'desc']).draw();
            tt8 = true;
        }
    });
    $('.ts9').on('dblclick', function () {
        if (tt9) {
            mytableUnprocessed.order([8, 'asc']).draw();
            tt9 = false;
        } else {
            mytableUnprocessed.order([8, 'desc']).draw();
            tt9 = true;
        }
    });
    $('.ts10').on('dblclick', function () {
        if (tt10) {
            mytableUnprocessed.order([9, 'asc']).draw();
            tt10 = false;
        } else {
            mytableUnprocessed.order([9, 'desc']).draw();
            tt10 = true;
        }
    });
}

function myFunction(val, qty, kode) { 
    if(val==0){
        if(val==''){
            
        }else{
            alert('Qty Receipt minimal 1');
            $('#qtyReceipt'+kode).val('');             
        }        
    }
    if(val<0){
        alert('Qty Receipt minimal 1');
        $('#qtyReceipt'+kode).val('');
    }
    if(val>qty){
        alert('Nilai tidak boleh melebihi QTY Shipment');
        $('#qtyReceipt'+kode).val('');
    }/*else if(val!=''){
        //alert(val);

        $('#qtyReject'+kode).val((parseInt(qty)-parseInt(val)));
    }else{
        $('#qtyReject'+kode).val('');
    }*/

}

function loadTable_App() {
    $('#table_processed').DataTable().destroy();
    $('#table_processed tbody').empty();
    var shipment = 0;
    mytable = $('#table_processed').DataTable({
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
        // "ajax": $("#base-url").val() + 'EC_Report_PL/getPOReport',
        "ajax": {
                url: $("#base-url").val() + 'EC_Good_Receipt_PL/getPOorder',
                // type: 'POST',
                dataType: 'json',
                data: {
                        
                }
            },
        /*"columnDefs": [{
            "searchable": false,
            "orderable": true,
            "targets": 0
        }],*/
        // "order": [[ 1, 'asc' ]],
        "fnInitComplete": function () {
            $('#table_processed tbody tr').each(function () {
                $(this).find('td').attr('nowrap', 'nowrap');
                // $(this).find('td').addClass('text-center');
            });
        },
        /*"fnCreatedRow": function (row, data, index) {
            $('td', row).eq(0).html("<div class='col-md-12 text-center'>"+(index + 1)+"</div>");
        },*/
        "drawCallback": function (settings) {
            $('#table_processed tbody tr').each(function () {
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
                a += full.VENDOR_NAME;
                a += "</div>";
                return a;
            }
        }, {
            mRender: function (data, type, full) {
                if (full.ROWSPAN == "YES"){
                    a = "<div class='col-md-12 text-center'>";
                    a += full.PO_NO;
                    a += "</div>";
                } else {
                    a = "";
                }
                return a;
            }
        }, {
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.LINE_ITEM;
                a += "</div>";
                return a;
            }
        },{
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += "<strong><a href='javascript:void(0)' data-backdrop='true' data-toggle='modal' data-target='#modaldetail' data-produk='"+full.MATNO+"'>"+full.MAKTX+"</a></strong>";
                a += "</div>";
                return a;
            }
        }, {
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += numberWithCommas(full.QTY_ORDER);
                a += "</div>";
                return a;
            }
        }, {
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.QTY_SHIPMENT;
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
        }, {
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += numberWithCommas(full.PRICE);
                a += "</div>";
                return a;
            }
        }, {
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += numberWithCommas(full.NET_VALUE);
                a += "</div>";
                return a;
            }
        },{
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.CURRENCY;
                a += "</div>";
                return a;
            }
        },{
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.PLANT+" - "+full.PLANT_NAME;
                a += "</div>";
                return a;
            }
        },{
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center' style='color: red;'>";
                a += "<strong>"+full.EXPIRED_DATE+"</strong>";
                a += "</div>";
                return a;
            }
        },{
            mRender: function (data, type, full) {                
                    a = "<div class='col-md-12 text-center'>" +                    
                    '<a href="javascript:void(0)" data-toggle="modal" data-target="#modalDetilGR" data-pono="' + (full.PO_NO) + '"><span title="History" class="glyphicon glyphicon-search" aria-hidden="true"></span></a>' +
                    '</div>';
                return a;
            }
        },{
        mRender: function (data, type, full) {   
            var shipment;
                a = "<div class='col-md-12 text-center'>";   
                if(full.QTY_SHIPMENT > 0){
                    if(shipment != full.PO_NO){
                        a += '<button class="btn btn-sm btn-success btn-print" data-po=' + full.PO_NO + ' data-vendor=' + full.VENDORNO + '><i class="fa fa-edit"></i> Cetak PO</button>';                         
                        shipment = full.PO_NO;
                    } else {
                        shipment = full.PO_NO;
                    }           
                }     
                a += "</div>";
                return a;
            }
        }],

    });                
    mytable.on('click', '.btn-print', function (e) {
        e.preventDefault();
        var _tr = $(this).closest('tr');
        var _tds = _tr.find('td');

        var po = $(this).data('po');
        var vendor = $(this).data('vendor');        
        var _data = {
            po_no: po,
            vendor: vendor            
        };

        $.redirect($('#base-url').val() + 'EC_Good_Receipt_PL/CetakPO', _data, 'POST', '_blank');
    });
    mytable.columns().every(function () {
        var that = this;
        $('.srch', this.header()).on('keyup change', function () {
            if (that.search() !== this.value) {
                that.search(this.value).draw();
            }
        });
    });

    // mytable.rows().eq(0).each( function ( index ) {
    // var row = mytable.row( index );
 
    // var data = row.data();
    // console.log( 'Data in index: '+row+' is: '+data );
    // // ... do something with data(), or row.node(), etc
    // } );

    $('#table_processed').find("th").off("click.DT");
    /*$('.ts0').on('dblclick', function () {
        if (t0) {
            mytable.order([0, 'asc']).draw();
            t0 = false;
        } else {
            mytable.order([0, 'desc']).draw();
            t0 = true;
        }
    });*/
    $('.tts1').on('dblclick', function () {
        if (t1) {
            mytable.order([0, 'asc']).draw();
            t1 = false;
        } else {
            mytable.order([0, 'desc']).draw();
            t1 = true;
        }
    });
    $('.tts2').on('dblclick', function () {
        if (t2) {
            mytable.order([1, 'asc']).draw();
            t2 = false;
        } else {
            mytable.order([1, 'desc']).draw();
            t2 = true;
        }
    });
    $('.tts3').on('dblclick', function () {
        if (t3) {
            mytable.order([2, 'asc']).draw();
            t3 = false;
        } else {
            mytable.order([2, 'desc']).draw();
            t3 = true;
        }
    });
    $('.tts4').on('dblclick', function () {
        if (t4) {
            mytable.order([3, 'asc']).draw();
            t4 = false;
        } else {
            mytable.order([3, 'desc']).draw();
            t4 = true;
        }
    });
    $('.tts5').on('dblclick', function () {
        if (t5) {
            mytable.order([4, 'asc']).draw();
            t5 = false;
        } else {
            mytable.order([4, 'desc']).draw();
            t5 = true;
        }
    });
    $('.tts6').on('dblclick', function () {
        if (t6) {
            mytable.order([5, 'asc']).draw();
            t6 = false;
        } else {
            mytable.order([5, 'desc']).draw();
            t6 = true;
        }
    });
    $('.tts7').on('dblclick', function () {
        if (t7) {
            mytable.order([6, 'asc']).draw();
            t7 = false;
        } else {
            mytable.order([6, 'desc']).draw();
            t7 = true;
        }
    });
    $('.tts8').on('dblclick', function () {
        if (t8) {
            mytable.order([7, 'asc']).draw();
            t8 = false;
        } else {
            mytable.order([7, 'desc']).draw();
            t8 = true;
        }
    });
    $('.tts9').on('dblclick', function () {
        if (t9) {
            mytable.order([8, 'asc']).draw();
            t9 = false;
        } else {
            mytable.order([8, 'desc']).draw();
            t9 = true;
        }
    });
    $('.tts10').on('dblclick', function () {
        if (t10) {
            mytable.order([9, 'asc']).draw();
            t10 = false;
        } else {
            mytable.order([9, 'desc']).draw();
            t10 = true;
        }
    });
    $('.tts11').on('dblclick', function () {
        if (t11) {
            mytable.order([10, 'asc']).draw();
            t11 = false;
        } else {
            mytable.order([10, 'desc']).draw();
            t11 = true;
        }
    });
    $('.tts12').on('dblclick', function () {
        if (t12) {
            mytable.order([11, 'asc']).draw();
            t12 = false;
        } else {
            mytable.order([11, 'desc']).draw();
            t12 = true;
        }
    });
}


function loadTable_detailGR(pono, lineitem) {
    var s1 = true,
        s2 = true,
        s3 = true,
        s4 = true,
        s5 = true,
        s6 = true,
        s7 = true,
        s8 = true,
        s9 = true,
        s10 = true,
        s11 = true,
        s12 = true,
        s13 = true,
        s14 = true,
        s15 = true,
        s16 = true,
        s17 = true
    // $('#table_detailGR').DataTable().clear();
    $('#table_detailGR').DataTable().destroy();
    $('#table_detailGR tbody').empty();
    mytableGR = $('#table_detailGR').DataTable({
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
        // "ajax": $("#base-url").val() + 'EC_Report_PL/getPOReport',
        "ajax": {
                url: $("#base-url").val() + 'EC_Good_Receipt_PL/detailHistoryGR/' + pono,
                type: 'POST',
                dataType: 'json',
                data: {
                    line_item: lineitem
                }
            },
        /*"columnDefs": [{
            "searchable": false,
            "orderable": true,
            "targets": 0
        }],*/
        // "order": [[ 1, 'asc' ]],
        "fnInitComplete": function () {
            $('#table_detailGR tbody tr').each(function () {
                $(this).find('td').attr('nowrap', 'nowrap');
                // $(this).find('td').addClass('text-center');
            });
        },
        /*"fnCreatedRow": function (row, data, index) {
            $('td', row).eq(0).html("<div class='col-md-12 text-center'>"+(index + 1)+"</div>");
        },*/
        "drawCallback": function (settings) {
            $('#table_detailGR tbody tr').each(function () {
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
                a += full.VENDOR_NAME;
                a += "</div>";
                return a;
            }
        },{
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.NO_SHIPMENT;
                a += "</div>";
                return a;
            }
        },  {
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.PO_NO;
                a += "</div>";
                return a;
            }
        }, {
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.LINE_ITEM;
                a += "</div>";
                return a;
            }
        },{
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.MAKTX;
                a += "</div>";
                return a;
            }
        }, {
            mRender: function (data, type, full) {
                if(full.STATUS==1){
                    qty = full.QTY_RECEIPT;
                }else if(full.STATUS==2){
                    qty = full.QTY_REJECT;
                }
                a = "<div class='col-md-12 text-center'>";
                a += numberWithCommas(qty);
                a += "</div>";
                return a;
            }
        }, {
            mRender: function (data, type, full) {
                if(full.STATUS==1){
                    status = 'Receipt'
                }else if(full.STATUS==2){
                    status = 'Reject'
                }
                a = "<div class='col-md-12 text-center'>";
                a += status;
                a += "</div>";
                return a;
            }
        },{
            mRender: function (data, type, full) {                
                a = "<div class='col-md-12 text-center'>";
                a += (full.ALASAN_REJECT==null?'-':full.ALASAN_REJECT);
                a += "</div>";
                return a;
            }
        },{
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.MEINS;
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
        }, {
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += (full.GR_NO==null?'-':full.GR_NO);
                a += "</div>";
                return a;
            }
        },{
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += (full.GR_YEAR==null?'-':full.GR_YEAR);
                a += "</div>";
                return a;
            }
        },{
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.DOC;
                a += "</div>";
                return a;
            }
        },{
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.POST;
                a += "</div>";
                return a;
            }
        },{
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.CREATED_ON;
                a += "</div>";
                return a;
            }
        },{
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.CREATED_BY;
                a += "</div>";
                return a;
            }
        }],

    });
    
    mytableGR.columns().every(function () {
        var that = this;
        $('.srchgr', this.header()).on('keyup change', function () {
            if (that.search() !== this.value) {
                that.search(this.value).draw();
            }
        });
    });

    // mytable.rows().eq(0).each( function ( index ) {
    // var row = mytable.row( index );
 
    // var data = row.data();
    // console.log( 'Data in index: '+row+' is: '+data );
    // // ... do something with data(), or row.node(), etc
    // } );

    $('#table_detailGR').find("th").off("click.DT");
    /*$('.ts0').on('dblclick', function () {
        if (t0) {
            mytable.order([0, 'asc']).draw();
            t0 = false;
        } else {
            mytable.order([0, 'desc']).draw();
            t0 = true;
        }
    });*/
    $('.s1').on('dblclick', function () {
        if (s1) {
            mytableGR.order([0, 'asc']).draw();
            s1 = false;
        } else {
            mytableGR.order([0, 'desc']).draw();
            s1 = true;
        }
    });
    $('.s2').on('dblclick', function () {
        if (s2) {
            mytableGR.order([1, 'asc']).draw();
            s2 = false;
        } else {
            mytableGR.order([1, 'desc']).draw();
            s2 = true;
        }
        console.log(s2)
    });
    $('.s3').on('dblclick', function () {
        if (s3) {
            mytableGR.order([2, 'asc']).draw();
            s3 = false;
        } else {
            mytableGR.order([2, 'desc']).draw();
            s3 = true;
        }
    });
    $('.s4').on('dblclick', function () {
        if (s4) {
            mytableGR.order([3, 'asc']).draw();
            s4 = false;
        } else {
            mytableGR.order([3, 'desc']).draw();
            s4 = true;
        }
    });
    $('.s5').on('dblclick', function () {
        if (s5) {
            mytableGR.order([4, 'asc']).draw();
            s5 = false;
        } else {
            mytableGR.order([4, 'desc']).draw();
            s5 = true;
        }
    });
    $('.s6').on('dblclick', function () {
        if (s6) {
            mytableGR.order([5, 'asc']).draw();
            s6 = false;
        } else {
            mytableGR.order([5, 'desc']).draw();
            s6 = true;
        }
    });
    $('.s7').on('dblclick', function () {
        if (s7) {
            mytableGR.order([6, 'asc']).draw();
            s7 = false;
        } else {
            mytableGR.order([6, 'desc']).draw();
            s7 = true;
        }
    });
    $('.s8').on('dblclick', function () {
        if (s8) {
            mytableGR.order([7, 'asc']).draw();
            s8 = false;
        } else {
            mytableGR.order([7, 'desc']).draw();
            s8 = true;
        }
    });
    $('.s9').on('dblclick', function () {
        if (s9) {
            mytableGR.order([8, 'asc']).draw();
            s9 = false;
        } else {
            mytableGR.order([8, 'desc']).draw();
            s9 = true;
        }
    });
    $('.s10').on('dblclick', function () {
        if (s10) {
            mytableGR.order([9, 'asc']).draw();
            s10 = false;
        } else {
            mytableGR.order([9, 'desc']).draw();
            s10 = true;
        }
    });
    $('.s11').on('dblclick', function () {
        if (s11) {
            mytableGR.order([10, 'asc']).draw();
            s11 = false;
        } else {
            mytableGR.order([10, 'desc']).draw();
            s11 = true;
        }
    });
    $('.s12').on('dblclick', function () {
        if (s12) {
            mytableGR.order([11, 'asc']).draw();
            s12 = false;
        } else {
            mytableGR.order([11, 'desc']).draw();
            s12 = true;
        }
    });
    $('.s13').on('dblclick', function () {
        if (s13) {
            mytableGR.order([12, 'asc']).draw();
            s13 = false;
        } else {
            mytableGR.order([12, 'desc']).draw();
            s13 = true;
        }
    });
    $('.s14').on('dblclick', function () {
        if (s14) {
            mytableGR.order([13, 'asc']).draw();
            s14 = false;
        } else {
            mytableGR.order([13, 'desc']).draw();
            s14 = true;
        }
    });
    $('.s15').on('dblclick', function () {
        if (s15) {
            mytableGR.order([14, 'asc']).draw();
            s15 = false;
        } else {
            mytableGR.order([14, 'desc']).draw();
            s15 = true;
        }
    });
}

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

$('#modaldetail').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget)
    var MATNR = button.data('produk')
    //var id = button.data('id')
    //var modal = $(this)
    $.ajax({
        url: $("#base-url").val() + 'EC_Good_Receipt_PL/getDescItem/' + MATNR,
        type: 'POST',
        dataType: 'json'
    }).done(function (data) {
        // console.log(data);
        $("#detail_MATNR").text(data.MATNR[0].MATNR == null ? "-" : data.MATNR[0].MATNR);
        $("#detail_MAKTX").text(data.MATNR[0].MAKTX == null ? "-" : data.MATNR[0].MAKTX);
        $("#detail_LNGTX").text(data.MATNR[0].LNGTX == null ? "-" : data.MATNR[0].LNGTX);
        $("#detail_MEINS").text(data.MATNR[0].MEINS == null ? "-" : data.MATNR[0].MEINS);
        $("#detail_MATKL").text(data.MATNR[0].MATKL == null ? "-" : data.MATNR[0].MATKL);
        $("#detail_MTART").text(data.MATNR[0].MTART == null ? "-" : data.MATNR[0].MTART);
        $("#detail_created").text(data.MATNR[0].ERNAM + ", " + data.MATNR[0].ERSDA.substring(6) + "-" + data.MATNR[0].ERSDA.substring(4, 6) + "-" + data.MATNR[0].ERSDA.substring(0, 4));
        if (data.MATNR[0].PICTURE != null || data.MATNR[0].DRAWING != null) {
            $("#pic").attr('src', $("#base-url").val() + $("#UPLOAD_PATH").val() + "EC_material_strategis/" + data.MATNR[0].PICTURE);
            $("#draw").attr('src', $("#base-url").val() + $("#UPLOAD_PATH").val() + "EC_material_strategis/" + data.MATNR[0].DRAWING);
        } else {
            $("#pic").attr('src', $("#base-url").val() + $("#UPLOAD_PATH").val() + "EC_material_strategis/default_post_img.png");
            $("#draw").attr('src', $("#base-url").val() + $("#UPLOAD_PATH").val() + "EC_material_strategis/default_post_img.png");
        }
    }).fail(function () {
        // console.log("error");
    }).always(function (data) {
        //console.log(data);
    });
});

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

$('#receipt').on('hidden.bs.modal', function (event) {
    itemShipment = []
    itemQty = []
    console.log(itemShipment);
    //console.log(teksin);
});

$('#reject').on('hidden.bs.modal', function (event) {
    itemShipment = []
    itemQty = []
    console.log(itemShipment);
    //console.log(teksin);
});

$('#modalDetilGR').on('hidden.bs.modal', function (event) {
    
    
});

$('#modalDetilGR').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget)
    var pono = button.data('pono')
    var lineitem = button.data('lineitem')

    // mytableGR.clear().draw();
    console.log(s2)
    loadTable_detailGR(pono, lineitem);

    /*$.ajax({
        url: $("#base-url").val() + 'EC_Good_Receipt_PL/detailHistoryGR/' + pono,
        type: 'POST',
        dataType: 'json',
        data: {
                lineitem: lineitem
        }
    }).done(function (data) {
        console.log(data.length);
        var teks = ""
        var status = ''
        if(data.length>0){
            $("#bodyTableDetailGR").empty()
            for (var i = 0; i < data.length; i++) {
                if(data[i]['STATUS']==1){
                    status = 'Receipt'
                }else if(data[i]['STATUS']==2){
                    status = 'Reject'
                }
                teks += "<tr>"
                teks += "<td class=\"text-center\">" + data[i]['VENDOR_NAME'] + "</td>"
                teks += "<td class=\"text-center\">" + data[i]['NO_SHIPMENT'] + "</td>"
                teks += "<td class=\"text-center\">" + data[i]['PO_NO'] + "</td>"
                teks += "<td class=\"text-center\">" + data[i]['LINE_ITEM'] + "</td>"
                teks += "<td class=\"text-center\">" + data[i]['MAKTX'] + "</td>"
                teks += "<td class=\"text-center\">" + data[i]['QTY_RECEIPT'] + "</td>"
                teks += "<td class=\"text-center\">" + data[i]['MEINS'] + "</td>"
                teks += "<td class=\"text-center\">" + data[i]['PLANT'] +"-"+ data[i]['PLANT_NAME'] + "</td>"
                teks += "<td class=\"text-center\">" + (data[i]['GR_NO']==null?'-':data[i]['GR_NO']) +"</td>"
                teks += "<td class=\"text-center\">" + (data[i]['GR_YEAR']==null?'-':data[i]['GR_YEAR']) +"</td>"
                teks += "<td class=\"text-center\">" + data[i]['DOC'] +"</td>"
                teks += "<td class=\"text-center\">" + data[i]['POST'] +"</td>"
                teks += "<td class=\"text-center\">" + status +"</td>"
                /*teks += "<td class=\"text-center\"><input type='checkbox' data-kodeshipment=" + data[i]['KODE_DETAIL_SHIPMENT'] + " class='itemship'></td>"*/

                /*teks += "</tr>"
            }
            $("#bodyTableDetailGR").html(teks)
        }else{
            $("#bodyTableDetailGR").empty()
            teks += "<div class='row text-center'>"
            teks += "No data history . . ."
            teks += "</div>"
            $("#bodyTableDetailGR").html(teks)
        }

    }).fail(function () {
        // console.log("error");
    }).always(function (data) {
        // console.log(data);

    });*/
});

$('#modalDetailPo').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget)
    var pono = button.data('pono')
    //var kodeshipment = button.data('kodeshipment')

    console.log("tes");
    $.ajax({
        url: $("#base-url").val() + 'EC_Shipment/getPODetail/' + pono,
        type: 'POST',
        dataType: 'json'
    }).done(function (data) {
        var teks = ""
        $("#tableDetailPO").empty()
        for (var i = 0; i < data.length; i++) {
            console.log("masuk");
            teks += "<tr>";
            //teks += "<td class=\"text-center\">" + (i + 1) + "</td>";
            teks += "<td class=\"text-center\">" + data[i]['LINE_ITEM'] + "</td>";
            teks += "<td class=\"text-center\">" + data[i]['MAKTX'] + "</td>";
            teks += "<td class=\"text-center\">" + data[i]['QTY'] + "</td>";
            teks += "<td class=\"text-center\">" + data[i]['MEINS'] + "</td>";
            teks += "<td class=\"text-center\">" + numberWithCommas(data[i]['PRICE']) + "</td>";
            teks += "<td class=\"text-center\">" + data[i]['CURRENCY'] + "</td>";
            teks += "<td class=\"text-center\">" + numberWithCommas(data[i]['TOTAL']) + "</td>";
            teks += "<td class=\"text-center\">" + data[i]['PLANT'] +" - "+ data[i]['DESC'] +"</td>";
            teks += "<td class=\"text-center\" style=\"color: red;\"><strong>" + data[i]['EXPIRED_DATE'] + "</strong></td>";
            teks += "</tr>";
        }
        $("#tableDetailPO").html(teks)
    }).fail(function () {
        // console.log("error");
    }).always(function (data) {
        // console.log(data);

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

    tt1 = true,
    tt2 = true,
    tt3 = true,
    tt4 = true,
    tt5 = true,
    tt6 = true,
    tt7 = true,
    tt8 = true,
    tt9 = true,
    tt10 = true,

    s1 = true,
    s2 = true,
    s3 = true,
    s4 = true,
    s5 = true,
    s6 = true,
    s7 = true,
    s8 = true,
    s9 = true,
    s10 = true,
    s11 = true,
    s12 = true,
    s13 = true,
    s14 = true,
    s15 = true,

    clicks = 0,
    timer = null;
var tt1 = [t1, t2, t3, t4, t5, t6, t7, t8, t9, t10];
var tt2 = [t1, t2, t3, t4, t5, t6, t7, t8, t9, t10];
var tt3 = [t1, t2, t3, t4, t5, t6, t7, t8, t9, t10, t11, t12];
var tt4 = [tt1, tt2, tt3, tt4, tt5, tt6, tt7, tt8, tt9, tt10];
var ss4 = [s1, s2, s3, s4, s5, s6, s7, s8, s9, s10, s11, s12, s13, s14, s15];
var items = []
var itemShipment = []
var itemQty = []
var itemship = []
var itemCheck = ''
var mytableGR = '';
$(document).ready(function () {

    loadTable_App();
    loadTable_Unprocessed();
    // loadTable_detailGR(0, 0)
    // loadTable_Processed();
    // loadTable_Intransit();
    $(".sear1").hide();
    for (var i = 0; i < tt4.length; i++) {
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

    $(".sear2").hide();
    for (var i = 0; i < tt3.length; i++) {
        $(".tts" + i).on("click", function (e) {
            clicks++;
            if (clicks === 1) {
                timer = setTimeout(function () {
                    $(".sear2").toggle();
                    clicks = 0;
                }, 300);
            } else {
                clearTimeout(timer);
                $(".sear2").hide();
                clicks = 0;
            }
        }).on("dblclick", function (e) {
            e.preventDefault();
        });
    }

    $(".seargr").hide();
    for (var i = 0; i < ss4.length; i++) {
        $(".s" + i).on("click", function (e) {
            clicks++;
            if (clicks === 1) {
                timer = setTimeout(function () {
                    $(".seargr").toggle();
                    clicks = 0;
                }, 300);
            } else {
                clearTimeout(timer);
                $(".seargr").hide();
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

    $('#setReceipt').click(function () {
        $(".date").datepicker("setDate", new Date());
        //items = []
        $(".itemShipment").each(function () {
            var kode = $(this).data("kodeshipment")
            if ($(this).is(":checked")){
                itemShipment.push(String($(this).data("kodeshipment")));
                itemQty.push($('#qtyReceipt'+kode).val());
            }
        });
        dataitems = JSON.stringify(itemShipment)
        console.log(itemQty)

        console.log(itemShipment);
        //accept(items)
        // var dataSplit = itemShipment[0].split('_')
        if(itemShipment.length==0){
            alert('pilih Item dulu');
            // $('#receipt').modal('hide');
        } else {
            $('#receipt').modal('show');
            $.ajax({
                url: $("#base-url").val() + 'EC_Good_Receipt_PL/getPOShipmentReview/',
                type: 'POST',
                data: {
                    kode_shipment: dataitems
                },
                dataType: 'json'
            }).done(function (data) {
                var teks = ""
                $("#bodyTableGR").empty()
                for (var i = 0; i < data.length; i++) {
                    teks += "<tr>";
                    // teks += "<td class=\"text-center\">" + (i + 1) + "</td>";
                    teks += "<td class=\"text-center\">" + data[i]['VENDOR_NAME'] + "</td>"
                    teks += "<td class=\"rowspan text-center\">" + data[i]['PO_NO'] + "</td>"
                    teks += "<td class=\"text-center\">" + data[i]['LINE_ITEM'] + "</td>"
                    teks += "<td class=\"text-center\">" + data[i]['MAKTX'] + "</td>"
                    teks += "<td class=\"text-center\">" + itemQty[i] + "</td>"
                    teks += "<td class=\"text-center\">" + data[i]['MEINS'] + "</td>"
                    teks += "<td class=\"text-center\">" + data[i]['PLANT'] + " - "+ data[i]['PLANT_NAME'] +"</td>"
                    teks += "</tr>"
                }
                $("#bodyTableGR").html(teks)
            }).fail(function () {
                // console.log("error");
            }).always(function (data) {
                // console.log(data);

            });
        }
        
    })

    $('#setReject').click(function () {
        // $(".date").datepicker("setDate", new Date());
        //items = []
        $(".itemShipment").each(function () {
            var kode = $(this).data("kodeshipment")
            if ($(this).is(":checked")){
                itemShipment.push(String($(this).data("kodeshipment")));
                itemQty.push($('#qtyReceipt'+kode).val());
            }
        });
        dataitems = JSON.stringify(itemShipment)
        console.log(itemQty)

        console.log(itemShipment);
        //accept(items)
        // var dataSplit = itemShipment[0].split('_')
        if(itemShipment.length==0){
            alert('pilih Item dulu');
        }else{
            $('#reject').modal('show');
            $.ajax({
                url: $("#base-url").val() + 'EC_Good_Receipt_PL/getPOShipmentReview/',
                type: 'POST',
                data: {
                    kode_shipment: dataitems
                },
                dataType: 'json'
            }).done(function (data) {
                var teks = ""
                $("#bodyTableReject").empty()
                for (var i = 0; i < data.length; i++) {
                    teks += "<tr>";
                    // teks += "<td class=\"text-center\">" + (i + 1) + "</td>";
                    teks += "<td class=\"text-center\">" + data[i]['VENDOR_NAME'] + "</td>"
                    teks += "<td class=\"text-center\">" + data[i]['PO_NO'] + "</td>"
                    teks += "<td class=\"text-center\">" + data[i]['LINE_ITEM'] + "</td>"
                    teks += "<td class=\"text-center\">" + data[i]['MAKTX'] + "</td>"
                    teks += "<td class=\"text-center\">" + itemQty[i] + "</td>"
                    teks += "<td class=\"text-center\">" + data[i]['MEINS'] + "</td>"
                    teks += "<td class=\"text-center\">" + data[i]['PLANT'] + " - "+ data[i]['PLANT_NAME'] +"</td>"
                    teks += "</tr>"
                }
                $("#bodyTableReject").html(teks)
            }).fail(function () {
                // console.log("error");
            }).always(function (data) {
                // console.log(data);

            });
        }
        
    })

    $(document).on('change','.itemShipment',function () {
        var kode = $(this).data("kodeshipment");
        console.log($('#qtyReceipt'+kode).val());
        if($('#qtyReceipt'+kode).val()=='' || $('#qtyReceipt'+kode).val()=='0'){
            alert('Qty receipt minimal 1');
            $($(this)).prop('checked', false);
            $('#qtyReceipt'+kode).val('');
        }else{
            var cek = String($(this).data("po"))+"_"+String($(this).data("noshipment"));
            if ($(this).is(":checked")){
                if(itemCheck==cek){
                    console.log(itemCheck)
                }else{
                    if(itemCheck==''){
                        itemCheck=cek;
                    }else if(itemCheck!=cek){
                        alert('Nomor shipment dan PO tidak boleh berbeda');
                        $($(this)).prop('checked', false);
                        $('#qtyReceipt'+kode).val('');
                    }else{
                        itemCheck=cek;
                    }
                }
                // itemShipment.push(String($(this).data("po"))+"_"+String($(this).data("noshipment")));
            }else{
                // console.log(itemCheck)
                var dat = 0;
                $(".itemShipment").each(function () {
                    if ($(this).is(":checked")){
                        dat = dat+1;
                    }
                });
                // console.log(dat)
                if(dat==0){
                    itemCheck= '';
                }
            }
        }
        
        // console.log(itemShipment)
    })

    $('#receiptShipment').click(function () {
        dataitems = JSON.stringify(itemShipment)
        dataqty = JSON.stringify(itemQty)
        console.log(dataitems)

        var docdate = $('#docdate').val();
        var postdate = $('#postdate').val();
        var rating = $('#rating-input').val();
        var comment = $('#comment').val();
        // console.log(docdate+"-"+postdate+"-"+rating+"-"+comment)
        receiptShipment(dataitems, dataqty, docdate, postdate, rating, comment);
    })

    $('#rejectShipment').click(function () {
        dataitems = JSON.stringify(itemShipment)
        dataqty = JSON.stringify(itemQty)
        console.log(dataitems)

        // var docdate = $('#docdate').val();
        // var postdate = $('#postdate').val();
        var rating = $('#rating-input').val();
        var alasan = $('#alasanReject').val();
        // console.log(docdate+"-"+postdate+"-"+rating+"-"+comment)
        rejectShipment(dataitems, dataqty, rating, alasan);
    })

    $('#saveShipment').click(function () {
        //items = []
        
        $(".itemspo").each(function () {
            if ($(this).is(":checked"))
                // if (itemShipment.indexOf($(this).data("po")) == -1)
                    itemShipment.push(String($(this).data("po"))+"_"+String($(this).data("lineitem"))+"_"+String($(this).data("kode"))+"_"+$("#"+String($(this).data("po"))+"_"+String($(this).data("lineitem"))).val()+"_"+String($(this).data("kodeship")));
        });

        if(itemShipment.length>0){
            dataitems = JSON.stringify(itemShipment)
            console.log(dataitems)

            console.log(itemShipment);
            save(dataitems, $('#shipmentCode').val(), $('#tglShipment').val());
        }else{
            alert('check terlebih dahulu item yg akan di shipment');
        }

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

        deleteShipment(dataitems)
    })
});

function receiptShipment(dataitems, dataqty, docdate, postdate, rating, comment) {
    // $('#receipt').modal('hide');
        $.ajax({
            url: $("#base-url").val() + 'EC_Good_Receipt_PL/insertGr',
            type: 'POST',
            data: {
                kodeshipment: dataitems,
                qtyreceipt: dataqty,
                docdate: docdate,
                postdate: postdate,
                rating: rating,
                comment: comment
            },
            dataType: 'json'
        }).done(function (data) {
            if(data.status){
              window.location.href = data.url; 
            } 
        }).always(function (data) {

        })
}

function rejectShipment(dataitems, dataqty, rating, alasan) {
    if(alasan !==''){
        $.ajax({
            url: $("#base-url").val() + 'EC_Good_Receipt_PL/rejectShipment',
            type: 'POST',
            dataType: 'json',
            data: {
                kodeshipment: dataitems,
                qtyreceipt: dataqty,
                rating: rating,
                alasan: alasan
            },
        }).done(function (data) {
            if(data.status){
              window.location.href = data.url; 
            } 
        }).always(function (data) {

        })
    }else{
        alert('Alasan Reject Wajib diisi');
    }
}
function cetakLaporan(elm){
	var _url = $(elm).data('href');
	var _hariini = $(elm).data('hariini');
	bootbox.prompt('Masukkan Bulan Laporan',function(t){
		if(t){
			window.open(_url+'/'+t);
		}
	}).on('shown.bs.modal', function(e) {
			$(this).find('input').datepicker({
					format: "yyyymmdd",
					autoclose: true,
					todayHighlight: true,
			}).datepicker('setDate',new Date()).prop('readonly',1);

	});
	return false;
}