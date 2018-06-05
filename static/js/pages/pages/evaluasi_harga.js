/* e itu button hitung nilai harga */
function hitung_nilai_eval_harga(e) {
	table = $(e).parent().parent().parent();
	console.log(table);
	hargamin = Infinity;
	table.find(".harga_vnd").each(function() {
		vnd = $(this).data('vnd');
		tdvnd = table.find('.validitaspenawaran [data-vnd='+vnd+']')
		if (tdvnd.find(".validity:checked").length > 0) {
			thisval = Number($(this).val());
			if (hargamin > thisval) {
				hargamin = thisval;
			}
		}
	});
	console.log(hargamin)

	table.find(".harga_vnd").each(function() {
		thisval = Number($(this).val());
		nilaiharga = hargamin / thisval * 100;
		nilaiharga = Math.ceil(nilaiharga)
		vnd = $(this).data('vnd');

		tdalid = table.find('.validitaspenawaran [data-vnd='+vnd+']');
		if (tdalid.find(".validity:checked").length <= 0) {
			nilaiharga = 0;
		}
		tdvnd = table.find('.nilai_harga [data-vnd='+vnd+']')
		tdvnd.find('.nilai_harga_vnd_span').html(nilaiharga);
		tdvnd.find('.nilai_harga_vnd').val(nilaiharga);


        nilaiharga = (thisval - hargamin) / hargamin * 100;
        nilaiharga = Math.ceil(nilaiharga)
        if (tdalid.find(".validity:checked").length <= 0) {
            nilaiharga = 0;
        }
        
        tdvnd = table.find('.range_harga [data-vnd='+vnd+']')
        tdvnd.find('.range_harga_vnd_span').html(nilaiharga);
        tdvnd.find('.range_harga_vnd').val(nilaiharga);

        hps_terendah = Number($('.hps_terendah').val());
        // alert(hps_terendah)
        nilaiharga = (thisval - hps_terendah) / hps_terendah;
        //nilaiharga = Math.ceil(nilaiharga)
        nilaiharga = Math.round(nilaiharga * 100) / 100

        if (tdalid.find(".validity:checked").length <= 0) {
            nilaiharga = 0;
        }
        // alert(nilaiharga);
        tdvnd = table.find('.penawaran_harga [data-vnd='+vnd+']')
        tdvnd.find('.penawaran_harga_vnd_span').html(nilaiharga);
        tdvnd.find('.penawaran_harga_vnd').val(nilaiharga);
    });
}

/* e itu button hitung nilai harga */
function hitung_nilai_eval_harga_paket(e) {
	table = $(e).parent().parent().parent();
	console.log(table);
	hargamin = Infinity;
	table.find(".harga_vnd").each(function() {
		vnd = $(this).data('vnd');
		console.log(vnd);
		tdvnd = table.find('.validitaspenawaran [data-vnd='+vnd+']')
		if (tdvnd.find(".validity:checked").length > 0) {
			thisval = Number($(this).val());
			if (hargamin > thisval) {
				hargamin = thisval;
			}
		}
	});
	console.log(hargamin)

	table.find(".harga_vnd").each(function() {
		thisval = Number($(this).val());
		nilaiharga = hargamin / thisval * 100;
		nilaiharga = Math.ceil(nilaiharga)
		vnd = $(this).data('vnd');

		tdalid = table.find('.validitaspenawaran [data-vnd='+vnd+']');
		if (tdalid.find(".validity:checked").length <= 0) {
			nilaiharga = 0;
		}
		tdvnd = table.find('.nilai_harga [data-vnd='+vnd+']')
		tdvnd.find('.nilai_harga_vnd_span').html(nilaiharga);
		tdvnd.find('.nilai_harga_vnd').val(nilaiharga);
	});
}

