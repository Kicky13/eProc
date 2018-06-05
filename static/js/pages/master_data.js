$(document).ready(function(){
	
	var table_department = $('#department_list').DataTable( {
		"dom": 'rtip',
		"processing": true,
		"serverSide": true,
		"lengthMenu": [ 10, 25, 50 ],
		"ajax": {
			url: location + "/../get_department",
			type: 'POST'
		},
		"columnDefs": [{
			"targets": 0
		}],
		"columns":[
			{"data" : null},
			{"data" : "DEP_CODE"},
			{"data" : "DEPT_NAME"},
			{"data" : "DISTRICT_NAME"},
			{
				mRender : function(data,type,full){
				return '<a class="btn btn-default" href="'+location+'/../update_department/'+full.DEPT_ID+'">Edit</a> &nbsp;<a class="btn btn-default" href="'+location+'/../delete_department/'+full.DEPT_ID+'" onclick="return confirm(\'Are you sure you want to delete this item?\');">Delete</a>'
			}, "sClass": "text-center"},
		],
	} );

	table_department.on( 'order.dt search.dt', function () {
		table_department.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
			cell.innerHTML = i+1;
		} );
	} ).draw();
	table_department.on('draw', function () {
		table_department.column(0, {search:'applied', order:'applied', page:'applied'}).nodes().each( function (cell, i) {
			cell.innerHTML = i+1;
			console.log(cell);
		} );
	} ).draw();

	var table_del_point = $('#del_point_list').DataTable( {
		"dom": 'rtip',
		"processing": true,
		"serverSide": true,
		"lengthMenu": [ 5, 10, 25, 50 ],
		"ajax": {
			url: location + "/../get_del_point",
			type: 'POST'
		},
		"columnDefs": [{
			"targets": 0
		}],
		"columns":[
			{"data" : null},
			{"data" : "DEL_POINT_CODE"},
			{"data" : "DEL_POINT_NAME"},
			{"data" : "PLANT_NAME"},
			{
				mRender : function(data,type,full){
				return '<a class="btn btn-default" href="'+location+'/../update_del_point/'+full.DEL_POINT_ID+'">Edit</a> &nbsp;<a class="btn btn-default" href="'+location+'/../delete_del_point/'+full.DEL_POINT_ID+'" onclick="return confirm(\'Are you sure you want to delete this item?\');">Delete</a>'
			}, "sClass": "text-center"},
		],
	} );

	table_del_point.on( 'order.dt search.dt', function () {
		table_del_point.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
			cell.innerHTML = i+1;
		} );
	} ).draw();
	table_del_point.on('draw', function () {
		table_del_point.column(0, {search:'applied', order:'applied', page:'applied'}).nodes().each( function (cell, i) {
			cell.innerHTML = i+1;
			console.log(cell);
		} );
	} ).draw();

	var table_district = $('#district_list').DataTable( {
		"dom": 'rtip',
		"processing": true,
		"serverSide": true,
		"lengthMenu": [ 5, 10, 25, 50 ],
		"ajax": {
			url: location + "/../get_district",
			type: 'POST'
		},
		"columnDefs": [{
			"targets": 0
		}],
		"columns":[
			{"data" : null},
			{"data" : "DISTRICT_CODE"},
			{"data" : "DISTRICT_NAME"},
			{"data" : "COMPANYNAME"},
			{
				mRender : function(data,type,full){
				return '<a class="btn btn-default" href="'+location+'/../update_district/'+full.DISTRICT_ID+'">Edit</a> &nbsp;<a class="btn btn-default" href="'+location+'/../delete_district/'+full.DISTRICT_ID+'" onclick="return confirm(\'Are you sure you want to delete this item?\');">Delete</a>'
			}, "sClass": "text-center"},
		],
	} );

	table_district.on( 'order.dt search.dt', function () {
		table_district.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
			cell.innerHTML = i+1;
		} );
	} ).draw();
	table_district.on('draw', function () {
		table_district.column(0, {search:'applied', order:'applied', page:'applied'}).nodes().each( function (cell, i) {
			cell.innerHTML = i+1;
			console.log(cell);
		} );
	} ).draw();

	var table_currency = $('#currency_list').DataTable( {
		"dom": 'rtip',
		"processing": true,
		"serverSide": true,
		"lengthMenu": [ 5, 10, 25, 50 ],
		"ajax": {
			url: location + "/../get_currency",
			type: 'POST'
		},
		"columnDefs": [{
			"targets": 0
		}],
		"columns":[
			{"data" : null},
			{"data" : "CURR_CODE"},
			{"data" : "CURR_NAME"},
			{
				mRender : function(data,type,full){
				return '<a class="btn btn-default" href="'+location+'/../update_currency/'+full.CURR_ID+'">Edit</a> &nbsp;<a class="btn btn-default" href="'+location+'/../delete_currency/'+full.CURR_ID+'" onclick="return confirm(\'Are you sure you want to delete this item?\');">Delete</a>'
			}, "sClass": "text-center"},
		],
	} );

	table_currency.on( 'order.dt search.dt', function () {
		table_currency.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
			cell.innerHTML = i+1;
		} );
	} ).draw();
	table_currency.on('draw', function () {
		table_currency.column(0, {search:'applied', order:'applied', page:'applied'}).nodes().each( function (cell, i) {
			cell.innerHTML = i+1;
			console.log(cell);
		} );
	} ).draw();

	var table_salutation = $('#salutation_list').DataTable( {
		"dom": 'rtip',
		"processing": true,
		"serverSide": true,
		"lengthMenu": [ 5, 10, 25, 50 ],
		"ajax": {
			url: location + "/../get_salutation",
			type: 'POST'
		},
		"columnDefs": [{
			"targets": 0
		}],
		"columns":[
			{"data" : null},
			{"data" : "ADM_SALUTATION_NAME"},
			{
				mRender : function(data,type,full){
				return '<a class="btn btn-default" href="'+location+'/../update_salutation/'+full.ADM_SALUTATION_ID+'">Edit</a> &nbsp;<a class="btn btn-default" href="'+location+'/../delete_salutation/'+full.ADM_SALUTATION_ID+'" onclick="return confirm(\'Are you sure you want to delete this item?\');">Delete</a>'
			}, "sClass": "text-center"},
		],
	} );

	table_salutation.on( 'order.dt search.dt', function () {
		table_salutation.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
			cell.innerHTML = i+1;
		} );
	} ).draw();
	table_salutation.on('draw', function () {
		table_salutation.column(0, {search:'applied', order:'applied', page:'applied'}).nodes().each( function (cell, i) {
			cell.innerHTML = i+1;
			console.log(cell);
		} );
	} ).draw();

})