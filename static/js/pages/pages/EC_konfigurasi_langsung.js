var items = [],
    matnr = '-'
//lamahari = 0
$(document).ready(function () {
    $('#lamahari').val('')
    $('#lamahariEdit').val('')

    $("#assign").prop('disabled', true);
    $(".btnpbls").prop('disabled', true);
    $(".btnupbls").prop('disabled', true);

    $('.items').change(function () {
                //$(".btnpbls").prop('disabled', false);
                //$(".btnupbls").prop('disabled', false);
                //$("#assign").prop('disabled', false);
                $(".items").each(function () {
                     //console.log($(this).data("pil"))
                    if ($(this).is(":checked")){
                        if ($(this).data("pil") == 1){
                            $(".btnpbls").prop('disabled', true);
                        }
                        else if ($(this).data("pil") == 0) {
                            $(".btnupbls").prop('disabled', true);
                            $("#assign").prop('disabled', true);
                            $(".btnpbls").prop('disabled', false);
                        }
                    }else{
                        $(".btnupbls").prop('disabled', true);
                        $("#assign").prop('disabled', true);
                        $(".btnpbls").prop('disabled', true);
                    }
                });
            });

    $('.date').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true
    });

    $("#days-row").hide();
    $("#days-rowEdit").hide();

    var activities = document.getElementById("activitySelector");
    activities.addEventListener("change", function () {
        //console.log(activities.value)
        if (activities.value == "510") {
            $("#days-row").show();
        } else {
            $("#days-row").hide();
        }
    });

    var activitiess = document.getElementById("activitySelectorEdit");
    activitiess.addEventListener("change", function () {
        if (activitiess.value == "510") {
            $("#days-rowEdit").show();
        } else {
            $("#days-rowEdit").hide();
        }
    });

    // $('.Date').datepicker({
    // 	format: "dd-mm-yyyy",
    // 	autoclose: true,
    // 	todayHighlight: true
    // });
    loadTableItemPublish();
    loadTree();
    loadTableItem('0');
    //loadTableVnd(data);
    // data = JSON.stringify(['401-118', '623'])
    // loadTableVnd(data)
    $('.generate_vendor').click(function () {
        items = []
        cekPublish = []
        ok = 0;
        $(".items").each(function () {
            if ($(this).is(":checked")){
                //console.log('data pil = '+$(this).data("pil"))
                cekPublish.push(String($(this).data("pil")));
                if (items.indexOf($(this).data("matgrp")) == -1){
                    items.push(String($(this).data("matgrp")));
                }
            }
        });
        data = JSON.stringify(items)
        //console.log(data)
        //console.log(cekPublish)
        for (var i = cekPublish.length - 1; i >= 0; i--) {
            if(cekPublish[i]==0){
                alert('Item not published');
                ok=1;
                break;
            }
        }
 
        if(ok==0){
            if (items.length > 0){
                loadTableVnd(data)
            }else{
                alert('No item selected');
            }
        }
        
    })
    $('#assign').click(function () {
        items = []
        startDate = $('#startdate').val()
        endDate = $('#enddate').val()
        kode_update = $('#activitySelector').val()
        currency = $('#activityCurrency').val()

        //var activities = document.getElementById("activitySelector");

        // activities.addEventListener("change", function() {
        //     if(activities.value == "510"){
        //         lamahari = $('#lamahari').val()
        //     }else{
        //     	lamahari = '0';
        //     }
        // });

        lamahari = $('#lamahari').val()
        if(lamahari==''){
            lamahari = '0';
        }
        
        $(".items").each(function () {
            if ($(this).is(":checked"))
                if (items.indexOf($(this).data("matno")) == -1)
                    items.push(String($(this).data("matno")));
        });
        dataitems = JSON.stringify(items)
        console.log(dataitems)
        vnd = []
        $(".vnd").each(function () {
            if ($(this).is(":checked"))
                if (vnd.indexOf($(this).data("vndno")) == -1)
                    vnd.push(String($(this).data("vndno")));
        });
        datavnd = JSON.stringify(vnd)
        console.log(datavnd)
        console.log(startDate)
        console.log(endDate)
        simpan(dataitems, datavnd, startDate, endDate, kode_update, lamahari, currency, 'insert')
    })
    $('#saveItm').click(function () {
        vnd = []
        startDate = $('#startdatemodal').val()
        endDate = $('#enddatemodal').val()
        $(".vndEdit").each(function () {
            if ($(this).is(":checked"))
                if (vnd.indexOf($(this).data("vndno")) == -1)
                    vnd.push(String($(this).data("vndno")));
        });
        datavnd = JSON.stringify(vnd)
        // console.log(datavnd)
        console.log("matno" + $("#matno").val())
        edit($("#matno").val(), datavnd, startDate, endDate)
    })

    $('#modalItem').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        // matnr = '-'
        // matnr = matnr == '-' ? (button.data('matno')) : matnr;
        matnr = (button.data('matno'))
        var matno = (button.data('matno'))
        var matgrp = []
        matgrp.push(button.data('matgrp'))
        var modal = $(this)
        var table = modal.find('.table')
        console.log(button.data('startdate'))
        console.log(button.data('enddate'))
        $("#matno").val(button.data('matno'))
        $("#matno").val(matnr)
        $("#material").text(button.data('full'))
        $("#nomaterial").text(button.data('matno'))

        $('#activitySelectorEdit').val(button.data('upd'))
        $('#activityCurrencyEdit').val(button.data('curr'))
        $("#days-rowEdit").hide();
        if (button.data('upd') == "510")
            $("#days-rowEdit").show();
        $('#lamahariEdit').val(button.data('days'))
        console.log(matnr)
        // if (matno != "" && matno != null && matno != 0) {
        // loadTableVndItem(matno, JSON.stringify(matgrp))
        // }
        if (matnr != "" && matnr != null && matnr != 0) {
            loadTableVndItem(matnr, JSON.stringify(matgrp))
        }
        if (button.data('startdate') != null && button.data('enddate') != null) {
            $("#startdatemodal").val(button.data('startdate'))
            $("#enddatemodal").val(button.data('enddate'))
        }
    })
    loadTablePlant()
});

