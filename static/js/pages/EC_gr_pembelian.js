function numberWithCommas(x) {
    return x == null || x == "0" ? "" : x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

function loadTable_() {

    $('#table_gr').DataTable().destroy();
    $('#table_gr tbody').empty();
    mytable = $('#table_gr').DataTable({
        "bSort": true,
        "dom": 'rtpli',
        "deferRender": true,
        "colReorder": true,
        "pageLength": 10,
        "order": [],
        // "fixedHeader" : true,
        // "scrollX" : true,
        // "lengthMenu" : [5, 10, 25, 50, 75, 100],
        "language": {
            "loadingRecords": "<center><b>Please wait - Updating and Loading Data List PO...</b></center>"
        },
        "ajax": $("#base-url").val() + 'EC_GR_Pembelian/getItemShipment',

        /*"columnDefs": [{
            "searchable": false, 
            "orderable": true,
            "targets": 0
        }],*/
        // "order": [[ 1, 'asc' ]],
        "fnInitComplete": function () {
            $('#table_gr tbody tr').each(function () {
                $(this).find('td').attr('nowrap', 'nowrap');
                // $(this).find('td').addClass('text-center');
            });
        },
        /*"fnCreatedRow": function (row, data, index) {
            $('td', row).eq(0).html("<div class='col-md-12 text-center'>"+(index + 1)+"</div>");
        },*/
        "drawCallback": function (settings) {
            $('#table_gr tbody tr').each(function () {
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
                a += full.DATE_BUY;
                a += "</div>";
                return a;
            }
        }, {
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.VENDOR_NAME;
                a += "</div>";
                return a;
            }
        }, /*{
            mRender: function (data, type, full) {                                
                a = "<div class='col-md-12 text-center'>";
                a += full.APPROVE_DATE==null?'-':full.APPROVE_DATE;
                a += "</div>";
                return a;
            }
        },*/ {
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
                if(full.STOCK_COMMIT==full.QTY_SHIPMENT){
                    status = 'Complete';
                }else{
                    status = 'Process';
                }
                a = "<div class='col-md-12 text-center'>";
                a += status;
                a += "</div>";
                return a;
            }
        },{
            mRender: function (data, type, full) {
                hidden = '';
                if(full.STATUS!=2){
                    hidden = 'hidden';
                }
                a = "<div class='col-md-12 text-center'>" +
                    /*'<a href="javascript:Accepted(' + (full.KODE_DETAIL_SHIPMENT) + ')" '+hidden+'><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></a>&nbsp;&nbsp;' +'<a href="javascript:reject(' + (full.KODE_DETAIL_SHIPMENT) + ')" '+hidden+'><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>&nbsp;&nbsp;' +*/                    
                    '<a href="javascript:void(0)" data-toggle="modal" data-target="#modalDetil" data-kodeshipment="' + (full.KODE_SHIPMENT) + '"><span title="View Detail" class="glyphicon glyphicon-list-alt" aria-hidden="true"></span></a>&nbsp;&nbsp;' +
                    '<a href="javascript:void(0)" data-toggle="modal" data-target="#modalHistory" data-kodeshipment="' + (full.KODE_SHIPMENT) + '"><span class="glyphicon glyphicon-search" aria-hidden="true" title="Tracking"></span></a>' +
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

    $('#table_gr').find("th").off("click.DT");
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
    /*$('.ts5').on('dblclick', function () {
        if (t5) {
            mytable.order([5, 'asc']).draw();
            t5 = false;
        } else {
            mytable.order([5, 'desc']).draw();
            t5 = true;
        }
    });*/
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
	  $('.ts9').on('dblclick', function () {
        if (t8) {
            mytable.order([8, 'asc']).draw();
            t8 = false;
        } else {
            mytable.order([8, 'desc']).draw();
            t8 = true;
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

function Accepted(kode) {
    bootbox.confirm('Konfirmasi Barang diterima?', function (result) {
        if (result)
            window.location.href = $("#base-url").val() + 'EC_Penerimaan_Shipment/Accepted/' + kode
    });
}

function reject(kode_detail) {
    bootbox.confirm('Konfirmasi Reject Barang?', function (result) {
        if (result)
            window.location.href = $("#base-url").val() + 'EC_Penerimaan_Shipment/reject/' + kode_detail
    });
}

$('#modalHistory').on('show.bs.modal', function (event) {
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
$('#modalDetil').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget)
    var kodeshipment = button.data('kodeshipment')
    //var curr = button.data('curr')

    $.ajax({
        url: $("#base-url").val() + 'EC_GR_Pembelian/detail/' + kodeshipment,
        type: 'POST',
        dataType: 'json'
    }).done(function (data) {
        var teks = ""
        var status = ""
        
        $("#bodyTableDetail").empty()
        for (var i = 0; i < data.length; i++) {
            var disable = ""
            if(data[i]['STATUS']==1){
                status = "Dikirim"
            }else if(data[i]['STATUS']==2){
                status = "Accepted"
                disable = "disabled"
            }else{
                status = "Rejected"
            }
            teks += "<tr>";
            teks += "<td class=\"text-center\">" + (i + 1) + "</td>";
            teks += "<td class=\"text-center\">" + data[i]['MATNO'] + "</td>"
            teks += "<td class=\"text-center\">" + data[i]['MAKTX'] + "</td>"
            teks += "<td class=\"text-center\">" + data[i]['QTY'] + "</td>"
            teks += "<td class=\"text-center\">" + data[i]['MEINS'] + "</td>"
            teks += "<td class=\"text-center\">" + numberWithCommas(data[i]['PRICE']) + "</td>"
            teks += "<td class=\"text-center\">" + data[i]['CURRENCY'] + "</td>"
            teks += "<td class=\"text-center\">" + data[i]['DATE_SEND'] + "</td>"
            teks += "<td class=\"text-center\">" + (data[i]['GR_NO']==null?'-':data[i]['GR_NO']) + "</td>"
            teks += "<td class=\"text-center\">" + (data[i]['IN_DATE_GR']==null?'-':data[i]['IN_DATE_GR']) + "</td>"
            teks += "<td class=\"text-center\">" + status + "</td>"
            teks += "<td class=\"text-center\"><input " + disable + " type=\"checkbox\" data-kodeshipment=" + data[i]['KODE_DETAIL_SHIPMENT'] + " class='items'></td>"
            teks += "</tr>"
        }
        $("#bodyTableDetail").html(teks)
    }).fail(function () {
        // console.log("error");
    }).always(function (data) {
        // console.log(data);

    });
});

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
    
    $('#acceptShipment').click(function () {
        items = []
        
        $(".items").each(function () {
            if ($(this).is(":checked"))
                if (items.indexOf($(this).data("kodeshipment")) == -1)
                    items.push(String($(this).data("kodeshipment")));
        });
        dataitems = JSON.stringify(items)
        console.log(dataitems)
        
        accept(items)
    })

});

function accept(itm) {
        $.ajax({
            url: $("#base-url").val() + 'EC_GR_Pembelian/Accepted',
            type: 'POST',
            dataType: 'json',
            data: {
                kodeshipment: itm
            },
        }).done(function (data) {
            
        }).always(function (data) {
            //location.reload();

        })
}
