

function select(e) {
    tr = $(e).parent().parent();
    tr.toggleClass('success');
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

$(document).ready(function(){
    $('#checkAll').click(function(){
        chk = $(this).is(':checked');
        if(chk){
            $('.chek_all').prop('checked', true);
        }else{
            $('.chek_all').prop('checked', false);
        }
    });
	/*$(".formsubmit").click(function(e){
        e.preventDefault();
        swal({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          type: 'warning',
          showCancelButton: true,
          cancelButtonColor: '#d33',
          confirmButtonColor: '#3085d6',
          cancelButtonText: 'No',
          confirmButtonText: 'Yes',
          cancelButtonClass: 'btn btn-danger',
          confirmButtonClass: 'btn btn-success',
          closeOnConfirm: true,
          closeOnCancel: true
        },
        function(isConfirm) {
          if (isConfirm === true) {
            $("form.submit").submit();
          } else if (isConfirm === false) {

          } else {
            
          }
        })
    });*/
	var doc_num = 1;
	var file_list = [];
	var file_opt = [];
	var file_opts = [];
	$('#document-table').hide();
	$('#list-document-modal').hide();

    /* Document category */
    category = null;
    category_options = '';
    $.ajax({
        url: $('#base-url').val() + 'Procurement_sap/get_category',
        type: 'GET',
        dataType: 'json'
    })
    .done(function(data) {
        console.log("success");
        console.log(data);
        category = data;
        for (var i = 0; i < category.length; i++) {
            category_options += '<option value="'+category[i].PDC_ID+'">'+category[i].PDC_NAME+'</option>';
        };
        $("#tipe_select").append(category_options);
    })
    .fail(function(data) {
        console.log("error");
        console.log(data);
    });
    //*/

    $(".close-modal").click(function() {
        $(".modal").modal("hide")
    });

    $('#submit-form').click(function() {
        for (var key in file_list) {
            file_opt = [];
            file_opt.push($('#document_category_'+file_list[key]).val());
            file_opt.push($('#document_desc_'+file_list[key]).val());
            file_opts.push(file_opt);
        }

        $('#doc').val(file_opts);
    });
})

function open_dokumen(e) {
    pr = $("#prno").html();
    ppi = $(e).data('ppi');

    tr = $(e).parent().parent();
    nomat = tr.find(".nomat").html();

    // $("#modal_dokumen").find('.pr').html(pr);
    if ($('#doc_cat').val() == '9') {
        $.ajax({
            url: $("#base-url").val() + 'Snippet_ajax/pr_doc_service/' + ppi,
            type: 'post',
            dataType: 'html'
        })
        .done(function(data) {
            $("#modal_dokumen").find(".modal_jasa").html(data);
        })
        .fail(function() {
            console.log("error");
        })
        .always(function(data) {
            console.log(data);
        });
    }

    $("#modal_dokumen").find(".modal_longtext").html('Sedang mengambil data di SAP..');
    $.ajax({
        url: $("#base-url").val() + 'Snippet_ajax/getlongtext/' + ppi + '/' + nomat,
        type: 'get',
        dataType: 'html',
    })
    .done(function(data) {
        $("#modal_dokumen").find(".modal_longtext").html(data);
    })
    .fail(function() {
        console.log("error");
        $("#modal_dokumen").find(".modal_longtext").html('Gagal mengambil data di SAP.');
    })
    .always(function(data) {
        console.log(data);
    });

    $("#modal_dokumen").modal("show");
}