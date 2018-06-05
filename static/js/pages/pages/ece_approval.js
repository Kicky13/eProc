$(document).ready(function(){
    var table_job_list = $('#ece-list-table-approve').DataTable({
        "ajax" : $("#base-url").val() + 'Ece/get_datatable_approval',
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
                    return '<td>Approval Ece</td>';
            }},
            {
                mRender : function(data,type,full){
                    return '<a href="' + $("#base-url").val() + 'Ece/approv/'+full.PTM_NUMBER+'/'+full.EC_ID_GROUP+'" class="btn btn-default">Proses</a>'
            }},
        ],
    });

    table_job_list.on( 'order.dt search.dt', function () {
        table_job_list.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();

})