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
        "ajax": $("#base-url").val() + 'EC_Report_pengadaan/getReport_approval',

        "columnDefs": [{
            "searchable": false,
            "orderable": true,
            "targets": 0
        }],
        // "order": [[ 1, 'asc' ]],
        "fnInitComplete": function () {
            $('#table_inv tbody tr').each(function () {
                $(this).find('td').attr('nowrap', 'nowrap');
                // $(this).find('td').addClass('text-center');
            });
        },
        // "fnCreatedRow": function (row, data, index) {
        //     $('td', row).eq(0).html("<div class='col-md-12 text-center'>"+(index + 1)+"</div>");
        // },
        "drawCallback": function (settings) {
            $('#table_inv tbody tr').each(function () {
                $(this).find('td').attr('nowrap', 'nowrap');
            });
        },
        "columns": [{
            mRender: function (data, type, full) {
                a = "<div hidden class='col-md-12 text-center'>";
                a += "-";
                a += "</div>";
                return a;
            }
        }, {
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += (full.MATNO);
                a += "</div>";
                return a;
            }
        }, {
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += (full.MAKTX);
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
        }, {
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.MEINS;
                a += "</div>";
                return a;
            }
        }, {
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center' style='color: red;'>";
                if (full.KODE_UPDATE == 510){
                    a += 'Harian';
                } else if (full.KODE_UPDATE == 511){
                    a += 'Perbulan';
                } else {
                    a += 'Perminggu';
                }
                a += "</div>";
                return a;
            }
        }, {
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.STATUS;
                a += "</div>";
                return a;
            }
        }, {
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>" +
                    // '<a href="javascript:void(0)" data-toggle="modal" data-target="#modalDetil" data-vendorno="' + (full.NOMERPO) + '" data-curr="' + (full.CURR) + '" data-ven="' + (full.VENDORNO) + '"><span title="Detail PO" class="glyphicon glyphicon-list-alt" aria-hidden="true"></span></a>&nbsp;&nbsp;' +
                    '<a href="javascript:void(0)" data-toggle="modal" data-target="#modalDetail" data-vendorno="' + (full.VENDORNO) + '" data-matno="' + (full.MATNO) + '"><span title="Tracking" class="glyphicon glyphicon-search" aria-hidden="true"></span></a>' +
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
}

function approve(KODE) {
    bootbox.confirm('Konfirmasi Approve Assign?', function (result) {
        if (result)
            window.location.href = $("#base-url").val() + 'EC_Publish_Approval/approve/' + KODE
    });
}

function reject(KODE) {
    bootbox.confirm('Konfirmasi Reject Assign?', function (result) {
        if (result)
            window.location.href = $("#base-url").val() + 'EC_Publish_Approval/reject/' + KODE
    });
}

$('#modalDetail').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget)
    var vendorno = button.data('vendorno')
    var matno = button.data('matno')
    console.log(vendorno + ' ' + matno)

    $.ajax({
        url: $("#base-url").val() + 'EC_Report_pengadaan/getDetail_approval/',
        type: 'POST',
        data:{
            'vendorno': vendorno,
            'matno': matno
        },
        dataType: 'json'
    }).done(function (data) {
        var teks = ""
        $("#bodyTableHistory").empty()
        for (var i = 0; i < data.length; i++) {
            teks += "<tr>";
            teks += "<td class=\"text-center\">" + (i + 1) + "</td>";
            teks += "<td class=\"text-center\">" + data[i]['LOG_DATE'] + "</td>"
            if (data[i]['LOG_ACTIVITY'] == 0){
                teks += "<td class=\"text-center\">Assign</td>"
            } else if (data[i]['LOG_ACTIVITY'] == 1){
                teks += "<td class=\"text-center\">Waiting for Approve</td>"
            } else if (data[i]['LOG_ACTIVITY'] == 2){
                teks += "<td class=\"text-center\">Approved</td>"
            } else if (data[i]['LOG_ACTIVITY'] == 3){
                teks += "<td class=\"text-center\">Rejected</td>"
            }
            teks += "<td class=\"text-center\">" + data[i]['FULLNAME'] + "</td>"
            teks += "</tr>"
        }
        $("#bodyTableHistory").html(teks)
    }).fail(function () {
        // console.log("error");
    }).always(function (data) {
        // console.log(data);

    });
});

