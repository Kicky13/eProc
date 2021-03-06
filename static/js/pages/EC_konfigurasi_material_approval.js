function numberWithCommas(x) {
    return x == null || x == "0" ? "" : x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

function loadTable_() {

    $('#table_conf').DataTable().destroy();
    $('#table_conf tbody').empty();
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
        "ajax": $("#base-url").val() + 'EC_Konfigurasi_Material_Approval/getMaster_data',

        "columnDefs": [{
            "searchable": false,
            "orderable": true,
            "targets": 0
        }],
        // "order": [[ 1, 'asc' ]],
        "fnInitComplete": function () {
            $('#table_conf tbody tr').each(function () {
                $(this).find('td').attr('nowrap', 'nowrap');
                // $(this).find('td').addClass('text-center');
            });
        },
        /*"fnCreatedRow": function (row, data, index) {
            $('td', row).eq(0).html("<div class='col-md-12 text-center'>"+(index + 1)+"</div>");
        },*/
        "drawCallback": function (settings) {
            $('#table_conf tbody tr').each(function () {
                $(this).find('td').attr('nowrap', 'nowrap');
            });
        },
        "columns": [{
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.USER_ID;
                a += "</div>";
                return a;
            }
        }, {
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.FULLNAME;
                a += "</div>";
                return a;
            }
        }, {
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.COMPANYNAME;
                a += "</div>";
                return a;
            }
        }, {
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.MATGROUP;
                a += "</div>";
                return a;
            }
        }, {
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.CONF_LEVEL;
                a += "</div>";
                return a;
            }
        }, {
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.PROPOSE_DATE;
                a += "</div>";
                return a;
            }
        }, {
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>" +
                    // '<a href="javascript:void(0)" data-toggle="modal" data-target="#modalDetil" data-lvl="' + (full.LEVEL) + '" data-id="' + (full.ID) + '" data-datein="' + (full.DATEIN) + '" data-username="' + (full.FULLNAME) + '" data-userid="' + (full.USER_ID) + '"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span></a>&nbsp;&nbsp;' +
                    '<a href="javascript:deleteMaster(' + (full.ID) + ')"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>&nbsp;&nbsp;' +
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

    $('#table_conf').find("th").off("click.DT");
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
    /*$('.ts7').on('dblclick', function () {
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
    });*/
}

function deleteMaster(ID) {
    bootbox.confirm('Konfirmasi Hapus?', function (result) {
        if (result)
            window.location.href = $("#base-url").val() + 'EC_Konfigurasi_Material_Approval/delete/' + ID
    });
}

$('#addNew').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget)

});

$('#modalDetil').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget)
    $("#viewusername").val(button.data('userid')+':'+button.data('username')).trigger("change");
    $("#viewlvl").val(button.data('lvl'))
    $("#viewId").val(button.data('id'))
    $("#viewUserid").val(button.data('userid'))
    $("#setLvl").val(button.data('lvl'))

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

function simpan() {
    matgrp = $('#matgrp').val();
    app = $('#lvl').val();
    userid = $('#ID_USER').val();
    if (matgrp == '' || app == '' || userid == ''){
        if (matgrp == ''){
            alert('Material Group tidak boleh kosong');
        } else if (app == ''){
            alert('Level Approval tidak boleh kosong');
        } else {
            alert('User tidak boleh kosong');
        }
    } else {
        $.ajax({
            url: $("#base-url").val() + 'EC_Konfigurasi_Material_Approval/simpan/',
            data: {
                "userid": userid,
                "lvl": app,
                "matgrp": matgrp
            },
            type: 'POST',
            dataType: 'json'
        }).done(function (data) {
            alert(data.responseText);
        }).fail(function (data) {
            alert(data.responseText);
        }).always(function (data) {
            if(data.responseText=='Success'){
                location.reload(true);
            }
        });
    }
}

function update() {
    $.ajax({
        url: $("#base-url").val() + 'EC_Konfigurasi_Material_Approval/update/',
        data: {
            "userid": $('#viewusername').val(),
            "lvl": $('#viewlvl').val(),
            "id": $('#viewId').val()
        },
        type: 'POST',
        dataType: 'json'
    }).done(function (data) {
        alert(data.responseText);
    }).fail(function (data) {
        alert(data.responseText);
    }).always(function (data) {
        if(data.responseText=='Success'){
            location.reload(true);
        }
    });

}

$(document).ready(function () {

    loadTable_();
    $("#txt_Nama").val('');
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

    var CCopt1 = $(".CCnew1").select2({
        dropdownParent: $('#addConfig')
    });
    var CCopt3 = $(".CCnew3").select2({
        dropdownParent: $('#addConfig')
    });

    var CCopt = $(".CC2").select2({
        dropdownParent: $('#modalDetil')
    });

    CCopt1.on("select2:select", function (e) {
        console.log($(this).val())
        $.ajax({
            url: $("#base-url").val() + 'EC_Master_Approval/checkCNF/',
            data: {
                "costCenter": $(this).val()
            },
            type: 'POST',
            dataType: 'json'
        }).done(function (data) {
            console.log(data.CNF);
            if(data.CNF==null){
                $('#lvl').val('1')
                $('#valueFrom').val('')
            }else{
                $('#lvl').val((parseInt(data.CNF)+1))
                $('#valueFrom').val((parseInt(data.VALUE_TO)+1))
            }
        }).fail(function (data) {

        }).always(function (data) {

        });
    });

    CCopt3.on("select2:select", function (e) {
        console.log($(this).val())
        if($(this).val()=='GUDANG'){
            $('#lvl').val('0')
            $('#valueFrom').val('0')
            $('#valueTo').val('0')
        }else{
            $.ajax({
                url: $("#base-url").val() + 'EC_Master_Approval/checkCNF/',
                data: {
                    "costCenter": $('#cc').val()
                },
                type: 'POST',
                dataType: 'json'
            }).done(function (data) {
                console.log(data.CNF);
                if(data.CNF==null){
                    $('#lvl').val('1')
                    $('#valueFrom').val('')
                }else{
                    $('#lvl').val((parseInt(data.CNF)+1))
                    $('#valueFrom').val((parseInt(data.VALUE_TO)+1))
                }
            }).fail(function (data) {

            }).always(function (data) {

            });
        }
    });

});

$(function(){
    $('.nama').autocomplete({
        dropdownParent: $('#addNew'),
        // serviceUrl berisi URL ke controller/fungsi yang menangani request kita
        serviceUrl: $("#base-url").val() + 'EC_Master_Approval/search_nama',
        // fungsi ini akan dijalankan ketika user memilih salah satu hasil request
        onSelect: function (suggestion) {
            $("#txt_Nama").val(suggestion.value);
            $("#ID_USER").val(suggestion.ID_USER);
        }
    });
});
