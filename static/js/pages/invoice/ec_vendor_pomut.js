
function loadTable() {

  $('#datatable_ajax').DataTable().destroy();
  $('#datatable_ajax tbody').empty();
  mytable = $('#datatable_ajax').DataTable({
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
    "ajax" : $("#base-url").val() + 'EC_Vendor/Pomut/data',

    "columnDefs" : [{
      "searchable" : false,
      "orderable" : true,
      "targets" : 0
    }],
    // "order": [[ 1, 'asc' ]],
    "fnInitComplete" : function() {
      $('#datatable_ajax tbody tr').each(function() {
        $(this).find('td').attr('nowrap', 'nowrap');
      });
    },
        "fnCreatedRow": function (row, data, index) {
                    $('td', row).eq(0).html(index + 1);
                },
    "drawCallback" : function(settings) {
      $('#datatable_ajax tbody tr').each(function() {
        $(this).find('td').attr('nowrap', 'nowrap');
      });
    },
    "columns" : [
                 {
      mRender : function(data, type, full) {
        a = "<div class='col-md-12 text-center'>";
        a += full.NO;
        a += "</div>";
        return a;
      }
    }, {
      mRender : function(data, type, full) {
        a = "<div class='col-md-12 text-center'>";
        a += full.PO_NO;
        a += "</div>";
        return a;
      }
    }, {
      mRender : function(data, type, full) {
        a = "<div class='col-md-12 text-center'>";
        a += full.PO_ITEM_NO;
        a += "</div>";
        return a;
      }
    },{
      mRender : function(data, type, full) {
        a = "<div class='col-md-12 text-center'>";
        a += full.NO_BA;
        a += "</div>";
        return a;
      }
    },{
      mRender : function(data, type, full) {
        a = "<div class='col-md-12 text-center'>";
        a += full.PERIODE;
        a += "</div>";
        return a;
      }
    },{
      mRender : function(data, type, full) {
        a = "<div class='col-md-12 text-center'>";
        a += full.TAHAP;
        a += "</div>";
        return a;
      }
    },{
      mRender : function(data, type, full) {
        a = "<div class='col-md-12 text-center'>";
        a += full.MATERIAL;
        a += "</div>";
        return a;
      }
    },{
      mRender : function(data, type, full) {
        return '<button class="btn btn-sm btn-success btn-rowedit" data-jenispo="a" data-item="A">\
                                  <i class="fa fa-edit"></i> View';
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

  var clicks = 0;
  mytable.on("click",'thead>tr>th.ts' ,function(e) {
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

  $('#datatable_ajax').find("th").off("click.DT");
  mytable.on('dblclick','thead>tr>th.ts' ,function() {
    var _index = $(this).index();
    var _sort = $(this).data('sorting') || 'asc';
    var _nextSort = _sort == 'asc' ? 'desc' : 'asc';
    $(this).data('sorting',_nextSort);
    mytable.order([_index, _sort]).draw();
  });
}  


function loadTable_approved() {

  $('#datatable_approved').DataTable().destroy();
  $('#datatable_approved tbody').empty();
  mytable_approved = $('#datatable_approved').DataTable({
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
    "ajax" : $("#base-url").val() + 'EC_Vendor/Pomut/data/3',

    "columnDefs" : [{
      "searchable" : false,
      "orderable" : true,
      "targets" : 0
    }],
    // "order": [[ 1, 'asc' ]],
    "fnInitComplete" : function() {
      $('#datatable_approved tbody tr').each(function() {
        $(this).find('td').attr('nowrap', 'nowrap');
      });
    },
        "fnCreatedRow": function (row, data, index) {
                    $('td', row).eq(0).html(index + 1);
                },
    "drawCallback" : function(settings) {
      $('#datatable_approved tbody tr').each(function() {
        $(this).find('td').attr('nowrap', 'nowrap');
      });
    },
    "columns" : [
                 {
      mRender : function(data, type, full) {
        a = "<div class='col-md-12 text-center'>";
        a += full.NO;
        a += "</div>";
        return a;
      }
    }, {
      mRender : function(data, type, full) {
        a = "<div class='col-md-12 text-center'>";
        a += full.PO_NO;
        a += "</div>";
        return a;
      }
    }, {
      mRender : function(data, type, full) {
        a = "<div class='col-md-12 text-center'>";
        a += full.PO_ITEM_NO;
        a += "</div>";
        return a;
      }
    },{
      mRender : function(data, type, full) {
        a = "<div class='col-md-12 text-center'>";
        a += full.NO_BA;
        a += "</div>";
        return a;
      }
    },{
      mRender : function(data, type, full) {
        a = "<div class='col-md-12 text-center'>";
        a += full.PERIODE;
        a += "</div>";
        return a;
      }
    },{
      mRender : function(data, type, full) {
        a = "<div class='col-md-12 text-center'>";
        a += full.TAHAP;
        a += "</div>";
        return a;
      }
    },{
      mRender : function(data, type, full) {
        a = "<div class='col-md-12 text-center'>";
        a += full.MATERIAL;
        a += "</div>";
        return a;
      }
    },{
      mRender : function(data, type, full) {
        return '<button class="btn btn-sm btn-success btn-rowedit" data-jenispo="a" data-item="A">\
                                  <i class="fa fa-edit"></i> View';
      }
    }],

  });

  mytable_approved.columns().every(function() {
    var that = this;
    $('.srcha', this.header()).on('keyup change', function() {
      if (that.search() !== this.value) {
        that.search(this.value).draw();
      }
    });
  });

  var clicks = 0;
  mytable_approved.on("click",'thead>tr>th.tsa' ,function(e) {
    clicks++;
    if (clicks === 1) {
      timer = setTimeout(function() {
        $(".seara").toggle();
        clicks = 0;
      }, 300);
    } else {
      clearTimeout(timer);
      $(".seara").hide();
      clicks = 0;
    }
  }).on("dblclick", function(e) {
    e.preventDefault();
  });

  $('#datatable_approved').find("th").off("click.DT");
  mytable_approved.on('dblclick','thead>tr>th.tsa' ,function() {
    var _index = $(this).index();
    var _sort = $(this).data('sorting') || 'asc';
    var _nextSort = _sort == 'asc' ? 'desc' : 'asc';
    $(this).data('sorting',_nextSort);
    mytable_approved.order([_index, _sort]).draw();
  });
}

$(document).ready(function() {
    loadTable();
    $(".sear").hide();
    loadTable_approved();
    $(".seara").hide();
   
    /* View Detail GR*/
        mytable_approved.on('click', '.btn-rowedit', function (e) {
          e.preventDefault();
          var _tr = $(this).closest('tr');
          var _tds = _tr.find('td');
          var _po_no = _tds.eq(1).text();
          var _ba_no = _tds.eq(3).text();
          var _material = _tds.eq(6).text();
          var _data = {
            po_no : _po_no,
            ba_no : _ba_no,
            material : _material
          };
          $.redirect($('#base-url').val()+'EC_Vendor/Pomut/detail',_data,'POST');//
        });

        mytable.on('click', '.btn-rowedit', function (e) {
          e.preventDefault();
          var _tr = $(this).closest('tr');
          var _tds = _tr.find('td');
          var _po_no = _tds.eq(1).text();
          var _ba_no = _tds.eq(3).text();
          var _material = _tds.eq(6).text();
          var _data = {
            po_no : _po_no,
            ba_no : _ba_no,
            material : _material
          };
          $.redirect($('#base-url').val()+'EC_Vendor/Pomut/detail',_data,'POST');//
        });

});