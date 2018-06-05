$(document).ready(function(){
    // targetUrl["Input Quotation"] = "Quotation/index";
    // targetUrl["Pembukaan Penawaran"] = "Penawaran/index";
    // targetUrl["Evaluasi Penawaran"] = "Evaluasi_penawaran/index";
    // targetUrl["Persetujuan Evaluasi"] = "Persetujuan_evaluasi/index";
    // targetUrl["Negosiasi"] = "Negosiasi/index";
    // targetUrl["Penunjukan Pemenang"] = "Penunjukan_pemenang/index";
    // targetUrl["Sudah Dimenangkan"] = "Penunjukan_pemenang/winner";
	//alert('OOOK');
	base_url = $("#base-url").val();
    var table_job_list = $('#job-list-table').DataTable({
		"dom": '<"toolbar">rtp',
		 "ajax" : {url:base_url+'Create_po/get_data',
		type: "post",
		data: function(d){d.id_pemenang=$('#id_pemenang').val()
			},
		},
        "columnDefs": [{
            "searchable": false,
            "orderable": false,
            "targets": 0
        }],
        //ID_PEMENANG,PTM_NUMBER,RFQ,KODE_VENDOR,HARGA_TERAKHIR,	STATUS_PEMENANG,STATUS_WINER,TGL_ACT_PEMENANG,PERUGAS_ID_PEMENANG,
        "columns":[
            {"data" : "BARIS"},
            {"data" : "NO_ITEM_NOMAT"},
            {"data" : "HARGA_ITEM"},
			{"data" : "PEMENANG_ID","visible": false,},
            
        ],
    });

    //table_job_list.on( 'order.dt search.dt', function () {
//        table_job_list.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
//            cell.innerHTML = i+1;
//        } );
//    } ).draw();

})