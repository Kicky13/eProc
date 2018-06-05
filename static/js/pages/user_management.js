var base_url = $('#base-url').val();
$('.flat-toggle').prev().attr('value', 'Inactive');
var approval_setting_list = [];
$(document).ready(function(){	
	var table_employee = $('#employee_list').DataTable( {
		"dom": 'rtip',
		"processing": true,
		"serverSide": true,
		"lengthMenu": [ 10, 25, 50 ],
		"ajax": {
			url: location + "/../get_employee",
			type: 'POST'
		},
		"columnDefs": [{
			"targets": 0
		}],
		"columns":[
			{"data" : null},
			{"data" : "FULLNAME"},
			{"data" : "EMAIL"},
			{"data" : "PHONE"},
			{"data" : "POS_NAME"},
			{"data" : "DISTRICT_NAME"},
			{
				mRender : function(data,type,full){
				return '<a class="btn btn-default" href="'+location+'/../update_employee/'+full.ID+'">Edit</a> &nbsp;<a class="btn btn-default" href="'+location+'/../delete_employee/'+full.ID+'" onclick="return confirm(\'Are you sure you want to delete this item?\');">Delete</a>'
			}, "sClass": "text-center"},
		],
	} );

	table_employee.on( 'order.dt search.dt', function () {
		table_employee.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
			cell.innerHTML = i+1;
		} );
	} ).draw();
	table_employee.on('draw', function () {
		table_employee.column(0, {search:'applied', order:'applied', page:'applied'}).nodes().each( function (cell, i) {
			cell.innerHTML = i+1;
		} );
	} ).draw();

	var table_approval_setting = $('#approval_setting_list').DataTable( {
		"dom": 'rtip',
		"lengthMenu": [ 10, 25 ],
		"ajax": {
			url: location + "/../get_approval_setting",
			type: 'POST'
		},
		"columnDefs": [{
			"targets": 0
		}],
		"columns":[
			{"data" : null},
			{"data" : "COMPANYNAME"},
			{"data" : "TOTAL", "sClass": "text-center"},
			{
				mRender : function(data,type,full){
				return '<a class="btn btn-default" href="'+location+'/../update_approval_setting/'+full.COMPANYID+'">Edit</a>'
			}, "sClass": "text-center"},
		],
	} );

	table_approval_setting.on( 'order.dt search.dt', function () {
		table_approval_setting.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
			cell.innerHTML = i+1;
		} );
	} ).draw();

	table_approval_setting.on('draw', function () {
		table_approval_setting.column(0, {search:'applied', order:'applied', page:'applied'}).nodes().each( function (cell, i) {
			cell.innerHTML = i+1;
		} );
	} ).draw();
	
	$.ajax({url: base_url + "User_management/get_approval_setting_detail", success: function(result){
		approval_setting_list = $.parseJSON(result);
		var options = '';
		var forms = '';
		for (var i = 0; i < approval_setting_list.length; i++) {
			options += '<tr id="data-'+i+'"><td class="text-center"></td><td>'+approval_setting_list[i].DEPT_NAME+'</td><td>'+approval_setting_list[i].POS_NAME+'</td><td class="text-center"><a class="btn btn-default removeData"><i class="ico ico-close"></i></a></td></tr>';
			forms += '<input id="input-'+i+'" type="text" class="hidden" name="ROLE[]" value="'+approval_setting_list[i].POS_ID+'">';
		}
		$('#apprv_set_detail').append(options);
		$('form').append(forms);
		drawNumber();
	}});
})

$('#apprv_set_detail').on('click', '.removeData', function(){
	var row = $(this).closest ('tr');
	var id = row.attr("id");
	row.remove();
	approval_setting_list.splice(id,1);
	var inputId = id.substring(5);
	$('#input-'+inputId).remove();
	drawNumber();
});

$('#add_apprv_set_det').on('click', function(){
	var approval_setting_list_newid = $('#apprv_set_detail tr').length;
	var dept = $('#DEPT').val().split('-');
	var pos = $('#ADM_POS_ID').val().split('-');
	var options = '<tr id="data-'+approval_setting_list_newid+'"><td class="text-center"></td><td>'+dept[1]+'</td><td>'+pos[1]+'</td><td class="text-center"><a class="btn btn-default removeData"><i class="ico ico-close"></i></a></td></tr>';
	$('#apprv_set_detail').append(options);
	var forms = '<input id="input-'+approval_setting_list_newid+'" type="text" class="hidden" name="ROLE[]" value="'+pos[0]+'">';
	$('form').append(forms);
	drawNumber();
	console.log(1);
});

