base_url = $("#base-url").val();

        var progressBar = $('.progress-bar'),
            progressOuter = $('.progress-striped');
$('.uploadAttachment').each(function(event) {
            var btn     = $(this),
                msgBox  = $($(btn).siblings('span.messageUpload')[0]);
            var uploader = new ss.SimpleUpload({
                button: btn,
                url: 'uploadAttachment',
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

                        btn.parent().find('.filenamespan').html(' &nbsp; <a target="_blank" style="color: #666; text-decoration: underline" href="'+base_url+response.upload_dir+response.newFileName+'">File Attachment</a>&nbsp;&nbsp;<a class="btn btn-default delete_upload_doc">Delete</a><script>$(".delete_upload_doc").click(function(){$(this).parent().parent().find(".uploadAttachment").data("uploaded", false);$(this).parent().parent().find(".uploadAttachment").html("Upload File (2MB Max)");$(this).parent().parent().find(".namafile").val("");$(this).parent().parent().find(".uploadAttachment").css("color","black");$(this).parent().children().remove();});</script>');
                        btn.data('uploaded', true);
                        msgBox.html('<a target="_blank" style="color: #666; text-decoration: underline" href="'+base_url+response.upload_dir+response.newFileName+'">File Attachment</a>&nbsp;&nbsp;<a class="btn btn-default delete_upload_doc">Delete</a><script>$(".delete_upload_doc").click(function(){$(this).parent().parent().find(".uploadAttachment").data("uploaded", false);$(this).parent().parent().find(".uploadAttachment").html("Upload File (2MB Max)");$(this).parent().parent().find(".namafile").val("");$(this).parent().parent().find(".uploadAttachment").css("color","black");$(this).parent().children().remove();});</script>');

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

$('.action-option').on('change', function(event) {
        if ( $('.action-option').val() == '2'){
         $('.reject-reason').show().focus();
         $('.approve-payment').hide();
        }
        else {
         $('.approve-payment').show();
         $('.reject-reason').hide();
        }
    });

$('.approve-payment').bootstrapValidator({
        fields: {
            
            tax_type: {
                trigger: 'change keyup',
                validators: {
                    notEmpty: {}
                }
            },
            text: {
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

$('#submitInv').on('submit', function(event) {
    event.preventDefault();
    swal({
        title: "Apakah anda yakin?",
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
            $('#submitInv').unbind('submit').submit();
        } else {
        }
    })
    });

$(document).ready(function() {
    $('.reject-reason').hide();

    // $(".select2").select2();

    $('input:file').bind('change', function() {
        if (this.files[0].size > 2000000) {
            alert('Ukuran file maksimum 2MB.');
            this.value = '';
        } else {
            var ext = this.value.match(/\.(.+)$/)[1];
            switch (ext) {
            case 'jpg':
            case 'JPG':
            case 'jpeg':
            case 'JPEG':
            case 'png':
            case 'PNG':
            case 'pdf':
            case 'PDF':
            case 'doc':
            case 'DOC':
                break;
            default: {
                //$('#uploadButton').attr('disabled', true);
                alert('Kesalahan tipe file.');
                this.value = '';
            }
            }
        }

    });    

    $('.input-group.date').datepicker({
        format: 'dd-mm-yyyy'
    });

});