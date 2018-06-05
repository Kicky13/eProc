var base_url = $('#base-url').val();

$(document).ready(function(){
 	$(".select2").select2();

 	$('#group_jasa_id').change(function(){
		$('#svc').val($('#group_jasa_id option:selected').text());
	 	id = $('#group_jasa_id').val();
        $.ajax({
			url : base_url + "Procurement_pratender/pilih_child",
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
			url : base_url + "Procurement_pratender/pilih_child",
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
			url : base_url + "Procurement_pratender/pilih_sub_klasifikasi",
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
						options1 += '<div required="" class="new_data"><input class="check_jasa" type="checkbox" name="subKlasifikasi_jasa_id[]" value="' + val[i].ID + '"> ' + val[i].NAMA + description +'</div>';
					}
					$('#subKlasifikasi_ganjil').append(options1);
				
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
			url : base_url + "Update_dirven/pilih_child_kualifikasi",
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

	$('#addServices').click(function(event){
		// cek = $("input.check_jasa").prop('checked');
		// if(cek == undefined || cek == false){
		// 	swal("Error!", "Sub Klasifikasi harus di centang!", "error")
		// 	return ;
		// }
		$('.insert_service').bootstrapValidator('validate');
		if (success) {
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
	                var form_data = $('.insert_service').serialize();
					console.log(form_data);
					$.ajax({
						url : base_url + "Update_dirven/do_insert_service",
						method : 'post',
						data : form_data,
						success : function(result)
						{
							if(result=='OK'){
								swal("Berhasil!", "Tambah data berhasil!", "success")
								location.reload();
							}else{
								swal("Error!", "Gagal Tambah data jasa.", "error")
								location.reload();
							}
						}
					});
	            } else {
	            }
	        })			
		}
	});

	var progressBar = $('.progress-bar'),
        progressOuter = $('.progress-striped');
    $('.uploadAttachment').each(function(event) {
        var btn     = $(this),
            msgBox  = $($(btn).siblings('span.messageUpload')[0]);
        var uploader = new ss.SimpleUpload({
            button: btn,
            url: base_url + 'Update_dirven/uploadAttachment',
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

	$('.delete_upload_file_ja').click(function(){
        $.ajax({
            url: base_url + 'Update_dirven/deleteFile',
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

});

function del(ID){
    swal({
        title: "Yakin Hapus Data Ini?",
        text: "",
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
		  		type: "post",
				url : base_url + 'Update_dirven/delete',
				data : "id="+ID,
				//dataType: "json",
				success: function(data) {
					if(data == 'OK'){
						swal("Berhasil!", "Data berhasil dihapus", "success")
						location.reload();
					}else{
						swal("Error!", "Data gagal dihapus", "error")
					}
				}
		  });
        } else {
        }
    })
    
}