function drawNumber () {
	$.each( $('#apprv_set_detail tr td:first-child'), function( key, value ) {
		$(this).html(key+1);
	});
}

var FIRSTNAME;
var LASTNAME;

$('#FIRSTNAME').on('input', function() {
	FIRSTNAME = $(this).val();
	$('#FULLNAME').attr('value', FIRSTNAME+' '+LASTNAME);
});

$('#LASTNAME').on('input', function() {
	LASTNAME = $(this).val();
	$('#FULLNAME').attr('value', FIRSTNAME+' '+LASTNAME);
});

$('#DEPT').change(function(){
	var dept_id = $(this).val();
	$('.new_position').remove();
	$.ajax({
		url : base_url+'User_management/do_get_position',
		method : 'post',
		data : {'DEPT':dept_id},
		success : function(result)
		{
			var position = $.parseJSON(result);
			var options = '';
			for (var i = 0; i < position.length; i++) {
				options += '<option class="new_position" value="' + position[i].POS_ID + '-' + position[i].POS_NAME + '">' + position[i].POS_NAME + '</option>';
			}
			$('#ADM_POS_ID').append(options);
		}
	})
	$('.flat-toggle').removeClass('on');
	$('.flat-toggle').prev().attr('value', 'Inactive');
});

$('.flat-toggle').on('click', function() {
	if ($(this).hasClass("on")) {
		$(this).prev().attr('value', 'Inactive');
	}
	else {
		$(this).prev().attr('value', 'Active');
	}
	$(this).toggleClass('on');
});

/*var totalNewPos = 0;
var emp_pos_list = [];
$('#add_emp_pos').on('click', function() {
	var new_emp_pos = {};
	var dept = $('#DEPT').val().split("-");
	var pos = $('#ADM_POS_ID').val().split("-");
	var new_emp_pos = {
		'DEPT_ID' : dept[0],
		'DEPT_NAME' : dept[1],
		'POS_ID' : pos[0],
		'POS_NAME' : pos[1],
		'IS_ACTIVE' : $('#is_active').val(),
		'IS_MAIN_JOB' : $('#is_main_job').val()
	};
	var foundEmpPos = $.grep(emp_pos_list, function(n, i){ return n.POS_ID == new_emp_pos['POS_ID']; });
	var foundMainJob = $.grep(emp_pos_list, function(n, i){ return n.IS_MAIN_JOB == new_emp_pos['IS_MAIN_JOB']; });
	if (foundEmpPos.length == 0 && foundMainJob.length == 0) {
		var active = "Active";
		if(new_emp_pos["IS_ACTIVE"] == 0) {
			active = "Inactive";
		}
		var main_job = "Main Job";
		if(new_emp_pos["IS_MAIN_JOB"] == 0) {
			main_job = "Not Main Job";
		}
		if (totalNewPos == 0) {
			$('#empty_row').hide();
		};
		$('#emp_pos:last-child').append('<tr id="'+totalNewPos+'"><td>'+new_emp_pos['DEPT_NAME']+'</td><td>'+new_emp_pos['POS_NAME']+'</td><td>'+active+'</td><td>'+main_job+'</td><td class="text-center"><a class="btn btn-default removeData"><i class="ico ico-close"></i></a></td></tr>');
		emp_pos_list[totalNewPos] = new_emp_pos;
		totalNewPos++;
		$('.flat-toggle').removeClass('on');
		$('.flat-toggle').prev().attr('value', 0);
	}
	else {
		alert("Position already inserted and or Main Job already inserted!");
	}
});

$('#emp_pos').on('click', '.removeData', function(){
	var row = $(this).closest ('tr');
	var id = row.attr("id");
	row.remove();
	emp_pos_list.splice(id,1);
	totalNewPos--;
	if (totalNewPos == 0) {
		$('#empty_row').show();
	};
});*/