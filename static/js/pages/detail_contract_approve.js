$(document).ready(function(){
    $("#panel_return_createpo_approve").hide();
    $(".btn_approve_po").on('click',function(e){
    	swal({
          title: 'Konfirmasi',
          text: 'Apakah Anda Yakin Menyetujui?',
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
	                url: $("#base-url").val() + 'Tender_winner_contract/approve',
	                type: 'POST',
	                dataType: 'json',
	                data: $("#form_po_approval").serialize()
	            }).done( 
	            	function(res) {
	            		console.log(res);
		            	if(res.state==true){
		            		alert('Approval sukses');
		            		console.log('sukses');		       
		            		window.location.href=$("#base-url").val() + 'Tender_winner_contract/listapprovalPO';
		            	}else{
		            		$("#panel_return_createpo_approve").show();
		                    $tbody = $("#panel_return_createpo_approve tbody");
		                    $tbody.html(res.data);
		                    alert('Approval gagal');
		                    $("html, body").animate({
						        scrollTop: 200
						    }, 100); 
		            	}
		            }
	            );
		    	
		    	// if($("#max_approve").val()!=$("#real_stat").val()){
		    	// 	console.log('Belum di approve terakhir');
			    //     $("form[name='form_po_approval']").submit();
		    	// }else
		    	// {

			    // 	if ($(".no_po").html() == '') {
			    //         $(".panel_submit").hide();
			    //         $("#submit-form").html('Tunggu Sebentar');
			    //         $.ajax({
			    //             url: $("#base-url").val() + 'Tender_winner_contract/ajax_create_po_ptm',
			    //             type: 'POST',
			    //             dataType: 'json',
			    //             data: $("#form_po_approval").serialize()
			    //         })
			    //         .done(function(data) {
			    //             sukses = false;
			    //             if (data.RETURN.length > 0) {
			    //                 $("#panel_return_createpo_approve").show();
			    //                 $tbody = $("#panel_return_createpo_approve tbody");
			    //                 $tbody.html('');
			    //                 for (var i = 0; i < data.RETURN.length; i++) {
			    //                     val = data.RETURN[i];
			    //                     tr = '<tr>';
			    //                     tr += '<td>' + val.ID + '</td>';
			    //                     tr += '<td>' + val.TYPE + '</td>';
			    //                     tr += '<td>' + val.MESSAGE + '</td>';
			    //                     $tbody.append(tr);
			    //                     if (val.TYPE == 'S') {
			    //                         no_po = val.MESSAGE_V2;
			    //                         $(".no_po").html(no_po);
			    //                         $("#po_no").val(no_po);
			    //                         sukses = true;
			    //                     }
			    //                     // console.log(val);
			    //                 };
			    //             }
			    //             if (sukses == true) {
			    //                 $("#form_po_approval").submit();
			    //             }
			    //         })
			    //         .fail(function() {
			    //             console.log("error");
			    //         });
			            
			    //     }
			    // }
          }
        }); 
    });

	$(".btn_reject_po").on('click',function(e){
		swal({
          title: 'Konfirmasi',
          text: 'Apakah Anda Yakin Menolak?',
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
				$("#is_approve").val(2);
				if($('#note').val()==''){
					alert('Harus mengisi catatan saat reject');
	        		return false;
				}else{
					$("#form_po_approval").submit();
				}
			}
        }); 
	});

	$(".btn-retender").on('click',function(e){
		e.preventDefault();
		var link = $(this).attr('href');
		console.log(link);
		swal({
          title: 'Konfirmasi',
          text: 'Apakah Anda Yakin RETENDER?',
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
            	window.location.href=link;
            }
        }); 
		
	});

	$(".btn-renego").on('click',function(e){
		e.preventDefault();
		var link = $(this).attr('href');
		console.log(link);
		swal({
          title: 'Konfirmasi',
          text: 'Apakah Anda Yakin RENEGOSIASI?',
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
            	window.location.href=link;
            }
        }); 
		
	});

	$(".btn-cancel").on('click',function(e){
		e.preventDefault();
		var link = $(this).attr('href');
		console.log(link);
		swal({
          title: 'Konfirmasi',
          text: 'Apakah Anda Yakin MEMBATALKAN PO?',
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
            	window.location.href=link;
            }
        }); 
		
	});
});