var range_harga = ['-', '-'],
    base_url = $("#base-url").val(),
    kodeParent = $("#kodeParent").val(),
    searctTag = $("#tag").val(),
    urlll = '/get_data_pembelian_lgsg/',
    listMode = 1,
    compare = [],
    limitMin = 0,
    limitMax = 12,
    pageMax = 1,
    pageMaxOld = 0,
    mode = "list",
    compareCntrk = [],
    MIN = 9999999999999, 
    MAX = 1
function loadDataList() {
    $('.breadcrumb').empty()
    $('.breadcrumb').append('<li><a href="' + base_url + 'EC_Ecatalog"><span style="color:#e74c3c;"  class="glyphicon glyphicon-home" aria-hidden="true"></span></a><a onclick="setCode(\'-\',this)" href="javascript:void(0)">&nbsp;&nbsp;Home</a></li>')
    if (kodeParent != null && kodeParent != '-' && range_harga[0] == '-') {
        urlll = '/get_data_category/' + kodeParent;
        splitt = kodeParent.split("-")
        teks = splitt[0]
        for (var i = 0; i < splitt.length; i++) {
            $(".lvl" + (i + 1)).each(function() {
                if ($(this).data('kode') == teks) {
                    $('.breadcrumb').append('<li><a href="javascript:void(0)"  onclick="setCode(\'' + $(this).data('kode') + '\',this)" data-id="' + $(this).data('id') + '" data-kode="' + $(this).data('kode') + '" data-desc="' + $(this).data('desc') + '" >' + $(this).data('desc') + '</a></li>')
                }
            });
            teks += ('-' + splitt[i + 1])
        };
        getCategoryBread(kodeParent);
        // limitMin=(limitMin!=0)?0:0
    }
    if (searctTag != null && searctTag != '-') {
        urlll = '/get_data_tag/' + searctTag
        if ($('.breadcrumb').text().indexOf('Search') < 0) {
            $('.breadcrumb').empty()
            $('.breadcrumb').append('<li><span style="color:#e74c3c;"  class="glyphicon glyphicon-home" aria-hidden="true"></span><a onclick="setCode(\'-\',this)" href="javascript:void(0)">&nbsp;&nbsp;Home</a></li>')
            $('.breadcrumb').append('<li><a href="javascript:void(0)">Filter Search</a></li>')
            // $('.breadcrumb').append('<li><a href="javascript:void(0)"  onclick="setCode(\'' + $(this).data('kode') + '\',this)" data-id="' + $(this).data('id') + '" data-kode="' + $(this).data('kode') + '" data-desc="' + $(this).data('desc') + '" >' + $(this).data('desc') + '</a></li>')
        }
        // limitMin=(limitMin!=0)?0:0
    }

    $.ajax({
        url: $("#base-url").val() + 'EC_Ecatalog/get_data_pembelian_lgsg',
        data: {
            "search": searctTag,
            "kategori": kodeParent,
            "harga_min": range_harga[0],
            "harga_max": range_harga[1],
            "limitMin": limitMin,
            "limitMax": limitMax
        },
        type: 'POST',
        dataType: 'json'
    }).done(function (data) {
        var plant = null;
        $('.pagination').empty()
        pageMax = Math.ceil(data.page / 12)
        pageMaxOld = (pageMaxOld == 0) ? pageMax : pageMaxOld
        if (pageMax != pageMaxOld) {
            limitMin = 0
            pageMaxOld = 0
            loadDataList()
            return ''
        } else {
            pageMaxOld = pageMax
        }
        $('.pagination').append('<li><a href="javascript:paginationPrev(this)" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>')
        for (var i = 0; i < Math.ceil(data.page / 12); i++) {
            $('.pagination').append('<li class="' + (i == (limitMin / 12) ? "active" : "") + '"><a href="javascript:pagination(this,' + (i * 12) + ',' + ((i + 1) * 12) + ')">' + (i + 1) + '</a></li>')
        }
        $('.pagination').append('<li><a href="javascript:paginationNext(this)" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>')
        var matno = "'"
        $("#divAttributes").empty()
        if (data.data.length == 0)
            $("#divAttributes").append('<div class="row text-center">Data Tidak Ditemukan!!</div>')
        else
            for (var i = limitMin; i < data.data.length; i++) {
                if (mode == 'list') {
                    if (i == data.data.length - 1) {
                        teks = ('<div class="row" style=" margin:3px;">')
                    } else {
                        teks = '<div class="row" style=" margin:3px; border-bottom: 1px solid #ccc;">'
                    }
                    teks += ('<div class="row" style=" margin:3px; padding:3px;">')
                    teks += ('<div class="col-md-2" style="  padding-left: 5px;">')
                    teks += ('<a href="javascript:void(0)" data-backdrop="true" data-toggle="modal" data-target="#modaldetail" data-produk="' + data.data[i].MATNR + '">')
                    teks += ('<img src="' + $("#base-url").val() + $("#UPLOAD_PATH").val() + "EC_material_strategis/" + (data.data[i].PICTURE==null?'default_post_img.png':data.data[i].PICTURE) + '" class="img-responsive"></a>')
                    teks += ('</div>' + '<div class="col-md-4" style="  padding-left: 35px;">' + '<div class="row" style="font-size:11px">Kategori: ' + data.data[i].DESC + '</div>')
                    teks += ('<div class="row" style="font-size:16px">')
                    teks += ('<strong><a href="javascript:void(0)" data-backdrop="true" data-toggle="modal" data-target="#modaldetail" data-produk="' + data.data[i].MATNR + '">' + data.data[i].MAKTX + '</a></strong></div>')
                    teks += ('</div>')
                    teks += ('<div class="col-md-4" style="padding-left: 35px;"><div class="row" style="font-size:14px;color: #E74C3C;">')
                    teks += ('<strong>Plant: ' + data.data[i].PLANT + " &mdash; " + data.data[i].NAMA_PLANT + '</strong></div>')
                    teks += ('<div class="row" style="font-size:14px">Harga: <span id="lblprice"><strong>' + data.data[i].CURRENCY + ' ' + numberWithCommas(data.data[i].HARGA) + ' /' + data.data[i].MEINS + '</strong></span></div>')
                    teks += '<input type="hidden" class="hargasss" value="' + data.data[i].HARGA + '" />'
                    teks += ('<div class="row" style="font-size:12px;">Delivery Time:<strong> ' + data.data[i].DELIVERY_TIME + ' Days</strong></div>')
                    teks += ('<div class="row" style="font-size:12px;">STOK:<strong> ' + data.data[i].STOK + ' </strong></div>')
                    teks += ('</div>' + '<div class="col-md-2">' + '<form class="form-horizontal">' )
                    // teks += ('<a href="' + base_url + 'EC_Ecatalog/detail_prod_langsung/' + data.data[i].MATNR + '/' + data.data[i].KODE_DETAIL_PENAWARAN + '" style="font-size:12px;box-shadow: 1px 1px 1px #ccc"  class="btn btn-primary form-control beli"><i class="glyphicon glyphicon-usd" ></i>&nbsp&nbspBuy</a>' )
                    teks += ('<a href="javascript:void(0)" onclick="buyOneCheck(this,\'' + data.data[i].MATNR + '\',\'' + data.data[i].KODE_DETAIL_PENAWARAN + '\',\'' + data.data[i].ID_CAT + '\')" style="font-size:12px;box-shadow: 1px 1px 1px #ccc"  class="btn btn-primary form-control beli"><i class="glyphicon glyphicon-usd" ></i>&nbsp&nbspBuy</a>' )
                    teks += ('<p></p><a href="javascript:void(0)" style="font-size:12px;padding: 5px;box-shadow: 1px 1px 1px #ccc" class="btn btn-info form-control beli"  onclick="addCart(this,\'' + data.data[i].MATNR + '\',\'PL2017\',\'' + data.data[i].KODE_DETAIL_PENAWARAN + '\',\'' + data.data[i].ID_CAT + '\')"><i class="glyphicon glyphicon-shopping-cart"></i> Add to Cart</a>' )
                    teks += ('<p></p><a href="javascript:addCompare(this,\'' + data.data[i].MATNR + '\',\'PL2017\',' + data.data[i].KODE_DETAIL_PENAWARAN + ',\'' + data.data[i].ID_CAT + '\')" style="box-shadow: 1px 1px 1px #ccc;font-size:12px;" class="btn btn-warning form-control" style="padding: 5px;"><i class="glyphicon glyphicon-tasks"></i>&nbspCompare</a>' + '</form>' + '</div>' + '</div>' + '</div>')
                } else {
                    teks = ''
                    if (i % 3 == 0 || i == 0) {
                        teks += '<div class="row">'
                        teks += '</div>'
                    }
                    ;
                    teks += '<div class="col-md-4 kotak" onmouseleave="remvHover(this)" onmouseenter="hoverMouse(this)">'
                    teks += '<div class="row" style="padding:20px; height:250px; width:250px; margin: 0 auto;">'
                    teks += ('<a href="javascript:void(0)" data-backdrop="true" data-toggle="modal" data-target="#modaldetail" data-produk="' + data.data[i].MATNR + '">')
                    teks += ('<img src="' + $("#base-url").val() + $("#UPLOAD_PATH").val() + "EC_material_strategis/" + (data.data[i].PICTURE==null?'default_post_img.png':data.data[i].PICTURE) + '" class="img-responsive"></a>')
                    teks += '</div>'
                    teks += '<div class="row" style="font-size:11px;padding-left:5px;padding-right:5px;">Kategori: ' + data.data[i].DESC + '</div>'
                    teks += ('<div class="row" style="font-size:16px;padding-left:5px;padding-right:5px; height:50px;">')
                    teks += ('<strong><a href="javascript:void(0)" data-backdrop="true" data-toggle="modal" data-target="#modaldetail" data-produk="' + data.data[i].MATNR + '">' + data.data[i].MAKTX + '</a></strong></div>')
                    teks += ('<div class="row" style="font-size:14px;padding-left:5px;padding-right:5px; color: #E74C3C;"><strong>Plant: ' + data.data[i].PLANT + " &mdash; " + data.data[i].NAMA_PLANT + '<strong></div>')

                    teks += ('<div class="row" style="font-size:14px;padding-left:5px;padding-right:5px;">Harga: <span id="lblprice"><strong>' + data.data[i].CURRENCY + ' ' + numberWithCommas(data.data[i].HARGA) + ' /' + data.data[i].MEINS + '</strong></span></div>')
                    teks += ('<div class="row" style="font-size:12px;padding-left:5px;padding-right:5px;">Delivery Time: <strong> ' + data.data[i].DELIVERY_TIME + ' Days</strong></div>')
                    teks += ('<div class="row" style="font-size:12px;padding-left:5px;padding-right:5px;">Stok: <strong> ' + data.data[i].STOK + ' </strong></div>')
                    // teks += ('<div class="row" style="font-size:12px;padding-left:5px;padding-right:5px;">Open Kuantitas : ' + numberWithCommas(data.data[i][6]) + ' ' + data.data[i][13] + '</div>')
                    // teks += ('<div class="row" style="font-size:12px;padding-left:5px;padding-right:5px;">Nomor kontrak: ' + data.data[i][5] + '</div>')
                    // teks += ('<div class="row" style="font-size:12px;padding-left:5px;padding-right:5px;">Penyedia: <a href="javascript:void(0)" data-backdrop="true" data-toggle="modal" data-target="#modalpenyedia" data-vendor="' + data.data[i][14] + '">' + data.data[i][7] + '</a></div>')
                    // teks += ('<div class="row" style="font-size:12px;padding-left:5px;padding-right:5px;">Principal: <a href="javascript:void(0)" data-backdrop="true" data-toggle="modal" data-target="#modalprincipal" data-principal="' + data.data[i][8] + '">' + data.data[i][8] + '</a></div>')
                    // teks += ('<div class="row" style="font-size:12px;padding-left:5px;padding-right:5px; color:' + color + '"><strong>Tanggal Berlaku: ' + data.data[i][9].substring(6) + '/' + data.data[i][9].substring(4, 6) + '/' + data.data[i][9].substring(0, 4) + ' - ' + data.data[i][10].substring(6) + '/' + data.data[i][10].substring(4, 6) + '/' + data.data[i][10].substring(0, 4) + '</strong></div>')

                    teks += '<div class="row" style="padding-left:35px">'
                    teks += '<a href="javascript:void(0)" onclick="buyOneCheck(this,\'' + data.data[i].MATNR + '\',\'' + data.data[i].KODE_DETAIL_PENAWARAN + '\',\'' + data.data[i].ID_CAT + '\')" style="font-size:12px;margin:5px;width:80%;box-shadow: 2px 2px 2px 2px #ccc"  class="btn btn-primary form-control beli"><i class="glyphicon glyphicon-usd" ></i>&nbsp&nbspBuy</a>'
                    teks += '<a href="javascript:void(0)" style="font-size:12px;padding: 5px;margin:5px;width:80%;box-shadow: 2px 2px 2px 2px #ccc" class="btn btn-info form-control beli"  onclick="addCart(this,\'' + data.data[i].MATNR + '\',\'PL2017\',\'' + data.data[i].KODE_DETAIL_PENAWARAN + '\',\'' + data.data[i].ID_CAT + '\')"><i class="glyphicon glyphicon-shopping-cart"></i> Add to Cart</a>'
                    teks += '<a href="javascript:addCompare(this,\'' + data.data[i].MATNR + '\',\'PL2017\',' + data.data[i].KODE_DETAIL_PENAWARAN + ',\'' + data.data[i].ID_CAT + '\')" style="font-size:12px;margin:5px;width:80%;box-shadow: 2px 2px 2px 2px #ccc" class="btn btn-warning form-control" style="padding: 5px;"><i class="glyphicon glyphicon-tasks"></i>&nbspCompare</a>'
                    teks += '</div>'
                    teks += '</div>'
                }
                $("#divAttributes").append(teks)

            }
        // }

        if (MAX == 1 && MIN == 9999999999999)
            $(".hargasss").each(function () {
                MIN = MIN > $(this).val() ? $(this).val() : MIN
                MAX = MAX > $(this).val() ? $(this).val() : MAX
            });
        if (window.location.pathname.indexOf('listCatalog') > -1)
            $("#ex2").slider({
                min: parseInt(MAX),
                max: parseInt(MIN),
                value: [parseInt(MAX / 2), parseInt(MIN)],
                step: 10
            })
    }).fail(function () {
        // console.log("error");
    }).always(function (data) {
        // console.log(data);

    });

}