$(document).ready(function() {
	$(".hitung_nilai").click(function() {
		hitung_nilai_eval_harga(this)
	});

	$(".hitung_nilai_paket").click(function() {
		hitung_nilai_eval_harga_paket(this)
	});
	$(".close_bidding").click(function(id) {
		$(".modal").modal('hide');
	});
	$("#form_evaluasi_harga").submit(function(e){
		masih_kosong = false;
		$(".nilai_harga_vnd").each(function() {
			if ($(this).val() == '' || $(this).val() == null) {
				masih_kosong = true;
			}
			if (masih_kosong) {
				alert('Masih ada item yang belum dinilai. Silakan cek kembali.')
				e.preventDefault();
			}
		});
		// $(".hitung_nilai").each(function() {
		// 	hitung_nilai_eval_harga(this);
		// })
	});

	$('.checkAll').click(function(){
		tit_id = $(this).val();
        chk = $(this).is(':checked');
        if(chk){
            $('.check_'+tit_id).prop('checked', true);
        }else{
            $('.check_'+tit_id).prop('checked', false);
        }
    });

    $('.checkAllPaket').click(function(){
      tit_id = $(this).val();
      chk = $(this).is(':checked');
      if(chk){
        $('.checkPaket_'+tit_id).prop('checked', true);
    }else{
        $('.checkPaket_'+tit_id).prop('checked', false);
    }
});

    $('#save_chat').click(function(){
    	vendor = $('#vendor_pesan').val();
    	isi_pesan = $('#isi_pesan').val();
    	file_pesan = $('#file_pesan').val();
    	ptm_number = $('#ptm_number').val();
    	ptm_status = $('#ptm_status').val();

    	if(vendor=='' || isi_pesan==''){
    		swal("Error!", "Pilih Vendor dan Isi Klarifikasi tidak boleh kosong.", "error");
         return;
     }

     $.ajax({
        url : $("#base-url").val() + 'Evaluasi_penawaran/save_pesan/',
        dataType : 'html',
        method : 'post',
        data : {ptm_number, ptm_status, vendor, isi_pesan, file_pesan},
        beforeSend: function() {
            progressOuter.css('display','block');
        },
        success : function(data){
           progressOuter.css('display','none');
           $(".uploadAttachment").html('Upload File');
           $('.filenamespan').html('');
           $('.kosong').val('');
           swal("Berhasil", "Pesan Berhasil dikirim.", "success");
           $('#history_pesan').html(data);
       },
       fail : function(data){
        progressOuter.css('display','none');
        console.log("error");
        console.log(data);
    }
});

 });

    $("#vendor_pesan").change(function(){
      vendor_no = $(this).val();
      ptm_number = $('#ptm_number').val();
      $.ajax({
        url : $("#base-url").val() + 'Evaluasi_penawaran/filter_chat_vendor/',
        dataType : 'html',
        method : 'post',
        data : {vendor_no, ptm_number},
        beforeSend: function() {
            progressOuter.css('display','block');
        },
        success : function(data){
           progressOuter.css('display','none');
           $('#history_pesan').html(data);
       },
       fail : function(data){
        progressOuter.css('display','none');
        console.log("error");
        console.log(data);
    }
});
  });

    var progressBar = $('.progress-bar'),
    progressOuter = $('.progress-striped');
    $('.uploadAttachment').each(function(event) {
        var btn     = $(this),
        msgBox  = $($(btn).siblings('span.messageUpload')[0]);
        var uploader = new ss.SimpleUpload({
            button: btn,
            url: $("#base-url").val() + 'Evaluasi_penawaran/uploadAttachment',
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
                    btn.html('Change File');
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

$('.del_upload_file').click(function(){
    $.ajax({
        url: $("#base-url").val() + 'Evaluasi_penawaran/deleteFile/'+$("#file_pesan").val(),
        type: 'POST',
        data: {},
        beforeSend: function() {
            progressOuter.css('display','block');
        },
    })
    .done(function(data) { 
        progressOuter.css('display','none');
        $(".uploadAttachment").html('Upload File');
        $('.filenamespan').html('');
    })
    .fail(function(data) {
        progressOuter.css('display','none');
        console.log("error");
        console.log(data);
    });
});

});

function tech(value, tit_id){
	if(value >= 100){
		$('#tech_'+tit_id).val(100);
		$('#price_'+tit_id).val(0);
		return;
	}
    price_weight = $('#price_'+tit_id).val();
    total = Number(value)+Number(price_weight);
    // if(total > 100){
    	$('#price_'+tit_id).val(100-Number(value));
    // }else if(total < 100){
    // 	$('#price_'+tit_id).val(100-Number(value));
    // }
    
};
function price(value, tit_id){
	if(value >= 100){
		$('#price_'+tit_id).val(100);
		$('#tech_'+tit_id).val(0);
		return;
	}
    tech_weight = $('#tech_'+tit_id).val();
    total = Number(value)+Number(tech_weight);
    // if(total > 100){
    	$('#tech_'+tit_id).val(100-Number(value));
    // }else if(total < 100){
    // 	$('#tech_'+tit_id).val(100-Number(value));
    // }
    
};

progressOuter = $('.progress-striped');
function replay(id){
	$.ajax({
        url : $("#base-url").val() + 'Evaluasi_penawaran/replay_pesan/',
        dataType : 'json',
        method : 'post',
        data : {id},
        beforeSend: function() {
            progressOuter.css('display','block');
        },
        success : function(data){
            progressOuter.css('display','none');
            $('#vendor_pesan').val(data.VENDOR_NO);
            $('#isi_pesan').focus();
        },
        fail : function(data){
            progressOuter.css('display','none');
            console.log("error");
            console.log(data);
        }
    });

}