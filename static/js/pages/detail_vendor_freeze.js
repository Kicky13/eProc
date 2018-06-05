function hitung(){
		var sign = $('#sign').val();
		var total_point = parseInt($('#total_point').val());		
		var adj_value = parseInt($('#value').val());
		var jml = 0;
		if(sign=='+'){
			jml=total_point+adj_value;
		}else if(sign=='-'){
			jml=total_point-adj_value;
		}else{
			jml=adj_value;
		}
		if(isNaN(jml)){
			$('#adj_point').val(total_point);
		}else{
			$('#adj_point').val(jml);

			$.ajax({
	            url : 'get_value_sanction',
	            method : 'post',
	            data : "nilai="+jml,
	            dataType : "json",
	            success : function(result)
	            { 	
	            	if(result != '0'){
	                	$('#span_sanction').attr('class', 'label label-danger').html(result);
	            	} else {
	            		var ket = "Tidak Ada Sanksi";
	                	$('#span_sanction').attr('class', 'label label-success').html(ket);
	            	}
	            }
        	}) 
		}
	}
$(document).ready(function(){
	hitung();
	$('#sign').change(function(){
		hitung();
	});
	$('#value').keyup(function(){
		if(isNaN($(this).val())){
			$(this).val('');
			$('.peringatan').remove();
			$(this).parent().after('<span class="peringatan txt-alert">Must a Number</span>');
		}else{
			$('.peringatan').remove();
			hitung();
		}		
	});

	$(".simpan").click(function(){
		var sign = $('#sign').val();
		if (sign == null || sign == 0) {
			swal("warning!", "Pilih Salah satu sign!", "warning")
		} else { 
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
	            	$(".form_simpan").submit();
	            }
	        });   
		};
			
			
		
	});
});