function publish(stat) {
    items = []
    $(".items").each(function () {
        if ($(this).is(":checked"))
            if (items.indexOf($(this).data("matno")) == -1)
                items.push(String($(this).data("matno")));
    });
    dataitems = JSON.stringify(items)
    $.ajax({
        url: $("#base-url").val() + 'EC_Konfigurasi_Langsung/publish/' + stat,
        type: 'POST',
        dataType: 'json',
        data: {
            items: dataitems
        },
    }).done(function (data) {
        //loadTableItem('3-1')
    }).always(function (data) {
        location.reload();
    })
}

function simpan(itm, vnd, start, end, kode_update, lamahari, curr, mode) {
    if (mode == 'insert')
        $.ajax({
            url: $("#base-url").val() + 'EC_Konfigurasi_Langsung/insert',
            type: 'POST',
            dataType: 'json',
            data: {
                items: itm,
                vnds: vnd,
                startDate: start,
                endDate: end,
                kode: kode_update,
                days: lamahari,
                currency: curr
            },
        }).done(function (data) {
            console.log(data.vnd)
        }).always(function (data) {
            alert('Data telah disimpan');
            location.reload(true);
            $('#enddate').val('');

        })
}

function edit(itm, vnd, start, end) {
    hari = '0';
    if($('#activitySelectorEdit').val()=='510'){
        hari = $('#lamahariEdit').val();
    }
    $.ajax({
        url: $("#base-url").val() + 'EC_Konfigurasi_Langsung/edit',
        type: 'POST',
        dataType: 'json',
        data: {
            kode_update: $('#activitySelectorEdit').val(),
            currency: $('#activityCurrencyEdit').val(),
            hari: hari,
            items: itm,
            vnds: vnd
        },
    }).done(function (data) {
        console.log(data)
    }).always(function (data) {
        $('#modalItem').modal('hide')
        location.reload();
    })
}

function setCode(id, elm) {
    

    $(".btnpbls").prop('disabled', true);
    $(".btnupbls").prop('disabled', true);
    $(".abuu").each(function () {
        $(this).css('color', '#666')
    });
    $(elm).css('color', '#e74c3c')
    loadTableItem(id)

    $('.breadcrumb').empty()
    $('.breadcrumb').append('<li><a href="javascript:void(0)"><span style="color:#e74c3c;" class="glyphicon glyphicon-home" aria-hidden="true"></span></a><a href="javascript:void(0)">&nbsp;&nbsp;Kategori</a></li>')
    splitt = id.split("-")
    teks = splitt[0]
    for (var i = 0; i < splitt.length; i++) {
        $(".lvl" + (i + 1)).each(function () {
            if ($(this).data('kode') == teks) {
                $('.breadcrumb').append('<li><a href="javascript:void(0)"  onclick="setCode(\'' + id + '\',this)" data-id="' + $(this).data('id') + '" data-kode="' + $(this).data('kode') + '" data-desc="' + $(this).data('desc') + '" >' + $(this).data('desc') + '</a></li>')
            }
        });
        teks += ('-' + splitt[i + 1])
    }
    ;
}