function remvHover(elm) {
    $(elm).css("border", "0px solid #fff");
    $(elm).css("box-shadow", "0px 0px 0px #ccc");
}

function hoverMouse(elm) {
    $(elm).css("border", "1px solid #ccc");
    $(elm).css("box-shadow", "1px 1px 1px #ccc");
}

function pagination(elm, min, maks) {
    limitMin = min
    limitMax = maks
    loadDataList()
}

function paginationPrev(elm) {
    if (limitMin >= 12) {
        limitMin -= 12
        limitMax -= 12
        loadDataList()
    };
}

function paginationNext(elm) {
    if (limitMax < (pageMax * 12)) {
        limitMin += 12
        limitMax += 12
        loadDataList()
    };
}

function getCategoryBread(id) {
    $(".abuu").each(function () {
        $(this).css('color', '#666')
        if ($(this).data('kode') == id)
            $(this).css('color', '#e74c3c')
    });
    return ''
}


$("#formsearch").submit(function (event) {
    event.preventDefault();
    searctTag = $('#txtsearch').val()
    kodeParent = '-'
    loadDataList()
});

$('#modalBeli').on('show.bs.modal', function (event) {
    $('#maktx2').text($('#maktx').text())
    $('#jmlItm').text($('.qtyy').val() + " " + $('#MEINS').val())
    $('#totalBiaya').text($('#totall').text())
    $.ajax({
        url: $("#base-url").val() + 'EC_Ecatalog/GET_MATERIALGLACCOUNT/' + $('#MATNO').val() + "/" + $('#plant').val(),
        type: 'POST',
        dataType: 'json'
    }).done(function (data) {
        // console.log(data);
    }).fail(function (data) {
        // console.log("error");
        // $("#pocreated").text(data['RETURN'][0]['MESSAGE'])
    }).always(function (data) {
        if (data.length > 0)
            $('#kdcmtn').text(data[0].TXT50 + "  (" + data[0].KONTS + ")")
        console.log()
    })
});

