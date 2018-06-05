var base_url = $('#base-url').val();
table_vendor_freeze_approval = null;


function populate_table(periode_awal,periode_akhir) {
	if (table_vendor_freeze_approval != null) {
		table_vendor_freeze_approval.destroy();
	}
	
	table_vendor_freeze_approval = $('#vendor_freeze_approval_list').DataTable( {
        "bSort": false,
		"dom": 'rtip',
		"processing": true,
		"ajax": {
			url: base_url + "Vendor_performance_freeze/get_all_freeze_approval",
			type: 'POST',
			data: {}
		},
        "columnDefs": [{
            "searchable": false,
            "orderable": false,
            "targets": 0
        }],
		"columns":[
			{"data" : "VENDOR_NO", "sClass": "text-center"},
			{"data" : "VENDOR_NAME"},
			{"data" : "START_DATE"},
			{"data" : "END_DATE"},
			{"data" : "DATE_CREATED"},
			{"data" : "VALUE", "sClass": "text-center"},
			{
				mRender : function(data,type,full){
					return '<form id="detail_freeze_approve" name="detail_freeze_approve[]" action="'+base_url+'Vendor_performance_freeze/detail_freeze_approval" method="POST"><input type="hidden" name="ID_REKAP_APPROVE" value="'+full.ID_REKAP_APPROVE+'"/><button type="submit" class="btn btn-default">Detail</a></form>'
				}, "sClass": "text-center"
			},
			{
				mRender : function(data,type,full){
					return '<input type="checkbox" name="check_freeze[]" id="check_freeze" onClick="checkMe($(this))" class="check_freeze" value="'+full.ID_REKAP_APPROVE+'" />'
				}, "sClass": "text-center"
			},
		],
	});
}

function checkMe(obj){
	var state=false;
	$('.check_freeze').each(function(){
		if($(this).is(':checked')){
			state = true;
		}
	});
	if(state){
		$("#approve_checked").removeAttr('disabled');						
	}else{		
		$("#approve_checked").prop('disabled','true');
	}
}


$(document).ready(function(){		
	populate_table();	
	$("#check_all").bind("change",function(){		
		if($(this).is(':checked')){
			$(".check_freeze").prop('checked','true');			
			$("#approve_checked").removeAttr('disabled');						
		}else{
			$(".check_freeze").removeAttr('checked');			
			$("#approve_checked").prop('disabled','true');
		}
	});

	$("#approve_checked").click(function(){
		swal({
          title: 'Konfirmasi',
          text: 'Apakah Anda Yakin?',
          type: 'warning',
          confirmButtonColor: '#d33',
          confirmButtonText: 'OK',   
          showCancelButton: true,       
    	  cancelButtonText: "Cancel",
          confirmButtonClass: 'btn btn-danger',
          closeOnConfirm: true,
        },function(isConfirm) {                 
            console.log(isConfirm);
            if(isConfirm){
            	$("#form_approve").submit()
            }
        });   

		
	});
});