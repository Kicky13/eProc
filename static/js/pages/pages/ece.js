$(document).ready(function(){
    var table_job_list = $('#ece-list-table').DataTable({
        "ajax" : $("#base-url").val() + 'Ece/get_datatable',
        "columnDefs": [{
            "searchable": false,
            "orderable": false,
            "targets": 0
        }],

        "order": [[ 0, "desc" ]],
        
        "columns":[
            {"data" : null},
            {"data"  :"PTM_PRATENDER"},
            {"data"  :"PTM_SUBJECT_OF_WORK"},
            {"data" : "FULLNAME"},
            {
                mRender : function(data,type,full){
                    if(full.STATUS_APPROVAL == 0){
                        status = '<td>Evaluasi ECE</td>';
                    }else if(full.STATUS_APPROVAL == 1){
                        status = '<td>Approval Evaluasi ECE</td>';
                    }else if(full.STATUS_APPROVAL == 2){
                        status = '<td>Release Evaluasi ECE</td>';
                    }else if(full.STATUS_APPROVAL == -1){
                        status = '<td>Reject Evaluasi ECE</td>';
                    }else{
                        status = '<td>Not set</td>';
                    }
                    return status;
            }},
            {
                mRender : function(data,type,full){
                    return '<a href="' + $("#base-url").val() + 'Ece/change/'+full.PTM_NUMBER+'/'+full.EC_ID_GROUP+'" class="btn btn-default">Proses</a>'
            }},
        ],
    });

    table_job_list.on( 'order.dt search.dt', function () {
        table_job_list.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();


        //popup
    $modal_item = $("#modal_detail_item_snippet");
    $modal_item.detach();
    $modal_item.appendTo('body');

    $(".snippet_detail_item").click(function() {
      $tr = $(this).parent().parent();
      ppi_id = $tr.find('.ppi').html();
      nomat = $tr.find('.nomat').html();

      $("#modal_detail_item_snippet").modal('show');

      /* populate detail item */
      $(".snippet_modal_pritem").html($tr.find('.pritem').html());
      $(".snippet_modal_prno").html($tr.find('.prno').html());
      $(".snippet_modal_nomat").html($tr.find('.nomat').html()+ ' ' + $tr.find('.decmat').html());
      // $(".snippet_modal_decmat").html($tr.find('.decmat').html());
      $(".snippet_modal_matgroup").html($tr.find('.matgroup').html()+ ' ' + $tr.find('.matgroup_detail').html());
      $(".snippet_modal_mrpc").html($tr.find('.mrpc').html());
      $(".snippet_modal_plant").html($tr.find('.plant').html() + ' ' + $tr.find('.plant_detail').html());
      $(".snippet_modal_note").html($tr.find('.note').html());
      //*/

      /* get long text */
      $.ajax({
        url: $("#base-url").val() + 'Snippet_ajax/getlongtext/' + ppi_id + '/' + nomat,
        type: 'GET',
        dataType: 'html',
      })
      .done(function(data) {
        $(".long_text_snippet_item").html(data);
      })
      .fail(function() {
        console.log("error");
      })
      .always(function(data) {
        console.log(data);
      });
      //*/

      docat = $tr.find('.docat').html();
      if (docat == '9') {
        /* get service line */
        $.ajax({
          url: $("#base-url").val() + 'Snippet_ajax/pr_doc_service/' + ppi_id,
          type: 'get',
          dataType: 'html',
          
        })
        .done(function(data) {
          $(".service_line_snippet_item").html(data);
        })
        .fail(function() {
          console.log("error");
        })
        .always(function(data) {
          console.log(data);
        });
        
      }
    });

        /* Activate autonumeric */
    $(".must_autonumeric").autoNumeric('init', {lZero: 'deny', mDec: 0});

})