//  onclick="buyOne(this,\'' + data.data[i][1] + '\',\'' + data.data[i][5] + '\',\'' + data.data[i][1] + '\')"
function buyOne(elm, id, contract_no, matno, kode_penawaran) {
    // console.log(qty + " < " + $("#avl").val() + "  " + $("#sisa").val())
    // qty = parseInt($(".qtyy").val())
    //if (confirm("Konfirmasi Order?"))
    // if (qty > 0 && $(".qtyy").val().search(/[A-Za-z]/g) == -1)//
    // if (qty < $("#avl").val())
    // if ($("#sisa").val() > 0)
    $.ajax({
        url: $("#base-url").val() + 'EC_Ecatalog/confirmOneLgsg/',
        data: {
            "qty": $(".qtyy").val(),
            "company": $("#selComp").val(),
            "kode_penawaran": kode_penawaran,
            "contract_no": contract_no,
            "matno": matno,
            "plant": $("#plant").val(),
            "alamat": $("#alamat").val(),
            "cp": $("#cp").val(),
            "gl": $("#gl").val(),
            "curr": $("#curre").val()
        },
        type: 'POST',
        dataType: 'json'
    }).done(function (data) {
        // console.log(data);
    }).fail(function (data) {
        // console.log("error");
        // $("#pocreated").text(data['RETURN'][0]['MESSAGE'])
    }).always(function (data) {
        console.log(data)
        // $("#statsPO").text(data)

        /*$('#tbodyPO').empty()
         if (data.indexOf("created") > 0)
         $('#tbodyPO').text(data)
         else
         for (var i = 0; i < data.length; i++) {
         $('#tbodyPO').append('<tr></tr>')
         $('#tbodyPO tr:eq(' + i + ')').append('<td>' + data[i].TYPE + '</td>')
         $('#tbodyPO tr:eq(' + i + ')').append('<td>' + (data[i].MESSAGE) + '</td>')
         $('#tbodyPO tr:eq(' + i + ')').append('<td>' + (data[i].MESSAGE_V1) + '</td>')
         $('#tbodyPO tr:eq(' + i + ')').append('<td>' + (data[i].PARAMETER) + '</td>')
         }*/

        var cnt = 0;
        $('#tbodyPO').empty()

        if(data.suksesReturn.length > 0){
            $('#tbodyPO').append('<tr><td>Sukses: </td></tr>')
            for (var i = 0; i < data.suksesReturn.length; i++) {
                $('#tbodyPO').append('<tr></tr>')
                $('#tbodyPO tr:eq(' + (i + 1) + ')').append('<td>PO: ' + data.suksesReturn[i].PO + '</td>')
                $('#tbodyPO tr:eq(' + (i + 1) + ')').append('<td>' + data.suksesReturn[i].VENDOR_NAME + '</td>')
                $('#tbodyPO tr:eq(' + (i + 1) + ')').append('<td>' + data.suksesReturn[i].MAKTX + " &mdash; " + data.suksesReturn[i].MATNO + '</td>')
                $('#tbodyPO tr:eq(' + (i + 1) + ')').append('<td>' + (data.suksesReturn[i].PLANT) + '</td>')
                $('#tbodyPO tr:eq(' + (i + 1) + ')').append('<td>' + (data.suksesReturn[i].NAMA_PLANT) + '</td>')
            }
        }
        

        if(data.gagalReturn.length > 0){
            //console.log('masuk');
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
//        var fiveMinutes = 10,
//            display = document.querySelector('#dtk');
//        startTimer(fiveMinutes, display);
//        setTimeout(function () {
//            // window.location.reload();
//            window.location=$("#base-url").val() + 'EC_Ecatalog/listCatalogLsgs/';
//        }, 10000);
    });
    // else
    // alert('Budget Exceeded!!')
    // else
    // alert('Maksimal jumlah order: ' + $("#avl").val() + ' !!')
    // else {
    // alert('Minimal 1 dan hanya angka!!')
    // $(elm).val($(elm).data('old'))
    // }
}

function chgPic(id, path) {
    //'.base_url(UPLOAD_PATH).'/material_strategis/'.
    $("#picSRC").attr('src', $("#base-url").val() + 'upload/EC_material_strategis/' + path)
}

function addCart(elm, matno, contract_no, kode_penawaran, category) {
    var COSCENTER = '1';
    $.ajax({
        url : $("#base-url").val() + 'EC_Ecatalog/cekAuthorize/',
        data : {
            "id_category" : category            
        },
        type : 'POST',
        dataType : 'json'
    }).done(function(data) {
        // console.log(data.sukses);
        if(data.sukses){
            $.ajax({
                url: $("#base-url").val() + 'EC_Ecatalog/addCart/' + matno,
                data: {
                    "contract_no": contract_no,
                    "kode_penawaran": kode_penawaran,
                    "COSCENTER": COSCENTER
                },
                type: 'POST',
                dataType: 'json'
            }).done(function (data) {
                // console.log(data);
                $(".jml").text(data);
            }).fail(function () {
                // console.log("error");
            }).always(function (data) {
                //console.log(data);
            });
        }else{
            bootbox.alert("You don't have authorized");
        }
        // console.log(cek);
    }).fail(function() {
        // console.log("error");
    }).always(function(data) {
        //console.log(data);
    });
}

function addCompare2(elm, matno, contract_no) {
    // console.log("id : " + id + " " + compare.indexOf(id));
    // if ((id != 'null' && matno != null) && (compare.indexOf(matno) < 0)) {
    compare.push(matno);
    compareCntrk.push(contract_no);
    $(elm).attr('enabled', false)
    // }

    $("#compare").text('Compare (' + compare.length + ')');
    $("#arr").val(compare)
    $("#arrC").val(compareCntrk)
    // console.log("compare : " + $("#arr").val());
}

function addCompare(elm, matno, contract_no, kode_p, category) {
    console.log(matno + ' ' + contract_no)
    $.ajax({
        url : $("#base-url").val() + 'EC_Ecatalog/cekAuthorize/',
        data : {
            "id_category" : category            
        },
        type : 'POST',
        dataType : 'json'
    }).done(function(data) {
        // console.log(data.sukses);
        if(data.sukses){
            $.ajax({
                url: $("#base-url").val() + 'EC_Ecatalog/addCompare_pl/' + matno,
                data: {
                    "contract_no": contract_no,
                    "kode": kode_p
                },
                type: 'POST',
                dataType: 'json'
            }).done(function (data) {
                $(".jmlCompare").text(data);
            }).fail(function () {
                // console.log("error");
            }).always(function (data) {
                console.log('cmp ' + data);
            });
        }else{
            bootbox.alert("You don't have authorized");
        }
        // console.log(cek);
    }).fail(function() {
        // console.log("error");
    }).always(function(data) {
        //console.log(data);
    });
}

function buyOneCheck(elm, matno, kode_penawaran, category) {
    // console.log(matno + ' ' + contract_no)
    $.ajax({
        url : $("#base-url").val() + 'EC_Ecatalog/cekAuthorize/',
        data : {
            "id_category" : category            
        },
        type : 'POST',
        dataType : 'json'
    }).done(function(data) {
        // console.log(data.sukses);
        if(data.sukses){
            window.location=$("#base-url").val() + 'EC_Ecatalog/detail_prod_langsung/'+matno+'/'+kode_penawaran;
        }else{
            bootbox.alert("You don't have authorized");
        }
        // console.log(cek);
    }).fail(function() {
        // console.log("error");
    }).always(function(data) {
        //console.log(data);
    });
}

function getCategory(KODE_USER) {
    // $.ajax({
    // url : $("#base-url").val() + 'EC_Ecatalog/listCatalog/' + KODE_USER,
    // data : {
    // "checked" : null
    // },
    // type : 'POST',
    // dataType : 'json'
    // }).done(function(data) {
    // }).fail(function() {
    // console.log("error");
    // }).always(function(data) {
    // //console.log(data);
    // });

}

function numberWithCommas(x) {
    return x == 0 || x == null ? '' : x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

$('#modalPO').on('hidden.bs.modal', function (event) {
    window.location=$("#base-url").val() + 'EC_Ecatalog/listCatalogLsgs/';
});

$('#modalpenyedia').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget)
    var vendor_no = button.data('vendor')
    $("#VENDOR_NAME").text("Loading Data.....");
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
    $("#PC_NAME").text("Loading Data.....");
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

$('#modaldetail').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget)
    var MATNR = button.data('produk')
    $("#detail_MATNR").text("Loading Data.....");
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

