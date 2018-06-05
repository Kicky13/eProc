$(document).ready(function(){

	base_url = $("#base-url").val();
    var table_job_list = $('#approval-po-list-table').DataTable({
		"ajax" : $("#base-url").val() + 'Tender_winner/get_datatable_po/',

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
            {
                mRender : function(data,type,full){
                            var str = full.PO_CREATED_AT;
                            str1 = str.substr(0,18);
                            str2 = str.substr(26,27);
                            return str1 + ' ' + str2;
                        }
            },
            {
                mRender : function(data,type,full){
                    ans = '<a href="'+base_url+'Tender_winner/approval/'+full.PO_ID+'" class="main_button small_btn">Verifikasi</a> ';
                    return ans;
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

