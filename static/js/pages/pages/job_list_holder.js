function openmodal (ptm) {
    $.ajax({
        url: $("#base-url").val() + 'Job_list/get_holder/' + ptm,
        type: 'get',
        dataType: 'json',
    })
    .done(function(data) {
        table = $("#tableholder");
        table.html('');
        for (var i = 0; i < data.emp.length; i++) {
            emp = data.emp[i];
            table.append('<tr><td>' + emp.ID + '</td><td>' + emp.FULLNAME + '</td><td>' + emp.EMAIL + '</td></tr>');
        };
        $("#modalholder").modal('show')
    })
    .fail(function() {
        console.log("error");
    })
    .always(function(data) {
        console.log(data);
    });
}

$(document).ready(function(){

    var table_job_list = $('#job-list-table').DataTable({
        "ajax" : $("#base-url").val() + 'Job_list/get_datatable_holder',
        
        "columnDefs": [{
            "searchable": false,
            "orderable": false,
            "targets": 0
        }],

        "order": [[ 5, "desc" ]],
        
        "columns":[
            {"data" : null},
            {
                mRender : function(data,type,full){
                    if (full.PTM_PRATENDER == 'null') {
                        return full.PTM_SUBPRATENDER
                    }
                    return full.PTM_PRATENDER;
                }
            },
            {"data" : "PTM_SUBJECT_OF_WORK"},
            {"data" : "PTM_PGRP"},
            {"data" : "PROCESS_NAME"},
            {"data" : "PTC_END_DATE"},
            {
                mRender : function(data,type,full){
                console.log(full);
                return '<button onclick="openmodal('+full.PTM_NUMBER+')" class="btn btn-default">Holder</button>'
            }},
        ],
    });

    table_job_list.on( 'order.dt search.dt', function () {
        table_job_list.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();

})