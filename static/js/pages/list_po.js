$(document).ready(function(){
    $(".refresh").click(function(e){
        $(".filterinput").val("");
        $(".filtercek").prop("checked",false);
    });

    // Change the selector if needed
	var $table = $('table'),
	    $bodyCells = $table.find('tbody tr:first').children(),
	    colWidth;

	// Get the tbody columns width array
	colWidth = $bodyCells.map(function() {
	    return $(this).width();
	}).get();

	// console.log(colWidth);

	var colheaderWidth=[];
	// Set the width of thead columns
	$table.find('thead tr').children().each(function(i, v) {
	    $(v).width(colWidth[i]);
	    colheaderWidth.push(colWidth[i]);
	});    
	// console.log(colheaderWidth);

    $("#panel_return_createpo_approve").hide();

	$(".save-approve").on('click',function(e){ 
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
		        if($('#is_approve').val()==2){
		        	if($('#note').val()==''){
		        		alert('Harus mengisi catatan saat reject');
		        		return false;
		        	}
		        }
		        $.ajax({
	                url: $("#base-url").val() + 'Tender_winner/approve',
	                type: 'POST',
	                dataType: 'json',
	                data: $("#form_list_approve").serialize()
	            }).done( 
	            	function(res) {
	            		console.log(res);
		            	if(res.state==true){
		            		alert('Approval Success');
		            		console.log('sukses');		            		
		            		$('#comment_modal').modal('hide');
		            		window.location.href=$("#base-url").val() + 'Tender_winner/listapprovalPO';
		            	}else{
		            		$("#panel_return_createpo_approve").show();
		                    $tbody = $("#panel_return_createpo_approve tbody");
		                    $tbody.html(res.data);
		            	}
		            }
	            );
	    	}
    	});
    });
})

function po_approve(po_id){
	
	$.ajax({
        url: $("#base-url").val() + 'Tender_winner/ajax_get_po_detail',
        type: 'POST',
        dataType: 'json',
        data: {'po_id':po_id}
    })
    .done(function(data) {
    	// console.log(data);
    	var po_header = data.po_header; 
    	$('#is_approve').val(1);
    	$('#po_id').val(po_header.PO_ID);
    	$('#max_approve').val(data.approval.length);
    	$('#real_stat').val(parseInt(po_header.REAL_STAT)+1);
    	$('#doctype').val(po_header.DOC_TYPE);
    	$('#is_contract').val(po_header.PTM_NUMBER.length>0?0:1);
    	$('#note').val('');

    	var po_detail = data.po_detail;
    	winner = '';
    	$.each(po_detail,function(key,val){      		
    		winner +='<input type="hidden" name="winner[]" value="'+val.PTW_ID+'"/>';
    	});	
    	$('.inputan').append(winner);
    	var phc = data.phc;
    	$('.table-comment').children().remove();
    	$.each(phc,function(key,val){  
    		tr = '<tr>';
            tr += '<td>' + val.PHC_NAME + '</td>';
            tr += '<td>' + val.PHC_START_DATE + '</td>';
            tr += '<td>' + val.PHC_COMMENT + '</td>';            
            $('.table-comment').append(tr);
    	});	
    });
    $('#comment_modal').modal('show');
	// console.log(po_id);
}

function po_reject(po_id){
	$.ajax({
        url: $("#base-url").val() + 'Tender_winner/ajax_get_po_detail',
        type: 'POST',
        dataType: 'json',
        data: {'po_id':po_id}
    })
    .done(function(data) {
    	// console.log(data);
    	var po_header = data.po_header; 
    	$('#is_approve').val(2);
    	$('#po_id').val(po_header.PO_ID);
    	$('#max_approve').val(data.approval.length);
    	$('#real_stat').val(parseInt(po_header.REAL_STAT)+1);
    	$('#doctype').val(po_header.DOC_TYPE);
    	$('#is_contract').val(po_header.PTM_NUMBER.length>0?0:1);
    	$('#note').val('');

    	var po_detail = data.po_detail;
    	winner = '';
    	$.each(po_detail,function(key,val){      		
    		winner +='<input type="hidden" name="winner[]" value="'+val.PTW_ID+'"/>';
    	});	
    	$('.inputan').append(winner);
    	var phc = data.phc;
    	$('.table-comment').children().remove();
    	$.each(phc,function(key,val){  
    		tr = '<tr>';
            tr += '<td>' + val.PHC_NAME + '</td>';
            tr += '<td>' + val.PHC_START_DATE + '</td>';
            tr += '<td>' + val.PHC_COMMENT + '</td>';            
            $('.table-comment').append(tr);
    	});
    	$(".save-approve").html('Reject');
    	$(".save-approve").addClass('btn-danger');
    	$(".save-approve").removeClass('btn-primary');
    });
    $('#comment_modal').modal('show');
	
	//console.log(po_id);
}