function loadTableVnd(data) {
    // no = 1;
    $('#table_vnd').DataTable().destroy();
    $('#table_vnd tbody').empty();
    mytable = $('#table_vnd').DataTable({
        "bSort": false,
        "dom": 'rtilp',
        "bAutoWidth": false,
        "deferRender": true,
        "language": {
            "loadingRecords": "<center><b>Please wait - Updating and Loading Data Item...</b></center>"
        },
        "ajax": {
            url: $("#base-url").val() + 'EC_Konfigurasi_Langsung/getVnd',
            type: 'POST',
            dataType: 'json',
            data: {
                items: data
            }
        },
        "columnDefs": [{
            "searchable": false,
            "orderable": true,
            "targets": 0
        }],
        "fnInitComplete": function () {
            $('#table_vnd tbody tr').each(function () {
                $(this).find('td').attr('nowrap', 'nowrap');
            });
        },
        "drawCallback": function (settings) {
            $('#table_vnd tbody tr').each(function () {
                $(this).find('td').attr('nowrap', 'nowrap');
            });
        },
        "columns": [{
            mRender: function (data, type, full) {
                // console.log(full);
                a = ''
                a += "<div class='col-md-12'>"
                // if (full.VENDORNO != null)
                // a += "<input type='checkbox' data-vndno=" + full.VENDOR_NO + " class='vnd' checked>&nbsp;&nbsp;&nbsp;"
                // else
                a += "<input type='checkbox' data-vndno=" + full.VENDOR_NO + " class='vnd'>&nbsp;&nbsp;&nbsp;"
                a += "</div>";
                return a
            }
        }, {
            mRender: function (data, type, full) {
                if (full.VENDOR_NO != null) {
                    a = ''
                    a += "<div class='col-md-12 text-center'>";
                    a += "&nbsp;" + full.VENDOR_NO;
                    a += "</div>";
                    return a;
                } else
                    return "";
            }
        }, {
            mRender: function (data, type, full) {
                if (full.VENDOR_NAME != null) {
                    a = "<div class='col-md-12 text-center'>";
                    a += full.VENDOR_NAME;
                    a += "</div>";
                    return a;
                } else
                    return "";
            }
        }, {
            mRender: function (data, type, full) {        
                if (full.MATKL != null) {
                    a = ''
                    a += "<div class='col-md-12 text-center'>";
                    a += full.MATKL;
                    a += "</div>";
                    return a;
                } else
                    return "";
            }
        }],
    });

    mytable.columns().every(function () {
        var that = this;
        $('.srch', this.header()).on('keyup change', function () {
            if (that.search() !== this.value) {
                // $('#tableMT tbody tr').each(function() {
                // $(this).find('td').attr('nowrap', 'nowrap');
                // });
                that.search(this.value).draw();
            }
        });
    });

} 

function loadTablePlant(data) {
    // no = 1;
    $('#table_plant').DataTable().destroy();
    $('#table_plant tbody').empty();
    mytable = $('#table_plant').DataTable({
        "bSort": false,
        "dom": 'rtilp',
        "pageLength": 25,
        "bAutoWidth": false,
        "deferRender": true,
        "language": {
            "loadingRecords": "<center><b>Please wait - Updating and Loading Data Item...</b></center>"
        },
        "ajax": {
            url: $("#base-url").val() + 'EC_Konfigurasi_Langsung/getPlant',
            type: 'POST',
            dataType: 'json',
            data: {
                items: data
            }
        },
        "columnDefs": [{
            "searchable": false,
            "orderable": true,
            "targets": 0
        }],
        "fnInitComplete": function () {
            $('#table_plant tbody tr').each(function () {
                $(this).find('td').attr('nowrap', 'nowrap');
            });
        },
        "drawCallback": function (settings) {
            $('#table_plant tbody tr').each(function () {
                $(this).find('td').attr('nowrap', 'nowrap');
            });
            $('.chkPlant').change(function () {
                if ($(this).is(":checked"))
                    publishPlant($(this).data("plant"),1)
                else
                    publishPlant($(this).data("plant"),0)
            });
        },
        "columns": [{
            mRender: function (data, type, full) {
                a = ''
                a += "<div class='col-md-12'>"
                if (full.STATUS == 1)
                    a += "<input type='checkbox' data-plant=" + full.PLANT + " class='chkPlant text-center' checked>&nbsp;&nbsp;&nbsp;"
                else
                    a += "<input type='checkbox' data-plant=" + full.PLANT + " class='chkPlant text-center'>&nbsp;&nbsp;&nbsp;"
                a += "</div>";
                return a
            }
        }, {
            mRender: function (data, type, full) {
                if (full.COMPANY != null) {
                    a = ''
                    a += "<div class='col-md-12 text-center'>";
                    a += "&nbsp;" + full.COMPANY;
                    a += "</div>";
                    return a;
                } else
                    return "";
            }
        }, {
            mRender: function (data, type, full) {
                if (full.PLANT != null) {
                    a = "<div class='col-md-12 text-center'>";
                    a += full.PLANT;
                    a += "</div>";
                    return a;
                } else
                    return "";
            }
        }, {
            mRender: function (data, type, full) {
                if (full.DESC != null) {
                    a = ''
                    a += "<div class='col-md-12 text-center'>";
                    a += full.DESC;
                    a += "</div>";
                    return a;
                } else
                    return "";
            }
        }],
    });

    mytable.columns().every(function () {
        var that = this;
        $('.srch', this.header()).on('keyup change', function () {
            if (that.search() !== this.value) {
                // $('#tableMT tbody tr').each(function() {
                // $(this).find('td').attr('nowrap', 'nowrap');
                // });
                that.search(this.value).draw();
            }
        });
    });

}

