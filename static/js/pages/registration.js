var base_url = $('#base-url').val();
var url = document.location.href.split('/');
$(function() {

	$("input#username").on({
		keydown: function(e) {
			if (e.which === 32)
				return false;
		},
		change: function() {
			this.value = this.value.replace(/\s/g, "");
		}
	});

	$('#company_name').on('keyup', function() {
		var value = $(this).val();
		var count = 0;  
		var iChars = "!@#$%^&*()+=-[]\\\';,./{}|\":<>?";  
		for (var i = 0; i < value.length; i++){  
			if (iChars.indexOf(value.charAt(i)) != -1){  
				count++;  
			}  
		}  
		if (count > 0){  
			document.getElementById("tombol_registration").disabled = true;
			$('#company_name1').html('<span style="color:red;font-size:11.5px">Kolom tidak boleh ada spesial karakter</span>');
			stop = true;
		} else {  
			document.getElementById("tombol_registration").disabled = false;  
			$('#company_name1').html('');
		}  
	});

	$('#reg_button').on('click', function() {
		var companyid = $('#Company option:selected').val();
		$('#reg_button').button('Loading');
		if (companyid != 0) {
			$.ajax({
				url: base_url+'Register/getRegistrationDateStatus',
				type: 'POST',
				dataType: 'json',
				data: {company: companyid}
			})
			.done(function(e) {
				console.log(e);
				$('#reg_button').button('reset');
				if (e.flag == 1) {
					$('#company').slideUp('slow');
					$('#terms').fadeIn('slow');
				}
				else {
					alert(e.message);
				};
			});
		};
	});
	$('#close').on('click', function() {
		$('#company').fadeIn('slow');
		$('#terms').slideUp('slow');
	});

	$('.npwp_no').hide();
	$('.type_change').on('change', function() {
		$('#vendor').val($('#vendor_type option:selected').text()); 
		name = $('#vendor_type').val();
		if (name == "INTERNASIONAL") {
			$('.npwp_no').hide();
		}
		else {
			$('.npwp_no').show();
		}
		$.ajax({
			url:base_url+'Register/get_prefix',
			method : 'post',
			data : "name="+name,
			success: function(data){
				$("#prefix").html(data);
			}
		});
		return false;
	});

	$(".text-uppercase").keyup(function () {
		this.value = this.value.toLocaleUpperCase();
	});

	$('.npwp_no').mask("99.999.999.9-999.999");

	$('.npwp_no').on('change', function() {
		if ($('#npwp_no').val() == '') {
			$('#npwp1').html('<span style="color:red;font-size:11.5px">Kolom tidak boleh kosong</span>');
			stop = true;
		} else {
			$('#npwp1').html('');
		}
	});

	// if ($('#npwp_no').val() == '') {
	// 	$('#npwp1').html('<span style="color:red;font-size:11.5px">Kolom tidak boleh kosong</span>');
	// 	stop = true;
	// }
	
	$('#formInitialize').bootstrapValidator({
		fields: {
			company_name: {
				validators: {
					notEmpty: {}
				}
			},
			username: {
				validators: {
					notEmpty: {},
					remote : {
						type: 'POST',
						url: 'checkUsernameHasTaken/'+$('#companyid').val(),
						delay:2000
					},
					stringLength: {
						min: 4,
						max: 15,
						message: 'The username must be more than 4 and less than 15 characters long'
					}

				}
			},
			email: {
				validators: {
					notEmpty: {},
					remote: {
						type: 'POST',
						url: 'checkEmailHasTaken/'+$('#companyid').val(),
						delay: 2000
					}
				}
			},
			npwp_no: {
				validators: {
					notEmpty: {},
					remote: {
						type: 'POST',
						url: 'checkNPWPHasTaken/'+$('#companyid').val(),
						delay: 2000
					}
				}
			},
			password: {
				validators: {
					notEmpty: {}
				}
			},
			password2: {
				validators: {
					notEmpty: {},
					identical: {
						field: 'password'
					}
				}
			},
			captcha: {
				validators: {
					notEmpty: {},
					identical: {
						field: 'captcha2'
					}
				}
			},
			captcha2: {
				validators: {
					notEmpty: {}
				}
			},
			vendor_type: {
				validators: {
					notEmpty: {}
				}
			}
		}
	});
});