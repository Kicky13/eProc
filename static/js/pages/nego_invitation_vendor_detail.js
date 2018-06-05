var base_url = $('#base-url').val();

function cek_hargawarning(e) {
	e = $(e);
    e.parent().parent().find(".cek_status").val("false");
    var dat = e.val();
    dat = dat.replace(/,/g, "");
    $("#save_bidding").addClass("hidden");
    $.ajax({
        url: $("#base-url").val() + 'Nego_invitation_vendor/cek_toleransi/' + e.parent().parent().find(".tit_id").val() + '/' + dat,
        type: 'post',
        dataType: 'json',
    })
    .done(function(data) {
        e.parent().parent().find(".cek_status").val(data.status);
        e.parent().parent().find(".cek_warning").val(data.warning);
    })
    .fail(function() {
        console.log("error");
    })
    .always(function(data) {
    	console.log(data);
        $("#save_bidding").removeClass("hidden");
    });
}

function removeCommas(x) {
    return x.replace(/,/g, "");
}

$(document).ready(function() {
	var file_limit=2097152;//byte
    var file_ext_accept=['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'odt', 'html', 'zip'];
	$('#file_negosiasi').bind('change', function() {
		var file=this.files[0];
		var file_name = file.name;
		var file_size = file.size;
		var file_ext = file.name.replace(/^.*\./, '');

		if($.inArray(file_ext, file_ext_accept) == -1){
		    // popupWarning('ERROR','Type File yang di-upload adalah '+file_ext+' yang diperbolehkan hanya: '+file_ext_accept.join(' ,'));
		    swal({
				  title: 'ERROR',
				  text: 'Type File yang di-upload adalah '+file_ext+' yang diperbolehkan hanya: '+file_ext_accept.join(' ,'),
				  type: 'error',
				  cancelButtonColor: '#d33',
				  confirmButtonColor: '#92c135',
				  confirmButtonText: 'OK',
				  cancelButtonText: 'Tidak',
				  //cancelButtonClass: 'btn btn-danger',
				  //confirmButtonClass: 'btn btn-success',
				  closeOnConfirm: true,
				  closeOnCancel: true,
				  showCancelButton: false,
				  
					}).then(function(isConfirm) {
					  return isConfirm;
				});
			state = false;
		    $(this).val("");
		}
		if(file_size>file_limit){
		    // popupWarning('ERROR','File yang di-upload sebesar '+file_size/1048576+' MB, File tidak boleh melebihi '+file_limit/1048576+' MB');
		    swal({
				  title: 'ERROR',
				  text: 'File yang di-upload sebesar '+file_size/1048576+' MB, File tidak boleh melebihi '+file_limit/1048576+' MB',
				  type: 'error',
				  cancelButtonColor: '#d33',
				  confirmButtonColor: '#92c135',
				  confirmButtonText: 'OK',
				  cancelButtonText: 'Tidak',
				  //cancelButtonClass: 'btn btn-danger',
				  //confirmButtonClass: 'btn btn-success',
				  closeOnConfirm: true,
				  closeOnCancel: true,
				  showCancelButton: false,
				  
					}).then(function(isConfirm) {
					  return isConfirm;
				});
			state = false;
		    $(this).val("");
		}
    });

	if ($(".must_auto_numeric").length > 0) {
		$(".must_auto_numeric").autoNumeric('init', {lZero: 'deny'});
	}
//	$("#form_ub").validationEngine({promptPosition : "topRight", scroll: false});
	
	$(".input_price_value").change(function() {
	//	cek_hargawarning(this);
	})

	$(".delete_file").click(function(){
		swal({
			  title: 'Yakin Menghapus File?',
			  text: 'File akan dihapus',
			  type: 'warning',
			  
			  cancelButtonColor: '#d33',
			  confirmButtonColor: '#92c135',
			  confirmButtonText: 'OK',
			  cancelButtonText: 'Tidak',
			  //cancelButtonClass: 'btn btn-danger',
			  //confirmButtonClass: 'btn btn-success',
			  closeOnConfirm: true,
			  closeOnCancel: true,
			  showCancelButton: true,
			  
				}).then(function(isConfirm) {
				  if (isConfirm) {
					$.ajax({
						url:$("#base-url").val() + 'Nego_invitation_vendor/delete_file',
						type:'post',
						data:{'ptnv_id':$("#ptnv_id").val()},
						dataType:'Json',
						success:function(respon){
							alert(respon.msg);
							if(respon.sts){
								$('.uploaded_file').hide();
								$('.delete_file').hide();
							}
						}
					});
				  }
			});
		
	});
	
	$('#save_bidding').click(function(dataku){

		var state=true;

		if($('#is_jasa').val()==1){
            if($('#file_breakdown').val()==''){                
                swal({
						  title: 'ERROR',
						  text: 'File Dokumen harus diisi',
						  type: 'error',
						  cancelButtonColor: '#d33',
						  confirmButtonColor: '#92c135',
						  confirmButtonText: 'OK',
						  cancelButtonText: 'Tidak',
						  //cancelButtonClass: 'btn btn-danger',
						  //confirmButtonClass: 'btn btn-success',
						  closeOnConfirm: true,
						  closeOnCancel: true,
						  showCancelButton: false,
						  
							}).then(function(isConfirm) {
							  return isConfirm;
						});
					state = false;
            }else{
               state = true;
            }
        }

		$('.input_price_value').each(function(){
			var price_value=parseFloat(removeCommas($(this).val()));
			var final_price=parseFloat($(this).parent().find('.input_final_price').val());
			var pqi_price=parseFloat($(this).parent().find('.input_pqi_price').val());
			var n_nego=$(this).parent().find('.n_nego').val();
			var nego_end=strTodatetime($(this).parent().find('.nego_end').val());
			var now = new Date();			
			//console.log(nego_end+'|'+now);
			
			//console.log(pqi_price+'|'+final_price+'|'+price_value);			
			if(n_nego>1 || final_price>0){			
				if(price_value>final_price){
					swal({
						  title: 'ERROR',
						  text: 'Harga Nego Melebihi Harga Negosiasi Sebelumnya',
						  type: 'error',
						  cancelButtonColor: '#d33',
						  confirmButtonColor: '#92c135',
						  confirmButtonText: 'OK',
						  cancelButtonText: 'Tidak',
						  //cancelButtonClass: 'btn btn-danger',
						  //confirmButtonClass: 'btn btn-success',
						  closeOnConfirm: true,
						  closeOnCancel: true,
						  showCancelButton: false,
						  
							}).then(function(isConfirm) {
							  return isConfirm;
						});
					state = false;
				}
				
			}else{
				if(price_value>pqi_price){
					swal({
						  title: 'ERROR',
						  text: 'Harga Nego Melebihi Harga Penawaran',
						  type: 'error',
						  cancelButtonColor: '#d33',
						  confirmButtonColor: '#92c135',
						  confirmButtonText: 'OK',
						  cancelButtonText: 'Tidak',
						  //cancelButtonClass: 'btn btn-danger',
						  //confirmButtonClass: 'btn btn-success',
						  closeOnConfirm: true,
						  closeOnCancel: true,
						  showCancelButton: false,
						  
							}).then(function(isConfirm) {
							  return isConfirm;
						});
					state = false;
				}
			}
		});
		
		if(state){
			var datakirim=$("#form_ub").serialize();
			$.ajax({
				url:$("#base-url").val() + 'Nego_invitation_vendor/cek_toleransi_ub',
				type:'post',
				data:datakirim,
				dataType:'Json',
				success:function(ea){
					if(ea.st==0){
						if(ea.isitemis==1){
							if(ea.jns==2){//warning
								$('#'+ea.id).css('background-color','#FEE2EA');
								$('#'+ea.id).focus();
								
								swal({
									  title: 'Yakin Menyimpan Data?',
									  text: ea.msg,
									  type: 'warning',
									  
									  cancelButtonColor: '#d33',
									  confirmButtonColor: '#92c135',
									  confirmButtonText: 'OK',
									  cancelButtonText: 'Tidak',
									  //cancelButtonClass: 'btn btn-danger',
									  //confirmButtonClass: 'btn btn-success',
									  closeOnConfirm: true,
									  closeOnCancel: true,
									  showCancelButton: true,
									  
										}).then(function(isConfirm) {
										  if (isConfirm) {
											
											$('#ubsub').trigger('click');
										  }
									})
								
								
								
							}else if(ea.jns==3||ea.jns==4){// error
								$('#'+ea.id).css('background-color','#FEE2EA');
								swal(ea.msg);
								swal({
								 // title: 'Auto close alert!',
								  text: ea.msg,
								  timer: 2000
								})
							}
						}else{
							if(ea.jns==2){//warning
								swal({
									  title: 'Yakin Menyimpan Data?',
									  text: ea.msg,
									  type: 'warning',
									  
									  cancelButtonColor: '#d33',
									  confirmButtonColor: '#92c135',
									  confirmButtonText: 'OK',
									  cancelButtonText: 'Tidak',
									  //cancelButtonClass: 'btn btn-danger',
									  //confirmButtonClass: 'btn btn-success',
									  closeOnConfirm: true,
									  closeOnCancel: true,
									  showCancelButton: true,
									  
										}).then(function(isConfirm) {
										  if (isConfirm) {
											$('#ubsub').trigger('click');
											
										  }
									})
							}else if(ea.jns==3){// error
								swal(ea.msg);
								swal({
								 // title: 'Auto close alert!',
								  text: ea.msg,
								  timer: 2000
								})
							}
							
							}
						}
						else{
							
							swal({
									  title: 'Apakah Anda Yakin Menyimpan Data Ini?',
									  text: ea.msg,
									  type: 'warning',
									  
									  cancelButtonColor: '#d33',
									  confirmButtonColor: '#92c135',
									  confirmButtonText: 'OK',
									  cancelButtonText: 'Tidak',
									  //cancelButtonClass: 'btn btn-danger',
									  //confirmButtonClass: 'btn btn-success',
									  closeOnConfirm: true,
									  closeOnCancel: true,
									  showCancelButton: true,
									  
										}).then(function(isConfirm) {
										  if (isConfirm) {
											
											$('#ubsub').trigger('click');
										  }
									})
							
							
							}
						
					
					}
			});
		}

		
		});
	
	
	
		

	//$("form").submit(function(e) {
//		warning = '';
//		masihfalse = false;
//		$(".cek_status").each(function() {
//			if ($(this).val() == 'false') {
//				masihfalse = true;
//				warning = $(this).parent().find('.cek_warning').val();
//			}
//		});
//
//		if (warning == 'warning') {
//			if (!confirm('Harga penawaran anda melebihi batas harga toleransi kami. Apakah anda yakin akan melanjutkan?')) {
//                e.preventDefault();
//			}
//		}
//
//		if (warning == 'error') {
//			alert('Harga penawaran anda melebihi batas harga toleransi kami.');
//            e.preventDefault();
//		}
//
//		if (!e.isDefaultPrevented()) {
//			if (!confirm('Apakah anda yakin akan melanjutkan? Pastikan data yang anda masukkan benar.')) {
//				e.preventDefault();
//			}
//		}
//	});
});