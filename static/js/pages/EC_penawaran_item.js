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
    old = '-', hgh2,
    compareCntrk = [];
function loadDataList() {

    $.ajax({
        url: $("#base-url").val() + 'EC_Penawaran_Item' + urlll,
        data : {            
            "limitMin" : limitMin,
            "limitMax" : limitMax            
        },
        type: 'POST',
        dataType: 'json'
    }).done(function (data) {
        console.log(data.data.length);
        console.log(data.page);
        $('.pagination').empty()
        pageMax = Math.ceil(data.page / 10)
        console.log('page: '+pageMax);
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
        for (var i = 0; i < Math.ceil(data.page / 10); i++) {
            $('.pagination').append('<li class="' + (i == (limitMin / 10) ? "active" : "") + '"><a href="javascript:pagination(this,' + (i * 10) + ',' + ((i + 1) * 10) + ')">' + (i + 1) + '</a></li>')
        }
        $('.pagination').append('<li><a href="javascript:paginationNext(this)" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>')

        $("#divAttributes").empty()
        if (data.data.length == 0) {
            $("#divAttributes").append('<div class="row text-center">Data Tidak Ditemukan!!</div>')
        }
        else {
            header = ('<div class="row">')
            header += ('<div class="col-md-6" style="font-size:16px"><strong>&nbsp;&nbsp;List Item:</strong></div>')
            // header += ('<div class="col-md-5">')
            // header += ('<div class="row">')
            // header += ('<div class="col-md-3 text-center" style="font-size:16px">')
            // header += ('<label for="harga"><strong>Harga</strong></label></div>')
            // header += ('<div class="col-md-4 text-center" style="font-size:16px">')
            // header += ('<label for="currency"><strong>Currency</strong></label>')
            // header += ('</div>')
            // header += ('<div class="col-md-3" style="font-size:16px"><label for="Delivery"><strong>Delivery Time</strong></label></div>')
            header += ('<div class="col-md-2" style="font-size:16px; margin-left: 10px;">')
            header += ('<label for="Stok"><strong>Stok</strong></label>')
            header += ('</div></div>')
            // header += ('</div></div>')
            $("#divAttributes").append(header)
            for (var i = limitMin; i < data.data.length; i++) {
                if (i == data.data.length - 1) {
                    teks = ('<div class="row items" style=" margin:3px;">')
                } else {
                    teks = '<div class="row items" style=" margin:3px; border-bottom: 1px solid #ccc;">'
                }

                var color = null;
                var disable = '';
                var onclick = '';
                //var datenow = new Date();
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
                var now = yyyy + '-' + mm + '-' + dd;
                var stok = 'stokUp'
                /*var lastupdate = data.data[i].LASTUPDATE.substring(6, 10) + '-' + data.data[i].LASTUPDATE.substring(3, 5) + '-' + data.data[i].LASTUPDATE.substring(0, 2);
                var nextupdate = data.data[i][10].substring(6, 10) + '-' + data.data[i][10].substring(3, 5) + '-' + data.data[i][10].substring(0, 2);
                
                if (new Date(now).getTime() < new Date(nextupdate).getTime()) {
                    //color = "blue";
                    //console.log("masuk");
                    disable = 'disabled';
                    onclick = '';
                } else if (new Date(now).getTime() >= new Date(nextupdate).getTime() || nextupdate == '---') {
                    //color = "red";
                    //disable = 'disabled';
                    stok = 'stokDo'
                    onclick = 'save(this, \'' + data.data[i].MATNR + '\',\'harga' + i + ' \',\'curr\',\'DELIVERY_TIME' + i + ' \',\'stok' + i + ' \')';
                }*/

                teks += ('<div class="row" style=" margin:3px; padding:3px;">')
                teks += ('<div class="col-md-2" style="  padding-left: 3px;">')
                teks += ('<a href="javascript:void(0)" data-backdrop="true" data-toggle="modal" data-target="#modaldetail" data-produk="' + data.data[i].MATNO + '">')
                teks += ('<img src="' + $("#base-url").val() + $("#UPLOAD_PATH").val() + "EC_material_strategis/" + data.data[i].PICTURE + '" class="img-responsive"></a>')
                teks += ('</div>' + '<div class="col-md-4" style="  padding-left: 20px;">')
                teks += ('<div class="row" style="font-size:15px">')
                teks += ('<strong><a href="javascript:void(0)" data-backdrop="true" data-toggle="modal" data-target="#modaldetail" data-produk="' + data.data[i].MATNO + '">' + data.data[i].MAKTX + '</a></strong></div>')
                // teks += ('<div class="row">')
                // teks += ('Last Update: <strong>' + data.data[i].LASTUPDATE + '</strong>')
                // teks += ('</div>')
                // teks += ('<div class="row">')
                // teks += ('Next Update: <strong style="color: green;">' + data.data[i][10] + '</strong>')
                // teks += ('</div>')
                teks += ('</div>' + '<div class="col-md-2" style="padding-left: 20px;">')

                // teks += ('<div class="row">')
                // teks += ('<div class="col-sm-3"><input ' + disable + ' id="harga' + i + '" style="" type="text" class="form-control harga" value="' + data.data[i][6] + '"></div>' )

                // teks += ('<div class="col-sm-6">')
                // teks += ('<input disabled id="curr" style="" type="text" class="form-control" value="' + data.data[i].CURRENCY + '">')
                // teks += ('</div>')
                // teks += ('<div class="col-sm-3"><form class="form-inline"> <div class="form-group">')
                // teks += ('<input ' + disable + ' id="DELIVERY_TIME' + i + '" style="width: 50px;" type="text" class="form-control harga" value="' + data.data[i][8] + '">&nbsp;&nbsp;Days' )
                // teks += ('</div></form></div>')
                // teks += ('<div class="col-sm-6">')
                teks += ('<form class="form-inline"> <div class="form-group">')
                teks += ('<input id="stok' + i + '" style="width: 50px;" type="text" class="form-control harga stokDo ' + stok + '" data-old="' + data.data[i].STOK + '" data-min="' + data.data[i].STOK_COMMIT + '" value="' + data.data[i].STOK + '">' )
                teks += ('</div></form>')
                // teks += ('</div></div>')
                teks += ('</div> ')
                // teks += ('<div class="col-md-1" style="text-align: right;"><input ' + disable + ' id="cek' + i + '" type="checkbox" style="margin-top: 20px;"></div>')
                teks += ('<div class="col-md-4" style="text-align: center;">')// + '<form class="form-horizontal">' )

                teks += ('<a href="javascript:updateStock(\'' + data.data[i].MATNO + '\',\'' + data.data[i][13] + '\',' + (data.data[i].STOK_COMMIT == "" ? 0 : data.data[i].STOK_COMMIT) + ',' + i + ',' + (data.data[i].STOK == "" ? 0 : data.data[i].STOK) + ')" style="font-size:12px;"  class="btn btn-info form-control beli">Update Stock</a><p></p>')
                teks += ('<a href="javascript:void(0)" onclick="getDetail(this,\'' + data.data[i].MATNO + '\',\'' + data.data[i].VENDORNO + '\',\'' + data.data[i].CURRENCY + '\')" data-nama="' + data.data[i].MAKTX + '"  style="font-size:12px;" data-matno="' + data.data[i].MATNO + '" class="btn btn-primary form-control beli">Detail  <span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span></a>')
                teks += ('</div>' + '</div>')
                $("#divAttributes").append(teks)
                // $("#divAttributes").append(teks)
                //$('#sel'+i).val(data.data[i].CURRENCY);

            }
        }

    }).fail(function () {
        // console.log("error");
    }).always(function (data) {
        hgh2 = $('.items').width()
        // console.log(data);
        /*$('.stokUp').on('keyup change', function () {
            qty = (this.value)
            if (parseInt(qty) < 0 || qty.search(/\D/g) != -1) {
                // alert('Minimal 0 !!')
                bootbox.alert('Minimal 0 !!');
                this.value = $(this).data('old')
            }
        });
        $('.stokDo').on('keyup change', function () {
            qty = (this.value)
            if (parseInt(qty) < parseInt($(this).data('min')) || qty.search(/\D/g) != -1) {
                // alert('Telah ter commit, Minimal ' + $(this).data('min') + '!!')
                // bootbox.confirm('', function(result) {});
                bootbox.alert('Telah ter commit sebanyak: ' + $(this).data('min') + '!!');
                this.value = $(this).data('min')
            }
        });*/
    });

}
function updateStock(matno, kode, stokc, id, stok_awal= '0') {
    var stok = $('#stok' + id).val();
    console.log('stok1: '+stok);
    console.log('stok2: '+stokc);
    // if (confirm('Konfirmasi Update Stok?'))
    if(stok<stokc){
        bootbox.alert('Update stok tidak boleh kurang dari stok yang sudah di commit<br/>Stok commit : '+stokc);
        $('#stok' + id).val(stok_awal);
    }else{
        bootbox.confirm('Konfirmasi Update Stok?', function (result) {
            if (result){
                $.ajax({
                    url: $("#base-url").val() + 'EC_Penawaran_Item/insertStok/' + matno,
                    data: {
                        "matno": matno,
                        "harga": '0',
                        "curr": '0',
                        "kode": kode,
                        "deliverytime": '0',
                        "stok": stok,
                        "stokc": stokc
                    },
                    type: 'POST',
                    dataType: 'json'
                }).done(function (data) {
                    //console.log(data);
                }).fail(function (data) {
                    // console.log("error");
                    // $("#pocreated").text(data['RETURN'][0]['MESSAGE'])
                }).always(function (data) {
                    location.reload(true);
                    // console.log(data)
                    //$("#statsPO").text(data)
                });
            }else{
                $('#stok' + id).val(stok_awal);
            }
        });
    }

    

}