function loadTree() {
    $('#tree1').empty()
    $.ajax({
        url: $("#base-url").val() + 'EC_Master_category/get_data/',
        type: 'POST',
        dataType: 'json'
    }).done(function (data) {
        // console.log('cat '+data[0]);
        // cate.push(data)
        // setCat(data)
        // console.log('catt ' + cate[5].DESC)
        for (var i = 0,
                 j = data.length; i < j; i++) {
            if (data[i].KODE_PARENT == '0') {
                $('#tree1').append('<li><a href="javascript:void(0)" onclick="setCode(\'' + data[i].KODE_USER + '\',this)" data-id="' + data[i].ID_CAT + '" data-kode="' + data[i].KODE_USER + '" data-desc="' + data[i].DESC + '" class="lvl1 abuu" style="color:#666;font-size: 13px;">' + data[i].DESC + '</a><ul></ul></li>');
            }
            ;
        }
        ;
        $(".lvl1").each(function () {
            for (var i = 0,
                     j = data.length; i < j; i++) {
                if ($(this).data('id') == data[i].KODE_PARENT) {
                    $(this).next().append('<li><a href="javascript:void(0)" onclick="setCode(\'' + data[i].KODE_USER + '\',this)" data-id="' + data[i].ID_CAT + '" data-kode="' + data[i].KODE_USER + '" data-desc="' + data[i].DESC + '"  class="lvl2 abuu"  style="color:#666;font-size: 13px;">' + data[i].DESC + '</a><ul></ul></li>');
                }
                ;
            }
            ;
        });

        $(".lvl2").each(function () {
            for (var i = 0,
                     j = data.length; i < j; i++) {
                if ($(this).data('id') == data[i].KODE_PARENT) {
                    $(this).next().append('<li><a href="javascript:void(0)" onclick="setCode(\'' + data[i].KODE_USER + '\',this)" data-id="' + data[i].ID_CAT + '" data-kode="' + data[i].KODE_USER + '"  data-desc="' + data[i].DESC + '" class="lvl3 abuu" style="color:#666;font-size: 13px;">' + data[i].DESC + '</a><ul></ul></li>');
                }
                ;
            }
            ;
        });

        $(".lvl3").each(function () {
            for (var i = 0,
                     j = data.length; i < j; i++) {
                if ($(this).data('id') == data[i].KODE_PARENT) {
                    $(this).next().append('<li><a href="javascript:void(0)" onclick="setCode(\'' + data[i].KODE_USER + '\',this)" data-id="' + data[i].ID_CAT + '" data-kode="' + data[i].KODE_USER + '"  data-desc="' + data[i].DESC + '" class="lvl4 abuu" style="color:#666;font-size: 13px;">' + data[i].DESC + '</a><ul></ul></li>');
                }
                ;
            }
            ;
        });

        $(".lvl4").each(function () {
            for (var i = 0,
                     j = data.length; i < j; i++) {
                if ($(this).data('id') == data[i].KODE_PARENT) {
                    $(this).next().append('<li><a href="javascript:void(0)" onclick="setCode(\'' + data[i].KODE_USER + '\',this)" data-id="' + data[i].ID_CAT + '" data-kode="' + data[i].KODE_USER + '"  data-desc="' + data[i].DESC + '" class="lvl5 abuu" style="color:#666;font-size: 13px;">' + data[i].DESC + '</a><ul></ul></li>');
                }
                ;
            }
            ;
        });

        $(".lvl5").each(function () {
            for (var i = 0,
                     j = data.length; i < j; i++) {
                if ($(this).data('id') == data[i].KODE_PARENT) {
                    $(this).next().append('<li><a href="javascript:void(0)" onclick="setCode(\'' + data[i].KODE_USER + '\',this)" data-id="' + data[i].ID_CAT + '" data-kode="' + data[i].KODE_USER + '"  data-desc="' + data[i].DESC + '" class="lvl6 abuu" style="color:#666;font-size: 13px;">' + data[i].DESC + '</a><ul></ul></li>');
                }
                ;
            }
            ;
        });
        if (window.location.pathname.indexOf('list') > -1) {
            $('#tree1').treed();
            $('#tree1 .branch').each(function () {
                var icon = $(this).children('a:first').children('i:first');
                icon.toggleClass('glyphicon-minus-sign glyphicon-plus-sign');
                $(this).children().children().toggle();

            });
        }
    }).fail(function () {
        console.log("error");
    }).always(function (data) {
        loadDataList();
        $("ul").each(function () {
            if ($(this).find('a').length < 1)
                $(this).prev().prev().empty()
        });
    });
    // $('.lvl3').parent.removeChild(d)
}

