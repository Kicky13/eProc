var base_url = $('#base-url').val();
table_master_sanction_list = null;

function populate_table(argument) {
	if (table_master_sanction_list != null) {
		table_master_sanction_list.destroy();
	}
	
	table_master_sanction_list = $('#detail_vendor_sanction_list').DataTable( {
        "bSort": false,
		"dom": 'rtip',
		"ajax": {
			url: base_url + "Vendor_sanction_management/get_detail_vendor_sanction",
			type: 'POST',
			data: {search: argument,vendor_no:$('#vendor_no').val()}
		},
        "columnDefs": [{
            "searchable": false,
            "orderable": false,
            "targets": 0
        }],
		"columns":[			
			{"data" : "SANCTION_NAME", "sClass": "text-center"},
			{"data" : "REASON", "sClass": "text-center"},
			{"data" : "START_DATE", "sClass": "text-center"},
			{"data" : "END_DATE", "sClass": "text-center"},
			{"data" : "DURATION", "sClass": "text-center"},
			{
				mRender:function(data,type,full){
					return (full.STATUS==1?'Aktif':'Non Aktif');
				}, "sClass": "text-center"},
			
		],
	});
}


$(document).ready(function(){
	populate_table('');
	

	$('.simpan').click(function(){
		 swal({
			  title: 'Konfirmasi',
			  text: 'Apakah anda yakin akan membebaskan sanksi dari vendor tersebut',
			  confirmButtonColor: '#d33',
	          confirmButtonText: 'OK',   
	          showCancelButton: true,       
	    	  cancelButtonText: "Cancel",
	          confirmButtonClass: 'btn btn-danger',
	          closeOnConfirm: true,
			  
				},function(isConfirm) {     
				  if(isConfirm){
					$('.form_sanction').submit();
					return true;		  	
				  }else{
				  	return false;
				  }
			});
		
	});
});