$(function(){

})
function openFormProses(elm){
  var _tr = $(elm).closest('tr');
  var _url = _tr.data('url');
  var _documentid = _tr.data('documentid');
  /* pastikan baris sebelumnya data-status = 1*/
  var _tr_sebelumnya = _tr.prev();
  var _lanjut = 0;
  if(_tr_sebelumnya.length){
    if(_tr_sebelumnya.attr('data-status')){
      _lanjut = 1;
    }
  }else{
    _lanjut = 1;
  }
  if(_lanjut){
    $.post(_url,{docid : _documentid},function(data){
      if(data.status){
        bootbox.dialog({
          title : data.title,
          message : data.content,
        /*  className : 'largeWidth' */
        }).on('shown.bs.modal',function(){
          $(this).find('.tgl').datepicker({
              format: "dd/mm/yyyy",
              autoclose: true,
              todayHighlight: true
          });
          $(this).find('form').submit(function(){
            var _urlAction = $(this).attr('action');
            var _data = $(this).serializeArray();
            $.post(_urlAction,_data,function(data){
              if(data.status){
                bootbox.alert(data.message,function(){
                  bootbox.hideAll();
                  /*
                  if(data.nextpage !== undefined){
                    window.location.href = data.nextpage;
                  }*/
                });
                _tr.find('td:last').html('<span class="label label-success">Done</span>');
                _tr.attr('data-status',1);
              }else{
                bootbox.alert(data.message.join('<br >'));
              }
            },'json');
            return false;
          })
        });
      }
    },'json');
  }else{
    bootbox.alert('Proses harus urut');
  }

}

function prosesReviseInvoice(elm){
  var _table = $(elm).closest('table');
  var _tbody = _table.find('tbody');
  var _listTask = _tbody.find('tr[data-status=0]');

  if(_listTask.length){
    _listTask.eq(0).each(function(){
      var _barisIni = $(this);
      var _url = $(this).data('url');
      var _documentid = $(this).data('documentid');
      $.post(_url,{docid : _documentid},function(data){
        if(data.status){
          _barisIni.attr('data-status',1);
          _barisIni.find('td:last').html('<span class="label label-success">Done</span>');
          prosesReviseInvoice(elm);
        }else{

        }
      },'json');
    });
  }else{
    alert('sudah semua');
  }

}
