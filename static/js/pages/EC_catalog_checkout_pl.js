var curBdg,
    qtyOld,
    contract_no_old,
    contract_no,
    contract_H,
    base_url = $("#base-url").val();

function chk23() {
    $("#goods").append('<div class="row"><div class="col-md-2"></div><div class="col-md-10">Please wait loading data....</div></div>')
    $.ajax({
        url: $("#base-url").val() + 'EC_Ecatalog_Marketplace/get_data_checkout_pl/',
        data: {
            "checked": null
        },
        type: 'POST',
        dataType: 'json'
    }).done(function (data) {
        // console.log(data.data.length);
        $("#goods").empty();
        $("#totall").text('Rp ' + numberWithCommas(data.total));
        $("#totalBiaya").text('Rp ' + numberWithCommas(data.total));
        var tottt = data.total;
        var availBdg = $("#availBdg").val();

        $(".budget").attr('title', 'cart: ' + numberWithCommas(tottt));
        $('.budget').tooltip();

        $("#budgett").text('Rp ' + numberWithCommas(availBdg));
        $("#hid_current_budget").val(data.budget);
        $("#totalsisa").text('Rp ' + numberWithCommas(availBdg - tottt));
        if (tottt <= 0) {
            console.log('minus');
            $('#totalsisa').append(' <a href="#javascript:void(0)">(Exceeded)</a>');
            $('#btn_confirm').removeClass("btn-success").addClass("btn-danger").addClass("disabled");
            $('#btn_confirm').attr('data-target', '#');
        } else {
            $("#totalsisa").text('Rp ' + numberWithCommas(availBdg - tottt))
            $('#btn_confirm').removeClass("btn-danger").addClass("btn-success").removeClass("disabled");
            $('#btn_confirm').attr('data-target', '#cnfrm');
        }
        /************************hard code enable confirm button********************************/
        // $('#btn_confirm').toggleClass("btn-danger btn-success").removeClass("disabled");
        /************************^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^********************************/
        var plant = null
        contract_no = 0
        var countSameCon = 0;
        contract_H = 0

        for (var i = 0; i < data.data.length; i++) {
            disable = ''
            act = 'cancelcart'
            btn = 'Hold'
            clr = 'danger'
            qtyOld = data.data[i].QTY

            qty = '<div class="row"><div class="input-group col-md-11">'
            qty += '<i class="input-group-addon tangan" data-avl="" onclick="minqtycart(this,\'' + data.data[i].ID_CHART + '\')"><span class="glyphicon glyphicon-minus" aria-hidden="true"></span></i>'
            qty += '<input type="number" value="' + data.data[i].QTY + '" data-id="' + data.data[i].ID_CHART + '" data-avl="" data-old="" max="' + data.data[i].STOK + '" onkeydown="return false" class="form-control text-center qtyy">'
            qty += '<i class="input-group-addon tangan" data-avl="" onclick="plsqtycart(this,\'' + data.data[i].ID_CHART + '\')"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></i>'
            qty += '<span class="input-group-addon">' + data.data[i].MEINS + '</span>'
            qty += '</div></div><br>'
            del = ''
            chk = ' checked'
            header = ''
            //teks = ''
            teks = '<div class="" style=" margin:3px; border-bottom: 1px solid #ccc;">'
            if (contract_H != data.data[i].VENDORNO) {
                contract_H = data.data[i].VENDORNO
                header = '<div class="row" style="padding:3px;">Nomor Vendor: ' + contract_H + ' - ' + data.data[i].VENDOR_NAME + '</div>'
                teks = '<div class="row chrt' + data.data[i].ID_CHART + '" style=" margin:3px; border-top: 1px solid #ccc;">'
            } else {
                teks = ('<div class="row chrt' + data.data[i].ID_CHART + '" style=" margin:3px;">')
            }
            if (data.data[i].STATUS_CHART == '8') {
                disable = ' disableddiv'
                act = 'addcart'
                btn = 'Re-assign'
                clr = 'default'
                qty = ''
                chk = ''
                del = '<a href="javascript:void(0)" onclick="deletecart(this,\'' + data.data[i].ID_CHART + '\')" class="btn btn-danger form-control" >Remove</a><p></p>'
            } else {
                contract_no = data.data[i].DELIVERY_TIME
                countSameCon++
            }
            // if (data.data[i][11].substring(0, 1) == 3) {
            // 	plant = 'Semen Padang';
            // } else if (data.data[i][11].substring(0, 1) == 4) {
            // 	plant = 'Semen Tonasa';
            // } else if (data.data[i][11].substring(0, 1) == 5) {
            // 	plant = 'Semen Gresik';
            // } else if (data.data[i][11].substring(0, 1) == 7) {
            // 	plant = 'KSO';
            // } else if (data.data[i][11].substring(0, 1) == 2) {
            // 	plant = 'Holding SMI';
            // }
            if (i == data.data.length - 1) {
                teks = ('<div class=""  style="margin:3px; border-bottom: 1px solid #ccc;">')
            }
            teks += header
            teks += '<div class="row" style=" margin:10px; padding:3px;">'
            teks += '<div class="col-md-2' + disable + '" style="  padding-left: 5px;">'
            teks += '<a href="javascript:void(0)" data-backdrop="true" data-toggle="modal" data-target="#modaldetail" data-produk="' + data.data[i].MATNR + '"><img src="' + $("#base-url").val() + $("#UPLOAD_PATH").val() + "EC_material_strategis/" + data.data[i].PICTURE + '" class="img-responsive"></a>'
            teks += '</div>' + '<div class="col-md-3' + disable + '" style="  padding-left: 35px;">'
            teks += '<div class="row" style="font-size:11px">Kategori: ' + data.data[i].DESC + '</div>'
            //teks += '<div class="row" style="font-size:11px">' + plant + '-' + data.data[i][11] + '</div>'
            teks += '<div class="row" style="font-size:18px"><strong><a href="javascript:void(0)" data-backdrop="true" data-toggle="modal" data-target="#modaldetail" data-produk="' + data.data[i].MATNR + '">' + data.data[i].MAKTX + '</a></strong></div>'
            teks += '</div><div class="col-md-4' + disable + '" style="padding-left: 35px;">' + '<div class="row" style="font-size:14px;color: #E74C3C;">' + '<strong>Plant: ' + data.data[i].PLANT + " &mdash; " + data.data[i].NAMA_PLANT + '</strong>' + '</div>'
            teks += '<div class="row" style="font-size:14px">Harga: <span id="lblprice"><strong>' + data.data[i].CURRENCY + ' ' + numberWithCommas(data.data[i].PRICE) + '</strong></span></div>'
            teks += '<div class="row" style="font-size:12px">Stok: <strong>' + data.data[i].STOK + ' ' + data.data[i].MEINS + '</strong></div>'
            teks += '<div class="row" style="font-size:12px">Delivery Time: <strong>' + data.data[i].DELIVERY_TIME + ' Days</strong></div>'
            teks += '<div class="row" style="font-size:12px">Nomor Material: <strong>' + data.data[i].MATNO + '</strong></div>'//" &mdash; " + "" + (data.data[i].CC_NAME == null ? "" : data.data[i].CC_NAME)            
            teks += '</div>' + '<div class="col-md-3">' + qty + '<form class="form-horizontal">'
            teks += del + '<div class="col-md-6 col-md-offset-3"><input class="chkPlant" type="checkbox" data-matno="' + data.data[i].MATNR + '" data-price="' + data.data[i].PRICE + '" data-plant="' + data.data[i].PLANT + '" data-teks="' + data.data[i].MAKTX + '" ' + chk + ' onchange="' + act + '(this,\'' + data.data[i].ID_CHART + '\')" /></div>'
            teks += '</form>' + '</div>' + '</div>' + '</div>'
            $("#goods").append(teks)

        }
        // $("#myModalLabel").text('Konfirmasi Crate PO dengan ' + countSameCon + ' tipe barang berbeda')

        // $("#myModalLabel").text('Tiap nomer PO terbit berdasarkan nomer kontrak barang yang sama')
        $("#btnCofirmmm").show();
        jml = 0,
            vndor = 0;
        vndor_no = "-";
        for (var i = 0; i < data.data.length; i++) {
            if (data.data[i].BUYONE == '0' && data.data[i].STATUS_CHART == 0) {
                jml++;
                if (vndor_no != data.data[i].VENDOR_NO) {
                    vndor++;
                    vndor_no = data.data[i].VENDOR_NO;
                    console.log('minus')
                    // $('#btn_confirm').toggleClass("btn-danger btn-success").addClass("disabled");
                    // $("#myModalLabel").text('Tiap nomer PO terbit berdasarkan vendor yang sama');
                    // $("#btnCofirmmm").hide();
                }
                console.log("barang :" + data.data[i].STATUS_CHART);
            }//status            
        }

        $("#jmlPO").text(vndor);
        $("#jmlBrg").text(jml);
        if (countSameCon == 0)
            $('#btn_confirm').removeClass("btn-success").addClass("btn-danger").addClass("disabled");
        $('#btn_confirm').attr('data-target', '#');
    }).fail(function () {
        console.log("error");
    }).always(function (data) {
        //console.log(data);
        $(".qtyy").keyup(function () {
            that = this
            setTimeout(function () {
                updQtycart(that, $(that).val(), $(that).data('id'))
            }, 1500);
        });
    });
}

