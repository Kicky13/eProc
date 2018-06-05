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
        "ajax": $("#base-url").val() + 'EC_Master_Approval/getMaster_approval',

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
        /*"fnCreatedRow": function (row, data, index) {
            $('td', row).eq(0).html("<div class='col-md-12 text-center'>"+(index + 1)+"</div>");
        },*/
        "drawCallback": function (settings) {
            $('#table_inv tbody tr').each(function () {
                $(this).find('td').attr('nowrap', 'nowrap');
            });  
        },
        "columns": [{
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += (full.UK_CODE);
                a += "</div>";
                return a;
            }
        }, {
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += (full.VALUE_FROM);
                a += "</div>";
                return a;
            }
        }, {
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.VALUE_TO;
                a += "</div>";
                return a;
            }
        }, {
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                //a += numberWithCommas(full.PRICE * full.STOK_COMMIT);
                a += full.USERNAME;
                a += "</div>";
                return a;
            }
        }, {
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.USERID;
                a += "</div>";
                return a;
            }
        }, {
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.PROGRESS_CNF;
                a += "</div>";
                return a;
            }
        }, /*{
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.COMMIT_DATE;
                a += "</div>";
                return a;
            }
        },*/{
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>" +
                    '<a href="javascript:void(0)" data-toggle="modal" data-target="#modalDetil" data-cc="' + (full.UK_CODE) + '" data-cnf="' + (full.PROGRESS_CNF) + '" data-valuefrom="' + (full.VALUE_FROM) + '" data-valueto="' + (full.VALUE_TO) + '" data-username="' + (full.USERNAME) + '" data-userid="' + (full.USERID) + '"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span></a>&nbsp;&nbsp;' +
                    '<a href="javascript:deleteMaster(' + (full.UK_CODE) + ',' + (full.PROGRESS_CNF) + ')"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>&nbsp;&nbsp;' +    
                    '</div>';
                return a;
            }
        }],
             /*{
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>" +
                    '<a href="javascript:approve(' + (full.PROGRESS_CNF) + ')"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></a>&nbsp;&nbsp;' +
                    '<a href="javascript:reject(' + (full.PROGRESS_CNF) + ')"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>&nbsp;&nbsp;' +
                    '<a href="javascript:void(0)" data-toggle="modal" data-target="#modalDetil" data-pono="' + (full.PROGRESS_CNF) + '" data-curr="' + (full.PROGRESS_CNF) + '"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span></a>&nbsp;&nbsp;' +
                    '<a href="javascript:void(0)" data-toggle="modal" data-target="#modalHistory" data-pono="' + (full.PROGRESS_CNF) + '"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></a>' +
                    '</div>';
                return a;
            }
        }],*/

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
    /*$('.ts6').on('dblclick', function () {
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
    });*/
}

function approve(PO) {
    bootbox.confirm('Konfirmasi Approve PO?', function (result) {
        if (result)
            window.location.href = $("#base-url").val() + 'EC_PO_PL_Approval/approve/' + PO
    });
}

function deleteMaster(CC,CNF) {
    bootbox.confirm('Konfirmasi Hapus?', function (result) {
        if (result)
            window.location.href = $("#base-url").val() + 'EC_Master_Approval/delete/' + CC +'/'+ CNF
    });
}

$('#addNew').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget)
    
});

$('#modalDetil').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget)
    
    $("#viewcc").val(button.data('cc')).trigger("change");
    $("#viewvalueFrom").val(button.data('valuefrom'))
    $("#viewvalueTo").val(button.data('valueto'))
    $("#viewusername").val(button.data('userid')+':'+button.data('username')).trigger("change");
    $("#viewcnf").val(button.data('cnf'))

    $("#costCenter").val(button.data('cc'))
    $("#setCnf").val(button.data('cnf'))    

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
    // console.log($(element).is(":checked"));
    //console.log($(element).parent().parent().find(".endDate").data('provide'))
    // var harga1 = $('#' + harga).val();
    // var currency = $('#' + curr).val();
    // var time = $('#' + deliverytime).val();
    // if (harga1 == '' || currency == null || time == '') {
    //     alert('Harga, currency atau delivery time masih kosong');
    // } else {
        // if (confirm('Apakah anda yakin menyimpan data ini ?'))
            $.ajax({
                url: $("#base-url").val() + 'EC_Master_Approval/simpan/',
                data: {
                    "cc": $('#cc').val(),
                    "valueFrom": $('#valueFrom').val(),
                    "valueTo": $('#valueTo').val(),
                    "username": $('#username').val(),
                    "cnf": $('#cnf').val()
                },
                type: 'POST',
                dataType: 'json'
            }).done(function (data) { 
                //location.reload(true);
                alert(data.responseText);
                // if (alert(data.responseText))
                // {
                //     window.location.reload();
                // }
                //window.location.reload();
                //window.location = $("#base-url").val() + 'EC_Master_Approval/';
                //console.log(data);
            }).fail(function (data) {
                alert(data.responseText);
                // console.log("error");
                // $("#pocreated").text(data['RETURN'][0]['MESSAGE'])
            }).always(function (data) {
                if(data.responseText=='Success'){
                    location.reload(true);
                }                
                // console.log(data)
                //$("#statsPO").text(data)
            });
    // }

}

function update() {
    // console.log($(element).is(":checked"));
    //console.log($(element).parent().parent().find(".endDate").data('provide'))
    // var harga1 = $('#' + harga).val();
    // var currency = $('#' + curr).val();
    // var time = $('#' + deliverytime).val();
    // if (harga1 == '' || currency == null || time == '') {
    //     alert('Harga, currency atau delivery time masih kosong');
    // } else {
        // if (confirm('Apakah anda yakin menyimpan data ini ?'))
            $.ajax({
                url: $("#base-url").val() + 'EC_Master_Approval/update/',
                data: {
                    "costCenter": $('#costCenter').val(),
                    "setCnf": $('#setCnf').val(),
                    "cc": $('#viewcc').val(),
                    "valueFrom": $('#viewvalueFrom').val(),
                    "valueTo": $('#viewvalueTo').val(),
                    "username": $('#viewusername').val(),
                    "cnf": $('#viewcnf').val()
                },
                type: 'POST',
                dataType: 'json'
            }).done(function (data) { 
                //location.reload(true);
                alert(data.responseText);
                // if (alert(data.responseText))
                // {
                //     window.location.reload();
                // }
                //window.location.reload();
                //window.location = $("#base-url").val() + 'EC_Master_Approval/';
                //console.log(data);
            }).fail(function (data) {
                alert(data.responseText);
                // console.log("error");
                // $("#pocreated").text(data['RETURN'][0]['MESSAGE'])
            }).always(function (data) {
                if(data.responseText=='Success'){
                    location.reload(true);
                }                
                // console.log(data)
                //$("#statsPO").text(data)
            });
    // }

}

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

    var CCopt = $(".CC").select2({
        dropdownParent: $('#addNew')
    });

    var CCopt = $(".CC2").select2({
        dropdownParent: $('#modalDetil')
    });
    //CCopt.on("select2:select", function (e) {
        //console.log($(this).val())
        //loadTableBG($(this).val())
        // table.ajax.url($("#base-url").val() + 'EC_Ecatalog/GET_REPORTBUDGET/' + $(this).val()).load();
    //});
});
