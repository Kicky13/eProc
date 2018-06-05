function loadTable() {

    $('#table_enofa').DataTable().destroy();
    $('#table_enofa tbody').empty();
    mytable = $('#table_enofa').DataTable({
        "bSort" : true,
        "dom" : 'rtpli',
        "deferRender" : true,
        "colReorder" : true,
        "pageLength" : 15,
        // "fixedHeader" : true,
        // "scrollX" : true,
        "lengthMenu" : [5, 10, 15, 25, 50, 75, 100],
        "language" : {
            "loadingRecords" : "<center><b>Please wait - Updating and Loading Data List Contract...</b></center>"
        },
        "ajax" : $("#base-url").val() + 'EC_Vendor/getAllEnofa',

        "columnDefs" : [{
            "searchable" : false,
            "orderable" : true,
            "targets" : 0
        }],
        // "order": [[ 1, 'asc' ]],
        "fnInitComplete" : function() {
            $('#table_enofa tbody tr').each(function() {
                $(this).find('td').attr('nowrap', 'nowrap');
            });
        },
        "fnCreatedRow": function (row, data, index) {
                    $('td', row).eq(0).html(index + 1);
                },
        "drawCallback" : function(settings) {
            $('#table_enofa tbody tr').each(function() {
                $(this).find('td').attr('nowrap', 'nowrap');
            });
        },
        "columns" : [
                 {
            mRender : function(data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += "#";
                a += "</div>";
                return a;
            }
        }, {
            mRender : function(data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.START_DATE2;
                a += "</div>";
                return a;
            }
        },{
            mRender : function(data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.END_DATE2;
                a += "</div>";
                return a;
            }
        }, {
            mRender : function(data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.START_NO;
                a += "</div>";
                return a;
            }
        },{
            mRender : function(data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.END_NO;
                a += "</div>";
                return a;
            }
        }, {
            mRender : function(data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.CREATE_DATE2;
                a += "</div>";
                return a;
            }
        }, {
            mRender : function(data, type, full) {
                if(full.UPDATE_BY == null)by='-'
                else by = full.UPDATE_BY;
                a = "<div class='col-md-12 text-center'>";
                a += by;
                a += "</div>";
                return a;
            }
        },{
            mRender : function(data, type, full) {
                if (full.STATUS == '1') {
                    status = "REQUEST";
                } else if (full.STATUS == '2') {
                    status = "APPROVED";
                } else if (full.STATUS == '3') {
                    status = "REJECTED";
                }

                a = "<div class='col-md-12 text-center'>";
                a += status;
                a += "</div>";
                return a;
            }
        },{
            mRender : function(data, type, full) {
                a = "<div class='col-md-12'>";
                a += "<a href='javascript:void(0)' data-id_enofa = '"+full.ID+"'data-toggle=\"modal\" data-target=\"#viewEnofa\" title='View E-Nova' data-id><span class='glyphicon glyphicon-eye-open' aria-hidden='true'></span></a>&nbsp;&nbsp;";
                if(full.STATUS == '3'){
                    a += "<a href='"+$("#base-url").val()+"EC_Vendor/Form_Enofa/"+full.ID+"' title='Edit E-Nofa'><span class='glyphicon glyphicon-edit' aria-hidden='true'></span></a>&nbsp;&nbsp;";
                } 

                if(full.STATUS == '1' || full.STATUS == '3'){
                    a +="<a href='javascript:void(0)' onClick = 'hapusENofa(this)' data-id_enofa = '"+full.ID+"' title='Hapus E-Nofa'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></a>";
                }
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

    $('#table_enofa').find("th").off("click.DT");
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

    clicks = 0,
    timer = null;
var t = [t0, t1, t2, t3, t4, t5, t6, t7, t8];




function loadTable2() {

    $('#table_enofa2').DataTable().destroy();
    $('#table_enofa2 tbody').empty();
    mytable = $('#table_enofa2').DataTable({
        "bSort" : true,
        "dom" : 'rtpli',
        "deferRender" : true,
        "colReorder" : true,
        "pageLength" : 15,
        // "fixedHeader" : true,
        // "scrollX" : true,
        "lengthMenu" : [5, 10, 15, 25, 50, 75, 100],
        "language" : {
            "loadingRecords" : "<center><b>Please wait - Updating and Loading Data List Contract...</b></center>"
        },
        "ajax" : $("#base-url").val() + 'EC_Vendor/getApprovedEnofa',

        "columnDefs" : [{
            "searchable" : false,
            "orderable" : true,
            "targets" : 0
        }],
        // "order": [[ 1, 'asc' ]],
        "fnInitComplete" : function() {
            $('#table_enofa2 tbody tr').each(function() {
                $(this).find('td').attr('nowrap', 'nowrap');
            });
        },
        "fnCreatedRow": function (row, data, index) {
                    $('td', row).eq(0).html(index + 1);
                },
        "drawCallback" : function(settings) {
            $('#table_enofa2 tbody tr').each(function() {
                $(this).find('td').attr('nowrap', 'nowrap');
            });
        },
        "columns" : [
                 {
            mRender : function(data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += "#";
                a += "</div>";
                return a;
            }
        }, {
            mRender : function(data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.START_DATE;
                a += "</div>";
                return a;
            }
        },{
            mRender : function(data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.END_DATE;
                a += "</div>";
                return a;
            }
        }, {
            mRender : function(data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.START_NO;
                a += "</div>";
                return a;
            }
        },{
            mRender : function(data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.END_NO;
                a += "</div>";
                return a;
            }
        }, {
            mRender : function(data, type, full) {
                var by = '';
                if(full.APPROVED_BY == ''){
                    by = '-';
                }else{
                    by = full.APPROVED_BY;
                }
                a = "<div class='col-md-12 text-center'>";
                a += by;
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

    $('#table_enofa2').find("th").off("click.DT");
    $('.te0').on('dblclick', function() {
        if (te0) {
            mytable.order([0, 'asc']).draw();
            te0 = false;
        } else {
            mytable.order([0, 'desc']).draw();
            te0 = true;
        }
    });
    $('.te1').on('dblclick', function() {
        if (te1) {
            mytable.order([1, 'asc']).draw();
            te1 = false;
        } else {
            mytable.order([1, 'desc']).draw();
            te1 = true;
        }
    });
    $('.te2').on('dblclick', function() {
        if (te2) {
            mytable.order([2, 'asc']).draw();
            te2 = false;
        } else {
            mytable.order([2, 'desc']).draw();
            te2 = true;
        }
    });
    $('.te3').on('dblclick', function() {
        if (te3) {
            mytable.order([3, 'asc']).draw();
            te3 = false;
        } else {
            mytable.order([3, 'desc']).draw();
            te3 = true;
        }
    });
    $('.te4').on('dbldblclick', function() {
        if (te4) {
            mytable.order([4, 'asc']).draw();
            te4 = false;
        } else {
            mytable.order([4, 'desc']).draw();
            te4 = true;
        }
    });
    $('.te5').on('dblclick', function() {
        if (te5) {
            mytable.order([5, 'asc']).draw();
            te5 = false;
        } else {
            mytable.order([5, 'desc']).draw();
            te5 = true;
        }
    });
    $('.te6').on('dblclick', function() {
        if (te6) {
            mytable.order([6, 'asc']).draw();
            te6 = false;
        } else {
            mytable.order([6, 'desc']).draw();
            te6 = true;
        }
    });
    $('.te7').on('dblclick', function() {
        if (te7) {
            mytable.order([7, 'asc']).draw();
            te7 = false;
        } else {
            mytable.order([7, 'desc']).draw();
            te7 = true;
        }
    });
   $('.te8').on('dblclick', function() {
        if (te8) {
            mytable.order([8, 'asc']).draw();
            te8 = false;
        } else {
            mytable.order([8, 'desc']).draw();
            te8 = true;
        }
    });
}

var te0 = true,
    te1 = true,
    te2 = true,
    te3 = true,
    te4 = true,
    te5 = true,
    te6 = true,
    te7 = true,
    te8 = true,

    clicks = 0,
    timer = null;
var t = [te0, te1, te2, te3, te4, te5, te6, te7, te8];




$(document).ready(function() {

    loadTable();
    loadTable2();
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
    $(".sear2").hide();
    for (var i = 0; i < t.length; i++) {
        $(".te" + i).on("click", function(e) {
            clicks++;
            if (clicks === 1) {
                timer = setTimeout(function() {
                    $(".sear2").toggle();
                    clicks = 0;
                }, 300);
            } else {
                clearTimeout(timer);
                $(".sear2").hide();
                clicks = 0;
            }
        }).on("dblclick", function(e) {
            e.preventDefault();
        });
    };
});

$('#viewEnofa').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget);
    var _id = button.data('id_enofa');

    //alert(_id);
    
    $.ajax({
        url : $("#base-url").val()+'EC_Vendor/getEnofaById/'+_id,
        type : 'POST',
        dataType : 'json'
    }).done(function(data) {
        if(data['ID']){
            $('#viewEnofa').modal('hide');
            $("#msg").html("Data Sudah Dihapus");
            $("#msg").removeClass('hide');
            loadTable();
        }else{
            var teks = "<tr><th><strong>Field</strong></td><td><strong>Value</strong></td></tr>";
            var _status = {
                1 : 'REQUEST',
                2 : 'APPROVED',
                3 : 'REJECTED'
            };
            teks +="<tr><td><strong>No. Awal E-Nofa</strong></td><td>"+data['0']['START_NO']+"</td></tr>";
            teks +="<tr><td><strong>No. Akhir E-Nofa</strong></td><td>"+data['0']['END_NO']+"</td></tr>";
            teks +="<tr><td><strong>Tanggal Mulai E-Nofa</strong></td><td>"+data['0']['START_DATE2']+"</td></tr>";
            teks +="<tr><td><strong>Tanggal Expired</strong></td><td>"+data['0']['END_DATE2']+"</td></tr>";
            teks +="<tr><td><strong>Dibuat pada</strong></td><td>"+data['0']['CREATE_DATE2']+"</td></tr>";
            teks +="<tr><td><strong>Status</strong></td><td>"+_status[data['0']['STATUS']]+"</td></tr>";
            teks +="<tr><td><strong>File E-Nofa</strong></td><td><a href='"+$("#base-url").val()+"upload/EC_invoice/E_Nova/"+data[0]['IMAGE']+"' target=_blank><u>Click Disini</u></a></td></tr>";
            //teks +="<tr class='text-center'><td colspan='2'><img src='"+$("#base-url").val()+"upload/EC_invoice/E_Nova/"+data[0]['IMAGE']+"' class='img-thumbnail' title='Gambar E-Nofa' alt='Gambar E-Nofa'></td></tr>";
        
            $("#tabel_view").html(teks);
        }
    }).fail(function() {
         //alert('error');
    }).always(function(data) {
        // console.log(data);

    });
});


function hapusENofa(elm){
    var _id = $(elm).data('id_enofa');
    var _url = $("#base-url").val() + 'EC_Vendor/deleteEnofa';

    bootbox.confirm("Apakah Anda Yakin", function(res){
        if(res){    
            $.post(_url,{id_enofa : _id}, function(data){
                if(data.status){
                    $("#msg").html("Data Berhasil Dihapus");
                    $("#msg").removeClass('hide');
                    loadTable();
                }else{
                    $("#msg").html("Data Gagal Dihapus");
                    $("#msg").removeClass('hide');
                    loadTable();
                }
            },'json');
        }
    });
}
