$(document).ready(function(){
    base_url = $("#base-url").val();
    var mytable;

    mytable = $('#tbl_data').DataTable({

        "bSort": false,
        "dom": 'rtip',
        "ajax" : {'url':base_url + 'Adm_company_master/get_data'},

        "columnDefs": [{
            "searchable": true,
            "orderable": false,
            "targets": 0
        }],
        
        "columns":[
            {"data" : null},
            {"data" : "COMPANYID"},
            {"data" : "COMPANYNAME"},
            {"data" : "EMAIL_COMPANY"},
            {"data" : "ALAMAT_COMPANY"},
            {
                mRender : function(data,type,full){
                    ans = '<img class="logo_dark" src="static/images/logo/'+full.LOGO_COMPANY+'" alt="">';
                    return ans;
            }},
            {
                mRender : function(data,type,full){
                    if (full.ISACTIVE == 1) {
                        ans = '<a title="Activated" OnClick="update('+full.COMPANYID+')" class="btn btn-default btn-sm glyphicon glyphicon-ok"></a>';
                        return ans;
                    } else {
                        ans = '<a title="Deactivated" OnClick="update('+full.COMPANYID+')" class="btn btn-default btn-sm glyphicon glyphicon-remove"></a>';
                        return ans;
                    }
            }},
        ],
    });

    
    mytable.on( 'order.dt search.dt', function () {
        mytable.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();

    mytable.columns().every( function () {
        var that = this;
    
        $( 'input', this.header() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that.search( this.value ).draw();
            }
        });
    });

    $('.formInitialize').bootstrapValidator({
        fields: {
            opco: {
                validators: {
                    notEmpty: {}
                }
            },
            company_name: {
                validators: {
                    notEmpty: {}
                }
            }, 
            email: {
                validators: {
                    notEmpty: {}
                }
            }, 
            alamat: {
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

    $('#save').click(function(e){ 
        var form_data = $('.formInitialize').serialize();
        console.log(form_data);
        
        $('.formInitialize').bootstrapValidator('validate');
        
        gagal = false;
        $('.formInitialize').find('.logo_upload').each(function() {
            if ($(this).data('uploaded') != true) {
                gagal = true;
            }
        });

        if (success) {
            if (gagal == true) {
                swal("Perhatian!", "Wajib Upload Logo!", "warning")
                return false;
            }
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
                        url : base_url + 'Adm_company_master/insert',
                        method : 'post',
                        data : form_data,
                        success : function(result)
                        {
                            if(result == 'ok'){
                                swal("Berhasil!", "Data berhasil disimpan", "success")
                                location.reload();
                            }else{
                                swal("Error!", "Data gagal disimpan", "error")
                            }
                        }
                    });
                }
            })
        };
    });

    // UPLOAD
    var url = document.location.href.split('/');
    var base_url = $('#base-url').val();
    var progressBar = $('.progress-bar.logos'),
                    progressOuter = $('.progress-striped.logos');
        $('.uploadAttachment').each(function(event) {
            var btn     = $(this),
                msgBox  = $($(btn).siblings('span.messageUpload')[0]);
            var uploader = new ss.SimpleUpload({
                button: btn,
                url: $("#base-url").val() + 'Adm_company_master/uploadAttachment',
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
                        msgBox.html('<a target="_blank" style="color: #666; text-decoration: underline" href="'+base_url+response.upload_dir+response.newFileName+'">File Attachment</a>&nbsp;&nbsp;<a class="btn btn-default delete_upload_doc glyphicon glyphicon-trash"></a><script>$(".delete_upload_doc").click(function(){$(this).parent().parent().find(".uploadAttachment").data("uploaded", false);$(this).parent().parent().find(".uploadAttachment").html("Upload File");$(this).parent().parent().find(".namafile").val("");$(this).parent().parent().find(".uploadAttachment").css("color","black");$(this).parent().children().remove();});</script>');

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

    // DELETE
    $('.delete_upload_file').on('click', function() {

            var data_file = $('#logo').val(),
                field = $('#logo'),
                upload_file = $('.uploadAttachment.logo_upload'),
                namespan = $('.filenamespan.logos'),
                progressBar = $('.progress-bar.logos'),
                progressOuter = $('.progress-striped.logos');
         

        $.ajax({
            url: 'deleteFile_akta',
            type: 'POST',
            data: {filename: data_file },
            beforeSend: function() {
                progressOuter.css('display','block');
            },
        })
        .done(function(data) { 
            progressOuter.css('display','none');
            field.val("");
            upload_file.html('Upload File');
            namespan.html('');
        })
        .fail(function(data) {
            progressOuter.css('display','none');
            console.log("error");
            console.log(data);
        });
    });
// END DELETE
})

function update(ID){
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
                url : base_url +'Adm_company_master/update',
                data : "id="+ID, 
                success: function(data) {
                    if(data == 'ok'){
                        swal("Berhasil!", "Updated", "success")
                        location.reload();
                    }else{
                        swal("Error!", "Error", "error")
                    }
                }
          });
        } else {
        }
    })

}