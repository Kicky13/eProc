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
        "ajax" : $("#base-url").val() + 'EC_Approval/E_Nofa/getAllEnofa',

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
                
                a = "<div class='col-md-12 text-center'>";
                a += full.CREATE_BY+' - '+full.VENDOR_NAME;
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
                    a += "<a href='"+$("#base-url").val()+"EC_Vendor/Form_Enofa/"+full.ID+"' title='Edit E-Nofa'><span class='glyphicon glyphicon-edit' aria-hidden='true'></span></a>&nbsp;&nbsp;"+
                     "<a href='"+$("#base-url").val()+"EC_Vendor/deleteEnofa/"+full.ID+"' title='Hapus E-Nofa'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></a>&nbsp;&nbsp;";
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
        "ajax" : $("#base-url").val() + 'EC_Approval/E_Nofa/getApprovedEnofa',

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
                
                a = "<div class='col-md-12 text-center'>";
                a += full.VENDOR;
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

        $(":file").filestyle({buttonText: " Find file"});
    };

});

$('#viewEnofa').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget);
    var _id = button.data('id_enofa');
    
    $.ajax({
        url : $("#base-url").val()+'EC_Vendor/getEnofaById/'+_id,
        type : 'POST',
        dataType : 'json'
    }).done(function(data) {
        if(data['ID']){
            $('#viewEnofa').modal('hide');
            $("#msg").html("Data Sudah Dihapus oleh Vendor");
            $("#msg").removeClass('hide');
            loadTable();
        }else{
            var teks = "<tr><th><strong>Field</strong></td><td><strong>Value</strong></td></tr>";
            var _status = {
                1 : 'REQUEST',
                2 : 'APPROVED',
                3 : 'REJECTED'
            };
            var base = $("#base-url").val().replace('https://','').replace('http://','').replace('int-','');
            var _url = 'https://' +base+"upload/EC_invoice/E_Nova/"+data[0]['IMAGE'];
            //var _url = 'https://10.15.3.142/eproc/upload/EC_invoice/E_Nova/'+data[0]['IMAGE'];
            teks +="<tr><td><strong>Nama Vendor</strong></td><td>"+data['0']['VENDOR_NAME']+"</td></tr>";
            teks +="<tr><td><strong>No. Awal E-Nofa</strong></td><td>"+data['0']['START_NO']+"</td></tr>";
            teks +="<tr><td><strong>No. Akhir E-Nofa</strong></td><td>"+data['0']['END_NO']+"</td></tr>";
            teks +="<tr><td><strong>Tanggal Mulai Aktif No. Seri E-Nofa</strong></td><td>"+data['0']['START_DATE2']+"</td></tr>";
            teks +="<tr><td><strong>Tanggal Berakhir No. Seri E-Nofa</strong></td><td>"+data['0']['END_DATE2']+"</td></tr>";
            teks +="<tr><td><strong>Dibuat pada</strong></td><td>"+data['0']['CREATE_DATE2']+"</td></tr>";
            teks +="<tr><td><strong>Status</strong></td><td>"+_status[data['0']['STATUS']]+"</td></tr>";
            teks +="<tr><td><strong>File E-Nofa</strong></td><td><a href='"+_url+"' target=_blank><u>Click Disini</u></a></td></tr>";
        
            $("#tabel_view").html(teks);

            var _btn = "<button type=button data-id='"+data['0']['ID']+"' onClick='approveENofa(this)' class='btn btn-success' data-dismiss='modal'>APPROVE</button>";
            _btn += "<button type=button data-id='"+data['0']['ID']+"' onClick='rejectENofa(this)' class='btn btn-danger'>REJECT</button>";
            $("#viewEnofa .modal-footer").html(_btn);
        }
    })
});

function approveENofa(elm){
    var _id = $(elm).data('id');
    var _url = $("#base-url").val() + "EC_Approval/E_Nofa/verENofa";

    $.post(_url,{id_enova : _id, status : 2}, function(data){
        $("#msg").html(data.msg);
        $("#msg").removeClass('hide');
        loadTable();  
    },'json');
}

function rejectENofa(elm){
    var _id = $(elm).data('id');
    $('#rejectNote').modal('show');
    $('input[name=id_enova]').val(_id);
    $('input[name=status]').val('3');
    $('textarea#msg').val('');
    $('input[name=img]').filestyle('clear');
}

$('form').submit(function(e){
    var form = this
    e.preventDefault();
    
    var _formdata = new FormData();

    _formdata.append('id_enova',$('input[name=id_enova]').val());
    _formdata.append('status',$('input[name=status]').val());
    _formdata.append('msg',$('textarea#msg').val());
    _formdata.append('img',$('input[name=img]')[0].files[0]);

    $.ajax({
        url: $("#base-url").val() + "EC_Approval/E_Nofa/verENofa",
        data: _formdata,
        processData: false,
        contentType: false,
        type: 'POST',
        success: function(data){
            var odata = JSON.parse(data);
            $('.modal').modal('hide');
            $("#msg").html(odata.msg);
            $("#msg").removeClass('hide');
            loadTable(); 
        }
    });
});