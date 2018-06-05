$('.input-group.date.year').datepicker({
    format: " yyyy",
    viewMode: "years", 
    minViewMode: "years"
});

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

	var url = document.location.href.split('/');
	var vendor_type = $('#vendor_type').val();
	var base_url = $('#base-url').val();

	$('.uploadAttachment').each(function(event){
		var panel = $(this).attr('id');
		var btn 	= $(this),
			msgBox 	= $($(btn).siblings('span.messageUpload')[0]);

			if (panel == 'akta1') {
				var progressBar = $('.progress-bar.akta'),
					progressOuter = $('.progress-striped.akta');
			} else if (panel == 'akta2') {
				var progressBar = $('.progress-bar.kehakiman'),
					progressOuter = $('.progress-striped.kehakiman');
			} else if (panel == 'akta3') {
				var progressBar = $('.progress-bar.berita_negara'),
					progressOuter = $('.progress-striped.berita_negara');
			} else if (panel == 'domisil') {
				var progressBar = $('.progress-bar.dmsl'),
					progressOuter = $('.progress-striped.dmsl');
			} else if (panel == 'npwp_up') {
				var progressBar = $('.progress-bar.npwp_prog'),
					progressOuter = $('.progress-striped.npwp_prog');
			} else if (panel == 'siup_up') {
				var progressBar = $('.progress-bar.siup_prog'),
					progressOuter = $('.progress-striped.siup_prog');
			} else if (panel == 'tdp_up') {
				var progressBar = $('.progress-bar.tdp_prog'),
					progressOuter = $('.progress-striped.tdp_prog');
			} else if (panel == 'tdp_up') {
				var progressBar = $('.progress-bar.tdp_prog'),
					progressOuter = $('.progress-striped.tdp_prog');
			} else if (panel == 'akta_edit1') { // EDIT AKTA
				var progressBar = $('.progress-bar.b_akta'),
					progressOuter = $('.progress-striped.p_akta');
			} else if (panel == 'akta_edit2') {
				var progressBar = $('.progress-bar.b_kehakiman'),
					progressOuter = $('.progress-striped.p_kehakiman');
			} else if (panel == 'akta_edit3') {
				var progressBar = $('.progress-bar.b_berita_negara'),
					progressOuter = $('.progress-striped.p_berita_negara');
			} else if (panel == 'id_komisaris') {
				var progressBar = $('.progress-bar.b_komisaris'),
					progressOuter = $('.progress-striped.p_komisaris');
			} else if (panel == 'id_direktur') {
				var progressBar = $('.progress-bar.b_direktur'),
					progressOuter = $('.progress-striped.p_direktur');
			} else if (panel == 'id_komisaris_e') {
				var progressBar = $('.progress-bar.b_komisaris_e'),
					progressOuter = $('.progress-striped.p_komisaris_e');
			} else if (panel == 'id_bank') {
				var progressBar = $('.progress-bar.b_bank'),
					progressOuter = $('.progress-striped.p_bank');
			} else if (panel == 'id_bank_e') {
				var progressBar = $('.progress-bar.b_bank_e'),
					progressOuter = $('.progress-striped.p_bank_e');
			} else if (panel == 'id_rpt') {
				var progressBar = $('.progress-bar.b_rpt'),
					progressOuter = $('.progress-striped.p_rpt');
			} else if (panel == 'id_rpt_e') {
				var progressBar = $('.progress-bar.b_rpt_e'),
					progressOuter = $('.progress-striped.p_rpt_e');
			} else {
				var progressBar = $('.progress-bar'),
					progressOuter = $('.progress-striped');
			}

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
                    msgBox.html('<a target="_blank" style="color: #666; text-decoration: underline" href="'+base_url+response.upload_dir+response.newFileName+'">File Attachment</a>&nbsp;&nbsp;<a class="btn btn-default delete_upload_doc glyphicon glyphicon-trash"></a><script>$(".delete_upload_doc").click(function(){$(this).parent().parent().find(".uploadAttachment").data("uploaded", false);$(this).parent().parent().find(".uploadAttachment").html("Upload File (2MB Max)");$(this).parent().parent().find(".").val("");$(this).parent().parent().find(".uploadAttachment").css("color","black");$(this).parent().children().remove();});</script>');

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

	/* GENERAL DATA */
	var success = true;

	$('.general_form').bootstrapValidator({
		fields: {
			company_name: {
				validators: {
					notEmpty: {}
				}
			},
			vendor_type: {
				validators: {
					notEmpty: {}
				}
			},
			contact_name: {
				validators: {
					notEmpty: {}
				}
			},
			contact_pos: {
				validators: {
					notEmpty: {}
				}
			},
			contact_phone_no: {
				validators: {
					notEmpty: {},
					numeric: {max:15, min:1}
				}
			},
			contact_phone_hp: {
				validators: {
					notEmpty: {},
					numeric: {max:15, min:1}
				}
			},
			contact_email: {
				validators: {
					notEmpty: {},
					emailAddress: {}
				}
			}
		}
	}).on('error.form.bv', function(e) {
		success = false;
	}).on('success.form.bv', function(e) {
		success = true;
	});

	$('#save').click(function(){
		var as = $('#info_perusahaan').val();
		$('.general_form').bootstrapValidator('validate');
		if (success) {
			var form_data = $('.general_form').serialize();
			$.ajax({
				url : 'do_update_general_data',
				method : 'post',
				data : form_data,
				success : function(result)
				{
					if (result) {
						swal("Berhasil!", "Simpan data berhasil!", "success")
						url = 'Vendor_update_profile/data_vendor';
						window.location.href = url;
					};
				}
			}); 
		};
		success = true;
	});

	$('.insert_address').bootstrapValidator({
		fields: {
			alamat: {
				validators: {
					notEmpty: {}
				}
			},
			city: {
				trigger: 'change keyup',
				validators: {
					notEmpty: {}
				}
			},
			city_select: {
				trigger: 'change keyup',
				validators: {
					notEmpty: {}
				}
			},
			province: {
				validators: {
					notEmpty: {}
				}
			},
			postcode: {
				trigger: 'change keyup',
				validators: {
					notEmpty: {},
					numeric: {},
					stringLength:{max:5, min:5}
				}
			},
			country: {
				trigger: 'change keyup',
				validators: {
					notEmpty: {},
					stringLength:{min:1}
				}
			},
			telp1: {
				validators: {
					notEmpty: {},
					numeric: {max:15, min:1}
				}
			},
			telp2: {
				validators: {
					numeric: {max:15, min:1}
				}
			},
			fax: {
				validators: {
					numeric: {max:15, min:1}
				}
			},
			website: {
				validators: {
				}
			}
		}
	}).on('error.form.bv', function(e) {
		success = false;
	}).on('success.form.bv', function(e) {
		success = true;
	});

	$('#saveandcont').click(function(){
		$('.general_form').bootstrapValidator('validate');
		if ($('#empty_row').length == 1) {
			$('.insert_address').bootstrapValidator('validate');
		};
		if (success && $('#empty_row').length != 1) {
			var form_data = $('.general_form').serialize();
			console.log(form_data);
			$.ajax({
				url : 'do_update_general_data',
				method : 'post',
				data : form_data,
				success : function(result)
				{
					window.location.href = "Legal_data";
				}
			})
		};
		success = true;
	});

	$('.update_general_address').click(function(){
		var address_id = $(this).closest('tr').attr('id');
		$('#address_id').val(address_id);
		var base_url = $('#base-url').val();
		$.ajax({
			url:base_url+'Vendor_update_profile/get_address_edit',
			dataType: "json",
			type:"post",
			data:{"id_addr":address_id},
			success:function(data){
				retval = data.retval;
				$.each(data.retval, function(i,item){
					console.log(item);
					if(item.COUNTRY=='ID'){
						$('#alamat_edit').val(item.ADDRESS);
						$('#postcode_edit').val(item.POST_CODE);
						$('#country_edit').val(item.COUNTRY);
						$('#province_edit').val(item.PROVINCE);
						$('#city_select_edit').html('');
						$('#city_select_edit').prop('disabled', false);
						var base_url = $('#base-url').val();
						$.ajax({
							url: base_url+'Vendor_update_profile/get_kota', 
							dataType: 'json',
							type:'POST',
							data:{"prov":$('#province_edit').val()},
							success: function(data) {
								$.each(data, function(i,kota){
									if(kota.ID!="empty"){
										if (kota.ID == item.CITY) {
											$('#city_select_edit').append('<option value="'+kota.ID+'" selected>'+kota.NAMA+'</option>')
										} else {
											$('#city_select_edit').append('<option value="'+kota.ID+'">'+kota.NAMA+'</option>')
										}
									}
								});
							}
						});
						$('#city_edit').val(item.CITY);
						$('#cabang_edit').val(item.TYPE);
						$('#telp1_edit').val(item.TELEPHONE1_NO);
						$('#telp2_edit').val(item.TELEPHONE2_NO);
						$('#fax_edit').val(item.FAX);
						$('#website_edit').val(item.WEBSITE);
					} else {
						$('#province_edit').val(null);
						$('#province_edit').prop('disabled', true);
						$('#city_select_edit').html('');
						$('#city_select_edit').prop('disabled', false);
						$('#city_select_edit').addClass('hidden');
						$('#city_edit').removeClass('hidden');
						$('#alamat_edit').val(item.ADDRESS);
						$('#city_edit').val(item.CITY);
						$('#postcode_edit').val(item.POST_CODE);
						$('#country_edit').val(item.COUNTRY);
						$('#cabang_edit').val(item.TYPE);
						$('#telp1_edit').val(item.TELEPHONE1_NO);
						$('#telp2_edit').val(item.TELEPHONE2_NO);
						$('#fax_edit').val(item.FAX);
						$('#website_edit').val(item.WEBSITE);
					}
					
				});
			}
		})
		$('#updateVendorAddressModal').modal();
	});

	$('.current_edited_address').bootstrapValidator({
		fields: {
			cabang: {
				validators: {
					notEmpty: {}
				}
			},
			alamat: {
				validators: {
					notEmpty: {}
				}
			},
			country: {
				validators: {
					notEmpty: {}
				}
			},
			province: {
				validators: {
					notEmpty: {}
				}
			},
			city: {
				validators: {
					notEmpty: {}
				}
			},
			postcode: {
				validators: {
					trigger: 'change keyup',
					notEmpty: {},
					numeric:{},
					stringLength:{max:5, min:5}
				}
			},
			telp1: {
				validators: {
					notEmpty: {},
					numeric: {},
					stringLength:{max:15, min:1}
				}
			},
			telp2: {
				validators: {
					numeric: {},
					stringLength:{max:15, min:1}
				}
			},
			fax: {
				validators: {
					numeric: {},
					stringLength:{max:15, min:1}
				}
			},
			website: {
				validators: {
					
				}
			},
			
		}
	}).on('error.form.bv', function(e) {
		success = false;
	}).on('success.form.bv', function(e) {
		success = true;
	});

	$('#update_general_address_button').click(function(){
		$('.current_edited_address').bootstrapValidator('validate');
		if(success){
			var form_data = $('.current_edited_address').serialize();
			console.log(form_data);
			$.ajax({
				url : 'do_update_general_address',
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
						swal("Gagal!", "Ubah data gagal!", "error")
					}
				}
			})  
		}
	});

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
			url: base_url+'Administrative_document/get_kota', 
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

	if($('#province').length)
	$('#province').bind('tabsshow', function(event, ui) {
			$('#city_select').html('');
			$('#city_select').prop('disabled', false);
			var base_url = $('#base-url').val();
			$.ajax({
				url: base_url+'Administrative_document/get_kota', 
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
			url: base_url+'Administrative_document/get_kota', 
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
				url: base_url+'Administrative_document/get_kota', 
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
	$('#save_legal').click(function(){
		$('.collapse').collapse('show');

		stop = false;
		gagal = false;
		if (vendor_type == 'NASIONAL' || vendor_type == 'EXPEDITURE') {
			$('.legal_form').find('.uploadAttachment').each(function() {
				if ($(this).data('uploaded') != true) {
					$(this).css('color','red');
					gagal = true;
				}
			});

			/* DOMISILI */ 
				if ($('#address_domisili_no').val() == '') {
					$('#dom1').html('<span style="color:red;font-size:11.5px">Kolom tidak boleh kosong</span>');
					stop = true;
				}

				if ($('#address_domisili_date').val() == '') {
					$('#dom2').html('<span style="color:red;font-size:11.5px">Kolom tidak boleh kosong</span>');
					stop = true;
				}

				if ($('#address_domisili_exp_date').val() == '') {
					$('#dom3').html('<span style="color:red;font-size:11.5px">Kolom tidak boleh kosong</span>');
					stop = true;
				}

				if ($('#address_street').val() == '') {
					$('#dom4').html('<span style="color:red;font-size:11.5px">Kolom tidak boleh kosong</span>');
					stop = true;
				}

				if ($('#address_country').val() == '') {
					$('#dom5').html('<span style="color:red;font-size:11.5px">Kolom tidak boleh kosong</span>');
					stop = true;
				}

				if ($('#address_prop').val() == '') {
					$('#dom6').html('<span style="color:red;font-size:11.5px">Kolom tidak boleh kosong</span>');
					stop = true;
				}

				if ($('#city_select').val() == '') {
					$('#dom7').html('<span style="color:red;font-size:11.5px">Kolom tidak boleh kosong</span>');
					stop = true;
				}

				if ($('#address_postcode').val() == '') {
					if ($('#address_postcode').val().length != 5) {
						$('#dompos').html('<span style="color:red;font-size:11.5px">Masukkan 5 digit kode pos</span>');
						stop = true;
					}
				} else {
					if ($('#address_postcode').val().length != 5) {
						$('#dompos').html('<span style="color:red;font-size:11.5px">Masukkan 5 digit kode pos</span>');
						stop = true;
					}
				}
			/* END DOMISILI*/ 

			/* NPWP */ 
				if ($('#npwp_no').val() == '') {
					$('#npwp1').html('<span style="color:red;font-size:11.5px">Kolom tidak boleh kosong</span>');
					stop = true;
				}

				if ($('#npwp_address').val() == '') {
					$('#npwp2').html('<span style="color:red;font-size:11.5px">Kolom tidak boleh kosong</span>');
					stop = true;
				}

				if ($('#npwp_prop').val() == '') {
					$('#npwp3').html('<span style="color:red;font-size:11.5px">Kolom tidak boleh kosong</span>');
					stop = true;
				}

				if ($('#npwp_city').val() == '') {
					$('#npwp4').html('<span style="color:red;font-size:11.5px">Kolom tidak boleh kosong</span>');
					stop = true;
				}

				if ($('#npwp_postcode').val() == '') {
					if ($('#npwp_postcode').val().length != 5) {
						$('#npwp5').html('<span style="color:red;font-size:11.5px">Masukkan 5 digit kode pos</span>');
						stop = true;
					}
				} else {
					if ($('#npwp_postcode').val().length != 5) {
						$('#npwp5').html('<span style="color:red;font-size:11.5px">Masukkan 5 digit kode pos</span>');
						stop = true;
					}
				}
			/* END NPWP */ 

			/* PKP */ 
				if ($('#npwp_pkp').val() == 'PKP') {
					$('.legal_form_pkp').find('.uploadAttachment').each(function() {
						if ($(this).data('uploaded') != true) {
							$(this).css('color','red');
							gagal = true;
						}
					});
				};

				if ($('#npwp_pkp').val() == 'PKP') {
					if ($('#npwp_pkp_no').val() == '') {
						$('.mySpan').html('<span style="color:red;font-size:11.5px">Kolom tidak boleh kosong</span>');
						stop = true;
					}
				}

				if ($('#npwp_pkp').val() == '') {
					$('.pkpspan').html('<span style="color:red;font-size:11.5px">Kolom tidak boleh kosong</span>');
						stop = true;
				}
			/* END PKP */

			/* SIUP */ 
				if ($('#siup_issued_by').val() == '') {
					$('#siup1').html('<span style="color:red;font-size:11.5px">Kolom tidak boleh kosong</span>');
					stop = true;
				}
				
				if ($('#siup_no').val() == '') {
					$('#siup2').html('<span style="color:red;font-size:11.5px">Kolom tidak boleh kosong</span>');
					stop = true;
				}

				if ($('#siup_type').val() == '') {
					$('#siup3').html('<span style="color:red;font-size:11.5px">Kolom tidak boleh kosong</span>');
					stop = true;
				}

				if ($('#siup_from').val() == '') {
					$('#siup4').html('<span style="color:red;font-size:11.5px">Kolom tidak boleh kosong</span>');
					stop = true;
				}

				if ($('#siup_to').val() == '') {
					$('#siup5').html('<span style="color:red;font-size:11.5px">Kolom tidak boleh kosong</span>');
					stop = true;
				}
			/* END SIUP */

			/* TDP */ 
				if ($('#tdp_issued_by').val() == '') {
					$('#tdp1').html('<span style="color:red;font-size:11.5px">Kolom tidak boleh kosong</span>');
					stop = true;
				}

				if ($('#tdp_no').val() == '') {
					$('#tdp2').html('<span style="color:red;font-size:11.5px">Kolom tidak boleh kosong</span>');
					stop = true;
				}

				if ($('#tdp_from').val() == '') {
					$('#tdp3').html('<span style="color:red;font-size:11.5px">Kolom tidak boleh kosong</span>');
					stop = true;
				}

				if ($('#tdp_to').val() == '') {
					$('#tdp4').html('<span style="color:red;font-size:11.5px">Kolom tidak boleh kosong</span>');
					stop = true;
				}
			/* END TDP */ 
			
		} else if (vendor_type == 'INTERNASIONAL') {
			$('.legal_form.domisili').find('.uploadAttachment').each(function() {
				if ($(this).data('uploaded') != true) {
					$(this).css('color','red');
					gagal = true;
				}
			});

			/* DOMISILI */ 
				if ($('#address_domisili_no').val() == '') {
					$('#dom1').html('<span style="color:red;font-size:11.5px">Kolom tidak boleh kosong</span>');
					stop = true;
				}

				if ($('#address_domisili_date').val() == '') {
					$('#dom2').html('<span style="color:red;font-size:11.5px">Kolom tidak boleh kosong</span>');
					stop = true;
				}

				if ($('#address_domisili_exp_date').val() == '') {
					$('#dom3').html('<span style="color:red;font-size:11.5px">Kolom tidak boleh kosong</span>');
					stop = true;
				}

				if ($('#address_street').val() == '') {
					$('#dom4').html('<span style="color:red;font-size:11.5px">Kolom tidak boleh kosong</span>');
					stop = true;
				}

				if ($('#address_country').val() == '') {
					$('#dom5').html('<span style="color:red;font-size:11.5px">Kolom tidak boleh kosong</span>');
					stop = true;
				}

				if ($('#address_prop').val() == '') {
					$('#dom6').html('<span style="color:red;font-size:11.5px">Kolom tidak boleh kosong</span>');
					stop = true;
				}

				if ($('#city_select').val() == '') {
					$('#dom7').html('<span style="color:red;font-size:11.5px">Kolom tidak boleh kosong</span>');
					stop = true;
				}

				if ($('#address_postcode').val() == '') {
					if ($('#address_postcode').val().length != 5) {
						$('#dompos').html('<span style="color:red;font-size:11.5px">Masukkan 5 digit kode pos</span>');
						stop = true;
					}
				} else {
					if ($('#address_postcode').val().length != 5) {
						$('#dompos').html('<span style="color:red;font-size:11.5px">Masukkan 5 digit kode pos</span>');
						stop = true;
					}
				}
			/* END DOMISILI*/ 

		} else if (vendor_type == 'PERORANGAN') {
			$('.legal_form.npwp').find('.uploadAttachment').each(function() {
				console.log($(this).data('uploaded'));
				if ($(this).data('uploaded') != true) {
					$(this).css('color','red');
					gagal = true;
				}
			});

			/* NPWP */ 
				if ($('#npwp_no').val() == '') {
					$('#npwp1').html('<span style="color:red;font-size:11.5px">Kolom tidak boleh kosong</span>');
					stop = true;
				}

				if ($('#npwp_address').val() == '') {
					$('#npwp2').html('<span style="color:red;font-size:11.5px">Kolom tidak boleh kosong</span>');
					stop = true;
				}

				if ($('#npwp_prop').val() == '') {
					$('#npwp3').html('<span style="color:red;font-size:11.5px">Kolom tidak boleh kosong</span>');
					stop = true;
				}

				if ($('#npwp_city').val() == '') {
					$('#npwp4').html('<span style="color:red;font-size:11.5px">Kolom tidak boleh kosong</span>');
					stop = true;
				}

				if ($('#npwp_postcode').val() == '') {
					if ($('#npwp_postcode').val().length != 5) {
						$('#npwp5').html('<span style="color:red;font-size:11.5px">Masukkan 5 digit kode pos</span>');
						stop = true;
					}
				} else {
					if ($('#npwp_postcode').val().length != 5) {
						$('#npwp5').html('<span style="color:red;font-size:11.5px">Masukkan 5 digit kode pos</span>');
						stop = true;
					}
				}
			/* END NPWP */ 
			
			/* PKP */ 
				if ($('#npwp_pkp').val() == 'PKP') {
					$('.legal_form_pkp').find('.uploadAttachment').each(function() {
						if ($(this).data('uploaded') != true) {
							$(this).css('color','red');
							gagal = true;
						}
					});
				};

				if ($('#npwp_pkp').val() == 'PKP') {
					if ($('#npwp_pkp_no').val() == '') {
						$("npwp_pkp_no").prop("required", true);
						$('#mySpan').html('<span style="color:red;font-size:11.5px">Kolom tidak boleh kosong</span>');
						stop = true;
					};
				}
			/* END NPWP */ 
			
		} else {
			swal("Perhatian!", "Data Vendor Tidak Ada!", "warning")
			return false;
		};

		if (success) {
			if (gagal == true) {
				swal("Perhatian!", "Wajib mengunggah dokumen!", "warning")
				return false;
			}
			
			if (stop == true) {
				console.log('stop proses');
				return false;
			}

			var form_data = $('.legal_form_all').serialize();
			console.log(form_data);
			$.ajax({
				url : 'do_update_legal_data',
				method : 'post',
				data : form_data,
				success : function(result)
				{
					console.log(result);
					swal("Berhasil!", "Simpan data berhasil!", "success")
					url = 'Vendor_update_profile/data_vendor';
					window.location.href = url;
				}
			});
		};
		success = true;
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
			var akta_doc = $('#akta_no_doc_edit').val();
			var hakim = $('#pengesahan_hakim_doc_edit').val();
			var negara = $('#berita_acara_ngr_doc_edit').val();
			var form_data = $('.current_edited_akta').serialize()+'&file1='+akta_doc+'&file2='+hakim+'&file3='+negara;
			console.log(form_data);
			$.ajax({
				url : 'do_update_akta_data',
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

	$('.current_edited_board').bootstrapValidator({
		fields: {
			name: {
				validators: {
					notEmpty: {}
				}
			},
			pos: {
				validators: {
					notEmpty: {}
				}
			},
			telephone_no: {
				validators: {
					notEmpty: {},
					numeric: {}
				}
			},
			email_address: {
				validators: {
					notEmpty: {},
					emailAddress: {}
				}
			},
			ktp_no: {
				validators: {
					notEmpty: {}
				}
			},
			ktp_expired_date: {
				trigger: 'change keyup',
				validators: {
					notEmpty: {}
				}
			},
			npwp_no: {
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

	$('#update_komisaris').click(function(){
			var form_data = $('.komisaris_board').serialize();
			$.ajax({
				url : 'do_update_company_board',
				method : 'post',
				data : form_data,
				success : function(result)
				{
					console.log(result);
					if (result) { 
						swal("Berhasil", "Ubah data Berhasil!", "success")
						location.reload();
					}
					else { 
						swal("Gagal", "Ubah data gagal!", "error")
					}
				}
			}) 
	});

	$('#update_direksi').click(function(){
		$('.current_edited_board').bootstrapValidator('validate');

		gagal = false;
		$('.current_edited_board').find('.dir_upload').each(function() {
			if ($(this).data('uploaded') != true) {
				gagal = true;
			}
		});

		if(success){
			if (gagal == true) {
				swal("Perhatian!", "Wajib mengunggah dokumen!", "warning")
				return false;
			}
			var form_data = $('.current_edited_board').serialize();
			$.ajax({
				url : 'do_update_company_board',
				method : 'post',
				data : form_data,
				success : function(result)
				{
					console.log(result);
					if (result) { 
						swal("Berhasil", "Ubah data Berhasil!", "success")
						location.reload();
					}
					else { 
						swal("Gagal", "Ubah data gagal!", "error")
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

			var akta_doc = $('#akta_no_doc').val();
			var hakim = $('#pengesahan_hakim_doc').val();
			var negara = $('#berita_acara_ngr_doc').val();
			var form_data = $('.insert_akta').serialize()+'&file1='+akta_doc+'&file2='+hakim+'&file3='+negara;
			
			$.ajax({
				url : 'do_insert_akta_pendirian',
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
			url: base_url+'Administrative_document/get_kota', 
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
				url: base_url+'Administrative_document/get_kota', 
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
            url: base_url+'Administrative_document/get_kota', 
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
            url: base_url+'Administrative_document/get_kota', 
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

	/* COMPANY BOARD */
	$('.insert_director').bootstrapValidator({
		fields: {
			name: {
				validators: {
					notEmpty: {}
				}
			},
			pos: {
				validators: {
					notEmpty: {}
				}
			},
			telephone_no: {
				validators: {
					notEmpty: {},
					numeric: {}
				}
			},
			email_address: {
				validators: {
					notEmpty: {},
					emailAddress: {}
				}
			},
			ktp_no: {
				validators: {
					notEmpty: {}
				}
			},
			ktp_expired_date: {
				trigger: 'change keyup',
				validators: {
					notEmpty: {}
				}
			},
			npwp_no: {
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

	$('#addCommissioner').click(function(){
		if (success) {
			var form_data = $('.insert_commissioner').serialize();
			console.log(form_data);
			$.ajax({
				url : 'do_insert_company_board',
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

	$('#addDirector').click(function(){
		$('.insert_director').bootstrapValidator('validate');
		
		gagal = false;
		$('.insert_director').find('.dir_upload').each(function() {
			if ($(this).data('uploaded') != true) {
				gagal = true;
			}
		});
		
		if (success) {
			if (gagal == true) {
				swal("Perhatian!", "Wajib mengunggah dokumen!", "warning")
				return false;
			}
			var form_data = $('.insert_director').serialize();
			console.log(form_data);
			$.ajax({
				url : 'do_insert_company_board',
				method : 'post',
				data : form_data,
				success : function(result)
				{
					// alert('Berhasil menambahkan dewan direksi!');
					swal("Berhasil!", "Tambah data berhasil!", "success")
					location.reload();
				}
			})  
		};
		success = true;
	});

	$('#save_company_board').click(function(){
		if (vendor_type == 'NASIONAL' || vendor_type == 'EXPEDITURE' || vendor_type == 'INTERNASIONAL') {
			if ($('#vendor_board_director #empty_row').length == 1) {
				$('.insert_director').bootstrapValidator('validate');
			};
		} else {
			swal("Perhatian!", "Data Vendor Tidak Ada!", "warning")
			return false;
		};
		if (success) {
			continueProcess = false;
			if (vendor_type == 'NASIONAL' || vendor_type == 'EXPEDITURE' || vendor_type == 'INTERNASIONAL') {
				if ($('#vendor_board_director #empty_row').length != 1) {
					continueProcess = true;
				}
				else {
					continueProcess = false;
				}
			}
			else {
				continueProcess = true;
			}
			if (continueProcess) {
				swal("Berhasil!", "Simpan data berhasil!", "success")
				window.location.href = "Vendor_update_profile";
			};
		};
		success = true;
	});

// EDIT KOMISARIS
	$('.update_komisaris_data').click(function(){
		var komisaris_id = $(this).closest('tr').attr('id');
		parent = $(this).parent().parent();
		$('#komisaris_id').val(komisaris_id);
		var base_url = $('#base-url').val();
		$.ajax({
			url:base_url+'Vendor_update_profile/get_board_edit',
			dataType: "json",
			type:"post",
			data:{"id":komisaris_id},
			success:function(data){
				$.each(data, function(i,komisaris){
				
					$('#name').val(komisaris.NAME);
					$('#pos').val(komisaris.POS);
					$('#telephone_no').val(komisaris.TELEPHONE_NO);
					$('#email_address').val(komisaris.EMAIL_ADDRESS);
					$('#ktp_no').val(komisaris.KTP_NO);
					$('#ktp_expired_date').val(parent.find('.ktp_date').html());
					$('#npwp_no').val(komisaris.NPWP_NO);
				});
			}
		});

		$('#updateKomisarisDataModal').modal();

	});
// END KOMISARIS

// EDIT DIREKTUR
	$('.update_direktur_data').click(function(){
		var direksi_id = $(this).closest('tr').attr('id');
		parent = $(this).parent().parent();
		$('#direksi_id').val(direksi_id);
		var base_url = $('#base-url').val();
		$.ajax({
			url:base_url+'Vendor_update_profile/get_board_edit',
			dataType: "json",
			type:"post",
			data:{"id":direksi_id},
			success:function(data){
				$.each(data, function(i,direksi){
				
					$('#direksi_name').val(direksi.NAME);
					$('#direksi_pos').val(direksi.POS);
					$('#direksi_telephone_no').val(direksi.TELEPHONE_NO);
					$('#direksi_email_address').val(direksi.EMAIL_ADDRESS);
					$('#direksi_ktp_no').val(direksi.KTP_NO);
					$('#direksi_ktp_expired_date').val(parent.find('.dir_ktp_date').html());
					$('#direksi_npwp_no').val(direksi.NPWP_NO);
				});
			}
		});

		$('#updateDireksiDataModal').modal();

	});
// END DIREKTUR

	/* BANK AND FINANCIAL DATA */
	if (url[url.length-1].toLowerCase() == "bank_and_financial_data") {
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
					},
					reference_bank: {
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
					},
					reference_bank: {
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
			gagal = false;
			if (vendor_type == 'INTERNASIONAL') {
				bootstrapValidator.enableFieldValidators('swift_code');
			};
			$('.insert_bank_data').bootstrapValidator('validate');

			$('.insert_bank_data').find('.u_bank').each(function() {
				if ($(this).data('uploaded') != true) {
					$(this).css('color','red');
					gagal = true;
				}
			});

			if (success) {
				if (gagal == true) { 
					swal("Perhatian!", "Wajib mengunggah dokumen!", "warning")
					return false;
				}
				var form_data = $('.insert_bank_data').serialize();
				console.log(form_data);
				$.ajax({
					url : 'do_insert_bank_data',
					method : 'post',
					data : form_data,
					success : function(result)
					{
						if (result == "OK") {
							swal("Berhasil!", "Ubah data berhasil!", "success")
							location.reload();
						}
						else {
							swal("Gagal", "Ubah data gagal!", "error")
						}
					}
				})  
			};
			success = true;
		});

		$('.insert_financial_report').bootstrapValidator({
			fields: {
				fin_rpt_year: {
					trigger: 'change keyup',
					validators: {
						notEmpty: {},
						numeric: {}
					}
				},
				fin_rpt_type: {
					validators: {
						notEmpty: {}
					}
				},
				fin_rpt_currency: {
					validators: {
						notEmpty: {}
					}
				},
				fin_rpt_asset_value: {
					trigger: 'change keyup',
					validators: {
						notEmpty: {}
					}
				},
				fin_rpt_hutang: {
					trigger: 'change keyup',
					validators: {
						notEmpty: {}
					}
				},
				fin_rpt_revenue: {
					trigger: 'change keyup',
					validators: {
						notEmpty: {}
					}
				},
				fin_rpt_netincome: {
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

		$('#addFinReport').click(function(){
			$('.insert_financial_report').bootstrapValidator('validate');
			if (success) {
				var form_data = $('.insert_financial_report').serialize();
				console.log(form_data);
				$.ajax({
					url : 'do_insert_financial_report',
					method : 'post',
					data : form_data,
					success : function(result)
					{
						if (result == "OK") {
							swal("Berhasil!", "Ubah data berhasil!", "success")
							location.reload();
						}
						else {
							swal("Gagal", "Ubah data gagal!", "error")
						}
					}
				}) 
			};
			success = true; 
		});

		$('#save_financial_data').click(function(){
			if (vendor_type == 'NASIONAL' || vendor_type == 'EXPEDITURE' || vendor_type == 'INTERNASIONAL') {
				$('.update_financial_data').bootstrapValidator('validate');
			} else {
				swal("Perhatian!", "Data Vendor Tidak Ada!", "warning")
				return false;
			};
			if (success) {
				var form_data = $('.update_financial_data').serialize();
				console.log(form_data);
				$.ajax({
					url : 'do_update_financial_data',
					method : 'post',
					data : form_data,
					success : function(result)
					{ 
						swal("Berhasil!", "Ubah data berhasil!", "success")
						url = 'Vendor_update_profile/data_vendor';
						window.location.href = url;
					},
					error : function(result){
						swal("Gagal", "Ubah data gagal!", "error") 
					}
				})  
			};
			success = true;
		});

		$('#saveandcont_financial_data').click(function(){
			if ($('#vendor_bank #empty_row').length == 1) {
				$('.insert_bank_data').bootstrapValidator('validate');
			};
			if (vendor_type == 'NASIONAL' || vendor_type == 'EXPEDITURE' || vendor_type == 'INTERNASIONAL') {
				$('.update_financial_data').bootstrapValidator('validate');
			}
			if (vendor_type == 'NASIONAL' || vendor_type == 'EXPEDITURE') {
				if ($('#vendor_fin_report #empty_row').length == 1) {
					$('.insert_financial_report').bootstrapValidator('validate');
				};
			};
			if (success) {
				console.log('continue');
				continueProcess = false;
				if (vendor_type == 'NASIONAL' || vendor_type == 'EXPEDITURE' || vendor_type == 'INTERNASIONAL') {
					if ($('#vendor_board_director #empty_row').length != 1) {
						continueProcess = true;
					}
					else {
						continueProcess = false;
					}
				}
				else {
					continueProcess = true;
				}
				if (continueProcess) {
					var form_data = $('.update_financial_data').serialize();
					console.log(form_data);
					$.ajax({
						url : 'do_update_financial_data',
						method : 'post',
						data : form_data,
						success : function(result)
						{
							window.location.href = "../Technical_document/good_and_service_data";
						}
					})
				};
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
				url:base_url+'Administrative_document/get_bank_edit',
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

						$('.u_bank_e').show();
				        $('#bank_upload_lama').val(bank.REFERENCE_FILE);
				        $('.file_bank').val('');

					});
				}
			});
			$('#updateRekeningModal').modal();
		});

		$('.update_fin_report').click(function(){
			var fin_rpt_id = $(this).closest('tr').attr('id');
			console.log(fin_rpt_id);
			$('#fin_rpt_id').val(fin_rpt_id);
			var base_url = $('#base-url').val();
			$('#fin_rpt_id').val(fin_rpt_id);
			$.ajax({
				url:base_url+'Administrative_document/get_fin_rpt_edit',
				dataType: "json",
				type:"post",
				data:{"fin_rpt_id":fin_rpt_id},
				success:function(data){
					$.each(data, function(i,fin_rpt){
						$('#fin_rpt_year_edit').val(fin_rpt.FIN_RPT_YEAR);
						$('#fin_rpt_year_edit').trigger('keyup');
						$('#fin_rpt_type_edit').val(fin_rpt.FIN_RPT_TYPE);
						$('#fin_rpt_type_edit').trigger('keyup');;
						$('#fin_rpt_currency_edit').val(fin_rpt.FIN_RPT_CURRENCY);
						$('#fin_rpt_currency_edit').trigger('keyup');;
						$('#fin_rpt_asset_value_edit').val(fin_rpt.FIN_RPT_ASSET_VALUE);
						$('#fin_rpt_asset_value_edit').trigger('keyup');;
						$('#fin_rpt_hutang_edit').val(fin_rpt.FIN_RPT_HUTANG);
						$('#fin_rpt_hutang_edit').trigger('keyup');;
						$('#fin_rpt_revenue_edit').val(fin_rpt.FIN_RPT_REVENUE);
						$('#fin_rpt_revenue_edit').trigger('keyup');;
						$('#fin_rpt_netincome_edit').val(fin_rpt.FIN_RPT_NETINCOME);
						$('#fin_rpt_netincome_edit').trigger('keyup');;

						$('.uploadAttachment.u_rpt_e').show();
				        $('#file_lama_rpt').val(fin_rpt.FILE_UPLOAD);
				        $('.file_rpt').val('');
					});
				}
			});
			$('#updateLaporanKeuanganModal').modal();
		});

		$('.input-group.date.year').datepicker({
            format: " yyyy",
            viewMode: "years", 
            minViewMode: "years"
        });
	};

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

	// UPDATE BANK AND FINANCE

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
			},
			reference_bank_edit: {
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
				url : 'do_update_bank_financial',
				method : 'post',
				data : form_data,
				success : function(result)
				{
					console.log(result);
					if (result == "OK") {
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

	$('.current_edited_laporan_keuangan').bootstrapValidator({
			fields: {
				fin_rpt_year: {
					trigger: 'change keyup',
					validators: {
						notEmpty: {},
						numeric: {}
					}
				},
				fin_rpt_type: {
					validators: {
						notEmpty: {}
					}
				},
				fin_rpt_currency: {
					validators: {
						notEmpty: {}
					}
				},
				fin_rpt_asset_value: {
					trigger: 'change keyup',
					validators: {
						notEmpty: {}
					}
				},
				fin_rpt_hutang: {
					trigger: 'change keyup',
					validators: {
						notEmpty: {}
					}
				},
				fin_rpt_revenue: {
					trigger: 'change keyup',
					validators: {
						notEmpty: {}
					}
				},
				fin_rpt_netincome: {
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
	
	$('#update_laporan_keuangan_data_button').click(function(){
		$('.current_edited_laporan_keuangan').bootstrapValidator('validate');
		if(success){
			var form_data = $('.current_edited_laporan_keuangan').serialize();
			$.ajax({
				url : 'do_update_laporan_keuangan',
				method : 'post',
				data : form_data,
				success : function(result)
				{
					console.log(result);
					if (result == "OK") {
						swal("Berhasil!", "Updating data berhasil!", "success")
						location.reload();
					}
					else {
						swal("Gagal!", "Updating data gagal!", "error")

					}
				}
			})  
		}
	});

	$(".select2").select2();

/* SAVE PANEL */

	/* GENERAL DATA */
    $('#save_panel_info_perusahaan').click(function(){
    	var vendor_id = $('#vendor_id').val();
    	// alert(vendor_id); return false;
    	var data_container = $('#info_perusahaan').val();
			$.ajax({
				url : 'do_insert_panel',
				method : 'post',
				data : {vendor_id : vendor_id, container : data_container},
				success : function(result)
				{
					swal("Berhasil!", "Simpan data berhasil!", "success")	
				}
			}) 
	});

	$('#save_panel_alamat_perusahaan').click(function(){
    	var vendor_id = $('#vendor_id').val();
    	var data_container = $('#alamat_perusahaan').val();
			$.ajax({
				url : 'do_insert_panel',
				method : 'post',
				data : {vendor_id : vendor_id, container : data_container},
				success : function(result)
				{
					swal("Berhasil!", "Simpan data berhasil!", "success")	
				}
			}) 
	});

	$('#save_panel_kontak_perusahaan').click(function(){
    	var vendor_id = $('#vendor_id').val();
    	var data_container = $('#kontak_perusahaan').val();
			$.ajax({
				url : 'do_insert_panel',
				method : 'post',
				data : {vendor_id : vendor_id, container : data_container},
				success : function(result)
				{
					swal("Berhasil!", "Simpan data berhasil!", "success")	
				}
			}) 
	});

	/* LEGAL DATA, BANK, FIN_RPT */

	$('.save_panel').click(function(){

		var val = $(this).val();
		if (val == 'Domisili Perusahaan') {
			var data_container = val;
		} else if (val == 'NPWP'){
			var data_container = val;
		} else if (val == 'PKP'){
			var data_container = val;
		} else if (val == 'SIUP'){
			var data_container = val;
		} else if (val == 'TDP'){
			var data_container = val;
		} else if (val == 'Angka Pengenal Importir'){
			var data_container = val;
		} else if (val == 'Modal Sesuai Dengan Akta Terakhir'){
			var data_container = val;
		};

    	var vendor_id = $('[name=vendor_id]').val();

			$.ajax({
				url : 'do_insert_panel',
				method : 'post',
				data : {vendor_id : vendor_id, container : data_container},
				success : function(result)
				{
					swal("Berhasil!", "Simpan data berhasil!", "success")	
				}
			}) 
	});
/* END PANEL */

	$('#npwp_pkp').on('change', function() {
		var nyo = $(this).val();
			if(nyo == 'PKP'){
				$('#npwp_pkp_no').removeAttr('disabled');
			} else {
				$('#npwp_pkp_no').attr('disabled', true);
			}
	});
	
	$('#npwp_pkp').each(function() {
		if($('#npwp_pkp').val() != 'PKP'){
    		$('#npwp_pkp_no').attr('disabled', true);
		}
	});

// DELETE AKTA
	$('.delete_upload_file').on('click', function() {

		var cek = $(this).attr('id');

		if (cek == 'del_akta') {
			var data_id = $('#akta_id').val(),
				data_file = $('#akta_no_doc').val(),
				field = $('#akta_no_doc'),
				upload_file = $('.uploadAttachment.akta_upload'),
				namespan = $('.filenamespan.akta'),
				progressBar = $('.progress-bar.akta'),
				progressOuter = $('.progress-striped.akta');
		} else if (cek == 'del_hakim'){
			var data_id = $('#akta_id').val(),
				data_file = $('#pengesahan_hakim_doc').val(),
				field = $('#pengesahan_hakim_doc'),
				upload_file = $('.uploadAttachment.hakim'),
				namespan = $('.filenamespan.hakim'),
				progressBar = $('.progress-bar.kehakiman'),
				progressOuter = $('.progress-striped.kehakiman');
		} else if (cek == 'del_negara') {
			var data_id = $('#akta_id').val(),
				data_file = $('#berita_acara_ngr_doc').val(),
				field = $('#berita_acara_ngr_doc'),
				upload_file = $('.uploadAttachment.negara'),
				namespan = $('.filenamespan.negara'),
				progressBar = $('.progress-bar.berita_negara'),
				progressOuter = $('.progress-striped.berita_negara');
		} 

        $.ajax({
            url: 'deleteFile_akta',
            type: 'POST',
            data: { id : data_id, filename: data_file },
            beforeSend: function() {
                progressOuter.css('display','block');
            },
        })
        .done(function(data) { 
            progressOuter.css('display','none');
            field.val("");
            upload_file.html('Upload File (2MB Max)');
            namespan.html('');
        })
        .fail(function(data) {
            progressOuter.css('display','none');
            console.log("error");
            console.log(data);
        });
    });
// END DELETE AKTA

// EDIT AKTA
	$('.update_legal_data').click(function(){
		var akta_id = $(this).closest('tr').attr('id');
		parent = $(this).parent().parent();
		$('#akta_id').val(akta_id);
		var base_url = $('#base-url').val();
		$.ajax({
			url:base_url+'Vendor_update_profile/get_akta_edit',
			dataType: "json",
			type:"post",
			data:{"akta":akta_id},
			success:function(data){
				$.each(data, function(i,akta){
				
					$('#akta_no').val(akta.AKTA_NO);
					$('#akta_type').val(akta.AKTA_TYPE);
					$('#tgl_akta').val(parent.find('.ak_date').html());
					$('#notaris_name').val(akta.NOTARIS_NAME);
					$('#notaris_address').val(akta.NOTARIS_ADDRESS);
					$('#pengesahan_hakim_edit').val(parent.find('.hk_date').html());
					$('#berita_acara_ngr_edit').val(parent.find('.ngr_date').html());
					
					// FILE AKTA 
					$('.uploadAttachment.u_akta').show();
			        if(akta.AKTA_NO_DOC != null){
			        	$('.uploadAttachment.u_akta').hide();
			        }
			        $('#file_akta_upload').val(akta.AKTA_NO_DOC);
			        $('.file_akta').val('');
			        
			        // FILE HAKIM
			        $('.uploadAttachment.u_hakim').show();
			        if(akta.PENGESAHAN_HAKIM_DOC != null){
			        	$('.uploadAttachment.u_hakim').hide();
			        }
			        $('#file_hakim_upload').val(akta.PENGESAHAN_HAKIM_DOC);
			        $('.file_hakim').val('');

			        // FILE NEGARA
			        $('.uploadAttachment.u_negara').show();
			        if(akta.BERITA_ACARA_NGR_DOC != null){
			        	$('.uploadAttachment.u_negara').hide();
			        }
			        $('#file_negara_upload').val(akta.BERITA_ACARA_NGR_DOC);
			        $('.file_negara').val('');


				});
			}
		});

		$('#updateLegalDataModal').modal();

	});
// END EDIT AKTA

// DELETE EDIT AKTA
	$('.delete_file_akta_edit').click(function(){

		var cek = $(this).attr('id');

		if (cek == 'e_del_akta') {

			var data_id = $('#akta_id').val(),
				file_lama = $("#file_akta_upload").val(),
				file_baru = $("#akta_no_doc_edit").val(),
				field = $('#akta_no_doc_edit'),
				upload_file = $('.uploadAttachment.u_akta'),
				namespan = $('.filenamespan.f_akta'),
				progressBar = $('.progress-bar.b_akta'),
				progressOuter = $('.progress-striped.p_akta');

		} else if (cek == 'e_del_hakim'){

			var data_id = $('#akta_id').val(),
				file_lama = $('#file_hakim_upload').val(),
				file_laru = $('#pengesahan_hakim_doc_edit').val(),
				field = $('#pengesahan_hakim_doc_edit'),
				upload_file = $('.uploadAttachment.u_hakim'),
				namespan = $('.filenamespan.f_hakim'),
				progressBar = $('.progress-bar.b_kehakiman'),
				progressOuter = $('.progress-striped.p_kehakiman');

		} else if (cek == 'e_del_negara') {

			var data_id = $('#akta_id').val(),
				file_lama = $('#file_negara_upload').val(),
				file_baru = $('#berita_acara_ngr_doc_edit').val(),
				field = $('#berita_acara_ngr_doc_edit'),
				upload_file = $('.uploadAttachment.u_negara'),
				namespan = $('.filenamespan.f_negara'),
				progressBar = $('.progress-bar.b_berita_negara'),
				progressOuter = $('.progress-striped.p_berita_negara');
		}

    	if(file_lama != ''){
    		file = file_lama;
    	}else{
    		file = file_baru;
    	}

        $.ajax({
            url: 'deleteFile_akta',
            type: 'POST',
            data: {
                id : $("#akta_id").val(),
                chek : cek,
                filename: file
            },
            beforeSend: function() {
                progressOuter.css('display','block');
            },
        })
        .done(function(data) { 
            progressOuter.css('display','none');  
            field.val("");
            upload_file.show();
            upload_file.html('Upload File (2MB Max)');
            namespan.html('');
        })
        .fail(function(data) {
            progressOuter.css('display','none');
            console.log("error");
            console.log(data);
        });
    });
// END DELETE EDIT AKTA
	
	$('.delete_upload_doc').click(function(){
		$(this).parent().parent().find('.uploadAttachment').data('uploaded', false);
		$(this).parent().parent().find('.uploadAttachment').html('Upload File (2MB Max)');
		$(this).parent().parent().find('.namafile').val('');
		$(this).parent().children().remove();
	});


//DELETE FILE
$('.delete_upload_file_ba').click(function(){
	var cek = $(this).attr('id');

	if (cek == 'del_komisaris') {
		var data_file = $('#kom_upload').val(),
			upload_file = $('.uploadAttachment.u_komisaris'),
			namespan = $('.filenamespan.f_komisaris'),
			progressOuter = $('.progress-striped.p_komisaris');
	} else if (cek == 'del_direktur') {
		var data_file = $('#dir_upload').val(),
			upload_file = $('.uploadAttachment.u_direktur'),
			namespan = $('.filenamespan.f_direktur'),
			progressOuter = $('.progress-striped.p_direktur');
	} else if (cek == 'del_komisaris_e') {
		var data_file = $('#kom_upload_e').val(),
			upload_file = $('.uploadAttachment.u_komisaris_e'),
			namespan = $('.filenamespan.f_komisaris_e'),
			progressOuter = $('.progress-striped.p_komisaris_e');
	} else if (cek == 'del_direktur_e') {
		var data_file = $('#dir_upload_e').val(),
			upload_file = $('.uploadAttachment.u_direktur_e'),
			namespan = $('.filenamespan.f_direktur_e'),
			progressOuter = $('.progress-striped.p_direktur_e');
	} else if (cek == 'del_bank') {
		var data_file = $('#bank_upload').val(),
			upload_file = $('.uploadAttachment.u_bank'),
			namespan = $('.filenamespan.f_bank'),
			progressOuter = $('.progress-striped.p_bank');
	} else if (cek == 'del_bank_e') {
		var data_file = $('#bank_upload_e').val(),
			upload_file = $('.uploadAttachment.u_bank_e'),
			namespan = $('.filenamespan.f_bank_e'),
			progressOuter = $('.progress-striped.p_bank_e');
	} else if (cek == 'del_rpt') {
		var data_file = $('#rpt_upload').val(),
			upload_file = $('.uploadAttachment.rpt'),
			namespan = $('.filenamespan.f_rpt'),
			progressOuter = $('.progress-striped.p_rpt');
	} else if (cek == 'del_rpt_e') {
		var data_file = $('#file_lama_rpt').val(),
			upload_file = $('.uploadAttachment.u_rpt_e'),
			namespan = $('.filenamespan.f_rpt_e'),
			progressOuter = $('.progress-striped.p_rpt_e');
	}

	$.ajax({
        url: 'deleteFile_ba',
        type: 'POST',
        data: { filename: data_file },
        beforeSend: function() {
            progressOuter.css('display','block');
        },
    })
    .done(function(data) { 
        progressOuter.css('display','none');
        upload_file.html('Upload File (2MB Max)');
        namespan.html('');
    })
    .fail(function(data) {
        progressOuter.css('display','none');
        console.log("error");
        console.log(data);
    });
	}) 
// END DELETE FILE

	$(".text-uppercase").keyup(function () {
	    this.value = this.value.toLocaleUpperCase();
	});
})