function numberWithCommas(x) {
    return x == null || x == "0" ? "" : x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

$('#cnfrm').on('show.bs.modal', function (event) {
    console.log('Modal On');
//    $('#maktx2').text($('#maktx').text())
//    $('#jmlItm').text($('.qtyy').val() + " " + $('#MEINS').val())
//    $('#totalBiaya').text($('#totall').text())
//    var i = 0, j = 0, ttl = 0, ttl2 = 0, dataa = [], matno = [], plant = [], teks = [], price = [], qty = []
//    $('#tbodyMat').empty()
//    $("input:checkbox").each(function () {
//        // console.log($(this).data('matno'))
//        // console.log($(this).data('plant'))
//        // matno[j] = $(this).data('matno')
//        // plant[j] = $(this).data('plant')
//        // teks[j] = $(this).data('teks')
//        // price[j] = $(this).data('price')
//        input = $('input')
//        // qty[j] = $(this).parent().parent().prev().prev().find(input).val()
//        price[$(this).data('matno') + $(this).data('plant')] = $(this).data('price')
//        qty[$(this).data('matno') + $(this).data('plant')] = $(this).parent().parent().prev().prev().find(input).val()
//        teks[$(this).data('matno') + $(this).data('plant')] = $(this).data('teks')
//        j++
//        $('#tbodyMat').append('<tr id="' + ($(this).data('matno') + $(this).data('plant')) + '"></tr>')
//        // console.log(qty)
//        if ($(this).is(":checked"))
//            $.ajax({
//                url: $("#base-url").val() + 'EC_Ecatalog/GET_MATERIALGLACCOUNT/' + $(this).data('matno') + "/" + $(this).data('plant'),
//                type: 'POST',
//                dataType: 'json'
//            }).done(function (data) {
//                // console.log(data);
//            }).fail(function (data) {
//                // console.log("error");
//                // $("#pocreated").text(data['RETURN'][0]['MESSAGE'])
//            }).always(function (data) {
//                    dt = (data[0].MATNR + data[0].BWKEY)
//                    ttl += (parseInt(price[dt]) * parseInt(qty[dt]))
//                    ttl2 += parseInt(qty[dt])
//                    tx = ('<td class="text-center">' + data[0].MATNR + '</td>')
//                    tx += ('<td class="text-center">' + data[0].BWKEY + '</td>')
//                    tx += ('<td class="text-center">' + teks[dt] + '</td>')
//                    tx += ('<td class="text-center">' + ((data[0].KONTS != null) ? (data[0].TXT50 + "  (" + data[0].KONTS + ')</td>') : '&mdash;tidak tersedia&mdash; </td>'))
//                    tx += ('<td class="text-center">' + qty[dt] + '</td>')
//                    tx += ('<td class="text-center">' + numberWithCommas(parseInt(price[dt]) * parseInt(qty[dt])) + '</td>')
//                    $('#' + dt).html(tx)
//                    // console.log(price[(data[0].MATNR + data[0].BWKEY )])
//                    i++
//                    if (i == j) {
//                        $('#tbodyMat').append('<tr></tr>')
//                        $('#tbodyMat tr:eq(' + i + ')').append('<td class="text-center"> </td>')
//                        $('#tbodyMat tr:eq(' + i + ')').append('<td class="text-center"> </td>')
//                        $('#tbodyMat tr:eq(' + i + ')').append('<td class="text-center"> </td>')
//                        $('#tbodyMat tr:eq(' + i + ')').append('<td class="text-center"> Total: </td>')
//                        $('#tbodyMat tr:eq(' + i + ')').append('<td class="text-center">' + ttl2 + ' </td>')
//                        $('#tbodyMat tr:eq(' + i + ')').append('<td class="text-center">' + numberWithCommas(ttl) + '</td>')
//
//                    }
//                $('#buyOne').show();
//                }
//            )
//    });
//
//    console.log($("#CCopt").val());
//    loadTable($("#CCopt").val());
});

function confirm(elm, id) {
    var sukses = 0;
    console.log(contract_no)
    $.ajax({
        url: $("#base-url").val() + 'EC_Ecatalog/confirm_pl/',
        type: 'POST',
        data: {
            "company": $("#selComp").val(),
            "costcenter": $("#costcenter-yu").val(),
            'korin': $('#korin_name').val(),
            'gudang': $('input[name="gudang"]:checked').val()
        },
        dataType: 'json'
    }).done(function (data) {
        console.log(data);
        $('#cnfrm').modal('hide')
    }).fail(function (data) {
        console.log("error");
        // $("#pocreated").text(data['RETURN'][0]['MESSAGE'])
    }).always(function (data) {
        // console.log(data['RETURN'][0]['MESSAGE']);
        var cnt = 0;
        $('#tbodyPO').empty()
        console.log(data);
        if (data.suksesReturn.length > 0) {
            sukses = 1;
            $('#tbodyPO').append('<tr><td>Sukses: </td></tr>')
            for (var i = 0; i < data.suksesReturn.length; i++) {
                for (var j = 0; j < data.suksesReturn[i].length; j++) {
                    $('#tbodyPO').append('<tr></tr>')
                    $('#tbodyPO tr:eq(' + (i + j + 1) + ')').append('<td>PO: ' + data.suksesReturn[i][j].PO + '</td>')
                    $('#tbodyPO tr:eq(' + (i + j + 1) + ')').append('<td>' + data.suksesReturn[i][j].MAKTX + " &mdash; " + data.suksesReturn[i][j].MATNO + '</td>')
                    $('#tbodyPO tr:eq(' + (i + j + 1) + ')').append('<td>' + (data.suksesReturn[i][j].PLANT) + '</td>')
                    $('#tbodyPO tr:eq(' + (i + j + 1) + ')').append('<td>' + (data.suksesReturn[i][j].NAMA_PLANT) + '</td>')
                }
            }
        }

        if (data.gagalReturn.length > 0) {
            $('#tbodyPO').append('<tr><td>Gagal: </td></tr>');
            for (var i = 0; i < data.gagalReturn.length; i++) {
                $('#tbodyPO').append('<tr><td>&mdash;</td></tr>');
                for (var j = 0; j < data.gagalReturn[i].length; j++) {
                    $('#tbodyPO').append('<tr id="cnt' + cnt + '"></tr>')
                    $('#cnt' + cnt).append('<td>' + data.gagalReturn[i][j].TYPE + '</td>')
                    $('#cnt' + cnt).append('<td>' + (data.gagalReturn[i][j].MESSAGE) + '</td>')
                    $('#cnt' + cnt).append('<td>' + (data.gagalReturn[i][j].MESSAGE_V1) + '</td>')
                    $('#cnt' + cnt).append('<td>' + (data.gagalReturn[i][j].PARAMETER) + '</td>')
                    cnt++
                }
            }
        }


        $('#modalPO').modal('show')
        var fiveMinutes = 10,
            display = document.querySelector('#dtk');
        startTimer(fiveMinutes, display);
        setTimeout(function () {
            if (sukses == 1) {
                window.location.reload();
            }
        }, 10000);

    });

}

$('#modalPO').on('hidden.bs.modal', function (event) {
    window.location = $("#base-url").val() + 'EC_Ecatalog_Marketplace/checkout';
});

function confirmOLD(elm, id) {
    console.log(contract_no)
    $.ajax({
        url: $("#base-url").val() + 'EC_Ecatalog/confirm/',
        type: 'POST',
        dataType: 'json'
    }).done(function (data) {
        console.log(data);
        $('#cnfrm').modal('hide')
    }).fail(function (data) {
        console.log("error");
        // $("#pocreated").text(data['RETURN'][0]['MESSAGE'])
    }).always(function (data) {
        console.log(data)
        // $("#pocreated").text(data)
        $('#cnfrm').modal('hide')

        $('#tbodyPO').empty()
        po = "-"
        for (var i = 0; i < data.length; i++) {
            po = (data[i].PO_NO) != po ? (data[i].PO_NO) : ""
            $('#tbodyPO').append('<tr></tr>')
            $('#tbodyPO tr:eq(' + i + ')').append('<td>' + (po == "null" ? "gagal" : po) + '</td>')
            $('#tbodyPO tr:eq(' + i + ')').append('<td>' + (data[i].MAKTX) + '   (' + (data[i].MATNO) + ')</td>')
            $('#tbodyPO tr:eq(' + i + ')').append('<td>' + (data[i].curr) + ' ' + numberWithCommas(data[i].netprice) + '</td>')
        }
        ;

        $('#modalPO').modal('show')
        chk23();
    });

}

function updQtycart(elm, qty, id) {
    if (qty > 0 && qty.search(/[A-Za-z]/g) == -1)//
    // if (qty < $(elm).data('avl'))
        $.ajax({
            url: $("#base-url").val() + 'EC_Ecatalog/updQtyCart/' + id,
            data: {
                "qty": qty
            },
            type: 'POST',
            dataType: 'json'
        }).done(function (data) {
            // console.log('hide ' + data);
        }).fail(function () {
            console.log("error");
        }).always(function (data) {
            chk23();
        });
    // else {
    //     $(elm).val($(elm).data('old'))
    //     alert('Maksimal jumlah order: ' + $(elm).data('avl') + ' !!')
    // }
    else {
        alert('Minimal 1 dan hanya angka!!')
        $(elm).val($(elm).data('old'))
    }
}

function deletecart(elm, id) {
    $.ajax({
        url: $("#base-url").val() + 'EC_Ecatalog/deletecart/' + id,
        type: 'POST',
        dataType: 'json'
    }).done(function (data) {
        console.log('hide ' + data);
    }).fail(function () {
        console.log("error");
    }).always(function (data) {
        chk23();
    });
}

function minqtycart(elm, id) {
    if ($(elm).next().val() > 1)
        $.ajax({
            url: $("#base-url").val() + 'EC_Ecatalog/minqtycart/' + id,
            type: 'POST',
            dataType: 'json'
        }).done(function (data) {
            console.log('hide ' + data);
        }).fail(function () {
            console.log("error");
        }).always(function (data) {
            chk23();
        });

}

function plsqtycart(elm, id) {
    // console.log($(elm).prev().val() + "<" + $(elm).data('avl'))
    // if ($(elm).prev().val() < $(elm).data('avl'))
    $.ajax({
        url: $("#base-url").val() + 'EC_Ecatalog/plsqtycart/' + id,
        type: 'POST',
        dataType: 'json'
    }).done(function (data) {
        console.log('hide ' + data);
    }).fail(function () {
        console.log("error");
    }).always(function (data) {
        chk23();
    });
    // else
    // 	alert('Maksimal jumlah order: ' + $(elm).data('avl') + ' !!')
}

function addcart(elm, id) {
    $.ajax({
        url: $("#base-url").val() + 'EC_Ecatalog/readdcart/' + id,
        type: 'POST',
        dataType: 'json'
    }).done(function (data) {
        console.log('hide ' + data);
    }).fail(function () {
        console.log("error");
    }).always(function (data) {
        chk23();
    });
}

function cancelcart(elm, id) {
    $.ajax({
        url: $("#base-url").val() + 'EC_Ecatalog/cancelcart/' + id,
        type: 'POST',
        dataType: 'json'
    }).done(function (data) {
        console.log('hide ' + data);
    }).fail(function () {
        console.log("error");
    }).always(function (data) {
        chk23();
    });
}


$(document).ready(function () {
    $('#buyOne').hide();
    $.ajax({
        url: $("#base-url").val() + 'EC_Ecatalog/get_data_cart_langsg/',
        type: 'POST',
        dataType: 'json'
    }).done(function (data) {
        console.log(data);
        $(".jml").text(data.jumlah);
        $(".budget").text(numberWithCommas(data.budget));
        $(".jmlCompare").text(data.compare)
        curBdg = data.budget;
        $(".budget").attr('title', 'cart: ' + numberWithCommas(data.total))
        $('.budget').tooltip();

        $('#tbody').empty()
        $('#tbody').append('<tr class="success"></tr>')
        $('#tbody tr').append('<td>' + (data.cost_center) + '</td>')
        $('#tbody tr').append('<td>' + (data.cost_center_desc) + '</td>')
        $('#tbody tr').append('<td>&nbsp;</td>')
        $('#tbody tr').append('<td>&nbsp;</td>')
        $('#tbody tr').append('<td>' + numberWithCommas(data.current_budget) + '</td>')
        $('#tbody tr').append('<td>' + numberWithCommas(data.commit_budget).replace('-', '') + '</td>')
        $('#tbody tr').append('<td>' + numberWithCommas(data.actual_budget).replace('-', '') + '</td>')
        $('#tbody tr').append('<td>' + numberWithCommas(data.budget) + '</td>')
        $('#tbody tr').append('<td>' + numberWithCommas(data.total) + '</td>')

        for (var i = 0; i < data.detailActualCommit.length; i++) {
            $('#tbody').append('<tr></tr>')
            $('#tbody tr:eq(' + (i + 1) + ')').append('<td> </td>')
            $('#tbody tr:eq(' + (i + 1) + ')').append('<td> </td>')
            $('#tbody tr:eq(' + (i + 1) + ')').append('<td>' + (data.detailActualCommit[i].glItem) + '</td>')
            $('#tbody tr:eq(' + (i + 1) + ')').append('<td>' + numberWithCommas(data.detailActualCommit[i].glDesc.SHORT_TEXT) + '</td>')
            $('#tbody tr:eq(' + (i + 1) + ')').append('<td></td>')
            $('#tbody tr:eq(' + (i + 1) + ')').append('<td>' + numberWithCommas(data.detailActualCommit[i].budgetCommit).replace('-', '') + '</td>')
            $('#tbody tr:eq(' + (i + 1) + ')').append('<td>' + numberWithCommas(data.detailActualCommit[i].budgetActual).replace('-', '') + '</td>')
            $('#tbody tr:eq(' + (i + 1) + ')').append('<td></td>')
            $('#tbody tr:eq(' + (i + 1) + ')').append('<td></td>')
        }
        ;

        if (window.location.pathname.indexOf('checkout') > -1) {
            $("#budgett").text('Rp ' + numberWithCommas(data.budget));
            $("#hid_current_budget").val(data.budget);
        }

    }).fail(function () {
        // console.log("error");
    }).always(function (data) {
        //console.log(data);
        // });
        chk23();
    });

    $('#btn_confirm').click(function (event) {
        if ($(this).hasClass("disabled")) {
            event.stopPropagation();
        } else {
            console.log('Klik Show');
            itemPlant = [];
            $(".chkPlant").each(function () {
                // var plant = $(this).data("plant")
                if ($(this).is(":checked")) {
                    itemPlant.push(String($(this).data("plant")));
                }
            });
            itemQty = []
            $(".qtyy").each(function () {
                // var plant = $(this).data("plant")
                // if ($(this).is(":checked")){
                itemQty.push(String($(this).val()));
                // }
            });
            // dataitems = JSON.stringify(itemPlant);
            console.log(itemQty);
            console.log(CekHomogenous(itemQty));
            if (isHomogenous(itemPlant)) {
                if (CekHomogenous(itemQty)) {
//                    console.log('itemPlant' + itemPlant);
//                    var valPlant = '';
//                    if(itemPlant[0].substring(0, 1)=='2'){
//                      valPlant = '2000';
//                    }else if(itemPlant[0].substring(0, 1)=='3') {
//			valPlant = '3000';
//                    }else if(itemPlant[0].substring(0, 1)=='4') {
//        		valPlant = '4000';
//                    }else if(itemPlant[0].substring(0, 1)=='5') {
//                      valPlant = '5000';
//                    }else if(itemPlant[0].substring(0, 1)=='6') {
//        		valPlant = '6000';
//                    }else if(itemPlant[0].substring(0, 1)=='7') {
//        		valPlant = '7000';
//                    }
//                    $("#selComp").val(valPlant);
                    $('#cnfrm').modal('show');
                } else {
                    alert('QTY masih 0');
                }
            } else {
                alert('Plant harus sama');
            }
        }
    });

    $("#korin").on('change', (function (e) {
        e.preventDefault();
        // alert('tesUpload');
        $.ajax({
            url: $("#base-url").val() + 'EC_Ecatalog_Marketplace/tesUplaod/', // Url to which the request is send
            type: "POST",             // Type of request to be send, called as method
            data: new FormData($("#uploadimage")[0]), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
            contentType: false,       // The content type used when sending data to the server.
            cache: false,             // To unable request pages to be cached
            processData: false,        // To send DOMDocument or non processed data file it is set to false
            success: function (data)   // A function to be called if request succeeds
            {
                var result = JSON.parse(data);
                if (result['file_name'] != '') {
                    $("#korin_name").val(result['file_name']);
                    $("#messagesUpload").show();
                    $("#messagesUpload").attr('style', 'color: green;');
                    $("#messagesUpload").text('Upload Sukses..!!');

                } else {
                    $("#messagesUpload").show();
                    $("#messagesUpload").attr('style', 'color: red;');
                    $("#messagesUpload").text('Upload Gagal..!!');
                }
                // console.log(result);
                // console.log(result['file_name']);
                // console.log(result.file_name);
                // $('#loading').hide();
                // $("#message").html(data);
            }
        });
    }));

    $("#cari-funcloc").on("click", function (e) {
        // $('#funcloc').selectpicker('val', '');
        // alert($("#funcloc-search").val());
        e.preventDefault();
        $.ajax({
            url: $("#base-url").val() + 'EC_Ecatalog_Marketplace/getFuncLocation',
            type: 'POST',
            data: {
                "keyword": $("#funcloc-search").val()
            },
            dataType: 'json'
        }).done(function (data) {
            // $("#funcloc-search").val('')
            // console.log(data.length);
            // console.log(data[0].STRNO);
            var option = '';
            $('#funcloc').empty()
            for (var i = 0; i < data.length; i++) {
                option += '<option value=' + data[i].STRNO + ':' + data[i].KOSTL + '>' + data[i].STRNO + ' &mdash; ' + data[i].PLTXT + '</option>'
            }
            $('#funcloc').html(option);
            $('#funcloc').selectpicker('refresh');
        }).fail(function () {
            //console.log("error");
        }).always(function (data) {
            //chk23();
        });
    });

    $("#clearFuncloc").on("click", function () {
        $('#funcloc').selectpicker('val', '');
        $.ajax({
            url: $("#base-url").val() + 'EC_Ecatalog_Marketplace/COSTCENTER_GETLIST1',
            type: 'POST',
            data: {},
            dataType: 'json'
        }).done(function (data) {
            // $("#funcloc-search").val('')
            console.log(data.length);
            console.log(data);
            // console.log(data[0].STRNO);
            var option = '';
            $('#CCopt').empty()
            for (var i = 0; i < data.length; i++) {
                option += '<option value=' + data[i].COSTCENTER + '>' + data[i].COSTCENTER + ' &mdash; ' + data[i].NAME + '</option>'
            }
            $('#CCopt').html(option);
            $('#CCopt').selectpicker('refresh');
            $('#selComp').val('').change();
        }).fail(function () {
            //console.log("error");
        }).always(function (data) {
            //chk23();
        });
    })

});

function isHomogenous(arr) {
    firstValue = arr[0];
    for (var i = 0; i < arr.length; i++) {
        // console.log(firstValue+':'+arr[i])
        if (firstValue != arr[i]) {
            return false;
        }
    }
    return true;
}

function CekHomogenous(arr) {
    for (var i = 0; i < arr.length; i++) {
        if (arr[i] == 0) {
            return false;
        }
    }
    return true;
}

$('label.tree-toggler').click(function () {
    $(this).parent().children('ul.tree').toggle(300);
});

$('#checkbox1').change(function () {
    if ($(this).is(":checked")) {
        var returnVal = confirm("Are you sure?");
        $(this).attr("checked", returnVal);
    }
    $('#textbox1').val($(this).is(':checked'));
});


var CCopt2 = $(".select2").select2({
    dropdownParent: $('#cnfrm')
});
CCopt2.on("select2:select", function (e) {
    console.log($(this).val())
    loadTable($(this).val())
    // table.ajax.url($("#base-url").val() + 'EC_Ecatalog/GET_REPORTBUDGET/' + $(this).val()).load();
    e.preventDefault();
    $.ajax({
        url: $("#base-url").val() + 'EC_Ecatalog/simpanCCBeforeBuy/',
        type: 'POST',
        data: {
            "cc": $("#CCopt").val()
        },
        dataType: 'json'
    }).done(function (data) {
        //console.log('hide ' + data);
    }).fail(function () {
        //console.log("error");
    }).always(function (data) {
        //chk23();
    });
});

var CCopt = $(".CC").select2({
    dropdownParent: $('#modalbudget')
});
CCopt.on("select2:select", function (e) {
    console.log($(this).val())
    //loadTableBG($(this).val())
    // table.ajax.url($("#base-url").val() + 'EC_Ecatalog/GET_REPORTBUDGET/' + $(this).val()).load();
});

$('#modalbudget').on('show.bs.modal', function (event) {
    //console.log($("#group_jasa_id").val());
    loadTableBG($("#budgetcc").val());
});

function loadTableBG(val) {
    // no = 1;
    CC = val.split(':')
    $('#tableCCBG').DataTable().destroy();
    $('#tableCCBG tbody').empty();
    mytable = $('#tableCCBG').DataTable({
        "bSort": true,
        "dom": 'rtlip',
        "deferRender": true,
        "language": {
            "loadingRecords": "<center><b>Please wait - Updating and Loading Data Strategic Material Assignment...</b></center>"
        },
        "ajax": $("#base-url").val() + 'EC_Ecatalog/GET_REPORTBUDGET/' + CC[0],

        "columnDefs": [{
            "searchable": false,
            "orderable": true,
            "targets": 0
        }],
        "columns": [{
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.GJAHR;
                a += "</div>";
                return a;
            }
        }, {
            mRender: function (data, type, full) {
                // console.log(full);
                if (full.FICTR != null) {
                    a = ''
                    a += "<div class='col-md-12 text-center'>";
                    a += full.FICTR
                    a += "</div>";
                    return a;
                } else
                    return "";
            }
        }, {
            mRender: function (data, type, full) {
                if (full.BESCHR != null) {
                    a = "<div class='col-md-12 text-center'>";
                    a += full.BESCHR;
                    a += "</div>";
                    return a;
                } else
                    return "";
            }
        }, {
            mRender: function (data, type, full) {
                if (full.FIPEX != null) {
                    a = ''
                    a += "<div class='col-md-12 text-center'>";
                    a += full.FIPEX;
                    a += "</div>";
                    return a;
                } else
                    return "";
            }
        }, {
            mRender: function (data, type, full) {
                if (full.BEZEI != null) {
                    a = "<div class='col-md-12 text-center'>";
                    a += full.BEZEI;
                    a += "</div>";
                    return a;
                } else
                    return "";
            }
        }, {
            mRender: function (data, type, full) {
                if (full.FKBTR_CB != null) {
                    a = ''
                    a += "<div class='col-md-12 text-center'>";
                    a += numberWithCommas(parseInt(full.FKBTR_CB) * 100);
                    a += "</div>";
                    return a;
                } else
                    return "";
            }
        }, {
            mRender: function (data, type, full) {
                // if(full[6] != null){
                a = ''
                a += "<div class='col-md-12 text-center'>";
                a += numberWithCommas(parseInt(full.FKBTR_AB) * 100);
                a += "</div>";
                return a;
                // }else return "";
            }
        }, {
            mRender: function (data, type, full) {
                //console.log(full[6]);
                a = ''
                a += "<div class='col-md-12 text-center'>";
                a += numberWithCommas(parseInt(full.WLJHR) * 100);
                a += "</div>";
                return a;
            }
        }, {
            mRender: function (data, type, full) {
                // if(full[6] != null){
                a = ''
                a += "<div class='col-md-12 text-center'>";
                a += numberWithCommas(parseInt(full.AVAILBUDGET) * 100);
                a += "</div>";
                return a;
                // }else return "";
            }
        }],
    });

}

