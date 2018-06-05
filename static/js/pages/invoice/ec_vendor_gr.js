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
    "ajax" : $("#base-url").val() + 'EC_Vendor/Gr/data/',

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
        a += full.NO_RR;
        a += "</div>";
        return a;
      }
    },{
      mRender : function(data, type, full) {
        a = "<div class='col-md-12 text-center'>";
        a += full.DOC_DATE.substring(6) + '/' + full.DOC_DATE.substring(4, 6) + '/' + full.DOC_DATE.substring(0, 4);
        a += "</div>";
        return a;
      }
    },{
      mRender : function(data, type, full) {
        a = "<div class='col-md-12 text-center'>";
        a += full.TXZ01;
        a += "</div>";
        return a;
      }
    },{
      mRender : function(data, type, full) {
        a = "<div class='col-md-12 text-center'>";
        a += full.NAME1;
        a += "</div>";
        return a;
      }
    },{
      mRender : function(data, type, full) {
        
                return '<button class="btn btn-sm btn-success btn-rowedit" data-jenispo='+full.JENISPO+' data-item='+full.DATA_ITEM+'>\
                                  <i class="fa fa-edit"></i> View\
                              </button> <input type="checkbox" onclick="checkPilihan(this)" data-po_no="'+full.PO_NO+'" data-rr_no ="'+full.NO_RR+'" data-gr_year ="'+full.GR_YEAR+'" data-jenis_po ="'+full.JENISPO+'">';
            
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

function loadTable_loted() {

  $('#data_loted').DataTable().destroy();
  $('#data_loted tbody').empty();
  mytable_loted = $('#data_loted').DataTable({
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
    "ajax" : $("#base-url").val() + 'EC_Vendor/Gr/data_loted',

    "columnDefs" : [{
      "searchable" : false,
      "orderable" : true,
      "targets" : 0
    }],
    // "order": [[ 1, 'asc' ]],
    "fnInitComplete" : function() {
      $('#data_loted tbody tr').each(function() {
        $(this).find('td').attr('nowrap', 'nowrap');
      });
    },
        "fnCreatedRow": function (row, data, index) {
                    $('td', row).eq(0).html(index + 1);
                },
    "drawCallback" : function(settings) {
      $('#data_loted tbody tr').each(function() {
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
        a += full.LOT_NUMBER;
        a += "</div>";
        return a;
      }
    },{
      mRender : function(data, type, full) {
        a = "<div class='col-md-12 text-center'>";
        a += full.PO_NO;
        a += "</div>";
        return a;
      }
    },{
      mRender : function(data, type, full) {
        a = "<div class='col-md-12 text-center'>";
        a += full.CREATED_BY;
        a += "</div>";
        return a;
      }
    },{
      mRender : function(data, type, full) {
        a = "<div class='col-md-12 text-center'>";
        a += full.CREATE_DATE;
        a += "</div>";
        return a;
      }
    },{
      mRender : function(data, type, full) {
        a = "<div class='col-md-12 text-center'>";
        a += full.GR_YEAR;
        a += "</div>";
        return a;
      }
    },{
      mRender : function(data, type, full) {
        a = "<div class='col-md-12 text-center'>";
        a += full.VENDOR;
        a += "</div>";
        return a;
      }
    },{
      mRender : function(data, type, full) {
        
        return '<button class="btn btn-sm btn-success btn-rowedit" data-jenispo='+full.JENISPO+' data-print_type = '+full.PRINT_TYPE+' data-lot_number='+full.LOT_NUMBER+'>\
                                  <i class="fa fa-edit"></i> View';
            
      }
    }],

  });

  mytable_loted.columns().every(function() {
    var that = this;
    $('.srch', this.header()).on('keyup change', function() {
      if (that.search() !== this.value) {
        that.search(this.value).draw();
      }
    });
  });

  var clicks = 0;
  mytable_loted.on("click",'thead>tr>th.ts' ,function(e) {
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

  $('#data_loted').find("th").off("click.DT");
  mytable_loted.on('dblclick','thead>tr>th.ts' ,function() {
    var _index = $(this).index();
    var _sort = $(this).data('sorting') || 'asc';
    var _nextSort = _sort == 'asc' ? 'desc' : 'asc';
    $(this).data('sorting',_nextSort);
    mytable_loted.order([_index, _sort]).draw();
  });
}

$(document).ready(function() {
    
    $(".sear").hide();
    loadTable();
    loadTable_loted()


    /*Set DateRange Picker*/
    var cur_year = new Date().getFullYear();
    $(".dr").daterangepicker({
      autoUpdateInput: false,
      startDate: "01/01/"+cur_year,
      locale: {
          cancelLabel: 'Clear',
          format : 'DD-MM-YYYY'
      }
    });

    $('.dr').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
    });

    $('.dr').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
    });

    $.fn.dataTable.ext.search.push(
        function (settings, data, dataIndex) {
            var min = $('.dr').data('daterangepicker').startDate._d;
            var max = $('.dr').data('daterangepicker').endDate._d;
            var temp = data[4].split('/');

            var startDate = new Date(temp[2], temp[1] - 1, temp[0]);

            if (min == null && max == null) { return true; }
            if (min == null && startDate <= max) { return true;}
            if(max == null && startDate >= min) {return true;}
            if (startDate <= max && startDate >= min) { return true; }
            return false;
        }
    );

    $('.dr').on('apply.daterangepicker', function(ev, picker) {
        mytable.draw();
    });

    $('.dr').on('cancel.daterangepicker', function(ev, picker) {
        mytable.draw();
    });

    /* View Detail GR
        mytable.on('click', '.btn-rowedit', function (e) {
          e.preventDefault();
          var _tr = $(this).closest('tr');
          var _tds = _tr.find('td');
          var _po_no = _tds.eq(1).text();
          var _rr = _tds.eq(3).text();
          var _year = _tds.eq(4).text().substring(6,10);
          var _desc = _tds.eq(5).text();
          var _vendor = _tds.eq(6).text();
          var _item = $(this).data('item');
          var _jenispo = $(this).data('jenispo');
          var _data = {
            po_no : _po_no,
            rr : _rr,
            year : _year,
            desc : _desc,
            vendor : _vendor,
            item : _item,
            jenispo : _jenispo,
            detail_type : 'rr'
          };
          $.redirect($('#base-url').val()+'EC_Vendor/Gr/detail',_data,'POST','_blank');
        });*/

    /* View Detail LOT*/
        mytable_loted.on('click', '.btn-rowedit', function (e) {
          e.preventDefault();
          var _tr = $(this).closest('tr');
          var _tds = _tr.find('td');
          var _po_no = _tds.eq(2).text();
          var _year = _tds.eq(5).text();
          var _vendor = _tds.eq(6).text();
          var _lot = $(this).data('lot_number');
          var _jenispo = $(this).data('jenispo');
          var _print = $(this).data('print_type');
          var _data = {
            po_no : _po_no,
            year : _year,
            vendor : _vendor,
            lot_number : _lot,
            jenispo : _jenispo,
            print_type : _print,
            detail_type : 'lot'
          };
          $.redirect($('#base-url').val()+'EC_Vendor/Gr/detail',_data,'POST');
        });
});


