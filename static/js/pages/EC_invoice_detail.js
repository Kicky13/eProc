$(document).ready(function() {
    $('input[name^=WTAX_AMOUNT],input[name^=amountSAP],input[name=Nominal],input[name=totalAmount],input[name=nominal_glaccount],input[name=Amount],input.angka').priceFormat({
        prefix: '',
        centsSeparator: ',',
        centsLimit : 0,
        thousandsSeparator: '.',
        clearOnEmpty : false,
    })
    /* batasi inptan user */
    $('input,textarea').not('input[name^=WTAX_AMOUNT],input[name=faktur_no]').alphanum({
      allow : './-,?:='
    });
    $('select[name=next_action]').change(function(){
       var _form = $(this).closest('form');
       var _div = _form.find('textarea[name=alasan_reject]').closest('.form-group');
       var _s = $(this).find('option:selected').val();
       if(_div.is(':visible')){
           _div.hide();
       }else{
           _div.show();
       }
    });

    $('.accordian-panel').click(function(){
       var _panel = $(this).closest('.panel');
       var _body = _panel.find('.panel-body');
       if(_body.is(':hidden')){
           _body.show();
           $(this).find('i').toggleClass('glyphicon-plus glyphicon-minus');
       }else{
           _body.hide();
           $(this).find('i').toggleClass('glyphicon-plus glyphicon-minus');
       }
    });

    $('a:contains("File attachment")').click(function(){
      $(this).css({'color' : 'blue'});
    });

    $('input[name$=date],input[name$=Date]').datepicker({
		format : "dd/mm/yyyy",
		autoclose : true,
		todayHighlight : true
	});

        $('#formDetailInvoice').submit(function(e){
            var currentForm = this;
            e.preventDefault();
            /* jika ada faktur pajak maka pastikan faktur pajak sudah dilakukan proses verifikasi */
            var _no_faktur = $(this).find('input[name=faktur_no]').val();
            var _error = 0;
            var _approve = $(this).find('select[name=next_action]').val();
            _approve = _approve == '0' ? 0 : 1;
            /** kalau ada tombol posting_btn set nilai _approve menjadi 1 */
            var _posting_btn = $(this).find('.posting_btn').length;
            if(_posting_btn){
              _approve = 1;
            }
            /* kalau ada WTAX_TYPE berarti verifikasi 2 */
            var _pesan_konfirmasi = "Apakah anda yakin ?";
            var _akanPosting = Invoice.akanPosting;
            if(_akanPosting){
              _pesan_konfirmasi = "Pastikan simulate di SAP sudah benar ?";
            }
            if(!empty(_no_faktur) && _approve){
              var _urlcheckpajak = $(this).data('urlcheckpajak');
              $.get(_urlcheckpajak,{no_faktur : _no_faktur},function(data){
                if(data.status){
                  bootbox.confirm(_pesan_konfirmasi, function(result) {
                      if (result) {
                          currentForm.submit();
                      }else{
                        Invoice.akanPosting = 0;
                        $('input[name=postingInvoice]').remove();
                      }
                  });
                }else{
                  bootbox.alert(data.message);
                }
              },'json');
            }else{
              bootbox.confirm(_pesan_konfirmasi, function(result) {
                  if (result) {
                      currentForm.submit();
                  }else{
                    Invoice.akanPosting = 0;
                    $('input[name=postingInvoice]').remove();
                  }
              });
            }
        });

    $('select[name=glaccount_option]').select2();

    Invoice.hitungAmount($('select[name=pajak]'));
    Invoice.setTaxBaseAmountDefault();

    var _a = $('select[name=next_action]').find('option:selected').val();
    var _reject_div = $('textarea[name=alasan_reject]').closest('.form-group');

    if(_a == 1){
      if(_reject_div.is(':visible')){
        _reject_div.hide();
      }
    }else{
      if(_reject_div.is(':hidden')){
        _reject_div.show();
      }
    }

    /* preview pdf faktur pajak */
    $('label.scan_faktur a').click(function(e){
      e.preventDefault();
      var _path = $(this).data('filepath');
      var _href = $(this).attr('href');
      var _url = $(this).data('url');
      var _nofaktur = $(this).data('nofaktur');
      var _nofaktur = $(this).closest('.form-group').find('input[name=faktur_no]').val();
      var _url_get_xml_pajak = $(this).data('get_xml_pajak');
      $.get(_url,{path : _path, href : _href, nofaktur : _nofaktur},function(data){
        bootbox.dialog({
          title : 'Scan Faktur Pajak',
          message : data,
          className : 'largeWidth'
        }).on('shown.bs.modal',function(){
          $(this).find('form').submit(function(e){
            var _f = $(this);
            var _furl = _f.attr('action');
            var _fdata = _f.serializeArray();
            var _error = 0;
            /* pastikan yang memiliki required sudah diisi */
            _f.find(['required']).each(function(){
              if(empty($(this).val())){
                _error++;
              }
            });
            if(!_error){
              $.post(_furl,_fdata,function(data){
              bootbox.alert(data.message,function(){
                  if(data.status){
                    bootbox.hideAll();
                  }
                // bootbox.hideAll();
                });
              },'json');
            }
            e.preventDefault();
          });
          $(this).find('input[name=URL_FAKTUR]').focus();
          var _xmlField = $(this).find('input[name=XML_FAKTUR]');
          $(this).find('input[name=URL_FAKTUR]').change(function(){
            var _urlxml = $(this).val();
            $.get(_url_get_xml_pajak,{url : _urlxml},function(data){
              _xmlField.val(data);
            });
          });
        });
      },'html');
    });

    /* set href mengarah ke public vendor */
    setHrefPublic();
});
var Invoice = {
    akanPosting : 0,
    listCostCenter : {},
    listProfitCenter : {2000 : [2100,2200],3000 : [3100],4000 : [4100],6000 : [6100],7000 : [7100,7200]},
    validasiData : function(elm){
        bootbox.confirm('Apakah anda yakin akan menyimpannya ?',function(r){
          //  console.log(r);
            if(r){

            }
        });

    },
    getListCostCenter : function(company){
      if(Invoice.listCostCenter[company] != undefined){
        return Invoice.listCostCenter[company];
      }else{
        var _url = $('#base-url').val()+'EC_Invoice_ver/getCostCenter/'+company;
        var _result = [];
        $.ajax({
          url : _url,
          data : {},
          dataType : 'json',
          async : false,
  				cache : false,
        }).done(function(result){
            if(result.status){
              var _tmp = [];
              for(var i in result.data){
                _tmp.push(result.data[i]);
              }
              Invoice.listCostCenter[company] = _tmp;
              _result = _tmp;
            }
        });
            return _result;
      }
    },

    simpanData : function(elm){
        var _result = false;
        bootbox.confirm('Apakah anda yakin akan menyimpannya ?',function(r){
            if(r){
               $(elm).closest('form').submit();
            }
        });
        return false;
    },
    showPajak : function(elm){
        var _div = $(elm).next('.list_pajak');
        if(_div.is(':hidden')){
            _div.show();
            $(elm).toggleClass('glyphicon-plus glyphicon-minus');
        }else{
            _div.hide();
            $(elm).toggleClass('glyphicon-plus glyphicon-minus');
        }

    },
    dropdownStatic : function(elm){
        var _oldValue = $(elm).data('static');
        $(elm).val(_oldValue);


    },
    setProfitCenter : function(elm){
      /*tampilkan popup untuk mengisi profit_ctr dan costcenter */
      var _gl = $(elm).data('glaccount');
      var _baris = $(elm).data('baris');
      var _td = $(elm).closest('td');
      var _tr = $(elm).closest('tr');
      var _cost_center = '';
      var _profit_center = '';
      var _company = $(elm).data('company');
      if(_tr.find('input[name^=costcenter]').length){
        _cost_center = _tr.find('input[name^=costcenter]').eq(0).val();
        _profit_center = _tr.find('input[name^=profit_ctr]').eq(0).val();
      }

      var _listCostCenter = this.getListCostCenter(_company);
      var _option = ['<option value="">Pilih Cost Center</option>'], _tmp,_selected;
      for(var i in _listCostCenter){
        _selected = _listCostCenter[i]['COSTCENTER'] == _cost_center ? 'selected' : '';
        _tmp = '<option '+_selected+' value="'+_listCostCenter[i]['COSTCENTER']+'">'+_listCostCenter[i]['COSTCENTER']+' - '+_listCostCenter[i]['NAME']+'</option>';
        _option.push(_tmp);
      }
      var _listProfitCenter = this.listProfitCenter[_company];
      var _option_profit = ['<option value="DUMMY">DUMMY</option>'];
      for(var i in _listProfitCenter){
        _selected = _listProfitCenter[i] == _profit_center ? 'selected' : '';
        _tmp = '<option '+_selected+' value="'+_listProfitCenter[i]+'">'+_listProfitCenter[i]+'</option>';
        _option_profit.push(_tmp);
      }
      var _message = [
        '<form class="form form-horizontal">',
          '<div class="form-group">',
            '<label for="costcenter" class="col-sm-3 control-label">Cost Center</label>',
            '<div class="col-sm-6">',
            //  '<input type="text" class="form-control" name="costcenter" value="'+_cost_center+'">',
              '<select class="form-control" name="costcenter">'+_option.join('')+'</select>',
            '</div>',
          '</div>',
          '<div class="form-group">',
            '<label for="profitcenter" class="col-sm-3 control-label">Profit Center</label>',
            '<div class="col-sm-6">',
            //  '<input type="text" class="form-control" name="profit_ctr" value="'+_profit_center+'">',
              '<select class="form-control" name="profit_ctr">'+_option_profit.join('')+'</select>',
            '</div>',
          '</div>',
          '<div class="form-group">',
            '<div class="col-sm-6 col-sm-offset-3">',
              '<span class="btn btn-primary" data-baris="'+_baris+'" data-glaccount="'+_gl+'" onclick="Invoice.setProfitCenterDenda(this)">Simpan</span>&nbsp;',
              '<span class="btn btn-danger" onclick="bootbox.hideAll()">Batal</span>',
            '</div>',
          '</div>',
        '</form>'
      ];
      bootbox.dialog({
        title : 'Account Assignment',
        message : _message.join(''),
        callback : function(){}
      }).on('shown.bs.modal',function(){
        $(this).removeAttr('tabindex');
        $(this).find('select').select2();
        //$(this).find('.select2-dropdown').css({  'z-index': 10052 });
      });
    },
    setProfitCenterDenda : function(elm){
      var _form = $(elm).closest('form');
      var _profit_center = _form.find('select[name=profit_ctr]').val();
      var _cost_center = _form.find('select[name=costcenter]').val();
      var _gl = $(elm).data('glaccount');
      var _baris = $(elm).data('baris');
      // var _span = $('.tdenda').find('span[data-glaccount="'+_gl+'"]');
      // var _td = _span.closest('td');
      var _tr = $('tbody#tbody-GL').find('tr[data-baris='+_baris+']');
      if(_tr.find('td.cost_center').find('input[name^=costcenter]').length){
        // console.log(_cost_center);
        // console.log(_tr.find('input[name^=costcenter]'));
        _tr.find('input[name^=costcenter]').eq(0).val(_cost_center);
        _tr.find('input[name^=profit_ctr]').eq(0).val(_profit_center);
      }else{
        _tr.find('td.profit_center').append('<input type="text" name="profit_ctr[]" value="'+_profit_center+'" readonly />');
        _tr.find('td.cost_center').append('<input type="text" name="costcenter[]" value="'+_cost_center+'" readonly />');
      }
      //_tr.css({'background-color' : 'gray'});
      /* tambahkan pada baris denda yang diset profitcenternya */
      bootbox.hideAll();
    },
    hapusBarisDenda : function(elm){
      var row = $(elm).closest('td').closest('tr');
      var _form_group = row.closest('table').closest('.form-group');
      row.remove();
      this.hitungAmount(_form_group);
    },
    addDenda : function(elm){
          var _form_group = $(elm).closest('.form-group');
          var _tbody = $('#tbody-denda');
          var teks = '';
          var _idDenda = _form_group.find('select');
          var _nominal = _form_group.find('input[name=Nominal]').unmask();
          var _numberPattern = /\d+/g;
          var _fileDendaAkhir = _tbody.find('input[name^=fileDenda]:last');
          var _urutanTerakhir = 0;
          var _glaccount = _idDenda.find('option:selected').data('glaccount');
          var _company = _idDenda.data('company');
          var _glaccountDenda = _glaccount+'_'+_idDenda.val();
          var _tombolProfitCenter =  _glaccount != '' ? '<span onclick="Invoice.setProfitCenter(this)" data-company="'+_company+'" data-glaccount="'+_glaccountDenda+'" class="btn btn-default pull-right"><i class="glyphicon glyphicon-check"></i></span>' : '<span class="btn btn-default pull-right"><i class="glyphicon glyphicon-ok"></i></span>';
          //var _tombolProfitCenter = '';
          if (_fileDendaAkhir.length > 0) {
              var _namaFileTerakhir = _fileDendaAkhir.attr('name');
              var _noUrut = _namaFileTerakhir.match(_numberPattern);
              _urutanTerakhir = _noUrut[0];
          }
          _urutanTerakhir = parseInt(_urutanTerakhir) + 1;

          if (!isNaN(_nominal)) {
              var _idDendaExist = $("#tbody-denda").find('input[name^=idDenda]');
              var _listDenda = {};
              _idDendaExist.each(function() {
                  _listDenda[$(this).val()] = $(this).val();
              });

              if (_listDenda[_idDenda.val()] !== undefined) {
                  bootbox.alert('Denda sudah ada');
              } else {
                  if (_nominal > 0) {
                    teks = '<tr class="dnd">';
                    teks += '<td class="text-center">' + _idDenda.find('option:selected').text() + '<input type="hidden" value="' + _idDenda.val() + '" name="idDenda[]"></td>';
                    teks += '<td class="text-center">' + numberWithCommas(_nominal) + '<input data-glaccount="" type="hidden" value="' + _nominal + '" name="Nominal[]"></td>';
                    teks +=  '<td><input class="hide" name="fileDenda'+_urutanTerakhir+'" type="file"><input name="oldFileDenda'+_urutanTerakhir+'" value="default.png" type="hidden"></td>';
                    teks +=  '<td class="text-center"><a onclick="Invoice.hapusBarisDenda(this);return false" href="#"><span class="glyphicon glyphicon-trash"></span></a></td>';
                    teks += '</tr>';
                    $(teks).appendTo(_tbody);
                    $("#Nominal").val("");
                    $("#jmlDenda").val($(".dnd").length);
                    Invoice.hitungAmount(_form_group);
                  }else{
                    bootbox.alert('Denda harus lebih besar dari 0');
                  }
              }
          } else {
              bootbox.alert('Denda harus angka');
          }
    },
    setPajak : function(elm){
      var _tbodyGR = $('tbody.tbodyGRItem');
      var _pajak = $(elm).val();
      _tbodyGR.find('tr').each(function(){
        $(this).find('select[name^=pajak_gr]').eq(0).val(_pajak);
      })
      this.hitungAmount(elm);
    },
    setPajakHeader : function(elm){
      var _tbodyGR = $('tbody.tbodyGRItem');
      // var _pajak = $(elm).val();
      var _jenisPajak = {}, _jenis, _jmlPajak = 0;
      _tbodyGR.find('tr').each(function(){
        _jenis = $(this).find('select[name^=pajak_gr]').eq(0).val();
        if(_jenisPajak[_jenis] == undefined){
          _jenisPajak[_jenis] = _jenis;
          _jmlPajak++;
        }
      });

      if(_jmlPajak == 1){
        $('select[name=pajak]').val(_jenis);
        $('select[name=pajak]').prop('disabled',0);
      }else{
        $('select[name=pajak]').prop('disabled',1);
      }
      this.hitungAmount(elm);
    },
    hitungAmount : function (elm){
    	var _form = $(elm).closest('form');
    	/* baseAmount + PPn - totalDenda */
    	var _baseAmount = 0 ; //_form.find('input[name=Amount]').data('baseamount');
      var _tbodyGR = $('tbody.tbodyGRItem');
    	var _pajak = 0;//_tbodyGR.find('select[name^=pajak_gr]').find('option:selected').data('pajak');
    	var _denda = 0, _nominalgl = 0, _dk, _tmpNominal;
      var _tmpAmount;
    	var _nilaiPajak = 0; //_pajak * _baseAmount;
      var _calc_tax = $('input[name=calc_tax]').is(':checked') ? 1 : 0;
      var _fix_tax = 0;
      _tbodyGR.find('tr').each(function(){
          _pajak = $(this).find('select[name^=pajak_gr]').find('option:selected').data('pajak');
          _tmpAmount = $(this).find('td.adjustAmount input').unmask();
          _baseAmount += parseInt(_tmpAmount) ;
          if(_calc_tax){
            _nilaiPajak += (_pajak * _tmpAmount) ;
          }else{
            _fix_tax = $(this).find('td.taxAmount input').unmask() || 0;
            _nilaiPajak += parseInt(_fix_tax);
          }
      });
      _nilaiPajak = Math.round(_nilaiPajak);

      /* cari gl account */

      _form.find('tbody#tbody-GL>tr').each(function(){
        _dk = $(this).find('input[name^=fileGL]').eq(0).val();
        _tmpNominal = $(this).find('input[name^=nilai_glaccount]').eq(0).val();
        if(_dk == 'S'){
          _nominalgl += parseInt(_tmpNominal);
        }else{
          _nominalgl -= parseInt(_tmpNominal);
        }
      });

    	_form.find('table.tdenda tbody').find('input[name^=Nominal]').each(function(){
          if($(this).data('glaccount') == '' ){
              _denda += parseInt($(this).val());
          }
    	});

    	// var _totalAmount = _baseAmount + _nilaiPajak - _denda + _nominalgl;
      var _totalAmount = _baseAmount + _nilaiPajak + _nominalgl;
      _form.find('input[name=ppn_readonly]').val(numberWithCommas(_nilaiPajak));
      _form.find('input[name=denda_readonly]').val(numberWithCommas(_denda - _nominalgl));
    	// _form.find("#total").val(_totalAmount);
    	_form.find('input[name=totalAmount]').val(numberWithCommas(_totalAmount));
      _form.find('input[name=Amount]').val(numberWithCommas(_baseAmount));
      _form.find('input#text_amount_help').val(numberWithCommas(_baseAmount));
    },

    hapusBarisGLAccount : function(elm){
      var row = $(elm).closest('td').closest('tr');
      var _form_group = row.closest('table').closest('.form-group');
      row.remove();
      this.hitungAmount(_form_group);
    },
    addGLAccount : function(elm){
          var _form_group = $(elm).closest('.form-group');
          var _tbody = $('tbody#tbody-GL');
          var teks = '';
          var _idglaccount = _form_group.find('select');
          var _textline = _form_group.find('input[name=text_glaccount]').val();
          var _nominal_glaccount = _form_group.find('input[name=nominal_glaccount]').unmask();
          var _numberPattern = /\d+/g;
          var _fileGLAkhir = _tbody.find('input[name^=fileGL]:last');
          var _urutanTerakhir = 0;
          var _glaccount2 = $('#glaccount_option').val();;
          var _company = _idglaccount.data('company');
          //var _glaccountDenda = _glaccount2+'_'+_idglaccount.val();
          //var _tombolProfitCenter = '';
          var _dkval = $('#dk').val();
          var _status_dk = "";
          //  alert(_fileGLAkhir.attr('name'));
          if(_dkval.length > 0){
            if(_dkval == "S"){
                _status_dk = "Debet";
            }else{
                _status_dk = "Kredit";
            }

              _urutanTerakhir = parseInt(_tbody.find('tr').length) + 1;
              var _tombolProfitCenter =  '<span onclick="Invoice.setProfitCenter(this)" data-baris="'+_urutanTerakhir+'" data-company="'+_company+'" data-glaccount="'+_glaccount2+'" class="btn btn-default pull-right"><i class="glyphicon glyphicon-check"></i></span>';

              if (!isNaN(_nominal_glaccount)) {
                  // var _idGLExist = $("#tbody-glaccount").find('input[name^=noglaccount]');
                  var _listGL = {};

                  if (_listGL[_idglaccount.val()] !== undefined) {
                      bootbox.alert('Denda sudah ada');
                  } else {
                      if (_nominal_glaccount > 0) {
                        var _pajak_master = [];
                        $('select[name=pajak]').find('option').each(function(){
                            _pajak_master.push('<option value="'+$(this).val()+'">'+$(this).text()+'</option>');
                        });
                        var _list_pajak = ['<select class="form-control" name="pajakGL[]" style="width:100px" >',
                            '<option value="">Pilih Jenis Pajak</option>',
                            _pajak_master.join(''),
                            '</select>'
                        ];
                        var _teks_option = $('#glaccount_option').find('option:selected').text().split('-');
                        teks = '<tr data-baris="'+_urutanTerakhir+'">';
                        teks += '<td><input type="text" name="noglaccount[]" style="border:none;width:100px" value="'+_glaccount2+'" readonly></td>';
                        teks += '<td>'+_teks_option[1]+'</td>';
                        teks += '<td class="text-center">' + numberWithCommas(_nominal_glaccount) + '<input type="hidden" value="' + _nominal_glaccount + '" name="nilai_glaccount[]"></td>';
                        teks += '<td><input class="hide" name="fileGL[]" value="'+_dkval+'" type="text">'+_status_dk+'</td>';
                        teks += '<td>'+_list_pajak.join('')+'</td>';
                        teks += '<td class="cost_center"><input type="text" style="border:none;width:100px" name="textline[]" value="'+_textline+'" /></td>';
                        teks += '<td class="cost_center"><input type="text" style="border:none;width:100px" name="costcenter[]" value="" readonly /></td>';
                        teks += '<td class="profit_center"><input type="text" style="border:none;width:100px" name="profit_ctr[]" value="" readonly />'+_tombolProfitCenter+'</td>';
                        teks +=  '<td class="text-center"><a onclick="Invoice.hapusGLAccount(this);return false" href="#"><span class="glyphicon glyphicon-trash"></span></a></td>';
                        teks += '</tr>';

                        $(teks).appendTo('#tbody-GL');
                        _form_group.find("input[name=nominal_glaccount]").val("");
                        _form_group.find('#dk').val('');
                        //$("#jmlDenda").val($(".dnd").length);
                        Invoice.hitungAmount(_form_group);
                      }else{
                        bootbox.alert('Denda harus lebih besar dari 0');
                      }
                  }
              } else {
                  bootbox.alert('Denda harus angka');
              }

          }else{
            bootbox.alert('Pilih Debat atau Kredit');
          }
    },
    hapusGLAccount : function(elm){
      var row = $(elm).closest('td').closest('tr');
      var _form_group = row.closest('table').closest('.form-group');
      row.remove();
      this.hitungAmount(_form_group);
    },

    addElmPosting : function(elm){
      this.akanPosting = 1;
      var _form = $(elm).closest('form');
      _form.append('<input type="hidden" name="postingInvoice" value="1">');
      _form.find(':submit').click();
    },

    setCalculateTax : function(elm){
      /* set required untuk taxBaseAmount dan taxAmount */
      var _checked = $(elm).is(':checked') ? 1 : 0;
      if(!_checked){
        $('input[name^=taxBaseAmountSAP],input[name^=taxAmountSAP]').prop('required', true);
        $('input[name^=taxBaseAmountSAP],input[name^=taxAmountSAP]').prop('readonly', false);
      }else{
        $('input[name^=taxBaseAmountSAP],input[name^=taxAmountSAP]').prop('required', false );
        $('input[name^=taxBaseAmountSAP],input[name^=taxAmountSAP]').prop('readonly', true);
      }
      Invoice.hitungAmount(elm);
    },
    setTaxBaseAmountDefault : function(){
        var _calc_tax = $('input[name=calc_tax]').is(':checked') ? 1 : 0;
        if(!_calc_tax){
          var _tbodyGR = $('tbody.tbodyGRItem');
          var _fix_tax;
          var _baseAmount,_pajak;
          _tbodyGR.find('tr').each(function(){
              _pajak = $(this).find('select[name^=pajak_gr]').find('option:selected').data('pajak');
              _fix_tax = $(this).find('td.taxAmount input').unmask();
              if(_pajak > 0){
                _baseAmount =  _fix_tax * (1/_pajak);
                $(this).find('td.taxBaseAmount input').val(numberWithCommas(_baseAmount));
              }
          });
        }
    },
    viewSimulate : function(elm){
      var _id = $('#ID_INVOICE').val();
      var _header = {};
      _header['ID_INVOICE'] = _id;
      _header['DOC_TYPE'] = $('select[name=doc_type]').val();
      _header['PSTNG_DATE'] = $('input[name=posting_date]').val();
      _header['REF_DOC_NO'] = $('input[name=faktur_no]').val();
      _header['BLINE_DATE'] = $('input[name=baseline_date]').val();
      _header['PMNT_BLOCK'] = $('select[name=payment_block]').val();
      _header['PYMT_METH'] = $('select[name=payment_method]').val();
      _header['PARTNER_BK'] = $('select[name=partner_bank]').val();
      _header['CALC_TAX_IND'] = $('input[name=calc_tax]').prop('checked') ? 'X' : '';
      _header['DOC_DATE'] = $('input[name=invoice_date]').val();
      _header['GROSS_AMOUNT'] = $('input[name=totalAmount]').val();

      //var pjk_gr = $("input[name='pajak_gr[]']").map(function(){return $(this).val();}).get();
      //var amount = $("input[name='amountSAP[]']").map(function(){return $(this).val();}).get();

      /*Base GR*/
      var pjk_gr = {};
      $('select[name^="pajak_gr"]').each(function() {
        var tr = $(this).closest('tr');
        var key = tr.find('td:eq(2)').data('key');
        pjk_gr[key] = $(this).val();
      });

      var amount = {};
      $('input[name^="amountSAP"]').each(function() {
        var tr = $(this).closest('tr');
        var key = tr.find('td:eq(2)').data('key');
        amount[key] = $(this).val();
      });

      var tax_base = {};
      $('input[name^="taxBaseAmountSAP"]').each(function() {
        var tr = $(this).closest('tr');
        var key = tr.find('td:eq(2)').data('key');
        tax_base[key] = $(this).val();
      });

      var tax_amount = {};
      $('input[name^="taxAmountSAP"]').each(function() {
        var tr = $(this).closest('tr');
        var key = tr.find('td:eq(2)').data('key');
        tax_amount[key] = $(this).val();
      });

      /*With Holding Tax*/
      var t_amount = {};
      $('input[name^="WTAX_AMOUNT"]').each(function() {
        var tr = $(this).closest('tr');
        var code = tr.find('td:eq(0)').text();
        t_amount[code] = $(this).val();
      });

      var t_type = {};
      $('input[name^="WTAX_TYPE"]').each(function() {
        var tr = $(this).closest('tr');
        var code = tr.find('td:eq(0)').text();
        t_type[code] = $(this).val();
      });

      var t_code = {};
      $('select[name^="WTAX_CODE"]').each(function() {
        var tr = $(this).closest('tr');
        var code = tr.find('td:eq(0)').text();
        t_code[code] = $(this).val();
      });

      /*GL Account*/
      var no_gl = new Array();
      $('input[name^="noglaccount"]').each(function() {
        no_gl.push($(this).val());
      });

      var nilai_gl = new Array();
      $('input[name^="nilai_glaccount"]').each(function() {
        nilai_gl.push($(this).val());
      });

      var file_gl = new Array();
      $('input[name^="fileGL"]').each(function() {
        file_gl.push($(this).val());
      });

      var pajak_gl = new Array();
      $('select[name^="pajakGL"]').each(function() {
        pajak_gl.push($(this).val());
      });

      var cc = new Array();
      $('input[name^="costcenter"]').each(function() {
        cc.push($(this).val());
      });

      var pc = new Array();
      $('input[name^="profit_ctr"]').each(function() {
        pc.push($(this).val());
      });

      var _url = $('#base-url').val() + 'EC_Invoice_ver/dataSimulate';
      $.post(_url,{
        header:_header,
        amountSAP:amount,
        pajak_gr:pjk_gr,
        taxBaseAmountSAP:tax_base,
        taxAmountSAP:tax_amount,
        WTAX_AMOUNT:t_amount,
        WTAX_TYPE:t_type,
        WTAX_CODE:t_code,
        noglaccount:no_gl,
        nilai_glaccount:nilai_gl,
        fileGL:file_gl,
        pajakGL:pajak_gl,
        costcenter:cc,
        profit_ctr:pc
      },function(data){

        if(data[0]['STATUS'] == false){
          $('#tabelDK').html('');
          $('#tabelSimulate').html(data[0]['ERROR']);
          $('#alert').text('Error');
          $('#alert').removeClass('hide');
        }else{
          var _tab =  '<thead><tr>'+
                      '<th class="text-center">No</th>'+
                      '<th class="text-center">Acc Type</th>'+
                      '<th class="text-center">G/L</th>'+
                      '<th class="text-center">Act/Mat/Ast/Vndr</th>'+
                      '<th class="text-center">Amount</th>'+
                      '<th class="text-center">Currency</th>'+
                      '<th class="text-center">Debet/Credit</th>'+
                      '<th class="text-center">Tax Code</th>'+
                    '</tr></thead><tbody>';

          for(var i = 1; i < data.length; i++){
            _tab += '<tr><td class="text-center">'+i+'</td>'+
                    '<td class="text-center">'+data[i]['ACCC_TYPE']+'</td>'+
                    '<td>'+data[i]['GL']+'</td>'+
                    '<td>'+data[i]['DESC']+'</td>'+
                    '<td>'+data[i]['AMOUNT']+'</td>'+
                    '<td class="text-center">'+data[i]['CURRENCY']+'</td>'+
                    '<td class="text-center">'+data[i]['DC']+'</td>'+
                    '<td class="text-center">'+data[i]['TAX_CODE']+'</td></tr>';

          }
          _tab += '</tbody>';
          $('#tabelSimulate').html(_tab);

          var _bl = '';
          if(data[0]['BL']){
            _bl = '<strong style="color:green;font-size: larger;">BALANCE</strong>';
          }else{
            _bl = '<strong style="color:red;font-size: larger;">NOT BALANCE</strong>';
          }
          var _dk = '<thead><tr><th class="text-center">Debet/Kredit</th><th class="text-center">Nilai</th><th class="text-center">Keterangan</th></tr></thead>'+
                    '<tbody><tr><td class="text-center">Debet</td><td class="text-center">'+data[0]['DEBIT']+'</td><td rowspan="2" class="text-center">'+_bl+'</td></tr>'+
                    '<tr><td class="text-center">Kredit</td><td class="text-center">'+data[0]['KREDIT']+'</td></tr></tbody>';
          $('#tabelDK').html(_dk);
          $('#alert').addClass('hide');
        }
        $('#simulateInvoice').modal('show');

      },'json');
    }
}

function showDocument(elm){
  var url = $(elm).data('url');
  var data = {
    tipe : $(elm).data('tipe'),
    id : $(elm).data('iddokumen'),
    nopo : $(elm).data('nopo'),
    print_type : $(elm).data('print_type')
  };
  $.redirect(url,data,'POST','_blank');
  return false;
}

function showDocumentBA(elm){
  var url = $('#base-url').val() + 'EC_Approval/Pomut/cetakBeritaAcara';
  var data = {
    no_ba : $(elm).data('no_ba')
  };
  $.redirect(url,data,'POST','_blank');
  //return false;
}