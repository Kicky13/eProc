$('.input-group.date').datepicker({
		format: 'dd-mm-yyyy',
		ignoreReadonly: true,
	});

btn = $('<span class="input-group-addon"><i class="glyphicon glyphicon-remove"></i></span>');
btn.click(function(e) {
	e.preventDefault();
	parent = $(this).parent();
	date = parent.children('input');
	date.datepicker('setDate', null);
});
$('.input-group.date').append(btn);
$('.input-group.date input').attr("readonly", true);

$(document).ready(function(){
	$(window).keydown(function(event){
	    if(event.keyCode == 13) {
	      event.preventDefault();
	      return false;
	    }
	});

	var vendor_type = $('#vendor_type').val();
	var base_url = $('#base-url').val();

	var url = document.location.href.split('/');
	// if (url[url.length-1].toLowerCase() == "legal_data") {
		var	progressBar = $('.progress-bar'),
			progressOuter = $('.progress-striped');
		$('.uploadAttachment').each(function(event) {
			var btn 	= $(this),
				msgBox 	= $($(btn).siblings('span.messageUpload')[0]);
			var uploader = new ss.SimpleUpload({
				button: btn,
				url: base_url+'Vendor_regis_bypass/uploadAttachment',
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
						msgBox.html('<a target="_blank" style="color: #666; text-decoration: underline" href="'+base_url+response.upload_dir+response.newFileName+'">File Attachment</a>&nbsp;&nbsp;<a class="btn btn-default delete_upload_doc">Delete</a><script>$(".delete_upload_doc").click(function(){$(this).parent().parent().find(".uploadAttachment").data("uploaded", false);$(this).parent().parent().find(".uploadAttachment").html("Upload File (2MB Max)");$(this).parent().parent().find(".namafile").val("");$(this).parent().parent().find(".uploadAttachment").css("color","black");$(this).parent().children().remove();});</script>');

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
		// $('.uploadAttachment').trigger('click');
	// };


	$('.reset_button').click(function(){
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

	$('#country_select').bind('change', function(e){
		var country = $('#country_select').val();
		$('#country').val(country);
		if(country == "ID"){
			$('#city').val(null);
			$('#city').addClass('hidden');
			$('#city').prop('disabled', true);

			$('#city_select').val(null);
			$('#city_select').removeClass('hidden');
			$('#city_select').prop('disabled', false);

			$('#province').prop('disabled', false);
			$('#province_mandatory').append('<span style="color: #E74C3C">*</span>');

		} else {
			$('#city_select').val(null);
			$('#city_select').addClass('hidden');
			$('#city_select').prop('disabled', true);

			$('#city').val(null);
			$('#city').removeClass('hidden');
			$('#city').prop('disabled', false);

			$('#province').val(null);
			$('#province_mandatory').find('span').remove();
			$('#province').prop('disabled', true);
		}
	});

	$('#city_select').bind('change', function(){
		$('#city_name').val($('#city_select').val());
	});

	if($('#country_select').length)
	$('#country_select').bind('tabsshow', function(event, ui) {
		 	var country = $('#country_select').val();
			$('#country').val(country);
			if(country == "ID"){
				$('#city').val(null);
				$('#city').addClass('hidden');
				$('#city').prop('disabled', true);

				$('#city_select').val(null);
				$('#city_select').removeClass('hidden');
				$('#city_select').prop('disabled', false);

				$('#province').prop('disabled', false);
				$('#province_mandatory').append('<span style="color: #E74C3C">*</span>');

			} else {
				$('#city_select').val(null);
				$('#city_select').addClass('hidden');
				$('#city_select').prop('disabled', true);

				$('#city').val(null);
				$('#city').removeClass('hidden');
				$('#city').prop('disabled', false);

				$('#province').val(null);
				$('#province_mandatory').find('span').remove();
				$('#province').prop('disabled', true);
			}   
	});

if($('#city_select').length)
	$('#city_select').bind('tabsshow', function(event, ui) {
			$('#city_name').val($('#city_select').val());
	});

	$('#city').bind('change', function(){
		$('#city_name').val($('#city').val());
	});

	if($('#city').length)
	$('#city').bind('tabsshow', function(event, ui) {
			$('#city_name').val($('#city').val());
	});


	$('#province').bind('change', function(e){
		$('#city_select').html('');
		$('#city_select').prop('disabled', false);
		var base_url = $('#base-url').val();
		$.ajax({
			url: base_url+'Vendor_regis_bypass/get_kota', 
			dataType: 'json',
			type:'POST',
			data:{"prov":$('#province').val()},
			success: function(data) {
				$.each(data, function(i,item){
					if(item.ID!="empty"){
						$('#city_select').append('<option value="'+item.NAMA+'">'+item.NAMA+'</option>');
					}
				});
			}
		});
	});

	if($('#province').length)
	$('#province').bind('tabsshow', function(event, ui) {
			$('#city_select').html('');
			$('#city_select').prop('disabled', false);
			var base_url = $('#base-url').val();
			$.ajax({
				url: base_url+'Vendor_regis_bypass/get_kota', 
				dataType: 'json',
				type:'POST',
				data:{"prov":$('#province').val()},
				success: function(data) {
					$.each(data, function(i,item){
						if(item.ID!="empty"){
							$('#city_select').append('<option value="'+item.ID+'">'+item.NAMA+'</option>');
						}
					});
				}
			});
	});

	$('#province_edit').bind('change', function(e){
		$('#city_select_edit').html('');
		$('#city_select_edit').prop('disabled', false);
		var base_url = $('#base-url').val();
		$.ajax({
			url: base_url+'Vendor_regis_bypass/get_kota', 
			dataType: 'json',
			type:'POST',
			data:{"prov":$('#province_edit').val()},
			success: function(data) {
				$.each(data, function(i,item){
					$('#city_select_edit').prop('disabled', false);
					if (i == 0) {
						$('#city_edit').val(item.ID)
					}
					if(item.ID!="empty"){
						$('#city_select_edit').append('<option value="'+item.ID+'">'+item.NAMA+'</option>')
					}
				});
			}
		});
	});

	if($('#province_edit').length)
	$('#province_edit').bind('tabsshow', function(event, ui) {
			$('#city_select_edit').html('');
			$('#city_select_edit').prop('disabled', false);
			var base_url = $('#base-url').val();
			$.ajax({
				url: base_url+'Vendor_regis_bypass/get_kota', 
				dataType: 'json',
				type:'POST',
				data:{"prov":$('#province_edit').val()},
				success: function(data) {
					$.each(data, function(i,item){
						$('#city_select_edit').prop('disabled', false);
						if (i == 0) {
							$('#city_edit').val(item.NAMA)
						}
						if(item.ID!="empty"){
							$('#city_select_edit').append('<option value="'+item.ID+'">'+item.NAMA+'</option>')
						}
					});
				}
			});
	});

	$('#city_select_edit').bind('change', function(){
		$('#city_edit').val($('#city_select_edit').val());
	});

	if($('#city_select_edit').length)
	$('#city_select_edit').bind('tabsshow', function(event, ui) {
		$('#city_edit').val($('#city_select_edit').val());
	});

	$('#country_edit').bind('change', function(){
		var country = $('#country_edit').val();
		if(country != 'ID') {
			$('#province_edit').val(null);
			$('#province_edit').prop('disabled', true);
			$('#city_select_edit').addClass('hidden');
			$('#city_edit').removeClass('hidden');
			$('#city_edit').val(null);
		} else {
			$('#city_select_edit').prop('disabled', true);
			$('#province_edit').prop('disabled', false);
			if($('#city_select_edit').hasClass('hidden')){
				$('#city_select_edit').val(null);
				$('#city_select_edit').removeClass('hidden');
				$('#city_edit').addClass('hidden');
			}
		}
	});

	if($('#country_edit').length)
	$('#country_edit').bind('tabsshow', function(event, ui) {
		var country = $('#country_edit').val();
		if(country != 'ID') {
			$('#province_edit').val(null);
			$('#province_edit').prop('disabled', true);
			$('#city_select_edit').addClass('hidden');
			$('#city_edit').removeClass('hidden');
			$('#city_edit').val(null);
		} else {
			$('#city_select_edit').prop('disabled', true);
			$('#province_edit').prop('disabled', false);
			if($('#city_select_edit').hasClass('hidden')){
				$('#city_select_edit').val(null);
				$('#city_select_edit').removeClass('hidden');
				$('#city_edit').addClass('hidden');
			}
		}
	});

	/* LEGAL DATA */
	if(vendor_type == 'NASIONAL'){
		$('.legal_form').bootstrapValidator({
			fields: {
				/* DOMISILI PERUSAHAAN */
				address_domisili_no: {
					trigger: 'change keyup',
					validators: {
						notEmpty: {},
						stringLength : {
							max:25
						}
					}
				},
				address_domisili_date: {
					trigger: 'change keyup',
					validators: {
						notEmpty: {}
					}
				},
				address_domisili_exp_date: {
					trigger: 'change keyup',
					validators: {
						notEmpty: {}
					}
				},
				address_street: {
					validators: {
						notEmpty: {}
					}
				},
				address_country: {
					validators: {
						notEmpty: {}
					}
				},
				addres_prop: {
					validators: {
						notEmpty: {}
					}
				},
				city_select: {
					validators: {
						notEmpty: {}
					}
				},
				address_city: {
					validators: {
						notEmpty: {}
					}
				},
				address_postcode: {
					validators: {
						notEmpty: {},
						numeric: {},
						stringLength:{max:5, min:5}
					}
				},

				/* NPWP */
				npwp_no: {
					trigger: 'change keyup',
					validators: {
						notEmpty: {}
					}
				},
				npwp_address: {
					validators: {
						notEmpty: {}
					}
				},
				npwp_postcode: {
					trigger: 'change keyup',
					validators: {
						numeric:{},
						notEmpty: {},
						stringLength:{max:5, min:5}
					}
				},
				npwp_city: {
					validators: {
						notEmpty: {}
					}
				},
				npwp_prop: {
					validators: {
						notEmpty: {}
					}
				},

				/* SIUP */
				siup_issued_by: {
					validators: {
						notEmpty: {}
					}
				},
				siup_no: {
					validators: {
						notEmpty: {},
						stringLength:{max:25},
					}
				},
				siup_type: {
					validators: {
						notEmpty: {}
					}
				},
				siup_from: {
					trigger: 'change keyup',
					validators: {
						notEmpty: {}
					}
				},
				siup_to: {
					trigger: 'change keyup',
					validators: {
						notEmpty: {}
					}
				},

				/* TDP */
				tdp_issued_by: {
					validators: {
						notEmpty: {}
					}
				},
				tdp_no: {
					validators: {
						notEmpty: {},
						stringLength:{max:25}
					}
				},
				tdp_from: {
					trigger: 'change keyup',
					validators: {
						notEmpty: {}
					}
				},
				tdp_to: {
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
	} else if(vendor_type == 'INTERNASIONAL'){
		$('.legal_form').bootstrapValidator({
			fields: {
				/* DOMISILI PERUSAHAAN */
				address_domisili_no: {
					trigger: 'change keyup',
					validators: {
						notEmpty: {},
						stringLength : {
							max:25
						}
					}
				},
				address_domisili_date: {
					trigger: 'change keyup',
					validators: {
						notEmpty: {}
					}
				},
				address_domisili_exp_date: {
					trigger: 'change keyup',
					validators: {
						notEmpty: {}
					}
				},
				address_street: {
					validators: {
						notEmpty: {}
					}
				},
				npwp_postcode: {
					trigger: 'change keyup',
					validators: {
						numeric:{},
						stringLength:{max:5, min:5}
					}
				},
				address_country: {
					validators: {
						notEmpty: {}
					}
				},
				addres_prop: {
					validators: {
						notEmpty: {}
					}
				},
				city_select: {
					validators: {
						notEmpty: {}
					}
				},
				address_city: {
					validators: {
						notEmpty: {}
					}
				},
				address_postcode: {
					validators: {
						notEmpty: {},
						numeric: {},
						stringLength:{max:5, min:5}
					}
				}
			}
		}).on('error.form.bv', function(e) {
			success = false;
		}).on('success.form.bv', function(e) {
			success = true;
		});
	} else if(vendor_type == 'PERORANGAN'){
		$('.legal_form').bootstrapValidator({
			fields: {
				/* NPWP */
				npwp_no: {
					trigger: 'change keyup',
					validators: {
						notEmpty: {}
					}
				},
				npwp_address: {
					validators: {
						notEmpty: {}
					}
				},
				npwp_postcode: {
					trigger: 'change keyup',
					validators: {
						numeric:{},
						notEmpty: {},
						stringLength:{max:5, min:5}
					}
				},
				npwp_city: {
					validators: {
						notEmpty: {}
					}
				},
				npwp_prop: {
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
	} 

	$('#save_legal').click(function(){
		$('.collapse').collapse('show');

		gagal = false;
		if (vendor_type == 'NASIONAL') {
			$('.legal_form').find('.panel').not('.hidden').find('.uploadAttachment').each(function() {
				if ($(this).data('uploaded') != true) {
					$(this).css('color','red');
					gagal = true;
				}
			});

			if ($('#npwp_pkp').val() == 'PKP') {
				$('.legal_form_pkp').find('.uploadAttachment').each(function() {
					if ($(this).data('uploaded') != true) {
						$(this).css('color','red');
						gagal = true;
					}
				});
			};

			$('.legal_form.domisili').bootstrapValidator('validate');
			$('.legal_form.npwp').bootstrapValidator('validate');
			$('.legal_form_pkp').bootstrapValidator('validate');
			$('.legal_form.tdp').bootstrapValidator('validate');
			$('.legal_form.siup').bootstrapValidator('validate');

		}
		else if (vendor_type == 'INTERNASIONAL') {
			$('.legal_form.domisili').find('.panel').not('.hidden').find('.uploadAttachment').each(function() {
				if ($(this).data('uploaded') != true) {
					$(this).css('color','red');
					gagal = true;
				}
			});
			$('.legal_form.domisili').bootstrapValidator('validate');
		}
		else if (vendor_type == 'PERORANGAN') {
			$('.legal_form.npwp').find('.panel').not('.hidden').find('.uploadAttachment').each(function() {
				console.log($(this).data('uploaded'));
				if ($(this).data('uploaded') != true) {
					$(this).css('color','red');
					gagal = true;
				}
			});
			$('.legal_form.npwp').bootstrapValidator('validate');

			if ($('#npwp_pkp').val() == 'PKP') {
				$('.legal_form_pkp').find('.uploadAttachment').each(function() {
					if ($(this).data('uploaded') != true) {
						$(this).css('color','red');
						gagal = true;
					}
				});
			};
			$('.legal_form_pkp').bootstrapValidator('validate');
		} else {
				swal("Perhatian!", "Vendor Type Kosong!", "warning") 
				return false;
		};

		if (success) {
			if (gagal == true) { 
				swal("Perhatian!", "Wajib mengunggah dokumen!", "warning")
				return false;
			}
			var form_data = $('.legal_form_all').serialize();
			console.log(form_data);
			$.ajax({
				url : base_url+'Vendor_regis_bypass/do_update_legal_data',
				method : 'post',
				data : form_data,
				success : function(result)
				{
					console.log(result); 
					swal("Berhasil!", "Simpan data berhasil!", "success")
					location.reload();
				}
			});
		};
		success = true;
	});

	$('.delete_upload_doc').click(function(){
		$(this).parent().parent().find('.uploadAttachment').data('uploaded', false);
		$(this).parent().parent().find('.uploadAttachment').html('Upload File (2MB Max)');
		$(this).parent().parent().find('.namafile').val('');
		$(this).parent().children().remove();
	});

	$('.update_legal_data').click(function(){
		var legal_row_data = $(this).closest('tr').children("td:not(:first-child, :last-child)").map(function() {return $(this).text();}).get();
		var legaldata_id = $(this).closest('tr').attr('id');
		$('#akta_id').val(legaldata_id);
		$('#akta_no').val(legal_row_data[0]);
		$('#akta_type').val(legal_row_data[1]);
		$('#tgl_akta').val(legal_row_data[2]);
		$('#notaris_name').val(legal_row_data[3]);
		$('#notaris_address').val(legal_row_data[4]);
		$('#pengesahan_hakim').val(legal_row_data[5]);
		$('#berita_acara_ngr').val(legal_row_data[6]);
		//console.log(legal_row_data);
		$('#updateLegalDataModal').modal();
	});

	$('.insert_akta').bootstrapValidator({
		fields: {
			
			akta_no: {
				validators: {
					notEmpty: {}
				}
			},
			akta_type: {
				validators: {
					notEmpty: {}
				}
			},
			date_creation: {
				trigger: 'change keyup',
				validators: {
					notEmpty: {}
				}
			},
			notaris_name: {
				validators: {
					notEmpty: {}
				}
			},
			notaris_address: {
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

	$('.current_edited_akta').bootstrapValidator({
		fields: {
			
			akta_no: {
				validators: {
					notEmpty: {}
				}
			},
			akta_type: {
				validators: {
					notEmpty: {}
				}
			},
			date_creation: {
				trigger: 'change keyup',
				validators: {
					notEmpty: {}
				}
			},
			notaris_name: {
				validators: {
					notEmpty: {}
				}
			},
			notaris_address: {
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

	$('#update_legal_data_button').click(function(){
		$(".current_edited_akta").bootstrapValidator('validate');
		if(success){
			var form_data = $('.current_edited_akta').serialize();
			$.ajax({
				url : base_url+'Vendor_regis_bypass/do_update_akta_data',
				method : 'post',
				data : form_data,
				success : function(result)
				{
					if (result) { 
						swal("Berhasil!", "Ubah data berhasil!", "success")
						location.reload();
					}
					else {
						swal("Gagal!", "Ubah data gagal!", "error")
					}
				}
			})  
		}
	});

	$('#addAkta').click(function(){
		$('.insert_akta').bootstrapValidator('validate');

		gagal = false;
		$('.insert_akta').find('.akta_upload').each(function() {
			if ($(this).data('uploaded') != true) {
				gagal = true;
			}
		});

		if (success) {
			if (gagal == true) {
				swal("Perhatian!", "Wajib mengunggah dokumen!", "warning")
				return false;
			}
			var form_data = $('.insert_akta').serialize();
			console.log(form_data);
			$.ajax({
				url : base_url+'Vendor_regis_bypass/do_insert_akta_pendirian',
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

	$('#address_country').bind('change', function(){
		var country = $('#address_country').val();
		if(country=='ID'){
			$('#address_prop').prop('disabled', false);

			$('#address_city').addClass('hidden');
			$('#address_city').prop('disabled', true);

			$('#city_select').val(null);
			$('#city_select').removeClass('hidden');
			$('#city_select').prop('disabled', true);
		} else {
			$('#city_select').addClass('hidden');
			$('#city_select').prop('disabled', true);

			$('#address_city').val(null);
			$('#address_city').removeClass('hidden');
			$('#address_city').prop('disabled', false);

			$('#address_prop').val(null);
			$('#address_prop').prop('disabled', true);
			
		}
	});

	if($('#address_country').length)
	$('#address_country').bind('tabsshow', function(event, ui) {
			var country = $('#address_country').val();
			if(country=='ID'){
				$('#address_prop').prop('disabled', false);

				$('#address_city').addClass('hidden');
				$('#address_city').prop('disabled', true);

				$('#city_select').val(null);
				$('#city_select').removeClass('hidden');
				$('#city_select').prop('disabled', true);
			} else {
				$('#city_select').addClass('hidden');
				$('#city_select').prop('disabled', true);

				$('#address_city').val(null);
				$('#address_city').removeClass('hidden');
				$('#address_city').prop('disabled', false);

				$('#address_prop').val(null);
				$('#address_prop').prop('disabled', true);
				
			}
	});

	$('#address_prop').bind('change', function(e){
		$('#city_select').prop('disabled', false);
		var base_url = $('#base-url').val();
		$('#city_select').html('');
		$.ajax({
			url: base_url+'Vendor_regis_bypass/get_kota', 
			dataType: 'json',
			type:'POST',
			data:{"prov":$('#address_prop').val()},
			success: function(data) {
				$('#city_select').append('<option value=""></option>');
				$.each(data, function(i,item){
					if(item.ID!="empty"){
						$('#city_select').append('<option value="'+item.ID+'">'+item.NAMA+'</option>')
					}
				});
				$('#city_select').prop('disabled', false);
			}
		});
	});


	if($('#address_prop').length)
	$('#address_prop').bind('tabsshow', function(event, ui) {
			$('#city_select').prop('disabled', false);
			var base_url = $('#base-url').val();
			$('#city_select').html('');
			$.ajax({
				url: base_url+'Vendor_regis_bypass/get_kota', 
				dataType: 'json',
				type:'POST',
				data:{"prov":$('#address_prop').val()},
				success: function(data) {
					$('#city_select').append('<option value=""></option>');
					$.each(data, function(i,item){
						if(item.ID!="empty"){
							$('#city_select').append('<option value="'+item.ID+'">'+item.NAMA+'</option>')
						}
					});
					$('#city_select').prop('disabled', false);
				}
			});
	});

	$('#npwp_prop').bind('change', function(e){
		$('#npwp_city').html('');
		$('#npwp_city').prop('disabled', false);
		var base_url = $('#base-url').val();
		$.ajax({
            url: base_url+'Vendor_regis_bypass/get_kota', 
            dataType: 'json',
            type:'POST',
            data:{"prov":$('#npwp_prop').val()},
            success: function(data) {
                $.each(data, function(i,item){
                	$('#npwp_city').prop('disabled', false);
                	if (i == 0) {
                		$('#city_edit').val(item.NAMA)
                	}
                	if(item.ID!="empty"){
                		$('#npwp_city').append('<option value="'+item.ID+'">'+item.NAMA+'</option>')
                	}
                });
            }
        });
	});

	if($('#npwp_prop').length)
	$('#npwp_prop').bind('tabsshow', function(e){
		$('#npwp_city').html('');
		$('#npwp_city').prop('disabled', false);
		var base_url = $('#base-url').val();
		$.ajax({
            url: base_url+'Vendor_regis_bypass/get_kota', 
            dataType: 'json',
            type:'POST',
            data:{"prov":$('#npwp_prop').val()},
            success: function(data) {
                $.each(data, function(i,item){
                	$('#npwp_city').prop('disabled', false);
                	if (i == 0) {
                		$('#city_edit').val(item.NAMA)
                	}
                	if(item.ID!="empty"){
                		$('#npwp_city').append('<option value="'+item.ID+'">'+item.NAMA+'</option>')
                	}
                });
            }
        });
	});

	if ($(".must_autonumeric").length > 0) {
		$(".must_autonumeric").autoNumeric('init', {lZero: 'deny', mDec: 0, vMax:'999999999999999'});
	}

	

	/* OTHER */
	function escapeTags( str ) {
		return String( str )
		.replace( /&/g, '&amp;' )
		.replace( /"/g, '&quot;' )
		.replace( /'/g, '&#39;' )
		.replace( /</g, '&lt;' )
		.replace( />/g, '&gt;' );
	}

	$('.npwp_no').mask("99.999.999.9-999.999");
	

	$(".select2").select2();

	$('.delete_upload_file_ba').click(function(){
        $.ajax({
            url: $("#base-url").val() + 'Vendor_regis_bypass/deleteFile_all',
            type: 'POST',
            data: {
                filename: $("#filename").val()
            },
            beforeSend: function() {
                progressOuter.css('display','block');
            },
        })
        .done(function(data) { 
            progressOuter.css('display','none');  
            $("#filename").val("");
            $(".file").html('Upload File (2MB Max)');
            $('.filenamespan').html('');
        })
        .fail(function(data) {
            progressOuter.css('display','none');
            console.log("error");
            console.log(data);
        });
    });

    $('#npwp_pkp').on('change', function() {
		var nyo = $(this).val()
		// alert(nyo);
			if(nyo == 'PKP'){
			$('#npwp_pkp_no').removeAttr('disabled');
				$('.legal_form_pkp').bootstrapValidator({
					fields: {
						 npwp_pkp_no: {
							validators: {
								notEmpty: {},
								stringLength:{max:100}
							}
						}
					}
				}).on('error.form.bv', function(e) {
					success = false;
				}).on('success.form.bv', function(e) {
					success = true;
				});
			} else {
				$('#npwp_pkp_no').attr('disabled', true);
			}
	});
    
    // $('#npwp_pkp_no').attr('disabled', false);

    $('#closeModal').on( "click", function() {
        $.magnificPopup.close();
    });

    if(vendor_type != 'INTERNASIONAL'){
			$('.insert_bank_data').bootstrapValidator({
				fields: {
					account_no: {
						trigger: 'change keyup',
						validators: {
							notEmpty: {},
							stringLength: {max:25}
						}
					},
					account_name: {
						validators: {
							notEmpty: {}
						}
					},
					bank_name: {
						validators: {
							notEmpty: {}
						}
					},
					bank_branch: {
						validators: {
							notEmpty: {}
						}
					},
					address: {
						validators: {
							notEmpty: {}
						}
					},
					bank_postal_code: {
						validators: {
							notEmpty: {},
							numeric:{},
							stringLength:{max:5, min:5}
						}
					},
					currency: {
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
		} else {
			$('.insert_bank_data').bootstrapValidator({
				fields: {
					account_no: {
						trigger: 'change keyup',
						validators: {
							notEmpty: {},
							stringLength: {max:25}
						}
					},
					account_name: {
						validators: {
							notEmpty: {}
						}
					},
					bank_name: {
						validators: {
							notEmpty: {}
						}
					},
					bank_branch: {
						validators: {
							notEmpty: {}
						}
					},
					swift_code: {
						validators: {
							notEmpty: {}
						}
					},
					address: {
						validators: {
							notEmpty: {}
						}
					},
					bank_postal_code: {
						validators: {
							notEmpty: {},
							numeric:{},
							stringLength:{max:5, min:5}
						}
					},
					currency: {
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
		}

		if(vendor_type != 'PERORANGAN'){
			$('.update_financial_data').bootstrapValidator({
				fields: {
					fin_akta_mdl_dsr_curr: {
						validators: {
							notEmpty: {}
						}
					},
					fin_akta_mdl_dsr: {
						trigger: 'change keyup',
						validators: {
							notEmpty: {}
							//numeric: {}
						}
					},
					fin_akta_mdl_str_curr: {
						validators: {
							notEmpty: {}
						}
					},
					fin_akta_mdl_str: {
						trigger: 'change keyup',
						validators: {
							notEmpty: {}
							//numeric: {}
						}
					},
					fin_class : {
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
		}

    $('#addBankData').click(function(){
			var bootstrapValidator = $('.insert_bank_data').data('bootstrapValidator');
			if (vendor_type == 'INTERNASIONAL') {
				bootstrapValidator.enableFieldValidators('swift_code');
			};
			$('.insert_bank_data').bootstrapValidator('validate');
			if (success) {
				var form_data = $('.insert_bank_data').serialize();
				console.log(form_data);
				$.ajax({
					url : base_url+'Vendor_regis_bypass/do_insert_bank_data',
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

	$('.update_bank_data').click(function(){
			var bootstrapValidator = $('.current_edited_bank_financial').data('bootstrapValidator');
			if (vendor_type == 'INTERNASIONAL') {
				bootstrapValidator.enableFieldValidators('swift_code');
			};
			var bank_id = $(this).closest('tr').attr('id');
			console.log(bank_id);
			$('#bank_id').val(bank_id);
			var base_url = $('#base-url').val();
			$.ajax({
				url:base_url+'Vendor_regis_bypass/get_bank_edit',
				dataType: "json",
				type:"post",
				data:{"bank_id":bank_id},
				success:function(data){
					$.each(data, function(i,bank){
						$('#account_no_edit').val(bank.ACCOUNT_NO);
						$('#account_name_edit').val(bank.ACCOUNT_NAME);
						$('#bank_name_edit').val(bank.BANK_NAME);
						$('#bank_branch_edit').val(bank.BANK_BRANCH);
						$('#swift_code_edit').val(bank.SWIFT_CODE);
						$('#address_edit').val(bank.ADDRESS);
						$('#bank_postal_code_edit').val(bank.BANK_POSTAL_CODE);
						$('#currency_edit').val(bank.CURRENCY);
						$('#reference_bank_edit').val(bank.REFERENCE_BANK);
						$('#filename').val(bank.REFERENCE_FILE);
					});
				}
			});
			$('#updateRekeningModal').modal();
		});

	$('.current_edited_bank_financial').bootstrapValidator({
		fields: {
			account_no: {
				trigger: 'change keyup',
				validators: {
					notEmpty: {},
					stringLength: {max:25}
				}
			},
			account_name: {
				validators: {
					notEmpty: {}
				}
			},
			bank_name: {
				validators: {
					notEmpty: {}
				}
			},
			bank_branch: {
				validators: {
					notEmpty: {}
				}
			},
			swift_code: {
				enabled: false,
				validators: {
					notEmpty: {}
				}
			},
			address: {
				validators: {
					notEmpty: {}
				}
			},
			bank_postal_code: {
				validators: {
					notEmpty: {},
					numeric:{},
					stringLength:{max:5, min:5}
				}
			},
			currency: {
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

	
	$('#update_rekening_data_button').click(function(){
		$('.current_edited_bank_financial').bootstrapValidator('validate');
		if(success){
			var form_data = $('.current_edited_bank_financial').serialize();
			$.ajax({
				url : base_url+'Vendor_regis_bypass/do_update_bank_financial',
				method : 'post',
				data : form_data,
				success : function(result)
				{
					console.log(result);
					if (result) { 
						swal("Berhasil!", "Ubah data berhasil!", "success")
						location.reload();
					}
					else { 
						swal("Gagal", "Ubah data gagal!", "error")
					}
				}
			})  
		}
	});


	$('.delete_akta').click(function(e){
		
		var akta = $(this).closest('tr').attr('id');
		console.log(akta);

		e.preventDefault();
            swal({
                title: "Apakah Anda Yakin?",
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
                	$.ajax({
						url : base_url+'Vendor_regis_bypass/do_remove_legal_akta',
						type : 'POST',
						data : {akta : akta},
                        dataType: 'json',
						// method: 'POST',
						success : function(result)
						{
							console.log(result);
							if (result == 'OK') { 
								swal("Berhasil!", "Hapus data berhasil!", "success")
								location.reload();
							}
							else { 
								swal("Gagal", "Hapus data gagal!", "error")
							}
						}
					})
                } else {
                	e.preventDefault();
                }
            })
	});

	$('.delete_bank').click(function(e){
			
			var bank = $(this).closest('tr').attr('id');
			console.log(bank);

			e.preventDefault();
	            swal({
	                title: "Apakah Anda Yakin?",
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
	                	$.ajax({
							url : base_url+'Vendor_regis_bypass/do_remove_vendor_bank',
							type : 'POST',
							data : {bank : bank},
	                        dataType: 'json',
							// method: 'POST',
							success : function(result)
							{
								console.log(result);
								if (result == 'OK') { 
									swal("Berhasil!", "Hapus data berhasil!", "success")
									location.reload();
								}
								else { 
									swal("Gagal", "Hapus data gagal!", "error")
								}
							}
						})
	                } else {
	                	e.preventDefault();
	                }
	            })
		});
	
	$(".text-uppercase").keyup(function () {
	    this.value = this.value.toLocaleUpperCase();
	});
})