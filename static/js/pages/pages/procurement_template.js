var countWeight = 0;

function hapus(e) {
	console.log('hapus parent');
	td = $(e).parent();
	console.log(td)
	tr = td.parent();
	console.log(tr)
	id_parent = tr.find(".id_parent").val()

	$("#select_item_det").children('option').each(function() {
		var s = $(this).prop('value');
    	var fields = s.split('_');
		if (fields[0] == id_parent) {
			$(this).remove();
		}
	});

	weight = tr.find(".parent_weight").val();
	countWeight -= weight;

	tr.remove()
}

function hapus_detail(e) {
	console.log('hapus parent');
	li = $(e).parent();
	li.remove();
}

$(document).ready(function(){
	var no = 1; // evt_teknis master id.

	/* Prevent submit on enter */
	$(window).keydown(function(event){
		if(event.keyCode == 13) {
			event.preventDefault();
			return false;
		}
	});

	$('#evt_tech_weight').keyup(function(){		
		tech_weight = $('#evt_tech_weight').val();
		price_weight = $('#evt_price_weight').val();
		if ((parseInt(tech_weight) + parseInt(price_weight)) > 100) {
			alert('Jumlah Bobot Teknis + Bobot Harga tidak boleh lebih dari 100.');
			$("#evt_tech_weight").val("");
			$("#evt_tech_weight").focus();
		}
	});
	$('#evt_price_weight').keyup(function(){		
		tech_weight = $('#evt_tech_weight').val();
		price_weight = $('#evt_price_weight').val();
		if ((parseInt(tech_weight) + parseInt(price_weight)) > 100) {
			alert('Jumlah Bobot Teknis + Bobot Harga tidak boleh lebih dari 100.');
			$("#evt_price_weight").val("");
			$("#evt_price_weight").focus();
		}
	});

	/* Check udah siap submit apa nggak */
	$("form").submit(function(event) {
		if ((Number($('#evt_tech_weight').val())+Number($('#evt_price_weight').val())) != 100) {
			console.log((Number($('#evt_tech_weight').val())+Number($('#evt_price_weight').val())));
			alert('Jumlah Bobot Teknis + Bobot Harga tidak boleh kurang/lebih dari 100.')
			event.preventDefault();
			return;
		}
		if (countWeight != $('#evt_tech_weight').val()) {
			alert('Total nilai evaluasi teknis belum mencapai Bobot Teknis')
			event.preventDefault();
			return;
		}
		data_child = 'ada';
		$(".listnya").each(function() {
			ul = $(this)
			if (ul.children('li').length <= 0) {
				alert('Setiap item evaluasi teknis harus paling tidak ada satu detail')
				event.preventDefault();	
				data_child = 'kosong';
				return;			
			}
		});
		//event.preventDefault();
		// cek apakah semua item tech udah ada detailnya
		if (data_child == 'ada') {
			event.preventDefault();
	        swal({
	            title: "Apakah Anda Yakin?",
	            text: "Pastikan Semua Data Yang Anda Masukkan Sudah Benar!",
	            type: "warning",
	            showCancelButton: true,
	            confirmButtonColor: '#92c135',
	            cancelButtonColor: '#d33',
	            confirmButtonText: 'Ya',
	            confirmButtonClass: 'btn btn-success',
	            cancelButtonClass: 'btn btn-danger',
	            cancelButtonText: "Tidak",
	            closeOnConfirm: true,
	            closeOnCancel: true
	        },
	        function(isConfirm) {
	            if (isConfirm) {
	                var form_data = $('.form_valid').serialize();
					console.log(form_data);
					$.ajax({
						url : $('#base-url').val() + 'Procurement_template/create',
						method : 'post',
						data : form_data,
						success : function(result)
						{
							if(result=='OK'){
								swal("Berhasil!", "Tambah data berhasil!", "success");
								window.location = $('#base-url').val() + 'Procurement_template/index';
							}else if(result=='weight_pptu'){
								swal("Error!", "Total bobot Sub Item harus sama dengan Parent Item !!", "error");
							}
						}
					});
	            } else {
	            }
	        })
	    }
	});

	/* Jenis Template */
	$('#evt_type').change(function(){
		switch (Number($('#evt_type').val())) {
			case 1:
				$('#evt_tech_weight').val(100);
				$('#evt_price_weight').val(0);
				$('#evt_tech_weight').prop('readonly',true);
				$('#evt_price_weight').prop('readonly',true);
				break;
			case 3:
				$('#evt_tech_weight').val(0);
				$('#evt_price_weight').val(100);
				$('#evt_tech_weight').prop('readonly',true);
				$('#evt_price_weight').prop('readonly',true);
				break;
			case 2:
				$('#evt_tech_weight').val(50);
				$('#evt_price_weight').val(50);
				$('#evt_tech_weight').prop('readonly',false);
				$('#evt_price_weight').prop('readonly',false);
				break;
			case 4:
				$('#evt_tech_weight').val(100);
				$('#evt_price_weight').val(0);
				$('#evt_tech_weight').prop('readonly',true);
				$('#evt_price_weight').prop('readonly',true);
				break;
			case 5:
				$('#evt_tech_weight').val(100);
				$('#evt_price_weight').val(0);
				$('#evt_tech_weight').prop('readonly',true);
				$('#evt_price_weight').prop('readonly',true);
				break;
		}
	});

	$("#buttonResetItem").click(function() {
		var exceptFirst = 0;
		$("#select_item_det").html('<option value="">- Pilih Item -</option>');
		$("#tableItem").children().each(function() {
			if (exceptFirst == 0) {
				$("#firstRow").show(400);
				exceptFirst = 1;
				return;
			}
			$(this).remove();
		});
		countWeight = 0;
	});

	$("#buttonAddItem").click(function() {
		var Name = $("#ppd_item").val();
		var Weight = $("#ppd_weight").val();
		var evt_Weight = $('#evt_tech_weight').val();
		// numeral.language('id');

		if (Name == "") return;
		$("#firstRow").hide(400);

		if(countWeight + parseInt(Weight) <= evt_Weight) {
			console.log('Create parent item with ID: ' + no);
			if ($('#ppd_mode').is(':checked')) {
				mode=1; //fix
			}else{
				mode=0; //dinamis
			}
			rowTag = '<tr style="vertical-align: top;">' +
						'<td>'+
						'<span>'+Name+'</span>'+
						'<input type="hidden" class="parent_name" name="evt_teknis['+no+'][name]" value="'+Name+'">'+
						'<input type="hidden" class="parent_weight" id="weight_'+no+'" name="evt_teknis['+no+'][weight]" value="'+Weight+'">'+
						'<input type="hidden" class="parent_mode" id="mode_'+no+'" name="evt_teknis['+no+'][mode]" value="'+mode+'">'+
						'<input type="hidden" class="id_parent" value="'+no+'">'+
						'<ul class="listnya col-md-offset-1">'+
							// '<li>'+
							// 	'<span title="Hapus" class="btn btn-sm glyphicon glyphicon-remove" onclick="hapus_detail(this)"></span> '+
							// 	Name+
							// 	'<input type="hidden" name="evt_detail['+no+'][]" value="'+Name+'"> '+
							// '</li>'+
						'</ul>'+
						// '<button type="button" class="col-md-offset-1 btn btn-default btn-sm glyphicon glyphicon-plus" click=""></button>'+
						'</td>' +
						'<td class="bobotnya" style="vertical-align: top;">'+Weight+'</td>' +
						'<td style="vertical-align: top;"><button type="button" title="Hapus" class="btn btn-danger btn-sm glyphicon glyphicon-remove" onclick="hapus(this)"></button></td>'+
					'</tr>'
			$("#tableItem").append(rowTag);
			
			countWeight += parseInt(Weight);

			/* Reset */
			$("#ppd_item").val("");
			$("#ppd_weight").val("");
			$("#ppd_item").focus();

			/* Nambah option */
			$("#select_item_det").append('<option value="'+no+'_'+mode+'">'+Name+'</option>')

			no++;
		} else {
			alert('Bobot melebihi Bobot Teknis');
			$("#ppd_weight").val("");
			$("#ppd_weight").focus();
			console.log("Bobtnya jadi " + (countWeight + parseInt(Weight)))
		}
	});

	$("#buttonAddDetail").click(function() {

		var pptu_weight = $("#pptu_weight").val();
		name = $("#name_item_det").val()
		if (name == "") return;
		var s = $("#select_item_det").val();
    	var fields = s.split('_'); 
    	parent_id = fields[0];
		if (parent_id == '' || parent_id == null){
			alert('Pilih Parent Item.');
			return;
		}

		console.log('Add detail for parent: '+ parent_id)
		parent = null;
		$(".id_parent").each(function() {
			if ($(this).val() == parent_id) {
				parent = $(this);
			}
		});
		console.log('get parent');
		console.log(parent);
		if (parent != null) {
			bobot_parent = $('#weight_'+parent_id).val();
			bobot_child=0;
			$("input[name^='cek_pptu_weight_"+parent_id+"[]']").each(function() {
			    bobot_child=$(this).val();
			});

			if(pptu_weight == '' && fields[1] == 0) { //jika dinamis
				tr = parent.parent();
				listnya = tr.find(".listnya");
				inputnya = '<li>'+
					'<span title="Hapus" class="btn btn-sm glyphicon glyphicon-remove" onclick="hapus_detail(this)"></span> '+
					name+
					'<input type="hidden" name="evt_detail['+parent_id+'][]" value="'+name+'">'+
					'</li>'
				listnya.append(inputnya);
			
			}else{
				if(pptu_weight == ''){
					alert('Bobot sub item tidak boleh kosong');
					$("#pptu_weight").select();
					return false;
				}
				bbt_chld_akumulasi = parseInt(bobot_child) + parseInt(pptu_weight);
				if(parseInt(bobot_parent) >= parseInt(bbt_chld_akumulasi)){
					tr = parent.parent();
					listnya = tr.find(".listnya");
					inputnya = '<li>'+
						'<span title="Hapus" class="btn btn-sm glyphicon glyphicon-remove" onclick="hapus_detail(this)"></span> '+
						name+
						'<input type="hidden" name="evt_detail['+parent_id+'][]" value="'+name+'">'+
						'<input type="hidden" name="cek_pptu_weight_'+parent_id+'[]" value="'+bbt_chld_akumulasi+'">'+
						'<td style="text-align:right; width:100px">&nbsp;&nbsp;&nbsp; Bobot = '+pptu_weight+'</td>'+
						'<input type="hidden" name="pptu_weight['+parent_id+'][]" value="'+pptu_weight+'">'+
						'</li>'
					listnya.append(inputnya);
				}else{
					alert('Bobot sub item melebihi bobot parent item');
					$("#pptu_weight").select();
					console.log("Bobtnya jadi " + (bbt_chld_akumulasi));
					return;
				}
			}
		}
		$("#name_item_det").val("");
		$("#pptu_weight").val("");
		$("#name_item_det").select();
	});

	$("#select_item_det").change(function(){
		var s = $("#select_item_det").val();
    	var fields = s.split('_');

		if (fields[1] == 0) { //dinamis
			$("#name_item_det").val("");
			$("#pptu_weight").val("");
			$("#sub_item_bobot").hide();
		}else{
			$("#sub_item_bobot").show();			
		}
	});

})