function loadTable(CC) {
    // no = 1;
    ccc = CC.split(':')
    $('#tableCC').DataTable().destroy();
    $('#tableCC tbody').empty();
    mytable = $('#tableCC').DataTable({
        "bSort": true,
        "dom": 'rtlip',
        "deferRender": true,
        "language": {
            "loadingRecords": "<center><b>Please wait - Updating and Loading Data Strategic Material Assignment...</b></center>"
        },
        "ajax": $("#base-url").val() + 'EC_Ecatalog/GET_REPORTBUDGET/' + ccc[0],

        "columnDefs": [{
            "searchable": false,
            "orderable": true,
            "targets": 0
        }],
        "columns": [{
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.GJAHR;
                a += "</div>";
                return a;
            }
        }, {
            mRender: function (data, type, full) {
                // console.log(full);
                if (full.FICTR != null) {
                    a = ''
                    a += "<div class='col-md-12 text-center'>";
                    a += full.FICTR
                    a += "</div>";
                    return a;
                } else
                    return "";
            }
        }, {
            mRender: function (data, type, full) {
                if (full.BESCHR != null) {
                    a = "<div class='col-md-12 text-center'>";
                    a += full.BESCHR;
                    a += "</div>";
                    return a;
                } else
                    return "";
            }
        }, {
            mRender: function (data, type, full) {
                if (full.FIPEX != null) {
                    a = ''
                    a += "<div class='col-md-12 text-center'>";
                    a += full.FIPEX;
                    a += "</div>";
                    return a;
                } else
                    return "";
            }
        }, {
            mRender: function (data, type, full) {
                if (full.BEZEI != null) {
                    a = "<div class='col-md-12 text-center'>";
                    a += full.BEZEI;
                    a += "</div>";
                    return a;
                } else
                    return "";
            }
        }, {
            mRender: function (data, type, full) {
                if (full.FKBTR_CB != null) {
                    a = ''
                    a += "<div class='col-md-12 text-center'>";
                    a += numberWithCommas(parseInt(full.FKBTR_CB) * 100);
                    a += "</div>";
                    return a;
                } else
                    return "";
            }
        }, {
            mRender: function (data, type, full) {
                // if(full[6] != null){
                a = ''
                a += "<div class='col-md-12 text-center'>";
                a += numberWithCommas(parseInt(full.FKBTR_AB) * 100);
                a += "</div>";
                return a;
                // }else return "";
            }
        }, {
            mRender: function (data, type, full) {
                //console.log(full[6]);
                a = ''
                a += "<div class='col-md-12 text-center'>";
                a += numberWithCommas(parseInt(full.WLJHR) * 100);
                a += "</div>";
                return a;
            }
        }, {
            mRender: function (data, type, full) {
                // if(full[6] != null){
                a = ''
                a += "<div class='col-md-12 text-center'>";
                a += numberWithCommas(parseInt(full.AVAILBUDGET) * 100);
                a += "</div>";
                return a;
                // }else return "";
            }
        }],
    });
    /*
     class="btn btn-default btn-sm glyphicon glyphicon-check"
     */
    mytable.columns().every(function () {
        var that = this;

        $('.srch', this.header()).on('keyup change', function () {
            if (that.search() !== this.value) {
                that.search(this.value).draw();
            }
        });
        $('input:checkbox', this.header()).on('keyup change', function () {
            var a = [];
            if ($('#checkAll:checked').length === 1) {
                $('input:checkbox', mytable.table().body()).prop('checked', true);
                $('input:checkbox', mytable.table().body()).each(function () {
                    a.push(this.value);
                    chk2("1", this.value);
                });
            } else if ($('#checkAll:checked').length === 0) {
                $('input:checkbox', mytable.table().body()).prop('checked', false);
                $('input:checkbox', mytable.table().body()).each(function () {
                    a.push(this.value);
                    chk2("0", this.value);
                });
            }

            console.log(a);
        });
    });

    $('#tableMT').find("th").off("click.DT");

    $('.ts0').on('click', function () {
        if (t0) {
            mytable.order([0, 'asc']).draw();
            t0 = false;
        } else {
            mytable.order([0, 'desc']).draw();
            t0 = true;
        }
    });
    $('.ts1').on('click', function () {
        if (t1) {
            mytable.order([1, 'asc']).draw();
            t1 = false;
        } else {
            mytable.order([1, 'desc']).draw();
            t1 = true;
        }
    });
    $('.ts2').on('click', function () {
        if (t2) {
            mytable.order([2, 'asc']).draw();
            t2 = false;
        } else {
            mytable.order([2, 'desc']).draw();
            t2 = true;
        }
    });
    $('.ts3').on('click', function () {
        if (t3) {
            mytable.order([3, 'asc']).draw();
            t3 = false;
        } else {
            mytable.order([3, 'desc']).draw();
            t3 = true;
        }
    });
    $('.ts4').on('click', function () {
        if (t4) {
            mytable.order([4, 'asc']).draw();
            t4 = false;
        } else {
            mytable.order([4, 'desc']).draw();
            t4 = true;
        }
    });
    $('.ts5').on('click', function () {
        if (t5) {
            mytable.order([5, 'asc']).draw();
            t5 = false;
        } else {
            mytable.order([5, 'desc']).draw();
            t5 = true;
        }
    });
    $('.ts6').on('click', function () {
        if (t6) {
            mytable.order([6, 'asc']).draw();
            t6 = false;
        } else {
            mytable.order([6, 'desc']).draw();
            t6 = true;
        }
    });
}


