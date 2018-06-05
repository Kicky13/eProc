base_url = $("#base-url").val();

function SAPsUpdate() {
	$.ajax({
		url : $("#base-url").val() + 'EC_Master_invoice/sapTax/',
		type : 'POST',
		dataType : 'json'
	}).done(function(data) {
		console.log(data);

	}).fail(function() {
		console.log("error");
	}).always(function(data) {
		//console.log(data);
		// $('#tableMT').DataTable().destroy();
		// $('#tableMT tbody').empty();
		// loadTable();
	});
}
function updateDenda(elm){
       /* pastikan semua sudah diisi */
       var _form = $(elm).closest('form');
       var _url = _form.attr('action');
       var _data = [];
       _form.find('input').each(function(){
           var _d = $(this);
          _data[_d.attr('name')] = _d.val();
       });
       $.post(_url,_data,function(result){
           bootbox.alert(result.message);
           if(result.status){
               $('#EditdendaBaru').hide();
           }
       },'json');
}
$(document).ready(function() {
	$('#CreateMapping').submit(function(e){
		var _form = this;
		var _email = $('#email').val();
		var _nama = $('#nama').val();
		var _id = $('#id_sap').val();
		//alert ('Email = '+_email+' nama = '+_nama+' id = '+_id);
		e.preventDefault();

		var _url = $('#base-url').val() + 'EC_Master_invoice/CheckEmail';
		$.get(_url,{email : _email},function(data){
			if(data.status){
				_form.submit();
			}else{
				alert('Mohon Maaf Email '+_email+' Sudah Terdaftar');
				return false;
			}
		},'json');
	});

	$('#invoicePlantForm').on('show.bs.modal', function(e){
		 var _btn = $(e.relatedTarget);
		 var _plant = _btn.data('plant') || '';
		 var _modal = $(this);
		 var _status = _btn.data('status') == undefined ? 1 : _btn.data('status');
		 _modal.find('input[name=plant]').val(_plant);
		 if(_status == 1){
			 	_modal.find('input[name=status_plant]').prop('checked',_status);
		 }else{
			 _modal.find('input[name=status_plant]').prop('checked',0);
		 }

	});

	$('#invoicePlantForm form').submit(function(e){
			var _form = $(this);
			var _url = _form.attr('action');
			var _plant = $.trim(_form.find('input[name=plant]').val());
			var _status = _form.find(':checkbox[name=status_plant]').is(':checked') ? 1 : 0;

			var _error = 0, _message = [];
			e.preventDefault();
			/* pastkan plant tidak kosong */
			if(_plant == ''){
				_error++;
				_message.push('Plant tidak boleh kosong');
			}
			if(!_error){
				$.post(_url,{ plant : _plant, status : _status}, function(data){
					$('#invoicePlantForm').modal('hide');
					bootbox.alert(data.message);
					if(data.data.action == 'insert'){
						var _row = [
							'<tr>',
							'<td class="plant text-center" data-db="'+data.data.plant+'">'+data.data.plant+'</td>',
							'<td class="status text-center" data-db="'+data.data.status+'">'+(data.data.status ? 'AKTIF' : 'NON AKTIF')+'</td>',
							'<td class="text-center" data-db="'+data.data.create_date+'">'+data.data.create_date+'</td>',
							'<td class="text-center" data-db="'+data.data.create_by+'">'+data.data.create_by+'</td>',
							'<td class="action text-center">',
								'<a href="javascript:void(0)" data-toggle="modal" data-target="#invoicePlantForm" data-status="'+data.data.status+'" data-plant="'+data.data.plant+'"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>',
								'<a href="#" data-plant="'+data.data.plant+'" onclick="deleteInvoicePlant(this)"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>',
							'</td>',
							'<tr>',
					];
					$('#tableinvoicePlant tbody').append(_row.join(''));

					}else{
						var _row = $('#tableinvoicePlant tbody tr>td.plant[data-db='+data.data.plant+']').closest('tr');
						var _td_status = data.data.status == 1 ? 'AKTIF' : 'NON AKTIF';
						_row.find('td.status').text(_td_status);
						_row.find('td.action a').data('status',data.data.status);
					}
				},'json');
			}

	})

	$('#purchasingGroupForm').on('show.bs.modal', function(e){
		 var _btn = $(e.relatedTarget);
		 var _tr = _btn.closest('tr');
		 var _prchgrp = _tr.find('td.prchgrp').text() || '';
		 var _desc = _tr.find('td.desc').text() || '';
		 var _modal = $(this);
		 var _url = $("#base-url").val() + 'EC_Master_invoice/getListPurchasingGroup/';
		 $.get(_url,{},function(data){
			 var _opt = [], _selected;
			 for(var i in data){
				 _selected = _prchgrp == data[i]['EKGRP'] ? 'selected' : '';
				 _opt.push('<option '+_selected+' value="'+data[i]['EKGRP']+'">'+data[i]['EKGRP']+' - '+data[i]['EKNAM']+'</option>');
			 }
			 _modal.find('select[name=PRCHGRP]').find('option:gt(0)').remove();
			 _modal.find('select[name=PRCHGRP]').append(_opt.join(''));
			 _modal.find('input[name=DESCRIPTION]').val(_desc);
			 _modal.find('select[name=PRCHGRP]').select2();
		 },'json');

	});

	$('#purchasingGroupForm form').submit(function(e){
			var _form = $(this);
			var _url = _form.attr('action');
			var _prchgrp = $.trim(_form.find('select[name=PRCHGRP]').val());
			var _desc = $.trim(_form.find('input[name=DESCRIPTION]').val());

			var _error = 0, _message = [];
			e.preventDefault();
			/* pastkan plant tidak kosong */
			if(_prchgrp == ''){
				_error++;
				_message.push('Purhasing group tidak boleh kosong');
			}
			if(!_error){
				$.post(_url,{ prchgrp : _prchgrp, desc : _desc}, function(data){
					$('#purchasingGroupForm').modal('hide');
					bootbox.alert(data.message);
					if(data.data.action == 'insert'){
						var _row = [
							'<tr>',
							'<td class="prchgrp text-center" data-db="'+_prchgrp+'">'+_prchgrp+'</td>',
							'<td class="desc text-center" >'+_desc+'</td>',
							'<td class="action text-center">',
								'<a href="javascript:void(0)" data-toggle="modal" data-target="#purchasingGroupForm" ><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>',
								'<a href="javascript:void(0)" data-prchgrp="'+_prchgrp+'" onclick="deletePurchasingGroup(this)"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>',
							'</td>',
							'<tr>',
					];
					$('#tablepurchasinggroup tbody').append(_row.join(''));

					}else{
						var _row = $('#tablepurchasinggroup tbody tr>td.prchgrp[data-db='+data.data.prchgrp+']').closest('tr');
						_row.find('td.desc').text(_desc);
					}
				},'json');
			}

	});

	$('#rangePOFrom form').submit(function(e){
		var _form = $(this);
		e.preventDefault();
		_url = _form.attr('action');
		_start = $('input[name=START_RANGE]').val();
		_end = $('input[name=END_RANGE]').val();
		_aksi = $('input[name=AKSI]').val();
		_status = $('input[name=STATUS]').is(':checked') ? 1 : 0;
		_stat = _status == 1 ? 'AKTIF' : 'TIDAK AKTIF';

		if(_start >= _end){
			bootbox.alert("Nilai Start Range Harus Lebih Kecil Dari End Range");
		}else{
			$.post(_url,{
				START_RANGE:_start,
				END_RANGE:_end,
				STATUS:_status,
				AKSI:_aksi
			}, function(data){
				if(data.status){
					if(data.aksi == 'tambah'){
						bootbox.alert(data.msg);
						var _tr = "<tr>";
						_tr += "<td class='text-center a'>"+_start+"</td>";
						_tr += "<td class='text-center b'>"+_end+"</td>";
						_tr += "<td class='text-center c'>"+_stat+"</td>";
						_tr += "<td class='action text-center'>";
						_tr += "<a href='javascript:void(0)' data-start='"+_start+"' data-end='"+_end+"' data-status='"+_status+"' onClick='updatePO(this)''><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></a>";
						_tr += " <a href='javascript:void(0)' data-rpo='"+_start+"' onclick='deleteRPO(this)'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></a>";
						_tr +="</td>";
						_tr += "</tr>";
						$('#tabelrangePO tr:last').after(_tr);
						$('#rangePOFrom').modal('hide');
					}else{
						var row = $('#tabelrangePO tbody tr>td a[data-start="'+_aksi+'"]').closest('tr');
						row.find(".a").text(_start);
						row.find(".b").text(_end);
						row.find(".c").text(_stat);

						row.find(".action").html('');

						var _act = "<a href='javascript:void(0)' data-start='"+_start+"' data-end='"+_end+"' data-status='"+_status+"' onClick='updatePO(this)''><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></a>";
						_act += " <a href='javascript:void(0)' data-rpo='"+_start+"' onclick='deleteRPO(this)'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></a>";
						row.find(".action").html(_act);
						bootbox.alert(data.msg);
						$('#rangePOFrom').modal('hide');
					}
				}else{
					bootbox.alert(data.msg);
				}
			},'json')
		}
	});

	$('#roleGRForm form').submit(function(e){
		var _form = $(this);
		e.preventDefault();
		_url = _form.attr('action');
		_username = $('input[name=Username]').val().toUpperCase();
		_access = $('input[name=Access]').val().toUpperCase();
		_aksi = $('input[name=AKSI]').val();
		_status = $('input[name=Status]').is(':checked') ? 1 : 0;
		_stat = _status == 1 ? 'AKTIF' : 'TIDAK AKTIF';

		$.post(_url,{
			USERNAME: _username,
			ACCESS: _access,
			STATUS:_status,
			AKSI:_aksi
		}, function(data){
			if(data.status){
				if(data.aksi == 'tambah'){
					bootbox.alert(data.msg);
					var _tr = "<tr>";
					_tr += "<td class='text-center a'>"+_username+"</td>";
					_tr += "<td class='text-center b'>"+_access+"</td>";
					_tr += "<td class='text-center c'>"+_stat+"</td>";
					_tr += "<td class='action text-center'>";
					_tr += "<a href='javascript:void(0)' data-username='"+_username+"' data-access='"+_access+"' data-status='"+_status+"' onClick='updateRoleGR(this)''><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></a>";
					_tr += " <a href='javascript:void(0)' data-username='"+_username+"' data-access='"+_access+"' onclick='deleteRoleGR(this)'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></a>";
					_tr +="</td>";
					_tr += "</tr>";
					$('#tabelRoleGR tr:last').after(_tr);
					$('#roleGRForm').modal('hide');
				}else{
					var row = $('#tabelRoleGR tbody tr>td a[data-username="'+_username+'"][data-access="'+_access+'"]').closest('tr');

					row.find(".a").text(_username);
					row.find(".b").text(_access);
					row.find(".c").text(_stat);
					row.find(".action").html('');
					var _act = "<a href='javascript:void(0)' data-username='"+_username+"' data-access='"+_access+"' data-status='"+_status+"' onClick='updateRoleGR(this)''><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></a>";
					_act += " <a href='javascript:void(0)' data-username='"+_username+"' data-access='"+_access+"' data-status='"+_status+"' onclick='deleteRoleGR(this)'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></a>";
					row.find(".action").html(_act);
					bootbox.alert(data.msg);
					$('#roleGRForm').modal('hide');
				}
			}else{
				bootbox.alert(data.msg);
			}
		},'json');
	});

});

