
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
    "ajax" : $("#base-url").val() + 'EC_Vendor/Faktur/data',

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
        a += full.TGL_EKSPEDISI;
        a += "</div>";
        return a;
      }
    }, {
      mRender : function(data, type, full) {
        a = "<div class='col-md-12 text-center'>";
        a += full.NO_EKSPEDISI;
        a += "</div>";
        return a;
      }
    },{
      mRender : function(data, type, full) {
        if(full.COMPANY=='2000'){
            company='PT. Semen Indonesia (Persero) Tbk. - Gresik';  
        } else if(full.COMPANY=='7000'){
            company='PT. Semen Indonesia (Persero) Tbk. - Tuban';  
        } else if(full.COMPANY=='5000'){
            company='PT. Semen Gresik';
        }
        a = "<div class='col-md-12 text-center'>";
        a += company;
        a += "</div>";
        return a;
      }
    },{
      mRender : function(data, type, full) {
        return '<a href="#" data-ekspedisi="'+full.NO_EKSPEDISI+'" data-company="'+full.COMPANY+'" onclick="cetakDocument(this)" class="btn btn-success">Cetak</a>';          
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

$(document).ready(function() {
    loadTable();
    $(".sear").hide();        

        mytable.on('click', '.btn-rowedit', function (e) {
          e.preventDefault();
//          var _tr = $(this).closest('tr');
//          var _tds = _tr.find('td');
//          var _po_no = _tds.eq(1).text();
//          var _ba_no = _tds.eq(3).text();
//          var _material = _tds.eq(6).text();
//          var _data = {
//            po_no : _po_no,
//            ba_no : _ba_no,
//            material : _material
//          };
////          $.redirect($('#base-url').val()+'EC_Vendor/Pomut/detail',_data,'POST');//
        });

});
$('.startDate').datepicker({
    format: "yyyymmdd",
    autoclose: true,
    todayHighlight: true,
});

$('.endDate').datepicker({
    format: "yyyymmdd",
    autoclose: true,
    todayHighlight: true,
});

function addFaktur(elm,tabel) {
    var _form_group = $(elm).closest('.form-group');
    var _tbody = $(tabel);
    var _noFaktur = $('#no_faktur').val();    
    var _tglFaktur = $('#tgl_faktur').val();
    var _tglBAST = $('#tgl_faktur').val();
    var _dasarPajak = $('#dasar_pajak').val();
    var _nama = $('#nama').val();
    var _email = $('#email').val();
    var _po = $('#po').val();    
    var _urut;
    var _jmlTr = _tbody.find('tr').length + 1;
    var _numberPattern = /\d+/g;
    var _fileDocAkhir = _tbody.find('input[name^=fileLampiranBast]:last');    
    if (_noFaktur == '' || _tglFaktur =='' || _tglBAST =='' || _dasarPajak =='' || _po =='' || _nama =='' || _email =='') {
        bootbox.alert('Form wajib diisi semua');
    } else {
        teks = '<tr>';
        teks += '<td>'+_jmlTr+'</td>';
        teks += '<td class="text-center"><input type="text" readonly name="no_faktur['+_jmlTr+']" value="'+_noFaktur+'"> </td>';
        teks += '<td class="text-center"><input type="text" readonly name="tgl_faktur['+_jmlTr+']" value="'+_tglFaktur+'"> </td>';
        teks += '<td class="text-center"><input type="text" readonly name="tgl_bast['+_jmlTr+']" value="'+_tglBAST+'"> </td>';        
        teks += '<td class="text-center"><input type="text" readonly name="dasar_pajak['+_jmlTr+']" value="'+_dasarPajak+'"> </td>';        
        teks += '<td class="text-center"><input type="text" readonly name="po['+_jmlTr+']" value="'+_po+'"> </td>';        
        teks += '<td class="text-center"><input type="text" readonly name="nama['+_jmlTr+']" value="'+_nama+'"> </td>';        
        teks += '<td class="text-center"><input type="text" readonly name="email['+_jmlTr+']" value="'+_email+'"> </td>';        
        teks += '<td class="text-center"><span  onclick="removeRow(this)" class="link glyphicon glyphicon-trash" aria-hidden="true"></span></td>';
        teks += '</tr>';

        $(teks).appendTo(_tbody);
    }
}

function removeRow(elm){
  var _tr = $(elm).closest('tr');
  var _tbody = _tr.closest('tbody');
  _tr.remove();
  setNomerUrut(_tbody);
}

function setNomerUrut(_tbody){
  var i = 1;
  _tbody.find('tr').each(function(){
    $(this).find('td:first').text(i++);
  });
}

function cetakDocument(elm){
    var ekspedisi = $(elm).data('ekspedisi');    
    var company = $(elm).data('company');  

    var _data = {
        id : ekspedisi,
        company : company
    };

    $.redirect($('#base-url').val()+'EC_Vendor/Faktur/cetakDocument',_data,'POST','_blank');
}