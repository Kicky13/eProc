function modalSearchPO(elm){
  var url = $(elm).data('url');
  var _body = [
    '<div class="divSearchPO" data-url="'+url+'">',
      '<div class="listPO"></div>',
    '</div>'
  ];
  bootbox.dialog({
    title : 'Pencarian PO',
    message : _body.join(''),
    className : 'largeWidth'
  }).on('shown.bs.modal',function(){
      var _elm = $(this).find('.divSearchPO');
      searchOpenPO(_elm);
  });
}

function modalSearchPegawai(elm){
  var url = $(elm).data('url');
  var _body = [
    '<div class="divSearchPegawai" data-url="'+url+'">',
      '<form class="form form-inline" action="'+url+'">',
      '<div class="form-group">',
        '<label for="no_po">Pegawai:</label>',
        '<input type="text" class="form-control" placeholder="" >',
      '</div>',
      '&nbsp;<button type="submit" class="btn btn-default">Cari</button>',
      '</form>',
      '<br>',
      '<div class="listPegawai"></div>',
    '</div>'
  ];
  bootbox.dialog({
    title : 'Pencarian Pegawai',
    message : _body.join(''),
    className : 'largeWidth'
  }).on('shown.bs.modal',function(){
      var _bt = $(this);
      $(this).find('form').submit(function(e){
        var _url = $(this).attr('action');
        var _s = $.trim($(this).find('input').val());
        e.preventDefault();
        if(_s.length >= 3){
          $.get(_url,{search : _s},function(data){
            _bt.find('.listPegawai').html(data).find('table').DataTable({
              "pagingType": "simple"
            });
          });
        }else{
          bootbox.alert('Masukkan minimal 3 karakter');
        }

      })
  });
}
function searchOpenPO(elm) {
      var _divListPO = elm.find('.listPO');
      var url = $(elm).data('url');
    	$.post(url, {}, function(data){
          _divListPO.html(data);
      }).done(function(){
        _divListPO.find('table').DataTable();
      });
      return false;
}

function setPOTerpilih(elm){
  var _po = $(elm).find('td.po_number').text();
  var _text_po = $(elm).find('td.short_text').text();
  var _po_item = $(elm).find('td.po_item').text();
  var _qty = $(elm).find('td.qty').text();
  var _company = $(elm).data('plant').toString().substr(0,1) + '000';

  $('input[name=NO_PO]').val(_po);
  $('input[name=COMPANY]').val(_company);
  $('input[name=PO_ITEM]').val(_po_item);
  $('textarea[name=SHORT_TEXT]').val(_text_po);

  bootbox.hideAll();
}

function setPegawaiTerpilih(elm){
  var _pengawas = $(elm).find('td.fullname').text();
  var _jabatan = $(elm).find('td.mjab_nama').text();
  var _email = $(elm).find('td.email').text();

  $('input[name=PENGAWAS]').val(_pengawas);
  $('input[name=JABATAN]').val(_jabatan);
  $('input[name=EMAIL]').val(_email);
  bootbox.hideAll();
}

