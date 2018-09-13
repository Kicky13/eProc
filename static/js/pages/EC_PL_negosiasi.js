

$(document).ready(function () {

    console.log('test');
    loadTable_Active();
    loadTable_Archive();

    $('#modalNego').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var username = (button.data('username'));
        var user = (button.data('userid'));
        var negoid = (button.data('negoid'));
        var plant = (button.data('plant'));
        var plantname = (button.data('plantname'));
        var matno = (button.data('matno'));
        var maktx = (button.data('maktx'));
        $('#userNego').text(username);
        $('#materialNego').text(maktx + '(' + matno + ')');
        $('#plantNego').text(plant + ' - ' + plantname);
        $('#plantHide').val(plant);
        $('#negoidHide').val(negoid);
        $('#matnoHide').val(matno);
        $('#useridHide').val(user);
        loadChat(negoid);
    });

    $('#modalNegoArchive').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var username = (button.data('username'));
        var negoid = (button.data('negoid'));
        var plant = (button.data('plant'));
        var plantname = (button.data('plantname'));
        var matno = (button.data('matno'));
        var maktx = (button.data('maktx'));
        $('#userNegoArc').text(username);
        $('#materialNegoArc').text(maktx + '(' + matno + ')');
        $('#plantNegoArc').text(plant + ' - ' + plantname);
        loadChatArchive(negoid);
    });

    $('#sendMsg').click(function () {
        var negoid = $('#negoidHide').val();
        var msg = $('#chatMsg').val();

        $.ajax({
            url: $('#base-url').val() + 'EC_Negosiasi_Ecatalog/sendMessage',
            type: 'POST',
            dataType: 'json',
            data: {
                negoId: negoid,
                message: msg
            },
        }).done(function (data) {
            console.log(data);
            $('#chatMsg').val('');
            loadChat(negoid);
        }).always(function (data) {
            console.log(data);
        })
    });
});

function loadTable_Active() {

    $('#table_nego_active').DataTable().destroy();
    $('#table_nego_active tbody').empty();
    mytable = $('#table_nego_active').DataTable({
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
            "loadingRecords": "<center><b>Please wait - Updating and Loading Data...</b></center>"
        },
        "ajax": $("#base-url").val() + 'EC_Negosiasi_Ecatalog/getActiveNego',

        /*"columnDefs": [{
            "searchable": false,
            "orderable": true,
            "targets": 0
        }],*/
        // "order": [[ 1, 'asc' ]],
        "fnInitComplete": function () {
            $('#table_nego_active tbody tr').each(function () {
                $(this).find('td').attr('nowrap', 'nowrap');
                // $(this).find('td').addClass('text-center');
            });
        },
        /*"fnCreatedRow": function (row, data, index) {
            $('td', row).eq(0).html("<div class='col-md-12 text-center'>"+(index + 1)+"</div>");
        },*/
        "drawCallback": function (settings) {
            $('#table_nego_active tbody tr').each(function () {
                $(this).find('td').attr('nowrap', 'nowrap');
            });
        },
        "columns": [{
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.OPENDATE;
                a += "</div>";
                return a;
            }
        }, {
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.MATNO;
                a += "<br/>";
                a += full.MAKTX;
                a += "</div>";
                return a;
            }
        }, {
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.PLANT;
                a += " — ";
                a += full.PLANT_NAME;
                a += "</div>";
                return a;
            }
        },{
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.FULLNAME;
                a += "</div>";
                return a;
            }
        }, {
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.MESSAGE_CONTENT;
                a += "</div>";
                return a;
            }
        },{
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += "<button type='button' data-toggle='modal' data-target='#modalNego' data-plant='"+ full.PLANT +"' data-plantName='"+ full.PLANT_NAME +"' data-matno='"+ full.MATNO +"' data-maktx='"+ full.MAKTX +"' data-userid='"+ full.USER_ID +"' data-username='"+ full.FULLNAME +"' data-negoid='"+ full.ID +"' title='Nego Harga' style='font-size:12px;box-shadow: 1px 1px 1px #ccc'  class='btn btn-primary nego'><i class='glyphicon glyphicon-comment' ></i> Negosiasi</button>";
                a += "</div>";
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

    $('#table_nego_active').find("th").off("click.DT");
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
    });
    $('.ts10').on('dblclick', function () {
        if (t10) {
            mytable.order([10, 'asc']).draw();
            t10 = false;
        } else {
            mytable.order([10, 'desc']).draw();
            t10 = true;
        }
    });
}

