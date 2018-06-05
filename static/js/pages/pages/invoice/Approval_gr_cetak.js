function loadTable() {

    $('#datatable_ajax').DataTable().destroy();
    $('#datatable_ajax tbody').empty();
    mytable = $('#datatable_ajax').DataTable({
        "bSort": true,
        "dom": 'rtpli',
        "deferRender": true,
        "colReorder": true,
        "pageLength": 15,
        // "fixedHeader" : true,
        // "scrollX" : true,
        "lengthMenu": [5, 10, 15, 25, 50, 75, 100],
        "language": {
            "loadingRecords": "<center><b>Please wait - Updating and Loading Data List Contract...</b></center>"
        },
        "ajax": $("#base-url").val() + 'EC_Approval/Gr/data_loted/3',
        "columnDefs": [{
                "searchable": false,
                "orderable": true,
                "targets": 0
            }],
        // "order": [[ 1, 'asc' ]],
        "fnInitComplete": function () {
            $('#datatable_ajax tbody tr').each(function () {
                $(this).find('td').attr('nowrap', 'nowrap');
            });
        },
        "fnCreatedRow": function (row, data, index) {
            $('td', row).eq(0).html(index + 1);
        },
        "drawCallback": function (settings) {
            $('#datatable_ajax tbody tr').each(function () {
                $(this).find('td').attr('nowrap', 'nowrap');
            });
        },
        "columns": [
            {
                mRender: function (data, type, full) {
                    a = "<div class='col-md-12 text-center'>";
                    a += full.NO;
                    a += "</div>";
                    return a;
                }
            }, {
                mRender: function (data, type, full) {
                    a = "<div class='col-md-12 text-center'>";
                    a += full.LOT_NUMBER;
                    a += "</div>";
                    return a;
                }
            }, {
                mRender: function (data, type, full) {
                    a = "<div class='col-md-12 text-center'>";
                    a += full.PO_NO;
                    a += "</div>";
                    return a;
                }
            }, {
                mRender: function (data, type, full) {
                    a = "<div class='col-md-12 text-center'>";
                    a += full.CREATED_BY;
                    a += "</div>";
                    return a;
                }
            }, {
                mRender: function (data, type, full) {
                    a = "<div class='col-md-12 text-center'>";
                    a += full.CREATE_DATE;
                    a += "</div>";
                    return a;
                }
            }, {
                mRender: function (data, type, full) {
                    a = "<div class='col-md-12 text-center'>";
                    a += full.GR_YEAR;
                    a += "</div>";
                    return a;
                }
            }, {
                mRender: function (data, type, full) {
                    a = "<div class='col-md-12 text-center'>";
                    a += full.VENDOR;
                    a += "</div>";
                    return a;
                }
            }, {
                mRender: function (data, type, full) {

                    return '<button class="btn btn-sm btn-success btn-rowedit" data-jenispo=' + full.JENISPO + ' data-print_type=' + full.PRINT_TYPE + ' data-item=' + full.DATA_ITEM + '>\
                                  <i class="fa fa-edit"></i> Cetak </button>';

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

    var clicks = 0;
    mytable.on("click", 'thead>tr>th.ts', function (e) {
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

    $('#datatable_ajax').find("th").off("click.DT");
    mytable.on('dblclick', 'thead>tr>th.ts', function () {
        var _index = $(this).index();
        var _sort = $(this).data('sorting') || 'asc';
        var _nextSort = _sort == 'asc' ? 'desc' : 'asc';
        $(this).data('sorting', _nextSort);
        mytable.order([_index, _sort]).draw();
    });
    $(".klik_sear").click(function(){
        $(".sear").toggle();
    });
}

function loadTable_request() {

    $('#datatable_request').DataTable().destroy();
    $('#datatable_request tbody').empty();
    mytable_request = $('#datatable_request').DataTable({
        "bSort": true,
        "dom": 'rtpli',
        "deferRender": true,
        "colReorder": true,
        "pageLength": 15,
        // "fixedHeader" : true,
        // "scrollX" : true,
        "lengthMenu": [5, 10, 15, 25, 50, 75, 100],
        "language": {
            "loadingRecords": "<center><b>Please wait - Updating and Loading Data List Contract...</b></center>"
        },
        "ajax": $("#base-url").val() + 'EC_Approval/Gr/data_loted/1',
        "columnDefs": [{
                "searchable": false,
                "orderable": true,
                "targets": 0
            }],
        // "order": [[ 1, 'asc' ]],
        "fnInitComplete": function () {
            $('#datatable_request tbody tr').each(function () {
                $(this).find('td').attr('nowrap', 'nowrap');
            });
        },
        "fnCreatedRow": function (row, data, index) {
            $('td', row).eq(0).html(index + 1);
        },
        "drawCallback": function (settings) {
            $('#datatable_request tbody tr').each(function () {
                $(this).find('td').attr('nowrap', 'nowrap');
            });
        },
        "columns": [
            {
                mRender: function (data, type, full) {
                    a = "<div class='col-md-12 text-center'>";
                    a += full.NO;
                    a += "</div>";
                    return a;
                }
            }, {
                mRender: function (data, type, full) {
                    a = "<div class='col-md-12 text-center'>";
                    a += full.LOT_NUMBER;
                    a += "</div>";
                    return a;
                }
            }, {
                mRender: function (data, type, full) {
                    a = "<div class='col-md-12 text-center'>";
                    a += full.PO_NO;
                    a += "</div>";
                    return a;
                }
            }, {
                mRender: function (data, type, full) {
                    a = "<div class='col-md-12 text-center'>";
                    a += full.CREATED_BY;
                    a += "</div>";
                    return a;
                }
            }, {
                mRender: function (data, type, full) {
                    a = "<div class='col-md-12 text-center'>";
                    a += full.CREATE_DATE;
                    a += "</div>";
                    return a;
                }
            }, {
                mRender: function (data, type, full) {
                    a = "<div class='col-md-12 text-center'>";
                    a += full.GR_YEAR;
                    a += "</div>";
                    return a;
                }
            }, {
                mRender: function (data, type, full) {
                    a = "<div class='col-md-12 text-center'>";
                    a += full.VENDOR;
                    a += "</div>";
                    return a;
                }
            }, {
                mRender: function (data, type, full) {
                    var jab = '';
                    if (full.STATUS == 1) {
                        jab = 'KASI'
                    }
                    else if (full.STATUS == 2)
                        (jab = 'KABIRO')

                    a = "<div class='col-md-12 text-center'>";
                    a += 'Request Approval ' + full.STATUS + ' (' + jab + ')';
                    a += "</div>";
                    return a;
                }
            }, {
                mRender: function (data, type, full) {

                    return '<button class="btn btn-sm btn-success btn-rowedit" data-jenispo=' + full.JENISPO + ' data-lot_number=' + full.LOT_NUMBER + '>\
                                  <i class="fa fa-edit"></i> View';

                }
            }],
    });

    mytable_request.columns().every(function () {
        var that = this;
        $('.srchb', this.header()).on('keyup change', function () {
            if (that.search() !== this.value) {
                that.search(this.value).draw();
            }
        });
    });

    var clicks = 0;
    mytable_request.on("click", 'thead>tr>th.tsb', function (e) {
        clicks++;
        if (clicks === 1) {
            timer = setTimeout(function () {
                $(".searb").toggle();
                clicks = 0;
            }, 300);
        } else {
            clearTimeout(timer);
            $(".searb").hide();
            clicks = 0;
        }
    }).on("dblclick", function (e) {
        e.preventDefault();
    });

    $('#datatable_request').find("th").off("click.DT");
    mytable_request.on('dblclick', 'thead>tr>th.tsb', function () {
        var _index = $(this).index();
        var _sort = $(this).data('sorting') || 'asc';
        var _nextSort = _sort == 'asc' ? 'desc' : 'asc';
        $(this).data('sorting', _nextSort);
        mytable_request.order([_index, _sort]).draw();
    });
}


function loadTable_rr() {

    $('#datatable_rr').DataTable().destroy();
    $('#datatable_rr tbody').empty();
    mytable_rr = $('#datatable_rr').DataTable({
        "bSort": true,
        "dom": 'rtpli',
        "deferRender": true,
        "colReorder": true,
        "pageLength": 15,
        // "fixedHeader" : true,
        // "scrollX" : true,
        "lengthMenu": [5, 10, 15, 25, 50, 75, 100],
        "language": {
            "loadingRecords": "<center><b>Please wait - Updating and Loading Data List Contract...</b></center>"
        },
        "ajax": $("#base-url").val() + 'EC_Approval/Gr/data/1',
        "columnDefs": [{
                "searchable": false,
                "orderable": true,
                "targets": 0
            }],
        // "order": [[ 1, 'asc' ]],
        "fnInitComplete": function () {
            $('#datatable_rr tbody tr').each(function () {
                $(this).find('td').attr('nowrap', 'nowrap');
            });
        },
        "fnCreatedRow": function (row, data, index) {
            $('td', row).eq(0).html(index + 1);
        },
        "drawCallback": function (settings) {
            $('#datatable_rr tbody tr').each(function () {
                $(this).find('td').attr('nowrap', 'nowrap');
            });
        },
        "columns": [
            {
                mRender: function (data, type, full) {
                    a = "<div class='col-md-12 text-center'>";
                    a += full.NO;
                    a += "</div>";
                    return a;
                }
            }, {
                mRender: function (data, type, full) {
                    a = "<div class='col-md-12 text-center'>";
                    a += full.PO_NO;
                    a += "</div>";
                    return a;
                }
            }, {
                mRender: function (data, type, full) {
                    a = "<div class='col-md-12 text-center'>";
                    a += full.PO_ITEM_NO;
                    a += "</div>";
                    return a;
                }
            }, {
                mRender: function (data, type, full) {
                    a = "<div class='col-md-12 text-center'>";
                    a += full.NO_RR;
                    a += "</div>";
                    return a;
                }
            }, {
                mRender: function (data, type, full) {
                    a = "<div class='col-md-12 text-center'>";
                    a += full.DOC_DATE.substring(6) + '/' + full.DOC_DATE.substring(4, 6) + '/' + full.DOC_DATE.substring(0, 4);
                    a += "</div>";
                    return a;
                }
            }, {
                mRender: function (data, type, full) {
                    a = "<div class='col-md-12 text-center'>";
                    a += full.NAME1;
                    a += "</div>";
                    return a;
                }
            }, {
                mRender: function (data, type, full) {
                    a = "<div class='col-md-12 text-center'>";
                    a += full.TXZ01;
                    a += "</div>";
                    return a;
                }
            }, {
                mRender: function (data, type, full) {
                    a = "<div class='col-md-12 text-center'>";
                    a += full.LOT_NUMBER;
                    a += "</div>";
                    return a;
                }
            }, {
                mRender: function (data, type, full) {

                    return '<button class="btn btn-sm btn-success btn-rowedit" data-jenispo=' + full.JENISPO + ' data-item=' + full.DATA_ITEM + '>\
                                  <i class="fa fa-edit"></i> View';

                }
            }],
    });

    mytable_rr.columns().every(function () {
        var that = this;
        $('.srchd', this.header()).on('keyup change', function () {
            if (that.search() !== this.value) {
                that.search(this.value).draw();
            }
        });
    });

    var clicks = 0;
    mytable_rr.on("click", 'thead>tr>th.tsd', function (e) {
        clicks++;
        if (clicks === 1) {
            timer = setTimeout(function () {
                $(".seard").toggle();
                clicks = 0;
            }, 300);
        } else {
            clearTimeout(timer);
            $(".seard").hide();
            clicks = 0;
        }
    }).on("dblclick", function (e) {
        e.preventDefault();
    });

    $('#datatable_rr').find("th").off("click.DT");
    mytable_rr.on('dblclick', 'thead>tr>th.tsd', function () {
        var _index = $(this).index();
        var _sort = $(this).data('sorting') || 'asc';
        var _nextSort = _sort == 'asc' ? 'desc' : 'asc';
        $(this).data('sorting', _nextSort);
        mytable_rr.order([_index, _sort]).draw();
    });
}


function loadTable_reject() {

    $('#datatable_reject').DataTable().destroy();
    $('#datatable_reject tbody').empty();
    mytable_reject = $('#datatable_reject').DataTable({
        "bSort": true,
        "dom": 'rtpli',
        "deferRender": true,
        "colReorder": true,
        "pageLength": 15,
        // "fixedHeader" : true,
        // "scrollX" : true,
        "lengthMenu": [5, 10, 15, 25, 50, 75, 100],
        "language": {
            "loadingRecords": "<center><b>Please wait - Updating and Loading Data List Contract...</b></center>"
        },
        "ajax": $("#base-url").val() + 'EC_Approval/Gr/data_loted/4',
        "columnDefs": [{
                "searchable": false,
                "orderable": true,
                "targets": 0
            }],
        // "order": [[ 1, 'asc' ]],
        "fnInitComplete": function () {
            $('#datatable_reject tbody tr').each(function () {
                $(this).find('td').attr('nowrap', 'nowrap');
            });
        },
        "fnCreatedRow": function (row, data, index) {
            $('td', row).eq(0).html(index + 1);
        },
        "drawCallback": function (settings) {
            $('#datatable_reject tbody tr').each(function () {
                $(this).find('td').attr('nowrap', 'nowrap');
            });
        },
        "columns": [
            {
                mRender: function (data, type, full) {
                    a = "<div class='col-md-12 text-center'>";
                    a += full.NO;
                    a += "</div>";
                    return a;
                }
            }, {
                mRender: function (data, type, full) {
                    a = "<div class='col-md-12 text-center'>";
                    a += full.LOT_NUMBER;
                    a += "</div>";
                    return a;
                }
            }, {
                mRender: function (data, type, full) {
                    a = "<div class='col-md-12 text-center'>";
                    a += full.PO_NO;
                    a += "</div>";
                    return a;
                }
            }, {
                mRender: function (data, type, full) {
                    a = "<div class='col-md-12 text-center'>";
                    a += full.CREATED_BY;
                    a += "</div>";
                    return a;
                }
            }, {
                mRender: function (data, type, full) {
                    a = "<div class='col-md-12 text-center'>";
                    a += full.CREATE_DATE;
                    a += "</div>";
                    return a;
                }
            }, {
                mRender: function (data, type, full) {
                    a = "<div class='col-md-12 text-center'>";
                    a += full.GR_YEAR;
                    a += "</div>";
                    return a;
                }
            }, {
                mRender: function (data, type, full) {
                    a = "<div class='col-md-12 text-center'>";
                    a += full.VENDOR;
                    a += "</div>";
                    return a;
                }
            }, {
                mRender: function (data, type, full) {

                    a = "<div class='col-md-12 text-center'>";
                    a += 'Rejected by ' + full.REJECTED_BY;
                    a += "</div>";
                    return a;
                }
            }, {
                mRender: function (data, type, full) {

                    return '<button class="btn btn-sm btn-success btn-rowedit" data-jenispo=' + full.JENISPO + ' data-lot_number=' + full.LOT_NUMBER + '>\
                                  <i class="fa fa-edit"></i> view </button>';

                }
            }],
    });

    mytable_reject.columns().every(function () {
        var that = this;
        $('.srchc', this.header()).on('keyup change', function () {
            if (that.search() !== this.value) {
                that.search(this.value).draw();
            }
        });
    });

    var clicks = 0;
    mytable_reject.on("click", 'thead>tr>th.tsc', function (e) {
        clicks++;
        if (clicks === 1) {
            timer = setTimeout(function () {
                $(".searc").toggle();
                clicks = 0;
            }, 300);
        } else {
            clearTimeout(timer);
            $(".searc").hide();
            clicks = 0;
        }
    }).on("dblclick", function (e) {
        e.preventDefault();
    });

    $('#datatable_reject').find("th").off("click.DT");
    mytable_reject.on('dblclick', 'thead>tr>th.tsc', function () {
        var _index = $(this).index();
        var _sort = $(this).data('sorting') || 'asc';
        var _nextSort = _sort == 'asc' ? 'desc' : 'asc';
        $(this).data('sorting', _nextSort);
        mytable_reject.order([_index, _sort]).draw();
    });
}


$(document).ready(function () {

    $(".sear").hide();
    loadTable();

    $(".searb").hide();
    loadTable_request();

    $(".searc").hide();
    loadTable_reject();

    $(".seard").hide();
    loadTable_rr();

    /* View Detail GR*/
    mytable.on('click', '.btn-rowedit', function (e) {
        e.preventDefault();
        var _tr = $(this).closest('tr');
        var _tds = _tr.find('td');

        var _print = $(this).data('print_type');


        var lot_no = _tds.eq(1).text();
        var _po_no = _tds.eq(2).text();
        var _data = {
            id: lot_no,
            nopo: _po_no,
            print_type: _print,
            tipe: 'RR'
        };

        $.redirect($('#base-url').val() + 'EC_Invoice_Management/showDocument', _data, 'POST', '_blank');
    });

    mytable_request.on('click', '.btn-rowedit', function (e) {
        e.preventDefault();
        var _tr = $(this).closest('tr');
        var _tds = _tr.find('td');
        var _po_no = _tds.eq(2).text();
        var _year = _tds.eq(5).text();
        var _vendor = _tds.eq(6).text();

        var _lot = $(this).data('lot_number');
        var _jenispo = $(this).data('jenispo');

        var _data = {
            po_no: _po_no,
            year: _year,
            vendor: _vendor,
            lot_number: _lot,
            jenispo: _jenispo,
            act: 'view',
            detail_type: 'lot'
        };
        $.redirect($('#base-url').val() + 'EC_Approval/Gr/detail', _data, 'POST');
    });

    mytable_rr.on('click', '.btn-rowedit', function (e) {
        e.preventDefault();
        var _tr = $(this).closest('tr');
        var _tds = _tr.find('td');
        var _po_no = _tds.eq(1).text();
        var _rr = _tds.eq(3).text();
        var _year = _tds.eq(4).text().substring(6, 10);
        var _vendor = _tds.eq(5).text();
        var _desc = _tds.eq(6).text();
        var _jenispo = $(this).data('jenispo');
        var _data = {
            po_no: _po_no,
            rr: _rr,
            year: _year,
            desc: _desc,
            vendor: _vendor,
            jenispo: _jenispo,
            detail_type: 'rr'
        };
        $.redirect($('#base-url').val() + 'EC_Approval/Gr/detail', _data, 'POST', '_blank');
    });

    mytable_reject.on('click', '.btn-rowedit', function (e) {
        e.preventDefault();
        var _tr = $(this).closest('tr');
        var _tds = _tr.find('td');
        var _po_no = _tds.eq(2).text();
        var _year = _tds.eq(5).text();
        var _vendor = _tds.eq(6).text();

        var _lot = $(this).data('lot_number');
        var _jenispo = $(this).data('jenispo');

        var _data = {
            po_no: _po_no,
            year: _year,
            vendor: _vendor,
            lot_number: _lot,
            jenispo: _jenispo,
            act: 'view',
            detail_type: 'lot'
        };
        $.redirect($('#base-url').val() + 'EC_Approval/Gr/detail', _data, 'POST');
    });
});
