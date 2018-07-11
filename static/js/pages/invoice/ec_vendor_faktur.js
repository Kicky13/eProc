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
    // "ScrollXInner": "200%",
    "lengthMenu" : [5, 10, 15, 25, 50, 75, 100],
    "language" : {
      "loadingRecords" : "<center><b>Please wait - Updating and Loading Data Tax Invoice...</b></center>"
  },
  "ajax" : $("#base-url").val() + 'EC_Vendor/Faktur/data',

  "columnDefs" : [{
      "searchable" : true,
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
   if(full.COMPANYCODE=='2000'){
    COMPANYCODE='PT. Semen Indonesia (Persero) Tbk. - Gresik';  
} else if(full.COMPANYCODE=='7000'){
    COMPANYCODE='PT. Semen Indonesia (Persero) Tbk. - Tuban';  
} else if(full.COMPANYCODE=='5000'){
    COMPANYCODE='PT. Semen Gresik';
}
a = "<div class='col-md-12 text-center'>";
a += COMPANYCODE;
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
},
{
  mRender : function(data, type, full) {
    a = "<div class='col-md-12 text-center'>";
    a += full.NO_EKSPEDISI;
    a += "</div>";
    return a;
}
},{
  mRender : function(data, type, full) {
    a = "<div class='col-md-12 text-center'>";
    a += full.NO_FAKTUR;
    a += "</div>";
    return a;
}
},{
  mRender : function(data, type, full) {
    a = "<div class='col-md-12 text-center'>";
    a += full.DPP;
    a += "</div>";
    return a;
}
},{
  mRender : function(data, type, full) {
    a = "<div class='col-md-12 text-center'>";
    a += full.PPN;
    a += "</div>";
    return a;
}
},{
  mRender : function(data, type, full) {
    a = "<div class='col-md-12 text-center'>";
    a += full.PO;
    a += "</div>";
    return a;
}
},{
  mRender : function(data, type, full) {
    a = "<div class='col-md-12 text-center'>";
    a += full.NAMA;
    a += "</div>";
    return a;
}
},{
  mRender : function(data, type, full) {
    a = "<div class='col-md-12 text-center'>";
    a += full.POSISI;
    a += "</div>";
    return a;
}
},{
  mRender : function(data, type, full) {
    a = "<div class='col-md-12 text-center'>";
    a += full.KET;
    a += "</div>";
    return a;
}
},{
  mRender : function(data, type, full) {
    if (full.KET == 'Belum diterima') {
      TGL_TERIMA ='-';
  } else if (full.KET == 'Diterima') {
      TGL_TERIMA = full.TGL_TERIMA;
  }

  a = "<div class='col-md-12 text-center'>";
  a += TGL_TERIMA;
  a += "</div>";
  return a;
}
},{
  mRender : function(data, type, full) {
      a = '<a href="#" data-ekspedisi="'+full.NO_EKSPEDISI+'" data-company="'+full.COMPANYCODE +'" data-fp="'+full.NO_FAKTUR+'" onclick="cetakDocument(this)" class="btn btn-success">Cetak</a>&nbsp;&nbsp;&nbsp;';
  a += '<a href="#" data-ekspedisi="'+full.NO_EKSPEDISI+'" data-company="'+full.COMPANYCODE +'" data-fp="'+full.NO_FAKTUR+'" data-vn="'+full.NO_VENDOR+'" onclick="batalDocument(this)" class="btn btn-danger">Batal</a>';
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

  $("#dasar_pajak").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110]) !== -1 ||
             // Allow: Ctrl/cmd+A
             (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
             // Allow: Ctrl/cmd+C
             (e.keyCode == 67 && (e.ctrlKey === true || e.metaKey === true)) ||
             // Allow: Ctrl/cmd+X
             (e.keyCode == 88 && (e.ctrlKey === true || e.metaKey === true)) ||
             // Allow: home, end, left, right
             (e.keyCode >= 35 && e.keyCode <= 39)) {
                 // let it happen, don't do anything
             return;
         }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });

  $('#dasar_pajak').keyup(function(event) {
    if(event.which >= 37 && event.which <= 40){
      event.preventDefault();
  }
  $(this).val(function(index, value) {
      value = value.replace(/,/g,'');
      return numberWithCommas(value);
  });
});

  function numberWithCommas(x) {
      var parts = x.toString().split(".");
      parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      return parts.join(".");
  }

  var max_chars = 16;
  $('#no_faktur').keydown( function(e){
    if ($(this).val().length >= max_chars) { 
        $(this).val($(this).val().substr(0, max_chars));
    }
});


  $('#no_faktur').keyup( function(e){
    if ($(this).val().length >= max_chars) { 
        $(this).val($(this).val().substr(0, max_chars));
    }
});

  var max_chars2 = 10;
  $('#po').keydown( function(e){
    if ($(this).val().length >= max_chars2) { 
        $(this).val($(this).val().substr(0, max_chars2));
    }
});

  $('#po').keyup( function(e){
    if ($(this).val().length >= max_chars2) { 
        $(this).val($(this).val().substr(0, max_chars2));
    }
});

  $("#no_faktur").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl/cmd+A
             (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
             // Allow: Ctrl/cmd+C
             (e.keyCode == 67 && (e.ctrlKey === true || e.metaKey === true)) ||
             // Allow: Ctrl/cmd+X
             (e.keyCode == 88 && (e.ctrlKey === true || e.metaKey === true)) ||
             // Allow: home, end, left, right
             (e.keyCode >= 35 && e.keyCode <= 39)) {
                 // let it happen, don't do anything
             return;
         }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
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


  var files;

  $("input[type=file]").change(function(){
      var formData = new FormData( $("#formID")[0] );
      $.ajax({
            url : $("#base-url").val() + 'EC_Vendor/Faktur/doInsertFp',  // Controller URL
            type : 'POST',
            data : formData,
            dataType : 'json',
            async : false,
            cache : false,
            contentType : false,
            processData : false,
            success : function(data) {
                if (data.success===true) {
                    var _tmpMessage = [
                    data.pesan
                    ];
                    $("#GAMBAR").val(data.gambar)
                    // alert(data.pesan);
                } else {
                    var _tmpMessage = [
                    data.pesan
                    ];
                    // alert(data.pesan);
                }
                bootbox.alert(_tmpMessage.join('<br />'));
            }
        });
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
    var _tglBAST = $('#tgl_bast').val();
    var _dasarPajak = $('#dasar_pajak').val();
    var _nama = $('#nama').val();
    var _email = $('#email').val();
    var _po = $('#po').val();    
    var _GAMBAR = $('#GAMBAR').val();    
    var _urut;
    var _jmlTr = _tbody.find('tr').length + 1;
    var _numberPattern = /\d+/g;
    // var _fileDocAkhir = _tbody.find('input[name^=fileLampiranBast]:last');    
    if (_noFaktur == '' || _tglFaktur =='' || _tglBAST =='' || _dasarPajak =='' || _po =='' || _nama =='' || _email =='') {
        bootbox.alert('Form wajib diisi semua');
    } else {
        teks = '<tr>';
        teks += '<td>'+_jmlTr+'</td>';
        teks += '<td class="text-center"><input type="text" readonly name="no_faktur[]" value="'+_noFaktur+'"> </td>';
        teks += '<td class="text-center"><input type="text" readonly name="tgl_faktur[]" value="'+_tglFaktur+'"> </td>';
        teks += '<td class="text-center"><input type="text" readonly name="tgl_bast[]" value="'+_tglBAST+'"> </td>';        
        teks += '<td class="text-center"><input type="text" readonly name="dasar_pajak[]" value="'+_dasarPajak+'"> </td>';        
        teks += '<td class="text-center"><input type="text" readonly name="po[]" value="'+_po+'"> </td>';        
        teks += '<td class="text-center"><input type="text" readonly name="nama[]" value="'+_nama+'"> </td>';        
        teks += '<td class="text-center"><input type="text" readonly name="email[]" value="'+_email+'"> </td>';        
        teks += '<td class="text-center">'+'<input type="hidden" name="file_gambar[]" value="'+_GAMBAR+'"><a href="'+$('#base-url').val()+'upload/fp_ekspedisi/'+_GAMBAR+'" target="_blank">'+_GAMBAR+'</a>'+'</td>';        
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

function batalDocument(elm){
    var ekspedisi = $(elm).data('ekspedisi');    
    var company = $(elm).data('company');
    var fp = $(elm).data('fp');
    var vn = $(elm).data('vn');

    var _data = {
        id : ekspedisi,
        company : company,
        vn : vn,
        fp : fp
    };

    $.ajax({
        url : $("#base-url").val() + 'EC_Vendor/Faktur/batalDocument',  // Controller URL
        type : 'POST',
        data : _data,
        dataType : 'json',
        success : function(data) {
            if (data.success===true) {
                var _tmpMessage = [
                data.pesan
                ];
            } else {
                var _tmpMessage = [
                data.pesan
                ];
            }
            bootbox.alert(_tmpMessage.join('<br />'));
        }
    });

    // $.redirect($('#base-url').val()+'EC_Vendor/Faktur/cetakDocument',_data,'POST','_blank');
}