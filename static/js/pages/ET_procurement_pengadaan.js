Number.prototype.formatMoney = function(c, d, t){
var n = this, 
    c = isNaN(c = Math.abs(c)) ? 2 : c, 
    d = d == undefined ? "." : d, 
    t = t == undefined ? "," : t, 
    s = n < 0 ? "-" : "", 
    i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", 
    j = (j = i.length) > 3 ? j % 3 : 0;
   return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};

function calculateTotal() {
    var TotalHPS = 0;
    var $trs = $(".itemtr");
    // console.log($trs)
    for (var i = 0; i < $trs.length; i++) {
        prc = $(".itemprc" + i).attr('val');
        qty = $(".itemqty" + i).val();
        var subtotal = prc*qty;
        TotalHPS += subtotal;
        $(".itemtot" + i).html(numeral(subtotal).format('$0,0.00'));
    };

    $("#total_hps").html(numeral(TotalHPS).format('$0,0.00'));
    var ppn = 0;
    Ppn = 0.1*TotalHPS;
    $("#ppn").html(numeral(Ppn).format('$0,0.00'));
    $("#total_hps_final").html(numeral(TotalHPS+Ppn).format('$0,0.00'));
}

function justify() {
    val = $("#ptp_justification").val();
    if (val == 2)
        $("#detail_justification").show('slow/400/fast');
    else {
        $("#detail_justification").hide();
    }
}
function open_dokumen(e) {
    pr = $(e).html();
    ppi = $(e).data('ppi');
    $("#modal_dokumen").find('.pr').html(pr);
    $.ajax({
        url: $("#base-url").val() + 'Snippet_ajax/pr_doc_service/' + ppi,
        type: 'post',
        dataType: 'html'
    })
    .done(function(data) {
        $("#modal_dokumen").find(".modal-body").html(data);
    })
    .fail(function() {
        console.log("error");
    })
    .always(function(data) {
        console.log(data);
    });
    $("#modal_dokumen").modal("show")
}

function doc_status(id, stat) {
    $.ajax({
        url: $('#base-url').val() + 'Procurement_sap/tor_status',
        type: 'post',
        dataType: 'json',
        data: {id: id, status: stat},
    })
    .done(function() {
        console.log("success");
    })
    .fail(function() {
        console.log("error");
    })
    .always(function(data) {
        console.log(data);
    });
}

function nocentang(e){
    if($(e).is(":checked")){

    } else {
        vendorno = $(e).val();
        $(".cekvendor:checked").each(function() {
            if ($(this).val() == vendorno) {
                $(this).prop('checked', false);
                terpilih(this);
            }
        });
        $(e).parent().parent().remove();
    }
}

function terpilih(e){
    vendorno = $(e).val();
    if($(e).is(":checked")){
        if($("#ptp_justification").val() >= 5 && $("#ptp_justification").val() <= 8 ){
            vnd = $(".cekvendor:checked").length;
            vnd_tmbhn = $(".cekvendor_tambahan:checked").length;
            dicentang = Number(vnd)+Number(vnd_tmbhn);
            if(dicentang > 1){
                alert("Metode penunjukan langsung hanya boleh satu vendor");
                $(e).prop("checked", false);
                return false;
            } 
        }
        // $(e).parent().parent().css("background-color","#dff0d8");
        $(e).parent().parent().addClass("success");
        ada = false;
        $(".vnd_terpilih").each(function() {
            if ($(this).val() == vendorno) {
                ada = true;
            } 
        });

        if (!ada) {
            tr = '<tr>' +
                    // '<td class="text-center"><input type="checkbox" class="vnd_terpilih" onclick="nocentang(this)" value="' + vendorno + '" checked></td>' +
                    '<td>' + vendorno + '</td>' +
                    '<td>' + $(e).parent().parent().find('.namavendor').html() + '</td>' +
                  '</tr>';
            $(".vendor_terpilih").append(tr);
        }

    } else {
        // $(e).parent().parent().css("background-color","");
        masih_ada = false;
        $(".cekvendor:checked").each(function() {
            if ($(this).val() == vendorno) {
                masih_ada = true;
            }
        });
        if (masih_ada) {

        } else {
            $(".vnd_terpilih").each(function() {
                if ($(this).val() == vendorno) {
                    $(this).parent().parent().remove();
                }
            });
        }
        $(e).parent().parent().removeClass("success");
    }

}


