var arrGR = [],
    arrGRL = [],
    jumlahTotal = 0,
    PO = "";

function numberWithDot(x) {
    return x == null || x == "0" ? "" : x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

function removeCommas(x) {
    return x.replace(/,/g, "");
}

function removeDot(x) {
    return x.replace(/\./g, "");
}

function noTax(elm) {
    if ($(elm).is(":checked")) {
        $("#faktur").prop('disabled', true)
        $("#file_faktur").prop('disabled', true)
    } else {
        $("#faktur").prop('disabled', false)
        $("#file_faktur").prop('disabled', false)
    }
}

$(document).ready(function() {
    $('.tgll .startDate').datepicker({
        format: "dd/mm/yyyy",
        autoclose: true,
        todayHighlight: true
    });

    if ($("#status").val() != 1 && $("#status").val() != 4) {
        $("input").prop('disabled', true);
        $("select").prop('disabled', true);
        $("textarea").prop('disabled', true);
    }
    $('a:contains("File Attachment")').click(function(){
      $(this).css({'color' : 'blue'});
    });

    loadTable();
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

    setHrefPublic();
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
        "aaSorting": [],
        // "fixedHeader" : true,
        // "scrollX" : true,
        // "lengthMenu" : [5, 10, 25, 50, 75, 100],
        "language": {
            "loadingRecords": "<center><b>Please wait - Updating and Loading Data List Contract...</b></center>"
        },
        "ajax": $("#base-url").val() + 'EC_Invoice_Report/get_data_detail/' + $("#ID_INVOICE").val() + '/' + $("#VENDOR_NO").val()+ '/' + $("#STATUS").val(),

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
            PO = $('.ckb:checked:eq(0)').val()
            $('#tableMT tbody tr').each(function() {
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
                a = "<div class='col-md-12 text-center'>";
                a += full.GR_NO;
                a += "</div>";
                return a;
            }
        }, {
            mRender: function(data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.GR_ITEM_NO;
                a += "</div>";
                return a;
            }
        }, {
            mRender: function(data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.GRDATE.substring(6) + '/' + full.GRDATE.substring(4, 6) + '/' + full.GRDATE.substring(0, 4);
                a += "</div>";
                return a;
            }
        }, {
            mRender: function(data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.GRPOSTING.substring(6) + '/' + full.GRPOSTING.substring(4, 6) + '/' + full.GRPOSTING.substring(0, 4);
                a += "</div>";
                return a;
            }
        }, {
            mRender: function(data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.DESCRIPTION;
                a += "</div>";
                return a;
            }
        }, {
            mRender: function(data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.GR_ITEM_QTY;
                a += "</div>";
                return a;
            }
        }, {
            mRender: function(data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.GR_ITEM_UNIT;
                a += "</div>";
                return a;
            }
        }, {
            mRender: function(data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += numberWithCommas(full.GR_AMOUNT_IN_DOC);
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
                a = "<div class='col-md-12 text-center'>";
                // onchange="ckbk(this,\'' + full.GR_NO + '\',\'' + full.GR_ITEM_NO + '\')"
                a += '<input type="checkbox" onchange="cekPOnCURR(this,\'' + full.GR_NO + '\',\'' + full.GR_ITEM_NO + '\')" class="ckb" value="' + full.PO_NO + '" data-curr="' + full.GR_CURR + '" data-id_inv="' + full.ID_INVOICE + '"  data-gr="' + full.GR_NO + '" data-amount="' + full.GR_AMOUNT_IN_DOC + '" data-grl="' + full.GR_ITEM_NO + '"';
                if (full.INV_NO == $("#ID_INVOICE").val())
                    a += " disabled checked>";
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



function viewdetail(element, invoiceno, docdate) {
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

    $("#InvoiceNo").val(invoiceno)
    $("#InvoiceNoApp").val(invoiceno)
    $("#DocumentDate").val(docdate)
    $("#PostingDate").val(now)
    $("#PaymentBlock").val('3')
    $.ajax({
        url: $("#base-url").val() + 'EC_Open_invoice/get_invoiceDetail/' + invoiceno,
        data: {
            //"qty" : $("#qtyy").val(),
            //"contract_no" : contract_no,
            //"matno" : matno
        },
        type: 'POST',
        dataType: 'json'
    }).done(function(data) {
        //console.log(data);
        $(".proposal").removeClass("success")
        $(element).parent().addClass("success")
        $("#InvoiceDetail").empty()
        if (data.data.length == 0)
            $("#InvoiceDetail").append('<div class="row text-center">Data Tidak Ditemukan!!</div>')
        else
            for (var i = 0; i < data.data.length; i++) {
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

function viewdetailApp(element, invoiceno, docdate) {
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

    $("#InvoiceNo").val(invoiceno)
    $("#InvoiceNoApp").val(invoiceno)
    $("#DocumentDate").val(docdate)
    $("#PostingDate").val(now)
    $("#PaymentBlock").val('3')
    $.ajax({
        url: $("#base-url").val() + 'EC_Open_invoice/get_invoiceDetail/' + invoiceno,
        data: {
            //"qty" : $("#qtyy").val(),
            //"contract_no" : contract_no,
            //"matno" : matno
        },
        type: 'POST',
        dataType: 'json'
    }).done(function(data) {
        //console.log(data);
        $(".approved").removeClass("success")
        $(element).parent().addClass("success")
        $("#InvoiceDetailApp").empty()
        if (data.data.length == 0)
            $("#InvoiceDetailApp").append('<div class="row text-center">Data Tidak Ditemukan!!</div>')
        else
            for (var i = 0; i < data.data.length; i++) {
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
                $("#InvoiceDetailApp").append(teks);

            }
    }).fail(function(data) {
        // console.log("error");
        // $("#pocreated").text(data['RETURN'][0]['MESSAGE'])
    }).always(function(data) {
        // console.log(data)

    });

}

function viewdetailreject(element, alasanreject) {
    $("#alasanreject").val(alasanreject);
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
var countDenda = 0;

function hapuss(elm, tbl, ke, jml) {
    /*	$("#ke"+ke).find("td").addClass('disableddiv')
    	$("#ke"+ke).find("span").removeClass('glyphicon-trash').addClass('glyphicon-plus')
    	$("#ke"+ke).find("a:eq(1)").prop("href", "javascript:undoo(this,'"+tbl+"','"+ke+"','"+jml+"')")
    	$("#ke"+ke).find("a:eq(1)").parent().removeClass('disableddiv')
     */
    if (jml != 0) {
        $("#totalAmount").val(numberWithCommas(parseInt($("#total").val()) + jml));
        $("#total").val(parseInt($("#total").val()) + jml);
    }
    if (tbl == 'tableDenda')
        $("#jmlDenda").val(parseInt($("#jmlDenda").val()) - 1)
    else
        $("#jmlDoc").val(parseInt($("#jmlDoc").val()) - 1)

    arrHDn = []
    arrHDc = []
    $("#arrHDn").val("")
    $("#arrHDc").val("")
    $('.glyphicon-plus').each(function() {
        if ($(this).data("iddenda") != "-" && arrHDn.indexOf($(this).data('iddenda')) < 0) {
            arrHDn.push($(this).data('iddenda'));
            $("#arrHDn").val(arrHDn)
        }
    });
    $('.glyphicon-plus').each(function() {
        if ($(this).data("iddoc") != "-" && arrHDc.indexOf($(this).data('iddoc')) < 0) {
            arrHDc.push($(this).data('iddoc'));
            $("#arrHDc").val(arrHDc)
        }
    });
    $('.' + tbl).find("tr#ke" + ke).remove()
        //$(elm).closest('td').closest('tr').remove();
}

function undoo(elm, tbl, ke, jml) {
    $("#ke" + ke).find("td").removeClass('disableddiv')
    $("#ke" + ke).find("span").removeClass('glyphicon-plus').addClass('glyphicon-trash')
    $("#ke" + ke).find("a:eq(1)").prop("href", "javascript:hapuss(this,'" + tbl + "','" + ke + "','" + jml + "')")
    if (jml != 0) {
        $("#totalAmount").val(numberWithCommas(parseInt($("#total").val()) + jml))
        $("#total").val(parseInt($("#total").val()) + jml)
    }
    if (tbl == 'tableDenda')
        $("#jmlDenda").val(parseInt($("#jmlDenda").val()) + 1)
    else
        $("#jmlDoc").val(parseInt($("#jmlDoc").val()) + 1)

    arrHDn = []
    arrHDc = []
    $("#arrHDn").val("")
    $("#arrHDc").val("")
    $('.glyphicon-plus').each(function() {
        if ($(this).data("iddenda") != "-" && arrHDn.indexOf($(this).data('iddenda')) < 0) {
            arrHDn.push($(this).data('iddenda'));
            $("#arrHDn").val(arrHDn)
        }
    });
    $('.glyphicon-plus').each(function() {
        if ($(this).data("iddoc") != "-" && arrHDc.indexOf($(this).data('iddoc')) < 0) {
            arrHDc.push($(this).data('iddoc'));
            $("#arrHDc").val(arrHDc)
        }
    });
}

function addDenda(elm) {
    var _form_group = $(elm).closest('.form-group');
    var _tbody = $('#tbody-denda');
    var teks = '';
    var _idDenda = _form_group.find('select');
    var _nominal = _form_group.find('input[name=Nominal]').val().replace(/\s/g, '');
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
        var _idDendaExist = $("#tbody-denda").find('input[name^=idDenda]');
        var _listDenda = {};
        _idDendaExist.each(function() {
            _listDenda[$(this).val()] = $(this).val();
        });
        if (_listDenda[_idDenda.val()] !== undefined) {
            bootbox.alert('Denda sudah ada');
        } else {
            if (_nominal > 0) {
                teks = '<tr id="ke' + countDenda + '" class="dnd">'
                teks += '<td class="text-center">' + _idDenda.find('option:selected').text() + '<input type="hidden" value="' + _idDenda.val() + '" name="idDenda[]"></td>';
                teks += '<td class="text-center">' + numberWithDot(_nominal) + '<input type="hidden" value="' + _nominal + '" name="Nominal[]"></td>';
                teks += '<td><a></a></td>'
                teks += '<td class="text-center"><input type="file" required name="fileDenda' + _urutanTerakhir + '" /></td>';
                teks += '<td class="text-center"><a href="#" onclick="hapusBarisDenda(this);return false"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></td></tr>';
                $(teks).appendTo(_tbody);
                $("#Nominal").val("");
                $("#jmlDenda").val($(".dnd").length);
                countDenda++;
            }
            hitungAmount(_form_group);
        }
    } else {
        bootbox.alert('Denda harus angka');
    }
}

function approvalInvoice(elm){
    var _id = $('#ID_INVOICE').val();
    var _inv_no = $('#invoice_no').val();
    var _status = $(elm).data('status');
    var _action = $(elm).data('action');
    var _tp = $(elm).data('t_payment');
    
    if(_action == 'approve'){
        bootbox.confirm('Apakah Anda Yakin', function(res){
            if(res){
                var _url = base_url+'EC_Approval/Invoice/approvalInvoice/'+_action;
                $.redirect(_url,{status_approval:_status,id_invoice:_id,invoice_no:_inv_no,total_payment:_tp},'POST');
            };
        });
    }else{
        $("#msg").prop('disabled', false);
        $('#reject').data('status',_status);
        $('#reject').data('action',_action);
        $('#rejectInvoice').modal('show');
    }
}

function rejectInvoice(elm){
    var _msg = $('#msg').val();
    var _id = $('#ID_INVOICE').val();
    var _inv_no = $('#invoice_no').val();
    var _status = $(elm).data('status');
    var _action = $(elm).data('action');
    
    bootbox.confirm('Apakah Anda Yakin', function(res){
        if(res){
            var _url = base_url+'EC_Approval/Invoice/approvalInvoice/'+_action;
            $.redirect(_url,{status_approval:_status,id_invoice:_id,invoice_no:_inv_no,msg:_msg},'POST');
        };
    });
}

function showDocument(elm){
  var url = $(elm).data('url');
  var data = {
    tipe : $(elm).data('tipe'),
    id : $(elm).data('iddokumen'),
    nopo : $(elm).data('nopo'),
    print_type : $(elm).data('print_type')
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