$('#EditdendaBaru').on('show.bs.modal', function(event) {
		var button = $(event.relatedTarget)
		$("#inputjenis").val(button.data('jenis'))
		$("#glAccount").val(button.data('gl'))
		$("#ID_JENIS").val(button.data('iddenda'))
		if(button.data('direct')==1){
			$("#checkboxdenda").prop("checked", true);
			$("#glAccount").prop("readonly", true);
		}else{
			$("#checkboxdenda").prop("checked", false);
			$("#glAccount").prop("readonly", false);
		}
	})

$('#editdocBaru').on('show.bs.modal', function(event) {
		var button = $(event.relatedTarget)
		$("#DokumenType").val(button.data('jenis'))
		$("#ID_DOC").val(button.data('docid'))
		/*$("#glAccount").val(button.data('gl'))
		$("#ID_JENIS").val(button.data('iddenda'))
		if(button.data('direct')==1){
			$("#checkboxdenda").prop("checked", true);
			$("#glAccount").prop("readonly", true);
		}else{
			$("#checkboxdenda").prop("checked", false);
			$("#glAccount").prop("readonly", false);
		}*/
	})

	$('#UserRoleUpdate').on('show.bs.modal', function(event) {
			var _modal = $(this);
			var _a = $(event.relatedTarget);
			var _td = _a.closest('td');
			var _tr = _a.closest('tr');
			var _id = _a.data('docid');
			var _user = _tr.find('td:eq(1)').text();
			var _role = _tr.find('td:eq(2)').data('db');
			var _status = _tr.find('td:eq(3)').data('db');
			//console.log(_id);
			_modal.find('input[name=id]').val(_id);
			_modal.find('input[name=username]').val(_user);
			_modal.find('select[name=role]').val(_role);
			_modal.find('input[name=status]').prop('checked',_status);
		})

	$('#userMappingUpdate').on('show.bs.modal', function(event) {
			var _modal = $(this);
			var _a = $(event.relatedTarget);
			var _td = _a.closest('td');
			var _tr = _a.closest('tr');
			var _email = _tr.find('td:eq(0)').data('db');
			var _nama = _tr.find('td:eq(1)').data('db');
			var _no_sap = _tr.find('td:eq(2)').data('db');
			//console.log(_id);
			_modal.find('input[name=email]').val(_email);
			_modal.find('input[name=nama]').val(_nama);
			_modal.find('input[name=id_sap]').val(_no_sap);
		})


