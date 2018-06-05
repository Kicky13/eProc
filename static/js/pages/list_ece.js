$(document).ready(function(){

    var table_job_list = $('#job-list-table').DataTable({
        "ajax" : $("#base-url").val() + 'Proc_ubah_ece/get_datatable',
        
        "columnDefs": [{
            "searchable": false,
            "orderable": false,
            "targets": 0
        }],
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
            {
                mRender : function(data,type,full){
                    return '<a href="' + $("#base-url").val() + 'Proc_ubah_ece/index/'+full.PTM_NUMBER+'" class="btn btn-default">Proses</a>';
            }},
        ],
    });

    table_job_list.on( 'order.dt search.dt', function () {
        table_job_list.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();

})