

$(document).ready(function () {

    console.log('test');
    loadTable();

    $('#modalChat').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget),
            vendorname = (button.data('vendorname')),
            negoid = (button.data('negoid')),
            plant = (button.data('plant')),
            plantname = (button.data('plantname')),
            matno = (button.data('matno')),
            maktx = (button.data('maktx'));
        $('#vendorOnChat').text(vendorname);
        $('#materialOnChat').text(maktx + '(' + matno + ')');
        $('#plantOnChat').text(plant + ' - ' + plantname);
        loadChat(negoid);
    });
});

function loadTable() {

    $('#table_nego').DataTable().destroy();
    $('#table_nego tbody').empty();
    mytable = $('#table_nego').DataTable({
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
        "ajax": $("#base-url").val() + 'EC_Report_Chat/getDataNego',

        /*"columnDefs": [{
            "searchable": false,
            "orderable": true,
            "targets": 0
        }],*/
        // "order": [[ 1, 'asc' ]],
        "fnInitComplete": function () {
            $('#table_nego tbody tr').each(function () {
                $(this).find('td').attr('nowrap', 'nowrap');
                // $(this).find('td').addClass('text-center');
            });
        },
        /*"fnCreatedRow": function (row, data, index) {
            $('td', row).eq(0).html("<div class='col-md-12 text-center'>"+(index + 1)+"</div>");
        },*/
        "drawCallback": function (settings) {
            $('#table_nego tbody tr').each(function () {
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
                a += full.VENDOR_NAME;
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
                a += "<button type='button' data-toggle='modal' data-target='#modalChat' data-plant='"+ full.PLANT +"' data-plantName='"+ full.PLANT_NAME +"' data-matno='"+ full.MATNO +"' data-maktx='"+ full.MAKTX +"' data-vendor='"+ full.VENDORNO +"' data-vendorname='"+ full.VENDOR_NAME +"' data-negoid='"+ full.ID +"' title='Lihat Chat' style='font-size:12px;box-shadow: 1px 1px 1px #ccc'  class='btn btn-primary nego'><i class='glyphicon glyphicon-comment' ></i> Negosiasi</button>";
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

    $('#table_nego').find("th").off("click.DT");
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
            url: $("#base-url").val() + 'EC_Report_Chat/getDataChat',
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
                if (full.SENDER_CODE == 1){
                    divClass = "<div class='text-right'>"
                    sender = 'You'
                } else {
                    divClass = "<div class='text-left'>"
                    sender = 'Vendor'
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