function setCode(id, elm) {
    $(".abuu").each(function () {
        $(this).css('color', '#666')
    });
    $(elm).css('color', '#e74c3c')
    base_url = $("#base-url").val()
    kodeParent = id
    if (id == '-') {
        kodeParent = "-"
        searctTag = "-"
        MIN = 9999999999999
        MAX = 1
        range_harga = ['-', '-']
    }
    loadDataList();
}

function modeList(model) {
    mode = model
    loadDataList()
}

budget = 0;
var harga = 0;
var dataBudget = 0;
$(document).ready(function () {
    // $(document).on("click",".img-responsive",function() {
    //     alert("click");
    // });
    loadTree()

    $('label.tree-toggler').click(function () {
        $(this).parent().children('ul.tree').toggle(300);
    });
    /***********************************************/
    $.ajax({
        url: $("#base-url").val() + 'EC_Ecatalog/get_data_cart_langsg/',
        type: 'POST',
        dataType: 'json'
    }).done(function (data) {
        console.log(data);
        $(".jml").text(data.jumlah);
        $(".budget").text(numberWithCommas(data.budget));
        $(".jmlCompare").text(data.compare)

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
            // $("#budgett").text('Rp ' + numberWithCommas(data.budget));
            $("#hid_current_budget").val(data.budget);
        }
        budget = data.budget
        $("#budgett").text($("#curre").val() + " " + numberWithCommas(data.budget));
        //var dataBudget = $("#budgettt").text().split(",")
        dataBudget = $("#budgettt").val()
        var totalbeli = $("#totall").text().replace(".", ""); 
        console.log("dataBudget: "+dataBudget);
        console.log("totalbeli: "+totalbeli);
        //$("#totalsisa").text($("#curre").val() + " " + numberWithCommas(data.budget));
        //$("#totalsisa").text($("#curre").val() + " " + numberWithCommas(dataBudget));
        //$("#totalsisa").text($("#curre").val() + " " + numberWithCommas(data.budget));
        $("#totalsisa").text(numberWithCommas(dataBudget-totalbeli));
        // $("#buyyy").removeAttr('disabled')
    }).fail(function () {
        // console.log("error");
    }).always(function (data) {
        //console.log(data);
    });
    /***********************************************/
    if (window.location.pathname.indexOf('listCatalog') > -1) {
        // $.ajax({
        // url : $("#base-url").val() + 'EC_Ecatalog/rangeHargaLgsg/ssssssssssss',
        // type : 'POST',
        // dataType : 'json'
        // }).done(function(data) {
        // // console.log('range ' + data[0].MAX + "-" + data[0].MIN);
        // $("#ex2").slider({
        // min : parseInt(data[0].MIN),
        // max : parseInt(data[0].MAX),
        // value : [parseInt(data[0].MAX / 4), parseInt(data[0].MIN / 4)],
        // step : 10
        // })
        // // $("#ex2").data('slider').setValue([data[0].MAX, data[0].MIN])
        // }).fail(function() {
        // // console.log("error");
        // }).always(function(data) {
        // //console.log(data);
        // });

        $("#ex2").on("slideStop", function (slideEvt) {
            $("#txtharga").val(numberWithCommas(slideEvt.value[0]) + " - " + numberWithCommas(slideEvt.value[1]))
            // console.log(slideEvt.value)
        });
        $("#btnTampilkan").on("click", function () {
            range_harga = $("#ex2").data('slider').getValue()
            loadDataList()
        })
        $("#removeTAG").on("click", function () {
            $("#txtsearch").val('');
        })
    }

    /***********************************************/
    $('#listmode').on('change', function (e) {
        var optionSelected = $("option:selected", this);
        listMode = this.value;
        console.log(listMode)
        if (listMode == 2) {
            // $(location).attr('href', $("#base-url").val() + 'EC_Ecatalog/listCatalogLsgs')
        } else if (listMode == 1) {
            $(location).attr('href', $("#base-url").val() + 'EC_Ecatalog/listCatalog')
        } else if (listMode == 3) {
            // $(location).attr('href', $("#base-url").val() + 'EC_Ecatalog/listCatalogLsgs')
        }
    });
    /***********************************************/
    $(".qtyy").val('1')
    $("#buyyy").prop('disabled', false);
    $("#buyOne").on("click", function () {
        // console.log($('#KODE_PENAWARAN').val())
        buyOne(this, '000', 'PL2017', $('#MATNO').val(), $('#KODE_PENAWARAN').val())
    })
    harga = $("#harga1").val()

    //var dataBudget = $("#budgettt").text().split(".")
    //var dataBudget = $("#budgettt").val()
    //dataBudget[0]*=(($("#budgettt").text().indexOf('-') > -1) ? ((-1)) : (1))
    $(".qtyy").change(function () {
        if($(this).val()==0){
            $(".qtyy").val('1')
        }
        if ($(this).val() > 0 && $(this).val().search(/[A-Za-z]/g) == -1) {
            $("#buyyy").prop('disabled', false);
            // console.log('Rp ' + ($(this).val() +" "+ harga))
            //$("#totall").text($("#curre").val() + " " + numberWithCommas($(this).val() * harga))
            $("#totall").text(numberWithCommas($(this).val() * harga))
            // var dataBudget = $("#budgettt").text().split(".")
            //$("#totalsisa").text($("#curre").val() + ' ' + numberWithCommas(budget - ($(this).val() * harga)));
            $("#totalsisa").text(numberWithCommas(dataBudget - ($(this).val() * harga)));
            //(($("#budgettt").text().indexOf('-') > -1) ? "-" : "") +
            //$("#totalsisa").text($("#curre").val() + ' ' +  numberWithCommas(dataBudget[0] - ($(this).val() * harga)));
            $("#sisa").val(budget - ($(this).val() * harga))
            if ($("#budgettt").text().indexOf('-') > -1) {
                $("#excd").text('Budget Exceeded!!!')
                // $("#buyyy").prop('disabled', true);
            }
            else {
                $("#excd").text(' ')
                // $("#buyyy").prop('disabled', false);
            }
        }
    });
    $(".qtyy").keyup(function () {
        // console.log($(this).val()+" "+harga+" "+budget)
        if($(this).val()==0){
            $(".qtyy").val('1')
        }
        if ($(this).val() > 0 && $(this).val().search(/[A-Za-z]/g) == -1) {
            $("#buyyy").prop('disabled', false);
            // console.log('Rp ' + ($(this).val() +" "+ harga))
            //$("#totall").text($("#curre").val() + " " + numberWithCommas($(this).val() * harga))
            $("#totall").text(numberWithCommas($(this).val() * harga))
            // var dataBudget = $("#budgettt").text().split(".")
            //$("#totalsisa").text($("#curre").val() + ' ' + numberWithCommas(budget - ($(this).val() * harga)));
            $("#totalsisa").text(numberWithCommas(dataBudget - ($(this).val() * harga)));
            //(($("#budgettt").text().indexOf('-') > -1) ? "-" : "") +
            //$("#totalsisa").text($("#curre").val() + ' ' +  numberWithCommas(dataBudget[0] - ($(this).val() * harga)));
            $("#sisa").val(budget - ($(this).val() * harga))
            if ($("#budgettt").text().indexOf('-') > -1) {
                $("#excd").text('Budget Exceeded!!!')
                // $("#buyyy").prop('disabled', true);
            }
            else {
                $("#excd").text(' ')
                // $("#buyyy").prop('disabled', false);
            }
        }
    });
    /*$(".qtyy").keyup(function () {
        // console.log($(this).val()+" "+harga+" "+budget)
        if ($(this).val() > 0 && $(this).val().search(/[A-Za-z]/g) == -1) {
            $("#buyyy").prop('disabled', false);
            dataBudget[0]*(($("#budgettt").text().indexOf('-') > -1) ? ((-1)) : (1))
            $("#totall").text($("#curre").val() + " " + numberWithCommas($(this).val() * harga))
            $("#totalsisa").text($("#curre").val() + ' ' + numberWithCommas(budget - ($(this).val() * harga)));
            //(($("#budgettt").text().indexOf('-') > -1) ? "-" : "")+
            $("#totalsisa").text($("#curre").val() + ' ' +   numberWithCommas(dataBudget[0] - ($(this).val() * harga)));
            $("#sisa").val(budget - ($(this).val() * harga))
            if ($("#budgettt").text().indexOf('-') > -1) {
                $("#excd").text('Budget Exceeded!!!')
                // $("#buyyy").prop('disabled', true);
            }
            else {
                $("#excd").text(' ')
                // $("#buyyy").prop('disabled', false);
            }
        }
    });*/

    if (window.location.pathname.indexOf('detail_prod_langsung') > -1) {
        var CCopt = $(".select2").select2({
            dropdownParent: $('#modalBeli')
        });
        CCopt.on("select2:select", function (e) {
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
    }

    var CCopt = $(".CC").select2({
        dropdownParent: $('#modalbudget')
    });
    CCopt.on("select2:select", function (e) {
        console.log($(this).val())
        loadTableBG($(this).val())
        // table.ajax.url($("#base-url").val() + 'EC_Ecatalog/GET_REPORTBUDGET/' + $(this).val()).load();
    });
});

$('#modalBeli').on('show.bs.modal', function (event) {
    //console.log($("#CCopt").val());    
    loadTable($("#CCopt").val());
});

$('#modalbudget').on('show.bs.modal', function (event) {
    //console.log($("#group_jasa_id").val());
    //$("#group_jasa_id").select2("val", $("#group_jasa_id").val());
    loadTableBG($("#group_jasa_id").val());
});

$('#modalbudgetDetail').on('show.bs.modal', function (event) {
    console.log($("#budgetcc").val());
    //$("#group_jasa_id").select2("val", $("#group_jasa_id").val());
    loadTableBG($("#budgetcc").val());
});

$('#modalbudget').on('hidden.bs.modal', function (event) {
    //console.log($("#nameCC").val());
    //$("#group_jasa_id").select2($("#nameCC").val());
    //$("#group_jasa_id").select2("val", $("#nameCC").val());
    //$("#group_jasa_id").val($("#nameCC").val())
    //loadTableBG('');
});

function loadTableBG(cost_center) {
    // no = 1;
    CC = cost_center.split(':')
    $('#tableCCBG').DataTable().destroy();
    $('#tableCCBG tbody').empty();
    mytable = $('#tableCCBG').DataTable({
        "bSort": true,
        "dom": 'rtlip',
        "deferRender": true,
        "language": {
            "loadingRecords": "<center><b>Please wait - Updating and Loading Cost Center...</b></center>"
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
                    a += numberWithCommas(parseInt(full.FKBTR_CB)*100);
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
                //a += full.FKBTR_AB;
                a += numberWithCommas(parseInt(full.FKBTR_AB)*100);
                a += "</div>";
                return a;
                // }else return "";
            }
        }, {
            mRender: function (data, type, full) {
                //console.log(full[6]);
                a = ''
                a += "<div class='col-md-12 text-center'>";
                //a += full.WLJHR;
                a += numberWithCommas(parseInt(full.WLJHR)*100);
                a += "</div>";
                return a;
            }
        }, {
            mRender: function (data, type, full) {
                // if(full[6] != null){
                a = ''
                a += "<div class='col-md-12 text-center'>";
                //a += full.AVAILBUDGET;
                a += numberWithCommas(parseInt(full.AVAILBUDGET)*100);
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
                    a += numberWithCommas(parseInt(full.FKBTR_CB)*100);
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
                a += numberWithCommas(parseInt(full.FKBTR_AB)*100);
                a += "</div>";
                return a;
                // }else return "";
            }
        }, {
            mRender: function (data, type, full) {
                //console.log(full[6]);
                a = ''
                a += "<div class='col-md-12 text-center'>";
                a += numberWithCommas(parseInt(full.WLJHR)*100);
                a += "</div>";
                return a;
            }
        }, {
            mRender: function (data, type, full) {
                // if(full[6] != null){
                a = ''
                a += "<div class='col-md-12 text-center'>";
                a += numberWithCommas(parseInt(full.AVAILBUDGET)*100);
                a += "</div>";
                return a;
                // }else return "";
            }
        }],
    });

}

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

