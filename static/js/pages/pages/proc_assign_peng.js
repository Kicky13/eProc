$(document).ready(function(){
    // targetUrl["Input Quotation"] = "Quotation/index";
    // targetUrl["Pembukaan Penawaran"] = "Penawaran/index";
    // targetUrl["Evaluasi Penawaran"] = "Evaluasi_penawaran/index";
    // targetUrl["Persetujuan Evaluasi"] = "Persetujuan_evaluasi/index";
    // targetUrl["Negosiasi"] = "Negosiasi/index";
    // targetUrl["Penunjukan Pemenang"] = "Penunjukan_pemenang/index";
    // targetUrl["Sudah Dimenangkan"] = "Penunjukan_pemenang/winner";

    cheat = $("#cheat").val();
    cheat = cheat == 'true' ? '/true' : '';
    count = 1;

    var table_job_list = $('#job-list-table').DataTable({
        "ajax" : $("#base-url").val() + 'Proc_assign_pengadaan/get_datatable' + cheat,
        
        "columnDefs": [{
            "searchable": false,
            "orderable": false,
            "targets": 0
        }],

        "order": [[ 5, "desc" ]],
        
        "columns":[
            {
                mRender : function(data,type,full){
                    return '<input type="checkbox" name="ptm_number[]" value="'+full.PTM_NUMBER+'">';
                }
            },
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
        ],
    });

})