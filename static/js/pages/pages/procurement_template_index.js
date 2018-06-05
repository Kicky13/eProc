$(document).ready(function(){
    var base_url = $("#base-url").val();

    var table_job_list = $('#job-list-table').DataTable({
        "ajax" : base_url + "Procurement_template/get_evaluation_template",
        
        "columnDefs": [{
            "searchable": false,
            "orderable": false,
            "targets": 0
        }],
        
        "columns":[
            {"data" : null},
            {"data" : "EVT_NAME"},
            {"data" : "COMPANY"},
            {"data" : "EVT_PASSING_GRADE"},
            {"data" : "EVT_TECH_WEIGHT"},
            {"data" : "EVT_PRICE_WEIGHT"},
            {
                mRender : function(data,type,full){
                    console.log(full);
                    return '<a href="' + base_url + 'Procurement_template/show/' + full.EVT_ID
                        + '" class="btn btn-default">Detail</a>';
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