function loadTableVndItem(data, matgrp) {
    // no = 1;
    $('#table_vnd_2').DataTable().destroy();
    $('#table_vnd_2 tbody').empty();
    mytable = $('#table_vnd_2').DataTable({
        "bSort": false,
        "dom": 'rtilp',
        "bAutoWidth": false,
        "deferRender": true,
        "language": {
            "loadingRecords": "<center><b>Please wait - Updating and Loading Data Item...</b></center>"
        },
        "ajax": {
            url: $("#base-url").val() + 'EC_Konfigurasi_Langsung/getVndMatno',
            type: 'POST',
            dataType: 'json',
            data: {
                items: data,
                itemsgrp: matgrp
            }
        },
        "columnDefs": [{
            "searchable": false,
            "orderable": true,
            "targets": 0
        }],
        "fnInitComplete": function () {
            $('#table_vnd_2 tbody tr').each(function () {
                $(this).find('td').attr('nowrap', 'nowrap');
            });
        },
        "drawCallback": function (settings) {
            $('#table_vnd_2 tbody tr').each(function () {
                $(this).find('td').attr('nowrap', 'nowrap');
            });
        },
        "columns": [{
            mRender: function (data, type, full) {
                // console.log(full);
                a = ''
                a += "<div class='col-md-12'>"
                if (full.VENDORNO != null)
                    a += "<input type='checkbox' data-vndno=" + full.VENDOR_NO + " class='vndEdit' checked>&nbsp;&nbsp;&nbsp;"
                else
                    a += "<input type='checkbox' data-vndno=" + full.VENDOR_NO + " class='vndEdit'>&nbsp;&nbsp;&nbsp;"
                a += "</div>";
                return a
            }
        }, {
            mRender: function (data, type, full) {
                if (full.VENDOR_NO != null) {
                    a = ''
                    a += "<div class='col-md-12 text-center'>";
                    a += "&nbsp;" + full.VENDOR_NO;
                    a += "</div>";
                    return a;
                } else
                    return "";
            }
        }, {
            mRender: function (data, type, full) {
                if (full.VENDOR_NAME != null) {
                    a = "<div class='col-md-12 text-center'>";
                    a += full.VENDOR_NAME;
                    a += "</div>";
                    return a;
                } else
                    return "";
            }
        }, {
            mRender: function (data, type, full) {
                if (full.MATKL != null) {
                    a = ''
                    a += "<div class='col-md-12 text-center'>";
                    a += full.MATKL;
                    a += "</div>";
                    return a;
                } else
                    return "";
            }
        }],
    });

    mytable.columns().every(function () {
        var that = this;
        $('.srch', this.header()).on('keyup change', function () {
            if (that.search() !== this.value) {
                // $('#tableMT tbody tr').each(function() {
                // $(this).find('td').attr('nowrap', 'nowrap');
                // });
                that.search(this.value).draw();
            }
        });
    });

}

