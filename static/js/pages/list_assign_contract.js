$(document).ready(function(){

	base_url = $("#base-url").val();
    var table_job_list = $('#job-list-table').DataTable({
		"ajax" : $("#base-url").val() + 'Create_po/get_datatable/'+ status,

        "columnDefs": [{
            "searchable": false,
            "orderable": false,
            "targets": 0
        }],
        "order": [[ 4, "desc" ]],
        
        "columns":[
            {"data" : null},
            // {"data" : null},
            {"data" : "PPI_PRNO"},
            {"data" : "PPI_PRITEM"},
            {"data" : "PPI_NOMAT"},
            {"data" : "PPI_DECMAT"},
            {"data" : "PPI_MATGROUP"},
            {"data" : "PPI_PRQUANTITY"},
            {"data" : "PPI_QTY_USED"},
            {
                mRender : function(data,type,full){
                var ans = full.PPI_PRQUANTITY - full.PPI_QUANTOPEN;
                if (ans < 0) ans = 0;
                return ans;
            }},
            {
                mRender : function(data,type,full){
                var ans = full.PPI_QUANTOPEN - full.PPI_QTY_USED;
                if (ans < 0) ans = 0;
                return ans;
            }},
            {"data" : "PPR_DOCTYPE"},
            {"data" : "PPR_PLANT"},
            // {"data" : "PPI_REALDATE"},
            {"data" : "PPR_PGRP"},
            {"data" : "PPI_MRPC"},
            {
                mRender : function(data,type,full){
                return '<a class="btn btn-default" href="'+base_url+'Create_po/show/'+full.PPI_ID+'/'+full.PPR_PLANT+'">Process</a>'
            }, "sClass": "text-center"}
            
        ],
    });

    table_job_list.on( 'order.dt search.dt', function () {
       table_job_list.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
           cell.innerHTML = i+1;
       } );
   } ).draw();

})