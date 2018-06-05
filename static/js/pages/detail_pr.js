function select(e) {
    tr = $(e).parent().parent();
    tr.toggleClass('danger');

    pritem = tr.find('.pritem').html();
    console.log(tr.html())
    if ($(e).prop('checked')) {
        $(".pritem"+pritem).remove();
    } else {
        $("#tablecomment").append('<div class="table-responsive">'+
            '<table class="table table-hover">'+
            '<tr class="pritem'+ pritem +'">'+
            '<td>' +
                '<input type="hidden" name="itemreject[]" class="itemreject" value="'+pritem+'">'+
                '<div class="row">' +
                    '<div class="col-md-2 text-right">' + 
                            '<p>PR Item</p>' +
                            '<p>Kode Material</p>' +
                            '<p>Nama Material</p>' +
                            '<p>Harga</p>' +
                    '</div>' +
                    '<div class="col-md-2">' + 
                        '<div class="row">'+
                            '<p> : ' + tr.find('.pritem').html() + '</p>' +
                            '<p> : ' + tr.find('.nomat').html() + '</p>' +
                            '<p> : ' + tr.find('.decmat').html() + '</p>' +
                            '<p> : ' + tr.find('.netprice').html() + '</p>' +
                        '</div>'+
                    '</div>' +
                    '<div class="col-md-2 text-right">' + 
                            '<p>PR Qty</p>' +
                            '<p>Open Qty</p>' +
                            '<p>PO Qty</p>' +
                            '<p>Hand Qty</p>' +
                    '</div>' +
                    '<div class="col-md-2">' + 
                        '<div class="row">'+
                            '<p> : ' + tr.find('.prquantity').html() + '</p>' +
                            '<p> : ' + tr.find('.quantopen').html() + '</p>' +
                            '<p> : ' + tr.find('.poquantity').html() + '</p>' +
                            '<p> : ' + tr.find('.handquantity').html() + '</p>' +
                        '</div>'+
                    '</div>' +
                    '<div class="col-md-4">' + 
                        '<br>'+
                        '<br>'+
                        '<h5><input type="radio" class="rejct_item" name="reject['+pritem+']" value="0" checked> REJECT Item</h5>'+
                        '<h5><input type="radio" class="rejct_document" name="reject['+pritem+']" value="1"> REJECT Document</h5>'+
                    '</div>' +
                    '<div class="col-md-12">' + 
                    '<textarea name="detailreject[]" class="hidden">'+
                        'PR Item:'+tr.find('.pritem').html()+';'+
                        'Kode Material:'+tr.find('.nomat').html()+';'+
                        'Nama Material:'+tr.find('.decmat').html()+';'+
                        'Harga:'+tr.find('.netprice').html()+';'+
                        'PR Qty:'+tr.find('.prquantity').html()+';'+
                        'Open Qty:'+tr.find('.quantopen').html()+';'+
                        'PO Qty:'+tr.find('.poquantity').html()+';'+
                        'Hand Qty:'+tr.find('.handquantity').html()+';'+
                    '</textarea>'+
                    '<input type="text" class="form-control" id="komen_reject_'+pritem+'" name="commentreject[]" placeholder="Masukan alasan mereject item ini.">' +
                    '</div>' +
                '</div>' +
            '</td></tr></table></div>'
        )
    }
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

var docs = null;

$(document).ready(function(){

    $(".check-success").change(function() {select(this)});

    $('#submit-form').click(function() {
        $table = $("#items_table");
        all = $table.find(".check-success");
        bye = $table.find(".check-success:not(:checked)");
        $("#all").html(all.length);
        $("#bye").html(bye.length);
        cekKomen = false;
        if (bye.length != 0) {
            $(".itemreject").each(function(){
                itm = $(this).val();
                if($('#komen_reject_'+itm).val()==''){
                    cekKomen = true;
                }
            }); 
            if(cekKomen){
                alert('Alasan mereject tidak boleh kosong.');
                return false;
            }
            
            $("#bye").addClass('text-danger')
            sizeitem = $(".rejct_item:checked").size();
            dokumen = "";
            if (sizeitem <= 0) {
                dokumen = " dokumen"
            }
            $("#isverify").val(0);
            $("#apakah").html("mereject" + dokumen);
            console.log(666)
            $("#modal-verifikasi").modal("show")
        } else {
            $("#bye").removeClass('text-danger')
            $("#isverify").val(1);
            $("#apakah").html("memverifikasi");
            console.log(8)
            $("#modal-verifikasi-cek").modal("show")

        }

    });

    $(".close-modal").click(function() {
        $(".modal").modal("hide")
    });

    $(".btn_history").click(function() {
        /* Jika jasa, maka nampilin detail jasa */
        console.log('btn_history.click = ' + $("#doc_cat").val());
        tr = $(this).parent().parent();
        if ($("#doc_cat").val() == '9') {
            pr = $("#prno").html();
            ppi = $(this).data('ppi');
            // $("#modal_dokumen").find('.pr').html(pr);
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
            
            nomat = tr.find(".nomat").html();
            ppi_id = tr.find(".ppi_id").val();

            $.ajax({
                url: $("#base-url").val() + 'Snippet_ajax/getlongtext/' + ppi_id + '/' + nomat,
                type: 'get',
                dataType: 'html',
            })
            .done(function(data) {
                $("#modal_dokumen").find(".modal-body").append(data);
            })
            .fail(function() {
                console.log("error");
            })
            .always(function(data) {
                console.log(data);
            });

            $("#modal_dokumen").modal("show")
        }
        /* Jika barang, maka nampilin history */
        else {
            nomat = tr.find(".nomat").html();
            ppi_id = tr.find(".ppi_id").val();
            console.log(nomat);

            $.ajax({
                url: $("#base-url").val() + 'Snippet_ajax/history_material/' + ppi_id,
                type: 'get',
                dataType: 'html',
            })
            .done(function(data) {
                $("#modal_history").find(".history_material").html(data);
            })
            .fail(function() {
                console.log("error btn_history");
            });

            $.ajax({
                url: $("#base-url").val() + 'Snippet_ajax/getlongtext/' + ppi_id + '/' + nomat,
                type: 'get',
                dataType: 'html',
            })
            .done(function(data) {
                $("#modal_history").find(".long_text").html(data);
                console.log("success");
            })
            .fail(function() {
                console.log("error");
            })
            .always(function(data) {
                console.log(data);
            });
            
            $("#modal_history").modal("show")
        }
    });

    $(".open_dokumen").click(function() {

        pr = $("#prno").html();
        $.ajax({
            url: $("#base-url").val() + 'Procurement_sap/get_detail_doc/' + pr,
            type: 'post',
            dataType: 'json'
        })
        .done(function(data) {
            table = $("#dokumentable");
            table.html("");
            docs = data.docs;
            for (var i = 0; i < data.docs.length; i++) {
                doc = data.docs[i];
                table.append('<tr>' +
                    '<td><input type="radio" value="'+ doc.PPD_ID+'" id="r'+ doc.PPD_ID+'" name="' + doc.PDC_NAME + '"'+(doc.PPD_STATUS == 1 ? "checked" : "")+'></td>' + 
                    '<td>'+ doc.PDC_NAME+'</td>' + 
                    '<td>'+ doc.PPD_DESCRIPTION+'</td>' + 
                    '<td><a href="'+ $("#base-url").val() + $("#UPLOAD_PATH").val() + 'ppm_document/' + doc.PPD_FILE_NAME+'" target="_blank">Download</a></td>' + 
                    '<td>'+ doc.PPD_CREATED_AT+'</td>' + 
                    '<td>'+ doc.PPD_CREATED_BY+'</td>' + 
                    '</tr>'
                )
            };
        })
        .fail(function() {
            console.log("error");
        })
        .always(function(data) {
            console.log(data);
        });
        $("#modal_dokumen").modal("show")
    })

    $("#savedoc").click(function() {
        for (var i = 0; i < docs.length; i++) {
            // docs[i];
            ppd_id = docs[i].PPD_ID;
            bolo = $('#r' + ppd_id).is(':checked')
            doc_status(ppd_id, bolo ? 1 : 0);
        };

        $("#modal_dokumen").modal("hide")
    });
})

function dokumen_by_pr(e) {
    ppi = $(e).data('itemid');
    $.ajax({
        url: $("#base-url").val() + 'Snippet_ajax/dokumen_by_pr/' + ppi,
        type: 'post',
        dataType: 'html'
    })
    .done(function(data) {
        $("#dokumen_by_pr").find(".modal-body").html(data);
    })
    .fail(function() {
        console.log("error");
    })
    .always(function(data) {
        console.log(data);
    });
    $("#dokumen_by_pr").modal("show")
}