function minqtycart() {
    $(".qtyy").val((parseInt($(".qtyy").val())-1))
    if($(".qtyy").val()==0){
        $(".qtyy").val('1')
    }
        
        $("#buyyy").prop('disabled', false);
            // console.log('Rp ' + ($(this).val() +" "+ harga))
            //$("#totall").text($("#curre").val() + " " + numberWithCommas($(this).val() * harga))
            $("#totall").text(numberWithCommas($(".qtyy").val() * harga))
            // var dataBudget = $("#budgettt").text().split(".")
            //$("#totalsisa").text($("#curre").val() + ' ' + numberWithCommas(budget - ($(this).val() * harga)));
            $("#totalsisa").text(numberWithCommas(dataBudget - ($(".qtyy").val() * harga)));
            //(($("#budgettt").text().indexOf('-') > -1) ? "-" : "") +
            //$("#totalsisa").text($("#curre").val() + ' ' +  numberWithCommas(dataBudget[0] - ($(this).val() * harga)));
            $("#sisa").val(budget - ($(".qtyy").val() * harga))
            if ($("#budgettt").text().indexOf('-') > -1) {
                $("#excd").text('Budget Exceeded!!!')
                // $("#buyyy").prop('disabled', true);
            }
            else {
                $("#excd").text(' ')
                // $("#buyyy").prop('disabled', false);
            }
    
    
}

