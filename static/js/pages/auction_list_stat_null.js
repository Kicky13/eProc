$(document).ready(function(){
    var table_job_list = $('#auction-list-table').DataTable({
        "ajax" : $("#base-url").val() + 'Auction/get_datatable_stat_null/',
        
        "columnDefs": [{
            "searchable": false,
            "orderable": false,
            "targets": 0
        }],

        "order": [[ 0, "desc" ]],
        
        "columns":[
            {"data" : null},
            {"data" : "PTM_SUBPRATENDER"},
            {"data"  :"PTM_PRATENDER"},
            {"data"  :"PTM_SUBJECT_OF_WORK"},
            {"data" : "PTM_REQUESTER_NAME"},
            {
                mRender : function(data,type,full){
                    return '<td>Belum setup</td>';
            }},
            {
                mRender : function(data,type,full){
                    return '<a href="' + $("#base-url").val() + 'Auction/create/'+full.PTM_NUMBER+'" class="btn btn-default">Setup</a>'
            }},
        ],
    });

    table_job_list.on( 'order.dt search.dt', function () {
        table_job_list.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();

})