function chkAll(elm, mode) {
    if ($(elm).is(":checked"))
        $('.' + mode).prop("checked", true);
    else
        $('.' + mode).prop("checked", false);
}

$('#modalDetil').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget)
    var pono = button.data('pono')
    var curr = button.data('curr')
    var ven = button.data('ven')

    $.ajax({
        url: $("#base-url").val() + 'EC_PO_PL_Approval/detail/' + pono,
        type: 'POST',
        dataType: 'json'
    }).done(function (data) {
        var teks = ""
        $("#bodyTableDetail").empty()
        for (var i = 0; i < data.length; i++) {
            teks += "<tr>";
            // teks += "<td class=\"text-center\">" + (i + 1) + "</td>";
            teks += "<td class=\"text-center\">" + data[i]['LINE_ITEM'] + "</td>"
            teks += "<td class=\"text-center\">" + data[i]['MATNO'] + "</td>"
            teks += "<td class=\"text-center\">" + data[i]['MAKTX'] + "</td>"
            teks += "<td class=\"text-center\">" + data[i]['QTY'] + "</td>"
            teks += "<td class=\"text-center\">" + data[i]['MEINS'] + "</td>"
            teks += "<td class=\"text-center\">" + numberWithCommas(data[i]['PRICE']) + "</td>"

            teks += "<td class=\"text-center\">" + numberWithCommas(data[i]['TOTAL']) + "</td>"
            teks += "<td class=\"text-center\">" + curr + "</td>"
            teks += "<td class=\"text-center\">" + data[i]['PLANT'] + "&mdash;" + data[i]['PLANT_NAME'] + "</td>"
            if(data[i]['FILE_KORIN']!= null){
                teks += "<td class=\"text-center\"><a target=\"_blank\" href="+$("#base-url").val()+"upload/EC_korin/"+data[i]['FILE_KORIN']+">View Dokumen</a></td>"
            }else{
                teks += "<td class=\"text-center\"> - </td>"
            }
            teks += "<td class=\"text-center\" style=\"color: red;\"><strong>" + addDays(data[i]['DELIVERY_TIME']) + "</strong></td>"
            teks += "<td class=\"text-center\"><a href=\"javascript:void(0)\" data-toggle=\"modal\" data-target=\"#modalHarga\" data-po="+ pono +" data-matno="+data[i]['MATNO']+" data-desc=\""+data[i]['MAKTX']+"\" data-ven="+ven+"><span title=\"Detail Harga Penawaran Vendor\" class=\"glyphicon glyphicon-list-alt\" aria-hidden=\"true\"></span></a></td>"
            teks += "</tr>"
        }
        $("#bodyTableDetail").html(teks)
    }).fail(function () {
        // console.log("error");
    }).always(function (data) {
        // console.log(data);

    });
});
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
var itemCheck = [];

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

    $('#approveItem').click(function () {
        $('.actionSelect').each(function () {
            var kode = $(this).data("kode");
            if ($(this).is(":checked")){
                if (itemCheck.indexOf($(this).data("kode")) == -1)
                    itemCheck.push(String($(this).data("kode")));
            }
        });
        dataKode = JSON.stringify(itemCheck);
        console.log(dataKode);
        console.log($('#base_url').val());
        if (itemCheck.length == 0){
            alert('Pilih itemnya terlebih dahulu');
        } else {
            urlHead = 'EC_Publish_Approval'
            $.ajax({
                url: 'EC_Publish_Approval/approve',
                type: 'POST',
                data: {
                    kode: dataKode
                }
            }).done(function (data) {
                console.log(urlHead);
                alert('Data Berhasil di Approve');
                location.reload();
            })
        }
    });

    $('#rejectItem').click(function () {
        $('.actionSelect').each(function () {
            var kode = $(this).data("kode");
            if ($(this).is(":checked")){
                if (itemCheck.indexOf($(this).data("kode")) == -1)
                    itemCheck.push(String($(this).data("kode")));
            }
        });
        dataKode = JSON.stringify(itemCheck);
        console.log(dataKode);
        if (itemCheck.length == 0){
            alert('Pilih itemnya terlebih dahulu');
        } else {
            urlHead = 'EC_Publish_Approval'
            $.ajax({
                url: 'EC_Publish_Approval/reject',
                type: 'POST',
                data: {
                    kode: dataKode
                }
            }).done(function (data) {
                console.log(urlHead);
                alert('Data telah di Reject');
                location.reload();
            })
        }
    });

});
