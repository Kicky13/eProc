var amountOLD = 0;
var total_amount = 0
$(document).ready(function() {
    $('.tab2').on('shown.bs.tab', function(e) {
        $("#create").hide();
    });

    $('.tab1').on('shown.bs.tab', function(e) {
        $("#create").show();
    });

    loadTable_invoice();
    //loadTableProposal();
    loadTable();

    $("#alasanreject").val('');
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

    $('.tgll .startDate').datepicker({
        format: "dd-mm-yyyy",
        autoclose: true,
        todayHighlight: true
    });
    var _sudahTampilPesan = $('#sudahTampilPesan').text();
    if(_sudahTampilPesan != '1'){
      var _tmpMessage = [
      'Faktur pajak dengan kode 030 agar diproses ke dalam E-Invoice paling lambat tanggal 5 bulan berikutnya setelah masa Faktur Pajak dibuat',
      'Kode Faktur Pajak selain 030 agar diproses kedalam E-Invoice paling lambat 3 bulan setelah masa Faktur Pajak dibuat',
      'Apabila terlambat potensi denda ditanggung rekanan'
      ];
      bootbox.alert(_tmpMessage.join('<br />'));
  }

});


function loadTable() {
    // no = 1;
    $('#tableMT').DataTable().destroy();
    $('#tableMT tbody').empty();
    mytable = $('#tableMT').DataTable({
        "bSort": true,
        "dom": 'rtpli',
        "deferRender": true,
        "colReorder": true,
        "pageLength": 25,
        // "fixedHeader" : true,
        // "scrollX" : true,
        // "lengthMenu" : [5, 10, 25, 50, 75, 100],
        "language": {
            "loadingRecords": "<center><b>Please wait - Updating and Loading Data List Contract...</b></center>"
        },
        "ajax": $("#base-url").val() + 'EC_Invoice_Management/get_data',

        "columnDefs": [{
            "searchable": false,
            "orderable": true,
            "targets": 0
        }],
        "fnInitComplete": function() {
            $('#tableMT tbody tr').each(function() {
                $(this).find('td').attr('nowrap', 'nowrap');
            });
        },
        "drawCallback": function(settings) {
            cnt = -1;
            $('#tableMT tbody tr').each(function() {
                $(this).find('td').attr('nowrap', 'nowrap');
            });
        },
        "columns": [{
            mRender: function(data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.GR_NO;
                a += "</div>";
                return a;
            }
        },{
            mRender: function(data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.RR_NO;
                a += "</div>";
                return a;
            }
        },{
            mRender: function(data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.GR_ITEM_NO;
                a += "</div>";
                return a;
            }
        }, {
            mRender: function(data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.CREATE_ON.substring(6) + '/' + full.CREATE_ON.substring(4, 6) + '/' + full.CREATE_ON.substring(0, 4);
                a += "</div>";
                return a;
            }
        }, {
            mRender: function(data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.GR_DATE.substring(6) + '/' + full.GR_DATE.substring(4, 6) + '/' + full.GR_DATE.substring(0, 4);
                a += "</div>";
                return a;
            }
        }, {
            mRender: function(data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.DESCRIPTION == null ? "-" : full.DESCRIPTION;
                a += "</div>";
                return a;
            }
        }, {
            mRender: function(data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += number_format(full.AVAILABLE_QTY, 2, ',', '.');
                a += " <a href='#' data-qtyasli='"+number_format(full.AVAILABLE_QTY, 2, ',', '.')+"' data-qtybaru='"+number_format(full.AVAILABLE_QTY, 2, ',', '.')+"' onclick='updateQty(this)'><i class='glyphicon glyphicon-pencil'></i></a>";
                a += "</div>";
                return a;
            }
        }, {
            mRender: function(data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.GR_ITEM_UNIT == null ? "-" : full.GR_ITEM_UNIT;
                a += "</div>";
                return a;
            }
        }, {
            mRender: function(data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += numberWithCommas(full.GR_AMOUNT_IN_DOC * (full.AVAILABLE_QTY /full.GR_ITEM_QTY));
                a += "</div>";
                return a;
            }
        }, {
            mRender: function(data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.GR_CURR == null || full.GR_CURR == 'null' ? "-" : full.GR_CURR;
                a += "</div>";
                return a;
            }
        }, {
            mRender: function(data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.PO_NO;
                a += "</div>";
                return a;
            }
        }, {
            mRender: function(data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.PO_ITEM_NO;
                a += "</div>";
                return a;
            }
        }, {
            mRender: function(data, type, full) {
                var val = full.LOT_NUMBER == null ? '-' : full.LOT_NUMBER;

                a = "<div class='col-md-12 text-center'>";
                a += val;
                a += "</div>";
                return a;
            }
        },{
            mRender: function(data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                // onchange="ckbk(this,\'' + full.GR_NO + '\',\'' + full.GR_ITEM_NO + '\')"
                a += '<input type="checkbox"class="lot'+full.LOT_NUMBER+'" onclick="cekGRSelected(this)" class="ckb" value="' + full.PO_NO + '" data-curr="' + full.GR_CURR + '"  data-gr="' + full.GR_NO + '" data-amount="' + full.GR_AMOUNT_IN_DOC + '" data-grl="' + full.GR_ITEM_NO + '" data-tahun="' + full.GR_YEAR + '" data-uom="' + full.GR_ITEM_UNIT + '" data-item_qty="' + full.AVAILABLE_QTY + '" data-av_qty="' + full.AVAILABLE_QTY + '" data-qtyasli="' + full.GR_ITEM_QTY +'" data-po_item_no="' + full.PO_ITEM_NO + '"data-no_ba="' + full.NO_BA + '" ';
                a += 'data-norr="'+full.RR_NO+'" data-grdate="' + full.CREATE_ON + '"  data-grposting="' + full.GR_DATE + '" data-description="' + full.DESCRIPTION + '" data-item_cat="' + full.TYPE_TRANSAKSI + '" data-lot_number="' + full.LOT_NUMBER + '"  data-print_type="' + full.PRINT_TYPE + '"';
                // '
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

var cnt = 1;

function loadTable_invoice() {
    no = 1;
    $('#table_inv').DataTable().destroy();
    $('#table_inv tbody').empty();
    mytable_inv = $('#table_inv').DataTable({
        "bSort": true,
        "dom": 'rtpli',
        "deferRender": true,
        "colReorder": true,
        "pageLength": 25,
        // "fixedHeader" : true,
        // "scrollX" : true,
        // "lengthMenu" : [5, 10, 25, 50, 75, 100],
        "language": {
            "loadingRecords": "<center><b>Please wait - Updating and Loading Data List Contract...</b></center>"
        },
        "ajax": $("#base-url").val() + 'EC_Invoice_Management/get_data_invoice',

        "columnDefs": [{
            "searchable": false,
            "orderable": true,
            "targets": 0
        }],
        // "order": [[ 1, 'asc' ]],
        "fnInitComplete": function() {
            $('#table_inv tbody tr').each(function() {
                $(this).find('td').attr('nowrap', 'nowrap');
            });
        },
        "drawCallback": function(settings) {
            $('#table_inv tbody tr').each(function() {
                $(this).find('td').attr('nowrap', 'nowrap');
            });
            $(".onoff").bootstrapSwitch({
                "size": 'mini',
                "offText": 'Draft',
                "onText": 'Published',
                "onSwitchChange": function(event, state) {
                    console.log(state)
                    draftChg($(this).val(), state ? "1" : "0")
                }
            });

        },
        "columns": [{
            mRender: function(data, type, full) {
                a = "<div class='col-md-12 text-center ds'>";
                a += full.NO;
                a += "</div>";
                return a;
            }
        }, {
            mRender: function(data, type, full) {
                a = "<div class='col-md-12 text-center '>";
                a += full.INVOICE_DATE;
                a += "</div>";
                return a;
            }
        }, {
            mRender: function(data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.NO_INVOICE;
                a += "</div>";
                return a;
            }
        }, {
            mRender: function(data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.NO_SP_PO;
                a += "</div>";
                return a;
            }
        },
        {
         mRender: function(data, type, full) {
             a = "<div class='col-md-12 text-center'>";
             a += full.FI_NUMBER_SAP;
             a += "</div>";
             return a;
         }
     }, {
        mRender: function(data, type, full) {
            a = "<div class='col-md-12 text-center'>";
            a += full.CURRENCY + " <strong>" + numberWithCommas(full.BASE_AMOUNT) + "</strong>";
            a += "</div>";
            return a;
        }
    }, {
        mRender: function(data, type, full) {
            a = "<div class='col-md-12 text-center'>";
            a += full.CHDATE;
            a += "</div>";
            return a;
        }
    }, {
        mRender: function(data, type, full) {
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
        mRender: function(data, type, full) {
            a = "<div class='col-md-12 text-center'>";
            a += full.POSISI;
            a += "</div>";
            return a;
        }
    },{
        mRender: function(data, type, full) {
            a = "<div class='col-md-12 text-center'>";
            a += full.STATUS_DOC;
            a += "</div>";
            return a;
        }
    },  {
        mRender: function(data, type, full) {
            a = "<div class='col-md-12 '>";
            a += "<a href='" + $("#base-url").val() + "EC_Invoice_Management/detail/" + full.ID_INVOICE + "/" + full.STATUS_HEADER + "' title='View / Edit Invoice'><span class='glyphicon glyphicon-list-alt' aria-hidden='true'></span></a>&nbsp;&nbsp;";
            if (full.STATUS_HEADER == '1') {
                a += "<a href=\"javascript:deleteInv(this," + full.ID_INVOICE + ")\" title='Hapus Invoice'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></a>&nbsp;&nbsp;"
                a += "<a href=\"javascript:setStatus(this," + full.ID_INVOICE + ",2)\" title='Submit Invoice'><span class='glyphicon glyphicon-share-alt' aria-hidden='true'></span></a>&nbsp;&nbsp;"
            } else if (full.STATUS_HEADER == '2') {

            } else if (full.STATUS_HEADER == '3') {
                if (full.STATUS_DOC == 'BELUM KIRIM' && full.POSISI == 'VENDOR') {
                    a += "<a href='#' data-invoice='" + full.ID_INVOICE + "' onclick='kirimDokumen(this)' title='Kirim Dokumen'><span class='glyphicon glyphicon-share' aria-hidden='true'></span></a>&nbsp;&nbsp;"
                }
                if (full.STATUS_DOC == 'KIRIM' && full.POSISI == 'EKSPEDISI') {
                    a += "<a href='EC_Invoice_Management/cetakDokumenEkspedisi/" + full.ID_INVOICE + "' target='_blank' data-invoice='" + full.ID_INVOICE + "' title='Cetak Dokumen'><span class='glyphicon glyphicon-print' aria-hidden='true'></span></a>&nbsp;&nbsp;"
                }
                if (full.STATUS_DOC == 'RETUR' && full.POSISI == 'EKSPEDISI') {
                    a += "<a href='#' data-proses='terima_retur' data-invoice='" + full.ID_INVOICE + "' onclick='terimaDokumen(this)' title='Terima Dokumen'><span class='glyphicon glyphicon-check' aria-hidden='true'></span></a>&nbsp;&nbsp;"
                }
                if (full.STATUS_DOC == 'TERIMA' && full.POSISI == 'VENDOR') {
                    a += "<a href='#' data-invoice='" + full.ID_INVOICE + "' data-status='kirimUlang' onclick='kirimDokumen(this)' title='Kirim Ulang Dokumen'><span class='glyphicon glyphicon-share' aria-hidden='true'></span></a>&nbsp;&nbsp;"
                }
            } else if (full.STATUS_HEADER == '4') {
                a += "<a href=\"javascript:deleteInv(this," + full.ID_INVOICE + ")\" title='Hapus Invoice'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></a>&nbsp;&nbsp;"
                a += "<a href=\"javascript:setStatus(this," + full.ID_INVOICE + ",2)\" title='Submit Invoice'><span class='glyphicon glyphicon-share-alt' aria-hidden='true'></span></a>&nbsp;&nbsp;"
            } else if (full.STATUS_HEADER == '5') {

            } else if (full.STATUS_HEADER == '6') {

            }
            a += "<a href='javascript:void(0)' data-toggle=\"modal\" data-id_invoice='" + full.ID_INVOICE + "' data-target=\"#modalTracking\" title='History Invoice'><span class='glyphicon glyphicon-search' aria-hidden='true'></span></a>"
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

$('#table_inv').find("th").off("click.DT");
$('.ts0').on('dblclick', function() {
    if (t0) {
        mytable_inv.order([0, 'asc']).draw();
        t0 = false;
    } else {
        mytable_inv.order([0, 'desc']).draw();
        t0 = true;
    }
});
$('.ts1').on('dblclick', function() {
    if (t1) {
        mytable_inv.order([1, 'asc']).draw();
        t1 = false;
    } else {
        mytable_inv.order([1, 'desc']).draw();
        t1 = true;
    }
});
$('.ts2').on('dblclick', function() {
    if (t2) {
        mytable_inv.order([2, 'asc']).draw();
        t2 = false;
    } else {
        mytable_inv.order([2, 'desc']).draw();
        t2 = true;
    }
});
$('.ts3').on('dblclick', function() {
    if (t3) {
        mytable_inv.order([3, 'asc']).draw();
        t3 = false;
    } else {
        mytable_inv.order([3, 'desc']).draw();
        t3 = true;
    }
});
$('.ts4').on('dbldblclick', function() {
    if (t4) {
        mytable_inv.order([4, 'asc']).draw();
        t4 = false;
    } else {
        mytable_inv.order([4, 'desc']).draw();
        t4 = true;
    }
});
$('.ts5').on('dblclick', function() {
    if (t5) {
        mytable_inv.order([5, 'asc']).draw();
        t5 = false;
    } else {
        mytable_inv.order([5, 'desc']).draw();
        t5 = true;
    }
});
$('.ts6').on('dblclick', function() {
    if (t6) {
        mytable_inv.order([6, 'asc']).draw();
        t6 = false;
    } else {
        mytable_inv.order([6, 'desc']).draw();
        t6 = true;
    }
});
$('.ts7').on('dblclick', function() {
    if (t7) {
        mytable_inv.order([7, 'asc']).draw();
        t7 = false;
    } else {
        mytable_inv.order([7, 'desc']).draw();
        t7 = true;
    }
});
$('.ts8').on('dblclick', function() {
    if (t8) {
        mytable_inv.order([8, 'asc']).draw();
        t8 = false;
    } else {
        mytable_inv.order([8, 'desc']).draw();
        t8 = true;
    }
});
$('.ts9').on('dblclick', function() {
    if (t9) {
        mytable_inv.order([9, 'asc']).draw();
        t9 = false;
    } else {
        mytable_inv.order([9, 'desc']).draw();
        t9 = true;
    }
});
    /*$('.ts10').on('dblclick', function() {
     if (t10) {
     mytable_inv.order([10, 'asc']).draw();
     t10 = false;
     } else {
     mytable_inv.order([10, 'desc']).draw();
     t10 = true;
     }
 });*/
}

var base_url = $("#base-url").val(),
manufacturer,
partner,
matgroup,
t0 = true,
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
t16 = true,
t17 = true,
t18 = true,
t19 = true,
t20 = true,
t21 = true,
clicks = 0,
timer = null;
var t = [t0, t1, t2, t3, t4, t5, t6, t7, t8, t9, t10, t11, t12, t13, t14, t15, t16, t17, t18, t19, t20, t21]

function setStatus(elm, idinv, stat) {
    if (confirm("Anda yakin?"))
        $.ajax({
            url: $("#base-url").val() + 'EC_Invoice_Management/update_invoice/' + idinv + '/' + stat,
            type: 'POST',
            dataType: 'json'
        }).done(function(data) {
          //  console.log(data)
          location.reload()
      }).fail(function() {
            // console.log("error");
        }).always(function(data) {
            // console.log(data);

        });
    }

    function deleteInv(elm, idinv) {
        if (confirm("Anda yakin?"))
            $.ajax({
                url: $("#base-url").val() + 'EC_Invoice_Management/delete_invoice/' + idinv,
                type: 'POST',
                dataType: 'json'
            }).done(function(data) {
        //    console.log(data)
        location.reload()
    }).fail(function() {
            // console.log("error");
        }).always(function(data) {
            // console.log(data);

        });
    }

    $('#modalTracking').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var Invoince = button.data('id_invoice')

        $.ajax({
            url: $("#base-url").val() + 'EC_Invoice_Management/tracking/' + Invoince,
            type: 'POST',
            dataType: 'json'
        }).done(function(data) {
            var teks = ""
            $("#bodyTableTrack").empty()
            //1->Draft,2->Submited,3->Approved,4->Rejected,5->Posted,6->Paid,9->Delete
            var _status_track = {
                1: 'DRAFT',
                2: 'SUBMITTED',
                3: 'APPROVED',
                4: 'REJECTED',
                5: 'POSTED',
                6: 'PAID'
            };

            for (var i = 0; i < data.length; i++) {
                teks += "<tr>";
                teks += "<td class=\"text-center\">" + (i + 1) + "</td>";
                teks += "<td class=\"text-center\">" + data[i]['TRACK_DATE'] + "</td>"
                teks += "<td class=\"text-center\">" + _status_track[data[i]['STATUS_TRACK']] + "</td>"

                ket = '';
                if(_status_track[data[i]['STATUS_TRACK']]!='DRAFT'&&_status_track[data[i]['STATUS_TRACK']]!='SUBMITTED'){
                    if(data[i]['POSISI']=='VENDOR' && data[i]['STATUS_DOC']=='BELUM KIRIM') ket = 'APPROVE-1';
                    else if(data[i]['POSISI']=='EKSPEDISI' && data[i]['STATUS_DOC']=='KIRIM') ket = 'APPROVE-2';
                    else if(data[i]['POSISI']=='VERIFIKASI' && data[i]['STATUS_DOC']=='TERIMA') ket = 'APPROVE-3';
                    else if(data[i]['POSISI']=='VERIFIKASI' && data[i]['STATUS_DOC']=='BELUM KIRIM') ket = 'POSTED-1';
                    else if(data[i]['POSISI']=='VERIFIKASI' && data[i]['STATUS_DOC']=='KIRIM') ket = 'POSTED-2';
                    else if(data[i]['POSISI']=='BENDAHARA' && data[i]['STATUS_DOC']=='TERIMA') ket = 'POSTED-3';
                }

                teks += "<td class=\"text-center\">" + ket + "</td>"
                
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
    $('#pajak').on('change', function(e) {
        var optionSelected = $("option:selected", this);
        var pajak = (parseInt(optionSelected.data('pajak')) / 100) * parseInt(amountOLD);
    //console.log(pajak)
    $("#totalAmount").val(numberWithCommas(parseInt(amountOLD) + pajak))
    $("#total").val(parseInt(amountOLD) + pajak)
});

    var countDenda = 0;

    function addDenda(elm) {
        var _form_group = $(elm).closest('.form-group');
        var _bb = $(elm).closest('.bootbox-body');
        var _tbody = _bb.find('#tbody-denda');
        var teks = '';
        var _idDenda = _form_group.find('select');
    // var _nominal_masked = _form_group.find('input[name=Nominal]').val().replace(/\s/g, '');

    var _nominal = _form_group.find('input[name=Nominal]').unmask();
    var _numberPattern = /\d+/g;
    var _fileDendaAkhir = _tbody.find('input[name^=fileDenda]:last');
    var _urutanTerakhir = 0;
    if (_fileDendaAkhir.length > 0) {
        var _namaFileTerakhir = _fileDendaAkhir.attr('name');
        var _noUrut = _namaFileTerakhir.match(_numberPattern);
        _urutanTerakhir = _noUrut[0];
    }
    _urutanTerakhir = parseInt(_urutanTerakhir) + 1;
    if (!isNaN(_nominal)) {
        var _idDendaExist = _tbody.find('input[name^=idDenda]');
        var _listDenda = {};
        _idDendaExist.each(function() {
            _listDenda[$(this).val()] = $(this).val();
        });
        if (_listDenda[_idDenda.val()] !== undefined) {
            bootbox.alert('Denda sudah ada');
        } else {
            if (_nominal > 0) {
                teks = '<tr id="ke' + countDenda + '" class="dnd">';
                teks += '<td class="text-center">' + _idDenda.find('option:selected').text() + '<input type="hidden" value="' + _idDenda.val() + '" name="idDenda[]"></td>';
                teks += '<td class="text-center">' + numberWithCommas(_nominal) + '<input type="hidden" value="' + _nominal + '" name="Nominal[]"></td>';
                teks += '<td class="text-center"><input type="file" required name="fileDenda' + _urutanTerakhir + '" onchange="validasiUpload(this)" /></td>';
                teks += '<td class="text-center"><a href="#" onclick="hapusBarisDenda(this)"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></td></tr>';
                $(teks).appendTo(_tbody);

                _form_group.find('input[name=Nominal]').val('');
                $("#jmlDenda").val($(".dnd").length);
                countDenda++;
                hitungAmount(_form_group);
            } else {
                bootbox.alert('Nominal harus lebih besar dari 0');
            }

        }
    } else {
        bootbox.alert('Nominal harus angka');
    }

}

function hapuss(tbl, ke, jml) {
    $('.' + tbl).find("tr#ke" + ke).remove();
    if (jml != 0) {
        $("#totalAmount").val(numberWithCommas(parseInt($("#total").val()) + jml));
        $("#total").val(parseInt($("#total").val()) + jml);
    }
    // $(elm).parent().parent().remove()
}

function hapusBarisDenda(elm) {
    var row = $(elm).closest('td').closest('tr');
    var _form_group = row.closest('table').closest('.form-group');
    row.remove();
    hitungAmount(_form_group);
}

function addDoc(elm) {
    var _form_group = $(elm).closest('.form-group');
    var _tbody = $(elm).closest('.bootbox-body').find('#tbody-doc');
    var _idDocExist = _tbody.find('input[name^=idDoc]');
    var _numberPattern = /\d+/g;
    var _fileDocAkhir = _tbody.find('input[name^=fileDoc]:last');
    var _urutanTerakhir = 0;
    if (_fileDocAkhir.length > 0) {
        var _namaFileTerakhir = _fileDocAkhir.attr('name');
        var _noUrut = _namaFileTerakhir.match(_numberPattern);
        _urutanTerakhir = _noUrut[0];
    }
    _urutanTerakhir = parseInt(_urutanTerakhir) + 1;
    var _listDoc = {};
    _idDocExist.each(function() {
        _listDoc[$(this).val()] = $(this).val();
    });

    var _idDoc = _form_group.find('select');
    var _noDoc = _form_group.find('input[name=Nomor_Dokumen]');
    if (_listDoc[_idDoc.val()] !== undefined) {
        bootbox.alert('Dokumen sudah ada');
    } else {
        teks = '<tr id="ke' + countDenda + '" class="dc">';
        teks += '<td class="text-center">' + _idDoc.find('option:selected').text() + '<input type="hidden" value="' + _idDoc.val() + '" name="idDoc[]"></td>';
        teks += '<td class="text-center">' + (_noDoc.val()) + '<input type="hidden" value="' + _noDoc.val() + '" name="noDoc[]"></td>';
        teks += '<td class="text-center"><input required type="file" name="fileDoc' + _urutanTerakhir + '" onchange="validasiUpload(this)" /></td>';
        teks += '<td class="text-center"><a href="#" onclick="hapusRow(this)"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></td></tr>';

        $(teks).appendTo(_tbody);
        _noDoc.val('');
        $("#jmlDoc").val($(".dc").length);
        hitungAmount(_form_group);
    }

}

function hapusRow(elm) {
    $(elm).closest('td').closest('tr').remove();
}

function kirimDokumen(elm) {
    var id_invoice = $(elm).data('invoice');
    var status = $(elm).data('status') || '';
    var url = $("#base-url").val() + 'EC_Invoice_Management/listDokumen';
    $.get(url, {
        invoice: id_invoice,
        status: status
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

function terimaDokumen(elm) {
    var id_invoice = $(elm).data('invoice');
    var _proses = $(elm).data('proses');
    var url = $("#base-url").val() + 'EC_Invoice_Management/listDokumen';
    $.get(url, {
        invoice: id_invoice,
        proses: _proses
    }, function(html) {
        bootbox.dialog({
            title: 'Proses Terima Dokumen Dari Retur Ekspedisi',
            message: html,
            className: 'bb-alternate-modal',
            callback: function() {

            }
        });
    }, 'html');
}

function kirimDokumenReject(elm){
    /* pastikan semua checkbox sudah dipilih */
    var _table = $(elm).closest('table');
    var _tbody = _table.find('tbody');
    var _ld = _tbody.find('input:checked');
    var _totalDoc = _tbody.find('tr').length - 1;
    var _invoice = $(elm).data('invoice');
    var _proses = $(elm).data('proses');

    //alert (_proses + "XXX");
    //$(elm).hide();
    if (_ld.length == _totalDoc) {
        var _url = $("#base-url").val() + 'EC_Invoice_Management/updatePosisiDokumen';

        bootbox.prompt({
            title: "Catatan untuk Verifikator",
            inputType: 'textarea',
            callback: function (result) {
                //var alasan = result;
                //console.log(result);
                if(result){var _url = $("#base-url").val() +'EC_Invoice_Management/updatePosisiDokumen';
                $.post(_url,{invoice : _invoice, catatan_vendor: result},function(data){
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

function SubmitDokumen(elm) {
    /* pastikan semua checkbox sudah dipilih */
    var _table = $(elm).closest('table');
    var _tbody = _table.find('tbody');
    var _ld = _tbody.find('input:checked');
    var _totalDoc = _tbody.find('tr').length - 1;
    var _invoice = $(elm).data('invoice');
    var _proses = $(elm).data('proses');
    $(elm).hide();
    if (_ld.length == _totalDoc) {
        var _url = $("#base-url").val() + 'EC_Invoice_Management/updatePosisiDokumen';
        $.post(_url, {
            invoice: _invoice,
            proses: _proses
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

function cekGRSelected(elm) {
    /* pastikan nomer PO dan item_cat sama */
    var ini = $(elm);
    var table = ini.closest('table');

    var _ln = ini.data('lot_number');

    var _ck = mytable.rows().nodes().to$().find(':checkbox:checked').not(ini);
    var _op, _ic;

    if (ini.is(':checked')) {
        if (_ck.length) {
            _op = _ck.eq(0).val();
            _ic = _ck.eq(0).data('item_cat');

            var _valid = 1,
            _pesan = [];
            if (ini.val() != _op) {
                _valid = 0;
                _pesan.push('Nomer PO tidak sama');
            }
            if (ini.data('item_cat') != _ic) {
                _valid = 0;
                _pesan.push('Jenis PO tidak sama');
            }
            if (!_valid) {
                ini.prop('checked', 0);
                bootbox.alert({
                    title: 'Warning ....',
                    message: _pesan.join(' '),
                    callback: function() {}
                })

                if(_ln != null){
                    mytable.rows().nodes().to$().find('.lot'+_ln).prop('checked', false);
                }
            }

        }else{
            if(_ln != null){
                mytable.rows().nodes().to$().find('.lot'+_ln).prop('checked', true);
            }
        }
    }else{
        if(_ln != null){
            mytable.rows().nodes().to$().find('.lot'+_ln).prop('checked', false);
        }
    }
}

function createInvoice(elm) {
    var grTerpilih = mytable.rows().nodes().to$().find(':checkbox:checked');
    var arrGR = [];

    if (grTerpilih.length) {
        var jumlah = 0,no_po, curr, gr, itemCat,no_rr = {}, _tmpgr, _tmprr,_cariBapp = [],rr_ref_fp=[],_no_ba=[],print_type,lot_tan=[];
        curr = grTerpilih.eq(0).data('curr');
        itemCat = grTerpilih.eq(0).data('item_cat');
        no_po = grTerpilih.eq(0).val();

        var _lot_no = grTerpilih.eq(0).data('lot_number');                        
        grTerpilih.each(function() {
            _tmpgr = $(this).data('gr');
            _tmprr = $(this).data('norr');
            _templt = $(this).data('lot_number');
            print_type = $(this).data('print_type');
            var temp_ba = $(this).data('no_ba');            

            if(temp_ba!=null){_no_ba.push(temp_ba);}

            rr_ref_fp.push(_tmprr);                      
            if(lot_tan!=_templt){
                lot_tan.push(_templt);
            }           
            var base_qty = $(this).data('qtyasli'); // Quantity Total
            var available = $(this).attr('data-av_qty'); // Quantity yang Tersedia
            var cur_qty = $(this).attr('data-item_qty'); // Quantity yang akan diinvoicekan

            var base_amount = $(this).data('amount'); // Amount Total

            var cur_amount = base_amount * (cur_qty/base_qty); // Amount yang Akan diinvoicekan

            var check_qty = available == cur_qty ? 1 : 0; // Cek Ketersediaan Quantity untuk diinvoicekan lagi
            var check_first_inv = base_qty == available ? 1 : 0;

            gr = $(this).data('gr') + '#' + $(this).data('grl') + '#' + $(this).data('tahun') + '#' + $(this).val() + '#';
            gr += $(this).data('po_item_no') + '#' + $(this).data('curr') + '#' + cur_amount + '#' + $(this).data('uom') + '#' + $(this).data('item_qty');
            gr += '#' + $(this).data('grdate') + '#' + $(this).data('grposting') + '#' + $(this).data('description')+ '#' + check_qty+ '#' + check_first_inv;

            arrGR.push(gr);


            /* no_gr#gr_item_no#tahun#po#po_item_no#curr#amount#uom#item_qty#grdate#grposting#description
            gr = $(this).data('gr') + '#' + $(this).data('grl') + '#' + $(this).data('tahun') + '#' + $(this).val() + '#' + $(this).data('po_item_no') + '#' + $(this).data('curr') + '#' + $(this).data('amount') + '#' + $(this).data('uom') + '#' + $(this).data('item_qty');
            gr += '#' + $(this).data('grdate') + '#' + $(this).data('grposting') + '#' + $(this).data('description');

            arrGR.push(gr);*/

          //  itemCat = '1'; /* nanti harus dikomentar */
          if(!empty(_tmprr) && itemCat != '9'){ /* jika jasa maka tidak perlu ditampilkan nomer RR */
              if(no_rr[_tmprr] == undefined){
                no_rr[_tmprr] = _tmprr;
            }
        }

        if(!empty(_tmprr) && itemCat == '9'){
          _cariBapp.push({gr_no : $(this).data('gr'), gr_item_no : $(this).data('grl'),gr_year : $(this).data('tahun'), po_no : no_po, po_item :$(this).data('po_item_no') });
      }
      /* dinullkan dulu, nanti dihapus jika gr online sudah diupload */
      if(_templt == null){
        no_rr = [];
    }
    jumlah += parseInt($(this).data('amount'));
});



        bootbox.dialog({
            title: 'Create Invoice No. PO ' + no_po,
            message: $('#divCreateInvoice').html(),
            className: 'mediumWidth',
            callback: function() {}
        }).on('shown.bs.modal', function(e) {
            $(this).find('.tgll .startDate').datepicker({
                format: "dd-mm-yyyy",
                autoclose: true,
                todayHighlight: true
            });
            $(this).find("input[name=sppo_no]").val(no_po);
            $(this).find("#arrGR").val(arrGR.join('&@'));
            //$(this).find("#arrGRL").val(arrGRL);
            $(this).find("#itemCat").val(itemCat);
            $(this).find("#curr").val(curr);
            $(this).find("#totalview").val(numberWithCommas(jumlah));
            $(this).find("#totalview").data('baseamount', jumlah);
            $(this).find("#base_amount").val(jumlah);
            $(this).find("#totalAmount").val(numberWithCommas(jumlah));
            $(this).find("#total").val(jumlah);

            var url_check_ref_fp = $('#base-url').val() + 'EC_Invoice_Management/getRefFP';
            var list_gr = rr_ref_fp.join(',');
            var _formModal = $(this);
            $.post(url_check_ref_fp,{datagr : list_gr},function(data){
                if(data.status){
                    _formModal.find('#ref_faktur').val(data.ref_fp);
                    _formModal.find('#ref_fp').removeClass('hide');
                    _formModal.find('#link_ref_fp').html(data.url_fp);
                    _formModal.find('#pajak').val('VZ');
                }else{
                    _formModal.find('#ref_fp').addClass('hide');
                    _formModal.find('#pajak').val('');
                    _formModal.find('#link_ref_fp').html('');
                }
            },'json');

            /* jika ditemukan no_rr set otomatis no_rr di bast_no dan hapus rubah field fileBast menjadi tipe hidden */
            if(!empty(no_rr)){
              var _rr_tmp = [], _link = [],_url, _typeDocument;
              _typeDocument = itemCat == '9' ? 'BAST' : 'RR';
              _url = $("#base-url").val() + 'EC_Invoice_Management/showDocument';

              for(var i in no_rr){
                _rr_tmp.push(i);
                _link.push('<div class="link"><a href="#" data-nopo="'+no_po+'" data-tipe="'+_typeDocument+'" data-iddokumen="'+i+'" data-url="'+_url+'" onclick="return showDocument(this)">'+i+'</a></div>');
            }             
            if(_lot_no != null ){
              _link = [];

              var uniqueLot = lot_tan.filter(function(item, pos){
                return lot_tan.indexOf(item)== pos; 
            });

              for(var j in uniqueLot){                    
                _link.push('<div class="link"><a href="#" data-nopo="'+no_po+'" data-tipe="'+_typeDocument+'" data-iddokumen="'+lot_tan[j]+'" data-url="'+_url+'" data-print_type='+print_type+' onclick="return showDocument(this)"> Lot Number '+lot_tan[j]+'</a></div>');                                                    
            }
        }

        $(this).find('input[name=bast_no]').val(_rr_tmp.join(','));
        $(this).find(':file[name=fileBast]').replaceWith('<input type="hidden" name="fileBast" value="'+_rr_tmp.join(',')+'" />'+_link.join(''));
    }

    /* cari nomer bast atau bapp */
    if(!empty(_tmprr) && itemCat == '9'){
      var _bast_tmp = [], _linkBast = [];
      var _formBast = $(this);
      var _urlCariBapp = $("#base-url").val() + 'EC_Invoice_Management/cariBapp';
      $.post(_urlCariBapp,{listgr : _cariBapp},function(data){
        if(!empty(data.bast)){
          var _urlBast = '';
          for(var i in data.bast){
            _urlBast = $("#base-url").val() + 'EC_Vendor/Bast/cetak/'+data.bast[i]['ID'];
            _bast_tmp.push(data.bast[i]['NO_BAST']);
            _linkBast.push('<div class="link"><a href="'+_urlBast+'" target="_blank" data-nopo="'+no_po+'" data-tipe="'+_typeDocument+'" data-iddokumen="'+data.bast[i]['NO_BAST']+'" data-url="'+_url+'">'+data.bast[i]['NO_BAST']+'</a></div>');
        }
        _formBast.find('input[name=bast_no]').val(_bast_tmp.join(','));
        _formBast.find(':file[name=fileBast]').replaceWith('<input type="hidden" name="fileBast" value="'+_bast_tmp.join(',')+'" />'+_linkBast.join(''));
    }

    if(!empty(data.bapp)){
      var _linkBapp = [], _tmpBapp = [], _urlBapp;
      for(var i in data.bapp){
        _urlBapp = $("#base-url").val() + 'EC_Vendor/Bapp/cetak/'+data.bapp[i]['ID'];
        _tmpBapp.push(data.bapp[i]['NO_BAPP']);
        _linkBapp.push('<div class="link"><a href="'+_urlBapp+'" target="_blank" data-tipe="BAPP" data-iddokumen="'+data.bapp[i]['NO_BAPP']+'">'+data.bapp[i]['NO_BAPP']+'</a></div>');
    }
    _formBast.find('input[name=bapp_no]').val(_tmpBapp.join(','));
    _formBast.find(':file[name=fileBapp]').replaceWith('<input type="hidden" name="fileBapp" value="'+_tmpBapp.join(',')+'" />'+_linkBapp.join(''));
}
},'json');
  }

  /*Cari Berita Acara Analisa Potongan Mutu*/
  if(!empty(_no_ba)){

    var uniqueBA = _no_ba.filter(function(item, pos){
        return _no_ba.indexOf(item)== pos; 
    });

    var _form = $(this);
    _form.find('input[name=potmut_no]').val(uniqueBA.join(','));
    var _linkBA=[];

    for(var i in uniqueBA){
        _linkBA.push('<div class="link"><a href="#" data-no_ba="'+uniqueBA[i]+'" onclick="return showDocumentBA(this)">'+uniqueBA[i]+'</a></div>');
    }
    console.log(_linkBA);
    _form.find(':file[name=filePotMutu]').replaceWith('<input type="hidden" name="filePotMutu" value="'+uniqueBA.join(',')+'" />'+_linkBA.join(''));

}
/*Menambahkan Price Format*/
$(this).find('#Nominal').priceFormat({
    prefix: '',
    centsSeparator: ',',
    centsLimit: 0,
    thousandsSeparator: '.',
    clearOnEmpty: true,
});


/*VALIDASI MASUKAN*/
$('input,textarea').not('input[name=faktur_no]').alphanum({
    allow: './-,?'
});

/*VALIDASI FILE SIZE*/
$(':file').on('change', function() {
    var _size = this.files[0].size;
    var _type = this.files[0].type;
    var _error = 1;
    var _tipe = _type.split('/');
    var _tape = _tipe[_tipe.length - 1];

    switch (_tape) {
        case 'jpg':
        _error = 0;
        break;
        case 'jpeg':
        _error = 0;
        break;
        case 'png':
        _error = 0;
        break;
        case 'pdf':
        _error = 0;
        break;
    }

    if (_size > 4096000) {
        _error = 1;
    }

    if (_error == 1) {
        alert('Ukuran File Anda Lebih Besar Dari 4MB atau Tipe File Tidak Sesuai');
                    //$("input[name=fileInv]").html("File size is greater than 2MB");
                    //$('input[name=fileInv]').css("border-color","#FF0000");
                    $(this).val('');
                }

            });
var _form = $(this).find('form');
_form.submit(function(e){
    var currentForm = this;
    e.preventDefault();
    /* cek apakah ada errornya */
    var _error = 0;
    var _message = [];
    var _pajak = _form.find('select[name=pajak]').val();
    /* jika pajak */
    if(_pajak != 'VZ'){
      var _nomerPajak = _form.find('input[name=faktur_no]').val();
      var _tglFaktur = _form.find('input[name=FakturDate]').val();
      var _cekPajak = harusAngka(_nomerPajak,'nomer faktur',16);
      /* pastikan tgl faktur diisi */
      if(_tglFaktur == ''){
        _error++;
        _message.push('Tanggal faktur harus diisi');
    }
    if(!_cekPajak['status']){
        _error++;
        _message.push(_cekPajak['message']);
    }
    if(!_error){
        var _url = $("#base-url").val() + 'EC_Invoice_Management/validFakturPajak/';
        var _po = _form.find('input[name=sppo_no]').val();
        var _invoice_date = _form.find('input[name=invoice_date]').val();
        $.get(_url,{no_faktur : hanyaAngka(_nomerPajak), no_po : _po, invoice_date : _invoice_date},function(data){
          if(data.status){
            currentForm.submit();
        }else{
            bootbox.alert(data.message);
        }
    },'json');
    }else{
        bootbox.alert(_message.join(' '));
    }
    /* pastikan pajaknya valid di SAP */

}else{
  currentForm.submit();
}
});
});

} else {
    bootbox.alert('Tidak ada GR yang dipilih');
}

}

function setRequired(elm, nameElement) {
    var _ini = $(elm);
    var _form_group = _ini.closest('.form-group');
    var _file = _form_group.find('input[name=' + nameElement + ']');
    var _nilai = $.trim(_ini.val());
    if (_nilai.length) {
        _ini.prop('required', true);
        _file.prop('required', true);
    } else {
        _ini.prop('required', false);
        _file.prop('required', false);
    }
}

function setRequiredPajak(elm, nonPajak) {
    var _ini = $(elm);
    var _form_group = _ini.closest('.form-group');
    var _form = _form_group.closest('form');
    var _nilai = _ini.val();
    if (_nilai != nonPajak) {
        _ini.prop('required', true);
        _form.find('input[name=faktur_no]').prop('required', true);
        _form.find('input[name=FakturDate]').prop('required', true);
        _form.find('input[name=fileFaktur]').prop('required', true);
    } else {
        _ini.prop('required', false);
        _form.find('input[name=faktur_no]').prop('required', false);
        _form.find('input[name=FakturDate]').prop('required', false);
        _form.find('input[name=fileFaktur]').prop('required', false);
    }
    hitungAmount(_form_group);
}

function hitungAmount(elm) {
    var _form = $(elm).closest('form');
    /* baseAmount + PPn - totalDenda */
    var _baseAmount = _form.find('input[name=Amount]').data('baseamount');
    var _pajak = _form.find('select[name=pajak]').find('option:selected').data('pajak');
    var _denda = 0;
    var _nilaiPajak = _pajak * _baseAmount;
    _form.find('table.tableDenda tbody').find('input[name^=Nominal]').each(function() {
        _denda += parseInt($(this).val());
    });
    var _totalAmount = _baseAmount + _nilaiPajak - _denda;

    _form.find("#total").val(_totalAmount);
    _form.find("#totalAmount").val(numberWithCommas(_totalAmount));
}

function validasiUpload(elm) {

    var _size = $(elm).get(0).files[0].size;
    var _type = $(elm).get(0).files[0].type;
    var _error = 1;
    var _tipe = _type.split('/');
    var _tape = _tipe[_tipe.length - 1];

    switch (_tape) {
        case 'jpg':
        _error = 0;
        break;
        case 'jpeg':
        _error = 0;
        break;
        case 'png':
        _error = 0;
        break;
        case 'pdf':
        _error = 0;
        break;
    }

    if (_size > 4096000) {
        _error = 1;
    }

    if (_error == 1) {
        alert('Ukuran File Anda Lebih Besar Dari 4MB atau Tipe File Tidak Sesuai');
        $(elm).val('');
    }

};

function showDocument(elm){
  var url = $(elm).data('url');
  var data = {
    tipe : $(elm).data('tipe'),
    id : $(elm).data('iddokumen'),
    nopo : $(elm).data('nopo'),
    print_type : $(elm).data('print_type'),
    jenis : 'lot'
};
$.redirect(url,data,'POST','_blank');
return false;
}

function showDocumentBA(elm){
  var url = $('#base-url').val() + 'EC_Approval/Pomut/cetakBeritaAcara';
  var data = {
    no_ba : $(elm).data('no_ba')
};
$.redirect(url,data,'POST','_blank');
  //return false;
}

function updateQty(elm){
  var _td = $(elm).closest('td');
  var _tr = $(elm).closest('tr');
  var _checkbox = _tr.find('[type=checkbox]');

  var _qtyAsli = $(elm).data('qtyasli');
  var _qtyBaru = $(elm).data('qtybaru');

  var _message = [
  '<form class="form form-horizontal">',
  '<div class="form-group">',
  '<label for="costcenter" class="col-sm-3 control-label">Original Quantity</label>',
  '<div class="col-sm-6">',
  '<input type="text" class="form-control" name="qtyAsli" value="'+_qtyAsli+'" readonly>',
  '</div>',
  '</div>',
  '<div class="form-group">',
  '<label for="costcenter" class="col-sm-3 control-label">New Quantity</label>',
  '<div class="col-sm-6">',
  '<input type="text" class="form-control required" name="qtyUpdate" value="'+_qtyBaru+'" placeholder="Nilai quantity baru">',
  '</div>',
  '</div>',
  '<div class="form-group">',
  '<div class="col-sm-6 col-sm-offset-3">',
  '<button type="submit" class="btn btn-primary">Simpan</button>&nbsp;',
  '<span class="btn btn-danger" onclick="bootbox.hideAll()">Batal</span>',
  '</div>',
  '</div>',
  '</form>'
  ];
  bootbox.dialog({
      title: 'Change Quantity',
      message: _message.join(''),
      className: 'bb-alternate-modal',
      callback: function() {

      }
  }).on('shown.bs.modal',function(){
    $(this).find('form input').priceFormat({
        prefix: '',
        centsSeparator: ',',
        centsLimit : 2,
        thousandsSeparator: '.',
        clearOnEmpty : false,
    });

    $(this).find('form').submit(function(e){
      e.preventDefault();
      var _f = $(this);
      var _qtyBaruVal = _f.find('input[name=qtyUpdate]').val();
      var _qtyBaru = $('input[name=qtyUpdate]').val();//.unmask();
      var _qtyMax = $('input[name=qtyAsli]').val();//.unmask();
      var msg = '';
      var _error = 0;

      /* pastikan yang memiliki required sudah diisi */
      if(_qtyBaru <= 0){
        msg += "Nilai Qty Baru Harus > 0 <br>";
        _error++;
    }

    /*Ubah Format Menjadi Float*/
    _qtyBaru = parseFloat(_qtyBaru.replace(/\./g,'').replace(',','.'));
    _qtyMax = parseFloat(_qtyMax.replace(/\./g,'').replace(',','.'));

    /* pastikan nilai yang diinput <= nilai asli */
    if(_qtyBaru > _qtyMax){
        msg += "Nilai Qty Baru Tidak Boleh Lebih Dari ("+_qtyMax+")";
        _error++;
    }

    bootbox.hideAll();

    if(!_error){
        a = "<div class='col-md-12 text-center'>";
        a += _qtyBaruVal;
        a += " <a href='#' data-qtybaru='"+_qtyBaruVal+"' data-qtyasli='"+_qtyAsli+"' onclick='updateQty(this)'><i class='glyphicon glyphicon-pencil'></i></a>";
        a += "</div>";

        _checkbox.attr('data-item_qty',_qtyBaru);

        _td.html(a);
        msg = "Jumlah Qty Berhasil Diubah. Dari ("+_qtyAsli+") Menjadi ("+_qtyBaruVal+")";
    }

    bootbox.alert(msg);

});

});
}
