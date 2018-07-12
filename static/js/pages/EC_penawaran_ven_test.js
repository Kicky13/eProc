var range_harga = ['-', '-'],
    base_url = $("#base-url").val(),
    kodeParent = $("#kodeParent").val(),
    searctTag = $("#tag").val(),
    url = '/get_data/',
    compare = [],
    limitMin = 0,
    limitMax = 10,
    pageMax = 1,
    pageMaxOld = 0,
    old = '-', hgh2,
    compareCntrk = [];

function loadDataList() {

    $.ajax({
        url: $("#base-url").val() + 'EC_Penawaran_Vendor' + url,
        data : {            
            "limitMin" : limitMin,
            "limitMax" : limitMax            
        },
        type: 'POST',
        dataType: 'json'
    }).done(function (data) {
        console.log(data.data.length);
        console.log(data.page);
        $('#pagination_1').empty()
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
        $('#pagination_1').append('<li><a href="javascript:paginationPrev(this)" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>')
        for (var i = 0; i < Math.ceil(data.page / 10); i++) {
            $('#pagination_1').append('<li class="' + (i == (limitMin / 10) ? "active" : "") + '"><a href="javascript:pagination(this,' + (i * 10) + ',' + ((i + 1) * 10) + ')">' + (i + 1) + '</a></li>')
        }
        $('#pagination_1').append('<li><a href="javascript:paginationNext(this)" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>')

        $("#divAttributes").empty()
        if (data.data.length == 0) {
            $("#divAttributes").append('<div class="row text-center">Data Tidak Ditemukan!!</div>')
        } else {
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
			// $("#divAttributes").append(header)
			
			var teks = "<div class='table-responsive'>" +
							"<table class='table table-bordered' style='width:100%;'>" +
								"<thead>" +
									"<tr>" +
										"<th style='width:70px;'>Picture</th>" +
										"<th>Name</th>" +
										"<th style='width:70px;'>Stok</th>" +
                                        "<th style='width:70px;'>Satuan</th>" +
										"<th>Kode</th>" +
										"<th>Destination</th>" +
										"<th style='width:70px;'>Currency</th>" +
										"<th style='width:70px;'>Price</th>" +
										"<th>Delivery Time</th>" +
										"<th>Last Update</th>" +
										"<th>Next Update</th>" +
										"<th>Save?</th>" +
									"</tr>" +
								"</thead>" +
								"<tbody>";
			
			var f, t, currentDate, yr, month, day, dateAfter, nextupdate, diselm;
			
            for (var i = limitMin; i < data.data.length; i++) {
                // if (i == data.data.length - 1) {
                    // teks = ('<div class="row items" style=" margin:3px;">')
                // } else {
                    // teks = '<div class="row items" style=" margin:3px; border-bottom: 1px solid #ccc;">'
                // }                
                f = (data.data[i].ISI[0].LASTUPDATE==null?"0":data.data[i].ISI[0].LASTUPDATE).split("-");
                t = new Date(f[2], f[1] - 1, f[0]);
                currentDate = new Date(t);

                if(data.data[i].ISI[0].KODE_UPDATE=='510'){
                    currentDate.setDate(currentDate.getDate() + parseInt(data.data[i].ISI[0].DAYS_UPDATE));
                }else if(data.data[i].ISI[0].KODE_UPDATE=='511'){
                    currentDate.setMonth((currentDate.getMonth() + 1), 1);
                }else if(data.data[i].ISI[0].KODE_UPDATE=='521'){
                    currentDate.setDate(currentDate.getDate() + (1 + 7 - currentDate.getDay()) % 7);
                }
				
                yr      = currentDate.getFullYear();
                month   = (currentDate.getMonth() + 1) < 10 ? '0' + (currentDate.getMonth() + 1) : (currentDate.getMonth() + 1);
                day     = currentDate.getDate()  < 10 ? '0' + currentDate.getDate()  : currentDate.getDate();
                dateAfter = day + '-' + month + '-' + yr;
                if(isNaN(day)){
                    dateAfter = '-';
                }
				
				nextupdate = yr + '-' + month + '-' + day;
				if (new Date().getTime() < new Date(nextupdate).getTime()) {
					diselm = " disabled='disabled'";
				} else {
					diselm = "";
				}
				
				teks +=	"<tr>" +
							"<td rowspan='" + data.data[i].ISI.length + "'>" + '<img src="' + $("#base-url").val() + $("#UPLOAD_PATH").val() + "EC_material_strategis/" + data.data[i].PICTURE + '" class="img-responsive"/>' + "</td>" + 
							"<td rowspan='" + data.data[i].ISI.length + "'>" + '<strong><a href="javascript:void(0)" data-backdrop="true" data-toggle="modal" data-target="#modaldetail" data-produk="' + data.data[i].MATNO + '">' + data.data[i].MAKTX + '</a></strong>' + "</td>" +
							"<td rowspan='" + data.data[i].ISI.length + "'><input type='text' value='" + data.data[i].STOK + "' style='width:100%;margin-bottom:2px;' id='stok"+i+"' placeholder='0'>" +
							'<a href="javascript:updateStock(\'' + data.data[i].MATNO + '\',\'' + data.data[i][13] + '\',' + (data.data[i].STOK_COMMIT == "" ? 0 : data.data[i].STOK_COMMIT) + ',' + i + ',' + (data.data[i].STOK == "" ? 0 : data.data[i].STOK) + ')" style="font-size:12px;margin-top:2px;" class="btn btn-info btn-block">Update</a>' +
							"</td>" +
                            "<td rowspan='" + data.data[i].ISI.length + "'>" + "<p>" + data.data[i].MEINS +"</p>" + "</td>";
				//console.log(data.data[i].ISI);
				
				// SaveHarga(matno, plant, harga, deliverytime, currency)
							
					if(data.data[i].ISI.length > 0) {
						teks +=	"" +
							"<td>" + data.data[i].ISI[0].PLANT + "</td>" +
							"<td>" + data.data[i].ISI[0].DESC + "</td>" +
							"<td><center>" + data.data[i].CURRENCY + "</center><input type='hidden' style='display:none;' value='" + data.data[i].MATNO + "' name='matno[D"+i+"0]'><input type='hidden' style='display:none;' value='" + data.data[i].ISI[0].PLANT + "' name='plant[D"+i+"0]'><input type='hidden' style='display:none;' value='" + data.data[i].ISI[0].DESC + "' name='desc[D"+i+"0]'><input type='hidden' style='display:none;' value='" + data.data[i].MAKTX + "' name='nama_material[D"+i+"0]'><input type='hidden' style='display:none;' value='" + data.data[i].CURRENCY + "' name='currency[D"+i+"0]'></td>" +
							"<td><center><input type='text' value='" + data.data[i].ISI[0].PRICE + "' style='width:70px;' placeholder='0' name='price[D"+i+"0]'"+diselm+"></center></td>" +
							"<td><center><input type='text' value='" + data.data[i].ISI[0].DELIVERY_TIME + "' style='width:30px;' placeholder='0' name='dlvtime[D"+i+"0]'"+diselm+">&nbsp;day(s)</center></td>" +
							"<td><center>" + data.data[i].ISI[0].LASTUPDATE + "</center></td>" +
							"<td><center>" + dateAfter + "</center></td>" +
							"<td class='cbtr' style='cursor:pointer;'><center><input type='checkbox' style='cursor:pointer;' name='cb[]' value='D"+i+"0'"+diselm+"></center></td>" +
						"</tr>";
						
						for(var j = 1; j < data.data[i].ISI.length; j++) {
							
							f = (data.data[i].ISI[j].LASTUPDATE==null?"0":data.data[i].ISI[j].LASTUPDATE).split("-");
							t = new Date(f[2], f[1] - 1, f[0]);
							currentDate = new Date(t);

							if(data.data[i].ISI[j].KODE_UPDATE=='510'){
								currentDate.setDate(currentDate.getDate() + parseInt(data.data[i].ISI[j].DAYS_UPDATE));
							}else if(data.data[i].ISI[j].KODE_UPDATE=='511'){
								currentDate.setMonth((currentDate.getMonth() + 1), 1);
							}else if(data.data[i].ISI[j].KODE_UPDATE=='521'){
								currentDate.setDate(currentDate.getDate() + (1 + 7 - currentDate.getDay()) % 7);
							}
							
							yr      = currentDate.getFullYear();
							month   = (currentDate.getMonth() + 1) < 10 ? '0' + (currentDate.getMonth() + 1) : (currentDate.getMonth() + 1);
							day     = currentDate.getDate()  < 10 ? '0' + currentDate.getDate()  : currentDate.getDate();
							dateAfter = day + '-' + month + '-' + yr;
							if(isNaN(day)){
								dateAfter = '-';
							}
							
							nextupdate = yr + '-' + month + '-' + day;
							if (new Date().getTime() < new Date(nextupdate).getTime()) {
								diselm = " disabled='disabled'";
							} else {
								diselm = "";
							}
							
							teks +=	"<tr>" +
										"<td>" + data.data[i].ISI[j].PLANT + "</td>" +
										"<td>" + data.data[i].ISI[j].DESC + "</td>" +
										"<td><center>" + data.data[i].CURRENCY + "</center><input type='hidden' style='display:none;' value='" + data.data[i].MATNO + "' name='matno[D"+i+j+"]'><input type='hidden' style='display:none;' value='" + data.data[i].ISI[j].PLANT + "' name='plant[D"+i+j+"]'><input type='hidden' style='display:none;' value='" + data.data[i].CURRENCY + "' name='currency[D"+i+j+"]'><input type='hidden' style='display:none;' value='" + data.data[i].CURRENCY + "' name='currency[D"+i+j+"]'><input type='hidden' style='display:none;' value='" + data.data[i].ISI[j].DESC + "' name='desc[D"+i+j+"]'><input type='hidden' style='display:none;' value='" + data.data[i].MAKTX + "' name='nama_material[D"+i+j+"]'></td>" +
										"<td><center><input type='text' value='" + data.data[i].ISI[j].PRICE + "' style='width:70px;' placeholder='0' name='price[D"+i+j+"]'"+diselm+"></center></td>" +
										"<td><center><input type='text' value='" + data.data[i].ISI[j].DELIVERY_TIME + "' style='width:30px;' placeholder='0' name='dlvtime[D"+i+j+"]'"+diselm+">&nbsp;day(s)</center></td>" +
										"<td><center>" + data.data[i].ISI[j].LASTUPDATE + "</center></td>" +
										"<td><center>" + dateAfter + "</center></td>" +
										"<td class='cbtr' style='cursor:pointer;'><center><input type='checkbox' style='cursor:pointer;' name='cb[]' value='D"+i+j+"'"+diselm+"></center></td>" +
									"</tr>";
						}
					} else {
						teks +=	"<td colspan='6'></td>";
					}
					
                
            }
			$("#divAttributes").append(teks);
			$("#divAttributes").append("</tbody></table></div>");
			$('.cbtr').click(function(event) {
			if (event.target.type !== 'checkbox') {
				$(':checkbox', this).trigger('click');
			}
			});
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
                    url: $("#base-url").val() + 'EC_Penawaran_Vendor/insertStok/' + matno,
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
					//bootbox.alert("Berhasil update stok.");
                }).fail(function (data) {
                    // console.log("error");
                    // $("#pocreated").text(data['RETURN'][0]['MESSAGE'])
					//bootbox.alert("Gagal update stok.");
                }).always(function (data) {
                    //location.reload(true);
                    // console.log(data)
                    //$("#statsPO").text(data)
					bootbox.alert("Berhasil update stok.");
                });
            }else{
                $('#stok' + id).val(stok_awal);
            }
        });
    }

    

}

