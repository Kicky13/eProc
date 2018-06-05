var base_url = $('#base-url').val();
$(document).ready(function(){
	var table_invitation_lsit = $('#invitation_lsit').DataTable({
        "dom": 'rtip',
		// "dom": 'rtip',
		"lengthMenu": [ 10, 25, 50 ],
		"ajax": {
			url: base_url + "Tender_invitation_principal/get_invitation_list"
		},
		"columnDefs": [{
			"targets": 0
		}],
		"columns":[
			{"data" : null},
			{"data" : "VENDOR_NAME"},
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
			// {
			// 	mRender : function(data,type,full){
			// 	return full.PTP_NEGO_START_DATE.substring(0,9)
			// }, "sClass": "text-center"},
			// {
			// 	mRender : function(data,type,full){
			// 	return full.PTP_NEGO_END_DATE.substring(0,9)
			// }, "sClass": "text-center"},
			{
				mRender : function(data,type,full){
					if (full.PTV_STATUS == null) {
						status = 'Belum Mendaftar'; 
					} else if (Number(full.PTV_STATUS) == 0) {
						status = 'Tidak Mendaftar';
					} else if (Number(full.PTV_STATUS) > 0) {
						status = 'Ikut Tender';
					} else if (Number(full.PTV_STATUS) == -1) {
						status = 'Direject';
					} else if (Number(full.PTV_STATUS) == -2) {
						status = 'Tidak lolos Evaluasi';
					}
				return status
			}, "sClass": "text-center"},
			{
				mRender : function(data,type,full){
				if (full.PTV_STATUS == null) {
					return '<a class="btn btn-default" href="'+base_url+'Tender_invitation_principal/detail_invitation/'+full.PTV_ID+'">Process</a>'
				} else {
					return '<a class="btn btn-default" disabled>Process</a>'
				}
			}, "sClass": "text-center"}
		],
	} );

	table_invitation_lsit.on( 'order.dt search.dt', function () {
		table_invitation_lsit.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
			cell.innerHTML = i+1;
		} );
	} ).draw();
	table_invitation_lsit.on('draw', function () {
		table_invitation_lsit.column(0, {search:'applied', order:'applied', page:'applied'}).nodes().each( function (cell, i) {
			cell.innerHTML = i+1;
		} );
	} ).draw();

});