function checkPilihan(elm){
  /* pastikan nomer PO dan item_cat sama */
  var ini = $(elm);
  var table = ini.closest('table');
  //var _ck = table.find('input:checked').not(ini);
  var _ck = mytable.rows().nodes().to$().find(':checkbox:checked').not(ini);
  var _op, _ic;

  if (ini.is(':checked')) {
      if (_ck.length) {
          _op = _ck.eq(0).data('po_no');
          _cy = _ck.eq(0).data('gr_year');
          var _valid = 1,
              _pesan = [];

          if (ini.data('po_no') != _op) {
              _valid = 0;
              _pesan.push('Nomer PO tidak sama');
          }

          if (ini.data('gr_year') != _cy) {
              _valid = 0;
              _pesan.push('Tahun tidak sama');
          }

          if (!_valid) {
              ini.prop('checked', 0);
              bootbox.alert({
                  title: 'Warning ....',
                  message: _pesan.join('</br>'),
                  callback: function() {}
              })
          }
      }
  }
}

function createLot() {
    var data_gr = get_data_GR();
    if (data_gr.length) {
        var url = $("#base-url").val() + 'EC_Approval/Gr/listGR';
      $.post(url, {data : data_gr}, function(html) {
          bootbox.dialog({
          title: 'Daftar GR',
          message: html,
          className: 'bb-alternate-modal',
          size:'large',
        callback: function() {

        }
      }).on('shown.bs.modal', function(e) {
        $(this).find('tr[class^=dokumen]').hide();
      });
      }, 'html');
    } else {
        bootbox.alert('Tidak ada GR yang dipilih');
    }

}

function get_data_GR() {
    var invTerpilih = mytable.rows().nodes().to$().find(':checkbox:checked');
    //$('#table_inv').find(':checked');
    var data_gr = [];

    var index = 0;

    if (invTerpilih.length) {
        invTerpilih.each(function() {

            var no_po = invTerpilih.eq(index).data('po_no');
            var no_gr = invTerpilih.eq(index).data('rr_no');
            var gr_year = invTerpilih.eq(index).data('gr_year');
            var jenis_po = invTerpilih.eq(index).data('jenis_po');
            data_gr[index] = no_po+';'+no_gr+';'+gr_year+';'+jenis_po;
            index +=1;
      });
    }
    return data_gr;
}

function SubmitLot(elm){
  var data_gr = $(elm).data('gr');
  var _print = $('input[name=PRINT_TYPE]').val();
   _print = _print == undefined ? $('select[name=PRINT_TYPE]').val():_print;

  bootbox.confirm('Apakah Anda Yakin?',function(e){
    if(e){
      $url = $('#base-url').val()+'EC_Approval/Gr/createLot';
      var _data = {data : data_gr,print_type : _print};
      $.redirect($url,_data,'POST');
    }
  }); 
}
