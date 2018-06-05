var base_url = $("#base-url").val();

function loadTable() {

    $('#table_invoice').DataTable().destroy();
    $('#table_invoice tbody').empty();
    mytable = $('#table_invoice').DataTable({
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
        "ajax" : $("#base-url").val() + 'EC_Approval/Invoice/getDataInvoice',

        "columnDefs" : [{
            "searchable" : false,
            "orderable" : true,
            "targets" : 0
        }],
        // "order": [[ 1, 'asc' ]],
        "fnInitComplete" : function() {
            $('#table_invoice tbody tr').each(function() {
                $(this).find('td').attr('nowrap', 'nowrap');
            });
        },
        "fnCreatedRow": function (row, data, index) {
                    $('td', row).eq(0).html(index + 1);
                },
        "drawCallback" : function(settings) {
            $('#table_invoice tbody tr').each(function() {
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
                a += '<a target="_blank" href="'+base_url+'upload/EC_invoice/'+full.INVOICE_PIC+'">'+full.NO_INVOICE+'</a>';
                a += "</div>";
                return a;
            }
        },{
            mRender : function(data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.INVOICE_DATE;
                a += "</div>";
                return a;
            }
        }, {
            mRender : function(data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += '<a target="_blank" href="'+base_url+'upload/EC_invoice/'+full.FAKPJK_PIC+'">'+ full.FAKTUR_PJK+'</a>';
                a += "</div>";
                return a;
            }
        }, {
            mRender : function(data, type, full) {
                a = "<div class='col-md-12 text-center'>";
                a += full.TOTAL_PAYMENT;
                a += "</div>";
                return a;
            }
        }, {
            mRender : function(data, type, full) {
                
                a = "<div class='col-md-12 text-center'>";
                a += full.VENDOR_NO+' - '+full.VENDOR_NAME;
                a += "</div>";
                return a;
            }
        },{
            mRender : function(data, type, full) {
                //var url =base_url.''
                a = "<div class='col-md-12'>";
                a += "<a href='javascript:void(0)' title='Approval Invoice' onclick='approvalInvoice(this)' data-t_payment='"+full.PAYMENT+"' data-id_invoice='"+full.ID_INVOICE+"' data-status='"+full.STATUS+"' data-id><span class='glyphicon glyphicon-share-alt' aria-hidden='true'></span></a>";
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

    $('#table_invoice').find("th").off("click.DT");
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

});

function approvalInvoice(elm){
    var _id = $(elm).data('id_invoice');
    var _status = $(elm).data('status');
    var _tp = $(elm).data('t_payment');
    
    var _url = $('#base-url').val()+'EC_Invoice_Report/detail/'+_id;
    
    $.redirect(_url,{status_approval:_status,total_payment:_tp},'POST');
}