function getDetail(elm, matno, vendorno, currency) {
    $('#namaItem').html($(elm).data('nama'))
    loadTable_App(matno,currency);
}

function getDetail_old(elm, matno, vendorno, currency) {
    $('.itemsfix').removeClass('fixed2');
    $('.items').removeClass('itemsfix');
    $('#matno').val(matno);
    $(elm).parent().parent().parent().addClass('itemsfix');
    $('#namaItem').html($(elm).data('nama'))
    $("input[class^='harga_']").each(function (i, el) {
        $(this).val('');
    });
    $("input[class^='deliv_']").each(function (i, el) {
        $(this).val('');
    });
    $.ajax({
        url: $("#base-url").val() + 'EC_Penawaran_Item/getDetail/' + matno,
        type: 'POST',
        dataType: 'json'
    }).done(function (data) {
        // console.log(data);
    }).fail(function (data) {
        // console.log("error");
    }).always(function (data) {
        

        var dateAfter = '';
        /*$.ajax({
                url: $("#base-url").val() + 'EC_Penawaran/getPlant/',
                type: 'POST',
                dataType: 'json'
            }).done(function (data) {
                for (var i = 0; i < $('#lenghtPlant').val(); i++) {
                    var child = document.getElementById("btn_" + data[i].PLANT);
                    var parent = document.getElementById("parent_" + data[i].PLANT);
                    parent.removeChild(child);

                    // $(".harga_" + data[i].PLANT).val('-')
                    // $(".deliv_" + data[i].PLANT).val('-')
                    // //$(".last_" + data[i].PLANT).val(data[i].INDATE)
                    // $(".last_" + data[i].PLANT+ " strong").text('-')
                    // $(".next_" + data[i].PLANT+ " strong").text('-') 
                    //$(".last_" + data[i].PLANT+ " span").text(data[i].INDATE)
                    //document.getElementById("#last_" + data[i].PLANT).innerHTML=data[i].INDATE;
                    //console.log(document.getElementById($("#last_" + data[i].PLANT)))
                    var p = document.getElementById("parent_" + data[i].PLANT);
                    var newElement = document.createElement("button");
                    newElement.setAttribute('id', "btn_" + data[i].PLANT);
                    newElement.setAttribute('class', 'btn btn-success pull-right');
                    newElement.setAttribute('onclick', "SaveHarga('"+matno+"','"+data[i].PLANT+"','','')")
                    newElement.innerHTML = "Save";
                    p.appendChild(newElement);
                    $("#harga"+data[i].PLANT).prop( "disabled", false );
                    $("#deliv"+data[i].PLANT).prop( "disabled", false );
                    $(".last_" + data[i].PLANT+ " strong").text('-')
                    $(".next_" + data[i].PLANT+ " strong").text('-')
                    
                }
            }).fail(function (data) {
                // console.log("error");
            }).always(function (data) {
                
            });*/

        if(data.length>0){
            for (var i = 0; i < data.length; i++) {
                console.log("datalength"+data.length);
                var child = document.getElementById("btn_" + data[i].PLANT);
                var parent = document.getElementById("parent_" + data[i].PLANT);
                parent.removeChild(child);

                var color = null;
                var disable = '';
                var onclick = '';
                //var datenow = new Date();
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
                var now = yyyy + '-' + mm + '-' + dd;

                var from = (data[i].LASTUPDATE==null?"0":data[i].LASTUPDATE).split("-");
                var f = new Date(from[2], from[1] - 1, from[0]);
                //console.log('date: '+f);
                var currentDate = new Date(f);     
                //console.log('DAYS_UPDATE: '+data[i].DAYS_UPDATE);

                if(data[i].KODE_UPDATE=='510'){
                    currentDate.setDate(currentDate.getDate() + parseInt(data[i].DAYS_UPDATE));
                }else if(data[i].KODE_UPDATE=='511'){
                    currentDate.setMonth((currentDate.getMonth() + 1), 1);
                }else if(data[i].KODE_UPDATE=='521'){
                    currentDate.setDate(currentDate.getDate() + (1 + 7 - currentDate.getDay()) % 7);
                }

                //console.log('tes: '+currentDate);
                var yr      = currentDate.getFullYear();
                var month   = (currentDate.getMonth() + 1) < 10 ? '0' + (currentDate.getMonth() + 1) : (currentDate.getMonth() + 1);
                var day     = currentDate.getDate()  < 10 ? '0' + currentDate.getDate()  : currentDate.getDate();
                dateAfter = day + '-' + month + '-' + yr;
                if(isNaN(day)){
                    dateAfter = '-';
                }
                var nextupdate = yr + '-' + month + '-' + day;
                

                
                console.log('nextupdate: '+data[i].LASTUPDATE);

                $(".harga_" + data[i].PLANT).val(data[i].PRICE)
                $(".deliv_" + data[i].PLANT).val(data[i].DELIVERY_TIME)
                //$(".last_" + data[i].PLANT).val(data[i].INDATE)
                if(data[i].PRICE==0){
                    $(".last_" + data[i].PLANT+ " strong").text('-')
                    $(".next_" + data[i].PLANT+ " strong").text('-')
                    $(".harga_" + data[i].PLANT).val('')
                    $(".deliv_" + data[i].PLANT).val('')
                }else{
                    $(".last_" + data[i].PLANT+ " strong").text(data[i].LASTUPDATE==null?"-":data[i].LASTUPDATE)
                    $(".next_" + data[i].PLANT+ " strong").text(dateAfter)
                }
                
                //$(".next_" + data[i].PLANT+ " strong").text(isNaN(dateAfter)?"-":dateAfter)
                //$(".last_" + data[i].PLANT+ " span").text(data[i].INDATE)
                //document.getElementById("#last_" + data[i].PLANT).innerHTML=data[i].INDATE;
                //console.log($('#matno').val())
                    var p = document.getElementById("parent_" + data[i].PLANT);
                    var newElement = document.createElement("button");
                    newElement.setAttribute('id', "btn_" + data[i].PLANT);
                    newElement.setAttribute('class', 'btn btn-success pull-right');
                    newElement.setAttribute('onclick', "SaveHarga('"+matno+"','"+data[i].PLANT+"','"+$(".harga_" + data[i].PLANT).val()+"','"+$(".deliv_" + data[i].PLANT).val()+"','"+currency+"')")
                    newElement.innerHTML = "Save";
                    p.appendChild(newElement);
                    //new Date("2017-03-28").getTime()
                    //new Date(now).getTime()
                if (new Date("2017-05-01").getTime() < new Date(nextupdate).getTime()) {
                    //color = "blue";
                    console.log($("#btn_"+data[i].PLANT).attr('id'));
                    $("#harga"+data[i].PLANT).prop( "disabled", true );
                    $("#deliv"+data[i].PLANT).prop( "disabled", true );
                    //document.getElementById($("#btn_"+data[i].PLANT).attr('id')).style.visibility = 'hidden';
                    //$("#btn_7702").prop( "disabled", false );
                    //document.getElementById("myId").disabled = false;
                    //newElement.disabled = false;
                    //parent.removeChild(child);
                    //document.getElementById("btn_" + data[i].PLANT).disabled = true;
                    //$("btn_" + data[i].PLANT).prop( "disabled", true );
                    //$("#btn_" + data[i].PLANT).attr("disabled","disabled");
                    //disable = 'disabled';
                }else{
                    $("#harga"+data[i].PLANT).prop( "disabled", false );
                    $("#deliv"+data[i].PLANT).prop( "disabled", false );
                    //$("#btn_"+ data[i].PLANT).prop( "disabled", false );
                }        
            }

            /*if(data.length!=$('#lenghtPlant').val()){
                console.log("datalength"+data.length);
                console.log("lenghtPlant"+$('#lenghtPlant').val());
                $.ajax({
                    url: $("#base-url").val() + 'EC_Penawaran/getPlant/',
                    type: 'POST',
                    dataType: 'json'
                }).done(function (tdata) {
                    // console.log(data);
                }).fail(function (tdata) {
                    // console.log("error");
                }).always(function (tdata) { 
                    console.log("masuk");
                    for (var j = data.length; j < $('#lenghtPlant').val(); j++) {
                        console.log("plant"+tdata[j].PLANT);
                        var child = document.getElementById("btn_" + tdata[j].PLANT);
                        var parent = document.getElementById("parent_" + tdata[j].PLANT);
                        parent.removeChild(child);

                        // $(".harga_" + data[i].PLANT).val('-')
                        // $(".deliv_" + data[i].PLANT).val('-')
                        // //$(".last_" + data[i].PLANT).val(data[i].INDATE)
                        // $(".last_" + data[i].PLANT+ " strong").text('-')
                        // $(".next_" + data[i].PLANT+ " strong").text('-') 
                        //$(".last_" + data[i].PLANT+ " span").text(data[i].INDATE)
                        //document.getElementById("#last_" + data[i].PLANT).innerHTML=data[i].INDATE;
                        //console.log(document.getElementById($("#last_" + data[i].PLANT)))
                        var p = document.getElementById("parent_" + tdata[j].PLANT);
                        var newElement = document.createElement("button");
                        newElement.setAttribute('id', "btn_" + tdata[j].PLANT);
                        newElement.setAttribute('class', 'btn btn-success pull-right');
                        newElement.setAttribute('onclick', "SaveHarga('"+matno+"','"+tdata[j].PLANT+"','','')")
                        newElement.innerHTML = "Save";
                        p.appendChild(newElement);

                        $("#harga"+tdata[j].PLANT).prop( "disabled", false );
                        $("#deliv"+tdata[j].PLANT).prop( "disabled", false );
                    }
                });
            }*/
            
        }/*else{
            $.ajax({
                url: $("#base-url").val() + 'EC_Penawaran/getPlant/',
                type: 'POST',
                dataType: 'json'
            }).done(function (data) {
                // console.log(data);
            }).fail(function (data) {
                // console.log("error");
            }).always(function (data) {
                for (var i = 0; i < $('#lenghtPlant').val(); i++) {
                    var child = document.getElementById("btn_" + data[i].PLANT);
                    var parent = document.getElementById("parent_" + data[i].PLANT);
                    parent.removeChild(child);

                    $(".harga_" + data[i].PLANT).val('-')
                    $(".deliv_" + data[i].PLANT).val('-')
                    //$(".last_" + data[i].PLANT).val(data[i].INDATE)
                    $(".last_" + data[i].PLANT+ " strong").text('-')
                    $(".next_" + data[i].PLANT+ " strong").text('-') 
                    //$(".last_" + data[i].PLANT+ " span").text(data[i].INDATE)
                    //document.getElementById("#last_" + data[i].PLANT).innerHTML=data[i].INDATE;
                    //console.log(document.getElementById($("#last_" + data[i].PLANT)))
                    var p = document.getElementById("parent_" + data[i].PLANT);
                    var newElement = document.createElement("button");
                    newElement.setAttribute('id', "btn_" + data[i].PLANT);
                    newElement.setAttribute('class', 'btn btn-success pull-right');
                    newElement.setAttribute('onclick', "SaveHarga('"+matno+"','"+data[i].PLANT+"','','')")
                    newElement.innerHTML = "Save";
                    p.appendChild(newElement);
                    $("#harga"+data[i].PLANT).prop( "disabled", false );
                    $("#deliv"+data[i].PLANT).prop( "disabled", false );
                }
            });
            
        }*/
        
        // $("#matno").val(matno)
    });
}

