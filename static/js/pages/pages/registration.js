var base_url = $('#base-url').val();
var url = document.location.href.split('/');
$(function() {
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

	$(".text-uppercase").keyup(function () {
	    this.value = this.value.toLocaleUpperCase();
	});
	
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