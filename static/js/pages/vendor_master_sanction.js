var base_url = $('#base-url').val();
table_master_sanction_list = null;

function populate_table(argument) {
	if (table_master_sanction_list != null) {
		table_master_sanction_list.destroy();
	}
	
	table_master_sanction_list = $('#vendor_sanction_list').DataTable( {
        "bSort": false,
		"dom": 'rtip',
		"ajax": {
			url: base_url + "Vendor_sanction_management/get_master_sanction",
			type: 'POST',
			data: {search: argument}
		},
        "columnDefs": [{
            "searchable": false,
            "orderable": false,
            "targets": 0
        }],
		"columns":[
			{"data" : "SANCTION_NAME", "sClass": "text-center"},
			{"data" : "CATEGORY"},
			{"data" : "UPPER", "sClass": "text-center"},
			{"data" : "LOWER", "sClass": "text-center"},
			{"data" : "DURATION", "sClass": "text-center"},
			{"data" : "STATUS", "sClass": "text-center"},
			{
				mRender : function(data,type,full){
					return '<a class="btn btn-info" href="'+base_url+'Vendor_sanction_management/master_sanction/'+full.M_SANCTION_ID+'">Edit</a><button class="btn btn-danger" onClick="hapus('+full.M_SANCTION_ID+')" >Delete</button>'
				}, "sClass": "text-center"
			
			},
		],
	});
}

var hapus =  function(id){
	var url = base_url+'Vendor_sanction_management/delete_master_sanction/'+id;
	swal({
      title: 'Konfirmasi',
      text: 'Anda yakin menghapus?',
      type: 'warning',
      confirmButtonColor: '#d33',
      confirmButtonText: 'OK',
      confirmButtonClass: 'btn btn-danger',
      closeOnConfirm: true,
    },function(isConfirm) {                 
        // console.log(isConfirm);
        if(isConfirm){
        	$(location).prop('href', url);
        }
    });       
};

$(document).ready(function(){
	populate_table('');
	$('#status').bind('change',function(){
		if($(this).val()==0){
			$(this).val(1);
		}else{
			$(this).val(0);
		}
	});

	
});