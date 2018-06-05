$(document).ready(function(){

	$('#create').click(function(e){ 
		var form_data = $('#formInitialize').serialize();
		console.log(form_data);
		$('#formInitialize').bootstrapValidator('validate');

		if (success) {
			
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
						url : 'Vendor_regis_bypass/do_create_vendor',
						method : 'post',
						data : form_data,
						success : function(result)
						{
							if (result == 'OK') {	
								console.log(result);
								swal("Berhasil!", "Create Account berhasil!", "success")
								location.reload();
							}else{
								swal("Gagal!", "Create Account gagal!", "error")
							}
						}
					});
                } else {}
            })
		};
	})

	$('#newregis').click(function(e){
		var next_regis = $('#regis').val(1); 
		var form_data = $('#formInitialize').serialize() + '&' + $.param(next_regis);
 		console.log(form_data);
		
		$('#formInitialize').bootstrapValidator('validate');

		if (success) {
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
						url : 'Vendor_regis_bypass/do_create_vendor',
						method : 'post',
						data : form_data,
						success : function(result)
						{
							console.log(result);
							swal("Berhasil!", "Create Account berhasil!", "success")
							url = 'Vendor_regis_bypass/vendor_regis/'+result;
							window.location.href = url;
						}
					});
                } else {}
            })
		};
	})

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
                    	url: 'Vendor_regis_bypass/checkUsernameHasTaken/'+$('#company').val(),
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
						url: 'Vendor_regis_bypass/checkEmailHasTaken/'+$('#company').val(),
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
			vendor_type: {
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

	$('#formInitializesap').bootstrapValidator({
		fields: {
			company_name: {
				validators: {
					notEmpty: {}
				}
			},
			vendorno: {
				validators: {
					notEmpty: {},
					remote : {
                    	type: 'POST',
                    	url: 'Vendor_regis_sap/check_vendor/'+$('#company').val(),
                    	delay:2000
                    }
				}
			},
			username: {
				validators: {
					notEmpty: {},
					remote : {
                    	type: 'POST',
                    	url: 'Vendor_regis_sap/checkUsernameHasTaken/'+$('#company').val(),
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
						url: 'Vendor_regis_sap/checkEmailHasTaken/'+$('#company').val(),
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
			vendor_type: {
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

	$(".text-uppercase").keyup(function () {
	    this.value = this.value.toLocaleUpperCase();
	});
})