var id_parent,
    lvl,
    countLvl0 = 0,
    countLvl1 = 0,
    countLvl2 = 0,
    countLvl3 = 0,
    countLvl4 = 0,
    countLvl5 = 0,
    countLvl6 = 0;
$(".formBaru").on("submit", function() {
	if ($("#kode").val() == '') {
		alert('Pilih Parent!!')
		return false;
	};
	// console.log(id_parent + " # " + $("#kode").val() + " # " + $("#desc").val() + " # " + lvl)
	baru(id_parent, $("#kode").val(), $("#desc").val(), lvl)
	return false;
})
// $(".formEdit").on("submit", function() {
// return false;
// })
$("#btnEdit").on("click", function() {
	$.ajax({
		url : $("#base-url").val() + 'EC_Master_category/ubah/' + id_parent,
		data : {
			"desc" : $("#descEdit").val(),
		},
		type : 'POST',
		dataType : 'json'
	}).done(function(data) {
		console.log(data);
	}).fail(function() {
		console.log("error");
	}).always(function(data) {
		loadTree()
	});
})
$("#btnDelete").on("click", function() {
	if (confirm("Konfirmasi hapus?") && $("#kodeEdit").val() != "")
		$.ajax({
			url : $("#base-url").val() + 'EC_Master_category/hapus/' + id_parent,
			data : {
				"kodeEdit" : $("#kodeEdit").val(),
			},
			type : 'POST',
			dataType : 'json'
		}).done(function(data) {
		}).fail(function() {
			console.log("error");
		}).always(function(data) {
			loadTree()
		});
})
function baru(id_parent, kode_user, desc, lvl) {
	$.ajax({
		url : $("#base-url").val() + 'EC_Master_category/baru/' + id_parent,
		data : {
			"desc" : desc,
			"kode_user" : kode_user,
			"level" : lvl
		},
		type : 'POST',
		dataType : 'json'
	}).done(function(data) {
		console.log(data);
		loadTree()
	}).fail(function() {
		console.log("error");
	}).always(function(data) {
		//console.log(data);
	});
}
function setDirect(elm) {
	if ($(elm).is(":checked")){
		$("#inputGl").val('-');
		$("#inputGl").prop("readonly", true);
	}else{
		$("#inputGl").val('');
		$("#inputGl").prop("readonly", false);
	}

}