function loadTable_Archive() {

    $('#table_nego_archive').DataTable().destroy();
    $('#table_nego_archive tbody').empty();
    mytable = $('#table_nego_archive').DataTable({
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
            "loadingRecords": "<center><b>Please wait - Updating and Loading Data...</b></center>"
        },
        "ajax": $("#base-url").val() + 'EC_Negosiasi_Ecatalog/getArchiveNego',

        /*"columnDefs": [{
            "searchable": false,
            "orderable": true,
            "targets": 0
        }],*/
        // "order": [[ 1, 'asc' ]],
        "fnInitComplete": function () {
            $('#table_nego_archive tbody tr').each(function () {
                $(this).find('td').attr('nowrap', 'nowrap');
                // $(this).find('td').addClass('text-center');
            });
        },
        /*"fnCreatedRow": function (row, data, index) {
            $('td', row).eq(0).html("<div class='col-md-12 text-center'>"+(index + 1)+"</div>");
        },*/
        "drawCallback": function (settings) {
            $('#table_nego_archive tbody tr').each(function () {
                $(this).find('td').attr('nowrap', 'nowrap');
            });
        },
        "columns": [{
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.MATNO;
                a += "<br/>";
                a += full.MAKTX;
                a += "</div>";
                return a;
            }
        }, {
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.PLANT;
                a += " — ";
                a += full.PLANT_NAME;
                a += "</div>";
                return a;
            }
        },{
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.FULLNAME;
                a += "</div>";
                return a;
            }
        }, {
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.MESSAGE_CONTENT;
                a += "</div>";
                return a;
            }
        }, {
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.OPENDATE;
                a += "</div>";
                return a;
            }
        }, {
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.CLOSEDATE;
                a += "</div>";
                return a;
            }
        }, {
            mRender: function (data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += "<button type='button' data-toggle='modal' data-target='#modalNegoArchive' data-plant='"+ full.PLANT +"' data-plantName='"+ full.PLANT_NAME +"' data-matno='"+ full.MATNO +"' data-maktx='"+ full.MAKTX +"' data-userid='"+ full.USER_ID +"' data-username='"+ full.FULLNAME +"' data-negoid='"+ full.ID +"' title='Nego Harga' style='font-size:12px;box-shadow: 1px 1px 1px #ccc'  class='btn btn-primary nego'><i class='glyphicon glyphicon-comment' ></i> Negosiasi</button>";
                a += "</div>";
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

    $('#table_nego_active').find("th").off("click.DT");
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
    });
    $('.ts10').on('dblclick', function () {
        if (t10) {
            mytable.order([10, 'asc']).draw();
            t10 = false;
        } else {
            mytable.order([10, 'desc']).draw();
            t10 = true;
        }
    });
}

function loadChat(negoId) {
    // no = 1;
    $('#table_chat').DataTable().destroy();
    $('#table_chat tbody').empty();
    mytable = $('#table_chat').DataTable({
        "bSort": false,
        "paging": false,
        "info": false,
        "dom": 'rtilp',
        "bAutoWidth": false,
        "deferRender": true,
        "language": {
            "loadingRecords": "<center><b>Please wait - Loading Chat...</b></center>",
            "zeroRecords": "<center><b>There is no current chat</b></center>"
        },
        "ajax": {
            url: $("#base-url").val() + 'EC_Negosiasi_Ecatalog/openChat',
            type: 'POST',
            dataType: 'json',
            data: {
                negoId: negoId
            }
        },
        "columnDefs": [{
            "searchable": false,
            "orderable": true,
            "targets": 0
        }],
        "columns": [{
            mRender: function (data, type, full) {
                divClass = ''
                readObj = ''
                sender = ''
                a = ''
                if (full.SENDER_CODE == 2){
                    divClass = "<div class='text-right'>"
                    sender = 'You'
                } else {
                    divClass = "<div class='text-left'>"
                    sender = 'Buyer'
                }
                if (full.MESSAGE_STATUS == 1){
                    readObj = '(Delivered)';
                } else {
                    readObj = '(Read)'
                }
                a += divClass
                a += "<p style='font: 14px;'><strong>" + full.MESSAGE_CONTENT + "</strong></p>"
                a += "<p style='font-size:12px;'>" + full.SENT_DATE + "</p>"
                if (full.SENDER_CODE == 2){
                    a += "<p style='font-size:12px;font-style: italic;margin:0;'> - " + sender + " " + readObj + "</p>"
                } else {
                    a += "<p style='font-size:12px;font-style: italic;margin:0;'> - " + sender + "</p>"
                }
                a += "</div>";
                return a
            }
        }],
    });

    // mytable.columns().every(function () {
    //     var that = this;
    //     $('.srch', this.header()).on('keyup change', function () {
    //         if (that.search() !== this.value) {
    //             // $('#tableMT tbody tr').each(function() {
    //             // $(this).find('td').attr('nowrap', 'nowrap');
    //             // });
    //             that.search(this.value).draw();
    //         }
    //     });
    // });

}

function loadChatArchive(negoId) {
    // no = 1;
    $('#table_chat_archive').DataTable().destroy();
    $('#table_chat_archive tbody').empty();
    mytable = $('#table_chat_archive').DataTable({
        "bSort": false,
        "paging": false,
        "info": false,
        "dom": 'rtilp',
        "bAutoWidth": false,
        "deferRender": true,
        "language": {
            "loadingRecords": "<center><b>Please wait - Loading Chat...</b></center>",
            "zeroRecords": "<center><b>There is no current chat</b></center>"
        },
        "ajax": {
            url: $("#base-url").val() + 'EC_Negosiasi_Ecatalog/openChat',
            type: 'POST',
            dataType: 'json',
            data: {
                negoId: negoId
            }
        },
        "columnDefs": [{
            "searchable": false,
            "orderable": true,
            "targets": 0
        }],
        "columns": [{
            mRender: function (data, type, full) {
                divClass = ''
                readClass = ''
                sender = ''
                a = ''
                if (full.SENDER_CODE == 2){
                    divClass = "<div class='text-right'>"
                    sender = 'You'
                } else {
                    divClass = "<div class='text-left'>"
                    sender = 'Buyer'
                }
                a += divClass
                a += "<p style='font: 14px;'><strong>" + full.MESSAGE_CONTENT + "</strong></p>"
                a += "<p style='font-size:12px;font-style: italic;margin:0;'> - " + sender + "</p>"
                a += "<p style='font-size:12px;'>" + full.SENT_DATE + "</p>"
                a += "</div>";
                return a
            }
        }],
    });

    // mytable.columns().every(function () {
    //     var that = this;
    //     $('.srch', this.header()).on('keyup change', function () {
    //         if (that.search() !== this.value) {
    //             // $('#tableMT tbody tr').each(function() {
    //             // $(this).find('td').attr('nowrap', 'nowrap');
    //             // });
    //             that.search(this.value).draw();
    //         }
    //     });
    // });

}