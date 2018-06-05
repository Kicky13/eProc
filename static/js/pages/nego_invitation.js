var base_url = $('#base-url').val();
$(document).ready(function() {
	if ($('#invitation_lsit').length > 0) {
		var table_invitation_lsit = $('#invitation_lsit').DataTable( {
			"dom": 'rtip',
			"lengthMenu": [ 10, 25, 50 ],
			"ajax": {
				url: base_url + "Nego_invitation/get_invitation_list"
			},
			"columnDefs": [{
				"targets": 0
			}],
			"columns":[
				{"data" : null},
				{"data" : "PTM_PRATENDER"},
				{"data" : "PTV_RFQ_NO"},
				{"data" : "PTM_SUBJECT_OF_WORK"},
				// {
				// 	mRender : function(data,type,full){
				// 	return full.PTP_NEGO_START_DATE.substring(0,9)
				// }, "sClass": "text-center"},
				{
					mRender : function(data,type,full){
					return full.NEGO_END
				}, "sClass": "text-center"},
				{
					mRender : function(data,type,full){
					return full.STATUS
				}, "sClass": "text-center"},
				{
					mRender : function(data,type,full){
					if (full.PTV_STATUS != 0 && full.PTV_STATUS != 1) {
						return '<a class="btn btn-default" href="'+base_url+'Nego_invitation/detail_invitation/'+full.ECT_PTV_ID+'">Process</a>'
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
	}

	if ($(".must_auto_numeric").length > 0) {
		$(".must_auto_numeric").autoNumeric('init', {lZero: 'deny'});
	}
});