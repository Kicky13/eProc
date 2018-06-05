var base_url = $('#base-url').val();
function cek_terpilih_func() {
	 
	cek_terpilih = false;
	$(".pilih_metode").each(function() {

		
		if ($(this).val() != '') {
			cek_terpilih = true;
		}
	
		
	});
	if (cek_terpilih) {		
		$(".panel_lanjut").show();
	} else {
		$(".panel_lanjut").hide();
	}
}

function get_rekap_nego(){	
	var nego_tit_id = [];
	var auction_tit_id = [];
	var ece_tit_id = [];
	$(".pilih_metode").each(function(){
		if($(this).val()==16){
			nego_tit_id.push($(this).parent().find('#tit_id').val());
		}else if($(this).val()==48){
			auction_tit_id.push($(this).parent().find('#tit_id').val());
		}else if($(this).val()==112){
			ece_tit_id.push($(this).parent().find('#tit_id').val());
		}
	});
	$(".pilih_metode_paket").each(function(){
		if($(this).val()==16){
			nego_tit_id.push($(this).parent().find('#tit_id').val());
		}else if($(this).val()==48){
			auction_tit_id.push($(this).parent().find('#tit_id').val());
		}else if($(this).val()==112){
			ece_tit_id.push($(this).parent().find('#tit_id').val());
		}
	});
	
	$(".item").each(function(){
		// console.log($("#item_status_"+$(this).val()).val());
		if($("#item_status_"+$(this).val()).val()==16){
			nego_tit_id.push($(this).val());
		}else if($("#item_status_"+$(this).val()).val()==48){
			auction_tit_id.push($(this).val());
		}else if($("#item_status_"+$(this).val()).val()==112){
			ece_tit_id.push($(this).val());
		}
	});

	$.ajax({
		url: base_url+'Tahap_negosiasi/get_rekap',
		type: 'POST',
		dataType: 'html',
		data: {
			title:$('#title').html(),
			ptm_number: $('#ptm_number').val(),
			nego_tit_id: nego_tit_id,
			auction_tit_id: auction_tit_id,
			ece_tit_id: ece_tit_id,
		},
		success: function(data){
			// console.log(data);
			$(".panel_rekap").show();				
			$(".panel_rekap").html(data);
		
		},
	});
}

function cekallvendor(ini){
	if($(ini).is(":checked")){
		$(ini).parent().parent().parent().parent().parent().find('.cekvendor').prop("checked",true);
	}else{
		$(ini).parent().parent().parent().parent().parent().find('.cekvendor').prop("checked",false);
	}
}

function kirim(){
	var submit_nego_stat=true;
	console.log('cekvendor_nego:'+$('.cekvendor_nego').length);
	if($('.cekvendor_nego').length){
		submit_nego_stat=false;
		$('.cekvendor_nego').each(function(){
			if($(this).is(':checked')){
				submit_nego_stat=true;
			}
		});
	}
	var submit_auction_stat=true;
	console.log('cekvendor_auction:'+$('.cekvendor_auction').length);
	if($('.cekvendor_auction').length){
		submit_auction_stat=false;
		$('.cekvendor_auction').each(function(){
			if($(this).is(':checked')){
				submit_auction_stat=true;
			}
		});
	}
	// console.log('submit_auction_stat:'+submit_auction_stat);
	// console.log('submit_nego_stat:'+submit_nego_stat);
	// console.log(submit_auction_stat&&submit_nego_stat);
	// return false;

	if(submit_nego_stat&&submit_auction_stat){	
	
	    $('#quotation-form')[0].submit();
	}else{
		console.log('error');
		alert('Vendor belum dipilih, pilih minimal satu vendor');
		swal({
          title: 'ERROR',
          text: 'Harus pilih minimal satu vendor',
          type: 'error',
          confirmButtonColor: '#d33',
          confirmButtonText: 'OK',
          confirmButtonClass: 'btn btn-danger',
          closeOnConfirm: true,
        }); 
        return false;

	}
};

function approve(apprv){
	$('#next_process').val(apprv);
	$('#approval-form')[0].submit();
}

$(document).ready(function() {
	// cek_terpilih_func();
	get_rekap_nego();
	$(".panel_rekap").hide();

	$(".pilih_metode_paket").change(function(){
		$(".pilih_metode").val($(this).val());
		// cek_terpilih_func();
		get_rekap_nego();
	});

	$(".pilih_metode").change(function() {
		// cek_terpilih_func();
		get_rekap_nego();
	});

	$('.formsubmit_').on('click',function(){
		console.log('click');
		swal({
		    title: 'Peringatan',
		    text: 'Apakah Anda yakin?',
		    type: 'warning',
		    showCancelButton: true,
		    confirmButtonColor: '#92c135',
		    cancelButtonColor: '#d33',
		    confirmButtonText: 'Ya',
		    cancelButtonText: 'Tidak',
		    confirmButtonClass: 'btn btn-success',
		    cancelButtonClass: 'btn btn-danger',
		    closeOnConfirm: true,
		    closeOnCancel: true
		  },
		 	function(isConfirm){
		  	console.log(isConfirm);
		  		if(isConfirm===true){
		  			kirim();
		  		}else{
		  			console.log('no submit');
		  		}
		        
		  });
	});

	$('.btn_approval').on('click',function(){
		var approval=$(this).val();
		console.log(approval);
		swal({
		    title: 'Peringatan',
		    text: 'Apakah Anda yakin?',
		    type: 'warning',
		    showCancelButton: true,
		    confirmButtonColor: '#92c135',
		    cancelButtonColor: '#d33',
		    confirmButtonText: 'Ya',
		    cancelButtonText: 'Tidak',
		    confirmButtonClass: 'btn btn-success',
		    cancelButtonClass: 'btn btn-danger',
		    closeOnConfirm: true,
		    closeOnCancel: true
		  },
		 	function(isConfirm){
		  	console.log(isConfirm);
		  		if(isConfirm===true){
		  			approve(approval);
		  		}else{
		  			console.log('no submit');
		  		}
		        
		  });
	});

})
function reject(){
	$("#next_process").val(0);
}

function approved(){
	$("#next_process").val(1);
}