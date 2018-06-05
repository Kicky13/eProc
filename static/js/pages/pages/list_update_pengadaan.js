$(document).ready(function(){
    // targetUrl["Input Quotation"] = "Quotation/index";
    // targetUrl["Pembukaan Penawaran"] = "Penawaran/index";
    // targetUrl["Evaluasi Penawaran"] = "Evaluasi_penawaran/index";
    // targetUrl["Persetujuan Evaluasi"] = "Persetujuan_evaluasi/index";
    // targetUrl["Negosiasi"] = "Negosiasi/index";
    // targetUrl["Penunjukan Pemenang"] = "Penunjukan_pemenang/index";
    // targetUrl["Sudah Dimenangkan"] = "Penunjukan_pemenang/winner";

    var table_job_list = $('#update-pengadaan-list-table').DataTable({
        "ajax" : $("#base-url").val() + 'Update_pengadaan/get_datatable',
        
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
            {"data" : "PROCESS_NAME"},
            {"data" : "PTC_END_DATE"},
            {
                mRender : function(data,type,full){
                console.log(full);
                return '<a href="' + $("#base-url").val() + 'Update_pengadaan/detail/'+full.PTM_NUMBER+'" class="btn btn-default">Proses</a>'
            }},
        ],
    });

    table_job_list.on( 'order.dt search.dt', function () {
        table_job_list.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();

})