function setDirect2(elm) {
	if ($(elm).is(":checked")){
		$("#glAccount").val('-');
		$("#glAccount").prop("readonly", true);
	}else{
		$("#glAccount").val('');
		$("#glAccount").prop("readonly", false);
	}

}

function setPublished(elm, ID_JENIS, table) {
	if ($(elm).is(":checked")){
		status = 1;
	}else{
		status = 0;
	}

        bootbox.confirm('Apakah anda yakin akan mengubah status ?',function(r){
            if(r){
               $.ajax({
		url : $("#base-url").val() + 'EC_Master_invoice/updatePublish/' + ID_JENIS,
		data : {
			status_publish : status,
			tabel : table
                    },
		type : 'POST',
		dataType : 'json'
                }).done(function(data) {
                    bootbox.alert(data.message);
                }).fail(function() {
                        //console.log("error");
                });
            }else{
                if ($(elm).is(":checked")){
                    $(elm).prop('checked',0);
                }else{

                    $(elm).prop('checked',1);
                }

            }
        });
}

function deleteMapping(elm){
	var _email = $(elm).data('email');
	var _tr = $(elm).closest('tr');
	//alert(_email);
	if(confirm('Apakah Anda Akan Menghapus Data Ini ?')){
		var _url = $('#base-url').val() + "EC_Master_invoice/deleteMapping/";
		$.get(_url,{email : _email},function(data){
			if(data.status){
					alert('Data Berhasil Dihapus');
					_tr.remove();
			}else{
					alert('Hapus Data Gagal');
			}
		},'json');
	}
}

