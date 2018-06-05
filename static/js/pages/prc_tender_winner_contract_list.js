function numberWithCommas(x) {
    var parts = x.toString().split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return parts.join(".");
}

function cekbox(e) {
    if ($(e).prop('checked')) {
        $(e).addClass('checked');
    } else {
        $(e).removeClass('checked');
    }
    namavendor = "";
    count = true;
    sama = true;
    $('.cekbox').each(function(){
        if($(this).hasClass("checked")){
            if(count){
                namavendor = $(this).parent().parent().find('.ebeln').html();
                count = false;
            } else {
                nama = $(this).parent().parent().find('.ebeln').html();                
                if(namavendor != nama)  sama = false;
            }
        }
    });
    console.log(namavendor);
    if(sama){
        $("#cekvendor").addClass("hidden");
    } else {
        $("#cekvendor").removeClass("hidden");
    }

    if($("#cekvendor").hasClass("hidden")){
        $("#submit-form").removeAttr("disabled");
    } else {
        $("#submit-form").attr("disabled", "disabled");
    }
}

function cekboxrfq(e) {
    if ($(e).prop('checked')) {
        $(e).addClass('checked');
    } else {
        $(e).removeClass('checked');
    }
    namavendor = "";
    count = true;
    sama = true;
    $('.cekboxrfq').each(function(){
        if($(this).hasClass("checked")){
            if(count){
                namavendor = $(this).parent().parent().find('.ebeln').html();
                count = false;
            } else {
                nama = $(this).parent().parent().find('.ebeln').html();                
                if(namavendor != nama)  sama = false;
            }
        }
    });
    console.log(namavendor);
    if(sama){
        $("#cekvendor").addClass("hidden");
    } else {
        $("#cekvendor").removeClass("hidden");
    }

    if($("#cekvendor").hasClass("hidden")){
        $("#submit-form").removeAttr("disabled");
    } else {
        $("#submit-form").attr("disabled", "disabled");
    }
}

function open_dokumendua(e) {
    ppi_id = $(e).data('ppi');
    nomat = $(e).data('nomat');
   // docat = $(e).data('docat');
   
    $.ajax({
        url: $("#base-url").val() + 'Snippet_ajax/pop_up_barang/'+ppi_id,
        type: 'post',
        dataType: 'html'
    })
    .done(function(data) {

        $("#idku").html(data);
        $("#modal_dokumen_dua").modal("show");

        $.ajax({
        url: $("#base-url").val() + 'Snippet_ajax/getlongtext/' + ppi_id + '/' + nomat,
        type: 'post',
        dataType: 'html'
        })
        .done(function(data) {
            $(".long_text_snippet_item").html(data);
            // $("#modal_dokumen_dua").modal("show");
            
        })
        .fail(function() {
            console.log("error");
        })
        .always(function(data) {
            console.log(data);
        });

    })
    .fail(function() {
        console.log("error");
    })
    .always(function(data) {
        console.log(data);
    });

   
}

