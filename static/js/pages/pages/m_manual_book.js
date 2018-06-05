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
		var	progressBar = $('.progress-bar'),
			progressOuter = $('.progress-striped');
		$('.uploadAttachment').each(function(event) {
			var btn 	= $(this),
				msgBox 	= $($(btn).siblings('span.messageUpload')[0]);
			var uploader = new ss.SimpleUpload({
				button: btn,
				url: 'Panduan/uploadAttachment',
				name: 'uploadfile',
				allowedExtensions: ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'odt', 'html', 'zip'],
				maxSize: 10048,
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
						btn.html('Change File (10MB Max)');
						btn.css('color','black');

						btn.parent().find('.filenamespan').html(' &nbsp; File Uploaded');
						btn.data('uploaded', true);
						msgBox.html('<a target="_blank" style="color: #666; text-decoration: underline" href="'+base_url+response.upload_dir+response.newFileName+'">File Attachment</a>&nbsp;&nbsp;<a class="btn btn-default delete_upload_doc">Delete</a><script>$(".delete_upload_doc").click(function(){$(this).parent().parent().find(".uploadAttachment").data("uploaded", false);$(this).parent().parent().find(".uploadAttachment").html("Upload File (10MB Max)");$(this).parent().parent().find(".namafile").val("");$(this).parent().parent().find(".uploadAttachment").css("color","black");$(this).parent().children().remove();});</script>');

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

	$('.delete_upload_file_mb').click(function(){
        $.ajax({
            url: 'Panduan/deleteFile',
            type: 'POST',
            data: {
                id : $("#id_manual").val(),
                filename: $("#name_file").val()
            },
            beforeSend: function() {
                progressOuter.css('display','block');
            },
        })
        .done(function(data) { 
            progressOuter.css('display','none');  
            $("#name_file").val("");
            $(".manual_book").html('Upload File (10MB Max)');
            $('.filenamespan').html('');
        })
        .fail(function(data) {
            progressOuter.css('display','none');
            console.log("error");
            console.log(data);
        });
    });

	$("form").submit(function(e) { 
			var form = this;
            e.preventDefault();
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
                        form.submit();
                    } else {
                    }
                }) 
		});

});

function deletedata(ID){
	// alert(ID);
    swal({
        title: "Apakah Anda Yakin?",
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
				url : base_url + 'Panduan/delete',
				data : "id="+ID,
				//dataType: "json",
				success: function(data) {
					if(data == 'ok'){
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