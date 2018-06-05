var base_url = $('#base-url').val();

$(document).ready(function(){
	var table = $('#list_pesan').DataTable( {
		"dom": 'rtip',
		"lengthMenu": [ 10, 25, 50 ],
		"ajax": {
			url: base_url + "Proc_chat_vendor/get_list"
		},
		"columnDefs": [{
			"targets": 0
		}],
		"columns":[
			{"data" : null},
			{"data" : "PTM_PRATENDER"},
			{"data" : "PTM_SUBJECT_OF_WORK"},
			{"data" : "FULLNAME"},
			{"data" : "TGL"},
			{
				mRender : function(data,type,full) {
					return '<a class="btn btn-default" href="'+base_url+'Proc_chat_vendor/detail/'+full.PTM+'">Detail</a>';
			}, "sClass": "text-center"}
		],
	} );

	table.on('draw', function () {
		table.column(0, {search:'applied', order:'applied', page:'applied'}).nodes().each( function (cell, i) {
			cell.innerHTML = i+1;
		} );
	} ).draw();
	table.columns().every( function () {
        var that = this;
    
        $( 'input', this.header() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that.search( this.value ).draw();
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
            url: $("#base-url").val() + 'Proc_chat_vendor/uploadAttachment',
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

    $(".open-material").click(function() {
        PPI_NOMAT = $(this).parent().find(".PPI_NOMAT").val();
        PPI_ID = $(this).parent().find(".PPI_ID").val();
        $.ajax({
            url: $("#base-url").val() + 'Proc_chat_vendor/getlongtext',
            type: 'POST',
            dataType: 'html',
            data: {
                PPI_NOMAT: PPI_NOMAT,
                PPI_ID: PPI_ID
            },
        })
        .done(function(data) {
            console.log(data)
            $("#detail-material").find(".modal-body").html(data);
            $("#detail-material").modal("show");
        })
        .fail(function(data) {
            console.log("error");
            console.log(data);
        });
    });

    $('.del_upload_file').click(function(){
        $.ajax({
            url: $("#base-url").val() + 'Proc_chat_vendor/deleteFile/'+$("#file_pesan").val(),
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

    $('#save_chat').click(function(){
    	isi_pesan = $('#isi_pesan').val();
    	file_pesan = $('#file_pesan').val();
    	ptm_number = $('#ptm_number').val();
    	ptm_status = $('#ptm_status').val();
    	user_id = $('#user_id').val();

    	if(isi_pesan==''){
    		swal("Error!", "Isi Klarifikasi tidak boleh kosong.", "error");
			return;
    	}

        $.ajax({
            url : $("#base-url").val() + 'Proc_chat_vendor/save/',
            dataType : 'html',
            method : 'post',
            data : {ptm_number, ptm_status, isi_pesan, file_pesan, user_id},
            beforeSend: function() {
                progressOuter.css('display','block');
            },
            success : function(data){
	            progressOuter.css('display','none');
	            location.reload();
	        },
	        fail : function(data){
                progressOuter.css('display','none');
	            console.log("error");
	            console.log(data);
            }
        });

    });

    function numberWithCommas(x) {
        var parts = x.toString().split(".");
        parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        return parts.join(".");
    }

    $(".pqi_price").autoNumeric('init', {lZero: 'deny'});

    function hitung(elem) {
        // id = (elem.attr('id')).split('_')[1];
        tritem = $(elem).parent().parent();
        if($("#justification").val() == 5){  //Penunjukan Langsung - Repeat Order (RO)
            netprice = tritem.find('.netprice').val();
            cekPrice = tritem.find('.pqi_price').val();
            repPrice = cekPrice.replace(/,/g,"");
            if(Number(repPrice) > Number(netprice)){
                alert('Harga satuan melebihi Harga PO');
                tritem.find('.pqi_price').val(netprice);
            }
        }
        // console.log("tr item nya")
        // console.log(tritem.html())
        var is_itemize = $('#is_itemize').val();
        $price = tritem.find('.pqi_price');
        $quan = tritem.find('.pqi_quan');
        if(is_itemize == "0")
            tritem.find('.subtot').html($price.autoNumeric('get') * $quan.html());
        else {
            tritem.find('.subtot').html($price.autoNumeric('get') * $quan.val());
        }
        var total = 0;
        
        $(".subtot").each(function() {
            val = Number($(this).html());
            total += val;
            $(this).parent().find(".subtot_tampil").html(numberWithCommas((val))) // harus number format            
        });
        $('#total_before_ppn').html(total);
        $('#total_after_ppn').html(total * 110 / 100);
        $('#total_before_ppn').html(numberWithCommas(total));
        $('#total_after_ppn').html(numberWithCommas(total * 110 / 100));
    }

    $(".pqi_price").each(function() {
        hitung($(this));
    });

});