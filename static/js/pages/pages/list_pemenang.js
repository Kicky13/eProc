$(document).ready(function(){
    // targetUrl["Input Quotation"] = "Quotation/index";
    // targetUrl["Pembukaan Penawaran"] = "Penawaran/index";
    // targetUrl["Evaluasi Penawaran"] = "Evaluasi_penawaran/index";
    // targetUrl["Persetujuan Evaluasi"] = "Persetujuan_evaluasi/index";
    // targetUrl["Negosiasi"] = "Negosiasi/index";
    // targetUrl["Penunjukan Pemenang"] = "Penunjukan_pemenang/index";
    // targetUrl["Sudah Dimenangkan"] = "Penunjukan_pemenang/winner";

    var table_job_list = $('#job-list-table').DataTable({
        "ajax" : 'get_datatable',
        
        "columnDefs": [{
            "searchable": false,
            "orderable": false,
            "targets": 0
        }],
        //ID_PEMENANG,PTM_NUMBER,RFQ,KODE_VENDOR,HARGA_TERAKHIR,	STATUS_PEMENANG,STATUS_WINER,TGL_ACT_PEMENANG,PERUGAS_ID_PEMENANG,
        "columns":[
            {"data" : "BARIS"},
            {"data" : "PTM_NUMBER"},
            {"data" : "RFQ"},
			{"data" : "KODE_VENDOR"},
			 {"data" : 'NAMA_VENDOR'},
            {"data" : "HARGA_TERAKHIR"},
			 {"data" : "ID_PEMENANG","visible": false,},
            {
                mRender : function(data,type,full){
                console.log(full);
                return '<a href="data_detil/'+full.ID_PEMENANG+'" class="btn btn-default">Detil Item</a>'
            }},
        ],
    });

    //table_job_list.on( 'order.dt search.dt', function () {
//        table_job_list.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
//            cell.innerHTML = i+1;
//        } );
//    } ).draw();

})