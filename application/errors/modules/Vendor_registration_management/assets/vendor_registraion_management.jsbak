var base_url = $('#base-url').val();
var url = document.location.href.split('/');
$(document).ready(function(){
    if (url[url.length-1].toLowerCase() == "registration_date") {
		var table_registration_date = $('#registration_date_list').DataTable( {
			"dom": 'rtip',
			"processing": true,
			"serverSide": true,
			"lengthMenu": [ 10, 25, 50 ],
			"ajax": {
				url: location + "/../get_registration_date",
				type: 'POST'
			},
			"columnDefs": [{
				"targets": 0
			}],
			"columns":[
			{"data" : null},
			{"data" : "company.COMPANYNAME"},
			{"data" : "OPEN_REG", "sClass": "text-center"},
			{"data" : "CLOSE_REG", "sClass": "text-center"},
			{
				mRender : function(data,type,full){
					return '<a class="btn btn-default" href="'+location+'/../update_registration_date/'+full.COMPANYID+'">Edit</a>'
				}, "sClass": "text-center"},
				],
			} );

		table_registration_date.on( 'order.dt search.dt', function () {
			table_registration_date.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
				cell.innerHTML = i+1;
			} );
		} ).draw();
		table_registration_date.on('draw', function () {
			table_registration_date.column(0, {search:'applied', order:'applied', page:'applied'}).nodes().each( function (cell, i) {
				cell.innerHTML = i+1;
			} );
		} ).draw();

		var table_vendor_registration_news = $('#vendor_registration_news_list').DataTable( {
			"dom": 'rtip',
			"processing": true,
			"serverSide": true,
			"lengthMenu": [ 5, 10, 25, 50 ],
			"ajax": {
				url: location + "/../get_vendor_registration_news",
				type: 'POST'
			},
			"columnDefs": [{
				"targets": 0
			}],
			"columns":[
			{"data" : null},
			{"data" : "NEWS_TITLE"},
			{
				mRender : function(data,type,full){
					console.log(2);
					return '<a class="btn btn-default" href="'+location+'/../update_vendor_registration_news/'+full.COMPANYID+'">Edit</a>'
				}, "sClass": "text-center"},
				],
			} );

		table_vendor_registration_news.on( 'order.dt search.dt', function () {
			table_vendor_registration_news.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
				cell.innerHTML = i+1;
			} );
		} ).draw();
		table_vendor_registration_news.on('draw', function () {
			table_vendor_registration_news.column(0, {search:'applied', order:'applied', page:'applied'}).nodes().each( function (cell, i) {
				cell.innerHTML = i+1;
			} );
		} ).draw();
	};
})
// $('#news').trumbowyg();
if (url[url.length-2].toLowerCase() == "update_registration_date") {
	$('.input-group.date').datepicker({
		format: 'dd-m-yyyy',
		orientation: 'bottom'
	});
};