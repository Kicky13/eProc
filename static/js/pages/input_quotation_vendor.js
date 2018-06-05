function numberWithCommas(x) {
    var parts = x.toString().split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return parts.join(".");
}

var base_url = $('#base-url').val();

$(document).ready(function(){
    $( ".previousfile" ).each(function(){
        $this = $(this);
        td = $this.parent();
        td.find(".inputfile").hide().prop("disabled", true);
    });
})
function deletefile(e){
    $this = $(e);
    // $this.preventDefault();
    td = $this.parent();
    td.find('.delete').val(1);
    td.find('.previousfile').remove();
    td.find(".inputfile").show().prop('disabled', false);
    return false; // prevent default click action from happening!
    e.preventDefault(); // same thing as above
}

function must_number(e) {
    val = Number($(e).val())
    $(e).val(val ? val : 0)
}
//hide and show <div> upload radio button
//hide and show <div> upload radio button
function penawaran_ShowHideDiv() {
    var chkYes = document.getElementById("chkYes_penawaran");
    var chkNo = document.getElementById("chkNo_penawaran");
    var dvshowmeon = document.getElementById("dvshowme_penawaran");

    // alert(dvshowmeon);
    if(chkYes.checked){
        $('#penawaran_k2').attr('required', true)
    }else{
        $('#penawaran_k2').attr('required', false)
    }
        dvshowmeon.style.display = chkYes.checked ? "block" : "none";
}

function pelaksanaan_ShowHideDiv() {
    var chkYesp = document.getElementById("chkYes_pelaksanaan");
    var chkNop = document.getElementById("chkNo_pelaksanaan");
    var dvshowmeof = document.getElementById("dvshowme_pelaksanaan");
    
    if(chkYesp.checked){
        $('#pelaksanaan_k2').attr('required', true)
    }else{
        $('#pelaksanaan_k2').attr('required', false)
    }
    dvshowmeof.style.display = chkYesp.checked ? "block" : "none";
}

function pemeliharaan_ShowHideDiv() {
    var chkYespp = document.getElementById("chkYes_pemeliharaan");
    var chkNopp = document.getElementById("chkNo_pemeliharaan");
    var dvshowmeofp = document.getElementById("dvshowme_pemeliharaan");
    // alert(dvshowmeof);
    if(chkYespp.checked){
        $('#pemeliharaan_k2').attr('required', true)
    }else{
        $('#pemeliharaan_k2').attr('required', false)
    }
    dvshowmeofp.style.display = chkYespp.checked ? "block" : "none";
}

function cek_hargawarning(e) {
    e.parent().parent().find(".cek_dordor").val("false");
    var dat = e.val();
    dat = dat.replace(/,/g, "");
    $("#save_bidding").addClass("hidden");
    $.ajax({
        url: $("#base-url").val() + 'Quotation_vendor/cek_toleransi/' + e.parent().parent().find(".tit_id").val() + '/' + dat,
        type: 'post',
        dataType: 'json',
    })
    .done(function(data) {
        e.parent().parent().find(".cek_dordor").val(data.status);
        e.parent().parent().find(".cek_warning").val(data.warning);
        // console.log(e.parent().parent().html());
    })
    .fail(function() {
        console.log("error");
    })
    .always(function(data) {
        $("#save_bidding").removeClass("hidden");
    });
}