$(document).ready(function(){

	base_url = $("#base-url").val();
    var table_job_list = $('#prc-tender-winner-list-table-contract').DataTable({
		"ajax" : $("#base-url").val() + 'Tender_winner_contract/get_datatablecontract/',

        "columnDefs": [{
            "searchable": false,
            "orderable": false,
            "targets": 0
        }],
        "order": [[ 4, "desc" ]],
        
        "columns":[
            {
                mRender : function(data,type,full){
                    var ans = "";
                    ans += '<input type="checkbox" class="cekbox" onchange="cekbox(this)" name="winner['+full.PTW_ID+']" value="'+full.PTW_ID+'">';
                    return ans;
                }
            },
            {"data" : "PPI_PRNO"},
            // {"data" : "PTV_RFQ_NO"},
            {
                mRender : function(data,type,full){
                    var ans = "";
                    ans += "<div class='ebeln'>"+full.PTV_RFQ_NO+"</div>";
                    return ans;
                }
            },
            {
                mRender : function(data,type,full){
                    var ans = "";
                    ans += "<div class='vendorname'>"+full.PTV_VENDOR_CODE+ " " + full.VENDOR_NAME+"</div>";
                    return ans;
                }
            },
            {
                mRender:function(data,type,full){
                    var ans = "";
                    ans += '<a href="#modal_dokumen_dua" onclick="open_dokumendua(this)" data-ppi="'+full.PPI_ID+'" data-nomat="'+full.PPI_NOMAT+'">' + full.PPI_NOMAT +' '+ full.PPI_DECMAT + '</a>' ;
                    return ans;
                }
            },
            {
                mRender : function(data,type,full){
                    var price_SAP = full.PQI_PRICE * 100;
                    return numberWithCommas(price_SAP);
                }
            },
            {"data" : "PPR_PGRP"},
            {
                mRender : function(data,type,full){
                    if (full.PTM_NUMBER == null) {
                        return 'CONTRACT';
                    } else {
                        return 'RFQ';
                    }
                    // console.log(full);
                    // var ans = '<form action="'+$("#base-url").val()+'Tender_winner_contract/delete" method="POST">';
                    // ans += '<button id="submit-form" type="submit" name="submit" value="'+full.PTW_ID+'" class="main_button color6 small_btn">Hapus</button>';
                    // return ans;
                }
            },
        ],
    });

    base_url = $("#base-url").val();
    var table_job_list = $('#prc-tender-winner-list-table-rfq').DataTable({
        "ajax" : $("#base-url").val() + 'Tender_winner_contract/get_datatablerfq/',

        "columnDefs": [{
            "searchable": false,
            "orderable": false,
            "targets": 0
        }],
        "order": [[ 4, "desc" ]],
        
        "columns":[
            {
                mRender : function(data,type,full){
                    var ans = "";
                    ans += '<input type="checkbox" class="cekboxrfq" onchange="cekboxrfq(this)" name="winner['+full.PTW_ID+']" value="'+full.PTW_ID+'">';
                    return ans;
                }
            },
            {"data" : "PTM_SUBPRATENDER"},
            {"data" : "PTM_PRATENDER"},
            {"data" : "PPI_PRNO"},
            {
                mRender : function(data,type,full){
                    var ans = "";
                    ans += "<div class='ebeln'>"+full.PTV_RFQ_NO+"</div>";
                    return ans;
                }
            },
            {
                mRender : function(data,type,full){
                    var ans = "";
                    ans += "<div class='vendorname'>" + full.VENDOR_NAME+"</div>";
                    return ans;
                }
            },
            {"data" : "PPI_DECMAT"},
            {
                mRender : function(data,type,full){
                    return numberWithCommas(full.PQI_PRICE);
                }
            },
            {"data" : "PPR_PGRP"},
            {
                mRender : function(data,type,full){
                    if (full.PTM_NUMBER == null) {
                        return 'CONTRACT';
                    } else {
                        return 'RFQ';
                    }
                    // console.log(full);
                    // var ans = '<form action="'+$("#base-url").val()+'Tender_winner_contract/delete" method="POST">';
                    // ans += '<button id="submit-form" type="submit" name="submit" value="'+full.PTW_ID+'" class="main_button color6 small_btn">Hapus</button>';
                    // return ans;
                }
            },
        ],
    });

    var table_job_list = $('#po-header-list-table').DataTable({
        "ajax" : $("#base-url").val() + 'Tender_winner_contract/get_datatable_po_header/',

        "columnDefs": [{
            "searchable": false,
            "orderable": false,
            "targets": 0
        }],
        "order": [[ 4, "desc" ]],
        
        "columns":[
            {"data" : null},
            {"data" : "VND_CODE"},
            {"data" : "VND_NAME"},
            {"data" : "PO_CREATED_AT"},
            {
                mRender : function(data,type,full){
                    return '<a href="' + $("#base-url").val() + 'PO/show/'+full.PO_ID+'" class="btn btn-default">Proses</a>'
                }
            },
        ],
    });

    table_job_list.on( 'order.dt search.dt', function () {
       table_job_list.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
           cell.innerHTML = i+1;
       } );
   } ).draw();

})