function addDoc(elm,tabel) {
    var _form_group = $(elm).closest('.form-group');
    var _tbody = $(tabel);
    var _noDoc = _form_group.find('input:first').val();
    var teks;
    var _urut;
    var _jmlTr = _tbody.find('tr').length + 1;
    var _numberPattern = /\d+/g;
    var _fileDocAkhir = _tbody.find('input[name^=fileLampiranBast]:last');
    var _urutanTerakhir = 0;
    if (_fileDocAkhir.length > 0) {
        var _namaFileTerakhir = _fileDocAkhir.attr('name');
        var _noUrut = _namaFileTerakhir.match(_numberPattern);
        _urutanTerakhir = _noUrut[0];
    }
    _urut = parseInt(_urutanTerakhir) + 1;
    if ($.trim(_noDoc) == '') {
        bootbox.alert('Nomer dokumen harus diisi');
    } else {
        teks = '<tr>';
        teks += '<td>'+_jmlTr+'</td>';
        teks += '<td class="text-center"><input type="text" readonly name="lampiranBast['+_urut+']" value="'+_noDoc+'"> </td>';
        teks += '<td class="text-center"><input required type="file" name="fileLampiranBast_'+_urut+'"> </td>';
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


$(function(){
  $('select[name=next_action]').change(function(){
     var _form = $(this).closest('form');
     var _div = _form.find('textarea[name=ALASAN_REJECT]').closest('.form-group');
     var _s = $(this).find('option:selected').val();
     if(_s == '1'){
       if(_div.is(':visible')){
           _div.hide();
       }
        _div.find('textarea[name=ALASAN_REJECT]').prop('required',0);
     }else{
        _div.find('textarea[name=ALASAN_REJECT]').prop('required',1);
        _div.show();
     }

  });

  $('select[name=next_action]').trigger('change');

  $('.editor-html').trumbowyg({
    btns: [
        ['viewHTML'],
        ['formatting'],
        ['superscript', 'subscript'],
        ['link'],
        ['strong', 'em', 'underline'],
        'btnGrp-justify',
        'btnGrp-lists',
        ['horizontalRule'],
        ['removeformat'],
        ['fullscreen']
    ],
  });

  $('input[name=QTY],input[name=qty_tmp]').priceFormat({
      prefix: '',
      centsSeparator: ',',
      centsLimit: 2,
      thousandsSeparator: '.',
      clearOnEmpty: true,
  });

  $('form').submit(function(e){
    var currentForm = this;
    var urlkonfirmasi = $(this).data('urlkonfirmasi');
    var _approval = $(this).data('approval');
    e.preventDefault();
    /* pastikan semua yang memiliki attribute required sudah terisi */
    var _error = 0, _message = [];
    $(this).find('[required]').each(function(){
      if(empty($(this).val())){
        _error++;
        _message.push($(this).attr('name') + ' harus diisi ');
      }
    });
    if(_error){
      bootbox.alert(_message.join(' '));
      return false;
    }
    /* pastikan qty yang dientry < qty po - po_item */
    var _data = {
      po_no : $('input[name=NO_PO]').val(),
      po_item : $('input[name=PO_ITEM]').val(),
      id : $(this).data('id')
    }
    if(_approval){
      /* approval pihak SI */
      bootbox.confirm('Apakah anda yakin ?',function(r){
        if(r){
          currentForm.submit();
        }
      })
    }else{
      /* jika vendor yang buat */
    //  $.post(urlcekdata,_data,function(data){
    //    if(data.status){
          $.get(urlkonfirmasi,{},function(data){
            bootbox.confirm({
              message : data,
              title : 'Konfirmasi Create BAST',
              callback : function(r){
                if(r){
                  currentForm.submit();
                }
              }
            });
          });
  /*      }else{
          bootbox.alert(data.message);
        }
      },'json');
      */
    }

  });

  $('.preview-btn').click(function(){
    /* pastikan semua yang memiliki attribute required sudah terisi */
    var _error = 0, _message = [];
    var _form = $(this).closest('form');
    _form.find('[required]').each(function(){
      if(empty($(this).val())){
        _error++;
        _message.push($(this).attr('name') + ' harus diisi ');
      }
    });
    if(_error){
      bootbox.alert(_message.join(' '));
      return false;
    }
    /* kumpulkan semua data */
    var _data = {}, _name;
    _form.find('input,textarea').not('input[name ^= lampiranBast]').each(function(){
        _name = $(this).attr('name');
        if(!empty(_name)){
            _data[_name] = $(this).val();
        }
    });
    var _url = $(this).data('urlpreview');
    $.redirect(_url,{data : _data},'POST','_blank');

  });
  /* supaya dari internal bisa lihat dokumen yang diupload vendor */
  setHrefPublic();
})