$(document).ready(function(){
    cancontinue = 0;

    var progressBar = $('.progress-bar'),
        progressOuter = $('.progress-striped');
    $('.uploadAttachment').each(function(event) {
        var btn     = $(this),
            msgBox  = $($(btn).siblings('span.messageUpload')[0]);
        var uploader = new ss.SimpleUpload({
            button: btn,
            url: $("#base-url").val() + 'Administrative_document/uploadAttachment',
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

    $(document).on('click','.eval_cek',(function(){
        // alert($(this).val()); 
        if ($(this).is(':checked')) {
            // alert('cek'); 
            $('input[name="optradio'+$(this).val()+'"]').prop('disabled', false);
            $('textarea[name="optradio'+$(this).val()+'"]').prop('disabled', false);
        }else{
            // alert('not cek'); 
            $('input[name="optradio'+$(this).val()+'"]').prop('disabled', true);
            $('input[name="optradio'+$(this).val()+'"]').prop('checked', false);

            $('textarea[name="optradio'+$(this).val()+'"]').prop('disabled', true);
            $('textarea[name="optradio'+$(this).val()+'"]').val('');
        }
    }));
    
        //////////rg///////////    
    $('.delete_upload_file').click(function(){
        $.ajax({
            url: $("#base-url").val() + 'Quotation_vendor/deleteFile',
            type: 'POST',
            data: {
                id : $("#id_ptv").val(),
                filename: cekFile
            },
            beforeSend: function() {
                progressOuter.css('display','block');
            },
        })
        .done(function(data) { 
            progressOuter.css('display','none');           
            $("#fileView").hide();
            $("#fileUpload").show();
            $("#fileLama_harga").val("");
        })
        .fail(function(data) {
            progressOuter.css('display','none');
            console.log("error");
            console.log(data);
        });
    });
        /////////////////////

    $(".pqi_price").each(function(){
        cek_hargawarning($(this));
    })

    count_tech_item = $('#sum_tech_row').val();

    $(".pqi_price").autoNumeric('init', {lZero: 'deny'});

    function hitung(elem) {
        // id = (elem.attr('id')).split('_')[1];
        tritem = $(elem).parents('tr');
        if($("#justification").val() == 5){  //Penunjukan Langsung - Repeat Order (RO)
            netprice = tritem.find('.netprice').val();
            cekPrice = tritem.find('.pqi_price').val();
            repPrice = cekPrice.replace(/,/g,"");
            if(Number(repPrice) > Number(netprice)){
                sweetAlert('Perhatian !','Harga satuan melebihi Harga PO','warning')
                tritem.find('.pqi_price').val(netprice);
            }
        }
        // console.log("tr item nya")
        var is_itemize = $('#is_itemize').val();
        $price = tritem.find('.pqi_price');
        $quan = tritem.find('.pqi_quan');

        // if(is_itemize == "0"){
        //     tritem.find('.subtot').html($price.autoNumeric('get') * $quan.val());
        // } else {
            tritem.find('.subtot').html($price.autoNumeric('get') * $quan.val());
        // }

        var total = 0;
        
        $(".subtot").each(function() {
            val = Number($(this).html());
            total += val;
            $(this).parent().find(".subtot_tampil").html(numberWithCommas(val)) // harus number format
        });
        
        
        $('#total_before_ppn').html(total);
        $('#total_after_ppn').html(total * 110 / 100);
        $('#total_before_ppn').html(numberWithCommas(total));
        $('#total_after_ppn').html(numberWithCommas(total * 110 / 100));
    }

    $(".pqi_price").each(function() {
        hitung($(this));
    });

    $(".qtywow").change(function(){
        val = $(this).parent().parent().find(".defprice").val();
        
        if(Number($(this).val()) > Number(val)){
            $(this).val(val);
        }
        if(Number($(this).val()) == 0){
            $(this).val(val);
        }

        hitung($(this));
    });

    $('.tritem').each(function() {
        var $desc = $(this).find('.pqi_desc')
        var $price = $(this).find('.pqi_price')
        $price.change(function(){
            hitung($(this));
        });
        console.log($desc)
        console.log($price)
    });

    $('#pqm_local_content').change(function() {
        must_number(this);
    });

    $('#pqm_delivery_time').change(function() {
        must_number(this);
    });

    $(".close-modal").click(function() {$(".modal").modal('hide')})

    $('#quoform').submit(function(e) {
        ptv_sts = $("#ptv_status").val();
        ptp_ev_mthd = $("#ptp_ev_met").val();
        udahsemua = false;
        statcek = true;

        if (Number($("#is_itemize").val()) != 1) {
            bisalanjut = true;
            $(".cekitem").each(function() {
                if (!$(this).is(':checked')) {
                    bisalanjut = false;
                }
            });
            if (!bisalanjut) {
                alert('Metode paket harus memasukkan penawaran untuk semua item.');
                e.preventDefault();
                return;
            }
        }
                    

        var cek_harga = false;
        $(".cekitem").each(function() {
            if ($(this).is(':checked')) {
                udahsemua = true;
                if($(this).parent().parent().find(".cek_dordor").val() == "false") {
                    statcek = false;
                    warning = $(this).parent().parent().find(".cek_warning").val();
                }

                if ( $(this).parent().parent().find(".pqi_price").val() < 1) {
                    sweetAlert('Perhatian !','Harga Tidak Boleh Kosong !','warning')
                    cek_harga = true;
                    return false;
                };
            } else {
               console.log('uncek');
            }
        });

        if (!udahsemua) {
            sweetAlert('Perhatian !','Pilih minimal satu item','warning')
            e.preventDefault();
            return false;
        } else if(statcek == false){ // kondisi dimana nilai harga melebihi batas toleransi
            // alert(statcek);
            if (warning == "warning" || warning == "error") {
                if (ptp_ev_mthd == "2 Tahap 2 Sampul" && ptv_sts == 1 || ptp_ev_mthd == "2 Tahap 2 Sampul" && ptv_sts == 2) {
                    var form = this;
                    e.preventDefault();
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
                             form.submit();
                        } else {
                        }
                    })
                } else if (warning == "warning") {
                    if (!cek_harga) {
                        var form = this;
                            e.preventDefault();
                            swal({
                                title: "Apakah anda yakin?",
                                text: "Harga penawaran anda melebihi batas harga toleransi kami.",
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
                    } else {
                        e.preventDefault();
                        return false;
                    }
                } else if (warning == "error") {
                    if (!cek_harga) {
                        sweetAlert('Perhatian !','Harga penawaran anda melebihi batas harga toleransi kami. ','warning')
                        e.preventDefault();
                        return false;
                    } else {
                        e.preventDefault();
                        return false;
                    }
                }
            }
        } else { // kondisi dimana nilai masih dalam batas toleransi
            if (ptp_ev_mthd == "2 Tahap 2 Sampul" && ptv_sts == 1 || ptp_ev_mthd == "2 Tahap 2 Sampul" && ptv_sts == 2) {
                var form = this;
                e.preventDefault();
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
                         form.submit();
                    } else {
                    }
                })
            } else {
                if (!cek_harga) {
                    var form = this;
                        e.preventDefault();
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
                                 form.submit();
                            } else {
                            }
                        }) 
                } else {
                    e.preventDefault();
                    return false;
                }
            }
        }

    });

    $('#quohargaform').submit(function(e) {
        statcek = true;
        if ($(".pqi_price").val() < 1) {
            sweetAlert(
                'Harga Tidak Boleh Kosong !',
                'Masukkan data dengan benar',
                'warning'
            )
            e.preventDefault();
            return false;
        };
        
        $(".cek_dordor").each(function(){
            if($(this).val() == "false") {
                statcek = false;
                console.log($(this).parent().parent().html())
                warning = $(this).parent().parent().find(".cek_warning").val();
            }
        });



        if($("#file_harga").val() == '' && $("#fileLama_harga").val() == ''){
            $("#msg_file").css("display","block");
            sweetAlert(
                'File Penawaran Harga tidak boleh kosong',
                'Lengkapi File Upload',
                'warning'
            )
            e.preventDefault();
            return false;
        }

        if(statcek == false){
            if(warning == "warning"){
                var form = this;
                e.preventDefault();
                swal({
                    title: "Apakah anda yakin?",
                    text: "Harga penawaran anda melebihi batas harga toleransi kami.",
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

            } else {
                sweetAlert(
                    'Perhatian !',
                    'Harga penawaran anda melebihi batas harga toleransi kami.',
                    'warning'
                )
                e.preventDefault();
                return false;
            }
        } else {
            var form = this;
                e.preventDefault();
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
                         form.submit();
                    } else {
                    }
                })
        }
       
    });

    // $(".mustdisabled").prop("disabled", true);

    $('.pqi_price').change(function() {
        cek_hargawarning($(this));
    });

    $('.cekitem').each(function() {
        ischecked = $(this).is(':checked');
        id = $(this).val();
        // console.log('ID ' + id + ' nilainya ' + (ischecked ? 'true' : 'false'));

        panelevatek = null
        $(".panelevatek").each(function() {
            if ($(this).val() == id) {
                panelevatek = $(this);
                return;
            }
        })

        if (panelevatek != null) {
            panelevatek = panelevatek.parent();
            if (ischecked) {
                // panelevatek.removeClass('hidden')
                panelevatek.show(40)
                panelevatek.find("input.mustnotdisabled").prop('disabled', false);
                $(this).parent().parent().find(".pqi_price").prop('disabled',false);
                $(this).parent().parent().find(".pqi_description").prop('disabled',false);
            } else {
                // panelevatek.addClass('hidden')
                panelevatek.hide(40);
                panelevatek.find("input.mustnotdisabled").prop('disabled', true);
                $(this).parent().parent().find(".pqi_description").html("");
                $(this).parent().parent().find(".pqi_description").prop('true',false);
                $(this).parent().parent().find(".pqi_price").val(0);
                hitung($(this).parent().parent().find(".pqi_price"))
                $(this).parent().parent().find(".pqi_price").prop('disabled',true);
                $(this).parent().parent().find(".pqi_description").prop('disabled',true);
            }
        }
    });

    $('.cekitem').change(function() {
        ischecked = $(this).is(':checked');
        id=$(this).val();
        console.log('ID ' + id + ' nilainya ' + (ischecked ? 'true' : 'false'));

        if (ischecked) {
            $(this).parent().parent().find(".pqi_quan").prop('disabled',false);
            $(this).parent().parent().find(".pqi_description").prop('disabled',false);
            $(this).parent().parent().find(".pqi_price").prop('disabled',false);
        } else {
            $(this).parent().parent().find(".pqi_quan").prop('disabled',true);
            $(this).parent().parent().find(".pqi_description").val('');
            $(this).parent().parent().find(".pqi_description").prop('disabled',true);
            $(this).parent().parent().find(".pqi_price").val('0.00');
            $(this).parent().parent().find(".pqi_price").prop('disabled',true);
        }

        // panelevatek = null
        // $(".panelevatek").each(function() {
        //     if ($(this).val() == id) {
        //         panelevatek = $(this);
        //         return;
        //     }
        // })

        // if (panelevatek != null) {
        //     panelevatek = panelevatek.parent();
        //     if (ischecked) {
        //         // panelevatek.removeClass('hidden')
        //         panelevatek.show(40)
        //         panelevatek.find("input.mustnotdisabled").prop('disabled', false);
        //         $(this).parent().parent().find(".pqi_price").prop('disabled',false);
        //         $(this).parent().parent().find(".pqi_description").prop('disabled',false);
        //     } else {
        //         // panelevatek.addClass('hidden')
        //         panelevatek.hide(40)
        //         panelevatek.find("input.mustnotdisabled").prop('disabled', true);
        //         $(this).parent().parent().find(".pqi_price").val(0);
        //         hitung($(this).parent().parent().find(".pqi_price"))
        //         $(this).parent().parent().find(".pqi_price").prop('disabled',true);
        //         $(this).parent().parent().find(".pqi_description").prop('disabled',true);
        //     }
        // }
    });
    
    $(".open-material").click(function() {
        // tes = $(this).parent().find(".PPI_NOMAT").val();
        // console.log(tes);
        PPI_NOMAT = $(this).parent().find(".PPI_NOMAT").val();
        PPI_ID = $(this).parent().find(".PPI_ID").val();
        $.ajax({
            url: $("#base-url").val() + 'Quotation_vendor/getlongtext',
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

    $('.quotation_uploadAttachment').each(function(event) {
        var btn     = $(this),
            msgBox  = $($(btn).siblings('span.messageUpload')[0]);
        var uploader = new ss.SimpleUpload({
            button: btn,
            url: $("#base-url").val() + 'Quotation_vendor/uploadAttachment',
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
                    //msgBox.html('<a target="_blank" style="color: #666; text-decoration: underline" href="'+base_url+response.upload_dir+response.newFileName+'">File Attachment</a>&nbsp;&nbsp;<a class="btn btn-default delete_upload_file">Delete</a><script>$(".delete_upload_file").click(function(){$(this).parent().parent().find(".uploadAttachment").data("uploaded", false);$(this).parent().parent().find(".uploadAttachment").html("Upload File (2MB Max)");$(this).parent().parent().find(".namafile").val("");$(this).parent().parent().find(".uploadAttachment").css("color","black");$(this).parent().children().remove();});</script>');

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

});

progressOuter = $('.progress-striped');
function delete_quotation_upload(tit_id){
    $.ajax({
        url: $("#base-url").val() + 'Quotation_vendor/deleteQuoFile',
        type: 'POST',
        data: {
            filename: $("#file_name"+tit_id).val(),
            id: $("#ptm_number").val(), 
            vendor_no: $("#vendor_no").val(),
            tit_id : tit_id
        },
        beforeSend: function() {
            progressOuter.css('display','block');
        },
    })
    .done(function(data) { 
        progressOuter.css('display','none');
        location.reload();
    })
    .fail(function(data) {
        progressOuter.css('display','none');
        console.log("error");
        console.log(data);
    });
};