function loadTableItem(KODE_USER) {
    // no = 1;
    $('#table_item').DataTable().destroy();
    $('#table_item tbody').empty();
    mytable = $('#table_item').DataTable({
        "bSort": false,
        "dom": 'rtilp',
        "bAutoWidth": false,
        "deferRender": true,
        "language": {
            "loadingRecords": "<center><b>Please wait - Updating and Loading Data Item...</b></center>"
        },

        "ajax": $("#base-url").val() + 'EC_Konfigurasi_Langsung/getItem/' + KODE_USER,
        "columnDefs": [{
            "searchable": false,
            "orderable": true,
            "targets": 0
        }],
        "fnInitComplete": function () {
            $('#table_item tbody tr').each(function () {
                $(this).find('td').attr('nowrap', 'nowrap');
            });
            $('.items').change(function () {
                //$(".btnpbls").prop('disabled', false);
                //$(".btnupbls").prop('disabled', false);
                //$("#assign").prop('disabled', false);
                if ($(this).is(":checked")){
                    if ($(this).data("pil") == 1){
                            $(".btnpbls").prop('disabled', true);
                            $(".btnupbls").prop('disabled', false);
                        }
                        else if ($(this).data("pil") == 0) {
                            $(".btnupbls").prop('disabled', true);
                            $("#assign").prop('disabled', true);
                            $(".btnpbls").prop('disabled', false);
                        }
                }else{
                    $(".btnpbls").prop('disabled', true);
                    $(".btnupbls").prop('disabled', true);
                }

                $(".items").each(function () {
                     //console.log($(this).data("pil"))
                    if ($(this).is(":checked")){
                        if ($(this).data("pil") == 1){
                            $(".btnpbls").prop('disabled', true);
                            $(".btnupbls").prop('disabled', false);
                            $("#assign").prop('disabled', false);
                        }
                        else if ($(this).data("pil") == 0) {
                            $(".btnupbls").prop('disabled', true);
                            $("#assign").prop('disabled', true);
                            $(".btnpbls").prop('disabled', false);
                        }
                    }else{
                        //$(".btnupbls").prop('disabled', true);
                        //$(".btnupbls").prop('disabled', true);
                        //$("#assign").prop('disabled', true);
                        //$(".btnpbls").prop('disabled', true);
                    }
                });
            });
        },
        "drawCallback": function (settings) {
            $('#table_item tbody tr').each(function () {
                $(this).find('td').attr('nowrap', 'nowrap');
            });
            $('.items').change(function () {
                //$(".btnpbls").prop('disabled', false);
                //$(".btnupbls").prop('disabled', false);
                //$("#assign").prop('disabled', false);
                if ($(this).is(":checked")){
                    if ($(this).data("pil") == 1){
                        $(".btnpbls").prop('disabled', true);
                        $(".btnupbls").prop('disabled', false);
                        //$("#assign").prop('disabled', true);
                    }
                    else if ($(this).data("pil") == 0) {
                        $(".btnupbls").prop('disabled', true);
                        $("#assign").prop('disabled', true);
                        $(".btnpbls").prop('disabled', false);
                    }
                }else{
                    $(".btnpbls").prop('disabled', true);
                    $(".btnupbls").prop('disabled', true);
                }

                $(".items").each(function () {
                    console.log($(this).data("pil"))
                    if ($(this).is(":checked")){
                        if ($(this).data("pil") == 1){
                            $(".btnpbls").prop('disabled', true);
                            $(".btnupbls").prop('disabled', false);
                            $("#assign").prop('disabled', false);
                        }
                        else if ($(this).data("pil") == 0) {
                            $(".btnupbls").prop('disabled', true);
                            $("#assign").prop('disabled', true);
                            $(".btnpbls").prop('disabled', false);
                        }
                    }else{
                        //$(".btnupbls").prop('disabled', true);
                        //$(".btnupbls").prop('disabled', true);
                        //$("#assign").prop('disabled', true);
                        //$(".btnpbls").prop('disabled', true);
                    }
                });
            });
        },
        "columns": [{
            mRender: function (data, type, full) {
                // console.log(full);
                a = ''
                a += "<div class='col-md-12'>"
                if (full.PUBLISHED_LANGSUNG == '1') {
                    a += "<input type='checkbox' data-matno=" + full.MATNR + " data-pil=" + 1 + " data-matgrp=" + full.MATKL + " class='items'>&nbsp;&nbsp;&nbsp;"
                    a += '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>'//full.MATNR;
                } else {
                    a += "<input type='checkbox' data-matno=" + full.MATNR + " data-pil=" + 0 + " data-matgrp=" + full.MATKL + " class='items'>&nbsp;&nbsp;&nbsp;"
                }
                a += "</div>";
                return a
            }
        }, {
            mRender: function (data, type, full) {
                if (full.MATNR != null) {
                    a = ''
                    a += "<div class='col-md-12 text-center'>";
                    a += "&nbsp;" + full.MATNR;
                    a += "</div>";
                    return a;
                } else
                    return "";
            }
        }, {
            mRender: function (data, type, full) {
                if (full.MAKTX != null) {
                    a = "<div class='col-md-12 text-center'>";
                    a += full.MAKTX;
                    a += "</div>";
                    return a;
                } else
                    return "";
            }
        }, {
            mRender: function (data, type, full) {
                if (full.MEINS != null) {
                    a = ''
                    a += "<div class='col-md-12 text-center'>";
                    a += full.MEINS;
                    a += "</div>";
                    return a;
                } else
                    return "";
            }
        }, {
            mRender: function (data, type, full) {
                a = ''
                a += "<div class='col-md-12'>";
                if (full.PUBLISHED_LANGSUNG == '1')
                    a += '<input type="datetime" style="height: 30px"  data-matgrp=" + full.MATKL + "  value="' + (full.PEMBUKAAN == null ? "" : full.PEMBUKAAN) + '" class="form-control start" />';
                else
                    a += '<input type="datetime" style="height: 30px" value="" class="form-control start" />';
                a += "</div>";
                return a;
            }
        /*}, {
            mRender: function (data, type, full) {
                a = ''
                a += "<div class='col-md-12'>";
                if (full.PUBLISHED_LANGSUNG == '1')
                    a += '<input type="datetime" style="height: 30px" value="' + (full.PENUTUPAN == null ? "" : full.PENUTUPAN) + '" class="form-control start" />';
                else
                    a += '<input type="datetime" style="height: 30px" value="" class="form-control start" />';
                a += "</div>";
                return a;
            }*/
            // mRender : function(data, type, full) {
            // 	a = ''
            // 	a += "<div class='col-md-12'>";
            // 	if (full.PUBLISHED_LANGSUNG == '1')
            // 		a += '<div class="input-group date"><input readonly id="startdate" type="text" value="" class="form-control" ><span class="input-group-addon"><a href="javascript:void(0)"><i class="glyphicon glyphicon-calendar"></i></a></span></div>';
            // 	else
            // 		a += '<div class="input-group date"><input readonly id="startdate" type="text" value="" class="form-control" ><span class="input-group-addon"><a href="javascript:void(0)"><i class="glyphicon glyphicon-calendar"></i></a></span></div>';
            // 	a += "</div>";
            // 	return a;
            // }
        }, {
            mRender: function (data, type, full) {
                disabled = '';
                a = '';
                a += "<div class='col-md-12'>";
                if (full.PUBLISHED_LANGSUNG == '1'){
                    if(full.PEMBUKAAN == null){
                        disabled = 'disabled';
                    }
                    a += '<button type="button" data-toggle="modal" data-startdate="' + full.PEMBUKAAN + '" data-enddate="' + full.PENUTUPAN + '" data-matgrp="' + full.MATKL + '" data-target="#modalItem" data-full="' + full.MAKTX + '"  data-matno="' + full.MATNR + '" data-curr="' + full.CURRENCY + '" data-upd="' + full.KODE_UPDATE + '"  data-days="' + full.DAYS_UPDATE + '" style="height: 70%" class="btn-sm btn btn-info" '+disabled+'>Vnd</button>';
                }
                else{
                    a += '<button type="button" disabled data-matno="' + full.MATNR + '" style="height: 70%" class="btn-sm btn btn-info" >Vnd</button>';
                }
                a += "</div>";
                return a;
            }
        }],
    });

    mytable.columns().every(function () {
        var that = this;
        $('.srch', this.header()).on('keyup change', function () {
            if (that.search() !== this.value) {
                // $('#tableMT tbody tr').each(function() {
                // $(this).find('td').attr('nowrap', 'nowrap');
                // });
                that.search(this.value).draw();
            }
        });
    });

}