function SaveHarga(matno, plant, harga, deliverytime, currency) {
    if($("#harga"+plant).is( ":disabled" ) == true){
        bootbox.alert('Tidak bisa update harga');
        //$('#stok' + id).val(stok_awal);
    }else if($("#harga"+plant).val()=='' || $("#deliv"+plant).val()==''){
        bootbox.alert('Harga atau Delivery time belum di isi');
    }
    else{
        bootbox.confirm('Konfirmasi Update Harga?', function (result) {
            if (result){
                $.ajax({
                url: $("#base-url").val() + 'EC_Penawaran_Item/SaveHarga/' + matno,
                data: {
                            "plant": plant,
                            "curr": currency,
                            "harga": $('#harga' + plant).val(),                    
                            "deliverytime": $('#deliv' + plant).val()                    
                        },
                        type: 'POST',
                        dataType: 'json'
                }).done(function (data) {
                        //console.log(data);
                }).fail(function (data) {
                        // console.log("error");
                        // $("#pocreated").text(data['RETURN'][0]['MESSAGE'])
                }).always(function (data) {
                        location.reload(true);
                        // console.log(data)
                        //$("#statsPO").text(data)
                });
            }else{
                $("#harga"+plant).val(harga);
                $("#deliv"+plant).val(deliverytime);
            }
        });
    }
}