function deleteInvoicePlant(elm){
	bootbox.confirm('Apakah anda yakin menghapus data ini ?',function(r){
		if(r){
			var _plant = $(elm).data('plant');
			var _tr = $(elm).closest('tr');
			var _url = $('#base-url').val() + "EC_Master_invoice/deleteInvoicePlant/";
			$.post(_url,{plant : _plant},function(data){
				if(data.status){
						_tr.remove();
				}
				bootbox.alert(data.message);
				bootbox.hideAll();
			},'json');
		}
	})
}

function deletePurchasingGroup(elm){
	bootbox.confirm('Apakah anda yakin menghapus data ini ?',function(r){
		if(r){
			var _prchgrp = $(elm).data('prchgrp');
			var _tr = $(elm).closest('tr');
			var _url = $('#base-url').val() + "EC_Master_invoice/deletePurchasingGroup/";
			$.post(_url,{prchgrp : _prchgrp},function(data){
				if(data.status){
						_tr.remove();
				}
				bootbox.alert(data.message);
				bootbox.hideAll();
			},'json');
		}
	})
}

function setDescription(elm){
	var _f = $(elm).closest('form');
	var _t = $(elm).find('option:selected').text();
	var _s = _t.split('-');
	var _u = _s[1] == undefined ? '' : _s[1];
	_f.find('[name=DESCRIPTION]').val(_u);
}

function tambahRPO(){
	$('#headerpo').text('CREATE RANGE PO');
	$("#rangePOFrom").modal("show");
	$("input").val('').attr('readonly',false);;
	$('input[name=AKSI]').val('TAMBAH');
	$('input[name=STATUS]').prop("checked",false);
}

function updatePO(elm){
	$("#rangePOFrom").modal("show");
	$('#headerpo').text('UPDATE RANGE PO');
	$("input").val('');
	$('input[name=STATUS]').prop("checked",false);


	var _start = $(elm).data('start');
	var _end = $(elm).data('end');
	var _status = $(elm).data('status');

	$('input[name=AKSI]').val(_start);
	$('input[name=START_RANGE]').val(_start).attr('readonly',true);;
	$('input[name=END_RANGE]').val(_end).attr('readonly',true);;
	$('input[name=STATUS]').prop("checked",_status);
}

function deleteRPO(elm){
	bootbox.confirm('Apakah anda yakin menghapus data ini ?',function(r){
		if(r){
			var _rpo = $(elm).data('rpo');
			var _tr = $(elm).closest('tr');
			var _url = $('#base-url').val() + "EC_Master_invoice/deleteRPO/";
			$.post(_url,{rpo : _rpo},function(data){
				if(data.status){
						_tr.remove();
				}
				bootbox.hideAll();
				bootbox.alert(data.msg);
			},'json');
		}
	})
}

function tambahRoleGR(){
	$('#headerRoleGR').text('CREATE ROLE APPROVAL GR');
	$("#roleGRForm").modal("show");
	$("input").val('').attr('readonly',false);;
	$('input[name=AKSI]').val('TAMBAH');
	$('input[name=Status]').prop("checked",false);
}

function updateRoleGR(elm){
	$("#roleGRForm").modal("show");
	$('#headerRoleGR').text('UPDATE RANGE PO');
	$("input").val('');
	$('input[name=Status]').prop("checked",false);


	var _username = $(elm).data('username');
	var _access = $(elm).data('access');
	var _status = $(elm).data('status');

	$('input[name=AKSI]').val('UBAH');
	$('input[name=Username]').val(_username).prop('readonly',true);
	$('input[name=Access]').val(_access).prop('readonly',true);
	$('input[name=Status]').prop("checked",_status);
}

function deleteRoleGR(elm){
	bootbox.confirm('Apakah anda yakin menghapus data ini ?',function(r){
		if(r){
			var _username = $(elm).data('username');
			var _access = $(elm).data('access');

			var _tr = $(elm).closest('tr');
			var _url = $('#base-url').val() + "EC_Master_invoice/deleteRoleGR/";
			$.post(_url,{username : _username,access : _access},function(data){
				if(data.status){
						_tr.remove();
				}
				bootbox.hideAll();
				bootbox.alert(data.msg);
			},'json');
		}
	})
}

$('#editPlantBaru').on('show.bs.modal', function(event) {
		var button = $(event.relatedTarget)
		$("#ROLE_AS").val(button.data('role'))
		$("#VALUE").val(button.data('nilai'))		
	})