function loadTableItemPublish() {
    // no = 1;
    $('#table_item_publish').DataTable().destroy();
    $('#table_item_publish tbody').empty();
    mytable = $('#table_item_publish').DataTable({
        "bSort": false,
        "dom": 'rtilp',
        "bAutoWidth": false,
        "deferRender": true,
        "language": {
            "loadingRecords": "<center><b>Please wait - Updating and Loading Data Item...</b></center>"
        },

        "ajax": $("#base-url").val() + 'EC_Konfigurasi_Langsung/getItemPublish/',
        "columnDefs": [{
            "searchable": false,
            "orderable": true,
            "targets": 0
        }],
        "fnInitComplete": function () {
            $('#table_item_publish tbody tr').each(function () {
                $(this).find('td').attr('nowrap', 'nowrap');
            });
            $('.items').change(function () {
                //$(".btnpbls").prop('disabled', false);
                //$(".btnupbls").prop('disabled', false);
                //$("#assign").prop('disabled', false);
                if ($(this).is(":checked")){
                    if ($(this).data("pil") == 1){
                            $(".btnpbls").prop('disabled', true);
                            $(".btnupbls").prop('disabled', false);
                        }
                        else if ($(this).data("pil") == 0) {
                            $(".btnupbls").prop('disabled', true);
                            $("#assign").prop('disabled', true);
                            $(".btnpbls").prop('disabled', false);
                        }
                }else{
                    $(".btnpbls").prop('disabled', true);
                    $(".btnupbls").prop('disabled', true);
                }

                $(".items").each(function () {
                     //console.log($(this).data("pil"))
                    if ($(this).is(":checked")){
                        if ($(this).data("pil") == 1){
                            $(".btnpbls").prop('disabled', true);
                            $(".btnupbls").prop('disabled', false);
                            $("#assign").prop('disabled', false);
                        }
                        else if ($(this).data("pil") == 0) {
                            $(".btnupbls").prop('disabled', true);
                            $("#assign").prop('disabled', true);
                            $(".btnpbls").prop('disabled', false);
                        }
                    }else{
                        //$(".btnupbls").prop('disabled', true);
                        //$(".btnupbls").prop('disabled', true);
                        //$("#assign").prop('disabled', true);
                        //$(".btnpbls").prop('disabled', true);
                    }
                });
            });
        },
        "drawCallback": function (settings) {
            $('#table_item_publish tbody tr').each(function () {
                $(this).find('td').attr('nowrap', 'nowrap');
            });
            $('.items').change(function () {
                //$(".btnpbls").prop('disabled', false);
                //$(".btnupbls").prop('disabled', false);
                //$("#assign").prop('disabled', false);
                if ($(this).is(":checked")){
                    if ($(this).data("pil") == 1){
                        $(".btnpbls").prop('disabled', true);
                        $(".btnupbls").prop('disabled', false);
                        //$("#assign").prop('disabled', true);
                    }
                    else if ($(this).data("pil") == 0) {
                        $(".btnupbls").prop('disabled', true);
                        $("#assign").prop('disabled', true);
                        $(".btnpbls").prop('disabled', false);
                    }
                }else{
                    $(".btnpbls").prop('disabled', true);
                    $(".btnupbls").prop('disabled', true);
                }

                $(".items").each(function () {
                    console.log($(this).data("pil"))
                    if ($(this).is(":checked")){
                        if ($(this).data("pil") == 1){
                            $(".btnpbls").prop('disabled', true);
                            $(".btnupbls").prop('disabled', false);
                            $("#assign").prop('disabled', false);
                        }
                        else if ($(this).data("pil") == 0) {
                            $(".btnupbls").prop('disabled', true);
                            $("#assign").prop('disabled', true);
                            $(".btnpbls").prop('disabled', false);
                        }
                    }else{
                        //$(".btnupbls").prop('disabled', true);
                        //$(".btnupbls").prop('disabled', true);
                        //$("#assign").prop('disabled', true);
                        //$(".btnpbls").prop('disabled', true);
                    }
                });
            });
        },
        "columns": [{
            mRender: function (data, type, full) {
                // console.log(full);
                a = ''
                a += "<div class='col-md-12'>"
                if (full.PUBLISHED_LANGSUNG == '1') {
                    a += "<input type='checkbox' data-matno=" + full.MATNR + " data-pil=" + 1 + " data-matgrp=" + full.MATKL + " class='items'>&nbsp;&nbsp;&nbsp;"
                    a += '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>'//full.MATNR;
                } else {
                    a += "<input type='checkbox' data-matno=" + full.MATNR + " data-pil=" + 0 + " data-matgrp=" + full.MATKL + " class='items'>&nbsp;&nbsp;&nbsp;"
                }
                a += "</div>";
                return a
            }
        }, {
            mRender: function (data, type, full) {
                if (full.MATNR != null) {
                    a = ''
                    a += "<div class='col-md-12 text-center'>";
                    a += "&nbsp;" + full.MATNR;
                    a += "</div>";
                    return a;
                } else
                    return "";
            }
        }, {
            mRender: function (data, type, full) {
                if (full.MAKTX != null) {
                    a = "<div class='col-md-12 text-center'>";
                    a += full.MAKTX;
                    a += "</div>";
                    return a;
                } else
                    return "";
            }
        }, {
            mRender: function (data, type, full) {
                if (full.MEINS != null) {
                    a = ''
                    a += "<div class='col-md-12 text-center'>";
                    a += full.MEINS;
                    a += "</div>";
                    return a;
                } else
                    return "";
            }
        }, {
            mRender: function (data, type, full) {
                a = ''
                a += "<div class='col-md-12'>";
                if (full.PUBLISHED_LANGSUNG == '1')
                    a += '<input type="datetime" style="height: 30px"  data-matgrp=" + full.MATKL + "  value="' + (full.PEMBUKAAN == null ? "" : full.PEMBUKAAN) + '" class="form-control start" />';
                else
                    a += '<input type="datetime" style="height: 30px" value="" class="form-control start" />';
                a += "</div>";
                return a;
            }
        /*}, {
            mRender: function (data, type, full) {
                a = ''
                a += "<div class='col-md-12'>";
                if (full.PUBLISHED_LANGSUNG == '1')
                    a += '<input type="datetime" style="height: 30px" value="' + (full.PENUTUPAN == null ? "" : full.PENUTUPAN) + '" class="form-control start" />';
                else
                    a += '<input type="datetime" style="height: 30px" value="" class="form-control start" />';
                a += "</div>";
                return a;
            }*/
            // mRender : function(data, type, full) {
            //  a = ''
            //  a += "<div class='col-md-12'>";
            //  if (full.PUBLISHED_LANGSUNG == '1')
            //      a += '<div class="input-group date"><input readonly id="startdate" type="text" value="" class="form-control" ><span class="input-group-addon"><a href="javascript:void(0)"><i class="glyphicon glyphicon-calendar"></i></a></span></div>';
            //  else
            //      a += '<div class="input-group date"><input readonly id="startdate" type="text" value="" class="form-control" ><span class="input-group-addon"><a href="javascript:void(0)"><i class="glyphicon glyphicon-calendar"></i></a></span></div>';
            //  a += "</div>";
            //  return a;
            // }
        }, {
            mRender: function (data, type, full) {
                disabled = '';
                a = '';
                a += "<div class='col-md-12'>";
                if (full.PUBLISHED_LANGSUNG == '1'){
                    if(full.PEMBUKAAN == null){
                        disabled = 'disabled';
                    }
                    a += '<button type="button" data-toggle="modal" data-startdate="' + full.PEMBUKAAN + '" data-enddate="' + full.PENUTUPAN + '" data-matgrp="' + full.MATKL + '" data-target="#modalItem" data-full="' + full.MAKTX + '"  data-matno="' + full.MATNR + '" data-curr="' + full.CURRENCY + '" data-upd="' + full.KODE_UPDATE + '"  data-days="' + full.DAYS_UPDATE + '" style="height: 70%" class="btn-sm btn btn-info" '+disabled+'>Vnd</button>';
                }
                else{
                    a += '<button type="button" disabled data-matno="' + full.MATNR + '" style="height: 70%" class="btn-sm btn btn-info" >Vnd</button>';
                }
                a += "</div>";
                return a;
            }
        }],
    });

    mytable.columns().every(function () {
        var that = this;
        $('.srch', this.header()).on('keyup change', function () {
            if (that.search() !== this.value) {
                // $('#tableMT tbody tr').each(function() {
                // $(this).find('td').attr('nowrap', 'nowrap');
                // });
                that.search(this.value).draw();
            }
        });
    });

}