function save(element, matno, harga, curr, deliverytime, stok) {
    // console.log($(element).is(":checked"));
    //console.log($(element).parent().parent().find(".endDate").data('provide'))
    var harga1 = $('#' + harga).val();
    var currency = $('#' + curr).val();
    var time = $('#' + deliverytime).val();
    if (harga1 == '' || currency == null || time == '') {
        alert('Harga, currency atau delivery time masih kosong');
    } else {
        if (confirm('Apakah anda yakin menyimpan data ini ?'))
            $.ajax({
                url: $("#base-url").val() + 'EC_Penawaran_Item/insertHarga/' + matno,
                data: {
                    "matno": matno,
                    "harga": $('#' + harga).val(),
                    "curr": $('#' + curr).val(),
                    "deliverytime": $('#' + deliverytime).val(),
                    "stok": $('#' + stok).val()
                },
                type: 'POST',
                dataType: 'json'
            }).done(function (data) {
                //console.log(data);
            }).fail(function (data) {
                // console.log("error");
                // $("#pocreated").text(data['RETURN'][0]['MESSAGE'])
            }).always(function (data) {
                // location.reload(true);
                // console.log(data)
                //$("#statsPO").text(data)
            });
    }

}

$("#formsearch").submit(function (event) {
    event.preventDefault();
    range_harga = ['-', '-']
    base_url = $("#base-url").val()
    kodeParent = $("#kodeParent").val()
    searctTag = $('#txtsearch').val()
    loadDataList()
});

