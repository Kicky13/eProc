
function check(){
    $('.error').hide();
    var contents = $('#items_table');
    count = $('input[name=assign]:checked', '#items_table').val();
    jumlah = Number($('input[name=jumlah'+count+']', '#items_table').val());
    quantopen = Number($('input[name=quantopen]', '#items_table').val());
    qtyused = Number($('input[name=qtyused]', '#items_table').val());

    if(typeof count != "undefined") {
        if (jumlah > 0) {
            if (jumlah <= (quantopen - qtyused)){
                return true;
            }
        }
        return false;
    } else {
        return false;
    }
}

$(document).ready(function(){

    $('form').submit(function(e){
        console.log("check");
        var submit = check();
        console.log('submit = ' + (submit ? 'true' : 'false'));
        if(submit == false) {
            e.preventDefault();
        } else {
            // e.preventDefault();
        }
    })

    $('.jumlahnya').change(function() {
        quantopen = Number($('input[name=quantopen]', '#items_table').val());
        qtyused = Number($('input[name=qtyused]', '#items_table').val());
        open = quantopen - qtyused;

        val = Number($(this).val())
        if (val < 0) val = 0;
        if (val > open) val = open;
        $(this).val(val);
    });

    $('.jumlahnya').prop('disabled', true).addClass('disabled');

    $('input[name=assign]').change(function() {
        tr = $(this).parent().parent();
        $('.jumlahnya').prop('disabled', true).addClass('disabled');
        tr.find('.jumlahnya').prop('disabled', false).removeClass('disabled');
    });

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
    });

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
        // table = $("#dokumentable");
        // table.html("");
        // docs = data.docs;
        // for (var i = 0; i < data.docs.length; i++) {
        //     doc = data.docs[i];
        //     table.append('<tr>' +
        //         '<td><input type="radio" value="'+ doc.PPD_ID+'" id="r'+ doc.PPD_ID+'" name="' + doc.PDC_NAME + '"'+(doc.PPD_STATUS == 1 ? "checked" : "")+'></td>' +
        //         '<td>'+ doc.PDC_NAME+'</td>' +
        //         '<td>'+ doc.PPD_DESCRIPTION+'</td>' +
        //         '<td><a href="'+ $("#base-url").val() + $("#UPLOAD_PATH").val() + 'ppm_document/' + doc.PPD_FILE_NAME+'" download>Download</a></td>' +
        //         '<td>'+ doc.PPD_CREATED_AT+'</td>' +
        //         '<td>'+ doc.PPD_CREATED_BY+'</td>' +
        //         '</tr>'
        //     )
        // };
    })
    .fail(function() {
        console.log("error");
    })
    .always(function(data) {
        console.log(data);
    });
    $("#modal_dokumen").modal("show")
}

function getlong(e) {
    ppi_id = $(e).data('ppi');
    nomat = $(e).data('nomat');
    $.ajax({
        url: $("#base-url").val() + 'Snippet_ajax/getlongtext/' + ppi_id + '/' + nomat,
        type: 'post',
        dataType: 'html'
    })
        .done(function(data) {
            $("#idgetlong").html(data);
            $("#modal_getlong").modal("show");
            $(".long_text_snippet_item").html(data);            
        })
        .fail(function() {
            console.log("error");
        })
        .always(function(data) {
            console.log(data);
        });

}