function syncPlant() {
    $.ajax({
        url: $("#base-url").val() + 'EC_Konfigurasi_Langsung/syncPlant/',
        type: 'POST',
        dataType: 'json'
    }).done(function (data) {
        console.log("done");
    }).fail(function () {
        console.log("error");
    }).always(function (data) {
        loadTablePlant()
    });
}

function publishPlant(plant,stat) {
    $.ajax({
        url: $("#base-url").val() + 'EC_Konfigurasi_Langsung/publishPlant/'+plant+'/'+stat,
        type: 'POST',
        dataType: 'json'
    }).done(function (data) {
        console.log("done");
    }).fail(function () {
        console.log("error");
    }).always(function (data) {
        //loadTablePlant()
        alert("Tersimpan")
    });
}
function loadTree() {
    $("#cat").hover(function () {
        $("#tbl_item").attr("class", "col-md-9");
        $(this).attr("class", "col-md-3");
    }, function () {
        $("#tbl_item").attr("class", "col-md-9");
        $(this).attr("class", "col-md-3");
    });
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
        // if (window.location.pathname.indexOf('list') > -1) {
        $('#tree1').treed();
        $('#tree1 .branch').each(function () {
            var icon = $(this).children('a:first').children('i:first');
            icon.toggleClass('glyphicon-minus-sign glyphicon-plus-sign');
            $(this).children().children().toggle();

        });
        // }
    }).fail(function () {
        console.log("error");
    }).always(function (data) {
        // loadDataList();
        $("ul").each(function () {
            if ($(this).find('a').length < 1)
                $(this).prev().prev().empty()
        });
        
    });
    // $('.lvl3').parent.removeChild(d)
}

function chkAll(elm, mode) {
    if ($(elm).is(":checked"))
        $('.' + mode).prop("checked", true);
    else
        $('.' + mode).prop("checked", false);
}

function klik(elm) {
    if ($(elm).find('input').is(":checked"))
        $('.' + mode).find('input').prop("checked", true);
    else
        $('.' + mode).find('input').prop("checked", false);
}