function getDetail(elm, tablename, index, matno, vendorno, currency) {
    $('#namaItem').html($(elm).data('nama'))
    // console.log(tablename);
    loadTable_App(tablename,index,matno,currency);
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
        url: $("#base-url").val() + 'EC_Penawaran_Vendor/getDetail/' + matno,
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
                url: $("#base-url").val() + 'EC_Penawaran_Vendor/SaveHarga/' + matno,
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
                url: $("#base-url").val() + 'EC_Penawaran_Vendor/insertHarga/' + matno,
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
        url: $("#base-url").val() + 'EC_Penawaran_Vendor/getDescItem/' + MATNR,
        type: 'POST',
        dataType: 'json'
    }).done(function (data) {
        // console.log(data);
        $("#detail_MATNR").text(data.MATNR[0].MATNR == null ? "-" : data.MATNR[0].MATNR);
        $("#detail_MAKTX").text(data.MATNR[0].MAKTX == null ? "-" : data.MATNR[0].MAKTX);
        $("#detail_LNGTX").html(data.MATNR[0].LNGTX == null ? "-" : data.MATNR[0].LNGTX.replace(/(?:\r\n|\r|\n)/g, '<br />'));
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

function loadTable_App(tabelname, index, matno, currency) {
    // console.log(matno);
    // console.log(currency);
    $('#'+tabelname).DataTable().destroy();
    $('#'+tabelname+' tbody').empty();
    mytable = $('#'+tabelname).DataTable({
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
        "ajax": $("#base-url").val() + 'EC_Penawaran_Vendor/getDetail/' + matno,

        /*"columnDefs": [{
            "searchable": false,
            "orderable": true,
            "targets": 0
        }],*/
        // "order": [[ 1, 'asc' ]],
        "fnInitComplete": function () {
            $('#'+tabelname+' tbody tr').each(function () {
                $(this).find('td').attr('nowrap', 'nowrap');
                // $(this).find('td').addClass('text-center');
            });
        },
        /*"fnCreatedRow": function (row, data, index) {
            $('td', row).eq(0).html("<div class='col-md-12 text-center'>"+(index + 1)+"</div>");
        },*/
        "drawCallback": function (settings) {
            $('#'+tabelname+' tbody tr').each(function () {
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
                if (new Date("2017-10-07").getTime() < new Date(nextupdate).getTime()) {
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
                a += '<button onclick=\"SaveHarga(\'' + matno + '\',\'' + full.PLANT + '\',\'' + (full.PRICE==0?'':full.PRICE) + '\',\'' + (full.DELIVERY_TIME==0?'':full.DELIVERY_TIME) + '\',\'' + currency + '\')"\ style=\"font-size:12px;"\  class=\"btn btn-success"\>Save</button>';
                a += '</div>';
                return a;
            }
        }],

    });

    mytable.columns().every(function () {
        var that = this;
        $('.srch'+index, this.header()).on('keyup change', function () {
            if (that.search() !== this.value) {
                that.search(this.value).draw();
            }
        });
    });

    $('#'+tabelname).find("th").off("click.DT");
    /*$('.ts0').on('dblclick', function () {
        if (t0) {
            mytable.order([0, 'asc']).draw();
            t0 = false;
        } else {
            mytable.order([0, 'desc']).draw();
            t0 = true;
        }
    });*/
    $('.ts1-'+index).on('dblclick', function () {
        if (t1) {
            mytable.order([0, 'asc']).draw();
            t1 = false;
        } else {
            mytable.order([0, 'desc']).draw();
            t1 = true;
        }
    });
    $('.ts2-'+index).on('dblclick', function () {
        if (t2) {
            mytable.order([1, 'asc']).draw();
            t2 = false;
        } else {
            mytable.order([1, 'desc']).draw();
            t2 = true;
        }
    });
    $('.t31-'+index).on('dblclick', function () {
        if (t3) {
            mytable.order([2, 'asc']).draw();
            t3 = false;
        } else {
            mytable.order([2, 'desc']).draw();
            t3 = true;
        }
    });
    $('.ts4-'+index).on('dblclick', function () {
        if (t4) {
            mytable.order([3, 'asc']).draw();
            t4 = false;
        } else {
            mytable.order([3, 'desc']).draw();
            t4 = true;
        }
    });
    $('.ts5-'+index).on('dblclick', function () {
        if (t5) {
            mytable.order([4, 'asc']).draw();
            t5 = false;
        } else {
            mytable.order([4, 'desc']).draw();
            t5 = true;
        }
    });
    $('.ts6-'+index).on('dblclick', function () {
        if (t6) {
            mytable.order([5, 'asc']).draw();
            t6 = false;
        } else {
            mytable.order([5, 'desc']).draw();
            t6 = true;
        }
    });
    $('.ts7-'+index).on('dblclick', function () {
        if (t7) {
            mytable.order([6, 'asc']).draw();
            t7 = false;
        } else {
            mytable.order([6, 'desc']).draw();
            t7 = true;
        }
    });
}

function ubahTab(elm1, elm2) {
	$("#" + elm2 + "LI").removeClass("active");
	$("#" + elm2 + "Only").hide();
	$("#" + elm1 + "LI").addClass("active");
	$("#" + elm1 + "Only").show();
}

function konfirmasiSimpan() {
	bootbox.confirm('Konfirmasi Update Harga? <br> Harga dan delivery time hanya bisa dilakukan perubahan kembali saat sudah melewati <span style="font-weight:bold">next update</span>', function (hasil) {
		if(hasil) {
			$("#form_simpan").submit();
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
    // loadDataTest();
    loadDataList();
	
	$("#form_simpan").ajaxForm({
		"beforeSend": function(jqXHR) {
			var jumlah = 0;
			$("input[name='cb[]']:checked").each(function () {
				jumlah++;
			});
			if(jumlah === 0) {
				bootbox.alert('Gagal menyimpan data. Tidak ada yang dipilih.');
				jqXHR.abort();
			}
			// if($("#file_input").val() == "") {
				// informasi(BootstrapDialog.TYPE_WARNING, "Pilih file terlebih dahulu.");
				// jqXHR.abort();
			// } else {
				// tombol(0, 0);
				// $("#proses_upload").width("0%");
				// $("#persen_upload").html("0%");
				// $("#upload_size").html("0&nbsp;Bytes");
				// $("#btn_upload").attr("disabled", "disabled");
				// $("#btn_upload").html("<i class='fa fa-spinner fa-spin'></i>");
			// }
		},
		"success": function(result) {
			bootbox.alert(result);
		},
		"error": function() {
			bootbox.alert('Gagal menyimpan data.');
		},
		"complete": function() {
			//$("body").addClass("modal-open");
			loadDataList();
		}
	}); 
	
	// $('#data_destination').DataTable({
		// "processing": true,
		// "serverSide": true,
        // "ajax": {
			// "url": $("#base-url").val() + 'EC_Penawaran_Vendor_test/getDest',
			// "type": "POST",
			// "dataType": "json"
		// },
		// "dom": 'rtpli',
        // "pageLength": 10,
        // "order": [[0, "asc"]],
		// "columnDefs": [
			// {"targets": 3, "className": "text-center"},
			// {"targets": 5, "className": "text-center"},
			// {"targets": 6, "className": "text-center"},
			// {"targets": 7, "className": "text-center"},
			// {"targets": 7, "orderable": false}
		// ],
        // "language": {
            // "loadingRecords": "<center><b>Please wait - Updating and Loading Data List PO...</b></center>"
        // }
    // });

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
    
//    var _sudahTampilPesan = $('#sudahTampilPesan').text();
//    if(_sudahTampilPesan != '1'){
//      var _tmpMessage = [
//        '1. Harga untuk produk yang dikirimkan sudah termasuk PPH dan ongkos kirim namun belum termasuk PPN',
//        '2. Harga untuk produk pengambilan sendiri sudah termasuk PPH namun tidak termasuk PPH dan ongkos kirim'        
//        ];
//      bootbox.alert(_tmpMessage.join('<br />'));
//    }
});