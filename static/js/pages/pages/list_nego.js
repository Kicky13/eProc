$(document).ready(function(){

    var table_job_list = $('#job-list-table').DataTable({
        "ajax" : $("#base-url").val() + 'Negosiasi/get_datatable',
        
        "columnDefs": [{
            "searchable": false,
            "orderable": false,
            "targets": 0
        }],

        "order": [[ 4, "desc" ]],
        
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
            {"data" : "NEGO_END"},
            {"data" : "STATUS"},            
            {
                mRender : function(data,type,full){
                if (Number(full.IS_EVALUATED) == 1) {
                    if (full.NEGO_DONE == 1) {
                        return '<a href="' + $("#base-url").val() + 'Negosiasi/approval/'+full.PTM_NUMBER+'/'+full.NEGO_ID+'" class="btn btn-default">Aprpoval</a>';
                    } else {
                        if(full.STATUS=='Negosiasi Sudah Dibuka'){
                            return '<a href="' + $("#base-url").val() + 'Negosiasi/index/'+full.PTM_NUMBER+'/'+full.NEGO_ID+'" class="btn btn-default">Proses</a>';
                            // return 'Tunggu Negosiasi selesai';
                        }else{
                            return '<a href="' + $("#base-url").val() + 'Negosiasi/index/'+full.PTM_NUMBER+'/'+full.NEGO_ID+'" class="btn btn-default">Proses</a>';
                        }
                    }
                } else if (Number(full.IS_EVALUATED) == 2) {
                    return '<a href="' + $("#base-url").val() + 'Penunjukan_pemenang/index/'+full.PTM_NUMBER+'" class="btn btn-default">Proses</a>'
                } else if (full.JUSTIFICATION == 5 ){
                    return '<a href="' + $("#base-url").val() + 'Negosiasi/index/'+full.PTM_NUMBER+'/'+full.NEGO_ID+'" class="btn btn-default">Proses</a>';
                }
            }},
        ],
    });

    table_job_list.on( 'order.dt search.dt', function () {
        table_job_list.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();

})