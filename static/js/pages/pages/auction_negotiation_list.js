function numberWithCommas(x) {
	var parts = x.toString().split(".");
	parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	return parts.join(".");
}

// function errorjs() {
// 	$(".panel_waktu").hide();
// 	$(".panel_bidder").hide();
// 	alert('Error. Try using uptodate chrome web browser.')
// 	console.log('Error. Try using uptodate chrome web browser.')
// }

var base_url = $('#base-url').val();
$(document).ready(function(){
	var table_negotiation_list = $('#negotiation_list').DataTable( {
		"dom": 'rtip',
		"lengthMenu": [ 10, 25, 50 ],
		"ajax": {
			url: base_url + "Auction_negotiation/get_negotiation_list"
		},
		"columnDefs": [{
			"targets": 0
		}],

		"order": [[ 4, "desc" ]],

		"columns":[
			{"data" : null, "sClass": "text-center"},
			{"data" : "PTM_PRATENDER", "sClass": "text-center"},
			{"data" : "PAQH_SUBJECT_OF_WORK", "sClass": "text-center"},
			{
				mRender : function(data,type,full){
				return full.PAQH_AUC_START.substring(0,19) 
			}, "sClass": "text-center"},
			{
				mRender : function(data,type,full){
				return full.PAQH_AUC_END.substring(0,19) 
			}, "sClass": "text-center"},
			{"data" : "STATUS", "sClass": "text-center"},
			{
				mRender : function(data,type,full){
				return '<a class="btn btn-default" href="'+base_url+'Auction_negotiation/detail_negotiation/'+full.ECT_PAQH_ID+'">Process</a>'
			}, "sClass": "text-center"}
		],
	} );

	table_negotiation_list.on( 'order.dt search.dt', function () {
		table_negotiation_list.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
			cell.innerHTML = i+1;
		} );
	} ).draw();
	table_negotiation_list.on('draw', function () {
		table_negotiation_list.column(0, {search:'applied', order:'applied', page:'applied'}).nodes().each( function (cell, i) {
			cell.innerHTML = i+1;
		} );
	} ).draw();

	var win_table_negotiation_list = $('#win_negotiation_list').DataTable( {
		"dom": 'rtip',
		"lengthMenu": [ 5, 10, 25, 50 ],
		"ajax": {
			url: base_url + "Auction_negotiation/get_auction_closed_list"
		},
		"columnDefs": [{
			"targets": 0
		}],

		"order": [[ 4, "desc" ]],

		"columns":[
			{"data" : null, "sClass": "text-center"},
			{"data" : "PTM_PRATENDER", "sClass": "text-center"},
			{"data" : "PAQH_SUBJECT_OF_WORK", "sClass": "text-center"},
			{
				mRender : function(data,type,full){
				return full.PAQH_AUC_START.substring(0,19) 
			}, "sClass": "text-center"},
			{
				mRender : function(data,type,full){
				return full.PAQH_AUC_END.substring(0,19) 
			}, "sClass": "text-center"},
			{
				mRender : function(data,type,full){
				return "Rincian Harga"
			}, "sClass": "text-center"},
			{
				mRender : function(data,type,full){
				return '<a class="btn btn-default" href="'+base_url+'Auction_negotiation/breakdown/'+full.ECT_PAQH_ID+'">Process</a>'
			}, "sClass": "text-center"}
		],
	} );

	win_table_negotiation_list.on( 'order.dt search.dt', function () {
		win_table_negotiation_list.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
			cell.innerHTML = i+1;
		} );
	} ).draw();
	win_table_negotiation_list.on('draw', function () {
		win_table_negotiation_list.column(0, {search:'applied', order:'applied', page:'applied'}).nodes().each( function (cell, i) {
			cell.innerHTML = i+1;
		} );
	} ).draw();

});