$(document).ready(function() {
   $("#ptp_reg_closing_date").blur(function(){
        var tglawal = strTodatetime($("#ptp_reg_closing_date").val());
        // alert(tglawal);
        var no = $(".nyotime").val();
        var tgltemp = new Date(tglawal);
        console.log(tgltemp);
        tgltemp.setDate(tgltemp.getDate() + Number(no));

        var tgl = new Date(tgltemp);
        console.log(tgl);
        tgl = moment(tgl).format('DD-MMM-YY HH:mm');
        $("#ptp_validity_harga").val(tgl);
    });

   // $('#peringatannego').ready(function(event) {
//        if($(this).val() != '1'){
//            $("#htmlbatasatasnego").addClass('form-required','form-required');
//            $("#batasatasnego").attr('required',true);
//        } else {
//            $("#batasatasnego").removeAttr('required');
//            $("#htmlbatasatasnego").addClass('form-required');
//        }
//    });
//
//    $('#peringatannego').change( function(event) {
//        if($(this).val() != '1'){
//            $("#htmlbatasatasnego").addClass('form-required','form-required');
//            $("#batasatasnego").attr('required',true);
//        } else {
//            $("#batasatasnego").removeAttr('required');
//            $("#htmlbatasatasnego").removeClass('form-required');
//        }
//    });

    $(".tambahfile").click(function(event){
        count = $(".numberfiles").val();
        console.log(count);
        count = Number(count) + Number(1);
        $(".divfiles").append("<div class='row'><div class='col-md-5'><input name='add_doc"+count+"' type='file' class='form-control' style='margin-top:1%;'></div><div class='col-md-7'><input name='name_doc"+count+"' type='text' class='form-control' placeholder='Keterangan'></div></div>");
        $(".numberfiles").val(count);
        event.preventDefault();
    });
    numeral.language('id');
    var no = 1;
    var totalItem = 0;

    justify();

    $('#selectIdTemplate').click(function() {
        $('#templateModal').modal('show');
        populateTable();
    });

    $("#ptp_justification").change(function(event) {
        justify();
    });

    $(".itemtr input").change(function(event) {
        calculateTotal();
    });

    $("#ptp_template_evaluasi").change(function(event) {
        // alert($(this).val());
        $.ajax({
            url: $("#base-url").val() + 'ET_Procurement_pengadaan/get_detail_template/' + $(this).val(),
            type: 'get',
            dataType: 'json',
        }).done(function(data) {
            $('#tbl_detail_template').empty();
            var setBody = '';
            for (var i = 0; i < data.detail.length; i++) {
                setBody += '<tr style="vertical-align: top;">';
                    setBody += '<td class="text-center" style="vertical-align: top;">'+(i+1)+'</td>';
                    setBody += '<td>';    
                        setBody += '<strong>'+data.detail[i].PPD_ITEM+'</strong>';    
                        setBody += '<ul class="listnya col-sm-offset-1 list-circle">';    
                        for (var j = 0; j < data.detail[i].uraian.length; j++) {
                            if(data.detail[i].PRASYARAT==1){
                                setBody += '<li>'+data.detail[i].uraian[j].PPTU_ITEM+'</li>';
                            }else{
                                setBody += '<li>'+data.detail[i].uraian[j].PPTU_ITEM+ '&nbsp;&nbsp;&nbsp; Bobot = '+data.detail[i].uraian[j].PPTU_WEIGHT+'</li>';
                            }                            
                        }   
                        setBody += '</ul>';
                        setBody += '</td>';                 
                    setBody += '<td class="text-center" style="vertical-align: top;">'+(data.detail[i].PRASYARAT==1?'Prasyarat':data.detail[i].PPD_WEIGHT)+'</td>';
                    setBody += '<td class="text-center" style="vertical-align: top;">'+(data.detail[i].PPD_MODE==1?'Fix':'Dinamis')+'</td>';                    
                setBody += '</tr>';
            }
            $('#tbl_detail_template').append(setBody);
        }).fail(function() {
        
        }).always(function(data) {
            console.log(data);            
            console.log(data.eval);
            console.log(data.detail);
            console.log(data.detail[0].uraian[0]);
        });
    });


    var template_table = null;
    function populateTable() {
        /* Populating the  table */
        if (template_table != null) {
            template_table.destroy();
        }
        i = 1;
        template_table = $('#template-table').DataTable( {
            "ajax": $("#base-url").val() + 'ET_Procurement_pengadaan/get_all_template',
            "columnDefs": [{
                "searchable": true,
                "orderable": false,
                "targets": 0
            }],
            "dom": 'rtip',
            "order": [[ 1, 'asc' ]],
            "columns": [
                { "data": null },
                { "data": "EVT_NAME" },
                { "data": "EVT_TYPE_NAME" },
                {
                    mRender : function(data,type,full){
                    return '<button type="button" class="btn btn-default btn-xs pull-right">Detail</button>'
                }}
            ],
        });
        template_table.on('draw', function () {
            template_table.column(0, {search:'applied', order:'applied', page:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();
        $("#template-table").removeAttr('style');
    }
    
    var progressBar = $('.progress-bar'),
        progressOuter = $('.progress-striped');
    $('.uploadAttachment').each(function(event) {
        var btn     = $(this),
            msgBox  = $($(btn).siblings('span.messageUpload')[0]);
        var uploader = new ss.SimpleUpload({
            button: btn,
            url: $("#base-url").val() + 'Procurement_pratender/uploadAttachment',
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
            url: $("#base-url").val() + 'Procurement_pratender/deleteFile',
            type: 'POST',
            data: {
                filename: $("#file_upload").val()
            },
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

    calculateTotal();

    $("#savedoc").click(function() {
        for (var i = 0; i < docs.length; i++) {
            // docs[i];
            ppd_id = docs[i].PPD_ID;
            bolo = $('#r' + ppd_id).is(':checked')
            doc_status(ppd_id, bolo ? 1 : 0);
        };

        $("#modal_dokumen").modal("hide")
    });

    $(".close-modal").click(function() {
        $(".modal").modal("hide")
    });

    $("form").submit(function(e) {        
        tanggal = $("#ptp_prebid_date").val();
        lokasi = $("#ptp_prebid_location").val();
        if($(".harusmilih_publicjs").val() == 'accept'){
            $("#msg_comment").css("display","none");
            if ($(".is_itemize").length > 0) {
                metode = false;
                $(".is_itemize").each(function() {
                    if ($(this).is(":checked")) {
                        metode = true;
                    }
                })
                if (!metode) {
                  $('#msg_is_itemize').css('display','');
                 sweetAlert(
                  'Metode Penawaran Harus Diisi',
                  'Pilih Metode Penawaran',
                  'warning'
                )
                e.preventDefault();
                 return false;
                }
            }

            if ($("#ptp_evaluation_method").val() == '') {
                $('#msg_ptp_evaluation_method').css('display','');
                    sweetAlert(
                       'Metode Sistem Sampul',
                       'Pilih Sistem Sampul',
                       'warning'
                    )
                e.preventDefault();
                 return false;
            }

            if($("#ptp_warning").val()==''){
                $('#msg_ptp_warning').css('display','');
                    sweetAlert(
                       'Sistem Peringatan Pada Penawaran',
                       'Pilih Sistem Peringatan Penawaran',
                       'warning'
                        )
                e.preventDefault();
                 return false;
            }

            if($("#ptp_warning_nego").val()==''){
                $('#msg_ptp_warning_nego').css('display','');
                    sweetAlert(
                       'Sistem Peringatan Pada Negosiasi',
                       'Pilih Sistem Peringatan Negosiasi',
                       'warning'
                        )
                e.preventDefault();
                 return false;
            }

            if($("#ptm_rfq_type").val()==''){
                $('#msg_ptm_rfq_type').css('display','');
                    sweetAlert(
                       'Tipe RFQ',
                       'Pilih Tipe RFQ',
                       'warning'
                        )
                e.preventDefault();
                 return false;
            }

            if($("#ptm_curr").val()==''){
                $('#msg_ptm_curr').css('display','');
                    sweetAlert(
                       'Currency',
                       'Pilih Mata Uang',
                       'warning'
                        )
                e.preventDefault();
                 return false;
            }

    	    if ($("#batasatasnego").val() == '') {
                ($("#msg_batasatasnego").css('display', ''));
    			sweetAlert(
    			  'Data Harus Dilengkapi',
    			  'Masukkan % Batas Nego',
    			  'warning'
    			)
               
                e.preventDefault();
                return false;
            }

       //      if ((tanggal != '' )&& (lokasi == '')) {
    			// sweetAlert(
    			//   'Data Harus Dilengkapi',
    			//   'Masukkan Tanggal dan Lokasi Aanwijzing!',
    			//   'warning'
    			// )
               
       //          e.preventDefault();
       //          return false;
       //      }

            // if ($("#evt_id").length > 0) {
            //     if ($("#evt_id").val() + '' == '') {
            //         ($("#msg_eval_id").css('display', ''));
            //          sweetAlert(
            //       'Tempatle Harus Diisi',
            //       'Pilih Template',
            //       'warning'
            //     )
            //     e.preventDefault();   
            //      return false;
            //     }
            // }
            // vnd_terpilih_tambahan
            vendor = false;
            vendor_tambahan = false;
            // $(".cek_pilih_vendor").each(function() {
            //     if ($(this).prop('checked')) {
            //         vendor = true;
            //     }
            // });

            $(".vnd_terpilih_tambahan").each(function() {
                if ($(this).prop('checked')) {
                    vendor_tambahan = true;
                }
            });

            $(".vnd_terpilih").each(function() {
                if ($(this).prop('checked')) {
                    vendor = true;
                }
            });
            if (!vendor && !vendor_tambahan) {
    			sweetAlert(
    			  'Data Harus Dilengkapi',
    			  'Pilih Salah Satu Vendor',
    			  'warning'
    			)
                e.preventDefault();
                 return false;
            }
        
            if ($("#ptp_reg_opening_date").length > 0) {
                if ($("#ptp_reg_opening_date").val() + '' == '') {
                  $('#msg_ptp_reg_opening_date').css('display','');
                    sweetAlert(
                      'RFQ Date Harus Diisi',
                      'Pilih Tanggal RFQ Date',
                      'warning'
                    )
                    e.preventDefault();
                    return false;
                }
            }

            if ($("#ptp_reg_closing_date").length > 0) {
                if ($("#ptp_reg_closing_date").val() + '' == '') {
                  $('#msg_ptp_reg_closing_date').css('display','');
                    sweetAlert(
                      'Quotation Deadline Harus Diisi',
                      'Pilih Tanggal Quotation Deadline',
                      'warning'
                    )
                    e.preventDefault();
                    return false;
                }
            }

            if ($("#ptp_delivery_date").length > 0) {
                if ($("#ptp_delivery_date").val() + '' == '') {
                  $('#msg_ptp_delivery_date').css('display','');
                    sweetAlert(
                      'Delivery Date Harus Diisi',
                      'Pilih Tanggal Delivery Date',
                      'warning'
                    )
                    e.preventDefault();
                   return false;
                }
            }

            if($("#ptp_term_delivery").val() !='' && $("#ptp_term_delivery_note").val() ==''){
                $('#msg_term').css('display','');
                    sweetAlert(
                       'Term of Delivery Description',
                       'Keterangan Tidak Boleh Kosong',
                       'warning'
                        )
                e.preventDefault();
                 return false;
            }

            if ($("#ptp_validity_harga").length > 0) {
                if ($("#ptp_validity_harga").val() + '' == '') {
                  $('#msg_ptp_validity_harga').css('display','');
                    sweetAlert(
                      'Tanggal Validity Harga Harus Diisi',
                      'Pilih Tanggal Validity Harga',
                      'warning'
                    )
                    e.preventDefault();
                    return false;
                }
            }

        }else{
            if ($("#comment").length > 0) {
                if ($("#comment").val() + '' == '') {
                    $('#msg_comment').css('display','');
                    sweetAlert(
                      'Komentar Harus Diisi',
                      'Harus diisi',
                      'warning'
                    )
                    e.preventDefault();
                    return false; 
                }               
            }

        }

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
                        $('.milihtombol_publicjs').prop('disabled', true);
                        form.submit();
                    } else {
                    }
                }) 
    });

//end submit

    if ($("#just").val() != '5') {
        if($("#jenis_perencanaan").val() == 0){ //barang
            // $('.panelvendor_barang').show();
            $('.panel_jasa_tambahan').hide();
            $table = $("#pr-list-table-vendor tbody");
            $table.html('<td colspan="8">Sedang memproses..</td>');

            $.ajax({
                url: $("#base-url").val() + 'ET_Procurement_pengadaan/get_vendor/' + $('#ptm_number').val(),
                type: 'get',
                dataType: 'json',
            })
            .done(function(data) {
                vendor = data.vendor;
                j = 1;
                $table = $("#pr-list-table-vendor tbody");
                $table.html('');
                for (var i = 0; i < vendor.length; i++) {
                    v = vendor[i];
                    if (v.header != null) {
                        td = ''
                        td += '<td class="text-center" nowrap>'+
                            '<input type="checkbox" class="hidden" checked name="vendor_driSAP[]" value="' + v.LIFNR + '"> '+
                            '<input type="checkbox" class="cekvendor cek_pilih_vendor" onchange="terpilih(this)" name="vendor[]" value="' + v.LIFNR + '"> '+(j++)+'</td>';
                        td += '<td class="text-center">' + v.LIFNR + '</td>';
                        td += '<td class="namavendor">' + v.header.VENDOR_NAME + '</td>';
                        td += '<td class="text-center">' + v.MATKL + '</td>';
                        td += '<td class="text-center">' + v.SUB_MATKL + '</td>';
                        td += '<td class="text-center">' + v.JP + '</td>';
                        td += '<td class="text-center">' + v.header.PERFORMA + '</td>';
                        td += '<td class="text-center">' + v.header.CATEGORY + '</td>';
                        td += '<td class="text-center">' + v.PO_TOTAL + '</td>';
                        td += '<td class="text-center">' + v.PO_OUTST + '</td>';
                        $table.append('<tr>' + td);
                    } else {
                        console.log("Vendor ini ga ada di database:");
                        console.log(v);
                    }
                }

                var table = $('#pr-list-table-vendor').DataTable({
                    "bSort": false,
                    "paging": false,
                    "scrollCollapse": true,
                    "scrollY": "500px",
                    "dom": 'rtip'
                });

                populate_vendor(table);

                table.columns().every( function () {
                    var that = this;
                
                    $( 'input', this.header() ).on( 'keyup change', function () {
                        if ( that.search() !== this.value ) {
                            that.search( this.value ).draw();
                        }
                    });
                });

            })
            .fail(function() {
                $table.html('<td colspan="8">Gagal mendapatkan data.</td>');
            })
            .always(function(data) {
                console.log(data);
            });
        
        }else{ //jasa
            $('.panel_jasa_tambahan').show();
            // $('.panelvendor_barang.pnl_dua').show();
            // $('.panelvendor_barang.pnl_satu').hide();

            id_ptm = $("#ptm_number").val();
            var tableGrid = $('#table_vendor_jasa').DataTable( {
                "bDestroy": true,
                "ordering": false,
                "dom": 'rtip',
                "scrollY": "500px",
                "scrollCollapse": true,
                "paging": false,
                "ajax": {
                    url : $("#base-url").val() + "ET_Procurement_pengadaan/get_vendor_jasa",
                    method : 'post',
                    data : {id_ptm},
                },
                "columnDefs": [{
                    "searchable": false,
                    "orderable": false,
                    "targets": 0
                }],
                "columns":[
                    {
                        "data":   null,
                    },
                    {
                        mRender: function (data,type,full) {
                            return  '<input type="checkbox" class="cekvendor cek_pilih_vendor" name="vendor[]" onchange="terpilih(this)" value="' + full.VENDOR_NO + '">';
                        },
                        className: "dt-body-center"
                    },
                    {"data" : "VENDOR_NO"},
                    {
                        mRender: function (data,type,full) {
                            return full.VENDOR_NAME;
                        },
                        className: "namavendor"
                    },
                    {"data" : "PRODUCT_NAME"},
                    {"data" : "KLASIFIKASI_NAME"},
                    {"data" : "SUBKUALIFIKASI_NAME"},
                    {
                        "data":   "PERFORMA",
                        className: "text-center"
                    },
                    {
                        "data":   "CATEGORY",
                        className: "text-center"
                    },
                ],

                "initComplete" : function(settings,json){
                    setTimeout(function(){populate_vendor(tableGrid);}, 1000);   
                }
            } );

            
            tableGrid.on('draw', function () {
                tableGrid.column(0, {search:'applied', order:'applied', page:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                } );
            } ).draw();
            tableGrid.columns().every( function () {
                var that = this;
            
                $( 'input', this.header() ).on( 'keyup change', function () {
                    if ( that.search() !== this.value ) {
                        that.search( this.value ).draw();
                    }
                });
            });


        }

    } else {
        // $('.panelvendor_barang').attr('hidden','hidden');
        $table = $("#pr-list-table-po tbody");
        $table.html('<td colspan="8">Sedang memproses..</td>');
        
        $.ajax({
            url: $("#base-url").val() + 'Procurement_pratender/get_po_from_ptm/' + $("#ptm_number").val(),
            type: 'POST',
            dataType: 'json',
            success : function(results){
                console.log('hasil vendor'+results);
                $('#pr-list-table-po').html(results.detail); 
                $(".vendor_terpilih").append(results.vnd_terpilih);             
            },
            fail : function(results){
                console.log(results);
            }
        });


        // $.ajax({
        //     url: $('#base-url').val() + 'Procurement_release/populate_vendor/' + $('#ptm_number').val(),
        //     type: 'get',
        //     dataType: 'json',
        // })
        // .done(function(data) {
        //     // console.log(data);
        //     for (var i = 0; i < data.vendor.length; i++) { 
        //         var cells = $("#pr-list-table-po").cells().nodes();
        //         lala = 0;
        //         $(cells).find(".cek_pilih_vendor").each(function(){
        //             // console.log("tes");
        //             if (lala == 0) {
        //                 if ($(this).val() == data.vendor[i].PTV_VENDOR_CODE) {
        //                     $(this).prop('checked', 'checked');
        //                     // $(this).parent().parent().css("background-color","#dff0d8");
        //                     terpilih(this);
        //                     lala = 1;
        //                 }
        //             }
        //         })
        //         // $(".cek_pilih_vendor").each(function(){
        //         //     // console.log("tes");
        //         //     if ($(this).val() == data.vendor[i].PTV_VENDOR_CODE) {
        //         //         $(this).prop('checked', 'checked');
        //         //     }
        //         // })
        //     };
        // })
        // .fail(function() {
        //     console.log("error");
        // })
        // .always(function(data) {
        //     console.log(data);
        // });
        ///////////////

        // $table = $("#pr-list-table-po tbody");
        // $table.html('<td colspan="8">Sedang memproses..</td>');

        // i = 0;
        // $.ajax({
        //     url: $("#base-url").val() + 'Procurement_pratender/get_po_from_ptm/' + $("#ptm_number").val(),
        //     type: 'POST',
        //     dataType: 'json',
        // })
        // .done(function(data) {
        //     po = data.IT_DATA;
        //     j = 1;
        //     $table = $("#pr-list-table-po tbody");
        //     $table.html('');

        //     $.each( po, function( key, value ) {
        //         v = value;
        //         if (v.LIFNR == '') {
        //             // ga ada kode vendor
        //         } else {
        //             td = ''
        //             td += '<td class="text-center"><input type="checkbox" class="cekvendor cek_pilih_vendor" onchange="terpilih(this)" name="vendor[]" value="' + v.LIFNR + '"> '+(j++)+'</td>';
        //             td += '<td>' + v.LIFNR + '</td>';
        //             td += '<td class="namavendor">' + v.NAME1 + '</td>';
        //             td += '<td>' + v.EBELN + '</td>';
        //             td += '<td>' + '' + '</td>';
        //             td += '<td>' + v.count + '</td>';
        //             $table.append('<tr>' + td);
        //          }
        //     });

        //     table_generate_po = $('#pr-list-table-po').DataTable({
        //         "bSort": false,
        //         "paging": false,
        //         "scrollCollapse": true,
        //         "scrollY": "500px",
        //         "dom": 'rtip'
        //     });

        //     populate_vendor(table_generate_po);

        //     table_generate_po.columns().every( function () {
        //         var that = this;
        //         $( 'input', this.header() ).on( 'keyup change', function () {
        //             if ( that.search() !== this.value ) {
        //                 that.search( this.value ).draw();
        //             }
        //         });
        //     });
            
        // })
        // .fail(function() {
        //     $table.html('<td colspan="8">Gagal mendapatkan data.</td>');
        // })
        // .always(function(data) {
        //     console.log(data);
        //     $('.generate_po').removeClass('disabled');
        // });
    }

    $(".snippet_detail_item").click(function() {
      $tr = $(this).parent().parent();
      ppi_id = $tr.find('.ppi').html();
      nomat = $tr.find('.nomat').html();

      $("#modal_detail_item_snippet").modal("show");

      /* populate detail item */
      $(".snippet_modal_pritem").html($tr.find('.pritem').html());
      $(".snippet_modal_prno").html($tr.find('.prno').html());
      $(".snippet_modal_nomat").html($tr.find('.nomat').html());
      $(".snippet_modal_decmat").html($tr.find('.decmat').html());
      $(".snippet_modal_matgroup").html($tr.find('.matgroup').html());
      $(".snippet_modal_mrpc").html($tr.find('.mrpc').html());
      $(".snippet_modal_plant").html($tr.find('.plant').html());
      $(".snippet_modal_pg").html($tr.find('.pg').html());
      //*/

      docat = $tr.find('.docat').html();
    });

    $(".select2").select2();

    $('#group_jasa_id').change(function(){
        id = $('#group_jasa_id').val();
        $.ajax({
            url: $("#base-url").val() + "Procurement_pratender/pilih_child",
            method : 'post',
            data : "id="+id,
            success: function(data){
                $("#subGroup_jasa_id").select2("val", "");
                $("#klasifikasi_jasa_id").select2("val", "");
                $("#subGroup_jasa_id").html(data);
                $("#klasifikasi_jasa_id").html(''); 
                $('.new_data').remove();
                $('#table_vendor_jasa_tambahan tbody').remove();
            }
        });
        return false;
    });

    $('#subGroup_jasa_id').change(function(){
        id = $('#subGroup_jasa_id').val();
        $.ajax({
            url: $("#base-url").val() + "Procurement_pratender/pilih_child",
            method : 'post',
            data : "id="+id,
            success: function(data){
                $("#klasifikasi_jasa_id").select2("val", "");
                $("#klasifikasi_jasa_id").html(data);
                $('.new_data').remove();
                $('#table_vendor_jasa_tambahan tbody').remove();
            }
        });
        return false;
    });

    $('#klasifikasi_jasa_id').change(function(){
        id = $('#klasifikasi_jasa_id').val();
        $('.new_data').remove();
        $.ajax({
            url : $("#base-url").val() + 'Procurement_pratender/pilih_sub_klasifikasi',
            method : 'post',
            data : "id="+id,
            success : function(result)
            {
                var val = $.parseJSON(result);
                var options1 = '';
                var options2 = '';
                if(val != null){
                    for (var i = 0; i < val.length; i++) {
                        description = '';
                        if(val[i].DESCRIPTION != null){
                            description = ' - ' + val[i].DESCRIPTION;
                        }
                        if(i % 2 == 0){
                            options1 += '<div class="new_data"><input class="check_jasa" type="checkbox" onchange="cekvendor_jasa(this)" name="subKlasifikasi_jasa_id[]" value="' + val[i].ID + '"> ' + val[i].NAMA + description +'</div>';
                        }
                        else{
                            options2 += '<div class="new_data"><input class="check_jasa" type="checkbox" onchange="cekvendor_jasa(this)" name="subKlasifikasi_jasa_id[]" value="' + val[i].ID + '"> ' + val[i].NAMA + description +'</div>';
                        }
                    }
                    $('#subKlasifikasi_ganjil').append(options1);
                    $('#subKlasifikasi_genap').append(options2);
                    $('#table_vendor_jasa_tambahan tbody').remove();
                
                }else{
                    $('#subKlasifikasi').append('<div class="new_data"> Data Kosong. </div>');
                }
            }
        })
    });   

    $('#search').click(function(){
        $table = $("#table_vendor_jasa_tambahan tbody");
        $table.html('<td colspan="8">Sedang memproses..</td>');
        
        group_jasa_id = $('#group_jasa_id').val();
        subGroup_jasa_id = $('#subGroup_jasa_id').val();
        klasifikasi_jasa_id = $('#klasifikasi_jasa_id').val();
        subKlasifikasi_jasa_id = new Array();
        $.each($("input[name='subKlasifikasi_jasa_id[]']:checked"), function() {
            subKlasifikasi_jasa_id.push($(this).val());
        });

        if(group_jasa_id == ''){
            alert('Pilih dahulu yang akan di filter !!');
            return false;
        }
            
        var tableGrid = $('#table_vendor_jasa_tambahan').DataTable( {
            "bDestroy": true,
            "ordering": false,
            "dom": 'rtip',
            "scrollY": "500px",
            "scrollCollapse": true,
            "paging": false,
            "ajax": {
                url : $("#base-url").val() + "Procurement_pratender/get_vendor_jasa",
                method : 'post',
                data : {group_jasa_id, subGroup_jasa_id, klasifikasi_jasa_id, subKlasifikasi_jasa_id},
            },
            "columnDefs": [{
                "searchable": false,
                "orderable": false,
                "targets": 0
            }],
            "columns":[
                {
                    "data":   null,
                },
                {
                    mRender: function (data,type,full) {
                        return '<input type="checkbox" onchange="terpilih_vnd_tambahan(this)" class="cekvendor_tambahan" name="vendor_tambahan[]" value="' + full.VENDOR_NO + '">';
                    },
                    className: "dt-body-center"
                },
                {"data" : "VENDOR_NO"},
                {
                    mRender: function (data,type,full) {
                        return full.VENDOR_NAME;
                    },
                    className: "namavendor_tambahan"
                },
                {"data" : "PRODUCT_NAME"},
                {"data" : "KLASIFIKASI_NAME"},
                {"data" : "SUBKUALIFIKASI_NAME"},
                {
                    "data":   "PERFORMA",
                    className: "text-center"
                },
                {
                    "data":   "CATEGORY",
                    className: "text-center"
                },
            ],
        } );
        
        tableGrid.on('draw', function () {
            tableGrid.column(0, {search:'applied', order:'applied', page:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();
        tableGrid.columns().every( function () {
            var that = this;
        
            $( 'input', this.header() ).on( 'keyup change', function () {
                if ( that.search() !== this.value ) {
                    that.search( this.value ).draw();
                }
            });
        });

    });

        // Generate vendor barang Non Dirven / tambahan
    $('#generate_vnd_brg_tmbhn').click(function(){
        $table = $("#table_vendor_barang_tambahan tbody");
        $table.html('<td colspan="8">Sedang memproses..</td>');

        vendor = new Array();
        $.each($("input[name='vendor_driSAP[]']:checked"), function() {
            vendor.push($(this).val());
        });
        
        $(function() {
          $("#grdBarang").height(500);
        });
        
        var tableGridBarang = $('#table_vendor_barang_tambahan').DataTable( {            
            "bDestroy": true,
            "ordering": false,
            "dom": 'rtip',
            //"scrollY": "500px",
            "scrollCollapse": true,
            "paging": false,

            "ajax": {
                url : $("#base-url").val() + "ET_Procurement_pengadaan/get_vendor_barang",
                method : 'post',
                data : {vendor},
            },
            "columnDefs": [{
                // "searchable": false,
                // "orderable": false,
                "targets": 1
            }],
            "columns":[
                {
                    "data":   null,
                },
                {
                    mRender: function (data,type,full) {
                        return '<input type="checkbox" onchange="terpilih_vnd_tambahan(this)" class="cekvendor_tambahan" name="vendor_tambahan[]" value="' + full.VENDOR_NO + '">';
                    },
                    className: "dt-body-center"
                },
                {"data" : "VENDOR_NO"},
                {
                    mRender: function (data,type,full) {
                        return full.VENDOR_NAME;
                    },
                    className: "namavendor_tambahan"
                },
                {
                    "data":   null,
                    render: function (data,type,full) {
                        return '';
                    },
                },
                {
                    "data":   null,
                    render: function (data,type,full) {
                        return '';
                    },
                },
                {
                    "data":   null,
                    render: function (data,type,full) {
                        return '';
                    },
                },
                {
                    "data":   null,
                    render: function (data,type,full) {
                        return '';
                    },
                },
                {
                    "data":   null,
                    render: function (data,type,full) {
                        return '';
                    },
                },
                {
                    "data":   null,
                    render: function (data,type,full) {
                        return '';
                    },
                },
                {
                    "data":   null,
                    render: function (data,type,full) {
                        return '';
                    },
                },
            ],
        } );
        
        tableGridBarang.on('draw', function () {
            tableGridBarang.column(0, {search:'applied', order:'applied', page:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();
        tableGridBarang.columns().every( function () {
            var that = this;
        
            $( 'input', this.header() ).on( 'keyup change', function () {
                if ( that.search() !== this.value ) {
                    that.search( this.value ).draw();
                }
            });
        });

    });

});

function cekvendor_jasa(e){
    if($(e).prop('checked')){
        $('#table_vendor_jasa_tambahan tbody').remove();
    } 
}

function populate_vendor(table) {
    // console.log("data");
    $.ajax({
        url: $('#base-url').val() + 'Procurement_release/populate_vendor/' + $('#ptm_number').val(),
        type: 'get',
        dataType: 'json',
    })
    .done(function(data) {
        // console.log(data);
        for (var i = 0; i < data.vendor.length; i++) { 
            var cells = table.cells().nodes();
            lala = 0;
            $(cells).find(".cek_pilih_vendor").each(function(){
                // console.log("tes");
                if (lala == 0) {
                    if ($(this).val() == data.vendor[i].PTV_VENDOR_CODE) {
                        $(this).prop('checked', 'checked');
                        // $(this).parent().parent().css("background-color","#dff0d8");
                        terpilih(this);
                        lala = 1;
                    }
                }
            })
            // $(".cek_pilih_vendor").each(function(){
            //     // console.log("tes");
            //     if ($(this).val() == data.vendor[i].PTV_VENDOR_CODE) {
            //         $(this).prop('checked', 'checked');
            //     }
            // })
        };
    })
    .fail(function() {
        console.log("error");
    })
    .always(function(data) {
        console.log(data);
    });
}

function terpilih_vnd_tambahan(e){
    vendorno = $(e).val();
    if($(e).is(":checked")){  
        if($("#ptp_justification").val() >= 5 && $("#ptp_justification").val() <= 8 ){
            vnd = $(".cekvendor:checked").length;
            vnd_tmbhn = $(".cekvendor_tambahan:checked").length;
            dicentang = Number(vnd)+Number(vnd_tmbhn);
            if(dicentang > 1){
                alert("Metode penunjukan langsung hanya boleh satu vendor");
                $(e).prop("checked", false);
                return false;
            } 
        }      
        $(e).parent().parent().addClass("success");
        ada = false;
        $(".vnd_terpilih_tambahan").each(function() {
            if ($(this).val() == vendorno) {
                ada = true;
            }
        }); 

        if (!ada) {
            tr = '<tr>' +
                    // '<td class="text-center"><input type="checkbox" class="vnd_terpilih_tambahan" onclick="nocentang_tambahan(this)" value="' + vendorno + '" checked></td>' +
                    '<td>' + vendorno + '</td>' +
                    '<td>' + $(e).parent().parent().find('.namavendor_tambahan').html() + '</td>' +
                  '</tr>';
            $(".vendor_terpilih_tambahan").append(tr);
        }

    } else {
        masih_ada = false;
        $(".cekvendor_tambahan:checked").each(function() {
            if ($(this).val() == vendorno) {
                masih_ada = true;
            }
        });
        if (masih_ada) {

        } else {
            $(".vnd_terpilih_tambahan").each(function() {
                if ($(this).val() == vendorno) {
                    $(this).parent().parent().remove();
                }
            });
        }
        $(e).parent().parent().removeClass("success");
    }

}

function nocentang_tambahan(e){
    if($(e).is(":checked")){

    } else {
        vendorno = $(e).val();
        $(".cekvendor_tambahan:checked").each(function() {
            if ($(this).val() == vendorno) {
                $(this).prop('checked', false);
                terpilih_vnd_tambahan(this);
            }
        });
        $(e).parent().parent().remove();
    }
}