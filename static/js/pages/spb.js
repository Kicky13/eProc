var base_url = $('#base-url').val();
$(document).ready(function(){
	var table_spb_list = $('#spb_list').DataTable({
		"dom": 'rtip',
		"deferRender": true,
		"lengthMenu": [ 10, 25, 50 ],
		"ajax": {
			url: base_url + "Tender_awarded_spb/get_spb_list/" + $('#id').val()
		},
		"columnDefs": [{
			"targets": 0
		}],
		"columns":[	
		{"data" : "FORM"},
		{"data" : "PO_NUMBER"},
		{"data" : "EBELP"},
		{"data" : "NO_MAT"},
		{"data" : "DET_MAT"},
		{"data" : "PLAT"},
		{"data" : "DRIVER"},
		{"data" : "VENDOR_NO"},
		{"data" : "VENDOR_NAME"},
		{"data" : "QTY"},
		{"data" : "CREATED_AT"},
		{"data" : "STATUS"},
		],

	} );

	
	table_spb_list.draw();



	var table_spb_detail = $('#po_detail').DataTable({
		"dom": 'rtip',
		"deferRender": true,
		"lengthMenu": [ 10, 25, 50 ],
		"ajax": {
			url: base_url + "Tender_awarded_spb/get_tender_awarded_detail/" + $('#id').val()
		},
		"columnDefs": [{
			"targets": 0
		}],
		"columns":[	
		{"data" : "FORM"},
		{"data" : "PO_NUMBER"},
		{"data" : "EBELP"},
		{"data" : "NO_MAT"},
		{"data" : "DET_MAT"},
		{"data" : "MEINS"},
		{"data" : "QTY_PO"},
		{"data" : "QTY_SPB"},
		{"data" : "QUAN_TIMBANG"},
		{"data" : "TOTAL_MENGE"},
		{"data" : "SISA_QTY"},
		],

	} );

	
	table_spb_detail.draw();




});

