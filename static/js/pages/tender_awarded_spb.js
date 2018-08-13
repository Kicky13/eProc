var base_url = $('#base-url').val();
$(document).ready(function(){
	var table_tender_awarded_list = $('#tender_awarded_list').DataTable({
		"dom": 'rtip',
		"deferRender": true,
		"lengthMenu": [ 10, 25, 50 ],
		"ajax": {
			url: base_url + "Tender_awarded_spb/get_tender_awarded_list"
		},
		"columnDefs": [{
			"targets": 0
		}],
		"columns":[	
		
		{"data" : "FORM"},
		{"data" : "PO_NUMBER"},
		{"data" : "VENDOR_NO"},

		],

	} );

	
	table_tender_awarded_list.draw();
});

