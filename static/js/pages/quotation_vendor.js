var base_url = $('#base-url').val();

$(document).ready(function(){
	$(".close-modal").click(function() {$(".modal").modal('hide')})

	var table_quotation_lsit = $('#quotation_lsit').DataTable( {
		"dom": 'rtip',
		"lengthMenu": [ 10, 25, 50 ],
		"ajax": {
			url: base_url + "Quotation_vendor/get_quotation_list"
		},
		"columnDefs": [{
			"targets": 0
		}],
		"columns":[
			{"data" : null},
			{"data" : "PTM_PRATENDER"},
			{"data" : "PTV_RFQ_NO"},
			{"data" : "PTM_SUBJECT_OF_WORK"},
			{
				mRender : function(data,type,full){
				return full.PTP_REG_OPENING_DATE
			}, "sClass": "text-center"},
			{
				mRender : function(data,type,full){
				return full.PTP_REG_CLOSING_DATE
			}, "sClass": "text-center"},
			{
				mRender : function(data,type,full){
					status = 'Belum Mendaftar';
					if (full.PTV_STATUS_EVAL == 1) {
						status = 'Belum Memasukkan Harga';
					} else if (full.PTV_STATUS_EVAL == 2) {
						status = 'Sudah Memasukkan Harga';
					} else if (full.PTV_STATUS == 0) {
						status = 'Tidak Mendaftar';
					}
					else if (full.PTV_STATUS == 1) {
						status = 'Belum Memasukkan';
					}
					else if (full.PTV_STATUS == 2) {
						status = 'Sudah Memasukkan';
					}

					if(full.PTV_APPROVAL == null && full.PTV_TENDER_TYPE == 1){
						status = 'Belum Memasukkan';
					}else if(full.PTV_APPROVAL == 0 && full.PTV_TENDER_TYPE == 1){
						status = 'Waiting Approval';
					}else if(full.PTV_APPROVAL == 1 && full.PTV_TENDER_TYPE == 1){
						status = 'Approved By Principal';
					}else if(full.PTV_APPROVAL == 1 && full.PTV_TENDER_TYPE == 2){
						status = 'Penawaran By Principal';
					}else{
						status = 'Belum Memasukkan';
					}
				return status
			}, "sClass": "text-center"},
			{
				mRender : function(data,type,full) {
					if (full.PTV_STATUS_EVAL == 1 || full.PTV_STATUS_EVAL == 2) {
						return '<a class="btn btn-default" href="'+base_url+'Quotation_vendor/harga/'+full.PTM_NUMBER+'/'+full.PTV_ID+'">Process</a>';
					} else {
						return '<a class="btn btn-default" href="'+base_url+'Quotation_vendor/inputQuotation/'+full.PTM_NUMBER+'">Process</a>';
					}
			}, "sClass": "text-center"}
		],
	} );

	table_quotation_lsit.on( 'order.dt search.dt', function () {
		table_quotation_lsit.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
			cell.innerHTML = i+1;
		} );
	} ).draw();
	table_quotation_lsit.on('draw', function () {
		table_quotation_lsit.column(0, {search:'applied', order:'applied', page:'applied'}).nodes().each( function (cell, i) {
			cell.innerHTML = i+1;
		} );
	} ).draw();

		//Quotation Submitted
	var table_quotation_submitted = $('#quotation_submitted').DataTable( {
		"dom": 'rtip',
		"lengthMenu": [ 10, 25, 50 ],
		"ajax": {
			url: base_url + "Quotation_vendor/get_quotation_list/"+"submitted"
		},
		"columnDefs": [{
			"searchable": false,
            "orderable": false,
			"targets": 0
		}],
		"columns":[
			{"data" : null},
			{"data" : "PTM_PRATENDER"},
			{"data" : "PTV_RFQ_NO"},
			{"data" : "PTM_SUBJECT_OF_WORK"},
			{
                mRender : function(data,type,full) {
                    if (full.PTM_STATUS > 0){
                        if(full.PROCESS_MASTER_ID == 'Proc_verify_entry/index' ){
                            return statusRfq(full.PTP_REG_CLOSING_DATE,full.NAMA_BARU);
                        }
                        if(full.PROCESS_MASTER_ID == 'Proc_verify_entry/harga' && full.SAMPUL == 3){
                            return statusPenawaranHarga(full.BATAS_VENDOR_HARGA,full.NAMA_BARU);
                        }
                         return full.NAMA_BARU;
                    }
                    else {
                        if (full.PTM_COMPANY_ID == '4000') { //Sementara Hardcode untuk kodisi tonasa
                            if (full.PTM_STATUS <= -2 && full.PTM_STATUS >= -8) {
                                return 'Reject';
                            }
                            return 'Retender';
                        } else {
                            if (full.PTM_STATUS <= -2 && full.PTM_STATUS >= -7) {
                                return 'Reject';
                            } 
                            return 'Retender';                        
                        } 

                    }
                }
            },
			{
				mRender : function(data,type,full){
				return full.PTP_REG_OPENING_DATE
			}, "sClass": "text-center"},
			{
				mRender : function(data,type,full){
				return full.PTP_REG_CLOSING_DATE
			}, "sClass": "text-center"},
			{
				mRender : function(data,type,full){
					status = 'Belum Mendaftar';
					if (full.PTV_STATUS_EVAL == 1) {
						status = 'Belum Memasukkan Harga';
					} else if (full.PTV_STATUS_EVAL == 2) {
						status = 'Sudah Memasukkan Harga';
					} else if (full.PTV_STATUS == 0) {
						status = 'Tidak Mendaftar';
					}
					else if (full.PTV_STATUS == 1) {
						status = 'Belum Memasukkan';
					}
					else if (full.PTV_STATUS == 2) {
						status = 'Sudah Memasukkan';
					}
				return status
			}, "sClass": "text-center"},
			{
				mRender : function(data,type,full) {
					if (full.PTV_STATUS_EVAL == 1 || full.PTV_STATUS_EVAL == 2) {
						return '<a title="View" href="'+base_url+'Quotation_vendor/harga/'+full.PTM_NUMBER+'/'+full.PTV_ID+'/viewSubmitted'+'" class="btn btn-default btn-sm glyphicon glyphicon-eye-open"></a>';
					} else {
						return '<a title="View" href="'+base_url+'Quotation_vendor/inputQuotation/'+full.PTM_NUMBER+'/viewSubmitted'+'" class="btn btn-default btn-sm glyphicon glyphicon-eye-open"></a>';
					}
			}, "sClass": "text-center"}
		],
	} );

	table_quotation_submitted.on('draw', function () {
		table_quotation_submitted.column(0, {search:'applied', order:'applied', page:'applied'}).nodes().each( function (cell, i) {
			cell.innerHTML = i+1;
		} );
	} ).draw();
	table_quotation_submitted.columns().every( function () {
        var that = this;
    
        $( 'input', this.header() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that.search( this.value ).draw();
            }
        });
    });

})