$('#modaldetail').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget)
    var MATNR = button.data('produk')
    //var id = button.data('id')
    //var modal = $(this)
    $.ajax({
        url: $("#base-url").val() + 'EC_Strategic_material/getDetail/' + MATNR,
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

    //$("#Category").val('');
    //$("#CODE_Category").val('');
    //console.log('nama: ', nama);
    //loadTableBPA(id);
});

$('#modalpenyedia').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget)
    var vendor_no = button.data('vendor')
    //var id = button.data('id')
    //var modal = $(this)
    $.ajax({
        url: $("#base-url").val() + 'EC_Ecatalog/getVendorNo/' + vendor_no,
        type: 'POST',
        dataType: 'json'
    }).done(function (data) {
        // console.log(data);
        $("#VENDOR_NAME").text(data[0].VENDOR_NAME == null ? "-" : data[0].VENDOR_NAME);
        $("#ADDRESS").text((data[0].ADDRESS_STREET == null ? "-" : data[0].ADDRESS_STREET) + ' ' + (data[0].NAMA == null ? "" : data[0].NAMA));
        $("#ADDRESS_COUNTRY").text(data[0].COUNTRY_NAME == null ? "-" : data[0].COUNTRY_NAME);
        $("#EMAIL_ADDRESS").text(data[0].EMAIL_ADDRESS == null ? "-" : data[0].EMAIL_ADDRESS);
        $("#ADDRESS_WEBSITE").text(data[0].ADDRESS_WEBSITE == null ? "-" : data[0].ADDRESS_WEBSITE);
        $("#NPWP_NO").text(data[0].NPWP_NO == null ? "-" : data[0].NPWP_NO);
        $("#CONTACT_NAME").text(data[0].CONTACT_NAME == null ? "-" : data[0].CONTACT_NAME);
        $("#CONTACT_PHONE_NO").text(data[0].CONTACT_PHONE_NO == null ? "-" : data[0].CONTACT_PHONE_NO);
        $("#CONTACT_EMAIL").text(data[0].CONTACT_EMAIL == null ? "-" : data[0].CONTACT_EMAIL);
    }).fail(function () {
        // console.log("error");
    }).always(function (data) {
        //console.log(data);
    });

    //$("#Category").val('');
    //$("#CODE_Category").val('');
    //console.log('nama: ', nama);
    //loadTableBPA(id);
});

