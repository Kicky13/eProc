$(document).ready(function(){
	$(window).keydown(function(event){
	    if(event.keyCode == 13) {
	      event.preventDefault();
	      return false;
	    }
	});
	
	var base_url = $('#base-url').val();
	var url = document.location.href.split('/');
	var success = true;

	/* GOOD AND SERVICE DATA */

	/* GOOD BARANG JIKA MATERIAL AMBIL DARI SAP
	$('#submaterial_code').change(function(){
		var material_id = $(".sap_material").serialize();
		$('#submaterial').val($('#submaterial_code option:selected').text());
		$('.new_material').remove();
		$.ajax(
			url : 'do_get_material',
			method : 'post',
			data : material_id,
			success : function(result)
			{
				var material = $.parseJSON(result);
				var mat = material.T_DATA;
				var options1 = '';
				var options2 = '';
				var penampungan='';
				for (var i = 0; i < mat.length; i++) {
					if(i % 2 == 0)
						options1 += '<div class="new_material"><input type="checkbox" name="product_description[]" value="' + mat[i].MATNR + '####' + mat[i].MAKTX + '"> ' + mat[i].MAKTX+'</div>';
					else
						options2 += '<div class="new_material"><input type="checkbox" name="product_description[]" value="' + mat[i].MATNR + '####' + mat[i].MAKTX + '"> ' + mat[i].MAKTX+'</div>';
				}
				$('#product_description_ganjil').append(options1);
				$('#product_description_genap').append(options2);
			}
		})
	});

	$('#submaterial_code').bind('tabsshow', function(event, ui) {
		var material_id = $(".sap_material").serialize();
		$('#submaterial').val($('#submaterial_code option:selected').text());
		$('.new_material').remove();
		$.ajax({
			url : 'do_get_material',
			method : 'post',
			data : material_id,
			success : function(result)
			{
				var material = $.parseJSON(result);
				var mat = material.T_DATA;
				var options1 = '';
				var options2 = '';
				var penampungan='';
				for (var i = 0; i < mat.length; i++) {
					if(i % 2 == 0)
						options1 += '<div class="new_material"><input type="checkbox" name="product_description[]" value="' + mat[i].MATNR + '####' + mat[i].MAKTX + '">' + mat[i].MAKTX+'</div>';
					else
						options2 += '<div class="new_material"><input type="checkbox" name="product_description[]" value="' + mat[i].MATNR + '####' + mat[i].MAKTX + '">' + mat[i].MAKTX+'</div>';
				}
				$('#product_description_ganjil').append(options1);
				$('#product_description_genap').append(options2);
			}
		})
	});


	$('#material_code').change(function(){
		$('#material').val($('#material_code option:selected').text());
	 	id = $('#material_code').val();
        $.ajax({ 
			url:"pilih_child_material",
			method : 'post',
			data : "id="+id,
			dataType : 'JSON',
			success: function(data){
				$("#submaterial_code").select2().empty();
				$.each(data.subgroup,function(key,val){
					$("#submaterial_code").append("<option value="+key+">"+val+"</option>");
				});
				// console.log(data);
				$('.new_material').remove();
				var mat = data.mat;
				mat = mat.T_DATA;
				var options1 = '';
				var options2 = '';
				var penampungan='';
				for (var i = 0; i < mat.length; i++) {
					if(i % 2 == 0)
						options1 += '<div class="new_material"><input type="checkbox" name="product_description[]" value="' + mat[i].MATNR + '####' + mat[i].MAKTX + '">' + mat[i].MAKTX+'</div>';
					else
						options2 += '<div class="new_material"><input type="checkbox" name="product_description[]" value="' + mat[i].MATNR + '####' + mat[i].MAKTX + '">' + mat[i].MAKTX+'</div>';
				}
				$('#product_description_ganjil').append(options1);
				$('#product_description_genap').append(options2);
			}
		});
		return false;
    });*/

    $('#material_code').change(function(){
		$('#material').val($('#material_code option:selected').text()); 
	 	id = $('#material_code').val();
        $.ajax({
			url:"pilih_child_material",
			method : 'post',
			data : "id="+id,
			success: function(data){
				$("#submaterial_code").html(data);
				$('.new_material').remove();
			}
		});
		return false;
    });

    $('#submaterial_code').change(function(){
		var material_id = $(".sap_material").serialize();
		$('#submaterial').val($('#submaterial_code option:selected').text());
		$('.new_material').remove();
		return false;
    });


    $('#material_code_edit').change(function(){
		$('#material_edit').val($('#material_code_edit option:selected').text());
	 	id = $('#material_code_edit').val();
        $.ajax({
			url:"pilih_child_material",
			method : 'post',
			data : "id="+id,
			success: function(data){
				$("#submaterial_code_edit").html(data);
				$('.new_material_edit').remove();
			}
		});
		return false;
    });

    $('#submaterial_code_edit').change(function(){
		var material_id = $(".sap_material").serialize();
		$('#submaterial_edit').val($('#submaterial_code_edit option:selected').text());
		$('.new_material_edit').remove();
		return false;
    });

	// BUAT EDIT BARANG
	/* EDIT GROUP BARANG JIKA MENGAMBIL DATA DARI SAP
	$('#submaterial_code_edit').change(function(){
		var material_id = $(".sap_material_edit").serialize();
		$('#submaterial_edit').val($('#submaterial_code_edit option:selected').text());
		$('.new_material_edit').remove();
		$.ajax({
			url : 'do_get_material',
			method : 'post',
			data : material_id,
			success : function(result)
			{
				var material = $.parseJSON(result);
				var mat = material.T_DATA;
				var options1 = '';
				var options2 = '';
				var penampungan='';
				for (var i = 0; i < mat.length; i++) {
					if(i % 2 == 0)
						options1 += '<div class="new_material_edit"><input type="radio" name="product_description" value="' + mat[i].MATNR + '####' + mat[i].MAKTX + '"> ' + mat[i].MAKTX+'</div>';						
					else
						options2 += '<div class="new_material_edit"><input type="radio" name="product_description" value="' + mat[i].MATNR + '####' + mat[i].MAKTX + '"> ' + mat[i].MAKTX+'</div>';
				}
				$('#product_description_ganjil_edit').append(options1);
				$('#product_description_genap_edit').append(options2);
			}
		})
	});

	$('#submaterial_code_edit').bind('tabsshow', function(event, ui) {
		var material_id = $(".sap_material_edit").serialize();
		$('#submaterial_edit').val($('#submaterial_code_edit option:selected').text());
		$('.new_material_edit').remove();
		$.ajax({
			url : 'do_get_material',
			method : 'post',
			data : material_id,
			success : function(result)
			{
				var material = $.parseJSON(result);
				var mat = material.T_DATA;
				var options1 = '';
				var options2 = '';
				var penampungan='';
				for (var i = 0; i < mat.length; i++) {
					if(i % 2 == 0)
						options1 += '<div class="new_material_edit"><input type="radio" name="product_description" value="' + mat[i].MATNR + '####' + mat[i].MAKTX + '"> ' + mat[i].MAKTX+'</div>';						
					else
						options2 += '<div class="new_material_edit"><input type="radio" name="product_description" value="' + mat[i].MATNR + '####' + mat[i].MAKTX + '"> ' + mat[i].MAKTX+'</div>';
				}
				$('#product_description_ganjil_edit').append(options1);
				$('#product_description_genap_edit').append(options2);
			}
		})
	});*/

	//END
	$('#svc_code').change(function(){
		var material_id = $(".sap_jasa").serialize();
		$('#svc').val($('#svc_code option:selected').text());
		$('.new_service').remove();
		$.ajax({
			url : 'do_get_material',
			method : 'post',
			data : material_id,
			success : function(result)
			{
				var material = $.parseJSON(result);
				var mat = material.T_DATA;
				var options1 = '';
				var options2 = '';
				var penampungan='';
				for (var i = 0; i < mat.length; i++) {
					if(i % 2 == 0)
						options1 += '<div class="new_service"><input type="checkbox" name="product_description_jasa[]" value="' + mat[i].MATNR + '####' + mat[i].MAKTX + '"> ' + mat[i].MAKTX+'</div>';
					else
						options2 += '<div class="new_service"><input type="checkbox" name="product_description_jasa[]" value="' + mat[i].MATNR + '####' + mat[i].MAKTX + '"> ' + mat[i].MAKTX+'</div>';
				}
				$('#jasa_description_ganjil').append(options1);
				$('#jasa_description_genap').append(options2);
			}
		})
	});

	$('#svc_code').bind('tabsshow', function(event, ui) {
		var material_id = $(".sap_jasa").serialize();
		$('#submaterial').val($('#svc_code option:selected').text());
		$('.new_service').remove();
		$.ajax({
			url : 'do_get_material',
			method : 'post',
			data : material_id,
			success : function(result)
			{
				var material = $.parseJSON(result);
				var mat = material.T_DATA;
				var options1 = '';
				var options2 = '';
				var penampungan='';
				for (var i = 0; i < mat.length; i++) {
					if(i % 2 == 0)
						options1 += '<div class="new_service"><input type="checkbox" name="product_description[]" value="' + mat[i].MATNR + '####' + mat[i].MAKTX + '">' + mat[i].MAKTX+'</div>';
					else
						options2 += '<div class="new_service"><input type="checkbox" name="product_description[]" value="' + mat[i].MATNR + '####' + mat[i].MAKTX + '">' + mat[i].MAKTX+'</div>';
				}
				$('#jasa_description_ganjil').append(options1);
				$('#jasa_description_genap').append(options2);
			}
		})
	});
	

	$('#svc_code_edit').change(function(){
		$('#subsvc_code_edit').val('');
		$('#svc_edit').val($('#svc_code_edit option:selected').text());
		$('.new_subsvc_edit').remove();
	});

	$('#svc_code_edit').bind('tabsshow', function(event, ui) {
		$('#subsvc_code_edit').val('');
		$('#svc_edit').val($('#svc_code_edit option:selected').text());
		$('.new_subsvc_edit').remove();
	});

	$('#subsvc_code').change(function(){
		$('#subsvc').val($('#subsvc_code option:selected').text());
	});

	$('#subsvc_code').bind('tabsshow', function(event, ui) {
		$('#subsvc').val($('#subsvc_code option:selected').text());
	});

	$('#svc_code').change(function(){
		$('#subsvc_code').val('');
		$('#svc').val($('#svc_code option:selected').text());
		$('.new_subsvc').remove();
	});

	$('#svc_code').bind('tabsshow', function(event, ui) {
		$('#subsvc_code').val('');
		$('#svc').val($('#svc_code option:selected').text());
		$('.new_subsvc').remove();
	});

	
	$('.insert_support_sdm').bootstrapValidator({
		fields: {
			name: {
				validators: {
					notEmpty: {}
				}
			},
			last_education: {
				validators: {
					notEmpty: {}
				}
			},
			main_skill: {
				validators: {
					notEmpty: {}
				}
			},
			year_exp: {
				validators: {
					notEmpty: {},
					numeric:{}
				}
			},
			emp_status: {
				validators: {
					notEmpty: {}
				}
			},
			emp_type: {
				validators: {
					notEmpty: {}
				}
			}
		}
	}).on('error.form.bv', function(e) {
		success = false;
	}).on('success.form.bv', function(e) {
		success = true;
	});

	$('.insert_main_sdm').bootstrapValidator({
		fields: {
			name: {
				validators: {
					notEmpty: {}
				}
			},
			last_education: {
				validators: {
					notEmpty: {}
				}
			},
			main_skill: {
				validators: {
					notEmpty: {}
				}
			},
			year_exp: {
				validators: {
					notEmpty: {},
					numeric:{}
				}
			},
			emp_status: {
				validators: {
					notEmpty: {}
				}
			},
			emp_type: {
				validators: {
					notEmpty: {}
				}
			}
		}
	}).on('error.form.bv', function(e) {
		success = false;
	}).on('success.form.bv', function(e) {
		success = true;
	});
	// $('.insert_service').bootstrapValidator({
	// 	fields: {
	// 		svc_code: {
	// 			validators: {
	// 				notEmpty: {}
	// 			}
	// 		},
	// 		subsvc_code: {
	// 			validators: {
	// 				notEmpty: {}
	// 			}
	// 		},
	// 		product_description_jasa: {
	// 			validators: {
	// 				notEmpty: {}
	// 			}
	// 		},
	// 		file_upload: {
	// 			//enabled: false,
	// 			validators: {
	// 				notEmpty: {}
	// 			}
	// 		},
	// 		file_upload: {
	// 			validators: {
	// 				notEmpty: {}
	// 			}
	// 		},
	// 		no: {
	// 			validators: {
	// 				notEmpty: {}
	// 			}
	// 		},
	// 		issued_by: {
	// 			validators: {
	// 				notEmpty: {}
	// 			}
	// 		},
	// 		issued_date: {
	// 			trigger: 'change keyup',
	// 			validators: {
	// 				notEmpty: {}
	// 			}
	// 		},
	// 		expired_date: {
	// 			trigger: 'change keyup',
	// 			validators: {
	// 				notEmpty: {}
	// 			}
	// 		},
	// 	}
	// }).on('error.form.bv', function(e) {
	// 	success = false;
	// }).on('success.form.bv', function(e) {
	// 	success = true;
	// });

	$('.insert_good').bootstrapValidator({
		fields: {
			material_code: {
				validators: {
					notEmpty: {}
				}
			},
			product_description: {
				validators: {
					notEmpty: {}
				}
			},
			source: {
				validators: {
					notEmpty: {}
				}
			},
			type: {
				validators: {
					notEmpty: {}
				}
			},
			file_upload: {
				validators: {
					notEmpty: {}
				}
			},

			no: {
				enabled: false,
				validators: {
					notEmpty: {},
				}
			},
			issued_by: {
				enabled: false,
				validators: {
					notEmpty: {}
				}
			},
			issued_date: {
				enabled: false,
				trigger: 'change keyup',
				validators: {
					notEmpty: {}
				}
			},
			expired_date: {
				enabled: false,
				trigger: 'change keyup',
				validators: {
					notEmpty: {}
				}
			},
		}
	}).on('error.form.bv', function(e) {
		success = false;
	}).on('success.form.bv', function(e) {
		success = true;
	});

	$('#submaterial_code_edit').change(function(){
		$('#submaterial_edit').val($('#submaterial_code_edit option:selected').text());
	});

	$('#submaterial_code_edit').bind('tabsshow', function(event, ui) {
			$('#submaterial_edit').val($('#submaterial_code_edit option:selected').text());
	});

	$('#addGoods').click(function(){
		$('.insert_good').bootstrapValidator('validate');
		if (success) {
			var form_data = $('.insert_good').serialize();
			console.log(form_data);
			$.ajax({
				url : 'do_insert_good',
				method : 'post',
				data : form_data,
				success : function(result)
				{ 
					swal("Berhasil!", "Tambah data berhasil!", "success")
					location.reload();
				}
			});
		} 
	});

	$('#addServices').click(function(){
		cek_cons = $("#group_jasa_id").val();
		gagal = false;

		cek = new Array();
		cek = false;
        $.each($("input[name='subKlasifikasi_jasa_id[]']:checked"), function() {
            cek = true;
        });


		if (cek_cons == '1' || cek_cons == '') {
			if(cek == false){
				swal("Error!", "Sub Klasifikasi harus di centang!", "error")
				return;
			}

			$('.insert_service').find('.jasa').each(function() {
					if ($(this).data('uploaded') != true) {
						$(this).css('color','red');
						gagal = true;
					}
			});

			$('.insert_service').bootstrapValidator('validate');
		} else {

			if ($("#subsvc").val() == '') {
				swal("Error!", "Pilih Sub Group Jasa!", "error")
				return false;
			}

			if ($("#klasf").val() == '') {
				swal("Error!", "Pilih Klasifikasi Jasa!", "error")
				return false;
			}
		}


		if (success) {
			if (gagal == true) { 
				swal("Perhatian!", "Wajib mengunggah dokumen!", "warning")
				return false;
			}
			var form_data = $('.insert_service').serialize();
			console.log(form_data);

			// alert('stop'); return false;
			$.ajax({
				url : 'do_insert_service',
				method : 'post',
				data : form_data,
				success : function(result)
				{
					if(result=='OK'){
						swal("Berhasil!", "Tambah data berhasil!", "success")
						location.reload();
					}else{
						swal("Error!", "Gagal !!", "error")
						location.reload();
					}
				}
			})
		}
	});

	$('#save_good_and_service').click(function(){

		swal("Berhasil!", "Simpan data berhasil!", "success")
		window.location.href = "Vendor_update_profile";
	});

	$('.update_vendor_product').click(function(){
		$('.new_material_edit').remove();
		var good_id = $(this).closest('tr').attr('id');
		parent = $(this).parent().parent();
		$('#good_id').val(good_id);
		var base_url = $('#base-url').val();
		var expired_date = $(this).parent().parent().find('.expired_date').html();
		var issued_date = $(this).parent().parent().find('.issued_date').html();
		$.ajax({
			url:base_url+'Vendor_update_profile/get_product_edit',
			dataType: "json",
			type:"post",
			data:{"product_id":good_id},
			success:function(data){
				$.each(data, function(i,product){
					var mat_code = product.PRODUCT_CODE;					

					$('#material_code_edit').val(product.PRODUCT_CODE);
					$('#material_edit').val(product.PRODUCT_NAME);
					$.ajax({
						url:"pilih_child_material",
						method : 'post',
						data : "id="+mat_code,
						success: function(data){
							$("#submaterial_code_edit").html(data);
							$('#submaterial_code_edit').val(product.PRODUCT_SUBGROUP_CODE);
							$('#submaterial_edit').val(product.PRODUCT_SUBGROUP_NAME);
							$('#product_description_edit').val(product.PRODUCT_DESCRIPTION);

						/* ajax untuk mengabil nilai dari SAP
							$.ajax({
								url : 'do_get_material',
								method : 'post',
								data : {'material_code':product.PRODUCT_CODE,'submaterial_code':product.PRODUCT_SUBGROUP_CODE},
								success : function(result)
								{
									var material = $.parseJSON(result);
									var mat = material.T_DATA;
									var options1 = '';
									var options2 = '';
									var penampungan='';
									for (var i = 0; i < mat.length; i++) {
										if(i % 2 == 0)
											if(mat[i].MATNR == product.PRODUCT_DESCRIPTION_CODE){
												options1 += '<div class="new_material_edit"><input type="radio" checked name="product_description" value="' + mat[i].MATNR + '####' + mat[i].MAKTX + '"> ' + mat[i].MAKTX+'</div>';
											} else {
												options1 += '<div class="new_material_edit"><input type="radio" name="product_description" value="' + mat[i].MATNR + '####' + mat[i].MAKTX + '"> ' + mat[i].MAKTX+'</div>';
											}
										else
											if(mat[i].MATNR == product.PRODUCT_DESCRIPTION_CODE){
												options2 += '<div class="new_material_edit"><input type="radio" checked name="product_description" value="' + mat[i].MATNR + '####' + mat[i].MAKTX + '"> ' + mat[i].MAKTX+'</div>';
											} else {
												options2 += '<div class="new_material_edit"><input type="radio" name="product_description" value="' + mat[i].MATNR + '####' + mat[i].MAKTX + '"> ' + mat[i].MAKTX+'</div>';
											}
									}
									$('#product_description_ganjil_edit').append(options1);
									$('#product_description_genap_edit').append(options2);
								}
							}); // ajax do_get_material */
						} 
					}); //ajax pilih_child_material

					$('#brand_edit').val(product.BRAND);
					$('#source_edit').val(product.SOURCE);
					$('#type_edit').val(product.TYPE);
					$('#no_edit').val(product.NO);
					$('#issued_by_edit').val(product.ISSUED_BY);
					$('#issued_date_edit').val(issued_date);
					$('#expired_date_edit').val(expired_date);
					$('.uploadAttachment').show();
			        if(product.FILE_UPLOAD != null){
			        	$('.uploadAttachment').hide();
			        }
			        $('#file_upload_lama_ba').val(product.FILE_UPLOAD);
			        $('#fil_barang_edit').val('');
			        setTimeout(function(){$(".select3").select2();}, 1000);
				});
			}
		});

		$('#updateGoodModal').modal();

		type = $('#type_edit').val();
		form = $('#type_edit').closest('form');
		if(type == 'Agent' || type == 'Distributor' || type == 'Sole Agent' || type == 'Supporting Letter'){
			form.find('.mandatory_barang_edit').each(function(index, val) {
				console.log($(this).has('span').length == 0);
				if($(this).has('span').length == 0){
					$(this).append('<span style="color: #E74C3C">*</span>');
				} else {
				}
			});
			var bootstrapValidator = $('.current_edited_good').data('bootstrapValidator');
			bootstrapValidator.enableFieldValidators('no');
			bootstrapValidator.enableFieldValidators('issued_by');
			bootstrapValidator.enableFieldValidators('issued_date');
			bootstrapValidator.enableFieldValidators('expired_date');
		} else {
			form.find('.mandatory_barang_edit').each(function(index, val) {
				console.log($(this).has('span').length == 0);
				if($(this).has('span').length == 0){
				} else {
					$(this).find('span').remove();
				}
			});
			var bootstrapValidator = $('.current_edited_good').data('bootstrapValidator');
			bootstrapValidator.enableFieldValidators('no',false);
			bootstrapValidator.enableFieldValidators('issued_by',false);
			bootstrapValidator.enableFieldValidators('issued_date',false);
			bootstrapValidator.enableFieldValidators('expired_date',false);
		}
	}); // end update barang

	if($('#type_barang').length){
		type = $('#type_barang').val();
		form = $('#type_barang').closest('form');
		if(type == 'Agent' || type == 'Distributor' || type == 'Sole Agent' || type == 'Supporting Letter'){
			// console.log(form.find('mandatory_barang').html());
			form.find('.mandatory_barang').each(function(index, val) {
				console.log($(this).has('span').length == 0);
				if($(this).has('span').length == 0){
					$(this).append('<span style="color: #E74C3C">*</span>');
				} else {
				}
			});
			var bootstrapValidator = $('.insert_good').data('bootstrapValidator');
			bootstrapValidator.enableFieldValidators('no');
			bootstrapValidator.enableFieldValidators('issued_by');
			bootstrapValidator.enableFieldValidators('issued_date');
			bootstrapValidator.enableFieldValidators('expired_date');
		} else {
			form.find('.mandatory_barang').each(function(index, val) {
				console.log($(this).has('span').length == 0);
				if($(this).has('span').length == 0){
				} else {
					$(this).find('span').remove();
				}
			});
			var bootstrapValidator = $('.insert_good').data('bootstrapValidator');
			bootstrapValidator.enableFieldValidators('no',false);
			bootstrapValidator.enableFieldValidators('issued_by',false);
			bootstrapValidator.enableFieldValidators('issued_date',false);
			bootstrapValidator.enableFieldValidators('expired_date',false);
		}
	}

	$('#type_barang').change(function(){
		type = $(this).val();
		form = $(this).closest('form');
		if(type == 'Agent' || type == 'Distributor' || type == 'Sole Agent' || type == 'Supporting Letter'){
			form.find('.mandatory_barang').each(function(index, val) {
				console.log($(this).has('span').length == 0);
				if($(this).has('span').length == 0){
					$(this).append('<span style="color: #E74C3C">*</span>');
				} else {
				}
			});
			var bootstrapValidator = $('.insert_good').data('bootstrapValidator');
			bootstrapValidator.enableFieldValidators('no');
			bootstrapValidator.enableFieldValidators('issued_by');
			bootstrapValidator.enableFieldValidators('issued_date');
			bootstrapValidator.enableFieldValidators('expired_date');
		} else {
			form.find('.mandatory_barang').each(function(index, val) {
				console.log($(this).has('span').length == 0);
				if($(this).has('span').length == 0){
				} else {
					$(this).find('span').remove();
				}
			});
			var bootstrapValidator = $('.insert_good').data('bootstrapValidator');
			bootstrapValidator.enableFieldValidators('no',false);
			bootstrapValidator.enableFieldValidators('issued_by',false);
			bootstrapValidator.enableFieldValidators('issued_date',false);
			bootstrapValidator.enableFieldValidators('expired_date',false);
		}
	})

	$('#type_barang').bind('tabsshow', function(event, ui) {
			type = $(this).val();
			form = $(this).closest('form');
			if(type == 'Agent' || type == 'Distributor' || type == 'Sole Agent' || type == 'Supporting Letter'){
				form.find('.mandatory_barang').each(function(index, val) {
					console.log($(this).has('span').length == 0);
					if($(this).has('span').length == 0){
						$(this).append('<span style="color: #E74C3C">*</span>');
					} else {
					}
				});
				var bootstrapValidator = $('.insert_good').data('bootstrapValidator');
				bootstrapValidator.enableFieldValidators('no');
				bootstrapValidator.enableFieldValidators('issued_by');
				bootstrapValidator.enableFieldValidators('issued_date');
				bootstrapValidator.enableFieldValidators('expired_date');
			} else {
				form.find('.mandatory_barang').each(function(index, val) {
					console.log($(this).has('span').length == 0);
					if($(this).has('span').length == 0){
					} else {
						$(this).find('span').remove();
					}
				});
				var bootstrapValidator = $('.insert_good').data('bootstrapValidator');
				bootstrapValidator.enableFieldValidators('no',false);
				bootstrapValidator.enableFieldValidators('issued_by',false);
				bootstrapValidator.enableFieldValidators('issued_date',false);
				bootstrapValidator.enableFieldValidators('expired_date',false);
			}
	})

	$('#type_edit').change(function(){
		type = $(this).val();
		form = $(this).closest('form');
		if(type == 'Agent' || type == 'Distributor' || type == 'Sole Agent' || type == 'Supporting Letter'){
			form.find('.mandatory_barang_edit').each(function(index, val) {
				console.log($(this).has('span').length == 0);
				if($(this).has('span').length == 0){
					$(this).append('<span style="color: #E74C3C">*</span>');
				} else {
				}
			});
			var bootstrapValidator = $('.current_edited_good').data('bootstrapValidator');
			bootstrapValidator.enableFieldValidators('no');
			bootstrapValidator.enableFieldValidators('issued_by');
			bootstrapValidator.enableFieldValidators('issued_date');
			bootstrapValidator.enableFieldValidators('expired_date');
		} else {
			form.find('.mandatory_barang_edit').each(function(index, val) {
				console.log($(this).has('span').length == 0);
				if($(this).has('span').length == 0){
				} else {
					$(this).find('span').remove();
				}
			});
			var bootstrapValidator = $('.current_edited_good').data('bootstrapValidator');
			bootstrapValidator.enableFieldValidators('no',false);
			bootstrapValidator.enableFieldValidators('issued_by',false);
			bootstrapValidator.enableFieldValidators('issued_date',false);
			bootstrapValidator.enableFieldValidators('expired_date',false);
		}
	})

	$('#type_edit').bind('tabsshow', function(event, ui) {
			type = $(this).val();
			form = $(this).closest('form');
			if(type == 'Agent' || type == 'Distributor' || type == 'Sole Agent' || type == 'Supporting Letter'){
				form.find('.mandatory_barang_edit').each(function(index, val) {
					console.log($(this).has('span').length == 0);
					if($(this).has('span').length == 0){
						$(this).append('<span style="color: #E74C3C">*</span>');
					} else {
					}
				});
				var bootstrapValidator = $('.current_edited_good').data('bootstrapValidator');
				bootstrapValidator.enableFieldValidators('no');
				bootstrapValidator.enableFieldValidators('issued_by');
				bootstrapValidator.enableFieldValidators('issued_date');
				bootstrapValidator.enableFieldValidators('expired_date');
			} else {
				form.find('.mandatory_barang_edit').each(function(index, val) {
					console.log($(this).has('span').length == 0);
					if($(this).has('span').length == 0){
					} else {
						$(this).find('span').remove();
					}
				});
				var bootstrapValidator = $('.current_edited_good').data('bootstrapValidator');
				bootstrapValidator.enableFieldValidators('no',false);
				bootstrapValidator.enableFieldValidators('issued_by',false);
				bootstrapValidator.enableFieldValidators('issued_date',false);
				bootstrapValidator.enableFieldValidators('expired_date',false);
			}
	})

	$('.update_vendor_service').click(function(){
		var service_id = $(this).closest('tr').attr('id');
		parent = $(this).parent().parent();
		$('#service_id').val(service_id);
		var base_url = $('#base-url').val();
		$.ajax({
			url:base_url+'Vendor_update_profile/get_product_edit',
			dataType: "json",
			type:"post",
			data:{"product_id":service_id},
			success:function(data){
				$.each(data, function(i,product){

					var svc_id = product.PRODUCT_CODE;					
					$('#group_jasa_id_edit').val(product.PRODUCT_CODE);
					$('#svc_edit').val(product.PRODUCT_NAME);
					$.ajax({
						url:"pilih_child",
						method : 'post',
						data : "id="+svc_id,
						success: function(data){
							$("#subGroup_jasa_id_edit").html(data);
							$('#subGroup_jasa_id_edit').val(product.PRODUCT_SUBGROUP_CODE);
							$('#subsvc_edit').val(product.PRODUCT_SUBGROUP_NAME);

							$.ajax({
								url:"pilih_child",
								method : 'post',
								data : "id="+product.PRODUCT_SUBGROUP_CODE,
								success: function(data){
									$("#klasifikasi_jasa_id_edit").html(data);
									$('#klasifikasi_jasa_id_edit').val(product.KLASIFIKASI_ID);
									$('#klasf_edit').val(product.KLASIFIKASI_NAME);
									if (product.SUBKLASIFIKASI_NAME != null) {
										arrSubKlasifikasi = product.SUBKLASIFIKASI_NAME.split(',');
									}

									$('.new_data_edit').remove();
									$.ajax({
										url : 'pilih_sub_klasifikasi',
										method : 'post',
										data : "id="+product.KLASIFIKASI_ID,
										success : function(result)
										{
											var val = $.parseJSON(result);
											var options1 = '';
											if(val != null){
												for (var i = 0; i < val.length; i++) {
													description = '';
													if(val[i].DESCRIPTION != null){
														description = ' - ' + val[i].DESCRIPTION;
													}

													check = '';
													for(r = 0; r < arrSubKlasifikasi.length; r++) {
														if(val[i].NAMA == arrSubKlasifikasi[r]){
															check = 'checked';
														}
													}

													options1 += '<div class="new_data_edit"><input type="checkbox" '+check+' name="subKlasifikasi_jasa_id[]" value="' + val[i].ID + '"><font size="2">&nbsp;' + val[i].NAMA + description +'<font/></div>';
												}
												$('#subKlasifikasi_edit').append(options1);
											
											}else{
												$('#subKlasifikasi_edit').append('<div class="new_data_edit"> Data Kosong. </div>');
											}
										}
									});

								},
							});

						},
					});
					
					$('#kualifikasi_jasa_id_edit').val(product.KUALIFIKASI_ID);
					$('#kualifi_edit').val(product.KUALIFIKASI_NAME);
			        $.ajax({
						url:"pilih_child_kualifikasi",
						method : 'post',
						data : "id="+product.KUALIFIKASI_ID,
						success: function(data){
							$("#subKualifikasi_jasa_id_edit").html(data);
							$('#subKualifikasi_jasa_id_edit').val(product.SUBKUALIFIKASI_ID);
							$('#subKualifi_edit').val(product.SUBKUALIFIKASI_NAME);
						}
					});
					
					$('.uploadAttachment').show();
			        if(product.FILE_UPLOAD != null){
			        	$('.uploadAttachment').hide();
			        }
			        $('#file_upload_lama_ja').val(product.FILE_UPLOAD);
			        $('.file_jasa').val('');
					$('#no_jasa_edit').val(product.NO);
					$('#issued_by_jasa_edit').val(product.ISSUED_BY);
					$('#issued_date_jasa_edit').val(parent.find('.f_issued_date').html());
					$('#expired_date_jasa_edit').val(parent.find('.f_expired_date').html());
					setTimeout(function(){$(".select3").select2();}, 1000);
				});
			}
		});

		$('#updateServiceModal').modal();

	});

	$('.insert_bahan').bootstrapValidator({
		fields: {
			material_code_bahan: {
				validators: {
					notEmpty: {}
				}
			},
			bahan_description: {
				validators: {
					notEmpty: {}
				}
			},
			bahan_source: {
				validators: {
					notEmpty: {}
				}
			},
			type_bahan: {
				validators: {
					notEmpty: {}
				}
			},
			type_dokumen: {
				validators: {
					notEmpty: {}
				}
			},
			no_dokumen: {
				enabled: false,
				validators: {
					notEmpty: {},
				}
			},
			issued_by_bahan: {
				enabled: false,
				validators: {
					notEmpty: {}
				}
			},
			issued_date_bahan: {
				enabled: false,
				trigger: 'change keyup',
				validators: {
					notEmpty: {}
				}
			},
			expired_date_bahan: {
				enabled: false,
				trigger: 'change keyup',
				validators: {
					notEmpty: {}
				}
			},
		}
	}).on('error.form.bv', function(e) {
		success = false;
	}).on('success.form.bv', function(e) {
		success = true;
	});

	$('#material_code_bahan').change(function(){
		$('#material_bahan').val($('#material_code_bahan option:selected').text()); 
	 	id = $('#material_code_bahan').val();
        $.ajax({
			url:"pilih_child_material",
			method : 'post',
			data : "id="+id,
			success: function(data){
				$("#submaterial_code_bahan").html(data);
				$('.new_material').remove();
			}
		});
		return false;
    });

    $('#submaterial_code_bahan').change(function(){
		var material_id = $(".sap_material").serialize();
		$('#submaterial_bahan').val($('#submaterial_code_bahan option:selected').text());
		$('.new_material').remove();
		return false;
    });
	
	$('#addBahan').click(function(){
		$('.insert_bahan').bootstrapValidator('validate');
		if (success) {
			var form_data = $('.insert_bahan').serialize();
			console.log(form_data);
			$.ajax({
				url : 'do_insert_bahan',
				method : 'post',
				data : form_data,
				success : function(result)
				{
					if(result=='OK'){
						swal("Berhasil!", "Ubah data berhasil!", "success")
						location.reload();
					}else{
						swal("Error!", "Gagal updating data barang.", "error") 
					}
				}
			});
		} 
	});

	$('.update_bahan').click(function(){
		$('.new_material_edit').remove();
		var bahan_id = $(this).closest('tr').attr('id');
		parent = $(this).parent().parent();
		$('#bahan_id').val(bahan_id);
		var base_url = $('#base-url').val();
		var expired_date = $(this).parent().parent().find('.expired_date_bahan').html();
		var issued_date = $(this).parent().parent().find('.issued_date_bahan').html();
		$.ajax({
			url:base_url+'Vendor_update_profile/get_product_edit',
			dataType: "json",
			type:"post",
			data:{"product_id":bahan_id},
			success:function(data){
				$.each(data, function(i,product){
					var mat_code = product.PRODUCT_CODE;				

					$('#material_code_edit_bahan').val(product.PRODUCT_CODE);
					$('#material_edit_bahan').val(product.PRODUCT_NAME);
					$.ajax({
						url:"pilih_child_material",
						method : 'post',
						data : "id="+mat_code,
						success: function(data){
							$("#submaterial_code_edit_bahan").html(data);
							$('#submaterial_code_edit_bahan').val(product.PRODUCT_SUBGROUP_CODE);
							$('#submaterial_edit_bahan').val(product.PRODUCT_SUBGROUP_NAME);
							$('#product_description_edit_bahan').val(product.PRODUCT_DESCRIPTION);
						
						} 
					});

					$('#type_dokumen_edit').val(product.KLASIFIKASI_NAME);
					$('#source_edit_bahan').val(product.SOURCE);
					$('#type_bahan_edit').val(product.TYPE);
					$('#no_edit_bahan').val(product.NO);
					$('#issued_by_edit_bahan').val(product.ISSUED_BY);
					$('#issued_date_edit_bahan').val(issued_date);
					$('#expired_date_edit_bahan').val(expired_date);
					$('.uploadAttachment').show();
			        if(product.FILE_UPLOAD != null){
			        	$('.uploadAttachment').hide();
			        }
			        $('#file_upload_lama_ba_bahan').val(product.FILE_UPLOAD);
			        $('#fil_barang_edit').val('');
			        setTimeout(function(){$(".select3").select2();}, 1000);
				});
			}
		});
		$('#updateBahanModal').modal();
	});

	$('.current_edited_bahan').bootstrapValidator({
		fields: {
			material_code_edit_bahan: {
				validators: {
					notEmpty: {}
				}
			},
			product_description_edit_bahan: {
				validators: {
					notEmpty: {}
				}
			},
			source_edit_bahan: {
				validators: {
					notEmpty: {}
				}
			},
			type_bahan_edit: {
				validators: {
					notEmpty: {}
				}
			},
			type_dokumen_edit: {
				validators: {
					notEmpty: {}
				}
			},
			no_edit_bahan: {
				enabled: false,
				validators: {
					notEmpty: {},
				}
			},
			issued_by_edit_bahan: {
				enabled: false,
				validators: {
					notEmpty: {}
				}
			},
			issued_date_edit_bahan: {
				enabled: false,
				trigger: 'change keyup',
				validators: {
					notEmpty: {}
				}
			},
			expired_date_edit_bahan: {
				enabled: false,
				trigger: 'change keyup',
				validators: {
					notEmpty: {}
				}
			},
		}
	}).on('error.form.bv', function(e) {
		success = false;
	}).on('success.form.bv', function(e) {
		success = true;
	});

	$('#material_code_edit_bahan').change(function(){
		$('#material_edit_bahan').val($('#material_code_edit_bahan option:selected').text());
	 	id = $('#material_code_edit_bahan').val();
        $.ajax({
			url:"pilih_child_material",
			method : 'post',
			data : "id="+id,
			success: function(data){
				$("#submaterial_code_edit").html(data);
				$('.new_material_edit').remove();
			}
		});
		return false;
    });

	$('#update_edit_bahan').click(function(){
		$('.current_edited_bahan').bootstrapValidator('validate');
		if (success) {
			var form_data = $('.current_edited_bahan').serialize();
			console.log(form_data);
			$.ajax({
				url : 'do_update_bahan',
				method : 'post',
				data : form_data,
				success : function(result)
				{
					if(result=='OK'){
						swal("Berhasil!", "Ubah data berhasil!", "success")
						location.reload();
					}else{
						swal("Error!", "Gagal updating data barang.", "error") 
					}
				}
			});
		} 
	});

	/* SDM */

	$('#addMainSDM').click(function(){
		$('.insert_main_sdm').bootstrapValidator('validate');
		if(success){
			console.log(form_data);
			var form_data = $('.insert_main_sdm').serialize();
			$.ajax({
				url : 'do_insert_main_sdm',
				method : 'post',
				data : form_data,
				success : function(result)
				{
					// alert("Success Inserting Data!");
					swal("Berhasil!", "Tambah data berhasil!", "success")
					location.reload();
				}
			})  
		}
	});

	$('#addSupportSDM').click(function(){
		$('.insert_support_sdm').bootstrapValidator('validate');
		if(success){
			console.log(form_data);
			var form_data = $('.insert_support_sdm').serialize();
			$.ajax({
				url : 'do_insert_support_sdm',
				method : 'post',
				data : form_data,
				success : function(result)
				{
					// alert("Success Inserting Data!");
					swal("Berhasil!", "Tambah data berhasil!", "success")
					location.reload();
				}
			})  
		}
	});

	$('#save_sdm').click(function(){
		swal("Berhasil!", "Simpan data berhasil!", "success")
		window.location.href = "Vendor_update_profile";
	});

	$('#save_certifications').click(function(){
		swal("Berhasil!", "Simpan data berhasil!", "success")
		window.location.href = "Vendor_update_profile";
	});

	$('.update_main_sdm').click(function(){
		var sdm_id = $(this).closest('tr').attr('id');
		$('#sdm_id_main').val(sdm_id);
		parent = $(this).parent().parent();
		var base_url = $('#base-url').val();
		$('#name_edit').val(parent.find('.name_utama').html());
		$('#last_education_edit').val(parent.find('.last_education_utama').html());
		$('#main_skill_edit').val(parent.find('.main_skill_utama').html());
		$('#year_exp_edit').val(parent.find('.year_exp_utama').html());
		$('#emp_status_edit').val(parent.find('.emp_status_utama').html());
		$('#emp_type_edit').val(parent.find('.emp_type_utama').html());

		$('#updateTenagaUtamaModal').modal();
	});

	$('.update_support_sdm').click(function(){
		var sdm_id = $(this).closest('tr').attr('id');
		parent = $(this).parent().parent();
		$('#sdm_id_support').val(sdm_id);
		var base_url = $('#base-url').val();
		$('#name_edit_pendukung').val(parent.find('.name_pendukung').html());
		$('#last_education_edit_pendukung').val(parent.find('.last_education_pendukung').html());
		$('#main_skill_edit_pendukung').val(parent.find('.main_skill_pendukung').html());
		$('#year_exp_edit_pendukung').val(parent.find('.year_exp_pendukung').html());
		$('#emp_status_edit_pendukung').val(parent.find('.emp_status_pendukung').html());
		$('#emp_type_edit_pendukung').val(parent.find('.emp_type_pendukung').html());
		$('#updateTenagaPendukungModal').modal();
	});

	/* CERTIFICATION DATA */
	$('.current_edited_certificate').bootstrapValidator({
		fields: {
			cert_name: {
				validators: {
					notEmpty: {}
				}
			},
			cert_no: {
				validators: {
					notEmpty: {}
				}
			},
			issued_by: {
				validators: {
					notEmpty: {}
				}
			},
			valid_from:{
				trigger: 'change keyup',
				validators:{
					notEmpty:{}
				}
			},
			valid_to:{
				trigger: 'change keyup',
				validators:{
					notEmpty:{}
				}
			},

		}
	}).on('error.form.bv', function(e) {
		success = false;
	}).on('success.form.bv', function(e) {
		success = true;
	});

	$('#update_certification_data_button').click(function(){
			$('.current_edited_certificate').bootstrapValidator('validate');
			if (success) {
				var form_data = $('.current_edited_certificate').serialize();
				$.ajax({
					url : 'do_update_certifications',
					method : 'post',
					data : form_data,
					success : function(result)
					{
						// alert("Success Updating Data!");
						swal("Berhasil!", "Ubah data berhasil!", "success")
						location.reload();
					}
				})
			};
			success = true;
		});

	if ((url[url.length-1].toLowerCase() == "certification_data") || (url[url.length-1].toLowerCase() == "facility_and_equipment") || (url[url.length-1].toLowerCase() == "company_experience")) {
		$('.insert_certifications').bootstrapValidator({
			fields: {
				cert_name: {
					validators: {
						notEmpty: {}
					}
				},
				cert_no: {
					validators: {
						notEmpty: {}
					}
				},
				issued_by: {
					validators: {
						notEmpty: {}
					}
				},
				valid_from:{
					trigger: 'change keyup',
					validators:{
						notEmpty:{}
					}
				},
				valid_to:{
					trigger: 'change keyup',
					validators:{
						notEmpty:{}
					}
				},

			}
		}).on('error.form.bv', function(e) {
			success = false;
		}).on('success.form.bv', function(e) {
			success = true;
		});


		$('#addCertifications').click(function(){
			$('.insert_certifications').bootstrapValidator('validate');
			if (success) {
				var form_data = $('.insert_certifications').serialize();
				$.ajax({
					url : 'do_insert_certifications',
					method : 'post',
					data : form_data,
					success : function(result)
					{
						// alert("Success Inserting Data!");
						swal("Berhasil!", "Tambah data berhasil!", "success")
						location.reload();
					}
				})
			};
			success = true;
		});

		
		$('.current_edited_facility').bootstrapValidator({
			excluded: ':disabled',
			fields: {
				equip_name: {
					validators: {
						trigger: 'load',
						notEmpty: {}
					}
				},
				spec: {
					validators: {
						notEmpty: {}
					}
				},
				quantity: {
					validators: {
						notEmpty: {},
						numeric:{}
					}
				},
				year_made: {
					trigger: 'change keyup',
					validators: {
						notEmpty: {}
					}
				}
			}
		}).on('error.form.bv', function(e) {
			success = false;
		}).on('success.form.bv', function(e) {
			success = true;
		});

		$('#updateeEquipmentModal').on('hidden.bs.modal', function () {
			$('.current_edited_facility').bootstrapValidator('resetForm', true);
		});

		$('#update_equip_data_button').click(function(){		
			$('.current_edited_facility').bootstrapValidator('validate');
			if (success) {
				var form_data = $('.current_edited_facility').serialize();
				$.ajax({
					url : 'do_update_equipments',
					method : 'post',
					data : form_data,
					success : function(result)
					{
						// alert("Success Updating Data!");
						swal("Berhasil!", "Ubah data berhasil!", "success")
						location.reload();
					}
				})
			};
			success = true;
		});

		/* FACILITY AND EQUIPMENT */
		$('.insert_equipments').bootstrapValidator({
			fields: {
				equip_name: {
					validators: {
						notEmpty: {}
					}
				},
				spec: {
					validators: {
						notEmpty: {}
					}
				},
				quantity: {
					validators: {
						notEmpty: {},
						numeric:{}
					}
				},
				year_made: {
					trigger: 'change keyup',
					validators: {
						notEmpty: {}
					}
				}
			}
		}).on('error.form.bv', function(e) {
			success = false;
		}).on('success.form.bv', function(e) {
			success = true;
		});

		$('#addEquipments').click(function(){
			$('.insert_equipments').bootstrapValidator('validate');
			if (success) {
				var form_data = $('.insert_equipments').serialize();
				$.ajax({
					url : 'do_insert_equipments',
					method : 'post',
					data : form_data,
					success : function(result)
					{ 
						swal("Berhasil!", "Tambah data berhasil!", "success")
						location.reload();
					}
				})
			};
			success = true;
		});

		$('#save_equipments').click(function(){
			swal("Berhasil!", "Simpan data berhasil!", "success")
			window.location.href = "Vendor_update_profile";
		});

		/* COMPANY EXPERIENCE */

		$('.insert_experiences').bootstrapValidator({
			fields: {
				client_name: {
					validators: {
						notEmpty: {}
					}
				},
				project_name: {
					validators: {
						notEmpty: {}
					}
				},
				description: {
					validators: {
						notEmpty: {}
					}
				},
				contract_no: {
					validators: {
						notEmpty: {}
					}
				},
				start_date: {
					trigger: 'change keyup',
					validators: {
						notEmpty: {}
					}
				},
				end_date: {
					trigger: 'change keyup',
					validators: {
						notEmpty: {}
					}
				},
				contact_person: {
					validators: {
						notEmpty: {}
					}
				},
				contact_no: {
					validators: {
						notEmpty: {}
					}
				}
			}
		}).on('error.form.bv', function(e) {
			success = false;
		}).on('success.form.bv', function(e) {
			success = true;
		});

		$('#addExperiences').click(function(){
			$('.insert_experiences').bootstrapValidator('validate');
			if (success) {
				var form_data = $('.insert_experiences').serialize();
				$.ajax({
					url : 'do_insert_experiences',
					method : 'post',
					data : form_data,
					success : function(result)
					{
						// alert("Success Inserting Data!");
						swal("Berhasil!", "Tambah data berhasil!", "success")
						location.reload();
					}
				})
			};
			success = true;
		});

		$('#save_experiences').click(function(){
			swal("Berhasil!", "Simpan data berhasil!", "success")
			window.location.href = "Vendor_update_profile";
		});
	};

	$('#type_edit_certificate').change(function(){
		$('#type_other_edit_certificate').val(null);
		if($(this).val() == '6'){
			$('#type_other_edit_certificate').prop('disabled',false);
		} else{
			$('#type_other_edit_certificate').prop('disabled',true);
		}
	})

	$('#type_edit_certificate').bind('tabsshow', function(event, ui) {
			$('#type_other_edit_certificate').val(null);
			if($(this).val() == '6'){
				$('#type_other_edit_certificate').prop('disabled',false);
			} else{
				$('#type_other_edit_certificate').prop('disabled',true);
			}
		
	})

	$('#type_certificate').change(function(){
		$('#type_other_certificate').val(null);
		if($(this).val() == '6'){
			$('#type_other_certificate').prop('disabled',false);
		} else{
			$('#type_other_certificate').prop('disabled',true);
		}
	})

	$('#type_certificate').bind('tabsshow', function(event, ui) {
			$('#type_other_certificate').val(null);
			if($(this).val() == '6'){
				$('#type_other_certificate').prop('disabled',false);
			} else{
				$('#type_other_certificate').prop('disabled',true);
			}
		
	})

	$('.update_vendor_certifications').click(function(){
		var cert_id = $(this).closest('tr').attr('id');
		$('#cert_id').val(cert_id);
		parent = $(this).parent().parent();
		var base_url = $('#base-url').val();
		$.ajax({
			url:base_url+'Vendor_update_profile/get_certification_edit',
			dataType: "json",
			type:"post",
			data:{"cert_id":cert_id},
			success:function(data){
				$.each(data, function(i,certification){
					$('#type_edit_certificate').val(certification.TYPE);
					$('#type_other_edit_certificate').val(certification.TYPE_OTHER);
					$('#cert_name_edit').val(certification.CERT_NAME);
					$('#cert_no_edit').val(certification.CERT_NO);
					$('#issued_by_edit').val(certification.ISSUED_BY);
					$('#valid_from_edit').val(parent.find('.f_valid_from').html());
					$('#valid_to_edit').val(parent.find('.f_valid_to').html());
					if($('#type_edit_certificate').val() == '6'){
						$('#type_other_edit_certificate').prop('disabled',false);
					} else{
						$('#type_other_edit_certificate').prop('disabled',true);
						$('#type_other_edit_certificate').val(null);
					}
				});
			}
		});

		$('#updateCertificationModal').modal();
	});

	
	/* FACILITY AND EQUIPMENT */
	$('.update_vendor_equipments').click(function(){
		var equip_id = $(this).closest('tr').attr('id');
		$('#equip_id').val(equip_id);
		parent = $(this).parent().parent();
		var base_url = $('#base-url').val();

		$('#category_edit_peralatan').val(parent.find('.category_code_peralatan').html());
		$('#equip_name_edit_peralatan').val(parent.find('.equp_name_peralatan').html());
		$('#spec_edit_peralatan').val(parent.find('.spec_peralatan').html());
		$('#quantity_edit_peralatan').val(parent.find('.quantity_peralatan').html());
		$('#year_made_edit_peralatan').val(parent.find('.year_made_peralatan').html());

		$('#updateeEquipmentModal').modal();
	});

	$('.update_vendor_experiences').click(function(){
		var cv_id = $(this).closest('tr').attr('id');
		parent = $(this).parent().parent();
		$('#cv_id').val(cv_id);
		var base_url = $('#base-url').val();
		$('#client_name_edit').val(parent.find('.f_client_name').html());
		$('#project_name_edit').val(parent.find('.f_project_name').html());
		$('#description_edit').val(parent.find('.f_description').html());
		$('#currency_edit').val(parent.find('.f_currency').html());
		$('#amount_edit').val(parent.find('.f_amount').html());
		$('#contract_no_edit').val(parent.find('.f_contract_no').html());
		$('#start_date_edit').val(parent.find('.f_start_date').html());
		$('#end_date_edit').val(parent.find('.f_end_date').html());
		$('#contact_person_edit').val(parent.find('.f_contact_person').html());
		$('#contact_no_edit').val(parent.find('.f_contact_no').html());

		$('#updateExperienceModal').modal();
	})

	/* OTHER */

	$('.reset_button').click(function(){
		$('.new_data').remove();
		$(this).closest('form').clearForm();
	});

	function clearForm(form) {
		$(':input', form).each(function() {
		var type = this.type;
		var tag = this.tagName.toLowerCase();
		if (type == 'text' || type == 'password' || tag == 'textarea')
		this.value = "";
		else if (type == 'checkbox' || type == 'radio')
		this.checked = false;
		else if (tag == 'select')
		this.selectedIndex = -1;
		});
	};

	$.fn.clearForm = function() {
		return this.each(function() {
			var type = this.type, tag = this.tagName.toLowerCase();
			if (tag == 'form')
				return $(':input',this).clearForm();
			if (type == 'text' || type == 'password' || tag == 'textarea')
				this.value = '';
			else if (type == 'checkbox' || type == 'radio')
				this.checked = false;
			else if (tag == 'select')
				this.selectedIndex = -1;
		});
	};

	if ((url[url.length-1].toLowerCase() == "good_and_service_data") || (url[url.length-1].toLowerCase() == "certification_data") || (url[url.length-1].toLowerCase() == "facility_and_equipment") || (url[url.length-1].toLowerCase() == "company_experience")) {
		$('.input-group.date.year').datepicker({
			format: " yyyy",
			viewMode: "years", 
			minViewMode: "years"
		});

		$('.input-group.date').datepicker({
			format: 'dd-mm-yyyy'
		});
	};


	if ($(".must_autonumeric").length > 0) {
		$(".must_autonumeric").autoNumeric('init', {lZero: 'deny', mDec: 0});
	}

	$('.current_edited_good').bootstrapValidator({
		fields: {
			material_code: {
				validators: {
					notEmpty: {}
				}
			},
			product_description: {
				validators: {
					notEmpty: {}
				}
			},
			source: {
				validators: {
					notEmpty: {}
				}
			},
			type: {
				validators: {
					notEmpty: {}
				}
			},

			no: {
				enabled: false,
				validators: {
					notEmpty: {},
				}
			},
			issued_by: {
				enabled: false,
				validators: {
					notEmpty: {}
				}
			},
			issued_date: {
				enabled: false,
				trigger: 'change keyup',
				validators: {
					notEmpty: {}
				}
			},
			expired_date: {
				enabled: false,
				trigger: 'change keyup',
				validators: {
					notEmpty: {}
				}
			},
		}
	}).on('error.form.bv', function(e) {
		success = false;
	}).on('success.form.bv', function(e) {
		success = true;
	});

	$('#update_good_data_button').click(function(){
		$('.current_edited_good').bootstrapValidator('validate');
		if (success) {
			var form_data = $('.current_edited_good').serialize();
			// alert(form_data); return false();
			console.log(form_data);
			$.ajax({
				url : 'do_update_good',
				method : 'post',
				data : form_data,
				success : function(result) 
				{
					if(result=='OK'){
						swal("Berhasil!", "Ubah data berhasil!", "success")
						location.reload();
					}else{
						swal("Error!", "Gagal updating data barang.", "error")
						// location.reload();
					}
				}
			});
		} 
	});

	$('.cek_mandatory_update').on('change', function() {
		var nyo = $(this).val();
			if(nyo == '1'){
				$('.current_edited_jasa').bootstrapValidator({
					fields: {
						svc_code: {
							validators: {
								notEmpty: {}
							}
						},
						subsvc_code: {
							validators: {
								notEmpty: {}
							}
						},
						product_description_jasa: {
							validators: {
								notEmpty: {}
							}
						},
						type: {
							enabled: false,
							validators: {
								notEmpty: {}
							}
						},
						no: {
							//enabled: false,
							validators: {
								notEmpty: {}
							}
						},
						issued_by: {
							//enabled: false,
							validators: {
								notEmpty: {}
							}
						},
						issued_date: {
							//enabled: false,
							trigger: 'change keyup',
							validators: {
								notEmpty: {}
							}
						},
						expired_date: {
							//enabled: false,
							trigger: 'change keyup',
							validators: {
								notEmpty: {}
							}
						},
					}
				}).on('error.form.bv', function(e) {
					success = false;
				}).on('success.form.bv', function(e) {
					success = true;
				});
			}
	})

	$('#update_jasa_data_button').click(function(){

		cek_cons = $("#group_jasa_id").val();
		// alert(cek_cons);

		gagal = false;

		cek = new Array();
		cek = false;
        $.each($("input[name='subKlasifikasi_jasa_id[]']:checked"), function() {
            cek = true;
        });


		if (cek_cons == '1') {
			if(cek == false){
				swal("Error!", "Sub Klasifikasi harus di centang!", "error")
				return;
			} 
			$('.current_edited_jasa').bootstrapValidator('validate');
		}

		if (success) { 
			var form_data = $('.current_edited_jasa').serialize();
			console.log(form_data);
			// alert('stop'); return false;
			$.ajax({
				url : 'do_update_service',
				method : 'post',
				data : form_data,
				success : function(result)
				{
					if(result=='OK'){
						swal("Berhasil!", "Ubah data berhasil!", "success")
						location.reload();
					}else{
						swal("Error!", "Gagal updating data jasa.", "error")
						location.reload();
					}
					
				}
			});
		} 
	});

	$('.current_edited_utama').bootstrapValidator({
		fields: {
			name: {
				validators: {
					notEmpty: {}
				}
			},
			last_education: {
				validators: {
					notEmpty: {}
				}
			},
			main_skill: {
				validators: {
					notEmpty: {}
				}
			},
			year_exp: {
				validators: {
					notEmpty: {},
					numeric:{}
				}
			},
			emp_status: {
				validators: {
					notEmpty: {}
				}
			},
			emp_type: {
				validators: {
					notEmpty: {}
				}
			}
		}
	}).on('error.form.bv', function(e) {
		success = false;
	}).on('success.form.bv', function(e) {
		success = true;
	});

	$('#update_utama_data_button').click(function(){
		$('.current_edited_utama').bootstrapValidator('validate');
		if(success){
			console.log(form_data);
			var form_data = $('.current_edited_utama').serialize();
			$.ajax({
				url : 'do_update_main_sdm',
				method : 'post',
				data : form_data,
				success : function(result)
				{
					// alert("Success Updating Data!");
					swal("Berhasil!", "Ubah data berhasil!", "success")
					location.reload();
				}
			})  
		}
	});

	$('.current_edited_ahli').bootstrapValidator({
		fields: {
			name: {
				validators: {
					notEmpty: {}
				}
			},
			last_education: {
				validators: {
					notEmpty: {}
				}
			},
			main_skill: {
				validators: {
					notEmpty: {}
				}
			},
			year_exp: {
				validators: {
					notEmpty: {},
					numeric:{}
				}
			},
			emp_status: {
				validators: {
					notEmpty: {}
				}
			},
			emp_type: {
				validators: {
					notEmpty: {}
				}
			}
		}
	}).on('error.form.bv', function(e) {
		success = false;
	}).on('success.form.bv', function(e) {
		success = true;
	});

	$('#update_ahli_data_button').click(function(){
		$('.current_edited_ahli').bootstrapValidator('validate');
		if(success){
			console.log(form_data);
			var form_data = $('.current_edited_ahli').serialize();
			$.ajax({
				url : 'do_update_support_sdm',
				method : 'post',
				data : form_data,
				success : function(result)
				{
					// alert("Success Updating Data!");
					swal("Berhasil!", "Ubah data berhasil!", "success")
					location.reload();
				}
			})  
		}
	});

	$('.current_edited_experience').bootstrapValidator({
		fields: {
			client_name: {
				validators: {
					notEmpty: {}
				}
			},
			project_name: {
				validators: {
					notEmpty: {}
				}
			},
			description: {
				validators: {
					notEmpty: {}
				}
			},
			contract_no: {
				validators: {
					notEmpty: {}
				}
			},
			start_date: {
				trigger: 'change keyup',
				validators: {
					notEmpty: {}
				}
			},
			end_date: {
				trigger: 'change keyup',
				validators: {
					notEmpty: {}
				}
			},
			contact_person: {
				validators: {
					notEmpty: {}
				}
			},
			contact_no: {
				validators: {
					notEmpty: {}
				}
			}
		}
	}).on('error.form.bv', function(e) {
		success = false;
	}).on('success.form.bv', function(e) {
		success = true;
	});

	$('#update_company_experience_button').click(function(){
		$('.current_edited_experience').bootstrapValidator('validate');
		if (success) {
			var form_data = $('.current_edited_experience').serialize();
			$.ajax({
				url : 'do_update_experiences',
				method : 'post',
				data : form_data,
				success : function(result)
				{
					// alert("Success Updating Data!");
					swal("Berhasil!", "Ubah data berhasil!", "success")
					location.reload();
				}
			})
		};
		success = true;
	});
	$('#material_code').change(function(){
		$('.new_material').remove();
		$('#material').val($('#material_code option:selected').text());
		$('#submaterial_code').val('');
	});

	$('#group_jasa_id').change(function(){
		if ($("#group_jasa_id").val() == '1') {
			$(".js_mandatory").show();
		} else {
			$(".js_mandatory").hide();
		};

		$('#svc').val($('#group_jasa_id option:selected').text());
	 	id = $('#group_jasa_id').val();
        $.ajax({
			url:"pilih_child",
			method : 'post',
			data : "id="+id,
			success: function(data){
				$("#subGroup_jasa_id").html(data);
				$("#klasifikasi_jasa_id").html('');
				$('.new_data').remove();
			}
		});
		return false;
    });

    $('#subGroup_jasa_id').change(function(){
    	$('#subsvc').val($('#subGroup_jasa_id option:selected').text());
	 	id = $('#subGroup_jasa_id').val();
        $.ajax({
			url:"pilih_child",
			method : 'post',
			data : "id="+id,
			success: function(data){
				$("#klasifikasi_jasa_id").html(data);
				$('.new_data').remove();
			}
		});
		return false;
    });

	$('#klasifikasi_jasa_id').change(function(){
		$('#klasf').val($('#klasifikasi_jasa_id option:selected').text());
		id = $('#klasifikasi_jasa_id').val();
		$('.new_data').remove();
		$.ajax({
			url : 'pilih_sub_klasifikasi',
			method : 'post',
			data : "id="+id,
			success : function(result)
			{
				var val = $.parseJSON(result);
				var options1 = '';
				//var options2 = '';
				if(val != null){
					options1 += '<span class="lfc_alert"></span>';
					for (var i = 0; i < val.length; i++) {
						description = '';
						if(val[i].DESCRIPTION != null){
							description = ' - ' + val[i].DESCRIPTION;
						}
						//if(i % 2 == 0){
							options1 += '<div required="" class="new_data"><input class="check_jasa" type="checkbox" name="subKlasifikasi_jasa_id[]" value="' + val[i].ID + '"> ' + val[i].NAMA + description +'</div>';
						// }
						// else{
						// 	options2 += '<div class="new_data"><input type="checkbox" name="subKlasifikasi_jasa_id[]" value="' + val[i].NAMA + '"> ' + val[i].NAMA+ ' - ' +val[i].DESCRIPTION+'</div>';				
						// }
					}
					$('#subKlasifikasi_ganjil').append(options1);
					//$('#subKlasifikasi_genal').append(options2);
				
				}else{
					$('#subKlasifikasi_ganjil').append('<div class="new_data"> Data Kosong. </div>');
				}
			}
		})
	});

	$('#kualifikasi_jasa_id').change(function(){
		$('#kualifi').val($('#kualifikasi_jasa_id option:selected').text());
	 	id = $('#kualifikasi_jasa_id').val();
        $.ajax({
			url:"pilih_child_kualifikasi",
			method : 'post',
			data : "id="+id,
			success: function(data){
				$("#subKualifikasi_jasa_id").html(data);
			}
		});
		return false;
    });

    $('#subKualifikasi_jasa_id').change(function(){
		$('#subKualifi').val($('#subKualifikasi_jasa_id option:selected').text());
	});

    	//CHANGE DROPDOWN EDIT JASA
    $('#group_jasa_id_edit').change(function(){
		$('#svc_edit').val($('#group_jasa_id option:selected').text());
	 	id = $('#group_jasa_id_edit').val();
        $.ajax({
			url:"pilih_child",
			method : 'post',
			data : "id="+id,
			success: function(data){
				$("#subGroup_jasa_id_edit").html(data);
				$("#klasifikasi_jasa_id_edit").html('');
				$('.new_data_edit').remove();
			}
		});
		return false;
    });

	$('#subGroup_jasa_id_edit').change(function(){
    	$('#subsvc_edit').val($('#subGroup_jasa_id_edit option:selected').text());
	 	id = $('#subGroup_jasa_id_edit').val();
        $.ajax({
			url:"pilih_child",
			method : 'post',
			data : "id="+id,
			success: function(data){
				$("#klasifikasi_jasa_id_edit").html(data);
				$('.new_data_edit').remove();
			}
		});
		return false;
    });

	$('#klasifikasi_jasa_id_edit').change(function(){
		$('#klasf').val($('#klasifikasi_jasa_id_edit option:selected').text());
		id = $('#klasifikasi_jasa_id_edit').val();
		$('.new_data_edit').remove();
		$.ajax({
			url : 'pilih_sub_klasifikasi',
			method : 'post',
			data : "id="+id,
			success : function(result)
			{
				var val = $.parseJSON(result);
				var options1 = '';
				if(val != null){
					for (var i = 0; i < val.length; i++) {
						description = '';
						if(val[i].DESCRIPTION != null){
							description = ' - ' + val[i].DESCRIPTION;
						}
							options1 += '<div class="new_data_edit"><input type="checkbox" id="subkla" name="subKlasifikasi_jasa_id[]" value="' + val[i].ID + '"> ' + val[i].NAMA + description +'</div>';
					}
					$('#subKlasifikasi_edit').append(options1);
				
				}else{
					$('#subKlasifikasi_edit').append('<div class="new_data_edit"> Data Kosong. </div>');
				}
			}
		})
	});

	$('#kualifikasi_jasa_id_edit').change(function(){
		$('#kualifi_edit').val($('#kualifikasi_jasa_id_edit option:selected').text());
	 	id = $('#kualifikasi_jasa_id_edit').val();
        $.ajax({
			url:"pilih_child_kualifikasi",
			method : 'post',
			data : "id="+id,
			success: function(data){
				$("#subKualifikasi_jasa_id_edit").html(data);
			}
		});
		return false;
    });

    $('#subKualifikasi_jasa_id_edit').change(function(){
		$('#subKualifi_edit').val($('#subKualifikasi_jasa_id_edit option:selected').text());
	});

// UPLOAD FILE
    $('.uploadAttachment').each(function(event) {
    	var panel = $(this).attr('id');
        var btn     = $(this),
            msgBox  = $($(btn).siblings('span.messageUpload')[0]);

        if (panel == 'up_good') {
			var	progressOuter = $('.progress-striped.p_good'),
        		progressBar = $('.progress-bar.b_good');
        } else if (panel == 'up_bahan') {
			var	progressOuter = $('.progress-striped.p_bahan'),
        		progressBar = $('.progress-bar.b_bahan');
        } else if (panel == 'up_jasa') {
        	var	progressOuter = $('.progress-striped.p_jasa'),
        		progressBar = $('.progress-bar.b_jasa');
        } else if (panel == 'id_upcert') {
        	var	progressOuter = $('.progress-striped.p_cert'),
        		progressBar = $('.progress-bar.b_cert');
        } else if (panel == 'id_upcert_e') {
        	var	progressOuter = $('.progress-striped.p_cert_e'),
        		progressBar = $('.progress-bar.b_cert_e');
        };

        var uploader = new ss.SimpleUpload({
            button: btn,
            url: $("#base-url").val() + 'Vendor_update_profile/uploadAttachment',
            name: 'uploadfile',
            allowedExtensions: ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'odt', 'html', 'zip'],
            maxSize: 2048,
            multipart: true,
            hoverClass: 'hover',
            focusClass: 'focus',
            responseType: 'json',
            startXHR: function() {
                progressOuter.css('display','block'); // make progress bar visible
                this.setProgressBar( progressBar );
            },
            onSubmit: function() {
                console.log($(this));
                msgBox.html(''); // empty the message box
                btn.html('Uploading...'); // change button text to "Uploading..."
            },
            onSizeError: function() {
                $.magnificPopup.open({
                    items: {
                        src: '<div class="popup-with-zoom-anim zoom-anim-dialog small-dialog"><h2>Error!</h2><p>File size exceeds limit.</p></div>',
                        type: 'inline'
                    },
                    mainClass:'my-mfp-zoom-in',
                    preloader:false,
                    midClick:true,
                    removalDelay:300,
                });
            },
            onExtError: function() {
                $.magnificPopup.open({
                    items: {
                        src: '<div class="popup-with-zoom-anim zoom-anim-dialog small-dialog"><h2>Error!</h2><p>Invalid file type.</p></div>',
                        type: 'inline'
                    },
                    mainClass:'my-mfp-zoom-in',
                    preloader:false,
                    midClick:true,
                    removalDelay:300,
                });
                // $.magnificPopup.close();
            },
            onComplete: function( filename, response ) {
                progressOuter.css('display','none'); // hide progress bar when upload is completed
                msgBox.css('display','inline');
                if ( !response ) {
                    $.magnificPopup.open({
                        items: {
                            src: '<div class="popup-with-zoom-anim zoom-anim-dialog small-dialog"><h2>Error!</h2><p>Unable to upload file.</p></div>',
                            type: 'inline'
                        },
                        mainClass:'my-mfp-zoom-in',
                        preloader:false,
                        midClick:true,
                        removalDelay:300,
                    });
                    return;
                }

                if ( response.success === true ) {
                    console.log($(btn).siblings('input')[0]);
                    $($(btn).siblings('input')[0]).val(response.newFileName);
                    btn.html('Change File (2MB Max)');
                    btn.css('color','black');

                    btn.parent().find('.filenamespan').html(' &nbsp; File Uploaded');
                    btn.data('uploaded', true);
                    msgBox.html('<a target="_blank" style="color: #666; text-decoration: underline" href="'+base_url+response.upload_dir+response.newFileName+'">File Attachment</a>&nbsp;&nbsp;<a class="btn btn-default delete_upload_file">Delete</a><script>$(".delete_upload_file").click(function(){$(this).parent().parent().find(".uploadAttachment").data("uploaded", false);$(this).parent().parent().find(".uploadAttachment").html("Upload File (2MB Max)");$(this).parent().parent().find(".namafile").val("");$(this).parent().parent().find(".uploadAttachment").css("color","black");$(this).parent().children().remove();});</script>');

                } else {
                    if ( response.msg )  {
                        msgBox.html(escapeTags( response.msg ));

                    } else {
                        $.magnificPopup.open({
                            items: {
                                src: '<div class="popup-with-zoom-anim zoom-anim-dialog small-dialog"><h2>Error!</h2><p>An error occurred and the upload failed.</p></div>',
                                type: 'inline'
                            },
                            mainClass:'my-mfp-zoom-in',
                            preloader:false,
                            midClick:true,
                            removalDelay:300,
                        });
                    }
                }
            },
            onError: function(filename, type, status, statusText, response, uploadBtn, size) {
                console.log(filename, type, status, statusText, response, uploadBtn, size);
                progressOuter.css('display','none');
                $.magnificPopup.open({
                    items: {
                        src: '<div class="popup-with-zoom-anim zoom-anim-dialog small-dialog"><h2>Error!</h2><p>Unable to upload file.</p></div>',
                        type: 'inline',
                        preloader:false,
                        midClick:true,
                        removalDelay:300,
                    }
                });
            }
        });
    });
// END UPLOAD FILE
	$('.delete_upload_file_ja').click(function(){
        $.ajax({
            url: $("#base-url").val() + 'Vendor_update_profile/deleteFile',
            type: 'POST',
            data: {
                id : $("#service_id").val(),
                filename: $("#file_jasa").val()
            },
            beforeSend: function() {
                progressOuter.css('display','block');
            },
        })
        .done(function(data) { 
            progressOuter.css('display','none');  
            $("#file_jasa").val("");
            $(".jasa").html('Upload File (2MB Max)');
            $('.filenamespan').html('');
        })
        .fail(function(data) {
            progressOuter.css('display','none');
            console.log("error");
            console.log(data);
        });
    });
    $('.delete_upload_file_edit_ja').click(function(){
    	file_lama = $("#file_upload_lama_ja").val();
    	file_baru = $("#file_jasa_edit").val();
    	if(file_lama != ''){
    		file = file_lama;
    	}else{
    		file = file_baru;
    	}

        $.ajax({
            url: $("#base-url").val() + 'Vendor_update_profile/deleteFile',
            type: 'POST',
            data: {
                id : $("#service_id").val(),
                filename: file
            },
            beforeSend: function() {
                progressOuter.css('display','block');
            },
        })
        .done(function(data) { 
            progressOuter.css('display','none');     
            $("#file_upload_lama_ja").val("");
            $("#file_jasa_edit").val("");
            $('.uploadAttachment').show();
            $(".jasa").html('Upload File (2MB Max)');
            $('.filenamespan').html('');
        })
        .fail(function(data) {
            progressOuter.css('display','none');
            console.log("error");
            console.log(data);
        });
    });

    $('.delete_upload_file_ba').click(function(){

		var	progressOuter = $('.progress-striped.p_good'),
    		progressBar = $('.progress-bar.b_good');

        $.ajax({
            url: $("#base-url").val() + 'Vendor_update_profile/deleteFile',
            type: 'POST',
            data: {
                id : $("#good_id").val(),
                filename: $("#file_upload_ba").val()
            },
            beforeSend: function() {
                progressOuter.css('display','block');
            },
        })
        .done(function(data) { 
            progressOuter.css('display','none');  
            $("#file_upload_ba").val("");
            $(".barang").html('Upload File (2MB Max)');
            $('.filenamespan').html('');
        })
        .fail(function(data) {
            progressOuter.css('display','none');
            console.log("error");
            console.log(data);
        });
    });

    $('.delete_upload_file_edit_ba').click(function(){

    	var	progressOuter = $('.progress-striped'),
    		progressBar = $('.progress-bar');

    	file_lama = $("#file_upload_lama_ba").val();
    	file_baru = $("#fil_barang_edit").val();
    	if(file_lama != ''){
    		file = file_lama;
    	}else{
    		file = file_baru;
    	}

        $.ajax({
            url: $("#base-url").val() + 'Vendor_update_profile/deleteFile',
            type: 'POST',
            data: {
                id : $("#good_id").val(),
                filename: file
            },
            beforeSend: function() {
                progressOuter.css('display','block');
            },
        })
        .done(function(data) { 
            progressOuter.css('display','none');     
            $("#file_upload_lama_ba").val("");
            $("#fil_barang_edit").val("");
            $('.uploadAttachment').show();
			$(".barang").html('Upload File (2MB Max)');
            $('.filenamespan').html('');
        })
        .fail(function(data) {
            progressOuter.css('display','none');
            console.log("error");
            console.log(data);
        });
    });

    $(".select2").select2();

    $('.cek_mandatory').on('change', function() {
		var nyo = $(this).val();
			if(nyo == '1'){
				$('.insert_service').bootstrapValidator({
					fields: {
						svc_code: {
							validators: {
								notEmpty: {}
							}
						},
						subsvc_code: {
							validators: {
								notEmpty: {}
							}
						},
						product_description_jasa: {
							validators: {
								notEmpty: {}
							}
						},
						file_upload: {
							//enabled: false,
							validators: {
								notEmpty: {}
							}
						},
						file_upload: {
							validators: {
								notEmpty: {}
							}
						},
						no: {
							validators: {
								notEmpty: {}
							}
						},
						issued_by: {
							validators: {
								notEmpty: {}
							}
						},
						issued_date: {
							trigger: 'change keyup',
							validators: {
								notEmpty: {}
							}
						},
						expired_date: {
							trigger: 'change keyup',
							validators: {
								notEmpty: {}
							}
						},
					}
				}).on('error.form.bv', function(e) {
					success = false;
				}).on('success.form.bv', function(e) {
					success = true;
				});
			}
	});

	$(".text-uppercase").keyup(function () {
	    this.value = this.value.toLocaleUpperCase();
	});

})