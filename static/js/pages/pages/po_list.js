$(document).ready(function(){
    var table_job_list = $('#po-header-list-table').DataTable({
        "ajax" : $("#base-url").val() + 'Po/get_datatable/',

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
                    return '<a href="' + $("#base-url").val() + 'PO/show/'+full.PO_ID+'" class="btn btn-default">Detail</a>'
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