$('#modalprincipal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget)
    var pc_code = button.data('principal')
    //var id = button.data('id')
    //var modal = $(this)
    $.ajax({
        url: $("#base-url").val() + 'EC_Ecatalog/getPrincipal/' + pc_code,
        type: 'POST',
        dataType: 'json'
    }).done(function (data) {
        // console.log(data);
        $("#PC_NAME").text(data.principal[0].PC_NAME == null ? "-" : data.principal[0].PC_NAME);
        $("#LOGO").attr('src', $("#base-url").val() + $("#UPLOAD_PATH").val() + "EC_principal_manufacturer/" + data.principal[0].LOGO);
        $("#ADDRESS_P").text(data.principal[0].ADDRESS == null ? "-" : data.principal[0].ADDRESS);
        $("#COUNTRY").text(data.principal[0].COUNTRY == null ? "-" : data.principal[0].COUNTRY);
        $("#MAIL").text(data.principal[0].MAIL == null ? "-" : data.principal[0].MAIL);
        $("#WEBSITE").text(data.principal[0].WEBSITE == null ? "-" : data.principal[0].WEBSITE);
        $("#PHONE").text(data.principal[0].PHONE == null ? "-" : data.principal[0].PHONE);
        $("#FAX").text(data.principal[0].FAX == null ? "-" : data.principal[0].FAX);
        $("#divPartner").empty();
        for (var i = 0; i < data.partner.length; i++) {
            teks = '<div class="row">'
            teks += '<div class="col-lg-3 text-center">' + (data.partner[i].VENDOR_NAME == null ? "-" : data.partner[i].VENDOR_NAME) + '</div>'
            teks += '<div class="col-lg-1 text-center">' + (data.partner[i].ADDRESS_COUNTRY == null ? "-" : data.partner[i].ADDRESS_COUNTRY) + '</div>'
            teks += '<div class="col-lg-2 text-center">' + (data.partner[i].ADDRESS_WEBSITE == null ? "-" : data.partner[i].ADDRESS_WEBSITE) + '</div>'
            teks += '<div class="col-lg-4 text-center">' + (data.partner[i].EMAIL_ADDRESS == null ? "-" : data.partner[i].EMAIL_ADDRESS) + '</div>'
            teks += '<div class="col-lg-2 text-center">' + (data.partner[i].ADDRESS_PHONE_NO == null ? "-" : data.partner[i].ADDRESS_PHONE_NO) + '</div>'
            teks += '</div>'
            $("#divPartner").append(teks)
        }
    }).fail(function () {
        // console.log("error");
    }).always(function (data) {
        //console.log(data);
    });

    //$("#Category").val('');
    //$("#CODE_Category").val('');
    //console.log('nama: ', nama);
    //loadTableBPA(id);
});

function startTimer(duration, display) {
    var start = Date.now(),
        diff,
        minutes,
        seconds;

    function timer() {
        // get the number of seconds that have elapsed since
        // startTimer() was called
        diff = duration - (((Date.now() - start) / 1000) | 0);

        // does the same job as parseInt truncates the float
        minutes = (diff / 60) | 0;
        seconds = (diff % 60) | 0;

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        display.textContent = minutes + ":" + seconds;

        if (diff <= 0) {
            // add one second so that the count down starts at the full duration
            // example 05:00 not 04:59
            start = Date.now() + 1000;
        }
    };
    // we don't want to wait a full second before the timer starts
    timer();
    setInterval(timer, 1000);
}