function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

$('#modaldetail').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget)
    var MATNR = button.data('produk')
    //var id = button.data('id')
    //var modal = $(this)
    $.ajax({
        url: $("#base-url").val() + 'EC_Penawaran_Item/getDescItem/' + MATNR,
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

function pagination(elm, min, maks) {
    limitMin = min
    limitMax = maks
    loadDataList()
}

function paginationPrev(elm) {
    if (limitMin >= 10) {
        limitMin -= 10
        limitMax -= 10
        loadDataList()
    };
}

function paginationNext(elm) {
    if (limitMax < (pageMax * 10)) {
        limitMin += 10
        limitMax += 10
        loadDataList()
    };
}

function loadTable_App(matno,currency) {

    $('#table_detail').DataTable().destroy();
    $('#table_detail tbody').empty();
    mytable = $('#table_detail').DataTable({
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
        "ajax": $("#base-url").val() + 'EC_Penawaran_Item/getDetail/' + matno,

        /*"columnDefs": [{
            "searchable": false,
            "orderable": true,
            "targets": 0
        }],*/
        // "order": [[ 1, 'asc' ]],
        "fnInitComplete": function () {
            $('#table_detail tbody tr').each(function () {
                $(this).find('td').attr('nowrap', 'nowrap');
                // $(this).find('td').addClass('text-center');
            });
        },
        /*"fnCreatedRow": function (row, data, index) {
            $('td', row).eq(0).html("<div class='col-md-12 text-center'>"+(index + 1)+"</div>");
        },*/
        "drawCallback": function (settings) {
            $('#table_detail tbody tr').each(function () {
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
                a = "<div class='col-md-12'>";
                a += full.PLANT+" - "+full.DESC;
                a += "</div>";
                return a;
            }
        }, {
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += currency;
                a += "</div>";
                return a;
            }
        },{
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += "<input type='number' class='form-control' id='harga"+full.PLANT+"' name='' value='"+(full.PRICE==0?'':full.PRICE)+"' style='width: 65px;' placeholder='0'>";
                a += "</div>";
                return a;
            }
        }, {
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += "<div class='input-group'>";
                a += "<input type='number' class='form-control' id='deliv"+full.PLANT+"' name='' value='"+(full.DELIVERY_TIME==0?'':full.DELIVERY_TIME)+"' style='width: 30px;' placeholder='0'>"; 
                a += "<div class='input-group-addon'>Days</div>";
                a += "</div></div>";
                return a;
            }
        },{
            mRender: function (data, type, full) {
                var lastupdate = null;
                if(full.PRICE==0){
                    lastupdate = '-';
                }else{
                    lastupdate = (full.LASTUPDATE==null?'-':full.LASTUPDATE)
                }
                a = "<div class='col-md-12 text-center'>";
                a += lastupdate;
                a += "</div>";
                return a;
            }
        },{
            mRender: function (data, type, full) {
                var color = null;
                var disable = '';
                var onclick = '';
                //var datenow = new Date();
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
                var now = yyyy + '-' + mm + '-' + dd;

                var from = (full.LASTUPDATE==null?"0":full.LASTUPDATE).split("-");
                var f = new Date(from[2], from[1] - 1, from[0]);
                //console.log('date: '+f);
                var currentDate = new Date(f);     
                //console.log('DAYS_UPDATE: '+data[i].DAYS_UPDATE);

                if(full.KODE_UPDATE=='510'){
                    currentDate.setDate(currentDate.getDate() + parseInt(full.DAYS_UPDATE));
                }else if(full.KODE_UPDATE=='511'){
                    currentDate.setMonth((currentDate.getMonth() + 1), 1);
                }else if(full.KODE_UPDATE=='521'){
                    currentDate.setDate(currentDate.getDate() + (1 + 7 - currentDate.getDay()) % 7);
                }

                //console.log('tes: '+currentDate);
                var yr      = currentDate.getFullYear();
                var month   = (currentDate.getMonth() + 1) < 10 ? '0' + (currentDate.getMonth() + 1) : (currentDate.getMonth() + 1);
                var day     = currentDate.getDate()  < 10 ? '0' + currentDate.getDate()  : currentDate.getDate();
                dateAfter = day + '-' + month + '-' + yr;
                if(isNaN(day)){
                    dateAfter = '-';
                }
                var nextupdate = yr + '-' + month + '-' + day;

                //new Date("2017-03-28").getTime()
                //new Date(now).getTime()
                if (new Date(now).getTime() < new Date(nextupdate).getTime()) {
                    color = "blue";
                    // console.log($("#btn_"+data[i].PLANT).attr('id'));
                    $("#harga"+full.PLANT).prop( "disabled", true );
                    $("#deliv"+full.PLANT).prop( "disabled", true );
                    //document.getElementById($("#btn_"+data[i].PLANT).attr('id')).style.visibility = 'hidden';
                    //$("#btn_7702").prop( "disabled", false );
                    //document.getElementById("myId").disabled = false;
                    //newElement.disabled = false;
                    //parent.removeChild(child);
                    //document.getElementById("btn_" + data[i].PLANT).disabled = true;
                    //$("btn_" + data[i].PLANT).prop( "disabled", true );
                    //$("#btn_" + data[i].PLANT).attr("disabled","disabled");
                    //disable = 'disabled';
                }else{
                    color = "green";
                    $("#harga"+full.PLANT).prop( "disabled", false );
                    $("#deliv"+full.PLANT).prop( "disabled", false );
                    //$("#btn_"+ data[i].PLANT).prop( "disabled", false );
                } 

                var nextupdate = null;
                if(full.PRICE==0){
                    nextupdate = '-';
                }else{
                    nextupdate = dateAfter;
                }

                a = "<div class='col-md-12 text-center' style='color: "+color+";'>";
                a += "<strong>"+nextupdate+"</strong>";
                a += "</div>";
                return a;
            }
        },{
            mRender: function (data, type, full) {
                a = '<div class=\"col-md-12 text-center"\>';
                // a += "<a href='javascript:SaveHarga("+full.MATNO+","+full.PLANT+","+(full.PRICE==0?'':full.PRICE)+","+(full.DELIVERY_TIME==0?'':full.DELIVERY_TIME)+","+full.CURRENCY+")' style='font-size:12px;'  class='btn btn-success form-control'>Save</a>";
                a += '<button onclick=\"SaveHarga(\'' + full.MATNO + '\',\'' + full.PLANT + '\',\'' + (full.PRICE==0?'':full.PRICE) + '\',\'' + (full.DELIVERY_TIME==0?'':full.DELIVERY_TIME) + '\',\'' + full.CURRENCY + '\')"\ style=\"font-size:12px;"\  class=\"btn btn-success form-control"\>Save</button>';
                a += '</div>';
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

    $('#table_detail').find("th").off("click.DT");
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
            mytable.order([0, 'asc']).draw();
            t1 = false;
        } else {
            mytable.order([0, 'desc']).draw();
            t1 = true;
        }
    });
    $('.ts2').on('dblclick', function () {
        if (t2) {
            mytable.order([1, 'asc']).draw();
            t2 = false;
        } else {
            mytable.order([1, 'desc']).draw();
            t2 = true;
        }
    });
    $('.t31').on('dblclick', function () {
        if (t3) {
            mytable.order([2, 'asc']).draw();
            t3 = false;
        } else {
            mytable.order([2, 'desc']).draw();
            t3 = true;
        }
    });
    $('.ts4').on('dblclick', function () {
        if (t4) {
            mytable.order([3, 'asc']).draw();
            t4 = false;
        } else {
            mytable.order([3, 'desc']).draw();
            t4 = true;
        }
    });
    $('.ts5').on('dblclick', function () {
        if (t5) {
            mytable.order([4, 'asc']).draw();
            t5 = false;
        } else {
            mytable.order([4, 'desc']).draw();
            t5 = true;
        }
    });
    $('.ts6').on('dblclick', function () {
        if (t6) {
            mytable.order([5, 'asc']).draw();
            t6 = false;
        } else {
            mytable.order([5, 'desc']).draw();
            t6 = true;
        }
    });
    $('.ts7').on('dblclick', function () {
        if (t7) {
            mytable.order([6, 'asc']).draw();
            t7 = false;
        } else {
            mytable.order([6, 'desc']).draw();
            t7 = true;
        }
    });
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
    clicks = 0,
    timer = null;
var tt1 = [t1, t2, t3, t4, t5, t6, t7];
var tt2 = [t1, t2, t3, t4, t5, t6, t7, t8, t9, t10];
var tt3 = [t1, t2, t3, t4, t5, t6, t7, t8, t9, t10, t11, t12, t13, t14];

$(document).ready(function () {
    loadDataList();

    $(".sear1").hide();
    for (var i = 0; i < tt1.length; i++) {
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

    //console.log("now");
    var hgh = $('.fixed-compare').width()
    // $('.tessss').css('width', hgh + 50)
    // console.log($(document).width())
    // if ($(document).width() < 1200)
    $(window).scroll(function () {
        if ($(this).scrollTop() > 300 && $(document).width() >= 1200) {
            $('.fixed-compare').addClass('fixed');
            $('.fixed-compare').css('width', hgh)
            $('.tessss').css('width', hgh + 50)
            $('.tessss').css('max-height', '75vh');
            // $('.itemsfix').addClass('fixed2');
            // $('.itemsfix').css('width', hgh2)
        } else if ($(document).width() < 1200) {
            $('.tessss').css('max-height', '');
            $('.fixed-compare').removeClass('fixed');
            $('.itemsfix').removeClass('fixed2');
        } else {
            $('.fixed-compare').removeClass('fixed');
            $('.itemsfix').removeClass('fixed2');
            // $('.fixed-compare').css('width', hgh)
        }
    });
});0