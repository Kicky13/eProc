var base_url = $('#base-url').val();
$(document).ready(function(){
	var table_tender_awarded_list = $('#tender_awarded_list').DataTable({
        "dom": 'rtip',
		// "dom": 'rtip',		
        "deferRender": true,
		"lengthMenu": [ 10, 25, 50 ],
		"ajax": {
			url: base_url + "Tender_awarded/get_tender_awarded_list"
		},
		"columnDefs": [{
			"render":function(data,type,full){
					var url = $("#base-url").val() + 'Tender_awarded/cetak_po/'+full.ECT_PO_ID;                    
                    var button = '<a title="Cetak PO" href="'+url+'" target="_blank" class="btn btn-default btn-sm glyphicon glyphicon-print"></a> ';                    
                    return button;
                },
			"targets": 0
		}],
		"rowsGroup":['action:name',0,1,2,3,4,5],		
		"columns":[	
			{
				"name":"action",
				"data" : "PO_NUMBER"},
			{
				"name":"po",
				"data" : "PO_NUMBER"},
			{"data" : "PTV_RFQ_NO"},
			{"data" : "DOC_DATE"},
			{"data" : "DDATE"},
			{"data" : "RELEASED_AT"},
			{"data" : "POD_NOMAT"},
			{"data" : "POD_DECMAT"},
			{"data" : "POD_QTY"},
			{"data" : "UOM"},
			{"data" : "POD_PRICE"},
			{"data" : "TOTAL_HARGA"},
			{"data" : "CURR"},
			{"data" : "DOC_ANALISA_HARGA"},
		],
		
	} );

	
	table_tender_awarded_list.draw();

});