function plsqtycart() {
    console.log('Rp ' + dataBudget)
    $(".qtyy").val((parseInt($(".qtyy").val())+1))
    $("#buyyy").prop('disabled', false);
            // console.log('Rp ' + ($(this).val() +" "+ harga))
            //$("#totall").text($("#curre").val() + " " + numberWithCommas($(this).val() * harga))
            $("#totall").text(numberWithCommas($(".qtyy").val() * harga))
            // var dataBudget = $("#budgettt").text().split(".")
            //$("#totalsisa").text($("#curre").val() + ' ' + numberWithCommas(budget - ($(this).val() * harga)));
            $("#totalsisa").text(numberWithCommas(dataBudget - ($(".qtyy").val() * harga)));
            //(($("#budgettt").text().indexOf('-') > -1) ? "-" : "") +
            //$("#totalsisa").text($("#curre").val() + ' ' +  numberWithCommas(dataBudget[0] - ($(this).val() * harga)));
            $("#sisa").val(budget - ($(".qtyy").val() * harga))
            if ($("#budgettt").text().indexOf('-') > -1) {
                $("#excd").text('Budget Exceeded!!!')
                // $("#buyyy").prop('disabled', true);
            }
            else {
                $("#excd").text(' ')
                // $("#buyyy").prop('disabled', false);
            }
}

$('#simpanCCBeforeBuy').on('click', function(e){
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

})

function simpanCCBeforeBuy() {
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

    return false;
}